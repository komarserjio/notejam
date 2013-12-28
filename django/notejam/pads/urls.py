from django.conf.urls import patterns, url
from django.contrib.auth.decorators import login_required

from pads.views import (PadCreateView, PadNotesListView, PadUpdateView,
PadDeleteView)

urlpatterns = patterns('',
    url(r'^create/$', login_required(PadCreateView.as_view()),
        name='create_pad'),
    url(r'^(?P<pk>\d+)/$', login_required(PadNotesListView.as_view()),
        name='view_pad_notes'),
    url(r'^(?P<pk>\d+)/edit/$', login_required(PadUpdateView.as_view()),
        name='edit_pad'),
    url(r'^(?P<pk>\d+)/delete/$', login_required(PadDeleteView.as_view()),
        name='delete_pad'),
)
