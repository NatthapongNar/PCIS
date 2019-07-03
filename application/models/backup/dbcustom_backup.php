<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dbcustom extends CI_Model {
	
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
		
		$this->role_ad 						= $this->config->item('ROLE_ADMIN');
		$this->role_rm 						= $this->config->item('ROLE_RM');
		$this->role_bm 						= $this->config->item('ROLE_BM');
		$this->role_am 						= $this->config->item('ROLE_AM');
		$this->role_rd 						= $this->config->item('ROLE_RD');
		$this->role_hq 						= $this->config->item('ROLE_HQ');
		$this->role_spv 					= $this->config->item('ROLE_SPV');
		$this->role_ads 					= $this->config->item('ROLE_ADMINSYS');
		
		$this->db_types						= $this->config->item('database_types');
		
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
			SELECT LendingEmp.EmployeeCode, LendingEmp.FullNameTh, LendingEmp.PositionTitle, LendingEmp.BranchCode
			FROM LendingEmp				
			WHERE LendingEmp.PositionTitle LIKE '%Branch Manager%' 
			AND LendingEmp.BranchCode = '".$brncode."'
			ORDER BY LendingEmp.BranchCode ASC");
			
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
					LendingEmp.BranchCode, LendingBranchs.BranchName, LendingBranchs.BranchDigit,
					LendingEmp.RoleSpecial, LendingEmp.IsActive
				FROM LendingEmp
				LEFT OUTER JOIN LendingBranchs
				ON LendingEmp.BranchCode = LendingBranchs.BranchCode
				LEFT OUTER JOIN MasterRegion
				ON LendingEmp.RegionID = MasterRegion.RegionID
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
		$this->load->library('effective');
		
		$wheres			= "WHERE NOT StartDate IS NULL";
		$where_addition = "";
		$wheres_name 	= "";
		
		$ncb_start 		= $this->input->post('ncb_start');
		$ncb_end		= $this->input->post('ncb_end');
		$rmname			= $this->input->post('rmname');
		$ownerName		= $this->input->post('ownerName');
		$caname			= $this->input->post('caname');
		$regionid		= $this->input->post('regionid');
		$branchs		= $this->input->post('branchdigit');
		$product		= $this->input->post('product');
		$rqloan_start	= (int)$this->input->post('rqloan_start');
		$rqloan_end		= (int)$this->input->post('rqloan_end');
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
		$defend_list	= ''; //$this->input->post('defend_check');
		$retrieve_list  = '';
		$re_activate	= '';
		
		$ncbdate_start  = !empty($ncb_start) ? $this->effective->StandartDateSorter($ncb_start):"";
		$ncbdate_end	= !empty($ncb_end) ? $this->effective->StandartDateSorter($ncb_end):"";
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

		$product_pieces = explode(',', $product);
		if(!empty($product_pieces[0])):
			$wheres_product 	= "'".implode("','", $product_pieces)."'";
		else:
			$wheres_product     = "";
		endif;
		
		$obj_status = array();		
		$refer_pieces = explode(',', $refer_tlf);
		$status_pieces = explode(',', $status);
		
		if(in_array("CR", $refer_pieces)):
			array_push($obj_status, 'CR');
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
			$wheres_refer   = @iconv('UTF-8', 'TIS-620', "'".implode("','", $refer_pieces)."'");
		else:
			$wheres_refer   = "";
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
		
		if(!empty($obj_status[0])):
			$wheres_status 	= "'".implode("','", $obj_status)."'";
		else:
			$wheres_status  = "";
		endif;
				
		$statusreason_pieces = explode(',', $status_reason);
		if(!empty($statusreason_pieces[0])):
			$wheres_statusreaon   = @iconv('UTF-8', 'TIS-620', "'".implode("','", $statusreason_pieces)."'");
		else:
			$wheres_statusreaon   = "";
		endif;
		
		$rmlist_pieces = explode(',', $rmname);
		if(!empty($rmlist_pieces[0])):
			$wheres_rmlist   = @iconv('UTF-8', 'TIS-620', "'".implode("','", $rmlist_pieces)."'");
		else:
			$wheres_rmlist   = "";
		endif;
		
		// Draft check date
		$check_datefilter = array();
		
		// Date Range
		if(!empty($ncbdate_start) && !empty($ncbdate_end)) {
			$wheres .= ' AND CONVERT(nvarchar(10), StartDate, 120) BETWEEN "'.$ncbdate_start.'" AND "'.$ncbdate_end.'"';
			array_push($check_datefilter, 'TRUE');
				
		} else {
		
			if(!empty($ncbdate_start)):
				$wheres .= ' AND CONVERT(nvarchar(10), StartDate, 120)  = "'.$ncbdate_start.'"';
				array_push($check_datefilter, 'TRUE');
			else:
				array_push($check_datefilter, 'FALSE');
			endif;
				
			if(!empty($ncbdate_end)):
				$wheres .= ' AND CONVERT(nvarchar(10), StartDate, 120)  = "'.$ncbdate_end.'"';
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
		//if(!empty($retrieve_list)) { $wheres .= " AND LatestEvent = '".$retrieve_list."'"; }
		//if(!empty($re_activate)) { $wheres .= " AND LatestEvent = '".$re_activate."'"; }
		
		// Optional Query
		if(!empty($caname)) { $wheres .= " AND CAName LIKE '%".iconv('UTF-8', 'TIS-620', $caname)."%'"; }
		
		if(!empty($ownerName)) {
			$wheres_name .= " AND NCB.MainLoanName LIKE '%".iconv('UTF-8', 'TIS-620', $ownerName)."%'";
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
	
		if(!empty($regionid)) { $wheres .= " AND RegionID = '".trim(str_pad($regionid, 2, "0", STR_PAD_LEFT))."'"; }
		
		if(!empty($pieces[0])) { $wheres .= " AND BranchDigit in ($where_brachs) "; }
		if(!empty($product_pieces[0])) { $wheres .= " AND ProductCode in ($wheres_product) "; }
		if(!empty($obj_status[0])) { $wheres .= " AND [Status] in ($wheres_status) "; }
		if(!empty($statusreason_pieces[0])) { $wheres .= " AND  StatusReason in ($wheres_statusreaon) "; }
		if(!empty($rmlist_pieces[0])) { $wheres .= " AND RMCode in ($wheres_rmlist) "; }
		if(!empty($refer_pieces[0])) { $wheres .= " AND SourceOfCustomer in ($wheres_refer) "; }

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
		
			if(count($authority) > 1) {
				$privileges = $authority[0];
					
			} else {
				$privileges = $authority[0];
			}
		
			// load data employees.
			$employees = $this->employeesInfo($condition[0]);
			$empbranch = str_pad($employees['data'][0]['BranchCode'], 3, "0", STR_PAD_LEFT);
		
			switch($privileges) {
				case $this->role_ad:
				case $this->role_bm:
				case $this->role_hq:
				case $this->role_spv:
				case $this->role_ads:
		
					if($empbranch == "000" || $empbranch == "901") {
		
						$result = $this->db->query("
							SELECT	* FROM
							(SELECT
								[Profile].DocID, [Profile].SourceOfCustomer,
								ISNULL( 
									ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
									ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
								) AS StartDate,
								[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
								[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit,
								[Profile].Branch, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
								Product.ProductCode, Product.ProductName, Product.ProductTypes, [Profile].RequestLoan,
								Verification.HQReceiveCADocDate AS HQReceiveCADocDate, 
								Verification.RMProcess, Verification.SentToCADate AS SentToCADate, CAReturnDateLog,
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
								END AS [Status], ApplicationStatus.StatusReason,
								CASE ApplicationStatus.PreLoan
									WHEN '0' THEN NULL
									ELSE ApplicationStatus.PreLoan
								END AS PreLoan,
								ApplicationStatus.StatusDate AS StatusDate, ApplicationStatus.ApprovedLoan  AS ApprovedLoan,
								ApplicationStatus.PlanDrawdownDate AS PlanDrawdownDate, ApplicationStatus.PlanDateUnknown,
								ApplicationStatus.DrawdownDate AS DrawdownDate,
								ApplicationStatus.DrawdownBaht AS DrawdownBaht, Verification.ActionNote,
								CASE									
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
									WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'							
									ELSE 'Active'
								END AS ActiveRecord,
								ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
								ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
								RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
								RetrieveRecord.EventTime AS RetrieveTime,
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
							LEFT OUTER JOIN LendingBranchs
							ON [Profile].BranchCode = LendingBranchs.BranchCode
							LEFT OUTER JOIN MasterRegion
							ON LendingBranchs.RegionID = MasterRegion.RegionID
							LEFT OUTER JOIN ( SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
							ON Defender.RF_DocID = [Profile].DocID	
							LEFT OUTER JOIN (
								SELECT * FROM (
								SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
								VerifyID AS VF, BorrowerType, BorrowerName, 
								CASE NCBCheckDate
									WHEN '1900-01-01' THEN NULL
									ELSE CONVERT(nvarchar(10), NCBCheckDate, 120) 
								END AS NCBCheckDate
								FROM dbo.NCBConsentLogs) Tmp
								WHERE Numindex = 1
							) NCBConsentLogs
							ON NCBConsentLogs.VF = Verification.VerifyID 
							AND NCBConsentLogs.BorrowerType = '101'
							LEFT OUTER JOIN (
								SELECT * FROM (
								SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
								DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
								CASE CAReturnDate
									WHEN '1900-01-01' THEN NULL
									WHEN '' THEN NULL
									ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
								END AS CAReturnDateLog
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
						
						$result = $this->db->query("
							SELECT	* FROM
							(SELECT
								[Profile].DocID, [Profile].SourceOfCustomer,
								ISNULL( 
									ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
									ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
								) AS StartDate,
								[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
								[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit,
								[Profile].Branch, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
								Product.ProductCode, Product.ProductName, Product.ProductTypes, [Profile].RequestLoan,
								Verification.HQReceiveCADocDate AS HQReceiveCADocDate, 
								Verification.RMProcess, Verification.SentToCADate AS SentToCADate, CAReturnDateLog,
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
								END AS [Status], ApplicationStatus.StatusReason,
								CASE ApplicationStatus.PreLoan
									WHEN '0' THEN NULL
									ELSE ApplicationStatus.PreLoan
								END AS PreLoan,
								ApplicationStatus.StatusDate AS StatusDate, ApplicationStatus.ApprovedLoan  AS ApprovedLoan,
								ApplicationStatus.PlanDrawdownDate AS PlanDrawdownDate, ApplicationStatus.PlanDateUnknown,
								ApplicationStatus.DrawdownDate AS DrawdownDate,
								ApplicationStatus.DrawdownBaht AS DrawdownBaht, Verification.ActionNote,
								CASE
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
									WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'							
									ELSE 'Active'
								END AS ActiveRecord,
								ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
								ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
								RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
								RetrieveRecord.EventTime AS RetrieveTime,
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
							LEFT OUTER JOIN LendingBranchs
							ON [Profile].BranchCode = LendingBranchs.BranchCode
							LEFT OUTER JOIN MasterRegion
							ON LendingBranchs.RegionID = MasterRegion.RegionID
							LEFT OUTER JOIN ( SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
							ON Defender.RF_DocID = [Profile].DocID
							LEFT OUTER JOIN (
								SELECT * FROM (
								SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
								VerifyID AS VF, BorrowerType, BorrowerName, 
								CASE NCBCheckDate
									WHEN '1900-01-01' THEN NULL
									ELSE CONVERT(nvarchar(10), NCBCheckDate, 120) 
								END AS NCBCheckDate
								FROM dbo.NCBConsentLogs) Tmp
								WHERE Numindex = 1
							) NCBConsentLogs
							ON NCBConsentLogs.VF = Verification.VerifyID 
							AND NCBConsentLogs.BorrowerType = '101'
							LEFT OUTER JOIN (
								SELECT * FROM (
								SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
								DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
								CASE CAReturnDate
									WHEN '1900-01-01' THEN NULL
									WHEN '' THEN NULL
									ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
								END AS CAReturnDateLog
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
						AND BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'");
						
						return $result->num_rows();
						
					}
				break;
				case $this->role_rm:
					
					$result = $this->db->query("
							SELECT	* FROM
							(SELECT
								[Profile].DocID, [Profile].SourceOfCustomer,
								ISNULL( 
									ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
									ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
								) AS StartDate,
								[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
								[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit,
								[Profile].Branch, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
								Product.ProductCode, Product.ProductName, Product.ProductTypes, [Profile].RequestLoan,
								Verification.HQReceiveCADocDate AS HQReceiveCADocDate, 
								Verification.RMProcess, Verification.SentToCADate AS SentToCADate, CAReturnDateLog,
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
								END AS [Status], ApplicationStatus.StatusReason,
								CASE ApplicationStatus.PreLoan
									WHEN '0' THEN NULL
									ELSE ApplicationStatus.PreLoan
								END AS PreLoan,
								ApplicationStatus.StatusDate AS StatusDate, ApplicationStatus.ApprovedLoan  AS ApprovedLoan,
								ApplicationStatus.PlanDrawdownDate AS PlanDrawdownDate, ApplicationStatus.PlanDateUnknown,
								ApplicationStatus.DrawdownDate AS DrawdownDate,
								ApplicationStatus.DrawdownBaht AS DrawdownBaht, Verification.ActionNote,
								CASE
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
									WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'								
									ELSE 'Active'
								END AS ActiveRecord,
								ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
								ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
								RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
								RetrieveRecord.EventTime AS RetrieveTime,
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
							LEFT OUTER JOIN LendingBranchs
							ON [Profile].BranchCode = LendingBranchs.BranchCode
							LEFT OUTER JOIN MasterRegion
							ON LendingBranchs.RegionID = MasterRegion.RegionID
							LEFT OUTER JOIN ( SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
							ON Defender.RF_DocID = [Profile].DocID	
							LEFT OUTER JOIN (
								SELECT * FROM (
									SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
									VerifyID AS VF, BorrowerType, BorrowerName, 
									CASE NCBCheckDate
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), NCBCheckDate, 120) 
									END AS NCBCheckDate
								FROM dbo.NCBConsentLogs) Tmp
								WHERE Numindex = 1
							) NCBConsentLogs
							ON NCBConsentLogs.VF = Verification.VerifyID 
							AND NCBConsentLogs.BorrowerType = '101'
							LEFT OUTER JOIN (
								SELECT * FROM (
								SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
								DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
								CASE CAReturnDate
									WHEN '1900-01-01' THEN NULL
									WHEN '' THEN NULL
									ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
								END AS CAReturnDateLog
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
						AND RMCode = '".$employees['data'][0]['EmployeeCode']."'");
							
					
						return $result->num_rows();
					
				break;
				case $this->role_am:
					
					$result = $this->db->query("
					SELECT	* FROM
					(SELECT
						[Profile].DocID, [Profile].SourceOfCustomer,
						ISNULL( 
							ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
							ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
						) AS StartDate,
						[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
						[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit,
						[Profile].Branch, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
						Product.ProductCode, Product.ProductName, Product.ProductTypes, [Profile].RequestLoan,
						Verification.HQReceiveCADocDate AS HQReceiveCADocDate, 
						Verification.RMProcess, Verification.SentToCADate AS SentToCADate, CAReturnDateLog,
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
						END AS [Status], ApplicationStatus.StatusReason,
						CASE ApplicationStatus.PreLoan
							WHEN '0' THEN NULL
							ELSE ApplicationStatus.PreLoan
						END AS PreLoan,
						ApplicationStatus.StatusDate AS StatusDate, ApplicationStatus.ApprovedLoan  AS ApprovedLoan,
						ApplicationStatus.PlanDrawdownDate AS PlanDrawdownDate, ApplicationStatus.PlanDateUnknown,
						ApplicationStatus.DrawdownDate AS DrawdownDate,
						ApplicationStatus.DrawdownBaht AS DrawdownBaht, Verification.ActionNote,
						CASE
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
							WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'								
							ELSE 'Active'
						END AS ActiveRecord,
						ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
						ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
						RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
						RetrieveRecord.EventTime AS RetrieveTime,
						[Profile].IsActive
					FROM [Profile]
					LEFT OUTER JOIN Verification
					ON [Profile].DocID = Verification.DocID
					LEFT OUTER JOIN NCB
					ON Verification.VerifyID = NCB.VerifyID
					LEFT OUTER JOIN ApplicationStatus
					ON [Profile].DocID = ApplicationStatus.DocID
					LEFT OUTER JOIN Product
					ON Verification.ProductCode = Product.ProductCode
					LEFT OUTER JOIN LendingBranchs
					ON [Profile].BranchCode = LendingBranchs.BranchCode
					LEFT OUTER JOIN MasterRegion
					ON LendingBranchs.RegionID = MasterRegion.RegionID
					LEFT OUTER JOIN ( SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
					ON Defender.RF_DocID = [Profile].DocID	
					LEFT OUTER JOIN (
						SELECT * FROM (
							SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
							VerifyID AS VF, BorrowerType, BorrowerName, 
							CASE NCBCheckDate
								WHEN '1900-01-01' THEN NULL
								ELSE CONVERT(nvarchar(10), NCBCheckDate, 120) 
							END AS NCBCheckDate
						FROM dbo.NCBConsentLogs) Tmp
						WHERE Numindex = 1
					) NCBConsentLogs
					ON NCBConsentLogs.VF = Verification.VerifyID 
					AND NCBConsentLogs.BorrowerType = '101'
					LEFT OUTER JOIN (
						SELECT * FROM (
						SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
						DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
						CASE CAReturnDate
							WHEN '1900-01-01' THEN NULL
							WHEN '' THEN NULL
							ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
						END AS CAReturnDateLog
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
				AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' GROUP BY BranchCode)");
								
				return $result->num_rows();
						
			break;
			case $this->role_rd:
					
					$result = $this->db->query("
					SELECT	* FROM
					(SELECT
						[Profile].DocID, [Profile].SourceOfCustomer,
						ISNULL( 
							ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
							ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
						) AS StartDate, 
						[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
						[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit,
						[Profile].Branch, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
						Product.ProductCode, Product.ProductName, Product.ProductTypes, [Profile].RequestLoan,
						Verification.HQReceiveCADocDate AS HQReceiveCADocDate, 
						Verification.RMProcess, Verification.SentToCADate AS SentToCADate, CAReturnDateLog,
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
						END AS [Status], ApplicationStatus.StatusReason,
						CASE ApplicationStatus.PreLoan
							WHEN '0' THEN NULL
							ELSE ApplicationStatus.PreLoan
						END AS PreLoan,
						ApplicationStatus.StatusDate AS StatusDate, ApplicationStatus.ApprovedLoan  AS ApprovedLoan,
						ApplicationStatus.PlanDrawdownDate AS PlanDrawdownDate, ApplicationStatus.PlanDateUnknown,
						ApplicationStatus.DrawdownDate AS DrawdownDate,
						ApplicationStatus.DrawdownBaht AS DrawdownBaht, Verification.ActionNote,
						CASE
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
							WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'								
							ELSE 'Active'
						END AS ActiveRecord,
						ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
						ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
						RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
						RetrieveRecord.EventTime AS RetrieveTime,
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
					LEFT OUTER JOIN LendingBranchs
					ON [Profile].BranchCode = LendingBranchs.BranchCode
					LEFT OUTER JOIN MasterRegion
					ON LendingBranchs.RegionID = MasterRegion.RegionID
					LEFT OUTER JOIN ( SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
					ON Defender.RF_DocID = [Profile].DocID
					LEFT OUTER JOIN (
						SELECT * FROM (
							SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
							VerifyID AS VF, BorrowerType, BorrowerName, 
							CASE NCBCheckDate
								WHEN '1900-01-01' THEN NULL
								ELSE CONVERT(nvarchar(10), NCBCheckDate, 120) 
							END AS NCBCheckDate
						FROM dbo.NCBConsentLogs) Tmp
						WHERE Numindex = 1
					) NCBConsentLogs
					ON NCBConsentLogs.VF = Verification.VerifyID 
					AND NCBConsentLogs.BorrowerType = '101'
					LEFT OUTER JOIN (
						SELECT * FROM (
						SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
						DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
						CASE CAReturnDate
							WHEN '1900-01-01' THEN NULL
							WHEN '' THEN NULL
							ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
						END AS CAReturnDateLog
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
				AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)");
					
				return $result->num_rows();
					
			break;
		}
			
		}
		
	}
	
	
	public function dataTableDashboard($authority, $condition = array()) {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$wheres			= "WHERE IsActive = 'Y'";
		$where_addition = "";
		$wheres_name	= "";
				
		$ncb_start 		= $this->input->post('ncb_start');
		$ncb_end		= $this->input->post('ncb_end');
		$rmname			= $this->input->post('rmname');
		$ownerName		= $this->input->post('ownerName');
		$caname			= $this->input->post('caname');
		$regionid		= $this->input->post('regionid');
		$branchs		= $this->input->post('branchdigit');
		$product		= $this->input->post('product');
		$rqloan_start	= (int)$this->input->post('rqloan_start');
		$rqloan_end		= (int)$this->input->post('rqloan_end');
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
		$defend_list	= '';//$this->input->post('defend_check');
		$retrieve_list 	= '';
		$re_activate	= '';
				
		$ncbdate_start  = !empty($ncb_start) ? $this->effective->StandartDateSorter($ncb_start):"";
		$ncbdate_end	= !empty($ncb_end) ? $this->effective->StandartDateSorter($ncb_end):"";
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

		$product_pieces = explode(',', $product);
		if(!empty($product_pieces[0])):
			$wheres_product 	= "'".implode("','", $product_pieces)."'";
		else:
			$wheres_product     = "";
		endif;
		
		$obj_status = array();		
		$refer_pieces = explode(',', $refer_tlf);
		$status_pieces = explode(',', $status);
		
		if(in_array("CR", $refer_pieces)):
			array_push($obj_status, 'CR');
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
			$wheres_refer   = @iconv('UTF-8', 'TIS-620', "'".implode("','", $refer_pieces)."'");
		else:
			$wheres_refer   = "";
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
		
		if(!empty($obj_status[0])):
			$wheres_status 	= "'".implode("','", $obj_status)."'";
		else:
			$wheres_status  = "";
		endif;
	
		$statusreason_pieces = explode(',', $status_reason);
		if(!empty($statusreason_pieces[0])):
			$wheres_statusreaon   = @iconv('UTF-8', 'TIS-620', "'".implode("','", $statusreason_pieces)."'");
		else:
			$wheres_statusreaon   = "";
		endif;
		
		$rmlist_pieces = explode(',', $rmname);
		if(!empty($rmlist_pieces[0])):
			$wheres_rmlist   = @iconv('UTF-8', 'TIS-620', "'".implode("','", $rmlist_pieces)."'");
		else:
			$wheres_rmlist   = "";
		endif;

		// Draft check date
		$check_datefilter = array();
		
		// Date Range
		if(!empty($ncbdate_start) && !empty($ncbdate_end)) { 
			$wheres .= ' AND CONVERT(nvarchar(10), StartDate, 120) BETWEEN "'.$ncbdate_start.'" AND "'.$ncbdate_end.'"'; 
			array_push($check_datefilter, 'TRUE');
			
		} else {
		
			if(!empty($ncbdate_start)):
				$wheres .= ' AND CONVERT(nvarchar(10), StartDate, 120)  = "'.$ncbdate_start.'"'; 
				array_push($check_datefilter, 'TRUE'); 
			else: 
				array_push($check_datefilter, 'FALSE'); 
			endif;
			
			if(!empty($ncbdate_end)):
				$wheres .= ' AND CONVERT(nvarchar(10), StartDate, 120)  = "'.$ncbdate_end.'"';
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
		//if(!empty($retrieve_list)) { $wheres .= " AND LatestEvent = '".$retrieve_list."'"; }
		//if(!empty($re_activate)) { $wheres .= " AND LatestEvent = '".$re_activate."'"; }
		
		// Optional Query
		if(!empty($caname)) { $wheres .= " AND CAName LIKE '%".iconv('UTF-8', 'TIS-620', $caname)."%'"; }
		
		if(!empty($ownerName)) { 
			$wheres_name .= " AND MainLoanName LIKE '%".iconv('UTF-8', 'TIS-620', $ownerName)."%'";
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

		if(!empty($regionid)) { $wheres .= " AND RegionID = '".trim(str_pad($regionid, 2, "0", STR_PAD_LEFT))."'"; }

		if(!empty($pieces[0])) { $wheres .= " AND BranchDigit in ($where_brachs) "; }
		if(!empty($product_pieces[0])) { $wheres .= " AND ProductCode in ($wheres_product) "; }
		if(!empty($obj_status[0])) { $wheres .= " AND [Status] in ($wheres_status) "; }
		if(!empty($statusreason_pieces[0])) { $wheres .= " AND  StatusReason in ($wheres_statusreaon) "; }
		if(!empty($rmlist_pieces[0])) { $wheres .= " AND RMCode in ($wheres_rmlist) "; }
		if(!empty($refer_pieces[0])) { $wheres .= " AND SourceOfCustomer in ($wheres_refer) "; }
	
		// Query Process
		$iStart  = $this->input->post('start');
		$iLength = $this->input->post('length') ? $iLength = $this->input->post('length') : 25;
		
		$start	= ($iStart)? $iStart : 0;
		$offset = $iLength + $start;
		
		$adjust_ordering = $this->get_ordering();
		/*
		$Ordering = $this->get_ordering();
		$expend_ordering = explode(" ", $Ordering);
		if($expend_ordering[0] == 'NCBCheckDate'):
			$adjust_ordering = 'ISNULL(NCBCheckDate, StartDate) '.$expend_ordering[1];
		else:
			$adjust_ordering = $expend_ordering[0]. ' ' .$expend_ordering[1];
		endif;
		*/
		
		if(empty($authority)) {
		
			$objForms = array(
					"Privileges" => $authority,
					"Condition"	 => $condition,
					"Optional"	 => $optional
			);
		
			log_message('error', 'method '.__METHOD__ .'can not load data progress. please check object criteria.');
			
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
		
		} else {
			

			if(count($authority) > 1) {
				$privileges = $authority[0];
					
			} else {
				$privileges = $authority[0];
			}

			// load data employees.
			$employees = $this->employeesInfo($condition[0]);
			$empbranch = str_pad($employees['data'][0]['BranchCode'], 3, "0", STR_PAD_LEFT);
			
			switch($privileges) {
				case $this->role_ad:
				case $this->role_bm:
				case $this->role_hq:
				case $this->role_spv:
				case $this->role_ads:
			
					if($empbranch == "000" || $empbranch == "901") {
						
						//AND NCB.CheckNCB = '1' OR NCB.CheckNCB = '3'
						$result = $this->dbmodel->CIQuery("
					  		 SELECT * INTO #TMPTEST 
							 FROM(SELECT
									[Profile].DocID,  Verification.VerifyID, [Profile].SourceOfCustomer,
									ISNULL( 
										ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
										ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
									) AS StartDate,
									CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) AS CheckNCBDate,
									CONVERT(nvarchar(10), NCBCheckDate, 120) AS NCBCheckDate,
									[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
									[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit, BranchTel,
									[Profile].Branch, LendingBranchs.BranchName, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
									Product.ProductCode, Product.ProductName, Product.ProductTypes, [Profile].RequestLoan,
									CASE Verification.HQReceiveCADocDate
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120) 
									END AS HQReceiveCADocDate,
									CASE Verification.RMProcess
										WHEN 'Completed' THEN 'CP'
										WHEN 'CANCELBYRM' THEN 'CR'
										WHEN 'CANCELBYCA' THEN 'CA'
										WHEN 'CANCELBYCUS' THEN 'CC'
										ELSE 'AA'
									END AS RMProcess,
									CASE Verification.SentToCADate
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120) 
									END AS SentToCADate, CAReturnDateLog, IsDefend,
									ApplicationStatus.CAName, CONVERT(nvarchar(10), CA_ReceivedDocDate, 120) AS CA_ReceivedDocDate, 										
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
									END AS [Status], ApplicationStatus.StatusReason,
									CASE ApplicationStatus.PreLoan
										WHEN '0' THEN NULL
										ELSE ApplicationStatus.PreLoan
									END AS PreLoan,
									CASE CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120)
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120)
									END AS StatusDate,
									CASE ApplicationStatus.ApprovedLoan
										WHEN '0' THEN NULL
										ELSE ApplicationStatus.ApprovedLoan
									END AS ApprovedLoan, ApplicationStatus.AFCancelReason,
									CASE CONVERT(nvarchar(10),  ApplicationStatus.PlanDrawdownDate, 120)
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10),  ApplicationStatus.PlanDrawdownDate, 120)
									END AS PlanDrawdownDate,
									CASE CONVERT(nvarchar(10),  ApplicationStatus.PlanDateUnknown, 120)
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10),  ApplicationStatus.PlanDateUnknown, 120)
									END AS PlanDateUnknown,
									CASE CONVERT(nvarchar(10), ApplicationStatus.DrawdownDate, 120)
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), ApplicationStatus.DrawdownDate, 120)
									END AS DrawdownDate,
									CASE ApplicationStatus.DrawdownBaht
										WHEN '0' THEN NULL
										ELSE ApplicationStatus.DrawdownBaht
									END AS DrawdownBaht, ActionNoteLogs.ActionNote,
									CASE
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
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
										ELSE 'Active'
									END AS ActiveRecord,
									ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
									ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
									RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
									RetrieveRecord.EventTime AS RetrieveTime,
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
								LEFT OUTER JOIN LendingBranchs
								ON [Profile].BranchCode = LendingBranchs.BranchCode
								LEFT OUTER JOIN MasterRegion
								ON LendingBranchs.RegionID = MasterRegion.RegionID
								LEFT OUTER JOIN ( SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
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
									SELECT * FROM (
									SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
									VerifyID AS VF, BorrowerType, BorrowerName, 
									CASE NCBCheckDate
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), NCBCheckDate, 120) 
									END AS NCBCheckDate
									FROM dbo.NCBConsentLogs) Tmp
									WHERE Numindex = 1
								) NCBConsentLogs
								ON NCBConsentLogs.VF = Verification.VerifyID 
								AND NCBConsentLogs.BorrowerType = '101'
								LEFT OUTER JOIN (
									SELECT * FROM (
									SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
									DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
									CASE CAReturnDate
										WHEN '1900-01-01' THEN NULL
										WHEN '' THEN NULL
										ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
									END AS CAReturnDateLog
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
								WHERE [Profile].IsEnabled = 'A'
								AND NOT [Profile].CreateDate IS NULL
								AND NOT NCB.CheckNCBDate IS NULL								
								AND BasicCriteria = '1'
								AND NCB.CheckNCB in ('1', '3')		
								$where_addition
								$wheres_name
							) Inquiry

							SELECT * FROM
							(
								SELECT * , ROW_NUMBER() OVER (ORDER BY $adjust_ordering) AS KeyPoint
								FROM #TMPTEST
								$wheres
							) TMPAAA
							WHERE KeyPoint > $start AND KeyPoint <= $offset
			
							DROP TABLE #TMPTEST");
							
							return $result;
						
					} else {
						
						$result = $this->dbmodel->CIQuery("
							SELECT * INTO #TMPTEST
							 FROM(SELECT
									[Profile].DocID,  Verification.VerifyID, [Profile].SourceOfCustomer,
									ISNULL( 
										ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
										ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
									) AS StartDate,
									CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) AS CheckNCBDate,
									CONVERT(nvarchar(10), NCBCheckDate, 120) AS NCBCheckDate,
									[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
									[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit, BranchTel,
									[Profile].Branch, LendingBranchs.BranchName, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
									Product.ProductCode, Product.ProductName, Product.ProductTypes, [Profile].RequestLoan,
									CASE Verification.HQReceiveCADocDate
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120) 
									END AS HQReceiveCADocDate,
									CASE Verification.RMProcess
										WHEN 'Completed' THEN 'CP'
										WHEN 'CANCELBYRM' THEN 'CR'
										WHEN 'CANCELBYCA' THEN 'CA'
										WHEN 'CANCELBYCUS' THEN 'CC'
										ELSE 'AA'
									END AS RMProcess,
									CASE Verification.SentToCADate
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120) 
									END AS SentToCADate, CAReturnDateLog, IsDefend,
									ApplicationStatus.CAName, CONVERT(nvarchar(10), CA_ReceivedDocDate, 120) AS CA_ReceivedDocDate, 										
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
									END AS [Status], ApplicationStatus.StatusReason,
									CASE ApplicationStatus.PreLoan
										WHEN '0' THEN NULL
										ELSE ApplicationStatus.PreLoan
									END AS PreLoan,
									CASE CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120)
									WHEN '1900-01-01' THEN NULL
									ELSE CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120)
									END AS StatusDate,
									CASE ApplicationStatus.ApprovedLoan
										WHEN '0' THEN NULL
										ELSE ApplicationStatus.ApprovedLoan
									END AS ApprovedLoan, ApplicationStatus.AFCancelReason,
									CASE CONVERT(nvarchar(10),  ApplicationStatus.PlanDrawdownDate, 120)
									WHEN '1900-01-01' THEN NULL
									ELSE CONVERT(nvarchar(10),  ApplicationStatus.PlanDrawdownDate, 120)
									END AS PlanDrawdownDate,
									CASE CONVERT(nvarchar(10),  ApplicationStatus.PlanDateUnknown, 120)
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10),  ApplicationStatus.PlanDateUnknown, 120)
									END AS PlanDateUnknown,
									CASE CONVERT(nvarchar(10), ApplicationStatus.DrawdownDate, 120)
									WHEN '1900-01-01' THEN NULL
									ELSE CONVERT(nvarchar(10), ApplicationStatus.DrawdownDate, 120)
									END AS DrawdownDate,
									CASE ApplicationStatus.DrawdownBaht
										WHEN '0' THEN NULL
										ELSE ApplicationStatus.DrawdownBaht
									END AS DrawdownBaht, ActionNoteLogs.ActionNote,
									CASE
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
										WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
										ELSE 'Active'
									END AS ActiveRecord,
									ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
									ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
									RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
									RetrieveRecord.EventTime AS RetrieveTime,
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
								LEFT OUTER JOIN LendingBranchs
								ON [Profile].BranchCode = LendingBranchs.BranchCode
								LEFT OUTER JOIN MasterRegion
								ON LendingBranchs.RegionID = MasterRegion.RegionID
								LEFT OUTER JOIN ( SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
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
									SELECT * FROM (
									SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
									VerifyID AS VF, BorrowerType, BorrowerName, 
									CASE NCBCheckDate
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), NCBCheckDate, 120) 
									END AS NCBCheckDate
									FROM dbo.NCBConsentLogs) Tmp
									WHERE Numindex = 1
								) NCBConsentLogs
								ON NCBConsentLogs.VF = Verification.VerifyID 
								AND NCBConsentLogs.BorrowerType = '101'
								LEFT OUTER JOIN (
									SELECT * FROM (
									SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
									DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
									CASE CAReturnDate
										WHEN '1900-01-01' THEN NULL
										WHEN '' THEN NULL
										ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
									END AS CAReturnDateLog
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
								WHERE [Profile].IsEnabled = 'A'
								AND NOT [Profile].CreateDate IS NULL
								AND NOT NCB.CheckNCBDate IS NULL								
								AND BasicCriteria = '1'
								AND NCB.CheckNCB in ('1', '3')
								$where_addition
								$wheres_name
							) Inquiry
							$wheres
							AND BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'
						
							SELECT * FROM
							(
								SELECT * , ROW_NUMBER() OVER (ORDER BY $adjust_ordering) AS KeyPoint
								FROM #TMPTEST
								$wheres
							) TMPAAA
							WHERE KeyPoint > $start AND KeyPoint <= $offset
				
							DROP TABLE #TMPTEST");	
							
							
						return $result;
						
					}
					
				break;
				case $this->role_rm:
					
					$result = $this->dbmodel->CIQuery("
					SELECT * INTO #TMPTEST
					FROM(SELECT
							[Profile].DocID,  Verification.VerifyID, [Profile].SourceOfCustomer,
							ISNULL( 
									ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
									ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
							) AS StartDate,
							CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) AS CheckNCBDate,
							CONVERT(nvarchar(10), NCBCheckDate, 120) AS NCBCheckDate,
							[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
							[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit, BranchTel,
							[Profile].Branch, LendingBranchs.BranchName, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
							Product.ProductCode, Product.ProductName, Product.ProductTypes, [Profile].RequestLoan,
							ApplicationStatus.[CAName], CONVERT(nvarchar(10), CA_ReceivedDocDate, 120) AS CA_ReceivedDocDate,
							CASE Verification.HQReceiveCADocDate
								WHEN '1900-01-01' THEN NULL
								ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120) 
							END AS HQReceiveCADocDate,
							CASE Verification.RMProcess
								WHEN 'Completed' THEN 'CP'
								WHEN 'CANCELBYRM' THEN 'CR'
								WHEN 'CANCELBYCA' THEN 'CA'
								WHEN 'CANCELBYCUS' THEN 'CC'
								ELSE 'AA'
							END AS RMProcess,
							CASE Verification.SentToCADate
								WHEN '1900-01-01' THEN NULL
								ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120) 
							END AS SentToCADate, CAReturnDateLog, IsDefend,
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
							END AS [Status], ApplicationStatus.StatusReason,
							CASE ApplicationStatus.PreLoan
								WHEN '0' THEN NULL
								ELSE ApplicationStatus.PreLoan
							END AS PreLoan,
							CASE CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120)
							WHEN '1900-01-01' THEN NULL
							ELSE CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120)
							END AS StatusDate,
							CASE ApplicationStatus.ApprovedLoan
								WHEN '0' THEN NULL
								ELSE ApplicationStatus.ApprovedLoan
							END AS ApprovedLoan, ApplicationStatus.AFCancelReason,
							CASE CONVERT(nvarchar(10),  ApplicationStatus.PlanDrawdownDate, 120)
							WHEN '1900-01-01' THEN NULL
							ELSE CONVERT(nvarchar(10),  ApplicationStatus.PlanDrawdownDate, 120)
							END AS PlanDrawdownDate,
							CASE CONVERT(nvarchar(10),  ApplicationStatus.PlanDateUnknown, 120)
								WHEN '1900-01-01' THEN NULL
								ELSE CONVERT(nvarchar(10),  ApplicationStatus.PlanDateUnknown, 120)
							END AS PlanDateUnknown,
							CASE CONVERT(nvarchar(10), ApplicationStatus.DrawdownDate, 120)
							WHEN '1900-01-01' THEN NULL
							ELSE CONVERT(nvarchar(10), ApplicationStatus.DrawdownDate, 120)
							END AS DrawdownDate,
							CASE ApplicationStatus.DrawdownBaht
								WHEN '0' THEN NULL
								ELSE ApplicationStatus.DrawdownBaht
							END AS DrawdownBaht, ActionNoteLogs.ActionNote,
							CASE
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
								WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
								ELSE 'Active'
							END AS ActiveRecord,
							ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
							ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
							RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
							RetrieveRecord.EventTime AS RetrieveTime,
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
						LEFT OUTER JOIN LendingBranchs
						ON [Profile].BranchCode = LendingBranchs.BranchCode
						LEFT OUTER JOIN MasterRegion
						ON LendingBranchs.RegionID = MasterRegion.RegionID
						LEFT OUTER JOIN ( SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
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
							SELECT * FROM (
							SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
							VerifyID AS VF, BorrowerType, BorrowerName, 
							CASE NCBCheckDate
								WHEN '1900-01-01' THEN NULL
								ELSE CONVERT(nvarchar(10), NCBCheckDate, 120) 
							END AS NCBCheckDate
							FROM dbo.NCBConsentLogs) Tmp
							WHERE Numindex = 1
						) NCBConsentLogs
						ON NCBConsentLogs.VF = Verification.VerifyID 
						AND NCBConsentLogs.BorrowerType = '101'
						LEFT OUTER JOIN (
							SELECT * FROM (
							SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
							DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
							CASE CAReturnDate
								WHEN '1900-01-01' THEN NULL
								WHEN '' THEN NULL
								ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
							END AS CAReturnDateLog
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
						WHERE [Profile].IsEnabled = 'A'
						AND NOT [Profile].CreateDate IS NULL
						AND NOT NCB.CheckNCBDate IS NULL						
						AND BasicCriteria = '1'
						AND NCB.CheckNCB in ('1', '3')
						$where_addition
						$wheres_name
					) Inquiry
					$wheres
					AND RMCode = '".$employees['data'][0]['EmployeeCode']."'
					
					SELECT * FROM
					(
						SELECT * , ROW_NUMBER() OVER (ORDER BY $adjust_ordering) AS KeyPoint
						FROM #TMPTEST
						$wheres
					) TMPAAA
					WHERE KeyPoint > $start AND KeyPoint <= $offset
		
					DROP TABLE #TMPTEST");
					
					return $result;
			
					
				break;
				case $this->role_am:
					
						$result = $this->dbmodel->CIQuery("
						SELECT * INTO #TMPTEST
						FROM(SELECT
							[Profile].DocID,  Verification.VerifyID, [Profile].SourceOfCustomer,
							ISNULL( 
								ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
								ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
							) AS StartDate,
							CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) AS CheckNCBDate,
							CONVERT(nvarchar(10), NCBCheckDate, 120) AS NCBCheckDate,
							[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
							[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit, BranchTel,
							[Profile].Branch, LendingBranchs.BranchName, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
							Product.ProductCode, Product.ProductName, Product.ProductTypes, [Profile].RequestLoan,
							ApplicationStatus.[CAName], CONVERT(nvarchar(10), CA_ReceivedDocDate, 120) AS CA_ReceivedDocDate,
							CASE Verification.HQReceiveCADocDate
								WHEN '1900-01-01' THEN NULL
								ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120) 
							END AS HQReceiveCADocDate,
							CASE Verification.RMProcess
								WHEN 'Completed' THEN 'CP'
								WHEN 'CANCELBYRM' THEN 'CR'
								WHEN 'CANCELBYCA' THEN 'CA'
								WHEN 'CANCELBYCUS' THEN 'CC'
								ELSE 'AA'
							END AS RMProcess,
							CASE Verification.SentToCADate
								WHEN '1900-01-01' THEN NULL
								ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120) 
							END AS SentToCADate, CAReturnDateLog, IsDefend,
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
							END AS [Status], ApplicationStatus.StatusReason,
							CASE ApplicationStatus.PreLoan
								WHEN '0' THEN NULL
								ELSE ApplicationStatus.PreLoan
							END AS PreLoan,
							CASE CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120)
							WHEN '1900-01-01' THEN NULL
							ELSE CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120)
							END AS StatusDate,
							CASE ApplicationStatus.ApprovedLoan
								WHEN '0' THEN NULL
								ELSE ApplicationStatus.ApprovedLoan
							END AS ApprovedLoan, ApplicationStatus.AFCancelReason,
							CASE CONVERT(nvarchar(10),  ApplicationStatus.PlanDrawdownDate, 120)
							WHEN '1900-01-01' THEN NULL
							ELSE CONVERT(nvarchar(10),  ApplicationStatus.PlanDrawdownDate, 120)
							END AS PlanDrawdownDate,
							CASE CONVERT(nvarchar(10),  ApplicationStatus.PlanDateUnknown, 120)
								WHEN '1900-01-01' THEN NULL
								ELSE CONVERT(nvarchar(10),  ApplicationStatus.PlanDateUnknown, 120)
							END AS PlanDateUnknown,
							CASE CONVERT(nvarchar(10), ApplicationStatus.DrawdownDate, 120)
							WHEN '1900-01-01' THEN NULL
							ELSE CONVERT(nvarchar(10), ApplicationStatus.DrawdownDate, 120)
							END AS DrawdownDate,
							CASE ApplicationStatus.DrawdownBaht
								WHEN '0' THEN NULL
								ELSE ApplicationStatus.DrawdownBaht
							END AS DrawdownBaht, ActionNoteLogs.ActionNote,
							CASE
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
								WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
								ELSE 'Active'
							END AS ActiveRecord,
							ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
							ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
							RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
							RetrieveRecord.EventTime AS RetrieveTime,
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
						LEFT OUTER JOIN LendingBranchs
						ON [Profile].BranchCode = LendingBranchs.BranchCode
						LEFT OUTER JOIN MasterRegion
						ON LendingBranchs.RegionID = MasterRegion.RegionID
						LEFT OUTER JOIN ( SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
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
							SELECT * FROM (
							SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
							VerifyID AS VF, BorrowerType, BorrowerName, 
							CASE NCBCheckDate
								WHEN '1900-01-01' THEN NULL
								ELSE CONVERT(nvarchar(10), NCBCheckDate, 120) 
							END AS NCBCheckDate
							FROM dbo.NCBConsentLogs) Tmp
							WHERE Numindex = 1
						) NCBConsentLogs
						ON NCBConsentLogs.VF = Verification.VerifyID 
						AND NCBConsentLogs.BorrowerType = '101'
						LEFT OUTER JOIN (
							SELECT * FROM (
							SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
							DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
							CASE CAReturnDate
								WHEN '1900-01-01' THEN NULL
								WHEN '' THEN NULL
								ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
							END AS CAReturnDateLog
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
						WHERE [Profile].IsEnabled = 'A'
						AND NOT [Profile].CreateDate IS NULL
						AND NOT NCB.CheckNCBDate IS NULL						
						AND BasicCriteria = '1'
						AND NCB.CheckNCB in ('1', '3')
						$where_addition
						$wheres_name
					) Inquiry
					$wheres
					AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' GROUP BY BranchCode)
				
					SELECT * FROM
					(
						SELECT * , ROW_NUMBER() OVER (ORDER BY $adjust_ordering) AS KeyPoint
						FROM #TMPTEST
						$wheres
					) TMPAAA
					WHERE KeyPoint > $start AND KeyPoint <= $offset
		
					DROP TABLE #TMPTEST");
							
					return $result;
					
					
				break;
				case $this->role_rd:
					
					$result = $this->dbmodel->CIQuery("
					SELECT * INTO #TMPTEST
					FROM(SELECT
						[Profile].DocID,  Verification.VerifyID, [Profile].SourceOfCustomer,
						ISNULL( 
							ISNULL(CONVERT(nvarchar(10), RetrieveRecord.EventDate, 120), CONVERT(nvarchar(10), ReActivateRecord.ReActivateDate, 120)), 
							ISNULL(CONVERT(nvarchar(10), NCBCheckDate, 120), CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)) 
						) AS StartDate,
						CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) AS CheckNCBDate,
						CONVERT(nvarchar(10), NCBCheckDate, 120) AS NCBCheckDate,
						[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
						[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit, BranchTel,
						[Profile].Branch, LendingBranchs.BranchName, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
						Product.ProductCode, Product.ProductName, Product.ProductTypes, [Profile].RequestLoan,
						ApplicationStatus.[CAName], CONVERT(nvarchar(10), CA_ReceivedDocDate, 120) AS CA_ReceivedDocDate,
						CASE Verification.HQReceiveCADocDate
							WHEN '1900-01-01' THEN NULL
							ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120) 
						END AS HQReceiveCADocDate,
						CASE Verification.RMProcess
							WHEN 'Completed' THEN 'CP'
							WHEN 'CANCELBYRM' THEN 'CR'
							WHEN 'CANCELBYCA' THEN 'CA'
							WHEN 'CANCELBYCUS' THEN 'CC'
							ELSE 'AA'
						END AS RMProcess,
						CASE Verification.SentToCADate
							WHEN '1900-01-01' THEN NULL
							ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120) 
						END AS SentToCADate, CAReturnDateLog, IsDefend,
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
						END AS [Status], ApplicationStatus.StatusReason,
						CASE ApplicationStatus.PreLoan
							WHEN '0' THEN NULL
							ELSE ApplicationStatus.PreLoan
						END AS PreLoan,
						CASE CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120)
						WHEN '1900-01-01' THEN NULL
						ELSE CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120)
						END AS StatusDate,
						CASE ApplicationStatus.ApprovedLoan
							WHEN '0' THEN NULL
							ELSE ApplicationStatus.ApprovedLoan
						END AS ApprovedLoan, ApplicationStatus.AFCancelReason,
						CASE CONVERT(nvarchar(10),  ApplicationStatus.PlanDrawdownDate, 120)
						WHEN '1900-01-01' THEN NULL
						ELSE CONVERT(nvarchar(10),  ApplicationStatus.PlanDrawdownDate, 120)
						END AS PlanDrawdownDate,
						CASE CONVERT(nvarchar(10),  ApplicationStatus.PlanDateUnknown, 120)
							WHEN '1900-01-01' THEN NULL
							ELSE CONVERT(nvarchar(10),  ApplicationStatus.PlanDateUnknown, 120)
						END AS PlanDateUnknown,
						CASE CONVERT(nvarchar(10), ApplicationStatus.DrawdownDate, 120)
							WHEN '1900-01-01' THEN NULL
							ELSE CONVERT(nvarchar(10), ApplicationStatus.DrawdownDate, 120)
						END AS DrawdownDate,
						CASE ApplicationStatus.DrawdownBaht
							WHEN '0' THEN NULL
							ELSE ApplicationStatus.DrawdownBaht
						END AS DrawdownBaht, ActionNoteLogs.ActionNote,
						CASE
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
							WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
							ELSE 'Active'
						END AS ActiveRecord,
						ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
						ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
						RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
						RetrieveRecord.EventTime AS RetrieveTime,
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
					LEFT OUTER JOIN LendingBranchs
					ON [Profile].BranchCode = LendingBranchs.BranchCode
					LEFT OUTER JOIN MasterRegion
					ON LendingBranchs.RegionID = MasterRegion.RegionID
					LEFT OUTER JOIN ( SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
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
						SELECT * FROM (
						SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
						VerifyID AS VF, BorrowerType, BorrowerName, 
						CASE NCBCheckDate
							WHEN '1900-01-01' THEN NULL
							ELSE CONVERT(nvarchar(10), NCBCheckDate, 120) 
						END AS NCBCheckDate
						FROM dbo.NCBConsentLogs) Tmp
						WHERE Numindex = 1
					) NCBConsentLogs
					ON NCBConsentLogs.VF = Verification.VerifyID 
					AND NCBConsentLogs.BorrowerType = '101'
					LEFT OUTER JOIN (
						SELECT * FROM (
						SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
						DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
						CASE CAReturnDate
							WHEN '1900-01-01' THEN NULL
							WHEN '' THEN NULL
							ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
						END AS CAReturnDateLog
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
					WHERE [Profile].IsEnabled = 'A'
					AND NOT [Profile].CreateDate IS NULL
					AND NOT NCB.CheckNCBDate IS NULL					
					AND BasicCriteria = '1'
					AND NCB.CheckNCB in ('1', '3')
					$where_addition
					$wheres_name
				) Inquiry
				$wheres
				AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)
				
				SELECT * FROM
				(
					SELECT * , ROW_NUMBER() OVER (ORDER BY $adjust_ordering) AS KeyPoint
					FROM #TMPTEST
					$wheres
				) TMPAAA
				WHERE KeyPoint > $start AND KeyPoint <= $offset
	
				DROP TABLE #TMPTEST");	
				
				return $result;
				
				break;
			}
			
		}
		
	}
	
	
	public function dataTableDashboardGrandTotal($authority, $condition = array(), $search = array()) {
		$this->load->model('dbmodel');		
		
		if(empty($authority)) {
			
			log_message('error', 'method '.__METHOD__ .'can not load data progress. please check object criteria.');
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
		
		} else {
						
			if(count($authority) > 1) {
				$privileges = $authority[0];
					
			} else {
				$privileges = $authority[0];
			}
		
			// load data employees.
			$employees = $this->employeesInfo($condition[0]);
			$empbranch = str_pad($employees['data'][0]['BranchCode'], 3, "0", STR_PAD_LEFT);
			
			switch($privileges) {
				case $this->role_ad:
				case $this->role_bm:
				case $this->role_hq:
				case $this->role_spv:
				case $this->role_ads:
					
					if($empbranch == "000" || $empbranch == "901"):
						$optional = '';
					else:
						$optional = ' AND BranchCode = "'.str_pad($empbranch, 3, "0", STR_PAD_LEFT).'"';
					endif;
				
					break;
				case $this->role_rm:
					$optional = ' AND RMCode = "'.$employees['data'][0]['EmployeeCode'].'"';
			
					break;
				case $this->role_am:
					$optional = ' AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = "'.$employees['data'][0]['EmployeeCode'].'" GROUP BY BranchCode)';
			
					break;
				case $this->role_rd:
					$optional = ' AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = "'.$employees['data'][0]['RegionID'].'" GROUP BY BranchCode)';
			
					break;

			}
		
		}
			
		try {
			
			$result = $this->dbmodel->CIQuery("
			SELECT COUNT(MGroup) AS RowRecord, SUM(CAST(RequestLoan AS decimal(18,0))) AS RequestLoan, 
			SUM(CAST(ApprovedLoan as decimal(18,0))) AS ApprovedLoan, SUM(CAST(DrawdownBaht as decimal(18,0))) AS DrawdownBaht
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
							) AS StartDate,
							[Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
							[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit,
							[Profile].Branch, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng,
							Product.ProductCode, Product.ProductName, Product.ProductTypes, [Profile].RequestLoan,
							Verification.HQReceiveCADocDate AS HQReceiveCADocDate,
							Verification.RMProcess, Verification.SentToCADate AS SentToCADate, CAReturnDateLog,
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
						END AS [Status], ApplicationStatus.StatusReason,
						CASE ApplicationStatus.PreLoan
							WHEN '0' THEN NULL
							ELSE ApplicationStatus.PreLoan
							END AS PreLoan,
							ApplicationStatus.StatusDate AS StatusDate, ApplicationStatus.ApprovedLoan  AS ApprovedLoan,
							ApplicationStatus.PlanDrawdownDate AS PlanDrawdownDate, ApplicationStatus.PlanDateUnknown,
							ApplicationStatus.DrawdownDate AS DrawdownDate,
							ApplicationStatus.DrawdownBaht AS DrawdownBaht, Verification.ActionNote,
						CASE
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
							WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
							ELSE 'Active'
							END AS ActiveRecord,
							ISNULL(RetrievedDigit, ReactivateDigit) AS LatestEvent,
							ReActivateRecord.ReActivated, ReActivateRecord.ReActivateDate,
							RetrieveRecord.Retrieved, RetrieveRecord.EventDate AS RetrieveDate,
							RetrieveRecord.EventTime AS RetrieveTime,
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
						LEFT OUTER JOIN LendingBranchs
						ON [Profile].BranchCode = LendingBranchs.BranchCode
						LEFT OUTER JOIN MasterRegion
						ON LendingBranchs.RegionID = MasterRegion.RegionID
						LEFT OUTER JOIN ( SELECT DISTINCT DocID AS RF_DocID, IsDefend FROM DefendHead ) Defender
						ON Defender.RF_DocID = [Profile].DocID
						LEFT OUTER JOIN (
							 SELECT * FROM (
								 SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
								 VerifyID AS VF, BorrowerType, BorrowerName, 
								 CASE NCBCheckDate
									 WHEN '1900-01-01' THEN NULL
									 ELSE CONVERT(nvarchar(10), NCBCheckDate, 120) 
								 END AS NCBCheckDate
							 FROM dbo.NCBConsentLogs) Tmp
							 WHERE Numindex = 1
						) NCBConsentLogs
						ON NCBConsentLogs.VF = Verification.VerifyID 
						AND NCBConsentLogs.BorrowerType = '101'
						LEFT OUTER JOIN (
							SELECT * FROM (
							SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
							DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
							CASE CAReturnDate
								WHEN '1900-01-01' THEN NULL
								WHEN '' THEN NULL
								ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
							END AS CAReturnDateLog
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
						WHERE [Profile].IsEnabled = 'A'
						AND NOT [Profile].CreateDate IS NULL
						AND NOT NCB.CheckNCBDate IS NULL						
						AND BasicCriteria = '1'
						AND NCB.CheckNCB in ('1', '3')	
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