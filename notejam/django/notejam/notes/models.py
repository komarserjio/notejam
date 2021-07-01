from django.contrib.auth.models import User
from django.db import models

from pads.models import Pad


class Note(models.Model):
    pad = models.ForeignKey(Pad, null=True, blank=True)
    user = models.ForeignKey(User)
    name = models.CharField(max_length=100)
    text = models.TextField()
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
