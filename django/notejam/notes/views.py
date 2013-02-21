from django.views.generic.edit import CreateView, UpdateView, DeleteView
from notes.models import Note


class NoteCreate(CreateView):
    model = Note


class NoteUpdate(UpdateView):
    model = Note


class NoteDelete(DeleteView):
    model = Note
