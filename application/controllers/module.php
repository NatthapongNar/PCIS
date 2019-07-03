<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module extends MY_Controller {
	
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
		
	public function drawdownTemplate() {
		
		if(!empty($this->authorized[0])) {
			switch ($this->authorized[0]) {
				case $this->config->item('ROLE_CA'):
					$this->data['role_department'] = 'CA_ROLE';
					break;
				case $this->config->item('ROLE_OPER'):
					$this->data['role_department'] = 'OPER_ROLE';
					break;
				default: 
					$this->data['role_department'] = 'LB_ROLE';
					break;
			}
		}
		
		$this->data['user_role']	 = $this->getRole($this->authorized[0], $this->branch_code);

		$this->pages  = "module/drawdown_template";
		$this->load->view($this->pages_customiz . $this->pages, $this->data);
		
	}
	
	public function getRole($role, $branch_code) {
		if(!empty($role)) {
			switch ($role) {
				case $this->config->item('ROLE_ADMIN'):
					if($branch_code == '000') return 'admin_role';
					else return 'adminbr_role';
					
					break;
				case $this->config->item('ROLE_RM'):
					return 'rm_role';
					break;
				case $this->config->item('ROLE_BM'):
					return 'bm_role';
					break;
				case $this->config->item('ROLE_AM'):
					return 'am_role';
					break;
				case $this->config->item('ROLE_RD'):
					return 'rd_role';
					break;
				case $this->config->item('ROLE_ADMINSYS'):
					return 'dev_role';
					break;
				case $this->config->item('ROLE_SPV'):
				case $this->config->item('ROLE_HQ'):
				default:
					return 'hq_role';
					break;
			}
		}
		
	}

}