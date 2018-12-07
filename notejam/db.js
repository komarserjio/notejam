var mysql = require('mysql');

var db;
db = mysql.createConnection({
    host: process.env.MYSQL_HOST,
    user: "root",
    password: process.env.MYSQL_ROOT_PASSWORD,
    database: "notejam"
});

db.connect(function(err) {
    if (err) throw err;
    console.log("Connected!");
});
