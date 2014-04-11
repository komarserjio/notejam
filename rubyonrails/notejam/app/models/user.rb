class User < ActiveRecord::Base
  validates :email, :presence => true,
    format: {with: /\A([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})\Z/i},
    uniqueness: true
  validates :password, :presence => true,
                       :confirmation =>true
end
