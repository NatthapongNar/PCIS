<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dbprogress extends CI_Model {
	
	// Gobal
	public $logs;
	private $individual_mode;
	private $branch_mode;
		
	// Application Process
	private $table_profile;
	private $table_verification;
	private $table_applicationstatus;
	
	// Relation Tables
	private $table_employees;
	private $table_branchs;
	
	// Object Role
	private $role_ad;
	private $role_rm;
	private $role_bm;
	private $role_am;
	private $role_rd;
	private $role_hq;
	private $role_spv;
	private $role_ads;	
	
	public $db_types;
	public $char_mode;
	
	public function __construct() {
		parent::__construct();
		$this->load->database("dbprogress");	
		
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
		
		$this->char_mode					= $this->config->item('char_mode');
		$this->db_types						= $this->config->item('database_types');
		
		$this->logs			 				= $_SERVER['DOCUMENT_ROOT'].'/ci/logs/debug/';
		$this->individual_mode				= 'individual';
		$this->branch_mode					= 'branchs';
		
	}
	
	
	/**
	 * @Param 1: Priviles position
	 * @Param 2: Condition or data criteria searching. First array is employeecode
	 * @Param 3: Limit, Offset, more 3 is other...
	 */
	public function loadDataProgress($authority, $condition = array(), $optional = array()) {
		$this->load->model('dbmodel');		
		if(empty($authority)) {
			
			$objForms = array(
				"Privileges" => $authority,
				"Condition"	 => $condition,
				"Optional"	 => $optional
			);
			
			log_message('error', 'method '.__METHOD__ .'can not load data progress. please check object criteria.');
			$this->writelogs($this->logs."model/dbprogress/", "dbprog_", $objForms);
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
			
		} else {
			
			if(count($authority) > 1) {
				$privileges = $authority[0];
			
			} else {
				$privileges = $authority[0];
			}
			
			// load data employees.
			$employees = $this->employeesInfo($condition[0]);
			$branchs   = str_pad($employees['data'][0]['BranchCode'], 3, "0", STR_PAD_LEFT);
			
			$searching = !empty($condition[1]) ? $condition[1]:"";
			
			switch($privileges) {
				
				case $this->role_ad:			
				case $this->role_bm:
				case $this->role_hq:
				case $this->role_spv:
				case $this->role_ads:
				
					if($branchs == "000" || $branchs == "901") {
						
						$result = $this->dbmodel->CIQuery("
							SELECT * FROM (
								SELECT *, ROW_NUMBER() OVER (ORDER BY CreateDate DESC) as KeyPoint FROM (
									SELECT TOP 100 PERCENT
									[Profile].DocID, CONVERT(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate, [Profile].OwnerName,
									[Profile].Company, [Profile].RequestLoan, Branch.RegionID,
									[Profile].RMName, Branch.BranchCode, Branch.BranchName, Branch.BranchDigit, NCB.MainLoanName,
									[Profile].IsActive AS application_process,
									Verify.IsActive AS verification_process,
									AppStatus.IsActive AS applictionstatus_process,
									DAY([Profile].CreateDate) AS DD,
									MONTH([Profile].CreateDate) AS MM,
									YEAR([Profile].CreateDate) AS YYYY
									FROM [Profile]
									LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
									LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
									LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
									LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
								) C
								WHERE NOT OwnerName like '%_test'
								AND NOT OwnerName like 'ทดสอบ%'
								$searching
							) A
							WHERE A.KeyPoint >= '".$optional[0]."' and A.KeyPoint <= '".$optional[1]."'
							ORDER BY YYYY DESC, MM DESC, DD DESC
						");	
					
						return $result;
						
					} else {
						
						$result = $this->dbmodel->CIQuery("
							SELECT * FROM (
								SELECT *, ROW_NUMBER() OVER (ORDER BY CreateDate DESC) as KeyPoint FROM (
									SELECT TOP 100 PERCENT
									[Profile].DocID, CONVERT(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate, [Profile].OwnerName,
									[Profile].Company, [Profile].RequestLoan, Branch.RegionID,
									[Profile].RMName, Branch.BranchCode, Branch.BranchName, Branch.BranchDigit, NCB.MainLoanName,
									[Profile].IsActive AS application_process,
									Verify.IsActive AS verification_process,
									AppStatus.IsActive AS applictionstatus_process,
									DAY([Profile].CreateDate) AS DD,
									MONTH([Profile].CreateDate) AS MM,
									YEAR([Profile].CreateDate) AS YYYY
									FROM [Profile]
									LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
									LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
									LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
									LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
									WHERE [Profile].BranchCode = '".$branchs."'
								) C
								WHERE NOT OwnerName like '%_test'
								AND NOT OwnerName like 'ทดสอบ%'
								$searching
							) A
							WHERE A.KeyPoint >= '".$optional[0]."' and A.KeyPoint <= '".$optional[1]."'
							ORDER BY YYYY DESC, MM DESC, DD DESC
						");
							
						return $result;
						
					}
										
					break;
				case $this->role_rm:
					$result = $this->dbmodel->CIQuery("
							SELECT * FROM (
								SELECT *, ROW_NUMBER() OVER (ORDER BY CreateDate DESC) as KeyPoint FROM (
									SELECT TOP 100 PERCENT
									[Profile].DocID, CONVERT(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate, [Profile].OwnerName,
									[Profile].Company, [Profile].RequestLoan, Branch.RegionID,
									[Profile].RMName, Branch.BranchCode, Branch.BranchName, Branch.BranchDigit, NCB.MainLoanName,
									[Profile].IsActive AS application_process,
									Verify.IsActive AS verification_process,
									AppStatus.IsActive AS applictionstatus_process,
									DAY([Profile].CreateDate) AS DD,
									MONTH([Profile].CreateDate) AS MM,
									YEAR([Profile].CreateDate) AS YYYY
									FROM [Profile]
									LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
									LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
									LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
									LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
									WHERE [Profile].BranchCode = '".$branchs."'
								) C
							WHERE NOT OwnerName like '%_test'
							AND NOT OwnerName like 'ทดสอบ%'
							AND RMName LIKE '%".$employees['data'][0]['FullnameTh']."%'
							$searching
							) A
							WHERE A.KeyPoint >= '".$optional[0]."' and A.KeyPoint <= '".$optional[1]."'
							ORDER BY YYYY DESC, MM DESC, DD DESC");
						return $result;
					break;
				case $this->role_am:
					
					$result	= $this->dbmodel->CIQuery("
						SELECT * FROM (
							SELECT *, ROW_NUMBER() OVER (ORDER BY CreateDate DESC) as KeyPoint FROM (
								SELECT TOP 100 PERCENT
								[Profile].DocID, CONVERT(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate, [Profile].OwnerName,
								[Profile].Company, [Profile].RequestLoan, Branch.RegionID,
								[Profile].RMName, Branch.BranchCode, Branch.BranchName, Branch.BranchDigit, NCB.MainLoanName,
								[Profile].IsActive AS application_process,
								Verify.IsActive AS verification_process,
								AppStatus.IsActive AS applictionstatus_process,
								DAY([Profile].CreateDate) AS DD,
								MONTH([Profile].CreateDate) AS MM,
								YEAR([Profile].CreateDate) AS YYYY
								FROM [Profile]
								LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
								LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
								LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
								LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
								WHERE [Profile].BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' GROUP BY BranchCode)
							) C
							WHERE NOT OwnerName like '%_test'
							AND NOT OwnerName like 'ทดสอบ%'
							$searching
						) A
						WHERE A.KeyPoint >= '".$optional[0]."' and A.KeyPoint <= '".$optional[1]."'
						ORDER BY YYYY DESC, MM DESC, DD DESC
					");
					
					return $result;
					
					break;
				case $this->role_rd:
					
					$result	= $this->dbmodel->CIQuery("
						SELECT * FROM (
							SELECT *, ROW_NUMBER() OVER (ORDER BY CreateDate DESC) as KeyPoint FROM (
								SELECT TOP 100 PERCENT
								[Profile].DocID, CONVERT(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate, [Profile].OwnerName,
								[Profile].Company, [Profile].RequestLoan, Branch.RegionID,
								[Profile].RMName, Branch.BranchCode, Branch.BranchName, Branch.BranchDigit, NCB.MainLoanName,
								[Profile].IsActive AS application_process,
								Verify.IsActive AS verification_process,
								AppStatus.IsActive AS applictionstatus_process,
								DAY([Profile].CreateDate) AS DD,
								MONTH([Profile].CreateDate) AS MM,
								YEAR([Profile].CreateDate) AS YYYY
								FROM [Profile]
								LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
								LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
								LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
								LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
								WHERE [Profile].BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)
							) C
							WHERE NOT OwnerName like '%_test'
							AND NOT OwnerName like 'ทดสอบ%'
							$searching
						) A
						WHERE A.KeyPoint >= '".$optional[0]."' and A.KeyPoint <= '".$optional[1]."'
						ORDER BY YYYY DESC, MM DESC, DD DESC		
					");
					
					return $result;
					
					break;
				
			}
			
		}
		
	}
	
	public function paginationGenerate($authority, $condition = array(), $option = array()) {
		$this->load->model('dbmodel');
		if(empty($authority)) {
				
			$objForms = array(
					"Privileges" => $authority,
					"Condition"	 => $condition,
					"Optional"	 => $optional
			);
				
			log_message('error', 'method '.__METHOD__ .'can not load data progress. please check object criteria.');
			$this->writelogs($this->logs."model/dbprogress/", "dbprog_", $objForms);
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
				
		} else {
			
			if(count($authority) > 1) {
				$privileges = $authority[0];
					
			} else {
				$privileges = $authority[0];
			}
			
			$employees = $this->employeesInfo($condition[0]);
			$branchs   = str_pad($employees['data'][0]['BranchCode'], 3, "0", STR_PAD_LEFT);
			$searching = !empty($condition[1]) ? $condition[1]:"";
				
			switch($privileges) {
				case $this->role_ad:
				case $this->role_bm:
				case $this->role_hq:
				case $this->role_spv:
				case $this->role_ads:
					
					if($branchs == "000" || $branchs == "901") {
						
						$result	= $this->dbmodel->CIQuery("
							SELECT * 
							FROM (
								SELECT
									[Profile].DocID, Branch.RegionID, [Profile].BranchCode, Branch.BranchDigit, [Profile].OwnerName, [Profile].RMName, [Profile].RequestLoan,
									convert(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate,
									[Profile].IsActive AS Application_Process,
									Verify.IsActive AS Verification_Process,
									AppStatus.IsActive AS Applictionstatus_Process
								FROM [Profile]
								LEFT OUTER JOIN Verification AS Verify
								ON [Profile].DocID = Verify.DocID
								LEFT OUTER JOIN ApplicationStatus AS AppStatus
								ON [Profile].DocID = AppStatus.DocID
								LEFT OUTER JOIN LendingBranchs AS Branch 
								ON [Profile].BranchCode = Branch.BranchCode 
								LEFT OUTER JOIN NCB 
								ON Verify.VerifyID = NCB.VerifyID
								WHERE NOT [Profile].OwnerName like '%_test'
								AND NOT [Profile].OwnerName like 'ทดสอบ%'
							) A
							WHERE NOT DocID LIKE '%del'
							$searching");
						
						return $result['rows'];
						
					} else {
						
						$result	= $this->dbmodel->CIQuery("
							SELECT * 
							FROM (
								SELECT
									[Profile].DocID, Branch.RegionID, [Profile].BranchCode, Branch.BranchDigit, [Profile].OwnerName, [Profile].RMName, [Profile].RequestLoan,
									convert(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate,
									[Profile].IsActive AS Application_Process,
									Verify.IsActive AS Verification_Process,
									AppStatus.IsActive AS Applictionstatus_Process
								FROM [Profile]
								LEFT OUTER JOIN Verification AS Verify
								ON [Profile].DocID = Verify.DocID
								LEFT OUTER JOIN ApplicationStatus AS AppStatus
								ON [Profile].DocID = AppStatus.DocID
								LEFT OUTER JOIN LendingBranchs AS Branch
								ON [Profile].BranchCode = Branch.BranchCode
								LEFT OUTER JOIN NCB
								ON Verify.VerifyID = NCB.VerifyID
								WHERE NOT [Profile].OwnerName like '%_test'
								AND NOT [Profile].OwnerName like 'ทดสอบ%'
								AND [Profile].BranchCode = '".$branchs."'
							) A
							WHERE NOT DocID LIKE '%del'
							$searching");
						
						return $result['rows'];
						
					}

					break;
				case $this->role_rm:
					$result	= $this->dbmodel->CIQuery("
						SELECT *
						FROM (
							SELECT
								[Profile].DocID, Branch.RegionID, [Profile].BranchCode, Branch.BranchDigit, [Profile].OwnerName, [Profile].RMName, [Profile].RequestLoan,
								convert(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate,
								[Profile].IsActive AS Application_Process,
								Verify.IsActive AS Verification_Process,
								AppStatus.IsActive AS Applictionstatus_Process
							FROM [Profile]
							LEFT OUTER JOIN Verification AS Verify
							ON [Profile].DocID = Verify.DocID
							LEFT OUTER JOIN ApplicationStatus AS AppStatus
							ON [Profile].DocID = AppStatus.DocID
							LEFT OUTER JOIN LendingBranchs AS Branch
							ON [Profile].BranchCode = Branch.BranchCode
							LEFT OUTER JOIN NCB
							ON Verify.VerifyID = NCB.VerifyID
							WHERE NOT [Profile].OwnerName like '%_test'
							AND NOT [Profile].OwnerName like 'ทดสอบ%'
							AND [Profile].BranchCode = '".$branchs."'
							AND RMName LIKE '%".$employees['data'][0]['FullnameTh']."%'
						) A
						WHERE NOT DocID LIKE '%del'
						$searching");
					
						return $result['rows'];
						
					break;	
				case $this->role_am:
					
					$result	= $this->dbmodel->CIQuery("
								SELECT *
								FROM (
										SELECT
											[Profile].DocID, Branch.RegionID, [Profile].BranchCode, Branch.BranchDigit, [Profile].OwnerName, [Profile].RMName, [Profile].RequestLoan,
											convert(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate,
											[Profile].IsActive AS Application_Process,
											Verify.IsActive AS Verification_Process,
											AppStatus.IsActive AS Applictionstatus_Process
										FROM [Profile]
										LEFT OUTER JOIN Verification AS Verify
										ON [Profile].DocID = Verify.DocID
										LEFT OUTER JOIN ApplicationStatus AS AppStatus
										ON [Profile].DocID = AppStatus.DocID
										LEFT OUTER JOIN LendingBranchs AS Branch
										ON [Profile].BranchCode = Branch.BranchCode
										LEFT OUTER JOIN NCB
										ON Verify.VerifyID = NCB.VerifyID
										WHERE NOT [Profile].OwnerName like '%_test'
										AND NOT [Profile].OwnerName like 'ทดสอบ%'
										AND [Profile].BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' GROUP BY BranchCode)
								) A
								WHERE NOT DocID LIKE '%del'
							$searching");
								
							return $result['rows'];
					
					break;
				case $this->role_rd:
					
					$result	= $this->dbmodel->CIQuery("
								SELECT * 
								FROM (
									SELECT
										[Profile].DocID, Branch.RegionID, [Profile].BranchCode, Branch.BranchDigit, [Profile].OwnerName, [Profile].RMName, [Profile].RequestLoan,
										convert(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate,
										[Profile].IsActive AS Application_Process,
										Verify.IsActive AS Verification_Process,
										AppStatus.IsActive AS Applictionstatus_Process
									FROM [Profile]
									LEFT OUTER JOIN Verification AS Verify
									ON [Profile].DocID = Verify.DocID
									LEFT OUTER JOIN ApplicationStatus AS AppStatus
									ON [Profile].DocID = AppStatus.DocID
									LEFT OUTER JOIN LendingBranchs AS Branch 
									ON [Profile].BranchCode = Branch.BranchCode 
									LEFT OUTER JOIN NCB 
									ON Verify.VerifyID = NCB.VerifyID
									WHERE NOT [Profile].OwnerName like '%_test'
									AND NOT [Profile].OwnerName like 'ทดสอบ%'
									AND [Profile].BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)
								) A
								WHERE NOT DocID LIKE '%del'
								$searching");
					
					return $result['rows'];
					
					break;
					
			}
			
			
		}
		
	}
	
	public function appProgressBranch($authority, $condition = array()) {
		$this->load->model('dbmodel');
		if(empty($authority)) {
	
			$objForms = array(
					"Privileges" => $authority,
					"Condition"	 => $condition,
					"Optional"	 => $optional
			);
	
			log_message('error', 'method '.__METHOD__ .'can not load data progress. please check object criteria.');
			$this->writelogs($this->logs."model/dbprogress/", "dbprog_", $objForms);
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
	
		} else {
			
			if(count($authority) > 1):
				$privileges = $authority[0];					
			else:
				$privileges = $authority[0];
			endif;
				
			$employees = $this->employeesInfo($condition[0]);
			$branchs   = str_pad($employees['data'][0]['BranchCode'], 3, "0", STR_PAD_LEFT);
			$searching = !empty($condition[1]) ? $condition[1]:"";
			
			switch ($privileges) {
				case $this->role_ad:
				case $this->role_rm:
				case $this->role_bm:
				case $this->role_hq:
				case $this->role_spv:
				case $this->role_ads:
						
					if($branchs == "000" || $branchs == "901") {
						
						$result = $this->dbmodel->CIQuery("
							SELECT RegionID, BranchCode, BranchDigit, BranchName
							FROM LendingBranchs
							WHERE LendingBranchs.IsActive = 'A'
							ORDER BY BranchDigit ASC");
						return $result;
						
					} else {
						
						// Admin are not head office
						// Check has authority area manager
						$select_privilege = '';
						if(in_array($this->role_am, $authority)):
							$select_privilege = " WHERE BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' AND LendingBranchs.IsActive = 'A' GROUP BY BranchCode)";
						else:
							$select_privilege = " WHERE BranchCode = '".$branchs."' AND LendingBranchs.IsActive = 'A'";
						endif;
						
						$result = $this->dbmodel->CIQuery("
							SELECT
							LendingBranchs.RegionID, MasterRegion.RegionNameEng, LendingBranchs.BranchCode, LendingBranchs.BranchDigit, LendingBranchs.BranchName
							FROM LendingBranchs
							LEFT OUTER JOIN MasterRegion
							ON LendingBranchs.RegionID = MasterRegion.RegionID
							$select_privilege
							ORDER BY LendingBranchs.BranchDigit ASC");
						return $result;
						
					}
					
					break;
				case $this->role_am:
					
					$result	= $this->dbmodel->CIQuery("
						SELECT
						LendingBranchs.RegionID, MasterRegion.RegionNameEng, LendingBranchs.BranchCode, LendingBranchs.BranchDigit, LendingBranchs.BranchName
						FROM LendingBranchs
						LEFT OUTER JOIN MasterRegion
						ON LendingBranchs.RegionID = MasterRegion.RegionID
						WHERE LendingBranchs.BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' GROUP BY BranchCode)
						AND LendingBranchs.IsActive = 'A'
						ORDER BY LendingBranchs.BranchDigit ASC");
					return $result;
					
					break;
				case $this->role_rd:
					
					$result = $this->dbmodel->CIQuery("
						SELECT
						LendingBranchs.RegionID, MasterRegion.RegionNameEng, LendingBranchs.BranchCode, LendingBranchs.BranchDigit, LendingBranchs.BranchName
						FROM LendingBranchs
						LEFT OUTER JOIN MasterRegion
						ON LendingBranchs.RegionID = MasterRegion.RegionID
						WHERE LendingBranchs.BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)
						AND LendingBranchs.IsActive = 'A'
						ORDER BY LendingBranchs.BranchDigit ASC");
					return $result; 
					
					break;
				
			}
				
				
		}
	
	
	}
	
	public function setBranchBoundary($region_id) {
		$this->load->model('dbmodel');

		try {			
			
			if(!empty($region_id)) {
				$where = "AND (RegionID = '".$region_id."')";
			} else {
				$where = '';
			}
			
			$result = $this->dbmodel->CIQuery("SELECT BranchCode, BranchDigit, BranchName, RegionID FROM LendingBranchs WHERE (IsActive = 'A') $where ORDER BY BranchDigit ASC");
			
			return $result;
			
		} catch (Exception $e) {
			
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
			
		}

	}
	
	public function regionListInfo() {
		$result = $this->dbmodel->CIQuery("
						SELECT 
						LendingBranchs.RegionID, MasterRegion.RegionNameEng, LendingBranchs.BranchCode, LendingBranchs.BranchDigit
						FROM LendingBranchs
						LEFT OUTER JOIN MasterRegion
						ON LendingBranchs.RegionID = MasterRegion.RegionID
						WHERE LendingBranchs.BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)");
		return $result;
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
				LEFT OUTER JOIN LendingBranchs
				ON ISNULL(LendingEmp.BranchCode, LendingEmp.OfficeBase) = LendingBranchs.BranchCode
				LEFT OUTER JOIN MasterArea
				ON MasterArea.AreaName = LendingEmp.AreaCode
				LEFT OUTER JOIN MasterRegion
				ON LendingEmp.RegionID = MasterRegion.RegionID
				WHERE LendingEmp.IsActive = 'A'
				AND LendingEmp.EmployeeCode = '".$emp_code."'		
			");
			
			return $result;
			
		}
				
	}
	
	/**
	 * @Param 1: Priviles position
	 * @Param 2: Condition or data criteria searching. First array is employeecode
	 * @Param 3: Limit, Offset, more 3 is other...
	 */
	public function loadDataProgressOveride($authority, $condition = array()) {
		$this->load->model('dbmodel');
		if(empty($authority)) {
				
			$objForms = array(
					"Privileges" => $authority,
					"Condition"	 => $condition,
					"Optional"	 => $optional
			);
				
			log_message('error', 'method '.__METHOD__ .'can not load data progress. please check object criteria.');
			$this->writelogs($this->logs."model/dbprogress/", "dbprog_", $objForms);
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
				
		} else {
				
			if(count($authority) > 1) {
				$privileges = $authority[0];
					
			} else {
				$privileges = $authority[0];
			}
				
			// load data employees.
			$employees = $this->employeesInfo($condition[0]);
			$branchs   = str_pad($employees['data'][0]['BranchCode'], 3, "0", STR_PAD_LEFT);
				
			$searching = !empty($condition[1]) ? $condition[1]:"";
			switch($privileges) {
	
				case $this->role_ad:
				case $this->role_bm:
				case $this->role_hq:
				case $this->role_spv:
				case $this->role_ads:
	
					if($branchs == "000" || $branchs == "901") {
	
						$result = $this->dbmodel->CIQuery("
							SELECT * FROM (
								SELECT *, ROW_NUMBER() OVER (ORDER BY CreateDate DESC) as KeyPoint FROM (
									SELECT TOP 100 PERCENT
									[Profile].DocID, CONVERT(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate, [Profile].OwnerName,
										[Profile].Company, [Profile].RequestLoan, Branch.RegionID,
										[Profile].RMName, Branch.BranchCode, Branch.BranchName, Branch.BranchDigit, NCB.MainLoanName,
										[Profile].IsActive AS application_process,
										Verify.IsActive AS verification_process,
										AppStatus.IsActive AS applictionstatus_process,
										DAY([Profile].CreateDate) AS DD,
										MONTH([Profile].CreateDate) AS MM,
										YEAR([Profile].CreateDate) AS YYYY
									FROM [Profile]
									LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
									LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
									LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
									LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
								) C
								WHERE NOT OwnerName like '%_test'
								AND NOT OwnerName like 'ทดสอบ%'
								$searching
							) A
							ORDER BY YYYY DESC, MM DESC, DD DESC
						");
							
						return $result;
	
					} else {
	
					$result = $this->dbmodel->CIQuery("
							SELECT * FROM (
								SELECT *, ROW_NUMBER() OVER (ORDER BY CreateDate DESC) as KeyPoint FROM (
									SELECT TOP 100 PERCENT
										[Profile].DocID, CONVERT(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate, [Profile].OwnerName,
										[Profile].Company, [Profile].RequestLoan, Branch.RegionID,
										[Profile].RMName, Branch.BranchCode, Branch.BranchName, Branch.BranchDigit, NCB.MainLoanName,
										[Profile].IsActive AS application_process,
										Verify.IsActive AS verification_process,
										AppStatus.IsActive AS applictionstatus_process,
										DAY([Profile].CreateDate) AS DD,
										MONTH([Profile].CreateDate) AS MM,
										YEAR([Profile].CreateDate) AS YYYY
									FROM [Profile]
									LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
									LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
									LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
									LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
									WHERE [Profile].BranchCode = '".$branchs."'
								) C
								WHERE NOT OwnerName like '%_test'
								AND NOT OwnerName like 'ทดสอบ%'
								$searching
							) A
							ORDER BY YYYY DESC, MM DESC, DD DESC
						");
				
						return $result;
	
					}
	
					break;
					case $this->role_rm:
					$result = $this->dbmodel->CIQuery("
						SELECT * FROM (
							SELECT *, ROW_NUMBER() OVER (ORDER BY CreateDate DESC) as KeyPoint FROM (
									SELECT TOP 100 PERCENT
											[Profile].DocID, CONVERT(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate, [Profile].OwnerName,
											[Profile].Company, [Profile].RequestLoan, Branch.RegionID,
											[Profile].RMName, Branch.BranchCode, Branch.BranchName, Branch.BranchDigit, NCB.MainLoanName,
											[Profile].IsActive AS application_process,
											Verify.IsActive AS verification_process,
											AppStatus.IsActive AS applictionstatus_process,
											DAY([Profile].CreateDate) AS DD,
											MONTH([Profile].CreateDate) AS MM,
											YEAR([Profile].CreateDate) AS YYYY
										FROM [Profile]
										LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
										LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
										LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
										LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
										WHERE [Profile].BranchCode = '".$branchs."'
									) C
								WHERE NOT OwnerName like '%_test'
								AND NOT OwnerName like 'ทดสอบ%'
								AND RMName LIKE '%".$employees['data'][0]['FullnameTh']."%'
								$searching
						) A
						ORDER BY YYYY DESC, MM DESC, DD DESC");
						return $result;
					break;
				case $this->role_am:
						
					$result	= $this->dbmodel->CIQuery("
							SELECT * FROM (
							SELECT *, ROW_NUMBER() OVER (ORDER BY CreateDate DESC) as KeyPoint FROM (
									SELECT TOP 100 PERCENT
											[Profile].DocID, CONVERT(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate, [Profile].OwnerName,
											[Profile].Company, [Profile].RequestLoan, Branch.RegionID,
											[Profile].RMName, Branch.BranchCode, Branch.BranchName, Branch.BranchDigit, NCB.MainLoanName,
											[Profile].IsActive AS application_process,
											Verify.IsActive AS verification_process,
											AppStatus.IsActive AS applictionstatus_process,
											DAY([Profile].CreateDate) AS DD,
											MONTH([Profile].CreateDate) AS MM,
											YEAR([Profile].CreateDate) AS YYYY
										FROM [Profile]
										LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
										LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
										LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
										LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
										WHERE [Profile].BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' GROUP BY BranchCode)
										) C
									WHERE NOT OwnerName like '%_test'
									AND NOT OwnerName like 'ทดสอบ%'
									$searching
									) A
									ORDER BY YYYY DESC, MM DESC, DD DESC
							");
								
							return $result;
			
					break;
				case $this->role_rd:
								
							$result	= $this->dbmodel->CIQuery("
							SELECT * FROM (
								SELECT *, ROW_NUMBER() OVER (ORDER BY CreateDate DESC) as KeyPoint FROM (
									SELECT TOP 100 PERCENT
										[Profile].DocID, CONVERT(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate, [Profile].OwnerName,
										[Profile].Company, [Profile].RequestLoan, Branch.RegionID,
										[Profile].RMName, Branch.BranchCode, Branch.BranchName, Branch.BranchDigit, NCB.MainLoanName,
										[Profile].IsActive AS application_process,
										Verify.IsActive AS verification_process,
										AppStatus.IsActive AS applictionstatus_process,
										DAY([Profile].CreateDate) AS DD,
										MONTH([Profile].CreateDate) AS MM,
										YEAR([Profile].CreateDate) AS YYYY
									FROM [Profile]
									LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
									LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
									LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
									LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
									WHERE [Profile].BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)
									) C
								WHERE NOT OwnerName like '%_test'
								AND NOT OwnerName like 'ทดสอบ%'
								$searching
							) A
							ORDER BY YYYY DESC, MM DESC, DD DESC");
			
						return $result;
			
					break;
	
			}
										
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
	
	// New
	public function dataTablePagination($authority, $condition = array()) {
		$this->load->model('dbmodel');
	
		$this->load->library('effective');
		$wheres 		= "WHERE NOT CONVERT(nvarchar(10), CreateDate, 120) = '' AND NOT CONVERT(nvarchar(10), CreateDate, 120) = '1900-01-01'";
		$wheres_name	= "WHERE NOT IsActive  = ''";
	
		$startdate           		= $this->input->post('createdate_start');
		$enddate            	    = $this->input->post('createdate_end');

		$start_loan					= (int)$this->input->post('loan_start');
		$end_loan					= (int)$this->input->post('loan_end');
		$customers					= $this->effective->set_chartypes($this->char_mode, $this->input->post('custname'));
		$rmname						= $this->input->post('rmname'); //$this->effective->set_chartypes($this->char_mode, $this->input->post('rmname'));
		$business_location			= $this->effective->set_chartypes($this->char_mode, $this->input->post('location'));
		$region						= $this->input->post('region');
		$branchs					= $this->input->post('branchs');
		$source_cust				= $this->input->post('source_cust');
		$id_card           			= $this->input->post('id_card');
		$application_no          	= strtoupper($this->input->post('appno'));
		$activerows					= $this->input->post('activerecords');
	
		$createdate_start  = !empty($startdate) ? $this->effective->StandartDateSorter($startdate):"";
		$createdate_end	   = !empty($enddate) ? $this->effective->StandartDateSorter($enddate):"";
	
		/* ############ KPI ############ */
		$kpi_search		= $this->input->post('search_kpi');
		$kpi_no			= $this->input->post('kpino');
		$emp_kpi		= $this->input->post('emp_auth');
		$mode_kpi		= $this->input->post('mode_kpi');
	
		$wheres_kpi		= "";
		$kpi_privileges	= "";
		if($kpi_search == 'true') {
	
			$special_role 	= $this->dbcustom->setDataAuthority($emp_kpi);
	
			$get_info 		= $this->dbcustom->getEmployeeDataInfo($emp_kpi);
			$brn_code 		= $get_info['data'][0]['BranchCode'];
			$area_code  	= $get_info['data'][0]['AreaCode'];
			$region_id  	= $get_info['data'][0]['RegionID'];
	
			$kpi_privileges  = $this->dbcustom->getAuthPermission($special_role);
	
			$first_date		= trim(date('Y-m-').'01');
			$second_date	= trim(date('Y-m-').date('t', strtotime(date("Y-m-d"))));
	
			if($kpi_no == '2') {
				//$wheres_kpi .= " AND SourceOfCustomer = 'Field visit'";
				$wheres_kpi .= " AND CreateDate BETWEEN '".$first_date."' AND '".$second_date."'";
	
			}
	
		}
		/* ############ KPI ############ */
		
		$pieces_sourcefield = explode(',', $source_cust);
		// Cut off - List condition
		// Interest Or Not
		$interest_condition = array();
		if(in_array('Y', $pieces_sourcefield)):
			array_push($interest_condition, 'Y');
			$key = array_search('Y', $pieces_sourcefield);
			if($key !== false) unset($pieces_sourcefield[$key]);
		endif;
		
		if(in_array('N', $pieces_sourcefield)):
			array_push($interest_condition, 'N');
			$key = array_search('N', $pieces_sourcefield);
			if($key !== false) unset($pieces_sourcefield[$key]);
		endif;
		
		// Potential Customer
		$level_customer = array();
		if(in_array('H', $pieces_sourcefield)):
			array_push($level_customer, 'H');
			$key = array_search('H', $pieces_sourcefield);
			if($key !== false) unset($pieces_sourcefield[$key]);
		endif;
		
		if(in_array('M', $pieces_sourcefield)):
			array_push($level_customer, 'M');
			$key = array_search('M', $pieces_sourcefield);
			if($key !== false) unset($pieces_sourcefield[$key]);
		endif;
		
		if(in_array('L', $pieces_sourcefield)):
			array_push($level_customer, 'L');
			$key = array_search('L', $pieces_sourcefield);
			if($key !== false) unset($pieces_sourcefield[$key]);
		endif;
		
		// Loan Type
		$LoanGroup_Types = array();
		if(in_array('NN', $pieces_sourcefield)):
			array_push($LoanGroup_Types, 'NN');
			$key = array_search('NN', $pieces_sourcefield);
			if($key !== false) unset($pieces_sourcefield[$key]);
		endif;
		
		if(in_array('MF', $pieces_sourcefield)):
			array_push($LoanGroup_Types, 'MF');
			$key = array_search('MF', $pieces_sourcefield);
			if($key !== false) unset($pieces_sourcefield[$key]);
		endif;
		
		if(in_array('SB', $pieces_sourcefield)):
			array_push($LoanGroup_Types, 'SB');
			$key = array_search('SB', $pieces_sourcefield);
			if($key !== false) unset($pieces_sourcefield[$key]);
		endif;
		
		if(in_array('MF SME', $pieces_sourcefield)):
			array_push($LoanGroup_Types, 'MF SME');
			$key = array_search('MF SME', $pieces_sourcefield);
			if($key !== false) unset($pieces_sourcefield[$key]);
		endif;
		
		// Staft Array
		if(!empty($interest_condition[0])):
			$where_interest = "'".implode("','", $interest_condition)."'";
		else:
			$where_interest = "";
		endif;
		
		if(!empty($level_customer[0])):
			$where_potential = "'".implode("','", $level_customer)."'";
		else:
			$where_potential = "";
		endif;
		
		
		if(!empty($LoanGroup_Types[0])):
			$where_loangroup = "'".implode("','", $LoanGroup_Types)."'";
		else:
			$where_loangroup = "";
		endif;
		
		// Branch List
		$pieces = explode(',', $branchs);
		if(!empty($pieces[0])) {
			$where_brachs 	= "'".implode("','", $pieces)."'";
		} else {
			$where_brachs   = "";
		}
	
		// Employee List
		$rmlist_pieces = explode(',', $rmname);
		if(!empty($rmlist_pieces[0])):
			$wheres_rmlist   = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $rmlist_pieces)."'");
		else:
			$wheres_rmlist   = "";
		endif;
	
		// Source Of Customer		
		if(!empty($pieces_sourcefield[0])) {
			$where_source 	= "'".implode("','", $pieces_sourcefield)."'";
		} else {
			$where_source   = "";
		}
		
		// Business Location
		$pieces_blc = explode(',', $business_location);
		if(!empty($pieces_blc[0])):
			
			$where_blc = '';
			for($i = 0; $i < count($pieces_blc); $i++) {
					
				if($i == '0') {
					$where_blc .= " AND Downtown LIKE '%".$pieces_blc[$i]."%' ";
		
				} else {
					$where_blc .= " OR Downtown LIKE '%".$pieces_blc[$i]."%' ";
		
				}
					
			}
			
		else :
			$where_blc = '';
		endif;
	
		if(!empty($startdate) && !empty($enddate)) {
			$wheres .= " AND CONVERT(nvarchar(10), CreateDate, 120) BETWEEN '".$createdate_start."' AND '".$createdate_end."'";
	
		} else {
	
			if(!empty($startdate)) {
				$wheres .= " AND CONVERT(nvarchar(10), CreateDate, 120) = '".$createdate_start."'";
			}
	
			if(!empty($enddate)) {
				$wheres .= " AND CONVERT(nvarchar(10), CreateDate, 120) = '".$createdate_end."'";
			}
	
		}
			
		if(!empty($start_loan) && !empty($end_loan)) {
			$wheres .= " AND RequestLoan BETWEEN '".$start_loan."' AND '".$end_loan."'";
				
		} else {
				
			if(!empty($start_loan)) {
				$wheres .= " AND RequestLoan = '".$start_loan."'";
			}
				
			if(!empty($end_loan)) {
				$wheres .= " AND RequestLoan = '".$end_loan."'";
			}
				
		}
	
		if(!empty($customers)) {
			$wheres_name .= " AND (MainLoanName LIKE '%".$customers."%' OR OwnerName LIKE '%".$customers."%')";
		}
	
		if(!empty($region)) {
			$wheres .= " AND RegionID = '".$region."'";
		}
		
		if(!empty($rmlist_pieces[0])) { $wheres .= " AND RMCode in ($wheres_rmlist) "; }
		if(!empty($pieces[0])) { $wheres .= " AND BranchCode in ($where_brachs) "; }
		if(!empty($pieces_sourcefield[0])) { $wheres .= " AND SourceChannel in ($where_source) "; }
		if(!empty($pieces_blc[0])) { $wheres .= $where_blc; }
		  
		if(!empty($interest_condition[0])) { $wheres_name .= " AND Interest in ($where_interest) "; }
		if(!empty($level_customer[0])) { $wheres_name .= " AND CSPotential in ($where_potential) "; }
		if(!empty($LoanGroup_Types[0])) { $wheres_name .= " AND LoanGroup in ($where_loangroup) "; }

		if(!empty($id_card)) {
			$wheres .= " AND ID_Card = '".$id_card."'";
		}
	
		if(!empty($application_no)) {
			$wheres .= " AND ApplicationNo = '".$application_no."'";
		}
	
		if($activerows == "Active") { $wheres_name .= " AND RecordActive = '".$activerows."'"; }
		if($activerows == "InActive") { $wheres_name .= " AND RecordActive = '".$activerows."'"; }
	
		
	
		if(empty($authority)) {
	
			$objForms = array(
					"Privileges" => $authority,
					"Condition"	 => $condition,
					"Optional"	 => $optional
			);
	
			log_message('error', 'method '.__METHOD__ .'can not load data progress. please check object criteria.');
			$this->writelogs($this->logs."model/dbprogress/", "dbprog_", $objForms);
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
	
		} else {
	
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
	
			$spcial_inquiry = '';
			switch($privileges) {
				case $this->role_ad:
				case $this->role_bm:
				case $this->role_hq:
				case $this->role_spv:
				case $this->role_ads:
						
					if($kpi_search == 'true') {
	
						
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
	
						return $this->db->query("
							SELECT *
							FROM (  
								SELECT * FROM (
									SELECT
										CONVERT(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate,
										[Profile].OwnerName, NCB.MainLoanName, CONVERT(nvarchar(10), Appointment.DueDate, 120) AS DueDate,
										[Profile].Downtown, Verify.ProductCode, [Profile].RequestLoan, Branch.RegionID, Branch.BranchCode,
										UPPER(AppStatus.ApplicationNo) AS ApplicationNo, Verify.ID_Card, [Profile].RMCode, [Profile].RMName,
										MasterArea.AreaName AS AreaCode, [Profile].IsActive, [Profile].IsEnabled,
									[Profile].SourceOfCustomer AS SourceChannel,								
									CASE [Profile].Interest
										WHEN '0' THEN 'Y'
										WHEN '1' THEN 'N'
										WHEN '2' THEN 'Y'
										ELSE ''
									END AS Interest,
									CASE [Profile].CSPotential
										WHEN '0' THEN 'H'
										WHEN '1' THEN 'M'
										WHEN '2' THEN 'L'
										ELSE NULL
									END AS CSPotential, LoanGroup,
									CASE
										WHEN [Profile].IsActive = 'Y' AND Verify.IsActive = 'Y' AND AppStatus.IsActive = 'Y' THEN 'InActive'
										WHEN [Profile].IsEnabled = 'N'  AND Verify.IsEnabled = 'N' AND AppStatus.IsEnabled = 'N' THEN 'InActive'
										ELSE 'Active'
									END AS RecordActive
									FROM [Profile]
									LEFT OUTER JOIN Appointment ON [Profile].DocID = Appointment.DocID
									LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
									LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
									LEFT OUTER JOIN LendingEmp ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
									LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
									LEFT OUTER JOIN MasterArea ON Branch.AreaID = MasterArea.AreaNo
									LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
								) Datas
								$wheres
							) A
							$wheres_name
							$wheres_kpi
							$spcial_inquiry")->num_rows();
	
					} else {
	
						if($empbranch == "000" || $empbranch == "901") {
								
							return $this->db->query("
								SELECT *
								FROM (
									SELECT * FROM (
										SELECT
											CONVERT(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate,
											[Profile].OwnerName, NCB.MainLoanName, CONVERT(nvarchar(10), Appointment.DueDate, 120) AS DueDate,
											[Profile].Downtown, Verify.ProductCode, [Profile].RequestLoan, Branch.RegionID, Branch.BranchCode,
											UPPER(AppStatus.ApplicationNo) AS ApplicationNo, Verify.ID_Card, [Profile].RMCode, [Profile].RMName,
											MasterArea.AreaName AS AreaCode, [Profile].IsActive, [Profile].IsEnabled,
										[Profile].SourceOfCustomer AS SourceChannel,								
										CASE [Profile].Interest
											WHEN '0' THEN 'Y'
											WHEN '1' THEN 'N'
											WHEN '2' THEN 'Y'
											ELSE ''
										END AS Interest,
										CASE [Profile].CSPotential
											WHEN '0' THEN 'H'
											WHEN '1' THEN 'M'
											WHEN '2' THEN 'L'
											ELSE NULL
										END AS CSPotential, LoanGroup,
										CASE
											WHEN [Profile].IsActive = 'Y' AND Verify.IsActive = 'Y' AND AppStatus.IsActive = 'Y' THEN 'InActive'
											WHEN [Profile].IsEnabled = 'N'  AND Verify.IsEnabled = 'N' AND AppStatus.IsEnabled = 'N' THEN 'InActive'
											ELSE 'Active'
										END AS RecordActive
										FROM [Profile]
										LEFT OUTER JOIN Appointment ON [Profile].DocID = Appointment.DocID
										LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
										LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
										LEFT OUTER JOIN LendingEmp ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
										LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
										LEFT OUTER JOIN MasterArea ON Branch.AreaID = MasterArea.AreaNo
										LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
									) Datas
									$wheres
								) A
								$wheres_name")->num_rows();
										
						} else {
							
							// Admin are not head office
							// Check has authority area manager
							$select_privilege = '';
							if(in_array($this->role_am, $authority)):
								$select_privilege = " AND BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' AND IsActive = 'A' GROUP BY BranchCode)";
							else:
								$select_privilege = " AND BranchCode = '".$empbranch."'";
							endif;
								
							return $this->db->query("
								SELECT *
								FROM (  
									SELECT * FROM (
										SELECT
											CONVERT(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate,
											[Profile].OwnerName, NCB.MainLoanName, CONVERT(nvarchar(10), Appointment.DueDate, 120) AS DueDate,
											[Profile].Downtown, Verify.ProductCode, [Profile].RequestLoan, Branch.RegionID, Branch.BranchCode,
											UPPER(AppStatus.ApplicationNo) AS ApplicationNo, Verify.ID_Card, [Profile].RMCode, [Profile].RMName,
											MasterArea.AreaName AS AreaCode, [Profile].IsActive, [Profile].IsEnabled,
										[Profile].SourceOfCustomer AS SourceChannel,							
										CASE [Profile].Interest
											WHEN '0' THEN 'Y'
											WHEN '1' THEN 'N'
											WHEN '2' THEN 'Y'
											ELSE ''
										END AS Interest,
										CASE [Profile].CSPotential
											WHEN '0' THEN 'H'
											WHEN '1' THEN 'M'
											WHEN '2' THEN 'L'
											ELSE NULL
										END AS CSPotential, LoanGroup,
										CASE
											WHEN [Profile].IsActive = 'Y' AND Verify.IsActive = 'Y' AND AppStatus.IsActive = 'Y' THEN 'InActive'
											WHEN [Profile].IsEnabled = 'N'  AND Verify.IsEnabled = 'N' AND AppStatus.IsEnabled = 'N' THEN 'InActive'
											ELSE 'Active'
										END AS RecordActive
										FROM [Profile]
										LEFT OUTER JOIN Appointment ON [Profile].DocID = Appointment.DocID
										LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
										LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
										LEFT OUTER JOIN LendingEmp ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
										LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
										LEFT OUTER JOIN MasterArea ON Branch.AreaID = MasterArea.AreaNo
										LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
									) Datas
									$wheres
									$select_privilege
								) A
								$wheres_name")->num_rows();
										
						}
	
					}
	
					break;
				case $this->role_rm:
						
					if($kpi_search == 'true'):
						$spcial_inquiry = " AND RMCode = '".$emp_kpi."'";
					else:
						$spcial_inquiry = " AND RMCode = '".$employees['data'][0]['EmployeeCode']."' AND BranchCode = '".$empbranch."'";
					endif;
						
					return $this->db->query("
						SELECT *
						FROM (
							SELECT * FROM ( 
								SELECT
									CONVERT(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate, [Profile].SourceOfCustomer,
									[Profile].OwnerName, NCB.MainLoanName, CONVERT(nvarchar(10), Appointment.DueDate, 120) AS DueDate,
									[Profile].Downtown, Verify.ProductCode, [Profile].RequestLoan, Branch.RegionID, Branch.BranchCode,
									UPPER(AppStatus.ApplicationNo) AS ApplicationNo, Verify.ID_Card, [Profile].RMCode, [Profile].RMName,
									MasterArea.AreaName AS AreaCode, [Profile].IsActive, [Profile].IsEnabled,
								[Profile].SourceOfCustomer AS SourceChannel,							
								CASE [Profile].Interest
									WHEN '0' THEN 'Y'
									WHEN '1' THEN 'N'
									WHEN '2' THEN 'Y'
									ELSE ''
								END AS Interest,
								CASE [Profile].CSPotential
									WHEN '0' THEN 'H'
									WHEN '1' THEN 'M'
									WHEN '2' THEN 'L'
									ELSE NULL
								END AS CSPotential, LoanGroup,
								CASE
									WHEN [Profile].IsActive = 'Y' AND Verify.IsActive = 'Y' AND AppStatus.IsActive = 'Y' THEN 'InActive'
									WHEN [Profile].IsEnabled = 'N'  AND Verify.IsEnabled = 'N' AND AppStatus.IsEnabled = 'N' THEN 'InActive'
									ELSE 'Active'
								END AS RecordActive
								FROM [Profile]
								LEFT OUTER JOIN Appointment ON [Profile].DocID = Appointment.DocID
								LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
								LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
								LEFT OUTER JOIN LendingEmp ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
								LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
								LEFT OUTER JOIN MasterArea ON Branch.AreaID = MasterArea.AreaNo
								LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
							) Datas
							$wheres
							$wheres_kpi
							$spcial_inquiry
						) A
						$wheres_name")->num_rows();
	
							break;
				case $this->role_am:
						
					if($kpi_search == 'true'):
						$spcial_inquiry = " AND AreaCode = '".$area_code."'";
					else:
						$spcial_inquiry = " AND AreaCode = '".$emp_area."'";
					endif;
						
					return $this->db->query("
						SELECT *
						FROM (
							SELECT * FROM (
								SELECT
									CONVERT(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate, 
									[Profile].OwnerName, NCB.MainLoanName, CONVERT(nvarchar(10), Appointment.DueDate, 103) AS DueDate,
									[Profile].Downtown, Verify.ProductCode, [Profile].RequestLoan, Branch.RegionID, Branch.BranchCode,
									UPPER(AppStatus.ApplicationNo) AS ApplicationNo, Verify.ID_Card, [Profile].RMCode, [Profile].RMName,
									MasterArea.AreaName AS AreaCode, [Profile].IsActive, [Profile].IsEnabled,
								[Profile].SourceOfCustomer AS SourceChannel,							
								CASE [Profile].Interest
									WHEN '0' THEN 'Y'
									WHEN '1' THEN 'N'
									WHEN '2' THEN 'Y'
									ELSE ''
								END AS Interest,
								CASE [Profile].CSPotential
									WHEN '0' THEN 'H'
									WHEN '1' THEN 'M'
									WHEN '2' THEN 'L'
									ELSE NULL
								END AS CSPotential, LoanGroup,
								CASE
									WHEN [Profile].IsActive = 'Y' AND Verify.IsActive = 'Y' AND AppStatus.IsActive = 'Y' THEN 'InActive'
									WHEN [Profile].IsEnabled = 'N'  AND Verify.IsEnabled = 'N' AND AppStatus.IsEnabled = 'N' THEN 'InActive'
									ELSE 'Active'
								END AS RecordActive
								FROM [Profile]
								LEFT OUTER JOIN Appointment ON [Profile].DocID = Appointment.DocID
								LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
								LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
								LEFT OUTER JOIN LendingEmp ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
								LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
								LEFT OUTER JOIN MasterArea ON Branch.AreaID = MasterArea.AreaNo
								LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
							) Datas
							$wheres
							$wheres_kpi
							$spcial_inquiry
						) A
						$wheres_name")->num_rows();
	
							break;
				case $this->role_rd:
						
					if($kpi_search == 'true'):
						$spcial_inquiry = " AND RegionID = '".$region_id."'";
					else:
						$spcial_inquiry = " AND RegionID = '".$emp_region."'";
					endif;
						
					return $this->db->query("
						SELECT *
						FROM (
							SELECT * FROM (
								SELECT
									CONVERT(nvarchar(10), [Profile].CreateDate, 120) AS CreateDate, 
									[Profile].OwnerName, NCB.MainLoanName, CONVERT(nvarchar(10), Appointment.DueDate, 120) AS DueDate,
									[Profile].Downtown, Verify.ProductCode, [Profile].RequestLoan, Branch.RegionID, Branch.BranchCode,
									UPPER(AppStatus.ApplicationNo) AS ApplicationNo, Verify.ID_Card, [Profile].RMCode, [Profile].RMName,
									MasterArea.AreaName AS AreaCode, [Profile].IsActive, [Profile].IsEnabled,
								[Profile].SourceOfCustomer AS SourceChannel,							
								CASE [Profile].Interest
									WHEN '0' THEN 'Y'
									WHEN '1' THEN 'N'
									WHEN '2' THEN 'Y'
									ELSE ''
								END AS Interest,
								CASE [Profile].CSPotential
									WHEN '0' THEN 'H'
									WHEN '1' THEN 'M'
									WHEN '2' THEN 'L'
									ELSE NULL
								END AS CSPotential, LoanGroup,
								CASE
									WHEN [Profile].IsActive = 'Y' AND Verify.IsActive = 'Y' AND AppStatus.IsActive = 'Y' THEN 'InActive'
									WHEN [Profile].IsEnabled = 'N'  AND Verify.IsEnabled = 'N' AND AppStatus.IsEnabled = 'N' THEN 'InActive'
									ELSE 'Active'
								END AS RecordActive
								FROM [Profile]
								LEFT OUTER JOIN Appointment ON [Profile].DocID = Appointment.DocID
								LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
								LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
								LEFT OUTER JOIN LendingEmp ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
								LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
								LEFT OUTER JOIN MasterArea ON Branch.AreaID = MasterArea.AreaNo
								LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
							) Datas
							$wheres
							$wheres_kpi
							$spcial_inquiry
						) A
						$wheres_name")->num_rows();
								
					break;
	
			}
				
		}
	
	}
	
	public function dataTableProgress($authority, $condition = array()) {
		$this->load->model('dbmodel');
		$this->load->model('dbcustom');
		$this->load->library('effective');
		
		$wheres 		= "WHERE NOT [Profile].CreateDate = '' AND NOT [Profile].CreateDate = '1900-01-01'";
		$wheres_name	= "WHERE NOT AppProcess = ''";
		
		
		$startdate           		= $this->input->post('createdate_start');
		$enddate            	    = $this->input->post('createdate_end');

		$start_loan					= (int)$this->input->post('loan_start');
		$end_loan					= (int)$this->input->post('loan_end');
		$customers					= $this->effective->set_chartypes($this->char_mode, $this->input->post('custname'));
		$rmname						= $this->input->post('rmname');
		$business_location			= $this->effective->set_chartypes($this->char_mode, $this->input->post('location'));
		$region						= $this->input->post('region');
		$branchs					= $this->input->post('branchs');
		$source_cust				= $this->input->post('source_cust');
		$id_card           			= $this->input->post('id_card');
		$application_no          	= strtoupper($this->input->post('appno'));
		$activerows					= $this->input->post('activerecords');
		
		$createdate_start  = !empty($startdate) ? $this->effective->StandartDateSorter($startdate):"";
		$createdate_end	   = !empty($enddate) ? $this->effective->StandartDateSorter($enddate):"";
		
		/* ############ KPI ############ */		
		$kpi_search		= $this->input->post('search_kpi');
		$kpi_no			= $this->input->post('kpino');
		$emp_kpi		= $this->input->post('emp_auth');
		$mode_kpi		= $this->input->post('mode_kpi');
	
		$wheres_kpi		= "";
		$kpi_privileges	= "";		
		if($kpi_search == 'true') {
			
			$special_role 	= $this->dbcustom->setDataAuthority($emp_kpi);
				
			$get_info 		= $this->dbcustom->getEmployeeDataInfo($emp_kpi);
			$brn_code 		= $get_info['data'][0]['BranchCode'];
			$area_code  	= $get_info['data'][0]['AreaCode'];
			$region_id  	= $get_info['data'][0]['RegionID'];
			
			$kpi_privileges  = $this->dbcustom->getAuthPermission($special_role);
			
			$first_date		= trim(date('Y-m-').'01');
			$second_date	= trim(date('Y-m-').date('t', strtotime(date("Y-m-d"))));
			
			if($kpi_no == '2') {
				//$wheres_kpi .= " AND SourceChannel = 'Field visit'";
				$wheres_kpi .= " AND CreateDate BETWEEN '".$first_date."' AND '".$second_date."'";				
			}
			
		}				
		/* ############ KPI ############ */
		
		$pieces_sourcefield = explode(',', $source_cust);
		// Cut off - List condition
		// Interest Or Not
		$interest_condition = array();
		if(in_array('Y', $pieces_sourcefield)):
			array_push($interest_condition, 'Y');
			$key = array_search('Y', $pieces_sourcefield);
			if($key !== false) unset($pieces_sourcefield[$key]);
		endif;
		
		if(in_array('N', $pieces_sourcefield)):
			array_push($interest_condition, 'N');
			$key = array_search('N', $pieces_sourcefield);
			if($key !== false) unset($pieces_sourcefield[$key]);
		endif;
		
		// Potential Customer
		$level_customer = array();
		if(in_array('H', $pieces_sourcefield)):
			array_push($level_customer, 'H');
			$key = array_search('H', $pieces_sourcefield);
			if($key !== false) unset($pieces_sourcefield[$key]);
		endif;
		
		if(in_array('M', $pieces_sourcefield)):
			array_push($level_customer, 'M');
			$key = array_search('M', $pieces_sourcefield);
			if($key !== false) unset($pieces_sourcefield[$key]);
		endif;
		
		if(in_array('L', $pieces_sourcefield)):
			array_push($level_customer, 'L');
			$key = array_search('L', $pieces_sourcefield);
			if($key !== false) unset($pieces_sourcefield[$key]);
		endif;
		
		// Loan Type
		$LoanGroup_Types = array();
		if(in_array('NN', $pieces_sourcefield)):
			array_push($LoanGroup_Types, 'NN');
			$key = array_search('NN', $pieces_sourcefield);
			if($key !== false) unset($pieces_sourcefield[$key]);
		endif;
		
		if(in_array('MF', $pieces_sourcefield)):
			array_push($LoanGroup_Types, 'MF');
			$key = array_search('MF', $pieces_sourcefield);
			if($key !== false) unset($pieces_sourcefield[$key]);
		endif;
		
		if(in_array('SB', $pieces_sourcefield)):
			array_push($LoanGroup_Types, 'SB');
			$key = array_search('SB', $pieces_sourcefield);
			if($key !== false) unset($pieces_sourcefield[$key]);
		endif;
		
		if(in_array('MF SME', $pieces_sourcefield)):
			array_push($LoanGroup_Types, 'SME');
			$key = array_search('MF SME', $pieces_sourcefield);
			if($key !== false) unset($pieces_sourcefield[$key]);
		endif;
		
		// Staft Array
		if(!empty($interest_condition[0])):
			$where_interest = "'".implode("','", $interest_condition)."'";
		else:
			$where_interest = "";
		endif;
		
		if(!empty($level_customer[0])):
			$where_potential = "'".implode("','", $level_customer)."'";
		else:
			$where_potential = "";
		endif;
		
		
		if(!empty($LoanGroup_Types[0])):
			$where_loangroup = "'".implode("','", $LoanGroup_Types)."'";
		else:
			$where_loangroup = "";
		endif;
		
		$pieces = explode(',', $branchs);		
		if(!empty($pieces[0])) {
			$where_brachs 	= "'".implode("','", $pieces)."'";
		} else {
			$where_brachs   = "";
		}
	
		$pieces_blc = explode(',', $business_location);		
		if(!empty($pieces_blc[0])):
					
			$where_blc = '';
			for($i = 0; $i < count($pieces_blc); $i++) {
							
				if($i == '0') {
					$where_blc .= " AND [Profile].Downtown LIKE '%".$pieces_blc[$i]."%' ";
					
				} else {
					$where_blc .= " OR [Profile].Downtown LIKE '%".$pieces_blc[$i]."%' ";
					
				}

			}	
					
		else :
			$where_blc = '';
		endif;
	
		$rmlist_pieces = explode(',', $rmname);
		if(!empty($rmlist_pieces[0])):
			$wheres_rmlist   = $this->effective->set_chartypes($this->char_mode, "'".implode("','", $rmlist_pieces)."'");
		else:
			$wheres_rmlist   = "";
		endif;
				
		if(!empty($pieces_sourcefield[0])) {
			$where_source 	= "'".implode("','", $pieces_sourcefield)."'";
		} else {
			$where_source   = "";
		}
		
		if(!empty($startdate) && !empty($enddate)) {
			$wheres .= " AND CONVERT(nvarchar(10), [Profile].CreateDate, 120) BETWEEN '".$createdate_start."' AND '".$createdate_end."'";
			
		} else {
			
			if(!empty($startdate)) {
				$wheres .= " AND CONVERT(nvarchar(10), [Profile].CreateDate, 120) = '".$createdate_start."'";
			}
			
			if(!empty($enddate)) {
				$wheres .= " AND CONVERT(nvarchar(10), [Profile].CreateDate, 120) = '".$createdate_end."'";
			}
		
		}

		if(!empty($start_loan) && !empty($end_loan)) {
			$wheres .= " AND [Profile].RequestLoan BETWEEN '".$start_loan."' AND '".$end_loan."'";
			
		} else {
			
			if(!empty($start_loan)) {
				$wheres .= " AND [Profile].RequestLoan = '".$start_loan."'";
			}
			
			if(!empty($end_loan)) {
				$wheres .= " AND [Profile].RequestLoan = '".$end_loan."'";
			}
			
		}
		
		if(!empty($customers)) {
			$wheres_name .= " AND (MainLoanName LIKE '%".$customers."%' OR OwnerName LIKE '%".$customers."%')";
		}
		
		if(!empty($region)) {
			$wheres .= " AND Branch.RegionID = '".$region."'";
		}

		if(!empty($rmlist_pieces[0])) { $wheres .= " AND [Profile].RMCode in ($wheres_rmlist) "; }
		if(!empty($pieces[0])) { $wheres .= " AND Branch.BranchCode in ($where_brachs) "; }
		if(!empty($pieces_sourcefield[0])) { $wheres .= " AND [Profile].SourceOfCustomer in ($where_source) "; }
		if(!empty($pieces_blc[0])) { $wheres .= $where_blc; }	
		
		if(!empty($interest_condition[0])) { $wheres_name .= " AND Interest in ($where_interest) "; }
		if(!empty($level_customer[0])) { $wheres_name .= " AND CSPotential in ($where_potential) "; }
		if(!empty($LoanGroup_Types[0])) { $wheres_name .= " AND LoanGroup in ($where_loangroup) "; }
			
		if(!empty($id_card)) {
			$wheres .= " AND Verify.ID_Card = '".$id_card."'";
		}
		
		if(!empty($application_no)) {
			$wheres .= " AND ApplicationNo = '".$application_no."'";
		}

		if($activerows == "Active") { $wheres_name .= " AND RecordActive = '".$activerows."'"; }
		if($activerows == "InActive") { $wheres_name .= " AND RecordActive = '".$activerows."'"; }
		
		$iStart = $this->input->post('start');
		$iLength = $this->input->post('length') ? $iLength = $this->input->post('length') : 10;
		
		$start	= ($iStart)? $iStart : 0;
		$offset = $iLength + $start;

		// Query Process
		if($kpi_search == 'true') {		
			switch ($kpi_no) {
				case '2':
					if($this->get_ordering() == 'CreateDate desc') $Ordering = 'SourceOrder ASC';
					else $Ordering = $this->get_ordering();						
				break;
				default:
					$Ordering = $this->get_ordering();
				break;
			}				
		} else {
			$Ordering = $this->get_ordering();
		}
		
		if(empty($authority)) {
		
			$objForms = array(
					"Privileges" => $authority,
					"Condition"	 => $condition,
					"Optional"	 => $optional
			);
		
			log_message('error', 'method '.__METHOD__ .'can not load data progress. please check object criteria.');
			$this->writelogs($this->logs."model/dbprogress/", "dbprog_", $objForms);
			throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
		
		} else {
			
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
				
			$spcial_inquiry = '';
			switch($privileges) {
				case $this->role_ad:
				case $this->role_bm:
				case $this->role_hq:
				case $this->role_spv:
				case $this->role_ads:
					
					if($kpi_search == 'true') {
						
						
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
							SELECT *
							FROM (SELECT *, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
								FROM (
								SELECT
								[Profile].DocID,
									CASE [Profile].CreateDate
									WHEN '1900-01-01' THEN NULL
									ELSE CONVERT(nvarchar(10), [Profile].CreateDate, 120)
								END AS CreateDate,
								MasterSourceField.SourceDigit AS SourceOfCustomer, 
								CASE [Profile].SourceOfCustomer
									WHEN 'Field visit' THEN '1'
									WHEN 'Call in' THEN '2'
									WHEN 'Walk in' THEN '3'
									WHEN 'Direct mail' THEN '4'
									WHEN 'Telelist' THEN '5'
									WHEN 'Walk in' THEN '6'
									WHEN 'Refer: Thai Life' THEN '7'
									WHEN 'Refer: Full Branch' THEN '8'
									WHEN 'อื่นๆ' THEN '9'
									ELSE '10'
								END AS SourceOrder,
								[Profile].SourceOfCustomer AS SourceChannel,
								CASE [Profile].Interest
									WHEN '0' THEN 'Y'
									WHEN '1' THEN 'N'
									WHEN '2' THEN 'Y'
									ELSE ''
								END AS Interest,
								CASE [Profile].CSPotential
									WHEN '0' THEN 'H'
									WHEN '1' THEN 'M'
									WHEN '2' THEN 'L'
									ELSE NULL
								END AS CSPotential, 
								CASE LoanGroup
									WHEN 'MF SME' THEN 'SME'
									ELSE LoanGroup
								END AS LoanGroup,
								[Profile].OwnerName, NCB.MainLoanName,
								CASE Appointment.DueDate
									WHEN '1900-01-01' THEN NULL
									ELSE CONVERT(nvarchar(10), Appointment.DueDate, 120)
								END AS DueDate, [Profile].Business,
								CONVERT(varchar(255), ISNULL(BusinessLocation, [Profile].Downtown)) AS Downtown,
								UPPER(AppStatus.ApplicationNo) AS ApplicationNo, Verify.ID_Card,
								Verify.ProductCode, Product.ProductName, Product.ProductTypes, Branch.BranchCode,
								[Profile].RequestLoan, Branch.BranchDigit, [Profile].RMCode, [Profile].RMName,
								MasterArea.AreaName AS AreaCode, Branch.RegionID,
								DAY([Profile].CreateDate) AS DD,
								MONTH([Profile].CreateDate) AS MM,
								YEAR([Profile].CreateDate) AS YYYY,
								[Profile].IsActive AS AppProcess,
								Verify.IsActive AS VerifyProcess,
								AppStatus.IsActive AS AStateProcess,
								[Profile].IsEnabled,
								CASE
									WHEN [Profile].IsActive = 'Y' AND Verify.IsActive = 'Y' AND AppStatus.IsActive = 'Y' THEN 'InActive'
									WHEN [Profile].IsEnabled = 'N'  AND Verify.IsEnabled = 'N' AND AppStatus.IsEnabled = 'N' THEN 'InActive'
									ELSE 'Active'
								END AS RecordActive
								FROM [Profile]
								LEFT OUTER JOIN Appointment ON [Profile].DocID = Appointment.DocID
								LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
								LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
								LEFT OUTER JOIN LendingEmp ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
								LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
								LEFT OUTER JOIN MasterArea ON Branch.AreaID = MasterArea.AreaNo
								LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
								LEFT OUTER JOIN Product ON Verify.ProductCode = Product.ProductCode
								LEFT OUTER JOIN MasterSourceField ON [Profile].SourceOfCustomer = MasterSourceField.SourceField
								$wheres
							) A
							$wheres_name
							$wheres_kpi
							$spcial_inquiry
						) Inquiry
						WHERE Inquiry.KeyPoint > '".$start."' AND Inquiry.KeyPoint <= '".$offset."'");
						
						return $result;
					
					} else {
						
						if($empbranch == "000" || $empbranch == "901") {
						
							$result = $this->dbmodel->CIQuery("
								SELECT *
								FROM (SELECT *, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
									  FROM (
										SELECT
										[Profile].DocID,
										CASE [Profile].CreateDate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), [Profile].CreateDate, 120) 
										END AS CreateDate,
										MasterSourceField.SourceDigit AS SourceOfCustomer,
										CASE [Profile].SourceOfCustomer
											WHEN 'Field visit' THEN '1'
											WHEN 'Call in' THEN '2'
											WHEN 'Walk in' THEN '3'
											WHEN 'Direct mail' THEN '4'
											WHEN 'Telelist' THEN '5'
											WHEN 'Walk in' THEN '6'
											WHEN 'Refer: Thai Life' THEN '7'
											WHEN 'Refer: Full Branch' THEN '8'
											WHEN 'อื่นๆ' THEN '9'
											ELSE '10'
										END AS SourceOrder,
										[Profile].SourceOfCustomer AS SourceChannel,
										CASE [Profile].Interest
										WHEN '0' THEN 'Y'
										WHEN '1' THEN 'N'
										WHEN '2' THEN 'Y'
										ELSE ''
										END AS Interest,
										CASE [Profile].CSPotential
										WHEN '0' THEN 'H'
										WHEN '1' THEN 'M'
										WHEN '2' THEN 'L'
										ELSE NULL
										END AS CSPotential,
										CASE LoanGroup
											WHEN 'MF SME' THEN 'SME'
											ELSE LoanGroup
										END AS LoanGroup,
										[Profile].OwnerName, NCB.MainLoanName, 
										CASE Appointment.DueDate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Appointment.DueDate, 120) 
										END AS DueDate, [Profile].Business,
										CONVERT(varchar(255), ISNULL(BusinessLocation, [Profile].Downtown)) AS Downtown, 
										UPPER(AppStatus.ApplicationNo) AS ApplicationNo, Verify.ID_Card,
										Verify.ProductCode, Product.ProductName, Product.ProductTypes, 
										[Profile].RequestLoan, Branch.BranchDigit, [Profile].RMCode, [Profile].RMName,
										MasterArea.AreaName AS AreaCode, Branch.RegionID,
										DAY([Profile].CreateDate) AS DD,
										MONTH([Profile].CreateDate) AS MM,
										YEAR([Profile].CreateDate) AS YYYY,
										[Profile].IsActive AS AppProcess,
										Verify.IsActive AS VerifyProcess,
										AppStatus.IsActive AS AStateProcess,
										[Profile].IsEnabled,
										CASE
											WHEN [Profile].IsActive = 'Y' AND Verify.IsActive = 'Y' AND AppStatus.IsActive = 'Y' THEN 'InActive'
											WHEN [Profile].IsEnabled = 'N'  AND Verify.IsEnabled = 'N' AND AppStatus.IsEnabled = 'N' THEN 'InActive'
											ELSE 'Active'
										END AS RecordActive
										FROM [Profile]
										LEFT OUTER JOIN Appointment ON [Profile].DocID = Appointment.DocID
										LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
										LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
										LEFT OUTER JOIN LendingEmp ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
										LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
										LEFT OUTER JOIN MasterArea ON Branch.AreaID = MasterArea.AreaNo
										LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN Product ON Verify.ProductCode = Product.ProductCode		
										LEFT OUTER JOIN MasterSourceField ON [Profile].SourceOfCustomer = MasterSourceField.SourceField
										$wheres				
									) A
									$wheres_name
								) Inquiry
								WHERE Inquiry.KeyPoint > '".$start."' AND Inquiry.KeyPoint <= '".$offset."'");
								
						} else {
							
							// Admin are not head office
							// Check has authority area manager
							$select_privilege = '';
							if(in_array($this->role_am, $authority)):
								$select_privilege = " AND [Profile].BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' AND IsActive = 'A' GROUP BY BranchCode)";
							else:
								$select_privilege = " AND [Profile].BranchCode = '".$empbranch."'";
							endif;
					
							$result = $this->dbmodel->CIQuery("
								SELECT *
								FROM (SELECT *, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
									  FROM (
										SELECT
										[Profile].DocID,
										CASE [Profile].CreateDate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), [Profile].CreateDate, 120) 
										END AS CreateDate,
										MasterSourceField.SourceDigit AS SourceOfCustomer, 
										CASE [Profile].SourceOfCustomer
											WHEN 'Field visit' THEN '1'
											WHEN 'Call in' THEN '2'
											WHEN 'Walk in' THEN '3'
											WHEN 'Direct mail' THEN '4'
											WHEN 'Telelist' THEN '5'
											WHEN 'Walk in' THEN '6'
											WHEN 'Refer: Thai Life' THEN '7'
											WHEN 'Refer: Full Branch' THEN '8'
											WHEN 'อื่นๆ' THEN '9'
											ELSE '10'
										END AS SourceOrder,
										[Profile].SourceOfCustomer AS SourceChannel,
										CASE [Profile].Interest
										WHEN '0' THEN 'Y'
										WHEN '1' THEN 'N'
										WHEN '2' THEN 'Y'
										ELSE ''
										END AS Interest,
										CASE [Profile].CSPotential
										WHEN '0' THEN 'H'
										WHEN '1' THEN 'M'
										WHEN '2' THEN 'L'
										ELSE NULL
										END AS CSPotential,
										CASE LoanGroup
											WHEN 'MF SME' THEN 'SME'
											ELSE LoanGroup
										END AS LoanGroup,
										[Profile].OwnerName, NCB.MainLoanName, 
										CASE Appointment.DueDate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Appointment.DueDate, 120) 
										END AS DueDate, [Profile].Business,
										CONVERT(varchar(255), ISNULL(BusinessLocation, [Profile].Downtown)) AS Downtown,
										UPPER(AppStatus.ApplicationNo) AS ApplicationNo, Verify.ID_Card,
										Verify.ProductCode, Product.ProductName, Product.ProductTypes, 
										[Profile].RequestLoan, Branch.BranchDigit, [Profile].RMCode, [Profile].RMName,
										MasterArea.AreaName AS AreaCode, Branch.RegionID,
										DAY([Profile].CreateDate) AS DD,
										MONTH([Profile].CreateDate) AS MM,
										YEAR([Profile].CreateDate) AS YYYY,
										[Profile].IsActive AS AppProcess,
										Verify.IsActive AS VerifyProcess,
										AppStatus.IsActive AS AStateProcess,
										[Profile].IsEnabled,
										CASE
											WHEN [Profile].IsActive = 'Y' AND Verify.IsActive = 'Y' AND AppStatus.IsActive = 'Y' THEN 'InActive'
											WHEN [Profile].IsEnabled = 'N'  AND Verify.IsEnabled = 'N' AND AppStatus.IsEnabled = 'N' THEN 'InActive'
											ELSE 'Active'
										END AS RecordActive
										FROM [Profile]
										LEFT OUTER JOIN Appointment ON [Profile].DocID = Appointment.DocID
										LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
										LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
										LEFT OUTER JOIN LendingEmp ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
										LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
										LEFT OUTER JOIN MasterArea ON Branch.AreaID = MasterArea.AreaNo
										LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN Product ON Verify.ProductCode = Product.ProductCode	
										LEFT OUTER JOIN MasterSourceField ON [Profile].SourceOfCustomer = MasterSourceField.SourceField											
										$wheres
										$select_privilege
									) A
									$wheres_name
								) Inquiry
								WHERE Inquiry.KeyPoint > '".$start."' AND Inquiry.KeyPoint <= '".$offset."'");
						
						}
						
						return $result;
					
					}

					break;
				case $this->role_rm:
					
					if($kpi_search == 'true'):
						$spcial_inquiry = " AND RMCode = '".$emp_kpi."'";
					else:
						$spcial_inquiry = " AND RMCode = '".$employees['data'][0]['EmployeeCode']."' AND BranchCode = '".$empbranch."'";
					endif;
					
					$result = $this->dbmodel->CIQuery("
						SELECT *
						FROM (SELECT *, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
							  FROM (
								SELECT
								[Profile].DocID,
								CASE [Profile].CreateDate
									WHEN '1900-01-01' THEN NULL
									ELSE CONVERT(nvarchar(10), [Profile].CreateDate, 120) 
								END AS CreateDate,
								MasterSourceField.SourceDigit AS SourceOfCustomer, 
								CASE [Profile].SourceOfCustomer
									WHEN 'Field visit' THEN '1'
									WHEN 'Call in' THEN '2'
									WHEN 'Walk in' THEN '3'
									WHEN 'Direct mail' THEN '4'
									WHEN 'Telelist' THEN '5'
									WHEN 'Walk in' THEN '6'
									WHEN 'Refer: Thai Life' THEN '7'
									WHEN 'Refer: Full Branch' THEN '8'
									WHEN 'อื่นๆ' THEN '9'
									ELSE '10'
								END AS SourceOrder,
								[Profile].SourceOfCustomer AS SourceChannel,
								CASE [Profile].Interest
								WHEN '0' THEN 'Y'
								WHEN '1' THEN 'N'
								WHEN '2' THEN 'Y'
								ELSE ''
								END AS Interest,
								CASE [Profile].CSPotential
								WHEN '0' THEN 'H'
								WHEN '1' THEN 'M'
								WHEN '2' THEN 'L'
								ELSE NULL
								END AS CSPotential, 
								CASE LoanGroup
									WHEN 'MF SME' THEN 'SME'
									ELSE LoanGroup
								END AS LoanGroup,
								[Profile].OwnerName, NCB.MainLoanName, 
								CASE Appointment.DueDate
									WHEN '1900-01-01' THEN NULL
									ELSE CONVERT(nvarchar(10), Appointment.DueDate, 120) 
								END AS DueDate, [Profile].Business,
								CONVERT(varchar(255), ISNULL(BusinessLocation, [Profile].Downtown)) AS Downtown,
								UPPER(AppStatus.ApplicationNo) AS ApplicationNo, Verify.ID_Card,
								Verify.ProductCode, Product.ProductName, Product.ProductTypes, 
								[Profile].RequestLoan, [Profile].BranchCode, Branch.BranchDigit, [Profile].RMCode, [Profile].RMName,
								MasterArea.AreaName AS AreaCode, Branch.RegionID,
								DAY([Profile].CreateDate) AS DD,
								MONTH([Profile].CreateDate) AS MM,
								YEAR([Profile].CreateDate) AS YYYY,
								[Profile].IsActive AS AppProcess,
								Verify.IsActive AS VerifyProcess,
								AppStatus.IsActive AS AStateProcess,
								[Profile].IsEnabled, 			
								CASE
									WHEN [Profile].IsActive = 'Y' AND Verify.IsActive = 'Y' AND AppStatus.IsActive = 'Y' THEN 'InActive'
									WHEN [Profile].IsEnabled = 'N'  AND Verify.IsEnabled = 'N' AND AppStatus.IsEnabled = 'N' THEN 'InActive'
									ELSE 'Active'
								END AS RecordActive
								FROM [Profile]
								LEFT OUTER JOIN Appointment ON [Profile].DocID = Appointment.DocID
								LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
								LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
								LEFT OUTER JOIN LendingEmp ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
								LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
								LEFT OUTER JOIN MasterArea ON Branch.AreaID = MasterArea.AreaNo
								LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
								LEFT OUTER JOIN Product ON Verify.ProductCode = Product.ProductCode	
								LEFT OUTER JOIN MasterSourceField ON [Profile].SourceOfCustomer = MasterSourceField.SourceField
								$wheres								
							) A
							$wheres_name
							$wheres_kpi
							$spcial_inquiry
						) Inquiry
						WHERE Inquiry.KeyPoint > '".$start."' AND Inquiry.KeyPoint <= '".$offset."'");
					
					return $result;
					
					break;
				case $this->role_am:
					/*
					if($kpi_search == 'true'):
						$spcial_inquiry = " AND AreaCode = '".$area_code."'";
					else:
						$spcial_inquiry = " AND AreaCode = '".$emp_area."'";
					endif;
					*/
					
					// MODIFY NEW ON 13NOV2018
					if($kpi_search == 'true') {
						$spcial_inquiry = " AND AreaCode = '".$area_code."'";
					} else {
						if(in_array($this->role_am, $authority)):
						$spcial_inquiry= " AND [BranchCode] IN (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' AND IsActive = 'A' GROUP BY BranchCode)";
						else:
						$spcial_inquiry= " AND AreaCode = '".$emp_area."'";
						endif;
					}
							
					$result = $this->dbmodel->CIQuery("
						SELECT *
						FROM (SELECT *, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
							  FROM (
								SELECT
								[Profile].DocID,
								CASE [Profile].CreateDate
									WHEN '1900-01-01' THEN NULL
									ELSE CONVERT(nvarchar(10), [Profile].CreateDate, 120) 
								END AS CreateDate,
								MasterSourceField.SourceDigit AS SourceOfCustomer, 
								CASE [Profile].SourceOfCustomer
									WHEN 'Field visit' THEN '1'
									WHEN 'Call in' THEN '2'
									WHEN 'Walk in' THEN '3'
									WHEN 'Direct mail' THEN '4'
									WHEN 'Telelist' THEN '5'
									WHEN 'Walk in' THEN '6'
									WHEN 'Refer: Thai Life' THEN '7'
									WHEN 'Refer: Full Branch' THEN '8'
									WHEN 'อื่นๆ' THEN '9'
									ELSE '10'
								END AS SourceOrder,
								[Profile].SourceOfCustomer AS SourceChannel,
								CASE [Profile].Interest
								WHEN '0' THEN 'Y'
								WHEN '1' THEN 'N'
								WHEN '2' THEN 'Y'
								ELSE ''
								END AS Interest,
								CASE [Profile].CSPotential
								WHEN '0' THEN 'H'
								WHEN '1' THEN 'M'
								WHEN '2' THEN 'L'
								ELSE NULL
								END AS CSPotential,
								CASE LoanGroup
									WHEN 'MF SME' THEN 'SME'
									ELSE LoanGroup
								END AS LoanGroup,
								[Profile].OwnerName, NCB.MainLoanName,
								CASE Appointment.DueDate
									WHEN '1900-01-01' THEN NULL
									ELSE CONVERT(nvarchar(10), Appointment.DueDate, 120) 
								END AS DueDate, [Profile].Business,
								CONVERT(varchar(255), ISNULL(BusinessLocation, [Profile].Downtown)) AS Downtown,
								UPPER(AppStatus.ApplicationNo) AS ApplicationNo, Verify.ID_Card,
								Verify.ProductCode, Product.ProductName, Product.ProductTypes, 
								[Profile].RequestLoan, Branch.BranchDigit, [Profile].RMCode, [Profile].RMName,
								[Profile].[BranchCode], MasterArea.AreaName AS AreaCode, Branch.RegionID,
								DAY([Profile].CreateDate) AS DD,
								MONTH([Profile].CreateDate) AS MM,
								YEAR([Profile].CreateDate) AS YYYY,
								[Profile].IsActive AS AppProcess,
								Verify.IsActive AS VerifyProcess,
								AppStatus.IsActive AS AStateProcess,
								[Profile].IsEnabled, 
								CASE
									WHEN [Profile].IsActive = 'Y' AND Verify.IsActive = 'Y' AND AppStatus.IsActive = 'Y' THEN 'InActive'
									WHEN [Profile].IsEnabled = 'N'  AND Verify.IsEnabled = 'N' AND AppStatus.IsEnabled = 'N' THEN 'InActive'
									ELSE 'Active'
								END AS RecordActive
								FROM [Profile]
								LEFT OUTER JOIN Appointment ON [Profile].DocID = Appointment.DocID
								LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
								LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
								LEFT OUTER JOIN LendingEmp ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
								LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
								LEFT OUTER JOIN MasterArea ON Branch.AreaID = MasterArea.AreaNo
								LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
								LEFT OUTER JOIN Product ON Verify.ProductCode = Product.ProductCode	
								LEFT OUTER JOIN MasterSourceField ON [Profile].SourceOfCustomer = MasterSourceField.SourceField
								$wheres
							) A
							$wheres_name
							$wheres_kpi
							$spcial_inquiry
						) Inquiry
						WHERE Inquiry.KeyPoint > '".$start."' AND Inquiry.KeyPoint <= '".$offset."'");
					
					return $result;
					
					break;
				case $this->role_rd:
					
					if($kpi_search == 'true'):
						$spcial_inquiry = " AND Branch.RegionID = '".$region_id."'";
					else:
						$spcial_inquiry = " AND Branch.RegionID = '".$emp_region."'";
					endif;
				
					$result = $this->dbmodel->CIQuery("
					SELECT *
					FROM (SELECT *, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
						  FROM (
							SELECT
							[Profile].DocID,
							CASE [Profile].CreateDate
								WHEN '1900-01-01' THEN NULL
								ELSE CONVERT(nvarchar(10), [Profile].CreateDate, 120) 
							END AS CreateDate,
							MasterSourceField.SourceDigit AS SourceOfCustomer, 
							CASE [Profile].SourceOfCustomer
								WHEN 'Field visit' THEN '1'
								WHEN 'Call in' THEN '2'
								WHEN 'Walk in' THEN '3'
								WHEN 'Direct mail' THEN '4'
								WHEN 'Telelist' THEN '5'
								WHEN 'Walk in' THEN '6'
								WHEN 'Refer: Thai Life' THEN '7'
								WHEN 'Refer: Full Branch' THEN '8'
								WHEN 'อื่นๆ' THEN '9'
								ELSE '10'
							END AS SourceOrder,
							[Profile].SourceOfCustomer AS SourceChannel,
							CASE [Profile].Interest
								WHEN '0' THEN 'Y'
								WHEN '1' THEN 'N'
								WHEN '2' THEN 'Y'
								ELSE ''
							END AS Interest,
							CASE [Profile].CSPotential
								WHEN '0' THEN 'H'
								WHEN '1' THEN 'M'
								WHEN '2' THEN 'L'
								ELSE NULL
							END AS CSPotential,
							CASE LoanGroup
								WHEN 'MF SME' THEN 'SME'
								ELSE LoanGroup
							END AS LoanGroup,
							[Profile].OwnerName, NCB.MainLoanName,
							CASE Appointment.DueDate
								WHEN '1900-01-01' THEN NULL
								ELSE CONVERT(nvarchar(10), Appointment.DueDate, 120) 
							END AS DueDate, [Profile].Business,
							CONVERT(varchar(255), ISNULL(BusinessLocation, [Profile].Downtown)) AS Downtown,
							UPPER(AppStatus.ApplicationNo) AS ApplicationNo, Verify.ID_Card,
							Verify.ProductCode, Product.ProductName, Product.ProductTypes, 
							[Profile].RequestLoan, Branch.BranchDigit, [Profile].RMCode, [Profile].RMName,
							MasterArea.AreaName AS AreaCode, Branch.RegionID,
							DAY([Profile].CreateDate) AS DD,
							MONTH([Profile].CreateDate) AS MM,
							YEAR([Profile].CreateDate) AS YYYY,
							[Profile].IsActive AS AppProcess,
							Verify.IsActive AS VerifyProcess,
							AppStatus.IsActive AS AStateProcess,
							[Profile].IsEnabled, 								
							CASE
								WHEN [Profile].IsActive = 'Y' AND Verify.IsActive = 'Y' AND AppStatus.IsActive = 'Y' THEN 'InActive'
								WHEN [Profile].IsEnabled = 'N'  AND Verify.IsEnabled = 'N' AND AppStatus.IsEnabled = 'N' THEN 'InActive'
								ELSE 'Active'
							END AS RecordActive
							FROM [Profile]
							LEFT OUTER JOIN Appointment ON [Profile].DocID = Appointment.DocID
							LEFT OUTER JOIN Verification AS Verify ON [Profile].DocID = Verify.DocID
							LEFT OUTER JOIN ApplicationStatus AS AppStatus ON [Profile].DocID = AppStatus.DocID
							LEFT OUTER JOIN LendingEmp ON [Profile].RMCode = LendingEmp.EmployeeCode AND LendingEmp.IsActive = 'A'
							LEFT OUTER JOIN LendingBranchs AS Branch ON [Profile].BranchCode = Branch.BranchCode
							LEFT OUTER JOIN MasterArea ON Branch.AreaID = MasterArea.AreaNo
							LEFT OUTER JOIN NCB ON Verify.VerifyID = NCB.VerifyID
							LEFT OUTER JOIN Product ON Verify.ProductCode = Product.ProductCode	
							LEFT OUTER JOIN MasterSourceField ON [Profile].SourceOfCustomer = MasterSourceField.SourceField
							$wheres		
							$spcial_inquiry
						) A
						$wheres_name
						$wheres_kpi
						
					) Inquiry
					WHERE Inquiry.KeyPoint > '".$start."' AND Inquiry.KeyPoint <= '".$offset."'");
		
					return $result;
					
					break;
					
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