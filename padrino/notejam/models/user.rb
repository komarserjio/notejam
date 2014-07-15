class User
  include DataMapper::Resource
  include DataMapper::Validate
  attr_accessor :password, :password_confirmation

  # Properties
  property :id,               Serial
  property :email,            String
  property :crypted_password, String, :length => 70
  property :role,             String

  has n, :pads
  has n, :notes

  # Validations
  validates_presence_of      :email
  validates_format_of        :email,    :with => :email_address
  validates_uniqueness_of    :email
  validates_presence_of      :password,                          :if => :password_required
  validates_presence_of      :password_confirmation,             :if => :password_required
  validates_length_of        :password, :min => 6, :max => 32,   :if => :password_required
  validates_confirmation_of  :password,                          :if => :password_required


  # Callbacks
  before :save, :encrypt_password

  ##
  # This method is for authentication purpose.
  #
  def self.authenticate(email, password)
    account = first(:conditions => ["lower(email) = lower(?)", email]) if email.present?
    account && account.has_password?(password) ? account : nil
  end

  ##
  # This method is used by AuthenticationHelper
  #
  def self.find_by_id(id)
    get(id) rescue nil
  end

  def has_password?(password)
    ::BCrypt::Password.new(crypted_password) == password
  end

  private

    def password_required
      crypted_password.blank? || password.present?
    end

    def encrypt_password
      self.crypted_password = ::BCrypt::Password.create(password) if password.present?
    end
end
