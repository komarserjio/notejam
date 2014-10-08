var express = require('express');
var router = express.Router();
var debug = require('debug')('http')

// Sign Up
router.get('/signup', function(req, res) {
    res.render('users/signup', {title: 'Sign Up'});
});

router.post('/signup', function(req, res) {
    req.models.user.create(req.body, function(err, message) {
        if (err) {
            res.locals.errors = err;
        } else {
            req.flash('success', 'User is successfully created. Now you can sign in.');
            res.redirect('/signin');
        }
        res.render('users/signup', {title: 'Sign Up'});
    });
});

// Sign In
router.get('/signin', function(req, res) {
    res.render('users/signin', {title: 'Sign In'});
});

router.post('/signin', function(req, res) {
    req.checkBody('email', 'Email is required').notEmpty();
    var errors = req.validationErrors();
    if (!errors) {
        res.redirect('/signin');
    }
    res.locals.errors = errors;
    res.render('users/signin', {title: 'Sign In'});
});

module.exports = router;
