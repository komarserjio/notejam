var orm = require('orm');
var moment = require('moment');

module.exports = function (db, cb) {
  var User = db.define("users", {
    id      : { type: "serial", key: true },
    email   : { type: "text" },
    password: { type: "text" }
  }, {
    validations: {
      email: [orm.enforce.unique("User with given email already exists!"),
              orm.enforce.patterns.email("Invalid email")],
      password: orm.enforce.notEmptyString("Password is required"),
      // @TODO add "match passwords" validation
    }
  });

  var Pad = db.define("pads", {
    id      : { type: "serial", key: true },
    name    : { type: "text" },
  }, {
    validations: {
      name: orm.enforce.notEmptyString("Name is required"),
    }
  });
  Pad.hasOne("user", User, { required: true, reverse: 'pads' });

  var Note = db.define("notes", {
    id         : { type: "serial", key: true },
    name       : { type: "text" },
    text       : { type: "text" },
    created_at : { type: "date", time: true },
    updated_at : { type: "date", time: true }
  }, {
    methods: {
      updatedAt: function () {
        return moment(this.updated_at).fromNow();
      }
    },
    validations: {
      name: orm.enforce.notEmptyString("Name is required"),
      text: orm.enforce.notEmptyString("Text is required"),
    }
  });
  Note.hasOne("user", User, { required: true, reverse: 'notes' });
  Note.hasOne("pad", Pad, { required: false, reverse: 'notes' });

  return cb();
};
