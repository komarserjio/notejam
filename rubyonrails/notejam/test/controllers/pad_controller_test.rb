require 'test_helper'

class PadControllerTest < ActionController::TestCase
  test "pad should be created" do
    login_as(:existent_user)
    assert_difference('Pad.count') do
      post :create, pad: {name: "test pad"}
    end
  end
end
