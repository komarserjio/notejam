from django.db import models


class Pad(models.Model):
    name = models.CharField(max_length=100)
