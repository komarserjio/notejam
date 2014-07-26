Notejam::App.controllers :note do

  layout :layout

  get :all_notes, :map => '/' do
    @notes = Note.all(
      :user_id => current_account.id, :order => order_param(params)
    )
    render "note/list"
  end

  get :create, :map => '/notes/create' do
    render "note/create"
  end

  post :create, :map => '/notes/create' do
    # @TODO datamapper validation issue?
    if params[:note][:pad_id] == "0"
      params[:note].delete("pad_id")
    else
      @pad = get_or_404(current_account.pads, params[:note][:pad_id])
    end

    @note = Note.new(params[:note])
    current_account.notes << @note
    if @note.save
      flash[:success] = 'Note is successfully created.'
      redirect url(:note, :view, :id => @note.id)
    end
    render "note/create"
  end

  get :edit, :map => '/notes/:id/edit' do
    @note = get_or_404(current_account.notes, params[:id])
    render "note/edit"
  end

  post :edit, :map => '/notes/:id/edit' do
    @note = get_or_404(current_account.notes, params[:id])

    # @TODO datamapper validation issue?
    if params[:note][:pad_id] == "0"
     params[:note].delete("pad_id")
    end

    @note.update(params[:note])
    if @note.save
      flash[:success] = 'Note is successfully updated.'
      redirect url(:note, :view, :id => @note.id)
    end
    render "note/edit"
  end

  get :view, :map => '/notes/:id' do
    @note = get_or_404(current_account.notes, params[:id])
    render "note/view"
  end

  get :delete, :map => '/notes/:id/delete' do
    @note = get_or_404(current_account.notes, params[:id])
    render "note/delete"
  end

  post :delete, :map => '/notes/:id/delete' do
    @note = get_or_404(current_account.notes, params[:id])
    @note.destroy
    flash[:success] = 'Note is successfully deleted.'
    redirect url(:note, :all_notes)
  end

end

