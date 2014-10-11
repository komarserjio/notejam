var orm = require('orm');

module.exports = function (db, cb) {
    var User = db.define("users", {
        id      : { type: "serial", key: true },
        email   : { type: "text" },
        password: { type: "text" }
    }, {
        validations: {
            email: orm.enforce.patterns.email("Invalid email"),
            password: orm.enforce.notEmptyString("The field is required"),
            // @TODO add "match passwords" validation
        }
    });

    var Pad = db.define("pads", {
        id      : { type: "serial", key: true },
        name    : { type: "text" },
    }, {
        validations: {
            name: orm.enforce.notEmptyString("The field is required"),
        }
    });
    Pad.hasOne("user", User, { required: true, reverse: 'pads' });

    var Note = db.define("notes", {
        id      : { type: "serial", key: true },
        name    : { type: "text" },
        text    : { type: "text" }
    }, {
        validations: {
            name: orm.enforce.notEmptyString("The field is required"),
            text: orm.enforce.notEmptyString("The field is required"),
        }
    });
    Note.hasOne("user", User, { required: true, reverse: 'notes' });
    Note.hasOne("pad", Pad, { required: false, reverse: 'notes' });

    return cb();
};
