from django.contrib import messages
from django.core.urlresolvers import reverse_lazy
from django.shortcuts import redirect
from django.views.generic.edit import CreateView, UpdateView, DeleteView
from django.views.generic.detail import DetailView
from django.views.generic import ListView


from notes.models import Note, Pad
from notes.forms import NoteForm


class NoteCreateView(CreateView):
    model = Note
    form_class = NoteForm
    template_name_suffix = '_create'
    success_message = 'Note is successfully created'

    def get_initial(self):
        return {'pad': self.request.GET.get('pad', None)}

    def get_form(self, form_class):
        form = super(NoteCreateView, self).get_form(self.get_form_class())
        # limit pad choice
        form.fields['pad'].queryset = Pad.objects.filter(
            user=self.request.user
        )
        return form

    def form_valid(self, form):
        self.object = form.save(commit=False)
        self.object.user = self.request.user
        self.object.save()
        messages.success(self.request, self.success_message)
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
    success_message = 'Note is successfully updated'

    def form_valid(self, form):
        messages.success(self.request, self.success_message)
        return super(NoteUpdateView, self).form_valid(form)

    def get_queryset(self):
        qs = super(NoteUpdateView, self).get_queryset()
        return qs.filter(user=self.request.user)

    def get_form(self, form_class):
        form = super(NoteUpdateView, self).get_form(self.get_form_class())
        # limit pad choice
        form.fields['pad'].queryset = Pad.objects.filter(
            user=self.request.user
        )
        return form

    def get_success_url(self):
        if self.object.pad is not None:
            return reverse_lazy(
                'view_pad_notes', kwargs={'pk': self.object.pad.id}
            )
        else:
            return reverse_lazy('home')


class NoteDeleteView(DeleteView):
    model = Note

    def get_queryset(self):
        qs = super(NoteDeleteView, self).get_queryset()
        return qs.filter(user=self.request.user)

    def get_success_url(self):
        if self.object.pad is not None:
            return reverse_lazy(
                'view_pad_notes', kwargs={'pk': self.object.pad.id}
            )
        else:
            return reverse_lazy('home')


class NoteDetailView(DetailView):
    model = Note

    def get_queryset(self):
        qs = super(NoteDetailView, self).get_queryset()
        return qs.filter(user=self.request.user)


class NoteListView(ListView):
    model = Note
    context_object_name = 'notes'
    order_by = '-updated_at'

    def get_queryset(self):
        qs = super(NoteListView, self).get_queryset()
        order_by = self.request.GET.get('order', self.order_by)
        return qs.filter(user=self.request.user).order_by(order_by)
