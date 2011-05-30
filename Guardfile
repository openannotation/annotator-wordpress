# A sample Guardfile
# More info at https://github.com/guard/guard#readme
#
# Runs the phpunit test suite whenever a .php file in lib/ or test changes
#

require 'guard/guard'

module ::Guard
  class PhpUnit < ::Guard::Guard
    def start
      Dir.chdir(File.dirname(File.expand_path(__FILE__)))
    end
    def run_on_change(paths)
      message = `phpunit`
      ::Guard::Notifier.notify(message, :title => 'PHPUnit')
    end
    def run_all
      true
    end
  end
end



guard 'phpunit', :cli => '--testdox ' do
  watch %r{^lib/(.+)\.php}
  watch %r{^test/(.+)\.php}
  watch %r{^phpunit.xml$}
end
