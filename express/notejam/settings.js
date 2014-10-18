var settings = {
    development: {
        db: "sqlite://notejam.db"
    },
    test: {
        db: {database: ':memory:', protocol: 'sqlite'}
    }
};

module.exports = settings[process.env.NODE_ENV];
