<?php 

class Dbdocmanage extends CI_Model {
	
	protected $role_ad;
	protected $role_rm;
	protected $role_bm;
	protected $role_am;
	protected $role_rd;
	protected $role_hq;
	protected $role_spv;
	protected $role_ads;
	
	private $condition_sql;
	
	public function __construct() {
		parent::__construct();
		$this->load->database('dbstore');
		
		$this->role_ad 						= $this->config->item('ROLE_ADMIN');
		$this->role_rm 						= $this->config->item('ROLE_RM');
		$this->role_bm 						= $this->config->item('ROLE_BM');
		$this->role_am 						= $this->config->item('ROLE_AM');
		$this->role_rd 						= $this->config->item('ROLE_RD');
		$this->role_hq 						= $this->config->item('ROLE_HQ');
		$this->role_spv 					= $this->config->item('ROLE_SPV');
		$this->role_ads 					= $this->config->item('ROLE_ADMINSYS');
		
	}
	
	public function getLayerPaginationAuthority($position, $authority, $condition = array()) {
		$this->load->model('dbmodel');
		$this->load->model('dbcustom');
		$this->load->library('effective');
		
		
		$rmname			= $this->input->post('rmname');
		$ownerName		= $this->input->post('ownerName');
		$logistic		= $this->input->post('logistic_code');
		$regionid		= $this->input->post('regionid');
		$branchs		= $this->input->post('branchdigit');
		
		// Date Ranger
		$emsdate_from	 = $this->input->post('emsdate_from');
		$emsdate_to		 = $this->input->post('emsdate_to');
		$missdate_from	 = $this->input->post('missdate_from');
		$missdate_to     = $this->input->post('missdate_to');
		$returndate_from = $this->input->post('returndate_from');
		$returndate_to	 = $this->input->post('returndate_to');
		
		// Date Ranger Convert
		$emsdate_from_conv     = !empty($emsdate_from) ? $this->effective->StandartDateSorter($emsdate_from):"";
		$emsdate_to_conv	   = !empty($emsdate_to) ? $this->effective->StandartDateSorter($emsdate_to):"";
		$missdate_from_conv    = !empty($missdate_from) ? $this->effective->StandartDateSorter($missdate_from):"";
		$missdate_to_conv	   = !empty($missdate_to) ? $this->effective->StandartDateSorter($missdate_to):"";
		$returndate_from_conv  = !empty($returndate_from) ? $this->effective->StandartDateSorter($returndate_from):"";
		$returndate_to_conv	   = !empty($returndate_to) ? $this->effective->StandartDateSorter($returndate_to):"";
		
		$wheres			= "";
		$wheres_option = " AND NOT CONVERT(nvarchar(10), Verification.EMSDate, 120) BETWEEN '1900-01-01' AND '2014-12-31' AND NOT CONVERT(nvarchar(10), Verification.EMSDate, 120) IS NULL";
		
		
		// Optional Query
		if(!empty($rmname)) { $wheres .= " AND RMName LIKE '%".iconv('UTF-8', 'TIS-620', $rmname)."%'"; }
		if(!empty($ownerName)) {
			$wheres .= " AND MainLoanName LIKE '%".iconv('UTF-8', 'TIS-620', $ownerName)."%' OR OwnerName LIKE '%".iconv('UTF-8', 'TIS-620', $ownerName)."%'";
		}
		

		if(!empty($regionid)) { $wheres .= " AND RegionID = '".trim(str_pad($regionid, 2, "0", STR_PAD_LEFT))."'"; }
		if(!empty($branchs)) { $wheres .= " AND BranchDigit = '".$branchs."'"; }
		if(!empty($logistic)) { $wheres .= " AND EMSNo = '".$logistic."'"; }
	
		// Date Ranger Statement
		if(!empty($emsdate_from_conv) && !empty($emsdate_to_conv)) { $wheres .= " AND CONVERT(nvarchar(10), EMSDate, 120) BETWEEN '".$emsdate_from_conv."' AND '".$emsdate_to_conv."'"; }
		else {
		
			if(!empty($emsdate_from_conv)) { $wheres .= " AND CONVERT(nvarchar(10), EMSDate, 120)  = '".$emsdate_from_conv."'"; }
			if(!empty($emsdate_to_conv)) { $wheres .= " AND CONVERT(nvarchar(10), EMSDate, 120)  = '".$emsdate_to_conv."'"; }
		
		}
		
		// Date Range
		if(!empty($missdate_from_conv) && !empty($missdate_to_conv)) { $wheres .= " AND CONVERT(nvarchar(10), CompletionDocDate, 120) BETWEEN '".$missdate_from_conv."' AND '".$missdate_to_conv."'"; }
		else {
		
			if(!empty($missdate_from_conv)) { $wheres .= " AND CONVERT(nvarchar(10), CompletionDocDate, 120)  = '".$missdate_from_conv."'"; }
			if(!empty($missdate_to_conv)) { $wheres .= " AND CONVERT(nvarchar(10), CompletionDocDate, 120)  = '".$missdate_to_conv."'"; }
		
		}
		
		/*
		// Date Range
		if(!empty($returndate_from_conv) && !empty($returndate_to_conv)) { $wheres .= " AND CONVERT(nvarchar(10), CreateDate, 120) BETWEEN '".$returndate_from_conv."' AND '".$returndate_to_conv."'"; }
		else {
		
			if(!empty($returndate_from_conv)) { $wheres .= " AND CONVERT(nvarchar(10), CreateDate, 120)  = '".$returndate_from_conv."'"; }
			if(!empty($returndate_to_conv)) { $wheres .= " AND CONVERT(nvarchar(10), CreateDate, 120)  = '".$returndate_to_conv."'"; }
		
		}
		*/
		
		// Query Process
		$iStart = $this->input->post('start');
		$iLength = $this->input->post('length') ? $iLength = $this->input->post('length') : 10;
	
		$start	= ($iStart)? $iStart : 0;
		$offset = $iLength + $start;
	
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
				
			switch($position) {
		
				// RECONCILE: PART MISSING DOCUMENT PAGINATION
				case 'misx':

					switch($privileges) {
						case $this->role_ad:
							
						if($empbranch == "000" || $empbranch == "901") {
							
							$result	= $this->db->query("
								SELECT * FROM (
									SELECT *
									FROM (
										SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
										LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
										[Profile].Region, Verification.VerifyID, Verification.EMSNo,
										CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE cONVERT(nvarchar(10), Verification.EMSDate, 120)
										END AS EMSDate, Verification.RMProcess,
										CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
										END AS HQReceiveCADocDate,
										CASE Verification.CompletionDocDate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
										END AS CompletionDocDate,
										CASE Verification.SentToCADate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
										END AS SentToCADate,
										Verification.SentDocToCA, Verification.CompletionDoc
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE NOT Verification.EMSNo IS NULL
										$wheres_option
										AND RMProcess = 'Completed'
										AND NOT HQReceiveCADocDate IS NULL
										$wheres
									) Datas
									LEFT OUTER JOIN (
											SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
											COUNT(LackList.VerifyID) AS MissingDocNum
											FROM LackList
											LEFT OUTER JOIN Verification
											ON LackList.VerifyID = Verification.VerifyID
											WHERE LackList.LackListActive = 'A'
											GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
									WHERE SentDocToCA IS NULL OR CompletionDoc IS NULL
								) A");
										
								return $result->num_rows();
						
						
						} else {
							
							$result	= $this->db->query("
								SELECT * FROM (
									SELECT *
									FROM (
										SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
										LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
										[Profile].Region, Verification.VerifyID, Verification.EMSNo,
										CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE cONVERT(nvarchar(10), Verification.EMSDate, 120)
										END AS EMSDate, Verification.RMProcess,
										CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
										END AS HQReceiveCADocDate,
										CASE Verification.CompletionDocDate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
										END AS CompletionDocDate,
										CASE Verification.SentToCADate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
										END AS SentToCADate,
										Verification.SentDocToCA, Verification.CompletionDoc
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE NOT Verification.EMSNo IS NULL
										$wheres_option
										AND RMProcess = 'Completed'
										AND [Profile].BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'
										$wheres
									) Datas
									LEFT OUTER JOIN (
											SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
											COUNT(LackList.VerifyID) AS MissingDocNum
											FROM LackList
											LEFT OUTER JOIN Verification
											ON LackList.VerifyID = Verification.VerifyID
											WHERE LackList.LackListActive = 'A'
											GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
								) A");
							
							return $result->num_rows();
						
						}
							
						break;
						case $this->role_bm:
						case $this->role_hq:
						case $this->role_spv:
						case $this->role_ads:
						
							if($empbranch == "000" || $empbranch == "901") {
								
								$result	= $this->db->query("
								SELECT * FROM (
									SELECT *
									FROM (
										SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
										LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
										[Profile].Region, Verification.VerifyID, Verification.EMSNo,
										CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE cONVERT(nvarchar(10), Verification.EMSDate, 120)
										END AS EMSDate, Verification.RMProcess,
										CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
										END AS HQReceiveCADocDate,
										CASE Verification.CompletionDocDate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
										END AS CompletionDocDate,
										CASE Verification.SentToCADate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
										END AS SentToCADate,
										Verification.SentDocToCA, Verification.CompletionDoc
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE NOT Verification.EMSNo IS NULL
										$wheres_option
										AND RMProcess = 'Completed'
										$wheres
									) Datas
									LEFT OUTER JOIN (
											SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
											COUNT(LackList.VerifyID) AS MissingDocNum
											FROM LackList
											LEFT OUTER JOIN Verification
											ON LackList.VerifyID = Verification.VerifyID
											WHERE LackList.LackListActive = 'A'
											GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
								) A");
									
								return $result->num_rows();
							
							} else {
								
								$result	= $this->db->query("
									SELECT * FROM (
										SELECT *
										FROM (
											SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE cONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc
											FROM [Profile]
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND RMProcess = 'Completed'
											AND [Profile].BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'
											$wheres
										) Datas
										LEFT OUTER JOIN (
											SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
											COUNT(LackList.VerifyID) AS MissingDocNum
											FROM LackList
											LEFT OUTER JOIN Verification
											ON LackList.VerifyID = Verification.VerifyID
											WHERE LackList.LackListActive = 'A'
											GROUP BY LackList.VerifyID, Verification.DocID
										) LackDocList
										ON Datas.DocID = LackDocList.DID
									) A");
										
								return $result->num_rows();
							
							}
						
						break;
						case $this->role_rm:
							
							$result	= $this->db->query("
								SELECT * FROM (
									SELECT *
									FROM (
										SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
										LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
										[Profile].Region, Verification.VerifyID, Verification.EMSNo,
										CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE cONVERT(nvarchar(10), Verification.EMSDate, 120)
										END AS EMSDate, Verification.RMProcess,
										CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
										END AS HQReceiveCADocDate,
										CASE Verification.CompletionDocDate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
										END AS CompletionDocDate,
										CASE Verification.SentToCADate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
										END AS SentToCADate,
										Verification.SentDocToCA, Verification.CompletionDoc
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE NOT Verification.EMSNo IS NULL
										$wheres_option
										AND RMProcess = 'Completed'
										AND [Profile].RMName LIKE '%".$employees['data'][0]['FullnameTh']."%'
										$wheres
									) Datas
									LEFT OUTER JOIN (
											SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
											COUNT(LackList.VerifyID) AS MissingDocNum
											FROM LackList
											LEFT OUTER JOIN Verification
											ON LackList.VerifyID = Verification.VerifyID
											WHERE LackList.LackListActive = 'A'
											GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
								) A");
								
							return $result->num_rows();
								
							
						break;
						case $this->role_am:
							
							$result	= $this->db->query("
								SELECT * FROM (
									SELECT *
									FROM (
										SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
										LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
										[Profile].Region, Verification.VerifyID, Verification.EMSNo,
										CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE cONVERT(nvarchar(10), Verification.EMSDate, 120)
										END AS EMSDate, Verification.RMProcess,
										CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
										END AS HQReceiveCADocDate,
										CASE Verification.CompletionDocDate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
										END AS CompletionDocDate,
										CASE Verification.SentToCADate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
										END AS SentToCADate,
										Verification.SentDocToCA, Verification.CompletionDoc
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE NOT Verification.EMSNo IS NULL
										$wheres_option
										AND RMProcess = 'Completed'
										AND [Profile].BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' GROUP BY BranchCode)
										$wheres
									) Datas
									LEFT OUTER JOIN (
											SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
											COUNT(LackList.VerifyID) AS MissingDocNum
											FROM LackList
											LEFT OUTER JOIN Verification
											ON LackList.VerifyID = Verification.VerifyID
											WHERE LackList.LackListActive = 'A'
											GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
								) A");
								
							return $result->num_rows();
								
							
						break;
						case $this->role_rd:
							
							$result	= $this->db->query("
								SELECT * FROM (
									SELECT *
									FROM (
										SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
										LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
										[Profile].Region, Verification.VerifyID, Verification.EMSNo,
										CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE cONVERT(nvarchar(10), Verification.EMSDate, 120)
										END AS EMSDate, Verification.RMProcess,
										CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
										END AS HQReceiveCADocDate,
										CASE Verification.CompletionDocDate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
										END AS CompletionDocDate,
										CASE Verification.SentToCADate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
										END AS SentToCADate,
										Verification.SentDocToCA, Verification.CompletionDoc
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE NOT Verification.EMSNo IS NULL
										$wheres_option
										AND RMProcess = 'Completed'
										AND [Profile].BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)
										$wheres
									) Datas
									LEFT OUTER JOIN (
											SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
											COUNT(LackList.VerifyID) AS MissingDocNum
											FROM LackList
											LEFT OUTER JOIN Verification
											ON LackList.VerifyID = Verification.VerifyID
											WHERE LackList.LackListActive = 'A'
											GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
								) A");
								
							return $result->num_rows();
								
							
						break;
					
					}
		
					break;
					
					
				// RECONCILE: PART RETURN PAGINATION
				case 'retx':
										 	
					switch($privileges) {
						case $this->role_ad:
								
							if($empbranch == "000" || $empbranch == "901") {
							
								$result = $this->db->query("
								SELECT * FROM (
									SELECT *
									FROM (SELECT [Profile].DocID, CountDocNo, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc
											FROM (SELECT DocID, COUNT(DocID) AS CountDocNo
												FROM DocRefund
												WHERE DocNo = '1' AND BranchGetDocDate IS NULL
												OR DocNo = '2' AND BranchGetDocDate IS NULL
												OR DocNo = '3' AND BranchGetDocDate IS NULL
												OR DocNo = '4' AND BranchGetDocDate IS NULL
												OR DocNo = '5' AND BranchGetDocDate IS NULL
												GROUP BY DocID
											) DocReturn
											INNER JOIN [Profile]
											ON DocReturn.DocID = [Profile].DocID
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											$wheres
										) Datas
										LEFT OUTER JOIN (
										SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
										COUNT(LackList.VerifyID) AS MissingDocNum
										FROM LackList
										LEFT OUTER JOIN Verification
										ON LackList.VerifyID = Verification.VerifyID
										WHERE LackList.LackListActive = 'A'
										GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
								) A");
											
								return $result->num_rows();
							
							
							} else {
								
								$result = $this->db->query("
								SELECT * FROM (
									SELECT *
									FROM (SELECT [Profile].DocID, CountDocNo, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc
											FROM (SELECT DocID, COUNT(DocID) AS CountDocNo
												FROM DocRefund
												WHERE DocNo = '1'
												OR DocNo = '2'
												OR DocNo = '3'
												OR DocNo = '4'
												OR DocNo = '5'
												GROUP BY DocID
											) DocReturn
											INNER JOIN [Profile]
											ON DocReturn.DocID = [Profile].DocID
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND [Profile].BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'
											$wheres
											) Datas
										LEFT OUTER JOIN (
										SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
										COUNT(LackList.VerifyID) AS MissingDocNum
										FROM LackList
										LEFT OUTER JOIN Verification
										ON LackList.VerifyID = Verification.VerifyID
										WHERE LackList.LackListActive = 'A'
										GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
								) A");
									
								return $result->num_rows();
							
							}
								
						break;
						case $this->role_bm:
						case $this->role_hq:
						case $this->role_spv:
						case $this->role_ads:
						
						
							if($empbranch == "000" || $empbranch == "901") {
									
								$result = $this->db->query("
								SELECT * FROM (
									SELECT *
									FROM (SELECT [Profile].DocID, CountDocNo, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc
											FROM (SELECT DocID, COUNT(DocID) AS CountDocNo
												FROM DocRefund
												WHERE DocNo = '1'
												OR DocNo = '2'
												OR DocNo = '3'
												OR DocNo = '4'
												OR DocNo = '5'
												GROUP BY DocID
											) DocReturn
											INNER JOIN [Profile]
											ON DocReturn.DocID = [Profile].DocID
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											$wheres
										) Datas
										LEFT OUTER JOIN (
										SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
										COUNT(LackList.VerifyID) AS MissingDocNum
										FROM LackList
										LEFT OUTER JOIN Verification
										ON LackList.VerifyID = Verification.VerifyID
										WHERE LackList.LackListActive = 'A'
										GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
								) A");
									
								return $result->num_rows();
									
									
							} else {
							
								$result = $this->db->query("
								SELECT * FROM (
									SELECT *
									FROM (SELECT [Profile].DocID, CountDocNo, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc
											FROM (SELECT DocID, COUNT(DocID) AS CountDocNo
												FROM DocRefund
												WHERE DocNo = '1'
												OR DocNo = '2'
												OR DocNo = '3'
												OR DocNo = '4'
												OR DocNo = '5'
												GROUP BY DocID
											) DocReturn
											INNER JOIN [Profile]
											ON DocReturn.DocID = [Profile].DocID
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND [Profile].BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'
											$wheres
										) Datas
										LEFT OUTER JOIN (
										SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
										COUNT(LackList.VerifyID) AS MissingDocNum
										FROM LackList
										LEFT OUTER JOIN Verification
										ON LackList.VerifyID = Verification.VerifyID
										WHERE LackList.LackListActive = 'A'
										GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
								) A");
									
								return $result->num_rows();
									
							}
														
							
						break;
						case $this->role_rm:
							
							$result = $this->db->query("
								SELECT * FROM (
									SELECT *
									FROM (SELECT [Profile].DocID, CountDocNo, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc
											FROM (SELECT DocID, COUNT(DocID) AS CountDocNo
												FROM DocRefund
												WHERE DocNo = '1'
												OR DocNo = '2'
												OR DocNo = '3'
												OR DocNo = '4'
												OR DocNo = '5'
												GROUP BY DocID
											) DocReturn
											INNER JOIN [Profile]
											ON DocReturn.DocID = [Profile].DocID
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND [Profile].RMName LIKE '%".$employees['data'][0]['FullnameTh']."%'
											$wheres
										) Datas
										LEFT OUTER JOIN (
										SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
										COUNT(LackList.VerifyID) AS MissingDocNum
										FROM LackList
										LEFT OUTER JOIN Verification
										ON LackList.VerifyID = Verification.VerifyID
										WHERE LackList.LackListActive = 'A'
										GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
								) A");
								
							return $result->num_rows();
								
							
						break;
						case $this->role_am:
							
							$result = $this->db->query("
								SELECT * FROM (
									SELECT *
									FROM (SELECT [Profile].DocID, CountDocNo, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc
											FROM (SELECT DocID, COUNT(DocID) AS CountDocNo
												FROM DocRefund
												WHERE DocNo = '1'
												OR DocNo = '2'
												OR DocNo = '3'
												OR DocNo = '4'
												OR DocNo = '5'
												GROUP BY DocID
											) DocReturn
											INNER JOIN [Profile]
											ON DocReturn.DocID = [Profile].DocID
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND [Profile].BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' GROUP BY BranchCode)
											$wheres
										) Datas
										LEFT OUTER JOIN (
										SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
										COUNT(LackList.VerifyID) AS MissingDocNum
										FROM LackList
										LEFT OUTER JOIN Verification
										ON LackList.VerifyID = Verification.VerifyID
										WHERE LackList.LackListActive = 'A'
										GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
								) A");
								
							return $result->num_rows();
								
							
						break;
						case $this->role_rd:
							
							
							$result = $this->db->query("
								SELECT * FROM (
									SELECT *
									FROM (SELECT [Profile].DocID, CountDocNo, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc
											FROM (SELECT DocID, COUNT(DocID) AS CountDocNo
												FROM DocRefund
												WHERE DocNo = '1'
												OR DocNo = '2'
												OR DocNo = '3'
												OR DocNo = '4'
												OR DocNo = '5'
												GROUP BY DocID
											) DocReturn
											INNER JOIN [Profile]
											ON DocReturn.DocID = [Profile].DocID
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND [Profile].BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)
											$wheres
										) Datas
										LEFT OUTER JOIN (
										SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
										COUNT(LackList.VerifyID) AS MissingDocNum
										FROM LackList
										LEFT OUTER JOIN Verification
										ON LackList.VerifyID = Verification.VerifyID
										WHERE LackList.LackListActive = 'A'
										GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
								) A");
								
							return $result->num_rows();
								
							
						break;
					
					}
					
					break;
					
				// ALL VIEW MODE PAGINATION 
				case 'allx':
	
					switch($privileges) {
						case $this->role_ad:
					
							if($empbranch == "000" || $empbranch == "901") {
								
								$result = $this->db->query("
									SELECT * FROM (
										SELECT *
										FROM (
											SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc
											FROM [Profile]
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND RMProcess = 'Completed'
											$wheres
										) Datas
										LEFT OUTER JOIN (
												SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
												COUNT(LackList.VerifyID) AS MissingDocNum
												FROM LackList
												LEFT OUTER JOIN Verification
												ON LackList.VerifyID = Verification.VerifyID
												WHERE LackList.LackListActive = 'A'
												GROUP BY LackList.VerifyID, Verification.DocID
										) LackDocList
										ON Datas.DocID = LackDocList.DID
										WHERE SentDocToCA IS NULL OR CompletionDoc IS NULL
									) A");
									
								return $result->num_rows();
								
								
							} else {
								
								$result = $this->db->query("
									SELECT * FROM (
										SELECT *
										FROM (
											SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc
											FROM [Profile]
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND RMProcess = 'Completed'
											AND [Profile].BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'
											$wheres
										) Datas
										LEFT OUTER JOIN (
												SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
												COUNT(LackList.VerifyID) AS MissingDocNum
												FROM LackList
												LEFT OUTER JOIN Verification
												ON LackList.VerifyID = Verification.VerifyID
												WHERE LackList.LackListActive = 'A'
												GROUP BY LackList.VerifyID, Verification.DocID
										) LackDocList
										ON Datas.DocID = LackDocList.DID
									) A");
									
								return $result->num_rows();
								
								
							}
							
						break;
						case $this->role_bm:
						case $this->role_hq:
						case $this->role_spv:
						case $this->role_ads:
								
							if($empbranch == "000" || $empbranch == "901") {
								
								$result = $this->db->query("
									SELECT * FROM (
										SELECT *
										FROM (
											SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc
											FROM [Profile]
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND RMProcess = 'Completed'
											$wheres
										) Datas
										LEFT OUTER JOIN (
												SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
												COUNT(LackList.VerifyID) AS MissingDocNum
												FROM LackList
												LEFT OUTER JOIN Verification
												ON LackList.VerifyID = Verification.VerifyID
												WHERE LackList.LackListActive = 'A'
												GROUP BY LackList.VerifyID, Verification.DocID
										) LackDocList
										ON Datas.DocID = LackDocList.DID
									) A");
									
								return $result->num_rows();
								
							} else {
								
								$result = $this->db->query("
									SELECT * FROM (
										SELECT *
										FROM (
											SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc
											FROM [Profile]
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND RMProcess = 'Completed'
											AND [Profile].BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'
											$wheres
										) Datas
										LEFT OUTER JOIN (
												SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
												COUNT(LackList.VerifyID) AS MissingDocNum
												FROM LackList
												LEFT OUTER JOIN Verification
												ON LackList.VerifyID = Verification.VerifyID
												WHERE LackList.LackListActive = 'A'
												GROUP BY LackList.VerifyID, Verification.DocID
										) LackDocList
										ON Datas.DocID = LackDocList.DID
									) A");
									
								return $result->num_rows();
								
							}
							
						break;
						case $this->role_rm:
							
							$result = $this->db->query("
									SELECT * FROM (
										SELECT *
										FROM (
											SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc
											FROM [Profile]
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND RMProcess = 'Completed'
											AND [Profile].RMName LIKE '%".$employees['data'][0]['FullnameTh']."%'
											$wheres
										) Datas
										LEFT OUTER JOIN (
												SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
												COUNT(LackList.VerifyID) AS MissingDocNum
												FROM LackList
												LEFT OUTER JOIN Verification
												ON LackList.VerifyID = Verification.VerifyID
												WHERE LackList.LackListActive = 'A'
												GROUP BY LackList.VerifyID, Verification.DocID
										) LackDocList
										ON Datas.DocID = LackDocList.DID
									) A");
								
							return $result->num_rows();
							
						break;
						case $this->role_am:
							
							$result = $this->db->query("
									SELECT * FROM (
										SELECT *
										FROM (
											SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc
											FROM [Profile]
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND RMProcess = 'Completed'
											AND [Profile].BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' GROUP BY BranchCode)
											$wheres
										) Datas
										LEFT OUTER JOIN (
												SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
												COUNT(LackList.VerifyID) AS MissingDocNum
												FROM LackList
												LEFT OUTER JOIN Verification
												ON LackList.VerifyID = Verification.VerifyID
												WHERE LackList.LackListActive = 'A'
												GROUP BY LackList.VerifyID, Verification.DocID
										) LackDocList
										ON Datas.DocID = LackDocList.DID
									) A");
								
							return $result->num_rows();
							
						break;
						case $this->role_rd:
							
							$result = $this->db->query("
									SELECT * FROM (
										SELECT *
										FROM (
											SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc
											FROM [Profile]
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND RMProcess = 'Completed'
											AND [Profile].BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)
											$wheres
										) Datas
										LEFT OUTER JOIN (
												SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
												COUNT(LackList.VerifyID) AS MissingDocNum
												FROM LackList
												LEFT OUTER JOIN Verification
												ON LackList.VerifyID = Verification.VerifyID
												WHERE LackList.LackListActive = 'A'
												GROUP BY LackList.VerifyID, Verification.DocID
										) LackDocList
										ON Datas.DocID = LackDocList.DID
									) A");
								
							return $result->num_rows();
							
						break;
						
					}
					
					break;
					
					
				// ALL RECONCILE: PART EMS PAGINATION 
				case 'recx':
				default:
					
					switch($privileges) {
						case $this->role_ad:
						
							if($empbranch == "000" || $empbranch == "901") {
								
								$result = $this->db->query("
										SELECT *
										FROM (
										SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
										LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
										[Profile].Region, Verification.VerifyID, Verification.EMSNo,
										CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
										END AS EMSDate, Verification.RMProcess,
										CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
										END AS HQReceiveCADocDate
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE Verification.RMProcess = 'Completed'
										AND NOT Verification.EMSNo = ''
										$wheres_option
										AND Verification.HQReceiveCADocDate IS NULL
										$wheres
								) A");
								
								return $result->num_rows();
								
								
							} else {
								
								$result = $this->db->query("
										SELECT *
										FROM (
										SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
										LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
										[Profile].Region, Verification.VerifyID, Verification.EMSNo,
										CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
										END AS EMSDate, Verification.RMProcess,
										CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
										END AS HQReceiveCADocDate
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE Verification.RMProcess = 'Completed'
										AND NOT Verification.EMSNo = ''
										$wheres_option
										AND [Profile].BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'
										$wheres
										$wheres_option
								) A");
											
								return $result->num_rows();
								
							}
								
								
							break;
						case $this->role_bm:
						case $this->role_hq:
						case $this->role_spv:
						case $this->role_ads:
							
							if($empbranch == "000" || $empbranch == "901") {
									
								$result = $this->db->query("
									SELECT *
										FROM (
										SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
										LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
										[Profile].Region, Verification.VerifyID, Verification.EMSNo,
										CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
										END AS EMSDate, Verification.RMProcess,
										CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
										END AS HQReceiveCADocDate
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE Verification.RMProcess = 'Completed'
										AND NOT Verification.EMSNo = ''
										$wheres_option
										$wheres
								) A");
											
								return $result->num_rows();
									
									
							} else {
									
								$result = $this->db->query("
									SELECT *
									FROM (
										SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
										LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
										[Profile].Region, Verification.VerifyID, Verification.EMSNo,
										CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
										END AS EMSDate, Verification.RMProcess,
										CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
										END AS HQReceiveCADocDate
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE Verification.RMProcess = 'Completed'
										AND NOT Verification.EMSNo = ''
										$wheres_option
										AND [Profile].BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'
										$wheres
										$wheres_option
									) A");
							
								return $result->num_rows();
													
							}
								
								
							break;
						case $this->role_rm:
					
							$result = $this->db->query("
									SELECT *
									FROM (
									SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
									LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
									[Profile].Region, Verification.VerifyID, Verification.EMSNo,
									CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
									WHEN '1900-01-01' THEN NULL
									ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
									END AS EMSDate, Verification.RMProcess,
									CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
									WHEN '1900-01-01' THEN NULL
									ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
									END AS HQReceiveCADocDate
									FROM [Profile]
									LEFT OUTER JOIN Verification
									ON [Profile].DocID = Verification.DocID
									LEFT OUTER JOIN NCB
									ON Verification.VerifyID = NCB.VerifyID
									LEFT OUTER JOIN LendingBranchs
									ON [Profile].BranchCode = LendingBranchs.BranchCode
									WHERE Verification.RMProcess = 'Completed'
									AND NOT Verification.EMSNo = ''
									$wheres_option
									AND [Profile].RMName LIKE '%".$employees['data'][0]['FullnameTh']."%'
									$wheres
							) A");
							
							return $result->num_rows();
								
							break;
						case $this->role_am:
								
							$result = $this->db->query("
								SELECT *
									FROM (
									SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
									LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
									[Profile].Region, Verification.VerifyID, Verification.EMSNo,
									CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
									WHEN '1900-01-01' THEN NULL
									ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
									END AS EMSDate, Verification.RMProcess,
									CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
									WHEN '1900-01-01' THEN NULL
									ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
									END AS HQReceiveCADocDate
									FROM [Profile]
									LEFT OUTER JOIN Verification
									ON [Profile].DocID = Verification.DocID
									LEFT OUTER JOIN NCB
									ON Verification.VerifyID = NCB.VerifyID
									LEFT OUTER JOIN LendingBranchs
									ON [Profile].BranchCode = LendingBranchs.BranchCode
									WHERE Verification.RMProcess = 'Completed'
									AND NOT Verification.EMSNo = ''
									$wheres_option
									AND [Profile].BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' GROUP BY BranchCode)
									$wheres
							) A");
							
							return $result->num_rows();
								
							break;
						case $this->role_rd:
								
							$result = $this->db->query("
								SELECT *
									FROM (
									SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
									LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
									[Profile].Region, Verification.VerifyID, Verification.EMSNo,
									CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
									WHEN '1900-01-01' THEN NULL
									ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
									END AS EMSDate, Verification.RMProcess,
									CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
									WHEN '1900-01-01' THEN NULL
									ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
									END AS HQReceiveCADocDate
									FROM [Profile]
									LEFT OUTER JOIN Verification
									ON [Profile].DocID = Verification.DocID
									LEFT OUTER JOIN NCB
									ON Verification.VerifyID = NCB.VerifyID
									LEFT OUTER JOIN LendingBranchs
									ON [Profile].BranchCode = LendingBranchs.BranchCode
									WHERE Verification.RMProcess = 'Completed'
									AND NOT Verification.EMSNo = ''
									$wheres_option
									AND [Profile].BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)
									$wheres
							) A");
							
							return $result->num_rows();
								
							break;
					}
					
					
		
				break;
			}
		}
	
	}
	
	// ------------------------------------------------------------------------------------------------------------------------------- //
	// --------------------------------------------------------  PROCESS ------------------------------------------------------------- //
	// ------------------------------------------------------------------------------------------------------------------------------- //
	
	
	public function getLayerAuthority($position, $authority, $condition = array()) {
		$this->load->model('dbmodel');
		$this->load->model('dbcustom');
		$this->load->library('effective');
		
		$rmname			= $this->input->post('rmname');
		$ownerName		= $this->input->post('ownerName');
		$logistic		= $this->input->post('logistic_code');
		$regionid		= $this->input->post('regionid');
		$branchs		= $this->input->post('branchdigit');
		
		// Date Ranger
		$emsdate_from	 = $this->input->post('emsdate_from');
		$emsdate_to		 = $this->input->post('emsdate_to');
		$missdate_from	 = $this->input->post('missdate_from');
		$missdate_to     = $this->input->post('missdate_to');
		$returndate_from = $this->input->post('returndate_from');
		$returndate_to	 = $this->input->post('returndate_to');
		
		// Date Ranger Convert
		$emsdate_from_conv     = !empty($emsdate_from) ? $this->effective->StandartDateSorter($emsdate_from):"";
		$emsdate_to_conv	   = !empty($emsdate_to) ? $this->effective->StandartDateSorter($emsdate_to):"";
		$missdate_from_conv    = !empty($missdate_from) ? $this->effective->StandartDateSorter($missdate_from):"";
		$missdate_to_conv	   = !empty($missdate_to) ? $this->effective->StandartDateSorter($missdate_to):"";
		$returndate_from_conv  = !empty($returndate_from) ? $this->effective->StandartDateSorter($returndate_from):"";
		$returndate_to_conv	   = !empty($returndate_to) ? $this->effective->StandartDateSorter($returndate_to):"";
		
		$wheres			= "";
		$wheres_option = " AND NOT CONVERT(nvarchar(10), Verification.EMSDate, 120) BETWEEN '1900-01-01' AND '2014-12-31'";
		
		
		// Optional Query
		if(!empty($rmname)) { $wheres .= " AND RMName LIKE '%".iconv('UTF-8', 'TIS-620', $rmname)."%'"; }
		if(!empty($ownerName)) {
			$wheres .= " AND MainLoanName LIKE '%".iconv('UTF-8', 'TIS-620', $ownerName)."%' OR OwnerName LIKE '%".iconv('UTF-8', 'TIS-620', $ownerName)."%'";
		}
		

		if(!empty($regionid)) { $wheres .= " AND RegionID = '".trim(str_pad($regionid, 2, "0", STR_PAD_LEFT))."'"; }
		if(!empty($branchs)) { $wheres .= " AND BranchDigit = '".$branchs."'"; }
		if(!empty($logistic)) { $wheres .= " AND EMSNo = '".$logistic."'"; }
	
		// Date Ranger Statment
		if(!empty($emsdate_from_conv) && !empty($emsdate_to_conv)) { $wheres .= " AND CONVERT(nvarchar(10), EMSDate, 120) BETWEEN '".$emsdate_from_conv."' AND '".$emsdate_to_conv."'"; }
		else {
		
			if(!empty($emsdate_from_conv)) { $wheres .= " AND CONVERT(nvarchar(10), EMSDate, 120)  = '".$emsdate_from_conv."'"; }
			if(!empty($emsdate_to_conv)) { $wheres .= " AND CONVERT(nvarchar(10), EMSDate, 120)  = '".$emsdate_to_conv."'"; }
		
		}
		
		// Date Range
		if(!empty($missdate_from_conv) && !empty($missdate_to_conv)) { $wheres .= " AND CONVERT(nvarchar(10), CompletionDocDate, 120) BETWEEN '".$missdate_from_conv."' AND '".$missdate_to_conv."'"; }
		else {
		
			if(!empty($missdate_from_conv)) { $wheres .= " AND CONVERT(nvarchar(10), CompletionDocDate, 120)  = '".$missdate_from_conv."'"; }
			if(!empty($missdate_to_conv)) { $wheres .= " AND CONVERT(nvarchar(10), CompletionDocDate, 120)  = '".$missdate_to_conv."'"; }
		
		}
		
		// Date Range
		if(!empty($returndate_from_conv) && !empty($returndate_to_conv)) { $wheres .= " AND CONVERT(nvarchar(10), CreateDate, 120) BETWEEN '".$returndate_from_conv."' AND '".$returndate_to_conv."'"; }
		else {
		
			if(!empty($returndate_from_conv)) { $wheres .= " AND CONVERT(nvarchar(10), CreateDate, 120)  = '".$returndate_from_conv."'"; }
			if(!empty($returndate_to_conv)) { $wheres .= " AND CONVERT(nvarchar(10), CreateDate, 120)  = '".$returndate_to_conv."'"; }
		
		}
		
		
		
		// Query Process
		$iStart = $this->input->post('start');
		$iLength = $this->input->post('length') ? $iLength = $this->input->post('length') : 10;
		
		$start	= ($iStart)? $iStart : 0;
		$offset = $iLength + $start;
		
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
			
			switch($position) {
				
				// RECONCILE: PART MISSING DOCUMENT PROCESS
				case 'misx':
					
					switch($privileges) {
						case $this->role_ad:
						
							if($empbranch == "000" || $empbranch == "901") {
								
								$result	= $this->dbmodel->CIQuery("
									SELECT * FROM (
										SELECT *
										FROM (
											SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
												LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
												[Profile].Region, Verification.VerifyID, Verification.EMSNo,
												CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												END AS EMSDate, Verification.RMProcess,
												CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												END AS HQReceiveCADocDate,
												CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
												END AS CompletionDocDate,
												CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
												END AS SentToCADate,
												Verification.SentDocToCA, Verification.CompletionDoc,
												[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
											FROM [Profile]
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND RMProcess = 'Completed'
											AND NOT HQReceiveCADocDate IS NULL
											$wheres
										) Datas
										LEFT OUTER JOIN (
										SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
										COUNT(LackList.VerifyID) AS MissingDocNum
										FROM LackList
										LEFT OUTER JOIN Verification
										ON LackList.VerifyID = Verification.VerifyID
										WHERE LackList.LackListActive = 'A'
										GROUP BY LackList.VerifyID, Verification.DocID
										) LackDocList
										ON Datas.DocID = LackDocList.DID
										WHERE SentDocToCA IS NULL OR CompletionDoc IS NULL
									) A
									WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
							
									return $result;
								
							} else {
								
								
								$result	= $this->dbmodel->CIQuery("
									SELECT * FROM (
										SELECT *
										FROM (
											SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
												LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
												[Profile].Region, Verification.VerifyID, Verification.EMSNo,
												CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												END AS EMSDate, Verification.RMProcess,
												CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												END AS HQReceiveCADocDate,
												CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
												END AS CompletionDocDate,
												CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
												END AS SentToCADate,
												Verification.SentDocToCA, Verification.CompletionDoc,
												[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
											FROM [Profile]
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND RMProcess = 'Completed'
											AND [Profile].BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'
											$wheres
										) Datas
										LEFT OUTER JOIN (
										SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
										COUNT(LackList.VerifyID) AS MissingDocNum
										FROM LackList
										LEFT OUTER JOIN Verification
										ON LackList.VerifyID = Verification.VerifyID
										WHERE LackList.LackListActive = 'A'
										GROUP BY LackList.VerifyID, Verification.DocID
										) LackDocList
										ON Datas.DocID = LackDocList.DID
								) A
								WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
									
								return $result;
								
							}
							
							
						break;
						case $this->role_bm:
						case $this->role_hq:
						case $this->role_spv:
						case $this->role_ads:

							if($empbranch == "000" || $empbranch == "901") {

								$result	= $this->dbmodel->CIQuery("
								SELECT * FROM (
									SELECT *
									FROM (
										SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc,
											[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE NOT Verification.EMSNo IS NULL
										$wheres_option
										AND RMProcess = 'Completed'
										$wheres
										) Datas
									LEFT OUTER JOIN (
									SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
									COUNT(LackList.VerifyID) AS MissingDocNum
									FROM LackList
									LEFT OUTER JOIN Verification
									ON LackList.VerifyID = Verification.VerifyID
									WHERE LackList.LackListActive = 'A'
									GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
								) A
								WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
					
								return $result;
								
							} else {
							
								$result	= $this->dbmodel->CIQuery("
								SELECT * FROM (
										SELECT *
										FROM (
											SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc,
											[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE NOT Verification.EMSNo IS NULL
										$wheres_option
										AND RMProcess = 'Completed'
										AND [Profile].BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'
										$wheres
									) Datas
									LEFT OUTER JOIN (
									SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
									COUNT(LackList.VerifyID) AS MissingDocNum
									FROM LackList
									LEFT OUTER JOIN Verification
									ON LackList.VerifyID = Verification.VerifyID
									WHERE LackList.LackListActive = 'A'
									GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
								) A
								WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
											
								return $result;
							
							}
							
						break;
						case $this->role_rm:
						
							$result	= $this->dbmodel->CIQuery("
								SELECT * FROM (
									SELECT *
									FROM (
										SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc,
											[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE NOT Verification.EMSNo IS NULL
										$wheres_option
										AND RMProcess = 'Completed'
										AND [Profile].RMName LIKE '%".$employees['data'][0]['FullnameTh']."%'
										$wheres
									) Datas
									LEFT OUTER JOIN (
									SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
									COUNT(LackList.VerifyID) AS MissingDocNum
									FROM LackList
									LEFT OUTER JOIN Verification
									ON LackList.VerifyID = Verification.VerifyID
									WHERE LackList.LackListActive = 'A'
									GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
								) A
								WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
									
							return $result;
							
						break;
						case $this->role_am:
							
							$result	= $this->dbmodel->CIQuery("
								SELECT * FROM (
									SELECT *
									FROM (
										SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc,
											[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE NOT Verification.EMSNo IS NULL
										$wheres_option
										AND RMProcess = 'Completed'
										AND [Profile].BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' GROUP BY BranchCode)
										$wheres
									) Datas
									LEFT OUTER JOIN (
									SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
									COUNT(LackList.VerifyID) AS MissingDocNum
									FROM LackList
									LEFT OUTER JOIN Verification
									ON LackList.VerifyID = Verification.VerifyID
									WHERE LackList.LackListActive = 'A'
									GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
								) A
								WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
					
							return $result;
							
							
						break;
						case $this->role_rd:
							
							$result	= $this->dbmodel->CIQuery("
								SELECT * FROM (
									SELECT *
									FROM (
										SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc,
											[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE NOT Verification.EMSNo IS NULL
										$wheres_option
										AND RMProcess = 'Completed'
										AND [Profile].BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)
										$wheres
									) Datas
									LEFT OUTER JOIN (
									SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
									COUNT(LackList.VerifyID) AS MissingDocNum
									FROM LackList
									LEFT OUTER JOIN Verification
									ON LackList.VerifyID = Verification.VerifyID
									WHERE LackList.LackListActive = 'A'
									GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
								) A
								WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
			
							return $result;
							
						break;
					}
						
						
			
					break;
					
					// RECONCILE: PART RETURN DOCUMENT PROCESS
					case 'retx':
						
						switch($privileges) {
							case $this->role_ad:
							
								
								if($empbranch == "000" || $empbranch == "901") {
									
									$result = $this->dbmodel->CIQuery("
										SELECT * FROM (
											SELECT *
											FROM (SELECT [Profile].DocID, CountDocNo, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
												LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
												[Profile].Region, Verification.VerifyID, Verification.EMSNo,
												CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												END AS EMSDate, Verification.RMProcess,
												CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												END AS HQReceiveCADocDate,
												CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
												END AS CompletionDocDate,
												CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
												END AS SentToCADate,
												Verification.SentDocToCA, Verification.CompletionDoc,
												[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
											FROM (	SELECT DocID, COUNT(DocID) AS CountDocNo
													FROM DocRefund
													WHERE DocNo = '1' AND BranchGetDocDate IS NULL
													OR DocNo = '2' AND BranchGetDocDate IS NULL
													OR DocNo = '3' AND BranchGetDocDate IS NULL
													OR DocNo = '4' AND BranchGetDocDate IS NULL
													OR DocNo = '5' AND BranchGetDocDate IS NULL
													GROUP BY DocID
											) DocReturn
											INNER JOIN [Profile]
											ON DocReturn.DocID = [Profile].DocID
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											$wheres
											) Datas
											LEFT OUTER JOIN (
											SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
											COUNT(LackList.VerifyID) AS MissingDocNum
											FROM LackList
											LEFT OUTER JOIN Verification
											ON LackList.VerifyID = Verification.VerifyID
											WHERE LackList.LackListActive = 'A'
											GROUP BY LackList.VerifyID, Verification.DocID
										) LackDocList
										ON Datas.DocID = LackDocList.DID
										) A
										WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
									
										return $result;
									
								} else {
									
									$result = $this->dbmodel->CIQuery("
										SELECT * FROM (
											SELECT *
											FROM (SELECT [Profile].DocID, CountDocNo, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
												LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
													[Profile].Region, Verification.VerifyID, Verification.EMSNo,
													CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
													WHEN '1900-01-01' THEN NULL
													ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
													END AS EMSDate, Verification.RMProcess,
													CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
													WHEN '1900-01-01' THEN NULL
													ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
													END AS HQReceiveCADocDate,
													CASE Verification.CompletionDocDate
													WHEN '1900-01-01' THEN NULL
													ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
													END AS CompletionDocDate,
													CASE Verification.SentToCADate
													WHEN '1900-01-01' THEN NULL
													ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
													END AS SentToCADate,
													Verification.SentDocToCA, Verification.CompletionDoc,
													[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
												FROM (	SELECT DocID, COUNT(DocID) AS CountDocNo
														FROM DocRefund
														WHERE DocNo = '1'
														OR DocNo = '2'
														OR DocNo = '3'
														OR DocNo = '4'
														OR DocNo = '5'
														GROUP BY DocID
												) DocReturn
												INNER JOIN [Profile]
												ON DocReturn.DocID = [Profile].DocID
												LEFT OUTER JOIN Verification
												ON [Profile].DocID = Verification.DocID
												LEFT OUTER JOIN NCB
												ON Verification.VerifyID = NCB.VerifyID
												LEFT OUTER JOIN LendingBranchs
												ON [Profile].BranchCode = LendingBranchs.BranchCode
												WHERE NOT Verification.EMSNo IS NULL
												$wheres_option
												AND [Profile].BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'
												$wheres
											) Datas
											LEFT OUTER JOIN (
											SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
											COUNT(LackList.VerifyID) AS MissingDocNum
											FROM LackList
											LEFT OUTER JOIN Verification
											ON LackList.VerifyID = Verification.VerifyID
											WHERE LackList.LackListActive = 'A'
											GROUP BY LackList.VerifyID, Verification.DocID
											) LackDocList
											ON Datas.DocID = LackDocList.DID
										) A
										WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
												
										return $result;
									
									
								}
									
									
								break;
							case $this->role_bm:
							case $this->role_hq:
							case $this->role_spv:
							case $this->role_ads:
								
								if($empbranch == "000" || $empbranch == "901") {
										
									$result = $this->dbmodel->CIQuery("
										SELECT * FROM (
											SELECT *
											FROM (SELECT [Profile].DocID, CountDocNo, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
												LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
												[Profile].Region, Verification.VerifyID, Verification.EMSNo,
												CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												END AS EMSDate, Verification.RMProcess,
												CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												END AS HQReceiveCADocDate,
												CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
												END AS CompletionDocDate,
												CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
												END AS SentToCADate,
												Verification.SentDocToCA, Verification.CompletionDoc,
												[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
											FROM (	SELECT DocID, COUNT(DocID) AS CountDocNo
													FROM DocRefund
													WHERE DocNo = '1'
													OR DocNo = '2'
													OR DocNo = '3'
													OR DocNo = '4'
													OR DocNo = '5'
													GROUP BY DocID
											) DocReturn
										INNER JOIN [Profile]
										ON DocReturn.DocID = [Profile].DocID
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE NOT Verification.EMSNo IS NULL
										$wheres_option
										$wheres
										) Datas
										LEFT OUTER JOIN (
										SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
										COUNT(LackList.VerifyID) AS MissingDocNum
										FROM LackList
										LEFT OUTER JOIN Verification
										ON LackList.VerifyID = Verification.VerifyID
										WHERE LackList.LackListActive = 'A'
										GROUP BY LackList.VerifyID, Verification.DocID
										) LackDocList
										ON Datas.DocID = LackDocList.DID
										) A
										WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
											
										return $result;
												
								} else {
												
									$result = $this->dbmodel->CIQuery("
									SELECT * FROM (
										SELECT *
										FROM (SELECT [Profile].DocID, CountDocNo, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc,
											[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
											FROM (	SELECT DocID, COUNT(DocID) AS CountDocNo
											FROM DocRefund
											WHERE DocNo = '1'
											OR DocNo = '2'
											OR DocNo = '3'
											OR DocNo = '4'
											OR DocNo = '5'
											GROUP BY DocID
									) DocReturn
									INNER JOIN [Profile]
									ON DocReturn.DocID = [Profile].DocID
									LEFT OUTER JOIN Verification
									ON [Profile].DocID = Verification.DocID
									LEFT OUTER JOIN NCB
									ON Verification.VerifyID = NCB.VerifyID
									LEFT OUTER JOIN LendingBranchs
									ON [Profile].BranchCode = LendingBranchs.BranchCode
									WHERE NOT Verification.EMSNo IS NULL
									$wheres_option
									AND [Profile].BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'
									$wheres
									) Datas
									LEFT OUTER JOIN (
									SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
									COUNT(LackList.VerifyID) AS MissingDocNum
									FROM LackList
									LEFT OUTER JOIN Verification
									ON LackList.VerifyID = Verification.VerifyID
									WHERE LackList.LackListActive = 'A'
									GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
									) A
									WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
								
									return $result;
										
										
									}
									
									
								break;
							case $this->role_rm:
								
								$result = $this->dbmodel->CIQuery("
									SELECT * FROM (
										SELECT *
										FROM (SELECT [Profile].DocID, CountDocNo, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
												LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
												[Profile].Region, Verification.VerifyID, Verification.EMSNo,
												CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												END AS EMSDate, Verification.RMProcess,
												CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												END AS HQReceiveCADocDate,
												CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
												END AS CompletionDocDate,
												CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
												END AS SentToCADate,
												Verification.SentDocToCA, Verification.CompletionDoc,
												[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
											FROM (	SELECT DocID, COUNT(DocID) AS CountDocNo
													FROM DocRefund
													WHERE DocNo = '1'
													OR DocNo = '2'
													OR DocNo = '3'
													OR DocNo = '4'
												OR DocNo = '5'
												GROUP BY DocID
													) DocReturn
											INNER JOIN [Profile]
											ON DocReturn.DocID = [Profile].DocID
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND [Profile].RMName LIKE '%".$employees['data'][0]['FullnameTh']."%'
											$wheres
										) Datas
										LEFT OUTER JOIN (
										SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
										COUNT(LackList.VerifyID) AS MissingDocNum
										FROM LackList
										LEFT OUTER JOIN Verification
										ON LackList.VerifyID = Verification.VerifyID
										WHERE LackList.LackListActive = 'A'
										GROUP BY LackList.VerifyID, Verification.DocID
										) LackDocList
										ON Datas.DocID = LackDocList.DID
									) A
									WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
			
								return $result;
						
									
								break;
							case $this->role_am:
								
								$result = $this->dbmodel->CIQuery("
									SELECT * FROM (
										SELECT *
										FROM (SELECT [Profile].DocID, CountDocNo, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc,
											[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
										FROM (	SELECT DocID, COUNT(DocID) AS CountDocNo
												FROM DocRefund
												WHERE DocNo = '1'
												OR DocNo = '2'
												OR DocNo = '3'
												OR DocNo = '4'
												OR DocNo = '5'
												GROUP BY DocID
										) DocReturn
										INNER JOIN [Profile]
										ON DocReturn.DocID = [Profile].DocID
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE NOT Verification.EMSNo IS NULL
										$wheres_option
										AND [Profile].BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' GROUP BY BranchCode)
										$wheres
										) Datas
										LEFT OUTER JOIN (
										SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
										COUNT(LackList.VerifyID) AS MissingDocNum
										FROM LackList
										LEFT OUTER JOIN Verification
										ON LackList.VerifyID = Verification.VerifyID
										WHERE LackList.LackListActive = 'A'
										GROUP BY LackList.VerifyID, Verification.DocID
										) LackDocList
										ON Datas.DocID = LackDocList.DID
									) A
									WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
									
								return $result;
									
									
								break;
							case $this->role_rd:
									
								$result = $this->dbmodel->CIQuery("
									SELECT * FROM (
										SELECT *
										FROM (SELECT [Profile].DocID, CountDocNo, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
												LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
												[Profile].Region, Verification.VerifyID, Verification.EMSNo,
												CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												END AS EMSDate, Verification.RMProcess,
												CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												END AS HQReceiveCADocDate,
												CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
												END AS CompletionDocDate,
												CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
												END AS SentToCADate,
												Verification.SentDocToCA, Verification.CompletionDoc,
												[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
											FROM (	SELECT DocID, COUNT(DocID) AS CountDocNo
											FROM DocRefund
													WHERE DocNo = '1'
													OR DocNo = '2'
													OR DocNo = '3'
													OR DocNo = '4'
													OR DocNo = '5'
													GROUP BY DocID
											) DocReturn
										INNER JOIN [Profile]
										ON DocReturn.DocID = [Profile].DocID
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE NOT Verification.EMSNo IS NULL
										$wheres_option
										AND [Profile].BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)
										$wheres
									) Datas
									LEFT OUTER JOIN (
									SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
									COUNT(LackList.VerifyID) AS MissingDocNum
									FROM LackList
									LEFT OUTER JOIN Verification
									ON LackList.VerifyID = Verification.VerifyID
									WHERE LackList.LackListActive = 'A'
									GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
									) A
									WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
				
									return $result;
						
									
								break;
						}

					break;
					
					// ALL VIEW MODE PROCESS
					case 'allx':
						
						
						switch($privileges) {
							case $this->role_ad:
	
								if($empbranch == "000" || $empbranch == "901") {
									
									$result = $this->dbmodel->CIQuery("
										SELECT * FROM (
											SELECT *
											FROM (
												SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
													LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
													[Profile].Region, Verification.VerifyID, Verification.EMSNo,
													CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
													WHEN '1900-01-01' THEN NULL
													ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
													END AS EMSDate, Verification.RMProcess,
													CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
													WHEN '1900-01-01' THEN NULL
													ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
													END AS HQReceiveCADocDate,
													CASE Verification.CompletionDocDate
													WHEN '1900-01-01' THEN NULL
													ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
													END AS CompletionDocDate,
													CASE Verification.SentToCADate
													WHEN '1900-01-01' THEN NULL
													ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
													END AS SentToCADate,
													Verification.SentDocToCA, Verification.CompletionDoc,
													[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
												FROM [Profile]
												LEFT OUTER JOIN Verification
												ON [Profile].DocID = Verification.DocID
												LEFT OUTER JOIN NCB
												ON Verification.VerifyID = NCB.VerifyID
												LEFT OUTER JOIN LendingBranchs
												ON [Profile].BranchCode = LendingBranchs.BranchCode
												WHERE NOT Verification.EMSNo IS NULL
												$wheres_option
												AND RMProcess = 'Completed'
												$wheres
											) Datas
											LEFT OUTER JOIN (
											SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
											COUNT(LackList.VerifyID) AS MissingDocNum
											FROM LackList
											LEFT OUTER JOIN Verification
											ON LackList.VerifyID = Verification.VerifyID
											WHERE LackList.LackListActive = 'A'
											GROUP BY LackList.VerifyID, Verification.DocID
											) LackDocList
											ON Datas.DocID = LackDocList.DID
											WHERE SentDocToCA IS NULL OR CompletionDoc IS NULL
										) A
										WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
									
									return $result;
								
							} else {
								
								$result = $this->dbmodel->CIQuery("
									SELECT * FROM (
										SELECT *
										FROM (
											SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
												LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
												[Profile].Region, Verification.VerifyID, Verification.EMSNo,
												CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												END AS EMSDate, Verification.RMProcess,
												CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												END AS HQReceiveCADocDate,
												CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
												END AS CompletionDocDate,
												CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
												END AS SentToCADate,
												Verification.SentDocToCA, Verification.CompletionDoc,
												[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
											FROM [Profile]
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND RMProcess = 'Completed'
											AND [Profile].BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'
											$wheres
										) Datas
										LEFT OUTER JOIN (
										SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
										COUNT(LackList.VerifyID) AS MissingDocNum
										FROM LackList
										LEFT OUTER JOIN Verification
										ON LackList.VerifyID = Verification.VerifyID
										WHERE LackList.LackListActive = 'A'
										GROUP BY LackList.VerifyID, Verification.DocID
										) LackDocList
										ON Datas.DocID = LackDocList.DID
									) A
									WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
											
								return $result;
								
							}
								
								
							break;
							case $this->role_bm:
							case $this->role_hq:
							case $this->role_spv:
							case $this->role_ads:
								
								if($empbranch == "000" || $empbranch == "901") {
										
									$result = $this->dbmodel->CIQuery("
										SELECT * FROM (
											SELECT *
											FROM (
												SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
													LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
													[Profile].Region, Verification.VerifyID, Verification.EMSNo,
													CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
													WHEN '1900-01-01' THEN NULL
													ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
													END AS EMSDate, Verification.RMProcess,
													CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
													WHEN '1900-01-01' THEN NULL
													ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
													END AS HQReceiveCADocDate,
													CASE Verification.CompletionDocDate
													WHEN '1900-01-01' THEN NULL
													ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
													END AS CompletionDocDate,
													CASE Verification.SentToCADate
													WHEN '1900-01-01' THEN NULL
													ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
													END AS SentToCADate,
													Verification.SentDocToCA, Verification.CompletionDoc,
													[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
												FROM [Profile]
												LEFT OUTER JOIN Verification
												ON [Profile].DocID = Verification.DocID
												LEFT OUTER JOIN NCB
												ON Verification.VerifyID = NCB.VerifyID
												LEFT OUTER JOIN LendingBranchs
												ON [Profile].BranchCode = LendingBranchs.BranchCode
												WHERE NOT Verification.EMSNo IS NULL
												$wheres_option
												AND RMProcess = 'Completed'
												$wheres
											) Datas
											LEFT OUTER JOIN (
											SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
											COUNT(LackList.VerifyID) AS MissingDocNum
											FROM LackList
											LEFT OUTER JOIN Verification
											ON LackList.VerifyID = Verification.VerifyID
											WHERE LackList.LackListActive = 'A'
											GROUP BY LackList.VerifyID, Verification.DocID
											) LackDocList
											ON Datas.DocID = LackDocList.DID
										) A
										WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
											
									return $result;
								
								} else {
								
									$result = $this->dbmodel->CIQuery("
										SELECT * FROM (
											SELECT *
											FROM (
												SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
												LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
												[Profile].Region, Verification.VerifyID, Verification.EMSNo,
												CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												END AS EMSDate, Verification.RMProcess,
												CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												END AS HQReceiveCADocDate,
												CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
												END AS CompletionDocDate,
												CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
												END AS SentToCADate,
												Verification.SentDocToCA, Verification.CompletionDoc,
												[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
											FROM [Profile]
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND RMProcess = 'Completed'
											AND [Profile].BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'
											$wheres
										) Datas
										LEFT OUTER JOIN (
										SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
										COUNT(LackList.VerifyID) AS MissingDocNum
										FROM LackList
										LEFT OUTER JOIN Verification
										ON LackList.VerifyID = Verification.VerifyID
										WHERE LackList.LackListActive = 'A'
										GROUP BY LackList.VerifyID, Verification.DocID
										) LackDocList
										ON Datas.DocID = LackDocList.DID
									) A
									WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
										
									return $result;
						
							}
								
								
							break;
							case $this->role_rm:
							
								$result = $this->dbmodel->CIQuery("
									SELECT * FROM (
										SELECT *
										FROM (
											SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
												LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
												[Profile].Region, Verification.VerifyID, Verification.EMSNo,
												CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												END AS EMSDate, Verification.RMProcess,
												CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												END AS HQReceiveCADocDate,
												CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
												END AS CompletionDocDate,
												CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
												END AS SentToCADate,
												Verification.SentDocToCA, Verification.CompletionDoc,
												[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
											FROM [Profile]
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND RMProcess = 'Completed'
											AND [Profile].RMName LIKE '%".$employees['data'][0]['FullnameTh']."%'
											$wheres
										) Datas
										LEFT OUTER JOIN (
										SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
										COUNT(LackList.VerifyID) AS MissingDocNum
										FROM LackList
										LEFT OUTER JOIN Verification
										ON LackList.VerifyID = Verification.VerifyID
										WHERE LackList.LackListActive = 'A'
										GROUP BY LackList.VerifyID, Verification.DocID
										) LackDocList
										ON Datas.DocID = LackDocList.DID
									) A
									WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
					
									return $result;
								
							break;
							case $this->role_am:
								
								$result = $this->dbmodel->CIQuery("
									SELECT * FROM (
										SELECT *
										FROM (
											SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
												LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
												[Profile].Region, Verification.VerifyID, Verification.EMSNo,
												CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
												END AS EMSDate, Verification.RMProcess,
												CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
												END AS HQReceiveCADocDate,
												CASE Verification.CompletionDocDate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
												END AS CompletionDocDate,
												CASE Verification.SentToCADate
												WHEN '1900-01-01' THEN NULL
												ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
												END AS SentToCADate,
												Verification.SentDocToCA, Verification.CompletionDoc,
												[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
											FROM [Profile]
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE NOT Verification.EMSNo IS NULL
											$wheres_option
											AND RMProcess = 'Completed'
											AND [Profile].BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' GROUP BY BranchCode)
											$wheres
										) Datas
										LEFT OUTER JOIN (
										SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
										COUNT(LackList.VerifyID) AS MissingDocNum
										FROM LackList
										LEFT OUTER JOIN Verification
										ON LackList.VerifyID = Verification.VerifyID
										WHERE LackList.LackListActive = 'A'
										GROUP BY LackList.VerifyID, Verification.DocID
										) LackDocList
										ON Datas.DocID = LackDocList.DID
									) A
									WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
							
								return $result;
								
								
							break;
							case $this->role_rd:
								
								$result = $this->dbmodel->CIQuery("
									SELECT * FROM (
										SELECT *
										FROM (
											SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID, [Profile].BranchCode,
											LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName,
											[Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											CASE Verification.CompletionDocDate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
											END AS CompletionDocDate,
											CASE Verification.SentToCADate
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
											END AS SentToCADate,
											Verification.SentDocToCA, Verification.CompletionDoc,
											[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE NOT Verification.EMSNo IS NULL
										$wheres_option
										AND RMProcess = 'Completed'
										AND [Profile].BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)
										$wheres
									) Datas
									LEFT OUTER JOIN (
									SELECT LackList.VerifyID AS VID, Verification.DocID AS DID,
									COUNT(LackList.VerifyID) AS MissingDocNum
									FROM LackList
									LEFT OUTER JOIN Verification
									ON LackList.VerifyID = Verification.VerifyID
									WHERE LackList.LackListActive = 'A'
									GROUP BY LackList.VerifyID, Verification.DocID
									) LackDocList
									ON Datas.DocID = LackDocList.DID
								) A
								WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
				
								return $result;
								
							break;
						}
					
						

					break;
					
					
					// RECONCILE: PART EMS PROCESS
					case 'recx':
					default:
						
						switch($privileges) {
							case $this->role_ad:
								
								if($empbranch == "000" || $empbranch == "901") {
									
									$result = $this->dbmodel->CIQuery("
											SELECT *
											FROM (  SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID,
											[Profile].BranchCode, LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile,
											[Profile].RMName, [Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
											FROM [Profile]
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE Verification.RMProcess = 'Completed'
											AND NOT Verification.EMSNo = ''
											$wheres_option
											AND Verification.HQReceiveCADocDate IS NULL
											$wheres
									) A
									WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
									
									return $result;
									
									
								} else {
									
									$result = $this->dbmodel->CIQuery("
											SELECT *
											FROM (  SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID,
											[Profile].BranchCode, LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile,
											[Profile].RMName, [Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
											FROM [Profile]
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE Verification.RMProcess = 'Completed'
											AND NOT Verification.EMSNo = ''
											$wheres_option
											AND [Profile].BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'
											$wheres
									) A
									WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
												
									return $result;
									
								}
								
							break;	
							case $this->role_bm:
							case $this->role_hq:
							case $this->role_spv:
							case $this->role_ads:
								
								if($empbranch == "000" || $empbranch == "901") {
								
									$result = $this->dbmodel->CIQuery("
										SELECT *
										FROM (SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID,
											[Profile].BranchCode, LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile,
											[Profile].RMName, [Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
											FROM [Profile]
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE Verification.RMProcess = 'Completed'
											AND NOT Verification.EMSNo = ''
											$wheres_option
											$wheres
									) A
									WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
									
									return $result;
								
								} else {
									
									$result = $this->dbmodel->CIQuery("
										SELECT *
										FROM (SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID,
											[Profile].BranchCode, LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile,
											[Profile].RMName, [Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
											FROM [Profile]
											LEFT OUTER JOIN Verification
											ON [Profile].DocID = Verification.DocID
											LEFT OUTER JOIN NCB
											ON Verification.VerifyID = NCB.VerifyID
											LEFT OUTER JOIN LendingBranchs
											ON [Profile].BranchCode = LendingBranchs.BranchCode
											WHERE Verification.RMProcess = 'Completed'
											AND NOT Verification.EMSNo = ''
											$wheres_option
											AND [Profile].BranchCode = '".str_pad($empbranch, 3, "0", STR_PAD_LEFT)."'
											$wheres
									) A
									WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
									
									return $result;
									
								}
								
								
							break;
							case $this->role_rm:
								
								$result = $this->dbmodel->CIQuery("
										SELECT *
										FROM (  SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID,
											[Profile].BranchCode, LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile,
											[Profile].RMName, [Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE Verification.RMProcess = 'Completed'
										AND NOT Verification.EMSNo = ''
										$wheres_option
										AND [Profile].RMName LIKE '%".$employees['data'][0]['FullnameTh']."%'
										$wheres
								) A
								WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
								
								return $result;
								
							break;
							case $this->role_am:
								
								$result = $this->dbmodel->CIQuery("
										SELECT *
										FROM (  SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID,
											[Profile].BranchCode, LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile,
											[Profile].RMName, [Profile].Region, Verification.VerifyID, Verification.EMSNo,
											CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
											END AS EMSDate, Verification.RMProcess,
											CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											WHEN '1900-01-01' THEN NULL
											ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
											END AS HQReceiveCADocDate,
											[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
											FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE Verification.RMProcess = 'Completed'
										AND NOT Verification.EMSNo = ''
										$wheres_option
										AND [Profile].BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$employees['data'][0]['EmployeeCode']."' GROUP BY BranchCode)
										$wheres
								) A
								WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
								
								return $result;
								
							break;
							case $this->role_rd:
								
								$result = $this->dbmodel->CIQuery("
										SELECT *
										FROM (  SELECT [Profile].DocID, NCB.MainLoanName, [Profile].OwnerName, [Profile].Telephone, [Profile].Mobile, LendingBranchs.RegionID,
										[Profile].BranchCode, LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile,
										[Profile].RMName, [Profile].Region, Verification.VerifyID, Verification.EMSNo,
										CASE CONVERT(nvarchar(10), Verification.EMSDate, 120)
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
										END AS EMSDate, Verification.RMProcess,
										CASE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
										WHEN '1900-01-01' THEN NULL
										ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
										END AS HQReceiveCADocDate,
										[Profile].OwnerType, ROW_NUMBER() OVER (ORDER BY $Ordering) as KeyPoint
										FROM [Profile]
										LEFT OUTER JOIN Verification
										ON [Profile].DocID = Verification.DocID
										LEFT OUTER JOIN NCB
										ON Verification.VerifyID = NCB.VerifyID
										LEFT OUTER JOIN LendingBranchs
										ON [Profile].BranchCode = LendingBranchs.BranchCode
										WHERE Verification.RMProcess = 'Completed'
										AND NOT Verification.EMSNo = ''
										$wheres_option
										AND [Profile].BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$employees['data'][0]['RegionID']."' GROUP BY BranchCode)
										$wheres
								) A
								WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
								
								return $result;
								
							break;
								
								
						}

					break;
			}
			
			
		}		
		
	} 
	
	protected static function setConditionQueryByPosition($authority, $set) {
		
		switch($authority) {
			case '074002':
				return "AND [Profile].RMName LIKE '%".$set."%'";
				
			break;
			case '074004':
				return "AND [Profile].BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$set."' GROUP BY BranchCode)";
				
			break;
			case '074005':
				return "AND [Profile].BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$set."' GROUP BY BranchCode)";
				
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