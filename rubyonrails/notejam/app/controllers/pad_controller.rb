class PadController < ApplicationController
  def create
    if params[:pad]
      @pad = current_user.pads.create(pad_params)
      if @pad.valid?
        redirect_to(
          url_for(:all_notes), 
          :flash => {:success => "Pad is created"}
        )
      end
    end
  end

  def edit
    @pad = Pad.find(params[:id])
    @current_name = @pad.name
    if params[:pad]
      if @pad.update(pad_params)
        redirect_to(
          all_notes_path,
          :flash => {:success => "Pad is updated"}
        )
      end
    end
  end

  def delete
    @pad = Pad.find(params[:id])
    if request.post?
        @pad.destroy
        redirect_to(
          all_notes_path,
          :flash => {:success => "Pad was deleted"}
        )
    end
  end

  def view
  end

  private
    def pad_params
      params.require(:pad).permit(:name)
    end
end
