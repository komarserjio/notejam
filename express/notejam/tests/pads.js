// Enable test environment
process.env.NODE_ENV = 'test';

var request = require('superagent');
var should = require('should');
var db = require('../db');

var app = require('../app');
app.listen(3000);

describe('Pad', function() {
  beforeEach(function() {
    db.createTables();
    db.applyFixtures();
  });

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
        .post('http://localhost:3000/pads/1/delete')
          .end(function(error, res){
            res.redirects.should.eql(['http://localhost:3000/']);
            res.text.should.containEql('Pad is successfully deleted');
            done();
          });
    });
  });

  //describe('can not be', function() {

  //});
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
