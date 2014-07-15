Notejam::App.mailer :mailer do

  email :new_password_email do |email, password|
    from 'noreply@notejamapp.com'
    to email
    subject 'New notejam password'
    locals :password => password, :email => email
    render 'mailer/new_password_email'
  end

end
