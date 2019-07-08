 <?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Metro extends MY_Controller {
	
	public $pages_default;
	public $pages_customiz;
	
	private $individual_mode;
	private $branch_mode;
	
	protected $sessid;
	protected $username;
	protected $emp_id;
	protected $email;
	protected $name, $engname, $bm;
	protected $position;
	protected $branch;
	protected $branch_code;
	protected $region_id;
	protected $region;
	protected $region_th;
	protected $authorized;
	protected $is_logged_in;
	protected $pilot;
	protected $logs;
	
	protected $identify;
	protected $revisit_ref;
	protected $is_active;

	public function __construct() {
		parent::__construct();
		
		$this->pages_default	= "frontend/metro";
		$this->pages_customiz	= "frontend/content/pages/";
		
		$this->sessid       = $this->session->userdata("session_id");

		$this->username      = $this->session->userdata("xuser");
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
		
		// Object: Session Enrolled.
		$this->data['session_data'] = array(
				"xuser"		 => $this->username,
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
				"role"		 => $this->getRole($this->authorized[0], $this->branch_code),
				"pilot"		 => $this->pilot
		);
		
		$this->logs			 = $_SERVER['DOCUMENT_ROOT'].'/ci/logs/debug/';
		$this->individual_mode				= 'individual';
		$this->branch_mode					= 'branchs';
		
		if(empty($this->authorized[0])) {
			redirect('authen/logout');
		} else {
			if(in_array($this->authorized[0], array($this->config->item('ROLE_CA'), $this->config->item('ROLE_OPER'))))
			   redirect('module/drawdownTemplate');
		}

	}
	
	public function checkAuthorityUser() {
		print_r($this->data['session_data']);
	}
	
	public function index() {
		$this->load->model('dbstore');
		
		$main_chart 				 = $this->config->item('mainchart_version');
		$this->data['stylesheet']	 = array('multi-select/multiple-select', 'fullcalendar/fullcalendar.min', 'fullcalendar/fullcalendar.print', 'custom/th_charmonman', '../js/tooltipster-master/css/tooltipster.bundle.min', '../js/tooltipster-master/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-borderless.min');
		$this->data['javascript']	 = array('vendor/jquery.multiple.select', 'chart/chartJS/Chart.min', 'chart/justgage/justgage', 'chart/justgage/raphael.min', 'moment.min', 'fullcalendar/fullcalendar.min', 'chart/sparkline/jquery.sparkline.min', 'tooltipster-master/js/tooltipster.bundle.min', 'build/metro_chart.js'.$main_chart);
		$this->data['royalGuidance'] = $this->dbstore->dbo_getRoyalGuidance();
		$this->data['user_role']	 = $this->getRole($this->authorized[0], $this->branch_code);
		
		$this->data['reset_chat']	 = '?v='. $this->config->item('reset_chat');		

		$this->_renders("frontend/metro", 'customiz');
	}
	
	public function bkk() {
		$this->load->model('dbstore');
		
		$main_chart 				 = $this->config->item('mainchart_version');
		$this->data['stylesheet']	 = array('multi-select/multiple-select', 'fullcalendar/fullcalendar.min', 'fullcalendar/fullcalendar.print', 'custom/th_charmonman', '../js/tooltipster-master/css/tooltipster.bundle.min', '../js/tooltipster-master/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-borderless.min');
		$this->data['javascript']	 = array('vendor/jquery.multiple.select', 'chart/chartJS/Chart.min', 'chart/justgage/justgage', 'chart/justgage/raphael.min', 'moment.min', 'fullcalendar/fullcalendar.min', 'chart/sparkline/jquery.sparkline.min', 'tooltipster-master/js/tooltipster.bundle.min', 'build/metro_chart_bkk.js'.$main_chart);
		$this->data['royalGuidance'] = $this->dbstore->dbo_getRoyalGuidance();
		$this->data['user_role']	 = $this->getRole($this->authorized[0], $this->branch_code);
		
		$this->data['reset_chat']	 = '?v='. $this->config->item('reset_chat');
		
		$this->pages 			    = "main_bkk";
		$this->_renders($this->pages_default, 'customiz');
		
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
	
	/** Implement New Functionality **/
	
	function createlink($status) {
		switch($status) {
			case "Y":
			case "N":
				return site_url('metro/routers');
				break;
			case "":
			case false:
			default:
				//return "#";
				return site_url('metro/routers');
				break;
		}
	}
	
	function processstate($status) {
		switch($status) {
			case "Y":
				return "app-stateno state_success";
				break;
			case "N":
				return "app-stateno state_start";
				break;
			case "":
			case null:
			default:
				return "app-stateno state_pending";
				break;
	
		}
	}
	
	public function notify($status) {
		switch($status) {
		case "Y":
			$notify = 'data-hint="Status|Progress Complete" data-hint-position="top"';
			return $notify;
		break;
		case "N":
			return 'data-hint="Status|Progress Start" data-hint-position="top"';
		break;
		case "":
		case null:
		default:
			return 'data-hint="Status|Progress Pending" data-hint-position="top"';
		break;
	
     	}
    }
	
    public function stateInitial($status) {
	
		switch($status) {
		case "Y":
		case "N":
			return "1";
			break;
		case "":
		case null:
		default:
			return "0";
			break;
        }
	
    }
	
    public function urlInitial($status) {
	
	 	switch($status) {
			case "Y":
				return "mod=1";
				break;
			case "N":
				return "mod=2";
				break;
			case "":
			case null:
			default:
				return "mod=3";
			break;
		}
	
	}
	
	public function liveInitial($status) {
		
		if($status == 'Y') {
			return '1';
		} else {
			return '2';
		}
		
	}
	
	private function levelCustomer($level) {
		switch($level) {
			case 'H':
				return 'High';
			break;
			case 'M':
				return 'Medium';
			break;
			case 'L';
				return 'Low';
			break;
			case '':
			default:
				return '';
			break;
		}
	}
	
	public function appComponents() {
		$this->load->model('dbprogress');
		$this->load->library('effective');		
		
		header('Content-Type: application/json; charset="UTF-8"');

		//$results = $this->dbprogress->dataTableProgress($this->authorized, array($this->emp_id));
		$iTotal	 = $this->dbprogress->dataTablePagination($this->authorized, array($this->emp_id));
	
		foreach($results['data'] as $index => $value) {
			$cust_name = ($results['data'][$index]['MainLoanName'] != "") ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['MainLoanName']):$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['OwnerName']);
			$retrieve  = !empty($results['data'][$index]['hasRetrieve']) ? ' <abbr title="Retrieve on date : '. $this->effective->StandartDateRollback($results['data'][$index]['RetrieveDate']) .'" style="border: 0;"><small>(' . $results['data'][$index]['hasRetrieve'] . ')</small></abbr>':null;
			
			$interest  = ($results['data'][$index]['Interest'] == 'Y') ? "สนใจ":"ไม่สนใจ";
			$products  = !empty($results['data'][$index]['ProductCode']) ? trim($results['data'][$index]['ProductTypes']).'-'.substr($results['data'][$index]['ProductCode'], -2, 2):"";
			$colums[]  = array(
				"CreateDate" 		=> $this->effective->StandartDateRollback($results['data'][$index]['CreateDate']),
				"SourceOfCustomer"  => '<abbr title="'.$results['data'][$index]['SourceChannel'].'" style="border:none;">'.$results['data'][$index]['SourceOfCustomer'].'</abbr>',
				"Interest"			=> '<abbr title="'.$interest.'" style="border:none;">'.$results['data'][$index]['Interest'].'</abbr>',
				"CSPotential"		=> '<abbr title="'.$this->levelCustomer($results['data'][$index]['CSPotential']).'" style="border:none;">'.$results['data'][$index]['CSPotential'].'</abbr>',
				"OwnerName"			=> $cust_name . $retrieve,
				"DueDate"			=> $this->effective->StandartDateRollback($results['data'][$index]['DueDate']),
				"Downtown"			=> ($results['data'][$index]['Downtown'] != "") ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['Downtown']):'',
				"Business"			=> ($results['data'][$index]['Business'] != "") ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['Business']):'',
				"RequestLoan"		=> ($results['data'][$index]['RequestLoan'] != "") ? number_format($results['data'][$index]['RequestLoan'], 0):"",
				"BranchDigit"		=> $results['data'][$index]['BranchDigit'],
				"RMName"			=> ($results['data'][$index]['RMName'] != "") ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['RMName']):'',
				"AppProcess"		=> !empty($results['data'][$index]['AppProcess']) ?
									   '<div class="app-state">'.
									   '<a target="_blank" href="'.$this->createlink($results['data'][$index]['AppProcess']).'?'.$this->urlInitial($results['data'][$index]['AppProcess']).'&cache=false&secure='.md5(true).'&rel='.$results['data'][$index]['DocID'].'&req=P1&live='.$this->liveInitial($results['data'][$index]['AppProcess']).'&t='.date('s').'"><div '.$this->notify($results['data'][$index]['AppProcess']).' class="'.$this->processstate($results['data'][$index]['AppProcess']).'" data-state="'.$this->stateInitial($results['data'][$index]['AppProcess']).'">1</div></a>'.
									   '</div>':"",
				"VerifyProcess"		=> !empty($results['data'][$index]['VerifyProcess']) ?
									   '<div class="app-state">'.
									   '<a target="_blank" href="'.$this->createlink($results['data'][$index]['VerifyProcess']).'?'.$this->urlInitial($results['data'][$index]['VerifyProcess']).'&cache=false&secure='.md5(true).'&rel='.$results['data'][$index]['DocID'].'&req=P2&live='.$this->liveInitial($results['data'][$index]['VerifyProcess']).'&t='.date('s').'"><div '.$this->notify($results['data'][$index]['VerifyProcess']).' class="'.$this->processstate($results['data'][$index]['VerifyProcess']).'" data-state="'.$this->stateInitial($results['data'][$index]['VerifyProcess']).'">2</div></a>'.
									   '</div>':"",					
				"AStateProcess"		=> !empty($results['data'][$index]['AStateProcess']) ?
									   '<div class="app-state">'.
									   '<a target="_blank" href="'.$this->createlink($results['data'][$index]['AStateProcess']).'?'.$this->urlInitial($results['data'][$index]['AStateProcess']).'&cache=false&secure='.md5(true).'&rel='.$results['data'][$index]['DocID'].'&ddflag=N&req=P3&live='.$this->liveInitial($results['data'][$index]['AStateProcess']).'&t='.date('s').'"><div '.$this->notify($results['data'][$index]['AStateProcess']).' class="'.$this->processstate($results['data'][$index]['AStateProcess']).'" data-state="'.$this->stateInitial($results['data'][$index]['AStateProcess']).'">3</div></a>'.
									   '</div>':"",					
			);
			
		}
		
		$sOutput = array(
				'draw'                => intval($this->input->post('draw')) ? intval($this->input->post('draw')) : 0,
				'recordsTotal'        => $iTotal,
				'recordsFiltered'     => $iTotal,
				'data'                => $colums
		);
	
		echo json_encode($sOutput);
		
	}
	
	public function appProgress() {
		$this->load->model('dbmodel');
		$this->load->model('dbprogress');
		
		$this->load->library('effective');
		$this->load->library('datatables');
	
		$this->pages 			    	= "app_progress";
		$this->data['char_mode']		= $this->char_mode;
		$this->data['SourceField']		= $this->getSourceFields();
		$this->data['AreaRegion']		= $this->dbmodel->loadData($this->table_region, 'RegionID, RegionNameEng', array("RegionNameEng !=" => "BKK - HQ", 'IsActive' => 'A'));
		$this->data['AreaBoundary']		= $this->dbprogress->appProgressBranch($this->authorized, array($this->emp_id));
		
		$this->data['stylesheet']	= array('kalendea/kalendae', 'textTags/jquery.tag-editor', 'multi-select/multiple-select', 'custom/app_progress');
		$this->data['javascript']	= array('kalendea/kalendae.standalone.min', 'dataTables/media/js/jquery.dataTables.min', 'vendor/jquery.truncate.min', 'vendor/jquery.number.min', 'textTags/jquery.tag-editor.min', 'textTags/jquery.caret.min', 'vendor/jquery.multiple.select', 'build/app_progress');

		$this->_renders($this->pages_default, 'customiz');
		
	}
	
	/** End Implement New Functionality **/


    /** Calendar Planner */
    public function calendarEvent() {
        $this->load->view($this->pages_customiz.'calendar');
    }
    
    /** Notification **/
    public function notificationManagement() {
    	$this->pages 			    = "nof_activity";
    	$this->_renders($this->pages_default, 'customiz');
    
    }
    

	/** Create Profile */
	public function createProfile() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		$this->load->library('form_validation');		
	
		$this->pages				= "form/create/profile_process";
		$this->data['char_mode']	= $this->char_mode;
	
		$this->data['stylesheet']	= array('pikaday', 'custom/bsi', 'custom/form', 'webui-popover/jquery.webui-popover', 'custom/tooltip_custom');
		$this->data['javascript']	= array('moment.min', 'pikaday', 'autocomplete', 'vendor/jquery.number.min', 'vendor/jquery.mask.min', 'vendor/jquery.cookie', 'build/form/profile_process/cprofile.js?v=001', 'build/form/profile_process/profile_validation.js?v=001', 'plugin/webui-popover/jquery.webui-popover.min');
	 
		$this->data['user_role']	= $this->getRole($this->authorized[0], $this->branch_code);
		$this->data['branchs']		= $this->dbmodel->loadData($this->table_ledingbranchs, "BranchCode, BranchName, BranchDigit", array("BranchCode !=" => ""));
		
		$this->_renders($this->pages_default, 'customiz');
		// $this->output->enable_profiler(TRUE);	
		
	}

	/** Application Process  */
	public function profileManage() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$this->data['branchs']		= $this->dbmodel->loadData($this->table_ledingbranchs, "BranchCode, BranchName, BranchDigit", array("BranchCode !=" => ""));
		
		$doc_id						= $this->input->get('rel');
		$this->data['results']		= $this->dbmodel->CIQuery("
                    									SELECT
														[Profile].DocID, [Profile].Interest, [Profile].SourceOfCustomer, [Profile].SourceOption, [Profile].CSPotential, [Profile].LoanGroup,
														[Profile].OwnerType, [Profile].OwnerName, [Profile].PrefixName, [Profile].Company, [Profile].PrefixCorp, [Profile].BusinessType, [Profile].Business, [Profile].Telephone,
														[Profile].Mobile, ISNULL(BusinessLocation, [Profile].Downtown) AS Downtown, [Profile].Address, [Profile].Province, [Profile].District, [Profile].Postcode,
														[Profile].Channel, [Profile].SubChannel, [Profile].RequestLoan, convert(nvarchar(10), [Profile].ReceiveDocDate, 120) as ReceiveDocDate,
														[Profile].ReferralCode, [Profile].BranchCode, [Profile].Branch, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName, [Profile].BMName,
														[Profile].Region, [Profile].Remark, [Profile].IsActive, convert(nvarchar(10), [Profile].CreateDate, 120) as CreateDate, 
														Appointment.DueID, convert(nvarchar(10), Appointment.DueDate, 120) as DueDate,
														Appointment.[Subject], Appointment.[Description], IsAssignCase, AssignByID, BorrowerName,
														Verification.BasicCriteria, Verification.CriteriaReasonID
														FROM [Profile]
														LEFT OUTER JOIN Verification
														ON [Profile].DocID = Verification.DocID
														LEFT OUTER JOIN Appointment
														ON [Profile].DocID = Appointment.DocID
														LEFT OUTER JOIN NCBConsent
														ON [Profile].DocID = NCBConsent.DocID AND BorrowerType = '101'
                    									WHERE [Profile].DocID = '".$doc_id."'
														ORDER BY [profile].DocID DESC");
		
		$this->data['steppers'] 		= $this->dbmodel->CIQuery("
														SELECT [Profile].DocID, [Profile].IsActive as ProfileActice, Verification.IsActive as VerifyActive, ApplicationStatus.IsActive as AppStateActive
														FROM [Profile]
														LEFT OUTER JOIN Verification
														ON [Profile].DocID = Verification.DocID
														LEFT OUTER JOIN ApplicationStatus
														ON [Profile].DocID = ApplicationStatus.DocID
														WHERE [Profile].DocID = '".$doc_id."'");
		
		$this->data['user_role']    = $this->getRole($this->authorized[0], $this->branch_code);
		
		// View: Retrieve Logs
		$this->data['getDocRetr']	= $this->getDataRetrieveLog($doc_id);
		$this->data['char_mode']	= $this->char_mode;
		
		$this->pages                = "form/update/process_1/profile_manage";
		
		$sv	= '.js?v=003';
		$this->data['stylesheet']	= array('pikaday', 'custom/bsi', 'custom/form', 'custom/tooltip_custom', 'floatmenu/contact-buttons', 'themify-icons', 'webui-popover/jquery.webui-popover');
		$this->data['javascript']	= array('moment.min', 'pikaday', 'autocomplete', 'vendor/jquery.number.min', 'vendor/jquery.mask.min', 'vendor/jquery.cookie', 'build/form/process_management/process_1/cprofile' . $sv, 'build/form/process_management/process_1/profile_validation' . $sv,
											'plugin/floatmenu/jquery.contact-buttons', 'build/form/process_management/process_1/plugin/manage_floatmenu' . $sv, 'plugin/webui-popover/jquery.webui-popover.min');

		$this->_renders($this->pages_default, 'customiz');
		 
	}
	
	public function profilePreview() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$doc_id						= $this->input->get('rel'); 
		$this->data['results']		= $this->dbmodel->CIQuery("
                    									SELECT
														[Profile].DocID, [Profile].Interest, [Profile].SourceOfCustomer, [Profile].SourceOption, [Profile].CSPotential, [Profile].LoanGroup,
														[Profile].OwnerType, [Profile].OwnerName, [Profile].PrefixName, [Profile].Company, [Profile].PrefixCorp, [Profile].BusinessType, [Profile].Business, [Profile].Telephone,
														[Profile].Mobile, ISNULL(BusinessLocation, [Profile].Downtown) AS Downtown, [Profile].Address, [Profile].Province, [Profile].District, [Profile].Postcode,
														[Profile].Channel, [Profile].SubChannel, [Profile].RequestLoan, convert(nvarchar(10), [Profile].ReceiveDocDate, 120) as ReceiveDocDate,
														[Profile].ReferralCode, [Profile].BranchCode, [Profile].Branch, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName, [Profile].BMName,
                    									[Profile].Region, [Profile].Remark, [Profile].IsActive, convert(nvarchar(10), [Profile].CreateDate, 120) as CreateDate, 
														Appointment.DueID, convert(nvarchar(10), Appointment.DueDate, 120) as DueDate,
                    									Appointment.[Subject], Appointment.[Description], IsAssignCase, AssignByID, BorrowerName,
														Verification.BasicCriteria, Verification.CriteriaReasonID, MasterCriteriaReason.CriteriaReason
														FROM [Profile]
														LEFT OUTER JOIN Verification
														ON [Profile].DocID = Verification.DocID
														LEFT OUTER JOIN Appointment
														ON [Profile].DocID = Appointment.DocID
														LEFT OUTER JOIN MasterCriteriaReason
														ON Verification.CriteriaReasonID = MasterCriteriaReason.CriteriaReasonID
														LEFT OUTER JOIN NCBConsent
														ON [Profile].DocID = NCBConsent.DocID AND BorrowerType = '101'
                    									WHERE [Profile].DocID = '".$doc_id."'
														ORDER BY [profile].DocID DESC");
		
		$this->data['steppers'] 	= $this->dbmodel->CIQuery("
														SELECT [Profile].DocID, [Profile].IsActive as ProfileActice, Verification.IsActive as VerifyActive, ApplicationStatus.IsActive as AppStateActive
														FROM [Profile]
														LEFT OUTER JOIN Verification
														ON [Profile].DocID = Verification.DocID
														LEFT OUTER JOIN ApplicationStatus
														ON [Profile].DocID = ApplicationStatus.DocID
														WHERE [Profile].DocID = '".$doc_id."'");
			
		// View: Retrieve Logs
		$this->data['getDocRetr']	= $this->getDataRetrieveLog($doc_id);
		$this->data['char_mode']	= $this->char_mode;
		
		$this->pages                = "form/update/process_1/profile_preview";
		
		$sv	= '.js?v=003';
		$this->data['stylesheet']	= array('pikaday', 'custom/bsi', 'custom/form', 'custom/tooltip_custom', 'floatmenu/contact-buttons', 'themify-icons', 'webui-popover/jquery.webui-popover');
		$this->data['javascript']	= array('moment.min', 'autocomplete', 'vendor/jquery.number.min', 'vendor/jquery.mask.min', 'vendor/jquery.cookie', 'build/form/process_management/process_1/cprofile' . $sv, 'build/form/process_management/process_1/profile_validation' . $sv,
											'plugin/floatmenu/jquery.contact-buttons', 'build/form/process_management/process_1/plugin/preview_floatmenu' . $sv, 'plugin/webui-popover/jquery.webui-popover.min');
		
		$this->_renders($this->pages_default, 'customiz');
		
	}
	
	public function getProfileInRetrieve() {		
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$doc_id						= $this->input->get('rel');
		$this->data['results']		= $this->dbmodel->CIQuery("
                    									SELECT
														[Profile].DocID, [Profile].Interest, [Profile].SourceOfCustomer, [Profile].SourceOption, [Profile].CSPotential, [Profile].LoanGroup,
														[Profile].OwnerType, [Profile].OwnerName, [Profile].PrefixName, [Profile].Company, [Profile].PrefixCorp, [Profile].BusinessType, [Profile].Business, [Profile].Telephone,
														[Profile].Mobile, [Profile].Downtown, [Profile].Address, [Profile].Province, [Profile].District, [Profile].Postcode,
														[Profile].Channel, [Profile].SubChannel, [Profile].RequestLoan, convert(nvarchar(10), [Profile].ReceiveDocDate, 120) as ReceiveDocDate,
														[Profile].ReferralCode, [Profile].BranchCode, [Profile].Branch, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName, [Profile].BMName,
                    									[Profile].Region, [Profile].Remark, [Profile].IsActive, convert(nvarchar(10), [Profile].CreateDate, 120) as CreateDate,
														Appointment.DueID, convert(nvarchar(10), Appointment.DueDate, 120) as DueDate,
                    									Appointment.[Subject], Appointment.[Description], IsAssignCase, AssignByID,
														Verification.BasicCriteria, Verification.CriteriaReasonID, MasterCriteriaReason.CriteriaReason
														FROM [Profile]
														LEFT OUTER JOIN Verification
														ON [Profile].DocID = Verification.DocID
														LEFT OUTER JOIN Appointment
														ON [Profile].DocID = Appointment.DocID
														LEFT OUTER JOIN MasterCriteriaReason
														ON Verification.CriteriaReasonID = MasterCriteriaReason.CriteriaReasonID
                    									WHERE [Profile].DocID = '".$doc_id."'
														ORDER BY [profile].DocID DESC");
		
		$this->data['steppers'] 	= $this->dbmodel->CIQuery("
														SELECT [Profile].DocID, [Profile].IsActive as ProfileActice, Verification.IsActive as VerifyActive, ApplicationStatus.IsActive as AppStateActive
														FROM [Profile]
														LEFT OUTER JOIN Verification
														ON [Profile].DocID = Verification.DocID
														LEFT OUTER JOIN ApplicationStatus
														ON [Profile].DocID = ApplicationStatus.DocID
														WHERE [Profile].DocID = '".$doc_id."'");
		
		$this->data['getCustInfo'] 	= $this->getCustomerInformation($doc_id);
		$this->data['char_mode']	= $this->char_mode;
		
		$this->pages                = "form/history_form/process_1/profile_form";
		
		$this->data['stylesheet']	= array('pikaday', 'custom/bsi', 'custom/form', 'themify-icons');
		$this->data['javascript']	= array('moment.min', 'autocomplete', 'vendor/jquery.number.min', 'vendor/jquery.mask.min', 'vendor/jquery.cookie', 'build/form/process_management/process_1/cprofile', 'build/form/process_management/process_1/profile_validation');
		
		$this->_renders($this->pages_default, 'customiz');
		
	}
	
	// Verification Processes
	public function verificationManage() {
		$this->load->model('dbmodel');
		
		$this->pages                = "form/update/process_2/verify_manage";
		
		$doc_id						= $this->input->get('rel');
		$this->data['results']		= $this->dbmodel->CIQuery("
										SELECT
										[Profile].DocID, [Profile].BranchCode, [Profile].Branch, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName, 
										[Profile].Company, [Profile].OwnerName, [Profile].BMName, [Profile].Region,
										Verification.VerifyID, Verification.ProductCode, Verification.BasicCriteria,
										Verification.RMProcess,convert(nvarchar(10), Verification.RMProcessDate, 120) as RMProcessDate,
										Verification.ActionNote,Verification.MRTA,Verification.Cashy,
										Verification.EMSNo,convert(nvarchar(10), Verification.EMSDate, 120) as EMSDate,
										convert(nvarchar(10), Verification.HQReceiveCADocDate, 120) as HQReceiveCADocDate,
										Verification.SentDocToCA, convert(nvarchar(10), Verification.SentToCADate, 120) as SentToCADate,
										Verification.DocID,Verification.ID_Card,Verification.CompletionDoc,
										convert(nvarchar(10), Verification.CompletionDocDate, 120) AS CompletionDocDate,Verification.IsActive,
										NCB.CheckNCB,convert(nvarchar(10), NCB.CheckNCBDate, 120) as CheckNCBDate,
										NCB.MainLoan,NCB.JoinLoan,NCB.Corporation,NCB.MainLoanName,
										NCB.JoinLoan2,NCB.JoinLoan3,NCB.JoinLoan4,NCB.Guarantor,
										CONVERT(nvarchar(10), NCB.BrnSentNCBDate, 120) AS BrnSentNCBDate, CONVERT(nvarchar(10), NCB.HQGetNCBDate, 120) AS HQGetNCBDate, NCB.Comments,
										ReActivate.RevisitRef, ReActivate.RevisitID, convert(nvarchar(10), ReActivate.RevisitDate, 120) as RevisitDate,
										CONVERT(nvarchar(10), HQSentNCBToOperDate, 120) AS HQSentNCBToOperDate
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN ReActivate
										ON  Verification.VerifyID = ReActivate.VerifyID
										WHERE [Profile].DocID = '".$doc_id."'");

		$this->data['lacklist']		= $this->dbmodel->CIQuery("
										SELECT LackList.RowID, LackList.LackID, MasterLackDoc.LackDoc, LackList.LackListActive
										FROM LackList
										INNER JOIN MasterLackDoc 
										ON LackList.LackID = MasterLackDoc.LackID
										WHERE LackList.LackListActive = 'A'
										AND LackList.VerifyID = '".$this->data['results']['data'][0]['VerifyID']."'");
		
		$this->data['docrefund']	= $this->dbmodel->loadData($this->table_docrefund, 'DocNo, DocType, DocNote, CreateBy, convert(nvarchar(10), CreateDate, 120) as CreateDate,
																						HQGetDocBy, convert(nvarchar(10), HQGetDocDate, 120) as	HQGetDocDate,
																						HQGetDocFromCABy, convert(nvarchar(10), HQGetDocFromCADate, 120) as HQGetDocFromCADate,
																						BranchGetDocBy,	convert(nvarchar(10), BranchGetDocDate, 120) as BranchGetDocDate', array("DocID" => $doc_id));
		
		$this->data['rmlogs']		= $this->dbmodel->CIQuery("
										SELECT * FROM (
											SELECT
												 VerifyID, convert(nvarchar(21), ProcessDate, 120) as ProcessDate, ProcessName, ROW_NUMBER() OVER(ORDER BY ProcessDate DESC) AS Runno
											FROM rmprocesslog
											WHERE VerifyID = '".$this->data['results']['data'][0]['VerifyID']."'
										) A
										WHERE A.Runno > 0 AND A.Runno <= 5
										ORDER BY convert(nvarchar(21), A.ProcessDate, 120) DESC");
		
		$this->data['stylesheet']	= array('pikaday', 'custom/bsi', 'custom/form');
		$this->data['javascript']	= array('moment.min', 'pikaday', 'vendor/jquery.number.min', 'vendor/jquery.mask.min', 'vendor/jquery.cookie', 'build/form/process_management/process_2/cverification', 'build/form/process_management/process_2/verify_validation');
		$this->_renders($this->pages_default, 'customiz');
		 
	}
	
	public function verificationPreview() {
		$this->load->model('dbmodel');
		
		$this->pages                = "form/update/process_2/verify_preview";
		
		$doc_id						= $this->input->get('rel');
		$this->data['results']		= $this->dbmodel->CIQuery("
										SELECT 
										[Profile].DocID, [Profile].BranchCode, [Profile].Branch, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName, 
										[Profile].Company, [Profile].OwnerName, [Profile].BMName, [Profile].Region,
										Verification.VerifyID, Verification.ProductCode,Verification.BasicCriteria,
										Verification.RMProcess,convert(nvarchar(10), Verification.RMProcessDate, 120) as RMProcessDate,
										Verification.ActionNote,Verification.MRTA,Verification.Cashy,
										Verification.EMSNo,convert(nvarchar(10), Verification.EMSDate, 120) as EMSDate, 
										convert(nvarchar(10), Verification.HQReceiveCADocDate, 120) as HQReceiveCADocDate, 
										Verification.SentDocToCA, convert(nvarchar(10), Verification.SentToCADate, 120) as SentToCADate,
										Verification.DocID,Verification.ID_Card,Verification.CompletionDoc,
										convert(nvarchar(10), Verification.CompletionDocDate, 120) AS CompletionDocDate, Verification.IsActive,
										NCB.CheckNCB,convert(nvarchar(10), NCB.CheckNCBDate, 120) as CheckNCBDate,
										NCB.MainLoan,NCB.JoinLoan,NCB.Corporation,NCB.MainLoanName,
										NCB.JoinLoan2,NCB.JoinLoan3,NCB.JoinLoan4,NCB.Guarantor,
										CONVERT(nvarchar(10), NCB.BrnSentNCBDate, 120) AS BrnSentNCBDate, CONVERT(nvarchar(10), NCB.HQGetNCBDate, 120) AS HQGetNCBDate, NCB.Comments,
										ReActivate.RevisitRef, ReActivate.RevisitID, convert(nvarchar(10), ReActivate.RevisitDate, 120) as RevisitDate,
										CONVERT(nvarchar(10), NCB.HQSentNCBToOperDate, 120) AS HQSentNCBToOperDate
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN ReActivate
										ON  Verification.VerifyID = ReActivate.VerifyID
										WHERE [Profile].DocID = '".$doc_id."'");
		
		$this->data['product']      = $this->productDetail($this->data['results']['data'][0]['ProductCode']);
		$this->data['lacklist']		= $this->dbmodel->CIQuery("
										SELECT LackList.LackID, MasterLackDoc.LackDoc, LackList.LackListActive
										FROM LackList
										INNER JOIN MasterLackDoc
										ON LackList.LackID = MasterLackDoc.LackID
										WHERE LackList.LackListActive = 'A'
										AND LackList.VerifyID = '".$this->data['results']['data'][0]['VerifyID']."'");
		
		$this->data['docrefund']	= $this->dbmodel->loadData($this->table_docrefund, 'DocNo, DocType, DocNote, CreateBy, convert(nvarchar(10), CreateDate, 120) as CreateDate,
																						HQGetDocBy, convert(nvarchar(10), HQGetDocDate, 120) as	HQGetDocDate,
																						HQGetDocFromCABy, convert(nvarchar(10), HQGetDocFromCADate, 120) as HQGetDocFromCADate,
																						BranchGetDocBy,	convert(nvarchar(10), BranchGetDocDate, 120) as BranchGetDocDate', array("DocID" => $doc_id));
		
		$this->data['rmlogs']		= $this->dbmodel->CIQuery("
										SELECT * FROM (
											SELECT 
												 VerifyID, convert(nvarchar(21), ProcessDate, 120) as ProcessDate, ProcessName, ROW_NUMBER() OVER(ORDER BY ProcessDate DESC) AS Runno
											FROM rmprocesslog
											WHERE VerifyID = '".$this->data['results']['data'][0]['VerifyID']."'											
										) A
										WHERE A.Runno > 0 AND A.Runno <= 5
										ORDER BY convert(nvarchar(21), A.ProcessDate, 120) DESC");
		
		$this->data['stylesheet']	= array('pikaday', 'custom/bsi', 'custom/form');
		$this->data['javascript']	= array('moment.min', 'pikaday', 'vendor/jquery.number.min', 'vendor/jquery.mask.min', 'vendor/jquery.cookie', 'build/form/process_management/process_2/cverification', 'build/form/process_management/process_2/verify_validation');
		$this->_renders($this->pages_default, 'customiz');
		 
	}
	
	// Application Status Processes
	public static function searchForAttr($value, $array, $attrs) {
		foreach ($array as $key => $val) {
			if ($val[$attrs] === $value) {
				return $key;
			}
		}
		return null;
	}
	
	public static function asort2d($records, $field, $reverse=false) {
		$hash = array();
		foreach($records as $key => $record) {
		    $hash[$record[$field].$key] = $record;
		}
		
		($reverse) ? krsort($hash) : ksort($hash);
		
		$records = array();
		foreach($hash as $record) {
		    $records []= $record;
		}
		
		return $records;
	}

	public static function onLoadOfficialHoliday($official_holiday) {
		$index = 1;
		$date_collection = array();
		for($i = 0; $i < date('t'); $i++):
			array_push($date_collection, date('D d', strtotime(date('Y-m') . '-' . str_pad($index++, 2, '0', STR_PAD_LEFT))));
		endfor;                            
		
		$date_temp = array();
		if(count($date_collection) >= 1) {
			for($i = 0; $i < count($date_collection); $i++):
				$str_temp = explode(" ", $date_collection[$i]);
				array_push($date_temp, array(
						'DayName' => $str_temp[0],
						'DayNo'   => $str_temp[1]
					)
				);
				
			endfor;
		}
		
		if(count($date_temp) >= 1) {
			foreach($date_temp as $index => $value) {
				if(in_array($value['DayName'], array('Sat', 'Sun'))):
					unset($date_temp[$index]);
				endif;
			}
		}

		if(!empty($official_holiday[date('M')][0])) {
			foreach($official_holiday[date('M')] as $index => $value) {
				$index_attr = self::searchForAttr($value, $date_temp, 'DayNo');
				unset($date_temp[$index_attr]);
			
			}	
		}
		
		$result = self::asort2d($date_temp, 'DayNo', true);
		
		// Final Cut-off
		$finalWeekendWorking = array();
		for($i = 0; $i < 5; $i++) {
			array_push($finalWeekendWorking, $result[$i]['DayNo']);
			
		}
		
		return $finalWeekendWorking;

		
	}

	public function appstateManage() {
		$this->load->model('dbmodel');
		$this->load->model('dbstore');
		$this->load->library('effective');
		
		$this->pages                = "form/update/process_3/appstate_manage";
		
		$script_version				= '.js?v=006';
		$this->data['stylesheet']	= array('pikaday', 'custom/bsi', 'custom/form', 'custom/tooltip_custom', 'multiselect/multiple-select.min', 'floatmenu/contact-buttons', 'themify-icons', 'webui-popover/jquery.webui-popover');
		$this->data['javascript']	= array('moment.min', 'pikaday', 'vendor/jquery.number.min', 'vendor/jquery.mask.min', 'multiselect/multiple-select.min', 'vendor/jquery.cookie', 'build/form/process_management/process_3/cappstate'  . $script_version, 'build/form/process_management/process_3/appstate_validation'  . $script_version, 'build/form/process_management/process_3/optionappstate'  . $script_version,   
											'plugin/floatmenu/jquery.contact-buttons', 'build/form/process_management/process_3/plugin/manage_floatmenu' . $script_version, 'plugin/webui-popover/jquery.webui-popover.min');
 		//'multi-select/multiple-select', 'vendor/jquery.multiple.select', 
 		
		$doc_id						= $this->input->get('rel');
		$this->data['char_mode']	= $this->char_mode;
		
		$this->data['results'] 		= $this->dbmodel->CIQuery("
			SELECT DISTINCT
				AppID, ApplicationStatus.DocID,Verification.ProductCode,ShortProductType,ApplicationNo,PreLoan,PreApproved,convert(nvarchar(10),PreApprovedDate, 120) as PreApprovedDate, 
				[Status], convert(nvarchar(10),StatusDate,120) as StatusDate,CAName,ApproverName,convert(nvarchar(10),CA_ReceivedDocDate,120) as CA_ReceivedDocDate,
				StatusReason, 
				CASE
					WHEN [StatusReason] = 'AIP' THEN 'AIP'
					WHEN [Status] = 'PENDING' AND ISNULL([PreLoan], PreApproved) > 0 THEN 'AIP'
				END [IsAIP],
				ApprovedLoan,TermYear, AFCancelReason, AFCancelReasonOther, DiviateReason, ReceivedEstimateDoc,
				convert(nvarchar(10),[PlanDDSubmit],120) as [PlanDDSubmit],
				CASE 
					WHEN [ShortProductType] = 'Secure' THEN convert(nvarchar(10),DATEADD(DAY, 4, [PlanDDSubmit]),120)
					WHEN [ShortProductType] = 'Clean' THEN convert(nvarchar(10),DATEADD(DAY, 3, [PlanDDSubmit]),120)
					ELSE NULL
				END [AllowReservDate],
				CASE 
					WHEN [PlanDrawdownDate] IS NOT NULL THEN (
						DATEDIFF(DAY, (
							CASE 
								WHEN [ShortProductType] = 'Secure' THEN convert(nvarchar(10),DATEADD(DAY, 4, [PlanDDSubmit]),120)
								WHEN [ShortProductType] = 'Clean' THEN convert(nvarchar(10),DATEADD(DAY, 3, [PlanDDSubmit]),120)
								ELSE NULL
							END), convert(nvarchar(10),PlanDrawdownDate,120) + ' ' + '19:00:00.000'
						)
					)
					ELSE NULL
				END [AllowDiff],
				convert(nvarchar(10),PlanDrawdownDate,120) as PlanDrawdownDate,
				convert(nvarchar(10),DrawdownDate,120) as DrawdownDate,
				DrawdownType,DrawdownBaht,TotalDrawdown,convert(nvarchar(10),ReceivedContactDate,120) as ReceivedContactDate, ContactRemark,
				Diff,CountDay,AppComment, PlanDateUnknown, DrawdownReservation, ApplicationStatus.IsActive 
			FROM [ApplicationStatus]
			LEFT OUTER JOIN [Verification] ON Verification.DocID = ApplicationStatus.DocID
			LEFT OUTER JOIN [MasterProductDropdown] ON Verification.ProductCode = MasterProductDropdown.ProductCode
			LEFT OUTER JOIN [ProductType] ON MasterProductDropdown.ProductTypeID = ProductType.ProductTypeID
			OUTER APPLY (
				SELECT TOP 1
					[CreateByDate] [PlanDDSubmit],
					DATEADD(DAY, 3, [CreateByDate]) [AllowReservDate]
				FROM [PCISEventLogs]
				WHERE [EventProcess] LIKE '%PLAN DRAWDOWN (CONFIRM%'
				AND [PCISEventLogs].[DocID] = ApplicationStatus.DocID
			) [PlanDD]
			WHERE ApplicationStatus.DocID = '".$doc_id."'
		");
		
		// NEW OBJECT ON 23 FEB 2019
		$this->data['pending_cancel_logs'] = $this->dbmodel->CIQuery("
			SELECT TOP 1 * FROM [PCIS].[dbo].[ApplicationPendingCancelLogs]
			WHERE [IsActive] = 'A'
			AND [DocID] = '".$doc_id."'
			ORDER BY [CreateByDate] DESC
		");
		
		$appno = !empty($this->data['results']['data'][0]['ApplicationNo']) ? $this->data['results']['data'][0]['ApplicationNo'] : '';
		$this->data['allow_reserved'] = $this->dbstore->exec_getAllowReserved($appno);
		
		$this->data['getCustInfo'] 	= $this->getCustomerInformation($doc_id);
		$this->data['objPostpone'] 	= $this->getPostReasonLists($doc_id);
		$this->data['objNonAccept'] = $this->getCustCancelReasonLists($doc_id);
		$this->data['dd_history']	= $this->getDrawdownHistory($appno);
		$this->data['user_role']	= $this->getRole($this->authorized[0], $this->branch_code);
		$this->data['cust_income']  = array('data' => array(), 'status' => false, 'msg' => 'application no not found.');
		
		
		
		$official_holiday  = $this->config->item('official holiday');
		$this->data['official_holiday'] = self::onLoadOfficialHoliday($official_holiday);
		
		// View: Retrieve Logs
		$this->data['getDocRetr']	= $this->getDataRetrieveLog($doc_id);
			
 		$this->_renders($this->pages_default, 'customiz');
		 
	}
	
	public function appstatePreview() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$this->pages                = "form/update/process_3/appstate_preview";
		
		$script_version				= '.js?v=005';
		$this->data['stylesheet']	= array('pikaday', 'custom/bsi', 'custom/form', 'custom/tooltip_custom', 'floatmenu/contact-buttons', 'themify-icons', 'webui-popover/jquery.webui-popover');
		$this->data['javascript']	= array('moment.min', 'pikaday', 'vendor/jquery.number.min', 'vendor/jquery.mask.min', 'vendor/jquery.multiple.select', 'vendor/jquery.cookie', 'build/form/process_management/process_3/appstate_validation' . $script_version,
											'plugin/floatmenu/jquery.contact-buttons', 'build/form/process_management/process_3/plugin/preview_floatmenu' . $script_version, 'plugin/webui-popover/jquery.webui-popover.min');
		
		$doc_id						= $this->input->get('rel');
		$this->data['char_mode']	= $this->char_mode;
		
		$this->data['results']   	= $this->dbmodel->CIQuery("
				SELECT
				[Profile].BranchCode, [Profile].Branch, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName, [Profile].Company, [Profile].OwnerName,
				[Profile].BMName, [Profile].Region,
				AState.ApplicationNo, AState.PreLoan, AState.PreApproved, convert(nvarchar(10), AState.PreApprovedDate, 120) as PreApprovedDate, AState.[Status],
				convert(nvarchar(10), AState.StatusDate,120) as StatusDate, AState.CAName, AState.ApproverName, convert(nvarchar(10),AState.CA_ReceivedDocDate,120) as CA_ReceivedDocDate, 
				convert(nvarchar(10), AState.PlanDrawdownDate,120) as PlanDrawdownDate, AState.StatusReason, AState.ApprovedLoan, AState.TermYear,
				convert(nvarchar(10), AState.DrawdownDate, 120) as DrawdownDate, AState.DiviateReason, ReceivedEstimateDoc,
				AState.AFCancelReason, AState.AFCancelReasonOther, AState.DrawdownType, AState.DrawdownBaht, AState.TotalDrawdown,
				convert(nvarchar(10),AState.ReceivedContactDate,120) as ReceivedContactDate, AState.ContactRemark,
				AState.Diff, AState.CountDay, AState.AppComment, AState.PlanDateUnknown, AState.DrawdownReservation, AState.IsActive
				FROM [Profile]
				LEFT OUTER JOIN ApplicationStatus as AState
				ON [Profile].DocID = AState.DocID
				WHERE AState.DocID = '".$doc_id	."'
		");
		
		$this->data['getCustInfo']  = $this->getCustomerInformation($doc_id);
		$this->data['objPostpone'] 	= $this->getPostReasonLists($doc_id);
		$this->data['objNonAccept'] = $this->getCustCancelReasonLists($doc_id);
		$this->data['nonListLive']  = $this->getCancelReasonByCustomer($doc_id);
		$this->data['dd_history']	= $this->getDrawdownHistory($this->data['results']['data'][0]['ApplicationNo']);
		
		// View: Retrieve Logs
		$this->data['getDocRetr']	= $this->getDataRetrieveLog($doc_id);
		
		$this->_renders($this->pages_default, 'customiz');
		 
	}
	
	public function getApplicationDecisionInRetrieve() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
	
		$doc_id						= $this->input->get('rel');
		
		$this->data['results']   	= $this->dbmodel->CIQuery("
										SELECT
										[Profile].BranchCode, [Profile].Branch, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName, [Profile].Company, [Profile].OwnerName,
										[Profile].BMName, [Profile].Region,
										AState.ApplicationNo, AState.PreLoan, AState.PreApproved, convert(nvarchar(10), AState.PreApprovedDate, 120) as PreApprovedDate, AState.[Status],
										convert(nvarchar(10), AState.StatusDate,120) as StatusDate, AState.CAName, convert(nvarchar(10),AState.CA_ReceivedDocDate,120) as CA_ReceivedDocDate,
										convert(nvarchar(10), AState.PlanDrawdownDate,120) as PlanDrawdownDate, AState.StatusReason, AState.ApprovedLoan, AState.TermYear,
										convert(nvarchar(10), AState.DrawdownDate, 120) as DrawdownDate,
										AState.AFCancelReason, AState.AFCancelReasonOther, AState.DrawdownType, AState.DrawdownBaht,
										convert(nvarchar(10),AState.ReceivedContactDate,120) as ReceivedContactDate, AState.ContactRemark,
										AState.Diff, AState.CountDay, AState.AppComment, AState.IsActive
										FROM [Profile]
										LEFT OUTER JOIN ApplicationStatus as AState
										ON [Profile].DocID = AState.DocID
										WHERE AState.DocID = '".$doc_id	."'");
		
		$this->data['getCustInfo']  = $this->getCustomerInformation($doc_id);
		$this->data['char_mode']	= $this->char_mode;
		
		// View: Retrieve Logs
		$this->data['getDocRetr']	= $this->getDataRetrieveLog($doc_id);
		
		$this->pages                = "form/history_form/process_3/decision_form";
		
		$this->data['stylesheet']	= array('pikaday', 'custom/bsi', 'custom/form', 'themify-icons');
		$this->data['javascript']	= array('moment.min', 'pikaday', 'vendor/jquery.number.min', 'vendor/jquery.mask.min', 'vendor/jquery.cookie', 'build/form/process_management/process_3/cappstate', 'build/form/process_management/process_3/appstate_validation');
				
		$this->_renders($this->pages_default, 'customiz');
		
	}
	
    /** Routers */
    public function routers() {
        $this->load->model("dbmodel");
        $this->load->model("dbcustom");
        $this->load->library('effective');
		
        $rel 	= $this->input->get("rel");
        $req    = strtoupper($this->input->get("req"));
        $mode   = $this->input->get("live");
        switch($req) {
            case "P1":
				// 1 = preview, 2 = change - update
                switch($mode) {                    
                    case '2': $this->profileManage(); break;
                    default:
                    case '1': $this->profilePreview(); break;

                }
                
                break;
            case "P2":

                switch($mode) {
                
                	case '1':
                		redirect('management/getDataVerifiedPreview?_='.md5(date('s')).'&state=false&rel='.$rel.'&req='.$req.'&live=1' . '&wrap=' . date('smdsys'));
                		break;
                	case '2': 
                		redirect('management/getDataVerifiedManagement?_='.md5(date('s')).'&state=false&rel='.$rel.'&req='.$req.'&live=2' . '&wrap=' . date('smdsys'));
                		//redirect('management/getPageVerificationManagement?_='.md5(date('s')).'&state=false&rel='.$rel.'&req='.$req.'&live=2' . '&wrap=' . date('smdsys'));                		
                		break;
                }

                break;
            case "P3":

                switch($mode) {
                    case '2': $this->appstateManage(); break;
                    default:
                    case '1': $this->appstatePreview(); break;
                }

                break;
        }

    }
  
    protected function makedirs($dirpath, $mode=0777) {
		return is_dir($dirpath) || mkdir($dirpath, $mode, true);
	}

	private function writelogs($log_path, $log_name, $result) {
		$this->load->library('xml/array2xml');
	
		$this->makedirs($log_path.date("dmy"));
	
		$xml = new DOMDocument();
		$xml = Array2XML::createXML('root_node_name', $result);
		$xml->save($log_path.date("dmy")."/".$log_name.date("His").".xml");
	
	}
	
	private function DocGenerate() {
		$this->load->model("dbmodel");
	
		$checked    = $this->dbmodel->loadData($this->table_masterdoc, "CurrentYear", array("CurrentYear" => date("Y")));
		if($checked['status'] == "false") {
			$result = $this->dbmodel->exec($this->table_masterdoc, array("CurrentYear" => date("Y"), "Runno" => "1"), false, "insert");
			if($result == TRUE)  {
				$doc_id = $this->dbmodel->loadData($this->table_masterdoc, "Runno", array("CurrentYear" => date("Y")));
				return $doc_id['data'][0]['Runno'];
	
			}
			else throw new Exception("Error exception: Table masterdoc is insert missing... ");
	
		} else {
			$doc_id = $this->dbmodel->loadData($this->table_masterdoc, "Runno", array("CurrentYear" => date("Y")));
			return $doc_id['data'][0]['Runno'];
	
		}
	
	}
	
	private function ReActivateGenerate() {
		$this->load->model("dbmodel");
		
		if(empty($this->branch_code)) {
			
			return array(
					"Runno"		=> '',
					"IsCheck"	=> FALSE,
					"msg"		=> "Branch code is empty."				
			);
			
		} else {
		
			$checked    = $this->dbmodel->loadData($this->table_masterrevisit, "BranchCode, [Year]", array("BranchCode" => $this->branch_code, "[Year]" => date("Y")));
			if($checked['status'] == "false") {
				$result = $this->dbmodel->exec($this->table_masterrevisit, array("BranchCode" => $this->branch_code, "[Year]" => date("Y"), "Runno" => "1"), false, "insert");
				if($result == TRUE)  {
					$doc_id = $this->dbmodel->loadData($this->table_masterrevisit, "Runno", array("BranchCode" => $this->branch_code, "[Year]" => date("Y")));
					return array("Runno" => $doc_id['data'][0]['Runno'], "IsCheck" => TRUE, "msg" => "");
						
				}
				else throw new Exception("Error exception: Table ".__function__." is insert missing... ");
				
				
			} else {
				$doc_id = $this->dbmodel->loadData($this->table_masterrevisit, "Runno", array("BranchCode" => $this->branch_code, "[Year]" => date("Y")));
				return array("Runno" => $doc_id['data'][0]['Runno'], "IsCheck" => TRUE, "msg" => "");
			
			}
			
		}
	
	}

    /** Check unique document identify */
	private function checkUniqueDoc($table, $doc_id) {
		$this->load->model("dbmodel");
		$result   =  $this->dbmodel->loadData($table, "DocID", array("DocID" => $doc_id));
		return $result;

	}
	
	private function checkUnique($table, $fields, $condition = array()) {
		$this->load->model("dbmodel");
		$result   =  $this->dbmodel->loadData($table,  $fields, $condition);
		return $result;
	
	}

   
	/** Field Forms Validation */
	public function profileFormValid() {
		$this->load->library("form_validation");
	
		$this->form_validation->set_rules("rmcode", "rm code", "trim|required");
		$this->form_validation->set_rules("rmmobile", "rm mobile", "trim");
		$this->form_validation->set_rules("empname", "rm name", "");
		$this->form_validation->set_rules("bm", "bm name", "");
		$this->form_validation->set_rules("region", "region", "trim");
		$this->form_validation->set_rules("branchcode", "branch code", "trim");
		$this->form_validation->set_rules("branch", "branch", "trim");
	
		$this->form_validation->set_rules("interest", "interest", "");
		$this->form_validation->set_rules("sourceofcustomer", "source of customer", "");
		$this->form_validation->set_rules("sourceoption", "source option", "");
		$this->form_validation->set_rules("ownertype", "owner type", "required");
		$this->form_validation->set_rules("owner", "customer name", "required");
		$this->form_validation->set_rules("company", "company", "");
		$this->form_validation->set_rules("businesstype", "business type", "");
		$this->form_validation->set_rules("business", "business type", "");
		$this->form_validation->set_rules("telephone", "telephone number", "trim");
		$this->form_validation->set_rules("mobile", "mobile number", "trim");
		$this->form_validation->set_rules("downtown", "business downtown", "required");
		$this->form_validation->set_rules("address", "address", "");
		$this->form_validation->set_rules("province", "province", "");
		$this->form_validation->set_rules("district", "district", "");
		$this->form_validation->set_rules("postcode", "postcode", "");
		$this->form_validation->set_rules("channelmodule", "news channel", "required");
		$this->form_validation->set_rules("channel", "channel", "");
		$this->form_validation->set_rules("loanrequest", "request loan", "");
		$this->form_validation->set_rules("duedatestatus", "due status", "");
		$this->form_validation->set_rules("duedate", "due date", "");
		$this->form_validation->set_rules("endevent", "end event", "");
		$this->form_validation->set_rules("referralcode", "referral code", "");
		$this->form_validation->set_rules("cspotential", "Customer Potential", "");
		$this->form_validation->set_rules("remark", "remark", "");
		if($this->form_validation->run() == FALSE) {
			$this->createProfile();
				
		} else {
			return TRUE;
		}
	
	}

	/** Form Exc: Insert Processes
	 *  Application Processes: Profile Process
	**/
	public function profileFormIntial() {
		$this->load->model("dbmodel");
		$this->load->model("dbstore");
		$this->load->library('effective');	

		// Post input handled
		$branchcode     = $this->input->post('branchcode');
		$branch         = $this->input->post('branch');
		$region         = $this->input->post('region');
		$rmcode         = $this->input->post('rmcode');
		$rmname         = $this->input->post('empname');
		$rmmobile       = $this->input->post('rmmobile');
		$bmname         = $this->input->post('bm');
		
		$custtypes		= $this->input->post('register');
		$gencreatedate	= $this->input->post('createdate');
		$interest       = (int)$this->input->post('interest');
		$sourceofcustom = $this->input->post('sourceofcustomer');
		$sourceoption	= $this->input->post('sourceoption');
		$ownertype      = (int)$this->input->post('ownertype');  
		$prefixname     = $this->input->post('prefixname');
		$owner          = $this->input->post('owner');
		$prefixcorp     = $this->input->post('prefixcorp');
		$company        = $this->input->post('company');
		$businesstype   = $this->input->post('businesstype');
		$business       = $this->input->post('business');
		$loan_group		= $this->input->post('loan_group');
		$telephone      = $this->input->post('telephone');
		$mobile         = $this->input->post('mobile');
		$downtown       = $this->input->post('downtown');
		$address        = $this->input->post('address');
		$province       = $this->input->post('province');
		$district		= $this->input->post('district');
		$postcode       = $this->input->post('postcode');
		$channel        = $this->input->post('channelmode');
		$subchannel     = $this->input->post('channelmodule');
		$rqloan         = $this->input->post('loanrequest');
		$referral       = $this->input->post('referralcode');
		$potential      = (int)$this->input->post('potential');
		$remark         = $this->input->post('remark');
		
		$duestatus		= $this->input->post('duedatestatus');
		$duedate		= $this->input->post('duedate');
		$duerepeat		= $this->input->post('endevent');
		$duenote		= $this->input->post('dueoption');
		
		$assign_case	= $this->input->post('assign_case');
		$assignname		= $this->input->post('assignname');
		
		// New 07/01/2015
		$criteria       = $this->input->post('criteria');
		$criteria_rea	= $this->input->post('criteria_reason');
	
		$fieldForms		= array(
			'RMCode'            => $rmcode,
			'RMName'            => $this->effective->set_chartypes($this->char_mode, $rmname),
			'RMMobile'          => $rmmobile,
			'BMName'            => $this->effective->set_chartypes($this->char_mode, $bmname),
			'BranchCode'        => $branchcode,
			'Branch'            => $this->effective->set_chartypes($this->char_mode, $branch),
			'Region'            => $region,
			'CustType'			=> $custtypes,
			'Interest'          => $interest,
			'IsAssignCase'		=> ($assign_case == 'Y') ? $assign_case:NULL,
			'AssignByID'		=> !empty($assignname) ? $assignname:NULL,
			'SourceOfCustomer'  => $this->effective->set_chartypes($this->char_mode, $sourceofcustom),
			'SourceOption'		=> $this->effective->set_chartypes($this->char_mode, $sourceoption),
			'CSPotential'		=> $potential,
			'OwnerType'         => $ownertype,
			"PrefixName"		=> $this->effective->set_chartypes($this->char_mode, $prefixname),
			'OwnerName'         => $this->effective->set_chartypes($this->char_mode, $owner),
			"PrefixCorp"		=> $this->effective->set_chartypes($this->char_mode, $prefixcorp),
			'Company'           => $this->effective->set_chartypes($this->char_mode, $company),
			'BusinessType'      => $this->effective->set_chartypes($this->char_mode, $businesstype),
			'Business'          => $this->effective->set_chartypes($this->char_mode, $business),
			'LoanGroup'			=> $loan_group,
			'Telephone'         => $telephone,
			'Mobile'            => $mobile,
			'Downtown'          => $this->effective->set_chartypes($this->char_mode, $downtown),
			'BusinessLocation' 	=> $this->effective->set_chartypes($this->char_mode, $downtown),
			'Address'           => $this->effective->set_chartypes($this->char_mode, $address),
			'Province'          => $this->effective->set_chartypes($this->char_mode, $province),
			'District'			=> $this->effective->set_chartypes($this->char_mode, $district),
			'Postcode'          => $postcode,
			'Channel'           => $channel,
			'SubChannel'        => $this->effective->set_chartypes($this->char_mode, $subchannel),
			'RequestLoan'       => !empty($rqloan) ? intval(str_replace(',', '', $rqloan)):0,
			'ReferralCode'      => $referral,
			'Remark'            => $this->effective->set_chartypes($this->char_mode, $remark),
			'CreateBy'          => $this->effective->set_chartypes($this->char_mode, $this->name),
			'CreateDate'		=> $this->effective->StandartDateSorter($gencreatedate),
			'IsEnabled'			=> 'A'
		);
	
		$validForm		= $this->profileFormValid();
		if($validForm) {

			if(!empty($rmcode) && !empty($ownertype) && !empty($owner) && !empty($subchannel) && !empty($province) && !empty($downtown) || !empty($telephone) || !empty($mobile) || in_array($rmcode, array('57199'))) {
				$this->is_active = "Y";					
			} else {
				$this->is_active = "P";					
			}
			
			// Document Identification Generate
			$doc_id  = $this->DocGenerate();
			$checked = $this->checkUniqueDoc($this->table_profile, substr(date("Y") + 543, 2).str_pad($doc_id, 6, "0", STR_PAD_LEFT));

			// Check Authorized
			if(in_array($this->role_ad, $this->authorized) || in_array($this->role_admin, $this->authorized) || in_array($this->role_rm, $this->authorized) || in_array($this->role_bm, $this->authorized) || in_array($this->emp_id, array('57251'))) {
				
				// Document unique identify
				if($checked['status'] == 'true') {
					$doc_id     		= (int)$doc_id + 1;
					$this->identify     = substr(date("Y") + 543, 2).str_pad($doc_id, 6, "0", STR_PAD_LEFT);
					$objForms			= array_merge($fieldForms, array("DocID" => $this->identify, 'IsActive' => $this->is_active));
	
				} else {					
					$this->identify     = substr(date("Y") + 543, 2).str_pad($doc_id, 6, "0", STR_PAD_LEFT);
					$objForms			= array_merge($fieldForms, array("DocID" => $this->identify, 'IsActive' => $this->is_active));

				}
				
				if(array_key_exists('DocID', $objForms)) {
					
					$source = $this->dbmodel->data_validation($this->table_profile, "RMCode, Ownername, Company, Province", array("RMCode" => $rmcode, 'BranchCode' => $branchcode, "Ownername"  => $this->effective->set_chartypes($this->char_mode, $owner), "CreateDate" => date('Y-m-d')), false);
									
					if($source == 'TRUE') {
						
						log_message('error', __METHOD__ .' - The Customer are already in pcis. Please your confirm data forms.');
						$this->data['databundled'] = array(
								"status"  => false,
								"access"  => 'databundle',
								"msg"     => "ขออภัย!มีลูกค้าคนนี้อยู่ในระบบแล้ว."
						);
						$this->createProfile();
						
					} else {
						
						$create_profile = $this->dbmodel->exec($this->table_profile, $objForms, false, "insert");
						$create_verify  = $this->dbstore->exec_verification_bundledoc($this->identify, null, 'A', $this->effective->set_chartypes($this->char_mode, $this->name), date('Y-m-d'), 1);
						$create_app   	= $this->dbstore->exec_appstate_bundledoc($this->identify, null, 'A', $this->effective->set_chartypes($this->char_mode, $this->name), date('Y-m-d'), 1);
							
						if($create_profile == TRUE && $create_verify == TRUE && $create_app == TRUE) {
							$DocRunno = $this->dbmodel->exec($this->table_masterdoc, array("Runno" => (int)($doc_id + 1)), array("CurrentYear" => date("Y")), "update");
						
							if($DocRunno == TRUE) {
									
								if(!empty($duestatus) && $duestatus != "N/A") {
										
									date_default_timezone_set('Asia/Bangkok');
									$result = $this->dbmodel->loadData($this->table_duecustom, 'DueReason', array("DueID" => $duestatus));
									$clndrEvent	= array(
											'DocID' 	  => $this->identify,
											'DueID' 	  => (int)$duestatus,
											'Subject'	  => $result['data'][0]['DueReason'],
											'Description' => $this->effective->set_chartypes($this->char_mode, $duenote),
											'StartDate'   => date("Y-m-d H:i:s"),
											'DueDate'	  => $this->effective->StandartDateSorter($duedate)." ".date('H:i:s') ,
											'Active'	  => 'A'
									);
						
									$clndrevent	= $this->dbmodel->exec($this->table_appointment, $clndrEvent, false, 'insert');
									$refid		= $this->dbmodel->loadData($this->table_appointment, 'AppointID', array("DocID" => $this->identify));
									
									// Check Repeat
									if(isset($duerepeat) && $duerepeat == 1) $repeat = 1;
									else $repeat = 0;
									
									// Verification Bundle
									if(empty($criteria)) $check_criteria = '1';
									else $check_criteria = '0';
									$verification = $this->dbmodel->exec($this->table_verification, array("BasicCriteria" => $check_criteria, "CriteriaReasonID" => $criteria_rea), array("DocID" => $this->identify), 'update');
									
									// Appointment 
									if($clndrevent == TRUE) {
										redirect('metro/createProfile?_=').date('s').'&forms=success&cache=false&msg='.true.'&rel='.$this->identify;
											
									} else {
											
										log_message('error', 'method '.__METHOD__ .' not had create calendar planner. please your check object.');
										$this->data['databundled'] = array(
												"status"  => false,
												"access"  => 'databundle',
												"msg"     => "เกิดข้อผิดพลาดในการสร้างตารางนัดหมาย โปรดติดต่อผู้ดูแลระบบ."
										);
										
										$this->createProfile();
											
									}
									
						
								} else {
									
									if(empty($criteria)) $check_criteria = '1';
									else $check_criteria = '0';
									$verification = $this->dbmodel->exec($this->table_verification, array("BasicCriteria" => $check_criteria, "CriteriaReasonID" => $criteria_rea), array("DocID" => $this->identify), 'update');
									
									if($verification == TRUE) {
										redirect('metro/createProfile?_='.date('s').'&forms=success&cache=false&msg='.true.'&rel='.$this->identify);
									}									
									
								}
									
							} else {
									
								log_message('error', 'method '.__METHOD__ .' not had update document identify please your check object.');
								$this->data['databundled'] = array(
										"status"  => false,
										"access"  => 'databundle',
										"msg"     => "เกิดข้อผิดพลาดในการบันทึกข้อมูล โปรดติดต่อผู้ดูแลระบบ."
								);
								$this->createProfile();
									
							}
						
						
						} else {
						
							log_message('error', 'method '.__METHOD__ .' not had inserting please your check object.');
							$this->data['databundled'] = array(
									"status"  => false,
									"access"  => 'databundle',
									"msg"     => "เกิดข้อผิดพลาดในการบันทึกข้อมูล โปรดติดต่อผู้ดูแลระบบ."
							);
							$this->createProfile();
						
						}
						
						
					}
					
					
				} else {
					
					log_message('error', __METHOD__ .' - Object not had key DocID in array. Please your check value in array.');
					$this->data['databundled'] = array(
							"status"  => false,
							"access"  => 'databundle',
							"msg"     => "เกิดข้อผิดพลาดในการสร้างเลขที่เอกสาร โปรดติดต่อผู้ดูแลระบบ."
					);
					$this->createProfile().'&forms=errors&cache=false&msg='.false.'&rel=""';
				}
				
			} else {
				
				$this->data['role_handled'] = array(
						"status"  => false,
						"access"  => 'permission',
						"msg"     => "ขออภัย! คุณไม่มีสิทธิในการสร้างเอกสาร โปรดติดต่อผู้ดูแลระบบ."
				);
				$this->createProfile().'&forms=errors&cache=false&msg='.false.'&rel=""';
				
			}

		}
	}
	
	// Update: Process Management 
	public function profileupdateFormInitial() {
		$this->load->model("dbmodel");
		$this->load->model("dbstore");
		$this->load->library('effective');
		
		$doc_id         = $this->input->post("docid");
		$branchcode     = $this->input->post('branchcode');
		$branch         = $this->input->post('branch');
		$region         = $this->input->post('region');
		$rmcode         = $this->input->post('rmcode');
		$rmname         = $this->input->post('empname');
		$rmmobile       = $this->input->post('rmmobile');
		$bmname         = $this->input->post('bm');
		
		$gencreatedate	= $this->input->post('createdate');
		$interest       = (int)$this->input->post('interest');
		$sourceofcustom = $this->input->post('sourceofcustomer');
		$sourceoption	= $this->input->post('sourceoption');
		$ownertype      = (int)$this->input->post('ownertype');
		$prefixname     = $this->input->post('prefixname');
		$owner          = $this->input->post('owner');
		$prefixcorp     = $this->input->post('prefixcorp');
		$company        = $this->input->post('company');
		$businesstype   = $this->input->post('businesstype');
		$business       = $this->input->post('business');
		$loan_group		= $this->input->post('loan_group');
		$telephone      = $this->input->post('telephone');
		$mobile         = $this->input->post('mobile');
		$downtown       = $this->input->post('downtown');
		$address        = $this->input->post('address');
		$province       = $this->input->post('province');
		$district		= $this->input->post('district');
		$postcode       = $this->input->post('postcode');
		$channel        = $this->input->post('channelmode');
		$subchannel     = $this->input->post('channelmodule');
		$rqloan         = $this->input->post('loanrequest');
		$referral       = $this->input->post('referralcode');
		$potential      = (int)$this->input->post('potential');
		$remark         = $this->input->post('remark');
		
		$duestatus		= $this->input->post('duedatestatus');
		$duedate		= $this->input->post('duedate');
		$duerepeat		= $this->input->post('endevent');
		$duenote		= $this->input->post('dueoption');
		
		$assign_case	= $this->input->post('assign_case');
		$assignname		= $this->input->post('assignname');
		
		// New 07/01/2015
		$criteria       = $this->input->post('criteria');
		$criteria_rea	= $this->input->post('criteria_reason');
		
		
		// Check Repeat
		if(isset($duerepeat) && $duerepeat == 1) $repeat = 1;
		else $repeat = 0;
		
		$fieldForms		= array(
			'RMCode'            => $rmcode,
			'RMName'            => $this->effective->set_chartypes($this->char_mode, $rmname),
			'RMMobile'          => $rmmobile,
			'BMName'            => $this->effective->set_chartypes($this->char_mode, $bmname),
			'BranchCode'        => $branchcode,
			'Branch'            => $this->effective->set_chartypes($this->char_mode, $branch),
			'Region'            => $region,					
			'Interest'          => $interest,
			'SourceOfCustomer'  => $this->effective->set_chartypes($this->char_mode, $sourceofcustom),
			'SourceOption'		=> $this->effective->set_chartypes($this->char_mode, $sourceoption),
			'LoanGroup'			=> $loan_group,
			'CSPotential'		=> $potential,
			'OwnerType'         => $ownertype,
			'IsAssignCase'		=> ($assign_case == 'Y') ? $assign_case:NULL,
			'AssignByID'		=> !empty($assignname) ? $assignname:NULL,
			"PrefixName"		=> $this->effective->set_chartypes($this->char_mode, $prefixname),
			'OwnerName'         => $this->effective->set_chartypes($this->char_mode, $owner),
			"PrefixCorp"		=> $this->effective->set_chartypes($this->char_mode, $prefixcorp),
			'Company'           => $this->effective->set_chartypes($this->char_mode, $company),
			'BusinessType'      => $this->effective->set_chartypes($this->char_mode, $businesstype),
			'Business'          => $this->effective->set_chartypes($this->char_mode, $business),
			'Telephone'         => $telephone,
			'Mobile'            => $mobile,
			'Downtown'          => $this->effective->set_chartypes($this->char_mode, $downtown),
			'BusinessLocation' 	=> $this->effective->set_chartypes($this->char_mode, $downtown),
			'Address'           => $this->effective->set_chartypes($this->char_mode, $address),
			'Province'          => $this->effective->set_chartypes($this->char_mode, $province),
			'District'			=> $this->effective->set_chartypes($this->char_mode, $district),
			'Postcode'          => $postcode,
			'Channel'           => $channel,
			'SubChannel'        => $this->effective->set_chartypes($this->char_mode, $subchannel),
			'RequestLoan'       => !empty($rqloan) ? intval(str_replace(',', '', $rqloan)):0,
			'ReferralCode'      => $referral,
			'Remark'            => $this->effective->set_chartypes($this->char_mode, $remark),
			'CreateDate'		=> $this->effective->StandartDateSorter($gencreatedate),
			'ChangeBy'          => $this->effective->set_chartypes($this->char_mode, $this->name),
			'ChangeDate'        => date('Y-m-d H:i:s')
		);
		
		$validForm		= $this->profileFormValid();
		if($validForm) {
			
			if(!empty($rmcode) && !empty($ownertype) && !empty($owner) && !empty($subchannel) && !empty($province) && !empty($downtown) || !empty($telephone) || !empty($mobile)) {
				$this->is_active = "Y";
					
			} else { $this->is_active = "P"; }
			
			if(empty($doc_id)) {
				
				log_message('error', 'method '.__METHOD__ .'Document identify have missing.');
				$this->writelogs($this->logs."form/profile_process/Missing/", "NUD_", $objForms);
				$this->data['databundled'] = array(
						"status"  => false,
						"access"  => 'databundle',
						"msg"     => "ขออภัย, ไม่สามารถปรับปรุงข้อมูลได้ เนื่องจากเลขที่เอกสารเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง (F5)."
				);
				$this->profileManage();
				
			} else {

				$objForms			= array_merge($fieldForms, array('IsActive' => $this->is_active));
				
				// Check Authorized
				//if(in_array($this->role_ad, $this->authorized) || in_array($this->role_admin, $this->authorized) || in_array($this->role_rm, $this->authorized)) {
				
					$create_profile = $this->dbmodel->exec($this->table_profile, $objForms, array("DocID" => $doc_id), "update");
					if($create_profile == TRUE) {
						
						// New Bundle Data into Verification process
						if(empty($criteria)) $check_criteria = '1';
						else $check_criteria = '0';
						$this->dbmodel->exec($this->table_verification, array("BasicCriteria" => $check_criteria, "CriteriaReasonID" => $criteria_rea), array("DocID" => $doc_id), 'update');
							
						// Appointment Bundled
						if(!empty($duestatus) && $duestatus != "N/A") {
								
							date_default_timezone_set('Asia/Bangkok');
							$result = $this->dbmodel->loadData($this->table_duecustom, 'DueReason', array("DueID" => $duestatus));
						
							$CheckCLNDR = $this->dbmodel->data_validation($this->table_appointment, "DocID", array("DocID" => $doc_id), false);
							if($CheckCLNDR == 'FALSE') {
								
								$clndrEvent	= array(
										'DocID' 	  => $doc_id,
										'DueID' 	  => (int)$duestatus,
										'StartDate'   => date("Y-m-d H:i:s"),
										'DueDate'	  => $this->effective->StandartDateSorter($duedate)." ".date('H:i:s') ,
										'Subject'	  => $result['data'][0]['DueReason'],
										'Description' => $this->effective->set_chartypes($this->char_mode, $duenote)
								);								
								$clndrevent	= $this->dbmodel->exec($this->table_appointment, $clndrEvent, false, 'insert');
								$refid	= $this->dbmodel->loadData($this->table_appointment, 'AppointID', array("DocID" => $doc_id));
													
							} else {
								
								$clndrEvent	= array(
										'DueID' 	  => (int)$duestatus,
										'DueDate'	  => $this->effective->StandartDateSorter($duedate)." ".date('H:i:s') ,
										'Subject'	  => $result['data'][0]['DueReason'],
										'Description' => $this->effective->set_chartypes($this->char_mode, $duenote)
								);
								$clndrevent	= $this->dbmodel->exec($this->table_appointment, $clndrEvent, array("DocID" => $doc_id), 'update');
								$refid		= $this->dbmodel->loadData($this->table_appointment, 'AppointID', array("DocID" =>  $doc_id));
								
							}

							// && $notify == TRUE
							if($clndrevent == TRUE) {
								redirect('metro/profileManage?_='.date('s').'&forms=success&cache=false&msg='.true.'&rel='.$doc_id);

							} else {
				
								log_message('error', 'method '.__METHOD__ .' not had create calendar planner. please your check object.');
								$this->data['databundled'] = array(
										"status"  => false,
										"access"  => 'databundle',
										"msg"     => "เกิดข้อผิดพลาดในการสร้างตารางนัดหมาย โปรดติดต่อผู้ดูแลระบบ."
								);
								$this->profileManage().'&forms=errors&cache=false&msg='.false.'&rel='.$doc_id;
				
							}
							
								
						} else {
							
							redirect('metro/profileManage?_='.date('s').'&forms=success&cache=false&msg='.true.'&rel='.$doc_id);

						}
				
					} else {
				
						log_message('error', 'method '.__METHOD__ .' not had inserting please your check object.');
						$this->data['databundled'] = array(
								"status"  => false,
								"access"  => 'databundle',
								"msg"     => "เกิดข้อผิดพลาดในการบันทึกข้อมูล โปรดติดต่อผู้ดูแลระบบ."
						);
							
						$this->profileManage();
				
					}
				/*
				} else {
				
					$this->data['role_handled'] = array(
							"status"  => false,
							"access"  => 'permission',
							"msg"     => "ขออภัย! คุณไม่มีสิทธิในการสร้างเอกสาร โปรดติดต่อผู้ดูแลระบบ."
					);
				
					$this->profileManage();
				
				}
				*/
			}
			
		}
	
	
	}
	
	// Verification
	private function fnVerificationCancelProcess($doc_id, $rmprocess, $rmprocessdate) {
		$this->load->model("dbmodel");
		$this->load->model('dbstore');
		$this->load->library('effective');
		
		$process_action = $this->effective->get_chartypes($this->char_mode, $rmprocess);
	
		if($process_action === "CANCELBYRM" || $process_action === "CANCELBYCUS") {

			try {
		
				$AppStateLog_Checked = $this->dbmodel->data_validation("AppStateLog", "DocID, AppState_Date", array("DocID" => $doc_id, "AppState_Date" => date('Y-m-d')), false);
			
				
				try {
		
					if($AppStateLog_Checked == 'TRUE'):
						$appstatelog_bundle   = $this->dbstore->exec_appstate_bundlelogs($doc_id, $rmprocess, $this->effective->StandartDateSorter($rmprocessdate), $this->effective->set_chartypes($this->char_mode, $this->prepareInput($this->name)), date('Y-m-d H:i:s'), "Y", 0);
					else:
						$appstatelog_bundle   = $this->dbstore->exec_appstate_bundlelogs($doc_id, $rmprocess, $this->effective->StandartDateSorter($rmprocessdate), $this->effective->set_chartypes($this->char_mode, $this->prepareInput($this->name)), date('Y-m-d H:i:s'), "Y", 1);
					endif;
		
					$collection_state = array(
							"Status"          => $rmprocess,
							"StatusDate"      => $this->effective->StandartDateSorter($rmprocessdate),
							"IsActive"        => "Y",
							"ChangeBy"        => $this->effective->set_chartypes($this->char_mode, $this->prepareInput($this->name)),
							"ChangeDate"      => date("Y-m-d H:i:s")
					);
						
					$this->dbmodel->exec($this->table_applicationstatus, $collection_state, array("DocID" => $doc_id), 'update');
					
				} catch (Exception $e) {
		
					echo 'Caught exception: '.$e->getMessage()."\n";
					echo 'Caught exception: '.$e->getLine()."\n";
					echo 'The Exception: '.$e->$getTrace()."\n";
		
				}
		
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->$getTrace()."\n";
		
			}
		
		} else {
	
			$appstate_checked = $this->dbmodel->loadData($this->table_applicationstatus, "DocID, Status, IsActive", array("DocID" => $doc_id));
			if(!$rmprocess == "Completed" && $appstate_checked['data'][0]['Status'] == "CANCELBYRM" || $appstate_checked['data'][0]['Status'] == "CANCELBYCUS") {
					
				try {
						
					$collection_state = array(
							"Status"          => "",
							"StatusDate"      => NULL,
							"IsActive"        => "",
							"ChangeBy"        => $this->effective->set_chartypes($this->char_mode, $this->prepareInput($this->name)),
							"ChangeDate"      => date("Y-m-d H:i:s")
					);
						
					$this->dbmodel->exec($this->table_applicationstatus, $collection_state, array("DocID" => $doc_id), 'update');
						
				} catch (Exception $e) {
					echo 'Caught exception: '.$e->getMessage()."\n";
					echo 'Caught exception: '.$e->getLine()."\n";
					echo 'The Exception: '.$e->$getTrace()."\n";
						
				}
					
			}
			
		
		}
			
		
	}
	
	public function verificationFormInitialyze() {
		$this->load->model("dbmodel");
		$this->load->model('dbstore');
		$this->load->library('effective');
		
		
		/** Verification */
		$doc_id				   = $this->input->post('doc_id');
		$id_card 			   = $this->input->post('id_card');
		$productprg            = $this->input->post('productprg');
	 // $criteria              = $this->input->post('criteria'); //Move to profile process
		$rmprocess             = $this->input->post('rmprocess');
		$rmprocessdate         = $this->input->post('rmprocessdate');
		$actionnote            = $this->input->post('actionnote');
		$mrta                  = $this->input->post('mrta');
		$emsno                 = $this->input->post('ems');
		$emsdate               = $this->input->post('EMSDate');
		$hqreceivecadocdate	   = $this->input->post('HQReceiveCADate');
		
		
		// new implement	
		$sent2ca			   = $this->input->post('sendto');
		$commitdate			   = $this->input->post('CADate');
		$lack_completion	   = $this->input->post('lackdoc_notsend');
		$lack_completiondate   = $this->input->post('lackdoc_sendDate');
		
		// ReActivate
		$revisitReason		   = $this->input->post('reactivate'); 
		$revisitDate		   = $this->input->post('reactivatePlan');
		
		// Lack List
		$lacklist			   = $this->input->post('lackdocument');
		$lackmissingdel		   = $this->input->post('missing_doc');
		
		/** ncb */
		$ncb_checked           = $this->input->post('checkncb');
		$checkncbdate          = $this->input->post('checkncbdate');
		$mainloan              = $this->input->post('mainloan');
		$loanname              = $this->input->post('loanname');
		$joinloan              = $this->input->post('joinloan');
		$joinloan2             = $this->input->post('joinloan2');
		$joinloan3             = $this->input->post('joinloan3');
		$joinloan4             = $this->input->post('joinloan4');
		$corporate             = $this->input->post('corporate');
		$guarantor             = $this->input->post('guarantor');
		
		$ncbbrnsenddate		   = $this->input->post('BrnNCBDate');
		$ncbhqsenddate		   = $this->input->post('HQNCBDate');
		$hqsendncb2oper		   = $this->input->post('HQSentToOperDate');
		$comment		   	   = $this->input->post('Comment');
			
		
		
		if(isset($sent2ca) && $sent2ca == 1) {
			$sendToCA = '1';
		} else { 
			$sendToCA = '0'; 
		}
		
		/*
		if(isset($criteria) && $criteria == 1) {
			$check_criteria = '1';
		} else { 
			$check_criteria = '0'; 
		}
		
		if($check_criteria == '0') {
			$status = "Y";
	
		} else if($check_criteria == '0' && $ncb_checked == '0') {
			$status = "Y";

		} else if($check_criteria == '1' && $ncb_checked == '2') {
			$status = "Y";

		} else if($check_criteria == '1' && $ncb_checked = '') {
			$status = "N";

		} else if(!empty($checkncbdate) && !empty($loanname) && !empty($rmprocess) && $rmprocess == "Completed" || $rmprocess == "ยกเลิก โดย RM" || $rmprocess == "ยกเลิก โดย ลูกค้า") {
			$status = "Y";
			
		} else {
			$status = "N";
			
		}
		
		*/
		
		if($ncb_checked == '0' || $ncb_checked == '2') {
			$status = "Y";

		} else if($ncb_checked = '') {
			$status = "N";

		} else if(!empty($checkncbdate) && !empty($loanname) && !empty($rmprocess) && $rmprocess == "Completed" || $rmprocess == "CANCELBYRM" || $rmprocess == "CANCELBYCUS") {
			$status = "Y";
			
		} else {
			$status = "N";
			
		}

		$collection = array(
				"ID_Card"			=> $id_card,
				"ProductCode"       => $productprg,
				//"BasicCriteria"     => $check_criteria,
				"RMProcess"         => $this->effective->set_chartypes($this->char_mode, $this->prepareInput($rmprocess)),
				"RMProcessDate"     => $this->effective->StandartDateSorter($rmprocessdate),
				'ActionNote'        => $this->effective->set_chartypes($this->char_mode, $this->prepareInput($actionnote)),
				"MRTA"              => $this->prepareChecked($mrta),
				"EMSNo"             => $this->prepareInput($emsno),
				"EMSDate"           => $this->effective->StandartDateSorter($emsdate),
				"HQReceiveCADocDate"=> $this->effective->StandartDateSorter($hqreceivecadocdate),
				"SentDocToCA"		=> $this->prepareChecked($sendToCA),
				"SentToCADate"		=> $this->effective->StandartDateSorter($commitdate),
				"CompletionDoc"		=> $this->prepareChecked($lack_completion),
				"CompletionDocDate"	=> $this->effective->StandartDateSorter($lack_completiondate),
				"IsActive"          => $status,
				"ChangeBy"          => $this->effective->set_chartypes($this->char_mode, $this->prepareInput($this->name)),
				"ChangeDate"        => date("Y-m-d H:i:s")
		);
		
		
		$verification = $this->dbmodel->exec($this->table_verification, $collection, array("DocID" => $doc_id), 'update');
		if($verification == TRUE) {
			
			$verified_id = $this->dbmodel->loadData($this->table_verification, "VerifyID", array("DocID" => $doc_id));
		
			$ncb  = array(
					"VerifyID"          	=> $verified_id['data'][0]['VerifyID'],
					"CheckNCB"          	=> $this->input->post('checkncb'),
					"CheckNCBDate"      	=> $this->effective->StandartDateSorter($checkncbdate),
					"MainLoan"          	=> $this->prepareChecked($mainloan),
					"JoinLoan"          	=> $this->prepareChecked($joinloan),
					"JoinLoan2"         	=> $this->prepareChecked($joinloan2),
					"JoinLoan3"         	=> $this->prepareChecked($joinloan3),
					"JoinLoan4"         	=> $this->prepareChecked($joinloan4),
					"Corporation"       	=> $this->prepareChecked($corporate),
					"Guarantor"         	=> $this->prepareChecked($guarantor),
					"MainLoanName"     		=> $this->effective->set_chartypes($this->char_mode, $this->prepareInput($loanname)),
					"BrnSentNCBDate" 		=> $this->effective->StandartDateSorter($ncbbrnsenddate),
					"HQGetNCBDate" 			=> $this->effective->StandartDateSorter($ncbhqsenddate),
					"HQSentNCBToOperDate" 	=> $this->effective->StandartDateSorter($hqsendncb2oper),
					"Comments" 				=> !empty($comment) ? $this->effective->set_chartypes($this->char_mode, $comment):null
			);
			
			$verified_checked = $this->dbmodel->data_validation($this->table_ncb, "VerifyID", array("VerifyID" => $verified_id['data'][0]['VerifyID']), false);
			if($verified_checked == 'TRUE') {
				$ncbstate   = $this->dbmodel->exec($this->table_ncb, $ncb, array("VerifyID" => $verified_id['data'][0]['VerifyID']), 'update');
			
			} else {
				$ncbstate   = $this->dbmodel->exec($this->table_ncb, $ncb, false, 'insert');
			
			}


			$pn_draft 	    = $rmprocess.' - '.$this->name;
			$processName    = $this->effective->set_chartypes($this->char_mode, $pn_draft);
			$rmLog_checked 	= $this->dbmodel->data_validation($this->table_rmprocesslog, "VerifyID, ProcessDate, ProcessName", 
								  array("VerifyID" 	   => $verified_id['data'][0]['VerifyID'],
								  		"ProcessName"  => $processName,
								  		"ProcessDate"  => date('Y-m-d')), false);
			try {
				
				if($rmLog_checked == 'TRUE') {
					$rmlog_bundle   = $this->dbstore->exec_rmlogs($verified_id['data'][0]['VerifyID'], $processName, date('Y-m-d H:i:s'), 0);
						
				} else {
					$rmlog_bundle   = $this->dbstore->exec_rmlogs($verified_id['data'][0]['VerifyID'], $processName, date('Y-m-d H:i:s'), 1);
						
				}
				
			} catch(Exception $e) {
				
				echo 'Caught exception: '.$e->getMessage()."\n";			
				echo 'Caught exception: '.$e->getLine()."\n";			
				echo 'The Exception: '.$e->$getTrace()."\n";
				
				
			}
		
			// Module 3: Implement update are process three in application process
			
			// Unlist Missing doc
			if(!empty($lackmissingdel[0])): $this->checkOutMissingDoc($lackmissingdel, $verified_id['data'][0]['VerifyID']); endif;
			
			// The verificaiton will cancel process 3 when was rm process had cancel by RM. system will been cancel process 3 for completed a application process.
			$canceloptional = $this->fnVerificationCancelProcess($doc_id, $this->effective->set_chartypes($this->char_mode, $rmprocess), $rmprocessdate);
			
			// CONTINUE STATEMENT PROCESSES 					
			if($ncbstate == TRUE && $rmlog_bundle == TRUE) {
				
				if(empty($revisitReason) || $revisitReason == "") {
					
					if(empty($lacklist[0])) {
							
						//Workflow Completed
						redirect('metro/verificationManage?_='.date('s').'&forms=success&cache=false&msg='.true.'&rel='.$doc_id.'&cache='.date('s'));
							
					} else {
					
						for($i=0; $i < count($lacklist); $i++) {
								
							$lacked[] = array(
									"VerifyID" 		=> $verified_id['data'][0]['VerifyID'],
									"LackID"   		=> $lacklist[$i],
									"LackListActive" => "A"
							);
								
							$lackist_checked 		= $this->dbmodel->data_validation($this->table_lacklist, "VerifyID, LackID", array("VerifyID" => $verified_id['data'][0]['VerifyID'], "LackID" => $lacklist[$i]), false);
							if($lackist_checked == 'TRUE') {
								$lackist_bundle   = $this->dbmodel->exec($this->table_lacklist, $lacked[$i], array("VerifyID" => $verified_id['data'][0]['VerifyID'], "LackID" => $lacklist[$i]), 'update');
									
							} else {
								$lackist_bundle   = $this->dbmodel->exec($this->table_lacklist, $lacked[$i], false, 'insert');
									
							}
								
						}
					
						if($lackist_bundle) {
							redirect('metro/verificationManage?_='.date('s').'&forms=success&cache=false&msg='.true.'&rel='.$doc_id.'&cache='.date('s'));
						}
					
					}
					
					
				} else {
					
					$revisit  	 = $this->ReActivateGenerate();
					$revisit_id	 = $this->branch_code.'-'.substr(date('Y'), 2).str_pad($revisit['Runno'], 3, "0",  "STR_PAD_LEFT");
					$checked 	 = $this->checkUnique($this->table_reactivate, "RevisitRef, BranchCode", array("RevisitRef" => $revisit_id, "BranchCode" => $this->branch_code));
					
					$ReActivate	= array(
							"VerifyID" 			=> (int)$verified_id['data'][0]['VerifyID'],
							"RevisitID" 		=> (int)$revisitReason,
							"RevisitDate" 		=> $this->effective->StandartDateSorter($revisitDate),
							"BranchCode" 		=> $this->branch_code,
							"CreateRevisitDate" => date('Y-m-d H:i:s')
					);
					
					if($checked['status'] == 'true') {
					
						$revisitno     		= (int)$revisit['Runno'] + 1;
						$revisit_ref  = $this->branch_code.'-'.substr(date('Y'), 2).str_pad($revisitno, 3, "0",  "STR_PAD_LEFT");
						$objForms			= array_merge($ReActivate, array("RevisitRef" => $revisit_ref));
					
					} else {
					
						$revisit_ref  = $this->branch_code.'-'.substr(date('Y'), 2).str_pad($revisit['Runno'], 3, "0",  "STR_PAD_LEFT");
						$objForms			= array_merge($ReActivate, array("RevisitRef" => $revisit_ref));
					
					
					}
					
					if(array_key_exists('RevisitRef', $objForms)) {
							
						$reactivate_checked = $this->dbmodel->data_validation($this->table_reactivate, "VerifyID", array("VerifyID" => $verified_id['data'][0]['VerifyID']), false);
						if($reactivate_checked == 'TRUE') {
							$revisit_bundle   = $this->dbmodel->exec($this->table_reactivate, $objForms, array("VerifyID" => $verified_id['data'][0]['VerifyID']), 'update');
						
						} else {
							$revisit_bundle   = $this->dbmodel->exec($this->table_reactivate, $objForms, false, 'insert');
						
						}
						
						// Appointment
						if($revisit_bundle == TRUE) {

							if(empty($lacklist[0])) {
							
								//Workflow Completed
								redirect('metro/verificationManage?_='.date('s').'&forms=success&cache=false&msg='.true.'&rel='.$doc_id);
							
							} else {
								
								for($i=0; $i < count($lacklist); $i++) {
									
									$lacked[] = array(
										"VerifyID" 		=> $verified_id['data'][0]['VerifyID'],
										"LackID"   		=> $lacklist[$i],
										"LackListActive" => "A"
									);
									
									$lackist_checked 		= $this->dbmodel->data_validation($this->table_lacklist, "VerifyID, LackID", array("VerifyID" => $verified_id['data'][0]['VerifyID'], "LackID" => $lacklist[$i]), false);
									if($lackist_checked == 'TRUE') {
										$lackist_bundle   = $this->dbmodel->exec($this->table_lacklist, $lacked[$i], array("VerifyID" => $verified_id['data'][0]['VerifyID'], "LackID" => $lacklist[$i]), 'update');
									
									} else {
										$lackist_bundle   = $this->dbmodel->exec($this->table_lacklist, $lacked[$i], false, 'insert');
									
									}	
									
								}
								
								if($lackist_bundle) {
									redirect('metro/verificationManage?_='.date('s').'&forms=success&cache=false&msg='.true.'&rel='.$doc_id);
									
								}  else {
							
									log_message('error', __METHOD__ .' - Object not had lack list at processing have re-activate in array. Please your check value in array.');
									$this->data['databundled'] = array(
											"status"  => false,
											"access"  => 'databundle',
											"msg"     => "เกิดข้อผิดพลาดในการสร้างเลขที่เอกสาร โปรดติดต่อผู้ดูแลระบบ."
									);
									
									$this->verificationManage();
									
								}
								
							}
							
						} else {
							
							log_message('error', 'method '.__METHOD__ .' not had inserting please your check object.');
							$this->data['databundled'] = array(
									"status"  => false,
									"access"  => 'databundle',
									"msg"     => "เกิดข้อผิดพลาดในการบันทึกข้อมูล โปรดติดต่อผู้ดูแลระบบ."
							);
							
							$this->verificationManage();
														
						}
						
					} else {
							
						log_message('error', __METHOD__ .' - Object not had key Re-Activate Referance ID in array. Please your check value in array.');
						$this->data['databundled'] = array(
								"status"  => false,
								"access"  => 'databundle',
								"msg"     => "เกิดข้อผิดพลาดในการสร้างเลขที่เอกสาร โปรดติดต่อผู้ดูแลระบบ."
						);
						$this->verificationManage();
					}
					
				}
				
			} else {
			
				log_message('error', 'method '.__METHOD__ .' not had create ncb, rmprocess logs. please your check object.');
				$this->data['databundled'] = array(
						"status"  => false,
						"access"  => 'databundle',
						"msg"     => "เกิดข้อผิดพลาดในการปรับปรุงข้อมูลเรื่องเครดิตบูโรเบื้องต้น โปรดติดต่อผู้ดูแลระบบ."
				);
				$this->verificationManage();
			
			}		
			
		} else {
			
			log_message('error', 'method '.__METHOD__ .' not had inserting please your check object.');
			$this->data['databundled'] = array(
					"status"  => false,
					"access"  => 'databundle',
					"msg"     => "เกิดข้อผิดพลาดในการบันทึกข้อมูล โปรดติดต่อผู้ดูแลระบบ."
			);
				
			$this->verificationManage();
			
		}
		
	}
	
	private function checkOutMissingDoc($row_id, $verify_id) {
		$this->load->model('dbmodel');
		
		$filter = array();
		for($i=0; $i < count($row_id); $i++):
		
			if(empty($row_id[$i])):
				continue;
			else:
				array_push($filter, array("LackListActive" => 'N'));
			endif;
		endfor;
		
		$i=0;
		foreach($filter as $index => $value):
			
			$pass = $this->dbmodel->exec($this->table_lacklist, $filter[$index], array("VerifyID" => $verify_id, "RowID" => $row_id[$index]), 'update');
			$i++;
			
		endforeach;
		
	}
	
	public function docmentRefunds() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$doc_id                = $this->input->post("doc_id");
		$docno                 = $this->input->post('docno');
		$doctype               = $this->input->post('doctype');
		$docnote               = $this->input->post('docoption');
		$docdate               = $this->input->post('doc_gendate');
		$hqreceive             = $this->input->post('hqreceivedoc');
		$docfromca             = $this->input->post('docfromca');
		$adminbranch           = $this->input->post('adminbranch');
		
		$createby              = $this->input->post('actor_gendate');
		$hqreceiveby           = $this->input->post('actor_hqreceivedoc');
		$hqfromcaby            = $this->input->post('actor_docfromca');
		$adminby               = $this->input->post('actor_adminbranch');
		
		$collection = array(
				"DocNo"             => $docno,
				"DocType"           => $doctype,
				"DocNote"			=> $docnote,
				"CreateBy"          => $createby,
				"CreateDate"        => $docdate,
				"HQGetDocBy"        => $hqreceiveby,
				"HQGetDocDate"      => $hqreceive,
				"HQGetDocFromCABy"  => $hqfromcaby,
				"HQGetDocFromCA"    => $docfromca,
				"BranchGetDocBy"    => $adminby,
				"BranchGetDocDate"  => $adminbranch
		);
		
		$filter = array();
        for($i=0; $i < count($collection['DocNo']); $i++) {

        	if(empty($collection['DocType'][$i]) || $collection['DocType'][$i] == "N/A") {
            	continue;

            } else {

            	array_push($filter, array(
                	"DocID" 			=> $doc_id, 
                    "DocNo" 			=> $collection['DocNo'][$i],  
                    "DocType" 			=> $this->effective->set_chartypes($this->char_mode, $collection['DocType'][$i]),
                    "DocNote"			=> $this->effective->set_chartypes($this->char_mode, $collection['DocNote'][$i]),
                    "CreateBy" 			=> $this->effective->set_chartypes($this->char_mode, $collection['CreateBy'][$i]), 
                    "CreateDate" 		=> $this->effective->StandartDateSorter($collection['CreateDate'][$i]),
                    "HQGetDocBy" 		=> $this->effective->set_chartypes($this->char_mode, $collection['HQGetDocBy'][$i]),  
                    "HQGetDocDate" 		=> $this->effective->StandartDateSorter($collection['HQGetDocDate'][$i]),
                    "HQGetDocFromCABy"  => $this->effective->set_chartypes($this->char_mode, $collection['HQGetDocFromCABy'][$i]), 
                    "HQGetDocFromCADate"=> $this->effective->StandartDateSorter($collection['HQGetDocFromCA'][$i]),
                    "BranchGetDocBy" 	=> $this->effective->set_chartypes($this->char_mode, $collection['BranchGetDocBy'][$i]), 
                    "BranchGetDocDate"  => $this->effective->StandartDateSorter($collection['BranchGetDocDate'][$i])
                ));

            }

         }
         
         $i=0;
         foreach($filter as $index => $value) {
         	
         	$filte_checked = $this->dbmodel->data_validation($this->table_docrefund, "DocID", array("DocID" => $doc_id, "DocNo" => $filter[$index]['DocNo']), false);
         	if($filte_checked == 'TRUE') {
         		$pass = $this->dbmodel->exec($this->table_docrefund, $filter[$index], array("DocID" => $doc_id, "DocNo" => $filter[$index]['DocNo']), 'update');
         	
         	} else {
         		$pass = $this->dbmodel->exec($this->table_docrefund, $filter[$index], false, 'insert');
         		
         	}
         	$i++;
         	 
         }
         
         if($pass == TRUE) {
         	redirect('metro/verificationManage?_='.date('s').'&forms_doc=success&cache=false&msg='.true.'&rel='.$doc_id);
         
         } else {
         
         	log_message('error', 'method '.__METHOD__ .' not had create document refund at processes beginner. please your check object.');
         	$this->writelogs($this->logs."form/verification_process/Missing/", "DocRefundError_Handled_", $collection);
         	$this->data['databundled_doc'] = array(
         			"status"  => false,
         			"access"  => 'databundle',
         			"msg"     => "เกิดข้อผิดพลาดในการบันทึกข้อมูลเอกสารขอคืน  โปรดติดต่อผู้ดูแลระบบ [Bx01-1]."
         	);    
         	$this->verificationManage();
         
         }
		
	}
	
	// ApplicationStatus
	public function applicationStatusFormInitialyze() {
		$this->load->model("dbmodel");
		$this->load->model("dbstore");
		$this->load->library('effective');
		
		date_default_timezone_set("Asia/Bangkok");
	
		$doc_id         	   = $this->input->post("docid");
		$applicationno         = $this->input->post('appno');
		$caname                = $this->input->post('caname');
		$approvername		   = $this->input->post('approvername');
		$ca_received_docdate   = $this->input->post('careceived_date');
		$preapproved           = $this->prepareChecked($this->input->post('preapproved'));
		$preloan			   = $this->input->post('preloan');
		$approveddate          = $this->input->post('approveddate');
		$statuses              = strtoupper($this->input->post('status'));
		$statusdate            = $this->input->post('statusdate');
		$obj_reason            = $this->input->post('objreason');
		
		
		$after_cancel		   = $this->input->post('cancel_reason');
		$after_cancelother     = $this->input->post('afcancel_other');
		$deviate_code		   = $this->input->post('deviate_code');
		
		//$pendingreason         = $this->input->post('pendingreason');			
		//$rjreason              = $this->input->post('rjreason');
		//$ccreason              = $this->input->post('ccreason');
		
		$amountapproved        = intval(str_replace(',', '', $this->input->post('approvedamount')));
		$termyear              = $this->input->post('termyear');
		
		$drawdownplat		   = $this->input->post('plandrawdowndate');
		$drawdownplat_draft	   = $this->input->post('plandrawdowndate_temp'); // Plan DD by Ref.
		$drawdown_reserv	   = $this->input->post('drawdown_reserv');
		
		$postpone_planreason   = $this->input->post('postpone_planreason');
		$postpone_otherreason  = $this->input->post('postpone_otherdesc');
		$postpone_unknown	   = $this->input->post('unknown_state');

		$drawdowndate          = $this->input->post('drawdowndate');
		$drawdowntype          = $this->input->post('drawdowntype');
		$drawdownamount        = intval(str_replace(',', '', $this->input->post('drawdownamount')));
		$contactdate		   = $this->input->post('contactdate');
		$contactremark		   = $this->input->post('contact_comment');
		$diff                  = intval(str_replace(',', '', $this->input->post('diff')));
		$countdaye             = $this->input->post('countday');
		$comment			   = $this->input->post('comment');
		
		// NEW FIELD ON 23 FEB 2019
		$pending_cancel_check  = $this->input->post('pending_cancel_check');
		$pending_cancel 	   = $this->input->post('pending_cancel');
		
		if(!empty($pending_cancel[0])):
			$pending_cancel_data = implode(",", $pending_cancel);
		else:
			$pending_cancel_data = NULL;
		endif;
		
		
		$status = '';
		switch($statuses) {
			case 'APPROVED':
				if(!empty($applicationno) && !empty($statuses) && !empty($statusdate) && !empty($amountapproved)) {
					$status = "Y";
				} 
				else if(!empty($applicationno) && !empty($statuses) && !empty($statusdate) && !empty($after_cancel) || !empty($applicationno) && !empty($after_cancel)) {
					$status = "Y";
				}
				else {
					$status = "N";
				}					
				break;
			case 'REJECT':
				if(!empty($applicationno) && !empty($statuses) && !empty($statusdate)):
					$status = "Y";
				else:
					$status = "N";
				endif;
				break;
			case 'CANCEL':
				if(!empty($applicationno) && !empty($statuses) && !empty($statusdate)):
					$status = "Y";
				else:
					$status = "N";
				endif;
				break;
			case 'CANCELBYRM':
			case 'CANCELBYCUS':
				if(!empty($statuses) && !empty($statusdate)):
					$status = "Y";
				else:
					$status = "N";
				endif;
				break;
			case '':
			default:
				
				if(!empty($after_cancel)):
					$status = "Y";
				else:
					$status = "N";
				endif;
			
				break;
		
		}
		
		if(!empty($after_cancel[0])):
			$cc_afterreason  = implode(",", $after_cancel);			
		 else:
			$cc_afterreason  = NULL;
		endif;
			
		if(!empty($cc_afterreason)):
			$status_stack = 'CANCELBYCUS';
			$reason_stack = 'Cancel after approved';
		else:
			$status_stack = $this->prepareInput($statuses);
			$reason_stack = $this->effective->set_chartypes($this->char_mode, $obj_reason);
		endif;
		
		$cc_afterotherreason = !empty($after_cancelother) ? $this->effective->set_chartypes($this->char_mode, $after_cancelother):NULL; 
		$drawdown_plandate	 = !empty($drawdownplat) ? $this->effective->StandartDateSorter($drawdownplat):NULL;
		$drawdown_booking	 = !empty($drawdown_reserv) ? $drawdown_reserv:'N';
		
		$collection = array(
			"ApplicationNo"   		=> $this->prepareInput($applicationno),
			"PreApproved"    	 	=> $preapproved,
			"PreLoan"		  		=> intval(str_replace(',', '', $preloan)),
			'PreApprovedDate' 		=> $this->effective->StandartDateSorter($approveddate),
			"Status"         		=> $status_stack,
			"StatusDate"      		=> $this->effective->StandartDateSorter($statusdate),
			"StatusReason"    		=> $reason_stack,
				
			"AFCancelReason"		=> $cc_afterreason,
			"AFCancelReasonOther"	=> $cc_afterotherreason,
			"DiviateReason"			=> $deviate_code,

			"ApprovedLoan"    		=> str_replace(',', '', $amountapproved),
			"TermYear"        		=> $this->prepareInput($termyear),
				
			"PlanDrawdownDate"		=> ($pending_cancel_check == 1 || $pending_cancel_check == 'Y') ? null : $drawdown_plandate,
			"PlanDateUnknown"		=> !empty($postpone_unknown) ? $postpone_unknown:NULL,
			"DrawdownReservation"	=> $drawdown_booking,
			
			"DrawdownDate"    		=> $this->effective->StandartDateSorter($drawdowndate),
			"DrawdownType"    		=> $this->effective->set_chartypes($this->char_mode, $this->prepareInput($drawdowntype)),
			"DrawdownBaht"    		=> str_replace(',', '', $drawdownamount),
			"ReceivedContactDate" 	=> $this->prepareInput($this->effective->StandartDateSorter($contactdate)),
			"ContactRemark"			=> $this->effective->set_chartypes($this->char_mode, $contactremark),
			"CAName"          		=> $this->effective->set_chartypes($this->char_mode, $this->prepareInput($caname)),
			"ApproverName"			=> $this->effective->set_chartypes($this->char_mode, $this->prepareInput($approvername)),
			"CA_ReceivedDocDate"	=> $this->effective->StandartDateSorter($ca_received_docdate),
			"Diff"            		=> (int)str_replace(',', '', $diff),
			"CountDay"       		=> (int)$countdaye,
			"AppComment"	  		=> $this->effective->set_chartypes($this->char_mode, $comment),
			"IsActive"        		=> $status,
			"ChangeBy"        		=> $this->effective->set_chartypes($this->char_mode, $this->prepareInput($this->name)),
			"ChangeDate"      		=> date("Y-m-d H:i:s")
		);
		
		// NEW OBJECT 23 FEB 2019
		$pending_cancel_arr = array(
			'DocID'	=> $doc_id,
			'PendingCancelStatus'	=> $pending_cancel_check,
			'PendingCancelReason'	=> $pending_cancel_data,
			'IsActive'				=> 'A',
			'CreateByID'			=> $this->emp_id,
			'CreateByName'        	=> $this->effective->set_chartypes($this->char_mode, $this->prepareInput($this->name)),
			'CreateByDate'      	=> date("Y-m-d H:i:s")
		);		

		// UPDATE VERIFICATION IN CUSTOMER CANCEL PART.		
		if(!empty($after_cancel[0])):
		
			// Cancel Reason into logs
			$this->writeCustomerCancelReasonLogs($doc_id, array("RMProcess" => 'NONACCEPT', "RMProcessDate" => date('Y-m-d'), "RMProcessReason" => $after_cancel, "OtherReason" => $after_cancelother));
		
			$this->db_env = $this->config->item('database_env');
			if($this->db_env == 'production') {
				$app_info = $this->dbmodel->loadData($this->table_applicationstatus, 'ApplicationNo', array("DocID" => $doc_id));
				$app_num = !empty($app_info['data'][0]['ApplicationNo']) ? $app_info['data'][0]['ApplicationNo']:'';
				if(!empty($app_info['data'][0]['ApplicationNo'])):
				$this->dbstore->exec_defendsuspend($app_num);
				endif;
			}
			
		endif;
		
		if(!empty($drawdown_plandate)) {
		
			$data_verify		 = $this->dbmodel->data_validation('PCISEventLogs', '*', array('DocID'	=> $doc_id, 'EventProcess' => 'PLAN DRAWDOWN (CONFIRM '. $drawdown_plandate .')'), false);
			if($data_verify == 'FALSE') {
				$event_logs 		 = array(
					'DocID'			=> $doc_id,
					'ApplicationNo' => $this->prepareInput($applicationno),
					'EventProcess'	=> 'PLAN DRAWDOWN (CONFIRM '. $this->effective->StandartDateRollback($drawdown_plandate) .')',
					'CreateByID'	=> $this->emp_id,
					'CreateByName'	=> $this->effective->get_chartypes($this->char_mode, $this->name),
					'CreateByDate'	=> date('Y-m-d H:i:s')
				);
					
				$result = $this->dbmodel->exec('PCISEventLogs', $event_logs, false, 'insert');
			}
			
		}

		if(!empty($drawdownplat) && ($drawdown_reserv === 'Y')) {
			//if(empty($drawdowndate))
				//$this->drawdownTemplateInsert($this->prepareInput($applicationno), $drawdown_plandate, $drawdown_booking, $doc_id);
			//endif;
		}		

		if(!empty($postpone_planreason[0])):
			//if($postpone_unknown == 'Y') { $this->dbstore->exec_drawdownTemplateDelete($this->prepareInput($applicationno)); }
			$this->writePostponeReasonlog($doc_id, $postpone_planreason, $postpone_otherreason, array($drawdownplat_draft, $drawdownplat));
		endif;
		
		// NEW STATEMENET 23 FEB 2019
		if($pending_cancel_check == 1 || $pending_cancel_check == 'Y') {
			
			$this->dbmodel->exec('ApplicationPendingCancelLogs', $pending_cancel_arr, false, 'insert');
			
			
			/* Action 
			$this->dbmodel->exec("ActionNote", array(
				"DocID" 		 => $doc_id,
				"ActionNote" 	 => '#' . date('d/m') . ' ' . $this->effective->set_chartypes($this->char_mode, $pending_cancel),
				"ActionNoteBy"	 => $this->emp_id,
				"ActionName"	 => $this->effective->set_chartypes($this->char_mode, $this->name),
				"ActionNoteDate" =>  date('Y-m-d H:i:s'),
				"IsActive"		 => 'A'
			), false, 'insert');
			*/
		}
			
		
		// UPDATE IN APPLICATION STATUS
		$appno_checked  = $this->dbmodel->data_validation('ApplicationStatus', '*', array('ApplicationNo' => $applicationno), false);
		if($appno_checked == 'FALSE') {
			
			$appstate     = $this->dbmodel->exec($this->table_applicationstatus, $collection, array("DocID" => $doc_id), 'update');
			$this->dbstore->exec_appstate_bundlelogs($doc_id, $this->prepareInput($statuses), $this->effective->StandartDateSorter($statusdate), $this->effective->set_chartypes($this->char_mode, $this->prepareInput($this->name)), date('Y-m-d H:i:s'), "Y", 1);
			
			// Action Note Bundled
			//$action_logs = $this->setProThirdAppendToActionNoteLog($doc_id, $this->prepareInput($statuses), array($obj_reason, $amountapproved), $statusdate);
				
			if($appstate == TRUE) {
				redirect('metro/appstateManage?_='.date('s').'&forms=success&cache=false&msg='.true.'&rel='.$doc_id.'&checked=false');
			
			} else {
			
				log_message('error', 'method '.__METHOD__ .' not had inserting please your check object.');
				$this->data['databundled'] = array(
						"status"  => false,
						"access"  => 'databundle',
						"msg"     => "เกิดข้อผิดพลาดในการบันทึกข้อมูล โปรดติดต่อผู้ดูแลระบบ."
				);
					
				$this->appstateManage();
			
			}
			
		} else {
			
			$appno_update  = $this->dbmodel->data_validation('ApplicationStatus', '*', array('ApplicationNo' => $applicationno, 'DocID' => $doc_id), false);
			if($appno_update == 'TRUE'):
			
				$appstate     = $this->dbmodel->exec($this->table_applicationstatus, $collection, array("DocID" => $doc_id), 'update');
				$this->dbstore->exec_appstate_bundlelogs($doc_id, $this->prepareInput($statuses), $this->effective->StandartDateSorter($statusdate), $this->effective->set_chartypes($this->char_mode, $this->prepareInput($this->name)), date('Y-m-d H:i:s'), "Y", 1);
				
				// Action Note Bundled
				//$action_logs = $this->setProThirdAppendToActionNoteLog($doc_id, $this->prepareInput($statuses), array($obj_reason, $amountapproved), $statusdate);

				$flag = ($drawdown_reserv == 'Y') ? 'Y':'N';	
				if($appstate == TRUE) {
					redirect('metro/appstateManage?_='.date('s').'&forms=success&cache=false&msg='.true.'&rel='.$doc_id.'&checked=false&ddflag='.$flag);
					
				} else {
				
					log_message('error', 'method '.__METHOD__ .' not had inserting please your check object.');
					$this->writelogs($this->logs."form/applicationstatus_process/DataBundled/", "data_", $objForms);
					$this->data['databundled'] = array(
							"status"  => false,
							"access"  => 'databundle',
							"msg"     => "เกิดข้อผิดพลาดในการบันทึกข้อมูล โปรดติดต่อผู้ดูแลระบบ."
					);
						
					$this->appstateManage();
				
				}
				
			else:
				redirect('metro/appstateManage?_='.date('s').'&forms=false&cache=false&msg='.true.'&rel='.$doc_id.'&checked=unique');
			endif;
			
		}
	
	}
	
	public function drawdownTemplateInsert($appno, $plan_dd, $dd_reserv, $doc_id) {
		if(!empty($appno)) {
			date_default_timezone_set("Asia/Bangkok");
			$event_logs = array(
					"DocID"  		=> $doc_id,
					"ApplicationNo" => $appno,
					"EventProcess"  => 'DRAWDOWN_RESERV',
					'CreateByID'	=> $this->emp_id,
					'CreateByName'	=> $this->effective->get_chartypes($this->char_mode, $this->name),
					'CreateByDate'	=> date('Y-m-d H:i:s')
			);
			
			$this->dbmodel->exec('PCISEventLogs', $event_logs, false, 'insert');
			
			if(($dd_reserv === 'Y') && !empty($plan_dd)):
				if($plan_dd >= date('Y-m-d')) {
					$this->dbstore->exec_drawdownTemplateInsert($appno, $plan_dd, $this->emp_id, $this->effective->set_chartypes($this->char_mode, $this->name));
				}				
			endif;
		}
		
	}

	public function writePostponeReasonlog($doc_id, $postpone_planreason, $postpone_otherreason, $date_plan = array()) {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$postpone = array(
				"DocID"			=> $doc_id,
				"OriginalPlan"	=> $this->effective->StandartDateSorter($date_plan[0]) . ' ' . date('H:i:s'),
				"NewPlan"		=> $this->effective->StandartDateSorter($date_plan[1]) . ' ' . date('H:i:s'),
				"IsActive"		=> 'A',
				"CreateBy"		=> $this->effective->set_chartypes($this->char_mode, $this->prepareInput($this->name)),
				"CreateDate"	=> date('Y-m-d H:i:s')
		);
			
		$postpone_check = $this->dbstore->exec_getPostponeAmount($doc_id);
		if($postpone_check['status'] == 'true') {
			$data_amount 			 = $postpone_check['data'][0]['PostponeRef'] + 1;
			$postpone["PostponeRef"] = $data_amount;
				
		} else {
			$data_amount			 = 1;
			$postpone["PostponeRef"] = $data_amount;
				
		}
		
		$data_bundled = $this->dbmodel->exec('PostponeHead', $postpone, false, 'insert');
		$data_bundled = TRUE;
		if($data_bundled == TRUE) {
		
			if(empty($postpone_planreason[0])) {
					
					
			} else {
					
				if(in_array("PO999", $postpone_planreason)):
				$key = array_search("PO999", $postpone_planreason);
				if($key !== false) unset($postpone_planreason[$key]);
				endif;
					
					
					
					
				$postpone_data 	 = array();
				foreach($postpone_planreason as $index => $value) {
						
					array_push($postpone_data, array(
							'DocID'         => $doc_id,
							'PostponeRef'   => $data_amount,
							'PostponeCode'  => $postpone_planreason[$index],
							'PostponeDesc'	=> NULL,
							'IsActive'		=> 'A'
					)
							);
						
				}
					
				if(!empty($postpone_otherreason)) {
						
					array_push($postpone_data, array(
							'DocID'         => $doc_id,
							'PostponeRef'   => $data_amount,
							'PostponeCode'  => 'PO999',
							'PostponeDesc'	=>  $this->effective->set_chartypes($this->char_mode, $this->prepareInput($postpone_otherreason)),
							'IsActive'		=> 'A'
					)
							);
						
				}
		
				if(!empty($postpone_data[0]['DocID'])) {
						
					foreach($postpone_data as $index => $value):
					$this->dbmodel->exec('PostponeSubscription', $postpone_data[$index], false, 'insert');
					endforeach;
						
				}
					
		
			}
		
		}
		
	}
	
	public function writeCustomerCancelReasonLogs($doc_id, $data_stack = array()) {
		$this->load->model('dbmodel');
	
		if(!empty($data_stack['RMProcessReason'][0])) {
			
			if(in_array("CM999", $data_stack['RMProcessReason'])):
				$key = array_search("CM999", $data_stack['RMProcessReason']);
				if(!empty($key)) unset($data_stack['RMProcessReason'][$key]);
			endif;
							
			$object_reason = array();
			foreach($data_stack['RMProcessReason'] as $index => $values) {				
			
				$nonaccept_list = $this->dbmodel->data_validation('CancelReasonListByCust', '*', array('DocID' => $doc_id, 'MasterCode' => $data_stack['RMProcessReason'][$index], 'CancelTypes' => $data_stack['RMProcess']), false);
				if($nonaccept_list == 'FALSE') {
					
					array_push($object_reason, array(
							"DocID"			=> $doc_id,
							"MasterCode"	=> $data_stack['RMProcessReason'][$index],
							"OtherDetail"	=> NULL,
							"CancelTypes"	=> $data_stack['RMProcess'],
							"CancelDate"	=> $data_stack['RMProcessDate'],
							"IsActive"		=> 'A',
							"CreateByID"	=> $this->emp_id,
							"CreateByName"	=> $this->effective->set_chartypes($this->char_mode, $this->name),
							"CreateByDate"	=> date('Y-m-d H:i:s'),
						)
					);
					
				}
				
			}
			
			if(!empty($data_stack['OtherReason'])) {
				
				array_push($object_reason, array(
						"DocID"			=> $doc_id,
						"MasterCode"	=> 'CM999',
						"OtherDetail"	=> $this->effective->set_chartypes($this->char_mode, $data_stack['OtherReason']),
						"CancelTypes"	=> $data_stack['RMProcess'],
						"CancelDate"	=> $data_stack['RMProcessDate'],
						"IsActive"		=> 'A',
						"CreateByID"	=> $this->emp_id,
						"CreateByName"	=> $this->effective->set_chartypes($this->char_mode, $this->name),
						"CreateByDate"	=> date('Y-m-d H:i:s')
					)
				);
				
			}
			
			if(!empty($object_reason[0])) {
				
				foreach($object_reason as $index => $value):
					$this->dbmodel->exec('CancelReasonListByCust', $object_reason[$index], false, 'insert');
				endforeach;
				
			}

			
		}
		
	}
	
	public function getPostReasonLists($doc_id) {
		$this->load->model('dbmodel');
	
		if(empty($doc_id)):
			return;
		
		else:
	
		$result = $this->dbmodel->CIQuery("
			SELECT PostponeSubscription.DocID, PostponeSubscription.PostponeRef, PostponeSubscription.PostponeCode, 
			MasterPostponeReason.PostponeReason, PostponeSubscription.PostponeDesc, PostponeSubscription.IsActive 
			FROM PostponeSubscription
			LEFT OUTER JOIN MasterPostponeReason
			ON PostponeSubscription.PostponeCode = MasterPostponeReason.PostponeCode
			WHERE PostponeSubscription.IsActive = 'A'
			AND DocID = '".$doc_id."'
			ORDER BY PostponeSubscription.PostponeRef ASC
		");
	
		if(empty($result['data'][0]['DocID'])) {
			return array(
					'data' => array(0), 
					'status' => false, 
					'msg' => 'Not Found.'				
			);
	
		} else {
	
			$objList['data'] = array();
			foreach ($result['data'] as $index => $value) {
				array_push($objList['data'], array(
						"DocID" 	   	 => $result['data'][$index]['DocID'],
						"PostponeRef"    => $result['data'][$index]['PostponeRef'],
						"PostponeCode"   => $result['data'][$index]['PostponeCode'],
						"PostponeReason" => $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['PostponeReason']),
						"PostponeDesc"   => $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['PostponeDesc'])
					)
				);
			}
	
			$objList['status']	= true;
			$objList['msg']		= 'query successfully.';
	
			return $objList;
	
		}
	
		endif;
	
	}
	
	// get reason: cancel after approved.
	public function getCustCancelReasonLists($doc_id) {	
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		if(empty($doc_id)) {
			return;
		} else {
			/*
			if(date('Y-m-d') >= '2019-05-02') {
				
				$result = $this->dbmodel->CIQuery("
					SELECT DocID, CancelReasonListByCust.MasterCode, PC_Name MasterReason, NULL OtherDetail, CancelReasonListByCust.CancelTypes, [dbo].[DateOnlyFormat]([CancelDate]) [CancelDate]
					FROM CancelReasonListByCust
					LEFT OUTER JOIN MasterAfterPendingCancel
					ON CancelReasonListByCust.MasterCode = MasterAfterPendingCancel.PC_Code
					WHERE CancelReasonListByCust.IsActive = 'A'
					AND CancelReasonListByCust.CancelTypes = 'NONACCEPT'
					AND DocID = '".$doc_id."'
					ORDER BY [CancelDate] DESC
				");
				
			} else {
			*/
				$result = $this->dbmodel->CIQuery("
					SELECT DocID, CancelReasonListByCust.MasterCode, MasterProcessCancelReason.ProcessReason AS MasterReason,
					CancelReasonListByCust.OtherDetail, CancelReasonListByCust.CancelTypes, [dbo].[DateOnlyFormat]([CancelDate]) [CancelDate]
					FROM CancelReasonListByCust
					LEFT OUTER JOIN MasterProcessCancelReason
					ON CancelReasonListByCust.MasterCode = MasterProcessCancelReason.ProcessCode
					WHERE CancelReasonListByCust.IsActive = 'A'
					AND CancelReasonListByCust.CancelTypes = 'NONACCEPT'
					AND DocID = '".$doc_id."'
					ORDER BY [CancelDate] DESC
				");
				
			//}
			
			if(empty($result['data'][0]['DocID'])) {
				return array('data' => array(0), 'status' => false, 'msg' => 'Not Found.');
				
			} else {
				
				$objList['data'] = array();
				foreach ($result['data'] as $index => $value) {
					array_push($objList['data'], array(
							"DocID" 	   => $result['data'][$index]['DocID'],
							"MasterCode"   => $result['data'][$index]['MasterCode'],
							"MasterReason" => $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['MasterReason']),
							"OtherDetail"  => $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['OtherDetail']),
							"CancelDate"   => !empty($result['data'][$index]['CancelDate']) ? $this->effective->StandartDateRollback($result['data'][$index]['CancelDate']) : '',
							"CancelTypes"  => $result['data'][$index]['CancelTypes']
						)
					);
				}
				
				$objList['status']	= true;
				$objList['msg']		= 'query successfully.';
				
				return $objList;
				
			}
			
		}
			
	}
	
	public function getDrawdownHistory($app_no) {
		$this->load->model('dbmodel');
		
		if(!empty($app_no)) {
			$result = $this->dbmodel->CIQuery("SELECT  RowID, ApplicationNo, DrawdownLoan, CONVERT(nvarchar(10), DrawdownDate, 120) AS DrawdownDate FROM Drawdown_History WHERE ApplicationNo = '".$app_no."' ORDER BY DrawdownDate ASC");
			return $result;
		} else {
			return array('data' => array(0), 'mgs' => 'The application is null', 'status' => false);
		}
		
	}
	
	public function getCancelReasonByCustomer($doc_id) {
		$this->load->model('dbmodel');
		
		if(!empty($doc_id)):
	
			$results = $this->dbmodel->CIQuery("SELECT DocID, AFCancelReason FROM ApplicationStatus WHERE DocID = '".$doc_id."'");
		
		
			if(!empty($results['data'][0]['DocID'])) {
		
				$objList = explode(',', $results['data'][0]['AFCancelReason']);
		
				if(in_array("CM999", $objList)):
					$key = array_search("CM999", $objList);
					if(!empty($key)) unset($objList[$key]);
				endif;
		
				if(!empty($objList[0])):
					$wheres_reason 	= "'".implode("','", $objList)."'";
			
					$list_result = $this->dbmodel->CIQuery("
						SELECT * FROM MasterProcessCancelReason
						WHERE ProcessCode in ($wheres_reason)
						AND IsActive = 'A'
					");						
					
					return $list_result;
					
				endif;
		
			} else {
				return array('data' => array(0), 'status' => false, 'msg' => 'Not Found.');
			}
		
		else:
			return array('data' => array(0), 'status' => false, 'msg' => 'Not Found.');
	
		endif;
	
	
	}
	
	public function setProThirdAppendToActionNoteLog($DocID, $status, $option = array(), $statusdate) {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		if(empty($status)):
			return FALSE;
			
		else:

			date_default_timezone_set("Asia/Bangkok");
			if($status == 'PENDING' || $status == 'CANCEL' || $status == 'REJECT') {
				
				$LogsBundled	 = '#'.str_replace('/', '', substr($statusdate, 0, 5)).' '. $status . ' ' . $this->effective->set_chartypes($this->char_mode, $option[0]);
				$AppSystemLog  	 = $this->dbmodel->data_validation("SystemNoteLog", "*", array("DocID" => $DocID, "ActionNote" => $LogsBundled), false);
				if($AppSystemLog == 'FALSE') :
				
					$AppCheckedLog  = $this->dbmodel->data_validation("ActionNote", "*", array("DocID" => $DocID, "ActionNote" => $LogsBundled), false);
					if($AppCheckedLog == 'FALSE'):
						$this->dbmodel->exec('ActionNote', array("DocID" => $DocID, "ActionNote" => $LogsBundled, 'ActionNoteBy' => $this->emp_id, "ActionNoteDate" => $this->effective->StandartDateSorter($statusdate). ' '. date('H:i:s'), "IsActive" => "A", "ActionName" => $this->effective->set_chartypes($this->char_mode, $this->name)), false, 'insert');
						$this->dbmodel->exec('Verification', array("ActionNote" => $LogsBundled, "ChangeBy" => $this->effective->set_chartypes($this->char_mode, $this->name),  "ChangeDate" => date('Y-m-d H:i:s')), array('DocID' => $DocID), 'update');
					endif;
				
				endif;

			} else {
				
				if($status == 'APPROVED'):
					$LogsBundled	 = '#'.str_replace('/', '', substr($statusdate, 0, 5)).' '. $status . ' ' . $this->effective->set_chartypes($this->char_mode, $option[0]);
					$AppSystemLog  	 = $this->dbmodel->data_validation("SystemNoteLog", "*", array("DocID" => $DocID, "ActionNote" => $LogsBundled), false);
					if($AppSystemLog == 'FALSE') :
						
						$AppCheckedLog  = $this->dbmodel->data_validation("ActionNote", "*", array("DocID" => $DocID, "ActionNote" => $LogsBundled), false);
						if($AppCheckedLog == 'FALSE'):
							$this->dbmodel->exec('ActionNote', array("DocID" => $DocID, "ActionNote" => $LogsBundled, 'ActionNoteBy' => $this->emp_id, "ActionNoteDate" => $this->effective->StandartDateSorter($statusdate). ' '. date('H:i:s'), "IsActive" => "A", "ActionName" => $this->effective->set_chartypes($this->char_mode, $this->name)), false, 'insert');
							$this->dbmodel->exec('Verification', array("ActionNote" => $LogsBundled, "ChangeBy" => $this->effective->set_chartypes($this->char_mode, $this->name),  "ChangeDate" => date('Y-m-d H:i:s')), array('DocID' => $DocID), 'update');
						endif;
					
					endif;
					
					
				endif;
				
			}
			
			
		endif;
	
	}
	
	/**  Report **/
	public function dashboard_loader() {
		$this->load->model('dbcustom');
		$this->load->library('effective');
		
		header('Content-Type: text/html; charset="UTF-8"');
		
		$results = $this->dbcustom->dataTableDashboard($this->authorized, array($this->emp_id));
		$iTotal	 = $this->dbcustom->dataTableDashboardPagination($this->authorized, array($this->emp_id));	
		
		foreach($results['data'] as $index => $value) {
		
			$day_diff		= $this->countDistinctDay($results['data'][$index]['StartDate'], $results['data'][$index]['Status'], $results['data'][$index]['DrawdownDate'], $results['data'][$index]['StatusDate']);
			$app2ca			= !empty($results['data'][$index]['CA_ReceivedDocDate']) ? $results['data'][$index]['CA_ReceivedDocDate']:'';
			
			$applicationno	= !empty($results['data'][$index]['ApplicationNo']) ? $results['data'][$index]['ApplicationNo']:'';
			$ownership_doc	= !empty($results['data'][$index]['OwnershipDoc']) ? $results['data'][$index]['OwnershipDoc']:'';
			
			if(!empty($results['data'][$index]['A2CAPostponeAmt'])) {
				if(in_array($results['data'][$index]['A2CAPostponeAmt'], array('0', '1'))) {
					$planA2CAStyle = 'background-color: #D1D1D1; border: 1px dotted red;';
					$planA2CALabel = '';
				} else if(in_array($results['data'][$index]['A2CAPostponeAmt'], array('2'))) {
					$planA2CAStyle = 'background-color: #E3C800; border: 1px dotted red;';
					$planA2CALabel = '(เลื่อนครั้งที่ 2)';
				} else if($results['data'][$index]['A2CAPostponeAmt'] >= 3) {
					$planA2CAStyle = 'background-color: #f16464; color: #000; border: 1px dotted #000;';
					$planA2CALabel = '(เลื่อนครั้งที่ 3 หรือมากกว่า)';
				}
			} else { $planA2CAStyle = 'background-color: #D1D1D1; border: 1px dotted red;'; $planA2CALabel = ''; }
			
			if(!empty($results['data'][$index]['AppToCAPlanDate']) && empty($results['data'][$index]['CA_ReceivedDocDate'])) {				
				$HQReceivedDocs = !empty($results['data'][$index]['HQReceiveCADocDate']) ? '<span  class="tooltip-right" data-tooltip="HO Received">'.$this->effective->StandartDateRollback($results['data'][$index]['HQReceiveCADocDate']).'</span>':'';
				$BeforeSentDate = !empty($results['data'][$index]['SentToCADate']) ? '<span class="tooltip-right" data-tooltip="HO2CA" style="color: rgb(35, 84, 188); font-weight: normal;">'.$this->effective->StandartDateRollback($results['data'][$index]['SentToCADate']).'</span>':$HQReceivedDocs;
				$AppToCADate	= !empty($results['data'][$index]['AppToCAPlanDate']) ? '<span  class="tooltip-right" data-tooltip="PLAN A2CA '. $planA2CALabel .'" style="'.$planA2CAStyle.' padding: 2px; font-weight: bold;">'.$this->effective->StandartDateRollback($results['data'][$index]['AppToCAPlanDate']).'</span>':$BeforeSentDate;
								
			} else {
				$PlanAppToCA	= !empty($results['data'][$index]['AppToCAPlanDate']) ? '<span  class="tooltip-right" data-tooltip="PLAN A2CA '. $planA2CALabel .'" style="'.$planA2CAStyle.' padding: 2px; font-weight: bold;">'.$this->effective->StandartDateRollback($results['data'][$index]['AppToCAPlanDate']).'</span>':'';
				$HQReceivedDocs = !empty($results['data'][$index]['HQReceiveCADocDate']) ? '<span  class="tooltip-right" data-tooltip="HO Received">'.$this->effective->StandartDateRollback($results['data'][$index]['HQReceiveCADocDate']).'</span>':$PlanAppToCA;
				$BeforeSentDate = !empty($results['data'][$index]['SentToCADate']) ? '<span class="tooltip-right" data-tooltip="HO2CA" style="color: rgb(35, 84, 188); font-weight: normal;">'.$this->effective->StandartDateRollback($results['data'][$index]['SentToCADate']).'</span>':'';
				$AppToCADate 	= !empty($results['data'][$index]['CA_ReceivedDocDate']) ? '<span  class="tooltip-right" data-tooltip="A2CA" style="color: #4a8e07; font-weight: normal;">'.$this->effective->StandartDateRollback($results['data'][$index]['CA_ReceivedDocDate']).'</span>':$BeforeSentDate;
			}
			
			// Check Gateway
			if($results['data'][$index]['StartDate'] != "") $gateway_1 = 'G1'; else $gateway_1 = "C1";
			if($results['data'][$index]['SentToCADate'] != "" && $results['data'][$index]['HQReceiveCADocDate'] != "") $gateway_2 = 'G2'; else $gateway_2 = "C2";
			if($results['data'][$index]['StatusDate'] != "" && $results['data'][$index]['SentToCADate'] != "") $gateway_3 = "G3"; else $gateway_3 = "C3";
			
			if($results['data'][$index]['Retrieved'] == 'Y') {
				//$name_color = 'color: #4a8e07;';
				$start_date_mof = $this->effective->StandartDateRollback($results['data'][$index]['RetrieveDate']);
				
			} else {
				
				// Modify NCB: Re-Check Consent
				if($results['data'][$index]['ReActivated'] == 'Y'):
					//$name_color = 'color: #178AC2;';
					$start_date_mof = $this->effective->StandartDateRollback($results['data'][$index]['ReActivateDate']);
				else:
					//$name_color = '';
					if($results['data'][$index]['NCBCheckDate'] != ""):
						$start_date_mof = $this->effective->StandartDateRollback($results['data'][$index]['NCBCheckDate']);
					else:
						$start_date_mof = $this->effective->StandartDateRollback($results['data'][$index]['StartDate']);
					endif;
					
				endif;			
			
			}
			
			// Distinct Calucation 
			if($results['data'][$index]['Status'] == "C" || $results['data'][$index]['Status'] == "R"):
				$a2ca_senddate = $results['data'][$index]['StatusDate'];
			else:
				$a2ca_senddate = $app2ca; // App2CA
			endif;
			
			// A2CA
			if($results['data'][$index]['Retrieved'] == 'Y') {
				$star_mof = !empty($results['data'][$index]['RetrieveDate']) ? $results['data'][$index]['RetrieveDate']:'';
				$a2ca     = $this->calDistinctDays("A2CA", array($star_mof, $a2ca_senddate), $results['data'][$index]['Status'], $gateway_1);
				
			} else {

				if($results['data'][$index]['ReActivated'] == 'Y'):
					$star_mof = !empty($results['data'][$index]['ReActivateDate']) ? $results['data'][$index]['ReActivateDate']:'';
					$a2ca     = $this->calDistinctDays("A2CA", array($star_mof, $a2ca_senddate), $results['data'][$index]['Status'], $gateway_1);
				else:
					$star_mof = !empty($results['data'][$index]['NCBCheckDate']) ? $results['data'][$index]['NCBCheckDate']:$results['data'][$index]['StartDate'];
					$a2ca     = $this->calDistinctDays("A2CA", array($star_mof, $a2ca_senddate), $results['data'][$index]['Status'], $gateway_1);
				endif;
				
			}
			
			// CA on handled
			$state 	  = $this->calDistinctDays("STATE", array($app2ca, $results['data'][$index]['StatusDate']), $results['data'][$index]['Status'], $gateway_2);
			
			// Loan
			$request_load 	 = !empty($results['data'][$index]['RequestLoan']) ? number_format($results['data'][$index]['RequestLoan'], 0):"";
			
			if($results['data'][$index]['Status'] == 'A') {
				$loan_easing = !empty($results['data'][$index]['ApprovedLoan']) ? number_format($results['data'][$index]['ApprovedLoan']):'';
			} else if($results['data'][$index]['Status'] == 'P') {
				$loan_easing = !empty($results['data'][$index]['PreLoan']) ? number_format($results['data'][$index]['PreLoan']):'';
			} else {
				$loan_easing = null;
			}
									
			$drawdown_loan   = !empty($results['data'][$index]['DrawdownBaht']) ? number_format($results['data'][$index]['DrawdownBaht'], 0):"";
			
			$ddstate  = $this->calDistinctDays("DDSTATE", array($results['data'][$index]['StatusDate'], $results['data'][$index]['DrawdownDate']), $results['data'][$index]['Status'], $gateway_3);
			$totalDay = $this->calDistinctDaySpecify(array($star_mof, $results['data'][$index]['StatusDate']), $results['data'][$index]['Status'], $results['data'][$index]['DrawdownDate']);
			
			// Data Option
			$cust_names = !empty($results['data'][$index]['MainLoanName']) ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['MainLoanName']) : $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['OwnerName']);
			$cm_concat  = (strlen($results['data'][$index]['MainLoanName']) >= 5) ? '...':'';
			
			$rm_names	= !empty($results['data'][$index]['RMName']) ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['RMName']):'';
			$rm_concat  = (strlen($results['data'][$index]['RMName']) >= 5) ? '...':'';
			
			$ca_names	= !empty($results['data'][$index]['CAName']) ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['CAName']):'';
			$ca_concat	= (strlen($results['data'][$index]['CAName']) >= 5) ? '...':'';
			
			$note_desc 	= !empty($results['data'][$index]['ActionNote']) ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['ActionNote']):'';
			$nt_concat	= (strlen($results['data'][$index]['ActionNote']) >= 25) ? '...':'';
			
			$products   = !empty($results['data'][$index]['ProductCode']) ? trim($results['data'][$index]['ProductTypes']).'-'.substr($results['data'][$index]['ProductCode'], -2, 2):"";
			
			$brn_name	= !empty($results['data'][$index]['BranchName']) ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BranchName']):'';
			$brn_tel	= !empty($results['data'][$index]['BranchTel']) ? $brn_name. ' (' .$results['data'][$index]['BranchTel']. ')':'';
			
			if(!empty($results['data'][$index]['PlanDateUnknown'])):
				$DDplandate = '00/00/0000';
			else:
				$DDplandate = $this->effective->StandartDateRollback($results['data'][$index]['PlanDrawdownDate']);
			endif;

			if(!empty($results['data'][$index]['RetrieveDate'])):
				$re_record = 'RT';
			else:		
				if(!empty($results['data'][$index]['ReActivateDate'])) $re_record = 'RA';
				else $re_record = '';	
			endif;
			
			/** DD History Start **/			
			$history_area = '';
			if(!empty($results['data'][$index]['DDHistory'])) {
				
				$temp_history  = array();
				$split_history = explode('|', $results['data'][$index]['DDHistory']);					
				
				if(!empty($split_history[0])) {
					
					foreach ($split_history as $sp_index => $sp_value) {					
						array_push($temp_history, explode(',', $split_history[$sp_index]));
					}
						
				}
				
				$numincreament 	= 1;
				$data_history 	= '';
				if(!empty($temp_history[0])) {					
					foreach ($temp_history as $sp_index => $sp_value) {
						$data_history .=  $numincreament .'. '. $this->effective->StandartDateRollback($temp_history[$sp_index][0]). ' - ' .number_format($temp_history[$sp_index][1], 0). ' Baht.<br/>';
						$numincreament++;
					}
					
				}
				
				if(!empty($data_history)):
					$history_area = '<div id="area_history_'.$index.'" style="display: none;">'.$data_history.'</div>';
				endif;
		
			}
			
			$dd_sup = '';
			if(!empty($results['data'][$index]['Installment']) && $results['data'][$index]['Installment'] == 'Y'):
				$drawdown_date = !empty($results['data'][$index]['DrawdownDate']) ? $this->effective->StandartDateRollback($results['data'][$index]['DrawdownDate']):'';
				$dd_sup		   = '<span id="element_area_'.$index.'" onmouseover="popover_areahistory(\'#element_area_'.$index.'\', \'#area_history_'.$index.'\');" class="show-pop" data-placement="top-right" style="background-color: #D1D1D1; border: 1px dotted red; padding: 2px; font-weight: bold; cursor: pointer; z-index: 1;">'.$drawdown_date.'</span>';
			else:
				$dd_sup		   = $this->effective->StandartDateRollback($results['data'][$index]['DrawdownDate']);
			endif;			
			/** DD History End;  */
						
			if($results['data'][$index]['Status'] == "CR"):
				$state_date = !empty($results['data'][$index]['CAReturnDateLog']) ? $this->effective->StandartDateRollback($results['data'][$index]['CAReturnDateLog']):$this->effective->StandartDateRollback($results['data'][$index]['StatusDate']);
			else:
				$state_date = $this->effective->StandartDateRollback($results['data'][$index]['StatusDate']);
			endif;
			
			$obj_datastatus		  = '';
			$received_estimatedoc = !empty($results['data'][$index]['ReceivedEstimateDoc']) ? $results['data'][$index]['ReceivedEstimateDoc']:'';
			$aip_enabled	  	  = !empty($results['data'][$index]['IsAIP']) ? $results['data'][$index]['IsAIP']:'';
			$aip_careason	  	  = !empty($results['data'][$index]['StatusReason']) ? $results['data'][$index]['StatusReason']:'';
			$bank_list	  	  	   = !empty($results['data'][$index]['Bank']) ? $results['data'][$index]['Bank']:'';
			
			if(in_array($results['data'][$index]['Status'], array('P', 'A'))) {
				
				if(!empty($received_estimatedoc) && $received_estimatedoc == 'Y') {
					
					$collecteral_uri  = $this->config->item('collateral_uri');
					if($results['data'][$index]['Status'] === 'A') {						
						if($ownership_doc !== 'Y'):
							$obj_datastatus   = $results['data'][$index]['Status'];
						else:
							$obj_datastatus	  = '<span onclick="modalPropEnabled(\''.$applicationno.'\', \''. $ownership_doc .'\');" style="padding: 3px 7px; border-radius: 50%; background: red; color: white; cursor: pointer;" class="tooltip-right" data-tooltip="หนังสือรับรองกรรมสิทธิสิ่งปลูกสร้างยังไม่สมบูรณ์">'. $results['data'][$index]['Status'] .'</span>';
						
						endif;						
					} else {
						$obj_datastatus	  = '<span onclick="modalPropEnabled(\''.$applicationno.'\', \''. $ownership_doc .'\');" style="padding: 3px 7px; border-radius: 50%; background: #FF5722; color: white; cursor: pointer;">'. $results['data'][$index]['Status'] .'</span>';
					}					
	
				//} else if(!empty($aip_enabled) || $aip_careason == 'AIP') {
				} else if(!empty($results['data'][$index]['PreLoan'])) {
					
					if($results['data'][$index]['Status'] === 'P'):
						$obj_datastatus	  = '<span style="padding: 3px 7px; border-radius: 50%; background: #4390DF; color: white;">'. $results['data'][$index]['Status'] .'</span>';
					else:
						$obj_datastatus   = $results['data'][$index]['Status'];
					endif;
				
				} else {
					$obj_datastatus   = $results['data'][$index]['Status'];
				}
				
			} else {
				$obj_datastatus		  = $results['data'][$index]['Status'];
			}

			$columns[] = array(
				"StartDate" 		 => '<span class="tooltip-right" data-tooltip="'.$start_date_mof.'">'.$start_date_mof.'</span>',
				"Days"				 => self::numLightState($totalDay),
				"Re_Record"			 => $re_record,
				"OwnerName"	 		 => '<span class="tooltip-right print_hold" data-tooltip="'.$cust_names . ' (' . $applicationno . ')">'.mb_strimwidth($cust_names, 0, 13).$cm_concat.'</span> <div class="printable hidden">' . mb_strimwidth($cust_names, 0, 10).$cm_concat . '<small>' . '<br/>' . $applicationno . '</small></div>',
				"RMName"	 		 => '<span class="tooltip-right" data-tooltip="'.$rm_names.'">'.mb_strimwidth($rm_names, 0, 13).$rm_concat.'</span>',
				"Region" 			 => $results['data'][$index]['RegionNameEng'],				
				"BranchDigit"		 => '<span class="tooltip-right" data-tooltip="'.$brn_tel.'">'.$results['data'][$index]['BranchDigit'].'</span>',
				"ProductCode" 		 => '<span class="tooltip-right print_hold" data-tooltip="'.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['ProductName']).'">'.$products.'</span><div class="printable hidden">' . $products . '<br/>' . $bank_list . '</div>',
				"RequestLoan" 		 => $request_load,
				"DayGate1"	 		 => self::numLightState($this->limitDistinctDays($a2ca)),
				"CA_ReceivedDocDate" => !empty($AppToCADate) ? $AppToCADate:$HQReceivedDocs,
				"CAName"	 		 => '<span class="tooltip-right" data-tooltip="'.$ca_names.'">'.mb_strimwidth($ca_names, 0, 13).$ca_concat.'</span>',
				"Status"	 		 => $obj_datastatus,
				"StatusDate" 		 => '<span class="tooltip-right" data-tooltip="'.$state_date.'">'.$state_date.'</span>',
				"ApprovedLoan"	 	 => $loan_easing,
				"DayGate2"			 => self::numLightState($this->limitDistinctDays($state)),
				"PlanDrawdownDate"	 => '<span class="tooltip-right" data-tooltip="'.$DDplandate.'">'.$DDplandate.'</span>',
				"DrawdownDate" 	 	 => $dd_sup,
				"DrawdownBaht"  	 => ($drawdown_loan === '0') ? '':$drawdown_loan,
				"DayGate3"			 => self::numLightState($this->limitDistinctDays($ddstate)) . $history_area,
				"ActionNote"  	     => '<span class="tooltip-left print_hold" data-tooltip="'.$note_desc.'">'.mb_strimwidth($note_desc, 0, 40).$nt_concat.'</span>' . '<div class="printable hidden">' . $note_desc . '</div> <input type="hidden" value="'.$results['data'][$index]['DocID'].'">',
				"DocID"				 => $results['data'][$index]['DocID'],
				"Links"				 => '<a href="'.site_url('management/getDataVerifiedPreview').'?mod=1&cache=false&secure=c4ca4238a0b923820dcc509a6f75849b&rel='.$results['data'][$index]['DocID'].'&req=P2&live=2&t=53&whip=true&clw=false" target="_blank" class="print_hold"><i class="icon-new-tab"></i></a>'			 			
			 );

		}

		$sOutput = array(
				'draw'                => intval($this->input->post('draw')) ? intval($this->input->post('draw')) : 0,
				'recordsTotal'        => $iTotal,
				'recordsFiltered'     => $iTotal,
				'data'                => $columns
		);

		echo json_encode($sOutput);
	
		//$this->output->enable_profiler(TRUE);
		
	}
	
	public function getSummaryLoanDashboard() {
		$this->load->model('dbcustom');
		$this->load->library('effective');

		$wheres			= "WHERE IsActive = 'Y'";
		$where_addition = "AND LendingBranchs.RegionID IS NOT NULL";
		$wheres_name	= "";
		
		$ncb_start 		= $this->input->post('ncb_start');
		$ncb_end		= $this->input->post('ncb_end');
		$rmname			= $this->input->post('rmname');
		$ownerName		= $this->input->post('ownerName');
		$caname			= $this->input->post('caname');
		$regionid		= $this->input->post('regionid');
		$branchs		= $this->input->post('branchdigit');
		$product		= $this->input->post('product');
		$loantype		= $this->input->post('loantype');
		$rqloan_start	= (int)$this->input->post('rqloan_start');
		$rqloan_end		= (int)$this->input->post('rqloan_end');
		$planca_start	= $this->input->post('planapp_start');
		$planca_end		= $this->input->post('planapp_end');
		$dateca_start	= $this->input->post('dateca_start');
		$dateca_end		= $this->input->post('dateca_end');
		$status			= $this->input->post('status');
		$status_reason	= $this->input->post('status_reason');
		$stdate_start	= $this->input->post('stdate_start');
		$stdate_end		= $this->input->post('stdate_end');
		$appLoan_start	= (int)$this->input->post('appLoan_start');
		$appLoan_end	= (int)$this->input->post('appLoan_end');
		$plandate_st	= $this->input->post('plandate_st');
		$plandate_ed	= $this->input->post('plandate_ed');
		$dddate_start	= $this->input->post('dddate_start');
		$dddate_end		= $this->input->post('dddate_end');
		$actualbaht_st	= (int)$this->input->post('actualbaht_st');
		$actualbaht_ed	= (int)$this->input->post('actualbaht_ed');
		$activerows		= $this->input->post('activerecords');
		$refer_tlf		= $this->input->post('refer_tlf');
		$cashy_field	= $this->input->post('cashy_field');
		$defend_list	= ''; 
		$retrieve_list	= ''; 
		$re_activate	= '';
		
		$drawdown_cm 	 = $this->input->post('drawdown_cm');
		$filter_cncancel = $this->input->post('filter_cncancel');
		
		/* ############ KPI ############ */		
		$kpi_search		= $this->input->post('search_kpi');
		$kpi_no			= $this->input->post('kpino');
		$emp_kpi		= $this->input->post('emp_auth');
		$mode_kpi		= $this->input->post('mode_kpi');
		$use_ca			= $this->input->post('use_ca');
		$modestate		= $this->input->post('modestate');
					
		$wheres_kpi		= "";
		$kpi_condition	= "";
		$kpi_privileges = "";
		if($kpi_search == 'true') {
			
			$special_role = $this->dbcustom->setDataAuthority($emp_kpi);
			$get_info = $this->dbcustom->getEmployeeDataInfo($emp_kpi);
			$brn_code = $get_info['data'][0]['BranchCode'];
			$area_code  = $get_info['data'][0]['AreaCode'];
			$region_id  = $get_info['data'][0]['RegionID'];
			
			$kpi_privileges = $this->dbcustom->getAuthPermission($special_role);
				
			$first_date		= trim(date('Y-m-').'01');
			$second_date	= trim(date('Y-m-').date('t', strtotime(date("Y-m-d"))));
						
			switch ($kpi_no) {
				case '4':	
					if($use_ca == 'false') { $wheres_kpi .= " AND CA_ReceivedDocDate IS NULL"; }
					
				break;
				case '6':
					
					if($mode_kpi == $this->branch_mode)  {
						if($brn_code != '000'):
							$kpi_condition = "@BrnCode = $brn_code";
						endif;
					}
					else if($mode_kpi == $this->individual_mode) {
						
						if(in_array($special_role, array($this->role_am, $this->role_rd))) {
								
							switch($special_role) {
								case $this->role_am:
									$kpi_condition = "@AreaCode = '".$area_code."'";
									break;
								case $this->role_rd:
									$kpi_condition = "@Region = '".$region_id."'";
									break;
								default:
									$kpi_condition = "@RMCode = '".$emp_kpi."'";
									break;
							}
							
						} else {
							$kpi_condition = "@RMCode = $emp_kpi";
						}
						
					}

				break;
				case '7':
					//$wheres_kpi     .= " AND LatestEvent = 'REA'";
					$wheres_kpi		.= " AND ReActivateDate BETWEEN '".$first_date."' AND '".$second_date."'";
				break;	
				case '8':
					$wheres_kpi		.= " AND CAReturnDateLog BETWEEN '".$first_date."' AND '".$second_date."'";
				break;
				case '9':
					$wheres_kpi     .= " AND StatusDesc IN ('CANCELBYCA', 'CANCELBYRM', 'CANCELBYCUS')";
					$wheres_kpi		.= " AND StatusDate BETWEEN '".$first_date."' AND '".$second_date."'";
					$wheres_kpi 	.= " AND CA_ReceivedDocDate IS NULL";
				break;			
				case '10':
					//$wheres_kpi     .= " AND LatestEvent = 'RET'";
					$wheres_kpi		.= " AND RetrieveDate BETWEEN '".$first_date."' AND '".$second_date."'";
				break;
				case '12':
					if($use_ca == 'false') { $wheres_kpi .= " AND CA_ReceivedDocDate IS NULL"; }
					$wheres_kpi		.= " AND CheckNCBDate BETWEEN '".$first_date."' AND '".$second_date."'";
					$wheres_kpi		.= " AND NCBCheckDate IS NULL";
					$wheres_kpi		.= " AND ((Year(ReActivateDate) = '".date('Y')."' AND Month(ReActivateDate) = '".date('m')."' ) OR ReActivateDate IS NULL)";
					$wheres_kpi		.= " AND ((Year(RetrieveDate) = '".date('Y')."' AND Month(RetrieveDate) =  '".date('m')."' ) OR RetrieveDate IS NULL)";
				break;
				case '14':
					if($use_ca == 'true') { $wheres_kpi .= " AND CA_ReceivedDocDate IS NOT NULL"; }
					$wheres_kpi		.= " AND [Status] = 'A'";
					$wheres_kpi		.= " AND StatusDate BETWEEN '".$first_date."' AND '".$second_date."'";
					break;
				case '15':
					if($use_ca == 'true') { $wheres_kpi .= " AND CA_ReceivedDocDate IS NOT NULL"; }
					$wheres_kpi		.= " AND [Status] = 'R'";
					$wheres_kpi		.= " AND StatusDate BETWEEN '".$first_date."' AND '".$second_date."'";
					break;
				case '16':
					if($use_ca == 'true') { $wheres_kpi .= " AND CA_ReceivedDocDate IS NOT NULL"; }
					$wheres_kpi		.= " AND [Status] = 'C'";
					$wheres_kpi		.= " AND StatusDate BETWEEN '".$first_date."' AND '".$second_date."'";
				break;
				case '17':					
					$wheres_kpi		.= " AND [Status] IN ('P')";
					//$wheres_kpi		.= " AND StatusDate BETWEEN '".$first_date."' AND '".$second_date."'";					
				break;
				case '18':
					$wheres_kpi		.= " AND SourceOfCustomer = 'Refer: Thai Life'";
					$wheres_kpi		.= " AND DrawdownDate IS NOT NULL";
					$wheres_kpi		.= " AND DrawdownDate BETWEEN '".$first_date."' AND '".$second_date."'";
				break;
				case '20':
					$wheres_kpi		.= " AND [Status] IN ('A')";
					$wheres_kpi		.= " AND DrawdownDate IS NOT NULL";
					$wheres_kpi		.= " AND DrawdownDate BETWEEN '".$first_date."' AND '".$second_date."'";
				break;
				case '21':
					$wheres_kpi		.= " AND [Status] IN ('A')";
					$wheres_kpi		.= " AND DrawdownDate IS NULL";
				break;
				case '22':
					$wheres_kpi		.= " AND [Status] IN ('A')";
					$wheres_kpi		.= " AND DrawdownDate IS NOT NULL";
					$wheres_kpi		.= " AND DrawdownDate BETWEEN '".$first_date."' AND '".$second_date."'";
					$wheres_kpi		.= " AND ProductCat = 'Secure Loan'";
				break;
			}
			
		}
		
		/* ############ KPI ############ */
		
		$ncbdate_start  = !empty($ncb_start) ? $this->effective->StandartDateSorter($ncb_start):"";
		$ncbdate_end	= !empty($ncb_end) ? $this->effective->StandartDateSorter($ncb_end):"";
		$caplan_start   = !empty($planca_start) ? $this->effective->StandartDateSorter($planca_start):"";
		$caplan_end		= !empty($planca_end) ? $this->effective->StandartDateSorter($planca_end):"";
		$cadate_start   = !empty($dateca_start) ? $this->effective->StandartDateSorter($dateca_start):"";
		$cadate_end		= !empty($dateca_end) ? $this->effective->StandartDateSorter($dateca_end):"";
		$statusdate_st  = !empty($stdate_start) ? $this->effective->StandartDateSorter($stdate_start):"";
		$statusdate_ed	= !empty($stdate_end) ? $this->effective->StandartDateSorter($stdate_end):"";
		$dateplan_start = !empty($plandate_st) ? $this->effective->StandartDateSorter($plandate_st):"";
		$dateplan_end	= !empty($plandate_ed) ? $this->effective->StandartDateSorter($plandate_ed):"";
		$actualdate_st	= !empty($dddate_start) ? $this->effective->StandartDateSorter($dddate_start):"";
		$actualdate_ed	= !empty($dddate_end) ? $this->effective->StandartDateSorter($dddate_end):"";
		
		$pieces = explode(',', $branchs);
		if(!empty($pieces[0])) :
			$where_brachs 	= "'".implode("','", $pieces)."'";
		else:
			$where_brachs   = "";
		endif;
		
		$loantype_piece = explode(',', $loantype);
		if(!empty($loantype_piece[0])) {
			if(in_array("Clean Loan", $loantype_piece)):
			$del_attr = array_search("Clean Loan", $loantype_piece);
			if($del_attr !== false) unset($loantype_piece[$del_attr]);
			endif;
		}
				
		if(!empty($loantype_piece[0])):
			$wheres_loantype 	= "'".implode("','", $loantype_piece)."'";
		else:
			$wheres_loantype     = "";
		endif;
		
		$product_pieces = explode(',', $product);
		if(!empty($product_pieces[0])):
			$wheres_product 	= "'".implode("','", $product_pieces)."'";
		else:
			$wheres_product     = "";
		endif;
		
		$obj_status 	 = array();	
		$obj_statusDraft = array();
		$refer_pieces    = explode(',', $refer_tlf);
		$status_pieces   = explode(',', $status);
		
		if(in_array("CR", $refer_pieces)):
			array_push($obj_status, 'CREDIT RETURN');
			$key = array_search("CR", $refer_pieces);
			if($key !== false) unset($refer_pieces[$key]);
		endif;
		
		if(in_array("Defend", $refer_pieces)):
			$defend_list = 'Y';
			$attr = array_search("Defend", $refer_pieces);
			if($attr !== false) unset($refer_pieces[$attr]);
		endif;
		
		$re_object = array();		
		if(in_array("Retrieved", $refer_pieces)):
			//$retrieve_list = 'RET';
			array_push($re_object, 'RET');
			$del_attr = array_search("Retrieved", $refer_pieces);
			if($del_attr !== false) unset($refer_pieces[$del_attr]);
		endif;
		
		if(in_array("ReActivate", $refer_pieces)):
			//$re_activate = 'REA';
			array_push($re_object, 'REA');
			$re_attr = array_search("ReActivate", $refer_pieces);
			if($re_attr !== false) unset($refer_pieces[$re_attr]);
		endif;	
		
		if(!empty($re_object[0])) {
			$wheres_retrieve 	= "'".implode("','", $re_object)."'";	
		}
		
		if(!empty($refer_pieces[0])):
			$wheres_refer   = $this->effective->set_chartypes($this->char_mode,  "'".implode("','", $refer_pieces)."'");
		else:
			$wheres_refer   = "";
		endif;
		
		if(in_array("CANCEL_BP", $status_pieces)):
			array_push($obj_statusDraft, 'CANCELBYRM');
			array_push($obj_statusDraft, 'CANCELBYCUS');
			$key = array_search("CANCEL_BP", $status_pieces);
			if($key !== false) unset($status_pieces[$key]);
		endif;
		
		if(in_array("CANCEL_AP", $status_pieces)):
			array_push($obj_statusDraft, 'CANCEL');
			array_push($obj_statusDraft, 'CANCELBYCA');
			$key = array_search("CANCEL_AP", $status_pieces);
			if($key !== false) unset($status_pieces[$key]);
		endif;
				
		// Filter Status
		$status_num = count($status_pieces);
		if($status_num >= 1) {
			foreach ($status_pieces as $index => $values):
				if($status_pieces[$index] !== "") {
					array_push($obj_status, $status_pieces[$index]);
				}				
			endforeach;			
		}
		
		$status_draftnum = count($obj_statusDraft);
		if($status_draftnum >= 1) {
			foreach ($obj_statusDraft as $index => $values):
				if($obj_statusDraft[$index] !== ""):
					array_push($obj_status, $obj_statusDraft[$index]);
				endif;
			endforeach;
		}
		
		if(!empty($obj_status[0])):
			$wheres_status 	= "'".implode("','", $obj_status)."'";
		else:
			$wheres_status  = "";
		endif;
		
		$restimated   		 = "";
		$aip_reason			 = "";
		
		$statusreason_pieces = explode(',', $status_reason);
		if(in_array("ReceivedEstimated", $statusreason_pieces)):
			$restimated  = 'Y';
			$rd_estimate = array_search("ReceivedEstimated", $statusreason_pieces);
			if($rd_estimate !== false) unset($statusreason_pieces[$rd_estimate]);
		endif;	
		
		if(in_array("AIP", $statusreason_pieces)):
			$aip_reason  = 'Y';
			$aipreason   = array_search("AIP", $statusreason_pieces);
			if($aipreason !== false) unset($statusreason_pieces[$aipreason]);
		endif;
		
		if(!empty($statusreason_pieces[0])):
			$wheres_statusreaon   = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $statusreason_pieces)."'");
		else:
			$wheres_statusreaon   = "";
		endif;

		$rmlist_pieces = explode(',', $rmname);
		if(!empty($rmlist_pieces[0])):
			$wheres_rmlist   = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $rmlist_pieces)."'");
		else:
			$wheres_rmlist   = "";
		endif;
		
		// Draft check date
		$check_datefilter = array();
		
		// Date Range
		if(!empty($ncbdate_start) && !empty($ncbdate_end)) {
			$wheres .= " AND CONVERT(nvarchar(10), StartDate, 120) BETWEEN '".$ncbdate_start."' AND '".$ncbdate_end."'";
			array_push($check_datefilter, 'TRUE');
				
		} else {
		
			if(!empty($ncbdate_start)):
				$wheres .= " AND CONVERT(nvarchar(10), StartDate, 120)  = '".$ncbdate_start."'";
				array_push($check_datefilter, 'TRUE');
			else:
				array_push($check_datefilter, 'FALSE');
			endif;
				
			if(!empty($ncbdate_end)):
				$wheres .= " AND CONVERT(nvarchar(10), StartDate, 120)  = '".$ncbdate_end."'";
				array_push($check_datefilter, 'TRUE');
			else:
				array_push($check_datefilter, 'FALSE');
			endif;
		
		}
		
		if(!empty($caplan_start) && !empty($caplan_end)) {
			$wheres .= " AND CONVERT(nvarchar(10), AppToCAPlanDate, 120) BETWEEN '".$caplan_start."' AND '".$caplan_end."'";
			array_push($check_datefilter, 'TRUE');
		
		} else {
		
			if(!empty($caplan_start)):
				$wheres .= " AND CONVERT(nvarchar(10), AppToCAPlanDate, 120)  = '".$caplan_start."'";
				array_push($check_datefilter, 'TRUE');
			else:
				array_push($check_datefilter, 'FALSE');
			endif;
		
			if(!empty($planca_end)):
				$wheres .= " AND CONVERT(nvarchar(10), AppToCAPlanDate, 120)  = '".$caplan_end."'";
				array_push($check_datefilter, 'TRUE');
			else:
				array_push($check_datefilter, 'FALSE');
			endif;
		}
		
		if(!empty($cadate_start) && !empty($cadate_end)) {
			$wheres .= " AND CONVERT(nvarchar(10), CA_ReceivedDocDate, 120) BETWEEN '".$cadate_start."' AND '".$cadate_end."'";
			array_push($check_datefilter, 'TRUE');
				
		} else {
				
			if(!empty($cadate_start)):
				$wheres .= " AND CONVERT(nvarchar(10), CA_ReceivedDocDate, 120)  = '".$cadate_start."'";
				array_push($check_datefilter, 'TRUE');
			else:
				array_push($check_datefilter, 'FALSE');
			endif;
				
			if(!empty($cadate_end)):
				$wheres .= " AND CONVERT(nvarchar(10), CA_ReceivedDocDate, 120)  = '".$cadate_end."'";
				array_push($check_datefilter, 'TRUE');
			else:
				array_push($check_datefilter, 'FALSE');
			endif;
		
		}
		
		if(!empty($statusdate_st) && !empty($statusdate_ed)) {
			$wheres .= " AND CONVERT(nvarchar(10), StatusDate, 120) BETWEEN '".$statusdate_st."' AND '".$statusdate_ed."'";
			array_push($check_datefilter, 'TRUE');
				
		} else {
		
			if(!empty($statusdate_st)):
				$wheres .= " AND CONVERT(nvarchar(10), StatusDate, 120)  = '".$statusdate_st."'";
				array_push($check_datefilter, 'TRUE');
			else:
				array_push($check_datefilter, 'FALSE');
			endif;
				
			if(!empty($statusdate_ed)):
				$wheres .= " AND CONVERT(nvarchar(10), StatusDate, 120)  = '".$statusdate_ed."'";
				array_push($check_datefilter, 'TRUE');
			else:
				array_push($check_datefilter, 'FALSE');
			endif;
		
		}
		
		if(!empty($dateplan_start) && !empty($dateplan_end)) {
			$wheres .= " AND CONVERT(nvarchar(10), PlanDrawdownDate, 120) BETWEEN '".$dateplan_start."' AND '".$dateplan_end."'";
			array_push($check_datefilter, 'TRUE');
				
		} else {
		
			if(!empty($dateplan_start)):
				$wheres .= " AND CONVERT(nvarchar(10), PlanDrawdownDate, 120)  = '".$dateplan_start."'";
				array_push($check_datefilter, 'TRUE');
			else:
				array_push($check_datefilter, 'FALSE');
			endif;
				
			if(!empty($dateplan_end)):
				$wheres .= " AND CONVERT(nvarchar(10), PlanDrawdownDate, 120)  = '".$dateplan_end."'";
				array_push($check_datefilter, 'TRUE');
			else:
				array_push($check_datefilter, 'FALSE');
			endif;
		
		}
		
		if(!empty($actualdate_st) && !empty($actualdate_ed)) {
			$wheres .= " AND CONVERT(nvarchar(10), DrawdownDate, 120) BETWEEN '".$actualdate_st."' AND '".$actualdate_ed."'";
			array_push($check_datefilter, 'TRUE');
		
		} else {
		
			if(!empty($actualdate_st)):
				$wheres .= " AND CONVERT(nvarchar(10), DrawdownDate, 120)  = '".$actualdate_st."'";
				array_push($check_datefilter, 'TRUE');
			else:
				array_push($check_datefilter, 'FALSE');
			endif;
				
			if(!empty($actualdate_ed)):
				$wheres .= " AND CONVERT(nvarchar(10), DrawdownDate, 120)  = '".$actualdate_ed."'";
				array_push($check_datefilter, 'TRUE');
			else:
				array_push($check_datefilter, 'FALSE');
			endif;
		
		}
		
		if(!empty($drawdown_cm)):
			$previos = trim(substr(date('Y-m-d', strtotime(date("Y-m-d"))), 0, 8).'01');
			$current = trim(date('Y-m-').date('t', strtotime(date("Y-m-d"))));
			$wheres .= " AND CONVERT(nvarchar(10), DrawdownDate, 120) BETWEEN '".$previos."' AND '".$current."'";
			array_push($check_datefilter, 'TRUE');
		else:
			array_push($check_datefilter, 'FALSE');
		endif;
		
		// Loan Range
		if(!empty($rqloan_start) && !empty($rqloan_end)) { $wheres .= " AND RequestLoan BETWEEN '".$rqloan_start."' AND '".$rqloan_end."'"; }
		else {
		
			if(!empty($rqloan_start)) { $wheres .= " AND RequestLoan = '".$rqloan_start."'"; }
			if(!empty($rqloan_end)) { $wheres .= " AND RequestLoan = '".$rqloan_end."'"; }		
		}
		
		if(!empty($appLoan_start) && !empty($appLoan_end)) { $wheres .= " AND ApprovedLoan BETWEEN '".$appLoan_start."' AND '".$appLoan_end."'"; }
		else {
		
			if(!empty($appLoan_start)) { $wheres .= " AND ApprovedLoan = '".$appLoan_start."'"; }
			if(!empty($appLoan_end)) { $wheres   .= " AND ApprovedLoan = '".$appLoan_end."'"; }
		
		}
		
		if(!empty($actualbaht_st) && !empty($actualbaht_ed)) { $wheres .= " AND DrawdownBaht BETWEEN '".$actualbaht_st."' AND '".$actualbaht_ed."'"; }
		else {
		
			if(!empty($actualbaht_st)) { $wheres .= " AND DrawdownBaht = '".$actualbaht_st."'"; }
			if(!empty($actualbaht_ed)) { $wheres .= " AND DrawdownBaht = '".$actualbaht_ed."'"; }
		
		}
		
		if(!empty($defend_list)) { $wheres .= " AND IsDefend = '".$defend_list."'"; }
		if(!empty($wheres_retrieve)) { $wheres .= " AND LatestEvent in ($wheres_retrieve)"; }
		
		// Optional Query
		if(!empty($caname)) { $wheres .= " AND CAName LIKE '%".$this->effective->set_chartypes($this->char_mode, $caname)."%'"; }
		
		if(!empty($ownerName)) {
			$wheres_name .= " AND MainLoanName LIKE '%".$this->effective->set_chartypes($this->char_mode, $ownerName)."%'";
		}
		
		if($activerows == "Active") { $wheres .= " AND ActiveRecord = '".$activerows."'"; } 
		if($activerows == "InActive") { $wheres .= " AND ActiveRecord = '".$activerows."'"; }

		// Condition: Check Date
		if(!in_array('TRUE', $check_datefilter)) {
				
			if($activerows == "Active" && empty($ncbdate_start) && empty($ncbdate_end)) {
				$wheres .= " AND NOT StartDate BETWEEN '1900-01-01' AND '2014-12-31'";
			}
				
			if($activerows == "InActive" && empty($ncbdate_start) && empty($ncbdate_end) && empty($ownerName)) {
				$start_ncb_date	= trim(substr(date('Y-m-d', strtotime('-3 MONTH')), 0, 8).'01');
				//$start_ncb_date	= trim(date('Y-m-').'01');
				$end_ncb_date	= trim(date('Y-m-').date('t', strtotime(date("Y-m-d"))));
				$wheres .= " AND StatusDate BETWEEN '".$start_ncb_date."' AND '".$end_ncb_date."'";
					
			}
				
			if($activerows == "All" && empty($ncbdate_start) && empty($ncbdate_end) && empty($ownerName)) {
				$previos = trim(substr(date('Y-m-d', strtotime('-3 MONTH')), 0, 8).'01');
				$current = trim(date('Y-m-').date('t', strtotime(date("Y-m-d"))));
				$wheres .= " AND StartDate BETWEEN '".$previos."' AND '".$current."'";
			}
		
		}	
		
		if(!empty($filter_cncancel)) { $wheres .= " AND StatusReason = 'CANCEL CN003'";	}
				
		if(!empty($regionid)) { $wheres .= " AND RegionID = '".trim(str_pad($regionid, 2, "0", STR_PAD_LEFT))."'"; }
		if(!empty($pieces[0])) { $wheres .= " AND BranchDigit in ($where_brachs) "; }
		if(!empty($product_pieces[0])) { $wheres .= " AND ProductCode in ($wheres_product) "; }
		if(!empty($loantype_piece[0])) { $wheres .= " AND ProductLoanType in ($wheres_loantype) "; }
		if(!empty($obj_status[0])) { $wheres .= " AND StatusDesc in ($wheres_status) "; }
		if(!empty($statusreason_pieces[0])) { $wheres .= " AND StatusReason in ($wheres_statusreaon) "; }
		if(!empty($rmlist_pieces[0])) { $wheres .= " AND RMCode in ($wheres_rmlist) "; }
		if(!empty($refer_pieces[0])) { $wheres .= " AND SourceOfCustomer in ($wheres_refer) "; }
		if($restimated == 'Y') { $wheres .= " AND ReceivedEstimateDoc = '".$restimated."'"; }
		if($aip_reason == 'Y') { $wheres .= " AND IsAIP = '".$aip_reason."'"; }
		if($cashy_field == 'Y') { $wheres .= " AND Cashy IS NOT NULL"; }
		else if($cashy_field == 'N') { $wheres .= " AND Cashy IS NULL"; }
			
		$summary = $this->dbcustom->dataTableDashboardGrandTotal($this->authorized, array($this->emp_id), array($where_addition, $wheres_name, $wheres, $wheres_kpi), $kpi_search, $mode_kpi, $modestate, $kpi_no, $emp_kpi, $kpi_condition, $kpi_privileges);
	
		header('Content-type: application/json; charset="UTF-8"');
		echo json_encode($summary);
		
	}
	
	public function dashboard_frame() {
		echo '<h2>ยกเลิกการใช้งาน</h2>';
		
		/*
		$this->load->model('dbmodel');
		$this->load->model('dbcustom');
		$this->load->model('dbprogress');
		$this->load->library('effective');
		
		$this->pages                	= "../report/dashboard/dashboard";
		$this->data['char_mode']		= $this->char_mode;		
		$this->data['AreaRegion']		= $this->dbmodel->loadData($this->table_region, 'RegionID, RegionNameEng', array("RegionNameEng !=" => "BKK - HQ", 'IsActive' => 'A'));
		$this->data['AreaBoundary']		= $this->dbprogress->appProgressBranch($this->authorized, array($this->emp_id));
		
		$this->data['stylesheet']		= array('../js/plugin/malihuscrollbar/jquery.mCustomScrollbar.min', 'kalendea/kalendae', 'multi-select/multiple-select', 'webui-popover/jquery.webui-popover', 
			//'../js/dataTables/plugin/buttons.dataTables.min'
		);
		$this->data['javascript']		= array(
			'moment.min', 'plugin/malihuscrollbar/jquery.mCustomScrollbar.concat.min', 'kalendea/kalendae.standalone.min', 'dataTables/media/js/jquery.dataTables.min', 'dataTables/extensions/Responsive/js/dataTables.responsive.min', 'vendor/jquery.truncate.min', 'vendor/jquery.mask.min', 'vendor/jquery.number.min', 'vendor/jquery.multiple.select', 'plugin/webui-popover/jquery.webui-popover.min', 'plugin/pdf_thumbnails/pdf.worker', 'plugin/pdf_thumbnails/pdf'
			//, 'dataTables/plugin/dataTables.buttons.min' 
			//, 'dataTables/plugin/buttons.flash.min'
			//, 'dataTables/plugin/jszip.min'
			//, 'dataTables/plugin/pdfmake.min'
			//, 'dataTables/plugin/vfs_fonts'	
			//, 'dataTables/plugin/buttons.html5.min'
			//, 'dataTables/plugin/buttons.print.min'
		);
		
		$this->_renders($this->pages_default, 'customiz');
		*/
	}
	
	
	public function docrefunds() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
	
		$doc_id                = $this->input->post("doc");
		$docno                 = $this->input->post('docno');
		$hqreceive             = $this->input->post('hqreceive');
		$docfromca             = $this->input->post('docfromca');
		$hqreceiveby           = $this->input->post('hqreceiveby');
		$hqfromcaby            = $this->input->post('hqfromcaby');
		
		$collection = array(
				"DocNo"				=> $docno,
				"HQGetDocBy"        => $hqreceiveby,
				"HQGetDocDate"      => $hqreceive,
				"HQGetDocFromCABy"  => $hqfromcaby,
				"HQGetDocFromCA"    => $docfromca,
		);
		
		$filter = array();
		for($i=0; $i < count($collection['DocNo']); $i++) {
		
			array_push($filter, array(
				"DocID" 			=> $doc_id,
				"DocNo"             => $collection['DocNo'][$i],
				"HQGetDocBy" 		=> $this->effective->set_chartypes($this->char_mode, $collection['HQGetDocBy'][$i]),
				"HQGetDocDate" 		=> $this->effective->StandartDateSorter($collection['HQGetDocDate'][$i]),
				"HQGetDocFromCABy"  => $this->effective->set_chartypes($this->char_mode, $collection['HQGetDocFromCABy'][$i]),
				"HQGetDocFromCADate"=> $this->effective->StandartDateSorter($collection['HQGetDocFromCA'][$i])
			));
		
		}
		 
		$i=0;
		foreach($filter as $index => $value) {
		
			$filte_checked = $this->dbmodel->data_validation($this->table_docrefund, "DocID", array("DocID" => $doc_id, "DocNo" => $filter[$index]['DocNo']), false);
			if($filte_checked == 'TRUE') {
				$pass = $this->dbmodel->exec($this->table_docrefund, $filter[$index], array("DocID" => $doc_id, "DocNo" => $filter[$index]['DocNo']), 'update');
		
			} else {
				$pass = $this->dbmodel->exec($this->table_docrefund, $filter[$index], false, 'insert');
				 
			}
			$i++;
			 
		}
		 
		if($pass == TRUE) {
			
			echo json_encode(array(
					"status"  => true,
					"process" => "success",
					"msg"     => "บันทึกข้อมูลเสร็จสิ้น."
				)
			);
			
		} else {
			 
			log_message('error', 'method '.__METHOD__ .' not had create document refund at processes beginner. please your check object.');
			echo json_encode(array(
                "status"  => false,
                "process" => 'exception',
             	"msg"     => "บันทึกข้อมูลผิดพลาด, โปรดติดต่อผู้ดูแลระบบ"
            ));
			 
		}
		
	
	}
	
	
	/** End Report **/


    /** Function */
    // prepare handle
    public function prepareInput($handles) {
        if (!empty($handles)) return $handles;
        else return null;
    }
    
    public function prepareChecked($handles) {
    	if (!empty($handles)) return $handles;
    	else return null;
    
    }
    
    // Code Mapping
    public function productDetail($product_id) {
    	$this->load->model('dbmodel');
    	$product = $this->dbmodel->loadData($this->table_product, "*", array("ProductCode" => $product_id));
    	return $product;
    }
    
    private static function compare_date($array) {
    		
    	if(!is_array($array)) { return;}
    		
    	if((!array_key_exists('begin', $array)) || empty($array['begin'])){ return;}
    	if((!array_key_exists('end', $array)) || empty($array['end'])){ return; }
    		
    	$begin_time  = strtotime( $array['begin'] );
    	$end_time 	 = strtotime( $array['end'] );
    		
    	$amount_time = $end_time - $begin_time ;
    		
    	$list = array('day' => array('', '86400'));
    		
    	foreach($list as $value):
    		
    		$result = floor($amount_time / $value[1]);
    		$join   = explode(" ", $result);
    		
    	endforeach;
    		
    	return implode('', $join);
    		
    
    }
    
    private function compare_checkdate($date1,$date2) {
    	$arrDate1 = explode("-", $date1);
    	$arrDate2 = explode("-", $date2);
    	$timStmp1 = mktime(0, 0, 0, $arrDate1[1], $arrDate1[2], $arrDate1[0]);
    	$timStmp2 = mktime(0, 0, 0, $arrDate2[1], $arrDate2[2], $arrDate2[0]);
    	
    	if ($timStmp1 >= $timStmp2) {
    		return 'TRUE';
    	} else {
    		return 'FALSE';
    	}
    }
    
    // For whiteboard only
    private function countDistinctDay($ncbdate, $status = "", $drawdown = "", $statusdate) {
    	if($ncbdate == "") {
    
    	} else {
    
    		if($drawdown != "" && $status == "A") {
    			return self::compare_date(array('begin'=> $ncbdate,'end'=> $drawdown));
    
    		} else {
    
    			switch($status) {
    				case 'C':
    					return self::compare_date(array('begin'=> $ncbdate,'end'=> $statusdate));
    					break;
    				case 'R':
    					return self::compare_date(array('begin'=> $ncbdate,'end'=> $statusdate));
    					break;
    				case 'A':
    				case 'P':
    				case 'PA':
    				case 'CR':
    				case '':
    				case null:
    				default:
    					return self::compare_date(array('begin'=> $ncbdate,'end'=> date('Y-m-d')));
    					break;
    						
    			}
    
    		}
    
    	}
    }
    
    
    // CountDistinctDay Update    
    private static function calDistinctDaySpecify($Dates = array(), $status, $option) {
    	
    	switch($status) {
    		case 'A':
    			
    			if($Dates[0] != "" && $option != "") {
    				return self::compare_date(array('begin'=> $Dates[0], 'end'=> $option));
    			} else {
    				return self::compare_date(array('begin'=> $Dates[0], 'end'=> date('Y-m-d')));
    			}

    			break;
    		case 'C':
    		case 'R':    		
    			return self::compare_date(array('begin'=> $Dates[0], 'end'=> $Dates[1]));
    			break;
    		case 'P':
    		case 'CR':
    		case '':
    		case null:
    		default:
    			return self::compare_date(array('begin'=> $Dates[0], 'end'=> date('Y-m-d')));
    			break;
    	}
    	
    }
    
    private static function calDistinctDays($session, $Dates = array(), $status, $gate) {
    	if(empty($session)) {
    		throw new Exception("Error, Please your are checked arsgument in function.");
    		
    	} else {

    		switch ($session) {
    			case "A2CA":
    				
    				if($gate == "G1") {
    					
    					if($Dates[0] != "" && $Dates[1] != ""):
    						return self::compare_date(array('begin'=> $Dates[0], 'end'=> $Dates[1]));
    					
    					else:
    							
		    				if($status != "C" || $status != "R"):
		    					return self::compare_date(array('begin'=> $Dates[0], 'end'=> date('Y-m-d')));
		    						
		    				else:
	    					return self::compare_date(array('begin'=> $Dates[0], 'end'=> $Dates[1]));
	    						
	    					endif;
    							
    					endif;
    													
    				} 
    				
    				break;
    			case "STATE":

    					switch($status) {
    						case 'C':
    						case 'R':
    						case 'A':
    							return self::compare_date(array('begin'=> $Dates[0], 'end'=> $Dates[1]));
    							break;
    						case 'P':
    						case 'CR':
    						case '':
    						case null:
    						default:
    							return self::compare_date(array('begin'=> $Dates[0], 'end'=> date('Y-m-d')));
    							break;
    					}
    				
    				break;
    			case "DDSTATE":
    				
    				if($gate == "G3") {
    					
    					if($status == 'A' || $status == 'C' || $status == 'R') {
    						
    						if($Dates[0] != "" && $Dates[1] != "" && $status == 'A' || $status == 'C' || $status == 'R'):
    							return self::compare_date(array('begin'=> $Dates[0], 'end'=> $Dates[1]));
    						else:
    							return self::compare_date(array('begin'=> $Dates[0], 'end'=> date('Y-m-d')));
    						endif;
    						
    					}
    					
    					
    				} 
    				
    				break;    		
    		}
    		
    		
    	}
    	
    }
    
    // Document Management
    public function vwDocManagement() {
    	
    	$this->data['getSFEList']		= $this->getGroupSFEList();
    	
		$this->pages  = "doc_management/doc_manage";		
		$this->data['javascript']	= array('build/doc_management/docmanage_initial');
				
    	$this->_renders($this->pages_default, 'customiz');
    	
    }
    
    public function fnReconcileNCB() {
    	$this->load->model('dbmodel');
    	$this->load->model('dbprogress');
    	$this->load->library('effective');
    	
    	$this->pages 			    	= "doc_management/doc_ncbconsent";
		$this->data['char_mode']		= $this->char_mode;
		$this->data['SourceField']		= $this->getSourceFields();
		$this->data['AreaRegion']		= $this->dbmodel->loadData($this->table_region, 'RegionID, RegionNameEng', array("RegionNameEng !=" => "BKK - HQ", 'IsActive' => 'A'));
		$this->data['AreaBoundary']		= $this->dbprogress->appProgressBranch($this->authorized, array($this->emp_id));
		$this->data['user_role']	 	= $this->getRole($this->authorized[0], $this->branch_code);
		
		$this->data['stylesheet']	= array('kalendea/kalendae', 'multi-select/multiple-select');
		$this->data['javascript']	= array('kalendea/kalendae.standalone.min', 'dataTables/media/js/jquery.dataTables.min', 'vendor/jquery.truncate.min', 'vendor/jquery.number.min', 'vendor/jquery.multiple.select');
		
		$this->_renders($this->pages_default, 'customiz');
    	
    }
     
    public function fnDocController() {
    	$this->load->model('dbmodel');
    	$this->load->model('dbprogress');

    	$this->data['AreaRegion']		= $this->dbmodel->loadData($this->table_region, 'RegionID, RegionNameEng', array("RegionNameEng !=" => "BKK - HQ", 'IsActive' => 'A'));
    	$this->data['AreaBoundary']		= $this->dbprogress->appProgressBranch($this->authorized, array($this->emp_id));
    	 
    	
    	$this->pages  = "doc_management/doc_controller";
    	$this->load->view($this->pages_customiz.$this->pages, $this->data);
    	
    }
    
    // Document Management Component: Data initialyze
    public function getReconcileNCBList() {
    	
    	$this->load->model('dbgener');
    	$this->load->library('effective');
    	 
    	$results = $this->dbgener->getRequestReconcileNCB();
    	$iTotal  = $this->dbgener->getRequestReconcileNCBPagination();
    	 
    	foreach($results['data'] as $index => $value) {
    		 
    		$day_diff = self::compare_date(array('begin'=> $results['data'][$index]['CheckNCBDate'],'end'=> date('Y-m-d')));
    		if($day_diff > 99) {
    			$days = 99;
    	
    		} else {
    			$days = $day_diff;
    	
    		}
    	
    
    		$brnSendNCB = !empty($results['data'][$index]['BrnSentNCBDate']) ? 
    		'<abbr title="'.$this->effective->StandartDateRollback($results['data'][$index]['BrnSentNCBDate']).'" style="border:none;">ส่งเอกสารแล้ว':"<span class=\"text-muted\">รอดำเนินการ &nbsp;</span>";
    		if(!empty($results['data'][$index]['BrnSentNCBDate'])) {
    			$brn_status = '<i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i> '.$brnSendNCB;
    			 
    		} else {
    			$brn_status = '<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i> '.$brnSendNCB;
    			 
    		}

    		$HQSendNCB = !empty($results['data'][$index]['HQGetNCBDate']) ? 
    		'<abbr title="'.$this->effective->StandartDateRollback($results['data'][$index]['HQGetNCBDate']).'" style="border:none;">รับเอกสารแล้ว':"<span class=\"text-muted\">รอรับเอกสาร &nbsp;</span>";
    		if(!empty($results['data'][$index]['HQGetNCBDate'])) {
    			$hq_status = '<i class="fa fa-circle" style="color: #60a917; font-size: 1.5em; cursor: pointer;"></i> '.$HQSendNCB;
    		
    		} else {	
    			$hq_status = '<i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i> '.$HQSendNCB;
    		
    		}
    		
    		switch($results['data'][$index]['CheckNCB']) {
    			case '1':
    			case '3':
    				$status = '<abbr title="ผ่านการตรวจสอบ" style="border: 0;"><i class="fa fa-circle fg-green on-left" style="font-size: 1.5em; cursor: pointer;"></i></abbr>';
    				break;
    			case '0';
    			case '2':
    				$status = '<abbr title="ไม่ผ่านการตรวจสอบ" style="border: 0;"><i class="fa fa-circle fg-red on-left" style="font-size: 1.5em; cursor: pointer;"></i></abbr>';
    				break;
    				
    			default:
    				$status = '<i class="icon-help text-muted on-left" style="font-size: 1.5em; cursor: pointer;"></i> Unknow';
    				break;
    		}
    		 
    		$columns[] = array(
    				"DocID"			 => $results['data'][$index]['DocID'],
    				"CheckNCBDate" 	 => !empty($results['data'][$index]['CheckNCBDate']) ? $this->effective->StandartDateRollback($results['data'][$index]['CheckNCBDate']):"-",
    				"DAY"			 => $days,
    				"CheckNCB"		 => $status,
    				"BrnSentNCBDate" => $brn_status,
    				"HQGetNCBDate"	 => $hq_status,
    				"HQToOper"		 => $results['data'][$index]['HQSentNCBToOperDate'],
    				"BranchDigit"	 => $results['data'][$index]['BranchDigit'],
    				"BorrowerType"	 => '',
    				"OwnerName"		 => '<abbr title="Phone : '.$results['data'][$index]['Mobile'].'" style="border:none;">'.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['OwnerName']).'</abbr>',
    				"RMName"		 => '<abbr title="Phone : '.$results['data'][$index]['RMMobile'].'" style="border:none;">'.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['RMName']).'</abbr>'
    		);
    		 
    	}
    	 
    	$sOutput = array(
    			'draw'                => intval($this->input->post('draw')) ? intval($this->input->post('draw')) : 0,
    			'recordsTotal'        => $iTotal,
    			'recordsFiltered'     => $iTotal,
    			'data'                => $columns
    	);
    	 
    	echo json_encode($sOutput);
    	
    }
    
    // Document Management Component
    private function getDocManageSLA($mode, $Dates = array()) {
    	switch ($mode) {
    		case 'misx':
    		case 'recx':
    		case 'allx':
    		default:
    			
    			if($Dates[0] != "" && $Dates[1] != ""): return self::compare_date(array('begin'=> $Dates[0], 'end'=> $Dates[1]));
    			else: return self::compare_date(array('begin'=> $Dates[0], 'end'=> date('Y-m-d'))); 
    			endif;
					
			break;
    	}
    	
    }
    
    protected static function fnLightStateDisplays($mode, $Dates = array()) {

    	switch ($mode) {
    		case 'allx':
    		case 'misx':
    			
    			switch($Dates[2]) {
    				case 'Z1':
    					
	    					if($Dates[0] != "" && $Dates[1] != "") :
	    						return  '<i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i>';
	    					else :
	    						return  '<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i>';
	    					endif;
	    					
    					break;
    				case 'Z2':
    					
    						if($Dates[0]  != "" && $Dates[1]['CompletionDocDate'] == "" || $Dates[0] != "" && $Dates[1]['CompletionDocDate'] != ""):
    							$mode = '1';
    						endif;
    						
    						if($Dates[0] != "" && $Dates[1]['SentToCADate'] != ""):
    							$mode = '2';
    						endif;
    						
    						switch ($mode) {
    							case '1':
    								return '<abbr title="Status : Waiting for document." style="border:none;">'.'<i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i>'.'</abbr>';
    								break;
    							case '2':
    								return '<abbr title="Status : Completed." style="border:none;">'.'<i class="fa fa-circle" style="color: #60a917; font-size: 1.5em; cursor: pointer;"></i>'.'</abbr>';
    								break;
    							
    						}
    					
    					break;
    				
    			}
    		
    			break;
			case 'retx':
				
				switch($Dates[2]) {
					case 'Z1':
							
						if($Dates[0] != "" && $Dates[1] != "") :
							return  '<i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i>';
						else :
							return  '<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i>';
						endif;
				
						break;
					case 'Z2':
						
						if($Dates[0]  == "" && $Dates[1]['CompletionDocDate'] == "" || $Dates[0] != "" && $Dates[1]['CompletionDocDate'] != "" ||
						   $Dates[0]  == "" && $Dates[1]['SentToCADate'] == "" || $Dates[0] != "" && $Dates[1]['SentToCADate'] != ""):
						   $mode = '0';
						endif;
							
						if($Dates[0]  != "" && $Dates[1]['CompletionDocDate'] == "" || $Dates[0] != "" && $Dates[1]['CompletionDocDate'] != ""):
							$mode = '1';
						endif;
						
						if($Dates[0] != "" && $Dates[1]['SentToCADate'] != ""):
							$mode = '2';
						endif;
						
						switch ($mode) {
							case '0':   
								return '';
								break;
							case '1':
								return '<abbr title="Status : Waiting for document." style="border:none;">'.'<i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i>'.'</abbr>';
								break;
							case '2':
								return '<abbr title="Status : Completed." style="border:none;">'.'<i class="fa fa-circle" style="color: #60a917; font-size: 1.5em; cursor: pointer;"></i>'.'</abbr>';
								break;
									
						}
							
						break;
					case 'Z3':
							
						
						break;
				}
					
				break;
			case 'recx':
			default: 
				
					

					if($Dates[0] != "" && $Dates[1] != "") :
						return  '<i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i>';
					else :
					
						if($Dates[0] == "" && $Dates[1] == ""):
							return;
						else:
							return  '<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i>';
						endif;
						
					endif;
					
				break;
    		 
    	}
    	
    }
    
    public static function autoAddStack($data, $stack) {
    	$data_checked = array();
    	foreach($data['data'] as $index => $values) {
    	
    		if($data['data'][$index][$stack] == "") {
    			array_push($data_checked, array($stack => $data['data'][$index][$stack], "FALSE"));
    			 
    		} else {
    			array_push($data_checked, array($stack => $data['data'][$index][$stack], "TRUE"));
    		}
    	
    	}
    	
    	return $data_checked;
    } 
    
    public static function autoStackCol($data, $stack) {
    	$data_checked = array();
    	foreach($data['data'] as $index => $values) {
    		 
    		if($data['data'][$index][$stack] == "") {
    			array_push($data_checked, "FALSE");
    
    		} else {
    			array_push($data_checked, "TRUE");
    		}
    		 
    	}
    	 
    	return $data_checked;
    }
    
    private function dataReconInquiry($doc) {
    	$this->load->model('dbmodel');
    	
    	$field = "
    			CASE CONVERT(nvarchar(10), CreateDate, 120)
					WHEN '1900-01-01' THEN NULL
					ELSE CONVERT(nvarchar(10), CreateDate, 120)
				END AS CreateDate,
				CASE CONVERT(nvarchar(10), HQGetDocDate, 120)
					WHEN '1900-01-01' THEN NULL
					ELSE CONVERT(nvarchar(10), HQGetDocDate, 120)
				END AS HQGetDocDate,
				CASE CONVERT(nvarchar(10), HQGetDocFromCADate, 120)
					WHEN '1900-01-01' THEN NULL
					ELSE CONVERT(nvarchar(10), HQGetDocFromCADate, 120)
				END AS HQGetDocFromCADate,
				CASE CONVERT(nvarchar(10), BranchGetDocDate, 120)
					WHEN '1900-01-01' THEN NULL
					ELSE CONVERT(nvarchar(10), BranchGetDocDate, 120)
				END AS BranchGetDocDate";
    	
    	$result   = $this->dbmodel->loadData($this->table_docrefund, $field, array('DocID' => $doc));
    	return $result;
    	
    }
    
    public function fnLeepLighterChange($doc) {
    	
    	$result 	= $this->dataReconInquiry($doc);
    	 
    	$createdate = self::autoStackCol($result, "CreateDate");
    	$hqgetdocbr = self::autoStackCol($result, "HQGetDocDate");
    	$hqgetdocca = self::autoStackCol($result, "HQGetDocFromCADate");
    	$brgetdoc 	= self::autoStackCol($result, "BranchGetDocDate");
    	$totals		= array_merge($createdate, $hqgetdocbr, $hqgetdocca, $brgetdoc);
    	    	
    	if(in_array("FALSE" , $createdate)) {
    		return '<i class="fa fa-circle" style="color: #666666; font-size: 1.5em; cursor: pointer;"></i>';
    		 
    	} else {
    		
    		if(!in_array("FALSE" , $hqgetdocbr)) {
    			
    			if(!in_array("FALSE" , $hqgetdocca)) {
    				
    				if(!in_array("FALSE" , $brgetdoc)) {
    					
    					if(!in_array("FALSE" , $totals)) {
    						return '<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i>';
    					} else {
    						return '<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i>';
    					}
    					
    				} else {
    					return '<i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i>';

    				}
    				
    				
    			} else {
    				return '<i class="fa fa-circle" style="color: #60a917; font-size: 1.5em; cursor: pointer;"></i>';
    			
    			}
    			
    		} else {
    			return '<i class="fa fa-circle" style="color: #666666; font-size: 1.5em; cursor: pointer;"></i>';
    			
    		}
    	
    	}
    	
    	
    }
    
    public function fnArsortDateInReconcileDoc($doc) {
    	$result 	= $this->dataReconInquiry($doc);
    	 
    	$sorter		= array();
    	for($i= 0; $i < count($result['data']); $i++) {
    		array_push($sorter, $result['data'][$i]['CreateDate']);
    	}
    	 
    	//rsort($sorter); // high to low
    	sort($sorter); // low to high
    	return $sorter[0];
    	 
    }
    
    private function fnNumSLAPointChange($doc) {
    	
    	$result 	= $this->dataReconInquiry($doc);
    	
    	$createdate = self::autoAddStack($result, "CreateDate");
    	$hqgetdocbr = self::autoAddStack($result, "HQGetDocDate");
    	$hqgetdocca = self::autoAddStack($result, "HQGetDocFromCADate");
    	$brgetdoc 	= self::autoAddStack($result, "BranchGetDocDate");
    	
    	for($i= 0; $i < count($result['data']); $i++) {
    		 
    		if(!in_array("FALSE", $hqgetdocbr[$i])) {
    	
    			if(!in_array("FALSE", $hqgetdocca[$i])) {
    				 
    				if(!in_array("FALSE", $brgetdoc[$i])) {
    					rsort($brgetdoc);
    					return $this->numLightState($this->limitDistinctDays($this->getDocManageSLA('retx', array($createdate[0]['CreateDate'], $brgetdoc[0]['BranchGetDocDate'], 'Z3'))));
    					 
    				} else {
    					rsort($hqgetdocca);
    					return $this->numLightState($this->limitDistinctDays($this->getDocManageSLA('retx', array($createdate[0]['CreateDate'], $hqgetdocca[0]['HQGetDocFromCADate'], 'Z3'))));
    					 
    				}
    				 
    			} else {
    				rsort($hqgetdocbr);
    				return $this->numLightState($this->limitDistinctDays($this->getDocManageSLA('retx', array($createdate[0]['CreateDate'], $hqgetdocbr[0]['HQGetDocDate'], 'Z3'))));
    				 
    			}
    	
    		} else {
    			return $this->numLightState($this->limitDistinctDays($this->getDocManageSLA('retx', array($createdate[0]['CreateDate'], '', 'Z3'))));
    	
    		}
    		 
    	}
    	
    }
    
    private static function fnDocRouter($mode) {
    	if(empty($mode)) :
    		throw new Exception('Error handled, Please you are check argusment.');
    		
    	else:
    	
    		switch ($mode) {
    			
    			case 'r2cx': return 'recx'; break; // A2CA Reconcile
    			case 'm2cx': return 'misx'; break; // Completion
    			case 'r2cl': return 'retx'; break; // Return
    			case 'a2lx': return 'allx'; break; // All 
    			
    		}
    	
    	endif;
    	
    }
    
    public function getDocManagementResults() {
    	$this->load->model('dbdocmanage');
    	$this->load->library('effective');
    	
    	$draft = $this->input->post('slmode');
    	$mode  = self::fnDocRouter($draft);

  		try {
  			
  			$results = $this->dbdocmanage->getLayerAuthority($mode, $this->authorized, array($this->emp_id)); 
  			$iTotal	 = $this->dbdocmanage->getLayerPaginationAuthority($mode, $this->authorized, array($this->emp_id));
  			
	  		switch($mode) {
	  			case 'allx':
	  				// All
	  				foreach($results['data'] as $index => $value) {
	  						
	  					$columns[] = array(
	  							"DocID" 			 => $results['data'][$index]['DocID'],
	  							"EMSNo" 			 => strtoupper($results['data'][$index]['EMSNo']),
	  							"EMSDate" 	 		 => $this->effective->StandartDateRollback($results['data'][$index]['EMSDate']),
	  							"EMSDay" 			 => $this->numLightState($this->limitDistinctDays($this->getDocManageSLA($mode, array($results['data'][$index]['EMSDate'], $results['data'][$index]['HQReceiveCADocDate'])))),
	  							"EMSStatus"	 		 => '<abbr title="Submit document to HQ : '.$this->effective->StandartDateRollback($results['data'][$index]['HQReceiveCADocDate']).'" style="border:none;">'.$this->fnLightStateDisplays($mode, array($results['data'][$index]['EMSDate'], $results['data'][$index]['HQReceiveCADocDate'], 'Z1')).'</abbr>',
	  							"SentToCADate"	 	 => $this->effective->StandartDateRollback(!empty($results['data'][$index]['CompletionDocDate']) ? $results['data'][$index]['CompletionDocDate']:$results['data'][$index]['SentToCADate']),
	  							"CompletionNum" 	 => $results['data'][$index]['MissingDocNum'],
	  							"CompletionDay"	 	 => $this->numLightState($this->limitDistinctDays($this->getDocManageSLA($mode, array($results['data'][$index]['HQReceiveCADocDate'], !empty($results['data'][$index]['CompletionDocDate']) ? $results['data'][$index]['CompletionDocDate']:$results['data'][$index]['SentToCADate'])))),
	  							"CompletionState"	 => $this->fnLightStateDisplays($mode, array($results['data'][$index]['HQReceiveCADocDate'],  array("CompletionDocDate" => $results['data'][$index]['CompletionDocDate'], "SentToCADate" => $results['data'][$index]['SentToCADate']), 'Z2', $results['data'][$index]['CompletionDoc'], $results['data'][$index]['SentDocToCA'])),
	  							"ReturnDate"		 => null,
	  							"ReturnNum" 		 => null,
	  							"ReturnDay" 		 => null,
	  							"ReturnState"	     => null,
	  							"NCBState"		 	 => null,
	  							"BranchDigit"    	 => '<abbr title="Phone : " style="border:none;">'.$results['data'][$index]['BranchDigit'].'</abbr>',
	  							"PeopleLoanTypes"	 => null,
	  							"OwnerName"      	 => !empty($results['data'][$index]['MainLoanName']) ? '<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.($this->effective->get_chartypes($this->char_mode, $results['data'][$index]['MainLoanName'])).'</abbr>':'<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.($this->effective->get_chartypes($this->char_mode, $results['data'][$index]['OwnerName'])).'</abbr>',
	  							"RMName"	    	 => '<abbr title="Phone : '.$results['data'][$index]['RMMobile'].'" style="border:none;">'.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['RMName']).'</abbr>'
	  					);
	  				}
	  					
	  				break;
				case 'misx':
					// Completion
					foreach($results['data'] as $index => $value) {
					
						$columns[] = array(
								"DocID" 			 => $results['data'][$index]['DocID'],
								"EMSNo" 			 => strtoupper($results['data'][$index]['EMSNo']),
								"EMSDate" 	 		 => $this->effective->StandartDateRollback($results['data'][$index]['EMSDate']),
								"EMSDay" 			 => $this->numLightState($this->limitDistinctDays($this->getDocManageSLA($mode, array($results['data'][$index]['EMSDate'], $results['data'][$index]['HQReceiveCADocDate'])))),
								"EMSStatus"	 		 => '<abbr title="Submit document to HQ : '.$this->effective->StandartDateRollback($results['data'][$index]['HQReceiveCADocDate']).'" style="border:none;">'.$this->fnLightStateDisplays($mode, array($results['data'][$index]['EMSDate'], $results['data'][$index]['HQReceiveCADocDate'], 'Z1')).'</abbr>',
								"SentToCADate"	 	 => $this->effective->StandartDateRollback(!empty($results['data'][$index]['CompletionDocDate']) ? $results['data'][$index]['CompletionDocDate']:$results['data'][$index]['SentToCADate']),
								"CompletionNum" 	 => $results['data'][$index]['MissingDocNum'],
								"CompletionDay"	 	 => $this->numLightState($this->limitDistinctDays($this->getDocManageSLA($mode, array($results['data'][$index]['HQReceiveCADocDate'], !empty($results['data'][$index]['CompletionDocDate']) ? $results['data'][$index]['CompletionDocDate']:$results['data'][$index]['SentToCADate'])))),
								"CompletionState"	 => $this->fnLightStateDisplays($mode, array($results['data'][$index]['HQReceiveCADocDate'],  array("CompletionDocDate" => $results['data'][$index]['CompletionDocDate'], "SentToCADate" => $results['data'][$index]['SentToCADate']), 'Z2', $results['data'][$index]['CompletionDoc'], $results['data'][$index]['SentDocToCA'])),
								"ReturnDate"		 => null,
								"ReturnNum" 		 => null,
								"ReturnDay" 		 => null,
								"ReturnState"	     => null,
								"NCBState"		 	 => null,
								"BranchDigit"    	 => '<abbr title="Phone : " style="border:none;">'.$results['data'][$index]['BranchDigit'].'</abbr>',
								"PeopleLoanTypes"	 => null,
								"OwnerName"      	 => !empty($results['data'][$index]['MainLoanName']) ? '<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.($this->effective->get_chartypes($this->char_mode, $results['data'][$index]['MainLoanName'])).'</abbr>':'<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.($this->effective->get_chartypes($this->char_mode, $results['data'][$index]['OwnerName'])).'</abbr>',
								"RMName"	    	 => '<abbr title="Phone : '.$results['data'][$index]['RMMobile'].'" style="border:none;">'.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['RMName']).'</abbr>'
						);
					}
					
					break;
				case 'retx':
					// Return Doc
					foreach($results['data'] as $index => $value) {
						
						$columns[] = array(
								"DocID" 			 => $results['data'][$index]['DocID'],
								"EMSNo" 			 => strtoupper($results['data'][$index]['EMSNo']),
								"EMSDate" 	 		 => $this->effective->StandartDateRollback($results['data'][$index]['EMSDate']),
								"EMSDay" 			 => $this->numLightState($this->limitDistinctDays($this->getDocManageSLA($mode, array($results['data'][$index]['EMSDate'], $results['data'][$index]['HQReceiveCADocDate'])))),
								"EMSStatus"	 		 => '<abbr title="Submit document to HQ : '.$this->effective->StandartDateRollback($results['data'][$index]['HQReceiveCADocDate']).'" style="border:none;">'.$this->fnLightStateDisplays($mode, array($results['data'][$index]['EMSDate'], $results['data'][$index]['HQReceiveCADocDate'], 'Z1')).'</abbr>',
								"SentToCADate"	 	 => $this->effective->StandartDateRollback(!empty($results['data'][$index]['CompletionDocDate']) ? $results['data'][$index]['CompletionDocDate']:$results['data'][$index]['SentToCADate']),
								"CompletionNum" 	 => $results['data'][$index]['MissingDocNum'],
								"CompletionDay"	 	 => $this->numLightState($this->limitDistinctDays($this->getDocManageSLA($mode, array($results['data'][$index]['HQReceiveCADocDate'], !empty($results['data'][$index]['CompletionDocDate']) ? $results['data'][$index]['CompletionDocDate']:$results['data'][$index]['SentToCADate'])))),
								"CompletionState"	 => $this->fnLightStateDisplays($mode, array($results['data'][$index]['HQReceiveCADocDate'],  array("CompletionDocDate" => $results['data'][$index]['CompletionDocDate'], "SentToCADate" => $results['data'][$index]['SentToCADate']), 'Z2', $results['data'][$index]['CompletionDoc'], $results['data'][$index]['SentDocToCA'])),
								"ReturnDate"		 => $this->effective->StandartDateRollback($this->fnArsortDateInReconcileDoc($results['data'][$index]['DocID'])),
								"ReturnNum" 		 => $results['data'][$index]['CountDocNo'],
								"ReturnDay" 		 => $this->fnNumSLAPointChange($results['data'][$index]['DocID']),
								"ReturnState"	     => $this->fnLeepLighterChange($results['data'][$index]['DocID']),
								"NCBState"		 	 => null,
								"BranchDigit"    	 => '<abbr title="Phone : " style="border:none;">'.$results['data'][$index]['BranchDigit'].'</abbr>',
								"PeopleLoanTypes"	 => null,
								"OwnerName"      	 => !empty($results['data'][$index]['MainLoanName']) ? '<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.($this->effective->get_chartypes($this->char_mode, $results['data'][$index]['MainLoanName'])).'</abbr>':'<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.($this->effective->get_chartypes($this->char_mode, $results['data'][$index]['OwnerName'])).'</abbr>',
								"RMName"	    	 => '<abbr title="Phone : '.$results['data'][$index]['RMMobile'].'" style="border:none;">'.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['RMName']).'</abbr>'
						);
					}
					
					break;
				case 'recx':
				default:
					// Reconcile Doc
					foreach($results['data'] as $index => $value) {
						
						$columns[] = array(
								"DocID" 			 => $results['data'][$index]['DocID'],
								"EMSNo" 			 => strtoupper($results['data'][$index]['EMSNo']),
								"EMSDate" 	 		 => $this->effective->StandartDateRollback($results['data'][$index]['EMSDate']),
								"EMSDay" 			 => $this->numLightState($this->limitDistinctDays($this->getDocManageSLA($mode, array($results['data'][$index]['EMSDate'], $results['data'][$index]['HQReceiveCADocDate'])))),
								"EMSStatus"	 		 => $this->fnLightStateDisplays($mode, array($results['data'][$index]['EMSDate'], $results['data'][$index]['HQReceiveCADocDate'])),
								"SentToCADate"		 => null,
								"CompletionNum" 	 => null,
								"CompletionDay"	 	 => null,
								"CompletionState"	 => null,
								"ReturnDate"		 => null,
								"ReturnNum" 		 => null,
								"ReturnDay" 		 => null,
								"ReturnState"	     => null,
								"NCBState"		 	 => null,
								"BranchDigit"    	 => '<abbr title="Phone : " style="border:none;">'.$results['data'][$index]['BranchDigit'].'</abbr>',
								"PeopleLoanTypes"	 => null,
								"OwnerName"      	 => !empty($results['data'][$index]['MainLoanName']) ? '<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.($this->effective->get_chartypes($this->char_mode, $results['data'][$index]['MainLoanName'])).'</abbr>':'<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.($this->effective->get_chartypes($this->char_mode, $results['data'][$index]['OwnerName'])).'</abbr>',
								"RMName"	    	 => '<abbr title="Phone : '.$results['data'][$index]['RMMobile'].'" style="border:none;">'.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['RMName']).'</abbr>'
						);
					}
				
				break;
				
  			}
  			
  		} catch(Exception $e) {
  			echo 'Caught Exception : '.$e->get_message();
  			
  		}
    	
    	
    	
    	$sOutput = array(
    			'draw'                => intval($this->input->post('draw')) ? intval($this->input->post('draw')) : 0,
    			'recordsTotal'        => $iTotal,
    			'recordsFiltered'     => $iTotal,
    			'data'                => $columns
    	);
    	
    	echo json_encode($sOutput);
    	 
    	
    } 
    
    private function limitDistinctDays($nums) {
    	if($nums > 99) {
    		return 99;
    
    	} else {
    		return $nums;
    
    	}
    
    }
        
    public static function numLightState($nums) {
    	if($nums <= 10) {
    		return '<div class="fg-emerald">'.$nums.'</div>';
    
    	} else if($nums >= 11 && $nums <= 20) {
    		return '<div class="fg-amber">'.$nums.'</div>';
    		 
    	} else if($nums >= 21) {
    		return '<div class="fg-red">'.$nums.'</div>';
    
    	}
    	 
    }
    
	public function loadRowEntries() {
		$this->load->model('dbgener');
		
		$mode = $this->input->post('sl');
		if(empty($mode)) {
			
		} else {
			
			try {
				
				switch($mode) {
					case '1':
						$iTotal  = $this->dbgener->getRequestReconcileNCBPagination();
						break;
					case '2':
						$iTotal  = $this->dbgener->getRequestReconcileDocPagination();
						break;
					case '3':
						$iTotal  = $this->dbgener->getRequestReturnDocPagination();
						break;
					case '4':
						$iTotal  = $this->dbgener->getRequestReturnDocPagination();
						break;
				}
				
				echo json_encode($iTotal);
				
			} catch (Exception $e) {
				echo 'Caught Exception : '.$e->get_message();
				
			}
			
		}
		
	} 

	// Retrive Module
	public function setRetrieveAllowByTransaction() {
		$this->load->model('dbstore');
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		$doc_id 		= $this->input->post('ref');
		$act_id 		= $this->input->post('xid');
		$act_name 		= $this->input->post('xnm');
		$retrieve		= $this->input->post('xdt');
		$application_no	= $this->input->post('app');
		$retrieve_date	= $this->effective->StandartDateSorter($retrieve);
	
		if(!empty($doc_id) && !empty($act_id)) {
				
			$actor  = array(
					"DocID" 		=> $doc_id,
					"EmployeeCode" 	=> $act_id,
					"EmployeeName" 	=> $act_name,
					"RetrieveDate" 	=> $retrieve_date,
					"IsActive"		=> 'A'
			);
				
				
			$case_holding		= array();
			$check_docref[] 	= $this->dbmodel->data_validation('Profile', 'DocID', array('DocID' => $doc_id), false);
			$check_docref[] 	= $this->dbmodel->data_validation('Verification', 'DocID', array('DocID' => $doc_id), false);
			$check_docref[]  	= $this->dbmodel->data_validation('ApplicationStatus', 'DocID', array('DocID' => $doc_id), false);
				
			if(!in_array('FALSE', $check_docref)) {
				
				$profile_disabled 	= $this->dbmodel->exec('Profile', array("IsEnabled" => 'N', 'ChangeDate' => $retrieve_date), array('DocID' => $doc_id), 'update');
				$verify_disabled 	= $this->dbmodel->exec('Verification', array("IsEnabled" => 'N', 'ChangeDate' => $retrieve_date), array('DocID' => $doc_id), 'update');
				$appstate_disabled  = $this->dbmodel->exec('ApplicationStatus', array("IsEnabled" => 'N', 'ChangeDate' => $retrieve_date), array('DocID' => $doc_id), 'update');
	
				if($profile_disabled): array_push($case_holding, 'TRUE');
				else: array_push($case_holding, 'FALSE'); endif;
				
				if($verify_disabled): array_push($case_holding, 'TRUE');
				else: array_push($case_holding, 'FALSE'); endif;
	
				if($appstate_disabled): array_push($case_holding, 'TRUE');
				else: array_push($case_holding, 'FALSE'); endif;
	
			} else {
				array_push($case_holding, array('TRUE', 'TRUE', 'TRUE'));
					
			}
				
			if(!in_array('FALSE', $case_holding)) {
				
				header('Content-Type: application/json; charset="utf-8"');
			
				// Inquery and into new data record.
				$getcust_info  	 = $this->getProfileInformation($doc_id);
				$getverify_info  = $this->dbmodel->CIQuery('SELECT BasicCriteria, CriteriaReasonID FROM Verification WHERE DocID = "'.$doc_id.'"');
				
				// clone data before delete data in object get_cust_info
				$criteria_dump 	 = $getverify_info['data'][0]['BasicCriteria'];
				$criteriaId_dump = $getverify_info['data'][0]['CriteriaReasonID'];
				
				// Document Identification Generate
				$doc_ref  = $this->DocGenerate();
				$checked  = $this->checkUniqueDoc($this->table_profile, substr(date("Y") + 543, 2).str_pad($doc_ref, 6, "0", STR_PAD_LEFT));
				
				if(!empty($getcust_info['DocID'])):
					unset($getcust_info['DocID']);					
					unset($getcust_info['CreateDate']);
					unset($getcust_info['CreateBy']);
					unset($getcust_info['IsActive']);	
					unset($getcust_info['IsEnabled']);
				endif;

				// Document unique identify
				if($checked['status'] == 'true') {			
					$ref_id     		= (int)$doc_ref + 1;
					$this->identify     = substr(date("Y") + 543, 2).str_pad($doc_ref, 6, "0", STR_PAD_LEFT);
					$objForms			= array_merge($getcust_info, array("DocID" => $this->identify, 'CreateDate' => date('Y-m-d H:i:s'), 'CreateBy' =>  $this->effective->set_chartypes($this->char_mode, $act_name), 'IsActive' => 'Y', 'IsEnabled' => 'A'));
			
				} else {						
					$this->identify     = substr(date("Y") + 543, 2).str_pad($doc_ref, 6, "0", STR_PAD_LEFT);
					$objForms			= array_merge($getcust_info, array("DocID" => $this->identify, 'CreateDate' => date('Y-m-d H:i:s'), 'CreateBy' =>  $this->effective->set_chartypes($this->char_mode, $act_name), 'IsActive' => 'Y', 'IsEnabled' => 'A'));
						
				}
	
				if(array_key_exists('DocID', $objForms)) {
										
					$create_profile = $this->dbmodel->exec($this->table_profile, $objForms, false, "insert");
					$create_verify  = $this->dbstore->exec_verification_bundledoc($this->identify, null, 'A', $this->effective->set_chartypes($this->char_mode, $act_name), date('Y-m-d H:i:s'), 1);
					$create_app   	= $this->dbstore->exec_appstate_bundledoc($this->identify, null, 'A', $this->effective->set_chartypes($this->char_mode, $act_name), date('Y-m-d H:i:s'), 1);

					if($create_profile == TRUE && $create_verify == TRUE && $create_app == TRUE) {
						$DocRunno = $this->dbmodel->exec($this->table_masterdoc, array("Runno" => (int)($doc_ref + 1)), array("CurrentYear" => date("Y")), "update");

						if($DocRunno == TRUE) {
							
							$verification = $this->dbmodel->exec($this->table_verification, array("BasicCriteria" => $criteria_dump, "CriteriaReasonID" => $criteriaId_dump), array("DocID" => $this->identify), 'update');
							$appstatus    = $this->dbmodel->exec('ApplicationStatus', array("ApplicationNo" => $application_no), array('DocID' => $this->identify), 'update');
							if($verification == TRUE && $appstatus == TRUE) {
								
								$responsed   = array(
									'ref'	 => $this->identify,
									'msg'	 => 'Retrieve Successfully. Plase wait...',
									'status' => true
								);
								
								$this->setRetrieveLogOnBundled($doc_id, $this->emp_id, $retrieve_date, $this->identify);
								
								header('Content-Type: application/json; charset="utf-8"');
								echo json_encode($responsed);
								
							}

						} else {
								
							$responsed   = array(
								'ref'	 => '',
								'msg'	 => 'เกิดข้อผิดพลาดในการอัพเดทข้อมูลรหัสเอกสาร กรุณาติดต่อผู้ดูแลระบบ.',
								'status' => false
							);						
								
							header('Content-Type: application/json; charset="utf-8"');
							echo json_encode($responsed);
								
						}
						
		
					} else {
		
						$responsed   = array(
							'ref'	 => '',
							'msg'	 => 'เกิดข้อผิดพลาดในการสร้างรหัสเอกสาร กรุณาติดต่อผู้ดูแลระบบ.',
							'status' => false
						);
							
						header('Content-Type: application/json; charset="utf-8"');
						echo json_encode($responsed);
		
					}
					
						
				} else {
						
					$responsed   = array(
							'ref'	 => '',
							'msg'	 => 'เกิดข้อผิดพลาดในการรับ-ส่งข้อมูล กรุณาตรวจสอบลองใหม่อีกครั้ง หรือติดต่อผู้ดูแลระบบ.',
							'status' => false
					);
						
					header('Content-Type: application/json; charset="utf-8"');
					echo json_encode($responsed);
				}		
		
	
			} else {
	
				$this->dbmodel->exec('Profile', array("IsEnabled" => 'A'), array('DocID' => $doc_id), 'update');
				$this->dbmodel->exec('Verification', array("IsEnabled" => 'A'), array('DocID' => $doc_id), 'update');
				$this->dbmodel->exec('ApplicationStatus', array("IsEnabled" => 'A'), array('DocID' => $doc_id), 'update');
	
				header('Content-Type: application/json; charset="utf-8"');
				echo json_encode(
					array(
						'ref'	 => '',
						'msg'	 => 'เกิดข้อผิดพลาดในการรับ-ส่งข้อมูล ระบบจะทำการยกเลิกการ retrieve ข้อมูล หรือติดต่อผู้ดูแลระบบ.',
						'status' => false	
					)				
				);
	
			}
				
		} else {
				
			$responsed   = array(
					'msg'	 => 'เกิดข้อผิดพลาดในการรับ-ส่งข้อมูล กรุณาตรวจสอบลองใหม่อีกครั้ง หรือติดต่อผู้ดูแลระบบ.',
					'status' => false
			);
				
			header('Content-Type: application/json; charset="utf-8"');
			echo json_encode($responsed);
		}
	
	}
	
	public function setRetrieveLogOnBundled($doc_id, $emp_code, $retrieve_date, $doc_ref) {
	
		$this->dbmodel->exec('Retrieve_TransactionLog',
		array(				'DocID'				=> $doc_id,
				"EmployeeCode"		=> $emp_code,
				"EventDate"			=> $retrieve_date,
				"EventTime"			=> date('H:i:s'),
				"RetrieveToNewDoc"  => $doc_ref,
				"IsActive"			=> 'A'
		), false, 'insert');
	
	}
	
	// Load Data And Convert
	private function checkRetrieveStatus($doc_id) {
		$this->load->model('dbstore');
			
		$result		= $this->dbstore->check_RetrieveStatus($doc_id);
		if(!empty($result)) {
			
			$data = array(
				'DocID'   	 	=> $result[0]['DocID'],
				'RMProcess'   	=> $result[0]['RMProcess'],
				'AppStatus'  	=> $result[0]['Status']
			);
			
			return $data;
			
		}
		
	}
	
	public function getPrivilegeRetrieveList() {
		$this->load->model('dbstore');

		$result		= $this->dbstore->getRetrieveAuthorityList();
		if(!empty($result)) {
		
			foreach ($result as $index => $values) {
				$data[] = $result[$index]['EmployeeCode'];
				
			}
				
			return $data;
				
		}
		
	}
	
	public function getSourceFields() {		
		$this->load->model('dbapp');		
		return $this->dbapp->getSourceFieldList();

	}
	
	private function getDataRetrieveLog($doc_id) {
		$this->load->model('dbstore');
	
		if(!empty($doc_id)):
	
		$result = $this->dbstore->exec_getDataRetrieve_Log($doc_id);
		if(!empty($result[0]['DocID'])) {
			return $result;
		} else {
			return;
		}
			
		else:
		return;
	
		endif;
	
	}
	
	private function getCustomerInformation($doc_id) {
		$this->load->model('dbstore');
		 
		$result		= $this->dbstore->exec_getCustomerInformation($doc_id);
		if(!empty($result)) {
			 
			$data = array(
					'DocID'   	 		 => $result[0]['DocID'],
					'CustType'   		 => $result[0]['CustType'],
					'Interest'  		 => $result[0]['Interest'],
					'SourceOfCustomer'   => $this->effective->get_chartypes($this->char_mode, $result[0]['SourceOfCustomer']),
					'SourceOption'  	 => $this->effective->get_chartypes($this->char_mode, $result[0]['SourceOption']),
					'CSPotential' 		 => $result[0]['CSPotential'],
					'OwnerType'   		 => $result[0]['OwnerType'],
					'PrefixName'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['PrefixName']),
					'OwnerName'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['OwnerName']),
					'BorrowerName'   	 => !empty($result[0]['BorrowerName']) ? $this->effective->get_chartypes($this->char_mode, $result[0]['BorrowerName']):"",
					'PrefixCorp'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['PrefixCorp']),
					'Company'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['Company']),
					'BusinessType'   	 => $this->effective->get_chartypes($this->char_mode, $result[0]['BusinessType']),
					'Business'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['Business']),
					'Telephone'   		 => $result[0]['Telephone'],
					'Mobile'   			 => $result[0]['Mobile'],
					'Downtown'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['Downtown']),
					'Address'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['Address']),
					'Province'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['Province']),
					'District'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['District']),
					'Postcode'   		 => $result[0]['Postcode'],
					'Channel'   		 => $result[0]['Channel'],
					'SubChannel'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['SubChannel']),
					'RequestLoan'   	 => $result[0]['RequestLoan'],
					'ReferralCode'   	 => $result[0]['ReferralCode'],
					'RegionID'   	 	 => $result[0]['RegionID'],
					'Region'   			 => $this->effective->get_chartypes($this->char_mode, $result[0]['Region']),
					'BranchCode'   	 	 => $result[0]['BranchCode'],
					'BranchDigit'   	 => $result[0]['BranchDigit'],
					'BranchTel'   	 	 => $result[0]['BranchTel'],
					'Branch'   			 => $this->effective->get_chartypes($this->char_mode, $result[0]['Branch']),
					'RMCode'   			 => $result[0]['RMCode'],
					'RMMobile'   		 => $result[0]['RMMobile'],
					'RMName'   			 => $this->effective->get_chartypes($this->char_mode, $result[0]['RMName']),
					'BMName'   			 => $this->effective->get_chartypes($this->char_mode, $result[0]['BMName']),
					'Remark'   			 => $this->effective->get_chartypes($this->char_mode, $result[0]['Remark']),
					'CAName'   			 => $this->effective->get_chartypes($this->char_mode, $result[0]['CAName']),
					'IsActive'   		 => $result[0]['IsActive'],
					'CreateBy'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['CreateBy']),
					'CreateDate'   		 => $result[0]['CreateDate'],
					'ChangeBy'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['ChangeBy']),
					'ChangeDate'   		 => $result[0]['ChangeDate'],
					'IsEnabled'  		 => $result[0]['IsEnabled']
			);
			 
			return $data;
		}
	
	}
	
	public function getGroupSFEList() {
		$this->load->model('dbstore');
	
		$data	= array();
		$result = $this->dbstore->exec_getGroupSFEList();
		foreach($result as $index => $values) {
			array_push($data, $result[$index]['EmployeeCode']);
	
		}
	
		return $data;
	
	}
	
	// Method for Retrieve.
	private function getProfileInformation($doc_id) {
		$this->load->model('dbstore');
			
		$result		= $this->dbstore->exec_getProfileProcessInfo($doc_id);
		if(!empty($result)) {
	
			$data = array(
					'DocID'   	 		 => $result[0]['DocID'],
					'CustType'   		 => $result[0]['CustType'],
					'Interest'  		 => $result[0]['Interest'],
					'SourceOfCustomer'   => $result[0]['SourceOfCustomer'],
					'SourceOption'  	 => $result[0]['SourceOption'],
					'CSPotential' 		 => $result[0]['CSPotential'],
					'OwnerType'   		 => $result[0]['OwnerType'],
					'PrefixName'   		 => $result[0]['PrefixName'],
					'OwnerName'   		 => $result[0]['OwnerName'],
					'PrefixCorp'   		 => $result[0]['PrefixCorp'],
					'Company'   		 => $result[0]['Company'],
					'BusinessType'   	 => $result[0]['BusinessType'],
					'Business'   		 => $result[0]['Business'],
					'Telephone'   		 => $result[0]['Telephone'],
					'Mobile'   			 => $result[0]['Mobile'],
					'Downtown'   		 => $result[0]['Downtown'],
					'Address'   		 => $result[0]['Address'],
					'Province'   		 => $result[0]['Province'],
					'District'   		 => $result[0]['District'],
					'Postcode'   		 => $result[0]['Postcode'],
					'Channel'   		 => $result[0]['Channel'],
					'SubChannel'   		 => $result[0]['SubChannel'],
					'RequestLoan'   	 => $result[0]['RequestLoan'],
					'ReferralCode'   	 => $result[0]['ReferralCode'],				
					'Region'   			 => $result[0]['Region'],
					'BranchCode'   	 	 => $result[0]['BranchCode'],		
					'Branch'   			 => $result[0]['Branch'],
					'RMCode'   			 => $result[0]['RMCode'],
					'RMMobile'   		 => $result[0]['RMMobile'],
					'RMName'   			 => $result[0]['RMName'],
					'BMName'   			 => $result[0]['BMName'],
					'Remark'   			 => $result[0]['Remark'],
					'IsActive'   		 => $result[0]['IsActive'],
					'IsEnabled'  		 => $result[0]['IsEnabled'],
					'CreateBy'   		 => $result[0]['CreateBy'],
					'CreateDate'   		 => $result[0]['CreateDate'],
					'ChangeBy'   		 => $result[0]['ChangeBy'],
					'ChangeDate'   		 => $result[0]['ChangeDate']
					
			);
	
			return $data;
		}
	
	}
	
}