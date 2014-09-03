module ApplicationHelper
  def field_errors(field, model)
    if model && model.errors[field].any?
      [
        "<ul class='errorlist'>",
        model.errors[field].map { |message| "<li>#{field} #{message}</li>" }.join,
        '</ul>'
      ].join.html_safe
    end
  end
end
