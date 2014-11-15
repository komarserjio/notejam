// Enable test environment
process.env.NODE_ENV = 'test';

var request = require('superagent');
var should = require('should');
require('should-http');

var db = require('../db');

var app = require('../app');
app.listen(3000);

before(function(done) {
  db.createTables(function() {
    db.applyFixtures(done);
  });
});

describe('Pad', function() {

  var agent = request.agent();
  before(
    signInUser(agent, {email: 'user1@example.com', password: 'password'})
  );

  describe('can be', function() {
    it('successfully created', function(done) {
      agent
        .post('http://localhost:3000/pads/create')
          .send({name: 'New pad'})
          .end(function(error, res){
            res.redirects.should.eql(['http://localhost:3000/']);
            res.text.should.containEql('Pad is successfully created');
            done();
          });
    });

    it('successfully edited', function(done) {
      agent
        .post('http://localhost:3000/pads/1/edit')
          .send({name: 'New pad name'})
          .end(function(error, res){
            res.redirects.should.eql(['http://localhost:3000/']);
            res.text.should.containEql('Pad is successfully updated');
            done();
          });
    });

    it('successfully deleted', function(done) {
      agent
        .post('http://localhost:3000/pads/2/delete')
          .end(function(error, res){
            res.redirects.should.eql(['http://localhost:3000/']);
            res.text.should.containEql('Pad is successfully deleted');
            done();
          });
    });

    it('successfully viewed', function(done) {
      agent
        .get('http://localhost:3000/pads/1')
          .end(function(error, res){
            res.should.have.status(200);
            res.text.should.containEql('Pad settings');
            done();
          });
    });
  });

  describe('can not be', function() {
    it('created if required fields are missing', function(done) {
      agent
        .post('http://localhost:3000/pads/create')
          .send({name: ''})
          .end(function(error, res){
            res.text.should.containEql('Name is required');
            done();
          });
    });

    it('edited if required fields are missing', function(done) {
      agent
        .post('http://localhost:3000/pads/1/edit')
          .send({name: ''})
          .end(function(error, res){
            res.text.should.containEql('Name is required');
            done();
          });
    });

    it('edited by not an owner', function(done) {
      var agent = request.agent();
      var signed = signInUser(
        agent, {email: 'user2@example.com', password: 'password'}
      );
      signed(function() {
        agent
          .post('http://localhost:3000/pads/1/edit')
            .send({name: 'new name'})
            .end(function(error, res){
              res.should.have.status(404);
              done();
            });
      })
    });

    it('deleted by not an owner', function(done) {
      var agent = request.agent();
      var signed = signInUser(
        agent, {email: 'user2@example.com', password: 'password'}
      );
      signed(function() {
        agent
          .post('http://localhost:3000/pads/1/delete')
            .end(function(error, res){
              res.should.have.status(404);
              done();
            });
      })
    });

    it('viewed by not an owner', function(done) {
      var agent = request.agent();
      var signed = signInUser(
        agent, {email: 'user2@example.com', password: 'password'}
      );
      signed(function() {
        agent
          .get('http://localhost:3000/pads/1')
            .end(function(error, res){
              res.should.have.status(404);
              done();
            });
      })
    });
  });
});


function signInUser(agent, user) {
  return function(done) {
    agent
      .post('http://localhost:3000/signin')
      .send(user)
      .end(onResponse);

    function onResponse(err, res) {
      res.should.have.status(200);
      return done();
    }
  };
}
