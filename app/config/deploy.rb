ssh_options[:keys] = [File.join(ENV["HOME"], ".ssh", "oorhoose", "oorhoose-deploy")]
default_run_options[:pty] = true

set :domain,          "192.168.0.11"
set :branch,          "master"

set :deploy_to,       "/var/www/scanmanager"

set :application,     "scanmanager"

set :app_path,        "app"

set :user,            "dave"
set :group,           "www-data"

set :repository,      "git@github.com:ccapndave/scanmanager.git"
set :scm,             :git
set :deploy_via,      :remote_cache

set :shared_files,    [ "app/config/parameters_local.yml" ]
set :shared_children, [ app_path + "/logs", "vendor", web_path + "/scans" ]
set :use_composer,    true
set :normalize_asset_timestamps, true
set :symfony_debug,   true
set :vendors_mode,    "reinstall"
set :permission_method,   :acl
set :use_set_permissions, true

set :model_manager,   "doctrine"

set  :use_sudo,       false
set  :keep_releases,  3

role :web,            domain                         # Your HTTP server, Apache/etc
role :app,            domain, :primary => true       # This may be the same as your `Web` server

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL