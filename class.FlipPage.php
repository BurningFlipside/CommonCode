<?php
/**
 * A WebPage class specific to this framework
 *
 * This file describes an abstraction for creating a webpage with JQuery, Bootstrap,
 * and other framework specific abilities
 *
 * PHP version 5 and 7
 *
 * @author Patrick Boyd / problem@burningflipside.com
 * @copyright Copyright (c) 2015, Austin Artistic Reconstruction
 * @license http://www.apache.org/licenses/ Apache 2.0 License
 */

/**
 * We use the FlipsideSettings class for a list of sites and settings
 * about CDNs and minified JS/CSS
 */
if(isset($GLOBALS['FLIPSIDE_SETTINGS_LOC']))
{
    require_once($GLOBALS['FLIPSIDE_SETTINGS_LOC'].'/class.FlipsideSettings.php');
}
else
{
    require_once('/var/www/secure_settings/class.FlipsideSettings.php');
}

/**
 * We need the parent class
 */
require_once('class.WebPage.php');

define('JS_JQUERY',       0);
define('JS_JQUERY_UI',    1);
define('JS_BOOTSTRAP',    2);
define('JQUERY_VALIDATE', 3);
define('JQUERY_TOUCH',    4);
define('JS_TINYNAV',      5);
define('JS_BOOTSTRAP_FH', 6);
define('JS_BOOTSTRAP_SW', 7);
define('JS_DATATABLE',    8);
define('JS_CHART',        9);
define('JS_METISMENU',    10);
define('JS_BOOTBOX',         11);
define('JS_DATATABLE_ODATA', 12);
define('JS_CRYPTO_MD5_JS',   13);
define('JS_JCROP',           14);
define('JS_TYPEAHEAD',       15);
define('JS_FLIPSIDE',     20);
define('JS_LOGIN',        21);

define('CSS_JQUERY_UI',    0);
define('CSS_BOOTSTRAP',    1);
define('CSS_BOOTSTRAP_FH', 2);
define('CSS_BOOTSTRAP_SW', 3);
define('CSS_DATATABLE',    4);
define('CSS_JCROP',        5);
define('CSS_FONTAWESOME',  6);

