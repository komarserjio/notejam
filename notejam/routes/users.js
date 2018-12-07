var express = require('express');
var router = express.Router();
var debug = require('debug')('http');
var orm = require('orm');
var passport = require('passport');
var LocalStrategy = require('passport-local').Strategy;
var bcrypt = require('bcrypt');
var nodemailer = require('nodemailer');
var stubTransport = require('nodemailer-stub-transport');

var helpers = require('../helpers');
var settings = require('../settings');

// Sign Up
router.get('/signup', function(req, res) {
  res.render('users/signup');
});

router.post('/signup', function(req, res) {
  var data = req.body;
  if (data['password']) {
    data['password'] = generateHash(data['password']);
  }
    req.models.User.create(data, function(err, message) {
    if (err) {
      res.locals.errors = helpers.formatModelErrors(err);
    } else {
      req.flash(
        'success',
        'User is successfully created. Now you can sign in.'
      );
      return res.redirect('/signin');
    }
    res.render('users/signup');
  });
});

// Sign In
router.get('/signin', function(req, res) {
  res.render('users/signin');
});

router.post('/signin', function(req, res, next) {
  req.checkBody('email', 'Email is required').notEmpty();
  req.checkBody('password', 'Password is required').notEmpty();
  if (req.validationErrors()) {
    var errors = helpers.formatFormErrors(req.validationErrors());
  }

  if (!errors) {
    passport.authenticate('local', function(err, user, info) {
      if (err) { return next(err) }
      if (!user) {
        req.flash('error', info.message);
        return res.redirect('/signin')
      }
      req.logIn(user, function(err) {
        if (err) { return next(err); }
        return res.redirect('/');
      });
    })(req, res, next);
  } else {
    res.locals.errors = errors;
    res.render('users/signin');
  }
});

// Account settings
router.get('/settings', helpers.loginRequired, function(req, res) {
  res.render('users/settings');
});

router.post('/settings', function(req, res, next) {
  req.checkBody('password', 'Password is required').notEmpty();
  req.checkBody('new_password', 'New password is required').notEmpty();
  req.checkBody('confirm_new_password', 'Passwords do not match').equals(
    req.body.new_password
  );
  if (req.validationErrors()) {
    var errors = helpers.formatFormErrors(req.validationErrors());
  }

  if (!errors) {
    if (!checkPassword(req.user, req.param('password'))) {
      req.flash(
        'error',
        'Current password is not correct'
      );
      return res.redirect('/settings');
    }
    var hash = generateHash(req.param('password'));
    req.user.save({password: hash}, function(err) {
      req.flash(
        'success',
        'Password is successfully changed'
      );
      return res.redirect('/');
    })
  } else {
    res.locals.errors = errors;
    res.render('users/settings');
  }
});

// Forgot password
router.get('/forgot-password', function(req, res) {
  res.render('users/forgot-password');
});

router.post('/forgot-password', function(req, res) {
  req.checkBody('email', 'Email is required').notEmpty();
  if (req.validationErrors()) {
    res.locals.errors = helpers.formatFormErrors(req.validationErrors());
    res.render('users/forgot-password');
    return;
  }
  if (req.models.User.one({email: req.param('email')}, function(err, user) {
    if (user) {
      var password = generateRandomPassword();
      var hash = generateHash(password);
      user.save({password: hash}, function() {
        sendNewPassword(user, password);
        req.flash(
          'success',
          'New password sent to your inbox'
        );
        return res.redirect('/signin');
      });
    } else {
      req.flash(
        'error',
        'No user with given email found'
      );
      return res.redirect('/forgot-password');
    }
  }));
});

// Sign Out
router.get('/signout', function(req, res) {
  req.logout();
  res.redirect('/signin');
});


// Helper user functions
// Auth settings
passport.serializeUser(function(user, done) {
  done(null, user.id);
});

passport.deserializeUser(function(id, done) {
  findById(id, function (err, user) {
    done(err, user);
  });
});

passport.use(new LocalStrategy(
  {usernameField: 'email', passwordField: 'password'},
  function(username, password, done) {
    findByUsername(username, function(err, user) {
      if (err) {
        return done(err);
      }
      if (!user) {
        return done(null, false, { message: 'Unknown user ' + username });
      }
      if (!checkPassword(user, password)) {
        return done(null, false, { message: 'Invalid password' });
      }
      return done(null, user);
    })
  }
));

function findByUsername(username, fn) {
  orm.connect(settings.dsn, function(err, db) {
    db.load("../models", function (err) {
      var User = db.models.users;
      db.models.users.find({email: username}, function (err, users) {
        if (users.length) {
          return fn(null, users[0]);
        } else {
          return fn(null, null);
        }
      });
    });
  });
}

function findById(id, fn) {
  orm.connect(settings.dsn, function(err, db) {
    db.load("../models", function (err) {
      var User = db.models.users;
      User.get(id, function (err, user) {
        if (err) {
          fn(new Error('User ' + id + ' does not exist'));
        }
        return fn(null, user);
      });
    });
  });
}

function generateHash(password) {
  return bcrypt.hashSync(password, bcrypt.genSaltSync(10));
}

function checkPassword(user, password) {
  return bcrypt.compareSync(password, user.password);
}

function generateRandomPassword() {
  return Math.random().toString(36).replace(/[^a-z]+/g, '');
}

function sendNewPassword(user, password) {
  var mailer = nodemailer.createTransport(stubTransport());
  mailer.sendMail({
    from: 'norepy@notejamapp.com',
    to: user.email,
    subject: 'New notejam password',
    text: 'Your new password: ' + password
  }, function(err, info) {
    // sent mail to console output
    console.log(info.response.toString());
  });
}

module.exports = router;
