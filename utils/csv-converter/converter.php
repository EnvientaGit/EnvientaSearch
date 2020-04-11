<?php

$keywords = [];
$resource_types = json_decode(file_get_contents("resource_types.json"));
foreach ($resource_types as $resource_type) {
    $resource_key = $resource_type->key;
    $resource_keywords = [];
    $file = fopen($resource_key . ".csv", "r");
    while (!feof($file)) {
        $line = trim(fgets($file));
        if (substr($line, 0, 1) == '#')
            $line = substr($line, 1);
        if (strlen($line) == 0)
            continue;
        $resource_keywords[] = $line; 
    }
    fclose($file);
    $keywords[$resource_key] = $resource_keywords;
}
file_put_contents("keywords.json", json_encode($keywords));