global $js_array;
$js_array = array(
     JS_JQUERY => array(
         'no' => array(
             'no'  => '/js/common/jquery.js',
             'min' => '/js/common/jquery.min.js'
         ),
         'cdn' => array(
             'no'  => '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.js',
             'min' => '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js'
         )
     ),
     JS_JQUERY_UI => array(
         'no' => array(
             'no'  => '/js/common/jquery-ui.js',
             'min' => '/js/common/jquery-ui.min.js'
         ),
         'cdn' => array(
             'no'  => '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js',
             'min' => '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js'
         )
     ),
     JS_BOOTSTRAP => array(
         'no' => array(
             'no'  => '/js/common/bootstrap.js',
             'min' => '/js/common/bootstrap.min.js'
         ),
         'cdn' => array(
             'no'  => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.js',
             'min' => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'
         )
     ),
     JQUERY_VALIDATE => array(
         'no' => array(
             'no'  => '/js/common/jquery.validate.js',
             'min' => '/js/common/jquery.validate.min.js'
         ),
         'cdn' => array(
             'no'  => '//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.js',
             'min' => '//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js'
         )
     ),
     JQUERY_TOUCH => array(
         'no' => array(
             'no'  => '/js/common/jquery.ui.touch-punch.min.js',
             'min' => '/js/common/jquery.ui.touch-punch.min.js'
         ),
         'cdn' => array(
             'no'  => '//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js',
             'min' => '//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js'
         )
     ),
     JS_TINYNAV => array(
         'no' => array(
             'no'  => '/js/common/tinynav.js',
             'min' => '/js/common/tinynav.min.js'
         ),
         'cdn' => array(
             'no'  => '//cdnjs.cloudflare.com/ajax/libs/TinyNav.js/1.2.0/tinynav.js',
             'min' => '//cdnjs.cloudflare.com/ajax/libs/TinyNav.js/1.2.0/tinynav.min.js'
         )
     ),
     JS_BOOTSTRAP_FH => array(
         'no' => array(
             'no'  => '/js/common/bootstrap-formhelpers.js',
             'min' => '/js/common/bootstrap-formhelpers.min.js'
         ),
         'cdn' => array(
             'no'  => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-formhelpers/2.3.0/js/bootstrap-formhelpers.js',
             'min' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-formhelpers/2.3.0/js/bootstrap-formhelpers.min.js'
         )
     ),
     JS_BOOTSTRAP_SW => array(
         'no' => array(
             'no'  => '/js/common/bootstrap-switch.js',
             'min' => '/js/common/bootstrap-switch.min.js'
         ),
         'cdn' => array(
             'no'  => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.js',
             'min' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js'
         )
     ),
     JS_DATATABLE => array(
         'no' => array(
             'no'  => '/js/common/jquery.dataTables.js',
             'min' => '/js/common/jquery.dataTables.min.js'
         ),
         'cdn' => array(
             'no'  => '//cdn.datatables.net/1.10.7/js/jquery.dataTables.js',
             'min' => '//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js'
         )
     ),
     JS_CHART => array(
         'no' => array(
             'no'  => '/js/common/Chart.js',
             'min' => '/js/common/Chart.min.js'
         ),
         'cdn' => array(
             'no'  => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.js',
             'min' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js'
         )
     ),
     JS_METISMENU => array(
         'no' => array(
             'no'  => '/js/common/metisMenu.js',
             'min' => '/js/common/metisMenu.min.js'
         ),
         'cdn' => array(
             'no'  => '//cdnjs.cloudflare.com/ajax/libs/metisMenu/2.0.2/metisMenu.js',
             'min' => '//cdnjs.cloudflare.com/ajax/libs/metisMenu/2.0.2/metisMenu.min.js'
         )
     ),
     JS_BOOTBOX => array(
         'no' => array(
             'no'  => '/js/common/bootbox.js',
             'min' => '/js/common/bootbox.min.js'
         ),
         'cdn' => array(
             'no'  => '//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.3.0/bootbox.js',
             'min' => '//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.3.0/bootbox.min.js'
         )
     ),
     JS_DATATABLE_ODATA => array(
         'no' => array(
             'no'  => '/js/common/jquery.dataTables.odata.js',
             'min' => '/js/common/jquery.dataTables.odata.js',
         ),
         'cdn' => array(
             'no'  => '/js/common/jquery.dataTables.odata.js',
             'min' => '/js/common/jquery.dataTables.odata.js',
         )
     ),
     JS_CRYPTO_MD5_JS => array(
         'no' => array(
             'no'  => '/js/common/md5.js',
             'min' => '/js/common/md5.js',
         ),
         'cdn' => array(
             'no'  => '//cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/md5.js',
             'min' => '//cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/md5.js',
         )
     ),
     JS_JCROP => array(
         'no' => array(
             'no'  => '/js/common/jquery.Jcrop.min.js',
             'min' => '/js/common/jquery.Jcrop.min.js'
         ),
         'cdn' => array(
             'no'  => '//cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/0.9.12/js/jquery.Jcrop.min.js',
             'min' => '//cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/0.9.12/js/jquery.Jcrop.min.js'
         )
     ),
     JS_TYPEAHEAD => array(
         'no' => array(
             'no'  => '/js/common/typeahead.bundle.js',
             'min' => '/js/common/typeahead.bundle.min.js'
         ),
         'cdn' => array(
             'no'  => '//cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.js',
             'min' => '//cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js'
         )
     ),
     JS_FLIPSIDE => array(
         'no' => array(
             'no'  => '/js/common/flipside.js',
             'min' => '/js/common/flipside.min.js'
         ),
         'cdn' => array(
             'no'  => '/js/common/flipside.js',
             'min' => '/js/common/flipside.min.js'
         )
     ),
     JS_LOGIN => array(
         'no' => array(
             'no'  => '/js/common/login.js',
             'min' => '/js/common/login.min.js'
         ),
         'cdn' => array(
             'no'  => '/js/common/login.js',
             'min' => '/js/common/login.min.js'
         )
     )
);

