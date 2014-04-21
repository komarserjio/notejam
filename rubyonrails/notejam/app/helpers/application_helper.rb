module ApplicationHelper
  def field_errors(field, model)
    if model && model.errors[field].any?
      errors = "<ul class='errorlist'>"
      model.errors[field].each do |message|
        errors << "<li>#{field} #{message}</li>"
      end
      errors << "</ul>"
      errors.html_safe
    end
  end
end
