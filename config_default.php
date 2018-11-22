<?php

	/*
	|===============================================
	| Default settings DON'T CHANGE!
	|===============================================
	|
	| Please don't edit this file, it will get overwritten
	| when a new version gets out. Just add the items you
	| want to change to config.php and change them there.
	|
	*/

	/*
	|===============================================
	| Index page
	|===============================================
	|
	| Default is index.php? which is the most compatible form.
	| You can leave it blank if you want nicer looking urls.
	| You will need a server which honors .htaccess (apache) or
	| figure out how to rewrite urls in the server of your choice.
	|
	*/
	$conf['index_page'] = env('INDEX_PAGE', 'index.php?');

	/*
	|===============================================
	| Uri protocol
	|===============================================
	|
	| $_SERVER variable that contains the correct request path,
	| e.g. 'REQUEST_URI', 'QUERY_STRING', 'PATH_INFO', etc.
	| defaults to AUTO
	|
	*/
	$conf['uri_protocol'] = env('URI_PROTOCOL', 'AUTO');

	/*
	|===============================================
	| HTTP host
	|===============================================
	|
	| The hostname of the webserver, default automatically
	| determined. no trailing slash
	|
	*/
	if(PHP_SAPI != 'cli') {
	    $webhost_default = (empty($_SERVER['HTTPS']) ? 'http' : 'https')
            . '://'.$_SERVER[ 'HTTP_HOST' ];
	    $conf['webhost'] = env('WEBHOST', $webhost_default);
	}

	/*
	|===============================================
	| Subdirectory
	|===============================================
	|
	| Relative to the webroot, with trailing slash.
	| If you're running munkireport from a subdirectory of a website,
	| enter subdir path here. E.g. if munkireport is accessible here:
	| http://mysite/munkireport/ you should set subdirectory to
	| '/munkireport/'
	| If you're using .htaccess to rewrite urls, you should change that too
	| The code below is for automagically deterimining your subdirectory,
	| if it fails, just add $conf['subdirectory'] = '/your_sub_dir/' in
	| config.php
	|
	*/
	$subdirectory_default = substr(
        $_SERVER['PHP_SELF'],
        0,
        strpos($_SERVER['PHP_SELF'], 'index.php')
        );
	$conf['subdirectory'] = env('SUBDIRECTORY', $subdirectory_default);

	/*
	|===============================================
	| Sitename
	|===============================================
	|
	| Will appear in the title bar of your browser and as heading on each webpage
	|
	*/
	$conf['sitename'] = env('SITENAME', 'MunkiReport');

	/*
	|===============================================
	| Hide Non-active Modules
	|===============================================
	|
	| When false, all modules will be shown in the interface like
	|	in the 'Listings' menu.
	*/
	$conf['hide_inactive_modules'] = env('HIDE_INACTIVE_MODULES', true);
	
	/*
	|===============================================
	| Module Search Paths
	|===============================================
	|
	| Filesystem paths to search for modules
	|	replaces the implicit 'custom' module path
	*/
	$conf['module_search_paths'] = env('MODULE_SEARCH_PATHS', []);

	/*
	|===============================================
	| Default Theme
	|===============================================
	|
	| Sets the default theme for new logins/users.
	|
	*/
	$conf['default_theme'] = env('DEFAULT_THEME', 'Default');

	/*
	|===============================================
	| Authentication
	|===============================================
	|
	| Currently four authentication methods are supported:
	|
	|	1) Don't require any authentication: paste the following line in your config.php
	|			$conf['auth']['auth_noauth'] = [];
	|
	|	2) (default) Local accounts: visit /index.php?/auth/generate and paste
	|	   the result in your config.php
	|
	|	3) LDAP:
	|		At least fill in these items:
	|		$conf['auth']['auth_ldap']['server']      = 'ldap.server.local'; // One or more servers separated by commas.
	|		$conf['auth']['auth_ldap']['usertree']    = 'uid=%{user},cn=users,dc=server,dc=local'; // Where to find the user accounts.
	|		$conf['auth']['auth_ldap']['grouptree']   = 'cn=groups,dc=server,dc=local'; // Where to find the groups.
	|		$conf['auth']['auth_ldap']['mr_allowed_users'] = ['user1','user2']; // For user based access, fill in users.
	|		$conf['auth']['auth_ldap']['mr_allowed_groups'] = ['group1','group2']; // For group based access, fill in groups.
	|
	|		Optional items:
	|		$conf['auth']['auth_ldap']['userfilter']  = '(&(uid=%{user})(objectClass=posixAccount))'; // LDAP filter to search for user accounts.
	|		$conf['auth']['auth_ldap']['groupfilter'] = '(&(objectClass=posixGroup)(memberUID=%{uid}))'; // LDAP filter to search for groups.
	|		$conf['auth']['auth_ldap']['port']        = 389; // LDAP port.
	|		$conf['auth']['auth_ldap']['version']     = 3; // Use LDAP version 1, 2 or 3.
	|		$conf['auth']['auth_ldap']['starttls']    = FALSE; // Set to TRUE to use TLS.
	|		$conf['auth']['auth_ldap']['referrals']   = FALSE; // Set to TRUE to follow referrals.
	|		$conf['auth']['auth_ldap']['deref']       = LDAP_DEREF_NEVER; // How to dereference aliases. See http://php.net/ldap_search
	|		$conf['auth']['auth_ldap']['binddn']      = ''; // Optional bind DN
	|		$conf['auth']['auth_ldap']['bindpw']      = ''; // Optional bind password
	|		$conf['auth']['auth_ldap']['userscope']   = 'sub'; // Limit search scope to sub, one or base.
	|		$conf['auth']['auth_ldap']['groupscope']  = 'sub'; // Limit search scope to sub, one or base.
	|		$conf['auth']['auth_ldap']['groupkey']    = 'cn'; // The key that is used to determine group membership
	|		$conf['auth']['auth_ldap']['debug']       = 0; // Set to TRUE to debug LDAP.
	|
	|	4) Active Directory: fill the needed and include the lines in your config.php.
	|		 e.g.
	|		$conf['auth']['auth_AD']['account_suffix'] = '@mydomain.local';
	|		$conf['auth']['auth_AD']['base_dn'] = 'DC=mydomain,DC=local'; //set to NULL to auto-detect
	|		$conf['auth']['auth_AD']['domain_controllers'] = ['dc01.mydomain.local']; //can be an array of servers
	|		$conf['auth']['auth_AD']['admin_username'] = NULL; //if needed to perform the search
	|		$conf['auth']['auth_AD']['admin_password'] = NULL; //if needed to perform the search
	|		$conf['auth']['auth_AD']['mr_allowed_users'] = ['macadmin','bossman'];
	|		$conf['auth']['auth_AD']['mr_allowed_groups'] = ['AD Group 1','AD Group 2']; //case sensitive
	|		$conf['auth']['auth_AD']['mr_recursive_groupsearch'] = false; //set to true to allow recursive searching
	|
	| Authentication methods are checked in the order that they appear above. Not in the order of your
	| config.php!. You can combine methods 2, 3 and 4
	|
	*/

	$auth_methods = env('AUTH_METHODS', []);
  if (count($auth_methods) > 0) {
      foreach ($auth_methods as $auth_method) {
          switch (strtoupper($auth_method)) {
              case 'NOAUTH':
                  $conf['auth']['auth_noauth'] = require APP_ROOT . 'config/auth_noauth.php';
                  break;
              case 'SAML':
                  $conf['auth']['auth_saml'] = require APP_ROOT . 'config/auth_saml.php';
                  break;
              case 'LDAP':
                  $conf['auth']['auth_ldap'] = require APP_ROOT . 'config/auth_ldap.php';
                  break;
              case 'AD':
                  $conf['auth']['auth_AD'] = require APP_ROOT . 'config/auth_ad.php';
                  break;
          }
      }
  }

	/*
	|===============================================
	| reCaptcha Integration
	|===============================================
	|
	| Enable reCaptcha Support on the Authentication Form
	| Request API keys from https://www.google.com/recaptcha
	|
	*/
	$conf['recaptchaloginpublickey'] = env('RECAPTCHA_LOGIN_PUBLIC_KEY', '');
	$conf['recaptchaloginprivatekey'] = env('RECAPTCHA_LOGIN_PRIVATE_KEY', '');

	/*
	|===============================================
	| Role Based Authorization
	|===============================================
	|
	| Authorize actions by listing roles appropriate array.
	| Don't change these unless you know what you're doing, these roles are
	| also used by the Business Units
	|
	*/
	$conf['authorization']['delete_machine'] = env('AUTHORIZATION_DELETE_MACHINE', ['admin', 'manager']);
	$conf['authorization']['global'] = env('AUTHORIZATION_GLOBAL', ['admin']);

	/*
	|===============================================
	| Roles
	|===============================================
	|
	| Add users or groups to the appropriate roles array.
	|
	*/
	$conf['roles']['admin'] = env('ROLES_ADMIN', ['*']);

	/*
	|===============================================
	| Local groups
	|===============================================
	|
	| Create local groups, add users to groups.
	|
	*/
	$conf['groups']['admin_users'] = env('GROUPS_ADMIN_USERS', []);

	/*
	|===============================================
	| Business Units
	|===============================================
	|
	| Set to TRUE to enable Business Units
	| For more information, see docs/business_units.md
	|
	*/
	$conf['enable_business_units'] = env('ENABLE_BUSINESS_UNITS', false);

	/*
	|===============================================
	| Force secure connection when authenticating
	|===============================================
	|
	| Set this value to TRUE to force https when logging in.
	| This is useful for sites that serve MR both via http and https
	|
	*/
	$conf['auth_secure'] = env('AUTH_SECURE', false);

	/*
	|===============================================
	| VNC and SSH links, optional links in the client detail view
	|===============================================
	|
	| Substitutions key:
	|   %s = remote IP
	|   %remote_ip = remote IP (same as above but easier to read in the config)
        |   %u = logged in username
        |   %network_ip_v4 = local network ipv4 address
        |   %network_ip_v6 = local network ipv6 address
	|
	| If you want to have link that opens a screensharing or SSH
	| connection to a client, enable these settings. If you don't
	| want the links, set either to an empty string, eg:
	| $conf['vnc_link'] = "";
	|
	| If you want to authenticate with SSH using the currently logged in user 
	| replace the username in the SSH config with %u: 
	| $conf['ssh_link'] = "ssh://%u@%s";
	*/
	$conf['vnc_link'] = env('VNC_LINK', "vnc://%s:5900");
	$conf['ssh_link'] = env('SSH_LINK',"ssh://adminuser@%s");

	/*
	|===============================================
	| Google Maps API Key
	|===============================================
	|
	| To plot the location, you need to use the google maps API. To use the API
	| you should obtain an API key. Without it, you may get blank maps and js
	| errors.
	|
	| Obtain an API Key at the google site:
	| https://console.developers.google.com/flows/enableapi?apiid=maps_backend&keyType=CLIENT_SIDE&reusekey=true
	| And choose - Create browser API key
	| Add the following line to your config.php file and insert your key.
	| $conf['google_maps_api_key'] = 'YOUR_API_KEY';
	|
	*/
	$conf['google_maps_api_key'] = env('GOOGLE_MAPS_API_KEY', '');

	/*
	|===============================================
	| Curl
	|===============================================
	|
	| Define path to the curl binary and add options
	| this is used by the installer script.
	| Override to use custom path and add or remove options, some environments
	| may need to add "--insecure" if the servercertificate is not to be
	| checked.
	|
	*/
        $default_curl_cmd = [
        "/usr/bin/curl",
        "--fail",
        "--silent",
        "--show-error"];
	$conf['curl_cmd'] = env('CURL_CMD', $default_curl_cmd);


	/*
	|===============================================
	| MunkiWebAdmin2
	|===============================================
	|
	| MunkiWebAdmin2 (MWA2) is a web-based administration tool for Munki
	| that focuses on editing manifests and pkginfo files.
	|
	| To learn more about MWA2 visit: https://github.com/munki/mwa2
	|
	*/
        $conf['mwa2_link'] = env('MWA2_LINK');

	/*
	|===============================================
	| Modules
	|===============================================
	|
	| List of modules that have to be installed on the client
	| See for possible values the names of the directories
	| in app/modules/
	| e.g. $conf['modules'] = ['disk_report', 'inventory'];
	|
	| An empty list installs only the basic reporting modules:
	| Machine and Reportdata
	|
	*/
	$conf['modules'] = env('MODULES', ['munkireport', 'managedinstalls']);

	/*
	|===============================================
	| Unit of temperature °C or °F
	|===============================================
	|
	| Unit of temperature, possible values: F for Fahrenheit, C for Celsius
	|
	|			$conf['temperature_unit'] = 'F';
	|
	| When not configured, the default behaviour applies.
	| By default temperature units are displayed in Celsius °C.
	|
	*/
	$conf['temperature_unit'] = env('TEMPERATURE_UNIT', 'F');

	/*
	|===============================================
	| Client passphrases
	|===============================================
	|
	| List of passphrases that the client can use to authenticate
	|
	| On the client:
	| defaults write /Library/Preferences/MunkiReport Passphrase 'secret1'
	|
	| On the server:
	| $conf['client_passphrases'] = ['secret1', 'secret2'];
	|
	|
	*/
	$conf['client_passphrases'] = env('CLIENT_PASSPHRASES', []);

	/*
	|===============================================
	| Client scriptnames
	|===============================================
	|
	| Override these if you want to provide your own custom scripts that
	| call the munkireport scripts
	*/
	$conf['preflight_script'] = env('PREFLIGHT_SCRIPT', 'preflight');
	$conf['postflight_script'] = env('POSTFLIGHT_SCRIPT', 'postflight');
	$conf['report_broken_client_script'] = env('REPORT_BROKEN_CLIENT_SCRIPT', 'report_broken_client');

	/*
	|===============================================
	| Proxy settings
	|===============================================
	|
	| If you are behind a proxy, MunkiReport may be unable to
	| retrieve warranty and model information from Apple.
	|
	| Note that there is only authenticated proxy support for
	| basic authentication
	|
	| $conf['proxy']['server'] = 'proxy.yoursite.org'; // Required
	| $conf['proxy']['username'] = 'proxyuser'; // Optional
	| $conf['proxy']['password'] = 'proxypassword'; Optional
	| $conf['proxy']['port'] = 8080; // Optional, defaults to 8080
	|
	*/
	//$conf['proxy']['server'] = 'proxy.yoursite.org';

	/*
	|===============================================
	| Guzzle settings
	|===============================================
	|
	| Guzzle is used to make http connections to other servers (e.g. apple.com)
	|
	| Guzzle will choose the appropriate handler based on your php installation
	| You can override this behaviour by specifying the handler here.
	|
	| Valid options are 'curl', 'stream' or 'auto' (default)
	| For CA Bundle options see http://docs.guzzlephp.org/en/stable/request-options.html#verify
	*/
	$conf['guzzle_handler'] = env('GUZZLE_HANDLER', 'auto');

	/*
	|===============================================
	| Request timeout
	|===============================================
	|
	| Timeout for retrieving warranty and model information from Apple.
	|
	| Timeout in seconds
	|
	*/
	$conf['request_timeout'] = env('REQUEST_TIMEOUT', 5);

	/*
	|===============================================
	| Apple Hardware Icon Url
	|===============================================
	|
	| URL to retrieve icon from Apple
	|
	*/
	$conf['apple_hardware_icon_url'] = env('APPLE_HARDWARE_ICON_URL', 'https://km.support.apple.com/kb/securedImage.jsp?configcode=%s&amp;size=240x240');

	/*
	|===============================================
	| Email Settings
	|===============================================
	|
	| These settings are used for email notifications
	| Only smtp is supported at the moment.
	|
	| 	$conf['email']['use_smtp'] = true;
	| 	$conf['email']['from'] = ['noreply@example.com' => 'Munkireport Mailer'];
	|	$conf['email']['smtp_host'] = 'smtp1.example.com;smtp2.example.com';
	|	$conf['email']['smtp_auth'] = true;
	|	$conf['email']['smtp_username'] = 'user@example.com';
	|	$conf['email']['smtp_password'] = 'secret';
	|	$conf['email']['smtp_secure'] = 'tls';
	|	$conf['email']['smtp_port'] = 587;
	|	$conf['email']['locale'] = 'en';
	*/

	/*
	|===============================================
	| Dashboard - IP Ranges
	|===============================================
	|
	| Plot IP ranges by providing an array with labels and
	| a partial IP address. Specify multiple partials in array
	| if you want to group them together.
	| The IP adress part is queried with SQL LIKE
	| Examples:
	| $conf['ip_ranges']['MyOrg'] = '100.99.';
	| $conf['ip_ranges']['AltLocation'] = ['211.88.12.', '211.88.13.'];
	|
	*/
    	$conf['ip_ranges'] = [];

 	/*
	|===============================================
	| Dashboard - VLANS
	|===============================================
	|
	| Plot VLANS by providing an array with labels and
	| a partial IP address of the routers. Specify multiple partials in array
	| if you want to group them together.
	| The router IP adress part is queried with SQL LIKE
	| Examples:
	| $conf['ipv4routers']['Wired'] = '211.88.10.1';
	| $conf['ipv4routers']['WiFi'] = ['211.88.12.1', '211.88.13.1'];
	| $conf['ipv4routers']['Private range'] = ['10.%', '192.168.%',
	| 	'172.16.%',
	| 	'172.17.%',
	| 	'172.18.%',
	| 	'172.19.%',
	| 	'172.2_.%',
	| 	'172.30.%',
	| 	'172.31.%', ];
	| $conf['ipv4routers']['Link-local'] = ['169.254.%'];
	|
	*/

	/*
	|===============================================
	| Dashboard - Layout
	|===============================================
	|
	| Dashboard layout is an array of rows that contain
	| an array of widgets. Omit the _widget postfix
	|
	| Up to three small horizontal widgets will show on one line
	|
	| Up to two medium horizontal widgets will show on one line
	|
	| Responsive horizontal widgets will change depending on window size
	|
	| Be aware of medium / dynamic vertical widgets as it may skew the responsive design
	|
	| This is a list of the current dashboard widgets
	|
	| Small horizontal widgets:
        |       bound_to_ds
        |       client (two items)
        |       disk_report
        |       external_displays_count
        |       firmwarepw
        |       gatekeeper
        |       hardware_model
        |       installed memory
        |       localadmin
        |       munki
        |       power_battery_condition
        |       power_battery_health
        |       sip
        |       smart_status
        |       uptime
        |       wifi_state
        |       	|
	| Small horizontal / medium vertical widgets:
	|	network_location
	|
	| Small horizontal / dynamic vertical widgets:
	|	32_bit_apps
	|	app
	|	duplicated_computernames
	|	filevault
	|	hardware_model
	|	manifests
	|	modified_computernames
	|	munki_versions
	|	new_clients
	|	pending
	|	pending_munki
	|	pending_apple
	|	warranty
	|
	| Medium horizontal widgets:
	|
	| Medium horizontal / dynamic vertical widgets:
	|	hardware_age
	|	hardware_model
	|	memory
	|	os breakdown
	|	printer
	|
	| Responsive horizontal widgets:
	|	network_vlan
	|	registered clients
	*/
	$conf['dashboard_layout'] = [
		['client', 'messages'],
		['new_clients', 'pending_apple', 'pending_munki'],
		['munki', 'disk_report','uptime']
	];

	/*
	|===============================================
	| Apps Version Report
	|===============================================
	|
	| List of applications, by name, that you want to see in the apps
	| version report. If this is not set the report page will appear empty.
	| This is case insensitive but must be an array.
	|
	| Eg:
	| $conf['apps_to_track'] = ['Flash Player', 'Java', 'Firefox', 'Microsoft Excel'];
	|
	*/
	$conf['apps_to_track'] = env('APPS_TO_TRACK', ['Safari']);

	/*
	|===============================================
	| Disk Report Widget Thresholds
	|===============================================
	|
	| Thresholds for disk report widget. This array holds two values:
	| free gigabytes below which the level is set to 'danger'
	| free gigabytes below which the level is set as 'warning'
	| If there are more free bytes, the level is set to 'success'
	|
	*/
	$conf['disk_thresholds'] = [
	    'danger' => env('DISK_REPORT_THRESHOLD_DANGER', 5),
        'warning' => env('DISK_REPORT_THRESHOLD_WARNING', 10)
        ];

	/*
	|===============================================
	| App settings
	|===============================================
	|
	| If the webapp is in a different directory as index.php, adjust
	| the variables below. For enhanced security it is advised to put the
	| webapp in a directory that is not visible to the internet.
	*/
	// Path to system folder, with trailing slash
	$conf['system_path'] = APP_ROOT.'/system/';

	// Path to app folder, with trailing slash
	$conf['application_path'] = APP_ROOT.'/app/';

	// Path to view directory, with trailing slash
	$conf['view_path'] = $conf['application_path'].'views/';

	// Path to controller directory, with trailing slash
	$conf['controller_path'] = $conf['application_path'].'controllers/';

	// Path to modules directory, with trailing slash
	$conf['module_path'] = APP_ROOT . "/vendor/munkireport/";

	// Routes
	$conf['routes'] = [];
	$conf['routes']['module(/.*)?']	= "module/load$1";

	/*
	|===============================================
	| Database configuration
	|===============================================
	|
	| Specify driver, username, password and options
	| Supported engines: sqlite and mysql
	| Mysql example:
	| $conf['connection'] = [
	|     'driver'    => 'mysql',
	|     'host'      => '127.0.0.1',
	|     'port'      => 3306,
	|     'database'  => 'munkireport',
	|     'username'  => 'munkireport',
	|     'password'  => 'munkireport',
	|     'charset' => 'utf8mb4',
	|     'collation' => 'utf8mb4_unicode_ci',
	|     'strict' => true,
	|     'engine' => 'InnoDB',
	|     'options' => [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'],
	| ];
	|
	*/
	$conf['connection'] = [
	    'driver'    => env('CONNECTION_DRIVER', 'sqlite'),
	    'database'  => env('CONNECTION_DATABASE', $conf['application_path'].'db/db.sqlite'),
	];

	if ($conf['connection']['driver'] !== 'sqlite') {
	    $conf['connection']['host'] = env('CONNECTION_HOST', '127.0.0.1');
	    $conf['connection']['port'] = env('CONNECTION_PORT', 3306);
	    $conf['connection']['database'] = env('CONNECTION_DATABASE', 'munkireport');
	    $conf['connection']['username'] = env('CONNECTION_USERNAME', 'munkireport');
	    $conf['connection']['password'] = env('CONNECTION_PASSWORD', 'munkireport');
	    $conf['connection']['charset'] = env('CONNECTION_CHARSET', 'utf8mb4');
	    $conf['connection']['collation'] = env('CONNECTION_COLLATION', 'utf8mb4_unicode_ci');
	    $conf['connection']['strict'] = env('CONNECTION_STRICT', true);
	    $conf['connection']['engine'] = env('CONNECTION_ENGINE', 'InnoDB');
	    // TODO: connection options
        }

	/*
	|===============================================
	| Create table options
	|===============================================
	|
	| For MySQL, define the default table and charset
	|
	*/
	$conf['mysql_create_tbl_opts'] = env('MYSQL_CREATE_TBL_OPTS','ENGINE=InnoDB DEFAULT CHARSET=utf8');

        /*
        |===============================================
        | Whitelist Management Console Access
        |===============================================
        |
        | Whitelisting of IP addresses that can access the management interface 
        |    (anything except for index.php?/report/ which is always allowed)
        |  - You can provide either individual IP addresses (which will have /32 appended automatically)
        |      or you can provide CIDR notation. See https://en.wikipedia.org/wiki/Classless_Inter-Domain_Routing for reference
        |  - You can also provide a custom 403 page for traffic that does not have access to the management interface
        |      Default: The default munkireport-php 403 client error page (no need to add this object if you 
        |                 dont want the custom 403 page
        |
        */

        /*
        | $conf['auth']['network'] = [
        |     'whitelist_ipv4' => [
        |         'xxx.xxx.xxx.xxx',
        |         'xxx.xxx.xxx.xxx',
        |     ],
        |     'redirect_unauthorized' => 'http://fqdn/403.html',
        | ]
        */

	/*
	|===============================================
	| Timezone
	|===============================================
	|
	| See http://www.php.net/manual/en/timezones.php for valid values
	|
	*/
	$conf['timezone'] = @date_default_timezone_get();

	/*
	|===============================================
	| Custom folder
	|===============================================
	|
	| Absolute path to folder with custom items.
	| This folder will be searched for widgets, both in views/widgets
	| and in modules/{modulename}/views
	|
	*/
	//$conf['custom_folder'] = APP_ROOT . '/custom/';

	/*
	|===============================================
	| Custom css and js
	|===============================================
	|
	| If you want to override the default css or default js
	| you can specify a custom file that will be included
	| in the header (css) and footer (js)
	|
	*/
	//$conf['custom_css'] = '/custom.css';
	//$conf['custom_js'] = '/custom.js';

	/*
        |===============================================
        | Custom Help URL
        |===============================================
        |
	| If you want to have a help URL provided, define the 
	| help_url as a blank string ('') to redirect to the 
	| MunkiReport-PHP's GitHub Wiki page (in a new tab).
	|
        | If you want to override the default help url
        | (MunkiReport's GitHub Wiki), you can specify which URL
        | to redirect to (in a new tab).
        |
        */
	// $conf['help_url'] = '';
	// $conf['help_url'] = 'https://path/to/help';

	/*
	|===============================================
	| Debugging
	|===============================================
	|
	| If set to TRUE, will deliver debugging messages in the page. Set to
	| FALSE in a production environment
	*/
	$conf['debug'] = env('DEBUG', false);
