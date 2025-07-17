<?php
require __DIR__ . '/vendor/autoload.php';
use MongoDB\Client;
session_start();

function getMongoCollection(string $name) {
    $uri    = 'mongodb+srv://<usuario>:<senha>@seu-cluster.mongodb.net/phil-asean?retryWrites=true&w=majority';
    $client = new Client($uri);
    $db     = $client->selectDatabase('phil-asean');
    return $db->selectCollection($name);
}
