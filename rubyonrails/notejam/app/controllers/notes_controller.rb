class NotesController < ApplicationController
  before_action :authenticate_user
  def index
    @notes = current_user.notes.order(order_param)
  end

  def edit
    @note = current_user.notes.find(params[:id])
    @current_name = @note.name
    if params[:note]
      # @TODO weird solution
      if params[:note][:pad_id] != '0'
        current_user.pads.find(params[:note][:pad_id])
      end
      if @note.update(note_params)
        redirect_to note_path(id: @note.id), flash: { success: 'Note is successfully updated' }
      end
    end
  end

  def delete
    @note = current_user.notes.find(params[:id])
    if request.post?
      @note.destroy
      redirect_to notes_path, flash: { success: 'Note is successfully deleted' }
    end
  end

  def create
    if params[:note]
      # @TODO weird solution
      if params[:note][:pad_id] != '0'
        current_user.pads.find(params[:note][:pad_id])
      end
      @note = current_user.notes.create(note_params)
      if @note.valid?
        redirect_to notes_path, flash: { success: 'Note is successfully created' }
      end
    end
  end

  def show
    @note = current_user.notes.find(params[:id])
  end

  private

  def note_params
    params.require(:note).permit(:name, :text, :pad_id)
  end
end
