migration 1, :create_users do
  up do
    create_table :users do
      column :id, Integer, :serial => true
      column :email, DataMapper::Property::String, :length => 255
      column :crypted_password, DataMapper::Property::String, :length => 255
      column :role, DataMapper::Property::String, :length => 255
    end
  end

  down do
    drop_table :users
  end
end
