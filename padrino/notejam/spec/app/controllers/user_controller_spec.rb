require 'spec_helper'

describe "UserController" do
  before do
    get "/"
  end

  it "returns hello world" do
    last_response.body.should == "Hello World"
  end

  it "successfully signs up" do
  end

  it "requires fields to sign up" do
  end

  it "doesn't sign up if email is taken" do
  end

  it "successfully signs in" do
  end

  it "doesn't sign in if invalid credentials" do
  end
end
