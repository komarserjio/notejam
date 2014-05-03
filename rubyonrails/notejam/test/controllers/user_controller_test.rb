require 'test_helper'

class UserControllerTest < ActionController::TestCase
  test "should successfully signup" do
    assert_difference('User.count') do
      post :signup, user: {
        email: 'user@example.com', password: 'password',
        password_confirmation: 'password'
      }
    end
    assert_redirected_to signin_path
  end
end
