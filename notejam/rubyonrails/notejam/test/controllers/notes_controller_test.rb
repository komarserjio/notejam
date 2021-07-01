require 'test_helper'

class NotesControllerTest < ActionController::TestCase
  test 'note should be successfully created' do
    assert_response :success
    login_as(:existent_user)
    assert_difference('Note.count') do
      post :create, note: { name: 'test note', text: 'text', pad_id: 0 }
    end
  end

  test 'note should not be created by anonymous user' do
    post :create, note: { name: 'test note', text: 'text' }
    assert_redirected_to signin_path
  end

  test 'note should not be created if required fields are missing' do
    login_as(:existent_user)
    post :create, note: { name: '', text: '', pad_id: 0 }
    assert_select '.errorlist li', count: 2
  end

  test 'note should be edited by an owner' do
    login_as(:existent_user)
    note = notes(:existent_note)
    new_name = 'new name'
    new_text = 'new text'
    post :edit, id: note.id, note: { name: new_name, text: new_text, pad_id: 0 }
    assert_redirected_to note_path id: note.id
    assert_equal [new_name, new_text], [Note.first.name, Note.first.text]
  end

  test "note can't be edited if required fields are missing" do
    login_as(:existent_user)
    note = notes(:existent_note)
    post :edit, id: note.id, note: { name: '', text: '', pad_id: 0 }
    assert_select '.errorlist li', count: 2
  end

  test 'note should not be edited by not an owner' do
    login_as(:existent_user2)
    note = notes(:existent_note)
    post :edit, id: note.id, note: { name: 'name', text: 'text' }
    assert_response :missing
  end

  test "note should not be added into another's user pad" do
    login_as(:existent_user2)
    another_user_pad = pads(:existent_pad)
    post :create, note: {
      name: 'name', text: 'text', pad_id: another_user_pad.id
    }
    assert_response :missing
  end

  test 'note should be viewed by an owner' do
    login_as(:existent_user)
    note = notes(:existent_note)
    get :show, id: note.id
    assert_response :success
  end

  test 'note should not be viewed by not an owner' do
    login_as(:existent_user2)
    note = notes(:existent_note)
    get :show, id: note.id
    assert_response :missing
  end

  test 'note should be deleted by an owner' do
    login_as(:existent_user)
    note = notes(:existent_note)
    assert_difference('Note.count', -1) do
      post :delete, id: note.id
    end
  end

  test 'note should not be deleted by not an owner' do
    login_as(:existent_user2)
    note = notes(:existent_note)
    post :delete, id: note.id
    assert_response :missing
  end

  test 'note should be listed in index page' do
    login_as(:existent_user)
    get :index
    assert_response :success
  end
end
