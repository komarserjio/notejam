// Enable test environment
process.env.NODE_ENV = 'test';

var request = require('superagent');
var should = require('should');
require('should-http');

var db = require('../db');
var config = require('./config');
var app = require('../app');

app.listen(config.port);

describe('Note', function() {

  var agent = request.agent();
  before(
    config.signInUser(
      agent, {email: 'user1@example.com', password: 'password'}
    )
  );

  describe('can be', function() {
    it('successfully created', function(done) {
      agent
        .post(config.url('/notes/create'))
          .send({name: 'New note', text: 'text', pad_id: 1})
          .end(function(error, res){
            res.redirects.should.eql([config.url('/')]);
            res.text.should.containEql('Note is successfully created');
            done();
          });
    });

    it('successfully edited', function(done) {
      agent
        .post(config.url('/notes/1/edit'))
          .send({name: 'New name', text: 'New text'})
          .end(function(error, res){
            res.redirects.should.eql([config.url('/notes/1')]);
            res.text.should.containEql('Note is successfully updated');
            done();
          });
    });

    it('successfully deleted', function(done) {
      agent
        .post(config.url('/notes/2/delete'))
          .end(function(error, res){
            res.redirects.should.eql([config.url('/')]);
            res.text.should.containEql('Note is successfully deleted');
            done();
          });
    });

    it('successfully viewed', function(done) {
      agent
        .get(config.url('/notes/1'))
          .end(function(error, res){
            res.should.have.status(200);
            done();
          });
    });
  });

  describe('can not be', function() {
    it('created if required fields are missing', function(done) {
      agent
        .post(config.url('/notes/create'))
          .send({name: '', text: ''})
          .end(function(error, res){
            res.text.should.containEql('Name is required');
            res.text.should.containEql('Text is required');
            done();
          });
    });

    it('edited if required fields are missing', function(done) {
      agent
        .post(config.url('/notes/1/edit'))
          .send({name: '', text: ''})
          .end(function(error, res){
            res.text.should.containEql('Name is required');
            res.text.should.containEql('Text is required');
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
          .post(config.url('/notes/1/edit'))
            .send({name: 'new name', text: 'new text'})
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
          .post(config.url('/notes/1/delete'))
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
          .get(config.url('/notes/1'))
            .end(function(error, res){
              res.should.have.status(404);
              done();
            });
      })
    });
  });
});
