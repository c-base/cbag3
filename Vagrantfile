# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant::Config.run do |config|
  config.vm.box = "precise64"
  # config.vm.box_url = "http://dl.dropbox.com/u/1537815/precise64.box"

  config.vm.boot_mode = :gui
  config.vbguest.auto_update = false

  config.vm.network :hostonly, "192.168.23.42", :auto_config => true, :adapter => 2
  config.ssh.forward_agent = true

  # config.vm.forward_port 80, 8080

  # config.vm.share_folder "v-data", "/vagrant_data", "../data"

  config.vm.provision :puppet do |puppet|
    puppet.manifests_path = "app/config"
    puppet.manifest_file  = "manifest.pp"
  end

end
