require 'test_helper'

class PadControllerTest < ActionController::TestCase
  test "pad should be created" do
    login_as(:existent_user)
    assert_difference('Pad.count') do
      post :create, pad: {name: "test pad"}
    end
  end

  test "pad should not be created if required fields are missing" do
    login_as(:existent_user)
    post :create, pad: {name: ""}
    assert_select ".errorlist li", "name can't be blank"
  end

  test "pad should not be created by anonymous user" do
    post :create, pad: {name: "test pad"}
    assert_redirected_to signin_path
  end

  test "pad should be editable by an owner" do
    login_as(:existent_user)
    pad = pads(:existent_pad)
    new_name = "new_name"
    post :edit, {id: pad.id, pad: {name: new_name}}
    assert_redirected_to view_pad_notes_path :id => pad.id
    assert_equal new_name, Pad.first.name
  end

  test "pad should not be editable by not an owner" do
    login_as(:existent_user2)
    pad = pads(:existent_pad)
    new_name = "new_name"
    post :edit, {id: pad.id, pad: {name: new_name}}
    assert_response :missing
  end
end
