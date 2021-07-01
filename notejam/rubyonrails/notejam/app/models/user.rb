class User < ActiveRecord::Base
  has_many :pads
  has_many :notes
  validates :email, presence: true,
                    format: { with: /\A([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})\Z/i },
                    uniqueness: true
  validates :password, presence: true
  has_secure_password
end
