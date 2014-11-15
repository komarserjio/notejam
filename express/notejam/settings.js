var settings = {
  development: {
    db: "notejam.db",
    dsn: "sqlite://notejam.db"
  },
  test: {
    db: "sqlite://notejam_test.db",
    dsn: "notejam_test.db"
  }
};


var env = process.env.NODE_ENV
if (!env) {
  env = 'development'
};
module.exports = settings[env];
