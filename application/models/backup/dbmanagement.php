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
	
	}
	
	// NCB Consent: Document Management
	public function getDataNCBConsentPagination($authority, $condition = array()) {
		$this->load->model('dbcustom');
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$startdate           		= $this->input->post('ncb_start');
		$enddate            	    = $this->input->post('ncb_end');
		$customers					= $this->input->post('customer');
		$rmname						= $this->input->post('rmname');
		$region						= $this->input->post('regions');
		$branchs					= $this->input->post('branchs');
		$views						= $this->input->post('views');
		
		$ncbdate_start  			= !empty($startdate) ? $this->effective->StandartDateSorter($startdate):"";
		$ncbdate_end	   			= !empty($enddate) ? $this->effective->StandartDateSorter($enddate):"";
		
		$wheres						= "";
		$where_option				= "";
		$where_filter				= "";
		
		if(!empty($ncbdate_start) && !empty($ncbdate_end)) { $wheres .= " AND CONVERT(nvarchar(10), NCBCheckDate, 120) BETWEEN '".$ncbdate_start."' AND '".$ncbdate_end."'"; }
		else {
		
			if(!empty($ncbdate_start)) { $where_filter .= " AND CONVERT(nvarchar(10), NCBCheckDate, 120)  = '".$ncbdate_start."'"; }
			if(!empty($ncbdate_end)) { $where_filter .= " AND CONVERT(nvarchar(10), NCBCheckDate, 120)  = '".$ncbdate_end."'"; }
		
		}
		
		// Optional Query
		if(!empty($rmname)) { $where_filter .= " AND RMName LIKE '%".iconv('UTF-8', 'TIS-620', $rmname)."%'"; }
		if(!empty($customers)) {
			$where_filter .= " AND BorrowerName LIKE '%".iconv('UTF-8', 'TIS-620', $customers)."%' OR OwnerName LIKE '%".iconv('UTF-8', 'TIS-620', $customers)."%'";
		}
		
		if(!empty($regionid)) { $where_filter .= " AND RegionID = '".trim(str_pad($regionid, 2, "0", STR_PAD_LEFT))."'"; }
		if(!empty($branchs)) { $where_filter .= " AND BranchDigit = '".$branchs."'"; }
				
		if($views == "Active"): $where_filter .= " AND ActiveRecord = '".$views."'"; endif;
		if($views == "InActive"): $where_filter .= " AND ActiveRecord = '".$views."'"; endif;
		
		if($views == "Active" && empty($ncbdate_start) && empty($ncbdate_end)) {
			$where_option = " AND NOT NCBCheckDate BETWEEN '1900-01-01' AND '2014-12-31'";
		}
		
		if($views == 'All' && empty($ncbdate_start) && empty($ncbdate_end)) {
			$where_option = " AND NOT NCBCheckDate BETWEEN '1900-01-01' AND '2014-12-31'";
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
			$empbranch = str_pad($employees['data'][0]['BranchCode'], 3, "0", "STR_PAD_LEFT");
			
			switch($authority) {
				case $this->role_ad:
			
					if($empbranch == "000" || $empbranch == "901"):
						$wheres = '';
					else:
						$wheres = ' AND BranchCode = "'.str_pad($empbranch, 3, "0", STR_PAD_LEFT).'"';
					endif;
			
					break;
				case $this->role_rm:
					$wheres	= ' AND RMCode = "'.$condition[0].'"';
			
					break;
				case $this->role_bm:
					$wheres = ' AND BranchCode = "'.str_pad($empbranch, 3, "0", STR_PAD_LEFT).'"';
			
					break;
				case $this->role_am:
					$wheres = ' AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = "'.$condition[0].'" GROUP BY BranchCode)';
			
					break;
				case $this->role_rd:
					$wheres = ' AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = "'.$employees['data'][0]['RegionID'].'" GROUP BY BranchCode)';
			
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
						SELECT * FROM (
							SELECT *, ROW_NUMBER() OVER (ORDER BY NCBCheckDate ASC) as KeyPoint FROM (
								SELECT
								NCBConsent.DocID, NCBConsent.VerifyID, [Profile].OwnerName, [Profile].Mobile, LendingBranchs.RegionID,
								[Profile].BranchCode, LendingBranchs.BranchDigit, [Profile].RMCode, [Profile].RMName,
								[Profile].RMMobile, NCBConsent.BorrowerType, NCBConsent.BorrowerName, NCBConsent.NCBCheck,
								CASE NCBConsent.NCBCheckDate
									WHEN '1900-01-01' THEN NULL
									WHEN '' THEN NULL
									ELSE CONVERT(nvarchar(10), NCBConsent.NCBCheckDate, 120)
								END AS NCBCheckDate,
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
								END AS ActiveRecord
							FROM NCBConsent
							LEFT OUTER JOIN [Profile]
							ON NCBConsent.DocID = [Profile].DocID
							LEFT OUTER JOIN LendingBranchs
							ON [Profile].BranchCode = LendingBranchs.BranchCode
							WHERE NOT NCBConsent.NCBCheckDate IS NULL
							AND NCBConsent.NCBCheck = '1'
							OR NCBConsent.NCBCheck = '3'
							AND NCBConsent.IsActive = 'A'
							) A
						WHERE NOT NCBCheckDate IS NULL
						AND NOT SubmitToHQ IS NULL
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
		$customers					= $this->input->post('customer');
		$rmname						= $this->input->post('rmname');
		$region						= $this->input->post('regions');
		$branchs					= $this->input->post('branchs');
		$views						= $this->input->post('views');
	
		$ncbdate_start  			= !empty($startdate) ? $this->effective->StandartDateSorter($startdate):"";
		$ncbdate_end	   			= !empty($enddate) ? $this->effective->StandartDateSorter($enddate):"";
	
		$wheres						= "";
		$where_option				= "";
		$where_filter				= "";
	
		if(!empty($ncbdate_start) && !empty($ncbdate_end)) { $wheres .= " AND CONVERT(nvarchar(10), NCBCheckDate, 120) BETWEEN '".$ncbdate_start."' AND '".$ncbdate_end."'"; }
		else {
	
			if(!empty($ncbdate_start)) { $where_filter .= " AND CONVERT(nvarchar(10), NCBCheckDate, 120)  = '".$ncbdate_start."'"; }
			if(!empty($ncbdate_end)) { $where_filter .= " AND CONVERT(nvarchar(10), NCBCheckDate, 120)  = '".$ncbdate_end."'"; }
	
		}
	
		// Optional Query
		if(!empty($rmname)) { $where_filter .= " AND RMName LIKE '%".iconv('UTF-8', 'TIS-620', $rmname)."%'"; }
		if(!empty($customers)) {
			$where_filter .= " AND BorrowerName LIKE '%".iconv('UTF-8', 'TIS-620', $customers)."%' OR OwnerName LIKE '%".iconv('UTF-8', 'TIS-620', $customers)."%'";
		}
	
		if(!empty($regionid)) { $where_filter .= " AND RegionID = '".trim(str_pad($regionid, 2, "0", STR_PAD_LEFT))."'"; }
		if(!empty($branchs)) { $where_filter .= " AND BranchDigit = '".$branchs."'"; }
	
		if($views == "Active"): $where_filter .= " AND ActiveRecord = '".$views."'"; endif;
		if($views == "InActive"): $where_filter .= " AND ActiveRecord = '".$views."'"; endif;
		
		if($views == "Active" && empty($ncbdate_start) && empty($ncbdate_end)) {
			$where_option = " AND NOT NCBCheckDate BETWEEN '1900-01-01' AND '2014-12-31'";
		}
		
		if($views == 'All' && empty($ncbdate_start) && empty($ncbdate_end)) {
			$where_option = " AND NOT NCBCheckDate BETWEEN '1900-01-01' AND '2014-12-31'";
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
			$empbranch = str_pad($employees['data'][0]['BranchCode'], 3, "0", "STR_PAD_LEFT");
				
			switch($authority) {
				case $this->role_ad:
						
					if($empbranch == "000" || $empbranch == "901"):
					$wheres = '';
					else:
					$wheres = ' AND BranchCode = "'.str_pad($empbranch, 3, "0", STR_PAD_LEFT).'"';
					endif;
						
					break;
				case $this->role_rm:
					$wheres	= ' AND RMCode = "'.$condition[0].'"';
						
					break;
				case $this->role_bm:
					$wheres = ' AND BranchCode = "'.str_pad($empbranch, 3, "0", STR_PAD_LEFT).'"';
						
					break;
				case $this->role_am:
					$wheres = ' AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = "'.$condition[0].'" GROUP BY BranchCode)';
						
					break;
				case $this->role_rd:
					$wheres = ' AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = "'.$employees['data'][0]['RegionID'].'" GROUP BY BranchCode)';
						
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
						SELECT * FROM (
						SELECT *, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint FROM (
						SELECT
						NCBConsent.DocID, NCBConsent.VerifyID, [Profile].OwnerName, [Profile].Mobile, LendingBranchs.RegionID,
						LendingBranchs.BranchCode, LendingBranchs.BranchDigit, [Profile].RMCode, [Profile].RMName,
						[Profile].RMMobile, NCBConsent.BorrowerType, NCBConsent.BorrowerName, NCBConsent.NCBCheck,
						CASE NCBConsent.NCBCheckDate
						WHEN '1900-01-01' THEN NULL
						WHEN '' THEN NULL
						ELSE CONVERT(nvarchar(10), NCBConsent.NCBCheckDate, 120)
						END AS NCBCheckDate,
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
						END AS ActiveRecord
						FROM NCBConsent
						LEFT OUTER JOIN [Profile]
						ON NCBConsent.DocID = [Profile].DocID
						LEFT OUTER JOIN LendingBranchs
						ON [Profile].BranchCode = LendingBranchs.BranchCode
						WHERE NOT NCBConsent.NCBCheckDate IS NULL
						AND NCBConsent.NCBCheck = '1'
						OR NCBConsent.NCBCheck = '3'
						AND NCBConsent.IsActive = 'A'
					) A
					WHERE NOT NCBCheckDate IS NULL
					AND NOT SubmitToHQ IS NULL
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
	
	
	
	
	// Reconcile Application: Document Management
	public function loadAppManagement($position, $authority, $condition = array()) {
		$this->load->model('dbmodel');
		$this->load->model('dbcustom');
		$this->load->library('effective');
		
		$where_condition = '';
		$where_filter	 = '';
		
		$views			= $this->input->post('aciverecord');
		$rmname			= $this->input->post('rmname');
		$customers		= $this->input->post('ownerName');
		$regionid		= $this->input->post('regionid');
		$branchs		= $this->input->post('branchdigit');
		
		$iStart  = $this->input->post('start');
		$iLength = $this->input->post('length') ? $iLength = $this->input->post('length') : 10;
		
		$start	 = ($iStart)? $iStart : 0;
		$offset  = $iLength + $start;
		
		$Ordering = $this->get_ordering();
		
		
		// Optional Query
		if(!empty($rmname)) { $where_filter .= " AND RMName LIKE '%".iconv('UTF-8', 'TIS-620', $rmname)."%'"; }
		if(!empty($customers)) {
			$where_filter .= " AND BorrowerName LIKE '%".iconv('UTF-8', 'TIS-620', $customers)."%' OR OwnerName LIKE '%".iconv('UTF-8', 'TIS-620', $customers)."%'";
		}
		
		if(!empty($regionid)) { $where_filter .= " AND RegionID = '".trim(str_pad($regionid, 2, "0", STR_PAD_LEFT))."'"; }
		if(!empty($branchs)) { $where_filter .= " AND BranchDigit = '".$branchs."'"; }
		
		
		if($views == "Active"): $where_filter .= " AND ActiveRecord = '".$views."'"; endif;
		if($views == "InActive"): $where_filter .= " AND ActiveRecord = '".$views."'"; endif;
		
		if($condition == "Active") {
			$where_option = " AND NOT NCBCheckDate BETWEEN '1900-01-01' AND '2014-12-31'";
		}
		
		if($views == 'All') {
			$where_option = " AND NOT NCBCheckDate BETWEEN '1900-01-01' AND '2014-12-31'";
		}
		
		
		if(empty($authority)) {
			throw new Exception("Exception handled: The syntax issue received parameter or condition. Please your are checked arguments at using for inquiry.");
			
		} else {
			
			if(count($authority) > 1) :
			$privileges = $authority[0];
			else:
			$privileges = $authority[0];
			endif;

			$employees = $this->dbcustom->employeesInfo($condition[0]);
			$empbranch = str_pad($employees['data'][0]['BranchCode'], 3, "0", "STR_PAD_LEFT");
			
			switch($position) {
				case 'reconcile':
					return $this->documentAppReconcileMode($authority[0], array($employees['data'][0]['EmployeeCode'], $empbranch, $views, array($start, $offset, $Ordering)), $where_filter);
					
				break;
				case 'missing':
					return $this->documentAppMissingMode($authority[0], array($employees['data'][0]['EmployeeCode'], $empbranch, $views, array($start, $offset, $Ordering)), $where_filter);
					
				break;
				case 'returndoc':
					return $this->documentAppReturnMode($authority[0], array($employees['data'][0]['EmployeeCode'], $empbranch, $views, array($start, $offset, $Ordering)), $where_filter);
					
				break;
				case 'allviews':
					return $this->documentAppAllMode($authority[0], array($employees['data'][0]['EmployeeCode'], $empbranch, $views, array($start, $offset, $Ordering)), $where_filter);				
					
				break;
				
				
			}
			
			
		}
		
		
	}
	
	// APP: Process Management
	private function documentAppReconcileMode($authority, $condition = array(), $criteria){
		
		$wheres  = "";
		switch($authority) {
			case $this->role_ad:
				
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = ' AND ReceivedDocFormLB IS NULL';
				else:
				$wheres = ' AND BranchCode = "'.str_pad($condition[1], 3, "0", STR_PAD_LEFT).'"';
				endif;
				
			break;
			case $this->role_rm:
				$wheres	= ' AND RMCode = "'.$condition[0].'"';
				
			break;
			case $this->role_bm:
				$wheres = ' AND BranchCode = "'.str_pad($condition[1], 3, "0", STR_PAD_LEFT).'"';
				
			break;
			case $this->role_am:
				$wheres = ' AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = "'.$condition[0].'" GROUP BY BranchCode)';
				
			break;
			case $this->role_rd:
				$wheres = ' AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = "'.$employees['data'][0]['RegionID'].'" GROUP BY BranchCode)';
				
			break;
			case $this->role_ads:
				case $this->role_hq:
				case $this->role_spv:	
				
			break;
		
		}
		
		try {
				
			$result = $this->dbmodel->CIQuery("
				SELECT * FROM (
				SELECT *, ROW_NUMBER() OVER (ORDER BY SubmitDocToHQ ASC) as KeyPoint
				FROM(SELECT DISTINCT ReconcileDoc.DocID, [Profile].OwnerName, [Profile].Mobile, [Profile].Telephone, 
					 LendingBranchs.RegionID, LendingBranchs.BranchCode, LendingBranchs.BranchDigit, [Profile].RMCode, 
					 [Profile].RMName, [Profile].RMMobile, ReconcileDoc.BorrowerName,ReconcileDoc. BorrowerType, 
					 ReconcileDoc.LogisticCode, NCBConsent.NCBCheck, NCBConsent.NCBCheckDate,
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
					 END AS AppToCA, ReconcileDoc.CAReturn,
					 CASE ReconcileDoc.CAReturnDate
						 WHEN '1900-01-01' THEN ''
						 WHEN '' THEN ''
						 ELSE CONVERT(nvarchar(10), ReconcileDoc.CAReturnDate, 120)
					 END AS CAReturnDate, ReconcileDoc.IsActive, ReconcileDoc.IsRef,
					 CASE [Profile].CreateDate
				 	 	WHEN '1900-01-01' THEN ''
				 	 	WHEN '' THEN ''
				 		ELSE CONVERT(nvarchar(10), [Profile].CreateDate, 120)
			 		 END AS CreateProfileDate, 
					 CASE
						 WHEN NOT ReconcileDoc.SubmitDocToHQ IS NULL AND NOT ReconcileDoc.ReceivedDocFormLB IS NULL THEN 'InActive'
						 WHEN NOT ReconcileDoc.SubmitDocToHQ IS NULL AND NOT ReconcileDoc.ReceivedDocFormLB IS NULL AND NOT ReconcileDoc.CAReturnDate IS NULL THEN 'InActive'						 
						 ELSE 'Active'
					 END AS ActiveRecord
				FROM ReconcileDoc
				LEFT OUTER JOIN NCBConsent
				ON ReconcileDoc.IsRef = NCBConsent.IsRef
				LEFT OUTER JOIN [Profile]
				ON ReconcileDoc.DocID = [Profile].DocID
				LEFT OUTER JOIN LendingBranchs
				ON [Profile].BranchCode = LendingBranchs.BranchCode
				WHERE NOT LogisticCode IS NULL
				) A
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
	
	private function documentAppMissingMode($authority, $condition = array(), $criteria){
		
		$wheres  = "";
		switch($authority) {
			case $this->role_ad:
				
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = '';
				else:
				$wheres = ' AND BranchCode = "'.str_pad($condition[1], 3, "0", STR_PAD_LEFT).'"';
				endif;
				
			break;
			case $this->role_rm:
				$wheres	= ' AND RMCode = "'.$condition[0].'"';
				
			break;
			case $this->role_bm:
				$wheres = ' AND BranchCode = "'.str_pad($condition[1], 3, "0", STR_PAD_LEFT).'"';
				
			break;
			case $this->role_am:
				$wheres = ' AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = "'.$condition[0].'" GROUP BY BranchCode)';
				
			break;
			case $this->role_rd:
				$wheres = ' AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = "'.$employees['data'][0]['RegionID'].'" GROUP BY BranchCode)';
				
			break;
			case $this->role_ads:
				case $this->role_hq:
				case $this->role_spv:	
				
			break;
		
		}
		
		if($condition[2] == 'Active'):
			$filter_criteria = ' AND SubmitDocToCADate IS NULL';
		endif;
			
		if($condition[2] == 'InActive'):
			$filter_criteria = ' AND NOT SubmitDocToCADate IS NULL';
		endif;
		
		if($condition[2] == 'All'):
			$filter_criteria = '';
		endif;
		
		try {
		
			$result = $this->dbmodel->CIQuery("
			SELECT * FROM (
				SELECT *, ROW_NUMBER() OVER (ORDER BY SubmitDocToHQ ASC) as KeyPoint
				FROM(SELECT ReconcileDoc.DocID, ReconcileDoc.BorrowerName,ReconcileDoc.BorrowerType, 
					 ReconcileCompletion.DocOwner,
					 CASE 
						 WHEN ReconcileCompletion.LackNums <= 0 THEN 0
						 WHEN ReconcileCompletion.LackNums IS NULL THEN 0
						 ELSE ReconcileCompletion.LackNums
					 END AS LackNums,
					 [Profile].OwnerName, [Profile].Mobile, [Profile].Telephone, LendingBranchs.RegionID, LendingBranchs.BranchCode,
					 LendingBranchs.BranchDigit, [Profile].RMCode, [Profile].RMName,
					 [Profile].RMMobile, 
					 ReconcileDoc.LogisticCode, NCBConsent.NCBCheck, NCBConsent.NCBCheckDate,
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
					 END AS AppToCA, ReconcileDoc.CAReturn,
					 CASE ReconcileDoc.CAReturnDate
						 WHEN '1900-01-01' THEN ''
						 WHEN '' THEN ''
						 ELSE CONVERT(nvarchar(10), ReconcileDoc.CAReturnDate, 120)
					 END AS CAReturnDate, 
					 ReconcileDoc.IsActive, ReconcileDoc.IsRef,
					 CASE [Profile].CreateDate
					 WHEN '1900-01-01' THEN ''
					 WHEN '' THEN ''
					 ELSE CONVERT(nvarchar(10), [Profile].CreateDate, 120)
					 END AS CreateProfileDate, 
					 CASE
						 WHEN NOT ReconcileDoc.SubmitDocToHQ IS NULL AND NOT ReconcileDoc.ReceivedDocFormLB IS NULL 
							 AND NOT ReconcileDoc.CompletionDoc IS NULL AND NOT ReconcileDoc.CompletionDate IS NULL AND ReconcileDoc.CompletionDoc = 'Y'
							 AND NOT ReconcileDoc.AppToCA IS NULL THEN 'InActive'
						WHEN NOT ReconcileDoc.SubmitDocToHQ IS NULL AND NOT ReconcileDoc.ReceivedDocFormLB IS NULL 
							 AND NOT ReconcileDoc.CompletionDoc IS NULL AND NOT ReconcileDoc.CompletionDate IS NULL AND ReconcileDoc.CompletionDoc = 'Y'
							 AND NOT ReconcileDoc.AppToCA IS NULL AND NOT ReconcileDoc.CAReturnDate IS NULL THEN 'InActive'
						ELSE 'Active'
					 END AS ActiveRecord
					 FROM ReconcileDoc
					 LEFT OUTER JOIN NCBConsent
					 ON ReconcileDoc.IsRef = NCBConsent.IsRef
					 LEFT OUTER JOIN [Profile]
					 ON ReconcileDoc.DocID = [Profile].DocID
					 LEFT OUTER JOIN LendingBranchs
					 ON [Profile].BranchCode = LendingBranchs.BranchCode
					 LEFT OUTER JOIN (
						 SELECT DocID, DocOwner, COUNT(DocID) AS LackNums, IsRef
						 FROM ReconcileCompletion
						 WHERE DocType = 'M'
						 AND IsActive = 'A'
						 $filter_criteria
						 GROUP BY DocID, DocOwner, IsRef
					 ) ReconcileCompletion
					 ON ReconcileDoc.IsRef = ReconcileCompletion.IsRef
					WHERE NOT LogisticCode IS NULL
					AND NOT ReceivedDocFormLB IS NULL
				) A
				WHERE NOT CreateProfileDate IS NULL
				$criteria
			) Data
			WHERE KeyPoint > '".$condition[3][0]."' AND KeyPoint <= '".$condition[3][1]."'");;
		
			return $result;
		
		} catch(Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
		
		}
		
							
	}
	
	private function documentAppReturnMode($authority, $condition = array(), $criteria){
		
		$wheres  = "";
		switch($authority) {
			case $this->role_ad:
		
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = '';
				else:
				$wheres = ' AND BranchCode = "'.str_pad($condition[1], 3, "0", STR_PAD_LEFT).'"';
				endif;
		
				break;
			case $this->role_rm:
				$wheres	= ' AND RMCode = "'.$condition[0].'"';
		
				break;
			case $this->role_bm:
				$wheres = ' AND BranchCode = "'.str_pad($condition[1], 3, "0", STR_PAD_LEFT).'"';
		
				break;
			case $this->role_am:
				$wheres = ' AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = "'.$condition[0].'" GROUP BY BranchCode)';
		
				break;
			case $this->role_rd:
				$wheres = ' AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = "'.$employees['data'][0]['RegionID'].'" GROUP BY BranchCode)';
		
				break;
			case $this->role_ads:
			case $this->role_hq:
			case $this->role_spv:
		
				break;
		}
		
		// -------- R ----------
		
		if($condition[2] == 'Active'):
			$filter_criteria = ' AND BranchReceivedDate IS NULL';
		endif;
		
		if($condition[2] == 'InActive'):
			$filter_criteria = ' AND NOT BranchReceivedDate IS NULL';
		endif;
		
		if($condition[2] == 'All'):
			$filter_criteria = '';
		endif;
		
		// -------- M ----------
		
		if($condition[2] == 'Active'):
			$filter_criteria_opt = ' AND SubmitDocToCADate IS NULL';
		endif;
		
		if($condition[2] == 'InActive'):
			$filter_criteria_opt = ' AND NOT SubmitDocToCADate IS NULL';
		endif;
		
		if($condition[2] == 'All'):
			$filter_criteria_opt = '';
		endif;
		
		try {
		
			$result = $this->dbmodel->CIQuery("
			SELECT * FROM (
				SELECT *, ROW_NUMBER() OVER (ORDER BY LBSubmitDocDate ASC) as KeyPoint
				FROM(SELECT DISTINCT ReconcileDoc.DocID, ReconcileDoc.BorrowerName,
					ReconcileDoc.BorrowerType, ReconcileReturn.DocOwner,
					CASE 
							WHEN ReconcileMissing.LackNums <= 0 THEN 0
							WHEN ReconcileMissing.LackNums IS NULL THEN 0
							ELSE ReconcileMissing.LackNums
						END AS LackNums,
					CASE 
						WHEN ReconcileReturn.ReturnNums <= 0 THEN 0
						WHEN ReconcileReturn.ReturnNums IS NULL THEN 0
						ELSE ReconcileReturn.ReturnNums
					END AS ReturnNums,
					[Profile].OwnerName, [Profile].Mobile, [Profile].Telephone, LendingBranchs.RegionID, 
					LendingBranchs.BranchCode, LendingBranchs.BranchDigit, [Profile].RMCode, [Profile].RMName,
					[Profile].RMMobile, 
					ReconcileDoc.LogisticCode, NCBConsent.NCBCheck, 
					CASE NCBConsent.NCBCheckDate
						WHEN '1900-01-01' THEN ''
						WHEN '' THEN ''
						ELSE CONVERT(nvarchar(10), NCBConsent.NCBCheckDate, 120)
					END AS NCBCheckDate,
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
					END AS AppToCA, ReconcileDoc.CAReturn,
					CASE ReconcileDoc.CAReturnDate
						WHEN '1900-01-01' THEN ''
						WHEN '' THEN ''
						ELSE CONVERT(nvarchar(10), ReconcileDoc.CAReturnDate, 120)
					END AS CAReturnDate, 
					CASE ReconcileCompletion.LBSubmitDocDate
						WHEN '1900-01-01' THEN ''
						WHEN '' THEN NULL
						ELSE CONVERT(nvarchar(10), ReconcileCompletion.LBSubmitDocDate, 120)
					END AS LBSubmitDocDate,
					CASE ReconcileCompletion.BranchReceivedDate
						WHEN '1900-01-01' THEN ''
						WHEN '' THEN NULL
						ELSE CONVERT(nvarchar(10), ReconcileCompletion.BranchReceivedDate, 120)
					END AS BranchReceivedDate,
					ReconcileDoc.IsActive, ReconcileDoc.IsRef,
					CASE [Profile].CreateDate
					WHEN '1900-01-01' THEN ''
					WHEN '' THEN ''
					ELSE CONVERT(nvarchar(10), [Profile].CreateDate, 120)
					END AS CreateProfileDate, 
					CASE
						WHEN NOT BranchReceivedDate IS NULL THEN 'InActive'
						ELSE 'Active'
					END AS ActiveRecord
					FROM ReconcileDoc
					LEFT OUTER JOIN NCBConsent
					ON ReconcileDoc.IsRef = NCBConsent.IsRef
					LEFT OUTER JOIN [Profile]
					ON ReconcileDoc.DocID = [Profile].DocID
					LEFT OUTER JOIN LendingBranchs
					ON [Profile].BranchCode = LendingBranchs.BranchCode
					LEFT OUTER JOIN (
							SELECT DocID, DocOwner, COUNT(DocID) AS LackNums, IsRef
							FROM ReconcileCompletion
							WHERE DocType = 'M'
							AND IsActive = 'A'
							$filter_criteria_opt
							GROUP BY DocID, DocOwner, IsRef
					) ReconcileMissing
					ON ReconcileDoc.IsRef = ReconcileMissing.IsRef
					INNER JOIN (
						SELECT DocID, DocOwner, COUNT(DocID) AS ReturnNums, IsRef
						FROM ReconcileCompletion
						WHERE DocType = 'R'
						AND IsActive = 'A'
						$filter_criteria
						GROUP BY DocID, DocOwner, IsRef
					) ReconcileReturn
					ON ReconcileDoc.IsRef = ReconcileReturn.IsRef
					LEFT OUTER JOIN ReconcileCompletion
					ON ReconcileDoc.DocID = ReconcileCompletion.DocID 
					AND DocType = 'R'
					WHERE NOT LogisticCode IS NULL
				) A
				WHERE NOT CreateProfileDate IS NULL
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
	
	private function documentAppAllMode($authority, $condition = array(), $criteria){

		$wheres  = "";
		switch($authority) {
			case $this->role_ad:
		
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = '';
				else:
				$wheres = ' AND BranchCode = "'.str_pad($condition[1], 3, "0", STR_PAD_LEFT).'"';
				endif;
		
				break;
			case $this->role_rm:
				$wheres	= ' AND RMCode = "'.$condition[0].'"';
		
				break;
			case $this->role_bm:
				$wheres = ' AND BranchCode = "'.str_pad($condition[1], 3, "0", STR_PAD_LEFT).'"';
		
				break;
			case $this->role_am:
				$wheres = ' AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = "'.$condition[0].'" GROUP BY BranchCode)';
		
				break;
			case $this->role_rd:
				$wheres = ' AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = "'.$employees['data'][0]['RegionID'].'" GROUP BY BranchCode)';
		
				break;
			case $this->role_ads:
			case $this->role_hq:
			case $this->role_spv:
		
				break;
		}
		
		// -------- R ----------
		
		if($condition[2] == 'Active'):
			$filter_criteria = ' AND BranchReceivedDate IS NULL';
		endif;
		
		if($condition[2] == 'InActive'):
			$filter_criteria = ' AND NOT BranchReceivedDate IS NULL';
		endif;
		
		if($condition[2] == 'All'):
			$filter_criteria = '';
		endif;
		
		// -------- M ----------
		
		if($condition[2] == 'Active'):
			$filter_criteria_opt = ' AND SubmitDocToCADate IS NULL';
		endif;
		
		if($condition[2] == 'InActive'):
			$filter_criteria_opt = ' AND NOT SubmitDocToCADate IS NULL';
		endif;
		
		if($condition[2] == 'All'):
			$filter_criteria_opt = '';
		endif;
		
		try {
		
			$result = $this->dbmodel->CIQuery("
			SELECT * FROM (
				SELECT *, ROW_NUMBER() OVER (ORDER BY LBSubmitDocDate ASC) as KeyPoint
				FROM(SELECT DISTINCT ReconcileDoc.DocID, ReconcileDoc.BorrowerName,
					ReconcileDoc.BorrowerType, ReconcileReturn.DocOwner,
					CASE 
						WHEN ReconcileMissing.LackNums <= 0 THEN ''
						WHEN ReconcileMissing.LackNums IS NULL THEN ''
						ELSE ReconcileMissing.LackNums
						END AS LackNums,
					CASE 
						WHEN ReconcileReturn.ReturnNums <= 0 THEN ''
						WHEN ReconcileReturn.ReturnNums IS NULL THEN ''
						ELSE ReconcileReturn.ReturnNums
					END AS ReturnNums,
					[Profile].OwnerName, [Profile].Mobile, [Profile].Telephone, LendingBranchs.RegionID, 
					LendingBranchs.BranchCode, LendingBranchs.BranchDigit, [Profile].RMCode, [Profile].RMName,
					[Profile].RMMobile, 
					ReconcileDoc.LogisticCode, NCBConsent.NCBCheck, 
					CASE NCBConsent.NCBCheckDate
						WHEN '1900-01-01' THEN ''
						WHEN '' THEN ''
						ELSE CONVERT(nvarchar(10), NCBConsent.NCBCheckDate, 120)
					END AS NCBCheckDate,
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
					END AS AppToCA, ReconcileDoc.CAReturn,
					CASE ReconcileDoc.CAReturnDate
						WHEN '1900-01-01' THEN ''
						WHEN '' THEN ''
						ELSE CONVERT(nvarchar(10), ReconcileDoc.CAReturnDate, 120)
					END AS CAReturnDate, 
					CASE ReconcileCompletion.LBSubmitDocDate
						WHEN '1900-01-01' THEN ''
						WHEN '' THEN NULL
						ELSE CONVERT(nvarchar(10), ReconcileCompletion.LBSubmitDocDate, 120)
					END AS LBSubmitDocDate,
					CASE ReconcileCompletion.BranchReceivedDate
						WHEN '1900-01-01' THEN ''
						WHEN '' THEN NULL
						ELSE CONVERT(nvarchar(10), ReconcileCompletion.BranchReceivedDate, 120)
					END AS BranchReceivedDate,
					ReconcileDoc.IsActive, ReconcileDoc.IsRef,
					CASE [Profile].CreateDate
						WHEN '1900-01-01' THEN ''
						WHEN '' THEN ''
						ELSE CONVERT(nvarchar(10), [Profile].CreateDate, 120)
					END AS CreateProfileDate, 
					CASE
						WHEN NOT ReconcileDoc.SubmitDocToHQ IS NULL AND NOT ReconcileDoc.ReceivedDocFormLB IS NULL
							 AND NOT ReconcileDoc.CompletionDoc IS NULL AND NOT ReconcileDoc.CompletionDate IS NULL 
							 AND ReconcileDoc.CompletionDoc = 'Y' AND NOT ReconcileDoc.AppToCA IS NULL THEN 'InActive'
						WHEN NOT ReconcileDoc.SubmitDocToHQ IS NULL AND NOT ReconcileDoc.ReceivedDocFormLB IS NULL
							 AND NOT ReconcileDoc.CompletionDoc IS NULL AND NOT ReconcileDoc.CompletionDate IS NULL AND ReconcileDoc.CompletionDoc = 'Y'
							 AND NOT ReconcileDoc.AppToCA IS NULL AND NOT ReconcileDoc.CAReturnDate IS NULL THEN 'InActive'
						WHEN ReconcileReturn.ReturnNums IS NULL AND ReconcileMissing.LackNums IS NULL AND ReconcileDoc.CompletionDoc = 'Y' AND NOT ReconcileDoc.CompletionDate IS NULL THEN 'InActive'
						WHEN ReconcileReturn.ReturnNums IS NULL AND ReconcileMissing.LackNums IS NULL AND ReconcileDoc.CompletionDoc = 'Y' AND NOT ReconcileDoc.CompletionDate IS NULL AND NOT ReconcileDoc.CAReturnDate IS NULL THEN 'InActive'
						ELSE 'Active'
					END AS ActiveRecord
					FROM ReconcileDoc
					LEFT OUTER JOIN NCBConsent
					ON ReconcileDoc.IsRef = NCBConsent.IsRef
					LEFT OUTER JOIN [Profile]
					ON ReconcileDoc.DocID = [Profile].DocID
					LEFT OUTER JOIN LendingBranchs
					ON [Profile].BranchCode = LendingBranchs.BranchCode
					LEFT OUTER JOIN (
							SELECT DocID, DocOwner, COUNT(DocID) AS LackNums, IsRef
							FROM ReconcileCompletion
							WHERE DocType = 'M'
							AND IsActive = 'A'
							$filter_criteria_opt
							GROUP BY DocID, DocOwner, IsRef
					) ReconcileMissing
					ON ReconcileDoc.IsRef = ReconcileMissing.IsRef
					LEFT OUTER JOIN (
						SELECT DocID, DocOwner, COUNT(DocID) AS ReturnNums, IsRef
						FROM ReconcileCompletion
						WHERE DocType = 'R'
						AND IsActive = 'A'
						$filter_criteria
						GROUP BY DocID, DocOwner, IsRef
					) ReconcileReturn
					ON ReconcileDoc.IsRef = ReconcileReturn.IsRef
					LEFT OUTER JOIN ReconcileCompletion
					ON ReconcileDoc.DocID = ReconcileCompletion.DocID 
					AND DocType = 'R'
					WHERE NOT LogisticCode IS NULL
				) A
				WHERE NOT CreateProfileDate IS NULL
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
		
		$where_condition = '';
		$where_filter	 = '';
		
		$views			 = $this->input->post('aciverecord');
		$rmname			 = $this->input->post('rmname');
		$ownerName		 = $this->input->post('ownerName');
		$regionid		 = $this->input->post('regionid');
		$branchs		 = $this->input->post('branchdigit');
		

		// Optional Query
		if(!empty($rmname)) { $where_filter .= " AND RMName LIKE '%".iconv('UTF-8', 'TIS-620', $rmname)."%'"; }
		if(!empty($customers)) {
			$where_filter .= " AND BorrowerName LIKE '%".iconv('UTF-8', 'TIS-620', $customers)."%' OR OwnerName LIKE '%".iconv('UTF-8', 'TIS-620', $customers)."%'";
		}
		
		if(!empty($regionid)) { $where_filter .= " AND RegionID = '".trim(str_pad($regionid, 2, "0", STR_PAD_LEFT))."'"; }
		if(!empty($branchs)) { $where_filter .= " AND BranchDigit = '".$branchs."'"; }
		
		if($views == "Active"): $where_filter .= " AND ActiveRecord = '".$views."'"; endif;
		if($views == "InActive"): $where_filter .= " AND ActiveRecord = '".$views."'"; endif;
		
		if(empty($authority)) {
			throw new Exception("Exception handled: The syntax issue received parameter or condition. Please your are checked arguments at using for inquiry.");
				
		} else {
				
			if(count($authority) > 1) :
			$privileges = $authority[0];
			else:
			$privileges = $authority[0];
			endif;
		
			$employees = $this->dbcustom->employeesInfo($condition[0]);
			$empbranch = str_pad($employees['data'][0]['BranchCode'], 3, "0", "STR_PAD_LEFT");
				
			switch($position) {
				case 'reconcile':
					return $this->documentAppReconcileModePagination($authority[0], array($employees['data'][0]['EmployeeCode'], $empbranch, $views), $where_filter);
						
					break;
				case 'missing':
					return $this->documentAppMissingModePagination($authority[0], array($employees['data'][0]['EmployeeCode'], $empbranch, $views), $where_filter);
						
					break;
				case 'returndoc':
					return $this->documentAppReturnModePagination($authority[0], array($employees['data'][0]['EmployeeCode'], $empbranch, $views), $where_filter);
						
					break;
				case 'allviews':
					return $this->documentAppAllModePagination($authority[0], array($employees['data'][0]['EmployeeCode'], $empbranch, $views), $where_filter);

					break;
		
		
			}
				
				
		}		
		
	}
	
	
	private function documentAppReconcileModePagination($authority, $condition = array(), $criteria){
		
		$wheres  = "";
		switch($authority) {
			case $this->role_ad:
		
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = ' AND ReceivedDocFormLB IS NULL';
				else:
				$wheres = ' AND BranchCode = "'.str_pad($condition[1], 3, "0", STR_PAD_LEFT).'"';
				endif;
		
				break;
			case $this->role_rm:
				$wheres	= ' AND RMCode = "'.$condition[0].'"';
		
				break;
			case $this->role_bm:
				$wheres = ' AND BranchCode = "'.str_pad($condition[1], 3, "0", STR_PAD_LEFT).'"';
		
				break;
			case $this->role_am:
				$wheres = ' AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = "'.$condition[0].'" GROUP BY BranchCode)';
		
				break;
			case $this->role_rd:
				$wheres = ' AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = "'.$employees['data'][0]['RegionID'].'" GROUP BY BranchCode)';
		
				break;
			case $this->role_ads:
			case $this->role_hq:
			case $this->role_spv:
				$where  = '';
				break;
		
		}
		
		try {
		
			$result = $this->db->query("
				SELECT *
				FROM(SELECT DISTINCT ReconcileDoc.DocID, [Profile].OwnerName, [Profile].Mobile, [Profile].Telephone, 
				LendingBranchs.RegionID, LendingBranchs.BranchCode, LendingBranchs.BranchDigit, [Profile].RMCode, 
				[Profile].RMName, [Profile].RMMobile, ReconcileDoc.BorrowerName,ReconcileDoc. BorrowerType, 
				ReconcileDoc.LogisticCode, NCBConsent.NCBCheck, NCBConsent.NCBCheckDate,
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
				END AS AppToCA, ReconcileDoc.CAReturn,
				CASE ReconcileDoc.CAReturnDate
					WHEN '1900-01-01' THEN ''
					WHEN '' THEN ''
					ELSE CONVERT(nvarchar(10), ReconcileDoc.CAReturnDate, 120)
				END AS CAReturnDate, ReconcileDoc.IsActive, ReconcileDoc.IsRef,
				CASE [Profile].CreateDate
					WHEN '1900-01-01' THEN ''
					WHEN '' THEN ''
					ELSE CONVERT(nvarchar(10), [Profile].CreateDate, 120)
				END AS CreateProfileDate,
				CASE
					WHEN NOT ReconcileDoc.SubmitDocToHQ IS NULL AND NOT ReconcileDoc.ReceivedDocFormLB IS NULL THEN 'InActive'
					WHEN NOT ReconcileDoc.SubmitDocToHQ IS NULL AND NOT ReconcileDoc.ReceivedDocFormLB IS NULL AND NOT ReconcileDoc.CAReturnDate IS NULL THEN 'InActive'
					ELSE 'Active'
				END AS ActiveRecord
				FROM ReconcileDoc
				LEFT OUTER JOIN NCBConsent
				ON ReconcileDoc.IsRef = NCBConsent.IsRef
				LEFT OUTER JOIN [Profile]
				ON ReconcileDoc.DocID = [Profile].DocID
				LEFT OUTER JOIN LendingBranchs
				ON [Profile].BranchCode = LendingBranchs.BranchCode
				WHERE NOT LogisticCode IS NULL
			) A
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
	
	private function documentAppMissingModePagination($authority, $condition = array(), $criteria){
		$wheres  = "";
		switch($authority) {
			case $this->role_ad:
		
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = '';
				else:
				$wheres = ' AND BranchCode = "'.str_pad($condition[1], 3, "0", STR_PAD_LEFT).'"';
				endif;
		
				break;
			case $this->role_rm:
				$wheres	= ' AND RMCode = "'.$condition[0].'"';
		
				break;
			case $this->role_bm:
				$wheres = ' AND BranchCode = "'.str_pad($condition[1], 3, "0", STR_PAD_LEFT).'"';
		
				break;
			case $this->role_am:
				$wheres = ' AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = "'.$condition[0].'" GROUP BY BranchCode)';
		
				break;
			case $this->role_rd:
				$wheres = ' AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = "'.$employees['data'][0]['RegionID'].'" GROUP BY BranchCode)';
		
				break;
			case $this->role_ads:
			case $this->role_hq:
			case $this->role_spv:
				$wheres	= '';
				break;
		
		}
		
		if($condition[2] == 'Active'):
			$filter_criteria = ' AND SubmitDocToCADate IS NULL';
		endif;
			
		if($condition[2] == 'InActive'):
			$filter_criteria = ' AND NOT SubmitDocToCADate IS NULL';
		endif;
		
		if($condition[2] == 'All'):
			$filter_criteria = '';
		endif;
		
		try {
		
			$result = $this->db->query("
			SELECT *
			FROM(SELECT ReconcileDoc.DocID, ReconcileDoc.BorrowerName,ReconcileDoc.BorrowerType,
				ReconcileCompletion.DocOwner,
				CASE
					WHEN ReconcileCompletion.LackNums <= 0 THEN 0
					WHEN ReconcileCompletion.LackNums IS NULL THEN 0
					ELSE ReconcileCompletion.LackNums
				END AS LackNums,
				[Profile].OwnerName, [Profile].Mobile, [Profile].Telephone, LendingBranchs.RegionID, LendingBranchs.BranchCode,
				LendingBranchs.BranchDigit, [Profile].RMCode, [Profile].RMName,
				[Profile].RMMobile,
				ReconcileDoc.LogisticCode, NCBConsent.NCBCheck, NCBConsent.NCBCheckDate,
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
				END AS AppToCA, ReconcileDoc.CAReturn,
				CASE ReconcileDoc.CAReturnDate
					WHEN '1900-01-01' THEN ''
					WHEN '' THEN ''
					ELSE CONVERT(nvarchar(10), ReconcileDoc.CAReturnDate, 120)
				END AS CAReturnDate,
				ReconcileDoc.IsActive, ReconcileDoc.IsRef,
				CASE [Profile].CreateDate
					WHEN '1900-01-01' THEN ''
					WHEN '' THEN ''
					ELSE CONVERT(nvarchar(10), [Profile].CreateDate, 120)
				END AS CreateProfileDate,
				CASE
					WHEN NOT ReconcileDoc.SubmitDocToHQ IS NULL AND NOT ReconcileDoc.ReceivedDocFormLB IS NULL
						 AND NOT ReconcileDoc.CompletionDoc IS NULL AND NOT ReconcileDoc.CompletionDate IS NULL AND ReconcileDoc.CompletionDoc = 'Y'
						 AND NOT ReconcileDoc.AppToCA IS NULL THEN 'InActive'
					WHEN NOT ReconcileDoc.SubmitDocToHQ IS NULL AND NOT ReconcileDoc.ReceivedDocFormLB IS NULL
						 AND NOT ReconcileDoc.CompletionDoc IS NULL AND NOT ReconcileDoc.CompletionDate IS NULL AND ReconcileDoc.CompletionDoc = 'Y'
						 AND NOT ReconcileDoc.AppToCA IS NULL AND NOT ReconcileDoc.CAReturnDate IS NULL THEN 'InActive'
					ELSE 'Active'
				END AS ActiveRecord
				FROM ReconcileDoc
				LEFT OUTER JOIN NCBConsent
				ON ReconcileDoc.IsRef = NCBConsent.IsRef
				LEFT OUTER JOIN [Profile]
				ON ReconcileDoc.DocID = [Profile].DocID
				LEFT OUTER JOIN LendingBranchs
				ON [Profile].BranchCode = LendingBranchs.BranchCode
				LEFT OUTER JOIN (
					SELECT DocID, DocOwner, COUNT(DocID) AS LackNums, IsRef
					FROM ReconcileCompletion
					WHERE DocType = 'M'
					AND IsActive = 'A'
					$filter_criteria
					GROUP BY DocID, DocOwner, IsRef
				) ReconcileCompletion
				ON ReconcileDoc.IsRef = ReconcileCompletion.IsRef
				WHERE NOT LogisticCode IS NULL
				AND NOT ReceivedDocFormLB IS NULL
			) A
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
	
	private function documentAppReturnModePagination($authority, $condition = array(), $criteria){

		$wheres  = "";
		switch($authority) {
			case $this->role_ad:
		
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = '';
				else:
				$wheres = ' AND BranchCode = "'.str_pad($condition[1], 3, "0", STR_PAD_LEFT).'"';
				endif;
		
				break;
			case $this->role_rm:
				$wheres	= ' AND RMCode = "'.$condition[0].'"';
		
				break;
			case $this->role_bm:
				$wheres = ' AND BranchCode = "'.str_pad($condition[1], 3, "0", STR_PAD_LEFT).'"';
		
				break;
			case $this->role_am:
				$wheres = ' AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = "'.$condition[0].'" GROUP BY BranchCode)';
		
				break;
			case $this->role_rd:
				$wheres = ' AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = "'.$employees['data'][0]['RegionID'].'" GROUP BY BranchCode)';
		
				break;
			case $this->role_ads:
			case $this->role_hq:
			case $this->role_spv:
		
				break;
		
		}
		
		// -------- R ----------
		
		if($condition[2] == 'Active'):
			$filter_criteria = ' AND BranchReceivedDate IS NULL';
		endif;
		
		if($condition[2] == 'InActive'):
			$filter_criteria = ' AND NOT BranchReceivedDate IS NULL';
		endif;
		
		if($condition[2] == 'All'):
			$filter_criteria = '';
		endif;
		
		// -------- M ----------
		
		if($condition[2] == 'Active'):
			$filter_criteria_opt = ' AND SubmitDocToCADate IS NULL';
		endif;
		
		if($condition[2] == 'InActive'):
			$filter_criteria_opt = ' AND NOT SubmitDocToCADate IS NULL';
		endif;
		
		if($condition[2] == 'All'):
			$filter_criteria_opt = '';
		endif;
		
		try {
		
			$result = $this->db->query("
			SELECT *
			FROM(SELECT DISTINCT ReconcileDoc.DocID, ReconcileDoc.BorrowerName,
				ReconcileDoc.BorrowerType, ReconcileReturn.DocOwner,
				CASE
					WHEN ReconcileMissing.LackNums <= 0 THEN 0
					WHEN ReconcileMissing.LackNums IS NULL THEN 0
					ELSE ReconcileMissing.LackNums
				END AS LackNums,
				CASE
					WHEN ReconcileReturn.ReturnNums <= 0 THEN 0
					WHEN ReconcileReturn.ReturnNums IS NULL THEN 0
					ELSE ReconcileReturn.ReturnNums
				END AS ReturnNums,
				[Profile].OwnerName, [Profile].Mobile, [Profile].Telephone, LendingBranchs.RegionID, LendingBranchs.BranchCode,
				LendingBranchs.BranchDigit, [Profile].RMCode, [Profile].RMName,
				[Profile].RMMobile,
				ReconcileDoc.LogisticCode, NCBConsent.NCBCheck,
				CASE NCBConsent.NCBCheckDate
					WHEN '1900-01-01' THEN ''
					WHEN '' THEN ''
					ELSE CONVERT(nvarchar(10), NCBConsent.NCBCheckDate, 120)
				END AS NCBCheckDate,
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
				END AS AppToCA, ReconcileDoc.CAReturn,
				CASE ReconcileDoc.CAReturnDate
					WHEN '1900-01-01' THEN ''
					WHEN '' THEN ''
					ELSE CONVERT(nvarchar(10), ReconcileDoc.CAReturnDate, 120)
				END AS CAReturnDate,
				CASE ReconcileCompletion.LBSubmitDocDate
					WHEN '1900-01-01' THEN ''
					WHEN '' THEN NULL
					ELSE CONVERT(nvarchar(10), ReconcileCompletion.LBSubmitDocDate, 120)
				END AS LBSubmitDocDate,
				CASE ReconcileCompletion.BranchReceivedDate
					WHEN '1900-01-01' THEN ''
					WHEN '' THEN NULL
					ELSE CONVERT(nvarchar(10), ReconcileCompletion.BranchReceivedDate, 120)
				END AS BranchReceivedDate,
				ReconcileDoc.IsActive, ReconcileDoc.IsRef,
				CASE [Profile].CreateDate
					WHEN '1900-01-01' THEN ''
					WHEN '' THEN ''
					ELSE CONVERT(nvarchar(10), [Profile].CreateDate, 120)
				END AS CreateProfileDate,
				CASE
					WHEN NOT BranchReceivedDate IS NULL THEN 'InActive'
					ELSE 'Active'
				END AS ActiveRecord
				FROM ReconcileDoc
				LEFT OUTER JOIN NCBConsent
				ON ReconcileDoc.IsRef = NCBConsent.IsRef
				LEFT OUTER JOIN [Profile]
				ON ReconcileDoc.DocID = [Profile].DocID
				LEFT OUTER JOIN LendingBranchs
				ON [Profile].BranchCode = LendingBranchs.BranchCode
				LEFT OUTER JOIN (
					SELECT DocID, DocOwner, COUNT(DocID) AS LackNums, IsRef
					FROM ReconcileCompletion
					WHERE DocType = 'M'
					AND IsActive = 'A'
					$filter_criteria_opt
					GROUP BY DocID, DocOwner, IsRef
				) ReconcileMissing
				ON ReconcileDoc.IsRef = ReconcileMissing.IsRef
				INNER JOIN (
					SELECT DocID, DocOwner, COUNT(DocID) AS ReturnNums, IsRef
					FROM ReconcileCompletion
					WHERE DocType = 'R'
					AND IsActive = 'A'
					$filter_criteria
					GROUP BY DocID, DocOwner, IsRef
				) ReconcileReturn
				ON ReconcileDoc.IsRef = ReconcileReturn.IsRef
				LEFT OUTER JOIN ReconcileCompletion
				ON ReconcileDoc.DocID = ReconcileCompletion.DocID
				AND DocType = 'R'
				WHERE NOT LogisticCode IS NULL
			) A
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
	
	private function documentAppAllModePagination($authority, $condition = array(), $criteria){

		$wheres  = "";
		switch($authority) {
			case $this->role_ad:
		
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = '';
				else:
				$wheres = ' AND BranchCode = "'.str_pad($condition[1], 3, "0", STR_PAD_LEFT).'"';
				endif;
		
				break;
			case $this->role_rm:
				$wheres	= ' AND RMCode = "'.$condition[0].'"';
		
				break;
			case $this->role_bm:
				$wheres = ' AND BranchCode = "'.str_pad($condition[1], 3, "0", STR_PAD_LEFT).'"';
		
				break;
			case $this->role_am:
				$wheres = ' AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = "'.$condition[0].'" GROUP BY BranchCode)';
		
				break;
			case $this->role_rd:
				$wheres = ' AND BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = "'.$employees['data'][0]['RegionID'].'" GROUP BY BranchCode)';
		
				break;
			case $this->role_ads:
			case $this->role_hq:
			case $this->role_spv:
				$wheres = '';
				break;
		}
		
		// -------- R ----------
		
		if($condition[2] == 'Active'):
			$filter_criteria = ' AND BranchReceivedDate IS NULL';
		endif;
		
		if($condition[2] == 'InActive'):
			$filter_criteria = ' AND NOT BranchReceivedDate IS NULL';
		endif;
		
		if($condition[2] == 'All'):
			$filter_criteria = '';
		endif;
		
		// -------- M ----------
		
		if($condition[2] == 'Active'):
			$filter_criteria_opt = ' AND SubmitDocToCADate IS NULL';
		endif;
		
		if($condition[2] == 'InActive'):
			$filter_criteria_opt = ' AND NOT SubmitDocToCADate IS NULL';
		endif;
		
		if($condition[2] == 'All'):
			$filter_criteria_opt = '';
		endif;
		
		try {
		
			$result = $this->db->query("
				SELECT *
				FROM(SELECT DISTINCT ReconcileDoc.DocID, ReconcileDoc.BorrowerName,
					ReconcileDoc.BorrowerType, ReconcileReturn.DocOwner,
					CASE 
						WHEN ReconcileMissing.LackNums <= 0 THEN ''
						WHEN ReconcileMissing.LackNums IS NULL THEN ''
						ELSE ReconcileMissing.LackNums
						END AS LackNums,
					CASE 
						WHEN ReconcileReturn.ReturnNums <= 0 THEN ''
						WHEN ReconcileReturn.ReturnNums IS NULL THEN ''
						ELSE ReconcileReturn.ReturnNums
					END AS ReturnNums,
					[Profile].OwnerName, [Profile].Mobile, [Profile].Telephone, LendingBranchs.RegionID, LendingBranchs.BranchCode,
					LendingBranchs.BranchDigit, [Profile].RMCode, [Profile].RMName,
					[Profile].RMMobile, 
					ReconcileDoc.LogisticCode, NCBConsent.NCBCheck, 
					CASE NCBConsent.NCBCheckDate
						WHEN '1900-01-01' THEN ''
						WHEN '' THEN ''
						ELSE CONVERT(nvarchar(10), NCBConsent.NCBCheckDate, 120)
					END AS NCBCheckDate,
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
					END AS AppToCA, ReconcileDoc.CAReturn,
					CASE ReconcileDoc.CAReturnDate
						WHEN '1900-01-01' THEN ''
						WHEN '' THEN ''
						ELSE CONVERT(nvarchar(10), ReconcileDoc.CAReturnDate, 120)
					END AS CAReturnDate, 
					CASE ReconcileCompletion.LBSubmitDocDate
						WHEN '1900-01-01' THEN ''
						WHEN '' THEN NULL
						ELSE CONVERT(nvarchar(10), ReconcileCompletion.LBSubmitDocDate, 120)
					END AS LBSubmitDocDate,
					CASE ReconcileCompletion.BranchReceivedDate
						WHEN '1900-01-01' THEN ''
						WHEN '' THEN NULL
						ELSE CONVERT(nvarchar(10), ReconcileCompletion.BranchReceivedDate, 120)
					END AS BranchReceivedDate,
					ReconcileDoc.IsActive, ReconcileDoc.IsRef,
					CASE [Profile].CreateDate
						WHEN '1900-01-01' THEN ''
						WHEN '' THEN ''
						ELSE CONVERT(nvarchar(10), [Profile].CreateDate, 120)
					END AS CreateProfileDate, 
					CASE
						WHEN NOT ReconcileDoc.SubmitDocToHQ IS NULL AND NOT ReconcileDoc.ReceivedDocFormLB IS NULL
							 AND NOT ReconcileDoc.CompletionDoc IS NULL AND NOT ReconcileDoc.CompletionDate IS NULL 
							 AND ReconcileDoc.CompletionDoc = 'Y' AND NOT ReconcileDoc.AppToCA IS NULL THEN 'InActive'
						WHEN NOT ReconcileDoc.SubmitDocToHQ IS NULL AND NOT ReconcileDoc.ReceivedDocFormLB IS NULL
							 AND NOT ReconcileDoc.CompletionDoc IS NULL AND NOT ReconcileDoc.CompletionDate IS NULL AND ReconcileDoc.CompletionDoc = 'Y'
							 AND NOT ReconcileDoc.AppToCA IS NULL AND NOT ReconcileDoc.CAReturnDate IS NULL THEN 'InActive'
						WHEN ReconcileReturn.ReturnNums IS NULL AND ReconcileMissing.LackNums IS NULL AND ReconcileDoc.CompletionDoc = 'Y' AND NOT ReconcileDoc.CompletionDate IS NULL THEN 'InActive'
						WHEN ReconcileReturn.ReturnNums IS NULL AND ReconcileMissing.LackNums IS NULL AND ReconcileDoc.CompletionDoc = 'Y' AND NOT ReconcileDoc.CompletionDate IS NULL AND NOT ReconcileDoc.CAReturnDate IS NULL THEN 'InActive'
						ELSE 'Active'
					END AS ActiveRecord
					FROM ReconcileDoc
					LEFT OUTER JOIN NCBConsent
					ON ReconcileDoc.IsRef = NCBConsent.IsRef
					LEFT OUTER JOIN [Profile]
					ON ReconcileDoc.DocID = [Profile].DocID
					LEFT OUTER JOIN LendingBranchs
					ON [Profile].BranchCode = LendingBranchs.BranchCode
					LEFT OUTER JOIN (
							SELECT DocID, DocOwner, COUNT(DocID) AS LackNums, IsRef
							FROM ReconcileCompletion
							WHERE DocType = 'M'
							AND IsActive = 'A'
							$filter_criteria_opt
							GROUP BY DocID, DocOwner, IsRef
					) ReconcileMissing
					ON ReconcileDoc.IsRef = ReconcileMissing.IsRef
					LEFT OUTER JOIN (
						SELECT DocID, DocOwner, COUNT(DocID) AS ReturnNums, IsRef
						FROM ReconcileCompletion
						WHERE DocType = 'R'
						AND IsActive = 'A'
						$filter_criteria
						GROUP BY DocID, DocOwner, IsRef
					) ReconcileReturn
					ON ReconcileDoc.IsRef = ReconcileReturn.IsRef
					LEFT OUTER JOIN ReconcileCompletion
					ON ReconcileDoc.DocID = ReconcileCompletion.DocID 
					AND DocType = 'R'
					WHERE NOT LogisticCode IS NULL
				) A
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