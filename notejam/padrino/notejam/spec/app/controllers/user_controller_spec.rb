require 'spec_helper'

describe "UserController" do

  def user_data
    {
      "email" => "user@example.com",
      "password" => "secure_password",
      "password_confirmation" => "secure_password",
    }
  end


  it "successfully signs up" do
    post "/signup", {
      "user" => user_data
    }
    last_response.should be_redirect
    follow_redirect!
    last_request.url.should include("/signin")

    expect(User.count).to eq(1)
  end

  it "requires mandatory fields to sign up" do
    post "/signup", {
      "user" => {
        "email" => "",
        "password" => "",
        "password_confirmation" => "",
      }
    }
    last_response.body.should include("Email must not be blank")
    last_response.body.should include("Password must not be blank")
    last_response.body.should include(
      "Password confirmation must not be blank"
    )
  end

  it "requires passwords to match" do
    data = user_data
    data['password_confirmation'] = "wrong"

    post "/signup", {
      "user" => data
    }
    last_response.body.should include(
      "Password does not match the confirmation"
    )
  end

  it "doesn't sign up if email is taken" do
    user = User.create(user_data)
    post "/signup", {
      "user" => user_data
    }
    last_response.body.should include("Email is already taken")
  end

  it "successfully signs in" do
    user = User.create(user_data)
    post "/signin", {
      "email" => user_data['email'],
      "password" => user_data['password']
    }
    last_response.should be_redirect
    follow_redirect!
    last_request.url.should include("/")
  end

  it "requires correct credentials to sign in" do
    user = User.create(user_data)
    post "/signin", {
      "email" => user_data['email'],
      "password" => "wrong password"
    }
    last_response.body.should include("Wrong email or password")
  end
end
