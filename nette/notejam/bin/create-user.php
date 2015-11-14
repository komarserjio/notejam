<?php

if (!isset($_SERVER['argv'][2])) {
	echo '
Add new user to database.

Usage: create-user.php <name> <password>
';
	exit(1);
}

list(, $name, $password) = $_SERVER['argv'];

$container = require __DIR__ . '/../app/bootstrap.php';
$manager = $container->getByType('App\Model\UserManager');

try {
	$manager->add($name, $password);
	echo "User $name was added.\n";

} catch (App\Model\DuplicateNameException $e) {
	echo "Error: duplicate name.\n";
	exit(1);
}
