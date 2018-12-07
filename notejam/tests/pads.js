// Enable test environment
process.env.NODE_ENV = 'test';

var request = require('superagent');
var should = require('should');
require('should-http');

var db = require('../db');
var config = require('./config');
var app = require('../app');

app.listen(3000);

describe('Pad', function() {

  var agent = request.agent();
  before(
    config.signInUser(agent, {email: 'user1@example.com', password: 'password'})
  );

  describe('can be', function() {
    it('successfully created', function(done) {
      agent
        .post(config.url('/pads/create'))
          .send({name: 'New pad'})
          .end(function(error, res){
            res.redirects.should.eql([config.url('/')]);
            res.text.should.containEql('Pad is successfully created');
            done();
          });
    });

    it('successfully edited', function(done) {
      agent
        .post(config.url('/pads/1/edit'))
          .send({name: 'New pad name'})
          .end(function(error, res){
            res.redirects.should.eql([config.url('/')]);
            res.text.should.containEql('Pad is successfully updated');
            done();
          });
    });

    it('successfully deleted', function(done) {
      agent
        .post(config.url('/pads/2/delete'))
          .end(function(error, res){
            res.redirects.should.eql([config.url('/')]);
            res.text.should.containEql('Pad is successfully deleted');
            done();
          });
    });

    it('successfully viewed', function(done) {
      agent
        .get(config.url('/pads/1'))
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
        .post(config.url('/pads/create'))
          .send({name: ''})
          .end(function(error, res){
            res.text.should.containEql('Name is required');
            done();
          });
    });

    it('edited if required fields are missing', function(done) {
      agent
        .post(config.url('/pads/1/edit'))
          .send({name: ''})
          .end(function(error, res){
            res.text.should.containEql('Name is required');
            done();
          });
    });

    it('edited by not an owner', function(done) {
      var agent = request.agent();
      var signed = config.signInUser(
        agent, {email: 'user2@example.com', password: 'password'}
      );
      signed(function() {
        agent
          .post(config.url('/pads/1/edit'))
            .send({name: 'new name'})
            .end(function(error, res){
              res.should.have.status(404);
              done();
            });
      })
    });

    it('deleted by not an owner', function(done) {
      var agent = request.agent();
      var signed = config.signInUser(
        agent, {email: 'user2@example.com', password: 'password'}
      );
      signed(function() {
        agent
          .post(config.url('/pads/1/delete'))
            .end(function(error, res){
              res.should.have.status(404);
              done();
            });
      })
    });

    it('viewed by not an owner', function(done) {
      var agent = request.agent();
      var signed = config.signInUser(
        agent, {email: 'user2@example.com', password: 'password'}
      );
      signed(function() {
        agent
          .get(config.url('/pads/1'))
            .end(function(error, res){
              res.should.have.status(404);
              done();
            });
      })
    });
  });
});
