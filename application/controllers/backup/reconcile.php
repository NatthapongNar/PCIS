<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reconcile extends MY_Controller {
	
	// Variable Path
	public $pages_default;
	public $pages_customiz;
	
	public function __construct() {
		parent::__construct();
	
		$this->pages_default	= "frontend/metro";
		$this->pages_customiz	= "frontend/content/pages/";
	
		$this->sessid       = $this->session->userdata("session_id");
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
	
		$this->data['session_data'] = array(
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
				"auth"       => $this->authorized
		);
	
		if(empty($this->authorized[0])):
		redirect('authen/logout');
		endif;
	
	}
	
	// NAV ROUTER
	public function vwNCBConsentManagement() {
		$this->load->model('dbmodel');
		$this->load->model('dbprogress');
			
		$this->data['AreaRegion']		= $this->dbmodel->loadData($this->table_region, 'RegionID, RegionNameEng', array("RegionNameEng !=" => "BKK - HQ"));
		$this->data['AreaBoundary']		= $this->dbprogress->appProgressBranch($this->authorized, array($this->emp_id));
			
		$this->pages  = "doc_management/doc_ncbconsent";
		$this->load->view($this->pages_customiz.$this->pages, $this->data);
	
	}
	
	public function vwAppManagement() {
		$this->load->model('dbmodel');
		$this->load->model('dbprogress');
		
		$this->data['AreaRegion']		= $this->dbmodel->loadData($this->table_region, 'RegionID, RegionNameEng', array("RegionNameEng !=" => "BKK - HQ"));
		$this->data['AreaBoundary']		= $this->dbprogress->appProgressBranch($this->authorized, array($this->emp_id));
			
		$this->pages  = "doc_management/doc_appmanagement";
		$this->load->view($this->pages_customiz.$this->pages, $this->data);
		
	}
	
	private static function json_parse($objArr) {
		//header("Content-Type: application/json");
		echo json_encode($objArr);
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
	
	public static function setNumColorLightStatus($nums) {
		if($nums <= 10) {
			return '<div class="fg-emerald">'.$nums.'</div>';
	
		} else if($nums >= 11 && $nums <= 20) {
			return '<div class="fg-amber">'.$nums.'</div>';
			 
		} else if($nums >= 21) {
			return '<div class="fg-red">'.$nums.'</div>';
	
		}
	
	}
	
	public static function setCheckNCB($ncb_checker) {
		
		if(empty($ncb_checker)){
			return '';
		} else {
			if($ncb_checker == 1 || $ncb_checker == 3):
				return '<i class="fa fa-circle fg-green" style="font-size: 1.5em; cursor: pointer;"></i>';
			else:
				return '<i class="fa fa-circle" style="font-size: 1.5em; cursor: pointer; color: #666666;"></i>';
			endif;
		}
		
	}
	
	private function limitCountDays($nums) {
		
		if($nums > 99):
			return 99;
		else:
			return $nums;
		endif;	
	
	}
	
	public static function setIconBorrwerLoanType($types) {
		
		if(empty($types)) :
			return '';
		else :
			
			switch ($types) {
				case '101':
					//return '<abbr title="ผู้กู้หลัก" style="border: 0px;"><i class="icon-user-3 fg-lightBlue" style="font-size: 1.5em; cursor: pointer;"></i></abbr>';
					return 'ผู้กู้หลัก';
				break;
				case '102':
					//return '<abbr title="ผู้กู้ร่วม" style="border: 0px;"><i class="fa fa-slideshare fg-lightBlue" style="font-size: 1.5em; cursor: pointer;"></i></abbr>';
					return 'ผู้กู้ร่วม';
				break;
				case '103':
					//return '<abbr title="ผู้ค้ำ" style="border: 0px;"><i class="fa fa-group fg-lightBlue" style="font-size: 1.5em; cursor: pointer;"></i></abbr>';
					return 'ผู้ค้ำ';
				break;
				case '104':
					//return '<abbr title="นิติบุคคล" style="border: 0px;"><i class="fa fa-institution fg-lightBlue" style="font-size: 1.5em; cursor: pointer;"></i></abbr>';
					return 'นิติบุคคล';
				break;
				
			}
		
		endif;
		
	} 
	
	public static function lightState($retuns, $date) {
		
		if(empty($retuns)) {
			return '';
			
		} else {
			
			if($retuns == 'N'):
				//return '<i class="fa fa-circle" style="font-size: 1.5em; color: #666666; cursor: pointer;"></i>';
				return '';
			else:
				return '<abbr title="'.$date.'" style="border: 0px;"><i class="fa fa-circle fg-red" style="font-size: 1.5em; cursor: pointer;"></i></abbr>';
			endif;
			
		}
		
	}

	public static function lightNCBMonitor($ncbdate, $lbsent, $hqget, $tooper) {
		
		if(!empty($ncbdate) && empty($lbsent) && empty($hqget) && empty($tooper)) {
			return '<i class="fa fa-circle" style="font-size: 1.5em; cursor: pointer; color: #666666;"></i>';
			
		} else if(!empty($ncbdate) && !empty($lbsent) && empty($hqget) && empty($tooper)) {
			return '<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i>';
			
		} else if(!empty($ncbdate) && !empty($lbsent) && !empty($hqget)  && empty($tooper)) {
			return '<i class="fa fa-circle fg-lightBlue" style="font-size: 1.5em; cursor: pointer;"></i>';
			
		} else if(!empty($ncbdate) && !empty($lbsent) && !empty($hqget) && !empty($tooper)) {
			return '<i class="fa fa-circle fg-green" style="font-size: 1.5em; cursor: pointer;"></i>';
			
		} else {
			return '';
			
		}
	
	}
	
	public function getDataNCBConsent() {
		header("Content-Type: application/json");
		
		$this->load->model('dbmanagement');
		$this->load->library('effective');
	
		try {
			
			$results = $this->dbmanagement->getDataNCBConsent($this->authorized, array($this->emp_id));
			$iTotal  = 0;//;$this->dbmanagement->getDataNCBConsentPagination($this->authorized, array($this->emp_id));
			
			foreach($results['data'] as $index => $value) {
			
				$day_diff = self::compare_date(array('begin'=> $results['data'][$index]['NCBCheckDate'], 'end'=> !empty($results['data'][$index]['HQSubmitToOper']) ? $results['data'][$index]['HQSubmitToOper']:date('Y-m-d')));
				if($day_diff > 99) {
					$days = 99;
						
				} else {
					$days = $day_diff;
						
				}
				
				$columns[] = array(
						"DocID"			 	=> $results['data'][$index]['DocID'],
						"NCBCheckDate" 	 	=> !empty($results['data'][$index]['NCBCheckDate']) ? $this->effective->StandartDateRollback($results['data'][$index]['NCBCheckDate']):"",
						"DAY"			 	=> self::setNumColorLightStatus(self::limitCountDays($days)),
						"NCBCheck"		 	=> self::lightNCBMonitor($results['data'][$index]['NCBCheck'], $results['data'][$index]['SubmitToHQ'], $results['data'][$index]['HQReceivedFromLB'], $results['data'][$index]['HQSubmitToOper']),
						"SubmitToHQ"  		=> $this->effective->StandartDateRollback($results['data'][$index]['SubmitToHQ']),
						"HQReceivedFromLB"  => $this->effective->StandartDateRollback($results['data'][$index]['HQReceivedFromLB']),
						"HQSubmitToOper"	=> $this->effective->StandartDateRollback($results['data'][$index]['HQSubmitToOper']),
						"OperReturn"		=> self::lightState($results['data'][$index]['OperReturn'], $this->effective->StandartDateRollback($results['data'][$index]['OperReturnDate'])),
						"BranchDigit"	 	=> $results['data'][$index]['BranchDigit'],
						"BorrowerType"	 	=> self::setIconBorrwerLoanType($results['data'][$index]['BorrowerType']),
						"BorrowerName"		=> '<abbr title="Phone : '.$results['data'][$index]['Mobile'].'" style="border:none;">'.@iconv('TIS-620', 'UTF-8', $results['data'][$index]['BorrowerName']).'</abbr>',
						"RMName"		 	=> '<abbr title="Phone : '.$results['data'][$index]['RMMobile'].'" style="border:none;">'.@iconv('TIS-620', 'UTF-8', $results['data'][$index]['RMName']).'</abbr>'
				);
			
			}
			
			
			$sOutput = array(
					'draw'                => intval($this->input->post('draw')) ? intval($this->input->post('draw')) : 0,
					'recordsTotal'        => $iTotal,
					'recordsFiltered'     => $iTotal,
					'data'                => $columns
			);
			
			self::json_parse($sOutput);
			
		} catch(Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
			
		}	
	
	}
	
	// APP CONTROLLER 
 	public static function fnDocRouter($mode) {
    	if(empty($mode)) :
    		throw new Exception('Error handled, Please you are check argusment.');
    		
    	else:
    	
    		switch ($mode) {
    			
    			case 'r2cx': return 'reconcile'; break;
    			case 'm2cx': return 'missing'; break; 
    			case 'r2cl': return 'returndoc'; break; 
    			case 'a2lx': return 'allviews'; break;
    			
    		}
    	
    	endif;
    	
    }
    
    static function iconLogisticTitle($logistic) {
    	
    	switch ($logistic) {
    		case 301:
    			return '<i class="fa fa-envelope fg-lightBlue" style="font-size: 1.5em; cursor: pointer;"></i>';
    			
    		break;
    		case 302:
    			return '<i class="fa fa-motorcycle fg-lightBlue" style="font-size: 1.5em; cursor: pointer;"></i>';
    			
    		break;
    		case 303:
    			return '<i class="fa fa-user fg-lightBlue" style="font-size: 1.5em; cursor: pointer;"></i>';
    			
    		break;
    		
    	}

    }
    
    private static function getDocManageSLA($mode, $Dates = array()) {
	 
    	if($Dates[0] != "" && $Dates[1] != ""): 
    		return self::compare_date(array('begin'=> $Dates[0], 'end'=> $Dates[1]));
    	else: 
    		return self::compare_date(array('begin'=> $Dates[0], 'end'=> date('Y-m-d')));
    	endif;
    	 
    }
    
	public function getAppController() {
		
		$this->load->model('dbmanagement');
		$this->load->library('effective');
		
		$draft = $this->input->post('slmode');
		$mode  = self::fnDocRouter($draft);
		
		$results = $this->dbmanagement->loadAppManagement($mode, $this->authorized, array($this->emp_id));
		$iTotal	 = $this->dbmanagement->loadAppManagementPagination($mode, $this->authorized, array($this->emp_id));
				
		try {
			
			switch($mode) {
				
				case 'reconcile':
					
					foreach($results['data'] as $index => $value) {
					
						$columns[] = array(
							"DocID" 			 => $results['data'][$index]['DocID'],
							"LogisticCode" 		 => self::iconLogisticTitle($results['data'][$index]['LogisticCode']),
							"SubmitDocToHQ" 	 => $this->effective->StandartDateRollback($results['data'][$index]['SubmitDocToHQ']),
							"LogisticDay" 		 => self::setNumColorLightStatus(self::limitCountDays(self::getDocManageSLA($mode, array($results['data'][$index]['SubmitDocToHQ'], $results['data'][$index]['ReceivedDocFormLB'])))),
							"LogisticStatus"	 => self::fnIconMonitorLightState($mode, array($results['data'][$index]['SubmitDocToHQ'], $results['data'][$index]['ReceivedDocFormLB'])),
							"AppToCA"		 	 => null,
							"LackNums" 	 		 => null,
							"CompletionDay"	 	 => null,
							"CompletionState"	 => null,
							"ReturnDate"		 => null,
							"ReturnNum" 		 => null,
							"ReturnDay" 		 => null,
							"ReturnState"	     => null,
							"NCBCheck"		 	 => self::setCheckNCB($results['data'][$index]['NCBCheck']),
							"BranchDigit"    	 => '<abbr title="Phone : " style="border:none;">'.$results['data'][$index]['BranchDigit'].'</abbr>',
							"BorrowerType"	 	 => self::setIconBorrwerLoanType($results['data'][$index]['BorrowerType']),
							"BorrowerName"       => !empty($results['data'][$index]['BorrowerName']) ? '<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.(iconv('TIS-620', 'UTF-8', $results['data'][$index]['BorrowerName'])).'</abbr>':'<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.(iconv('TIS-620', 'UTF-8', $results['data'][$index]['OwnerName'])).'</abbr>',
							"RMName"	    	 => '<abbr title="Phone : '.$results['data'][$index]['RMMobile'].'" style="border:none;">'.iconv('TIS-620', 'UTF-8', $results['data'][$index]['RMName']).'</abbr>'
						);
					}
				
					
				break;
				case 'missing':
					
					foreach($results['data'] as $index => $value) {
							
						$columns[] = array(
								"DocID" 			 => $results['data'][$index]['DocID'],
								"LogisticCode" 		 => self::iconLogisticTitle($results['data'][$index]['LogisticCode']),
								"SubmitDocToHQ" 	 => $this->effective->StandartDateRollback($results['data'][$index]['SubmitDocToHQ']),
								"LogisticDay" 		 => self::setNumColorLightStatus(self::limitCountDays(self::getDocManageSLA($mode, array($results['data'][$index]['SubmitDocToHQ'], $results['data'][$index]['ReceivedDocFormLB'])))),
								"LogisticStatus"	 => self::fnIconMonitorLightState($mode, array($results['data'][$index]['SubmitDocToHQ'], $results['data'][$index]['ReceivedDocFormLB'], 'Z1')),
								
								"AppToCA"	 	 	 => $this->effective->StandartDateRollback(!empty($results['data'][$index]['AppToCA']) ? $results['data'][$index]['AppToCA']:$results['data'][$index]['CompletionDate']),
								"LackNums" 	 		 => $results['data'][$index]['LackNums'],
								"CompletionDay"	 	 => self::setNumColorLightStatus(self::limitCountDays(self::getDocManageSLA($mode, array($results['data'][$index]['ReceivedDocFormLB'], !empty($results['data'][$index]['AppToCA']) ? $results['data'][$index]['AppToCA']:$results['data'][$index]['CompletionDate'])))),
								"CompletionState"	 => self::fnIconMonitorLightState($mode, array($results['data'][$index]['ReceivedDocFormLB'],  array("CompletionDocDate" => $results['data'][$index]['CompletionDate'], "SentToCADate" => $results['data'][$index]['AppToCA']), 'Z2', $results['data'][$index]['CompletionDoc'], $results['data'][$index]['AppToCA'])),
								
								"ReturnDate"		 => null,
								"ReturnNum" 		 => null,
								"ReturnDay" 		 => null,
								"ReturnState"	     => null,
								"NCBCheck"		 	 => self::setCheckNCB($results['data'][$index]['NCBCheck']),
								"BranchDigit"    	 => '<abbr title="Phone : " style="border:none;">'.$results['data'][$index]['BranchDigit'].'</abbr>',
								"BorrowerType"	 	 => self::setIconBorrwerLoanType($results['data'][$index]['BorrowerType']),
								"BorrowerName"       => !empty($results['data'][$index]['BorrowerName']) ? '<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.(iconv('TIS-620', 'UTF-8', $results['data'][$index]['BorrowerName'])).'</abbr>':'<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.(iconv('TIS-620', 'UTF-8', $results['data'][$index]['OwnerName'])).'</abbr>',
								"RMName"	    	 => '<abbr title="Phone : '.$results['data'][$index]['RMMobile'].'" style="border:none;">'.iconv('TIS-620', 'UTF-8', $results['data'][$index]['RMName']).'</abbr>'
						);
					}
					
				break;
				case 'returndoc':
						
					foreach($results['data'] as $index => $value) {
					
						$columns[] = array(
								"DocID" 			 => $results['data'][$index]['DocID'],
								"LogisticCode" 		 => self::iconLogisticTitle($results['data'][$index]['LogisticCode']),
								"SubmitDocToHQ" 	 => $this->effective->StandartDateRollback($results['data'][$index]['SubmitDocToHQ']),
								"LogisticDay" 		 => self::setNumColorLightStatus(self::limitCountDays(self::getDocManageSLA($mode, array($results['data'][$index]['SubmitDocToHQ'], $results['data'][$index]['ReceivedDocFormLB'])))),
								"LogisticStatus"	 => self::fnIconMonitorLightState($mode, array($results['data'][$index]['SubmitDocToHQ'], $results['data'][$index]['ReceivedDocFormLB'], 'Z1')),
								
								"AppToCA"	 	 	 => $this->effective->StandartDateRollback(!empty($results['data'][$index]['AppToCA']) ? $results['data'][$index]['AppToCA']:$results['data'][$index]['CompletionDate']),
								"LackNums" 	 		 => $results['data'][$index]['LackNums'],
								"CompletionDay"	 	 => self::setNumColorLightStatus(self::limitCountDays(self::getDocManageSLA($mode, array($results['data'][$index]['ReceivedDocFormLB'], !empty($results['data'][$index]['AppToCA']) ? $results['data'][$index]['AppToCA']:$results['data'][$index]['CompletionDate'])))),
								"CompletionState"	 => self::fnIconMonitorLightState($mode, array($results['data'][$index]['ReceivedDocFormLB'],  array("CompletionDocDate" => $results['data'][$index]['CompletionDate'], "SentToCADate" => $results['data'][$index]['AppToCA']), 'Z2', $results['data'][$index]['CompletionDoc'], $results['data'][$index]['AppToCA'])),
								
								"ReturnDate"		 => $this->effective->StandartDateRollback($this->fnArsortDateInReconcileDoc($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'])),
								"ReturnNum" 		 => $results['data'][$index]['ReturnNums'],
								"ReturnDay" 		 => self::setNumColorLightStatus(self::limitCountDays(self::getDocManageSLA($mode, array($results['data'][$index]['LBSubmitDocDate'], $results['data'][$index]['BranchReceivedDate'])))),
								"ReturnState"	     => $this->fnLeepLighterChange($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R'),
								
								"NCBCheck"		 	 => self::setCheckNCB($results['data'][$index]['NCBCheck']),
								"BranchDigit"    	 => '<abbr title="Phone : " style="border:none;">'.$results['data'][$index]['BranchDigit'].'</abbr>',
								"BorrowerType"	 	 => self::setIconBorrwerLoanType($results['data'][$index]['BorrowerType']),
								"BorrowerName"       => !empty($results['data'][$index]['BorrowerName']) ? '<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.(iconv('TIS-620', 'UTF-8', $results['data'][$index]['BorrowerName'])).'</abbr>':'<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.(iconv('TIS-620', 'UTF-8', $results['data'][$index]['OwnerName'])).'</abbr>',
								"RMName"	    	 => '<abbr title="Phone : '.$results['data'][$index]['RMMobile'].'" style="border:none;">'.iconv('TIS-620', 'UTF-8', $results['data'][$index]['RMName']).'</abbr>'
						);
					}
						
				break;
				case 'allviews':
					
					foreach($results['data'] as $index => $value) {
							
						$columns[] = array(
								"DocID" 			 => $results['data'][$index]['DocID'],
								"LogisticCode" 		 => self::iconLogisticTitle($results['data'][$index]['LogisticCode']),
								"SubmitDocToHQ" 	 => $this->effective->StandartDateRollback($results['data'][$index]['SubmitDocToHQ']),
								"LogisticDay" 		 => self::setNumColorLightStatus(self::limitCountDays(self::getDocManageSLA($mode, array($results['data'][$index]['SubmitDocToHQ'], $results['data'][$index]['ReceivedDocFormLB'])))),
								"LogisticStatus"	 => self::fnIconMonitorLightState($mode, array($results['data'][$index]['SubmitDocToHQ'], $results['data'][$index]['ReceivedDocFormLB'], 'Z1')),
					
								"AppToCA"	 	 	 => $this->effective->StandartDateRollback(!empty($results['data'][$index]['AppToCA']) ? $results['data'][$index]['AppToCA']:$results['data'][$index]['CompletionDate']),
								"LackNums" 	 		 => $results['data'][$index]['LackNums'],
								"CompletionDay"	 	 => self::setNumColorLightStatus(self::limitCountDays(self::getDocManageSLA($mode, array($results['data'][$index]['ReceivedDocFormLB'], !empty($results['data'][$index]['AppToCA']) ? $results['data'][$index]['AppToCA']:$results['data'][$index]['CompletionDate'])))),
								"CompletionState"	 => self::fnIconMonitorLightState($mode, array($results['data'][$index]['ReceivedDocFormLB'],  array("CompletionDocDate" => $results['data'][$index]['CompletionDate'], "SentToCADate" => $results['data'][$index]['AppToCA']), 'Z2', $results['data'][$index]['CompletionDoc'], $results['data'][$index]['AppToCA'])),
					
								"ReturnDate"		 => $this->effective->StandartDateRollback($this->fnArsortDateInReconcileDoc($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'])),
								"ReturnNum" 		 => $results['data'][$index]['ReturnNums'],
								"ReturnDay" 		 => self::setNumColorLightStatus(self::limitCountDays(self::getDocManageSLA($mode, array($results['data'][$index]['LBSubmitDocDate'], $results['data'][$index]['BranchReceivedDate'])))),
								"ReturnState"	     => $this->fnLeepLighterChange($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R'),
					
								"NCBCheck"		 	 => self::setCheckNCB($results['data'][$index]['NCBCheck']),
								"BranchDigit"    	 => '<abbr title="Phone : " style="border:none;">'.$results['data'][$index]['BranchDigit'].'</abbr>',
								"BorrowerType"	 	 => self::setIconBorrwerLoanType($results['data'][$index]['BorrowerType']),
								"BorrowerName"       => !empty($results['data'][$index]['BorrowerName']) ? '<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.(iconv('TIS-620', 'UTF-8', $results['data'][$index]['BorrowerName'])).'</abbr>':'<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.(iconv('TIS-620', 'UTF-8', $results['data'][$index]['OwnerName'])).'</abbr>',
								"RMName"	    	 => '<abbr title="Phone : '.$results['data'][$index]['RMMobile'].'" style="border:none;">'.iconv('TIS-620', 'UTF-8', $results['data'][$index]['RMName']).'</abbr>'
						);
					}
						
				break;
				
			}
			
			$sOutput = array(
					'draw'                => intval($this->input->post('draw')) ? intval($this->input->post('draw')) : 0,
					'recordsTotal'        => $iTotal,
					'recordsFiltered'     => $iTotal,
					'data'                => $columns
			);
			 
			echo json_encode($sOutput);
						
		} catch(Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
			
		}	
		
	}
	
	protected static function fnIconMonitorLightState($mode, $Dates = array()) {
	
		switch ($mode) {
			case 'allviews':
			case 'missing':
				 
				switch($Dates[2]) {
					case 'Z1':
							
						if($Dates[0] != "" && $Dates[1] != "") :
							return  '<i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i>';
						else :
							//<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i>
							return  '<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i>';
						endif;
	
					break;
					case 'Z2':
							
						if($Dates[0] != "" && $Dates[1]['CompletionDocDate'] == "" || $Dates[0] != "" && $Dates[1]['CompletionDocDate'] != ""):
						$mode = '1';
						endif;
	
						if($Dates[0] != "" && $Dates[1]['SentToCADate'] != ""):
						$mode = '2';
						endif;
	
						switch ($mode) {
							case '1':
								return '<i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i>';
								break;
							case '2':
								return '<i class="fa fa-circle" style="color: #60a917; font-size: 1.5em; cursor: pointer;"></i>';
								break;
									
						}
							
					break;
	
				}
	
				break;
			case 'returndoc':
	
				switch($Dates[2]) {
					case 'Z1':
							
						if($Dates[0] != "" && $Dates[1] != "") :
						return  '<i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i>';
						else :
						//return  '<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i>';
						return  '';
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
			case 'reconcile':
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
	
	private function fnArsortDateInReconcileDoc($doc, $is_ref) {
		$result 	= $this->dataReconInquiry($doc, $is_ref);
	
		$sorter		= array();
		for($i= 0; $i < count($result['data']); $i++) {
			array_push($sorter, $result['data'][$i]['LBSubmitDocDate']);
		}
	
		//rsort($sorter); // high to low
		sort($sorter); // low to high
		return $sorter[0];
	
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
	
		
	private function dataReconInquiry($doc, $is_ref) {
		$this->load->model('dbmodel');
			
		$field = "
    		CASE LBSubmitDocDate
				WHEN '1900-01-01' THEN ''
				WHEN '' THEN NULL
				ELSE CONVERT(nvarchar(10), LBSubmitDocDate, 120)
			END AS LBSubmitDocDate,
			CASE HQReceivedDocFromLBDate
				WHEN '1900-01-01' THEN ''
				WHEN '' THEN NULL
				ELSE CONVERT(nvarchar(10), HQReceivedDocFromLBDate, 120)
			END AS HQReceivedDocFromLBDate, 
			CASE SubmitDocToCADate
				WHEN '1900-01-01' THEN ''
				WHEN '' THEN NULL
				ELSE CONVERT(nvarchar(10), SubmitDocToCADate, 120)
			END AS SubmitDocToCADate, 
			CASE CAReturnDate
				WHEN '1900-01-01' THEN ''
				WHEN '' THEN NULL
				ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
			END AS CAReturnDate, 
			CASE HQSentToLBDate
				WHEN '1900-01-01' THEN ''
				WHEN '' THEN NULL
				ELSE CONVERT(nvarchar(10), HQSentToLBDate, 120)
			END AS HQSentToLBDate, 
			CASE BranchReceivedDate
				WHEN '1900-01-01' THEN ''
				WHEN '' THEN NULL
				ELSE CONVERT(nvarchar(10), BranchReceivedDate, 120)
			END AS BranchReceivedDate";
			
		$result   = $this->dbmodel->loadData("ReconcileCompletion", $field, array('DocID' => $doc, 'IsRef' => $is_ref));
		return $result;
			
	}
	
	private function dataReconTypeInquiry($doc, $is_ref, $type) {
		$this->load->model('dbmodel');
			
		$field = "
    		CASE LBSubmitDocDate
				WHEN '1900-01-01' THEN ''
				WHEN '' THEN NULL
				ELSE CONVERT(nvarchar(10), LBSubmitDocDate, 120)
			END AS LBSubmitDocDate,
			CASE HQReceivedDocFromLBDate
				WHEN '1900-01-01' THEN ''
				WHEN '' THEN NULL
				ELSE CONVERT(nvarchar(10), HQReceivedDocFromLBDate, 120)
			END AS HQReceivedDocFromLBDate,
			CASE SubmitDocToCADate
				WHEN '1900-01-01' THEN ''
				WHEN '' THEN NULL
				ELSE CONVERT(nvarchar(10), SubmitDocToCADate, 120)
			END AS SubmitDocToCADate,
			CASE CAReturnDate
				WHEN '1900-01-01' THEN ''
				WHEN '' THEN NULL
				ELSE CONVERT(nvarchar(10), CAReturnDate, 120)
			END AS CAReturnDate,
			CASE HQSentToLBDate
				WHEN '1900-01-01' THEN ''
				WHEN '' THEN NULL
				ELSE CONVERT(nvarchar(10), HQSentToLBDate, 120)
			END AS HQSentToLBDate,
			CASE BranchReceivedDate
				WHEN '1900-01-01' THEN ''
				WHEN '' THEN NULL
				ELSE CONVERT(nvarchar(10), BranchReceivedDate, 120)
			END AS BranchReceivedDate";
			
		$result   = $this->dbmodel->loadData("ReconcileCompletion", $field, array('DocID' => $doc, 'IsRef' => $is_ref, 'DocType' => $type));
		return $result;
			
	}
	
	public function fnLeepLighterChange($doc, $is_ref, $type) {
		 
		$result 	  = $this->dataReconTypeInquiry($doc, $is_ref, $type);
		
		$lbsubmitdate = self::autoStackCol($result, "LBSubmitDocDate");
		$hqgetdoc 	  = self::autoStackCol($result, "HQReceivedDocFromLBDate");
		$hqtoca 	  = self::autoStackCol($result, "SubmitDocToCADate");
		$careturn 	  = self::autoStackCol($result, "CAReturnDate");
		$hqtolbdate   = self::autoStackCol($result, "HQSentToLBDate");
		$lbreceived   = self::autoStackCol($result, "BranchReceivedDate");
		$totals		  = array_merge($lbsubmitdate, $hqgetdoc, $hqtoca, $careturn, $hqtolbdate, $lbreceived);

	
		for($i = 0; $i < count($lbsubmitdate); $i++) {

			if(!in_array("FALSE", $lbsubmitdate)) {
				
				if(!in_array("FALSE", $hqgetdoc)) {
			
					if(!in_array("FALSE", $hqtoca)) {
							
						if(!in_array("FALSE", $careturn)) {
							
							if(!in_array("FALSE", $hqtolbdate)) {
								
								if(!in_array("FALSE", $lbreceived)) {
									return '<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i>';
									
								} else {
									return '<i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i>';
								}
								
							} else {
								return '<i class="fa fa-circle" style="color: #60a917; font-size: 1.5em; cursor: pointer;"></i>';
							}
							
						} else {
							return '<i class="fa fa-circle" style="color: #60a917; font-size: 1.5em; cursor: pointer;"></i>';
						}
							
					} else {
						return '<i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i>';
					}
			
				} else {
					return '<i class="fa fa-circle" style="color: #666666; font-size: 1.5em; cursor: pointer;"></i>';
				}
				
			} else {
				return '<i class="fa fa-circle" style="color: #666666; font-size: 1.5em; cursor: pointer;"></i>';
			}
			
		}
		
		
	}
	
	
	
}