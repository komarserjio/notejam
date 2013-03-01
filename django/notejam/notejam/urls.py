from django.conf.urls import patterns, include, url
from django.views.generic import TemplateView
from users.views import SignupView, SigninView


# Uncomment the next two lines to enable the admin:
# from django.contrib import admin
# admin.autodiscover()

urlpatterns = patterns('',
    # Examples:
    url(r'^$', TemplateView.as_view(template_name="base.html"), name='home'),

    # users' urls
    url(r'^signup/', SignupView.as_view(), name='signup'),
    url(r'^signin/', SigninView.as_view(), name='signin'),
    url(r'^signout/$', 'django.contrib.auth.views.logout',
        {'next_page': '/'}, name='signout')
    # url(r'^notejam/', include('notejam.foo.urls')),

    # Uncomment the admin/doc line below to enable admin documentation:
    # url(r'^admin/doc/', include('django.contrib.admindocs.urls')),

    # Uncomment the next line to enable the admin:
    # url(r'^admin/', include(admin.site.urls)),
)
