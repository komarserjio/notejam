var settings = {
  development: {
    db: "sqlite://notejam.db",
    dbfile: "notejam.db"
  },
  test: {
    db: "sqlite://notejam_test.db",
    dbfile: "notejam_test.db"
  }
};

module.exports = settings[process.env.NODE_ENV];
