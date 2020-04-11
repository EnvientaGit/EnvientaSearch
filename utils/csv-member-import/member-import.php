<?php

define("DB_HOST", "127.0.0.1");
define("DB_NAME", "envienta_search");
define("DB_USER", "root");
define("DB_PASS", "");

$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$file = fopen("services-members.csv", "r");
while (!feof($file)) {
    $item = fgetcsv($file);
    $id = "service_" . $item[0];
    $st = $conn->prepare('SELECT * FROM resources WHERE importId=:importId');
    $st->bindParam(':importId', $id);
    $st->execute();
    $data = $st->fetch(PDO::FETCH_ASSOC);
    if (!$data) {
        $lat = $item[5];
        $lng = $item[6];
        $st = $conn->prepare("INSERT INTO resources (title, description, photoUrl, url, importId, service, coords) VALUES (:title, :description, :photoUrl, :url, :importId, :service, ST_GeomFromText('POINT(" . $lng . " " . $lat . ")', 4326))");
        $st->bindParam(':title', $item[1]);
        $st->bindParam(':photoUrl', $item[2]);
        $st->bindParam(':description', $item[3]);
        $st->bindParam(':url', $item[4]);
        $st->bindParam(':importId', $id);
        $st->bindParam(':service', $item[8]);
        $st->execute();
    } else {
        $lat = $item[5];
        $lng = $item[6];
        $st = $conn->prepare("UPDATE resources SET title=:title, description=:description, photoUrl=:photoUrl, url=:url, service=:service, coords=ST_GeomFromText('POINT(" . $lng . " " . $lat . ")', 4326) WHERE importId=:importId");
        $st->bindParam(':title', $item[1]);
        $st->bindParam(':photoUrl', $item[2]);
        $st->bindParam(':description', $item[3]);
        $st->bindParam(':url', $item[4]);
        $st->bindParam(':importId', $id);
        $st->bindParam(':service', $item[8]);
        $st->execute();
    }
}
fclose($file);
