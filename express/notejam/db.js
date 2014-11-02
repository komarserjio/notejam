var sqlite3 = require('sqlite3').verbose();

var settings = require('./settings');
var db = new sqlite3.Database(settings.dbfile);

var functions = {
  createTables: function() {
    // create db schema
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
    db.run("CREATE TABLE IF NOT EXISTS notes (" +
        "id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL," +
        "pad_id INTEGER REFERENCES pads(id)," +
        "user_id INTEGER NOT NULL REFERENCES users(id)," +
        "name VARCHAR(100) NOT NULL," +
        "text text NOT NULL," +
        "created_at default current_timestamp," +
        "updated_at default current_timestamp);")
  },

  applyFixtures: function() {
    this.truncateTables();
    db.run("INSERT INTO users VALUES (1, 'user1@example.com', 'password')");
    db.run("INSERT INTO users VALUES (2, 'user2@example.com', 'password')");

    db.run("INSERT INTO pads VALUES (1, 'Pad 1', 1)");
  },

  truncateTables: function() {
    db.run("DELETE FROM notes;");
    db.run("DELETE FROM pads;");
    db.run("DELETE FROM users;");
  }
}


if (require.main === module) {
  functions.createTables();
}

module.exports = functions;
