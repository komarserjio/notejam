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
  end

  def delete
  end

  def view
  end

  private
    def pad_params
      params.require(:pad).permit(:name)
    end
end
