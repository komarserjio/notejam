class ApplicationController < ActionController::Base
  # Prevent CSRF attacks by raising an exception.
  # For APIs, you may want to use :null_session instead.
  protect_from_forgery with: :exception

  def authenticate_user
    if session[:user_id]
      return true
    else
      redirect_to(
        url_for(:signin),
        :flash => {:success => "Please sign in"}
      )
    end
  end


  private
    def order_param
      order = params[:order] || '-updated_at'
      {"name" => "name ASC",
       "-name" => "name DESC",
       "updated_at" => "updated_at ASC",
       "-updated_at" => "updated_at DESC"}[order]
    end

    def current_user
      @current_user ||= User.find(session[:user_id]) if session[:user_id]
    end
    helper_method :current_user
end
