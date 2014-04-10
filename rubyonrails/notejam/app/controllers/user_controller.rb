class UserController < ApplicationController
  def signup
    if params[:user]
      @user = User.new(user_params)
      if @user.valid?
        redirect_to url_for :signin
      end
    end
  end

  def signin
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
