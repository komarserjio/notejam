class UserController < ApplicationController
  #before_filter :authenticate_user, :only => [:signin]
  def signup
    if params[:user]
      @user = User.new(user_params)
      if @user.valid?
        @user.save
        redirect_to(
          url_for(:signin), 
          :flash => {:success => "Now you can sign in"}
        )
      end
    end
  end

  def signin
    if request.post?
      user = User.find_by_email(params[:email])
      if user && user.authenticate(params[:password])
        session[:user_id] = user.id
        redirect_to(
          url_for(:all_notes),
          :flash => {:success => "Successfully signed in"}
        )
      else
        flash.now[:error] = "Invalid email or password"
      end
    end
  end

  def forgot_password
  end

  def signout
    session[:user_id] = nil
    redirect_to url_for :signin
  end

  def change_password
  end

  private
    def user_params
      params.require(:user).permit(:email, :password, :password_confirmation)
    end
end
