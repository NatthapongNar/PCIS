<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Collection_control extends MY_Controller {
	
	public $pages_default;
	public $pages_customiz;
	
	protected $sessid;
	protected $emp_id;
	protected $email;
	protected $name, $engname, $bm;
	protected $position;
	protected $branch;
	protected $branch_code;
	protected $region_id;
	protected $region;
	protected $region_th;
	protected $authorized ;
	protected $is_logged_in;
	
	public function __construct() {
		parent::__construct();
	
		$this->sessid       = $this->session->userdata("session_id");
		$this->uhash        = substr($this->session->userdata("uhash"), 6);
	
		$this->emp_id        = $this->session->userdata("empcode");
		$this->name          = $this->session->userdata("thname");
		$this->engname       = $this->session->userdata("engname");
		$this->email         = $this->session->userdata("email");
		$this->branch_code   = $this->session->userdata("branchcode");
		$this->branch        = $this->session->userdata("branch");
		$this->bm			 = $this->session->userdata("bmname");
		$this->position      = $this->session->userdata("position");
		$this->region_id	 = $this->session->userdata("region_id");
		$this->region		 = $this->session->userdata("region");
		$this->region_th	 = $this->session->userdata("region_th");
		$this->authorized    = $this->session->userdata("privileges");
		$this->is_logged_in  = $this->session->userdata("is_logged_in");

		// Object: Session Enrolled.
		$this->data['session_data'] = array(
				"sess_id"    => trim($this->sessid),
				"emp_id"     => trim($this->emp_id),
				"thname"     => $this->name,
				"engname"    => $this->engname,
				"email"      => $this->email,
				"position"   => trim($this->position),
				"branch"     => trim($this->branch),
				"branchcode" => trim($this->branch_code),
				'bmname'	 => $this->bm,
				"region_id"	 => trim($this->region_id),
				"region" 	 => trim($this->region),
				"region_th"	 => $this->region_th,
				"auth"       => $this->authorized
		);
		
		$this->pages_default	= "frontend/metro";
		$this->pages_customiz	= "frontend/content/pages/";

		if(empty($this->authorized[0])) {
			redirect('authen/logout');
		}
		
	}
	
	public function getCollectionList() {
		
		$version = $this->config->item('collection_version');
		
		$this->data['stylesheet']	= array('custom/collection', 'notifIt/notifIt', 'multi-select/multiple-select', 'kalendea/kalendae', 'webui-popover/jquery.webui-popover');
		$this->data['javascript']	= array('moment.min', 'vendor/jquery.number.min', 'dataTables/media/js/jquery.dataTables.min', 'dataTables/extensions/Responsive/js/dataTables.responsive.min', 'plugin/notifIt/notifIt', 'vendor/jquery.multiple.select', 'kalendea/kalendae.standalone.min', 'build/collection/collection_loader.js?v=' . $version, 'plugin/webui-popover/jquery.webui-popover.min');
		
		$this->data['os_balance']	= $this->getOSBalance();
		
		$this->pages  = "collection/collection_report";
		$this->_renders($this->pages_default, 'customiz');
		
	}
	
	public function whiteboard() {
		$version = $this->config->item('whiteboard');
	
		$this->data['stylesheet']	= array('custom/collection', 'notifIt/notifIt', 'multi-select/multiple-select', 'kalendea/kalendae', 'webui-popover/jquery.webui-popover');
		$this->data['javascript']	= array('moment.min', 'vendor/jquery.number.min', 'dataTables/media/js/jquery.dataTables.min', 'dataTables/extensions/Responsive/js/dataTables.responsive.min','plugin/notifIt/notifIt', 'vendor/jquery.multiple.select', 'kalendea/kalendae.standalone.min', 'build/collection/whiteboard.js?v=' . $version, 'plugin/webui-popover/jquery.webui-popover.min');
	
		$this->pages  = "module/whiteboard";
		$this->_renders($this->pages_default, 'customiz');
	}

	public function getOSBalance() {
		$this->load->model('dbstore');
	
		$result = $this->dbstore->getOSBalance($this->emp_id);		

		$object = array(
				'Year'				=> !empty($result['data'][0]['Year']) ? $result['data'][0]['Year']:'',
				'OSActual'			=> !empty($result['data'][0]['OSActual']) ? $result['data'][0]['OSActual']:'',
				'DDActual'			=> !empty($result['data'][0]['DDActual']) ? $result['data'][0]['DDActual']:'',
				'ActualTotal'		=> !empty($result['data'][0]['ActualTotal']) ? $result['data'][0]['ActualTotal']:'',
				'PayPercentage'		=> !empty($result['data'][0]['PayPercentage']) ? $result['data'][0]['PayPercentage']:'',
				'FinalNetActual'	=> !empty($result['data'][0]['FinalNetActual']) ? $result['data'][0]['FinalNetActual']:''
		);
			
		return $object;
		
	}
	
}