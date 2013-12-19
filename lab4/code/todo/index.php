<?php
require 'vendor/autoload.php';
require 'Database.php';
require_once 'Todo.php';


$app = new \Slim\Slim(array(
    'debug' => true
));

$app->get('/todos', function () {
	$db = new Database();
    echo json_encode($db->getTodos());
});
$app->get('/todos/:id', function ($id) {
    $db = new Database();
	echo json_encode($db->getTodo($id));
});

$app->post('/todos', function () use ($app) {
    $req = $app->request();
	$db = new Database();
	print_r($req->params("isDone"));
	$db->addTodo($req->params("title"),$req->params("isDone"));    
});

$app->put('/todos/:id', function($id) use ($app){
	$db = new Database();
	$req = $app->request();
	$db->updateTodo($id, $req->params("title"), $req->params("isDone"));
});

$app->delete('/todos/:id', function ($id) {
    $db = new Database();
	$db->deleteTodo($id);
});


$app->run();
?>