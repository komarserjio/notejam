Notejam::App.controllers :note do

  layout :layout

  get :all_notes, :map => '/' do
    "All notes"
  end

  get :create, :map => '/notes/create' do
    render "note/create"
  end

  post :create, :map => '/notes/create' do
    if params[:note][:pad_id] == "0"
     params[:note].delete("pad_id")
    end

    @note = Note.new(params[:note])
    current_account.notes << @note
    if @note.save
      flash[:success] = 'Note is created!'
      redirect url(:note, :create)
    end
    render "note/create"
  end

  get :edit, :map => '/notes/:id/edit' do
    @note = get_or_404(current_account.notes, params[:id])
    render "note/edit"
  end

end

