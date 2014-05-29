# Helper methods defined here can be accessed in any controller or view in the application

module Notejam
  class App
    def get_or_404(model, id)
      halt 404, "Page not found"
    end
  end
end
