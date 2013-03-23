from flask import render_template, flash, request, redirect, url_for

from notejam import app, db
from notejam.forms import SigninForm, SignupForm
from notejam.models import User


@app.route('/')
def index():
    return render_template('base.html')


@app.route('/signin/', methods=['GET', 'POST'])
def signin():
    form = SigninForm()
    if request.method == 'POST' and form.validate():
        flash('OK', 'success')
    return render_template('users/signin.html', form=form)


@app.route('/signup/', methods=['GET', 'POST'])
def signup():
    form = SignupForm()
    if request.method == 'POST' and form.validate():
        user = User(email=form.email.data)
        db.session.add(user)
        db.session.commit()
        flash('Account is created. Now you can sign in.', 'success')
        return redirect(url_for('signin'))
    return render_template('users/signup.html', form=form)
