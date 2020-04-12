<?php
require_once "utils.php";

$path_info = $_SERVER["PATH_INFO"];

if ($path_info == '/test') {
    echo "OK";
}

if ($path_info == '/search') {
    header('Content-Type: application/json');
    echo json_encode(search($_REQUEST['taglist'], $_REQUEST['lat'], $_REQUEST['lng'], $_REQUEST['offset']));
    return;
}

if ($path_info == '/getUserData') {
    $fbuser = getUserByToken($_REQUEST['token']);
    if (!$fbuser) {
        echo "failed Invalid token!";
        return;
    }

    $ownerId = "envienta_" . md5($fbuser->email);
    $resource = getResourceByOwnerId($ownerId);

    $result = array();
    if ($resource) {
        $result['ownerId'] = $ownerId;
        $result['name'] = $resource["title"];
        $result['description'] = $resource["description"];
        $result['taglist'] = $resource["service"] ? explode(" ", trim($resource["service"])) : array();
        $result['lat'] = $resource["lat"];
        $result['lng'] = $resource["lng"];
    }

    header('Content-Type: application/json');
    echo json_encode($result);

    return;
}

if ($path_info == '/setUserData') {
    $fbuser = getUserByToken($_REQUEST['token']);
    if (!$fbuser) {
        echo "failed Invalid token!";
        return;
    }

    $ownerId = "envienta_" . md5($fbuser->email);
    $resource = getResourceByOwnerId($ownerId);

    $resourceData = array(
        "ownerId" => $ownerId,
        "title" => $_REQUEST['name'],
        "description" => $_REQUEST['description'],
        "photoUrl" => $fbuser->photoUrl,
        "lat" => $_REQUEST['lat'],
        "lng" => $_REQUEST['lng'],
        "service" => str_replace(",", " ", $_REQUEST['service-taglist'])
    );

    if (!$resource) {
        insertResource($resourceData);
    } else {
        updateResource($resourceData);
    }
}


/*
if ($path_info == '/import') {
    $token = $_REQUEST["token"];
    $user = getUserByImportToken($token);
    if (!$user) {
        echo "failed No user found by token!";
        return;
    }

    $rawdata = file_get_contents("php://input");
    $import_json = json_decode($rawdata);
    var_dump($import_json);
}

if ($path_info == '/getUserData') {
    $fbuser = getUserByToken($_REQUEST['token']);
    if (!$fbuser) {
        echo "{}";
        return;
    }
    
    $uid = $fbuser->localId;
    $user = getUserByUid($uid);
    echo json_encode($user);
}
*/
