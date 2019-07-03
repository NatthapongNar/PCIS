<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dbcustom extends CI_Model {
	
	private $object_kpi;
	private $individual_mode;
	private $branch_mode;
	
	// Relation
	private $table_branch;
	private $table_masteremployee;
	
	// Application Process
	private $table_profile;
	private $table_verification;
	private $table_applicationstatus;

	// Object Role
	protected  $role_ad;
	protected $role_rm;
	protected $role_bm;
	protected $role_am;
	protected $role_rd;
	protected $role_hq;
	protected $role_spv;
	protected $role_ads;
	
	
	
	public $db_types;

	public function __construct() {
		parent::__construct();
		$this->load->database("dbcustom");
		
		if(!is_resource($this->db->conn_id)) {
			$this->db->reconnect();
		}
				
		$this->table_profile                = $this->config->item('table_profile');
		$this->table_verification           = $this->config->item('table_verification');
		$this->table_applicationstatus      = $this->config->item('table_applicationstatus');
		$this->table_masteremployee         = $this->config->item('table_employee');
		$this->table_branch                 = $this->config->item('table_branch');
		$this->table_lendingemp             = $this->config->item('table_lendingemp');
		
		$this->role_ad 						= $this->config->item('ROLE_ADMIN');
		$this->role_rm 						= $this->config->item('ROLE_RM');
		$this->role_bm 						= $this->config->item('ROLE_BM');
		$this->role_am 						= $this->config->item('ROLE_AM');
		$this->role_rd 						= $this->config->item('ROLE_RD');
		$this->role_hq 						= $this->config->item('ROLE_HQ');
		$this->role_spv 					= $this->config->item('ROLE_SPV');
		$this->role_ads 					= $this->config->item('ROLE_ADMINSYS');
		
		$this->char_mode					= $this->config->item('char_mode');
		$this->db_types						= $this->config->item('database_types');	
		
		$this->object_kpi					= array(6);	
		$this->individual_mode				= 'individual';
		$this->branch_mode					= 'branchs';
		
	}
	
	public function getAreaInfo($brncode) {
		
		if(empty($brncode)) {
			
			return array(
					"data"   => array(0),
					"status" => "false",
					"msg"    => "Not found data.",
					"rows"   => 0
			);
			
		} else {
			
		 	$query = $this->db->query("
				SELECT 
				LendingBranchs.BranchCode, LendingBranchs.BranchName, LendingBranchs.BranchDigit,
				MasterRegion.RegionID, MasterRegion.RegionNameEng, MasterRegion.RegionNameTh
				FROM LendingBranchs
				LEFT OUTER JOIN MasterRegion
				ON LendingBranchs.RegionID = MasterRegion.RegionID
				WHERE LendingBranchs.BranchCode = '".$brncode."'");
		 	
			if($query->num_rows() > 0):
				return array(
						"data"   => $query->result_array(),
						"status" => "true",
						"msg"    => "Active Record Queries..",
						"rows"   => $query->num_rows()
				);
			else:
				return array(
						"data"   => array(0),
						"status" => "false",
						"msg"    => "Not found data.",
						"rows"   => $query->num_rows()
				);
			endif;
			
		}
	}
	
	public function getBranchnIfo($brncode) {
		$this->load->model("dbmodel");
		
		if(empty($brncode)) {
				
			return array(
					"data"   => array(0),
					"status" => "false",
					"msg"    => "Not found data.",
					"rows"   => 0
			);
				
		} else {
				
			$result = $this->dbmodel->CIQuery("
			SELECT LendingEmp.EmployeeCode, LendingEmp.FullNameTh, LendingEmp.PositionTitle, LendingEmp.BranchCode, RoleSpecial
			FROM LendingEmp				
			WHERE LendingEmp.PositionTitle LIKE '%Branch Manager%' 
			AND LendingEmp.BranchCode = '".$brncode."'
			ORDER BY LendingEmp.BranchCode ASC, RoleSpecial DESC");
			
			return $result;
			
		}
	}

	public function employeesInfo($emp_code) {
		$this->load->model('dbmodel');
		if(empty($emp_code)) {
			throw new Exception(__function__.' method is exception handled please check argusment was null.');
				
		} else {
				
			$result = $this->dbmodel->CIQuery("
				SELECT
					LendingEmp.EmployeeCode, LendingEmp.FullnameTh, LendingEmp.FullnameEng, LendingEmp.Nickname, LendingEmp.PositionTitle, 
					LendingEmp.Mobile, LendingEmp.RegionID, MasterRegion.RegionNameTh, MasterRegion.RegionNameEng, 
					LendingEmp.BranchCode, LendingBranchs.BranchName, LendingBranchs.BranchDigit, MasterArea.AreaName AS AreaCode,
					LendingEmp.RoleSpecial, LendingEmp.IsActive
				FROM LendingEmp
				INNER JOIN LendingBranchs
				ON LendingEmp.BranchCode = LendingBranchs.BranchCode
				INNER JOIN MasterRegion
				ON MasterRegion.RegionID = LendingEmp.RegionID
				LEFT OUTER JOIN MasterArea
				ON LendingBranchs.AreaID = MasterArea.AreaNo
				WHERE LendingEmp.IsActive = 'A'
				AND LendingEmp.EmployeeCode = '".$emp_code."'
			");
				
			return $result;
				
		}
	
	}	
	
	// Logging
	protected function makedirs($dirpath, $mode = 0777) {
		return is_dir($dirpath) || mkdir($dirpath, $mode, true);
	}
	
	private function writelogs($log_path, $log_name, $result) {
		$this->load->library('xml/array2xml');
	
		$this->makedirs($log_path.date("dmy"));
	
		$xml = new DOMDocument();
		$xml = Array2XML::createXML('root_node_name', $result);
		$xml->save($log_path.date("dmy")."/".$log_name.date("His").".xml");
	
	}
	
	// Module Maintenance  ###
	
	public function dataTableDashboardPagination($authority, $condition = array()) {
		$this->load->model('dbmodel');
		$this->load->model('dbstore');
		$this->load->library('effective');
		
		$wheres			= "WHERE NOT StartDate IS NULL";
		$where_addition = "AND LendingBranchs.RegionID IS NOT NULL AND CheckNCBDate > '2014-12-31'";
		$wheres_name 	= "";
		
		$ncb_start 		= $this->input->post('ncb_start');
		$ncb_end		= $this->input->post('ncb_end');
		$rmname			= $this->input->post('rmname');
		$ownerName		= $this->input->post('ownerName');
		$caname			= $this->input->post('caname');
		$regionid		= $this->input->post('regionid');
		$branchs		= $this->input->post('branchdigit');
		$loantype		= $this->input->post('loantype');
		$product		= $this->input->post('product');
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
		$defend_list	= ''; //$this->input->post('defend_check');
		$retrieve_list  = '';
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
		$kpi_privileges = '';
		
		if($kpi_search == 'true') {
			
			// Call role permission
			$special_role = $this->setDataAuthority($emp_kpi);
			
			// Get Primary condition
			$get_info 	= $this->getEmployeeDataInfo($emp_kpi);
			$brn_code 	= $get_info['data'][0]['BranchCode'];
			$area_code  = $get_info['data'][0]['AreaCode'];
			$region_id  = $get_info['data'][0]['RegionID'];
			
			$kpi_privileges  = $this->getAuthPermission($special_role);
				
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
						
						// Check special role in kpi preview mode by passing empcode						
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
						
						// Role individual usually.
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
					$wheres_kpi		.= " AND [Status] IN ('A')";
					$wheres_kpi		.= " AND StatusDate BETWEEN '".$first_date."' AND '".$second_date."'";						
				break;
				case '15':		
					if($use_ca == 'true') { $wheres_kpi .= " AND CA_ReceivedDocDate IS NOT NULL"; }					
					$wheres_kpi		.= " AND [Status] IN ('R')";
					$wheres_kpi		.= " AND StatusDate BETWEEN '".$first_date."' AND '".$second_date."'";				
				break;
				case '16':					
					if($use_ca == 'true') { $wheres_kpi .= " AND CA_ReceivedDocDate IS NOT NULL"; }					
					$wheres_kpi		.= " AND [Status] IN ('C')";
					$wheres_kpi		.= " AND StatusDate BETWEEN '".$first_date."' AND '".$second_date."'";
				break;
				case '17':
					if($use_ca == 'true') { $wheres_kpi .= " AND CA_ReceivedDocDate IS NOT NULL"; }
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
		
		$obj_status = array();		
		$obj_statusDraft = array();
		$refer_pieces = explode(',', $refer_tlf);
		$status_pieces = explode(',', $status);
		
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
			$wheres_refer   = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $refer_pieces)."'");
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
		
			if(!empty($caplan_end)):
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
			if(!empty($appLoan_end)) { $wheres .= " AND ApprovedLoan = '".$appLoan_end."'"; }
		
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
			$wheres_name .= " AND NCB.MainLoanName LIKE '%".$this->effective->set_chartypes($this->char_mode, $ownerName)."%'";
		}
		
		if($activerows == "Active") { $wheres .= " AND ActiveRecord = '".$activerows."'"; }
		if($activerows == "InActive") { $wheres .= " AND ActiveRecord = '".$activerows."'"; }
				
		// Condition Check Date
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

		if(empty($authority)) {
		
			$objForms = array(
					"Privileges" => $authority,
					"Condition"	 => $condition,
					"Optional"	 => $optional
			);
		
			log_message('error', 'method '.__METHOD__ .'can not load data progress. please check object criteria.');
			$this->writelogs($this->logs."model/dbcusotm/", "db_cust", $objForms);
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
			
			
		} else {
		
			if($kpi_search == 'true') {
				$privileges = $kpi_privileges;				
			} else {	
				
				if(count($authority) > 1) $privileges = $authority[0];
				else $privileges = $authority[0];	
				
				/*
				$bm_direct = $this->config->item('BM_Direct');
				if(in_array($condition[0], $bm_direct)) {
					$privileges = array('074004');
						
				} else {
					if(count($authority) > 1) $privileges = $authority[0];
					else $privileges = $authority[0];
				}
				*/
				
			}
		
			// load data employees.
			$employees 	= $this->employeesInfo($condition[0]);
			$empbranch 	= str_pad($employees['data'][0]['BranchCode'], 3, "0", STR_PAD_LEFT);
			$emp_area  	= $employees['data'][0]['AreaCode'];
			$emp_region	= $employees['data'][0]['RegionID'];

			if($kpi_search == 'true' && in_array($kpi_no, $this->object_kpi)) {
				switch ($kpi_no):
					case '6':
						$result	= $this->dbstore->exec_getWhiteboardKPIPreview($kpi_condition, $modestate);						
						return count($result['data']);
					break;
						
				endswitch;
			
			} else {
				
				$plana2ca_sql = "
				CASE 
					WHEN ProductLoanTypeID = 1 THEN 'Refinance'
					WHEN ProductLoanTypeID = 2 THEN 'Non Refinance'
					ELSE NULL
				END AS ProductLoanType, IsAIP, Verification.Cashy, Bank,
				ISNULL(OwnershipDoc, 'N') AS OwnershipDoc,
				Verification.AppToCAPlanDate AS PlanA2CADraft,
				CASE 		
					WHEN Verification.AppToCAPlanDate <= ApplicationStatus.CA_ReceivedDocDate THEN NULL
					WHEN Verification.AppToCAPlanDate <= ApplicationStatus.[StatusDate]	THEN NULL
					WHEN Verification.AppToCAPlanDate > Verification.HQReceiveCADocDate OR
						 Verification.AppToCAPlanDate > Verification.SentToCADate OR
						 Verification.AppToCAPlanDate > ApplicationStatus.CA_ReceivedDocDate
					THEN Verification.AppToCAPlanDate
					WHEN Verification.HQReceiveCADocDate IS NULL THEN Verification.AppToCAPlanDate
					ELSE NULL
				END AS AppToCAPlanDate,";
				
				$join_strsql  = "
				LEFT OUTER JOIN (
					SELECT * FROM (
						SELECT RC.DocID, 'Y' AS OwnershipDoc, SubmitDocToCADate AS CompletionDoc, [Status], StatusDate, DrawdownDate,
						ROW_NUMBER() OVER(PARTITION BY RC.DocID ORDER BY RC.DocID ASC) as Numindex
						FROM ReconcileCompletion AS RC
						LEFT OUTER JOIN ApplicationStatus AS APS
						ON RC.DocID = APS.DocID
						WHERE DocList IN ('55','187')
						AND RC.IsActive = 'A'
						AND SubmitDocToCADate IS NULL
						AND DrawdownDate IS NULL
					) A
					WHERE Numindex = 1
				) ObjOwnershipDoc
				ON [Profile].DocID = ObjOwnershipDoc.DocID";

				switch($privileges) {
					case $this->role_ad:
					case $this->role_bm:
					case $this->role_hq:
					case $this->role_spv:
					case $this->role_ads:
						
						if($kpi_search == 'true') {
							
							$spcial_inquiry = '';
							if($kpi_search == 'true') {
								if($mode_kpi == $this->individual_mode) $spcial_inquiry = " AND RMCode = '".$emp_kpi."'";
								if($mode_kpi == $this->branch_mode)  {
									if($brn_code == '000'):
										$spcial_inquiry = '';
									else:
										$spcial_inquiry = " AND BranchCode = '".$brn_code."'";
									endif;								
								}
							} else {
								$spcial_inquiry = " AND BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'";
							}
							
							$result = $this->db->query("
							SELECT	* FROM
								(SELECT
									[Profile].DocID, [Profile].SourceOfCustomer,
									ISNULL( 
										ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
										ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
									) AS StartDate, NCBCheckDate, NCB.CheckNCBDate,
									[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
									[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit, MasterArea.AreaName AS AreaCode,
									[Profile].Branch, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
									Product.ProductCode, Product.ProductName, Product.ProductTypes, ProductType.ProductType AS ProductCat, [Profile].RequestLoan,
									$plana2ca_sql
									Verification.RMProcess, Verification.HQReceiveCADocDate AS HQReceiveCADocDate,
									Verification.SentToCADate AS SentToCADate, CAReturnDateLog,
									IsDefend, ApplicationStatus.CAName, CA_ReceivedDocDate, ApplicationStatus.AFCancelReason,
									CASE
										WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CR'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CR' 
										WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C' 
										WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'P'
										WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PA'
										WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'A'
										WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'R'
										WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'C'
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
										ELSE NULL
									END AS [Status], 
									CASE
										WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CREDIT RETURN'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CREDIT RETURN'  
										WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
										WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'PENDING'
										WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PREAPPROVED'
										WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'APPROVED'
										WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'REJECT'
										WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'CANCEL'
										WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'CANCELBYRM'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'CANCELBYCUS'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'CANCELBYCA'
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
									ELSE NULL
									END AS StatusDesc, 
									ApplicationStatus.StatusReason,
									CASE ApplicationStatus.PreLoan
										WHEN '0' THEN NULL
										ELSE ApplicationStatus.PreLoan
									END AS PreLoan,
									ApplicationStatus.StatusDate AS StatusDate, ApplicationStatus.ApprovedLoan  AS ApprovedLoan,
									ApplicationStatus.PlanDrawdownDate AS PlanDrawdownDate, ApplicationStatus.PlanDateUnknown,
									ApplicationStatus.DrawdownDate AS DrawdownDate,
									ApplicationStatus.DrawdownBaht AS DrawdownBaht, Verification.ActionNote,
									CASE
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'APPROVED' 
											AND NOT ApplicationStatus.DrawdownDate = '' 
											AND NOT ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'APPROVED' 
											AND ApplicationStatus.DrawdownDate = '' 
											AND ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'Active'
										WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'Active'
										WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'Active'							
										ELSE 'Active'
									END AS ActiveRecord,
									ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
									ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
									RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
									RetrieveRecord.EventTime AS RetrieveTime, Installment, 
									dbo.GetApplication(ApplicationStatus.ApplicationNo) AS DDHistory,
									ApplicationStatus.ReceivedEstimateDoc, [Profile].IsActive
								FROM [Profile]
								LEFT OUTER JOIN Verification
								ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
								LEFT OUTER JOIN NCB
								ON Verification.VerifyID = NCB.VerifyID
								LEFT OUTER JOIN ApplicationStatus
								ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
								LEFT OUTER JOIN Product
								ON Verification.ProductCode = Product.ProductCode
								LEFT OUTER JOIN ProductType
								ON Product.ProductTypeID = ProductType.ProductTypeID
								LEFT OUTER JOIN LendingEmp
								ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
								LEFT OUTER JOIN LendingBranchs
								ON [Profile].BranchCode = LendingBranchs.BranchCode
								LEFT OUTER JOIN MasterArea
								ON LendingBranchs.AreaID = MasterArea.AreaNo
								LEFT OUTER JOIN MasterRegion
								ON LendingBranchs.RegionID = MasterRegion.RegionID
								LEFT OUTER JOIN ( SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
								ON Defender.RF_DocID = [Profile].DocID
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
										VerifyID AS VF, BorrowerType, BorrowerName, 
										[dbo].[DateInvalid](CONVERT(nvarchar(10), NCBCheckDate, 120)) AS NCBCheckDate
									FROM dbo.NCBConsentLogs) Tmp
									WHERE Numindex = 1
								) NCBConsentLogs
								ON NCBConsentLogs.VF = Verification.VerifyID 
								AND NCBConsentLogs.BorrowerType = '101'
								LEFT OUTER JOIN (
									SELECT * FROM (
									SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
									DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
									[dbo].[DateInvalid](CONVERT(nvarchar(10), CAReturnDate, 120)) AS CAReturnDateLog
									FROM ReconcileDocLogs) Tmp
									WHERE Numindex = 1				
								) ReconcileDocLogs
								ON [Profile].DocID = ReconcileDocLogs.DocLogs 
								AND ReconcileDocLogs.BorrowerType = '101'
								LEFT OUTER JOIN (
									SELECT DocID, 'Y' AS IsAIP FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
										DocID, ActionNote, ActionNoteDate, ActionDateTime
										FROM (
											SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
											FROM ActionNote
											UNION   
											SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
											FROM SystemNoteLog
										) DATA	
										WHERE IsActive = 'A'
										AND ActionNote LIKE '%AIP%'
									) AS ActionLog
									WHERE Numindex = 1
								) AIPInquiry
								ON [Profile].DocID = AIPInquiry.DocID
								LEFT OUTER JOIN (		
									SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY RetrieveToNewDoc ORDER BY CONVERT(NVARCHAR(10), EventDate, 120) DESC, RIGHT(CONVERT(NVARCHAR(24) , EventTime, 120), 8) DESC) as Numindex, 
										RetrieveToNewDoc, EmployeeCode, CONVERT(NVARCHAR(10) , EventDate, 120) AS EventDate, RIGHT(CONVERT(NVARCHAR(24), EventTime, 120), 8) AS EventTime, 
										'RET' AS RetrievedDigit, 'Y' AS Retrieved
										FROM Retrieve_TransactionLog
									) Tmp
									WHERE Numindex = 1
								) RetrieveRecord
								ON [Profile].DocID = RetrieveRecord.RetrieveToNewDoc
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT DocID, CONVERT(NVARCHAR(10), ReActivateDate, 120) AS ReActivateDate, 
										'REA' AS ReactivateDigit, 'Y' AS ReActivated,
										ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ReActivateDate DESC) as Numindex
										FROM Reactivate_TransactionLog
									) Tmp
									WHERE Numindex = 1
								) ReActivateRecord
								ON [Profile].DocID = ReActivateRecord.DocID
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT isnull([ApplicationNoReplace].[ApplicationNoReplace],[Drawdown_History].[ApplicationNo]) [ApplicationNo] ,
										'Y' AS Installment, ROW_NUMBER() OVER(PARTITION BY [Drawdown_History].[ApplicationNo] ORDER BY DrawdownDate ASC) as Numindex
										FROM [PCIS].[dbo].[Drawdown_History]
										LEFT OUTER JOIN [PCIS].[dbo].[ApplicationNoReplace] ON [Drawdown_History].[ApplicationNo] = [ApplicationNoReplace].[ApplicationNo]
									) Tmp
									WHERE Numindex = 2
								) DDHistory
								ON ApplicationStatus.ApplicationNo = DDHistory.ApplicationNo 
								$join_strsql
								WHERE [Profile].IsActive = 'Y'
								AND [Profile].IsEnabled = 'A'
								AND NOT [Profile].CreateDate IS NULL
								AND NOT NCB.CheckNCBDate IS NULL					
								AND BasicCriteria = '1'
								AND NCB.CheckNCB in ('1', '3')	
								
								$where_addition
								$wheres_name
							) Inquiry
							$wheres
							$wheres_kpi
							$spcial_inquiry");
							
							return $result->num_rows();
					
						} else {
							
							if($empbranch == "000" || $empbranch == "901") {
			
								$result = $this->db->query("
								SELECT	* FROM
									(SELECT
										[Profile].DocID, [Profile].SourceOfCustomer,
										ISNULL( 
											ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
											ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
										) AS StartDate, NCBCheckDate, NCB.CheckNCBDate,
										[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
										[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit, MasterArea.AreaName AS AreaCode,
										[Profile].Branch, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
										Product.ProductCode, Product.ProductName, Product.ProductTypes, ProductType.ProductType AS ProductCat, [Profile].RequestLoan,
										$plana2ca_sql
										Verification.RMProcess, Verification.HQReceiveCADocDate AS HQReceiveCADocDate,
										Verification.SentToCADate AS SentToCADate, CAReturnDateLog,
										IsDefend, ApplicationStatus.CAName, CA_ReceivedDocDate, ApplicationStatus.AFCancelReason,
										CASE
											WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CR'
											WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CR' 
											WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
											WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C' 
											WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'P'
											WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PA'
											WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'A'
											WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'R'
											WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'C'
											WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'C'
											WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'C'
											WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'C'
											WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
											ELSE NULL
										END AS [Status], 
										CASE
											WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CREDIT RETURN'
											WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CREDIT RETURN'  
											WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
											WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
											WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'PENDING'
											WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PREAPPROVED'
											WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'APPROVED'
											WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'REJECT'
											WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'CANCEL'
											WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'CANCELBYRM'
											WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'CANCELBYCUS'
											WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'CANCELBYCA'
											WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
										ELSE NULL
										END AS StatusDesc, 
										ApplicationStatus.StatusReason,
										CASE ApplicationStatus.PreLoan
											WHEN '0' THEN NULL
											ELSE ApplicationStatus.PreLoan
										END AS PreLoan,
										ApplicationStatus.StatusDate AS StatusDate, ApplicationStatus.ApprovedLoan  AS ApprovedLoan,
										ApplicationStatus.PlanDrawdownDate AS PlanDrawdownDate, ApplicationStatus.PlanDateUnknown,
										ApplicationStatus.DrawdownDate AS DrawdownDate,
										ApplicationStatus.DrawdownBaht AS DrawdownBaht, Verification.ActionNote,
										CASE
											WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'APPROVED' 
												AND NOT ApplicationStatus.DrawdownDate = '' 
												AND NOT ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'APPROVED' 
												AND ApplicationStatus.DrawdownDate = '' 
												AND ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'Active'
											WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'Active'
											WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'Active'							
											ELSE 'Active'
										END AS ActiveRecord,
										ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
										ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
										RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
										RetrieveRecord.EventTime AS RetrieveTime, Installment, 
										dbo.GetApplication(ApplicationStatus.ApplicationNo) AS DDHistory,
										ApplicationStatus.ReceivedEstimateDoc, [Profile].IsActive
									FROM [Profile]
									LEFT OUTER JOIN Verification
									ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
									LEFT OUTER JOIN NCB
									ON Verification.VerifyID = NCB.VerifyID
									LEFT OUTER JOIN ApplicationStatus
									ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
									LEFT OUTER JOIN Product
									ON Verification.ProductCode = Product.ProductCode
									LEFT OUTER JOIN ProductType
									ON Product.ProductTypeID = ProductType.ProductTypeID
									LEFT OUTER JOIN LendingEmp
									ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
									LEFT OUTER JOIN LendingBranchs
									ON [Profile].BranchCode = LendingBranchs.BranchCode
									LEFT OUTER JOIN MasterArea
									ON LendingBranchs.AreaID = MasterArea.AreaNo
									LEFT OUTER JOIN MasterRegion
									ON LendingBranchs.RegionID = MasterRegion.RegionID
									LEFT OUTER JOIN ( SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
									ON Defender.RF_DocID = [Profile].DocID
									LEFT OUTER JOIN (
										SELECT * FROM (
											SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
											VerifyID AS VF, BorrowerType, BorrowerName, 
											[dbo].[DateInvalid](CONVERT(nvarchar(10), NCBCheckDate, 120)) AS NCBCheckDate
										FROM dbo.NCBConsentLogs) Tmp
										WHERE Numindex = 1
									) NCBConsentLogs
									ON NCBConsentLogs.VF = Verification.VerifyID 
									AND NCBConsentLogs.BorrowerType = '101'
									LEFT OUTER JOIN (
										SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
										DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
										[dbo].[DateInvalid](CONVERT(nvarchar(10), CAReturnDate, 120)) AS CAReturnDateLog
										FROM ReconcileDocLogs) Tmp
										WHERE Numindex = 1				
									) ReconcileDocLogs
									ON [Profile].DocID = ReconcileDocLogs.DocLogs 
									AND ReconcileDocLogs.BorrowerType = '101'
									LEFT OUTER JOIN (
										SELECT DocID, 'Y' AS IsAIP FROM (
											SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
											DocID, ActionNote, ActionNoteDate, ActionDateTime
											FROM (
												SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
												CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
												FROM ActionNote
												UNION   
												SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
												CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
												FROM SystemNoteLog
											) DATA	
											WHERE IsActive = 'A'
											AND ActionNote LIKE '%AIP%'
										) AS ActionLog
										WHERE Numindex = 1
									) AIPInquiry
									ON [Profile].DocID = AIPInquiry.DocID
									LEFT OUTER JOIN (		
										SELECT * FROM (
											SELECT ROW_NUMBER() OVER(PARTITION BY RetrieveToNewDoc ORDER BY CONVERT(NVARCHAR(10), EventDate, 120) DESC, RIGHT(CONVERT(NVARCHAR(24) , EventTime, 120), 8) DESC) as Numindex, 
											RetrieveToNewDoc, EmployeeCode, CONVERT(NVARCHAR(10) , EventDate, 120) AS EventDate, RIGHT(CONVERT(NVARCHAR(24), EventTime, 120), 8) AS EventTime, 
											'RET' AS RetrievedDigit, 'Y' AS Retrieved
											FROM Retrieve_TransactionLog
										) Tmp
										WHERE Numindex = 1
									) RetrieveRecord
									ON [Profile].DocID = RetrieveRecord.RetrieveToNewDoc
									LEFT OUTER JOIN (
										SELECT * FROM (
											SELECT DocID, CONVERT(NVARCHAR(10), ReActivateDate, 120) AS ReActivateDate, 
											'REA' AS ReactivateDigit, 'Y' AS ReActivated,
											ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ReActivateDate DESC) as Numindex
											FROM Reactivate_TransactionLog
										) Tmp
										WHERE Numindex = 1
									) ReActivateRecord
									ON [Profile].DocID = ReActivateRecord.DocID
									LEFT OUTER JOIN (
										SELECT * FROM (
											SELECT isnull([ApplicationNoReplace].[ApplicationNoReplace],[Drawdown_History].[ApplicationNo]) [ApplicationNo] ,
											'Y' AS Installment, ROW_NUMBER() OVER(PARTITION BY [Drawdown_History].[ApplicationNo] ORDER BY DrawdownDate ASC) as Numindex
											FROM [PCIS].[dbo].[Drawdown_History]
											LEFT OUTER JOIN [PCIS].[dbo].[ApplicationNoReplace] ON [Drawdown_History].[ApplicationNo] = [ApplicationNoReplace].[ApplicationNo]
										) Tmp
										WHERE Numindex = 2
									) DDHistory
									ON ApplicationStatus.ApplicationNo = DDHistory.ApplicationNo
									$join_strsql
									WHERE [Profile].IsActive = 'Y'
									AND [Profile].IsEnabled = 'A'
									AND NOT [Profile].CreateDate IS NULL
									AND NOT NCB.CheckNCBDate IS NULL					
									AND BasicCriteria = '1'
									AND NCB.CheckNCB in ('1', '3')	
									
									$where_addition
									$wheres_name
								) Inquiry
								$wheres");
							
							return $result->num_rows();
														
						} else {
							
							// Admin are not head office
							// Check has authority area manager
							$select_privilege = '';
							if(in_array($this->role_am, $authority)):
								$select_privilege = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' GROUP BY BranchCode)";
							else:
								$select_privilege = " AND BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'";
							endif;
							
							$result = $this->db->query("
							SELECT	* FROM
								(SELECT
									[Profile].DocID, [Profile].SourceOfCustomer,
									ISNULL( 
										ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
										ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
									) AS StartDate, NCBCheckDate, NCB.CheckNCBDate,
									[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
									[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit, MasterArea.AreaName AS AreaCode,
									[Profile].Branch, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
									Product.ProductCode, Product.ProductName, Product.ProductTypes, ProductType.ProductType AS ProductCat, [Profile].RequestLoan,
									$plana2ca_sql
									Verification.RMProcess, Verification.HQReceiveCADocDate AS HQReceiveCADocDate,
									Verification.SentToCADate AS SentToCADate, CAReturnDateLog,
									IsDefend, ApplicationStatus.CAName, CA_ReceivedDocDate, ApplicationStatus.AFCancelReason,
									CASE
										WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CR'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CR' 
										WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C' 
										WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'P'
										WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PA'
										WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'A'
										WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'R'
										WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'C'
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
										ELSE NULL
									END AS [Status], 
									CASE
										WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CREDIT RETURN'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CREDIT RETURN'  
										WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
										WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'PENDING'
										WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PREAPPROVED'
										WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'APPROVED'
										WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'REJECT'
										WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'CANCEL'
										WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'CANCELBYRM'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'CANCELBYCUS'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'CANCELBYCA'
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
									ELSE NULL
									END AS StatusDesc, 
									ApplicationStatus.StatusReason,
									CASE ApplicationStatus.PreLoan
										WHEN '0' THEN NULL
										ELSE ApplicationStatus.PreLoan
									END AS PreLoan,
									ApplicationStatus.StatusDate AS StatusDate, ApplicationStatus.ApprovedLoan  AS ApprovedLoan,
									ApplicationStatus.PlanDrawdownDate AS PlanDrawdownDate, ApplicationStatus.PlanDateUnknown,
									ApplicationStatus.DrawdownDate AS DrawdownDate,
									ApplicationStatus.DrawdownBaht AS DrawdownBaht, Verification.ActionNote,
									CASE
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'APPROVED' 
											AND NOT ApplicationStatus.DrawdownDate = '' 
											AND NOT ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'APPROVED' 
											AND ApplicationStatus.DrawdownDate = '' 
											AND ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'Active'
										WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'Active'
										WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'Active'							
										ELSE 'Active'
									END AS ActiveRecord,
									ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
									ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
									RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
									RetrieveRecord.EventTime AS RetrieveTime, Installment, 
									dbo.GetApplication(ApplicationStatus.ApplicationNo) AS DDHistory,
									ApplicationStatus.ReceivedEstimateDoc, [Profile].IsActive
								FROM [Profile]
								LEFT OUTER JOIN Verification
								ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
								LEFT OUTER JOIN NCB
								ON Verification.VerifyID = NCB.VerifyID
								LEFT OUTER JOIN ApplicationStatus
								ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
								LEFT OUTER JOIN Product
								ON Verification.ProductCode = Product.ProductCode
								LEFT OUTER JOIN ProductType
								ON Product.ProductTypeID = ProductType.ProductTypeID
								LEFT OUTER JOIN LendingEmp
								ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
								LEFT OUTER JOIN LendingBranchs
								ON [Profile].BranchCode = LendingBranchs.BranchCode
								LEFT OUTER JOIN MasterArea
								ON LendingBranchs.AreaID = MasterArea.AreaNo
								LEFT OUTER JOIN MasterRegion
								ON LendingBranchs.RegionID = MasterRegion.RegionID
								LEFT OUTER JOIN ( SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
								ON Defender.RF_DocID = [Profile].DocID
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
										VerifyID AS VF, BorrowerType, BorrowerName, 
										[dbo].[DateInvalid](CONVERT(nvarchar(10), NCBCheckDate, 120)) AS NCBCheckDate
									FROM dbo.NCBConsentLogs) Tmp
									WHERE Numindex = 1
								) NCBConsentLogs
								ON NCBConsentLogs.VF = Verification.VerifyID 
								AND NCBConsentLogs.BorrowerType = '101'
								LEFT OUTER JOIN (
									SELECT * FROM (
									SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
									DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
									[dbo].[DateInvalid](CONVERT(nvarchar(10), CAReturnDate, 120)) AS CAReturnDateLog
									FROM ReconcileDocLogs) Tmp
									WHERE Numindex = 1				
								) ReconcileDocLogs
								ON [Profile].DocID = ReconcileDocLogs.DocLogs 
								AND ReconcileDocLogs.BorrowerType = '101'
								LEFT OUTER JOIN (
									SELECT DocID, 'Y' AS IsAIP FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
										DocID, ActionNote, ActionNoteDate, ActionDateTime
										FROM (
											SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
											FROM ActionNote
											UNION   
											SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
											FROM SystemNoteLog
										) DATA	
										WHERE IsActive = 'A'
										AND ActionNote LIKE '%AIP%'
									) AS ActionLog
									WHERE Numindex = 1
								) AIPInquiry
								ON [Profile].DocID = AIPInquiry.DocID
								LEFT OUTER JOIN (		
									SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY RetrieveToNewDoc ORDER BY CONVERT(NVARCHAR(10), EventDate, 120) DESC, RIGHT(CONVERT(NVARCHAR(24) , EventTime, 120), 8) DESC) as Numindex, 
										RetrieveToNewDoc, EmployeeCode, CONVERT(NVARCHAR(10) , EventDate, 120) AS EventDate, RIGHT(CONVERT(NVARCHAR(24), EventTime, 120), 8) AS EventTime, 
										'RET' AS RetrievedDigit, 'Y' AS Retrieved
										FROM Retrieve_TransactionLog
									) Tmp
									WHERE Numindex = 1
								) RetrieveRecord
								ON [Profile].DocID = RetrieveRecord.RetrieveToNewDoc
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT DocID, CONVERT(NVARCHAR(10), ReActivateDate, 120) AS ReActivateDate, 
										'REA' AS ReactivateDigit, 'Y' AS ReActivated,
										ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ReActivateDate DESC) as Numindex
										FROM Reactivate_TransactionLog
									) Tmp
									WHERE Numindex = 1
								) ReActivateRecord
								ON [Profile].DocID = ReActivateRecord.DocID
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT isnull([ApplicationNoReplace].[ApplicationNoReplace],[Drawdown_History].[ApplicationNo]) [ApplicationNo] ,
										'Y' AS Installment, ROW_NUMBER() OVER(PARTITION BY [Drawdown_History].[ApplicationNo] ORDER BY DrawdownDate ASC) as Numindex
										FROM [PCIS].[dbo].[Drawdown_History]
										LEFT OUTER JOIN [PCIS].[dbo].[ApplicationNoReplace] ON [Drawdown_History].[ApplicationNo] = [ApplicationNoReplace].[ApplicationNo]
									) Tmp
									WHERE Numindex = 2
								) DDHistory
								ON ApplicationStatus.ApplicationNo = DDHistory.ApplicationNo 
								$join_strsql
								WHERE [Profile].IsActive = 'Y'
								AND [Profile].IsEnabled = 'A'
								AND NOT [Profile].CreateDate IS NULL
								AND NOT NCB.CheckNCBDate IS NULL					
								AND BasicCriteria = '1'
								AND NCB.CheckNCB in ('1', '3')	
								
								$where_addition
								$wheres_name
							) Inquiry
							$wheres
							$select_privilege");
								
							return $result->num_rows();
								
							}
						
						}
									
					break;
					case $this->role_rm:
						
						if($kpi_search == 'true'):
							$spcial_inquiry = " AND RMCode = '".$emp_kpi."'";
						else:
							$spcial_inquiry = " AND RMCode = '".$employees['data'][0]['EmployeeCode']."'";
						endif;
						
						$result = $this->db->query("
							SELECT	* FROM
								(SELECT
									[Profile].DocID, [Profile].SourceOfCustomer,
									ISNULL( 
										ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
										ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
									) AS StartDate, NCBCheckDate, NCB.CheckNCBDate,
									[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
									[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit, MasterArea.AreaName AS AreaCode,
									[Profile].Branch, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
									Product.ProductCode, Product.ProductName, Product.ProductTypes, ProductType.ProductType AS ProductCat, [Profile].RequestLoan,
									$plana2ca_sql
									Verification.RMProcess, Verification.HQReceiveCADocDate AS HQReceiveCADocDate,
									Verification.SentToCADate AS SentToCADate, CAReturnDateLog,
									IsDefend, ApplicationStatus.CAName, CA_ReceivedDocDate, ApplicationStatus.AFCancelReason,
									CASE
										WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CR'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CR' 
										WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C' 
										WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'P'
										WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PA'
										WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'A'
										WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'R'
										WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'C'
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
										ELSE NULL
									END AS [Status], 
									CASE
										WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CREDIT RETURN'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CREDIT RETURN'  
										WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
										WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'PENDING'
										WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PREAPPROVED'
										WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'APPROVED'
										WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'REJECT'
										WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'CANCEL'
										WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'CANCELBYRM'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'CANCELBYCUS'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'CANCELBYCA'
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
									ELSE NULL
									END AS StatusDesc, 
									ApplicationStatus.StatusReason,
									CASE ApplicationStatus.PreLoan
										WHEN '0' THEN NULL
										ELSE ApplicationStatus.PreLoan
									END AS PreLoan,
									ApplicationStatus.StatusDate AS StatusDate, ApplicationStatus.ApprovedLoan  AS ApprovedLoan,
									ApplicationStatus.PlanDrawdownDate AS PlanDrawdownDate, ApplicationStatus.PlanDateUnknown,
									ApplicationStatus.DrawdownDate AS DrawdownDate,
									ApplicationStatus.DrawdownBaht AS DrawdownBaht, Verification.ActionNote,
									CASE
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'APPROVED' 
											AND NOT ApplicationStatus.DrawdownDate = '' 
											AND NOT ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'APPROVED' 
											AND ApplicationStatus.DrawdownDate = '' 
											AND ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'Active'
										WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'Active'
										WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'Active'							
										ELSE 'Active'
									END AS ActiveRecord,
									ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
									ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
									RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
									RetrieveRecord.EventTime AS RetrieveTime, Installment, 
									dbo.GetApplication(ApplicationStatus.ApplicationNo) AS DDHistory,
									ApplicationStatus.ReceivedEstimateDoc, [Profile].IsActive
								FROM [Profile]
								LEFT OUTER JOIN Verification
								ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
								LEFT OUTER JOIN NCB
								ON Verification.VerifyID = NCB.VerifyID
								LEFT OUTER JOIN ApplicationStatus
								ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
								LEFT OUTER JOIN Product
								ON Verification.ProductCode = Product.ProductCode
								LEFT OUTER JOIN ProductType
								ON Product.ProductTypeID = ProductType.ProductTypeID
								LEFT OUTER JOIN LendingEmp
								ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
								LEFT OUTER JOIN LendingBranchs
								ON [Profile].BranchCode = LendingBranchs.BranchCode
								LEFT OUTER JOIN MasterArea
								ON LendingBranchs.AreaID = MasterArea.AreaNo
								LEFT OUTER JOIN MasterRegion
								ON LendingBranchs.RegionID = MasterRegion.RegionID
								LEFT OUTER JOIN ( SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
								ON Defender.RF_DocID = [Profile].DocID
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
										VerifyID AS VF, BorrowerType, BorrowerName, 
										[dbo].[DateInvalid](CONVERT(nvarchar(10), NCBCheckDate, 120)) AS NCBCheckDate
									FROM dbo.NCBConsentLogs) Tmp
									WHERE Numindex = 1
								) NCBConsentLogs
								ON NCBConsentLogs.VF = Verification.VerifyID 
								AND NCBConsentLogs.BorrowerType = '101'
								LEFT OUTER JOIN (
									SELECT * FROM (
									SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
									DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
									[dbo].[DateInvalid](CONVERT(nvarchar(10), CAReturnDate, 120)) AS CAReturnDateLog
									FROM ReconcileDocLogs) Tmp
									WHERE Numindex = 1				
								) ReconcileDocLogs
								ON [Profile].DocID = ReconcileDocLogs.DocLogs 
								AND ReconcileDocLogs.BorrowerType = '101'
								LEFT OUTER JOIN (		
									SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY RetrieveToNewDoc ORDER BY CONVERT(NVARCHAR(10), EventDate, 120) DESC, RIGHT(CONVERT(NVARCHAR(24) , EventTime, 120), 8) DESC) as Numindex, 
										RetrieveToNewDoc, EmployeeCode, CONVERT(NVARCHAR(10) , EventDate, 120) AS EventDate, RIGHT(CONVERT(NVARCHAR(24), EventTime, 120), 8) AS EventTime, 
										'RET' AS RetrievedDigit, 'Y' AS Retrieved
										FROM Retrieve_TransactionLog
									) Tmp
									WHERE Numindex = 1
								) RetrieveRecord
								ON [Profile].DocID = RetrieveRecord.RetrieveToNewDoc
								LEFT OUTER JOIN (
									SELECT DocID, 'Y' AS IsAIP FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
										DocID, ActionNote, ActionNoteDate, ActionDateTime
										FROM (
											SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
											FROM ActionNote
											UNION   
											SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
											FROM SystemNoteLog
										) DATA	
										WHERE IsActive = 'A'
										AND ActionNote LIKE '%AIP%'
									) AS ActionLog
									WHERE Numindex = 1
								) AIPInquiry
								ON [Profile].DocID = AIPInquiry.DocID
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT DocID, CONVERT(NVARCHAR(10), ReActivateDate, 120) AS ReActivateDate, 
										'REA' AS ReactivateDigit, 'Y' AS ReActivated,
										ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ReActivateDate DESC) as Numindex
										FROM Reactivate_TransactionLog
									) Tmp
									WHERE Numindex = 1
								) ReActivateRecord
								ON [Profile].DocID = ReActivateRecord.DocID
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT isnull([ApplicationNoReplace].[ApplicationNoReplace],[Drawdown_History].[ApplicationNo]) [ApplicationNo] ,
										'Y' AS Installment, ROW_NUMBER() OVER(PARTITION BY [Drawdown_History].[ApplicationNo] ORDER BY DrawdownDate ASC) as Numindex
										FROM [PCIS].[dbo].[Drawdown_History]
										LEFT OUTER JOIN [PCIS].[dbo].[ApplicationNoReplace] ON [Drawdown_History].[ApplicationNo] = [ApplicationNoReplace].[ApplicationNo]
									) Tmp
									WHERE Numindex = 2
								) DDHistory
								ON ApplicationStatus.ApplicationNo = DDHistory.ApplicationNo 
								$join_strsql
								WHERE [Profile].IsActive = 'Y'
								AND [Profile].IsEnabled = 'A'
								AND NOT [Profile].CreateDate IS NULL
								AND NOT NCB.CheckNCBDate IS NULL					
								AND BasicCriteria = '1'
								AND NCB.CheckNCB in ('1', '3')	
								
								$where_addition
								$wheres_name
							) Inquiry
							$wheres
							$wheres_kpi
							$spcial_inquiry");
									
							return $result->num_rows();
							
						break;
						case $this->role_am:
							
							if($kpi_search == 'true'):
							$spcial_inquiry = " AND AreaCode = '".$area_code."'";
							else:
							$spcial_inquiry = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' GROUP BY BranchCode)";
							endif;
							
							$result = $this->db->query("
							SELECT	* FROM
								(SELECT
									[Profile].DocID, [Profile].SourceOfCustomer,
									ISNULL( 
										ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
										ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
									) AS StartDate, NCBCheckDate, NCB.CheckNCBDate,
									[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
									[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit, MasterArea.AreaName AS AreaCode,
									[Profile].Branch, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
									Product.ProductCode, Product.ProductName, Product.ProductTypes, ProductType.ProductType AS ProductCat, [Profile].RequestLoan,
									$plana2ca_sql
									Verification.RMProcess, Verification.HQReceiveCADocDate AS HQReceiveCADocDate,
									Verification.SentToCADate AS SentToCADate, CAReturnDateLog,
									IsDefend, ApplicationStatus.CAName, CA_ReceivedDocDate, ApplicationStatus.AFCancelReason,
									CASE
										WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CR'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CR' 
										WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C' 
										WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'P'
										WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PA'
										WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'A'
										WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'R'
										WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'C'
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
										ELSE NULL
									END AS [Status], 
									CASE
										WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CREDIT RETURN'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CREDIT RETURN'  
										WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
										WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'PENDING'
										WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PREAPPROVED'
										WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'APPROVED'
										WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'REJECT'
										WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'CANCEL'
										WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'CANCELBYRM'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'CANCELBYCUS'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'CANCELBYCA'
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
									ELSE NULL
									END AS StatusDesc, 
									ApplicationStatus.StatusReason,
									CASE ApplicationStatus.PreLoan
										WHEN '0' THEN NULL
										ELSE ApplicationStatus.PreLoan
									END AS PreLoan,
									ApplicationStatus.StatusDate AS StatusDate, ApplicationStatus.ApprovedLoan  AS ApprovedLoan,
									ApplicationStatus.PlanDrawdownDate AS PlanDrawdownDate, ApplicationStatus.PlanDateUnknown,
									ApplicationStatus.DrawdownDate AS DrawdownDate,
									ApplicationStatus.DrawdownBaht AS DrawdownBaht, Verification.ActionNote,
									CASE
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'APPROVED' 
											AND NOT ApplicationStatus.DrawdownDate = '' 
											AND NOT ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'APPROVED' 
											AND ApplicationStatus.DrawdownDate = '' 
											AND ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'Active'
										WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'Active'
										WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'Active'							
										ELSE 'Active'
									END AS ActiveRecord,
									ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
									ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
									RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
									RetrieveRecord.EventTime AS RetrieveTime, Installment, 
									dbo.GetApplication(ApplicationStatus.ApplicationNo) AS DDHistory,
									ApplicationStatus.ReceivedEstimateDoc, [Profile].IsActive
								FROM [Profile]
								LEFT OUTER JOIN Verification
								ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
								LEFT OUTER JOIN NCB
								ON Verification.VerifyID = NCB.VerifyID
								LEFT OUTER JOIN ApplicationStatus
								ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
								LEFT OUTER JOIN Product
								ON Verification.ProductCode = Product.ProductCode
								LEFT OUTER JOIN ProductType
								ON Product.ProductTypeID = ProductType.ProductTypeID
								LEFT OUTER JOIN LendingEmp
								ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
								LEFT OUTER JOIN LendingBranchs
								ON [Profile].BranchCode = LendingBranchs.BranchCode
								LEFT OUTER JOIN MasterArea
								ON LendingBranchs.AreaID = MasterArea.AreaNo
								LEFT OUTER JOIN MasterRegion
								ON LendingBranchs.RegionID = MasterRegion.RegionID
								LEFT OUTER JOIN ( SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
								ON Defender.RF_DocID = [Profile].DocID
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
										VerifyID AS VF, BorrowerType, BorrowerName, 
										[dbo].[DateInvalid](CONVERT(nvarchar(10), NCBCheckDate, 120)) AS NCBCheckDate
									FROM dbo.NCBConsentLogs) Tmp
									WHERE Numindex = 1
								) NCBConsentLogs
								ON NCBConsentLogs.VF = Verification.VerifyID 
								AND NCBConsentLogs.BorrowerType = '101'
								LEFT OUTER JOIN (
									SELECT * FROM (
									SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
									DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
									[dbo].[DateInvalid](CONVERT(nvarchar(10), CAReturnDate, 120)) AS CAReturnDateLog
									FROM ReconcileDocLogs) Tmp
									WHERE Numindex = 1				
								) ReconcileDocLogs
								ON [Profile].DocID = ReconcileDocLogs.DocLogs 
								AND ReconcileDocLogs.BorrowerType = '101'
								LEFT OUTER JOIN (
									SELECT DocID, 'Y' AS IsAIP FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
										DocID, ActionNote, ActionNoteDate, ActionDateTime
										FROM (
											SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
											FROM ActionNote
											UNION   
											SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
											FROM SystemNoteLog
										) DATA	
										WHERE IsActive = 'A'
										AND ActionNote LIKE '%AIP%'
									) AS ActionLog
									WHERE Numindex = 1
								) AIPInquiry
								ON [Profile].DocID = AIPInquiry.DocID
								LEFT OUTER JOIN (		
									SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY RetrieveToNewDoc ORDER BY CONVERT(NVARCHAR(10), EventDate, 120) DESC, RIGHT(CONVERT(NVARCHAR(24) , EventTime, 120), 8) DESC) as Numindex, 
										RetrieveToNewDoc, EmployeeCode, CONVERT(NVARCHAR(10) , EventDate, 120) AS EventDate, RIGHT(CONVERT(NVARCHAR(24), EventTime, 120), 8) AS EventTime, 
										'RET' AS RetrievedDigit, 'Y' AS Retrieved
										FROM Retrieve_TransactionLog
									) Tmp
									WHERE Numindex = 1
								) RetrieveRecord
								ON [Profile].DocID = RetrieveRecord.RetrieveToNewDoc
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT DocID, CONVERT(NVARCHAR(10), ReActivateDate, 120) AS ReActivateDate, 
										'REA' AS ReactivateDigit, 'Y' AS ReActivated,
										ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ReActivateDate DESC) as Numindex
										FROM Reactivate_TransactionLog
									) Tmp
									WHERE Numindex = 1
								) ReActivateRecord
								ON [Profile].DocID = ReActivateRecord.DocID
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT isnull([ApplicationNoReplace].[ApplicationNoReplace],[Drawdown_History].[ApplicationNo]) [ApplicationNo] ,
										'Y' AS Installment, ROW_NUMBER() OVER(PARTITION BY [Drawdown_History].[ApplicationNo] ORDER BY DrawdownDate ASC) as Numindex
										FROM [PCIS].[dbo].[Drawdown_History]
										LEFT OUTER JOIN [PCIS].[dbo].[ApplicationNoReplace] ON [Drawdown_History].[ApplicationNo] = [ApplicationNoReplace].[ApplicationNo]
									) Tmp
									WHERE Numindex = 2
								) DDHistory
								ON ApplicationStatus.ApplicationNo = DDHistory.ApplicationNo 
								$join_strsql
								WHERE [Profile].IsActive = 'Y'
								AND [Profile].IsEnabled = 'A'
								AND NOT [Profile].CreateDate IS NULL
								AND NOT NCB.CheckNCBDate IS NULL					
								AND BasicCriteria = '1'
								AND NCB.CheckNCB in ('1', '3')	
								
								$where_addition
								$wheres_name
							) Inquiry
							$wheres
							$wheres_kpi
							$spcial_inquiry
						");
								
						return $result->num_rows();
								
					break;
					case $this->role_rd:
						
							if($kpi_search == 'true'):
								$spcial_inquiry = " AND RegionID = '".$region_id."'";
							else:
								$spcial_inquiry = " AND RegionID = '".$emp_region."'";
							endif;
							
							$result = $this->db->query("
							SELECT	* FROM
								(SELECT
									[Profile].DocID, [Profile].SourceOfCustomer,
									ISNULL( 
										ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
										ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
									) AS StartDate, NCBCheckDate, NCB.CheckNCBDate,
									[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
									[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit, MasterArea.AreaName AS AreaCode,
									[Profile].Branch, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
									Product.ProductCode, Product.ProductName, Product.ProductTypes, ProductType.ProductType AS ProductCat, [Profile].RequestLoan,
									$plana2ca_sql
									Verification.RMProcess, Verification.HQReceiveCADocDate AS HQReceiveCADocDate,
									Verification.SentToCADate AS SentToCADate, CAReturnDateLog,
									IsDefend, ApplicationStatus.CAName, CA_ReceivedDocDate, ApplicationStatus.AFCancelReason,
									CASE
										WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CR'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CR' 
										WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C' 
										WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'P'
										WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PA'
										WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'A'
										WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'R'
										WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'C'
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
										ELSE NULL
									END AS [Status], 
									CASE
										WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CREDIT RETURN'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CREDIT RETURN'  
										WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
										WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'PENDING'
										WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PREAPPROVED'
										WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'APPROVED'
										WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'REJECT'
										WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'CANCEL'
										WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'CANCELBYRM'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'CANCELBYCUS'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'CANCELBYCA'
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
									ELSE NULL
									END AS StatusDesc, 
									ApplicationStatus.StatusReason,
									CASE ApplicationStatus.PreLoan
										WHEN '0' THEN NULL
										ELSE ApplicationStatus.PreLoan
									END AS PreLoan,
									ApplicationStatus.StatusDate AS StatusDate, ApplicationStatus.ApprovedLoan  AS ApprovedLoan,
									ApplicationStatus.PlanDrawdownDate AS PlanDrawdownDate, ApplicationStatus.PlanDateUnknown,
									ApplicationStatus.DrawdownDate AS DrawdownDate,
									ApplicationStatus.DrawdownBaht AS DrawdownBaht, Verification.ActionNote,
									CASE
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'APPROVED' 
											AND NOT ApplicationStatus.DrawdownDate = '' 
											AND NOT ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'APPROVED' 
											AND ApplicationStatus.DrawdownDate = '' 
											AND ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'Active'
										WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'Active'
										WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'Active'							
										ELSE 'Active'
									END AS ActiveRecord,
									ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
									ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
									RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
									RetrieveRecord.EventTime AS RetrieveTime, Installment, 
									dbo.GetApplication(ApplicationStatus.ApplicationNo) AS DDHistory,
									ApplicationStatus.ReceivedEstimateDoc, [Profile].IsActive
								FROM [Profile]
								LEFT OUTER JOIN Verification
								ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
								LEFT OUTER JOIN NCB
								ON Verification.VerifyID = NCB.VerifyID
								LEFT OUTER JOIN ApplicationStatus
								ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
								LEFT OUTER JOIN Product
								ON Verification.ProductCode = Product.ProductCode
								LEFT OUTER JOIN ProductType
								ON Product.ProductTypeID = ProductType.ProductTypeID
								LEFT OUTER JOIN LendingEmp
								ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
								LEFT OUTER JOIN LendingBranchs
								ON [Profile].BranchCode = LendingBranchs.BranchCode
								LEFT OUTER JOIN MasterArea
								ON LendingBranchs.AreaID = MasterArea.AreaNo
								LEFT OUTER JOIN MasterRegion
								ON LendingBranchs.RegionID = MasterRegion.RegionID
								LEFT OUTER JOIN ( SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
								ON Defender.RF_DocID = [Profile].DocID
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
										VerifyID AS VF, BorrowerType, BorrowerName, 
										[dbo].[DateInvalid](CONVERT(nvarchar(10), NCBCheckDate, 120)) AS NCBCheckDate
									FROM dbo.NCBConsentLogs) Tmp
									WHERE Numindex = 1
								) NCBConsentLogs
								ON NCBConsentLogs.VF = Verification.VerifyID 
								AND NCBConsentLogs.BorrowerType = '101'
								LEFT OUTER JOIN (
									SELECT * FROM (
									SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
									DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
									[dbo].[DateInvalid](CONVERT(nvarchar(10), CAReturnDate, 120)) AS CAReturnDateLog
									FROM ReconcileDocLogs) Tmp
									WHERE Numindex = 1				
								) ReconcileDocLogs
								ON [Profile].DocID = ReconcileDocLogs.DocLogs 
								AND ReconcileDocLogs.BorrowerType = '101'
								LEFT OUTER JOIN (
									SELECT DocID, 'Y' AS IsAIP FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
										DocID, ActionNote, ActionNoteDate, ActionDateTime
										FROM (
											SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
											FROM ActionNote
											UNION   
											SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
											FROM SystemNoteLog
										) DATA	
										WHERE IsActive = 'A'
										AND ActionNote LIKE '%AIP%'
									) AS ActionLog
									WHERE Numindex = 1
								) AIPInquiry
								ON [Profile].DocID = AIPInquiry.DocID
								LEFT OUTER JOIN (		
									SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY RetrieveToNewDoc ORDER BY CONVERT(NVARCHAR(10), EventDate, 120) DESC, RIGHT(CONVERT(NVARCHAR(24) , EventTime, 120), 8) DESC) as Numindex, 
										RetrieveToNewDoc, EmployeeCode, CONVERT(NVARCHAR(10) , EventDate, 120) AS EventDate, RIGHT(CONVERT(NVARCHAR(24), EventTime, 120), 8) AS EventTime, 
										'RET' AS RetrievedDigit, 'Y' AS Retrieved
										FROM Retrieve_TransactionLog
									) Tmp
									WHERE Numindex = 1
								) RetrieveRecord
								ON [Profile].DocID = RetrieveRecord.RetrieveToNewDoc
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT DocID, CONVERT(NVARCHAR(10), ReActivateDate, 120) AS ReActivateDate, 
										'REA' AS ReactivateDigit, 'Y' AS ReActivated,
										ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ReActivateDate DESC) as Numindex
										FROM Reactivate_TransactionLog
									) Tmp
									WHERE Numindex = 1
								) ReActivateRecord
								ON [Profile].DocID = ReActivateRecord.DocID
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT isnull([ApplicationNoReplace].[ApplicationNoReplace],[Drawdown_History].[ApplicationNo]) [ApplicationNo] ,
										'Y' AS Installment, ROW_NUMBER() OVER(PARTITION BY [Drawdown_History].[ApplicationNo] ORDER BY DrawdownDate ASC) as Numindex
										FROM [PCIS].[dbo].[Drawdown_History]
										LEFT OUTER JOIN [PCIS].[dbo].[ApplicationNoReplace] ON [Drawdown_History].[ApplicationNo] = [ApplicationNoReplace].[ApplicationNo]
									) Tmp
									WHERE Numindex = 2
								) DDHistory
								ON ApplicationStatus.ApplicationNo = DDHistory.ApplicationNo 
								$join_strsql
								WHERE [Profile].IsActive = 'Y'
								AND [Profile].IsEnabled = 'A'
								AND NOT [Profile].CreateDate IS NULL
								AND NOT NCB.CheckNCBDate IS NULL					
								AND BasicCriteria = '1'
								AND NCB.CheckNCB in ('1', '3')	
								
								$where_addition
								$wheres_name
							) Inquiry
							$wheres
							$wheres_kpi
							$spcial_inquiry
						");
							
						return $result->num_rows();
							
					break;
				}
			}
			
		}
		
	}
	
	
	public function dataTableDashboard($authority, $condition = array()) {
		$this->load->model('dbmodel');
		$this->load->model('dbstore');
		$this->load->library('effective');
		
		$wheres			= "WHERE IsActive = 'Y'";
		$where_addition = "AND LendingBranchs.RegionID IS NOT NULL AND CheckNCBDate > '2014-12-31'";
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
		$defend_list	= '';//$this->input->post('defend_check');
		$retrieve_list 	= '';
		$re_activate	= '';
		
		$drawdown_cm 	 = $this->input->post('drawdown_cm');
		$filter_cncancel = $this->input->post('filter_cncancel');
		
		$iStart  = $this->input->post('start');
		$iLength = $this->input->post('length') ? $iLength = $this->input->post('length') : 25;
		
		$start	= ($iStart)? $iStart : 0;
		$offset = $iLength + $start;
		
		/* ############ KPI ############ */
		
		$kpi_search		= $this->input->post('search_kpi');
		$kpi_no			= $this->input->post('kpino');
		$emp_kpi		= $this->input->post('emp_auth');
		$mode_kpi		= $this->input->post('mode_kpi');
		$use_ca			= $this->input->post('use_ca');			
		$modestate		= $this->input->post('modestate');

		$wheres_kpi		= "";
		$kpi_condition	= "";
		$kpi_privileges	= "";
		
		if($kpi_search == 'true') {
			
			// Call role permission
			$special_role 	= $this->setDataAuthority($emp_kpi);
			
			$get_info 		= $this->getEmployeeDataInfo($emp_kpi); 				
			$brn_code 		= $get_info['data'][0]['BranchCode'];
			$area_code  	= $get_info['data'][0]['AreaCode'];
			$region_id  	= $get_info['data'][0]['RegionID'];
			
			$kpi_privileges  = $this->getAuthPermission($special_role);
				
			$first_date		= trim(date('Y-m-').'01');
			$second_date	= trim(date('Y-m-').date('t', strtotime(date("Y-m-d"))));
						
			switch ($kpi_no) {
				
				case '4':
					
					if($use_ca == 'false') { $wheres_kpi .= " AND CA_ReceivedDocDate IS NULL"; }
					
					break;
				case '6':
					
					if($mode_kpi == $this->branch_mode)  {
						if($brn_code == '000'):
							$kpi_condition = "@Start = $start, @Offset = $offset";
						else:
							$kpi_condition = "@BrnCode = $brn_code, @Start = $start, @Offset = $offset";
						endif;
					}
					else if($mode_kpi == $this->individual_mode) { 
						
						// Check special role in kpi preview mode by passing empcode				
						if(in_array($special_role, array($this->role_am, $this->role_rd))) {
							
							switch($special_role) {
								case $this->role_am:
									$kpi_condition = "@AreaCode = '".$area_code."', @Start = $start, @Offset = $offset";
									break;
								case $this->role_rd:
									$kpi_condition = "@Region = '".$region_id."', @Start = $start, @Offset = $offset";
									break;
								default:
									$kpi_condition = "@RMCode = '".$emp_kpi."', @Start = $start, @Offset = $offset";
									break;
							}
						
						// Role individual usually.
						} else {
							$kpi_condition = "@RMCode = $emp_kpi, @Start = $start, @Offset = $offset";
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
					if($use_ca == 'true') { $wheres_kpi .= " AND CA_ReceivedDocDate IS NOT NULL"; }
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
		$refer_pieces = explode(',', $refer_tlf);
		$status_pieces = explode(',', $status);
				
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
			$wheres_refer   = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $refer_pieces)."'");
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
				if($status_pieces[$index] !== ""):
					array_push($obj_status, $status_pieces[$index]);
				endif;				
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
		
		$order_a2caplan = FALSE;
		if(!empty($caplan_start) && !empty($caplan_end)) {
			$order_a2caplan = TRUE;
			$wheres .= " AND CONVERT(nvarchar(10), AppToCAPlanDate, 120) BETWEEN '".$caplan_start."' AND '".$caplan_end."'";
			array_push($check_datefilter, 'TRUE');
		
		} else {
		
			if(!empty($caplan_start)):
				$order_a2caplan = TRUE;
				$wheres .= " AND CONVERT(nvarchar(10), AppToCAPlanDate, 120)  = '".$caplan_start."'";
				array_push($check_datefilter, 'TRUE');
			else:
				array_push($check_datefilter, 'FALSE');
			endif;
		
			if(!empty($planca_end)):
				$order_a2caplan = TRUE;
				$wheres .= " AND CONVERT(nvarchar(10), AppToCAPlanDate, 120)  = '".$caplan_end."'";
				array_push($check_datefilter, 'TRUE');
			else:
				array_push($check_datefilter, 'FALSE');
			endif;
		}

		$order_a2ca = FALSE;
		if(!empty($cadate_start) && !empty($cadate_end)) {			
			$order_a2ca = TRUE;
			$wheres .= " AND CONVERT(nvarchar(10), CA_ReceivedDocDate, 120) BETWEEN '".$cadate_start."' AND '".$cadate_end."'"; 
			array_push($check_datefilter, 'TRUE');
			
		} else {	
			
			if(!empty($cadate_start)):
				$order_a2ca = TRUE;
				$wheres .= " AND CONVERT(nvarchar(10), CA_ReceivedDocDate, 120)  = '".$cadate_start."'";
				array_push($check_datefilter, 'TRUE');
			else:
				array_push($check_datefilter, 'FALSE');
			endif;
			
			if(!empty($cadate_end)):
				$order_a2ca = TRUE;
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
			if(!empty($appLoan_end)) { $wheres .= " AND ApprovedLoan = '".$appLoan_end."'"; }
		
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
		if(!empty($statusreason_pieces[0])) { $wheres .= " AND  StatusReason in ($wheres_statusreaon) "; }
		if(!empty($rmlist_pieces[0])) { $wheres .= " AND RMCode in ($wheres_rmlist) "; }
		if(!empty($refer_pieces[0])) { $wheres .= " AND SourceOfCustomer in ($wheres_refer) "; }
		if($restimated == 'Y') { $wheres .= " AND ReceivedEstimateDoc = '".$restimated."'"; }
		if($aip_reason == 'Y') { $wheres .= " AND IsAIP = '".$aip_reason."'"; }
		if($cashy_field == 'Y') { $wheres .= " AND Cashy IS NOT NULL"; }	
		else if($cashy_field == 'N') { $wheres .= " AND Cashy IS NULL"; }
	
		// Query Process	
		if($kpi_search == 'true') {
	
			switch ($kpi_no) {
				case '4':	
				case '7':
				case '10':
				case '11':
					if($this->get_ordering() == 'StartDate desc') $adjust_ordering = 'StartDate ASC';
					else $adjust_ordering = $this->get_ordering();					
				break;	
				case '8':
					if($this->get_ordering() == 'StartDate desc') $adjust_ordering = 'CAReturnDateLog ASC';
					else $adjust_ordering = $this->get_ordering();
				break;
				case '9':
				case '14':
				case '15':
				case '16':
				case '17':
				case '21':
					if($this->get_ordering() == 'StartDate desc') $adjust_ordering = 'StatusDate ASC';
					else $adjust_ordering = $this->get_ordering();
				break;
				case '20':
				case '22':
					if($this->get_ordering() == 'StartDate desc') $adjust_ordering = 'DrawdownDate DESC';
					else $adjust_ordering = $this->get_ordering();
				break;
				default: 
					$adjust_ordering = $this->get_ordering();						
				break;
			}
			
		} else {
	
			if($order_a2caplan == TRUE) {
				$adjust_ordering = 'AppToCAPlanDate ASC';
			} 
			/*
			else if($order_a2ca == TRUE) {
				$adjust_ordering = 'CA_ReceivedDocDate ASC';
			}
			*/
			else {
				$adjust_ordering = $this->get_ordering();
			}
			
		}
	
		if(empty($authority)) {
		
			$objForms = array(
					"Privileges" => $authority,
					"Condition"	 => $condition,
					"Optional"	 => $optional
			);
		
			log_message('error', 'method '.__METHOD__ .'can not load data progress. please check object criteria.');
			
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
		
		} else {
			
			if($kpi_search == 'true') {
				$privileges = $kpi_privileges;				
			} else {				
				if(count($authority) > 1) $privileges = $authority[0];
				else $privileges = $authority[0];			
			}

			// load data employees.
			$employees   = $this->employeesInfo($condition[0]);
			$empbranch   = str_pad($employees['data'][0]['BranchCode'], 3, "0", STR_PAD_LEFT);
			$emp_area    = $employees['data'][0]['AreaCode'];
			$emp_region  = $employees['data'][0]['RegionID'];
			
			// KPI PREVIEW
			if($kpi_search == 'true' && in_array($kpi_no, $this->object_kpi)) {
				
				switch ($kpi_no):
					case '6':			
						$result	= $this->dbstore->exec_getWhiteboardKPIPreview($kpi_condition, $modestate);
						return $result;
						
					break;
					
				endswitch;
			
			} else {
				
				$plana2ca_sql = "
				CASE 
					WHEN ProductLoanTypeID = 1 THEN 'Refinance'
					WHEN ProductLoanTypeID = 2 THEN 'Non Refinance'
					ELSE NULL
				END AS ProductLoanType, IsAIP, Verification.Cashy, Bank,
				ISNULL(OwnershipDoc, 'N') AS OwnershipDoc,
				ApplicationStatus.ApplicationNo,
				[dbo].[DateInvalid](CONVERT(nvarchar(10), Verification.AppToCAPlanDate, 120)) AS PlanA2CADraft,
				CASE 		
					WHEN Verification.AppToCAPlanDate <= ApplicationStatus.CA_ReceivedDocDate THEN NULL
					WHEN Verification.AppToCAPlanDate <= ApplicationStatus.[StatusDate]	THEN NULL
					WHEN Verification.AppToCAPlanDate > Verification.HQReceiveCADocDate OR
					Verification.AppToCAPlanDate > Verification.SentToCADate OR
					Verification.AppToCAPlanDate > ApplicationStatus.CA_ReceivedDocDate
					THEN CONVERT(nvarchar(10), Verification.AppToCAPlanDate, 120)
					WHEN Verification.HQReceiveCADocDate IS NULL THEN CONVERT(nvarchar(10), Verification.AppToCAPlanDate, 120)
					ELSE NULL
				END AS AppToCAPlanDate,";
				
				$join_strsql  = "
				LEFT OUTER JOIN (
					SELECT * FROM (
						SELECT RC.DocID, 'Y' AS OwnershipDoc, SubmitDocToCADate AS CompletionDoc, [Status], StatusDate, DrawdownDate,
						ROW_NUMBER() OVER(PARTITION BY RC.DocID ORDER BY RC.DocID ASC) as Numindex
						FROM ReconcileCompletion AS RC
						LEFT OUTER JOIN ApplicationStatus AS APS
						ON RC.DocID = APS.DocID
						WHERE DocList IN ('55','187')
						AND RC.IsActive = 'A'
						AND SubmitDocToCADate IS NULL
						AND DrawdownDate IS NULL
					) A
					WHERE Numindex = 1
				) ObjOwnershipDoc
				ON [Profile].DocID = ObjOwnershipDoc.DocID
				LEFT OUTER JOIN (SELECT DocID AS A2CAID, COUNT(DocID) AS A2CAPostponeAmt FROM AppToCA_History GROUP BY DocID) AS A2CAPlanHis
				ON [Profile].DocID = A2CAPlanHis.A2CAID";
						
				switch($privileges) {
					case $this->role_ad:
					case $this->role_bm:
					case $this->role_hq:
					case $this->role_spv:
					case $this->role_ads:
						
						if($kpi_search == 'true') {
							
							$spcial_inquiry = '';
							if($kpi_search == 'true') {
								if($mode_kpi == $this->individual_mode) $spcial_inquiry = " AND RMCode = '".$emp_kpi."'";
								if($mode_kpi == $this->branch_mode)  {
									if($brn_code == '000'):
										$spcial_inquiry = '';
									else:
										$spcial_inquiry = " AND BranchCode = '".$brn_code."'";
									endif;								
								}
							} else {
								$spcial_inquiry = " AND BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'";
							}
							
							$result = $this->dbmodel->CIQuery("
							SELECT * FROM (
								SELECT *, ROW_NUMBER() OVER (ORDER BY $adjust_ordering) AS KeyPoint
								FROM(SELECT
									[Profile].DocID,  Verification.VerifyID, [Profile].SourceOfCustomer,
									ISNULL( 
										ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
										ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
									) AS StartDate,
									CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) AS CheckNCBDate,
									CONVERT(nvarchar(10), NCBCheckDate, 120) AS NCBCheckDate,
									[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
									[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit, BranchTel, MasterArea.AreaName AS AreaCode,
									[Profile].Branch, LendingBranchs.BranchName, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
									Product.ProductCode, Product.ProductName, Product.ProductTypes, ProductType.ProductType AS ProductCat, [Profile].RequestLoan,										
									CASE Verification.RMProcess
										WHEN 'Completed' THEN 'CP'
										WHEN 'CANCELBYRM' THEN 'CR'
										WHEN 'CANCELBYCA' THEN 'CA'
										WHEN 'CANCELBYCUS' THEN 'CC'
										ELSE 'AA'
									END AS RMProcess,
									$plana2ca_sql
									[dbo].[DateInvalid](CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)) AS HQReceiveCADocDate,
									[dbo].[DateInvalid](CONVERT(nvarchar(10), Verification.SentToCADate, 120)) AS SentToCADate, 
									CAReturnDateLog, IsDefend, ApplicationStatus.CAName,
									CONVERT(nvarchar(10), CA_ReceivedDocDate, 120) AS CA_ReceivedDocDate, 										
									CASE
										WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CR'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CR'  
										WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'P'
										WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PA'
										WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'A'
										WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'R'
										WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'C'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'C'
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
									ELSE NULL
									END AS [Status], 
									CASE
										WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CREDIT RETURN'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CREDIT RETURN'  
										WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
										WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
										WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'PENDING'
										WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PREAPPROVED'
										WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'APPROVED'
										WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'REJECT'
										WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'CANCEL'
										WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'CANCELBYRM'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'CANCELBYCUS'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'CANCELBYCA'
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
									ELSE NULL
									END AS StatusDesc, 
									ApplicationStatus.StatusReason,
									[dbo].[DateInvalid](ApplicationStatus.PreLoan) AS PreLoan,
									[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120)) AS StatusDate,
									[dbo].[DateInvalid](ApplicationStatus.ApprovedLoan) AS ApprovedLoan,
									ApplicationStatus.AFCancelReason,
									[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.PlanDrawdownDate, 120)) AS PlanDrawdownDate,
									[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.PlanDateUnknown, 120)) AS PlanDateUnknown,
									[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.DrawdownDate, 120)) AS DrawdownDate,
									[dbo].[DateInvalid](ApplicationStatus.DrawdownBaht) AS DrawdownBaht, ActionNoteLogs.ActionNote,
									CASE
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'APPROVED' 
										AND NOT ApplicationStatus.DrawdownDate = '' 
										AND NOT ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'APPROVED' 
										AND ApplicationStatus.DrawdownDate = '' 
										AND ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'Active'
										WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'InActive'
										WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'Active'
										WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'Active'
										ELSE 'Active'
									END AS ActiveRecord,
									ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
									ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
									RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
									RetrieveRecord.EventTime AS RetrieveTime, Installment, 
									dbo.GetApplication(ApplicationStatus.ApplicationNo) AS DDHistory,
									ApplicationStatus.ReceivedEstimateDoc, A2CAPostponeAmt,
									[Profile].IsActive
									FROM [Profile]
									LEFT OUTER JOIN Verification
									ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
									LEFT OUTER JOIN NCB
									ON Verification.VerifyID = NCB.VerifyID
									LEFT OUTER JOIN ApplicationStatus
									ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
									LEFT OUTER JOIN Product
									ON Verification.ProductCode = Product.ProductCode
									LEFT OUTER JOIN ProductType
									ON Product.ProductTypeID = ProductType.ProductTypeID
									LEFT OUTER JOIN LendingEmp
									ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
									LEFT OUTER JOIN LendingBranchs
									ON [Profile].BranchCode = LendingBranchs.BranchCode
									LEFT OUTER JOIN MasterArea
									ON LendingBranchs.AreaID = MasterArea.AreaNo
									LEFT OUTER JOIN MasterRegion
									ON LendingBranchs.RegionID = MasterRegion.RegionID
									LEFT OUTER JOIN (SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
									ON Defender.RF_DocID = [Profile].DocID	
									LEFT OUTER JOIN ( 
										SELECT * FROM (
											SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
											DocID, ActionNote, ActionNoteDate, ActionDateTime
											FROM (
												SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
												CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
												FROM ActionNote
												UNION
												SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
												CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
												FROM ActionNoteLog
												UNION   
												SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
												CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
												FROM SystemNoteLog
											) DATA	
											WHERE IsActive = 'A'
										) AS ActionLog
										WHERE Numindex = 1
									) ActionNoteLogs
									ON [Profile].DocID = ActionNoteLogs.DocID
									LEFT OUTER JOIN (
										SELECT DocID, 'Y' AS IsAIP FROM (
											SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
											DocID, ActionNote, ActionNoteDate, ActionDateTime
											FROM (
												SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
												CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
												FROM ActionNote
												UNION   
												SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
												CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
												FROM SystemNoteLog
											) DATA	
											WHERE IsActive = 'A'
											AND ActionNote LIKE '%AIP%'
										) AS ActionLog
										WHERE Numindex = 1
									) AIPInquiry
									ON [Profile].DocID = AIPInquiry.DocID
									LEFT OUTER JOIN (
										SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
										VerifyID AS VF, BorrowerType, BorrowerName, 
										[dbo].[DateInvalid](CONVERT(nvarchar(10), NCBCheckDate, 120)) AS NCBCheckDate
										FROM dbo.NCBConsentLogs) Tmp
										WHERE Numindex = 1
									) NCBConsentLogs
									ON NCBConsentLogs.VF = Verification.VerifyID 
									AND NCBConsentLogs.BorrowerType = '101'
									LEFT OUTER JOIN (
										SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
										DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
										[dbo].[DateInvalid]( CONVERT(nvarchar(10), CAReturnDate, 120)) AS CAReturnDateLog
										FROM ReconcileDocLogs) Tmp
										WHERE Numindex = 1				
									) ReconcileDocLogs
									ON [Profile].DocID = ReconcileDocLogs.DocLogs 
									AND ReconcileDocLogs.BorrowerType = '101'
									LEFT OUTER JOIN (		
										SELECT * FROM (
											SELECT ROW_NUMBER() OVER(PARTITION BY RetrieveToNewDoc ORDER BY CONVERT(NVARCHAR(10), EventDate, 120) DESC, RIGHT(CONVERT(NVARCHAR(24) , EventTime, 120), 8) DESC) as Numindex, 
											RetrieveToNewDoc, EmployeeCode, CONVERT(NVARCHAR(10) , EventDate, 120) AS EventDate, RIGHT(CONVERT(NVARCHAR(24), EventTime, 120), 8) AS EventTime, 
											'RET' AS RetrievedDigit, 'Y' AS Retrieved
											FROM Retrieve_TransactionLog
										) Tmp
										WHERE Numindex = 1
									) RetrieveRecord
									ON [Profile].DocID = RetrieveRecord.RetrieveToNewDoc
									LEFT OUTER JOIN (
										SELECT * FROM (
											SELECT DocID, CONVERT(NVARCHAR(10), ReActivateDate, 120) AS ReActivateDate, 
											'REA' AS ReactivateDigit, 'Y' AS ReActivated,
											ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ReActivateDate DESC) as Numindex
											FROM Reactivate_TransactionLog
										) Tmp
										WHERE Numindex = 1
									) ReActivateRecord
									ON [Profile].DocID = ReActivateRecord.DocID
									LEFT OUTER JOIN (
										SELECT * FROM (
											SELECT isnull([ApplicationNoReplace].[ApplicationNoReplace],[Drawdown_History].[ApplicationNo]) [ApplicationNo] ,
											'Y' AS Installment, ROW_NUMBER() OVER(PARTITION BY [Drawdown_History].[ApplicationNo] ORDER BY DrawdownDate ASC) as Numindex
											FROM [PCIS].[dbo].[Drawdown_History]
											LEFT OUTER JOIN [PCIS].[dbo].[ApplicationNoReplace] ON [Drawdown_History].[ApplicationNo] = [ApplicationNoReplace].[ApplicationNo]
										) Tmp
										WHERE Numindex = 2
									) DDHistory
									ON ApplicationStatus.ApplicationNo = DDHistory.ApplicationNo 
									$join_strsql
									WHERE [Profile].IsEnabled = 'A'
									AND NOT [Profile].CreateDate IS NULL
									AND NOT NCB.CheckNCBDate IS NULL								
									AND BasicCriteria = '1'
									AND NCB.CheckNCB in ('1', '3')	
									
									$where_addition
									$wheres_name
								) Inquiry
								$wheres
								$wheres_kpi	
								$spcial_inquiry										
							) TMPAAA
							WHERE KeyPoint > $start AND KeyPoint <= $offset");
							
							return $result;
							
						} else {
							
							if($empbranch == "000" || $empbranch == "901") {
							
								$result = $this->dbmodel->CIQuery("
								SELECT * FROM (
									SELECT *, ROW_NUMBER() OVER (ORDER BY $adjust_ordering) AS KeyPoint
									FROM(SELECT
										[Profile].DocID,  Verification.VerifyID, [Profile].SourceOfCustomer,
										ISNULL( 
											ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
											ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
										) AS StartDate,
										CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) AS CheckNCBDate,
										CONVERT(nvarchar(10), NCBCheckDate, 120) AS NCBCheckDate,
										[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
										[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit, BranchTel, MasterArea.AreaName AS AreaCode,
										[Profile].Branch, LendingBranchs.BranchName, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
										Product.ProductCode, Product.ProductName, Product.ProductTypes, ProductType.ProductType AS ProductCat, [Profile].RequestLoan,										
										CASE Verification.RMProcess
											WHEN 'Completed' THEN 'CP'
											WHEN 'CANCELBYRM' THEN 'CR'
											WHEN 'CANCELBYCA' THEN 'CA'
											WHEN 'CANCELBYCUS' THEN 'CC'
											ELSE 'AA'
										END AS RMProcess,
										$plana2ca_sql
										[dbo].[DateInvalid](CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)) AS HQReceiveCADocDate,
										[dbo].[DateInvalid](CONVERT(nvarchar(10), Verification.SentToCADate, 120)) AS SentToCADate, 
										CAReturnDateLog, IsDefend, ApplicationStatus.CAName,
										CONVERT(nvarchar(10), CA_ReceivedDocDate, 120) AS CA_ReceivedDocDate, 										
										CASE
											WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CR'
											WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CR'  
											WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
											WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
											WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'P'
											WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PA'
											WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'A'
											WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'R'
											WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'C'
											WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'C'
											WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'C'
											WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'C'
											WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
										ELSE NULL
										END AS [Status], 
										CASE
											WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CREDIT RETURN'
											WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CREDIT RETURN'  
											WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
											WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
											WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'PENDING'
											WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PREAPPROVED'
											WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'APPROVED'
											WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'REJECT'
											WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'CANCEL'
											WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'CANCELBYRM'
											WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'CANCELBYCUS'
											WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'CANCELBYCA'
											WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
										ELSE NULL
										END AS StatusDesc, 
										ApplicationStatus.StatusReason,
										[dbo].[DateInvalid](ApplicationStatus.PreLoan) AS PreLoan,
										[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120)) AS StatusDate,
										[dbo].[DateInvalid](ApplicationStatus.ApprovedLoan) AS ApprovedLoan,
										ApplicationStatus.AFCancelReason,
										[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.PlanDrawdownDate, 120)) AS PlanDrawdownDate,
										[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.PlanDateUnknown, 120)) AS PlanDateUnknown,
										[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.DrawdownDate, 120)) AS DrawdownDate,
										[dbo].[DateInvalid](ApplicationStatus.DrawdownBaht) AS DrawdownBaht, ActionNoteLogs.ActionNote,
										CASE
											WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'APPROVED' 
											AND NOT ApplicationStatus.DrawdownDate = '' 
											AND NOT ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'APPROVED' 
											AND ApplicationStatus.DrawdownDate = '' 
											AND ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'Active'
											WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'Active'
											WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'Active'
											ELSE 'Active'
										END AS ActiveRecord,
										ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
										ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
										RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
										RetrieveRecord.EventTime AS RetrieveTime, Installment, 
										dbo.GetApplication(ApplicationStatus.ApplicationNo) AS DDHistory,
										ApplicationStatus.ReceivedEstimateDoc, A2CAPostponeAmt,
										[Profile].IsActive
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN ApplicationStatus
										ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
										LEFT OUTER JOIN Product
										ON Verification.ProductCode = Product.ProductCode
										LEFT OUTER JOIN ProductType
										ON Product.ProductTypeID = ProductType.ProductTypeID
										LEFT OUTER JOIN LendingEmp
										ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										LEFT OUTER JOIN MasterArea
										ON LendingBranchs.AreaID = MasterArea.AreaNo
										LEFT OUTER JOIN MasterRegion
										ON LendingBranchs.RegionID = MasterRegion.RegionID
										LEFT OUTER JOIN (SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
										ON Defender.RF_DocID = [Profile].DocID	
										LEFT OUTER JOIN ( 
											SELECT * FROM (
												SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
												DocID, ActionNote, ActionNoteDate, ActionDateTime
												FROM (
													SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
													CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
													FROM ActionNote
													UNION
													SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
													CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
													FROM ActionNoteLog
													UNION   
													SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
													CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
													FROM SystemNoteLog
												) DATA	
												WHERE IsActive = 'A'
											) AS ActionLog
											WHERE Numindex = 1
										) ActionNoteLogs
										ON [Profile].DocID = ActionNoteLogs.DocID
										LEFT OUTER JOIN (
											SELECT DocID, 'Y' AS IsAIP FROM (
												SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
												DocID, ActionNote, ActionNoteDate, ActionDateTime
												FROM (
													SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
													CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
													FROM ActionNote
													UNION   
													SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
													CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
													FROM SystemNoteLog
												) DATA	
												WHERE IsActive = 'A'
												AND ActionNote LIKE '%AIP%'
											) AS ActionLog
											WHERE Numindex = 1
										) AIPInquiry
										ON [Profile].DocID = AIPInquiry.DocID
										LEFT OUTER JOIN (
											SELECT * FROM (
											SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
											VerifyID AS VF, BorrowerType, BorrowerName, 
											[dbo].[DateInvalid](CONVERT(nvarchar(10), NCBCheckDate, 120)) AS NCBCheckDate
											FROM dbo.NCBConsentLogs) Tmp
											WHERE Numindex = 1
										) NCBConsentLogs
										ON NCBConsentLogs.VF = Verification.VerifyID 
										AND NCBConsentLogs.BorrowerType = '101'
										LEFT OUTER JOIN (
											SELECT * FROM (
											SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
											DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
											[dbo].[DateInvalid]( CONVERT(nvarchar(10), CAReturnDate, 120)) AS CAReturnDateLog
											FROM ReconcileDocLogs) Tmp
											WHERE Numindex = 1				
										) ReconcileDocLogs
										ON [Profile].DocID = ReconcileDocLogs.DocLogs 
										AND ReconcileDocLogs.BorrowerType = '101'
										LEFT OUTER JOIN (		
											SELECT * FROM (
												SELECT ROW_NUMBER() OVER(PARTITION BY RetrieveToNewDoc ORDER BY CONVERT(NVARCHAR(10), EventDate, 120) DESC, RIGHT(CONVERT(NVARCHAR(24) , EventTime, 120), 8) DESC) as Numindex, 
												RetrieveToNewDoc, EmployeeCode, CONVERT(NVARCHAR(10) , EventDate, 120) AS EventDate, RIGHT(CONVERT(NVARCHAR(24), EventTime, 120), 8) AS EventTime, 
												'RET' AS RetrievedDigit, 'Y' AS Retrieved
												FROM Retrieve_TransactionLog
											) Tmp
											WHERE Numindex = 1
										) RetrieveRecord
										ON [Profile].DocID = RetrieveRecord.RetrieveToNewDoc
										LEFT OUTER JOIN (
											SELECT * FROM (
												SELECT DocID, CONVERT(NVARCHAR(10), ReActivateDate, 120) AS ReActivateDate, 
												'REA' AS ReactivateDigit, 'Y' AS ReActivated,
												ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ReActivateDate DESC) as Numindex
												FROM Reactivate_TransactionLog
											) Tmp
											WHERE Numindex = 1
										) ReActivateRecord
										ON [Profile].DocID = ReActivateRecord.DocID
										LEFT OUTER JOIN (
											SELECT * FROM (
												SELECT isnull([ApplicationNoReplace].[ApplicationNoReplace],[Drawdown_History].[ApplicationNo]) [ApplicationNo] ,
												'Y' AS Installment, ROW_NUMBER() OVER(PARTITION BY [Drawdown_History].[ApplicationNo] ORDER BY DrawdownDate ASC) as Numindex
												FROM [PCIS].[dbo].[Drawdown_History]
												LEFT OUTER JOIN [PCIS].[dbo].[ApplicationNoReplace] ON [Drawdown_History].[ApplicationNo] = [ApplicationNoReplace].[ApplicationNo]
											) Tmp
											WHERE Numindex = 2
										) DDHistory
										ON ApplicationStatus.ApplicationNo = DDHistory.ApplicationNo 
										$join_strsql
										WHERE [Profile].IsEnabled = 'A'
										AND NOT [Profile].CreateDate IS NULL
										AND NOT NCB.CheckNCBDate IS NULL								
										AND BasicCriteria = '1'
										AND NCB.CheckNCB in ('1', '3')	
										
										$where_addition
										$wheres_name
									) Inquiry
									$wheres									
								) TMPAAA
								WHERE KeyPoint > $start AND KeyPoint <= $offset");
									
								return $result;
								
							} else {
								
								// Admin are not head office
								// Check has authority area manager
								$select_privilege = '';
								if(in_array($this->role_am, $authority)):
									$select_privilege = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' AND IsActive = 'A' GROUP BY BranchCode)";
								else:
									$select_privilege = " AND BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'";
								endif;
					
								$result = $this->dbmodel->CIQuery("
								SELECT * FROM (
									SELECT *, ROW_NUMBER() OVER (ORDER BY $adjust_ordering) AS KeyPoint
									FROM(SELECT
										[Profile].DocID,  Verification.VerifyID, [Profile].SourceOfCustomer,
										ISNULL( 
											ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
											ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
										) AS StartDate,
										CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) AS CheckNCBDate,
										CONVERT(nvarchar(10), NCBCheckDate, 120) AS NCBCheckDate,
										[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
										[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit, BranchTel, MasterArea.AreaName AS AreaCode,
										[Profile].Branch, LendingBranchs.BranchName, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
										Product.ProductCode, Product.ProductName, Product.ProductTypes, ProductType.ProductType AS ProductCat, [Profile].RequestLoan,										
										CASE Verification.RMProcess
											WHEN 'Completed' THEN 'CP'
											WHEN 'CANCELBYRM' THEN 'CR'
											WHEN 'CANCELBYCA' THEN 'CA'
											WHEN 'CANCELBYCUS' THEN 'CC'
											ELSE 'AA'
										END AS RMProcess,
										$plana2ca_sql
										[dbo].[DateInvalid](CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)) AS HQReceiveCADocDate,
										[dbo].[DateInvalid](CONVERT(nvarchar(10), Verification.SentToCADate, 120)) AS SentToCADate, 
										CAReturnDateLog, IsDefend, ApplicationStatus.CAName,
										CONVERT(nvarchar(10), CA_ReceivedDocDate, 120) AS CA_ReceivedDocDate, 										
										CASE
											WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CR'
											WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CR'  
											WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
											WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
											WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'P'
											WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PA'
											WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'A'
											WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'R'
											WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'C'
											WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'C'
											WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'C'
											WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'C'
											WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
										ELSE NULL
										END AS [Status], 
										CASE
											WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CREDIT RETURN'
											WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CREDIT RETURN'  
											WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
											WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
											WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'PENDING'
											WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PREAPPROVED'
											WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'APPROVED'
											WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'REJECT'
											WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'CANCEL'
											WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'CANCELBYRM'
											WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'CANCELBYCUS'
											WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'CANCELBYCA'
											WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
										ELSE NULL
										END AS StatusDesc, 
										ApplicationStatus.StatusReason,
										[dbo].[DateInvalid](ApplicationStatus.PreLoan) AS PreLoan,
										[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120)) AS StatusDate,
										[dbo].[DateInvalid](ApplicationStatus.ApprovedLoan) AS ApprovedLoan,
										ApplicationStatus.AFCancelReason,
										[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.PlanDrawdownDate, 120)) AS PlanDrawdownDate,
										[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.PlanDateUnknown, 120)) AS PlanDateUnknown,
										[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.DrawdownDate, 120)) AS DrawdownDate,
										[dbo].[DateInvalid](ApplicationStatus.DrawdownBaht) AS DrawdownBaht, ActionNoteLogs.ActionNote,
										CASE
											WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'APPROVED' 
											AND NOT ApplicationStatus.DrawdownDate = '' 
											AND NOT ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'APPROVED' 
											AND ApplicationStatus.DrawdownDate = '' 
											AND ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'Active'
											WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'InActive'
											WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'Active'
											WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'Active'
											ELSE 'Active'
										END AS ActiveRecord,
										ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
										ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
										RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
										RetrieveRecord.EventTime AS RetrieveTime, Installment, 
										dbo.GetApplication(ApplicationStatus.ApplicationNo) AS DDHistory,
										ApplicationStatus.ReceivedEstimateDoc, A2CAPostponeAmt,
										[Profile].IsActive
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN ApplicationStatus
										ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
										LEFT OUTER JOIN Product
										ON Verification.ProductCode = Product.ProductCode
										LEFT OUTER JOIN ProductType
										ON Product.ProductTypeID = ProductType.ProductTypeID
										LEFT OUTER JOIN LendingEmp
										ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										LEFT OUTER JOIN MasterArea
										ON LendingBranchs.AreaID = MasterArea.AreaNo
										LEFT OUTER JOIN MasterRegion
										ON LendingBranchs.RegionID = MasterRegion.RegionID
										LEFT OUTER JOIN (SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
										ON Defender.RF_DocID = [Profile].DocID	
										LEFT OUTER JOIN ( 
											SELECT * FROM (
												SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
												DocID, ActionNote, ActionNoteDate, ActionDateTime
												FROM (
													SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
													CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
													FROM ActionNote
													UNION
													SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
													CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
													FROM ActionNoteLog
													UNION   
													SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
													CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
													FROM SystemNoteLog
												) DATA	
												WHERE IsActive = 'A'
											) AS ActionLog
											WHERE Numindex = 1
										) ActionNoteLogs
										ON [Profile].DocID = ActionNoteLogs.DocID
										LEFT OUTER JOIN (
											SELECT DocID, 'Y' AS IsAIP FROM (
												SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
												DocID, ActionNote, ActionNoteDate, ActionDateTime
												FROM (
													SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
													CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
													FROM ActionNote
													UNION   
													SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
													CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
													FROM SystemNoteLog
												) DATA	
												WHERE IsActive = 'A'
												AND ActionNote LIKE '%AIP%'
											) AS ActionLog
											WHERE Numindex = 1
										) AIPInquiry
										ON [Profile].DocID = AIPInquiry.DocID
										LEFT OUTER JOIN (
											SELECT * FROM (
											SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
											VerifyID AS VF, BorrowerType, BorrowerName, 
											[dbo].[DateInvalid](CONVERT(nvarchar(10), NCBCheckDate, 120)) AS NCBCheckDate
											FROM dbo.NCBConsentLogs) Tmp
											WHERE Numindex = 1
										) NCBConsentLogs
										ON NCBConsentLogs.VF = Verification.VerifyID 
										AND NCBConsentLogs.BorrowerType = '101'
										LEFT OUTER JOIN (
											SELECT * FROM (
											SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
											DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
											[dbo].[DateInvalid]( CONVERT(nvarchar(10), CAReturnDate, 120)) AS CAReturnDateLog
											FROM ReconcileDocLogs) Tmp
											WHERE Numindex = 1				
										) ReconcileDocLogs
										ON [Profile].DocID = ReconcileDocLogs.DocLogs 
										AND ReconcileDocLogs.BorrowerType = '101'
										LEFT OUTER JOIN (		
											SELECT * FROM (
												SELECT ROW_NUMBER() OVER(PARTITION BY RetrieveToNewDoc ORDER BY CONVERT(NVARCHAR(10), EventDate, 120) DESC, RIGHT(CONVERT(NVARCHAR(24) , EventTime, 120), 8) DESC) as Numindex, 
												RetrieveToNewDoc, EmployeeCode, CONVERT(NVARCHAR(10) , EventDate, 120) AS EventDate, RIGHT(CONVERT(NVARCHAR(24), EventTime, 120), 8) AS EventTime, 
												'RET' AS RetrievedDigit, 'Y' AS Retrieved
												FROM Retrieve_TransactionLog
											) Tmp
											WHERE Numindex = 1
										) RetrieveRecord
										ON [Profile].DocID = RetrieveRecord.RetrieveToNewDoc
										LEFT OUTER JOIN (
											SELECT * FROM (
												SELECT DocID, CONVERT(NVARCHAR(10), ReActivateDate, 120) AS ReActivateDate, 
												'REA' AS ReactivateDigit, 'Y' AS ReActivated,
												ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ReActivateDate DESC) as Numindex
												FROM Reactivate_TransactionLog
											) Tmp
											WHERE Numindex = 1
										) ReActivateRecord
										ON [Profile].DocID = ReActivateRecord.DocID
										LEFT OUTER JOIN (
											SELECT * FROM (
												SELECT isnull([ApplicationNoReplace].[ApplicationNoReplace],[Drawdown_History].[ApplicationNo]) [ApplicationNo] ,
												'Y' AS Installment, ROW_NUMBER() OVER(PARTITION BY [Drawdown_History].[ApplicationNo] ORDER BY DrawdownDate ASC) as Numindex
												FROM [PCIS].[dbo].[Drawdown_History]
												LEFT OUTER JOIN [PCIS].[dbo].[ApplicationNoReplace] ON [Drawdown_History].[ApplicationNo] = [ApplicationNoReplace].[ApplicationNo]
											) Tmp
											WHERE Numindex = 2
										) DDHistory
										ON ApplicationStatus.ApplicationNo = DDHistory.ApplicationNo 
										$join_strsql
										WHERE [Profile].IsEnabled = 'A'
										AND NOT [Profile].CreateDate IS NULL
										AND NOT NCB.CheckNCBDate IS NULL								
										AND BasicCriteria = '1'
										AND NCB.CheckNCB in ('1', '3')	
										
										$where_addition
										$wheres_name
									) Inquiry
									$wheres	
									$select_privilege								
								) TMPAAA
								WHERE KeyPoint > $start AND KeyPoint <= $offset");	
			
								return $result;
								
							}
							
						}
		
					break;
					case $this->role_rm:
						
						if($kpi_search == 'true'):
							$spcial_inquiry = " AND RMCode = '".$emp_kpi."'";
						else:
							$spcial_inquiry = " AND RMCode = '".$employees['data'][0]['EmployeeCode']."'";
						endif;
						
						$result = $this->dbmodel->CIQuery("
						SELECT * FROM (
							SELECT *, ROW_NUMBER() OVER (ORDER BY $adjust_ordering) AS KeyPoint
							FROM(SELECT
								[Profile].DocID,  Verification.VerifyID, [Profile].SourceOfCustomer,
								ISNULL( 
									ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
									ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
								) AS StartDate,
								CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) AS CheckNCBDate,
								CONVERT(nvarchar(10), NCBCheckDate, 120) AS NCBCheckDate,
								[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
								[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit, BranchTel, MasterArea.AreaName AS AreaCode,
								[Profile].Branch, LendingBranchs.BranchName, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
								Product.ProductCode, Product.ProductName, Product.ProductTypes, ProductType.ProductType AS ProductCat, [Profile].RequestLoan,										
								CASE Verification.RMProcess
									WHEN 'Completed' THEN 'CP'
									WHEN 'CANCELBYRM' THEN 'CR'
									WHEN 'CANCELBYCA' THEN 'CA'
									WHEN 'CANCELBYCUS' THEN 'CC'
									ELSE 'AA'
								END AS RMProcess,
								$plana2ca_sql
								[dbo].[DateInvalid](CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)) AS HQReceiveCADocDate,
								[dbo].[DateInvalid](CONVERT(nvarchar(10), Verification.SentToCADate, 120)) AS SentToCADate, 
								CAReturnDateLog, IsDefend, ApplicationStatus.CAName,
								CONVERT(nvarchar(10), CA_ReceivedDocDate, 120) AS CA_ReceivedDocDate, 										
								CASE
									WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CR'
									WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CR'  
									WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
									WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
									WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'P'
									WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PA'
									WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'A'
									WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'R'
									WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'C'
									WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'C'
									WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'C'
									WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'C'
									WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
								ELSE NULL
								END AS [Status], 
								CASE
									WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CREDIT RETURN'
									WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CREDIT RETURN'  
									WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
									WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
									WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'PENDING'
									WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PREAPPROVED'
									WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'APPROVED'
									WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'REJECT'
									WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'CANCEL'
									WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'CANCELBYRM'
									WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'CANCELBYCUS'
									WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'CANCELBYCA'
									WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
								ELSE NULL
								END AS StatusDesc, 
								ApplicationStatus.StatusReason,
								[dbo].[DateInvalid](ApplicationStatus.PreLoan) AS PreLoan,
								[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120)) AS StatusDate,
								[dbo].[DateInvalid](ApplicationStatus.ApprovedLoan) AS ApprovedLoan,
								ApplicationStatus.AFCancelReason,
								[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.PlanDrawdownDate, 120)) AS PlanDrawdownDate,
								[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.PlanDateUnknown, 120)) AS PlanDateUnknown,
								[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.DrawdownDate, 120)) AS DrawdownDate,
								[dbo].[DateInvalid](ApplicationStatus.DrawdownBaht) AS DrawdownBaht, ActionNoteLogs.ActionNote,
								CASE
									WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'APPROVED' 
									AND NOT ApplicationStatus.DrawdownDate = '' 
									AND NOT ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'APPROVED' 
									AND ApplicationStatus.DrawdownDate = '' 
									AND ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'Active'
									WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'Active'
									WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'Active'
									ELSE 'Active'
								END AS ActiveRecord,
								ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
								ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
								RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
								RetrieveRecord.EventTime AS RetrieveTime, Installment, 
								dbo.GetApplication(ApplicationStatus.ApplicationNo) AS DDHistory,
								ApplicationStatus.ReceivedEstimateDoc, A2CAPostponeAmt,
								[Profile].IsActive
								FROM [Profile]
								LEFT OUTER JOIN Verification
								ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
								LEFT OUTER JOIN NCB
								ON Verification.VerifyID = NCB.VerifyID
								LEFT OUTER JOIN ApplicationStatus
								ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
								LEFT OUTER JOIN Product
								ON Verification.ProductCode = Product.ProductCode
								LEFT OUTER JOIN ProductType
								ON Product.ProductTypeID = ProductType.ProductTypeID
								LEFT OUTER JOIN LendingEmp
								ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
								LEFT OUTER JOIN LendingBranchs
								ON [Profile].BranchCode = LendingBranchs.BranchCode
								LEFT OUTER JOIN MasterArea
								ON LendingBranchs.AreaID = MasterArea.AreaNo
								LEFT OUTER JOIN MasterRegion
								ON LendingBranchs.RegionID = MasterRegion.RegionID
								LEFT OUTER JOIN (SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
								ON Defender.RF_DocID = [Profile].DocID	
								LEFT OUTER JOIN ( 
									SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
										DocID, ActionNote, ActionNoteDate, ActionDateTime
										FROM (
											SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
											FROM ActionNote
											UNION
											SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
											FROM ActionNoteLog
											UNION   
											SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
											FROM SystemNoteLog
										) DATA	
										WHERE IsActive = 'A'
									) AS ActionLog
									WHERE Numindex = 1
								) ActionNoteLogs
								ON [Profile].DocID = ActionNoteLogs.DocID
								LEFT OUTER JOIN (
									SELECT DocID, 'Y' AS IsAIP FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
										DocID, ActionNote, ActionNoteDate, ActionDateTime
										FROM (											
											SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
											FROM ActionNote
											UNION   
											SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
											FROM SystemNoteLog
										) DATA	
										WHERE IsActive = 'A'
										AND ActionNote LIKE '%AIP%'
									) AS ActionLog
									WHERE Numindex = 1
								) AIPInquiry
								ON [Profile].DocID = AIPInquiry.DocID
								LEFT OUTER JOIN (
									SELECT * FROM (
									SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
									VerifyID AS VF, BorrowerType, BorrowerName, 
									[dbo].[DateInvalid](CONVERT(nvarchar(10), NCBCheckDate, 120)) AS NCBCheckDate
									FROM dbo.NCBConsentLogs) Tmp
									WHERE Numindex = 1
								) NCBConsentLogs
								ON NCBConsentLogs.VF = Verification.VerifyID 
								AND NCBConsentLogs.BorrowerType = '101'
								LEFT OUTER JOIN (
									SELECT * FROM (
									SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
									DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
									[dbo].[DateInvalid]( CONVERT(nvarchar(10), CAReturnDate, 120)) AS CAReturnDateLog
									FROM ReconcileDocLogs) Tmp
									WHERE Numindex = 1				
								) ReconcileDocLogs
								ON [Profile].DocID = ReconcileDocLogs.DocLogs 
								AND ReconcileDocLogs.BorrowerType = '101'
								LEFT OUTER JOIN (		
									SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY RetrieveToNewDoc ORDER BY CONVERT(NVARCHAR(10), EventDate, 120) DESC, RIGHT(CONVERT(NVARCHAR(24) , EventTime, 120), 8) DESC) as Numindex, 
										RetrieveToNewDoc, EmployeeCode, CONVERT(NVARCHAR(10) , EventDate, 120) AS EventDate, RIGHT(CONVERT(NVARCHAR(24), EventTime, 120), 8) AS EventTime, 
										'RET' AS RetrievedDigit, 'Y' AS Retrieved
										FROM Retrieve_TransactionLog
									) Tmp
									WHERE Numindex = 1
								) RetrieveRecord
								ON [Profile].DocID = RetrieveRecord.RetrieveToNewDoc
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT DocID, CONVERT(NVARCHAR(10), ReActivateDate, 120) AS ReActivateDate, 
										'REA' AS ReactivateDigit, 'Y' AS ReActivated,
										ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ReActivateDate DESC) as Numindex
										FROM Reactivate_TransactionLog
									) Tmp
									WHERE Numindex = 1
								) ReActivateRecord
								ON [Profile].DocID = ReActivateRecord.DocID
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT isnull([ApplicationNoReplace].[ApplicationNoReplace],[Drawdown_History].[ApplicationNo]) [ApplicationNo] ,
										'Y' AS Installment, ROW_NUMBER() OVER(PARTITION BY [Drawdown_History].[ApplicationNo] ORDER BY DrawdownDate ASC) as Numindex
										FROM [PCIS].[dbo].[Drawdown_History]
										LEFT OUTER JOIN [PCIS].[dbo].[ApplicationNoReplace] ON [Drawdown_History].[ApplicationNo] = [ApplicationNoReplace].[ApplicationNo]
									) Tmp
									WHERE Numindex = 2
								) DDHistory
								ON ApplicationStatus.ApplicationNo = DDHistory.ApplicationNo 
								$join_strsql
								WHERE [Profile].IsEnabled = 'A'
								AND NOT [Profile].CreateDate IS NULL
								AND NOT NCB.CheckNCBDate IS NULL								
								AND BasicCriteria = '1'
								AND NCB.CheckNCB in ('1', '3')	
								
								$where_addition
								$wheres_name
							) Inquiry
							$wheres	
							$wheres_kpi
							$spcial_inquiry							
						) TMPAAA
						WHERE KeyPoint > $start AND KeyPoint <= $offset

								");
						
						return $result;
				
						
					break;
					case $this->role_am:
						
						if($kpi_search == 'true'):
							$spcial_inquiry = " AND AreaCode = '".$area_code."'";
						else:
							$spcial_inquiry = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' GROUP BY BranchCode)";
						endif;
											
						$result = $this->dbmodel->CIQuery("
						SELECT * FROM (
							SELECT *, ROW_NUMBER() OVER (ORDER BY $adjust_ordering) AS KeyPoint
							FROM(SELECT
								[Profile].DocID,  Verification.VerifyID, [Profile].SourceOfCustomer,
								ISNULL( 
									ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
									ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
								) AS StartDate,
								CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) AS CheckNCBDate,
								CONVERT(nvarchar(10), NCBCheckDate, 120) AS NCBCheckDate,
								[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
								[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit, BranchTel, MasterArea.AreaName AS AreaCode,
								[Profile].Branch, LendingBranchs.BranchName, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
								Product.ProductCode, Product.ProductName, Product.ProductTypes, ProductType.ProductType AS ProductCat, [Profile].RequestLoan,										
								CASE Verification.RMProcess
									WHEN 'Completed' THEN 'CP'
									WHEN 'CANCELBYRM' THEN 'CR'
									WHEN 'CANCELBYCA' THEN 'CA'
									WHEN 'CANCELBYCUS' THEN 'CC'
									ELSE 'AA'
								END AS RMProcess,
								$plana2ca_sql
								[dbo].[DateInvalid](CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)) AS HQReceiveCADocDate,
								[dbo].[DateInvalid](CONVERT(nvarchar(10), Verification.SentToCADate, 120)) AS SentToCADate, 
								CAReturnDateLog, IsDefend, ApplicationStatus.CAName,
								CONVERT(nvarchar(10), CA_ReceivedDocDate, 120) AS CA_ReceivedDocDate, 										
								CASE
									WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CR'
									WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CR'  
									WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
									WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
									WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'P'
									WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PA'
									WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'A'
									WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'R'
									WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'C'
									WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'C'
									WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'C'
									WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'C'
									WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
								ELSE NULL
								END AS [Status], 
								CASE
									WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CREDIT RETURN'
									WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CREDIT RETURN'  
									WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
									WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
									WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'PENDING'
									WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PREAPPROVED'
									WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'APPROVED'
									WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'REJECT'
									WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'CANCEL'
									WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'CANCELBYRM'
									WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'CANCELBYCUS'
									WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'CANCELBYCA'
									WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
								ELSE NULL
								END AS StatusDesc, 
								ApplicationStatus.StatusReason,
								[dbo].[DateInvalid](ApplicationStatus.PreLoan) AS PreLoan,
								[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120)) AS StatusDate,
								[dbo].[DateInvalid](ApplicationStatus.ApprovedLoan) AS ApprovedLoan,
								ApplicationStatus.AFCancelReason,
								[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.PlanDrawdownDate, 120)) AS PlanDrawdownDate,
								[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.PlanDateUnknown, 120)) AS PlanDateUnknown,
								[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.DrawdownDate, 120)) AS DrawdownDate,
								[dbo].[DateInvalid](ApplicationStatus.DrawdownBaht) AS DrawdownBaht, ActionNoteLogs.ActionNote,
								CASE
									WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'APPROVED' 
									AND NOT ApplicationStatus.DrawdownDate = '' 
									AND NOT ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'APPROVED' 
									AND ApplicationStatus.DrawdownDate = '' 
									AND ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'Active'
									WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'Active'
									WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'Active'
									ELSE 'Active'
								END AS ActiveRecord,
								ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
								ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
								RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
								RetrieveRecord.EventTime AS RetrieveTime, Installment, 
								dbo.GetApplication(ApplicationStatus.ApplicationNo) AS DDHistory,
								ApplicationStatus.ReceivedEstimateDoc, A2CAPostponeAmt,
								[Profile].IsActive
								FROM [Profile]
								LEFT OUTER JOIN Verification
								ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
								LEFT OUTER JOIN NCB
								ON Verification.VerifyID = NCB.VerifyID
								LEFT OUTER JOIN ApplicationStatus
								ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
								LEFT OUTER JOIN Product
								ON Verification.ProductCode = Product.ProductCode
								LEFT OUTER JOIN ProductType
								ON Product.ProductTypeID = ProductType.ProductTypeID
								LEFT OUTER JOIN LendingEmp
								ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
								LEFT OUTER JOIN LendingBranchs
								ON [Profile].BranchCode = LendingBranchs.BranchCode
								LEFT OUTER JOIN MasterArea
								ON LendingBranchs.AreaID = MasterArea.AreaNo
								LEFT OUTER JOIN MasterRegion
								ON LendingBranchs.RegionID = MasterRegion.RegionID
								LEFT OUTER JOIN (SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
								ON Defender.RF_DocID = [Profile].DocID	
								LEFT OUTER JOIN ( 
									SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
										DocID, ActionNote, ActionNoteDate, ActionDateTime
										FROM (
											SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
											FROM ActionNote
											UNION
											SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
											FROM ActionNoteLog
											UNION   
											SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
											FROM SystemNoteLog
										) DATA	
										WHERE IsActive = 'A'
									) AS ActionLog
									WHERE Numindex = 1
								) ActionNoteLogs
								ON [Profile].DocID = ActionNoteLogs.DocID
								LEFT OUTER JOIN (
									SELECT DocID, 'Y' AS IsAIP FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
										DocID, ActionNote, ActionNoteDate, ActionDateTime
										FROM (
											SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
											FROM ActionNote
											UNION   
											SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
											FROM SystemNoteLog
										) DATA	
										WHERE IsActive = 'A'
										AND ActionNote LIKE '%AIP%'
									) AS ActionLog
									WHERE Numindex = 1
								) AIPInquiry
								ON [Profile].DocID = AIPInquiry.DocID
								LEFT OUTER JOIN (
									SELECT * FROM (
									SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
									VerifyID AS VF, BorrowerType, BorrowerName, 
									[dbo].[DateInvalid](CONVERT(nvarchar(10), NCBCheckDate, 120)) AS NCBCheckDate
									FROM dbo.NCBConsentLogs) Tmp
									WHERE Numindex = 1
								) NCBConsentLogs
								ON NCBConsentLogs.VF = Verification.VerifyID 
								AND NCBConsentLogs.BorrowerType = '101'
								LEFT OUTER JOIN (
									SELECT * FROM (
									SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
									DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
									[dbo].[DateInvalid]( CONVERT(nvarchar(10), CAReturnDate, 120)) AS CAReturnDateLog
									FROM ReconcileDocLogs) Tmp
									WHERE Numindex = 1				
								) ReconcileDocLogs
								ON [Profile].DocID = ReconcileDocLogs.DocLogs 
								AND ReconcileDocLogs.BorrowerType = '101'
								LEFT OUTER JOIN (		
									SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY RetrieveToNewDoc ORDER BY CONVERT(NVARCHAR(10), EventDate, 120) DESC, RIGHT(CONVERT(NVARCHAR(24) , EventTime, 120), 8) DESC) as Numindex, 
										RetrieveToNewDoc, EmployeeCode, CONVERT(NVARCHAR(10) , EventDate, 120) AS EventDate, RIGHT(CONVERT(NVARCHAR(24), EventTime, 120), 8) AS EventTime, 
										'RET' AS RetrievedDigit, 'Y' AS Retrieved
										FROM Retrieve_TransactionLog
									) Tmp
									WHERE Numindex = 1
								) RetrieveRecord
								ON [Profile].DocID = RetrieveRecord.RetrieveToNewDoc
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT DocID, CONVERT(NVARCHAR(10), ReActivateDate, 120) AS ReActivateDate, 
										'REA' AS ReactivateDigit, 'Y' AS ReActivated,
										ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ReActivateDate DESC) as Numindex
										FROM Reactivate_TransactionLog
									) Tmp
									WHERE Numindex = 1
								) ReActivateRecord
								ON [Profile].DocID = ReActivateRecord.DocID
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT isnull([ApplicationNoReplace].[ApplicationNoReplace],[Drawdown_History].[ApplicationNo]) [ApplicationNo] ,
										'Y' AS Installment, ROW_NUMBER() OVER(PARTITION BY [Drawdown_History].[ApplicationNo] ORDER BY DrawdownDate ASC) as Numindex
										FROM [PCIS].[dbo].[Drawdown_History]
										LEFT OUTER JOIN [PCIS].[dbo].[ApplicationNoReplace] ON [Drawdown_History].[ApplicationNo] = [ApplicationNoReplace].[ApplicationNo]
									) Tmp
									WHERE Numindex = 2
								) DDHistory
								ON ApplicationStatus.ApplicationNo = DDHistory.ApplicationNo 
								$join_strsql
								WHERE [Profile].IsEnabled = 'A'
								AND NOT [Profile].CreateDate IS NULL
								AND NOT NCB.CheckNCBDate IS NULL								
								AND BasicCriteria = '1'
								AND NCB.CheckNCB in ('1', '3')	
								
								$where_addition
								$wheres_name
							) Inquiry
							$wheres	
							$wheres_kpi
							$spcial_inquiry							
						) TMPAAA
						WHERE KeyPoint > $start AND KeyPoint <= $offset");

						return $result;
			
					break;
					case $this->role_rd:
		
						if($kpi_search == 'true'):
							$spcial_inquiry = " AND RegionID = '".$region_id."'";
						else:
							$spcial_inquiry = " AND RegionID = '".$emp_region."'";
						endif;
						
						$result = $this->dbmodel->CIQuery("
						SELECT * FROM (
							SELECT *, ROW_NUMBER() OVER (ORDER BY $adjust_ordering) AS KeyPoint
							FROM(SELECT
								[Profile].DocID,  Verification.VerifyID, [Profile].SourceOfCustomer,
								ISNULL( 
									ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
									ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
								) AS StartDate,
								CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) AS CheckNCBDate,
								CONVERT(nvarchar(10), NCBCheckDate, 120) AS NCBCheckDate,
								[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
								[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit, BranchTel, MasterArea.AreaName AS AreaCode,
								[Profile].Branch, LendingBranchs.BranchName, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
								Product.ProductCode, Product.ProductName, Product.ProductTypes, ProductType.ProductType AS ProductCat, [Profile].RequestLoan,										
								CASE Verification.RMProcess
									WHEN 'Completed' THEN 'CP'
									WHEN 'CANCELBYRM' THEN 'CR'
									WHEN 'CANCELBYCA' THEN 'CA'
									WHEN 'CANCELBYCUS' THEN 'CC'
									ELSE 'AA'
								END AS RMProcess,
								$plana2ca_sql
								[dbo].[DateInvalid](CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)) AS HQReceiveCADocDate,
								[dbo].[DateInvalid](CONVERT(nvarchar(10), Verification.SentToCADate, 120)) AS SentToCADate, 
								CAReturnDateLog, IsDefend, ApplicationStatus.CAName,
								CONVERT(nvarchar(10), CA_ReceivedDocDate, 120) AS CA_ReceivedDocDate, 										
								CASE
									WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CR'
									WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CR'  
									WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
									WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
									WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'P'
									WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PA'
									WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'A'
									WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'R'
									WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'C'
									WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'C'
									WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'C'
									WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'C'
									WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
								ELSE NULL
								END AS [Status], 
								CASE
									WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CREDIT RETURN'
									WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CREDIT RETURN'  
									WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
									WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
									WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'PENDING'
									WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PREAPPROVED'
									WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'APPROVED'
									WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'REJECT'
									WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'CANCEL'
									WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'CANCELBYRM'
									WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'CANCELBYCUS'
									WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'CANCELBYCA'
									WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
								ELSE NULL
								END AS StatusDesc, 
								ApplicationStatus.StatusReason,
								[dbo].[DateInvalid](ApplicationStatus.PreLoan) AS PreLoan,
								[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120)) AS StatusDate,
								[dbo].[DateInvalid](ApplicationStatus.ApprovedLoan) AS ApprovedLoan,
								ApplicationStatus.AFCancelReason,
								[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.PlanDrawdownDate, 120)) AS PlanDrawdownDate,
								[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.PlanDateUnknown, 120)) AS PlanDateUnknown,
								[dbo].[DateInvalid](CONVERT(nvarchar(10), ApplicationStatus.DrawdownDate, 120)) AS DrawdownDate,
								[dbo].[DateInvalid](ApplicationStatus.DrawdownBaht) AS DrawdownBaht, ActionNoteLogs.ActionNote,
								CASE
									WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'APPROVED' 
									AND NOT ApplicationStatus.DrawdownDate = '' 
									AND NOT ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'APPROVED' 
									AND ApplicationStatus.DrawdownDate = '' 
									AND ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'Active'
									WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'InActive'
									WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'Active'
									WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'Active'
									ELSE 'Active'
								END AS ActiveRecord,
								ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
								ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
								RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
								RetrieveRecord.EventTime AS RetrieveTime, Installment, 
								dbo.GetApplication(ApplicationStatus.ApplicationNo) AS DDHistory,
								ApplicationStatus.ReceivedEstimateDoc, A2CAPostponeAmt,
								[Profile].IsActive
								FROM [Profile]
								LEFT OUTER JOIN Verification
								ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
								LEFT OUTER JOIN NCB
								ON Verification.VerifyID = NCB.VerifyID
								LEFT OUTER JOIN ApplicationStatus
								ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
								LEFT OUTER JOIN Product
								ON Verification.ProductCode = Product.ProductCode
								LEFT OUTER JOIN ProductType
								ON Product.ProductTypeID = ProductType.ProductTypeID
								LEFT OUTER JOIN LendingEmp
								ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
								LEFT OUTER JOIN LendingBranchs
								ON [Profile].BranchCode = LendingBranchs.BranchCode
								LEFT OUTER JOIN MasterArea
								ON LendingBranchs.AreaID = MasterArea.AreaNo
								LEFT OUTER JOIN MasterRegion
								ON LendingBranchs.RegionID = MasterRegion.RegionID
								LEFT OUTER JOIN (SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
								ON Defender.RF_DocID = [Profile].DocID	
								LEFT OUTER JOIN ( 
									SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
										DocID, ActionNote, ActionNoteDate, ActionDateTime
										FROM (
											SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
											FROM ActionNote
											UNION
											SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
											FROM ActionNoteLog
											UNION   
											SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
											FROM SystemNoteLog
										) DATA	
										WHERE IsActive = 'A'
									) AS ActionLog
									WHERE Numindex = 1
								) ActionNoteLogs
								ON [Profile].DocID = ActionNoteLogs.DocID
								LEFT OUTER JOIN (
									SELECT DocID, 'Y' AS IsAIP FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
										DocID, ActionNote, ActionNoteDate, ActionDateTime
										FROM (
											SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
											FROM ActionNote
											UNION   
											SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
											CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
											FROM SystemNoteLog
										) DATA	
										WHERE IsActive = 'A'
										AND ActionNote LIKE '%AIP%'
									) AS ActionLog
									WHERE Numindex = 1
								) AIPInquiry
								ON [Profile].DocID = AIPInquiry.DocID
								LEFT OUTER JOIN (
									SELECT * FROM (
									SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
									VerifyID AS VF, BorrowerType, BorrowerName, 
									[dbo].[DateInvalid](CONVERT(nvarchar(10), NCBCheckDate, 120)) AS NCBCheckDate
									FROM dbo.NCBConsentLogs) Tmp
									WHERE Numindex = 1
								) NCBConsentLogs
								ON NCBConsentLogs.VF = Verification.VerifyID 
								AND NCBConsentLogs.BorrowerType = '101'
								LEFT OUTER JOIN (
									SELECT * FROM (
									SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
									DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
									[dbo].[DateInvalid]( CONVERT(nvarchar(10), CAReturnDate, 120)) AS CAReturnDateLog
									FROM ReconcileDocLogs) Tmp
									WHERE Numindex = 1				
								) ReconcileDocLogs
								ON [Profile].DocID = ReconcileDocLogs.DocLogs 
								AND ReconcileDocLogs.BorrowerType = '101'
								LEFT OUTER JOIN (		
									SELECT * FROM (
										SELECT ROW_NUMBER() OVER(PARTITION BY RetrieveToNewDoc ORDER BY CONVERT(NVARCHAR(10), EventDate, 120) DESC, RIGHT(CONVERT(NVARCHAR(24) , EventTime, 120), 8) DESC) as Numindex, 
										RetrieveToNewDoc, EmployeeCode, CONVERT(NVARCHAR(10) , EventDate, 120) AS EventDate, RIGHT(CONVERT(NVARCHAR(24), EventTime, 120), 8) AS EventTime, 
										'RET' AS RetrievedDigit, 'Y' AS Retrieved
										FROM Retrieve_TransactionLog
									) Tmp
									WHERE Numindex = 1
								) RetrieveRecord
								ON [Profile].DocID = RetrieveRecord.RetrieveToNewDoc
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT DocID, CONVERT(NVARCHAR(10), ReActivateDate, 120) AS ReActivateDate, 
										'REA' AS ReactivateDigit, 'Y' AS ReActivated,
										ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ReActivateDate DESC) as Numindex
										FROM Reactivate_TransactionLog
									) Tmp
									WHERE Numindex = 1
								) ReActivateRecord
								ON [Profile].DocID = ReActivateRecord.DocID
								LEFT OUTER JOIN (
									SELECT * FROM (
										SELECT isnull([ApplicationNoReplace].[ApplicationNoReplace],[Drawdown_History].[ApplicationNo]) [ApplicationNo] ,
										'Y' AS Installment, ROW_NUMBER() OVER(PARTITION BY [Drawdown_History].[ApplicationNo] ORDER BY DrawdownDate ASC) as Numindex
										FROM [PCIS].[dbo].[Drawdown_History]
										LEFT OUTER JOIN [PCIS].[dbo].[ApplicationNoReplace] ON [Drawdown_History].[ApplicationNo] = [ApplicationNoReplace].[ApplicationNo]
									) Tmp
									WHERE Numindex = 2
								) DDHistory
								ON ApplicationStatus.ApplicationNo = DDHistory.ApplicationNo 
								$join_strsql
								WHERE [Profile].IsEnabled = 'A'
								AND NOT [Profile].CreateDate IS NULL
								AND NOT NCB.CheckNCBDate IS NULL								
								AND BasicCriteria = '1'
								AND NCB.CheckNCB in ('1', '3')	
								
								$where_addition
								$wheres_name
							) Inquiry
							$wheres	
							$wheres_kpi
							$spcial_inquiry							
						) TMPAAA
						WHERE KeyPoint > $start AND KeyPoint <= $offset");	
					
						return $result;
					
					break;
				}
				
			}	
			
		}
		
	}
	
	
	public function dataTableDashboardGrandTotal($authority, $condition = array(), $search = array(), $kpi_search, $mode_kpi, $modestate, $kpi_no, $emp_kpi, $kpi_condition, $kpi_privileges) {
		$this->load->model('dbmodel');		
		$this->load->model('dbstore');
		
		if(empty($authority)) {
			
			log_message('error', 'method '.__METHOD__ .'can not load data progress. please check object criteria.');
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
		
		} else {
			
			$get_info 		= $this->getEmployeeDataInfo($emp_kpi);
			$brn_code 		= $get_info['data'][0]['BranchCode'];
			$area_code  	= $get_info['data'][0]['AreaCode'];
			$region_id  	= $get_info['data'][0]['RegionID'];
						
			if($kpi_search == 'true') {
				$privileges = $kpi_privileges;				
			} else {				
				if(count($authority) > 1) $privileges = $authority[0];
				else $privileges = $authority[0];			
			}
		
			// load data employees.
			$employees  = $this->employeesInfo($condition[0]);
			$empbranch  = str_pad($employees['data'][0]['BranchCode'], 3, "0", STR_PAD_LEFT);
			$emp_area   = $employees['data'][0]['AreaCode'];
			$emp_region = $employees['data'][0]['RegionID'];
						
			if($kpi_search == 'true' && in_array($kpi_no, $this->object_kpi)) {
				switch ($kpi_no):
					case '6':
						$result	= $this->dbstore->exec_getWhiteboardKPILoanSummary($kpi_condition, $modestate);			
						return $result;
					break;
			
				endswitch;
						
			} else {
			
				$plana2ca_sql = "
				CASE 
					WHEN ProductLoanTypeID = 1 THEN 'Refinance'
					WHEN ProductLoanTypeID = 2 THEN 'Non Refinance'
					ELSE NULL
				END AS ProductLoanType, IsAIP, Verification.Cashy, Bank,
				ISNULL(OwnershipDoc, 'N') AS OwnershipDoc,
				Verification.AppToCAPlanDate AS PlanA2CADraft,
				CASE 		
					WHEN Verification.AppToCAPlanDate <= ApplicationStatus.CA_ReceivedDocDate THEN NULL
					WHEN Verification.AppToCAPlanDate <= ApplicationStatus.[StatusDate]	THEN NULL
					WHEN Verification.AppToCAPlanDate > Verification.HQReceiveCADocDate OR
						 Verification.AppToCAPlanDate > Verification.SentToCADate OR
						 Verification.AppToCAPlanDate > ApplicationStatus.CA_ReceivedDocDate
					THEN Verification.AppToCAPlanDate
					WHEN Verification.HQReceiveCADocDate IS NULL THEN Verification.AppToCAPlanDate
					ELSE NULL
				END AS AppToCAPlanDate,";
				
				$join_strsql  = "
				LEFT OUTER JOIN (
					SELECT * FROM (
						SELECT RC.DocID, 'Y' AS OwnershipDoc, SubmitDocToCADate AS CompletionDoc, [Status], StatusDate, DrawdownDate,
						ROW_NUMBER() OVER(PARTITION BY RC.DocID ORDER BY RC.DocID ASC) as Numindex
						FROM ReconcileCompletion AS RC
						LEFT OUTER JOIN ApplicationStatus AS APS
						ON RC.DocID = APS.DocID
						WHERE DocList IN ('55','187')
						AND RC.IsActive = 'A'
						AND SubmitDocToCADate IS NULL
						AND DrawdownDate IS NULL
					) A
					WHERE Numindex = 1
				) ObjOwnershipDoc
				ON [Profile].DocID = ObjOwnershipDoc.DocID";
				
				switch($privileges) {
					case $this->role_ad:
					case $this->role_bm:
					case $this->role_hq:
					case $this->role_spv:
					case $this->role_ads:
						
						if($kpi_search == 'true') {						
							
							if($mode_kpi == $this->branch_mode)  {
								if($brn_code == '000'):
									$optional = $search[3];
								else:
									$optional = " AND BranchCode in ('".$brn_code."')" . $search[3];		
								endif;
							}
							else if($mode_kpi == $this->individual_mode) {
								$optional = " AND RMCode = '".$emp_kpi."'" . $search[3];								
							}
						
						} else {	
							
							if($empbranch == "000" || $empbranch == "901"):
								$optional = '';
							else:
							
								// Admin are not head office
								// Check has authority area manager
								$select_privilege = '';
								if(in_array($this->role_am, $authority)):
									$optional = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' AND IsActive = 'A' GROUP BY BranchCode)";
								else:
									$optional = " AND BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'";
								endif;
								
							endif;
							
						}
						
						break;
					case $this->role_rm:
						
						if($kpi_search == 'true'):
							$optional = " AND RMCode = '".$emp_kpi."'" . $search[3];
						else:
							$optional = " AND RMCode = '".$employees['data'][0]['EmployeeCode']."'";
						endif;
						
				
						break;
					case $this->role_am:
						
						if($kpi_search == 'true'):
							$optional = " AND AreaCode = '".$area_code."'" . $search[3];
						else:
							$optional = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' GROUP BY BranchCode)";
						endif;
						
						break;
					case $this->role_rd:
					
						if($kpi_search == 'true'):
							$optional = " AND RegionID = '".$region_id."'" . $search[3];
						else:
							$optional = " AND RegionID = '".$emp_region."'";
						endif;
										
						break;
	
				}
			
			}
	
			try {
				
				$result = $this->dbmodel->CIQuery("
				SELECT COUNT(MGroup) AS RowRecord, 
				ISNULL(SUM(CAST(RequestLoan AS decimal(18,0))), 0) AS RequestLoan, 
				ISNULL(SUM(CAST(ApprovedLoan as decimal(18,0))), 0) AS ApprovedLoan, 
				ISNULL(SUM(CAST(DrawdownBaht as decimal(18,0))), 0) AS DrawdownBaht
				FROM (
					SELECT 'A' AS MGroup, RequestLoan,  
					CASE [Status]
					WHEN 'A' THEN ISNULL(ApprovedLoan, 0)
					WHEN 'P' THEN ISNULL(PreLoan, 0)
					ELSE NULL
					END AS ApprovedLoan, 
					ISNULL(DrawdownBaht, 0) DrawdownBaht, IsActive
					FROM(SELECT * 
						 FROM (SELECT
								[Profile].DocID, [Profile].SourceOfCustomer,
								ISNULL( 
									ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
									ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
								) AS StartDate, NCBCheckDate, NCB.CheckNCBDate,
								[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
								[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit, MasterArea.AreaName AS AreaCode,
								[Profile].Branch, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng,
								Product.ProductCode, Product.ProductName, Product.ProductTypes, ProductType.ProductType AS ProductCat, [Profile].RequestLoan,
								$plana2ca_sql
								Verification.RMProcess, Verification.HQReceiveCADocDate AS HQReceiveCADocDate, 
								Verification.SentToCADate AS SentToCADate, CAReturnDateLog,
								IsDefend, ApplicationStatus.CAName, CA_ReceivedDocDate, ApplicationStatus.AFCancelReason,
							CASE
								WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CR'
								WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CR'   
								WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
								WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
								WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'P'
								WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PA'
								WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'A'
								WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'R'
								WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'C'
								WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'C'
								WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'C'
								WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'C'
								WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
								ELSE NULL
							END AS [Status], 
							CASE
								WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CREDIT RETURN'
								WHEN ApplicationStatus.[Status] = 'PENDING' AND Verification.SentToCADate IS NULL AND NOT CAReturnDateLog IS NULL THEN 'CREDIT RETURN'  
								WHEN ApplicationStatus.[Status] = 'APPROVED' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
								WHEN ApplicationStatus.[Status] = 'PENDING' AND NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
								WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'PENDING'
								WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PREAPPROVED'
								WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'APPROVED'
								WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'REJECT'
								WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'CANCEL'
								WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'CANCELBYRM'
								WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'CANCELBYCUS'
								WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'CANCELBYCA'
								WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'CANCEL'
								ELSE NULL
							END AS StatusDesc, 
							ApplicationStatus.StatusReason,
							CASE ApplicationStatus.PreLoan
								WHEN '0' THEN NULL
								ELSE ApplicationStatus.PreLoan
								END AS PreLoan,
								ApplicationStatus.StatusDate AS StatusDate, ApplicationStatus.ApprovedLoan  AS ApprovedLoan,
								ApplicationStatus.PlanDrawdownDate AS PlanDrawdownDate, ApplicationStatus.PlanDateUnknown,
								ApplicationStatus.DrawdownDate AS DrawdownDate,
								ApplicationStatus.DrawdownBaht AS DrawdownBaht, Verification.ActionNote,
							CASE
								WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
								WHEN ApplicationStatus.[Status] = 'APPROVED'
								     AND NOT ApplicationStatus.DrawdownDate = ''
									 AND NOT ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'InActive'
								WHEN ApplicationStatus.[Status] = 'APPROVED'
									 AND ApplicationStatus.DrawdownDate = ''
									 AND ApplicationStatus.DrawdownDate = '1900-01-01' THEN 'Active'
								WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'InActive'
								WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'InActive'
								WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'InActive'
								WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'InActive'
								WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'InActive'
								WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'Active'
								WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'Active'
								ELSE 'Active'
							END AS ActiveRecord,
							ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
							ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
							RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
							RetrieveRecord.EventTime AS RetrieveTime, Installment, 
							dbo.GetApplication(ApplicationStatus.ApplicationNo) AS DDHistory,
							ApplicationStatus.ReceivedEstimateDoc, [Profile].IsActive
							FROM [Profile]
							LEFT OUTER JOIN Verification
							ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
							LEFT OUTER JOIN NCB
							ON Verification.VerifyID = NCB.VerifyID
							LEFT OUTER JOIN ApplicationStatus
							ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
							LEFT OUTER JOIN Product
							ON Verification.ProductCode = Product.ProductCode
							LEFT OUTER JOIN ProductType
							ON Product.ProductTypeID = ProductType.ProductTypeID
							LEFT OUTER JOIN LendingEmp
							ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
							LEFT OUTER JOIN LendingBranchs
							ON [Profile].BranchCode = LendingBranchs.BranchCode
							LEFT OUTER JOIN MasterArea
							ON LendingBranchs.AreaID = MasterArea.AreaNo
							LEFT OUTER JOIN MasterRegion
							ON LendingBranchs.RegionID = MasterRegion.RegionID
							LEFT OUTER JOIN ( SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
							ON Defender.RF_DocID = [Profile].DocID
							LEFT OUTER JOIN (
								 SELECT * FROM (
									 SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
									 VerifyID AS VF, BorrowerType, BorrowerName, 
									 [dbo].[DateInvalid](CONVERT(nvarchar(10), NCBCheckDate, 120)) AS NCBCheckDate
								 FROM dbo.NCBConsentLogs) Tmp
								 WHERE Numindex = 1
							) NCBConsentLogs
							ON NCBConsentLogs.VF = Verification.VerifyID 
							AND NCBConsentLogs.BorrowerType = '101'
							LEFT OUTER JOIN (
								SELECT * FROM (
								SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
								DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
								[dbo].[DateInvalid](CONVERT(nvarchar(10), CAReturnDate, 120)) AS CAReturnDateLog
								FROM ReconcileDocLogs) Tmp
								WHERE Numindex = 1				
							) ReconcileDocLogs
							ON [Profile].DocID = ReconcileDocLogs.DocLogs 
							AND ReconcileDocLogs.BorrowerType = '101'
							LEFT OUTER JOIN (
								SELECT DocID, 'Y' AS IsAIP FROM (
									SELECT ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ActionDateTime DESC) as Numindex,
									DocID, ActionNote, ActionNoteDate, ActionDateTime
									FROM (
										SELECT DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
										CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime 
										FROM ActionNote
										UNION   
										SELECT  DocID, ActionNote, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate, IsActive, 
										CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime
										FROM SystemNoteLog
									) DATA	
									WHERE IsActive = 'A'
									AND ActionNote LIKE '%AIP%'
								) AS ActionLog
								WHERE Numindex = 1
							) AIPInquiry
							ON [Profile].DocID = AIPInquiry.DocID
							LEFT OUTER JOIN (		
								SELECT * FROM (
									SELECT ROW_NUMBER() OVER(PARTITION BY RetrieveToNewDoc ORDER BY CONVERT(NVARCHAR(10), EventDate, 120) DESC, RIGHT(CONVERT(NVARCHAR(24) , EventTime, 120), 8) DESC) as Numindex, 
									RetrieveToNewDoc, EmployeeCode, CONVERT(NVARCHAR(10) , EventDate, 120) AS EventDate, RIGHT(CONVERT(NVARCHAR(24), EventTime, 120), 8) AS EventTime, 
									'RET' AS RetrievedDigit, 'Y' AS Retrieved
									FROM Retrieve_TransactionLog
								) Tmp
								WHERE Numindex = 1
							) RetrieveRecord
							ON [Profile].DocID = RetrieveRecord.RetrieveToNewDoc
							LEFT OUTER JOIN (
								SELECT * FROM (
									SELECT DocID, CONVERT(NVARCHAR(10), ReActivateDate, 120) AS ReActivateDate, 
									'REA' AS ReactivateDigit, 'Y' AS ReActivated,
									ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY ReActivateDate DESC) as Numindex
									FROM Reactivate_TransactionLog
								) Tmp
								WHERE Numindex = 1
							) ReActivateRecord
							ON [Profile].DocID = ReActivateRecord.DocID
							LEFT OUTER JOIN (
								SELECT * FROM (
									SELECT isnull([ApplicationNoReplace].[ApplicationNoReplace],[Drawdown_History].[ApplicationNo]) [ApplicationNo] ,
									'Y' AS Installment, ROW_NUMBER() OVER(PARTITION BY [Drawdown_History].[ApplicationNo] ORDER BY DrawdownDate ASC) as Numindex
									FROM [PCIS].[dbo].[Drawdown_History]
									LEFT OUTER JOIN [PCIS].[dbo].[ApplicationNoReplace] ON [Drawdown_History].[ApplicationNo] = [ApplicationNoReplace].[ApplicationNo]
								) Tmp
								WHERE Numindex = 2
							) DDHistory
							ON ApplicationStatus.ApplicationNo = DDHistory.ApplicationNo 
						    $join_strsql
							WHERE [Profile].IsEnabled = 'A'
							AND NOT [Profile].CreateDate IS NULL
							AND NOT NCB.CheckNCBDate IS NULL						
							AND BasicCriteria = '1'
							AND NCB.CheckNCB in ('1', '3')	
							AND NCB.CheckNCBDate > '2014-12-31'
							$search[0]
							$search[1]
						) Inquiry
						$search[2]					
						$optional
					) Data			
				) Summary
				GROUP BY MGroup");	
				
				return $result;

			} catch(Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			
			}
				
		} 
	
	}
	
	// Maintanance on date 01/03/2017
	public function loadDataDashboardNewFunction($authority, $condition = array()) {
		$this->load->model('dbmodel');
		$this->load->model('dbstore');
		$this->load->library('effective');
		
		// Load data employees
		$employees   = $this->employeesInfo($condition[0]);
		$emp_code	 = $condition[0];
		$emp_branch  = !empty($employees['data'][0]['BranchCode']) ? str_pad($employees['data'][0]['BranchCode'], 3, "0", STR_PAD_LEFT):'000';
		$emp_area    = $employees['data'][0]['AreaCode'];
		$emp_region  = $employees['data'][0]['RegionID'];
	
		// Default Authority
		$defualt_authority = '';
		switch($authority) {
			case $this->role_ad:
				if(in_array($emp_branch, array("000", "901"))):
					$defualt_authority = '';
				else:
					$defualt_authority = ' AND BranchCode = "'.$emp_branch.'"';
				endif;
			break;
			case $this->role_rm:
				$defualt_authority	= ' AND RMCode = "'.$emp_code.'"';
			break;
			case $this->role_bm:
				$defualt_authority = ' AND BranchCode = "'.$emp_branch.'"';
			break;
			case $this->role_am:
				$defualt_authority = ' AND BranchCode IN (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = "'.$emp_code.'" GROUP BY BranchCode)';
			break;
			case $this->role_rd:
				$defualt_authority = ' AND BranchCode IN (SELECT BranchCode FROM LendingBranchs WHERE RegionID = "'.$emp_region.'" GROUP BY BranchCode)';
			break;
			default:
			case $this->role_ads:
			case $this->role_hq:
			case $this->role_spv:
				$defualt_authority = '';
			break;
		}

		print_r($defualt_authority);
		
		
	}
	
	public function getEmployeeDataInfo($emp_code) {
		$this->load->model('dbmodel');
		
		if(!empty($emp_code)) {
			
			$check_emp = $this->dbmodel->data_validation($this->table_lendingemp, array("*"), array("EmployeeCode" => $emp_code), false);
			if($check_emp == "TRUE") {
				
				$result = $this->dbmodel->loadData('LendingEmp', 'PositionTitle, RegionID, BranchCode, AreaCode', array('EmployeeCode' => $emp_code));
				if(!empty($result['data'][0]['PositionTitle'])) {
					return $result;				
				}
				
			}
			
		}
		
		
	}
	
	public function setDataAuthority($data) {
	
		if(!empty($data)) {
			
			$result   = $this->getEmployeeDataInfo($data);
			$position = $this->effective->set_chartypes($this->char_mode, $result['data'][0]['PositionTitle']);
			switch ($position) {
				case 'Developer':
				case 'Senior Developer':
					return $this->role_ads;				
				break;
				case 'Relationship Manager':
					return $this->role_rm;
				break;
				case 'Branch Manager':
					return $this->role_bm;
				break;
				case 'Area Manager':
					return $this->role_am;
				break;
				case 'Regional Director':
				case 'Admin-SFE':
					return $this->role_rd;
				break;
				case 'Branch Admin':
				case 'Branch Admin Manager':
				case 'Admin - Support':
				case 'Admin Location Management':				
					return $this->role_ad;
				break;
				case 'Assistant Managing Director':
				case 'Vice President - People Management':
				case 'Vice President - Lending Support':
					return $this->role_spv;
				break;
				default:
					return $this->role_hq;
				break;	
				
			}
				
			
		} else {
			return $this->role_hq;			
		}
	
	}
	
	public function getAuthPermission($special_role) {
		
		switch($special_role) {
			case $this->role_am:
				return $this->role_am;
			break;
			case $this->role_rd:
				return$this->role_rd;
			break;
			case $this->role_rm:
				return $this->role_rm;
			break;
			case $this->role_bm:
				return $this->role_bm;
			break;
			default:
				return $this->role_hq;
			break;
		}
		
	}
	
	// Datatable Functional Component
	private function check_cType() {
		$column = $this->input->post('columns');
		if(is_numeric($column[0]['data']))
			return FALSE;
		else
			return TRUE;
	}
	
	private function get_ordering() {
	
		$Data = $this->input->post('columns');
	
		if ($this->input->post('order')) {
			foreach ($this->input->post('order') as $key)
				if($this->check_cType())
				$Orders = $Data[$key['column']]['data'].' '.$key['dir'];
			 
		} else {
			$Orders = $this->columns[$key['column']].' '.$key['dir'];
			 
		}
	
		return $Orders;
	}
	
	
}