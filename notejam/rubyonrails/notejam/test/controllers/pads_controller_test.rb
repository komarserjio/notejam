require 'test_helper'

class PadsControllerTest < ActionController::TestCase
  test 'pad should be created' do
    login_as(:existent_user)
    assert_difference('Pad.count') do
      post :create, pad: { name: 'test pad' }
    end
  end

  test 'pad should not be created if required fields are missing' do
    login_as(:existent_user)
    post :create, pad: { name: '' }
    assert_select '.errorlist li', "name can't be blank"
  end

  test 'pad should not be created by anonymous user' do
    post :create, pad: { name: 'test pad' }
    assert_redirected_to signin_path
  end

  test 'pad should not be edited if required fields are misiing' do
    login_as(:existent_user)
    pad = pads(:existent_pad)
    post :edit, id: pad.id, pad: { name: '' }
    assert_select '.errorlist li', "name can't be blank"
  end

  test 'pad should be edited by an owner' do
    login_as(:existent_user)
    pad = pads(:existent_pad)
    new_name = 'new_name'
    post :edit, id: pad.id, pad: { name: new_name }
    assert_redirected_to pad_path id: pad.id
    assert_equal new_name, Pad.first.name
  end

  test 'pad should not be edited by not an owner' do
    login_as(:existent_user2)
    pad = pads(:existent_pad)
    new_name = 'new_name'
    post :edit, id: pad.id, pad: { name: new_name }
    assert_response :missing
  end

  test 'pad notes should be viewd by an owner' do
    login_as(:existent_user)
    pad = pads(:existent_pad)
    get :show, id: pad.id
    assert_response :success
  end

  test 'pad notes should not be viewed by not an owner' do
    login_as(:existent_user2)
    pad = pads(:existent_pad)
    get :show, id: pad.id
    assert_response :missing
  end

  test 'pad should be deleted by an owner' do
    login_as(:existent_user)
    pad = pads(:existent_pad)
    assert_difference('Pad.count', -1) do
      post :delete, id: pad.id
    end
  end

  test 'pad should not be deleted by not an owner' do
    login_as(:existent_user2)
    pad = pads(:existent_pad)
    post :delete, id: pad.id
    assert_response :missing
  end
end
