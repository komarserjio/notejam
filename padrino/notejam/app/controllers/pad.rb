Notejam::App.controllers :pad do

  layout :layout

  get :create, :map => '/pads/create' do
    render "pad/create"
  end

  post :create, :map => '/pads/create' do
    @pad = Pad.new(params[:pad])
    current_account.pads << @pad
    if @pad.save
      flash[:success] = 'Pad is created!'
      redirect url(:pad, :view, :id => @pad.id)
    end
    @pad.destroy
    render "pad/create"
  end

  get :edit, :map => '/pads/:id/edit' do
    @pad = get_or_404(current_account.pads, params[:id])
    render "pad/edit"
  end

  post :edit, :map => '/pads/:id/edit' do
    @pad = get_or_404(current_account.pads, params[:id])
    @pad.update(params[:pad])
    if @pad.save
      flash[:success] = 'Pad is updated!'
      redirect url(:pad, :view, :id => @pad.id)
    end
    render "pad/edit"
  end

  get :delete, :map => '/pads/:id/delete' do
    @pad = get_or_404(current_account.pads, params[:id])
    render "pad/delete"
  end

  post :delete, :map => '/pads/:id/delete' do
    @pad = get_or_404(current_account.pads, params[:id])
    @pad.destroy
    flash[:success] = 'Pad is deleted!'
    redirect url(:note, :all_notes)
  end

  get :view, :map => '/pads/:id' do
    @pad = get_or_404(current_account.pads, params[:id])
    @notes = Note.all(
      :pad_id => @pad.id, :order => order_param(params)
    )
    render "pad/view"
  end
end


