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
    user = User.create(user_data)
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

  it "requires mandatory fields to create pad" do
    login_user user_data
    post "/pads/create", {
      "pad" => {
        "name" => ""
      }
    }
    last_response.body.should include("Name must not be blank")
  end

  it "edits pad successfully" do
    user = User.create(user_data)
    pad = Pad.create({name: "Initial name", user: user})
    login_user user_data
    post "/pads/#{pad.id}/edit", {
      "pad" => pad_data
    }
    expect(Pad.get(pad.id).name).to eq(pad_data['name'])
  end

  it "requires mandatory fields to edit pad" do
    user = User.create(user_data)
    pad = Pad.create({name: "Initial name", user: user})
    login_user user_data
    post "/pads/#{pad.id}/edit", {
      "pad" => {
        "name" => ""
      }
    }
    last_response.body.should include("Name must not be blank")
  end

  it "doens't allow to edit pad by not an owner" do
    owner = User.create(user_data)
    pad = Pad.create({name: "Initial name", user: owner})

    data = user_data
    data['email'] = 'another_user@example.com'
    another_user = User.create(data)

    login_user data
    post "/pads/#{pad.id}/edit", {
      "pad" => pad_data
    }
    expect(last_response.status).to eq(404)
  end

  it "views pad successfully" do
    user = User.create(user_data)
    pad = Pad.create({name: "Pad", user: user})
    login_user user_data

    get "/pads/#{pad.id}"
    expect(last_response.status).to eq(200)
  end

  it "doesn't allow to view pad by not an owner" do
    owner = User.create(user_data)
    pad = Pad.create({name: "Pad", user: owner})

    data = user_data
    data['email'] = 'another_user@example.com'
    another_user = User.create(data)

    login_user data
    get "/pads/#{pad.id}"
    expect(last_response.status).to eq(404)
  end

  it "deletes pad successfully" do
    user = User.create(user_data)
    pad = Pad.create({name: "Pad", user: user})
    login_user user_data
    post "/pads/#{pad.id}/delete"
    expect(Pad.count).to eq(0)
  end

  it "doesn't allow to delete pad by not an owner" do
    owner = User.create(user_data)
    pad = Pad.create({name: "Pad", user: owner})

    data = user_data
    data['email'] = 'another_user@example.com'
    another_user = User.create(data)

    login_user data
    post "/pads/#{pad.id}/delete"
    expect(last_response.status).to eq(404)
  end
end


