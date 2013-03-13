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
    template_name_suffix = '_create'

    def get_initial(self):
        return {'pad': self.request.GET.get('pad', None)}

    def form_valid(self, form):
        self.object = form.save(commit=False)
        self.object.user = self.request.user
        self.object.save()
        return redirect(self.get_success_url())

    def get_success_url(self):
        if self.object.pad is not None:
            return reverse_lazy(
                'view_pad_notes', kwargs={'pk': self.object.pad.id}
            )
        else:
            return reverse_lazy('home')


class NoteUpdateView(UpdateView):
    model = Note
    form_class = NoteForm
    success_url = reverse_lazy('home')
    template_name_suffix = '_edit'

    def get_success_url(self):
        if self.object.pad is not None:
            return reverse_lazy(
                'view_pad_notes', kwargs={'pk': self.object.pad.id}
            )
        else:
            return reverse_lazy('home')


class NoteDeleteView(DeleteView):
    model = Note

    def get_success_url(self):
        if self.object.pad is not None:
            return reverse_lazy(
                'view_pad_notes', kwargs={'pk': self.object.pad.id}
            )
        else:
            return reverse_lazy('home')


class NoteDetailView(DetailView):
    model = Note


class NoteListView(ListView):
    model = Note
    context_object_name = 'notes'
    order_by = '-updated_at'

    def get_queryset(self):
        order_by = self.request.GET.get('order', self.order_by)
        return Note.objects.filter().order_by(order_by)
