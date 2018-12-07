var settings = {
    production: {
        db: "notejam",
        dsn: "mysql://root:" + process.env.MYSQL_ROOT_PASSWORD + "@" + process.env.MYSQL_HOST + ":" + process.env.MYSQL_TCP_PORT + "/notejam"
    },
    default: {
        db: "notejam",
        dsn: "mysql://root:" + process.env.MYSQL_ROOT_PASSWORD + "@" + process.env.MYSQL_HOST + ":" + process.env.MYSQL_TCP_PORT + "/notejam"
    },
    dev: {
        db: "notejam",
        dsn: "mysql://root:" + process.env.MYSQL_ROOT_PASSWORD + "@" + process.env.MYSQL_HOST + ":" + process.env.MYSQL_TCP_PORT + "/notejam"
    },
    development: {
        db: "notejam",
        dsn: "mysql://root:" + process.env.MYSQL_ROOT_PASSWORD + "@" + process.env.MYSQL_HOST + ":" + process.env.MYSQL_TCP_PORT + "/notejam"
    },
    test: {
        db: "notejam",
        dsn: "mysql://root:" + process.env.MYSQL_ROOT_PASSWORD + "@" + process.env.MYSQL_HOST + ":" + process.env.MYSQL_TCP_PORT + "/notejam"
    }
};

var env = process.env.NODE_ENV;

if (!env) {
    env = 'development'
}

module.exports = settings[env];
