class UserMailer < ActionMailer::Base
  default from: 'noreply@notejamapp.com'

  def send_new_password(user, password)
    @user = user
    @password = password
    mail(to: @user.email, subject: 'New notejam password')
  end
end
