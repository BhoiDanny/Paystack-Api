<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

   use SannyTech\Response;

   require_once('../../../vendor/autoload.php');

$response = new Response();

$response->setSuccess(true);
$response->setStatusCode(200);
$response->setMessages("Daniel Botchway!!");
$response->setData("Hello World");
$response->toCache(false);
$response->send();

