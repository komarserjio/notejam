var sqlite3 = require('sqlite3').verbose();

var settigns = require('./settings')
var db = new sqlite3.Database('notejam.db');

// create db schema

// users tables
db.run("CREATE TABLE IF NOT EXISTS users (" +
    "id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL," +
    "email VARCHAR(75) NOT NULL," +
    "password VARCHAR(128) NOT NULL);");

// pads table
db.run("CREATE TABLE IF NOT EXISTS pads (" +
    "id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL," +
    "name VARCHAR(100) NOT NULL," +
    "user_id INTEGER NOT NULL REFERENCES users(id));")

// notes table
db.run("CREATE TABLE notes (" +
    "id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL," +
    "pad_id INTEGER REFERENCES pads(id)," +
    "user_id INTEGER NOT NULL REFERENCES users(id)," +
    "name VARCHAR(100) NOT NULL," +
    "text text NOT NULL," +
    "created_at DATETIME NOT NULL," +
    "updated_at DATETIME NOT NULL);")
