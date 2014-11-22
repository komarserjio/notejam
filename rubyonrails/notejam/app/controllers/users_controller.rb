class UsersController < ApplicationController
  before_action :authenticate_user, only: [:settings]

  def signup
    if params[:user]
      @user = User.new(user_params)
      if @user.valid?
        @user.save
        redirect_to signin_path, flash: { success: 'Account is created. Now you can sign in.' }
      end
    end
  end

  def signin
    if request.post?
      user = User.find_by_email(params[:email])
      if user && user.authenticate(params[:password])
        session[:user_id] = user.id
        redirect_to notes_path, flash: { success: 'Successfully signed in' }
      else
        flash.now[:error] = 'Invalid email or password'
      end
    end
  end

  def forgot_password
    if request.post?
      user = User.find_by_email(params[:email])
      if user
        new_password = generate_password
        user.password = new_password
        user.password_confirmation = new_password
        user.save
        UserMailer.send_new_password(user, new_password).deliver
        redirect_to signin_path, flash: { success: 'New password sent to your mail' }
        return
      end
      flash.now[:error] = 'No user with given email found'
    end
  end

  def signout
    session[:user_id] = nil
    redirect_to signin_path
  end

  def settings
    @user = current_user
    if params[:user]
      unless current_user.authenticate(params[:current_password])
        flash.now[:error] = 'Invalid current password'
        return
      end
      @user.password = user_params[:password]
      @user.password_confirmation = user_params[:password_confirmation]
      if @user.valid?
        @user.save
        redirect_to settings_path, flash: { success: 'Password is successfully changed' }
      end
    end
  end

  private

  def user_params
    params.require(:user).permit(:email, :password, :password_confirmation, :current_password)
  end

  def generate_password
    # weak password generation
    ('a'..'z').to_a.sample(8).join
  end
end