global $css_array;
$css_array = array(
    CSS_JQUERY_UI => array(
        'no' => array(
             'no'  => '/css/common/jquery-ui.css',
             'min' => '/css/common/jquery-ui.min.css'
         ),
         'cdn' => array(
             'no'  => '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css',
             'min' => '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.min.css'
         )
    ),
    CSS_BOOTSTRAP => array(
         'no' => array(
             'no'  => '/css/common/bootstrap.css',
             'min' => '/css/common/bootstrap.min.css'
         ),
         'cdn' => array(
             'no'  => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css',
             'min' => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'
         )
    ),
    CSS_BOOTSTRAP_FH => array(
        'no' => array(
             'no'  => '/css/common/bootstrap-formhelpers.css',
             'min' => '/css/common/bootstrap-formhelpers.min.css'
         ),
         'cdn' => array(
             'no'  => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-formhelpers/2.3.0/css/bootstrap-formhelpers.css',
             'min' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-formhelpers/2.3.0/css/bootstrap-formhelpers.min.css'
         )
    ),
    CSS_BOOTSTRAP_SW => array(
         'no' => array(
             'no'  => '/css/common/bootstrap-switch.css',
             'min' => '/css/common/bootstrap-switch.min.css'
         ),
         'cdn' => array(
             'no'  => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap3/bootstrap-switch.css',
             'min' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap3/bootstrap-switch.min.css'
         )
    ),
    CSS_DATATABLE => array(
        'no' => array(
             'no'  => '/css/common/jquery.dataTables.css',
             'min' => '/css/common/jquery.dataTables.min.css'
         ),
         'cdn' => array(
             'no'  => '//cdn.datatables.net/1.10.7/css/jquery.dataTables.css',
             'min' => '//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css'
         )
    ),
    CSS_JCROP => array(
        'no'  => array(
            'no'  => '/css/common/jquery.Jcrop.min.css',
            'min' => '/css/common/jquery.Jcrop.min.css'
        ),
        'cdn' => array(
            'no'  => '//cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/0.9.12/css/jquery.Jcrop.min.css',
            'min' => '//cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/0.9.12/css/jquery.Jcrop.min.css'
        ) 
    ),
    CSS_FONTAWESOME => array(
        'no'  => array(
            'no'  => '/css/common/font-awesome.min.css',
            'min' => '/css/common/font-awesome.min.css'
        ),
        'cdn' => array(
            'no'  => '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',
            'min' => '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'
        )
    )
);

/**
 * A framework specific webpage abstraction layer
 *
 * This class abstracts out some basic webpage creation with JQuery, Bootstrap, and other helpers
 */
class FlipPage extends WebPage
{
    /** The currently logged in user or null if no user is logged in */
    public $user;
    /** An array of websites to link to globally*/
    public $sites;
    /** An array of links to put in the header */
    public $links;
    /** An array of notifications to draw on the page */
    public $notifications;
    /** Should we draw the header? */
    public $header;
    /** The login page URL */
    public $login_url;
    /** The logout page URL */
    public $logout_url;
    /** Should we use minified JS/CSS? */
    protected $minified = null;
    /** Should we use local JS/CSS or Content Delivery Networks? */
    protected $cdn = null;

    /**
     * Create a webpage with JQuery, Bootstrap, etc
     *
     * @param string $title The webpage title
     * @param boolean $header Draw the header bar?
     */
    function __construct($title, $header=true)
    {
        parent::__construct($title);
        $this->add_js(JS_JQUERY, false);
        $this->add_js(JS_FLIPSIDE, false);
        $this->addBootstrap();
        $this->header = $header;
        if(isset(FlipsideSettings::$sites))
        {
            $this->sites = FlipsideSettings::$sites;
        }
        else
        {
            $this->sites = array();
        }
        $this->links = array();
        $this->notifications = array();
        $this->minified = 'min';
        $this->cdn      = 'cdn';
        if(isset(FlipsideSettings::$global))
        {
            if(isset(FlipsideSettings::$global['use_minified']) && !FlipsideSettings::$global['use_minified'])
            {
                $this->minified = 'no';
            }
            if(isset(FlipsideSettings::$global['use_cdn']) && !FlipsideSettings::$global['use_cdn'])
            {
                $this->cdn = 'no';
            }
            if(isset(FlipsideSettings::$global['login_url']))
            {
                $this->login_url = FlipsideSettings::$global['login_url'];
            }
            if(isset(FlipsideSettings::$global['logout_url']))
            {
                $this->logout_url = FlipsideSettings::$global['logout_url'];
            }
        }
        $this->user = FlipSession::getUser();
        $this->addAllLinks();
    }

    /**
     * Add the links to be used in the header
     *
     * @todo Consider pulling the about menu from the settings file or a DB
     */
    protected function addAllLinks()
    {
        if($this->user === false || $this->user === null)
        {
            if(isset($_SERVER['REQUEST_URI']) && strstr($_SERVER['REQUEST_URI'], 'logout.php') === false)
            {
                $this->addLink('Login', $this->login_url);
            }
        }
        else
        {
            $this->add_links();
            $this->addLink('Logout', $this->logout_url);
        }
        $about_menu = array(
            'Burning Flipside'=>'https://www.burningflipside.com/about/event',
            'AAR, LLC'=>'https://www.burningflipside.com/organization/aar',
            'Privacy Policy'=>'https://www.burningflipside.com/about/privacy'
        );
        $this->addLink('About', 'http://www.burningflipside.com/about', $about_menu);
    }

