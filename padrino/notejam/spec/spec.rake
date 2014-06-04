begin
  require 'rspec/core/rake_task'

  spec_tasks = Dir['spec/*/'].inject([]) do |result, d|
    result << File.basename(d) unless Dir["#{d}*"].empty?
    result
  end

  spec_tasks.each do |folder|
    RSpec::Core::RakeTask.new("spec:#{folder}") do |t|
      t.pattern = "./spec/#{folder}/**/*_spec.rb"
      t.rspec_opts = %w(-fs --color)
    end
  end

  desc "Run complete application spec suite"
  task 'spec' => spec_tasks.map { |f| "spec:#{f}" }
rescue LoadError
  puts "RSpec is not part of this bundle, skip specs."
end
