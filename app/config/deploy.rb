set :application,  "cbag3"
set :domain,       "#{application}.c-base.org"
set :deploy_to,    "/srv/capistranos/cbag3"
set :app_path,     "app"
set :user,         "deployer"
set :ssh_options,  { :forward_agent => true }

set :branch,       "develop"
set :use_composer, true
set :composer_options, "--verbose --prefer-dist"
set :dump_assetic_assets,   true

set :repository,   "git@bitbucket.org:dazs/cbag3.git"
set :scm,          :git

set :shared_files,        ["app/config/parameters.yml"]
#set :shared_children,     [app_path + "/logs", web_path + "/uploads", "vendor"]


# set :model_manager, "doctrine"
# Or: `propel`

role :web,        "baseos.ext.c-base.org"                         # Your HTTP server, Apache/etc
role :app,        "baseos.ext.c-base.org"                         # This may be the same as your `Web` server
# role :db,         domain, :primary => true       # This is where Symfony2 migrations will run

set  :keep_releases,  0

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL

set :use_sudo, false

namespace :symfony do
    namespace :assets do
        task :install do
        end
    end
end

namespace :deploy do
    before :finalize_update do
        #run "rm -rf #{latest_release}/web/uploads"
    end
end