from flask import render_template, flash, request, redirect, url_for
from flask.ext.login import login_user, login_required, logout_user

from notejam import app, db, login_manager
from notejam.forms import SigninForm, SignupForm
from notejam.models import User


@login_manager.user_loader
def load_user(user_id):
    return User.query.get(user_id)


@app.route('/')
@login_required
def index():
    return render_template('base.html')


# @TODO use macro for form fields in template
@app.route('/signin/', methods=['GET', 'POST'])
def signin():
    form = SigninForm()
    if form.validate_on_submit():
        auth_user = User.authenticate(form.email.data, form.password.data)
        if auth_user:
            login_user(auth_user)
            flash('You are signed in!', 'success')
            return redirect(url_for('index'))
        else:
            flash('Wrong credentials.', 'error')
    return render_template('users/signin.html', form=form)


@app.route('/signout/')
def signout():
    logout_user()
    return redirect(url_for('signin'))


# @TODO use macro for form fields in template
@app.route('/signup/', methods=['GET', 'POST'])
def signup():
    form = SignupForm()
    if request.method == 'POST' and form.validate():
        user = User(email=form.email.data)
        user.set_password(form.password.data)
        db.session.add(user)
        db.session.commit()
        flash('Account is created. Now you can sign in.', 'success')
        return redirect(url_for('signin'))
    return render_template('users/signup.html', form=form)


@app.route('/settings/')
def account_settings():
    pass
