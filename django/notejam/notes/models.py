from django.db import models

from pads.models import Pad


class Note(models.Model):
    pad = models.ForeignKey(Pad)
    name = models.CharField(max_length=100)
