<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class MY_Controller extends CI_Controller {

	
	protected $pages;
	protected $js_default;
	protected $css_default;
	
	protected $char_mode;
	
	protected $role_ad;
	protected $role_rm;
	protected $role_bm;
	protected $role_am;
	protected $role_rd;
	protected $role_hq;
	protected $role_spv;
	protected $role_admin;
	
	// Old Table:Implemented
	protected $table_profile;
	protected $table_verification;
	protected $table_branch;
	protected $table_applicationstatus;
	protected $table_callout;
	protected $table_docrefund;
	protected $table_masterchannel;
	protected $table_masterdoc;
	protected $table_masterdowntown;
	protected $table_masteremployee;
	protected $table_ncb;
	protected $table_product;
	protected $table_rmprocesslog;
	protected $table_exportlog;
	protected $table_provicne;
		
	// New Table
	protected $table_depmap;
	protected $table_duecustom;
	protected $table_clndrevent;
	protected $table_clndrplant;
	protected $table_notification;
	protected $table_region;
	protected $table_ledingbranchs;
	protected $table_revisitreason;
	protected $table_lackdoc;
	protected $table_masterrevisit;
	protected $table_reactivate;
	protected $table_lacklist;	
	protected $table_appointment;
	protected $table_lendingbranchs;
	
	
	public function __construct() {
		parent::__construct();
		
		// META Header
		$this->data['title']		        = $this->config->item('site_title');
		$this->data['desc']				    = $this->config->item('site_description');
		$this->data['author']			    = $this->config->item('site_author');
		$this->data['keyword']			    = $this->config->item('site_keyword');
		$this->data['footer']               = $this->config->item('site_footer');
		$this->data['viewport']             = $this->config->item('site_viewport');
		
		// Role Permission
		$this->role_ad 						= $this->config->item('ROLE_ADMIN');
		$this->role_rm 						= $this->config->item('ROLE_RM');
		$this->role_bm 						= $this->config->item('ROLE_BM');
		$this->role_am 						= $this->config->item('ROLE_AM');
		$this->role_rd 						= $this->config->item('ROLE_RD');
		$this->role_hq 						= $this->config->item('ROLE_HQ');
		$this->role_spv 					= $this->config->item('ROLE_SPV');
		$this->role_admin 					= $this->config->item('ROLE_ADMINSYS');
		$this->role_ads 					= $this->config->item('ROLE_ADMINSYS');
		
		/** LOAD: TABLE NAME */
		// Old Table
		$this->table_profile                = $this->config->item('table_profile');
		$this->table_verification           = $this->config->item('table_verification');
		$this->table_applicationstatus      = $this->config->item('table_applicationstatus');
		$this->table_branch                 = $this->config->item('table_branch');
		$this->table_callout                = $this->config->item('table_callout');
		$this->table_docrefund              = $this->config->item('table_docrefund');
		$this->table_masterchannel          = $this->config->item('table_masterchannel');
		$this->table_masterdoc              = $this->config->item('table_masterdoc');
		$this->table_masterdowntown         = $this->config->item('table_masterdowntown');
		$this->table_masteremployee         = $this->config->item('table_employee');
		$this->table_ncb                    = $this->config->item('table_ncb');
		$this->table_rmprocesslog           = $this->config->item('table_rmprocesslog');
		$this->table_exportlog              = $this->config->item('table_exportlog');
		$this->table_province				= $this->config->item('table_province');
		$this->table_product				= $this->config->item('table_product');
		
		// New Table
		$this->table_depmap					= $this->config->item('table_depmap');
		$this->table_duecustom				= $this->config->item('table_duecustom');
		$this->table_clndrevent			 	= $this->config->item('table_clndrevent');
		$this->table_clndrplant			 	= $this->config->item('table_clndrplant');
		$this->table_notification			= $this->config->item('table_notification');
		$this->table_region					= $this->config->item('table_region');
		$this->table_ledingbranchs			= $this->config->item('table_lendingbranchs');
		$this->table_revisitreason			= $this->config->item('table_revisitreason');
		$this->table_lackdoc				= $this->config->item('table_lackdoc');
		$this->table_masterrevisit			= $this->config->item('table_masterrevisit');
		$this->table_reactivate				= $this->config->item('table_reactivate');
		$this->table_masterlack				= $this->config->item('table_lackdoc');
		$this->table_lacklist				= $this->config->item('table_lacklist');
		$this->table_appointment		    = $this->config->item('table_appointment');
		$this->table_lendingemp				= "LendingEmp";
		
		$this->char_mode					= $this->config->item('char_mode');
		
		$this->pages                        = "main"; // Page Defaults

	}
	
	
	/**
	 * This method will be render template or theme. which it's default root variable for we are used in web application.
	 * @param $view (Page name or data collection for convert to json and view must have key is to_json)
	 * @param $render (Type = AJAX, JSON, REDIRECT)
	 * @throws Exception throw exception
	 */
	
	public function _renders($view,  $render) {
	
		switch(strtoupper($render)) {
			case "AJAX":
	
				$this->load->view($view);
	
				break;
			case "JSON":
	
				if(isset($view['A2J'])) {
					echo json_encode($view);
				} else {
					throw new Exception('Key incorrect, variable must have name properties A2J for convert json in customized core.');
					
				}
	
				break;
			case "":
			case "customiz":
			default:

				$this->css_default           = array('metro/metro-bootstrap.min', 'metro/metro-bootstrap-responsive.min', 'metro/iconFont.min', 'custom/tooltip_custom', 'themify-icons', 'awesome/css/font-awesome.min', 'flaticonv2/flaticonv2', 'jquery-ui/jquery-ui.min');
				$this->js_default            = array('vendor/jquery.min', 'vendor/jquery-ui.min', 'vendor/jquery.widget.min', 'vendor/jquery.mousewheel', 'metro/metro.min', 'plugins', 'build/load_profile');
				//'angular/angular.min', 'angular/angular-animate.min', 'angular/angular-cookies.min', 'angular/angular-sanitize.min', 'angular/angular-touch.min', 'angular/ui-bootstrap-tpls-1.1.2.min', 'angular/chat-client/chat-client'
				
				if(!empty($option)) {
					foreach($option as $index => $values) {
						$this->data[$index]   = $values;
					}
				}
	
				$js  = isset($this->data['javascript']) ? $this->data['javascript']:$this->data['javascript'] = array();
				$css = isset($this->data['stylesheet']) ? $this->data['stylesheet']:$this->data['stylesheet'] = array();
				$opt = isset($this->data['option']) ? $this->data['option']:$this->data['option'] = array();
	
				$this->data['js']           = array_merge($this->js_default, $js);
				$this->data['css']          = array_merge($this->css_default, $css);
				
				$component['css_st']	    = $this->load->view('frontend/implement/cssoption', $this->data, true);
				$component['nav']	        = $this->load->view('frontend/implement/nav', $this->data, true);
				$component['content']	    = $this->pageOnLoads('frontend/content/pages/'.$this->pages);
				$component['js_lib']        = $this->load->view("frontend/implement/jsoption", $this->data, true);
				$component['op_lib']        = $this->load->view("frontend/implement/option_script", $this->data, true);
				$component['footer']	    = $this->load->view('frontend/implement/footer', $this->data, true);			
	
	
				$this->load->view($view, $component);
	
				break;
	
		}
	
	}
	
	
	/**
	 * GET js & css increment.
	 * @param array $option
	 * @return bool
	 * @throws Exception
	 */
	public function renderOps($option = array()) {
	
		if(!empty($option)) {
			foreach($option as $index => $values) {
				$this->data[$index]   = $values;
			}
		} else {
			throw new Exception("Error, Not found values.");
		}
	
		return true;
	}
	
	/**
	 * This method is function load page.
	 * @param $pages page name
	 */
	public function pageOnLoads($pages) {
		return $this->load->view($pages, $this->data, true);
	}
	
	
	
}