class PadController < ApplicationController
  before_filter :authenticate_user
  def create
    if params[:pad]
      @pad = current_user.pads.create(pad_params)
      if @pad.valid?
        redirect_to(
          url_for(:all_notes),
          :flash => {:success => "Pad is created"}
        )
      end
      current_user.pads.delete(@pad)
    end
  end

  def edit
    @pad = current_user.pads.find(params[:id])
    @current_name = @pad.name
    if params[:pad]
      if @pad.update(pad_params)
        redirect_to(
          view_pad_notes_path(:id => @pad.id),
          :flash => {:success => "Pad is updated"}
        )
      end
    end
  end

  def delete
    @pad = current_user.pads.find(params[:id])
    if request.post?
        @pad.destroy
        redirect_to(
          all_notes_path,
          :flash => {:success => "Pad is deleted"}
        )
    end
  end

  def view
    @pad = current_user.pads.find(params[:id])
    @notes = @pad.notes.order(order_param)
  end

  private
    def pad_params
      params.require(:pad).permit(:name)
    end
end
