<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dbdashboard extends CI_Model {
	
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
		$this->load->database("dbprogress");
		
		$this->role_ad 						= $this->config->item('ROLE_ADMIN');
		$this->role_rm 						= $this->config->item('ROLE_RM');
		$this->role_bm 						= $this->config->item('ROLE_BM');
		$this->role_am 						= $this->config->item('ROLE_AM');
		$this->role_rd 						= $this->config->item('ROLE_RD');
		$this->role_hq 						= $this->config->item('ROLE_HQ');
		$this->role_spv 					= $this->config->item('ROLE_SPV');
		$this->role_ads 					= $this->config->item('ROLE_ADMINSYS');
	
		if(!is_resource($this->db->conn_id)) {
			$this->db->reconnect();
		}
		
		
	}
	
	// APP: Process Management
	private function dataTableDashboard($authority, $condition = array()){
		$this->load->model('dbdashboard');
		$this->load->library('effective');
	
		$wheres			= "WHERE NOT StartDate IS NULL";
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
		$stDate_start	= $this->input->post('stDate_start');
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
		
		$ncbdate_start  = !empty($ncb_start) ? $this->effective->StandartDateSorter($ncb_start):"";
		$ncbdate_end	= !empty($ncb_end) ? $this->effective->StandartDateSorter($ncb_end):"";
		$cadate_start   = !empty($dateca_start) ? $this->effective->StandartDateSorter($dateca_start):"";
		$cadate_end		= !empty($dateca_end) ? $this->effective->StandartDateSorter($dateca_end):"";
		$statusdate_st  = !empty($stDate_start) ? $this->effective->StandartDateSorter($stDate_start):"";
		$statusdate_ed	= !empty($stdate_end) ? $this->effective->StandartDateSorter($stdate_end):"";
		$dateplan_start = !empty($plandate_st) ? $this->effective->StandartDateSorter($plandate_st):"";
		$dateplan_end	= !empty($plandate_ed) ? $this->effective->StandartDateSorter($plandate_ed):"";
		$actualdate_st	= !empty($dddate_start) ? $this->effective->StandartDateSorter($dddate_start):"";
		$actualdate_ed	= !empty($dddate_end) ? $this->effective->StandartDateSorter($dddate_end):"";
		
		if(!empty($branchs[0])) {
			$where_brachs 	= "'".implode("','", $branchs)."'";
		} else {
			$where_brachs   = "";
		}
	
		switch($authority) {
			case $this->role_ad:
	
				if($condition[1] == "000" || $condition[1] == "901"):
				$wheres = ' ';
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
			SELECT
				DocID, SourceOfCustomer, StartDate, RMCode, RMName, OwnerName, MainLoanName, RegionID, RegionNameEng, BasicCriteria, CheckNCB,
				BrnSentNCBDate, BranchCode, Branch, BranchDigit, ProductCode, ProductName, ProductTypes, RequestLoan, RMProcess, HQReceiveCADocDate,
				SentToCADate, CAName, [Status], PreLoan, StatusDate, ApprovedLoan, PlanDrawdownDate, DrawdownDate, DrawdownBaht,
				ActionNote, ActiveRecord, KeyPoint
			FROM(SELECT	*, ROW_NUMBER() OVER (ORDER BY $Ordering) AS KeyPoint
				FROM(SELECT
						[Profile].DocID, [Profile].SourceOfCustomer,
						CASE NCB.CheckNCBDate
							WHEN '1900-01-01' THEN NULL
							ELSE CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) 
						END AS StartDate,  [Profile].RMCode, [Profile].RMName, Verification.BasicCriteria, NCB.CheckNCB, NCB.BrnSentNCBDate,
						[Profile].OwnerName, NCB.MainLoanName, [Profile].BranchCode, LendingBranchs.BranchDigit,
						[Profile].Branch, LendingBranchs.RegionID, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng, 
						Product.ProductCode, Product.ProductName, Product.ProductTypes, [Profile].RequestLoan,
						CASE Verification.HQReceiveCADocDate
							WHEN '1900-01-01' THEN NULL
							ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120) 
						END AS HQReceiveCADocDate,
						CASE Verification.RMProcess
							WHEN 'Completed' THEN 'CP'
							WHEN 'ยกเลิก โดย RM' THEN 'CR'
							WHEN 'ยกเลิก โดย ลูกค้า' THEN 'CC'
							ELSE 'AA'
						END AS RMProcess,
						CASE Verification.SentToCADate
							WHEN '1900-01-01' THEN NULL
							ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120) 
						END AS SentToCADate,
						ApplicationStatus.CAName,
						CASE ApplicationStatus.[Status]
						WHEN 'PENDING' THEN 'P'
						WHEN 'PREAPPROVED' THEN 'PA'
						WHEN 'APPROVED' THEN 'A'
						WHEN 'REJECT' THEN 'R'
						WHEN 'CANCEL' THEN 'C'
						WHEN 'CANCELBYRM' THEN 'C'
						WHEN 'CANCELBYCUS' THEN 'C'
						WHEN 'CANCELBYCA' THEN 'C'
						ELSE NULL
						END AS [Status],
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
						END AS ApprovedLoan,
						CASE CONVERT(nvarchar(10),  ApplicationStatus.PlanDrawdownDate, 120)
						WHEN '1900-01-01' THEN NULL
						ELSE CONVERT(nvarchar(10),  ApplicationStatus.PlanDrawdownDate, 120)
						END AS PlanDrawdownDate,
						CASE CONVERT(nvarchar(10), ApplicationStatus.DrawdownDate, 120)
						WHEN '1900-01-01' THEN NULL
						ELSE CONVERT(nvarchar(10), ApplicationStatus.DrawdownDate, 120)
						END AS DrawdownDate,
						CASE ApplicationStatus.DrawdownBaht
							WHEN '0' THEN NULL
							ELSE ApplicationStatus.DrawdownBaht
						END AS DrawdownBaht, Verification.ActionNote,
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
						ELSE 'Active'
						END AS ActiveRecord
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
					WHERE [Profile].IsActive = 'Y'
					AND BasicCriteria = '1'
					AND NCB.CheckNCB in ('1', '3')
					$where_addition
					$wheres_name
				) Inquiry
				$wheres
			) Datas
			WHERE KeyPoint > '".$start."' AND KeyPoint <= '".$offset."'");
	
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
	
		$rec_date_from   = $this->input->post('recdate_from');
		$rec_date_to     = $this->input->post('recdate_to');
	
		$miss_date_from  = $this->input->post('missdate_from');
		$miss_date_to    = $this->input->post('missdate_to');
	
		$returndate_from = $this->input->post('returndoc_from');
		$returndate_to   = $this->input->post('returndoc_to');
	
		$conv_recondate_1  = !empty($rec_date_from) ? $this->effective->StandartDateSorter($rec_date_from):"";
		$conv_recondate_2  = !empty($rec_date_to) ? $this->effective->StandartDateSorter($rec_date_to):"";
	
		$conv_missdate_1   = !empty($miss_date_from) ? $this->effective->StandartDateSorter($miss_date_from):"";
		$conv_missdate_2   = !empty($miss_date_to) ? $this->effective->StandartDateSorter($miss_date_to):"";
	
		if($views == "Active"):
		$field_submit2hq = 'SubmitDocToHQ';
		$field_app2ca 	 = 'CompletionDate';
		endif;
	
		if($views == "InActive"):
		$field_submit2hq = 'ReceivedDocFormLB';
		$field_app2ca 	 = 'AppToCA';
		endif;
	
	
		if(!empty($conv_recondate_1) && !empty($conv_missdate_2)) { $where_filter .= " AND CONVERT(nvarchar(10), $field_submit2hq, 120) BETWEEN '".$conv_recondate_1."' AND '".$conv_recondate_2."'"; }
		else {
	
			if(!empty($conv_recondate_1)) { $where_filter .= " AND CONVERT(nvarchar(10), $field_submit2hq, 120)  = '".$conv_recondate_1."'"; }
			if(!empty($conv_recondate_2)) { $where_filter .= " AND CONVERT(nvarchar(10), $field_submit2hq, 120)  = '".$conv_recondate_2."'"; }
	
		}
	
		if(!empty($conv_missdate_1) && !empty($conv_missdate_2)) { $where_filter .= " AND CONVERT(nvarchar(10), $field_app2ca, 120) BETWEEN '".$conv_missdate_1."' AND '".$conv_missdate_2."'"; }
		else {
	
			if(!empty($conv_missdate_1)) { $where_filter .= " AND CONVERT(nvarchar(10), $field_app2ca, 120)  = '".$conv_missdate_1."'"; }
			if(!empty($conv_missdate_2)) { $where_filter .= " AND CONVERT(nvarchar(10), $field_app2ca, 120)  = '".$conv_missdate_2."'"; }
	
		}
	
		if(!empty($returndate_from) && !empty($returndate_to)) { $where_filter .= " AND CONVERT(nvarchar(10), LBSubmitDocDate, 120) BETWEEN '".$returndate_from."' AND '".$returndate_to."'"; }
		else {
	
			if(!empty($returndate_from)) { $where_filter .= " AND CONVERT(nvarchar(10), LBSubmitDocDate, 120)  = '".$returndate_from."'"; }
			if(!empty($returndate_to)) { $where_filter .= " AND CONVERT(nvarchar(10), LBSubmitDocDate, 120)  = '".$returndate_to."'"; }
	
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