from django.core.urlresolvers import reverse_lazy
from django.shortcuts import redirect
from django.views.generic.edit import CreateView, UpdateView, DeleteView
from django.views.generic.detail import DetailView
from django.views.generic import ListView

from notes.models import Note
from notes.forms import NoteForm


class NoteCreateView(CreateView):
    model = Note
    form_class = NoteForm
    success_url = reverse_lazy('home')

    def form_valid(self, form):
        self.object = form.save(commit=False)
        self.object.user = self.request.user
        self.object.save()
        return redirect(self.get_success_url())


class NoteUpdateView(UpdateView):
    model = Note
    form_class = NoteForm
    success_url = reverse_lazy('home')


class NoteDeleteView(DeleteView):
    model = Note


class NoteDetailView(DetailView):
    model = Note

    def get_context_data(self, **kwargs):
        context = super(NoteDetailView, self).get_context_data(**kwargs)
        context['note'] = self.get_object()
        return context


class NoteListView(ListView):
    model = Note
    context_object_name = 'notes'

    def get_queryset(self):
        return Note.objects.all()

    def get_context_data(self, **kwargs):
        context = super(NoteListView, self).get_context_data(**kwargs)
        context['count'] = Note.objects.all().count()
        return context
