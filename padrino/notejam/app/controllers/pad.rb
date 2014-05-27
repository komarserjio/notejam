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
      redirect url(:pad, :create)
    end
    render "pad/create"
  end

  get :view, :map => '/pads/:id/' do
    "View pad"
  end

  get :edit, :map => '/pads/:id/edit' do
    @pad = Pad.get(params[:id])
    render "pad/edit"
  end

  post :edit, :map => '/pads/:id/edit' do
    @pad = Pad.get(params[:id])
    @pad.update(params[:pad])
    if @pad.save
      flash[:success] = 'Pad is updated!'
      redirect url(:pad, :edit, :id => @pad.id)
    end
    render "pad/edit"
  end

end


