from django.views.generic.edit import CreateView, UpdateView, DeleteView
from django.views.generic import ListView
from notes.models import Note


class NoteCreateView(CreateView):
    model = Note


class NoteUpdateView(UpdateView):
    model = Note


class NoteDeleteView(DeleteView):
    model = Note


class NoteListView(ListView):
    model = Note
