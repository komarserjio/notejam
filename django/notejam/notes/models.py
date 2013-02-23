from django.db import models

from pads.models import Pad


class Note(models.Model):
    pad = models.ForeignKey(Pad)
    name = models.CharField(max_length=100)
    text = models.TextField()
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
