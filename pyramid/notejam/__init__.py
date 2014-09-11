from pyramid.config import Configurator
from pyramid.authentication import SessionAuthenticationPolicy
from pyramid.authorization import ACLAuthorizationPolicy
from pyramid.session import UnencryptedCookieSessionFactoryConfig

from sqlalchemy import engine_from_config

from .models import (
    DBSession,
    Base,
    RootFactory
    )


def main(global_config, **settings):
    """ This function returns a Pyramid WSGI application.
    """
    engine = engine_from_config(settings, 'sqlalchemy.')
    DBSession.configure(bind=engine)

    session_factory = UnencryptedCookieSessionFactoryConfig(
        settings['session.secret']
    )

    authn_policy = SessionAuthenticationPolicy()
    authz_policy = ACLAuthorizationPolicy()

    Base.metadata.bind = engine
    config = Configurator(
        settings=settings,
        root_factory=RootFactory,
        authentication_policy=authn_policy,
        authorization_policy=authz_policy,
        session_factory=session_factory
    )
    config.include('pyramid_chameleon')
    config.add_static_view('static', 'static', cache_max_age=3600)
    # routes
    config.add_route('notes', '/')
    config.add_route('create_note', '/notes/create/')
    config.add_route('view_note', '/notes/{note_id}/')
    config.add_route('update_note', '/notes/{note_id}/edit/')
    config.add_route('delete_note', '/notes/{note_id}/delete/')

    config.add_route('signin', '/signin/')
    config.add_route('signout', '/signout/')
    config.add_route('signup', '/signup/')
    config.add_route('forgot_password', '/forgot-password/')
    config.add_route('settings', '/settings/')

    config.add_route('create_pad', '/pads/create/')
    config.add_route('pad_notes', '/pads/{pad_id}/')
    config.add_route('update_pad', '/pads/{pad_id}/edit/')
    config.add_route('delete_pad', '/pads/{pad_id}/delete/')
    config.scan()
    return config.make_wsgi_app()
