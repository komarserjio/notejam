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
      
    end
  end

  def forgot_password
  end

  def signout
  end

  def change_password
  end

  private
    def user_params
      params.require(:user).permit(:email, :password, :password_confirmation)
    end
end
