class CreateNotes < ActiveRecord::Migration
  def change
    create_table :notes do |t|
      t.string :name
      t.string :text
      t.references :pad, index: true
      t.references :user, index: true

      t.timestamps
    end
  end
end
