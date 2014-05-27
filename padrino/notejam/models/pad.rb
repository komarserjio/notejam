class Pad
  include DataMapper::Resource
  include DataMapper::Validate

  # Properties
  property :id,               Serial
  property :name,             String

  belongs_to :user

  # Validations
  validates_presence_of      :name
end

