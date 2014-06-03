# Helper methods defined here can be accessed in any controller or view in the application

module Notejam
  class App
    module UserHelper
      def current_user
        nil
      end

      def pads
        nil
      end
    end

    helpers UserHelper
  end
end
