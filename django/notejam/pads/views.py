from django.core.urlresolvers import reverse_lazy
from django.views.generic.edit import CreateView, UpdateView, DeleteView
from pads.models import Pad
from pads.forms import PadForm


class PadCreateView(CreateView):
    model = Pad
    form_class = PadForm
    success_url = reverse_lazy('home')

    def form_valid(self, form):
        pad = form.save(commit=False)
        pad.user = self.request.user
        pad.save()


class PadUpdateView(UpdateView):
    model = Pad


class PadDeleteView(DeleteView):
    model = Pad
