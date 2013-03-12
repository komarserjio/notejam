from django.conf.urls import patterns, include, url
from django.contrib.auth.decorators import login_required

from users.views import SignupView, SigninView
from pads.views import PadCreateView, PadNotesListView, PadUpdateView
from notes.views import (NoteCreateView, NoteListView,
NoteDetailView, NoteUpdateView)


# Uncomment the next two lines to enable the admin:
# from django.contrib import admin
# admin.autodiscover()

urlpatterns = patterns('',
    # Examples:
    #url(r'^$', TemplateView.as_view(template_name="base.html"), name='home'),

    # users' urls
    url(r'^signup/', SignupView.as_view(), name='signup'),
    url(r'^signin/', SigninView.as_view(), name='signin'),
    url(r'^signout/$', 'django.contrib.auth.views.logout',
        {'next_page': '/'}, name='signout'),
    # url(r'^notejam/', include('notejam.foo.urls')),

    # pad views
    url(r'^pads/create/$', login_required(PadCreateView.as_view()),
        name='create_pad'),
    url(r'^pads/(?P<pk>\d+)/$', login_required(PadNotesListView.as_view()),
        name='view_pad_notes'),
    url(r'^pads/(?P<pk>\d+)/edit/$', login_required(PadUpdateView.as_view()),
        name='edit_pad'),
    #url(r'^pads/(?P<pk>\d+)/$', NoteListView.as_view(),
        #name='pad_notes'),

    # note views
    url(r'^notes/create/$', login_required(NoteCreateView.as_view()),
        name='create_note'),
    url(r'^notes/(?P<pk>\d+)/$', login_required(NoteDetailView.as_view()),
        name='view_note'),
    url(r'^notes/(?P<pk>\d+)/edit/$', login_required(NoteUpdateView.as_view()),
        name='edit_note'),
    url(r'^$', login_required(NoteListView.as_view()), name='home'),

    # Uncomment the admin/doc line below to enable admin documentation:
    # url(r'^admin/doc/', include('django.contrib.admindocs.urls')),

    # Uncomment the next line to enable the admin:
    # url(r'^admin/', include(admin.site.urls)),
)
