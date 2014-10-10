// http://stackoverflow.com/questions/20927155/writing-express-js-app-where-do-helper-methods-go
module.exports = {
    formatFormErrors: function(errors) {
        formatted = {};
        errors.forEach(function(e) {
            formatted[e.param] = e.msg;
        });
        return formatted;
    },

    formatModelErrors: function(errors) {
        formatted = {};
        errors.forEach(function(e) {
            formatted[e.property] = e.msg;
        });
        return formatted;
    },

    loginRequired: function (req, res, next) {
        console.log(req.isAuthenticated());
        if (req.isAuthenticated()) { return next(); }
        res.redirect('/signin')
    }
}