    /**
     * Setup minified and cdn class varibles from defaults or the settings file
     */
    private function setupVars()
    {
        if($this->minified !== null && $this->cdn !== null) return;
        $this->minified = 'min';
        $this->cdn      = 'cdn';
        if(isset(FlipsideSettings::$global))
        {
            if(isset(FlipsideSettings::$global['use_minified']) && !FlipsideSettings::$global['use_minified'])
            {
                $this->minified = 'no';
            }
            if(isset(FlipsideSettings::$global['use_cdn']) && !FlipsideSettings::$global['use_cdn'])
            {
                $this->cdn = 'no';
            }
        }
    }

    /**
     * Add a JavaScript file from its src URI
     *
     * @param string $src The webpath to the JavaScript file
     * @param boolean $async Can the JavaScript be loaded asynchronously?
     *
     * @deprecated 2.0.0 Please use addJSByURI() instead
     */
    function add_js_from_src($src, $async=true)
    {
        $this->addJSByURI($src, $async);
    }

    /**
     * Add a JavaScript file from its src URI
     *
     * @param string $uri The webpath to the JavaScript file
     * @param boolean $async Can the JavaScript be loaded asynchronously?
     */
    public function addJSByURI($uri, $async=true)
    {
        $attributes = array('src'=>$uri, 'type'=>'text/javascript');
        if($async === true)
        {
            $attributes['async'] = true;
        }
        $js_tag = $this->createOpenTag('script', $attributes);
        $close_tag = $this->createCloseTag('script');
        $this->addHeadTag($js_tag);
        $this->addHeadTag($close_tag);
    }

    /**
     * Add a Cascading Style Sheet file from its src URI
     *
     * @param string $src The webpath to the Cascading Style Sheet file
     * @param boolean $import Can the CSS be loaded asynchronously?
     *
     * @deprecated 2.0.0 Please use addCSSByURI() instead
     */
    function add_css_from_src($src, $import=false)
    {
        $this->addCSSByURI($src, $import);
    }

    /**
     * Add a Cascading Style Sheet file from its src URI
     *
     * @param string $src The webpath to the Cascading Style Sheet file
     * @param boolean $async Can the CSS be loaded asynchronously?
     */
    public function addCSSByURI($uri, $async=false)
    {
        $attributes = array('rel'=>'stylesheet', 'href'=>$uri, 'type'=>'text/css');
        if($async === true && $this->import_support === true)
        {
            $attributes['rel'] = 'import';
        }
        $css_tag = $this->createOpenTag('link', $attributes, true);
        $this->addHeadTag($css_tag);
    }

    /**
     * Add a JavaScript file from a set of files known to the framework
     *
     * @param string $type the ID of the JS file
     * @param boolean $async Can the JS file be loaded asynchronously?
     *
     * @deprecated 2.0.0 Please use addWellKnownJS() instead
     */
    function addJS($type, $async=true)
    {
        $this->addWellKnownJS($type, $async);
    }

    function add_js($type, $async=true)
    {
        $this->addWellKnownJS($type, $async);
    }

    /**
     * Add a JavaScript file from a set of files known to the framework
     *
     * @param string $jsFileID the ID of the JS file
     * @param boolean $async Can the JS file be loaded asynchronously?
     */
    public function addWellKnownJS($jsFileID, $async=true)
    {
        global $js_array;
        $this->setupVars();
        $src = $js_array[$jsFileID][$this->cdn][$this->minified];
        $this->addJSByURI($src, $async);
    }

    /**
     * Add a CSS file from a set of files known to the framework
     *
     * @param string $type the ID of the CSS file
     * @param boolean $import Can the CSS file be loaded asynchronously?
     *
     * @deprecated 2.0.0 Please use addWellKnownCSS() instead
     */
    function add_css($type, $import=false)
    {
        $this->addWellKnownCSS($type, $import);
    }

    /**
     * Add a CSS file from a set of files known to the framework
     *
     * @param string $cssFileID the ID of the CSS file
     * @param boolean $async Can the CSS file be loaded asynchronously?
     */
    public function addWellKnownCSS($cssFileID, $async=true)
    {
        global $css_array;
        $this->setupVars();
        $src = $css_array[$cssFileID][$this->cdn][$this->minified];
        $this->addCSSByURI($src, $async);
    }

