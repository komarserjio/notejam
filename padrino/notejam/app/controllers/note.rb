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

  post :edit, :map => '/notes/:id/edit' do
    @note = get_or_404(current_account.notes, params[:id])

    if params[:note][:pad_id] == "0"
     params[:note].delete("pad_id")
    end

    @note.update(params[:note])
    if @note.save
      flash[:success] = 'Note is updated!'
      redirect url(:note, :view, :id => @note.id)
    end
    render "note/edit"
  end

  get :view, :map => '/notes/:id' do
    @note = get_or_404(current_account.notes, params[:id])
    render "note/view"
  end

end

