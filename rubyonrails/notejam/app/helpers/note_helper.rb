module NoteHelper
  def smart_date(datetime)
    diff = Date.today - datetime.to_date
    days = diff.to_i
    if days == 0
      'Today at ' + datetime.strftime("%H:%M")
    elsif days == 1
      'Yesterday'
    elsif days > 2 && days < 7
      days + " days ago"
    else
      datetime.strftime("%d %b %Y")  
    end
  end
end