    /**
     * Add files needed by the Bootstrap framework
     */
    private function addBootstrap()
    {
        $this->add_js(JS_BOOTSTRAP, false);
        $this->add_css(CSS_BOOTSTRAP);
        $this->add_css(CSS_FONTAWESOME);
    }

    /**
     * Draw the header for the page
     */
    protected function addHeader()
    {
        $sites = '';
        $site_names = array_keys($this->sites);
        foreach($site_names as $site_name)
        {
            $sites.='<li>'.$this->create_link($site_name, $this->sites[$site_name]).'</li>';
        }
        $links = '';
        $link_names = array_keys($this->links);
        foreach($link_names as $link_name)
        {
            if(is_array($this->links[$link_name]))
            {
                $links.='<li class="dropdown">';
                if(isset($this->links[$link_name]['_']))
                {
                    $links.='<a href="'.$this->links[$link_name]['_'].'" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$link_name.' <span class="caret"></span></a>';
                    unset($this->links[$link_name]['_']);
                }
                else
                {
                    $links.='<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$link_name.' <span class="caret"></span></a>';
                }
                $links.='<ul class="dropdown-menu">';
                $sub_names = array_keys($this->links[$link_name]);
                foreach($sub_names as $sub_name)
                {
                    if($this->links[$link_name][$sub_name] === false)
                    {
                        $links.='<li>'.$sub_name.'</li>';
                    }
                    else
                    {
                        $links.='<li>'.$this->create_link($sub_name, $this->links[$link_name][$sub_name]).'</li>';
                    }
                }
                $links.='</ul></li>';
            }
            else
            {
                if($this->links[$link_name] === false)
                {
                    $links.='<li>'.$link_name.'</li>';
                }
                else
                {
                    $links.='<li>'.$this->create_link($link_name, $this->links[$link_name]).'</li>';
                }
            }
        }
        $header ='<nav class="navbar navbar-default navbar-fixed-top">
                      <div class="container-fluid">
                          <!-- Brand and toggle get grouped for better mobile display -->
                          <div class="navbar-header">
                          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                              <span class="sr-only">Toggle navigation</span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                          </button>
                          <a class="navbar-brand" href="#">
                              <picture>
                                  <source srcset="/img/common/logo.svg" style="width: 30px; height:30px"/>
                                  <img alt="Burning Flipside" src="/img/common/logo.png" style="width: 30px; height:30px"/>
                              </picture>
                          </a>
                          </div>
                          <!-- Collect the nav links, forms, and other content for toggling -->
                          <div class="collapse navbar-collapse" id="navbar-collapse">
                              <ul id="site_nav" class="nav navbar-nav">
                              '.$sites.'
                              </ul>
                              <ul class="nav navbar-nav navbar-right">
                              '.$links.'
                              </ul>
                          </div>
                      </div>
                  </nav>';
        $this->body = $header.$this->body;
        $this->body_tags.='style="padding-top: 60px;"';
    }

    /** Notification that is green for success */
    const NOTIFICATION_SUCCESS = 'alert-success';
    /** Notification that is blue for infomrational messages */
    const NOTIFICATION_INFO    = 'alert-info';
    /** Notification that is yellow for warning */
    const NOTIFICATION_WARNING = 'alert-warning';
    /** Notification that is red for error */
    const NOTIFICATION_FAILED  = 'alert-danger';

    /**
     * Add a notification to the page
     *
     * @param string $msg The message to show in the notifcation
     * @param string $sev The severity of the notifcation
     * @param boolean $dismissible Can the user dismiss the notificaton?
     *
     * @deprecated 2.0.0 Use the addNotification function instead 
     */
    function add_notification($msg, $sev=self::NOTIFICATION_INFO, $dismissible=1)
    {
        $notice = array('msg'=>$msg, 'sev'=>$sev, 'dismissible'=>$dismissible);
        array_push($this->notifications, $notice);
    }

    /**
     * Add a notification to the page
     *
     * @param string $message The message to show in the notifcation
     * @param string $sevity The severity of the notifcation
     * @param boolean $dismissible Can the user dismiss the notificaton?
     *
     * @deprecated 2.0.0 Use the addNotification function instead
     */
    public function addNotification($message, $severity=self::NOTIFICATION_INFO, $dismissible=true)
    {
        array_push($this->notificatons, array('msg'=>$message, 'sev'=>$severity, 'dismissible'=>$dismissible)); 
    }

