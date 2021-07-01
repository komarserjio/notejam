from django import forms

from notes.models import Note


class NoteForm(forms.ModelForm):
    class Meta:
        model = Note
        exclude = ('created_at', 'updated_at', 'user')
