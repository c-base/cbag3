set :application,  "artefact"
#set :domain,       "10.0.1.12"
set :domain,       "#{application}.c-base.org"
set :deploy_to,    "/opt/cbag3"
set :app_path,     "app"
set :user,         "deployer"
set :ssh_options,  { :forward_agent => true }

set :branch,       "develop"
set :use_composer, true
#set :composer_options, "--verbose --prefer-dist"
set :dump_assetic_assets,   true

set :repository,   "git@github.com:c-base/cbag3.git"
set :scm,          :git

set :shared_files,        ["app/config/parameters.yml"]
#set :shared_children,     [app_path + "/logs", web_path + "/uploads", "vendor"]


# set :model_manager, "doctrine"
# Or: `propel`

role :web,        "artefact.c-base.org"                         # Your HTTP server, Apache/etc
role :app,        "artefact.c-base.org"                         # This may be the same as your `Web` server
# role :db,         domain, :primary => true       # This is where Symfony2 migrations will run

set  :keep_releases,  1

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL

set :use_sudo, false


namespace :symfony do
  task :install_mopa_bootstrap do
    run "cd #{latest_release} && php app/console mopa:bootstrap:symlink:less"
  end
  task :asset_dump do
    run "cd #{latest_release} && php app/console assetic:dump"
  end
end

namespace :cbag3 do
  task :backup_mongo do
    run "cd /opt/cbag3/shared/backup && ./backup_mongo.sh"
  end
end

#before "deploy", "cbag3:backup_mongo"
after "deploy", "symfony:install_mopa_bootstrap"
after "deploy", "symfony:asset_dump"
