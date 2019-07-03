<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dbreferral extends CI_Model {

	protected $role_ad;
	protected $role_rm;
	protected $role_bm;
	protected $role_am;
	protected $role_rd;
	protected $role_hq;
	protected $role_spv;
	protected $role_ads;

	public $db_types;
	private $char_mode;

	public function __construct() {
		parent::__construct();

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

	}
	
	public function getDataTLATransaction($authority, $condition = array()) {		
		$this->load->model('dbmodel');
		$this->load->model('dbcustom');
		$this->load->library('effective');
		
		$wheres			= 'WHERE CreateDate IS NOT NULL';

		$start_date		= $this->input->post('start_date');
		$end_date 		= $this->input->post('end_date');
		
		$tl_code 		= $this->input->post('tl_code');
		$tl_name 		= $this->input->post('tl_name');
		$tl_branch 		= $this->input->post('tl_branch');	
		$tl_status 		= $this->input->post('tl_status');
		$tl_state_main  = $this->input->post('tl_state_main');
		$tl_position 	= $this->input->post('tl_position');
		
		$lb_region 		= $this->input->post('lb_region');
		$lb_branch 		= $this->input->post('lb_branch');
		$lb_rm 			= $this->input->post('lb_rm');
		$lb_bm 			= $this->input->post('lb_bm');
		
		if(!empty($tl_state_main[0]) && !empty($tl_status[0])):
			$status_object  = array_merge($tl_state_main, $tl_status);
			
		else:
			
			if(!empty($tl_state_main[0])):
				$status_object	= $tl_state_main;
			endif;
			
			if(!empty($tl_status[0])):
				$status_object  = $tl_status;
			endif;
			
		endif;
				
		// ################# FIELD VALIDATION ###############
		if(!empty($tl_branch[0])):
			$where_BelongtoTLA   = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $tl_branch)."'");
		else:
			$where_BelongtoTLA   = "";
		endif;
		
		$id_expired		= '';
		$tl_expired		= '';

		if(!empty($status_object[0])):
		
			if(in_array("IDCard Expired", $status_object)):
				$id_expired = 'Y';
				$attr = array_search("IDCard Expired", $status_object);
				if($attr !== false) unset($status_object[$attr]);
			endif;
			
			if(in_array("TLCard Expired", $status_object)):
				$tl_expired = 'Y';
				$attr = array_search("TLCard Expired", $status_object);
				if($attr !== false) unset($status_object[$attr]);
			endif;
		
			$where_TLAStatus   	= "'".implode("','", $status_object)."'";
		else:
			$where_TLAStatus   	= "";
		endif;
		
		if(!empty($tl_position[0])):
			$where_TLAPosition  = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $tl_position)."'");
		else:
			$where_TLAPosition  = "";
		endif;
		
		if(!empty($lb_branch[0])):
			$where_branchs   	= "'".implode("','", $lb_branch)."'";
		else:
			$where_branchs   	= "";
		endif;
		
		if(!empty($lb_bm[0])):
			$where_manager   	= "'".implode("','", $lb_bm)."'";
		else:
			$where_manager   	= "";
		endif;
		
		if(!empty($lb_rm[0])):
			$where_employee   	= "'".implode("','", $lb_rm)."'";
		else:
			$where_employee   	= "";
		endif;
		
		// ################ START SET FILTER ################
		
		// CONDITION GENERAL
		if(!empty($tl_code)) { $wheres .= " AND TLA_Code = '".$tl_code."'"; }
		if(!empty($tl_name)) { $wheres .= " AND TLA_Name LIKE '%".$this->effective->set_chartypes($this->char_mode, $tl_name)."%'"; }
		
		// GROUP DATA
		if(!empty($lb_region)) { $wheres .= " AND LB_RegionID = $lb_region"; }
		if(!empty($tl_branch[0])) { $wheres .= " AND TLA_BranchName in ($where_BelongtoTLA) "; }
		
		if(!empty($status_object[0])) { $wheres .= " AND TLA_Status in ($where_TLAStatus) "; } 
		else { $wheres .= " AND NOT TLA_Status in ('Cancel by TL', 'Terminate')";  }
		
		if(!empty($tl_position[0])) { $wheres .= " AND TLA_Position in ($where_TLAPosition) "; }
		if(!empty($lb_branch[0])) { $wheres .= " AND LB_BranchCode in ($where_branchs) "; }
		if(!empty($lb_bm[0])) { $wheres .= " AND BMCode in ($where_manager) "; }
		if(!empty($lb_rm[0])) { $wheres .= " AND RMCode in ($where_employee) "; }
		if(!empty($id_expired)) { $wheres .= " AND IDExpired = '".$id_expired."'"; }
		if(!empty($tl_expired)) { $wheres .= " AND TLExpired = '".$tl_expired."'"; }
		  
		// DATE RANGE
		$conv_startdate  = !empty($start_date) ? $this->effective->StandartDateSorter($start_date):"";
		$conv_enddate	 = !empty($end_date) ? $this->effective->StandartDateSorter($end_date):"";
		
		if(!empty($conv_startdate) && !empty($end_date)) {
			$wheres .= " AND CONVERT(nvarchar(10), JoinDate, 120) BETWEEN '".$conv_startdate."' AND '".$conv_enddate."'";
		} else {
		
			if(!empty($conv_startdate)):
				$wheres .= " AND CONVERT(nvarchar(10), JoinDate, 120)  = '".$conv_startdate."'";
			endif;
		
			if(!empty($conv_enddate)):
				$wheres .= " AND CONVERT(nvarchar(10), JoinDate, 120)  = '".$conv_enddate."'";
			endif;
		
		}
			
		//################# #END SET FILTER# ##################
		
		$iStart  = $this->input->post('start');
		$iLength = $this->input->post('length') ? $iLength = $this->input->post('length') : 10;
		
		$start	 = ($iStart)? $iStart : 0;
		$offset  = $iLength + $start;
		
		$Ordering = $this->get_ordering();

		if(empty($authority)) {
		
			log_message('error', 'method '.__METHOD__ .'can not load data. Please you are check object criteria in parameter.');
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
		
		} else {
			
			if(count($authority) > 1) :
				$privileges = $authority[0];
			else:
				$privileges = $authority[0];
			endif;
			
			$employees  = $this->dbcustom->employeesInfo($condition[0]);
			$empbranch  = str_pad($employees['data'][0]['BranchCode'], 3, '0', STR_PAD_LEFT);
			
			$where_auth = '';
			switch($privileges) {
				case $this->role_ad:
			
					if($empbranch == "000" || $empbranch == "901"):
						$where_auth = '';
					else:
						$where_auth = " AND LB_BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'";
					endif;
			
					break;
				case $this->role_rm:
					$where_auth	= " AND BMCode = '".$condition[0]."'";
			
					break;
				case $this->role_bm:
					$where_auth = " AND LB_BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'";
			
					break;
				case $this->role_am:
					$where_auth = " AND LB_BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$condition[0]."' GROUP BY BranchCode)";
			
					break;
				case $this->role_rd:
					$where_auth = " AND LB_BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)";
			
					break;
						
				case $this->role_hq:
				case $this->role_spv:
				case $this->role_ads:
					$where_auth = '';
					break;
			
			}
					
			try {
				
				$result = $this->dbmodel->CIQuery("
				SELECT * FROM (
					SELECT *, ROW_NUMBER() OVER (ORDER BY $Ordering) AS KeyPoint 
					FROM (
						SELECT TL_ID, TLA_Code, TLA_Name, TLA_Position, TLA_PositionShort, TLA_BranchName, REPLACE(TLA_BranchTel, '-', '') AS TLA_BranchTel, TLA_Mobile, TLA_Mobile_2, LB_RegionID, LB_BranchCode, LendingEmp.PositionTitle, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
						BranchName AS LB_BranchName, BranchDigit AS BranchDigit, BranchTel, LB_Ref01_Code AS BMCode, LB_Ref01 AS BMName, LendingEmp.Nickname, LendingEmp.Mobile AS BMMobile, LB_Ref02_Code AS RMCode, LB_Ref02 AS RMName, TLA_Status,
						CONVERT(NVARCHAR(10), JoinDate, 120) AS JoinDate,
						CONVERT(NVARCHAR(10), ExpiredDate, 120) AS TLCardExpiredDate,
						CASE 
							WHEN ExpiredDate < GETDATE() THEN 'Y'
							ELSE NULL
						END AS TLExpired,
						CONVERT(NVARCHAR(10), IDCardExpired, 120) AS IDCardExpired,
							CASE 
							WHEN IDCardExpired < GETDATE() THEN 'Y'
							ELSE NULL
						END AS IDExpired,
						CreateBy, CONVERT(NVARCHAR(10), CreateDate, 120) AS CreateDate, 
						UpdateBy, CONVERT(NVARCHAR(10), UpdateDate, 120) AS UpdateDate,
						MasterTLAStatus.Seq
						FROM  MasterTLA
						LEFT OUTER JOIN LendingEmp
						ON MasterTLA.LB_Ref01_Code = LendingEmp.EmployeeCode  AND LendingEmp.IsActive = 'A'
						LEFT OUTER JOIN LendingBranchs
						ON LendingBranchs.BranchCode = ISNULL(MasterTLA.LB_BranchCode, LendingEmp.OfficeBase)
						LEFT OUTER JOIN MasterRegion
						ON LendingBranchs.RegionID = MasterRegion.RegionID
						LEFT OUTER JOIN MasterTLAStatus
						ON MasterTLA.TLA_Status = MasterTLAStatus.TL_Status
					) Filters
					$wheres
					$where_auth
				) A
				WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
				
				return $result;

			} catch(Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
					
			}
			
		}
		
		
	}
	
	public function getDataTLATransactionPagination($authority, $condition = array()) {
		$this->load->model('dbmodel');
		$this->load->model('dbcustom');
		$this->load->library('effective');
		
		$wheres			= 'WHERE CreateDate IS NOT NULL';
		
		$start_date		= $this->input->post('start_date');
		$end_date 		= $this->input->post('end_date');
		
		$tl_code 		= $this->input->post('tl_code');
		$tl_name 		= $this->input->post('tl_name');
		$tl_branch 		= $this->input->post('tl_branch');
		$tl_status 		= $this->input->post('tl_status');
		$tl_state_main  = $this->input->post('tl_state_main');
		$tl_position 	= $this->input->post('tl_position');
		
		$lb_region 		= $this->input->post('lb_region');
		$lb_branch 		= $this->input->post('lb_branch');
		$lb_bm 			= $this->input->post('lb_bm');
		$lb_rm 			= $this->input->post('lb_rm');

		if(!empty($tl_state_main[0]) && !empty($tl_status[0])):
			$status_object  = array_merge($tl_state_main, $tl_status);
			
		else:
			
			if(!empty($tl_state_main[0])):
				$status_object	= $tl_state_main;
			endif;
			
			if(!empty($tl_status[0])):
				$status_object  = $tl_status;
			endif;
			
		endif;

		// ################# FIELD VALIDATION ###############
		if(!empty($tl_branch[0])):
			$where_BelongtoTLA   = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $tl_branch)."'");
		else:
			$where_BelongtoTLA   = "";
		endif;
		
		$id_expired		= '';
		$tl_expired		= '';

		if(!empty($status_object[0])):
		
			if(in_array("IDCard Expired", $status_object)):
				$id_expired = 'Y';
				$attr = array_search("IDCard Expired", $status_object);
				if($attr !== false) unset($status_object[$attr]);
			endif;
			
			if(in_array("TLCard Expired", $status_object)):
				$tl_expired = 'Y';
				$attr = array_search("TLCard Expired", $status_object);
				if($attr !== false) unset($status_object[$attr]);
			endif;
		
			$where_TLAStatus   	= "'".implode("','", $status_object)."'";
		else:
			$where_TLAStatus   	= "";
		endif;
		
		if(!empty($tl_position[0])):
			$where_TLAPosition  = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $tl_position)."'");
		else:
			$where_TLAPosition  = "";
		endif;
		
		
		if(!empty($lb_branch[0])):
			$where_branchs   	= "'".implode("','", $lb_branch)."'";
		else:
			$where_branchs   	= "";
		endif;
		
		if(!empty($lb_bm[0])):
			$where_manager   	= "'".implode("','", $lb_bm)."'";
		else:
			$where_manager   	= "";
		endif;
		
		if(!empty($lb_rm[0])):
			$where_employee   	= "'".implode("','", $lb_rm)."'";
		else:
			$where_employee   	= "";
		endif;
	
		// ################ START SET FILTER ################
		
		// CONDITION GENERAL
		if(!empty($tl_code)) { $wheres .= " AND TLA_Code = '".$tl_code."'"; }
		if(!empty($tl_name)) { $wheres .= " AND TLA_Name LIKE '%".$this->effective->set_chartypes($this->char_mode, $tl_name)."%'"; }
		
		// GROUP DATA
		if(!empty($lb_region)) { $wheres .= " AND LB_RegionID = $lb_region"; }
		if(!empty($tl_branch[0])) { $wheres .= " AND TLA_BranchName in ($where_BelongtoTLA) "; }
		if(!empty($status_object[0])) { $wheres .= " AND TLA_Status in ($where_TLAStatus) "; } else { $wheres .= " AND NOT TLA_Status in ('Cancel by TL', 'Terminate')";  }
		if(!empty($tl_position[0])) { $wheres .= " AND TLA_Position in ($where_TLAPosition) "; }
		if(!empty($lb_branch[0])) { $wheres .= " AND LB_BranchCode in ($where_branchs) "; }
		if(!empty($lb_bm[0])) { $wheres .= " AND BMCode in ($where_manager) "; }
		if(!empty($lb_rm[0])) { $wheres .= " AND RMCode in ($where_employee) "; }
		if(!empty($id_expired)) { $wheres .= " AND IDExpired = '".$id_expired."'"; }
		if(!empty($tl_expired)) { $wheres .= " AND TLExpired = '".$tl_expired."'"; }

		// DATE RANGE
		$conv_startdate  = !empty($start_date) ? $this->effective->StandartDateSorter($start_date):"";
		$conv_enddate	 = !empty($end_date) ? $this->effective->StandartDateSorter($end_date):"";
		
		if(!empty($conv_startdate) && !empty($end_date)) {
			$wheres .= " AND CONVERT(nvarchar(10), JoinDate, 120) BETWEEN '".$conv_startdate."' AND '".$conv_enddate."'";
		} else {
		
			if(!empty($conv_startdate)):
				$wheres .= " AND CONVERT(nvarchar(10), JoinDate, 120)  = '".$conv_startdate."'";
			endif;
		
			if(!empty($conv_enddate)):
				$wheres .= " AND CONVERT(nvarchar(10), JoinDate, 120)  = '".$conv_enddate."'";
			endif;
		
		}
			
		//################# #END SET FILTER# ##################
		if(empty($authority)) {
	
			log_message('error', 'method '.__METHOD__ .'can not load data. Please you are check object criteria in parameter.');
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
	
		} else {
				
			if(count($authority) > 1) :
			$privileges = $authority[0];
			else:
			$privileges = $authority[0];
			endif;
				
			$employees  = $this->dbcustom->employeesInfo($condition[0]);
			$empbranch  = str_pad($employees['data'][0]['BranchCode'], 3, '0', STR_PAD_LEFT);
				
			$where_auth = '';
			switch($privileges) {
				case $this->role_ad:
						
					if($empbranch == "000" || $empbranch == "901"):
						$where_auth = '';
					else:
						$where_auth = " AND LB_BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'";
					endif;
						
					break;
				case $this->role_rm:
					$where_auth	= " AND BMCode = '".$condition[0]."'";
						
					break;
				case $this->role_bm:
					$where_auth = " AND LB_BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'";
						
					break;
				case $this->role_am:
					$where_auth = " AND LB_BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$condition[0]."' GROUP BY BranchCode)";
						
					break;
				case $this->role_rd:
					$where_auth = " AND LB_BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)";
						
					break;
	
				case $this->role_hq:
				case $this->role_spv:
				case $this->role_ads:
						$where_auth = '';
					break;
						
			}				
				
			try {
	
				$result = $this->db->query("
					SELECT * FROM (
						SELECT *
						FROM (
							SELECT TL_ID, TLA_Code, TLA_Name, TLA_Position, TLA_PositionShort, TLA_BranchName, TLA_BranchTel, TLA_Mobile, TLA_Mobile_2, LB_RegionID, LB_BranchCode, LendingEmp.PositionTitle, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
							BranchName AS LB_BranchName, BranchDigit AS BranchDigit, BranchTel, LB_Ref01_Code AS BMCode, LB_Ref01 AS BMName, LendingEmp.Nickname, LendingEmp.Mobile AS BMMobile, LB_Ref02_Code AS RMCode, LB_Ref02 AS RMName, TLA_Status,
							CONVERT(NVARCHAR(10), JoinDate, 120) AS JoinDate,
							CONVERT(NVARCHAR(10), ExpiredDate, 120) AS TLCardExpiredDate,
							CASE 
								WHEN ExpiredDate < GETDATE() THEN 'Y'
								ELSE NULL
							END AS TLExpired,
							CONVERT(NVARCHAR(10), IDCardExpired, 120) AS IDCardExpired,
								CASE 
								WHEN IDCardExpired < GETDATE() THEN 'Y'
								ELSE NULL
							END AS IDExpired,
							CreateBy, CONVERT(NVARCHAR(10), CreateDate, 120) AS CreateDate, 
							UpdateBy, CONVERT(NVARCHAR(10), UpdateDate, 120) AS UpdateDate,
							MasterTLAStatus.Seq
							FROM  MasterTLA
							LEFT OUTER JOIN LendingEmp
							ON MasterTLA.LB_Ref01_Code = LendingEmp.EmployeeCode  AND LendingEmp.IsActive = 'A'
							LEFT OUTER JOIN LendingBranchs
							ON LendingBranchs.BranchCode = ISNULL(MasterTLA.LB_BranchCode, LendingEmp.OfficeBase)
							LEFT OUTER JOIN MasterRegion
							ON LendingBranchs.RegionID = MasterRegion.RegionID
							LEFT OUTER JOIN MasterTLAStatus
							ON MasterTLA.TLA_Status = MasterTLAStatus.TL_Status						
						) Filters
						$wheres
						$where_auth
					) A
				");
	
				return $result->num_rows();
	
	
			} catch(Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
					
			}
				
		}
	
	
	}
	
	public function getDataTLAVolume($authority, $condition = array()) {
		$this->load->model('dbcustom');
		$this->load->library('effective');

		$wheres	 		= '';
		$join_date 		= '';
		$tla_code		= '';
		$tla_name		= '';
		$tla_branch		= '';
		$tla_position	= '';
		$tla_status		= '';
				
		$lb_region_id	= '';
		$lb_branchcode	= '';
		$employee_find	= '';
		$has_drawdown	= '';
		$has_a2ca		= '';
		$has_ncb		= '';

		$filter_type	= $this->input->post('filter_type');
		$start_date		= $this->input->post('start_date');
		$end_date 		= $this->input->post('end_date');
		
		$tl_code 		= $this->input->post('tl_code');
		$tl_name 		= $this->input->post('tl_name');
		$tl_branch 		= $this->input->post('tl_branch');	
		$tl_position 	= $this->input->post('tl_position');
		
		$tl_status		= $this->input->post('tl_status');
		$tl_state_main  = $this->input->post('tl_state_main');
		$drawdown_check	= $this->input->post('drawdown_check');
		$a2ca_check		= $this->input->post('a2ca_check');
		$ncb_check		= $this->input->post('ncb_check');
		
		$lb_region 		= $this->input->post('lb_region');
		$lb_branch 		= $this->input->post('lb_branch');
		$lb_emp 		= $this->input->post('lb_emp');
		
		$iStart  = $this->input->post('start');
		$iLength = $this->input->post('length') ? $iLength = $this->input->post('length') : 10;
		
		if(!empty($tl_state_main[0]) && !empty($tl_status[0])):
			$status_object  = array_merge($tl_state_main, $tl_status);
			
		else:
			
			if(!empty($tl_state_main[0])):
				$status_object	= $tl_state_main;
			endif;
				
			if(!empty($tl_status[0])):
				$status_object  = $tl_status;
			endif;
			
		endif;
		
		// Condition
		if(!empty($tl_code)) { $tla_code = ", @TL_Code = '".$tl_code."'"; }
		if(!empty($tl_name)) { $tla_name = ", @TL_Name = '".$this->effective->set_chartypes($this->char_mode, $tl_name)."'"; }
				
		$conv_startdate  = !empty($start_date) ? $this->effective->StandartDateSorter($start_date):"";
		$conv_enddate	 = !empty($end_date) ? $this->effective->StandartDateSorter($end_date):"";
		
		if($filter_type == 'DrawdownDate') {
			
			if(!empty($conv_startdate) && !empty($end_date)) {
				$join_date = ", @DDStart = '".$conv_startdate."', @DDEnd = '".$conv_enddate."'";
				
			} else {
							
				if(!empty($conv_startdate)) $join_date = ", @DDStart = '".$conv_startdate."', @DDEnd = '".$conv_startdate."' ";		
				if(!empty($conv_enddate)) $join_date   = ", @DDStart = '".$conv_enddate."', @DDEnd = '".$conv_enddate."'";
		
			}
			
		} else {
			
			if(!empty($conv_startdate) && !empty($end_date)):
				$join_date = ", @JoinStart = '".$conv_startdate."', @JoinEnd = '".$conv_enddate."'";
			else:
				if(!empty($conv_startdate)) $join_date .= ", @JoinStart =  '".$conv_startdate."'";
				if(!empty($conv_enddate)) $join_date .= ", @JoinEnd = '".$conv_enddate."'";
			endif;
		
		}
	
		if(!empty($status_object[0])) { $tla_status .= ", @Status = '".implode(',', $status_object)."'"; }
		
		if(!empty($lb_emp[0])):
			$employee_find  = ", @LB_Emp = '".implode(',', $lb_emp)."'";
		endif;
		
		if(!empty($tl_position[0])):
			$tla_position   = ", @TL_Position = '".$this->effective->set_chartypes($this->char_mode, implode(',', $tl_position))."'";
		endif;
		
		if(!empty($tl_branch[0])):
			$tla_branch   	= ", @TL_Branch = '".$this->effective->set_chartypes($this->char_mode, implode(',', $tl_branch))."'";
		endif;
		
		if(!empty($lb_branch[0])):
			$lb_branchcode  = ", @LB_Branch = '".implode(',', $lb_branch)."'";
		endif;
		
		if(!empty($lb_region)) $lb_region_id .= ", @LB_Region = '".$lb_region."'";		
		if(!empty($drawdown_check)) $has_drawdown .= ", @hasDrawdown = '".$drawdown_check."'";
		if(!empty($a2ca_check)) $has_a2ca .= ", @hasA2CA = '".$a2ca_check."'";
		if(!empty($ncb_check)) $has_ncb .= ", @hasNCB = '".$ncb_check."'";

		$start	 = ($iStart)? $iStart : 0;
		$offset  = $iLength + $start;
		
		$Ordering = $this->get_ordering();
		
		if(empty($authority)) {		
			log_message('error', 'method '.__METHOD__ .'can not load data. Please you are check object criteria in parameter.');
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
		
		} else {
		
			if(count($authority) > 1) :
				$privileges = $authority[0];
			else:
				$privileges = $authority[0];
			endif;
		
			$employees   = $this->dbcustom->employeesInfo($condition[0]);
			$empbranch   = str_pad($employees['data'][0]['BranchCode'], 3, '0', STR_PAD_LEFT);
			$emp_area    = $employees['data'][0]['AreaCode'];
			$emp_region  = $employees['data'][0]['RegionID'];
		
			$where_auth = '';
			switch($privileges) {
				case $this->role_ad:
		
					if($empbranch == "000" || $empbranch == "901"):
						$where_auth = '';
					else:
						$where_auth = ", @BrnCode = '".$empbranch."'";
					endif;
		
					break;
				case $this->role_rm:
					$where_auth	= ", @RMCode = '".$condition[0]."'";
		
					break;
				case $this->role_bm:
					$where_auth = ", @BrnCode = '".$empbranch."'";
		
					break;
				case $this->role_am:
					$where_auth = ", @AreaCode = '".$emp_area."'";
		
					break;
				case $this->role_rd:
					$where_auth = ", @Region = '".$emp_region."'";
		
					break;
		
				case $this->role_hq:
				case $this->role_spv:
				case $this->role_ads:
					$where_auth = '';
					break;
		
			}
	
			$wheres .= "@Ordering = '".$Ordering."', @Start = '".$start."', @Offset = '".$offset."' $join_date $tla_code $tla_name $tla_branch $tla_position $tla_status $lb_region_id $lb_branchcode $employee_find $has_drawdown $has_a2ca $has_ncb $where_auth";
		
			try {
					
				$result = $this->dbstore->exec_getTLAVolumeSummary($wheres);
				return $result;
			
					
			} catch(Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
						
		}

	}
	
	public function exec_getTLAVolumePagination($authority, $condition = array()) {
		$this->load->model('dbstore');
		$this->load->model('dbcustom');
		$this->load->library('effective');
		
		$wheres	 		= '';
		$join_date 		= '';
		$tla_code		= '';
		$tla_name		= '';
		$tla_branch		= '';
		$tla_position	= '';
		$tla_status		= '';
		
		$lb_region_id	= '';
		$lb_branchcode	= '';
		$employee_find	= '';
		$has_drawdown	= '';
		$has_a2ca		= '';
		$has_ncb		= '';
		
		$filter_type	= $this->input->post('filter_type');
		$start_date		= $this->input->post('start_date');
		$end_date 		= $this->input->post('end_date');
		
		$tl_code 		= $this->input->post('tl_code');
		$tl_name 		= $this->input->post('tl_name');
		$tl_branch 		= $this->input->post('tl_branch');
		$tl_position 	= $this->input->post('tl_position');
		
		$tl_status		= $this->input->post('tl_status');		
		$tl_state_main  = $this->input->post('tl_state_main');
		$drawdown_check	= $this->input->post('drawdown_check');
		$a2ca_check		= $this->input->post('a2ca_check');
		$ncb_check		= $this->input->post('ncb_check');
		
		$lb_region 		= $this->input->post('lb_region');
		$lb_branch 		= $this->input->post('lb_branch');
		$lb_emp			= $this->input->post('lb_emp');
		
		$iStart  = $this->input->post('start');
		$iLength = $this->input->post('length') ? $iLength = $this->input->post('length') : 10;
		
		if(!empty($tl_state_main[0]) && !empty($tl_status[0])):
		$status_object  = array_merge($tl_state_main, $tl_status);
			
		else:
			
		if(!empty($tl_state_main[0])):
		$status_object	= $tl_state_main;
		endif;
		
		if(!empty($tl_status[0])):
		$status_object  = $tl_status;
		endif;
			
		endif;
		
		// Condition
		if(!empty($tl_code)) { $tla_code = ", @TL_Code = '".$tl_code."'"; }
		if(!empty($tl_name)) { $tla_name = ", @TL_Name = '".$this->effective->set_chartypes($this->char_mode, $tl_name)."'"; }
		
		$conv_startdate  = !empty($start_date) ? $this->effective->StandartDateSorter($start_date):"";
		$conv_enddate	 = !empty($end_date) ? $this->effective->StandartDateSorter($end_date):"";
		
		if($filter_type == 'DrawdownDate') {
			
			if(!empty($conv_startdate) && !empty($end_date)) {
				$join_date = ", @DDStart = '".$conv_startdate."', @DDEnd = '".$conv_enddate."'";
				
			} else {
							
				if(!empty($conv_startdate)) $join_date = ", @DDStart = '".$conv_startdate."', @DDEnd = '".$conv_startdate."' ";		
				if(!empty($conv_enddate)) $join_date   = ", @DDStart = '".$conv_enddate."', @DDEnd = '".$conv_enddate."'";
		
			}
			
		} else {
			
			if(!empty($conv_startdate) && !empty($end_date)):
				$join_date = ", @JoinStart = '".$conv_startdate."', @JoinEnd = '".$conv_enddate."'";
			else:
				if(!empty($conv_startdate)) $join_date .= ", @JoinStart =  '".$conv_startdate."'";
				if(!empty($conv_enddate)) $join_date .= ", @JoinEnd = '".$conv_enddate."'";
			endif;

		}
		
		/*
		if(!empty($tl_state_main[0])):
			$tla_status   	= ", @Status = '".implode(',', $tl_state_main)."'";
		endif;
		*/
	
		if(!empty($status_object[0])) { $tla_status .= ", @Status = '".implode(',', $status_object)."'"; }
		
		if(!empty($lb_emp[0])):
			$employee_find  = ", @LB_Emp = '".implode(',', $lb_emp)."'";
		endif;
		
		if(!empty($tl_position[0])):
			$tla_position   = ", @TL_Position = '".$this->effective->set_chartypes($this->char_mode, implode(',', $tl_position))."'";
		endif;
		
		if(!empty($tl_branch[0])):
			$tla_branch   	= ", @TL_Branch = '".$this->effective->set_chartypes($this->char_mode, implode(',', $tl_branch))."'";
		endif;
		
		if(!empty($lb_branch[0])):
			$lb_branchcode  = ", @LB_Branch = '".implode(',', $lb_branch)."'";
		endif;

		if(!empty($lb_region)) $lb_region_id .= ", @LB_Region = '".$lb_region."'";
		if(!empty($drawdown_check)) $has_drawdown .= ", @hasDrawdown = '".$drawdown_check."'";
		if(!empty($a2ca_check)) $has_a2ca .= ", @hasA2CA = '".$a2ca_check."'";
		if(!empty($ncb_check)) $has_ncb .= ", @hasNCB = '".$ncb_check."'";
				
		$Ordering = $this->get_ordering();
		
		if(empty($authority)) {
			log_message('error', 'method '.__METHOD__ .'can not load data. Please you are check object criteria in parameter.');
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
		
		} else {
		
			if(count($authority) > 1) :
				$privileges = $authority[0];
			else:
				$privileges = $authority[0];
			endif;
		
			$employees   = $this->dbcustom->employeesInfo($condition[0]);
			$empbranch   = str_pad($employees['data'][0]['BranchCode'], 3, '0', STR_PAD_LEFT);
			$emp_area    = $employees['data'][0]['AreaCode'];
			$emp_region  = $employees['data'][0]['RegionID'];
		
			$where_auth = '';
			switch($privileges) {
				case $this->role_ad:
		
					if($empbranch == "000" || $empbranch == "901"):
					$where_auth = '';
					else:
					$where_auth = ", @BrnCode = '".$empbranch."'";
					endif;
		
					break;
				case $this->role_rm:
					$where_auth	= ", @RMCode = '".$condition[0]."'";
		
					break;
				case $this->role_bm:
					$where_auth = ", @BrnCode = '".$empbranch."'";
		
					break;
				case $this->role_am:
					$where_auth = ", @AreaCode = '".$emp_area."'";
		
					break;
				case $this->role_rd:
					$where_auth = ", @Region = '".$emp_region."'";
		
					break;
		
				case $this->role_hq:
				case $this->role_spv:
				case $this->role_ads:
					$where_auth = '';
					break;
		
			}
		
			$wheres .= "@Ordering = '".$Ordering."' $join_date $tla_code $tla_name $tla_branch $tla_position $tla_status $lb_region_id $lb_branchcode $employee_find $has_drawdown $has_a2ca $has_ncb $where_auth";
					
			try {
				
				$result = $this->dbstore->exec_getTLAVolumePagination($wheres);
				return $result;

			} catch(Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
	
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