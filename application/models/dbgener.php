<?php 

class Dbgener extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database('dbgener');
		
	}
	
	
	
	public function getRequestReconcileNCB() {
		$this->load->library('effective');
		
		$startdate           		= $this->input->post('ncb_start');
		$enddate            	    = $this->input->post('ncb_end');
		$customers					= @iconv('UTF-8', 'TIS-620', $this->input->post('customer'));
		$rmname						= @iconv('UTF-8', 'TIS-620', $this->input->post('rmname'));
		$region						= $this->input->post('regions');
		$branchs					= $this->input->post('branchs');
		
		$createdate_start  			= !empty($startdate) ? $this->effective->StandartDateSorter($startdate):"";
		$createdate_end	   			= !empty($enddate) ? $this->effective->StandartDateSorter($enddate):"";
		
		$wheres = "";
		
		if(!empty($startdate) && !empty($enddate)) {
			$wheres .= " AND CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) BETWEEN '".$createdate_start."' AND '".$createdate_end."'";
		
		} else {
		
			if(!empty($startdate)) {
				$wheres .= " AND CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) = '".$createdate_start."'";
			}
		
			if(!empty($enddate)) {
				$wheres .= " AND CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) = '".$createdate_end."'";
			}
		
		}
		
		if(!empty($customers)) {
			$wheres .= " AND [Profile].OwnerName LIKE '%".$customers."%'";
		}
		
		if(!empty($rmname)) {
			$wheres .= " AND [Profile].RMName LIKE '%".$rmname."%'";
		}
		
		if(!empty($region)) {
			$wheres .= " AND LendingBranchs.RegionID = '".$region."'";
		}
		
		if(!empty($branchs)) {
			$wheres .= " AND [Profile].BranchCode = '".str_pad($branchs, 3, "0", STR_PAD_LEFT)."'";
		}
		
		$iStart = $this->input->post('start');
		$iLength = $this->input->post('length') ? $iLength = $this->input->post('length') : 10;
		
		$start	= ($iStart)? $iStart : 0;
		$offset = $iLength + $start;
		
		$Ordering = $this->get_ordering();
		
		$query = $this->db->query("
			SELECT *
			FROM (
					SELECT [Profile].DocID,
					[Profile].OwnerName, [Profile].Mobile, [Profile].BranchCode, LendingBranchs.RegionID,
					LendingBranchs.BranchDigit, [Profile].RMName, [Profile].RMMobile,
					MasterRegion.RegionNameEng, NCB.VerifyID, NCB.CheckNCB, 
					CASE NCB.CheckNCBDate
						WHEN '1900-01-01' THEN NULL
						ELSE CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)
					END AS CheckNCBDate,
					CASE NCB.BrnSentNCBDate
						WHEN '1900-01-01' THEN NULL
						ELSE CONVERT(nvarchar(10), NCB.BrnSentNCBDate, 120)
					END AS BrnSentNCBDate,
					CASE NCB.HQGetNCBDate
						WHEN '1900-01-01' THEN NULL
						ELSE CONVERT(nvarchar(10), NCB.HQGetNCBDate, 120)
					END AS HQGetNCBDate, Comments,
					CASE HQSentNCBToOperDate
						WHEN '1900-01-01' THEN NULL
						ELSE CONVERT(nvarchar(10), NCB.HQSentNCBToOperDate, 120)
					END AS HQSentNCBToOperDate,
					ROW_NUMBER() OVER (ORDER BY convert(nvarchar(10), NCB.CheckNCBDate, 120) DESC) AS KeyPoint
					FROM [Profile]
					LEFT OUTER JOIN LendingBranchs
					ON [Profile].BranchCode = LendingBranchs.BranchCode
					LEFT OUTER JOIN Verification
					ON [Profile].DocID = Verification.DocID
					LEFT OUTER JOIN MasterRegion
					ON LendingBranchs.RegionID = MasterRegion.RegionID
					LEFT OUTER JOIN NCB
					ON Verification.VerifyID = NCB.VerifyID
					WHERE NOT NCB.CheckNCB IN ('2', '0')
					AND NOT NCB.CheckNCBDate IS NULL
					AND NOT CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) = '1900-01-01'
					AND NCB.HQGetNCBDate IS NULL
					$wheres
			) A
			WHERE A.KeyPoint > '".$start."' AND A.KeyPoint <= '".$offset."'
			ORDER BY $Ordering");
		
		if($query->num_rows() > 0) {
			return array(
					'data' 		=> $query->result_array(),
					'status'	=> 'true'
			);
				
		} else {
			return array(
					'data' 		=> array(0),
					'status'	=> 'false'
			);
		}
		
		
	}
	
	public function getRequestReconcileNCBPagination() {
		$this->load->library('effective');
		
		$startdate           		= $this->input->post('ncb_start');
		$enddate            	    = $this->input->post('ncb_end');
		$customers					= @iconv('UTF-8', 'TIS-620', $this->input->post('customer'));
		$rmname						= @iconv('UTF-8', 'TIS-620', $this->input->post('rmname'));
		$region						= $this->input->post('regions');
		$branchs					= $this->input->post('branchs');
		
		$createdate_start  = !empty($startdate) ? $this->effective->StandartDateSorter($startdate):"";
		$createdate_end	   = !empty($enddate) ? $this->effective->StandartDateSorter($enddate):"";
		
		$wheres = "";
		
		if(!empty($startdate) && !empty($enddate)) {
			$wheres .= " AND CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) BETWEEN '".$createdate_start."' AND '".$createdate_end."'";
		
		} else {
		
			if(!empty($startdate)) {
				$wheres .= " AND CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) = '".$createdate_start."'";
			}
		
			if(!empty($enddate)) {
				$wheres .= " AND CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) = '".$createdate_end."'";
			}
		
		}
		
		if(!empty($customers)) {
			$wheres .= " AND [Profile].OwnerName LIKE '%".$customers."%'";
		}
		
		if(!empty($rmname)) {
			$wheres .= " AND [Profile].RMName LIKE '%".$rmname."%'";
		}
		
		if(!empty($region)) {
			$wheres .= " AND LendingBranchs.RegionID = '".$region."'";
		}
		
		if(!empty($branchs)) {
			$wheres .= " AND [Profile].BranchCode = '".str_pad($branchs, 3, "0", STR_PAD_LEFT)."'";
		}
		
		
		$query = $this->db->query("
			SELECT *
			FROM (
					SELECT [Profile].DocID,
					[Profile].OwnerName, [Profile].Mobile, [Profile].BranchCode, LendingBranchs.RegionID,
					LendingBranchs.BranchDigit, [Profile].RMName, [Profile].RMMobile,
					MasterRegion.RegionNameEng, NCB.VerifyID, NCB.CheckNCB, 
					CASE NCB.CheckNCBDate
						WHEN '1900-01-01' THEN null
						ELSE CONVERT(nvarchar(10), NCB.CheckNCBDate, 120)
					END AS CheckNCBDate,
					CASE NCB.BrnSentNCBDate
						WHEN '1900-01-01' THEN null
						ELSE CONVERT(nvarchar(10), NCB.BrnSentNCBDate, 120)
					END AS BrnSentNCBDate,
					CASE NCB.HQGetNCBDate
						WHEN '1900-01-01' THEN null
						ELSE CONVERT(nvarchar(10), NCB.HQGetNCBDate, 120)
					END AS HQGetNCBDate, Comments
					FROM [Profile]
					LEFT OUTER JOIN LendingBranchs
					ON [Profile].BranchCode = LendingBranchs.BranchCode
					LEFT OUTER JOIN Verification
					ON [Profile].DocID = Verification.DocID
					LEFT OUTER JOIN MasterRegion
					ON LendingBranchs.RegionID = MasterRegion.RegionID
					LEFT OUTER JOIN NCB
					ON Verification.VerifyID = NCB.VerifyID
					WHERE NOT NCB.CheckNCB IN ('2', '0')
					AND NOT NCB.CheckNCBDate IS NULL
					AND NOT CONVERT(nvarchar(10), NCB.CheckNCBDate, 120) = '1900-01-01'
					AND NCB.HQGetNCBDate IS NULL
					$wheres
			) A");
		
		return $query->num_rows();
		
	
	}
	
	public function getRequestReconcileDoc() {
		$this->load->library('effective');
		
		$startdate           		= $this->input->post('ncb_start');
		$enddate            	    = $this->input->post('ncb_end');
		$emsno						= $this->input->post('emsno');
		$customers					= @iconv('UTF-8', 'TIS-620', $this->input->post('customer'));
		$rmname						= @iconv('UTF-8', 'TIS-620', $this->input->post('rmname'));
		$region						= $this->input->post('regions');
		$branchs					= $this->input->post('branchs');
		
		$createdate_start  = !empty($startdate) ? $this->effective->StandartDateSorter($startdate):"";
		$createdate_end	   = !empty($enddate) ? $this->effective->StandartDateSorter($enddate):"";
		
		$wheres = "";
		
		if(!empty($startdate) && !empty($enddate)) {
			$wheres .= " AND CONVERT(nvarchar(10), Verification.EMSDate, 120) BETWEEN '".$createdate_start."' AND '".$createdate_end."'";
		
		} else {
		
			if(!empty($startdate)) {
				$wheres .= " AND CONVERT(nvarchar(10), Verification.EMSDate, 120) = '".$createdate_start."'";
			}
		
			if(!empty($enddate)) {
				$wheres .= " AND CONVERT(nvarchar(10), Verification.EMSDate, 120) = '".$createdate_end."'";
			}
		
		}
		
		if(!empty($emsno)) {
			$wheres .= " AND Verification.EMSNo = '".$emsno."'";
		}
		
		if(!empty($customers)) {
			$wheres .= " AND [Profile].OwnerName LIKE '%".$customers."%'";
		}
		
		if(!empty($rmname)) {
			$wheres .= " AND [Profile].RMName LIKE '%".$rmname."%'";
		}
		
		if(!empty($region)) {
			$wheres .= " AND LendingBranchs.RegionID = '".$region."'";
		}
		
		if(!empty($branchs)) {
			$wheres .= " AND [Profile].BranchCode = '".str_pad($branchs, 3, "0", STR_PAD_LEFT)."'";
		}
		
		
		$iStart = $this->input->post('start');
		$iLength = $this->input->post('length') ? $iLength = $this->input->post('length') : 10;
		
		$start	= ($iStart)? $iStart : 0;
		$offset = $iLength + $start;
		
		$Ordering = $this->get_ordering();
		
		$query = $this->db->query("
			SELECT *
			FROM(SELECT 
				CASE Verification.EMSDate
					WHEN '1900-01-01' THEN NULL
					ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
				END AS EMSDate, UPPER(Verification.EMSNo) AS EMSNo, 
				CASE Verification.HQReceiveCADocDate
					WHEN '1900-01-01' THEN NULL
					ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
				END AS HQReceiveCADocDate,
				[Profile].DocID, [Profile].OwnerName, [Profile].Mobile, [Profile].BranchCode, LendingBranchs.RegionID,
				MasterRegion.RegionNameEng, LendingBranchs.BranchDigit, [Profile].RMName, [Profile].RMMobile,
				ROW_NUMBER() OVER (ORDER BY convert(nvarchar(10), Verification.EMSDate, 120) DESC) AS KeyPoint
				FROM [Profile]
				LEFT OUTER JOIN Verification 
				ON [Profile].DocID = Verification.DocID
				LEFT OUTER JOIN LendingBranchs
				ON [Profile].BranchCode = LendingBranchs.BranchCode
				LEFT OUTER JOIN MasterRegion
				ON LendingBranchs.RegionID = MasterRegion.RegionID
				WHERE NOT Verification.EMSNo = ''
				AND Verification.HQReceiveCADocDate IS NULL
				$wheres
			)A
			WHERE A.KeyPoint > '".$start."' AND A.KeyPoint <= '".$offset."'
			ORDER BY $Ordering");
		
		if($query->num_rows() > 0) {
			return array(
					'data' 		=> $query->result_array(),
					'status'	=> 'true'
			);
				
		} else {
			return array(
					'data' 		=> array(0),
					'status'	=> 'false'
			);
		}
		
	}
	
	public function getRequestReconcileDocPagination() {
		$this->load->library('effective');
		
		$startdate           		= $this->input->post('ncb_start');
		$enddate            	    = $this->input->post('ncb_end');
		$emsno						= $this->input->post('emsno');
		$customers					= @iconv('UTF-8', 'TIS-620', $this->input->post('customer'));
		$rmname						= @iconv('UTF-8', 'TIS-620', $this->input->post('rmname'));
		$region						= $this->input->post('regions');
		$branchs					= $this->input->post('branchs');
		
		$createdate_start  = !empty($startdate) ? $this->effective->StandartDateSorter($startdate):"";
		$createdate_end	   = !empty($enddate) ? $this->effective->StandartDateSorter($enddate):"";
		
		$wheres = "";
		
		if(!empty($startdate) && !empty($enddate)) {
			$wheres .= " AND CONVERT(nvarchar(10), Verification.EMSDate, 120) BETWEEN '".$createdate_start."' AND '".$createdate_end."'";
		
		} else {
		
			if(!empty($startdate)) {
				$wheres .= " AND CONVERT(nvarchar(10), Verification.EMSDate, 120) = '".$createdate_start."'";
			}
		
			if(!empty($enddate)) {
				$wheres .= " AND CONVERT(nvarchar(10), Verification.EMSDate, 120) = '".$createdate_end."'";
			}
		
		}
		
		if(!empty($emsno)) {
			$wheres .= " AND Verification.EMSNo = '".$emsno."'";
		}
		
		
		if(!empty($customers)) {
			$wheres .= " AND [Profile].OwnerName LIKE '%".$customers."%'";
		}
		
		if(!empty($rmname)) {
			$wheres .= " AND [Profile].RMName LIKE '%".$rmname."%'";
		}
		
		if(!empty($region)) {
			$wheres .= " AND LendingBranchs.RegionID = '".$region."'";
		}
		
		if(!empty($branchs)) {
			$wheres .= " AND [Profile].BranchCode = '".str_pad($branchs, 3, "0", STR_PAD_LEFT)."'";
		}
		
	
	
		$query = $this->db->query("
			SELECT *	
			FROM(SELECT 
				CASE Verification.EMSDate
					WHEN '1900-01-01' THEN NULL
					ELSE CONVERT(nvarchar(10), Verification.EMSDate, 120)
				END AS EMSDate, UPPER(Verification.EMSNo) AS EMSNo, 
				CASE Verification.HQReceiveCADocDate
					WHEN '1900-01-01' THEN NULL
					ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
				END AS HQReceiveCADocDate,
				[Profile].DocID, [Profile].OwnerName, [Profile].Mobile, [Profile].BranchCode, [Profile].Region,
				LendingBranchs.RegionID, MasterRegion.RegionNameEng, LendingBranchs.BranchDigit, [Profile].RMName, [Profile].RMMobile,
				ROW_NUMBER() OVER (ORDER BY convert(nvarchar(10), Verification.EMSDate, 120) DESC) AS KeyPoint
				FROM [Profile]
				LEFT OUTER JOIN Verification 
				ON [Profile].DocID = Verification.DocID
				LEFT OUTER JOIN LendingBranchs
				ON [Profile].BranchCode = LendingBranchs.BranchCode
				LEFT OUTER JOIN MasterRegion
				ON LendingBranchs.RegionID = MasterRegion.RegionID
				WHERE NOT Verification.EMSNo = ''
				AND Verification.HQReceiveCADocDate IS NULL
				$wheres
			) A");
		
		return $query->num_rows();
	
	}
	
	public function getRequestCompletionDoc() {
		$this->load->library('effective');
		
		$startdate           		= $this->input->post('ncb_start');
		$enddate            	    = $this->input->post('ncb_end');
		$emsno						= $this->input->post('emsno');
		$customers					= @iconv('UTF-8', 'TIS-620', $this->input->post('customer'));
		$rmname						= @iconv('UTF-8', 'TIS-620', $this->input->post('rmname'));
		$region						= $this->input->post('regions');
		$branchs					= $this->input->post('branchs');
		
		$createdate_start  = !empty($startdate) ? $this->effective->StandartDateSorter($startdate):"";
		$createdate_end	   = !empty($enddate) ? $this->effective->StandartDateSorter($enddate):"";
		
		$wheres = "";
		
		if(!empty($startdate) && !empty($enddate)) {
			$wheres .= " AND CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120) BETWEEN '".$createdate_start."' AND '".$createdate_end."'";
		
		} else {
		
			if(!empty($startdate)) {
				$wheres .= " AND CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120) = '".$createdate_start."'";
			}
		
			if(!empty($enddate)) {
				$wheres .= " AND CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120) = '".$createdate_end."'";
			}
		
		}
		
		if(!empty($customers)) {
			$wheres .= " AND NCB.MainLoanName LIKE '%".$customers."%'";
		}
		
		if(!empty($rmname)) {
			$wheres .= " AND [Profile].RMName LIKE '%".$rmname."%'";
		}
		
		if(!empty($region)) {
			$wheres .= " AND LendingBranchs.RegionID = '".$region."'";
		}
		
		if(!empty($branchs)) {
			$wheres .= " AND [Profile].BranchCode = '".str_pad($branchs, 3, "0", STR_PAD_LEFT)."'";
		}
		
		$iStart = $this->input->post('start');
		$iLength = $this->input->post('length') ? $iLength = $this->input->post('length') : 10;
		
		$start	= ($iStart)? $iStart : 0;
		$offset = $iLength + $start;
		
		$Ordering = $this->get_ordering();
		
		$query = $this->db->query("
			SELECT	* 
			FROM (
					SELECT 
					[Profile].DocID, [Profile].OwnerName, NCB.MainLoanName, [Profile].Mobile, [Profile].BranchCode, 
					LendingBranchs.BranchDigit, [Profile].RMName, [Profile].RMMobile, [Profile].Region,
					LendingBranchs.RegionID, MasterRegion.RegionNameEng, Verification.VerifyID, 
					CASE Verification.HQReceiveCADocDate
						WHEN '1900-01-01' THEN null
						ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
					END AS HQReceiveCADocDate, Verification.SentDocToCA,
					CASE Verification.SentToCADate
						WHEN '1900-01-01' THEN null
						ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
					END AS SentToCADate, Verification.CompletionDoc, 
					CASE Verification.CompletionDocDate
						WHEN '1900-01-01' THEN null
						ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
					END AS CompletionDocDate,
					ROW_NUMBER() OVER (ORDER BY convert(nvarchar(10), Verification.HQReceiveCADocDate, 120) DESC) AS KeyPoint
					FROM [Profile]
					LEFT OUTER JOIN Verification
					ON [Profile].DocID = Verification.DocID
					LEFT OUTER JOIN LendingBranchs
					ON [Profile].BranchCode = LendingBranchs.BranchCode
					LEFT OUTER JOIN MasterRegion
					ON LendingBranchs.RegionID = MasterRegion.RegionID
					LEFT OUTER JOIN NCB
					ON Verification.VerifyID = NCB.VerifyID
					WHERE NCB.CheckNCB in ('1', '3')
					AND NOT Verification.HQReceiveCADocDate IS Null
					AND Verification.CompletionDoc IS Null
					$wheres
			) A	
			WHERE A.KeyPoint > '".$start."' AND A.KeyPoint <= '".$offset."'
			ORDER BY $Ordering
		");
		
		if($query->num_rows() > 0) {
			return array(
					'data' 		=> $query->result_array(),
					'status'	=> 'true'
			);
				
		} else {
			return array(
					'data' 		=> array(0),
					'status'	=> 'false'
			);
		}
	}
	
	public function getRequestCompletionDocPagination() {
		$this->load->library('effective');
		
		$startdate           		= $this->input->post('ncb_start');
		$enddate            	    = $this->input->post('ncb_end');
		$emsno						= $this->input->post('emsno');
		$customers					= @iconv('UTF-8', 'TIS-620', $this->input->post('customer'));
		$rmname						= @iconv('UTF-8', 'TIS-620', $this->input->post('rmname'));
		$region						= $this->input->post('regions');
		$branchs					= $this->input->post('branchs');
		
		$createdate_start  = !empty($startdate) ? $this->effective->StandartDateSorter($startdate):"";
		$createdate_end	   = !empty($enddate) ? $this->effective->StandartDateSorter($enddate):"";
		
		$wheres = "";
		
		if(!empty($startdate) && !empty($enddate)) {
			$wheres .= " AND CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120) BETWEEN '".$createdate_start."' AND '".$createdate_end."'";
		
		} else {
		
			if(!empty($startdate)) {
				$wheres .= " AND CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120) = '".$createdate_start."'";
			}
		
			if(!empty($enddate)) {
				$wheres .= " AND CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120) = '".$createdate_end."'";
			}
		
		}
		
		if(!empty($customers)) {
			$wheres .= " AND NCB.MainLoanName LIKE '%".$customers."%'";
		}
		
		if(!empty($rmname)) {
			$wheres .= " AND [Profile].RMName LIKE '%".$rmname."%'";
		}
		
		if(!empty($region)) {
			$wheres .= " AND LendingBranchs.RegionID = '".$region."'";
		}
		
		if(!empty($branchs)) {
			$wheres .= " AND [Profile].BranchCode = '".str_pad($branchs, 3, "0", STR_PAD_LEFT)."'";
		}
		
		$query = $this->db->query("
			SELECT	* 
			FROM (
					SELECT 
					[Profile].DocID, [Profile].OwnerName, NCB.MainLoanName, [Profile].Mobile, [Profile].BranchCode, 
					LendingBranchs.BranchDigit, [Profile].RMName, [Profile].RMMobile, [Profile].Region,
					LendingBranchs.RegionID, MasterRegion.RegionNameEng, Verification.VerifyID, 
					CASE Verification.HQReceiveCADocDate
						WHEN '1900-01-01' THEN null
						ELSE CONVERT(nvarchar(10), Verification.HQReceiveCADocDate, 120)
					END AS HQReceiveCADocDate, Verification.SentDocToCA,
					CASE Verification.SentToCADate
						WHEN '1900-01-01' THEN null
						ELSE CONVERT(nvarchar(10), Verification.SentToCADate, 120)
					END AS SentToCADate, Verification.CompletionDoc, 
					CASE Verification.CompletionDocDate
						WHEN '1900-01-01' THEN null
						ELSE CONVERT(nvarchar(10), Verification.CompletionDocDate, 120)
					END AS CompletionDocDate,
					ROW_NUMBER() OVER (ORDER BY convert(nvarchar(10), Verification.HQReceiveCADocDate, 120) DESC) AS KeyPoint
					FROM [Profile]
					LEFT OUTER JOIN Verification
					ON [Profile].DocID = Verification.DocID
					LEFT OUTER JOIN LendingBranchs
					ON [Profile].BranchCode = LendingBranchs.BranchCode
					LEFT OUTER JOIN MasterRegion
					ON LendingBranchs.RegionID = MasterRegion.RegionID
					INNER JOIN NCB
					ON Verification.VerifyID = NCB.VerifyID
					WHERE NCB.CheckNCB in ('1', '3')
					AND NOT Verification.HQReceiveCADocDate IS Null
					AND Verification.CompletionDoc IS Null
					$wheres
			) A	
		");
		
		return $query->num_rows();
		
	}
	
	public function getRequestReturnDoc() {
		$this->load->library('effective');
		
		$startdate           		= $this->input->post('ncb_start');
		$enddate            	    = $this->input->post('ncb_end');
		$emsno						= $this->input->post('emsno');
		$customers					= @iconv('UTF-8', 'TIS-620', $this->input->post('customer'));
		$rmname						= @iconv('UTF-8', 'TIS-620', $this->input->post('rmname'));
		$region						= $this->input->post('regions');
		$branchs					= $this->input->post('branchs');
		
		$createdate_start  = !empty($startdate) ? $this->effective->StandartDateSorter($startdate):"";
		$createdate_end	   = !empty($enddate) ? $this->effective->StandartDateSorter($enddate):"";
		
		$wheres = "";
		
		if(!empty($startdate) && !empty($enddate)) {
			$wheres .= " AND CONVERT(nvarchar(10), DocRefund.CreateDate, 120) BETWEEN '".$createdate_start."' AND '".$createdate_end."'";
		
		} else {
		
			if(!empty($startdate)) {
				$wheres .= " AND CONVERT(nvarchar(10), DocRefund.CreateDate, 120) = '".$createdate_start."'";
			}
		
			if(!empty($enddate)) {
				$wheres .= " AND CONVERT(nvarchar(10), DocRefund.CreateDate, 120) = '".$createdate_end."'";
			}
		
		}
		
		if(!empty($customers)) {
			$wheres .= " AND [Profile].OwnerName LIKE '%".$customers."%'";
		}
		
		if(!empty($rmname)) {
			$wheres .= " AND [Profile].RMName LIKE '%".$rmname."%'";
		}
		
		if(!empty($region)) {
			$wheres .= " AND LendingBranchs.RegionID = '".$region."'";
		}
		
		if(!empty($branchs)) {
			$wheres .= " AND [Profile].BranchCode = '".str_pad($branchs, 3, "0", STR_PAD_LEFT)."'";
		}
		
		$iStart = $this->input->post('start');
		$iLength = $this->input->post('length') ? $iLength = $this->input->post('length') : 10;
		
		$start	= ($iStart)? $iStart : 0;
		$offset = $iLength + $start;
		
		$Ordering = $this->get_ordering();
		
		$query = $this->db->query("
			SELECT * FROM (
				SELECT A.DocID, A.CountDocNo,
					[Profile].OwnerName, [Profile].Mobile, [Profile].BranchCode, MasterRegion.RegionNameEng,
					LendingBranchs.RegionID, LendingBranchs.BranchDigit, [Profile].RMName, [Profile].RMMobile,
					CASE DocRefund.CreateDate
						WHEN '1900-01-01' THEN ''
						ELSE CONVERT(nvarchar(10), DocRefund.CreateDate, 120)
					END AS CreateDate, DocRefund.CreateBy,
					CASE DocRefund.HQGetDocDate
						WHEN '1900-01-01' THEN ''
						ELSE CONVERT(nvarchar(10), DocRefund.HQGetDocDate, 120)
					END AS HQGetDocDate,
					CASE DocRefund.HQGetDocFromCADate
						WHEN '1900-01-01' THEN ''
						ELSE CONVERT(nvarchar(10), DocRefund.HQGetDocFromCADate, 120)
					END AS HQGetDocFromCADate,
					CASE DocRefund.BranchGetDocDate
						WHEN '1900-01-01' THEN ''
						ELSE CONVERT(nvarchar(10), DocRefund.BranchGetDocDate, 120)
					END AS BranchGetDocDate,
					ROW_NUMBER() OVER (ORDER BY convert(nvarchar(10), DocRefund.DocID, 120) DESC) AS KeyPoint
				FROM (SELECT DocID, COUNT(DocRefund.DocNo) AS CountDocNo
					  FROM  DocRefund
					  WHERE NOT DocRefund.DocNo IS NULL
					  GROUP BY DocRefund.DocID
				) A
				LEFT OUTER JOIN [Profile]
				ON A.DocID = [Profile].DocID 
				LEFT OUTER JOIN LendingBranchs
				ON [Profile].BranchCode = LendingBranchs.BranchCode
				LEFT OUTER JOIN MasterRegion
				ON LendingBranchs.RegionID = MasterRegion.RegionID
				LEFT OUTER JOIN DocRefund
				ON [Profile].DocID = DocRefund.DocID AND DocRefund.DocNO = '1' 
				WHERE NOT DocRefund.DocNo IS NULL
				$wheres
			) Data
			WHERE Data.KeyPoint > '".$start."' AND Data.KeyPoint <= '".$offset."'
			ORDER BY $Ordering
		");
		
		if($query->num_rows() > 0) {
			return array(
					'data' 		=> $query->result_array(),
					'status'	=> 'true'
			);
		
		} else {
			return array(
					'data' 		=> array(0),
					'status'	=> 'false'
			);
		}
		
	}
	
	public function getRequestReturnDocPagination() {
		$this->load->library('effective');
		
		$startdate           		= $this->input->post('ncb_start');
		$enddate            	    = $this->input->post('ncb_end');
		$emsno						= $this->input->post('emsno');
		$customers					= @iconv('UTF-8', 'TIS-620', $this->input->post('customer'));
		$rmname						= @iconv('UTF-8', 'TIS-620', $this->input->post('rmname'));
		$region						= $this->input->post('regions');
		$branchs					= $this->input->post('branchs');
		
		$createdate_start  = !empty($startdate) ? $this->effective->StandartDateSorter($startdate):"";
		$createdate_end	   = !empty($enddate) ? $this->effective->StandartDateSorter($enddate):"";
		
		$wheres = "";
		
		if(!empty($startdate) && !empty($enddate)) {
			$wheres .= " AND CONVERT(nvarchar(10), DocRefund.CreateDate, 120) BETWEEN '".$createdate_start."' AND '".$createdate_end."'";
		
		} else {
		
			if(!empty($startdate)) {
				$wheres .= " AND CONVERT(nvarchar(10), DocRefund.CreateDate, 120) = '".$createdate_start."'";
			}
		
			if(!empty($enddate)) {
				$wheres .= " AND CONVERT(nvarchar(10), DocRefund.CreateDate, 120) = '".$createdate_end."'";
			}
		
		}
		
		if(!empty($customers)) {
			$wheres .= " AND [Profile].OwnerName LIKE '%".$customers."%'";
		}
		
		if(!empty($rmname)) {
			$wheres .= " AND [Profile].RMName LIKE '%".$rmname."%'";
		}
		
		if(!empty($region)) {
			$wheres .= " AND LendingBranchs.RegionID = '".$region."'";
		}
		
		if(!empty($branchs)) {
			$wheres .= " AND [Profile].BranchCode = '".str_pad($branchs, 3, "0", STR_PAD_LEFT)."'";
		}
		
		
		$query = $this->db->query("
			SELECT A.DocID, A.CountDocNo,
				[Profile].OwnerName, [Profile].Mobile, [Profile].BranchCode, MasterRegion.RegionNameEng,
				LendingBranchs.RegionID, LendingBranchs.BranchDigit, [Profile].RMName, [Profile].RMMobile,
				CASE DocRefund.CreateDate
					WHEN '1900-01-01' THEN ''
					ELSE CONVERT(nvarchar(10), DocRefund.CreateDate, 120)
				END AS CreateDate, DocRefund.CreateBy,
				CASE DocRefund.HQGetDocDate
					WHEN '1900-01-01' THEN ''
					ELSE CONVERT(nvarchar(10), DocRefund.HQGetDocDate, 120)
				END AS HQGetDocDate,
				CASE DocRefund.HQGetDocFromCADate
					WHEN '1900-01-01' THEN ''
					ELSE CONVERT(nvarchar(10), DocRefund.HQGetDocFromCADate, 120)
				END AS HQGetDocFromCADate,
				CASE DocRefund.BranchGetDocDate
					WHEN '1900-01-01' THEN ''
					ELSE CONVERT(nvarchar(10), DocRefund.BranchGetDocDate, 120)
				END AS BranchGetDocDate,
				ROW_NUMBER() OVER (ORDER BY convert(nvarchar(10), DocRefund.DocID, 120) DESC) AS KeyPoint
			FROM (SELECT DocID, COUNT(DocRefund.DocNo) AS CountDocNo
				  FROM  DocRefund
				  WHERE NOT DocRefund.DocNo IS NULL
				  GROUP BY DocRefund.DocID
			) A
			LEFT OUTER JOIN [Profile]
			ON A.DocID = [Profile].DocID 
			LEFT OUTER JOIN LendingBranchs
			ON [Profile].BranchCode = LendingBranchs.BranchCode
			LEFT OUTER JOIN MasterRegion
			ON LendingBranchs.RegionID = MasterRegion.RegionID
			LEFT OUTER JOIN DocRefund
			ON [Profile].DocID = DocRefund.DocID AND DocRefund.DocNO = '1' 
			WHERE NOT DocRefund.DocNo IS NULL
			$wheres
		");
		
		return $query->num_rows();
		
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