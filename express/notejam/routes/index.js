var express = require('express');
var router = express.Router();
var helpers = require('../helpers')

/* GET home page. */
router.get('/', helpers.loginRequired, function(req, res) {
  res.render('index', { title: 'All notes' });
});


module.exports = router;
