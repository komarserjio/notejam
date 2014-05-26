# Helper methods defined here can be accessed in any controller or view in the application

module Notejam
  class App
    module UserHelper
      def current_user
        nil
      end

      def url_for (arg1, arg2 = nil)
        nil
      end

      def pads
        nil
      end

    def field_errors(field, model)
      if model && model.errors[field].any?
        errors = "<ul class='errorlist'>"
        model.errors[field].each do |message|
          errors << "<li>#{message}</li>"
        end
        errors << "</ul>"
        errors.html_safe
      end
    end

    end

    helpers UserHelper
  end
end
