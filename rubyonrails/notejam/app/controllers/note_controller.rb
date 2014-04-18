class NoteController < ApplicationController
  before_filter :authenticate_user
  def list
  end

  def edit
  end

  def delete
  end

  def create
    if params[:note]
      @note = current_user.notes.create(note_params)
      if @note.valid?
        redirect_to(
          url_for(:all_notes), 
          :flash => {:success => "Note is created"}
        )
      end
    end
  end

  def view
  end

  private
    def note_params
      params.require(:note).permit(:name, :text, :pad_id)
    end
end
