<?php

require_once "config.php";

function getUserByToken($token)
{
    $data = array("idToken" => $token);
    $data_string = json_encode($data);

    $ch = curl_init('https://identitytoolkit.googleapis.com/v1/accounts:lookup?key=' . API_KEY);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        )
    );

    $response = json_decode(curl_exec($ch));
    return $response->users[0];
}

$DB_conn = null;

function getDBConnection()
{
    global $DB_conn;
    if ($DB_conn == null) {
        $DB_conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $DB_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    return $DB_conn;
}

function search($taglist, $lat, $lng, $offset)
{
    $searchExp = '';
    foreach ($taglist as $tag) {
        $searchExp .= '+' . $tag . ' ';
    }

    $lat = floatval($lat);
    $lng = floatval($lng);
    $offset = intval($offset);

    $conn = getDBConnection();
    $st = $conn->prepare("SELECT id, title, description, photoUrl, url, service, ST_Distance(coords, ST_GeomFromText('POINT(" . $lng . " " . $lat . ")', 4326)) as distance FROM resources WHERE MATCH(service) AGAINST(:searchExp IN BOOLEAN MODE) ORDER BY distance ASC LIMIT " . $offset . ",6");
    $st->bindParam(':searchExp', $searchExp);
    $st->execute();
    return $st->fetchAll(PDO::FETCH_OBJ);
}

function getResourceByOwnerId($ownerId)
{
    $conn = getDBConnection();
    $st = $conn->prepare('SELECT title, description, service, ST_X(coords) as lng, ST_Y(coords) as lat FROM resources WHERE ownerId=:ownerId');
    $st->bindParam(':ownerId', $ownerId);
    $st->execute();
    return $st->fetch();
}

function bindResourceData($st, $resource)
{
    var_dump($resource);
    $st->bindParam(':ownerId', $resource['ownerId']);
    $st->bindParam(':title', $resource['title']);
    $st->bindParam(':description', $resource['description']);
    $st->bindParam(':photoUrl', $resource['photoUrl']);
    $st->bindParam(':service', $resource['service']);
}

function insertResource($resource)
{
    $lat = floatval($resource['lat']);
    $lng = floatval($resource['lng']);
    $conn = getDBConnection();
    $st = $conn->prepare("INSERT INTO resources (ownerId, title, description, photoUrl, coords, service) VALUES (:ownerId, :title, :description, :photoUrl, ST_GeomFromText('POINT(" . $lng . " " . $lat . ")', 4326), :service)");
    bindResourceData($st, $resource);
    var_dump($st->execute());
}

function updateResource($resource)
{
    $lat = floatval($resource['lat']);
    $lng = floatval($resource['lng']);
    $conn = getDBConnection();
    $st = $conn->prepare("UPDATE resources SET title=:title, photoUrl=:photoUrl, description=:description, coords=ST_GeomFromText('POINT(" . $lng . " " . $lat . ")', 4326), service=:service WHERE ownerId=:ownerId");
    bindResourceData($st, $resource);
    $st->execute();
}


/*




function getUserByUid($uid)
{
    $conn = getDBConnection();
    $st = $conn->prepare('SELECT * FROM profiles WHERE uid=:uid');
    $st->bindParam(':uid', $uid);
    $st->execute();
    return $st->fetch();
}

function getUserByImportToken($token)
{
    $conn = getDBConnection();
    $st = $conn->prepare('SELECT * FROM users WHERE token=:token');
    $st->bindParam(':token', $token);
    $st->execute();
    return $st->fetch();
}
*/