    /**
     * Draw all notifications to the page
     */
    private function renderNotifications()
    {
        for($i = 0; $i < count($this->notifications); $i++)
        {
            $class = 'alert '.$this->notifications[$i]['sev'];
            $button = '';
            if($this->notifications[$i]['dismissible'])
            {
                $class .= ' alert-dismissible';
                $button = '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            }
            $prefix = '';
            switch($this->notifications[$i]['sev'])
            {
                case self::NOTIFICATION_INFO:
                    $prefix = '<strong>Notice:</strong> '; 
                    break;
                case self::NOTIFICATION_WARNING:
                    $prefix = '<strong>Warning!</strong> ';
                    break;
                case self::NOTIFICATION_FAILED:
                    $prefix = '<strong>Warning!</strong> ';
                    break;
            }
            $style = '';
            if($i+1 < count($this->notifications))
            {
                //Not the last notification, remove the end margin
                $style='style="margin: 0px;"';
            }
            $this->body = '
                <div class="'.$class.'" role="alert" '.$style.'>
                    '.$button.$prefix.$this->notifications[$i]['msg'].'
                </div>
            '.$this->body;
        }
    }

    /**
     * Draw the page
     *
     * @param boolean $header Draw the header
     */
    function print_page($header=true)
    {
        if(count($this->notifications) > 0)
        {
            $this->renderNotifications();
        }
        $this->body = '
            <noscript>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <strong>Error!</strong> This site makes extensive use of JavaScript. Please enable JavaScript or this site will not function.
                </div>
            </noscript>
        '.$this->body.'<script>
  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');

  ga(\'create\', \'UA-64901342-1\', \'auto\');
  ga(\'send\', \'pageview\');

</script>';
        if($this->header || $header)
        {
            $this->addHeader();
        }
        parent::printPage();
    }

    /**
     * Draw the page
     *
     * @param boolean $header Draw the header
     * @param boolean $analytics Include analytics on the page
     */
    public function printPage($header=true, $analytics=true)
    {
        if(count($this->notifications) > 0)
        {
            $this->renderNotifications();
        }
        $this->body = '
            <noscript>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <strong>Error!</strong> This site makes extensive use of JavaScript. Please enable JavaScript or this site will not function.
                </div>
            </noscript>
        '.$this->body;
        if($analytics)
        {
            $this->body.='<script>
  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');

  ga(\'create\', \'UA-64901342-1\', \'auto\');
  ga(\'send\', \'pageview\');

</script>';
        }
        if($this->header || $header)
        {
            $this->addHeader();
        }
        parent::printPage();
    }

    /**
     * Add a link to the header
     *
     * @param string $name The name of the link
     * @param false|string $url The URL to link to
     * @param false|array $subment Any submenu items for the dropdown
     *
     * @deprecated 1.0.0 Use addLink instead
     */
    function add_link($name, $url=false, $submenu=false)
    {
        $this->addLink($name, $url, $submenu);
    }

    /**
     * Add a link to the header
     *
     * @param string $name The name of the link
     * @param false|string $url The URL to link to
     * @param false|array $subment Any submenu items for the dropdown
     */
    public function addLink($name, $url=false, $submenu=false)
    {
        if(is_array($submenu))
        {
            $submenu['_'] = $url;
            $this->links[$name] = $submenu;
        }
        else
        {
            $this->links[$name] = $url;
        }
    }

    /**
     * Add the login form to the page
     */
    function add_login_form()
    {
        $auth = \AuthProvider::getInstance();
        $auth_links = $auth->getSupplementaryLinks();
        $auth_links_str = '';
        $count = count($auth_links);
        for($i = 0; $i < $count; $i++)
        {
            $auth_links_str .= $auth_links[$i];
        }
        if($count > 0)
        {
            $auth_links_str = 'Sign in with '.$auth_links_str;
        }
        $this->body .= '<div class="modal fade" role="dialog" id="login-dialog" title="Login" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <h4 class="modal-title">Login</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="login_dialog_form" role="form">
                                            <input class="form-control" type="text" name="username" placeholder="Username or Email" required autofocus/>
                                            <input class="form-control" type="password" name="password" placeholder="Password" required/>
                                            <input type="hidden" name="return" value="'.$this->current_url().'"/>
                                            <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                                        </form>
                                        '.$auth_links_str.'
                                    </div>
                                </div>
                            </div>
                        </div>';
    }

    /**
     * Add additional links
     */
    function add_links()
    {
    }
}
/* vim: set tabstop=4 shiftwidth=4 expandtab: */
?>
