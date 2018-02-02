<?php
require_once __DIR__ . '/vendor/autoload.php';
use Workerman\Worker;
use Workerman\Connection\AsyncTcpConnection;

$clients = [];

// #### create socket and listen 1234 port ####
$tcp_worker = new Worker("tcp://0.0.0.0:1234");

// 4 processes
$tcp_worker->count = 1;

// Emitted when new connection come
$tcp_worker->onConnect = function($connection)
{
    global $clients;
    $clients[$connection->id] = $connection;
    $connection->send("hello {$connection->id} \n");
};

// Emitted when data received
$tcp_worker->onMessage = function($connection, $data)
{
    // send data to client
    //$connection->send("hello $data \n");
    sendB($data);
};

// Emitted when new connection come
$tcp_worker->onClose = function($connection)
{
    global $clients;
    unset($clients[$connection->id]);
};

function sendB($msg) {
    global $clients;
    foreach($clients as $client) {
        $client->send($msg." \n");
    }
}

//---------------------------------------------------


// #### http worker ####
$http_worker = new Worker("http://0.0.0.0:2345");

// 4 processes
$http_worker->count = 1;

// Emitted when data received
$http_worker->onMessage = function($connection, $data)
{
    // $_GET, $_POST, $_COOKIE, $_SESSION, $_SERVER, $_FILES are available
    // var_dump($_GET, $_POST, $_COOKIE, $_SESSION, $_SERVER, $_FILES);
    // send data to client
    $tcp = new AsyncTcpConnection("tcp://127.0.0.1:1234");
    $tcp->onConnect = function($c) use ($connection){
        $c->send($_GET['a']);
        $connection->send("done");
        $connection->close();
    };
    $tcp->connect();
};

// run all workers
Worker::runAll();