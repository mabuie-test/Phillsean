<?php
require __DIR__ . '/vendor/autoload.php';  // composer autoload
use MongoDB\Client;

function getMongoCollection(string $name) {
    // ATUALIZE com seu URI Atlas
    $uri    = 'mongodb+srv://Phillasean:8466@phillasean.zstuh6t.mongodb.net/?retryWrites=true&w=majority&appName=Phillasean';
    $client = new Client($uri);
    $db     = $client->selectDatabase('phil-asean');
    return $db->selectCollection($name);
}
