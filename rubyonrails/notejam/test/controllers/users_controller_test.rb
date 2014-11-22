require 'test_helper'

class UsersControllerTest < ActionController::TestCase
  test 'should successfully signup' do
    assert_difference('User.count') do
      post :signup, user: {
        email: 'user@example.com', password: 'password',
        password_confirmation: 'password'
      }
    end
    assert_redirected_to signin_path
  end

  test 'should not signup if invalid email' do
    post :signup, user: {
      email: 'invalid email', password: 'password',
      password_confirmation: 'password'
    }
    assert_select '.errorlist li', 'email is invalid'
  end

  test 'should not signup if required fields are missing' do
    post :signup, user: {
      email: '', password: '',
      password_confirmation: ''
    }
    assert_select '.errorlist li'
  end

  test 'should not signup if email exists' do
    email = users(:existent_user).email
    post :signup, user: {
      email: email, password: 'password',
      password_confirmation: 'password'
    }
    assert_select '.errorlist li', 'email has already been taken'
  end

  test 'should not signup if passwords do not match' do
    post :signup, user: {
      email: 'user@example.com', password: 'password1',
      password_confirmation: 'password2'
    }
    assert_select '.errorlist li'
  end

  test 'should successfully signin' do
    email = users(:existent_user).email
    post :signin,
         email: email, password: 'secure_password'

    assert_redirected_to notes_path
  end

  test 'should not signin if wrong email/password' do
    post :signin,
         email: 'some_email@example.com', password: 'password'

    assert_select '.alert-error', 'Invalid email or password'
  end
end
