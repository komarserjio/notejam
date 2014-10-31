// Enable test environment
process.env.NODE_ENV = 'test';

var request = require('superagent');
var should = require('should');
var db = require('../db');


var app = require('../app');
app.listen(3000);

describe('User', function(){
  beforeEach(function() {
    db.createTables();
    db.applyFixtures();
  });
  afterEach(function() {
    db.truncateTables();
  });

  describe('cant sign in', function() {
    it('with wrong credentials', function(done){
      var agent = request.agent();
      agent
      .post('http://localhost:3000/signin')
        .send({email: 'unknown@email.com', password: 'unknown' })
        .end(function(error, res){
          res.text.should.containEql('Unknown user');
          done();
        });
    });

    it('if required fields are missing', function(done){
      var agent = request.agent();
      agent
      .post('http://localhost:3000/signin')
        .send({email: '', password: '' })
        .end(function(error, res){
          res.text.should.containEql('Email is required');
          res.text.should.containEql('Password is required');
          done();
        });
    });
  });

  describe('cant signup', function() {
    var data = {
      email: 'user@example.com',
      password: 'password'
    };

    it('if email is invalid', function(done) {
      var agent = request.agent();
      agent
      .post('http://localhost:3000/signup')
        .send({email: 'invalid', password: 'password' })
        .end(function(error, res){
          res.text.should.containEql('Invalid email');
          done();
        });
    });

    it('if required fields are missing', function(done) {
      var agent = request.agent();
      agent
      .post('http://localhost:3000/signup')
        .send({email: '', password: '' })
        .end(function(error, res){
          res.text.should.containEql('Invalid email');
          res.text.should.containEql('Password is required');
          done();
        });
    });

    it('if user already exists', function(done) {
      var agent = request.agent();
      agent
      .post('http://localhost:3000/signup')
        .send({email: 'user1@example.com', password: 'password' })
        .end(function(error, res){
          res.text.should.containEql('User with given email already exists');
          done();
        });
    });
  });
})



