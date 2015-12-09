<?php

$container = require __DIR__ . '/../app/bootstrap.php';
/** @var Nette\Database\Context $db */
$db = $container->getByType('Nette\Database\Context');
$db->getConnection()->query("
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    email VARCHAR(75) NOT NULL,
    password VARCHAR(128) NOT NULL
);");

$db->getConnection()->query("
CREATE TABLE IF NOT EXISTS pads (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    name VARCHAR(100) NOT NULL,
    user_id INTEGER NOT NULL REFERENCES users(id)
);");

$db->getConnection()->query("
CREATE TABLE notes (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    pad_id INTEGER REFERENCES pads(id),
    user_id INTEGER NOT NULL REFERENCES users(id),
    name VARCHAR(100) NOT NULL,
    text text NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);");
