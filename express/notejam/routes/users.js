var express = require('express');
var router = express.Router();
var debug = require('debug')('http')
var orm = require('orm');
var passport = require('passport');
var LocalStrategy = require('passport-local').Strategy;
var helpers = require('../helpers')

var settings = require('../settings');


// Sign Up
router.get('/signup', function(req, res) {
  res.render('users/signup', {title: 'Sign Up'});
});

router.post('/signup', function(req, res) {
  req.models.User.create(req.body, function(err, message) {
    if (err) {
      res.locals.errors = helpers.formatModelErrors(err);
    } else {
      req.flash(
        'success',
        'User is successfully created. Now you can sign in.'
      );
      return res.redirect('/signin');
    }
    res.render('users/signup', {title: 'Sign Up'});
  });
});

// Sign In
router.get('/signin', function(req, res) {
  res.render('users/signin', {title: 'Sign In'});
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
        return res.redirect('/pads/create');
      });
    })(req, res, next);
  } else {
    res.locals.errors = errors;
    res.render('users/signin', {title: 'Sign In'});
  }

});

// Sign Out
router.get('/signout', function(req, res) {
  req.logout();
  res.redirect('/signin');
});

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
    // Find the user by username.  If there is no user with the given
    // username, or the password is not correct, set the user to `false` to
    // indicate failure and set a flash message.  Otherwise, return the
    // authenticated `user`.
    findByUsername(username, function(err, user) {
      if (err) { return done(err); }
      if (!user) { return done(null, false, { message: 'Unknown user ' + username }); }
      if (user.password != password) { return done(null, false, { message: 'Invalid password' }); }
      return done(null, user);
    })
  }
));

function findByUsername(username, fn) {
  // @TODO refactor
  orm.connect(settings.db, function(err, db) {
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
  // @TODO refactor
  orm.connect(settings.db, function(err, db) {
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

module.exports = router;
