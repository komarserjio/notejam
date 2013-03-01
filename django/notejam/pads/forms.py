from django import forms

from pads.models import Pad


class PadForm(forms.ModelForm):
    class Meta:
        model = Pad
        exclude = ('user',)
