from datetime import date
import md5

from flask import render_template, flash, request, redirect, url_for, abort
from flask.ext.login import (login_user, login_required, logout_user,
current_user)
from flask.ext.mail import Message

from notejam import app, db, login_manager, mail
from notejam.models import User, Note, Pad
from notejam.forms import (SigninForm, SignupForm, NoteForm, PadForm,
DeleteForm, ChangePasswordForm, ForgotPasswordForm)


@login_manager.user_loader
def load_user(user_id):
    return User.query.get(user_id)


@app.route('/')
@login_required
def home():
    notes = (Note.query
                 .filter_by(user=current_user)
                 .order_by(_get_order_by(request.args.get('order')))
                 .all())
    return render_template('notes/list.html', notes=notes)


@app.route('/notes/create/', methods=['GET', 'POST'])
@login_required
def create_note():
    note_form = NoteForm(user=current_user, pad=request.args.get('pad'))
    if note_form.validate_on_submit():
        note = Note(
            name=note_form.name.data,
            text=note_form.text.data,
            pad_id=note_form.pad.data,
            user=current_user
        )
        db.session.add(note)
        db.session.commit()
        flash('Note is successfully created', 'success')
        return redirect(_get_note_success_url(note))
    return render_template('notes/create.html', form=note_form)


@app.route('/notes/<int:note_id>/edit/', methods=['GET', 'POST'])
@login_required
def edit_note(note_id):
    note = _get_user_object_or_404(Note, note_id, current_user)
    note_form = NoteForm(user=current_user, obj=note)
    if note_form.validate_on_submit():
        note.name = note_form.name.data
        note.text = note_form.text.data
        note.pad_id = note_form.pad.data

        db.session.commit()
        flash('Note is successfully updated', 'success')
        return redirect(_get_note_success_url(note))
    if note.pad:
        note_form.pad.data = note.pad.id  # XXX ?
    return render_template('notes/edit.html', form=note_form)


@app.route('/notes/<int:note_id>/')
@login_required
def view_note(note_id):
    note = _get_user_object_or_404(Note, note_id, current_user)
    return render_template('notes/view.html', note=note)


@app.route('/notes/<int:note_id>/delete/', methods=['GET', 'POST'])
@login_required
def delete_note(note_id):
    note = _get_user_object_or_404(Note, note_id, current_user)
    delete_form = DeleteForm()
    if request.method == 'POST':
        db.session.delete(note)
        db.session.commit()
        flash('Note is successfully deleted', 'success')
        if note.pad:
            return redirect(url_for('pad_notes', pad_id=note.pad.id))
        else:
            return redirect(url_for('home'))
    return render_template('notes/delete.html', note=note, form=delete_form)


@app.route('/pads/create/', methods=['GET', 'POST'])
@login_required
def create_pad():
    pad_form = PadForm()
    if pad_form.validate_on_submit():
        pad = Pad(
            name=pad_form.name.data,
            user=current_user
        )
        db.session.add(pad)
        db.session.commit()
        flash('Pad is successfully created', 'success')
        return redirect(url_for('home'))
    return render_template('pads/create.html', form=pad_form)


@app.route('/pads/<int:pad_id>/edit/', methods=['GET', 'POST'])
@login_required
def edit_pad(pad_id):
    pad = _get_user_object_or_404(Pad, pad_id, current_user)
    pad_form = PadForm(obj=pad)
    if pad_form.validate_on_submit():
        pad.name = pad_form.name.data
        db.session.commit()
        flash('Pad is successfully updated', 'success')
        return redirect(url_for('pad_notes', pad_id=pad.id))
    return render_template('pads/edit.html', form=pad_form, pad=pad)


@app.route('/pads/<int:pad_id>/')
@login_required
def pad_notes(pad_id):
    pad = _get_user_object_or_404(Pad, pad_id, current_user)
    notes = (Note.query
                 .filter_by(user=current_user, pad=pad)
                 .order_by(_get_order_by(request.args.get('order')))
                 .all())
    return render_template('pads/note_list.html', pad=pad, notes=notes)


