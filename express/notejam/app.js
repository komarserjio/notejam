var express = require('express');
var session = require('express-session');
var path = require('path');
var favicon = require('static-favicon');
var logger = require('morgan');
var cookieParser = require('cookie-parser');
var flash = require('connect-flash');
var bodyParser = require('body-parser');
var orm = require('orm');

var routes = require('./routes/index');
var users = require('./routes/users');

var app = express();

// view engine setup
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'jade');

app.use(favicon());
app.use(logger('dev'));
app.use(bodyParser.json());
app.use(bodyParser.urlencoded());
app.use(cookieParser());
app.use(session({cookie: { maxAge: 60000 }, secret: 'secret'}));
app.use(flash());
app.use(express.static(path.join(__dirname, 'public')));

orm.settings.set("instance.returnAllErrors", true);
app.use(orm.express("sqlite://notejam.db", {
    define: function (db, models, next) {
        models.user = db.define("users", {
            id      : { type: "serial", key: true }, // autoincrementing primary key
            email   : { type: "text" },
            password: { type: "text" },
        }, {
            validations: {
                email: orm.validators.patterns.email("Invalid email"),
                password: orm.validators.notEmptyString("The field is required")
            }
        }
        );
        next();
    }
}));

// inject flash messages
app.use(function(req, res, next){
    res.locals.flash_messages = {
        'success': req.flash('success'),
        'error': req.flash('error')
    }
    next();
});

app.use('/', routes);
app.use('/', users);



/// catch 404 and forward to error handler
app.use(function(req, res, next) {
    var err = new Error('Not Found');
    err.status = 404;
    next(err);
});

/// error handlers

// development error handler
// will print stacktrace
if (app.get('env') === 'development') {
    app.use(function(err, req, res, next) {
        res.status(err.status || 500);
        res.render('error', {
            message: err.message,
            error: err
        });
    });
}

// production error handler
// no stacktraces leaked to user
app.use(function(err, req, res, next) {
    res.status(err.status || 500);
    res.render('error', {
        message: err.message,
        error: {}
    });
});


module.exports = app;
