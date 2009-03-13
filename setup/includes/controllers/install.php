<?php/** * XtraUpload * * A turn-key open source web 2.0 PHP file uploading package requiring PHP v5 * * @package		XtraUpload * @author		Matthew Glinski * @copyright	Copyright (c) 2006, XtraFile.com * @license		http://xtrafile.com/docs/license * @link		http://xtrafile.com * @since		Version 2.0 * @filesource */// ------------------------------------------------------------------------/** * XtraUpload Installer * * @package		XtraUpload * @subpackage	Installer * @category	Controllers * @author		Matthew Glinski * @link		http://xtrafile.com/docs/pages/home */// ------------------------------------------------------------------------class Install extends Controller {	private $_db_version = '2.0.0,0.3.0.0';	function Install()	{		parent::Controller();	}		function index()	{		$this->step1();	}		function step1()	{		$this->load->view('header');		$this->load->view('install/step1');		$this->load->view('footer');	}		function step2()	{		$this->load->view('header');		$this->load->view('install/step2');		$this->load->view('footer');	}		function step3()	{		$this->load->view('header');		$this->load->view('install/step3');		$this->load->view('footer');	}		function step4()	{		if($this->input->post('url'))		{			$cookie_prefix = $this->input->post('cookie_prefix');			$encryption_key = $this->input->post('encryption_key');						$seo = $this->input->post('seo');						if(!empty($seo))			{				$seo = '';			}			else			{				$seo = 'index.php';			}						if($cookie_prefix == '')			{				$cookie_prefix = substr( uniqid(md5(rand(1,99999999))) , 0, -16);			}						if($encryption_key == '')			{				$encryption_key = uniqid(md5(rand(1,99999999)));			}						$url = $this->input->post('url');					if (substr($url, -1) != '/')			{					$url .= '/';			}						$this->_writeConfig($cookie_prefix, $encryption_key, $seo, $url);			$this->_writeDatabase();		}				$this->load->view('header');		$this->load->view('install/step4', array('enc' => $encryption_key, 'url' => $url));		$this->load->view('footer');	}		function step5()	{		$this->load->database();		$this->load->dbforge();				if($this->input->post('username'))		{			$this->_loadDatabase();		}				$this->load->view('header');		$this->load->view('install/step5');		$this->load->view('footer');	}		function _writeConfig($cookie_prefix, $encryption_key, $seo, $url)	{				$conf = '<'.'?php  if ( ! defined("BASEPATH")) exit("No direct script access allowed");/*|--------------------------------------------------------------------------| Base Site URL|--------------------------------------------------------------------------|| URL to your CodeIgniter root. Typically this will be your base URL,| WITH a trailing slash:||	http://example.com/|*/$config["base_url"]	= "'.$url.'";/*|--------------------------------------------------------------------------| Index File|--------------------------------------------------------------------------|| Typically this will be your index.php file, unless you"ve renamed it to| something else. If you are using mod_rewrite to remove the page set this| variable so that it is blank.|*/$config["index_page"] = "'.$seo.'";/*|--------------------------------------------------------------------------| URI PROTOCOL|--------------------------------------------------------------------------|| This item determines which server global should be used to retrieve the| URI string.  The default setting of "AUTO" works for most servers.| If your links do not seem to work, try one of the other delicious flavors:|| "AUTO"			Default - auto detects| "PATH_INFO"		Uses the PATH_INFO| "QUERY_STRING"	Uses the QUERY_STRING| "REQUEST_URI"		Uses the REQUEST_URI| "ORIG_PATH_INFO"	Uses the ORIG_PATH_INFO|*/$config["uri_protocol"]	= "AUTO";/*|--------------------------------------------------------------------------| URL suffix|--------------------------------------------------------------------------|| This option allows you to add a suffix to all URLs generated by CodeIgniter.| For more information please see the user guide:|| http://codeigniter.com/user_guide/general/urls.html*/$config["url_suffix"] = "";/*|--------------------------------------------------------------------------| Default Language|--------------------------------------------------------------------------|| This determines which set of language files should be used. Make sure| there is an available translation if you intend to use something other| than english.|*/$config["language"]	= "english";/*|--------------------------------------------------------------------------| Default Character Set|--------------------------------------------------------------------------|| This determines which character set is used by default in various methods| that require a character set to be provided.|*/$config["charset"] = "UTF-8";/*|--------------------------------------------------------------------------| Enable/Disable System Hooks|--------------------------------------------------------------------------|| If you would like to use the "hooks" feature you must enable it by| setting this variable to TRUE (boolean).  See the user guide for details.|*/$config["enable_hooks"] = FALSE;/*|--------------------------------------------------------------------------| Class Extension Prefix|--------------------------------------------------------------------------|| This item allows you to set the filename/classname prefix when extending| native libraries.  For more information please see the user guide:|| http://codeigniter.com/user_guide/general/core_classes.html| http://codeigniter.com/user_guide/general/creating_libraries.html|*/$config["subclass_prefix"] = "MY_";/*|--------------------------------------------------------------------------| Allowed URL Characters|--------------------------------------------------------------------------|| This lets you specify with a regular expression which characters are permitted| within your URLs.  When someone tries to submit a URL with disallowed| characters they will get a warning message.|| As a security measure you are STRONGLY encouraged to restrict URLs to| as few characters as possible.  By default only these are allowed: a-z 0-9~%.:_-|| Leave blank to allow all characters -- but only if you are insane.|| DO NOT CHANGE THIS UNLESS YOU FULLY UNDERSTAND THE REPERCUSSIONS!!|*/$config["permitted_uri_chars"] = "a-z 0-9~%.:_\-";/*|--------------------------------------------------------------------------| Enable Query Strings|--------------------------------------------------------------------------|| By default CodeIgniter uses search-engine friendly segment based URLs:| example.com/who/what/where/|| You can optionally enable standard query string based URLs:| example.com?who=me&what=something&where=here|| Options are: TRUE or FALSE (boolean)|| The other items let you set the query string "words" that will| invoke your controllers and its functions:| example.com/index.php?c=controller&m=function|| Please note that some of the helpers won"t work as expected when| this feature is enabled, since CodeIgniter is designed primarily to| use segment based URLs.|*/$config["enable_query_strings"] = FALSE;$config["directory_trigger"] = "d";	 // experimental not currently in use$config["controller_trigger"] = "c";$config["function_trigger"] = "m";/*|--------------------------------------------------------------------------| Error Logging Threshold|--------------------------------------------------------------------------|| If you have enabled error logging, you can set an error threshold to | determine what gets logged. Threshold options are:| You can enable error logging by setting a threshold over zero. The| threshold determines what gets logged. Threshold options are:||	0 = Disables logging, Error logging TURNED OFF|	1 = Error Messages (including PHP errors)|	2 = Debug Messages|	3 = Informational Messages|	4 = All Messages|| For a live site you"ll usually only enable Errors (1) to be logged otherwise| your log files will fill up very fast.|*/$config["log_threshold"] = 1;/*|--------------------------------------------------------------------------| Error Logging Directory Path|--------------------------------------------------------------------------|| Leave this BLANK unless you would like to set something other than the default| system/logs/ folder.  Use a full server path with trailing slash.|*/$config["log_path"] = "";/*|--------------------------------------------------------------------------| Date Format for Logs|--------------------------------------------------------------------------|| Each item that is logged has an associated date. You can use PHP date| codes to set your own date formatting|*/$config["log_date_format"] = "Y-m-d H:i:s";/*|--------------------------------------------------------------------------| Cache Directory Path|--------------------------------------------------------------------------|| Leave this BLANK unless you would like to set something other than the default| system/cache/ folder.  Use a full server path with trailing slash.|*/$config["cache_path"] = "";/*|--------------------------------------------------------------------------| Encryption Key|--------------------------------------------------------------------------|| If you use the Encryption class or the Sessions class with encryption| enabled you MUST set an encryption key.  See the user guide for info.|*/$config["encryption_key"] = "'.$encryption_key.'";/*|--------------------------------------------------------------------------| Session Variables|--------------------------------------------------------------------------|| "session_cookie_name" = the name you want for the cookie| "encrypt_sess_cookie" = TRUE/FALSE (boolean).  Whether to encrypt the cookie| "session_expiration"  = the number of SECONDS you want the session to last.|  by default sessions last 7200 seconds (two hours).  Set to zero for no expiration.| "time_to_update"		= how many seconds between CI refreshing Session Information|*/$config["sess_cookie_name"]		= "xu2";$config["sess_expiration"]		= 7200;$config["sess_encrypt_cookie"]	= TRUE;$config["sess_use_database"]	= TRUE;$config["sess_table_name"]		= "sessions";$config["sess_match_ip"]		= FALSE;$config["sess_match_useragent"]	= TRUE;$config["sess_time_to_update"] 	= 300;/*|--------------------------------------------------------------------------| Cookie Related Variables|--------------------------------------------------------------------------|| "cookie_prefix" = Set a prefix if you need to avoid collisions| "cookie_domain" = Set to .your-domain.com for site-wide cookies| "cookie_path"   =  Typically will be a forward slash|*/$config["cookie_prefix"]	= "'.$cookie_prefix.'";$config["cookie_domain"]	= "";$config["cookie_path"]		= "/";/*|--------------------------------------------------------------------------| Global XSS Filtering|--------------------------------------------------------------------------|| Determines whether the XSS filter is always active when GET, POST or| COOKIE data is encountered|*/$config["global_xss_filtering"] = FALSE;/*|--------------------------------------------------------------------------| Output Compression|--------------------------------------------------------------------------|| Enables Gzip output compression for faster page loads.  When enabled,| the output class will test whether your server supports Gzip.| Even if it does, however, not all browsers support compression| so enable only if you are reasonably sure your visitors can handle it.|| VERY IMPORTANT:  If you are getting a blank page when compression is enabled it| means you are prematurely outputting something to your browser. It could| even be a line of whitespace at the end of one of your scripts.  For| compression to work, nothing can be sent before the output buffer is called| by the output class.  Do not "echo" any values with compression enabled.|*/$config["compress_output"] = FALSE;/*|--------------------------------------------------------------------------| Master Time Reference|--------------------------------------------------------------------------|| Options are "local" or "gmt".  This pref tells the system whether to use| your server"s local time as the master "now" reference, or convert it to| GMT.  See the "date helper" page of the user guide for information| regarding date handling.|*/$config["time_reference"] = "local";/*|--------------------------------------------------------------------------| Rewrite PHP Short Tags|--------------------------------------------------------------------------|| If your PHP installation does not have short tag support enabled CI| can rewrite the tags on-the-fly, enabling you to utilize that syntax| in your view files.  Options are TRUE or FALSE (boolean)|*/$config["rewrite_short_tags"] = FALSE;';		file_put_contents('../system/application/config/config.php', $conf);	}		function _writeDatabase()	{		$conf = '<'.'?php  if ( ! defined("BASEPATH")) exit("No direct script access allowed");/'.'*| -------------------------------------------------------------------| DATABASE CONNECTIVITY SETTINGS| -------------------------------------------------------------------| This file will contain the settings needed to access your database.|| For complete instructions please consult the "Database Connection"| page of the User Guide.|| -------------------------------------------------------------------| EXPLANATION OF VARIABLES| -------------------------------------------------------------------||	["hostname"] The hostname of your database server.|	["username"] The username used to connect to the database|	["password"] The password used to connect to the database|	["database"] The name of the database you want to connect to|	["dbdriver"] The database type. ie: mysql.  Currently supported:				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8|	["dbprefix"] You can add an optional prefix, which will be added|				 to the table name when using the  Active Record class|	["pconnect"] TRUE/FALSE - Whether to use a persistent connection|	["db_debug"] TRUE/FALSE - Whether database errors should be displayed.|	["cache_on"] TRUE/FALSE - Enables/disables query caching|	["cachedir"] The path to the folder where cache files should be stored|	["char_set"] The character set used in communicating with the database|	["dbcollat"] The character collation used in communicating with the database|| The $active_group variable lets you choose which connection group to| make active.  By default there is only one group (the "default" group).|| The $active_record variables lets you determine whether or not to load| the active record class*'.'/$active_group = "default";$active_record = TRUE;$db["default"]["hostname"] = "'.$this->input->post('sql_server').'";$db["default"]["username"] = "'.$this->input->post('sql_user').'";$db["default"]["password"] = "'.$this->input->post('sql_pass').'";$db["default"]["database"] = "'.$this->input->post('sql_name').'";$db["default"]["dbdriver"] = "'.$this->input->post('sql_engine').'";$db["default"]["dbprefix"] = "'.$this->input->post('sql_prefix').'";$db["default"]["pconnect"] = TRUE;$db["default"]["db_debug"] = TRUE;$db["default"]["cache_on"] = FALSE;$db["default"]["cachedir"] = "";$db["default"]["char_set"] = "utf8";$db["default"]["dbcollat"] = "utf8_general_ci";/'.'* End of file database.php *'.'//'.'* Location: ./system/application/config/database.php *'.'/';		file_put_contents('../system/application/config/database.php', $conf);		file_put_contents('includes/config/database.php', $conf);	}		function _loadDatabase()	{		// Bans Table		$fields = array(			'id' => array(				'type' => 'INT',				'constraint' => 11,				'unsigned' => TRUE,				'auto_increment' => TRUE			),			'md5' => array(				'type' => 'VARCHAR',				'constraint' => '32'			),			'name' => array(				'type' =>'TEXT'			)		);		$this->dbforge->add_field($fields);		$this->dbforge->add_key('id', true);		$this->dbforge->add_key('md5', false);		$this->dbforge->create_table('bans');						// Captcha Table		$fields = array(			'captcha_id' => array(				'type' => 'BIGINT',				'constraint' => 13,				'unsigned' => TRUE,				'auto_increment' => TRUE			),			'captcha_time' => array(				'type' => 'TEXT'			),			'ip_address' => array(				'type' => 'VARCHAR',				'constraint' => 15,				'default' => '0'			),			'word' => array(				'type' => 'VARCHAR',				'constraint' => 20,			)		);		$this->dbforge->add_field($fields);		$this->dbforge->add_key('captcha_id', true);		$this->dbforge->add_key('word', false);		$this->dbforge->create_table('captcha');						// Config Table		$fields = array(			'id' => array(				'type' => 'INT',				'constraint' => 11,				'unsigned' => TRUE,				'auto_increment' => TRUE			),			'name' => array(				'type' => 'VARCHAR',				'constraint' => 64			),			'value' => array(				'type' => 'VARCHAR',				'constraint' => 255			),			'description1' => array(				'type' => 'TEXT'			),			'description2' => array(				'type' => 'TEXT'			),			'group' => array(				'type' => 'VARCHAR',				'constraint' => 32,				'default' => '0'			),			'type' => array(				'type' => 'VARCHAR',				'constraint' => 12			),			'invincible' => array(				'type' => 'TINYINT',				'constraint' => 1,			)		);		$this->dbforge->add_field($fields);		$this->dbforge->add_key('id', true);		$this->dbforge->create_table('config');				// INSERT initnal data		$data = array('id' => NULL,'name' => 'sitename','value' => 'XtraUpload v2','description1' => 'Site Name:','description2' => '(Site Name)','group' => 'Main Settings','type' => 'text','invincible' => 1);		$this->db->insert('config', $data);				$data = array('id' => NULL,'name' => 'slogan','value' => 'Preview','description1' => 'Your Site Slogan','description2' => '','group' => 'Main Settings','type' => 'text','invincible' => 1);		$this->db->insert('config', $data);				$data = array( 'id' =>  NULL, 'name' => 'site_email', 'value' => 'admin@localhost', 'description1' => 'Site EMail', 'description2' => 'Email address used to send emails', 'group' => 'Main Settings', 'type' => 'text', 'invincible' => 1);		$this->db->insert('config', $data);				$data = array( 'id' =>  NULL, 'name' => 'title_separator', 'value' => '-', 'description1' => 'Title Separator', 'description2' => '', 'group' => 'Main Settings', 'type' => 'text', 'invincible' => 1);		$this->db->insert('config', $data);				$data = array('id' =>  NULL, 'name' => 'no_php_images', 'value' => '0', 'description1' => 'Use Static Image Links', 'description2' => 'Yes|-|No<br /><br />Use actual filesystem URLs to serve image thumbnails and direct images. Will save memory and server cycles on large sites.', 'group' => 'Main Settings', 'type' => 'yesno', 'invincible' => 1);		$this->db->insert('config', $data);				$data = array('id' =>  NULL, 'name' => 'allow_version_check', 'value' => '1', 'description1' => 'Allow Version Check', 'description2' => 'Yes|-|No<br /><br />Allow XtraUpload to call home to check for new versions and security updates?', 'group' => 0, 'type' => 'yesno', 'invincible' => 1);		$this->db->insert('config', $data);				$data = array('id' =>  NULL, 'name' => 'home_info_msg', 'value' => NULL, 'description1' => 'Home Page Message', 'description2' => 'Message to display to all your users on the home page. Like an announcement', 'group' => 0, 'type' => 'box', 'invincible' => 1);		$this->db->insert('config', $data);				$data = array('id' =>  NULL, 'name' => 'show_preview', 'value' => '1', 'description1' => 'Show File Preview', 'description2' => 'Yes|-|No<br /><br />Show a preview of some file types on download(mp3, wmv, mov) and an embed code.', 'group' => 0, 'type' => 'yesno', 'invincible' => 1);		$this->db->insert('config', $data);				$data = array('id' =>  NULL, 'name' => 'show_recent_uploads', 'value' => '1', 'description1' => 'Show Recent Uploads', 'description2' => 'Yes|-|No<br /><br />Show a list of the 5 most recently uploaded files?', 'group' => 0, 'type' => 'yesno', 'invincible' => 1);		$this->db->insert('config', $data);				$data = array('id' =>  NULL, 'name' => '_db_version', 'value' => $this->_db_version, 'description1' => '', 'description2' => '', 'group' => 0, 'type' => 'text', 'invincible' => 1);		$this->db->insert('config', $data);				// counters Table		$fields = array(			'id' => array(				'type' => 'INT',				'constraint' => 11,				'unsigned' => TRUE,				'auto_increment' => TRUE			),			'downloads' => array(				'type' => 'VARCHAR',				'constraint' => 8			),			'bandwidth' => array(				'type' => 'VARCHAR',				'constraint' => 8			)		);		$this->dbforge->add_field($fields);		$this->dbforge->add_key('id', true);		$this->dbforge->create_table('counters');						// dlinks Table		$fields = array(			'id' => array(				'type' => 'INT',				'constraint' => 11,				'unsigned' => TRUE,				'auto_increment' => TRUE			),			'fid' => array(				'type' => 'VARCHAR',				'constraint' => 16			),			'time' => array(				'type' => 'VARCHAR',				'constraint' => 22			),			'name' => array(				'type' => 'VARCHAR',				'constraint' => 255			),			'ip' => array(				'type' => 'VARCHAR',				'constraint' => 15			),			'stream' => array(				'type' => 'TINYINT',				'constraint' => 1			)		);		$this->dbforge->add_field($fields);		$this->dbforge->add_key('id', true);		$this->dbforge->create_table('dlinks');						// dlsessions Table		$fields = array(			'id' => array(				'type' => 'INT',				'constraint' => 11,				'unsigned' => TRUE,				'auto_increment' => TRUE			),			'fid' => array(				'type' => 'VARCHAR',				'constraint' => 16			),			'ip' => array(				'type' => 'VARCHAR',				'constraint' => 15			),			'user' => array(				'type' => 'INT',				'constraint' => 11			)		);		$this->dbforge->add_field($fields);		$this->dbforge->add_key('id', true);		$this->dbforge->add_key('fid');		$this->dbforge->add_key('ip');		$this->dbforge->create_table('dlsessions');				// Downloads Table		$fields = array(			'id' => array(				'type' => 'INT',				'constraint' => 11,				'unsigned' => TRUE,				'auto_increment' => TRUE			),			'file_id' => array(				'type' => 'VARCHAR',				'constraint' => 16			),			'user' => array(				'type' => 'VARCHAR',				'constraint' => 20			),			'ip' => array(				'type' => 'VARCHAR',				'constraint' => 15			),			'size' => array(				'type' => 'VARCHAR',				'constraint' => 50			),			'sent' => array(				'type' => 'VARCHAR',				'constraint' => 50			),			'time' => array(				'type' => 'VARCHAR',				'constraint' => 25			)		);				$this->dbforge->add_field($fields);		$this->dbforge->add_key('id', true);		$this->dbforge->add_key('file_id');		$this->dbforge->add_key('user');		$this->dbforge->add_key('ip');		$this->dbforge->create_table('downloads');								// Extend Table		$fields = array(			'id' => array(				'type' => 'INT',				'constraint' => 11,				'unsigned' => TRUE,				'auto_increment' => TRUE			),			'file_name' => array(				'type' => 'VARCHAR',				'constraint' => 100			),			'data' => array(				'type' => 'TEXT'			),			'date' => array(				'type' => 'VARCHAR',				'constraint' => 22			),			'uid' => array(				'type' => 'INT',				'constraint' => 11,				'unsigned' => TRUE			),			'active' => array(				'type' => 'TINYINT',				'constraint' => 1			)		);				$this->dbforge->add_field($fields);		$this->dbforge->add_key('id', true);		$this->dbforge->add_key('file_name');		$this->dbforge->create_table('extend');						// Files Table		$fields = array(			'id' => array(				'type' => 'INT',				'constraint' => 11,				'unsigned' => TRUE,				'auto_increment' => TRUE			),			'filename' => array(				'type' => 'TEXT'			),			'size' => array(				'type' => 'INT',				'constraint' => 11			),			'md5' => array(				'type' => 'VARCHAR',				'constraint' => 32			),			'status' => array(				'type' => 'TINYINT',				'constraint' => 4			),			'type' => array(				'type' => 'VARCHAR',				'constraint' => 10			),			'prefix' => array(				'type' => 'VARCHAR',				'constraint' => 2			),			'is_image' => array(				'type' => 'TINYINT',				'constraint' => 1			),			'thumb' => array(				'type' => 'TEXT'			),			'last_download' => array(				'type' => 'VARCHAR',				'constraint' => 30			),			'server' => array(				'type' => 'VARCHAR',				'constraint' => 255			),			'mirror' => array(				'type' => 'TINYINT',				'constraint' => 1			),			'server' => array(				'type' => 'TEXT'			)		);		$this->dbforge->add_field($fields);		$this->dbforge->add_key('id', true);		$this->dbforge->add_key('prefix');		$this->dbforge->add_key('md5');		$this->dbforge->create_table('files');				// Folder Table		$fields = array(			'id' => array(				'type' => 'INT',				'constraint' => 11,				'unsigned' => TRUE,				'auto_increment' => TRUE			),			'f_id' => array(				'type' => 'VARCHAR',				'constraint' => 15			),			'name' => array(				'type' => 'TEXT'			),			'descr' => array(				'type' => 'TEXT'			),			'pass' => array(				'type' => 'VARCHAR',				'constraint' => 150,			)		);		$this->dbforge->add_field($fields);		$this->dbforge->add_key('id', true);		$this->dbforge->add_key('f_id', false);		$this->dbforge->create_table('folder');								// Folder Table		$fields = array(			'id' => array(				'type' => 'INT',				'constraint' => 11,				'unsigned' => TRUE,				'auto_increment' => TRUE			),			'g_id' => array(				'type' => 'VARCHAR',				'constraint' => 15			),			'name' => array(				'type' => 'TEXT'			),			'descr' => array(				'type' => 'TEXT'			),			'pass' => array(				'type' => 'VARCHAR',				'constraint' => 150,			)		);		$this->dbforge->add_field($fields);		$this->dbforge->add_key('id', true);		$this->dbforge->add_key('g_id', false);		$this->dbforge->create_table('gallery');						// g_items Table		$fields = array(			'id' => array(				'type' => 'INT',				'constraint' => 11,				'unsigned' => TRUE,				'auto_increment' => TRUE			),			'gid' => array(				'type' => 'VARCHAR',				'constraint' => 8			),			'thumb' => array(				'type' => 'TEXT'			),			'direct' => array(				'type' => 'TEXT'			),			'fid' => array(				'type' => 'VARCHAR',				'constraint' => 16			),			'view' => array(				'type' => 'TEXT'			)		);		$this->dbforge->add_field($fields);		$this->dbforge->add_key('id', true);		$this->dbforge->add_key('gid', false);		$this->dbforge->create_table('g_items');								// groups Table		$fields = array(			'id' => array(				'type' => 'INT',				'constraint' => 11,				'unsigned' => TRUE,				'auto_increment' => TRUE			),			'name' => array(				'type' => 'VARCHAR',				'constraint' => 100			),			'status' => array(				'type' => 'TINYINT',				'constraint' => 1			),			'descr' => array(				'type' => 'TEXT'			),			'price' => array(				'type' => 'VARCHAR',				'constraint' => 8			),			'repeat_billing' => array(				'type' => 'VARCHAR',				'constraint' => 5			),			'speed_limit' => array(				'type' => 'VARCHAR',				'constraint' => 10			),			'upload_size_limit' => array(				'type' => 'VARCHAR',				'constraint' => 15			),			'wait_time' => array(				'type' => 'VARCHAR',				'constraint' => 10			),			'files_types' => array(				'type' => 'TEXT'			),			'file_types_allow_deny' => array(				'type' => 'TINYINT',				'constraint' => 1			),			'download_captcha' => array(				'type' => 'TINYINT',				'constraint' => 1			),			'auto_download' => array(				'type' => 'TINYINT',				'constraint' => 1			),			'upload_num_limit' => array(				'type' => 'INT',				'constraint' => 11			),			'storage_limit' => array(				'type' => 'VARCHAR',				'constraint' => 50			),			'can_search' => array(				'type' => 'TINYINT',				'default' => '0',				'constraint' => 1			),			'can_flash_upload' => array(				'type' => 'TINYINT',				'default' => '1',				'constraint' => 1			),			'can_url_upload' => array(				'type' => 'TINYINT',				'default' => '1',				'constraint' => 1			),			'admin' => array(				'type' => 'TINYINT',				'constraint' => 1,				'default' => '0'			)		);		$this->dbforge->add_field($fields);		$this->dbforge->add_key('id', true);		$this->dbforge->create_table('groups');				// Insert Free Group		$data = array(			'id' => '1',			'name' => 'Free',			'status' => 1,			'price' => 0,			'descr' => 'Free Users',			'admin' => 0,			'speed_limit' => '250',			'upload_size_limit' => '100',			'wait_time' => '10',			'files_types' => 'exe|php|sh|bat|cgi|pl',			'file_types_allow_deny' => 0,			'download_captcha' => 1,			'auto_download' => 0,			'can_search' => '0',			'can_flash_upload' => '1',			'can_url_upload' => '1',			'upload_num_limit' => 10		);		$this->db->insert('groups', $data);				// Insert Admin Group		$data = array(			'id' => '2',			'name' => 'Admins',			'status' => 0,			'price' => 0,			'descr' => 'Administrators',			'admin' => 1,			'speed_limit' => '2500',			'upload_size_limit' => '500',			'wait_time' => '1',			'files_types' => '',			'file_types_allow_deny' => 0,			'download_captcha' => 0,			'auto_download' => 1,			'can_search' => 1,			'can_flash_upload' => 1,			'can_url_upload' => 1,			'upload_num_limit' => 500		);		$this->db->insert('groups', $data);				// Insert Admin Group		$data = array(			'id' => '3',			'name' => 'Premium',			'status' => 1,			'price' => 9.99,			'descr' => 'Premium Users',			'admin' => 0,			'repeat_billing' => 'm',			'speed_limit' => '500',			'upload_size_limit' => '250',			'wait_time' => '1',			'files_types' => '',			'file_types_allow_deny' => 0,			'download_captcha' => 0,			'auto_download' => 0,			'can_search' => 0,			'can_flash_upload' => 1,			'can_url_upload' => 1,			'upload_num_limit' => 50		);		$this->db->insert('groups', $data);						// f_items Table		$fields = array(			'id' => array(				'type' => 'INT',				'constraint' => 11,				'unsigned' => TRUE,				'auto_increment' => TRUE			),			'folder_id' => array(				'type' => 'VARCHAR',				'constraint' => 8			),			'file_id' => array(				'type' => 'VARCHAR',				'constraint' => 16			),			'view' => array(				'type' => 'TEXT'			)		);		$this->dbforge->add_field($fields);		$this->dbforge->add_key('id', true);		$this->dbforge->add_key('folder_id', false);		$this->dbforge->create_table('f_items');						// progress Table		$fields = array(		'id' => array(			 'type' => 'INT',			 'constraint' => 11,			 'unsigned' => TRUE,			 'auto_increment' => TRUE		),		'progress' => array(			'type' => 'BIGINT',			'constraint' => 1		),		'curr_time' => array(			 'type' => 'TEXT'		),		'total' => array(			'type' => 'VARCHAR',			'constraint' => 50		),		'start_time' => array(			 'type' => 'TEXT'		),				'fid' => array(			 'type' => 'VARCHAR',			'constraint' => 16		)		);		$this->dbforge->add_field($fields);		$this->dbforge->add_key('id', true);		$this->dbforge->add_key('fid', false);		$this->dbforge->create_table('progress');						// Refrence Table		$fields = array(			'id' => array(				'type' => 'INT',				'constraint' => '11', 				'unsigned' => true, 				'auto_increment' => true			),			'file_id' => array(				'type' => 'VARCHAR',				'constraint' => '16'			),			'descr' => array(				'type' => 'TEXT'			),			'password' => array(				'type' => 'VARCHAR',				'constraint' => '32'			),			'o_filename' => array(				'type' => 'TEXT'			),			'secid' => array(				'type' => 'VARCHAR',				'constraint' => '32'			),			'status' => array(				'type' => 'TINYINT',				'constraint' => '32'			),			'ip' => array(				'type' => 'VARCHAR',				'constraint' => '15'			),			'link_name' => array(				'type' => 'TEXT'			),			'feature' => array(				'type' => 'TINYINT',				'constraint' => '32'			),			'user' => array(				'type' => 'INT',				'constraint' => '11'			),			'type' => array(				'type' => 'VARCHAR',				'constraint' => '10'			),			'time' => array(				'type' => 'VARCHAR',				'constraint' => '20'			),			'pass' => array(				'type' => 'VARCHAR',				'constraint' => '32'			),			'rate_num' => array(				'type' => 'INT',				'constraint' => '32'			),			'rate_total' => array(				'type' => 'INT',				'constraint' => '11'			),			'is_image' => array(				'type' => 'TINYINT',				'constraint' => '32'			),			'link_id' => array(				'type' => 'VARCHAR',				'constraint' => '16'			),			'downloads' => array(				'type' => 'INT',				'constraint' => '11'			),			'featured' => array(				'type' => 'TINYINT',				'constraint' => '32'			),			'remote' => array(				'type' => 'TINYINT',				'constraint' => '1',				'default' => '0'			),			'last_download' => array(				'type' => 'VARCHAR',				'constraint' => '22'			),			'direct_bw' => array(				'type' => 'VARCHAR',				'constraint' => '50'			),			'direct' => array(				'type' => 'TINYINT',				'constraint' => '1',				'default' => '0'			)		);				$this->dbforge->add_field($fields);		$this->dbforge->add_key('id', true);		$this->dbforge->add_key('feature');		$this->dbforge->add_key('file_id');		$this->dbforge->create_table('refrence');						// Servers Table		$fields = array(			'id' => array(				'type' => 'INT',				'constraint' => 11,				'unsigned' => true,				'auto_increment' => true			),			'name' => array(				'type' => 'VARCHAR',				'constraint' => 150			),			'url' => array(				'type' => 'VARCHAR',				'constraint' => 255			),			'status' => array(				'type' => 'INT',				'default' => '0',				'constraint' => 4			)		);		$this->dbforge->add_field($fields);		$this->dbforge->add_key('id', true);		$this->dbforge->create_table('servers');				$data = array('id' => NULL, 'name' => 'main', 'url' => $this->input->post('url'), 'status' => 1);		$this->db->insert('servers', $data);						// Skins Table		$fields = array(			'id' => array(				'type' => 'INT',				'constraint' => 11,				'unsigned' => true,				'auto_increment' => true			),			'name' => array(				'type' => 'TEXT',			),			'active' => array(				'type' => 'TINYINT',				'unsigned' => TRUE,				'default' => '0',				'constraint' => 1			)		);		$this->dbforge->add_field($fields);		$this->dbforge->add_key('id', true);		$this->dbforge->create_table('skin');				$data = array('id' => NULL, 'name' => 'default', 'active' => 1);		$this->db->insert('skin', $data);				$data = array('id' => NULL, 'name' => 'vector_lover', 'active' => 0);		$this->db->insert('skin', $data);				$data = array('id' => NULL, 'name' => 'urban_artist', 'active' => 0);		$this->db->insert('skin', $data);				$data = array('id' => NULL, 'name' => 'tech_junkie', 'active' => 0);		$this->db->insert('skin', $data);				$data = array('id' => NULL, 'name' => 'citrus_island', 'active' => 0);		$this->db->insert('skin', $data);				$data = array('id' => NULL, 'name' => 'style_vantage_orange', 'active' => 0);		$this->db->insert('skin', $data);				$data = array('id' => NULL, 'name' => 'style_vantage_blue', 'active' => 0);		$this->db->insert('skin', $data);				$data = array('id' => NULL, 'name' => 'style_vantage_green', 'active' => 0);		$this->db->insert('skin', $data);						// Sessions Table		$fields = array(			'id' => array(				'type' => 'INT',				'constraint' => 11,				'unsigned' => TRUE,				'auto_increment' => TRUE			),			'username' => array(				'type' => 'VARCHAR',				'constraint' => 16			),			'password' => array(				'type' => 'VARCHAR',				'constraint' => 32			),			'time' => array(				'type' => 'INT',				'constraint' => 11			),			'lastLogin' => array(				'type' => 'INT',				'constraint' => 11			),			'status' => array(				'type' => 'INT',				'constraint' => 11			),			'ip' => array(				'type' => 'VARCHAR',				'constraint' => 15			),			'email' => array(				'type' => 'VARCHAR',				'constraint' => 255			),			'group' => array(				'type' => 'TINYINT',				'constraint' => 4			),			'public' => array(				'type' => 'TINYINT',				'default' => 0,				'constraint' => 1			)		);		$this->dbforge->add_field($fields);		$this->dbforge->add_key('id', true);		$this->dbforge->add_key('email');		$this->dbforge->add_key('group');		$this->dbforge->create_table('users');				// Insert Admin User		$data = array(			'id' => NULL,			'username' => $this->input->post('username'),			'password' => md5($this->input->post('enc').$this->input->post('password')),			'time' => time(),			'lastLogin' => 0,			'status' => 1,			'public' => 0,			'ip' => $this->input->ip_address(),			'email' => $this->input->post('email'),			'group' => 2		);		$this->db->insert('users', $data);	}}