Notejam::App.controllers :note do

  layout :layout

  get :all_notes, :map => '/' do
    "All notes"
  end

  get :create, :map => '/notes/create' do
    render "note/create"
  end

  post :create, :map => '/notes/create' do
    @note = Note.new(params[:note])
    current_account.notes << @note
    if @note.save
      flash[:success] = 'Note is created!'
      redirect url(:note, :create)
    end
    print @note.errors.full_messages
    render "note/create"
  end

end

