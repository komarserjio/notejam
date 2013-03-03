from django.core.urlresolvers import reverse_lazy
from django.shortcuts import redirect
from django.views.generic.edit import CreateView, UpdateView, DeleteView

from pads.models import Pad
from pads.forms import PadForm


class PadCreateView(CreateView):
    model = Pad
    form_class = PadForm
    success_url = reverse_lazy('home')

    def form_valid(self, form):
        self.object = form.save(commit=False)
        self.object.user = self.request.user
        self.object.save()
        return redirect(self.get_success_url())


class PadUpdateView(UpdateView):
    model = Pad
    form_class = PadForm
    success_url = reverse_lazy('home')


class PadDeleteView(DeleteView):
    model = Pad
