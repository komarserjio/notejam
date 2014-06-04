require 'spec_helper'

describe "Notejam::App::SampleHelper" do
  let(:helpers){ Class.new }
  before { helpers.extend Notejam::App::SampleHelper }
  subject { helpers }

  it "should return nil" do
    expect(subject.foo).to be_nil
  end
end