@app.route('/pads/<int:pad_id>/delete/', methods=['GET', 'POST'])
@login_required
def delete_pad(pad_id):
    pad = _get_user_object_or_404(Pad, pad_id, current_user)
    delete_form = DeleteForm()
    if request.method == 'POST':
        db.session.delete(pad)
        db.session.commit()
        flash('Note is successfully deleted', 'success')
        return redirect(url_for('home'))
    return render_template('pads/delete.html', pad=pad, form=delete_form)


# @TODO use macro for form fields in template
@app.route('/signin/', methods=['GET', 'POST'])
def signin():
    form = SigninForm()
    if form.validate_on_submit():
        auth_user = User.authenticate(form.email.data, form.password.data)
        if auth_user:
            login_user(auth_user)
            flash('You are signed in!', 'success')
            return redirect(url_for('home'))
        else:
            flash('Wrong email or password', 'error')
    return render_template('users/signin.html', form=form)


@app.route('/signout/')
def signout():
    logout_user()
    return redirect(url_for('signin'))


@app.route('/signup/', methods=['GET', 'POST'])
def signup():
    form = SignupForm()
    if form.validate_on_submit():
        user = User(email=form.email.data)
        user.set_password(form.password.data)
        db.session.add(user)
        db.session.commit()
        flash('Account is created. Now you can sign in.', 'success')
        return redirect(url_for('signin'))
    return render_template('users/signup.html', form=form)


@app.route('/settings/', methods=['GET', 'POST'])
@login_required
def account_settings():
    form = ChangePasswordForm(user=current_user)
    if form.validate_on_submit():
        current_user.set_password(form.new_password.data)
        db.session.commit()
        flash("Your password is successfully changed.", 'success')
        return redirect(url_for('home'))
    return render_template('users/settings.html', form=form)


@app.route('/forgot-password/', methods=['GET', 'POST'])
def forgot_password():
    form = ForgotPasswordForm()
    if form.validate_on_submit():
        user = User.query.filter_by(email=form.email.data).first()
        new_password = _generate_password(user)
        user.set_password(new_password)

        message = Message(
            subject="Notejam password",
            body="Your new password is {}".format(new_password),
            sender="from@notejamapp.com",
            recipients=[user.email]
        )
        mail.send(message)

        db.session.commit()
        flash("Find new password in your inbox", 'success')
        return redirect(url_for('home'))
    return render_template('users/forgot_password.html', form=form)


# context processors and filters
@app.context_processor
def inject_user_pads():
    ''' inject list of user pads in template context '''
    if not current_user.is_anonymous():
        return dict(pads=current_user.pads.all())
    return dict(pads=[])


@app.template_filter('smart_date')
def smart_date_filter(updated_at):
    delta = date.today() - updated_at.date()
    if delta.days == 0:
        return 'Today at {}'.format(updated_at.strftime("%H:%M"))
    elif delta.days == 1:
        return 'Yesterday at {}'.format(updated_at.strftime("%H:%M"))
    elif 1 > delta.days > 4:
        return '{} days ago'.format(abs(delta.days))
    else:
        return updated_at.date()


# helper functions, @TODO move to helpers.py?
def _get_note_success_url(note):
    ''' get note success redirect url depends on note's pad '''
    if note.pad is None:
        return url_for('home')
    else:
        return url_for('pad_notes', pad_id=note.pad.id)


def _get_user_object_or_404(model, object_id, user, code=404):
    ''' get an object by id and owner user or raise an abort '''
    result = model.query.filter_by(id=object_id, user=user).first()
    return result or abort(code)


def _get_order_by(param='-updated_at'):
    ''' get model order param by string description '''
    return {
        'name': Note.name.asc(),
        '-name': Note.name.desc(),
        'updated_at': Note.updated_at.asc(),
        '-updated_at': Note.updated_at.desc(),
    }.get(param, Note.updated_at.desc())


def _generate_password(user):
    ''' generate new user password '''
    m = md5.new()
    m.update(
        "{email}{secret}{date}".format(
            email=user.email,
            secret=app.secret_key,
            date=str(date.today())
        )
    )
    return m.hexdigest()[:8]
