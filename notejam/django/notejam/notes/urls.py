from django.conf.urls import patterns, url
from django.contrib.auth.decorators import login_required

from notes.views import (NoteCreateView, NoteDeleteView,
NoteDetailView, NoteUpdateView)


# Uncomment the next two lines to enable the admin:
# from django.contrib import admin
# admin.autodiscover()

urlpatterns = patterns('notes.views',
    url(r'^create/$', login_required(NoteCreateView.as_view()),
        name='create_note'),
    url(r'^(?P<pk>\d+)/$', login_required(NoteDetailView.as_view()),
        name='view_note'),
    url(r'^(?P<pk>\d+)/edit/$', login_required(NoteUpdateView.as_view()),
        name='edit_note'),
    url(r'^(?P<pk>\d+)/delete/$', login_required(NoteDeleteView.as_view()),
        name='delete_note'),
)
