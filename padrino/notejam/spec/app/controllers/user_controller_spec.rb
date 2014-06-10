require 'spec_helper'

describe "UserController" do

  it "successfully signs up" do
    post "/signup", {
      "user" => {
        "email" => "user@example.com",
        "password" => "123123",
        "password_confirmation" => "123123",
      }
    }
    last_response.should be_redirect
    follow_redirect!
    last_request.url.should include("/signin")

    expect(User.count).to eq(1)
  end

  it "doesn't sign up if email is taken" do
  end

  it "successfully signs in" do
  end

  it "doesn't sign in if invalid credentials" do
  end
end
