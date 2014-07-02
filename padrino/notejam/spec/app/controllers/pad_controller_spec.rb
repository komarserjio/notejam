require 'spec_helper'

describe "PadController" do

  def pad_data
    {
      "name" => "Pad"
    }
  end

  it "requires to be signed in to create pad" do
    post "/pads/create", {
      "pad" => pad_data
    }
    last_response.should be_redirect
    follow_redirect!
    last_request.url.should include("/signin")
  end

  it "creates pad successfully" do
    #last_response.body.should == "Hello World"
    #post "/signup", {
      #"user" => user_data
    #}
    #last_response.should be_redirect
    #follow_redirect!
    #last_request.url.should include("/signin")

    #expect(User.count).to eq(1)
  end
end


