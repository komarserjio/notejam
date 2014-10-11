var orm = require('orm');

module.exports = function (db, cb) {
    db.define("users", {
        id      : { type: "serial", key: true }, // autoincrementing primary key
        email   : { type: "text" },
        password: { type: "text" }
    }, {
        validations: {
            email: orm.enforce.patterns.email("Invalid email"),
            password: orm.enforce.notEmptyString("The field is required"),
            // @TODO add "match passwords" validation
        }
    });

    return cb();
};
