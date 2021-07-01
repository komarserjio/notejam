<?php

if (file_exists($_SERVER['SCRIPT_FILENAME']) && strtolower(pathinfo($_SERVER['SCRIPT_FILENAME'], PATHINFO_EXTENSION)) !== 'php') {
	return FALSE; // let the static files be server by internal php server
}

$container = require __DIR__ . '/../app/bootstrap.php';
$container->getByType('Nette\Application\Application')->run();
