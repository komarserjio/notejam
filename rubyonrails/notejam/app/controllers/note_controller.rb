class NoteController < ApplicationController
  before_filter :authenticate_user
  def list
    @notes = current_user.notes.order(order_param)
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
          all_notes_path,
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

    def order_param
      if params[:order]
        {"name" => "name ASC",
         "-name" => "name DESC",
         "updated_at" => "updated_at ASC",
         "-updated_at" => "updated_at DESC"}[params[:order]]
      end
    end
end
