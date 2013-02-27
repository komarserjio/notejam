from django.conf.urls import patterns, include, url
from django.views.generic import TemplateView
from users.views import SignupView


# Uncomment the next two lines to enable the admin:
# from django.contrib import admin
# admin.autodiscover()

urlpatterns = patterns('',
    # Examples:
    url(r'^$', TemplateView.as_view(template_name="base.html"), name='home'),
    url(r'^signup/', SignupView.as_view(), name='signup'),
    # url(r'^notejam/', include('notejam.foo.urls')),

    # Uncomment the admin/doc line below to enable admin documentation:
    # url(r'^admin/doc/', include('django.contrib.admindocs.urls')),

    # Uncomment the next line to enable the admin:
    # url(r'^admin/', include(admin.site.urls)),
)
