<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends MY_Controller {
	
	// Variable Path
	public $pages_default;	
	public $pages_customiz;
	public $pages_mangement;
	
	public function __construct() {
		parent::__construct();
		
		$this->sessid       = $this->session->userdata("session_id");
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
		$this->pilot		 = $this->session->userdata("pilot");

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
				"auth"       => $this->authorized,
				"pilot"		 => $this->pilot
		);
		
		$this->pages_default	= "frontend/metro";
		$this->pages_customiz	= "frontend/content/pages/";
		$this->pages_mangement	= "frontend/content/report/mangement/";
		
		if(empty($this->authorized[0])):
			redirect('authen/logout');
		endif;
		
	}
	
	public function whiteboard() {
		$this->load->model('dbmodel');
		$version = $this->config->item('whiteboard');
		
		$this->data['stylesheet']	= array('custom/angular_whiteboard.css?v=001', 'notifIt/notifIt', 'multi-select/multiple-select', 'kalendea/kalendae', 'webui-popover/jquery.webui-popover', '../js/plugin/malihuscrollbar/jquery.mCustomScrollbar.min');
		$this->data['javascript']	= array('moment.min', 'vendor/jquery.number.min', 'dataTables/media/js/jquery.dataTables.min', 'dataTables/extensions/Responsive/js/dataTables.responsive.min', 'dataTables/date-eu',
											'plugin/notifIt/notifIt', 'vendor/jquery.multiple.select', 'kalendea/kalendae.standalone.min', 'plugin/webui-popover/jquery.webui-popover.min',
											'plugin/pdf_thumbnails/pdf.worker', 'plugin/pdf_thumbnails/pdf', 'plugin/malihuscrollbar/jquery.mCustomScrollbar.concat.min');
		
		$this->data['is_pilot']		= !empty($this->pilot[0]) ? 'TRUE':'FALSE';
		
		$this->data['user_role']	= $this->getRole($this->authorized[0], $this->branch_code);
		$this->data['profiles']		= (!empty(trim($this->emp_id))) ? $this->dbmodel->CIQuery("SELECT * FROM LendingEmp WHERE EmployeeCode = '".trim($this->emp_id)."'"):null;

		$this->pages  = "module/whiteboard";
		$this->_renders($this->pages_default, 'customiz');
		
	}
	
	public function whiteboardH4C() {
		$this->load->model('dbmodel');
		$version = $this->config->item('whiteboard');
		
		$this->data['stylesheet']	= array('custom/angular_whiteboard.css?v=001', 'notifIt/notifIt', 'multi-select/multiple-select', 'kalendea/kalendae', 'webui-popover/jquery.webui-popover', '../js/plugin/malihuscrollbar/jquery.mCustomScrollbar.min');
		$this->data['javascript']	= array('moment.min', 'vendor/jquery.number.min', 'dataTables/media/js/jquery.dataTables.min', 'dataTables/extensions/Responsive/js/dataTables.responsive.min', 'dataTables/date-eu',
				'plugin/notifIt/notifIt', 'vendor/jquery.multiple.select', 'kalendea/kalendae.standalone.min', 'plugin/webui-popover/jquery.webui-popover.min',
				'plugin/pdf_thumbnails/pdf.worker', 'plugin/pdf_thumbnails/pdf', 'plugin/malihuscrollbar/jquery.mCustomScrollbar.concat.min');
		
		$this->data['is_pilot']		= !empty($this->pilot[0]) ? 'TRUE':'FALSE';
		
		$this->data['user_role']	= $this->getRole($this->authorized[0], $this->branch_code);
		$this->data['profiles']		= (!empty(trim($this->emp_id))) ? $this->dbmodel->CIQuery("SELECT * FROM LendingEmp WHERE EmployeeCode = '".trim($this->emp_id)."'"):null;
		
		$this->pages  = "module/whiteboard_h4c";
		$this->_renders($this->pages_default, 'customiz');
		
	}
		
	public function whiteboard_v2() {		
		$this->data['version'] 		= $this->config->item('whiteboard_v2');
		$this->data['user_role']	= $this->getRole($this->authorized[0], $this->branch_code);
		
		$this->pages  = "dashboard/whiteboard";
		$this->_renders($this->pages_mangement, 'customiz');
		
	}
	
	public function getRole($role, $branch_code) {
		if(!empty($role)) {
			switch ($role) {
				case $this->config->item('ROLE_ADMIN'):
					if($branch_code == '000') return 'hq_role';
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
	
	public function gridDataList() {
		$this->load->model('dbmodel');
		$object_logs = array(
				'Page'		 => 'KPI',
				'CreateCode' => $this->emp_id,
				'CreateDate' => date('Y-m-d H:i:s')
		);
		
		$this->dbmodel->exec('UserSignInPageLogs', $object_logs, false, 'insert');
		
		$this->load->view($this->pages_customiz.'../report/kpi/dashboard', $this->data);
	}
	
	public function gridDashboardTable() {
		$this->load->view($this->pages_customiz.'../report/kpi/dashboard_viewer', $this->data);
	}
	
	public function dashboardchart() {
		$this->load->view($this->pages_customiz.'../report/kpi/chart', $this->data);
	}
	
	public function onloadKPI() {
		$this->load->view($this->pages_customiz.'../report/kpi/dashboard_chart', $this->data);
		
	}
	
	public function oldOnloadKPI() {
		$this->load->view($this->pages_customiz.'../report/kpi/backup/dashboard_new', $this->data);
	
	}

}