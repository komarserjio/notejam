RACK_ENV = 'test' unless defined?(RACK_ENV)
require File.expand_path(File.dirname(__FILE__) + "/../config/boot")

RSpec.configure do |conf|
  conf.include Rack::Test::Methods

  conf.before(:each) do
    DatabaseCleaner.strategy = :transaction
    DatabaseCleaner.clean_with(:truncation)
  end
end

# You can use this method to custom specify a Rack app
# you want rack-test to invoke:
#
#   app Notejam::App
#   app Notejam::App.tap { |a| }
#   app(Notejam::App) do
#     set :foo, :bar
#   end
#
def app(app = nil, &blk)
  @app ||= block_given? ? app.instance_eval(&blk) : app
  @app ||= Padrino.application
end

module Rack
  module Test
    class Session
      alias_method :old_env_for, :env_for
      def rack_session
        @rack_session ||= {}
      end
      def rack_session=(hash)
        @rack_session = hash
      end
      def env_for(path, env)
        old_env_for(path, env).merge({'rack.session' => rack_session})
      end
    end
  end
end
