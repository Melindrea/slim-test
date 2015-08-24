<?php
define('DEVELOPEREMAIL', 'marie@pineberry.com');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT)) {
    // Application extends the core
    require APPPATH.'classes/Kohana'.EXT;
} else {
    // Load empty core extension
    require SYSPATH.'classes/Kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('Europe/Stockholm');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'sv_SE.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

/**
 * Set the mb_substitute_character to "none"
 *
 * @link http://www.php.net/manual/function.mb-substitute-character.php
 */
mb_substitute_character('none');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

if (isset($_SERVER['SERVER_PROTOCOL'])) {
    // Replace the default protocol.
    HTTP::$protocol = $_SERVER['SERVER_PROTOCOL'];
}

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV'])) {
    Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
} elseif (isset($_SERVER['HTTP_HOST'])) {
    if (strpos($_SERVER['HTTP_HOST'], 'rubus.pineberry.com') !== false) {
        // We are live!
        Kohana::$environment = Kohana::PRODUCTION;

        // Turn off notices and strict errors
        error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
    } elseif (strpos($_SERVER['HTTP_HOST'], 'local') !== false) {
        // We are developing
        Kohana::$environment = Kohana::DEVELOPMENT;
    }
} else {
    // We are developing
        Kohana::$environment = Kohana::DEVELOPMENT;
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
    'base_url'      => '',
    'index_file'    => '',
    'cache_dir'     => APPPATH . 'cache',
    'profile'       => Kohana::$environment !== Kohana::PRODUCTION,
    'errors'        => true,
));

/**
 * Set sessionhandler to database
 */
Session::$default = 'database';

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH . 'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
    'auth'       => MODPATH . 'auth',       // Basic authentication
    'cache'      => MODPATH . 'cache',      // Caching with multiple backends
    // 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
    'database'   => MODPATH . 'database',   // Database access
    // 'image'      => MODPATH.'image',      // Image manipulation
    'minion'     => MODPATH . 'minion',     // CLI Tasks
    'orm'        => MODPATH . 'orm',        // Object Relationship Mapping
    'unittest'   => MODPATH . 'unittest',   // Unit testing
    // 'userguide'  => MODPATH.'userguide',  // User guide and API documentation

    'pagination'           => MODPATH.'pagination',
    'smarty'               => MODPATH.'smarty',
    'gravatar'             => MODPATH.'gravatar',
    'common'               => MODPATH.'common',
    'domaincrawler'        => MODPATH.'domaincrawler',
    'event'                => MODPATH.'event',
    'email'                => MODPATH.'email',
    'adparser'             => MODPATH.'adparser',
    'gapi'                 => MODPATH.'gapi',
    'api'                 => MODPATH.'api',
    'ahrefs'                 => MODPATH.'ahrefs',
    'kostache'                 => MODPATH.'kostache',
    'mysqli'                => MODPATH.'mysqli',
    ));

/**
 * Include composer
 */
require MODPATH.'/../vendor/autoload.php';

/**
 * mb_ucfirst until php provides it
 *
 * We keep it wraped in a if function_exists statement, just in case.
 */
if (! function_exists('mb_ucfirst') && function_exists('mb_substr')) {
    function mb_ucfirst($string)
    {
        $string = mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
        return $string;
    }
}

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
Route::set(
    'api2_projectreports',
    '<directory>/<controller>/<action>/<idHash>',
    array(
        'directory' => 'api2',
        'controller' => 'projectreports',
        'encryptedId' => '.*',
    )
);

Route::set(
    'api2_find',
    '<directory>(/<controller>(/<id>))',
    array(
        'directory' => '(api2|api2)', //add more dirs this way
        'id' => '\d+',
    )
)->defaults(
    array(
        'controller' => 'home',
        'action'     => 'find',
    )
);

Route::set(
    'budget_requests_old',
    'budget_requests/<oldAction>/<id>',
    array(
        'oldAction' => '(view|edit)',
        'id' => '\d+',
    )
)->defaults(
    array(
        'controller' => 'budget_requests',
        'action' => 'old',
    )
);

Route::set('budget_requests_add', 'budget_requests/add/<orgSiteId>', array('id' => '.*'))
    ->defaults(array(
        'controller' => 'budget_requests',
        'action' => 'add',
    ));

Route::set(
    'budget_requests',
    'budget_requests/<id>(/<action>)',
    array(
        'id' => '\d+',
        'action' => '(add|edit|view|quote)',
    )
)->defaults(
    array(
        'controller' => 'budget_requests',
        'action' => 'view',
    )
);

Route::set(
    'budget_requests_delete',
    'budget_requests/<id>/delete-part/<productType>/<partId>',
    array(
        'id' => '\d+',
        'partId' => '\d+',
    )
)->defaults(
    array(
        'controller' => 'budget_requests',
        'action' => 'delete_part'
    )
);

Route::set(
    'budget_request_add_product',
    'budget_requests/<id>/add-product/<productId>',
    array(
        'id' => '\d+',
        'productId' => '\d+',
    )
)->defaults(
    array(
        'controller' => 'budget_requests',
        'action' => 'add_product'
    )
);

Route::set(
    'project_group_view',
    '<controller>/<id>',
    array(
        'id' => '\d+',
    )
)->defaults(
    array(
        'controller' => 'projects',
        'action' => 'group_view'
    )
);

Route::set(
    'project_group_edit',
    '<controller>(/<id>)/edit',
    array(
        'id' => '\d+',
    )
)->defaults(
    array(
        'controller' => 'projects',
        'action' => 'group_edit'
    )
);

Route::set(
    'project_group_add_quote',
    '<controller>(/<id>)/add-quote/<quoteId>',
    array(
        'id' => '\d+',
        'quoteId' => '\d+',
    )
)->defaults(
    array(
        'controller' => 'projects',
        'action' => 'group_add_quote'
    )
);

Route::set(
    'project_group_add_part',
    '<controller>(/<id>)/add-part/<quoteId>',
    array(
        'id' => '\d+',
        'quoteId' => '\d+',
    )
)->defaults(
    array(
        'controller' => 'projects',
        'action' => 'group_add_part'
    )
);

Route::set(
    'project_group_delete_part',
    '<controller>(/<id>)/delete-part/<projectId>',
    array(
        'id' => '\d+',
        'projectId' => '\d+',
    )
)->defaults(
    array(
        'controller' => 'projects',
        'action' => 'group_delete_part'
    )
);

Route::set(
    'project_group_remove_quote',
    '<controller>(/<id>)/remove-quote/<quoteId>',
    array(
        'id' => '\d+',
        'quoteId' => '\d+',
    )
)->defaults(
    array(
        'controller' => 'projects',
        'action' => 'group_remove_quote'
    )
);

Route::set(
    'api2',
    '<directory>(/<controller>(/<action>(/<id>)))',
    array(
        'directory' => '(api2|api2)', //add more dirs this way
        'id' => '\d+',
    )
)->defaults(
    array(
        'controller' => 'home',
        'action'     => 'index',
    )
);

Route::set(
    'subdir',
    '<directory>(/<controller>(/<action>(/<id>)))',
    array(
        'directory' => '(api|api)', //add more dirs this way
    )
)->defaults(
    array(
        'controller' => 'home',
        'action'     => 'index',
    )
);

Route::set('default', '(<controller>(/<action>(/<id>(/<id2>))))')
    ->defaults(array(
        'controller'    => 'rubus',
        'action'    => 'index',
    ));

Route::set('assets', 'assets/<action>/<file>', array('file' => '.*'))
    ->defaults(array(
        'controller'    => 'assets',
        'action'    => 'css',
    ));
