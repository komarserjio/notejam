from django.contrib import messages
from django.core.urlresolvers import reverse_lazy
from django.shortcuts import redirect
from django.shortcuts import get_object_or_404
from django.views.generic.edit import CreateView, UpdateView, DeleteView
from django.views.generic import ListView


from pads.models import Pad
from notes.models import Note
from pads.forms import PadForm


class PadCreateView(CreateView):
    model = Pad
    form_class = PadForm
    template_name_suffix = '_create'
    success_url = reverse_lazy('home')
    success_message = 'Pad is successfully created'

    def form_valid(self, form):
        self.object = form.save(commit=False)
        self.object.user = self.request.user
        self.object.save()
        messages.success(self.request, self.success_message)
        return redirect(self.get_success_url())

    def get_success_url(self):
        return reverse_lazy("view_pad_notes", kwargs={'pk': self.object.pk})


class PadUpdateView(UpdateView):
    model = Pad
    form_class = PadForm
    template_name_suffix = '_edit'
    success_url = reverse_lazy('home')
    success_message = 'Pad is successfully updated'

    def form_valid(self, form):
        messages.success(self.request, self.success_message)
        return super(PadUpdateView, self).form_valid(form)

    def get_queryset(self):
        qs = super(PadUpdateView, self).get_queryset()
        return qs.filter(user=self.request.user)

    def get_success_url(self):
        return reverse_lazy("view_pad_notes", kwargs={'pk': self.object.pk})


# Note list mixed with pad details data
class PadNotesListView(ListView):
    model = Note
    context_object_name = 'notes'
    order_by = '-updated_at'
    template_name = 'pads/pad_note_list.html'

    def get_queryset(self):
        order_by = self.request.GET.get('order', self.order_by)
        return self.get_pad().note_set.all().order_by(order_by)

    def get_pad(self):
        return get_object_or_404(
            Pad, pk=int(self.kwargs.get('pk')), user=self.request.user
        )

    def get_context_data(self, **kwargs):
        context = super(PadNotesListView, self).get_context_data(**kwargs)
        context['pad'] = self.get_pad()
        return context


class PadDeleteView(DeleteView):
    model = Pad
    success_url = reverse_lazy("home")

    def get_queryset(self):
        qs = super(PadDeleteView, self).get_queryset()
        return qs.filter(user=self.request.user)
