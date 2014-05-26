Notejam::App.controllers :user do

  layout :user

  get :signup, :map => '/signup' do
    render "user/signup"
  end

  post :signup, :map => '/signup' do
    @user = User.new(params[:user])
    if @user.save
      flash[:success] = 'Now you can sign in'
      redirect url(:user, :signin)
    end
    render "user/signup"
  end

  get :signin, :map => '/signin' do
    render "user/signin"
  end

  post :signup, :map => '/signin' do
    if user = User.authenticate(params[:email], params[:password])
      set_current_account(user)
      redirect url(:note, :all_notes)
    else
      params[:email] = h(params[:email])
      flash.now[:error] = "Invalid credentials"
      render "user/signin"
    end
  end
end
