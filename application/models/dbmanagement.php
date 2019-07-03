<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dbmanagement extends CI_Model {
	
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
	
	// DEFEND LIST
	public function getNumDefendNote($doc_id) {
		
		/*
		$result = $this->db->query("
			SELECT DocID, COUNT(DocID) AS DefendNum
			FROM DefendHead
			WHERE DocID = '".$doc_id."'
			AND IsActive = 'A'
			GROUP BY DocID
		");
		*/
		
		$result = $this->db->query("
			SELECT DocID, COUNT(DocID) AS DefendNum
			FROM New_DefendHead
			WHERE DocID = '".$doc_id."'
			AND IsActive = 'A'
			GROUP BY DocID
		");
		
		return $result->result_array();
		
	}
	
	public function getEmployeeRelation($position, $condition = array()) {
		
		switch ($position) {
			case 'RD':
				$where = "WHERE (PositionTitle LIKE '%Regional%') AND (RegionID = '".$condition[0]."') AND (IsActive = 'A')";
				break;
			case 'AM':
				$where = "WHERE (PositionTitle LIKE '%Area Manager%') AND (AreaBoundary.BranchCode = '".$condition[1]."') AND (AreaBoundary.IsActive = 'A')";
				break;
			case 'BM':
				$where = "WHERE (PositionTitle LIKE '%Branch Manager%') AND (BranchCode = '".$condition[1]."') AND (IsActive = 'A')";
				break;
					
		}
		
		switch ($position) {
			
			case 'RD':
			case 'BM':
				
				$result = $this->db->query("
					SELECT EmployeeCode, FullNameEng, FullNameTh, PositionTitle, RegionID, BranchCode, Mobile, IsActive, Email  
					FROM [dbo].[LendingEmp]
					$where
					ORDER BY StartWorkDate DESC");
				
				break;
			case 'AM':

				$result = $this->db->query("		
					SELECT
						LendingEmp.EmployeeCode, LendingEmp.FullNameEng, LendingEmp.FullNameTh, LendingEmp.PositionTitle,
						AreaBoundary.RegionID, AreaBoundary.BranchCode,  LendingEmp.Mobile,  LendingEmp.IsActive,  LendingEmp.Email
					FROM [dbo].[AreaBoundary]
					LEFT OUTER JOIN [dbo].[LendingEmp]
					ON AreaBoundary.EmployeeCode = LendingEmp.EmployeeCode		
					$where
					ORDER BY StartWorkDate DESC");
				
				break;
			
		}
		
		return $result->result_array();
		
	}
	
	public function getActorInfo($doc_id, $list_lot) {
		$this->load->library('effective');
		
		$results   = $this->dbmodel->CIQuery("
			SELECT DefendHead.DocID, DefendHead.DefendEmpID, DefendHead.DefendEmpName, LendingEmp.Mobile, AssignmentBy,
			CONVERT(NVARCHAR(10), AssignmentDate, 120) AS AssignmentDate, DefendHead.IsActive
			FROM DefendHead
			LEFT OUTER JOIN LendingEmp 
			ON DefendHead.DefendEmpID = LendingEmp.EmployeeCode
			WHERE DocID = '".$doc_id."'
			AND DefendRef =  '".$list_lot."'
			AND DefendHead.IsActive  = 'A'
         ");
		
		$conv['data'] = array();
		foreach($results['data'] as $index => $values) {
		
			array_push($conv['data'], array(
					"DocID"				=> $results['data'][$index]['DocID'],
					"DefendEmpID"		=> $results['data'][$index]['DefendEmpID'],
					"DefendEmpName"  	=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['DefendEmpName']),
					"AssignmentDate"	=> !empty($results['data'][$index]['AssignmentDate']) ? $this->effective->StandartDateRollback($results['data'][$index]['AssignmentDate']):'',
					"Mobile"			=> $results['data'][$index]['Mobile']
				)
			);
		
		}
		
		return $conv;
		
	}
	
	public function getDefendItemList($doc_id, $list_lot) {
		$this->load->library('effective');
		
		$results   = $this->dbmodel->CIQuery("
                          	SELECT DefendSubscription.DFS_ID, DefendSubscription.DocID, 
							DefendSubscription.DefendRef, DefendSubscription.DefendCode, 
							DefendSubscription.DefendNote, MasterDefendReason.DefendReason, DefendSubscription.DefendOther,
							MasterDefendReason.DefendType, DefendSubscription.IsActive, DefendSubscription.CreateBy, 
							CASE DefendSubscription.CreateDate
								WHEN '1900-01-01' THEN NULL
								ELSE CONVERT(nvarchar(10), DefendSubscription.CreateDate, 120)
							END AS CreateDate, RIGHT(CONVERT(VARCHAR(20), CreateDate, 113), 8) AS CreateTime,
							DefendSubscription.UpdateBy,
							CASE DefendSubscription.UpdateDate
								WHEN '1900-01-01' THEN NULL
								ELSE CONVERT(nvarchar(10), DefendSubscription.UpdateDate, 120)
							END AS UpdateDate, RIGHT(CONVERT(VARCHAR(20), UpdateDate,113), 8) AS UpdateTime
							FROM DefendSubscription 
							LEFT OUTER JOIN  MasterDefendReason 
							ON DefendSubscription.DefendCode = MasterDefendReason.DefendCode
						    WHERE DocID = '".$doc_id."'
                            AND DefendRef =  '".$list_lot."'
                            AND DefendSubscription.IsActive  = 'A'");
		
		$conv['data'] = array();
		foreach($results['data'] as $index => $values) {
		
			array_push($conv['data'], array(
					"DFS_ID"		=> $results['data'][$index]['DFS_ID'],
					"DocID"			=> $results['data'][$index]['DocID'],
					"DefendRef"		=> $results['data'][$index]['DefendRef'],
					"DefendCode"	=> $results['data'][$index]['DefendCode'],
					"DefendReason"	=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['DefendReason']),
					"DefendOther"	=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['DefendOther']),
					"DefendNote"	=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['DefendNote']),
					"DefendType"	=> $results['data'][$index]['DefendType'],
					"IsActive"  	=> $results['data'][$index]['IsActive'],
					"CreateBy"		=> $results['data'][$index]['CreateBy'],
					"CreateDate"	=> $this->effective->StandartDateRollback($results['data'][$index]['CreateDate']),
					"CreateTime"	=> !empty($results['data'][$index]['CreateTime']) ? $results['data'][$index]['CreateTime']:'',
					"UpdateBy"		=> $results['data'][$index]['UpdateBy'],
					"UpdateDate"	=> $this->effective->StandartDateRollback($results['data'][$index]['UpdateDate']),
					"UpdateTime"	=> !empty($results['data'][$index]['UpdateTime']) ? $results['data'][$index]['UpdateTime']:''
				)
			);
		
		}
		
		return $conv;
		
	}
	
	public function getDefenListLogs($doc_id, $list_lot) {		
		$this->load->library('effective');
		
		$results   = $this->dbmodel->CIQuery("
			SELECT * FROM (
                SELECT  DefendSubscriptionLogs.DFS_ID, DefendSubscriptionLogs.DocID, DefendSubscriptionLogs.DefendRef, DefendSubscriptionLogs.DefendCode,
				MasterDefendReason.DefendReason, MasterDefendReason.DefendType, DefendSubscriptionLogs.DefendNote, 
				DefendSubscriptionLogs.IsActive, DefendSubscriptionLogs.ActorBy, DefendSubscriptionLogs.ActorName, 
				CASE DefendSubscriptionLogs.ActorDate
					WHEN '1900-01-01' THEN NULL
					ELSE CONVERT(nvarchar(10), DefendSubscriptionLogs.ActorDate, 120)
				END AS ActorDate, ROW_NUMBER() OVER (ORDER BY DefendSubscriptionLogs.ActorDate DESC) as KeyPoint
				FROM DefendSubscriptionLogs
				LEFT OUTER JOIN  MasterDefendReason 
				ON DefendSubscriptionLogs.DefendCode = MasterDefendReason.DefendCode
				WHERE DefendSubscriptionLogs.DocID = '".$doc_id."'
				AND DefendSubscriptionLogs.DefendRef =  '".$list_lot."'
				AND DefendSubscriptionLogs.IsActive  = 'A'
			) A
			WHERE KeyPoint > '0' AND KeyPoint <= '30'");
		
		$conv['data'] = array();
		foreach($results['data'] as $index => $values) {
		
			array_push($conv['data'], array(
					"DocID"			=> $results['data'][$index]['DocID'],
					"DefendRef"		=> $results['data'][$index]['DefendRef'],
					"DefendCode"	=> $results['data'][$index]['DefendCode'],
					"DefendReason"	=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['DefendReason']),
					"DefendNote"	=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['DefendNote']),
					"DefendType"	=> $results['data'][$index]['DefendType'],
					"IsActive"  	=> $results['data'][$index]['IsActive'],
					"ActorBy"		=> $results['data'][$index]['ActorBy'],
					"ActorName"		=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['ActorName']),
					"ActorDate"		=> $this->effective->StandartDateRollback($results['data'][$index]['ActorDate'])
			)
			);
		
		}
		
		return $conv;
		
		
	}
	
	public function getDefendListHelper($doc_id) {
		$this->load->model('dbmodel');
		
		$result = $this->dbmodel->loadData('DefendHead', 'DISTINCT DocID, DefendRef', array('DocID' => $doc_id, 'IsActive' => 'A'), false);
		return $result;
		
		
	}
	
	// NCB Consent: Document Management
	public function getDataNCBConsentPagination($authority, $condition = array()) {
		$this->load->model('dbcustom');
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$startdate           		= $this->input->post('ncb_start');
		$enddate            	    = $this->input->post('ncb_end');
		$hqstartdate           		= $this->input->post('hq_start');
		$hqenddate            	    = $this->input->post('hq_end');
		$customers					= $this->input->post('customer');
		$rmname						= $this->input->post('rmname');
		$region						= $this->input->post('regions');
		$branchs					= $this->input->post('branchs');
		$views						= $this->input->post('views');
		
		$ncbdate_start  			= !empty($startdate) ? $this->effective->StandartDateSorter($startdate):"";
		$ncbdate_end	   			= !empty($enddate) ? $this->effective->StandartDateSorter($enddate):"";
		$hqdate_start  				= !empty($hqstartdate) ? $this->effective->StandartDateSorter($hqstartdate):"";
		$hqdate_end	   				= !empty($hqenddate) ? $this->effective->StandartDateSorter($hqenddate):"";
		
		$pieces = explode(',', $branchs);
		if(!empty($pieces[0])):
			$where_brachs 	= "'".implode("','", $pieces)."'";
		else:
			$where_brachs   = "";
		endif;
		
		$rmlist_pieces = explode(',', $rmname);
		if(!empty($rmlist_pieces[0])):
			$wheres_rmlist   = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $rmlist_pieces)."'");
		else:
			$wheres_rmlist   = "";
		endif;
		
		$wheres						= "";
		$where_option				= "";
		$where_filter				= "";
		
		if(!empty($ncbdate_start) && !empty($ncbdate_end)) { $where_filter .= " AND CONVERT(nvarchar(10), NCBCheckDate, 120) BETWEEN '".$ncbdate_start."' AND '".$ncbdate_end."'"; }
		else {
		
			if(!empty($ncbdate_start)) { $where_filter .= " AND CONVERT(nvarchar(10), NCBCheckDate, 120)  = '".$ncbdate_start."'"; }
			if(!empty($ncbdate_end)) { $where_filter .= " AND CONVERT(nvarchar(10), NCBCheckDate, 120)  = '".$ncbdate_end."'"; }
		
		}
		
		if(!empty($hqdate_start) && !empty($hqdate_end)) { $where_filter .= " AND CONVERT(nvarchar(10), HQReceivedFromLB, 120) BETWEEN '".$hqdate_start."' AND '".$hqdate_end."'"; }
		else {
		
			if(!empty($hqdate_start)) { $where_filter .= " AND CONVERT(nvarchar(10), HQReceivedFromLB, 120)  = '".$hqdate_start."'"; }
			if(!empty($hqdate_end)) { $where_filter .= " AND CONVERT(nvarchar(10), HQReceivedFromLB, 120)  = '".$hqdate_end."'"; }
		
		}
		
		
		// Optional Query
		if(!empty($customers)) {
			$where_filter .= " AND BorrowerName LIKE '%".$this->effective->set_chartypes($this->char_mode, $customers)."%'";
		}
		
		if(!empty($region)) { $where_filter .= " AND RegionID = '".trim(str_pad($region, 2, "0", STR_PAD_LEFT))."'"; }
		if(!empty($branchs[0])) { $where_filter .= " AND BranchDigit in ($where_brachs) "; }
		if(!empty($rmlist_pieces[0])) { $where_filter .= " AND RMCode in ($wheres_rmlist) "; }
				
		if($views == "Active"): $where_filter .= " AND ActiveRecord = '".$views."'"; endif;
		if($views == "InActive"): $where_filter .= " AND ActiveRecord = '".$views."'"; endif;
		
		if($views == "Active" && empty($ncbdate_start) && empty($ncbdate_end)) {
			$where_option = " AND NOT NCBCheckDate BETWEEN '1900-01-01' AND '2014-12-31'";
		}
		
		if($views == 'All' && empty($ncbdate_start) && empty($ncbdate_end) && empty($customers)) {
			$where_option = " AND NOT NCBCheckDate BETWEEN '1900-01-01' AND '2014-12-31'";
			
			$previos = trim(substr(date('Y-m-d', strtotime('-3 MONTH')), 0, 8).'01');
			$current = trim(date('Y-m-').date('t', strtotime(date("Y-m-d"))));
			$where_option = " AND NCBCheckDate BETWEEN '".$previos."' AND '".$current."'";
		}
		
		$iStart  = $this->input->post('start');
		$iLength = $this->input->post('length') ? $iLength = $this->input->post('length') : 10;
		
		$start	 = ($iStart)? $iStart : 0;
		$offset  = $iLength + $start;
		
		if(empty($authority)) {
		
			$objForms = array(
					"Privileges" => $authority,
					"Condition"	 => $condition,
					"Optional"	 => $optional
			);
		
			log_message('error', 'method '.__METHOD__ .'can not load data. Please you are check object criteria in parameter.');
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
		
		} else {
		
			if(count($authority) > 1) :
				$privileges = $authority[0];
			else:
				$privileges = $authority[0];
			endif;
		
			$employees = $this->dbcustom->employeesInfo($condition[0]);
			$empbranch = str_pad($employees['data'][0]['BranchCode'], 3, "0", STR_PAD_LEFT);
			
			switch($privileges) {
				case $this->role_ad:
			
					if($empbranch == "000" || $empbranch == "901"):
						$wheres = '';
					else:
						$wheres = " AND BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'";
					endif;
			
					break;
				case $this->role_rm:
					$wheres	= " AND RMCode = '".$condition[0]."'";
			
					break;
				case $this->role_bm:
					$wheres = " AND BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'";
			
					break;
				case $this->role_am:
					$wheres = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$condition[0]."' GROUP BY BranchCode)";
			
					break;
				case $this->role_rd:
					$wheres = " AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)";
			
					break;
				
				case $this->role_hq:
				case $this->role_spv:
					$wheres = '';
					break;
				case $this->role_ads:
					$wheres = '';
					break;
			
			}
			
			
			try {

				// AND NOT SubmitToHQ IS NULL
				$result = $this->db->query("
						SELECT * FROM (
							SELECT *, ROW_NUMBER() OVER (ORDER BY NCBCheckDate ASC) as KeyPoint FROM (
							SELECT NCS_ID, NCBConsent.DocID, NCBConsent.VerifyID, [Profile].OwnerName, [Profile].Mobile, LendingBranchs.RegionID,
							[Profile].BranchCode, LendingBranchs.BranchDigit, [Profile].RMCode, [Profile].RMName,
							[Profile].RMMobile, NCBConsent.BorrowerType, NCBConsent.BorrowerName, NCBConsent.NCBCheck,
							NCBConsent.NCBCheckDate, NCBConsent.SubmitToHQ, NCBConsent.HQReceivedFromLB, NCBConsent.HQSubmitToOper,
							NCBConsent.OperReturn, NCBConsent.OperReturnDate, NCBConsent.IsActive, NCBConsent.IsRef,
							CASE
								WHEN NOT NCBConsent.SubmitToHQ IS NULL AND NOT NCBConsent.HQReceivedFromLB IS NULL AND NOT NCBConsent.HQSubmitToOper IS NULL THEN 'InActive'
								WHEN NOT NCBConsent.SubmitToHQ IS NULL AND NOT NCBConsent.HQReceivedFromLB IS NULL AND NOT NCBConsent.HQSubmitToOper IS NULL AND NOT NCBConsent.OperReturnDate IS NULL THEN 'InActive'
								ELSE 'Active'
							END AS ActiveRecord, [Profile].CreateDate 
							FROM NCBConsent
							LEFT OUTER JOIN [Profile]
							ON NCBConsent.DocID = [Profile].DocID
							LEFT OUTER JOIN LendingBranchs
							ON [Profile].BranchCode = LendingBranchs.BranchCode
							WHERE NOT [Profile].CreateDate IS NULL
							AND [Profile].IsEnabled = 'A'
							AND NCBConsent.IsActive = 'A'
						) A
						WHERE NOT NCBCheckDate IS NULL
						$where_option
						$wheres
						$where_filter
				) Data");
					
				return $result->num_rows();
					
			} catch(Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			
			}
			
			
		}
		
	}
	
	public function getDataNCBConsent($authority, $condition = array()) {
		$this->load->model('dbcustom');
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		$startdate           		= $this->input->post('ncb_start');
		$enddate            	    = $this->input->post('ncb_end');
		$hqstartdate           		= $this->input->post('hq_start');
		$hqenddate            	    = $this->input->post('hq_end');
		$customers					= $this->input->post('customer');
		$rmname						= $this->input->post('rmname');
		$region						= $this->input->post('regions');
		$branchs					= $this->input->post('branchs');
		$views						= $this->input->post('views');
	
		$ncbdate_start  			= !empty($startdate) ? $this->effective->StandartDateSorter($startdate):"";
		$ncbdate_end	   			= !empty($enddate) ? $this->effective->StandartDateSorter($enddate):"";
		$hqdate_start  				= !empty($hqstartdate) ? $this->effective->StandartDateSorter($hqstartdate):"";
		$hqdate_end	   				= !empty($hqenddate) ? $this->effective->StandartDateSorter($hqenddate):"";
			
		$wheres						= "";
		$where_option				= "";
		$where_filter				= "";
			
		$pieces = explode(',', $branchs);
		if(!empty($pieces[0])):
			$where_brachs 	= "'".implode("','", $pieces)."'";
		else:
			$where_brachs   = "";
		endif;	
		
		$rmlist_pieces = explode(',', $rmname);
		if(!empty($rmlist_pieces[0])):
			$wheres_rmlist   = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $rmlist_pieces)."'");
		else:
			$wheres_rmlist   = "";
		endif;
	
		if(!empty($ncbdate_start) && !empty($ncbdate_end)) { $where_filter .= " AND CONVERT(nvarchar(10), NCBCheckDate, 120) BETWEEN '".$ncbdate_start."' AND '".$ncbdate_end."'"; }
		else {
	
			if(!empty($ncbdate_start)) { $where_filter .= " AND CONVERT(nvarchar(10), NCBCheckDate, 120)  = '".$ncbdate_start."'"; }
			if(!empty($ncbdate_end)) { $where_filter .= " AND CONVERT(nvarchar(10), NCBCheckDate, 120)  = '".$ncbdate_end."'"; }
	
		}
		
		if(!empty($hqdate_start) && !empty($hqdate_end)) { $where_filter .= " AND CONVERT(nvarchar(10), HQReceivedFromLB, 120) BETWEEN '".$hqdate_start."' AND '".$hqdate_end."'"; }
		else {
		
			if(!empty($hqdate_start)) { $where_filter .= " AND CONVERT(nvarchar(10), HQReceivedFromLB, 120)  = '".$hqdate_start."'"; }
			if(!empty($hqdate_end)) { $where_filter .= " AND CONVERT(nvarchar(10), HQReceivedFromLB, 120)  = '".$hqdate_end."'"; }
		
		}
	
		// Optional Query
		if(!empty($customers)) {
			$where_filter .= " AND BorrowerName LIKE '%".$this->effective->set_chartypes($this->char_mode, $customers)."%'";
		}
	
		if(!empty($region)) { $where_filter .= " AND RegionID = '".trim(str_pad($region, 2, "0", STR_PAD_LEFT))."'"; }
		if(!empty($branchs[0])) { $where_filter .= " AND BranchDigit in ($where_brachs) "; }
		if(!empty($rmlist_pieces[0])) { $where_filter .= " AND RMCode in ($wheres_rmlist) "; }
	
		if($views == "Active"): $where_filter .= " AND ActiveRecord = '".$views."'"; endif;
		if($views == "InActive"): $where_filter .= " AND ActiveRecord = '".$views."'"; endif;
		
		if($views == "Active" && empty($ncbdate_start) && empty($ncbdate_end)) {
			$where_option = " AND NOT NCBCheckDate BETWEEN '1900-01-01' AND '2014-12-31'";
		}
		
		if($views == 'All' && empty($ncbdate_start) && empty($ncbdate_end) && empty($customers)) {
			$where_option = " AND NOT NCBCheckDate BETWEEN '1900-01-01' AND '2014-12-31'";
			
			$previos = trim(substr(date('Y-m-d', strtotime('-3 MONTH')), 0, 8).'01');
			$current = trim(date('Y-m-').date('t', strtotime(date("Y-m-d"))));
			$where_option = " AND NCBCheckDate BETWEEN '".$previos."' AND '".$current."'";
		}
		
			
		
		$iStart  = $this->input->post('start');
		$iLength = $this->input->post('length') ? $iLength = $this->input->post('length') : 10;
	
		$start	 = ($iStart)? $iStart : 0;
		$offset  = $iLength + $start;
		
		$Ordering = $this->get_ordering();
	
		if(empty($authority)) {
	
			$objForms = array(
				"Privileges" => $authority,
				"Condition"	 => $condition,
				"Optional"	 => $optional
			);
	
			log_message('error', 'method '.__METHOD__ .'can not load data. Please you are check object criteria in parameter.');
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
	
		} else {
	
			if(count($authority) > 1) :
			$privileges = $authority[0];
			else:
			$privileges = $authority[0];
			endif;
	
			$employees = $this->dbcustom->employeesInfo($condition[0]);
			$empbranch = str_pad($employees['data'][0]['BranchCode'], 3, "0", STR_PAD_LEFT);			
			
			switch($privileges) {
				case $this->role_ad:
						
					if($empbranch == "000" || $empbranch == "901"):
					$wheres = '';
					else:
					$wheres = " AND BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'";
					endif;
						
					break;
				case $this->role_rm:
					$wheres	= " AND RMCode = '".$condition[0]."'";
						
					break;
				case $this->role_bm:
					$wheres = " AND BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'";
						
					break;
				case $this->role_am:
					$wheres = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$condition[0]."' GROUP BY BranchCode)";
						
					break;
				case $this->role_rd:
					$wheres = " AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)";
						
					break;
			
				case $this->role_hq:
				case $this->role_spv:
					$wheres = '';
					break;
				case $this->role_ads:
					$wheres = '';
					break;
						
			}
			
			try {
					
				//AND NOT SubmitToHQ IS NULL
				$result = $this->dbmodel->CIQuery("
					SELECT * FROM (
						SELECT *, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint FROM (
						SELECT NCS_ID, NCBConsent.DocID, NCBConsent.VerifyID, [Profile].OwnerName, [Profile].Mobile, LendingBranchs.RegionID,
						LendingBranchs.BranchCode, LendingBranchs.BranchDigit, [Profile].RMCode, [Profile].RMName,
						[Profile].RMMobile, NCBConsent.BorrowerType, NCBConsent.BorrowerName, NCBConsent.NCBCheck,
						CASE NCBConsent.NCBCheckDate
							WHEN '1900-01-01' THEN NULL
							WHEN '' THEN NULL
							ELSE CONVERT(nvarchar(10), NCBConsent.NCBCheckDate, 120)
						END AS NCBCheckDate, NCBCheckDateLog, ReCheck, ReturnDateLog,
						CASE NCBConsent.SubmitToHQ
							WHEN '1900-01-01' THEN NULL
							WHEN '' THEN NULL
							ELSE CONVERT(nvarchar(10), NCBConsent.SubmitToHQ, 120)
						END AS SubmitToHQ,
						CASE NCBConsent.HQReceivedFromLB
						WHEN '1900-01-01' THEN NULL
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), NCBConsent.HQReceivedFromLB, 120)
						END AS HQReceivedFromLB,
						CASE NCBConsent.HQSubmitToOper
							WHEN '1900-01-01' THEN NULL
							WHEN '' THEN NULL
						ELSE CONVERT(nvarchar(10), NCBConsent.HQSubmitToOper, 120)
						END AS HQSubmitToOper,NCBConsent.OperReturn,
						CASE NCBConsent.OperReturnDate
							WHEN '1900-01-01' THEN NULL
							WHEN '' THEN NULL
							ELSE CONVERT(nvarchar(10), NCBConsent.OperReturnDate, 120)
						END AS OperReturnDate, NCBConsent.IsActive, NCBConsent.IsRef,
						CASE
							WHEN NOT NCBConsent.SubmitToHQ IS NULL AND NOT NCBConsent.HQReceivedFromLB IS NULL AND NOT NCBConsent.HQSubmitToOper IS NULL THEN 'InActive'
							WHEN NOT NCBConsent.SubmitToHQ IS NULL AND NOT NCBConsent.HQReceivedFromLB IS NULL AND NOT NCBConsent.HQSubmitToOper IS NULL AND NOT NCBConsent.OperReturnDate IS NULL THEN 'InActive'
							ELSE 'Active'
						END AS ActiveRecord, 
						CONVERT(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate
						FROM NCBConsent
						LEFT OUTER JOIN [Profile]
						ON NCBConsent.DocID = [Profile].DocID
						LEFT OUTER JOIN LendingBranchs
						ON [Profile].BranchCode = LendingBranchs.BranchCode
						LEFT OUTER JOIN (
							SELECT * FROM (
							SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY NCBCheckDate, VerifyID, BorrowerType) as Numindex,
							VerifyID AS VF, BorrowerType, BorrowerName,
							CASE NCBCheckDate
								WHEN '1900-01-01' THEN NULL
								WHEN '' THEN NULL
								ELSE CONVERT(nvarchar(10), NCBCheckDate, 120)
							END AS NCBCheckDateLog
							FROM dbo.NCBConsentLogs) Tmp
							WHERE Numindex = 1
						) NCBConsentLogs
						ON NCBConsentLogs.VF = NCBConsent.VerifyID
						AND NCBConsentLogs.BorrowerType = NCBConsent.BorrowerType
						LEFT OUTER JOIN (
							SELECT * FROM (
							SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,VerifyID ORDER BY OperReturnDate DESC, VerifyID, BorrowerType) as Numindex,
							VerifyID AS VFL, BorrowerType, BorrowerName, OperReturn AS ReCheck,
							CASE OperReturnDate
								WHEN '1900-01-01' THEN NULL
								WHEN '' THEN NULL
								ELSE CONVERT(nvarchar(10), OperReturnDate, 120)
							END AS ReturnDateLog
							FROM dbo.NCBConsentLogs) Tmp
							WHERE Numindex = 1					
						) NCBConsentRetrunLogs
						ON NCBConsentRetrunLogs.VFL = NCBConsent.VerifyID
						AND NCBConsentRetrunLogs.BorrowerType = NCBConsent.BorrowerType
						WHERE NOT NCBConsent.NCBCheckDate IS NULL
						AND NCBConsent.IsActive = 'A'
						AND [Profile].IsEnabled = 'A'
						AND NOT [Profile].CreateDate IS NULL 
					) A
					WHERE NOT NCBCheckDate IS NULL
					$wheres
					$where_option
					$where_filter
				) Data
				WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
					
				return $result;
					
					
			} catch(Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
					
			}
							
		}
	
	}
	
	public static function fnDocRouter($mode) {
		if(empty($mode)) :
			throw new Exception('Error handled, Please you are check argusment.');
	
		else:
		 
			switch ($mode) {
				 
				case 'r2cx': return 'reconcile'; break;
				case 'm2cx': return 'missing'; break;
				case 'r2cl': return 'returndoc'; break;
				case 'd2cr': return 'careturn'; break;
				case 'a2lx': return 'allviews'; break;
				 
			}
		 
		endif;
		 
	}	
	
	// Reconcile Application: Document Management
	public function loadAppManagement($position, $authority, $condition = array()) {
		$this->load->model('dbmodel');
		$this->load->model('dbcustom');
		$this->load->library('effective');
		
		$where_special	 = '';
		$where_condition = " AND NOT ReconcileDoc.BorrowerType = '104'";
		$where_filter	 = '';
		
		$event_mode		 = $this->input->post('slmode');
		$views			 = $this->input->post('aciverecord');
		$rmname			 = $this->input->post('rmname');
		$customers		 = $this->input->post('ownerName');
		$region		 	 = $this->input->post('regionid');
		$branchs		 = $this->input->post('branchdigit');
	
		$rec_date_from   = $this->input->post('recdate_from');
		$rec_date_to     = $this->input->post('recdate_to');
		
		$miss_date_from  = $this->input->post('missdate_from');
		$miss_date_to    = $this->input->post('missdate_to');
		
		$returndate_from = $this->input->post('returndate_from');
		$returndate_to   = $this->input->post('returndate_to');
		
		$careturn_from 	 = $this->input->post('careturndate_from');
		$careturn_to   	 = $this->input->post('careturndate_to');
		
		$ddflag_doc		 = $this->input->post('ddflag');
		
		$conv_recondate_1  = !empty($rec_date_from) ? $this->effective->StandartDateSorter($rec_date_from):"";
		$conv_recondate_2  = !empty($rec_date_to) ? $this->effective->StandartDateSorter($rec_date_to):"";
		
		$conv_missdate_1   = !empty($miss_date_from) ? $this->effective->StandartDateSorter($miss_date_from):"";
		$conv_missdate_2   = !empty($miss_date_to) ? $this->effective->StandartDateSorter($miss_date_to):"";
		
		$conv_returndoc_1  = !empty($returndate_from) ? $this->effective->StandartDateSorter($returndate_from):"";
		$conv_returndoc_2  = !empty($returndate_to) ? $this->effective->StandartDateSorter($returndate_to):"";
		
		$conv_careturn_1  = !empty($careturn_from) ? $this->effective->StandartDateSorter($careturn_from):"";
		$conv_careturn_2  = !empty($careturn_to) ? $this->effective->StandartDateSorter($careturn_to):"";
		
		$iStart  = $this->input->post('start');
		$iLength = $this->input->post('length') ? $iLength = $this->input->post('length') : 10;
		
		$start	 = ($iStart)? $iStart : 0;
		$offset  = $iLength + $start;
		
		$Ordering = $this->get_ordering();
		
		$pieces = explode(',', $branchs);
		if(!empty($pieces[0])):
			$where_brachs 	= "'".implode("','", $pieces)."'";
		else:
			$where_brachs   = "";
		endif;	
		
		$rmlist_pieces = explode(',', $rmname);
		if(!empty($rmlist_pieces[0])):
			$wheres_rmlist   = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $rmlist_pieces)."'");
		else:
			$wheres_rmlist   = "";
		endif;
		
		if($views == "Active"):
			$field_submit2hq = 'ReconcileDoc.SubmitDocToHQ';
			$field_app2ca 	 = 'ReconcileDoc.CompletionDate';
			$field_returndoc = 'ReturnDoc_LBSubmitToDate'; 
		endif;
		
		if($views == "InActive"):
			$field_submit2hq = 'ReconcileDoc.ReceivedDocFormLB';
			$field_app2ca 	 = 'ReconcileDoc.AppToCA';
			$field_returndoc = 'Return_BranchReceivedDate';
		endif;
		

		if($views == "All"):
			$field_submit2hq = 'ReconcileDoc.SubmitDocToHQ';
			$field_app2ca 	 = 'ReconcileDoc.AppToCA';
			$field_returndoc = 'ReturnDoc_LBSubmitToDate';
		endif;
		
		
		if(!empty($conv_recondate_1) && !empty($conv_recondate_2)) { $where_condition .= " AND $field_submit2hq BETWEEN '".$conv_recondate_1."' AND '".$conv_recondate_2."'"; }
		else {
		
			if(!empty($conv_recondate_1)) { $where_condition .= " AND $field_submit2hq = '".$conv_recondate_1."'"; }
			if(!empty($conv_recondate_2)) { $where_condition .= " AND $field_submit2hq = '".$conv_recondate_2."'"; }
		
		}
		
		if(!empty($conv_missdate_1) && !empty($conv_missdate_2)) { $where_condition .= " AND $field_submit2hq BETWEEN '".$conv_missdate_1."' AND '".$conv_missdate_2."'"; }
		else {
		
			if(!empty($conv_missdate_1)) { $where_condition .= " AND $field_submit2hq = '".$conv_missdate_1."'"; }
			if(!empty($conv_missdate_2)) { $where_condition .= " AND $field_submit2hq = '".$conv_missdate_2."'"; }
		
		}
		
		if(!empty($conv_returndoc_1) && !empty($conv_returndoc_2)) { $where_special .= " AND $field_returndoc BETWEEN '".$conv_returndoc_1."' AND '".$conv_returndoc_2."'"; }
		else {
		
			if(!empty($conv_returndoc_1)) { $where_special .= " AND $field_returndoc = '".$conv_returndoc_1."'"; }
			if(!empty($conv_returndoc_2)) { $where_special .= " AND $field_returndoc = '".$conv_returndoc_2."'"; }
		
		}
		
		if(!empty($conv_careturn_1) && !empty($conv_careturn_2)) { $where_condition .= " AND ReconcileDocLogs.CAReturnDateLog BETWEEN '".$conv_careturn_1."' AND '".$conv_careturn_2."'"; }
		else {
		
			if(!empty($conv_careturn_1)) { $where_condition .= " AND ReconcileDocLogs.CAReturnDateLog  = '".$conv_careturn_1."'"; }
			if(!empty($conv_careturn_2)) { $where_condition .= " AND ReconcileDocLogs.CAReturnDateLog  = '".$conv_careturn_2."'"; }
		
		}		
		
		if(!empty($customers)) {
			$where_filter .= " AND BorrowerName LIKE '%".$this->effective->set_chartypes($this->char_mode, $customers)."%'";
		}
		
		if(!empty($region)) { $where_filter .= " AND RegionID = '".trim(str_pad($region, 2, "0", STR_PAD_LEFT))."'"; }
		if(!empty($branchs[0])) { $where_filter .= " AND BranchDigit in ($where_brachs) "; }
		if(!empty($rmlist_pieces[0])) { $where_filter .= " AND RMCode in ($wheres_rmlist) "; }
		if($ddflag_doc == 'Y') { $where_condition .= " AND DrawdownDate IS NOT NULL"; }

		if($views == "Active"): $where_filter .= " AND ActiveRecord = '".$views."'"; endif;
		if($views == "InActive"): $where_filter .= " AND ActiveRecord = '".$views."'"; endif;
		
		$mode_handled  		 = self::fnDocRouter($event_mode);
		switch($mode_handled) {
			case 'returndoc':
				$where_filter .= ' AND ReturnTotal >= 1';
			break;
		}
			
		if(empty($authority)) {
			throw new Exception("Exception handled: The syntax issue received parameter or condition. Please your are checked arguments at using for inquiry.");
			
		} else {
			
			if(count($authority) > 1) :
			$privileges = $authority[0];
			else:
			$privileges = $authority[0];
			endif;

			$employees  = $this->dbcustom->employeesInfo($condition[0]);
			$empbranch  = str_pad($employees['data'][0]['BranchCode'], 3, '0', STR_PAD_LEFT);
			$emp_area  	= $employees['data'][0]['AreaCode'];
			$emp_region	= $employees['data'][0]['RegionID'];
			
			switch($position) {
				case 'reconcile':
					return $this->documentAppReconcileMode($authority[0], array($employees['data'][0]['EmployeeCode'], $empbranch, $views, array($start, $offset, $Ordering),  $employees['data'][0]['RegionID']), $where_filter, $where_condition);
					
				break;
				case 'missing':
					return $this->documentAppMissingMode($authority[0], array($employees['data'][0]['EmployeeCode'], $empbranch, $views, array($start, $offset, $Ordering),  $employees['data'][0]['RegionID']), $where_filter, $where_condition);
					
				break;
				case 'returndoc':
					return $this->documentAppReturnMode($authority[0], array($employees['data'][0]['EmployeeCode'], $empbranch, $views, array($start, $offset, $Ordering),  $employees['data'][0]['RegionID']), $where_filter, $where_condition, $where_special);
					
				break;
				case 'careturn':
					return $this->documentCAReturnMode($authority[0], array($employees['data'][0]['EmployeeCode'], $empbranch, $views, array($start, $offset, $Ordering),  $employees['data'][0]['RegionID']), $where_filter, $where_condition);	
				break;
				case 'allviews':
					return $this->documentAppAllMode($authority[0], array($employees['data'][0]['EmployeeCode'], $empbranch, $views, array($start, $offset, $Ordering),  $employees['data'][0]['RegionID']), $where_filter, $where_condition);				
					
				break;
				
				
			}
			
			
		}
	
	}
	
	// APP: Process Management
	private function documentAppReconcileMode($authority, $condition = array(), $criteria, $optional){
		
		$wheres  		  = "";
		$filter_condition = "AND NOT SubmitDocToHQ BETWEEN '1900-01-01'";
		$ordering		  = $condition[3][2];
		
		switch($authority) {
			case $this->role_ad:
				
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = '';
				else:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, '0', STR_PAD_LEFT)."'";
				endif;
				
			break;
			case $this->role_rm:
				$wheres	= " AND RMCode = '".$condition[0]."'";
				
			break;
			case $this->role_bm:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, '0', STR_PAD_LEFT)."'";
				
			break;
			case $this->role_am:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$condition[0]."' GROUP BY BranchCode)";
				
			break;
			case $this->role_rd:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$condition[4]."' GROUP BY BranchCode)";
				
			break;
			case $this->role_ads:
			case $this->role_hq:
			case $this->role_spv:	
				
			break;
		
		}
		
		try {
				
			$result = $this->dbmodel->CIQuery("
			SELECT * FROM (
				SELECT *, ROW_NUMBER() OVER (ORDER BY $ordering) as KeyPoint FROM (
				SELECT *, 
				CASE 
					WHEN NOT AFCancelReason = '' THEN 'InActive'
					WHEN [Status] = 'CANCEL' THEN 'InActive'
					WHEN [Status] = 'REJECT' THEN 'InActive'
					WHEN [Status] = 'APPROVED' THEN 'InActive'
					WHEN [Status] = 'CANCELBYRM' THEN 'InActive'
					WHEN [Status] = 'CANCELBYCUS' THEN 'InActive'
					WHEN [Status] = 'CANCELBYCA' THEN 'InActive'
					WHEN NOT SubmitDocToHQ IS NULL AND NOT ReceivedDocFormLB IS NULL AND NOT AppToCALog IS NULL THEN 'InActive'
					WHEN NOT SubmitDocToHQ IS NULL AND NOT ReceivedDocFormLB IS NULL AND NOT AppToCA IS NULL THEN 'InActive'
					WHEN NOT SubmitDocToHQ IS NULL AND NOT ReceivedDocFormLB IS NULL AND NOT AppToCA IS NULL AND NOT CAReturnDate IS NULL THEN 'InActive'
					ELSE 'Active'
				END AS ActiveRecord
				FROM (
					SELECT ReconcileDoc.DocID, [Profile].OwnerName, [Profile].Mobile, [Profile].Telephone, 
					LendingBranchs.RegionID, LendingBranchs.BranchCode, LendingBranchs.BranchDigit, [Profile].RMCode, 
					[Profile].RMName, [Profile].RMMobile, UPPER(Verification.RMProcess) AS RMProcess, ApplicationStatus.AFCancelReason,
					ApplicationStatus.[Status], ApplicationStatus.StatusReason, ReconcileDoc.BorrowerName, ReconcileDoc.BorrowerType, NCBConsent.NCBCheck,
						CASE NCBConsent.NCBCheckDate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), NCBConsent.NCBCheckDate, 120)
						END AS NCBCheckDate, ReconcileDoc.LogisticCode,
						CASE ReconcileDoc.SubmitDocToHQ
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileDoc.SubmitDocToHQ, 120)
						END AS SubmitDocToHQ,
						CASE ReconcileDoc. ReceivedDocFormLB
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileDoc.ReceivedDocFormLB, 120)
						END AS ReceivedDocFormLB, ReconcileDoc.CompletionDoc,
						CASE ReconcileDoc.CompletionDate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileDoc.CompletionDate, 120)
						END AS CompletionDate,
						CASE ReconcileDoc.AppToCA
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileDoc.AppToCA, 120)
						END AS AppToCA, AppToCALog,
						CASE 
							WHEN ReconcileMissing.LackNums <= 0 THEN ''
							WHEN ReconcileMissing.LackNums IS NULL THEN ''
							ELSE ReconcileMissing.LackNums
							END AS LackNums,
						CASE 
							WHEN ReconcileReturn.ReturnNums <= 0 THEN ''
							WHEN ReconcileReturn.ReturnNums IS NULL THEN ''
							ELSE ReconcileReturn.ReturnNums
						END AS ReturnNums, ReconcileDoc.CAReturn,
						CASE ReconcileDoc.CAReturnDate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileDoc.CAReturnDate, 120)
						END AS CAReturnDate, ReconcileDocLogs.CAReturnDateLog,
						ReconcileDoc.IsActive, ReconcileDoc.IsRef,
						CASE [Profile].CreateDate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), [Profile].CreateDate, 120)
						END AS CreateProfileDate	
					FROM ReconcileDoc
					INNER JOIN NCBConsent
					ON ReconcileDoc.IsRef = NCBConsent.IsRef
					INNER JOIN [Profile]
					ON ReconcileDoc.DocID = [Profile].DocID AND [Profile].IsEnabled = 'A'
					INNER JOIN Verification
					ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
					INNER JOIN ApplicationStatus
					ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
					INNER JOIN LendingBranchs
					ON [Profile].BranchCode = LendingBranchs.BranchCode
					LEFT OUTER JOIN (
						SELECT DocID, DocOwner, COUNT(DocID) AS LackNums, IsRef
						FROM ReconcileCompletion
						WHERE NOT DocID = '0'
						AND DocType = 'M'
						AND IsActive = 'A'
						AND SubmitDocToCADate IS NULL
						GROUP BY DocID, DocOwner, IsRef
					) ReconcileMissing
					ON ReconcileDoc.IsRef = ReconcileMissing.IsRef
					LEFT OUTER JOIN (
						SELECT DocID, DocOwner, COUNT(DocID) AS ReturnNums, IsRef
						FROM ReconcileCompletion
						WHERE NOT DocID = '0'
						AND DocType = 'R'
						AND IsActive = 'A'
						AND LBSubmitDocDate IS NOT NULL
						AND BranchReceivedDate IS NULL
						AND DocIsLock IS NULL
						GROUP BY DocID, DocOwner, IsRef
					) ReconcileReturn
					ON ReconcileDoc.IsRef = ReconcileReturn.IsRef
					LEFT OUTER JOIN (
						SELECT * FROM (
						SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
						DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
						CASE AppToCA
							WHEN '1900-01-01' THEN NULL
							WHEN '' THEN NULL
							ELSE CONVERT(nvarchar(10), AppToCA, 120)
						END AS AppToCALog,
						CASE CAReturnDate
							WHEN '1900-01-01' THEN NULL
							WHEN '' THEN NULL
							ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
						END AS CAReturnDateLog
						FROM ReconcileDocLogs) Tmp
						WHERE Numindex = 1				
					) ReconcileDocLogs
					ON ReconcileDoc.DocID = ReconcileDocLogs.DocLogs 
					AND ReconcileDoc.BorrowerType = ReconcileDocLogs.BorrowerType
					WHERE NOT LogisticCode IS NULL
					$filter_condition
					$optional
					) A
					WHERE IsActive = 'A'
				) Inquiry
				WHERE NOT CreateProfileDate IS NULL	
				$wheres
				$criteria
			) Data
			WHERE KeyPoint > '".$condition[3][0]."' AND KeyPoint <= '".$condition[3][1]."'");
				
			return $result;
				
		} catch(Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
				
		}
		
	}
	
	private function documentAppMissingMode($authority, $condition = array(), $criteria, $optional){
		
		$wheres  = "";
		$filter_condition = "AND NOT SubmitDocToHQ BETWEEN '1900-01-01' AND '2014-12-31'";
		$ordering		  = $condition[3][2];
		
		switch($authority) {
			case $this->role_ad:
				
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = '';
				else:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, "0", STR_PAD_LEFT)."'";
				endif;
				
			break;
			case $this->role_rm:
				$wheres	= " AND RMCode = '".$condition[0]."'";
				
			break;
			case $this->role_bm:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, "0", STR_PAD_LEFT)."'";
				
			break;
			case $this->role_am:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$condition[0]."' GROUP BY BranchCode)";
				
			break;
			case $this->role_rd:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$condition[4]."' GROUP BY BranchCode)";
				
			break;
			case $this->role_ads:
			case $this->role_hq:
			case $this->role_spv:	
				
			break;
		
		}

		try {
		
			$result = $this->dbmodel->CIQuery("
			SELECT * FROM (
				SELECT *, ROW_NUMBER() OVER (ORDER BY $ordering) as KeyPoint 
				FROM (
					SELECT *, 
					CASE 					
						WHEN NOT AFCancelReason = '' THEN 'InActive'
						WHEN [Status] = 'CANCEL' THEN 'InActive'
						WHEN [Status] = 'REJECT' THEN 'InActive'
						WHEN [Status] = 'APPROVED'
						AND  DrawdownDate IS NOT NULL
						AND  LackNums = 0 THEN 'InActive'
						WHEN [Status] = 'CANCELBYRM' THEN 'InActive'
						WHEN [Status] = 'CANCELBYCUS' THEN 'InActive'
						WHEN [Status] = 'CANCELBYCA' THEN 'InActive'
						WHEN LackNums >= 1 THEN 'Active'
						ELSE 'InActive'
					END AS ActiveRecord
					FROM (
						SELECT ReconcileDoc.DocID, [Profile].OwnerName, [Profile].Mobile, [Profile].Telephone, 
						LendingBranchs.RegionID, LendingBranchs.BranchCode, LendingBranchs.BranchDigit, [Profile].RMCode, 
						[Profile].RMName, [Profile].RMMobile, UPPER(Verification.RMProcess) AS RMProcess, ApplicationStatus.AFCancelReason,
						ApplicationStatus.[Status], ApplicationStatus.StatusReason, ApplicationStatus.DrawdownDate,
						ReconcileDoc.BorrowerName, ReconcileDoc.BorrowerType, NCBConsent.NCBCheck,
						CASE NCBConsent.NCBCheckDate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), NCBConsent.NCBCheckDate, 120)
						END AS NCBCheckDate, ReconcileDoc.LogisticCode,
						CASE ReconcileDoc.SubmitDocToHQ
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileDoc.SubmitDocToHQ, 120)
						END AS SubmitDocToHQ,
						CASE ReconcileDoc. ReceivedDocFormLB
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileDoc.ReceivedDocFormLB, 120)
						END AS ReceivedDocFormLB, ReconcileDoc.CompletionDoc,
						CASE ReconcileDoc.CompletionDate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileDoc.CompletionDate, 120)
						END AS CompletionDate,
						CASE ReconcileDoc.AppToCA
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileDoc.AppToCA, 120)
						END AS AppToCA, AppToCALog,					
						CASE 
							WHEN ReconcileMissingStay.LackNumTotal <= 0 THEN ''
							WHEN ReconcileMissingStay.LackNumTotal IS NULL THEN ''
							ELSE ReconcileMissingStay.LackNumTotal
						END AS LackNumTotal,
						CASE 
							WHEN ReconcileMissing.LackNums <= 0 THEN ''
							WHEN ReconcileMissing.LackNums IS NULL THEN ''
							ELSE ReconcileMissing.LackNums
						END AS LackNums,
						CASE 
							WHEN ReconcileReturn.ReturnNums <= 0 THEN ''
							WHEN ReconcileReturn.ReturnNums IS NULL THEN ''
							ELSE ReconcileReturn.ReturnNums
						END AS ReturnNums, ReconcileDoc.CAReturn,
						CASE ReconcileDoc.CAReturnDate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileDoc.CAReturnDate, 120)
						END AS CAReturnDate, ReconcileDocLogs.CAReturnDateLog,
						ReconcileDoc.IsActive, ReconcileDoc.IsRef,
						CASE [Profile].CreateDate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), [Profile].CreateDate, 120)
						END AS CreateProfileDate	
						FROM ReconcileDoc
						INNER JOIN NCBConsent
						ON ReconcileDoc.IsRef = NCBConsent.IsRef
						INNER JOIN [Profile]
						ON ReconcileDoc.DocID = [Profile].DocID AND [Profile].IsEnabled = 'A'
						INNER JOIN Verification
						ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
						INNER JOIN ApplicationStatus
						ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
						INNER JOIN LendingBranchs
						ON [Profile].BranchCode = LendingBranchs.BranchCode
						LEFT OUTER JOIN (
							SELECT DocID, COUNT(DocID) AS LackNumTotal, IsRef
							FROM ReconcileCompletion
							WHERE NOT DocID = '0'
							AND DocType = 'M'
							AND IsActive = 'A'
							GROUP BY DocID, IsRef
						) ReconcileMissingStay
						ON ReconcileDoc.IsRef = ReconcileMissingStay.IsRef	
						LEFT OUTER JOIN (
							SELECT DocID, DocOwner, COUNT(DocID) AS LackNums, IsRef
							FROM ReconcileCompletion
							WHERE NOT DocID = '0'
							AND DocType = 'M'
							AND IsActive = 'A'
							AND SubmitDocToCADate IS NULL
							GROUP BY DocID, DocOwner, IsRef
						) ReconcileMissing
						ON ReconcileDoc.IsRef = ReconcileMissing.IsRef
						LEFT OUTER JOIN (
							SELECT DocID, DocOwner, COUNT(DocID) AS ReturnNums, IsRef
							FROM ReconcileCompletion
							WHERE NOT DocID = '0' 
							AND DocType = 'R'
							AND IsActive = 'A'
							AND LBSubmitDocDate IS NOT NULL
							AND BranchReceivedDate IS NULL
							AND DocIsLock IS NULL
							GROUP BY DocID, DocOwner, IsRef
						) ReconcileReturn
						ON ReconcileDoc.IsRef = ReconcileReturn.IsRef
						LEFT OUTER JOIN (
							SELECT * FROM (
							SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
							DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
							CASE AppToCA
								WHEN '1900-01-01' THEN NULL
								WHEN '' THEN NULL
								ELSE CONVERT(nvarchar(10), AppToCA, 120)
							END AS AppToCALog,
							CASE CAReturnDate
								WHEN '1900-01-01' THEN NULL
								WHEN '' THEN NULL
								ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
							END AS CAReturnDateLog
							FROM ReconcileDocLogs) Tmp
							WHERE Numindex = 1				
						) ReconcileDocLogs
						ON ReconcileDoc.DocID = ReconcileDocLogs.DocLogs 
						AND ReconcileDoc.BorrowerType = ReconcileDocLogs.BorrowerType
						WHERE NOT LogisticCode IS NULL
						$filter_condition	
						$optional
					) A
					WHERE IsActive = 'A'
					AND LackNumTotal >= 1		
				) Inquiry
				WHERE NOT CreateProfileDate IS NULL
				$wheres
				$criteria
			) Data
			WHERE KeyPoint > '".$condition[3][0]."' AND KeyPoint <= '".$condition[3][1]."'");
		
			return $result;
		
		} catch(Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
		
		}
		
							
	}
	
	private function documentAppReturnMode($authority, $condition = array(), $criteria, $optional, $special){
		
		$wheres  = "";
		$filter_condition = "AND NOT SubmitDocToHQ BETWEEN '1900-01-01' AND '2014-12-31'";
		$ordering		  = $condition[3][2];
		
		switch($authority) {
			case $this->role_ad:
				
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = '';
				else:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, "0", STR_PAD_LEFT)."'";
				endif;
				
			break;
			case $this->role_rm:
				$wheres	= " AND RMCode = '".$condition[0]."'";
				
			break;
			case $this->role_bm:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, "0", STR_PAD_LEFT)."'";
				
			break;
			case $this->role_am:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$condition[0]."' GROUP BY BranchCode)";
				
			break;
			case $this->role_rd:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$condition[4]."' GROUP BY BranchCode)";
				
			break;
			case $this->role_ads:
			case $this->role_hq:
			case $this->role_spv:	
				
			break;
		
		}
		
		try {
		
			$result = $this->dbmodel->CIQuery("
			SELECT * FROM (
				SELECT *, ROW_NUMBER() OVER (ORDER BY $ordering) as KeyPoint FROM (
				SELECT *, 
				CASE 
					WHEN ReturnNums >= 1 THEN 'Active'
					WHEN ReturnNums <= 0 AND NOT Return_BranchReceivedDate IS NULL THEN 'InActive'	
					ELSE 'InActive'
				END AS ActiveRecord
				FROM (
					SELECT ReconcileDoc.DocID, [Profile].OwnerName, [Profile].Mobile, [Profile].Telephone, 
					LendingBranchs.RegionID, LendingBranchs.BranchCode, LendingBranchs.BranchDigit, [Profile].RMCode, 
					[Profile].RMName, [Profile].RMMobile, UPPER(Verification.RMProcess) AS RMProcess, ApplicationStatus.AFCancelReason,
					ApplicationStatus.[Status], ApplicationStatus.StatusReason, ReconcileDoc.BorrowerName, ReconcileDoc.BorrowerType, NCBConsent.NCBCheck,
						CASE NCBConsent.NCBCheckDate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), NCBConsent.NCBCheckDate, 120)
						END AS NCBCheckDate, ReconcileDoc.LogisticCode,
						CASE ReconcileDoc.SubmitDocToHQ
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileDoc.SubmitDocToHQ, 120)
						END AS SubmitDocToHQ,
						CASE ReconcileDoc. ReceivedDocFormLB
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileDoc.ReceivedDocFormLB, 120)
						END AS ReceivedDocFormLB, ReconcileDoc.CompletionDoc,
						CASE ReconcileDoc.CompletionDate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileDoc.CompletionDate, 120)
						END AS CompletionDate,
						CASE ReconcileDoc.AppToCA
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileDoc.AppToCA, 120)
						END AS AppToCA, AppToCaLog,					
						CASE 
							WHEN ReconcileMissing.LackNums <= 0 THEN ''
							WHEN ReconcileMissing.LackNums IS NULL THEN ''
							ELSE ReconcileMissing.LackNums
						END AS LackNums,					
						CASE 
							WHEN ReconcileReturnStay.ReturnTotal <= 0 THEN ''
							WHEN ReconcileReturnStay.ReturnTotal IS NULL THEN ''
							ELSE ReconcileReturnStay.ReturnTotal
						END AS ReturnTotal,
						CASE 
							WHEN ReconcileReturn.ReturnNums <= 0 THEN ''
							WHEN ReconcileReturn.ReturnNums IS NULL THEN ''
							ELSE ReconcileReturn.ReturnNums
						END AS ReturnNums, ReconcileDoc.CAReturn,
						CASE ReconcileDoc.CAReturnDate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileDoc.CAReturnDate, 120)
						END AS CAReturnDate, ReconcileDocLogs.CAReturnDateLog,
						ReconcileDoc.IsActive, ReconcileDoc.IsRef,
						CASE [Profile].CreateDate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), [Profile].CreateDate, 120)
						END AS CreateProfileDate,
						CASE ReconcileReturnDocStay.LBSubmitDocDate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
						ELSE CONVERT(nvarchar(10), ReconcileReturnDocStay.LBSubmitDocDate, 120)
						END AS ReturnDoc_LBSubmitToDate,		
						CASE ReconcileReturnDoc.LBSubmitDocDate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileReturnDoc.LBSubmitDocDate, 120)
						END AS Return_LBSubmitDocDate,		
						CASE ReconcileReturnDoc.HQReceivedDocFromLBDate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileReturnDoc.HQReceivedDocFromLBDate, 120)
						END AS Return_HQReceivedDocFromLB,
						CASE ReconcileReturnDoc.SubmitDocToCADate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileReturnDoc.SubmitDocToCADate, 120)
						END AS Return_SubmitDocToCADate,
						CASE ReconcileReturnDoc.CAReturnDate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileReturnDoc.CAReturnDate, 120)
						END AS Return_CAReturnDate,
						CASE ReconcileReturnDoc.HQSentToLBDate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileReturnDoc.HQSentToLBDate, 120)
						END AS Return_HQSentToLBDate,
						CASE ReconcileReturnDoc.BranchReceivedDate
							WHEN '1900-01-01' THEN ''
							WHEN '' THEN ''
							ELSE CONVERT(nvarchar(10), ReconcileReturnDoc.BranchReceivedDate, 120)
						END AS Return_BranchReceivedDate
					FROM ReconcileDoc
					INNER JOIN NCBConsent
					ON ReconcileDoc.IsRef = NCBConsent.IsRef
					INNER JOIN [Profile]
					ON ReconcileDoc.DocID = [Profile].DocID AND [Profile].IsEnabled = 'A'
					INNER JOIN Verification
					ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
					INNER JOIN ApplicationStatus
					ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
					INNER JOIN LendingBranchs
					ON [Profile].BranchCode = LendingBranchs.BranchCode
					LEFT OUTER JOIN (
							SELECT DocID, DocOwner, COUNT(DocID) AS LackNums, IsRef
							FROM ReconcileCompletion
							WHERE NOT DocID = '0'
							AND DocType = 'M'
							AND IsActive = 'A'
							AND SubmitDocToCADate IS NULL
							GROUP BY DocID, DocOwner, IsRef
					) ReconcileMissing
					ON ReconcileDoc.IsRef = ReconcileMissing.IsRef
					LEFT OUTER JOIN (
						SELECT DocID, DocOwner, COUNT(DocID) AS ReturnNums, IsRef
						FROM ReconcileCompletion
						WHERE NOT DocID = '0' 
						AND DocType = 'R'
						AND IsActive = 'A'
						AND LBSubmitDocDate IS NOT NULL
						AND BranchReceivedDate IS NULL
						AND DocIsLock IS NULL
						GROUP BY DocID, DocOwner, IsRef
					) ReconcileReturn
					ON ReconcileDoc.IsRef = ReconcileReturn.IsRef
					LEFT OUTER JOIN (
						SELECT DocID, COUNT(DocID) AS ReturnTotal, IsRef
						FROM ReconcileCompletion
						WHERE NOT DocID = '0'
						AND DocType = 'R'
						AND IsActive = 'A'
						AND LBSubmitDocDate IS NOT NULL
						AND DocIsLock IS NULL
						GROUP BY DocID, IsRef
					) ReconcileReturnStay
					ON ReconcileDoc.IsRef = ReconcileReturnStay.IsRef	
					LEFT OUTER JOIN (
						SELECT * FROM (
						SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
						DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
						CASE AppToCA
							WHEN '1900-01-01' THEN NULL
							WHEN '' THEN NULL
							ELSE CONVERT(nvarchar(10), AppToCA, 120)
						END AS AppToCALog,
						CASE CAReturnDate
							WHEN '1900-01-01' THEN NULL
							WHEN '' THEN NULL
							ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
						END AS CAReturnDateLog
						FROM ReconcileDocLogs) Tmp
						WHERE Numindex = 1				
					) ReconcileDocLogs
					ON ReconcileDoc.DocID = ReconcileDocLogs.DocLogs 
					AND ReconcileDoc.BorrowerType = ReconcileDocLogs.BorrowerType
					LEFT OUTER JOIN (
						SELECT * FROM (
							SELECT DocID, LBSubmitDocDate, IsRef, ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY LBSubmitDocDate ASC, DocOwner ASC) as Numindex
							FROM ReconcileCompletion
							WHERE IsActive = 'A'
							AND DocType = 'R'
							AND LBSubmitDocDate IS NOT NULL
							AND DocIsLock IS NULL
						) A
						WHERE Numindex = '1'
					) AS ReconcileReturnDocStay
					ON ReconcileDoc.DocID = ReconcileReturnDocStay.DocID 
					AND ReconcileDoc.IsRef = ReconcileReturnDocStay.IsRef
					LEFT OUTER JOIN (
						SELECT * FROM (
							SELECT 
								DocID, LBSubmitDocDate, HQReceivedDocFromLBDate, SubmitDocToCADate, CAReturnDate, HQSentToLBDate, BranchReceivedDate, IsActive, IsRef,
								ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY LBSubmitDocDate ASC, DocOwner ASC) as Numindex
							FROM ReconcileCompletion
							WHERE IsActive = 'A'
							AND DocType = 'R'
							AND LBSubmitDocDate IS NOT NULL
							AND BranchReceivedDate IS NOT NULL
							AND DocIsLock IS NULL
							) A
						WHERE Numindex = '1'
					) AS ReconcileReturnDoc
					ON ReconcileDoc.DocID = ReconcileReturnDoc.DocID 
					AND ReconcileDoc.IsRef = ReconcileReturnDoc.IsRef
					WHERE NOT LogisticCode IS NULL
					$filter_condition
					$optional
					) A
					WHERE IsActive = 'A'
					$special
				) Inquiry
				WHERE NOT CreateProfileDate IS NULL
				$wheres
				$criteria
			) Data
			WHERE KeyPoint > '".$condition[3][0]."' AND KeyPoint <= '".$condition[3][1]."'");
			
			return $result;
		
		} catch(Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
		
		}
		
	
	}
	
	private function documentCAReturnMode($authority, $condition = array(), $criteria, $optional){
	
		$wheres  = "";
		$filter_condition = "AND NOT SubmitDocToHQ BETWEEN '1900-01-01' AND '2014-12-31'";
		$ordering		  = $condition[3][2];
	
		switch($authority) {
			case $this->role_ad:
				
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = '';
				else:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, "0", STR_PAD_LEFT)."'";
				endif;
				
			break;
			case $this->role_rm:
				$wheres	= " AND RMCode = '".$condition[0]."'";
				
			break;
			case $this->role_bm:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, "0", STR_PAD_LEFT)."'";
				
			break;
			case $this->role_am:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$condition[0]."' GROUP BY BranchCode)";
				
			break;
			case $this->role_rd:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$condition[4]."' GROUP BY BranchCode)";
				
			break;
			case $this->role_ads:
			case $this->role_hq:
			case $this->role_spv:	
				
			break;
		
		}
	
		try {
	
			$result = $this->dbmodel->CIQuery("
				SELECT * FROM (
					SELECT *, ROW_NUMBER() OVER (ORDER BY $ordering) as KeyPoint FROM (
					SELECT *, 
					CASE 
						WHEN NOT AFCancelReason = '' THEN 'InActive'
						WHEN [Status] = 'CANCEL' THEN 'InActive'
						WHEN [Status] = 'REJECT' THEN 'InActive'
						WHEN [Status] = 'APPROVED' THEN 'InActive'
						WHEN [Status] = 'CANCELBYRM' THEN 'InActive'
						WHEN [Status] = 'CANCELBYCUS' THEN 'InActive'
						WHEN [Status] = 'CANCELBYCA' THEN 'InActive'
						WHEN NOT SubmitDocToHQ IS NULL AND NOT ReceivedDocFormLB IS NULL AND NOT AppToCA IS NULL THEN 'InActive'
						WHEN NOT SubmitDocToHQ IS NULL AND NOT ReceivedDocFormLB IS NULL AND NOT AppToCA IS NULL AND NOT CAReturnDate IS NULL THEN 'InActive'
						ELSE 'Active'
					END AS ActiveRecord
					FROM (
						SELECT ReconcileDoc.DocID, [Profile].OwnerName, [Profile].Mobile, [Profile].Telephone, 
						LendingBranchs.RegionID, LendingBranchs.BranchCode, LendingBranchs.BranchDigit, [Profile].RMCode, 
						[Profile].RMName, [Profile].RMMobile, UPPER(Verification.RMProcess) AS RMProcess, ApplicationStatus.AFCancelReason,
						ApplicationStatus.[Status], ApplicationStatus.StatusReason, ReconcileDoc.BorrowerName, ReconcileDoc.BorrowerType, NCBConsent.NCBCheck,
							CONVERT(nvarchar(10), NCBConsent.NCBCheckDate, 120) AS NCBCheckDate, ReconcileDoc.LogisticCode,
							CONVERT(nvarchar(10), ReconcileDoc.SubmitDocToHQ, 120) AS SubmitDocToHQ,
							CONVERT(nvarchar(10), ReconcileDoc.ReceivedDocFormLB, 120) AS ReceivedDocFormLB, ReconcileDoc.CompletionDoc,
							CONVERT(nvarchar(10), ReconcileDoc.CompletionDate, 120) AS CompletionDate,
							CONVERT(nvarchar(10), ReconcileDoc.AppToCA, 120) AS AppToCA, AppToCALog,
							CASE 
								WHEN ReconcileMissing.LackNums <= 0 THEN ''
								WHEN ReconcileMissing.LackNums IS NULL THEN ''
								ELSE ReconcileMissing.LackNums
								END AS LackNums,
							CASE 
								WHEN ReconcileReturn.ReturnNums <= 0 THEN ''
								WHEN ReconcileReturn.ReturnNums IS NULL THEN ''
								ELSE ReconcileReturn.ReturnNums
							END AS ReturnNums, ReconcileDoc.CAReturn,
							CONVERT(nvarchar(10), ReconcileDoc.CAReturnDate, 120) AS CAReturnDate, ReconcileDocLogs.CAReturnDateLog,
							ReconcileDoc.IsActive, ReconcileDoc.IsRef,
							CONVERT(nvarchar(10), [Profile].CreateDate, 120) AS CreateProfileDate	
						FROM ReconcileDoc
						INNER JOIN NCBConsent
						ON ReconcileDoc.IsRef = NCBConsent.IsRef
						INNER JOIN [Profile]
						ON ReconcileDoc.DocID = [Profile].DocID AND [Profile].IsEnabled = 'A'
						INNER JOIN Verification
						ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
						INNER JOIN ApplicationStatus
						ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
						INNER JOIN LendingBranchs
						ON [Profile].BranchCode = LendingBranchs.BranchCode
						LEFT OUTER JOIN (
								SELECT DocID, DocOwner, COUNT(DocID) AS LackNums, IsRef
								FROM ReconcileCompletion
								WHERE NOT DocID = '0'
								AND DocType = 'M'
								AND IsActive = 'A'
								AND SubmitDocToCADate IS NULL
								GROUP BY DocID, DocOwner, IsRef
						) ReconcileMissing
						ON ReconcileDoc.IsRef = ReconcileMissing.IsRef
						LEFT OUTER JOIN (
							SELECT DocID, DocOwner, COUNT(DocID) AS ReturnNums, IsRef
							FROM ReconcileCompletion
							WHERE NOT DocID = '0'
							AND DocType = 'R'
							AND IsActive = 'A'
							AND LBSubmitDocDate IS NOT NULL
							AND BranchReceivedDate IS NULL
							AND DocIsLock IS NULL
							GROUP BY DocID, DocOwner, IsRef
						) ReconcileReturn
						ON ReconcileDoc.IsRef = ReconcileReturn.IsRef
						LEFT OUTER JOIN (
							SELECT * FROM (
							SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
							DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
							CONVERT(nvarchar(10), AppToCA, 120) AS AppToCALog,
							CONVERT(nvarchar(10), CAReturnDate, 120) AS CAReturnDateLog
							FROM ReconcileDocLogs WHERE IsActive = 'A') Tmp
							WHERE Numindex = 1				
						) ReconcileDocLogs
						ON ReconcileDoc.DocID = ReconcileDocLogs.DocLogs 
						AND ReconcileDoc.BorrowerType = ReconcileDocLogs.BorrowerType
						WHERE NOT LogisticCode IS NULL	
						AND AppToCA IS NULL
						AND NOT CAReturnDateLog IS NULL	
						$filter_condition	
						$optional
					) A
					WHERE IsActive = 'A'							
				) Inquiry
				WHERE NOT CreateProfileDate IS NULL	
				$wheres
				$criteria
			) Data
			WHERE KeyPoint > '".$condition[3][0]."' AND KeyPoint <= '".$condition[3][1]."'");
				
			return $result;
	
		} catch(Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
	
		}
	
	
	}
	
	private function documentAppAllMode($authority, $condition = array(), $criteria, $optional){

		$wheres  = "";
		$filter_condition = "AND NOT SubmitDocToHQ BETWEEN '1900-01-01' AND '2014-12-31'";
		$ordering		  = $condition[3][2];
		
		switch($authority) {
			case $this->role_ad:
				
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = '';
				else:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, "0", STR_PAD_LEFT)."'";
				endif;
				
			break;
			case $this->role_rm:
				$wheres	= " AND RMCode = '".$condition[0]."'";
				
			break;
			case $this->role_bm:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, "0", STR_PAD_LEFT)."'";
				
			break;
			case $this->role_am:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$condition[0]."' GROUP BY BranchCode)";
				
			break;
			case $this->role_rd:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$condition[4]."' GROUP BY BranchCode)";
				
			break;
			case $this->role_ads:
			case $this->role_hq:
			case $this->role_spv:	
				
			break;
		
		}
		
		try {
		
			$result = $this->dbmodel->CIQuery("
			SELECT * FROM (
				SELECT *, ROW_NUMBER() OVER (ORDER BY $ordering) as KeyPoint FROM (
					SELECT *, 
					CASE 
						 WHEN NOT AFCancelReason = '' THEN 'InActive'
						 WHEN [Status] = 'CANCEL' THEN 'InActive'
						 WHEN [Status] = 'REJECT' THEN 'InActive'
						 WHEN [Status] = 'APPROVED' THEN 'InActive'
						 WHEN [Status] = 'CANCELBYRM' THEN 'InActive'
						 WHEN [Status] = 'CANCELBYCUS' THEN 'InActive'
						 WHEN [Status] = 'CANCELBYCA' THEN 'InActive'
						 WHEN NOT SubmitDocToHQ IS NULL AND NOT ReceivedDocFormLB IS NULL
						 AND NOT CompletionDoc IS NULL AND NOT CompletionDate IS NULL 
						 AND CompletionDoc = 'Y' AND NOT AppToCA IS NULL
		 				 AND LackNums = 0 AND ReturnNums = 0 THEN 'InActive'
						 WHEN NOT SubmitDocToHQ IS NULL AND NOT ReceivedDocFormLB IS NULL
						 AND NOT CompletionDoc IS NULL AND NOT CompletionDate IS NULL 
						 AND CompletionDoc = 'Y' AND NOT AppToCA IS NULL
						 AND LackNums = 0 AND ReturnNums = 0
						 AND NOT CAReturnDate IS NULL
						 THEN 'InActive'
						 ELSE 'Active'
					END AS ActiveRecord
					FROM (
						SELECT ReconcileDoc.DocID, [Profile].OwnerName, [Profile].Mobile, [Profile].Telephone, 
						LendingBranchs.RegionID, LendingBranchs.BranchCode, LendingBranchs.BranchDigit, [Profile].RMCode, 
						[Profile].RMName, [Profile].RMMobile, UPPER(Verification.RMProcess) AS RMProcess, ApplicationStatus.AFCancelReason,
						ApplicationStatus.[Status], ApplicationStatus.StatusReason, ReconcileDoc.BorrowerName, ReconcileDoc.BorrowerType, NCBConsent.NCBCheck,
							CASE NCBConsent.NCBCheckDate
								WHEN '1900-01-01' THEN ''
								WHEN '' THEN ''
								ELSE CONVERT(nvarchar(10), NCBConsent.NCBCheckDate, 120)
							END AS NCBCheckDate, ReconcileDoc.LogisticCode,
							CASE ReconcileDoc.SubmitDocToHQ
								WHEN '1900-01-01' THEN ''
								WHEN '' THEN ''
								ELSE CONVERT(nvarchar(10), ReconcileDoc.SubmitDocToHQ, 120)
							END AS SubmitDocToHQ,
							CASE ReconcileDoc. ReceivedDocFormLB
								WHEN '1900-01-01' THEN ''
								WHEN '' THEN ''
								ELSE CONVERT(nvarchar(10), ReconcileDoc.ReceivedDocFormLB, 120)
							END AS ReceivedDocFormLB, ReconcileDoc.CompletionDoc,
							CASE ReconcileDoc.CompletionDate
								WHEN '1900-01-01' THEN ''
								WHEN '' THEN ''
								ELSE CONVERT(nvarchar(10), ReconcileDoc.CompletionDate, 120)
							END AS CompletionDate,
							CASE ReconcileDoc.AppToCA
								WHEN '1900-01-01' THEN ''
								WHEN '' THEN ''
								ELSE CONVERT(nvarchar(10), ReconcileDoc.AppToCA, 120)
							END AS AppToCA, AppToCALog,
							CASE 
								WHEN ReconcileMissing.LackNums <= 0 THEN ''
								WHEN ReconcileMissing.LackNums IS NULL THEN ''
								ELSE ReconcileMissing.LackNums
								END AS LackNums,
							CASE 
								WHEN ReconcileReturn.ReturnNums <= 0 THEN ''
								WHEN ReconcileReturn.ReturnNums IS NULL THEN ''
								ELSE ReconcileReturn.ReturnNums
							END AS ReturnNums, ReconcileDoc.CAReturn,
							CASE ReconcileDoc.CAReturnDate
								WHEN '1900-01-01' THEN ''
								WHEN '' THEN ''
								ELSE CONVERT(nvarchar(10), ReconcileDoc.CAReturnDate, 120)
							END AS CAReturnDate, ReconcileDocLogs.CAReturnDateLog,
							ReconcileDoc.IsActive, ReconcileDoc.IsRef,
							CASE [Profile].CreateDate
								WHEN '1900-01-01' THEN ''
								WHEN '' THEN ''
								ELSE CONVERT(nvarchar(10), [Profile].CreateDate, 120)
							END AS CreateProfileDate	
						FROM ReconcileDoc
						INNER JOIN NCBConsent
						ON ReconcileDoc.IsRef = NCBConsent.IsRef
						INNER JOIN [Profile]
						ON ReconcileDoc.DocID = [Profile].DocID AND [Profile].IsEnabled = 'A'
						INNER JOIN Verification
						ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
						INNER JOIN ApplicationStatus
						ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
						INNER JOIN LendingBranchs
						ON [Profile].BranchCode = LendingBranchs.BranchCode
						LEFT OUTER JOIN (
								SELECT DocID, DocOwner, COUNT(DocID) AS LackNums, IsRef
								FROM ReconcileCompletion
								WHERE NOT DocID = '0'
								AND DocType = 'M'
								AND IsActive = 'A'
								AND SubmitDocToCADate IS NULL
								GROUP BY DocID, DocOwner, IsRef
						) ReconcileMissing
						ON ReconcileDoc.IsRef = ReconcileMissing.IsRef
						LEFT OUTER JOIN (
							SELECT DocID, DocOwner, COUNT(DocID) AS ReturnNums, IsRef
							FROM ReconcileCompletion
							WHERE NOT DocID = '0'
							AND DocType = 'R'
							AND IsActive = 'A'
							AND LBSubmitDocDate IS NOT NULL
							AND BranchReceivedDate IS NULL
							AND DocIsLock IS NULL
							GROUP BY DocID, DocOwner, IsRef
						) ReconcileReturn
						ON ReconcileDoc.IsRef = ReconcileReturn.IsRef
						LEFT OUTER JOIN (
							SELECT * FROM (
							SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
							DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
							CASE AppToCA
								WHEN '1900-01-01' THEN NULL
								WHEN '' THEN NULL
								ELSE CONVERT(nvarchar(10), AppToCA, 120)
							END AS AppToCALog,
							CASE CAReturnDate
								WHEN '1900-01-01' THEN NULL
								WHEN '' THEN NULL
								ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
							END AS CAReturnDateLog
							FROM ReconcileDocLogs) Tmp
							WHERE Numindex = 1				
						) ReconcileDocLogs
						ON ReconcileDoc.DocID = ReconcileDocLogs.DocLogs 
						AND ReconcileDoc.BorrowerType = ReconcileDocLogs.BorrowerType
						WHERE NOT LogisticCode IS NULL
						$filter_condition
						$optional
					) A
					WHERE IsActive = 'A'
				) Inquiry
				WHERE NOT CreateProfileDate IS NULL
				$wheres
				$criteria
			) Data
			WHERE KeyPoint > '".$condition[3][0]."' AND KeyPoint <= '".$condition[3][1]."'");
		
			return $result;
		
		} catch(Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
		
		}
		
	}
	
	
	
	
	// Pagination Document Management
	public function loadAppManagementPagination($position, $authority, $condition = array()) {
		$this->load->model('dbmodel');
		$this->load->model('dbcustom');
		$this->load->library('effective');
		
		$where_special	 = '';
		$where_condition = " AND NOT ReconcileDoc.BorrowerType = '104'";
		$where_filter	 = '';
		
		$event_mode		 = $this->input->post('slmode');
		$views			 = $this->input->post('aciverecord');
		$rmname			 = $this->input->post('rmname');
		$customers		 = $this->input->post('ownerName');
		$region		 	 = $this->input->post('regionid');
		$branchs		 = $this->input->post('branchdigit');
		
		$rec_date_from   = $this->input->post('recdate_from');
		$rec_date_to     = $this->input->post('recdate_to');
		
		$miss_date_from  = $this->input->post('missdate_from');
		$miss_date_to    = $this->input->post('missdate_to');
		
		$returndate_from = $this->input->post('returndate_from');
		$returndate_to   = $this->input->post('returndate_to');
		
		$careturn_from 	 = $this->input->post('careturndate_from');
		$careturn_to   	 = $this->input->post('careturndate_to');
		
		$ddflag_doc		 = $this->input->post('ddflag');
		
		$conv_recondate_1  = !empty($rec_date_from) ? $this->effective->StandartDateSorter($rec_date_from):"";
		$conv_recondate_2  = !empty($rec_date_to) ? $this->effective->StandartDateSorter($rec_date_to):"";
		
		$conv_missdate_1   = !empty($miss_date_from) ? $this->effective->StandartDateSorter($miss_date_from):"";
		$conv_missdate_2   = !empty($miss_date_to) ? $this->effective->StandartDateSorter($miss_date_to):"";
		
		$conv_returndoc_1  = !empty($returndate_from) ? $this->effective->StandartDateSorter($returndate_from):"";
		$conv_returndoc_2  = !empty($returndate_to) ? $this->effective->StandartDateSorter($returndate_to):"";
		
		$conv_careturn_1  = !empty($careturn_from) ? $this->effective->StandartDateSorter($careturn_from):"";
		$conv_careturn_2  = !empty($careturn_to) ? $this->effective->StandartDateSorter($careturn_to):"";
		
		$pieces = explode(',', $branchs);
		if(!empty($pieces[0])):
			$where_brachs 	= "'".implode("','", $pieces)."'";
		else:
			$where_brachs   = "";
		endif;	
		
		$rmlist_pieces = explode(',', $rmname);
		if(!empty($rmlist_pieces[0])):
			$wheres_rmlist   = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $rmlist_pieces)."'");
		else:
			$wheres_rmlist   = "";
		endif;
		
		if($views == "Active"):
			$field_submit2hq = 'ReconcileDoc.SubmitDocToHQ';
			$field_app2ca 	 = 'ReconcileDoc.CompletionDate';
			$field_returndoc = 'ReturnDoc_LBSubmitToDate'; 
		endif;
		
		if($views == "InActive"):
			$field_submit2hq = 'ReconcileDoc.ReceivedDocFormLB';
			$field_app2ca 	 = 'ReconcileDoc.AppToCA';
			$field_returndoc = 'Return_BranchReceivedDate';
		endif;
		

		if($views == "All"):
			$field_submit2hq = 'ReconcileDoc.SubmitDocToHQ';
			$field_app2ca 	 = 'ReconcileDoc.AppToCA';
			$field_returndoc = 'ReturnDoc_LBSubmitToDate';
		endif;
		
		
		if(!empty($conv_recondate_1) && !empty($conv_recondate_2)) { $where_condition .= " AND $field_submit2hq BETWEEN '".$conv_recondate_1."' AND '".$conv_recondate_2."'"; }
		else {
		
			if(!empty($conv_recondate_1)) { $where_condition .= " AND $field_submit2hq = '".$conv_recondate_1."'"; }
			if(!empty($conv_recondate_2)) { $where_condition .= " AND $field_submit2hq = '".$conv_recondate_2."'"; }
		
		}
		
		if(!empty($conv_missdate_1) && !empty($conv_missdate_2)) { $where_condition .= " AND $field_submit2hq BETWEEN '".$conv_missdate_1."' AND '".$conv_missdate_2."'"; }
		else {
		
			if(!empty($conv_missdate_1)) { $where_condition .= " AND $field_submit2hq = '".$conv_missdate_1."'"; }
			if(!empty($conv_missdate_2)) { $where_condition .= " AND $field_submit2hq = '".$conv_missdate_2."'"; }
		
		}
		
		if(!empty($conv_returndoc_1) && !empty($conv_returndoc_2)) { $where_special .= " AND $field_returndoc BETWEEN '".$conv_returndoc_1."' AND '".$conv_returndoc_2."'"; }
		else {
		
			if(!empty($conv_returndoc_1)) { $where_special .= " AND $field_returndoc = '".$conv_returndoc_1."'"; }
			if(!empty($conv_returndoc_2)) { $where_special .= " AND $field_returndoc = '".$conv_returndoc_2."'"; }
		
		}
		
		if(!empty($conv_careturn_1) && !empty($conv_careturn_2)) { $where_condition .= " AND ReconcileDocLogs.CAReturnDateLog BETWEEN '".$conv_careturn_1."' AND '".$conv_careturn_2."'"; }
		else {
		
			if(!empty($conv_careturn_1)) { $where_condition .= " AND ReconcileDocLogs.CAReturnDateLog  = '".$conv_careturn_1."'"; }
			if(!empty($conv_careturn_2)) { $where_condition .= " AND ReconcileDocLogs.CAReturnDateLog  = '".$conv_careturn_2."'"; }
		
		}			
		
		// Optional Query
		//if(!empty($rmname)) { $where_filter .= " AND RMName LIKE '%".$this->effective->set_chartypes($this->char_mode, $rmname)."%'"; }
		if(!empty($customers)) {
			$where_filter .= " AND BorrowerName LIKE '%".$this->effective->set_chartypes($this->char_mode, $customers)."%'";
		}
		
		if(!empty($region)) { $where_filter .= " AND RegionID = '".trim(str_pad($region, 2, "0", STR_PAD_LEFT))."'"; }
		if(!empty($branchs[0])) { $where_filter .= " AND BranchDigit in ($where_brachs) "; }
		if(!empty($rmlist_pieces[0])) { $where_filter .= " AND RMCode in ($wheres_rmlist) "; }
		if($ddflag_doc == 'Y') { $where_condition .= " AND DrawdownDate IS NOT NULL"; }
		//if(!empty($branchs)) { $where_filter .= " AND BranchDigit = '".$branchs."'"; }
		
		if($views == "Active"): $where_filter .= " AND ActiveRecord = '".$views."'"; endif;
		if($views == "InActive"): $where_filter .= " AND ActiveRecord = '".$views."'"; endif;
		
		$mode_handled  		 = self::fnDocRouter($event_mode);
		switch($mode_handled) {
			case 'returndoc':		
				$where_filter .= ' AND ReturnTotal >= 1';		
			break;
		}
		
		if(empty($authority)) {
			throw new Exception("Exception handled: The syntax issue received parameter or condition. Please your are checked arguments at using for inquiry.");
				
		} else {
				
			if(count($authority) > 1) :
			$privileges = $authority[0];
			else:
			$privileges = $authority[0];
			endif;
		
			$employees  = $this->dbcustom->employeesInfo($condition[0]);
			$empbranch  = str_pad($employees['data'][0]['BranchCode'], 3, "0", STR_PAD_LEFT);
			$emp_area  	= $employees['data'][0]['AreaCode'];
			$emp_region	= $employees['data'][0]['RegionID'];
				
			switch($position) {
				case 'reconcile':
					return $this->documentAppReconcileModePagination($authority[0], array($employees['data'][0]['EmployeeCode'], $empbranch, $views, $employees['data'][0]['RegionID']), $where_filter, $where_condition);
						
					break;
				case 'missing':
					return $this->documentAppMissingModePagination($authority[0], array($employees['data'][0]['EmployeeCode'], $empbranch, $views, $employees['data'][0]['RegionID']), $where_filter, $where_condition);
						
					break;
				case 'returndoc':
					return $this->documentAppReturnModePagination($authority[0], array($employees['data'][0]['EmployeeCode'], $empbranch, $views, $employees['data'][0]['RegionID']), $where_filter, $where_condition, $where_special);
						
					break;
				case 'careturn':
					return $this->documentCAReturnModePagination($authority[0], array($employees['data'][0]['EmployeeCode'], $empbranch, $views, $employees['data'][0]['RegionID']), $where_filter, $where_condition);					
					
					break;					
				case 'allviews':
					return $this->documentAppAllModePagination($authority[0], array($employees['data'][0]['EmployeeCode'], $empbranch, $views, $employees['data'][0]['RegionID']), $where_filter, $where_condition);

					break;
		
		
			}
				
				
		}		
		
	}
	
	
	private function documentAppReconcileModePagination($authority, $condition = array(), $criteria, $optional){
		
		$wheres  = "";
		$filter_condition = "AND NOT SubmitDocToHQ BETWEEN '1900-01-01' AND '2014-12-31'";
		switch($authority) {
			case $this->role_ad:
		
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = " AND ReceivedDocFormLB IS NULL";
				else:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, '0', STR_PAD_LEFT)."'";
				endif;
		
				break;
			case $this->role_rm:
				$wheres	= " AND RMCode = '".$condition[0]."'";
		
				break;
			case $this->role_bm:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, '0', STR_PAD_LEFT)."'";
		
				break;
			case $this->role_am:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$condition[0]."' GROUP BY BranchCode)";
		
				break;
			case $this->role_rd:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$condition[3]."' GROUP BY BranchCode)";
		
				break;
			case $this->role_ads:
			case $this->role_hq:
			case $this->role_spv:
				$where  = '';
				break;
		
		}
		
		try {
		
			$result = $this->db->query("		
				SELECT * FROM (
					SELECT *, 
					CASE 
						WHEN NOT AFCancelReason = '' THEN 'InActive'
						WHEN [Status] = 'CANCEL' THEN 'InActive'
						WHEN [Status] = 'REJECT' THEN 'InActive'
						WHEN [Status] = 'APPROVED' THEN 'InActive'
						WHEN [Status] = 'CANCELBYRM' THEN 'InActive'
						WHEN [Status] = 'CANCELBYCUS' THEN 'InActive'
						WHEN [Status] = 'CANCELBYCA' THEN 'InActive'
						WHEN NOT SubmitDocToHQ IS NULL AND NOT ReceivedDocFormLB IS NULL AND NOT AppToCALog IS NULL THEN 'InActive'
						WHEN NOT SubmitDocToHQ IS NULL AND NOT ReceivedDocFormLB IS NULL AND NOT AppToCA IS NULL THEN 'InActive'
						WHEN NOT SubmitDocToHQ IS NULL AND NOT ReceivedDocFormLB IS NULL AND NOT AppToCA IS NULL AND NOT CAReturnDate IS NULL THEN 'InActive'
						ELSE 'Active'
					END AS ActiveRecord
					FROM (
						SELECT ReconcileDoc.DocID, [Profile].OwnerName, [Profile].Mobile, [Profile].Telephone, 
						LendingBranchs.RegionID, LendingBranchs.BranchCode, LendingBranchs.BranchDigit, [Profile].RMCode, 
						[Profile].RMName, [Profile].RMMobile, UPPER(Verification.RMProcess) AS RMProcess, ApplicationStatus.AFCancelReason,
						ApplicationStatus.[Status], ReconcileDoc.BorrowerName, ReconcileDoc.BorrowerType, NCBConsent.NCBCheck,
						NCBConsent.NCBCheckDate, ReconcileDoc.LogisticCode, ReconcileDoc.SubmitDocToHQ, ReconcileDoc. ReceivedDocFormLB,
						ReconcileDoc.CompletionDoc, ReconcileDoc.CompletionDate, ReconcileDoc.AppToCA, AppToCALog, ReconcileDoc.CAReturn,
						ReconcileDoc.CAReturnDate, ReconcileDocLogs.CAReturnDateLog, ReconcileDoc.IsActive, ReconcileDoc.IsRef,
						[Profile].CreateDate AS CreateProfileDate	
						FROM ReconcileDoc
						INNER JOIN NCBConsent
						ON ReconcileDoc.IsRef = NCBConsent.IsRef
						INNER JOIN [Profile]
						ON ReconcileDoc.DocID = [Profile].DocID AND [Profile].IsEnabled = 'A'
						INNER JOIN Verification
						ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
						INNER JOIN ApplicationStatus
						ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
						INNER JOIN LendingBranchs
						ON [Profile].BranchCode = LendingBranchs.BranchCode
						LEFT OUTER JOIN (
							SELECT DocID, DocOwner, COUNT(DocID) AS LackNums, IsRef
							FROM ReconcileCompletion
							WHERE NOT DocID = '0'
							AND DocType = 'M'
							AND IsActive = 'A'
							AND SubmitDocToCADate IS NULL
							GROUP BY DocID, DocOwner, IsRef
						) ReconcileMissing
						ON ReconcileDoc.IsRef = ReconcileMissing.IsRef
						LEFT OUTER JOIN (
							SELECT DocID, DocOwner, COUNT(DocID) AS ReturnNums, IsRef
							FROM ReconcileCompletion
							WHERE NOT DocID = '0' 
							AND DocType = 'R'
							AND IsActive = 'A'
							AND LBSubmitDocDate IS NOT NULL
							AND BranchReceivedDate IS NULL
							AND DocIsLock IS NULL
							GROUP BY DocID, DocOwner, IsRef
						) ReconcileReturn
						ON ReconcileDoc.IsRef = ReconcileReturn.IsRef
						LEFT OUTER JOIN (
							SELECT * FROM (
							SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
							DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
							CASE AppToCA
								WHEN '1900-01-01' THEN NULL
								WHEN '' THEN NULL
								ELSE CONVERT(nvarchar(10), AppToCA, 120)
							END AS AppToCALog,
							CASE CAReturnDate
								WHEN '1900-01-01' THEN NULL
								WHEN '' THEN NULL
								ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
							END AS CAReturnDateLog
							FROM ReconcileDocLogs) Tmp
							WHERE Numindex = 1				
						) ReconcileDocLogs
						ON ReconcileDoc.DocID = ReconcileDocLogs.DocLogs 
						AND ReconcileDoc.BorrowerType = ReconcileDocLogs.BorrowerType
						WHERE NOT LogisticCode IS NULL
						$filter_condition
						$optional
					) A
					WHERE IsActive = 'A'
				) Inquiry
				WHERE NOT CreateProfileDate IS NULL
				$wheres
				$criteria");
		
			return $result->num_rows();
		
		} catch(Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
		
		}

	}
	
	private function documentAppMissingModePagination($authority, $condition = array(), $criteria, $optional){
		
		$wheres  = "";
		$filter_condition = "AND NOT SubmitDocToHQ BETWEEN '1900-01-01' AND '2014-12-31'";
				
		switch($authority) {
			case $this->role_ad:
		
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = '';
				else:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, '0', STR_PAD_LEFT)."'";
				endif;
		
				break;
			case $this->role_rm:
				$wheres	= " AND RMCode = '".$condition[0]."'";
		
				break;
			case $this->role_bm:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, '0', STR_PAD_LEFT)."'";
		
				break;
			case $this->role_am:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$condition[0]."' GROUP BY BranchCode)";
		
				break;
			case $this->role_rd:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$condition[3]."' GROUP BY BranchCode)";
		
				break;
			case $this->role_ads:
			case $this->role_hq:
			case $this->role_spv:
				$where  = '';
				break;
		}
		
		try {
		
			$result = $this->db->query("
			SELECT * FROM (
				SELECT *, 
				CASE 
					WHEN NOT AFCancelReason = '' THEN 'InActive'
					WHEN [Status] = 'CANCEL' THEN 'InActive'
					WHEN [Status] = 'REJECT' THEN 'InActive'
					WHEN [Status] = 'APPROVED'
					AND  DrawdownDate IS NOT NULL
					AND  LackNums = 0 THEN 'InActive'
					WHEN [Status] = 'CANCELBYRM' THEN 'InActive'
					WHEN [Status] = 'CANCELBYCUS' THEN 'InActive'
					WHEN [Status] = 'CANCELBYCA' THEN 'InActive'
					WHEN LackNums >= 1 THEN 'Active'
					ELSE 'InActive'
				END AS ActiveRecord
				FROM (
					SELECT ReconcileDoc.DocID, [Profile].OwnerName, [Profile].Mobile, [Profile].Telephone, 
					LendingBranchs.RegionID, LendingBranchs.BranchCode, LendingBranchs.BranchDigit, [Profile].RMCode, 
					[Profile].RMName, [Profile].RMMobile, UPPER(Verification.RMProcess) AS RMProcess, ApplicationStatus.AFCancelReason,
					ApplicationStatus.[Status], ApplicationStatus.DrawdownDate, ReconcileDoc.BorrowerName, ReconcileDoc.BorrowerType, NCBConsent.NCBCheck,
					NCBConsent.NCBCheckDate, ReconcileDoc.LogisticCode, ReconcileDoc.SubmitDocToHQ, ReconcileDoc. ReceivedDocFormLB,
					ReconcileDoc.CompletionDoc, ReconcileDoc.CompletionDate, 
					CASE 
						WHEN ReconcileMissingStay.LackNumTotal <= 0 THEN ''
						WHEN ReconcileMissingStay.LackNumTotal IS NULL THEN ''
						ELSE ReconcileMissingStay.LackNumTotal
					END AS LackNumTotal,
					ReconcileMissing.LackNums, ReconcileReturn.ReturnNums,
					ReconcileDoc.AppToCA, ReconcileDoc.CAReturn, ReconcileDoc.CAReturnDate, ReconcileDoc.IsActive, ReconcileDoc.IsRef, 
					[Profile].CreateDate AS CreateProfileDate	
					FROM ReconcileDoc
					INNER JOIN NCBConsent
					ON ReconcileDoc.IsRef = NCBConsent.IsRef
					INNER JOIN [Profile]
					ON ReconcileDoc.DocID = [Profile].DocID AND [Profile].IsEnabled = 'A'
					INNER JOIN Verification
					ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
					INNER JOIN ApplicationStatus
					ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
					INNER JOIN LendingBranchs
					ON [Profile].BranchCode = LendingBranchs.BranchCode
					LEFT OUTER JOIN (
						SELECT DocID, COUNT(DocID) AS LackNumTotal, IsRef
						FROM ReconcileCompletion
						WHERE NOT DocID = '0'
						AND DocType = 'M'
						AND IsActive = 'A'
						GROUP BY DocID, IsRef
					) ReconcileMissingStay
					ON ReconcileDoc.IsRef = ReconcileMissingStay.IsRef	
					LEFT OUTER JOIN (
						SELECT DocID, DocOwner, COUNT(DocID) AS LackNums, IsRef
						FROM ReconcileCompletion
						WHERE NOT DocID = '0'
						AND DocType = 'M'
						AND IsActive = 'A'
						AND SubmitDocToCADate IS NULL
						GROUP BY DocID, DocOwner, IsRef
					) ReconcileMissing
					ON ReconcileDoc.IsRef = ReconcileMissing.IsRef
					LEFT OUTER JOIN (
						SELECT DocID, DocOwner, COUNT(DocID) AS ReturnNums, IsRef
						FROM ReconcileCompletion
						WHERE NOT DocID = '0'
						AND DocType = 'R'
						AND IsActive = 'A'
						AND LBSubmitDocDate IS NOT NULL
						AND BranchReceivedDate IS NULL
						AND DocIsLock IS NULL
						GROUP BY DocID, DocOwner, IsRef
					) ReconcileReturn
					ON ReconcileDoc.IsRef = ReconcileReturn.IsRef					
					WHERE NOT LogisticCode IS NULL
					$filter_condition
					$optional
				) A
				WHERE IsActive = 'A'
				AND LackNumTotal >= 1
			) Data
			WHERE NOT CreateProfileDate IS NULL
			$wheres
			$criteria");
		
			return $result->num_rows();
		
		} catch(Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
		
		}
		
	}	
	
	private function documentAppReturnModePagination($authority, $condition = array(), $criteria, $optional, $special){

		$wheres  = "";
		$filter_condition = "AND NOT SubmitDocToHQ BETWEEN '1900-01-01' AND '2014-12-31'";
			
		switch($authority) {
			case $this->role_ad:
		
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = '';
				else:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, '0', STR_PAD_LEFT)."'";
				endif;
		
				break;
			case $this->role_rm:
				$wheres	= " AND RMCode = '".$condition[0]."'";
		
				break;
			case $this->role_bm:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, '0', STR_PAD_LEFT)."'";
		
				break;
			case $this->role_am:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$condition[0]."' GROUP BY BranchCode)";
		
				break;
			case $this->role_rd:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$condition[3]."' GROUP BY BranchCode)";
		
				break;
			case $this->role_ads:
			case $this->role_hq:
			case $this->role_spv:
				$where  = '';
				break;
		
		}
		

		try {
		
			$result = $this->db->query("
			SELECT * FROM (
				SELECT *, 
				CASE 
					WHEN ReturnNums >= 1 THEN 'Active'
					WHEN ReturnNums <= 0 AND NOT Return_BranchReceivedDate IS NULL THEN 'InActive'	
					ELSE 'InActive'
				END AS ActiveRecord
				FROM (
					SELECT ReconcileDoc.DocID, [Profile].OwnerName, [Profile].Mobile, [Profile].Telephone, 
						LendingBranchs.RegionID, LendingBranchs.BranchCode, LendingBranchs.BranchDigit, [Profile].RMCode, 
						[Profile].RMName, [Profile].RMMobile, UPPER(Verification.RMProcess) AS RMProcess, ApplicationStatus.AFCancelReason,
						ApplicationStatus.[Status], ReconcileDoc.BorrowerName, ReconcileDoc.BorrowerType, NCBConsent.NCBCheck,
						NCBConsent.NCBCheckDate, ReconcileDoc.LogisticCode, ReconcileDoc.SubmitDocToHQ, ReconcileDoc. ReceivedDocFormLB,
						ReconcileDoc.CompletionDoc, ReconcileDoc.CompletionDate, 
						CASE 
							WHEN ReconcileMissing.LackNums <= 0 THEN ''
							WHEN ReconcileMissing.LackNums IS NULL THEN ''
							ELSE ReconcileMissing.LackNums
						END AS LackNums,
						CASE 
							WHEN ReconcileReturnStay.ReturnTotal <= 0 THEN ''
							WHEN ReconcileReturnStay.ReturnTotal IS NULL THEN ''
							ELSE ReconcileReturnStay.ReturnTotal
						END AS ReturnTotal,
						CASE 
							WHEN ReconcileReturn.ReturnNums <= 0 THEN ''
							WHEN ReconcileReturn.ReturnNums IS NULL THEN ''
							ELSE ReconcileReturn.ReturnNums
						END AS ReturnNums,
						ReconcileDoc.AppToCA, ReconcileDoc.CAReturn, ReconcileDoc.CAReturnDate, ReconcileDoc.IsActive, ReconcileDoc.IsRef,
						ReconcileReturnDocStay.LBSubmitDocDate AS ReturnDoc_LBSubmitToDate,
						ReconcileReturnDoc.LBSubmitDocDate AS Return_LBSubmitDocDate, 
						ReconcileReturnDoc.HQReceivedDocFromLBDate AS Return_HQReceivedDocFromLBDate, 
						ReconcileReturnDoc.SubmitDocToCADate AS Return_SubmitDocToCADate, 
						ReconcileReturnDoc.CAReturnDate AS Return_CAReturnDate, 
						ReconcileReturnDoc.HQSentToLBDate AS Return_HQSentToLBDate, 
						ReconcileReturnDoc.BranchReceivedDate AS Return_BranchReceivedDate,
						[Profile].CreateDate AS CreateProfileDate	
					FROM ReconcileDoc
					INNER JOIN NCBConsent
					ON ReconcileDoc.IsRef = NCBConsent.IsRef
					INNER JOIN [Profile]
					ON ReconcileDoc.DocID = [Profile].DocID AND [Profile].IsEnabled = 'A'
					INNER JOIN Verification
					ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
					INNER JOIN ApplicationStatus
					ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
					INNER JOIN LendingBranchs
					ON [Profile].BranchCode = LendingBranchs.BranchCode
					LEFT OUTER JOIN (
						SELECT DocID, DocOwner, COUNT(DocID) AS LackNums, IsRef
						FROM ReconcileCompletion
						WHERE NOT DocID = '0'
						AND DocType = 'M'
						AND IsActive = 'A'
						AND SubmitDocToCADate IS NULL
						GROUP BY DocID, DocOwner, IsRef
					) ReconcileMissing
					ON ReconcileDoc.IsRef = ReconcileMissing.IsRef
					LEFT OUTER JOIN (
						SELECT DocID, COUNT(DocID) AS ReturnTotal, IsRef
						FROM ReconcileCompletion
						WHERE NOT DocID = '0'
						AND DocType = 'R'
						AND IsActive = 'A'
						AND LBSubmitDocDate IS NOT NULL
						AND DocIsLock IS NULL
						GROUP BY DocID, IsRef
					) ReconcileReturnStay
					ON ReconcileDoc.IsRef = ReconcileReturnStay.IsRef	
					LEFT OUTER JOIN (
						SELECT DocID, DocOwner, COUNT(DocID) AS ReturnNums, IsRef
						FROM ReconcileCompletion
						WHERE NOT DocID = '0'
						AND DocType = 'R'
						AND IsActive = 'A'
						AND LBSubmitDocDate IS NOT NULL
						AND BranchReceivedDate IS NULL
						AND DocIsLock IS NULL
						GROUP BY DocID, DocOwner, IsRef
					) ReconcileReturn
					ON ReconcileDoc.IsRef = ReconcileReturn.IsRef	
					LEFT OUTER JOIN (
						SELECT * FROM (
							SELECT DocID, LBSubmitDocDate, IsRef, ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY LBSubmitDocDate ASC, DocOwner ASC) as Numindex
							FROM ReconcileCompletion
							WHERE IsActive = 'A'
							AND DocType = 'R'
							AND LBSubmitDocDate IS NOT NULL
							AND DocIsLock IS NULL
						) A
						WHERE Numindex = '1'
					) AS ReconcileReturnDocStay
					ON ReconcileDoc.DocID = ReconcileReturnDocStay.DocID 
					AND ReconcileDoc.IsRef = ReconcileReturnDocStay.IsRef
					LEFT OUTER JOIN (
						SELECT * FROM (
							SELECT 
								DocID, LBSubmitDocDate, HQReceivedDocFromLBDate, SubmitDocToCADate, CAReturnDate, HQSentToLBDate, BranchReceivedDate, IsActive, IsRef,
								ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY LBSubmitDocDate ASC, DocOwner ASC) as Numindex
							FROM ReconcileCompletion
							WHERE IsActive = 'A'
							AND DocType = 'R'
							AND LBSubmitDocDate IS NOT NULL
							AND BranchReceivedDate IS NOT NULL
							AND DocIsLock IS NULL
						) A
						WHERE Numindex = '1'
					) AS ReconcileReturnDoc
					ON ReconcileDoc.DocID = ReconcileReturnDoc.DocID 
					AND ReconcileDoc.IsRef = ReconcileReturnDoc.IsRef	
					WHERE NOT LogisticCode IS NULL
					$filter_condition
					$optional
					) A
					WHERE IsActive = 'A'
					$special
				) Data
				WHERE NOT CreateProfileDate IS NULL
				$wheres
				$criteria");
		
			return $result->num_rows();
		
		} catch(Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
		
		}
		
	}
	
	private function documentCAReturnModePagination($authority, $condition = array(), $criteria, $optional){
	
		$wheres  = "";
		$filter_condition = "AND NOT SubmitDocToHQ BETWEEN '1900-01-01' AND '2014-12-31'";
			
		switch($authority) {
			case $this->role_ad:
		
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = '';
				else:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, '0', STR_PAD_LEFT)."'";
				endif;
		
				break;
			case $this->role_rm:
				$wheres	= " AND RMCode = '".$condition[0]."'";
		
				break;
			case $this->role_bm:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, '0', STR_PAD_LEFT)."'";
		
				break;
			case $this->role_am:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$condition[0]."' GROUP BY BranchCode)";
		
				break;
			case $this->role_rd:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$condition[3]."' GROUP BY BranchCode)";
		
				break;
			case $this->role_ads:
			case $this->role_hq:
			case $this->role_spv:
				$where  = '';
				break;
		
		}
	
	
		try {
	
			$result = $this->db->query("		
			SELECT * FROM (
				SELECT *, 
				CASE 
					WHEN NOT AFCancelReason = '' THEN 'InActive'
					WHEN [Status] = 'CANCEL' THEN 'InActive'
					WHEN [Status] = 'REJECT' THEN 'InActive'
					WHEN [Status] = 'APPROVED' THEN 'InActive'
					WHEN [Status] = 'CANCELBYRM' THEN 'InActive'
					WHEN [Status] = 'CANCELBYCUS' THEN 'InActive'
					WHEN [Status] = 'CANCELBYCA' THEN 'InActive'
					WHEN NOT SubmitDocToHQ IS NULL AND NOT ReceivedDocFormLB IS NULL AND NOT AppToCA IS NULL THEN 'InActive'
					WHEN NOT SubmitDocToHQ IS NULL AND NOT ReceivedDocFormLB IS NULL AND NOT AppToCA IS NULL AND NOT CAReturnDate IS NULL THEN 'InActive'
					ELSE 'Active'
				END AS ActiveRecord
				FROM (
					SELECT ReconcileDoc.DocID, [Profile].OwnerName, [Profile].Mobile, [Profile].Telephone, 
						LendingBranchs.RegionID, LendingBranchs.BranchCode, LendingBranchs.BranchDigit, [Profile].RMCode, 
						[Profile].RMName, [Profile].RMMobile, UPPER(Verification.RMProcess) AS RMProcess, ApplicationStatus.AFCancelReason,
						ApplicationStatus.[Status], ReconcileDoc.BorrowerName, ReconcileDoc.BorrowerType, NCBConsent.NCBCheck,
						NCBConsent.NCBCheckDate, ReconcileDoc.LogisticCode, ReconcileDoc.SubmitDocToHQ, ReconcileDoc. ReceivedDocFormLB,
						ReconcileDoc.CompletionDoc, ReconcileDoc.CompletionDate, ReconcileDoc.AppToCA, AppToCALog, ReconcileDoc.CAReturn,
						ReconcileDoc.CAReturnDate, ReconcileDocLogs.CAReturnDateLog, ReconcileDoc.IsActive, ReconcileDoc.IsRef,
						[Profile].CreateDate AS CreateProfileDate		
					FROM ReconcileDoc
					INNER JOIN NCBConsent
					ON ReconcileDoc.IsRef = NCBConsent.IsRef
					INNER JOIN [Profile]
					ON ReconcileDoc.DocID = [Profile].DocID AND [Profile].IsEnabled = 'A'
					INNER JOIN Verification
					ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
					INNER JOIN ApplicationStatus
					ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
					INNER JOIN LendingBranchs
					ON [Profile].BranchCode = LendingBranchs.BranchCode
					LEFT OUTER JOIN (
							SELECT DocID, DocOwner, COUNT(DocID) AS LackNums, IsRef
							FROM ReconcileCompletion
							WHERE NOT DocID = '0'
							AND DocType = 'M'
							AND IsActive = 'A'
							AND SubmitDocToCADate IS NULL
							GROUP BY DocID, DocOwner, IsRef
					) ReconcileMissing
					ON ReconcileDoc.IsRef = ReconcileMissing.IsRef
					LEFT OUTER JOIN (
						SELECT DocID, DocOwner, COUNT(DocID) AS ReturnNums, IsRef
						FROM ReconcileCompletion
						WHERE NOT DocID = '0'
						AND DocType = 'R'
						AND IsActive = 'A'
						AND LBSubmitDocDate IS NOT NULL
						AND BranchReceivedDate IS NULL
						AND DocIsLock IS NULL
						GROUP BY DocID, DocOwner, IsRef
					) ReconcileReturn
					ON ReconcileDoc.IsRef = ReconcileReturn.IsRef
					LEFT OUTER JOIN (
						SELECT * FROM (
						SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID ASC, BorrowerType ASC) as Numindex,
						DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, AppToCA AS AppToCALog, CAReturnDate AS CAReturnDateLog		
						FROM ReconcileDocLogs WHERE IsActive = 'A') Tmp	
						WHERE Numindex = 1				
					) ReconcileDocLogs
					ON ReconcileDoc.DocID = ReconcileDocLogs.DocLogs 
					AND ReconcileDoc.BorrowerType = ReconcileDocLogs.BorrowerType
					WHERE NOT LogisticCode IS NULL	
					AND AppToCA IS NULL
					AND NOT CAReturnDateLog IS NULL		
					$filter_condition	
					$optional
				) A
				WHERE IsActive = 'A'							
			) Inquiry
			WHERE NOT CreateProfileDate IS NULL	
			$wheres
			$criteria");
	
			return $result->num_rows();
	
		} catch(Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
	
		}
	
	}
	
	private function documentAppAllModePagination($authority, $condition = array(), $criteria, $optional){

		$wheres  = "";
		$filter_condition = "AND NOT SubmitDocToHQ BETWEEN '1900-01-01' AND '2014-12-31'";
		
		switch($authority) {
			case $this->role_ad:
		
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = '';
				else:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, '0', STR_PAD_LEFT)."'";
				endif;
		
				break;
			case $this->role_rm:
				$wheres	= " AND RMCode = '".$condition[0]."'";
		
				break;
			case $this->role_bm:
				$wheres = " AND BranchCode = '".str_pad($condition[1], 3, '0', STR_PAD_LEFT)."'";
		
				break;
			case $this->role_am:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$condition[0]."' GROUP BY BranchCode)";
		
				break;
			case $this->role_rd:
				$wheres = " AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$condition[3]."' GROUP BY BranchCode)";
		
				break;
			case $this->role_ads:
			case $this->role_hq:
			case $this->role_spv:
				$where  = '';
				break;
		
		}
				
		try {
		
			$result = $this->db->query("
				SELECT * FROM (
					SELECT *, 
					CASE 
						WHEN NOT AFCancelReason = '' THEN 'InActive'
						WHEN [Status] = 'CANCEL' THEN 'InActive'
						WHEN [Status] = 'REJECT' THEN 'InActive'
						WHEN [Status] = 'APPROVED' THEN 'InActive'
						WHEN [Status] = 'CANCELBYRM' THEN 'InActive'
						WHEN [Status] = 'CANCELBYCUS' THEN 'InActive'
						WHEN [Status] = 'CANCELBYCA' THEN 'InActive'
						WHEN NOT SubmitDocToHQ IS NULL AND NOT ReceivedDocFormLB IS NULL
						 	AND NOT CompletionDoc IS NULL AND NOT CompletionDate IS NULL 
						 	AND CompletionDoc = 'Y' AND NOT AppToCA IS NULL
		 				 	AND LackNums = 0 AND ReturnNums = 0 THEN 'InActive'
						WHEN NOT SubmitDocToHQ IS NULL AND NOT ReceivedDocFormLB IS NULL
						 	AND NOT CompletionDoc IS NULL AND NOT CompletionDate IS NULL 
						 	AND CompletionDoc = 'Y' AND NOT AppToCA IS NULL
						 	AND LackNums = 0 AND ReturnNums = 0
						 	AND NOT CAReturnDate IS NULL
						THEN 'InActive'
						ELSE 'Active'
					END AS ActiveRecord
					FROM (
						SELECT ReconcileDoc.DocID, [Profile].OwnerName, [Profile].Mobile, [Profile].Telephone, 
						LendingBranchs.RegionID, LendingBranchs.BranchCode, LendingBranchs.BranchDigit, [Profile].RMCode, 
						[Profile].RMName, [Profile].RMMobile, UPPER(Verification.RMProcess) AS RMProcess, ApplicationStatus.AFCancelReason,
						ApplicationStatus.[Status], ReconcileDoc.BorrowerName, ReconcileDoc.BorrowerType, NCBConsent.NCBCheck,
						NCBConsent.NCBCheckDate, ReconcileDoc.LogisticCode, ReconcileDoc.SubmitDocToHQ, ReconcileDoc. ReceivedDocFormLB,
						ReconcileDoc.CompletionDoc, ReconcileDoc.CompletionDate, LackNums, ReturnNums,
						ReconcileDoc.AppToCA, AppToCALog, ReconcileDoc.CAReturn,
						ReconcileDoc.CAReturnDate, ReconcileDocLogs.CAReturnDateLog, ReconcileDoc.IsActive, ReconcileDoc.IsRef,
						[Profile].CreateDate AS CreateProfileDate
						FROM ReconcileDoc
						INNER JOIN NCBConsent
						ON ReconcileDoc.IsRef = NCBConsent.IsRef
						INNER JOIN [Profile]
						ON ReconcileDoc.DocID = [Profile].DocID AND [Profile].IsEnabled = 'A'
						INNER JOIN Verification
						ON [Profile].DocID = Verification.DocID AND Verification.IsEnabled = 'A'
						INNER JOIN ApplicationStatus
						ON [Profile].DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
						INNER JOIN LendingBranchs
						ON [Profile].BranchCode = LendingBranchs.BranchCode
						LEFT OUTER JOIN (
								SELECT DocID, DocOwner, COUNT(DocID) AS LackNums, IsRef
								FROM ReconcileCompletion
								WHERE NOT DocID = '0'
								AND DocType = 'M'
								AND IsActive = 'A'
								AND SubmitDocToCADate IS NULL
								GROUP BY DocID, DocOwner, IsRef
						) ReconcileMissing
						ON ReconcileDoc.IsRef = ReconcileMissing.IsRef
						LEFT OUTER JOIN (
							SELECT DocID, DocOwner, COUNT(DocID) AS ReturnNums, IsRef
							FROM ReconcileCompletion
							WHERE DocType = 'R'
							AND IsActive = 'A'
							AND LBSubmitDocDate IS NOT NULL
							AND BranchReceivedDate IS NULL
							AND DocIsLock IS NULL
							GROUP BY DocID, DocOwner, IsRef
						) ReconcileReturn
						ON ReconcileDoc.IsRef = ReconcileReturn.IsRef
						LEFT OUTER JOIN (
							SELECT * FROM (
							SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
							DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
							CASE AppToCA
								WHEN '1900-01-01' THEN NULL
								WHEN '' THEN NULL
								ELSE CONVERT(nvarchar(10), AppToCA, 120)
							END AS AppToCALog,
							CASE CAReturnDate
								WHEN '1900-01-01' THEN NULL
								WHEN '' THEN NULL
								ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
							END AS CAReturnDateLog
							FROM ReconcileDocLogs WHERE IsActive = 'A') Tmp
							WHERE Numindex = 1				
						) ReconcileDocLogs
						ON ReconcileDoc.DocID = ReconcileDocLogs.DocLogs 
						AND ReconcileDoc.BorrowerType = ReconcileDocLogs.BorrowerType						
						WHERE NOT LogisticCode IS NULL
						$filter_condition
						$optional
					) A
					WHERE IsActive = 'A'
				) Data
				WHERE NOT CreateProfileDate IS NULL
				$wheres
				$criteria");

			return $result->num_rows();
		
		} catch(Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
		
		}
		
	}
	
	
	public function getLatestReturnLogs($table_logs, $condition = array()) {
		
		switch ($table_logs) {
			case 'NCB':
				
					$result = $this->db->query("
							SELECT OperReturn,
							CASE OperReturnDate
								WHEN '1900-01-01' THEN NULL
								ELSE OperReturnDate
							END AS OperReturnDate
							FROM ReconcileDocLogs
							WHERE DocID = '".$condition."'
							ORDER BY OperReturnDate DESC
						");
					
					return $result->result_array();
				
				break;
			case 'APP':
					
					$result = $this->db->query("
						SELECT CAReturn,
						CASE CAReturnDate 
							WHEN '1900-01-01' THEN NULL
							ELSE CAReturnDate
						END AS CAReturnDate
						FROM ReconcileDocLogs
						WHERE DocID = '".$condition."'
						ORDER BY CAReturnDate DESC		
					");
					
					return $result->result_array();
				
				break;
			
		}

	}
	
	// Defend Zone Model
	public function getDefendListRecorder($authority, $condition = array()) {
		$this->load->model('dbcustom');
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		$startdate           		= $this->input->post('defend_start');
		$enddate            	    = $this->input->post('defend_end');
		$customers					= $this->input->post('customer');
		$status						= $this->input->post('status');
		$rmname						= $this->input->post('rmname');
		$caname						= $this->input->post('caname');
		$defend_process				= $this->input->post('def_process');
		$defend_type				= $this->input->post('def_type');
		$defendname					= $this->input->post('defendname');
		$region						= $this->input->post('regions');
		$branchs					= $this->input->post('branchs');
		$views						= $this->input->post('views');
		
		$pieces = explode(',', $branchs);
		if(!empty($pieces[0])):
			$where_brachs 	= "'".implode("','", $pieces)."'";
		else:
			$where_brachs   = "";
		endif;
		
		$rmlist_pieces = explode(',', $rmname);
		if(!empty($rmlist_pieces[0])):
			$wheres_rmlist   = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $rmlist_pieces)."'");
		else:
			$wheres_rmlist   = "";
		endif;
		
		$def_process_piece = explode(',', $defend_process);
		if(!empty($def_process_piece[0])):
			$wheres_defprocess   = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $def_process_piece)."'");
		else:
			$wheres_defprocess   = "";
		endif;
		
		$def_type_piece = explode(',', $defend_type);
		if(!empty($def_type_piece[0])):
			$wheres_deftype   = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $def_type_piece)."'");
		else:
			$wheres_deftype   = "";
		endif;
		
		$status_pieces = explode(',', $status);
		if(!empty($status_pieces[0])):
			$wheres_status 	= "'".implode("','", $status_pieces)."'";
		else:
			$wheres_status   = "";
		endif;
	
		$defenddate_start  			= !empty($startdate) ? $this->effective->StandartDateSorter($startdate):"";
		$defenddate_end	   			= !empty($enddate) ? $this->effective->StandartDateSorter($enddate):"";
	
		$wheres						= "";
		$where_option				= "";
		$where_filter				= "";
	
		if(!empty($defenddate_start) && !empty($defenddate_end)) { 
			$where_filter .= " AND CONVERT(nvarchar(10), DefendDate, 120) BETWEEN '".$defenddate_start."' AND '".$defenddate_end."'";
			
		} else {
	
			if(!empty($defenddate_start)) { $where_filter .= " AND CONVERT(nvarchar(10), DefendDate, 120)  = '".$defenddate_start."'"; }
			if(!empty($defenddate_end)) { $where_filter .= " AND CONVERT(nvarchar(10), DefendDate, 120)  = '".$defenddate_end."'"; }
	
		}
	
		// Optional Query
		if(!empty($defendname)) { $where_filter .= " AND DefendBy LIKE '%".$this->effective->set_chartypes($this->char_mode, $defendname)."%'"; }
		if(!empty($caname)) { $where_filter .= " AND CAName LIKE '%".$this->effective->set_chartypes($this->char_mode, $caname)."%'"; }
		if(!empty($customers)) {
			$where_option .= " AND NCBConsent.BorrowerName LIKE '%".$this->effective->set_chartypes($this->char_mode, $customers)."%'";
		}
	
		if(!empty($region)) { $where_filter .= " AND RegionID = '".trim(str_pad($region, 2, "0", STR_PAD_LEFT))."'"; }
		if(!empty($branchs[0])) { $where_filter .= " AND BranchDigit in ($where_brachs) "; }
		if(!empty($rmlist_pieces[0])) { $where_filter .= " AND RMCode in ($wheres_rmlist) "; }
		if(!empty($def_process_piece[0])) { $where_filter .= " AND DefendProcess in ($wheres_defprocess) "; }
		if(!empty($def_type_piece[0])) { $where_filter .= " AND ProposerType in ($wheres_deftype) "; }
		if(!empty($status_pieces[0])) { $where_filter .= " AND  [Status] in ($wheres_status) "; }
	
		if($views == "Active"): 
			$where_filter .= " AND ActiveRecord = '".$views."'"; 
		endif;
		
		if($views == "InActive"): 
			$where_filter .= " AND ActiveRecord = '".$views."'";
		endif;
	
		$iStart   = $this->input->post('start');
		$iLength  = $this->input->post('length') ? $iLength = $this->input->post('length') : 10;
	
		$start	  = ($iStart)? $iStart : 0;
		$offset   = $iLength + $start;
		
		$Ordering = $this->get_ordering();
	
		if(empty($authority)) {
	
			$objForms = array(
				"Privileges" => $authority,
				"Condition"	 => $condition,
				"Optional"	 => $optional
			);
	
			log_message('error', 'method '.__METHOD__ .'can not load data. Please you are check object criteria in parameter.');
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
	
		} else {
	
			if(count($authority) > 1) :
				$privileges = $authority[0];
			else:
				$privileges = $authority[0];
			endif;
	
			$employees = $this->dbcustom->employeesInfo($condition[0]);
			$empbranch = str_pad($employees['data'][0]['BranchCode'], 3, "0", STR_PAD_LEFT);
			
			switch($privileges) {
				case $this->role_ad:
						
					if($empbranch == "000" || $empbranch == "901"):
						$wheres = '';
					else:
						$wheres = " AND BranchCode = '".str_pad($empbranch, 3, '0', STR_PAD_LEFT)."'";
					endif;
						
					break;
				case $this->role_rm:
					$wheres	= " AND RMCode = '".$condition[0]."'";
						
					break;
				case $this->role_bm:
					$wheres = " AND BranchCode = '".str_pad($empbranch, 3, '0', STR_PAD_LEFT)."'";
						
					break;
				case $this->role_am:
					$wheres = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$condition[0]."' GROUP BY BranchCode)";
						
					break;
				case $this->role_rd:
					$wheres = " AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)";
						
					break;			
				case $this->role_hq:
				case $this->role_spv:
					$wheres = '';
					
					break;
				case $this->role_ads:
					$wheres = '';
					
					break;
						
			}
		
			try {
			
					$result = $this->dbmodel->CIQuery("			 
					SELECT * FROM															
					(	SELECT *, ROW_NUMBER() OVER (ORDER BY $Ordering) AS KeyPoint
						FROM(
						SELECT
						DefendHead.DocID, COUNTNUM, Times, DefendFill.Fill_Item, DefendSubscription.Lists,
						CASE DefendHead.DefendDate
							WHEN '1900-01-01' THEN NULL
							ELSE CONVERT(nvarchar(10), DefendHead.DefendDate, 120)
						END AS DefendDate, LatestUpdateItem, DefendHead.DefendProcess, DefendHead.ProposerType,
						CASE DefendProcess
							WHEN 'Before Process' THEN 'B'
							WHEN 'On Process' THEN 'P'
							WHEN 'After Process' THEN 'R'
						END AS DefendModule,
						DefendHead.DefendEmpID, DefendHead.DefendEmpName AS DefendBy, LendingEmp.Mobile AS DefendMobile,
						[Profile].OwnerName, NCBConsent.BorrowerName,
						[Profile].Mobile, [Profile].Telephone, LendingBranchs.RegionID, LendingBranchs.BranchCode, 
						LendingBranchs.BranchDigit, LendingBranchs.BranchTel, [Profile].RMCode, [Profile].RMName, 
						[Profile].RMMobile, ApplicationStatus.CAName,
						CASE
							WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL 
							AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CR'
							WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
							WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'P'
							WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PA'
							WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'A'
							WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'R'
							WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'C'
							WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'C'
							WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'C'
							WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'C'
							ELSE NULL
						END AS [Status], 
						CASE ApplicationStatus.StatusDate
							WHEN '1900-01-01' THEN NULL
							ELSE CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120)
						END AS StatusDate, StatusReason, AppComment, 									
						CASE 
							WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'InActive'
							WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'InActive'
							WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'InActive'
							WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'InActive'
							WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'InActive'
							WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'InActive'
							WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
							ELSE 'Active'
						END AS ActiveRecord, DefendHead.IsActive
						FROM 
						(	SELECT DocID, MAX(DefendRef) AS Times, COUNT(Point) AS COUNTNUM
							FROM (SELECT DocID, DefendRef,  ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY DocID DESC) AS Point
							FROM [dbo].[DefendHead]
							WHERE IsActive = 'A'
							) AS Data
							GROUP BY DocID
						) AS Filter
						INNER JOIN [dbo].DefendHead
						ON Filter.DocID = DefendHead.DocID
						AND Filter.Times = DefendHead.DefendRef
						INNER JOIN [dbo].[Profile]
						ON Filter.DocID = [Profile].DocID 
						AND NOT [Profile].CreateDate IS NULL AND [Profile].IsEnabled = 'A'
						INNER JOIN [dbo].Verification
						ON Filter.DocID = Verification.DocID AND Verification.IsEnabled = 'A'
						INNER JOIN [dbo].ApplicationStatus
						ON Filter.DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
						LEFT OUTER JOIN [dbo].MasterProcessCancelReason
						ON Verification.RMProcessReason = MasterProcessCancelReason.ProcessCode
						LEFT OUTER JOIN [dbo].NCBConsent
						ON Filter.DocID = NCBConsent.DocID  AND BorrowerType = '101' AND NCBConsent.IsActive = 'A'
						LEFT OUTER JOIN [dbo].LendingBranchs
						ON [Profile].BranchCode = LendingBranchs.BranchCode
						LEFT OUTER JOIN [dbo].LendingEmp
						ON DefendHead.DefendEmpID = LendingEmp.EmployeeCode
						LEFT OUTER JOIN (SELECT DocID, COUNT(DocID) AS Fill_Item FROM [dbo].DefendSubscription WHERE NOT DefendNote = '' GROUP BY DocID) AS DefendFill
						ON Filter.DocID = DefendFill.DocID 
						LEFT OUTER JOIN (SELECT DocID, COUNT(DocID) AS Lists FROM [dbo].DefendSubscription GROUP BY DocID) AS DefendSubscription
						ON Filter.DocID = DefendSubscription.DocID 
						LEFT OUTER JOIN (
							SELECT TOP 1 DocID, DefendRef,
							CASE CreateDate
								WHEN '1900-01-01' THEN NULL
								ELSE CONVERT(nvarchar(10), CreateDate, 120)
							END AS LatestUpdateItem
							FROM [dbo].DefendSubscription
							GROUP BY DocID, DefendRef, CreateDate
							ORDER BY CreateDate DESC
						) LatestUpdate
						ON Filter.DocID = LatestUpdate.DocID 
						AND Filter.Times = LatestUpdate.DefendRef 
						LEFT OUTER JOIN 
						(	SELECT * 
							FROM (
								SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
								DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
								CASE CAReturnDate
									WHEN '1900-01-01' THEN NULL
									WHEN '' THEN NULL
									ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
								END AS CAReturnDateLog
								FROM [dbo].ReconcileDocLogs) Tmp
							WHERE Numindex = 1		
						) ReconcileDocLogs
						ON [Profile].DocID = ReconcileDocLogs.DocLogs AND ReconcileDocLogs.BorrowerType = '101'
						WHERE NOT [Profile].DocID IS NULL
						$where_option
					) AS DataRecord
					WHERE IsActive = 'A'
					$wheres
					$where_filter
				) Data
				WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
			
				return $result;
	
			} catch(Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			
			}
		
		}	
		
	}
	
	public function getDefendListPagination($authority, $condition = array()) {
		$this->load->model('dbcustom');
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		$startdate           		= $this->input->post('defend_start');
		$enddate            	    = $this->input->post('defend_end');
		$customers					= $this->input->post('customer');
		$rmname						= $this->input->post('rmname');
		$status						= $this->input->post('status');
		$caname						= $this->input->post('caname');
		$defend_process				= $this->input->post('def_process');
		$defend_type				= $this->input->post('def_type');
		$defendname					= $this->input->post('defendname');
		$region						= $this->input->post('regions');
		$branchs					= $this->input->post('branchs');
		$views						= $this->input->post('views');
		
		$pieces = explode(',', $branchs);
		if(!empty($pieces[0])):
			$where_brachs 	= "'".implode("','", $pieces)."'";
		else:
			$where_brachs   = "";
		endif;
		
		$rmlist_pieces = explode(',', $rmname);
		if(!empty($rmlist_pieces[0])):
			$wheres_rmlist   = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $rmlist_pieces)."'");
		else:
			$wheres_rmlist   = "";
		endif;
		
		$def_process_piece = explode(',', $defend_process);
		if(!empty($def_process_piece[0])):
			$wheres_defprocess   = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $def_process_piece)."'");
		else:
			$wheres_defprocess   = "";
		endif;
		
		$def_type_piece = explode(',', $defend_type);
		if(!empty($def_type_piece[0])):
			$wheres_deftype   = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $def_type_piece)."'");
		else:
			$wheres_deftype   = "";
		endif;
		
		$status_pieces = explode(',', $status);
		if(!empty($status_pieces[0])):
			$wheres_status 	= "'".implode("','", $status_pieces)."'";
		else:
			$wheres_status   = "";
		endif;
	
		$defenddate_start  			= !empty($startdate) ? $this->effective->StandartDateSorter($startdate):"";
		$defenddate_end	   			= !empty($enddate) ? $this->effective->StandartDateSorter($enddate):"";
	
		$wheres						= "";
		$where_option				= "";
		$where_filter				= "";
	
		if(!empty($defenddate_start) && !empty($defenddate_end)) { $where_filter .= " AND CONVERT(nvarchar(10), DefendDate, 120) BETWEEN '".$defenddate_start."' AND '".$defenddate_end."'"; }
		else {
	
			if(!empty($defenddate_start)) { $where_filter .= " AND CONVERT(nvarchar(10), DefendDate, 120)  = '".$defenddate_start."'"; }
			if(!empty($defenddate_end)) { $where_filter .= " AND CONVERT(nvarchar(10), DefendDate, 120)  = '".$defenddate_end."'"; }
	
		}
	
		// Optional Query
		//if(!empty($rmname)) { $where_filter .= " AND RMName LIKE '%".$this->effective->set_chartypes($this->char_mode, $rmname)."%'"; }
		//if(!empty($defend_process)) { $where_filter .= " AND DefendProcess LIKE '%".$this->effective->set_chartypes($this->char_mode, $defend_process)."%'"; }
		if(!empty($defendname)) { $where_filter .= " AND DefendBy LIKE '%".$this->effective->set_chartypes($this->char_mode, $defendname)."%'"; }
		if(!empty($caname)) { $where_filter .= " AND CAName LIKE '%".$this->effective->set_chartypes($this->char_mode, $caname)."%'"; }
		if(!empty($customers)) {
			$where_option .= " AND NCBConsent.BorrowerName LIKE '%".$this->effective->set_chartypes($this->char_mode, $customers)."%'";
		}
	
		if(!empty($region)) { $where_filter .= " AND RegionID = '".trim(str_pad($region, 2, "0", STR_PAD_LEFT))."'"; }
		if(!empty($branchs[0])) { $where_filter .= " AND BranchDigit in ($where_brachs) "; }
		if(!empty($rmlist_pieces[0])) { $where_filter .= " AND RMCode in ($wheres_rmlist) "; }
		if(!empty($def_process_piece[0])) { $where_filter .= " AND DefendProcess in ($wheres_defprocess) "; }
		if(!empty($def_type_piece[0])) { $where_filter .= " AND ProposerType in ($wheres_deftype) "; }
		if(!empty($status_pieces[0])) { $where_filter .= " AND  [Status] in ($wheres_status) "; }
		//if(!empty($branchs)) { $where_filter .= " AND BranchDigit = '".$branchs."'"; }
	
		if($views == "Active"): $where_filter .= " AND ActiveRecord = '".$views."'"; endif;
		if($views == "InActive"): $where_filter .= " AND ActiveRecord = '".$views."'"; endif;
	
		$iStart  = $this->input->post('start');
		$iLength = $this->input->post('length') ? $iLength = $this->input->post('length') : 10;
	
		$start	 = ($iStart)? $iStart : 0;
		$offset  = $iLength + $start;
		
		if(empty($authority)) {
	
			$objForms = array(
					"Privileges" => $authority,
					"Condition"	 => $condition,
					"Optional"	 => $optional
			);
	
			log_message('error', 'method '.__METHOD__ .'can not load data. Please you are check object criteria in parameter.');
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
	
		} else {
	
			if(count($authority) > 1) :
			$privileges = $authority[0];
			else:
			$privileges = $authority[0];
			endif;
	
			$employees = $this->dbcustom->employeesInfo($condition[0]);
			$empbranch = str_pad($employees['data'][0]['BranchCode'], 3, "0", STR_PAD_LEFT);
			
			switch($privileges) {
				case $this->role_ad:
			
					if($empbranch == "000" || $empbranch == "901"):
					$wheres = '';
					else:
					$wheres = " AND BranchCode = '".str_pad($empbranch, 3, '0', STR_PAD_LEFT)."'";
					endif;
			
					break;
				case $this->role_rm:
					$wheres	= " AND RMCode = '".$condition[0]."'";
			
					break;
				case $this->role_bm:
					$wheres = " AND BranchCode = '".str_pad($empbranch, 3, '0', STR_PAD_LEFT)."'";
			
					break;
				case $this->role_am:
					$wheres = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$condition[0]."' GROUP BY BranchCode)";
			
					break;
				case $this->role_rd:
					$wheres = " AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)";
			
					break;
						
				case $this->role_hq:
				case $this->role_spv:
					$wheres = '';
					break;
				case $this->role_ads:
					$wheres = '';
					break;
			
			}
	
			try {
					
				$result = $this->db->query("			
					SELECT *
						FROM(
						SELECT
						DefendHead.DocID, COUNTNUM, Times, DefendFill.Fill_Item, DefendSubscription.Lists,
						CASE DefendHead.DefendDate
							WHEN '1900-01-01' THEN NULL
							ELSE CONVERT(nvarchar(10), DefendHead.DefendDate, 120)
						END AS DefendDate, LatestUpdateItem, DefendHead.DefendProcess, DefendHead.ProposerType,
						CASE DefendProcess
							WHEN 'Before Process' THEN 'B'
							WHEN 'On Process' THEN 'P'
							WHEN 'After Process' THEN 'R'
						END AS DefendModule,
						DefendHead.DefendEmpID, DefendHead.DefendEmpName AS DefendBy, LendingEmp.Mobile AS DefendMobile,
						[Profile].OwnerName, NCBConsent.BorrowerName,
						[Profile].Mobile, [Profile].Telephone, LendingBranchs.RegionID, LendingBranchs.BranchCode, 
						LendingBranchs.BranchDigit, LendingBranchs.BranchTel, [Profile].RMCode, [Profile].RMName, 
						[Profile].RMMobile, ApplicationStatus.CAName,
						CASE
							WHEN ApplicationStatus.[Status] IS NULL AND Verification.SentToCADate IS NULL 
							AND NOT CAReturnDateLog IS NULL AND CA_ReceivedDocDate IS NULL THEN 'CR'
							WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'C'
							WHEN ApplicationStatus.[Status] = 'PENDING' THEN 'P'
							WHEN ApplicationStatus.[Status] = 'PREAPPROVED' THEN 'PA'
							WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'A'
							WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'R'
							WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'C'
							WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'C'
							WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'C'
							WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'C'
							ELSE NULL
						END AS [Status], 
						CASE ApplicationStatus.StatusDate
							WHEN '1900-01-01' THEN NULL
							ELSE CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120)
						END AS StatusDate, StatusReason, AppComment, 									
						CASE 
							WHEN ApplicationStatus.[Status] = 'APPROVED' THEN 'InActive'
							WHEN ApplicationStatus.[Status] = 'CANCEL' THEN 'InActive'
							WHEN ApplicationStatus.[Status] = 'REJECT' THEN 'InActive'
							WHEN ApplicationStatus.[Status] = 'CANCELBYRM' THEN 'InActive'
							WHEN ApplicationStatus.[Status] = 'CANCELBYCUS' THEN 'InActive'
							WHEN ApplicationStatus.[Status] = 'CANCELBYCA' THEN 'InActive'
							WHEN NOT ApplicationStatus.AFCancelReason = '' THEN 'InActive'
							ELSE 'Active'
						END AS ActiveRecord, DefendHead.IsActive
						FROM 
						(	SELECT DocID, MAX(DefendRef) AS Times, COUNT(Point) AS COUNTNUM
							FROM (SELECT DocID, DefendRef,  ROW_NUMBER() OVER(PARTITION BY DocID ORDER BY DocID DESC) AS Point
							FROM [dbo].[DefendHead]
							WHERE IsActive = 'A'
							) AS Data
							GROUP BY DocID
						) AS Filter
						INNER JOIN [dbo].DefendHead
						ON Filter.DocID = DefendHead.DocID
						AND Filter.Times = DefendHead.DefendRef
						INNER JOIN [dbo].[Profile]
						ON Filter.DocID = [Profile].DocID 
						AND NOT [Profile].CreateDate IS NULL AND [Profile].IsEnabled = 'A'
						INNER JOIN [dbo].Verification
						ON Filter.DocID = Verification.DocID AND Verification.IsEnabled = 'A'
						INNER JOIN [dbo].ApplicationStatus
						ON Filter.DocID = ApplicationStatus.DocID AND ApplicationStatus.IsEnabled = 'A'
						LEFT OUTER JOIN [dbo].MasterProcessCancelReason
						ON Verification.RMProcessReason = MasterProcessCancelReason.ProcessCode
						LEFT OUTER JOIN [dbo].NCBConsent
						ON Filter.DocID = NCBConsent.DocID  AND BorrowerType = '101' AND NCBConsent.IsActive = 'A'
						LEFT OUTER JOIN [dbo].LendingBranchs
						ON [Profile].BranchCode = LendingBranchs.BranchCode
						LEFT OUTER JOIN [dbo].LendingEmp
						ON DefendHead.DefendEmpID = LendingEmp.EmployeeCode
						LEFT OUTER JOIN (SELECT DocID, COUNT(DocID) AS Fill_Item FROM [dbo].DefendSubscription WHERE NOT DefendNote = '' GROUP BY DocID) AS DefendFill
						ON Filter.DocID = DefendFill.DocID 
						LEFT OUTER JOIN (SELECT DocID, COUNT(DocID) AS Lists FROM [dbo].DefendSubscription GROUP BY DocID) AS DefendSubscription
						ON Filter.DocID = DefendSubscription.DocID 
						LEFT OUTER JOIN (
							SELECT TOP 1 DocID, DefendRef,
							CASE CreateDate
								WHEN '1900-01-01' THEN NULL
								ELSE CONVERT(nvarchar(10), CreateDate, 120)
							END AS LatestUpdateItem
							FROM [dbo].DefendSubscription
							GROUP BY DocID, DefendRef, CreateDate
							ORDER BY CreateDate DESC
						) LatestUpdate
						ON Filter.DocID = LatestUpdate.DocID 
						AND Filter.Times = LatestUpdate.DefendRef 
						LEFT OUTER JOIN 
						(	SELECT * 
							FROM (
								SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType, DocID ORDER BY CAReturnDate DESC, DocID, BorrowerType) as Numindex,
								DocID AS DocLogs, BorrowerType, BorrowerName, CAReturn, 
								CASE CAReturnDate
									WHEN '1900-01-01' THEN NULL
									WHEN '' THEN NULL
									ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
								END AS CAReturnDateLog
								FROM [dbo].ReconcileDocLogs) Tmp
							WHERE Numindex = 1		
						) ReconcileDocLogs
						ON [Profile].DocID = ReconcileDocLogs.DocLogs AND ReconcileDocLogs.BorrowerType = '101'
						WHERE NOT [Profile].DocID IS NULL
						$where_option
					) AS DataRecord
					WHERE IsActive = 'A'
					$wheres
					$where_filter");
					
				return $result->num_rows();
	
			} catch(Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
					
			}
	
		}
	
	}
	
	public function getDocumentCategoryTrackList() {
		$this->load->model('dbmodel');
	
		$result = $this->dbmodel->CIQuery("SELECT Doc_CatID, Doc_Category, IsActive FROM DocumentErrorCategory WHERE IsActive = 'A' ORDER BY Seq ASC");
		return $result;
	
	}
	
	public function getTrackDataList() {
	
		$result = $this->db->query("
            SELECT DocSubscription.RowID, DocSubscription.Doc_CatID, DocumentCategory.Doc_Category,
            DocSubscription.Onbehalf_ID, Onbehalf.Onbehalf_Type, DocSubscription.Document_List,
            DocSubscription.Weight_ID, Document_Weight.Weight,  Document_Weight.Point,
            DocSubscription.IsActive
            FROM DocumentErrorTrackSubscription AS DocSubscription
            LEFT OUTER JOIN DocumentErrorCategory AS DocumentCategory
            ON DocSubscription.Doc_CatID = DocumentCategory.Doc_CatID
            LEFT OUTER JOIN Onbehalf
            ON DocSubscription.Onbehalf_ID = Onbehalf.Onbehalf_ID
            LEFT OUTER JOIN Document_Weight
            ON DocSubscription.Weight_ID = Document_Weight.Weight_ID
            WHERE DocSubscription.IsActive = 'A'");
	
		return $result->result_array();
	
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