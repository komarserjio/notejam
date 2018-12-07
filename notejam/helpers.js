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
    if (req.isAuthenticated()) { return next(); }
    res.redirect('/signin')
  }
};
