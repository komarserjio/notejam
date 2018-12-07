var express = require('express');
var router = express.Router();
var orm = require('orm');

var helpers = require('../helpers');

// Create new pad
router.get('/pads/create', helpers.loginRequired, function(req, res) {
  res.render('pads/create');
});

router.post('/pads/create', helpers.loginRequired, function(req, res) {
  var data = req.body;
  data['user_id'] = req.user.id;
  req.models.Pad.create(data, function(err, message) {
    if (err) {
      res.locals.errors = helpers.formatModelErrors(err);
    } else {
      req.flash(
        'success',
        'Pad is successfully created'
      );
      return res.redirect('/');
    }
    res.render('pads/create');
  });
});

// Inject pad in request
router.use('/pads/:id', function(req, res, next) {
  if (req.user) {
    req.models.Pad.one(
      {id: req.param('id'), user_id: req.user.id},
      function(err, pad) {
        if (pad == null) {
          res.send(404);
          return;
        }
          req.pad = pad;
        next();
      });
  } else {
    next();
  }
});

// Pad notes
router.get('/pads/:id', helpers.loginRequired, function(req, res) {
  req.pad.getNotes(req.param("order", "-updated_at"), function(i, notes) {
    res.render(
      'pads/list',
      {title: req.pad.name + ' (' + notes.length + ')',
       pad: req.pad, notes: notes}
    );
  });
});

// Edit pad
router.get('/pads/:id/edit', helpers.loginRequired, function(req, res) {
  res.render('pads/edit', {pad: req.pad});
});

router.post('/pads/:id/edit', helpers.loginRequired, function(req, res) {
  req.pad.save({name: req.param('name')}, function(err) {
    if (err) {
      res.locals.errors = helpers.formatModelErrors(err);
      res.render('pads/edit', {pad: req.pad});
    } else {
      req.flash(
        'success',
        'Pad is successfully updated'
      );
      res.redirect('/');
    }
  });
});

// Delete pad
router.get('/pads/:id/delete', helpers.loginRequired, function(req, res) {
  res.render('pads/delete', {pad: req.pad});
});

router.post('/pads/:id/delete', helpers.loginRequired, function(req, res) {
  req.pad.remove(function(err) {
    req.flash(
      'success',
      'Pad is successfully deleted'
    );
    res.redirect('/');
  });
});

module.exports = router;
