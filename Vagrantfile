require 'yaml'

domains = {
    api: 'api.book-crossing.local',
    frontend: 'book-crossing.local'
}

config = {
    local: './vagrant/config/local.yml',
    example: './vagrant/config/example.yml'
}

# copy config from example if local config not exists
FileUtils.cp config[:example], config[:local] unless File.exist?(config[:local])
# read config
options = YAML.load_file config[:local]

# check github token
if options['github_token'].nil? || options['github_token'].to_s.length != 40
    puts "You must place REAL GitHub token into configuration:\n/vagrant/config/local.yml"
    exit
end

unless Vagrant.has_plugin?("vagrant-env")
  puts "vagrant-env is not installed!\nrun \"vagrant plugin install vagrant-env\""
  exit
end

unless Vagrant.has_plugin?("vagrant-hostmanager")
  puts "vagrant-hostmanager is not installed!\nrun \"vagrant plugin install vagrant-hostmanager\""
  exit
end

Vagrant.configure(2) do |config|
    config.env.enable

    config.vm.box = "ubuntu/trusty64"
    config.vm.box_check_update = options['box_check_update']

    config.vm.provider "virtualbox" do |vb|
        vb.gui = false
        vb.cpus = options['cpus']
        vb.memory = options['memory']
        vb.name = options['machine_name']
    end

    # network settings
    config.vm.network 'private_network', ip: options['ip']

    # hosts settings (host machine)
    config.vm.provision :hostmanager
    config.hostmanager.enabled = true
    config.hostmanager.manage_host = true
    config.hostmanager.ignore_private_ip = false
    config.hostmanager.include_offline = true
    config.hostmanager.aliases = domains.values

    # machine name (for vagrant console)
    config.vm.define options['machine_name']

    # machine name (for guest machine console)
    config.vm.hostname = options['machine_name']

    config.vm.provision 'shell', path: './vagrant/provision/once-as-root.sh'
    config.vm.provision 'shell', path: './vagrant/provision/once-as-vagrant.sh', args: [options['github_token']], privileged: false
    config.vm.provision 'shell', path: './vagrant/provision/always-as-root.sh', run: 'always'

    # post-install message (vagrant console)
    config.vm.post_up_message = "Api URL: http://#{domains[:api]}\nFrontend URL: http://#{domains[:frontend]}"
end
