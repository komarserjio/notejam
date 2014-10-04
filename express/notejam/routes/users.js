var express = require('express');
var router = express.Router();
var debug = require('debug')('http')

router.get('/signin', function(req, res) {
    req.models.user.get(1, function(err, user) {
        //console.log(err);
        //console.log(user.email);
    })

    res.render('users/signin', {title: 'Sign In', messages: req.flash('info')});
});

router.post('/signin', function(req, res) {
    var email = req.param('email');
    var password = req.param('password');
    params = {'email': email, 'password': password};
    req.models.user.create(params, function(err, message) {
        if (err) {
            res.locals.errors = err;
        } else {
            req.flash('success', 'User is successfully created');
            res.redirect('/signin');
        }
        res.render('users/signin', { title: 'Sign In' });
    });
});

module.exports = router;
