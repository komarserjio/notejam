module.exports = {
  host: 'http://' + process.env.NOTEJAM_HOST,
  port: 3000,

  // build absolute url
  url: function(url) {
    return this.host + ":" + this.port + url;
  },

  // sign in user/agent
  signInUser: function (agent, user) {
    var self = this;
    return function(done) {
      agent
        .post(self.url('/signin'))
        .send(user)
        .end(onResponse);

      function onResponse(err, res) {
        res.should.have.status(200);
        return done();
      }
    };
  }
};
