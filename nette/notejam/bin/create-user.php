<?php

if (!isset($_SERVER['argv'][2])) {
	echo '
Add new user to database.

Usage: create-user.php <email> <password>
';
	exit(1);
}

list(, $email, $password) = $_SERVER['argv'];

$container = require __DIR__ . '/../app/bootstrap.php';
$manager = $container->getByType('App\Model\UserManager');

try {
	$manager->add($email, $password);
	echo "User $email was added.\n";

} catch (App\Model\DuplicateNameException $e) {
	echo "Error: duplicate email.\n";
	exit(1);
}
