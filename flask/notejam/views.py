from flask import render_template, flash, request

from notejam import app
from notejam.forms import SigninForm


@app.route('/')
def index():
    return render_template('base.html')


@app.route('/signin/', methods=['GET', 'POST'])
def signin():
    form = SigninForm()
    if request.method == 'POST' and form.validate():
        flash('OK', 'success')
    return render_template('users/signin.html', form=form)
