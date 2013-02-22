from django.views.generic.edit import CreateView, UpdateView, DeleteView
from pads.models import Pad


class PadCreate(CreateView):
    model = Pad


class PadUpdate(UpdateView):
    model = Pad


class PadDelete(DeleteView):
    model = Pad
