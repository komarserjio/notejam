class NoteController < ApplicationController
  before_filter :authenticate_user
  def list
    @notes = current_user.notes.order(order_param)
  end

  def edit
    @note = current_user.notes.find(params[:id])
    @current_name = @note.name
    if params[:note]
      if @note.update(note_params)
        redirect_to(
          all_notes_path,
          :flash => {:success => "Note is updated"}
        )
      end
    end
  end

  def delete
  end

  def create
    if params[:note]
      @note = current_user.notes.create(note_params)
      if @note.valid?
        redirect_to(
          all_notes_path,
          :flash => {:success => "Note is created"}
        )
      end
    end
  end

  def view
    @note = current_user.notes.find(params[:id])
  end

  private
    def note_params
      params.require(:note).permit(:name, :text, :pad_id)
    end
end
