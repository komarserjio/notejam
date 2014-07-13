require 'spec_helper'

describe "PadController" do

  def pad_data
    {
      "name" => "Pad"
    }
  end

  def user_data
    {
      "email" => "user@example.com",
      "password" => "secure_password",
      "password_confirmation" => "secure_password",
    }
  end

  # How to enable testing sessions?
  # http://snippets.aktagon.com/snippets/332-testing-sessions-with-sinatra-and-rack-test
  # Silly workaround:
  def login_user(user_data)
    user= User.create(user_data)
    post "/signin", {
      "email" => user_data['email'],
      "password" => user_data['password']
    }
    user
  end

  it "requires to be signed in to create pad" do
    post "/pads/create", {
      "pad" => pad_data,
    }
    last_response.should be_redirect
    follow_redirect!
    last_request.url.should include("/signin")
  end

  it "creates pad successfully" do
    login_user user_data
    post "/pads/create", {
      "pad" => pad_data
    }

    expect(Pad.count).to eq(1)
  end
end


