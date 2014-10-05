var express = require('express');
var router = express.Router();
var debug = require('debug')('http')

router.get('/signup', function(req, res) {
    res.render('users/signup', {title: 'Sign Up'});
});

router.post('/signup', function(req, res) {
    req.models.user.create(req.body, function(err, message) {
        if (err) {
            res.locals.errors = err;
        } else {
            req.flash('success', 'User is successfully created');
            res.redirect('/signup');
        }
        res.render('users/signup', {title: 'Sign Up'});
    });
});

module.exports = router;
