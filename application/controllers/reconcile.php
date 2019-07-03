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
			
		$this->data['AreaRegion']		= $this->dbmodel->loadData($this->table_region, 'RegionID, RegionNameEng', array("RegionNameEng !=" => "BKK - HQ", 'IsActive' => 'A'));
		$this->data['AreaBoundary']		= $this->dbprogress->appProgressBranch($this->authorized, array($this->emp_id));
			
		$this->pages  = "doc_management/doc_ncbconsent";
		$this->load->view($this->pages_customiz.$this->pages, $this->data);
	
	}
	
	public function vwAppManagement() {
		$this->load->model('dbmodel');
		$this->load->model('dbprogress');
		$this->load->library('effective');

		$this->pages 			    	= "doc_management/doc_appmanagement";
		$this->data['char_mode']		= $this->char_mode;		
		$this->data['AreaRegion']		= $this->dbmodel->loadData($this->table_region, 'RegionID, RegionNameEng', array("RegionNameEng !=" => "BKK - HQ", 'IsActive' => 'A'));
		$this->data['AreaBoundary']		= $this->dbprogress->appProgressBranch($this->authorized, array($this->emp_id));
		
		$version = '.js?v=001';
		$this->data['stylesheet']		= array('kalendea/kalendae', 'multi-select/multiple-select', 'custom/verified_new_process');
		$this->data['javascript']		= array('kalendea/kalendae.standalone.min', 'dataTables/media/js/jquery.dataTables.min', 'vendor/jquery.truncate.min', 'vendor/jquery.number.min', 'vendor/jquery.multiple.select', 'build/doc_management/app_management_script' . $version);
		
		$this->_renders($this->pages_default, 'customiz');
		
	}
	
	public function getDefendDashboard() {
		$this->load->model('dbmodel');
		$this->load->model('dbprogress');
		$this->load->library('effective');
		
		$this->pages 			    	= "doc_management/defend_dashboard";
		$this->data['char_mode']		= $this->char_mode;
		$this->data['AreaRegion']		= $this->dbmodel->loadData($this->table_region, 'RegionID, RegionNameEng', array("RegionNameEng !=" => "BKK - HQ", 'IsActive' => 'A'));
		$this->data['AreaBoundary']		= $this->dbprogress->appProgressBranch($this->authorized, array($this->emp_id));
		
		$this->data['stylesheet']		= array('kalendea/kalendae', 'multi-select/multiple-select');
		$this->data['javascript']		= array('kalendea/kalendae.standalone.min', 'dataTables/media/js/jquery.dataTables.min', 'vendor/jquery.truncate.min', 'vendor/jquery.number.min', 'vendor/jquery.multiple.select');
		
		$this->_renders($this->pages_default, 'customiz');
	
	}
	
	public function getDefendManage() {
		$this->load->model('dbmodel');
		$this->load->model('dbprogress');
	
		$this->data['AreaRegion']		= $this->dbmodel->loadData($this->table_region, 'RegionID, RegionNameEng', array("RegionNameEng !=" => "BKK - HQ", 'IsActive' => 'A'));
		$this->data['AreaBoundary']		= $this->dbprogress->appProgressBranch($this->authorized, array($this->emp_id));
	
		$this->load->view($this->pages_customiz.'doc_management/defend_management', $this->data);
	
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
			return '<i class="fa fa-circle fg-green" style="font-size: 1.5em; cursor: pointer;"></i>';
		} else {
			return '<i class="fa fa-circle fg-green" style="font-size: 1.5em; cursor: pointer;"></i>';
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
				return '<abbr title="RETURN DATE : '.$date.'" style="border: 0px;"><i class="fa fa-circle fg-red" style="font-size: 1.5em; cursor: pointer;"></i></abbr>';
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
			return '<i class="fa fa-circle" style="font-size: 1.5em; cursor: pointer; color: #666666;"></i>';
			
		}
	
	}
	
	public function getDataNCBConsent() {
		header("Content-Type: application/json");
		
		$this->load->model('dbmodel');
		$this->load->model('dbmanagement');
		$this->load->library('effective');
	
		try {
			
			// Load: Borrower Type
			$types = $this->dbmodel->CIQuery("SELECT * FROM MasterBorrowerType WHERE IsActive = 'A'");
			
			$results = $this->dbmanagement->getDataNCBConsent($this->authorized, array($this->emp_id));
			$iTotal  = $this->dbmanagement->getDataNCBConsentPagination($this->authorized, array($this->emp_id));			
			
			foreach($results['data'] as $index => $value) {
				
				// Modify NCB: Re-Check Consent		
				$star_mof = !empty($results['data'][$index]['NCBCheckDate']) ? $results['data'][$index]['NCBCheckDate']:$results['data'][$index]['NCBCheckDateLog'];
				$day_diff = self::compare_date(array('begin'=> $star_mof, 'end'=> !empty($results['data'][$index]['HQSubmitToOper']) ? $results['data'][$index]['HQSubmitToOper']:date('Y-m-d')));
				
				if($day_diff > 99):
					$days = 99;						
				else:
					$days = $day_diff;
				endif;
				
				$is_return = !empty($results['data'][$index]['NCBCheckDateLog']) ? $this->effective->StandartDateRollback($results['data'][$index]['NCBCheckDateLog']):NULL;
				
				$borrower_type = '';
				foreach ($types['data'] as $indexed => $values) {
						
					if($results['data'][$index]['BorrowerType'] == $types['data'][$indexed]['BorrowerType']) {
						$borrower_type = $this->effective->get_chartypes($this->char_mode, $types['data'][$indexed]['BorrowerDesc']);
					}
				
				}
				
				$columns[] = array(
						"DocID"			 	=> $results['data'][$index]['DocID'],
						"NCBCheckDate" 	 	=> $this->effective->StandartDateRollback($results['data'][$index]['NCBCheckDate']),
						"DAY"			 	=> self::setNumColorLightStatus(self::limitCountDays($days)),
						"NCBCheck"		 	=> self::lightNCBMonitor($results['data'][$index]['NCBCheck'], $results['data'][$index]['SubmitToHQ'], $results['data'][$index]['HQReceivedFromLB'], $results['data'][$index]['HQSubmitToOper']),
						"SubmitToHQ"  		=> $this->effective->StandartDateRollback($results['data'][$index]['SubmitToHQ']),
						"HQReceivedFromLB"  => $this->effective->StandartDateRollback($results['data'][$index]['HQReceivedFromLB']),
						"HQSubmitToOper"	=> $this->effective->StandartDateRollback($results['data'][$index]['HQSubmitToOper']),
						"OperReturn"		=> self::lightState($results['data'][$index]['ReCheck'], $is_return),
						"BranchDigit"	 	=> $results['data'][$index]['BranchDigit'],
						"BorrowerType"	 	=> $borrower_type,
						"BorrowerName"		=> '<abbr title="Phone : '.$results['data'][$index]['Mobile'].'" style="border:none;">'.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BorrowerName']).'</abbr>',
						"RMName"		 	=> '<abbr title="Phone : '.$results['data'][$index]['RMMobile'].'" style="border:none;">'.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['RMName']).'</abbr>',
						"NCBTools"			=> '<i class="fa fa-calendar-check-o icon" onclick="openModalComponent('. $results['data'][$index]['NCS_ID'].');"></i>',
						"Links"				=> '<a href="'.site_url('management/getDataVerifiedPreview').'?mod=1&cache=false&secure=c4ca4238a0b923820dcc509a6f75849b&rel='.$results['data'][$index]['DocID'].'&req=P2&live=1&t=53&whip=true&clw=false" target="_blank"><i class="icon-new-tab"></i></a>'
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
    			case 'd2cr': return 'careturn'; break;
    			case 'a2lx': return 'allviews'; break;
    			
    		}
    	
    	endif;
    	
    }
    
    static function iconLogisticTitle($logistic) {
    	// fg-lightBlue
    	switch ($logistic) {
    		case 301:
    			return '<i class="fa fa-envelope-o" style="font-size: 1em; cursor: pointer;"></i>';
    			
    		break;
    		case 302:
    			return '<i class="fa fa-motorcycle" style="font-size: 1em; cursor: pointer;"></i>';
    			
    		break;
    		case 303:
    			return '<i class="fa fa-user" style="font-size: 1em; cursor: pointer;"></i>';
    			
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
    
    public function getDocReturnTime($doc, $is_ref, $type) {
    	
    	$result 	  = $this->dataReconTypeInquiry($doc, $is_ref, $type);
    	if(empty($result['data'][0]['LBSubmitDocDate'])) {
    		return '';	
    	} else {
    		
    		if($result['data'][0]['LBSubmitDocDate'] != "" && $result['data'][0]['BranchReceivedDate'] != ""):
    			return self::compare_date(array('begin'=> $result['data'][0]['LBSubmitDocDate'], 'end'=> $result['data'][0]['BranchReceivedDate']));
    		else:
    			return self::compare_date(array('begin'=> $result['data'][0]['LBSubmitDocDate'], 'end'=> date('Y-m-d')));
    		endif;
    		
    	}
    	    	
    }
    
	public function getAppController() {
		$this->load->model('dbmodel');
		$this->load->model('dbmanagement');
		$this->load->library('effective');
		
		$draft = $this->input->post('slmode');
		$mode  = self::fnDocRouter($draft);
		
		$types = $this->dbmodel->CIQuery("SELECT * FROM MasterBorrowerType WHERE IsActive = 'A'");
		
		$results = $this->dbmanagement->loadAppManagement($mode, $this->authorized, array($this->emp_id));
		$iTotal	 = $this->dbmanagement->loadAppManagementPagination($mode, $this->authorized, array($this->emp_id));
	
		try {
			
			switch($mode) {
				
				case 'careturn':
				case 'reconcile':
					
					foreach($results['data'] as $index => $value) {
						
						if(!empty($results['data'][$index]['ReceivedDocFormLB'])) {
							
							$Z2_CAReturnOld = !empty($results['data'][$index]['CAReturnDate']) ? $this->effective->StandartDateRollback($results['data'][$index]['CAReturnDate']):"";
							$Z2_CAReturnDoc = !empty($results['data'][$index]['CAReturnDateLog']) ? $this->effective->StandartDateRollback($results['data'][$index]['CAReturnDateLog']):"";
							
							$BeforeSentDate = !empty($results['data'][$index]['AppToCA']) ? '<abbr title="Sent Document to CA Date" style="border:none;">'.$this->effective->StandartDateRollback($results['data'][$index]['AppToCA']).'</abbr>':'<abbr title="HO Received Date" style="border:none;">'.$this->effective->StandartDateRollback($results['data'][$index]['ReceivedDocFormLB']).'</abbr>';
							$AppToCADate 	= !empty($results['data'][$index]['CA_ReceivedDocDate']) ? '<abbr title="App To CA" style="border:none;">'.$this->effective->StandartDateRollback($results['data'][$index]['CA_ReceivedDocDate']).'</abbr>':$BeforeSentDate;
							
							$status_reason 	= !empty($results['data'][$index]['StatusReason']) ? '| '.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['StatusReason']):'';
							
							//!empty($results['data'][$index]['CA_ReceivedDocDate']) ? $this->effective->StandartDateRollback($results['data'][$index]['CA_ReceivedDocDate']):$this->effective->StandartDateRollback($results['data'][$index]['AppToCA'])
							
							$Z2_AppDate 	= $AppToCADate;//$this->effective->StandartDateRollback(!empty($results['data'][$index]['AppToCA']) ? $results['data'][$index]['AppToCA']:$results['data'][$index]['CompletionDate']);
							$Z2_LackNum 	= '<i id="CompletionDoc_'.$index.'" onclick="openModalComponent(\''.$results['data'][$index]['DocID'].'\', \''.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BorrowerName']).'\', \''.$results['data'][$index]['IsRef'].'\', \'M\', '.$index.');" class="icon-copy on-left" style="color: #999; cursor: pointer; font-size: 1.5em; margin-top: 7px;"></i><span id="onBadge_'.$index.'" class="badge" style="background: #666; position: absolute; margin-left: -15px; margin-top: -5px; ">'.$results['data'][$index]['LackNums'].'</span>';
							$Z2_CompleteDoc = '<span style="font-size: 1em;">'.self::setNumColorLightStatus(self::limitCountDays(self::getDocManageSLA($mode, array($results['data'][$index]['ReceivedDocFormLB'], !empty($results['data'][$index]['AppToCA']) ? $results['data'][$index]['AppToCA']:$results['data'][$index]['CompletionDate'])))).'</span>';
							$Z2_CompleteST  = self::fnIconMonitorLightState('missing', array($this->effective->StandartDateRollback($results['data'][$index]['ReceivedDocFormLB']),  array("CompletionDocDate" => $this->effective->StandartDateRollback($results['data'][$index]['CompletionDate']), "SentToCADate" => $this->effective->StandartDateRollback($results['data'][$index]['AppToCA']), "CAReturnDate" => $Z2_CAReturnDoc), 'Z2', $results['data'][$index]['CompletionDoc'], $this->effective->StandartDateRollback($results['data'][$index]['AppToCA'])), $status_reason);
							
							$Return_dump 	= $this->effective->StandartDateRollback($this->fnArsortDateInReconcileDoc($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R'));
							
							$Z3_ReturnDate  = $this->effective->StandartDateRollback($this->fnArsortDateInReconcileDoc($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R'));
							$Z3_ReturnNums  = !empty($Return_dump) ? '<i id="ReturnsDoc_'.$index.'" onclick="openModalComponent(\''.$results['data'][$index]['DocID'].'\', \''.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BorrowerName']).'\', \''.$results['data'][$index]['IsRef'].'\', \'R\', '.$index.');" class="icon-copy on-left" style="color: #999;  cursor: pointer; font-size: 1.5em;  margin-top: 7px;"></i><span id="returndoc_onBadge_'.$index.'" class="badge" style="background: #666; position: absolute; margin-left: -15px; margin-top: -5px;">'.$results['data'][$index]['ReturnNums'].'</span>' : "";
							$Z3_ReturnDay   = '<span style="font-size: 1em;">'.self::setNumColorLightStatus($this->getDocReturnTime($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R')).'</span>';
							$Z3_ReturnState = $this->fnLeepLighterChange($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R');
							
							$Z1_LBToHQ		= $this->effective->StandartDateRollback($results['data'][$index]['SubmitDocToHQ']);
							if(!empty($Z1_LBToHQ)) {
								$Z1_light 	= self::fnIconMonitorLightState('reconcile', array($this->effective->StandartDateRollback($results['data'][$index]['SubmitDocToHQ']), $this->effective->StandartDateRollback($results['data'][$index]['ReceivedDocFormLB'])), $status_reason);
							} else {
								$Z1_light	= '';
							}
							
							
						} else {
							$Z2_AppDate		= '';
							$Z2_LackNum		= '';
							$Z2_CompleteDoc = '';
							$Z2_CompleteST	= '';
							
							$Z3_ReturnDate  = '';
							$Z3_ReturnNums  = '';
							$Z3_ReturnDay   = '';
							$Z3_ReturnState = '';
							
							$Z1_light		= '<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i>';

						}
						
						$borrower_type 		= '';
						foreach ($types['data'] as $indexed => $values) {
						
							if($results['data'][$index]['BorrowerType'] == $types['data'][$indexed]['BorrowerType']) {
								$borrower_type = $this->effective->get_chartypes($this->char_mode, $types['data'][$indexed]['BorrowerDesc']);
							}
						
						}
			
						$columns[] = array(
							"DocID" 			 => $results['data'][$index]['DocID'],
							"LogisticCode" 		 => self::iconLogisticTitle($results['data'][$index]['LogisticCode']),
							"SubmitDocToHQ" 	 => $this->effective->StandartDateRollback($results['data'][$index]['SubmitDocToHQ']),
							"LogisticDay" 		 => self::setNumColorLightStatus(self::limitCountDays(self::getDocManageSLA($mode, array($results['data'][$index]['SubmitDocToHQ'], $results['data'][$index]['ReceivedDocFormLB'])))),
							"LogisticStatus"	 => $Z1_light,
							
							"AppToCA"	 	 	 => $Z2_AppDate,
							"LackNums" 	 		 => $Z2_LackNum,
							"CompletionDay"	 	 => $Z2_CompleteDoc,
							"CompletionState"	 => $Z2_CompleteST,
								
							"ReturnDate"		 => $Z3_ReturnDate,
							"ReturnNum" 		 => $Z3_ReturnNums,
							"ReturnDay" 		 => $Z3_ReturnDay,
							"ReturnState"	     => $Z3_ReturnState,
								
							"NCBCheck"		 	 => self::setCheckNCB($results['data'][$index]['NCBCheck']),
							"BranchDigit"    	 => '<abbr title="Phone : " style="border:none;">'.$results['data'][$index]['BranchDigit'].'</abbr>',
							"BorrowerType"	 	 => $borrower_type,
							"BorrowerName"       => !empty($results['data'][$index]['BorrowerName']) ? '<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.($this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BorrowerName'])).'</abbr>':'<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.($this->effective->get_chartypes($this->char_mode, $results['data'][$index]['OwnerName'])).'</abbr>',
							"RMName"	    	 => '<abbr title="Phone : '.$results['data'][$index]['RMMobile'].'" style="border:none;">'.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['RMName']).'</abbr>',
							"Links"				=> '<a href="'.site_url('management/getDataVerifiedPreview').'?mod=1&cache=false&secure=c4ca4238a0b923820dcc509a6f75849b&rel='.$results['data'][$index]['DocID'].'&req=P2&live=1&t=53&whip=true&clw=false" target="_blank"><i class="icon-new-tab"></i></a>'
						);
					}
				
					
				break;
				case 'missing':
					
					foreach($results['data'] as $index => $value) {
						
						if(!empty($results['data'][$index]['ReceivedDocFormLB'])) {
							
							$status_reason 	= !empty($results['data'][$index]['StatusReason']) ? '| '.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['StatusReason']):'';

							$Z2_CAReturnOld = !empty($results['data'][$index]['CAReturnDate']) ? $this->effective->StandartDateRollback($results['data'][$index]['CAReturnDate']):"";
							$Z2_CAReturnDoc = !empty($results['data'][$index]['CAReturnDateLog']) ? $this->effective->StandartDateRollback($results['data'][$index]['CAReturnDateLog']):"";
							
							$BeforeSentDate = !empty($results['data'][$index]['AppToCA']) ? '<abbr title="Sent Document to CA Date" style="border:none;">'.$this->effective->StandartDateRollback($results['data'][$index]['AppToCA']).'</abbr>':'<abbr title="HO Received Date" style="border:none;">'.$this->effective->StandartDateRollback($results['data'][$index]['ReceivedDocFormLB']).'</abbr>';
							$AppToCADate 	= !empty($results['data'][$index]['CA_ReceivedDocDate']) ? '<abbr title="App To CA" style="border:none;">'.$this->effective->StandartDateRollback($results['data'][$index]['CA_ReceivedDocDate']).'</abbr>':$BeforeSentDate;
							
							$Z2_AppDate 	= $AppToCADate;
							$Z2_LackNum 	= '<i id="CompletionDoc_'.$index.'" onclick="openModalComponent(\''.$results['data'][$index]['DocID'].'\', \''.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BorrowerName']).'\', \''.$results['data'][$index]['IsRef'].'\', \'M\', '.$index.');" class="icon-copy on-left" style="color: #999; cursor: pointer; font-size: 1.5em; margin-top: 7px;"></i><span id="onBadge_'.$index.'" class="badge" style="background: #666; position: absolute; margin-left: -15px; margin-top: -5px; ">'.$results['data'][$index]['LackNums'].'</span>';
							$Z2_CompleteDoc = '<span style="font-size: 1em;">'.self::setNumColorLightStatus(self::limitCountDays(self::getDocManageSLA($mode, array($results['data'][$index]['ReceivedDocFormLB'], !empty($results['data'][$index]['AppToCA']) ? $results['data'][$index]['AppToCA']:$results['data'][$index]['CompletionDate'])))).'</span>';
							$Z2_CompleteST  = self::fnIconMonitorLightState('missing', array($this->effective->StandartDateRollback($results['data'][$index]['ReceivedDocFormLB']),  array("CompletionDocDate" => $this->effective->StandartDateRollback($results['data'][$index]['CompletionDate']), "SentToCADate" => $this->effective->StandartDateRollback($results['data'][$index]['AppToCA']), "CAReturnDate" => $Z2_CAReturnDoc), 'Z2', $results['data'][$index]['CompletionDoc'], $this->effective->StandartDateRollback($results['data'][$index]['AppToCA'])), $status_reason);
								
							$Return_dump 	= $this->effective->StandartDateRollback($this->fnArsortDateInReconcileDoc($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R'));
							
							$Z3_ReturnDate  = $this->effective->StandartDateRollback($this->fnArsortDateInReconcileDoc($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R'));
							$Z3_ReturnNums  = !empty($Return_dump) ? '<i id="ReturnsDoc_'.$index.'" onclick="openModalComponent(\''.$results['data'][$index]['DocID'].'\', \''.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BorrowerName']).'\', \''.$results['data'][$index]['IsRef'].'\', \'R\', '.$index.');" class="icon-copy on-left" style="color: #999;  cursor: pointer; font-size: 1.5em;  margin-top: 7px;"></i><span id="returndoc_onBadge_'.$index.'" class="badge" style="background: #666; position: absolute; margin-left: -15px; margin-top: -5px;">'.$results['data'][$index]['ReturnNums'].'</span>' : "";
							$Z3_ReturnDay   = '<span style="font-size: 1em;">'.self::setNumColorLightStatus($this->getDocReturnTime($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R')).'</span>';
							$Z3_ReturnState = $this->fnLeepLighterChange($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R');
							
							$Z1_LBToHQ		= $this->effective->StandartDateRollback($results['data'][$index]['SubmitDocToHQ']);
							if(!empty($Z1_LBToHQ)) {
								$Z1_light 	= self::fnIconMonitorLightState('reconcile', array($this->effective->StandartDateRollback($results['data'][$index]['SubmitDocToHQ']), $this->effective->StandartDateRollback($results['data'][$index]['ReceivedDocFormLB'])), $status_reason);
							} else {
								$Z1_light	= '';
							}
								
						} else {
							
							$status_reason 	= '';
							
							$Z2_CAReturnDoc = !empty($results['data'][$index]['CAReturnDateLog']) ? $this->effective->StandartDateRollback($results['data'][$index]['CAReturnDateLog']):"";
							
							$Z2_AppDate 	= $this->effective->StandartDateRollback(!empty($results['data'][$index]['AppToCA']) ? $results['data'][$index]['AppToCA']:$results['data'][$index]['CompletionDate']);
							$Z2_LackNum 	= '<i id="CompletionDoc_'.$index.'" onclick="openModalComponent(\''.$results['data'][$index]['DocID'].'\', \''.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BorrowerName']).'\', \''.$results['data'][$index]['IsRef'].'\', \'M\', '.$index.');" class="icon-copy on-left" style="color: #999; cursor: pointer; font-size: 1.5em; margin-top: 7px;"></i><span id="onBadge_'.$index.'" class="badge" style="background: #666; position: absolute; margin-left: -15px; margin-top: -5px; ">'.$results['data'][$index]['LackNums'].'</span>';
							$Z2_CompleteDoc = '<span style="font-size: 1em;">'.self::setNumColorLightStatus(self::limitCountDays(self::getDocManageSLA($mode, array($results['data'][$index]['ReceivedDocFormLB'], !empty($results['data'][$index]['AppToCA']) ? $results['data'][$index]['AppToCA']:$results['data'][$index]['CompletionDate'])))).'</span>';
							$Z2_CompleteST  = self::fnIconMonitorLightState('missing', array($this->effective->StandartDateRollback($results['data'][$index]['ReceivedDocFormLB']),  array("CompletionDocDate" => $this->effective->StandartDateRollback($results['data'][$index]['CompletionDate']), "SentToCADate" => $this->effective->StandartDateRollback($results['data'][$index]['AppToCA']), "CAReturnDate" => $Z2_CAReturnDoc), 'Z2', $results['data'][$index]['CompletionDoc'], $this->effective->StandartDateRollback($results['data'][$index]['AppToCA'])), $status_reason);
								
							$Z3_ReturnDate  = '';
							$Z3_ReturnNums  = '';
							$Z3_ReturnDay   = '';
							$Z3_ReturnState = '';
							
							$Z1_light		= '<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i>';
						}
						
						$borrower_type 		= '';
						foreach ($types['data'] as $indexed => $values) {
						
							if($results['data'][$index]['BorrowerType'] == $types['data'][$indexed]['BorrowerType']) {
								$borrower_type = $this->effective->get_chartypes($this->char_mode, $types['data'][$indexed]['BorrowerDesc']);
							}
						
						}
															
						$columns[] = array(
								"DocID" 			 => $results['data'][$index]['DocID'],
								"LogisticCode" 		 => self::iconLogisticTitle($results['data'][$index]['LogisticCode']),
								"SubmitDocToHQ" 	 => $this->effective->StandartDateRollback($results['data'][$index]['SubmitDocToHQ']),
								"LogisticDay" 		 => self::setNumColorLightStatus(self::limitCountDays(self::getDocManageSLA($mode, array($results['data'][$index]['SubmitDocToHQ'], $results['data'][$index]['ReceivedDocFormLB'])))),
								"LogisticStatus"	 => $Z1_light,
								
								"AppToCA"	 	 	 => $Z2_AppDate,
								"LackNums" 	 		 => $Z2_LackNum,
								"CompletionDay"	 	 => $Z2_CompleteDoc,
								"CompletionState"	 => $Z2_CompleteST,
									
								"ReturnDate"		 => $Z3_ReturnDate,
								"ReturnNum" 		 => $Z3_ReturnNums,
								"ReturnDay" 		 => $Z3_ReturnDay,
								"ReturnState"	     => $Z3_ReturnState,
								
								"NCBCheck"		 	 => self::setCheckNCB($results['data'][$index]['NCBCheck']),
								"BranchDigit"    	 => '<abbr title="Phone : " style="border:none;">'.$results['data'][$index]['BranchDigit'].'</abbr>',
								"BorrowerType"	 	 => $borrower_type,
								"BorrowerName"       => !empty($results['data'][$index]['BorrowerName']) ? '<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.($this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BorrowerName'])).'</abbr>':'<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.($this->effective->get_chartypes($this->char_mode, $results['data'][$index]['OwnerName'])).'</abbr>',
								"RMName"	    	 => '<abbr title="Phone : '.$results['data'][$index]['RMMobile'].'" style="border:none;">'.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['RMName']).'</abbr>',
								"Links"			 	 => '<a href="'.site_url('management/getDataVerifiedPreview').'?mod=1&cache=false&secure=c4ca4238a0b923820dcc509a6f75849b&rel='.$results['data'][$index]['DocID'].'&req=P2&live=1&t=53&whip=true&clw=false" target="_blank"><i class="icon-new-tab"></i></a>'
						);
					}
					
				break;
				case 'returndoc':
						
					foreach($results['data'] as $index => $value) {
						
						if(!empty($results['data'][$index]['ReceivedDocFormLB'])) {
							
							$status_reason 	= !empty($results['data'][$index]['StatusReason']) ? '| '.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['StatusReason']):'';

							$Z2_CAReturnOld = !empty($results['data'][$index]['CAReturnDate']) ? $this->effective->StandartDateRollback($results['data'][$index]['CAReturnDate']):"";
							$Z2_CAReturnDoc = !empty($results['data'][$index]['CAReturnDateLog']) ? $this->effective->StandartDateRollback($results['data'][$index]['CAReturnDateLog']):"";
							
							$BeforeSentDate = !empty($results['data'][$index]['AppToCA']) ? '<abbr title="Sent Document to CA Date" style="border:none;">'.$this->effective->StandartDateRollback($results['data'][$index]['AppToCA']).'</abbr>':'<abbr title="HO Received Date" style="border:none;">'.$this->effective->StandartDateRollback($results['data'][$index]['ReceivedDocFormLB']).'</abbr>';
							$AppToCADate 	= !empty($results['data'][$index]['CA_ReceivedDocDate']) ? '<abbr title="App To CA" style="border:none;">'.$this->effective->StandartDateRollback($results['data'][$index]['CA_ReceivedDocDate']).'</abbr>':$BeforeSentDate;
							
							$Z2_AppDate 	= $AppToCADate; //$this->effective->StandartDateRollback(!empty($results['data'][$index]['AppToCA']) ? $results['data'][$index]['AppToCA']:$results['data'][$index]['CompletionDate']);
							$Z2_LackNum 	= '<i id="CompletionDoc_'.$index.'" onclick="openModalComponent(\''.$results['data'][$index]['DocID'].'\', \''.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BorrowerName']).'\', \''.$results['data'][$index]['IsRef'].'\', \'M\', '.$index.');" class="icon-copy on-left" style="color: #999; cursor: pointer; font-size: 1.5em; margin-top: 7px;"></i><span id="onBadge_'.$index.'" class="badge" style="background: #666; position: absolute; margin-left: -15px; margin-top: -5px; ">'.$results['data'][$index]['LackNums'].'</span>';
							$Z2_CompleteDoc = '<span style="font-size: 1em;">'.self::setNumColorLightStatus(self::limitCountDays(self::getDocManageSLA($mode, array($results['data'][$index]['ReceivedDocFormLB'], !empty($results['data'][$index]['AppToCA']) ? $results['data'][$index]['AppToCA']:$results['data'][$index]['CompletionDate'])))).'</span>';
							$Z2_CompleteST  = self::fnIconMonitorLightState('missing', array($this->effective->StandartDateRollback($results['data'][$index]['ReceivedDocFormLB']),  array("CompletionDocDate" => $this->effective->StandartDateRollback($results['data'][$index]['CompletionDate']), "SentToCADate" => $this->effective->StandartDateRollback($results['data'][$index]['AppToCA']), "CAReturnDate" => $Z2_CAReturnDoc), 'Z2', $results['data'][$index]['CompletionDoc'], $this->effective->StandartDateRollback($results['data'][$index]['AppToCA'])), $status_reason);
						
							$Return_dump 	= $this->effective->StandartDateRollback($this->fnArsortDateInReconcileDoc($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R'));
							
							$Z3_ReturnDate  = $this->effective->StandartDateRollback($this->fnArsortDateInReconcileDoc($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R'));
							$Z3_ReturnNums  = !empty($Return_dump) ? '<i id="ReturnsDoc_'.$index.'" onclick="openModalComponent(\''.$results['data'][$index]['DocID'].'\', \''.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BorrowerName']).'\', \''.$results['data'][$index]['IsRef'].'\', \'R\', '.$index.');" class="icon-copy on-left" style="color: #999;  cursor: pointer; font-size: 1.5em;  margin-top: 7px;"></i><span id="returndoc_onBadge_'.$index.'" class="badge" style="background: #666; position: absolute; margin-left: -15px; margin-top: -5px;">'.$results['data'][$index]['ReturnNums'].'</span>' : "";
							$Z3_ReturnDay   = '<span style="font-size: 1em;">'.self::setNumColorLightStatus($this->getDocReturnTime($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R')).'</span>';
							$Z3_ReturnState = $this->fnLeepLighterChange($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R');
							
							$Z1_LBToHQ		= $this->effective->StandartDateRollback($results['data'][$index]['SubmitDocToHQ']);
							if(!empty($Z1_LBToHQ)) {
								$Z1_light 	= self::fnIconMonitorLightState('reconcile', array($this->effective->StandartDateRollback($results['data'][$index]['SubmitDocToHQ']), $this->effective->StandartDateRollback($results['data'][$index]['ReceivedDocFormLB'])), $status_reason);
							} else {
								$Z1_light	= '';
							}
						
						} else {
							
							$status_reason 	= '';
							
							$Z2_AppDate		= '';
							$Z2_LackNum		= '';
							$Z2_CompleteDoc = '';
							$Z2_CompleteST	= '';
						
							$Return_dump 	= $this->effective->StandartDateRollback($this->fnArsortDateInReconcileDoc($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R'));
								
							$Z3_ReturnDate  = $this->effective->StandartDateRollback($this->fnArsortDateInReconcileDoc($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R'));
							$Z3_ReturnNums  = !empty($Return_dump) ? '<i id="ReturnsDoc_'.$index.'" onclick="openModalComponent(\''.$results['data'][$index]['DocID'].'\', \''.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BorrowerName']).'\', \''.$results['data'][$index]['IsRef'].'\', \'R\', '.$index.');" class="icon-copy on-left" style="color: #999;  cursor: pointer; font-size: 1.5em;  margin-top: 7px;"></i><span id="returndoc_onBadge_'.$index.'" class="badge" style="background: #666; position: absolute; margin-left: -15px; margin-top: -5px;">'.$results['data'][$index]['ReturnNums'].'</span>' : "";
							$Z3_ReturnDay   = '<span style="font-size: 1em;">'.self::setNumColorLightStatus($this->getDocReturnTime($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R')).'</span>';
							$Z3_ReturnState = $this->fnLeepLighterChange($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R');
							
							
							$Z1_light		= '<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i>';
						}
						
						$borrower_type 		= '';
						foreach ($types['data'] as $indexed => $values) {
						
							if($results['data'][$index]['BorrowerType'] == $types['data'][$indexed]['BorrowerType']) {
								$borrower_type = $this->effective->get_chartypes($this->char_mode, $types['data'][$indexed]['BorrowerDesc']);
							}
						
						}
																		     
						$columns[] = array(
								"DocID" 			 => $results['data'][$index]['DocID'],
								"LogisticCode" 		 => self::iconLogisticTitle($results['data'][$index]['LogisticCode']),
								"SubmitDocToHQ" 	 => $this->effective->StandartDateRollback($results['data'][$index]['SubmitDocToHQ']),
								"LogisticDay" 		 => self::setNumColorLightStatus(self::limitCountDays(self::getDocManageSLA($mode, array($results['data'][$index]['SubmitDocToHQ'], $results['data'][$index]['ReceivedDocFormLB'])))),
								"LogisticStatus"	 => $Z1_light,
								
								"AppToCA"	 	 	 => $Z2_AppDate,
								"LackNums" 	 		 => $Z2_LackNum,
								"CompletionDay"	 	 => $Z2_CompleteDoc,
								"CompletionState"	 => $Z2_CompleteST,
									
								"ReturnDate"		 => $Z3_ReturnDate,
								"ReturnNum" 		 => $Z3_ReturnNums,
								"ReturnDay" 		 => $Z3_ReturnDay,
								"ReturnState"	     => $Z3_ReturnState,
								
								
								"NCBCheck"		 	 => self::setCheckNCB($results['data'][$index]['NCBCheck']),
								"BranchDigit"    	 => '<abbr title="Phone : " style="border:none;">'.$results['data'][$index]['BranchDigit'].'</abbr>',
								"BorrowerType"	 	 => $borrower_type,
								"BorrowerName"       => !empty($results['data'][$index]['BorrowerName']) ? '<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.($this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BorrowerName'])).'</abbr>':'<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.($this->effective->get_chartypes($this->char_mode, $results['data'][$index]['OwnerName'])).'</abbr>',
								"RMName"	    	 => '<abbr title="Phone : '.$results['data'][$index]['RMMobile'].'" style="border:none;">'.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['RMName']).'</abbr>',
								"Links"				 => '<a href="'.site_url('management/getDataVerifiedPreview').'?mod=1&cache=false&secure=c4ca4238a0b923820dcc509a6f75849b&rel='.$results['data'][$index]['DocID'].'&req=P2&live=1&t=53&whip=true&clw=false" target="_blank"><i class="icon-new-tab"></i></a>'
						);
					}
						
				break;
				case 'allviews':
					
					foreach($results['data'] as $index => $value) {
							
						if(!empty($results['data'][$index]['ReceivedDocFormLB'])) {
							

							$Z2_CAReturnOld = !empty($results['data'][$index]['CAReturnDate']) ? $this->effective->StandartDateRollback($results['data'][$index]['CAReturnDate']):"";
							$Z2_CAReturnDoc = !empty($results['data'][$index]['CAReturnDateLog']) ? $this->effective->StandartDateRollback($results['data'][$index]['CAReturnDateLog']):"";
						
							$BeforeSentDate = !empty($results['data'][$index]['AppToCA']) ? '<abbr title="Sent Document to CA Date" style="border:none;">'.$this->effective->StandartDateRollback($results['data'][$index]['AppToCA']).'</abbr>':'<abbr title="HO Received Date" style="border:none;">'.$this->effective->StandartDateRollback($results['data'][$index]['ReceivedDocFormLB']).'</abbr>';
							$AppToCADate 	= !empty($results['data'][$index]['CA_ReceivedDocDate']) ? '<abbr title="App To CA" style="border:none;">'.$this->effective->StandartDateRollback($results['data'][$index]['CA_ReceivedDocDate']).'</abbr>':$BeforeSentDate;
							$status_reason 	= !empty($results['data'][$index]['StatusReason']) ? '| '.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['StatusReason']):'';
														
							$Z2_AppDate 	= $AppToCADate; //$this->effective->StandartDateRollback(!empty($results['data'][$index]['AppToCA']) ? $results['data'][$index]['AppToCA']:$results['data'][$index]['CompletionDate']);
							$Z2_LackNum 	= '<i id="CompletionDoc_'.$index.'" onclick="openModalComponent(\''.$results['data'][$index]['DocID'].'\', \''.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BorrowerName']).'\', \''.$results['data'][$index]['IsRef'].'\', \'M\', '.$index.');" class="icon-copy on-left" style="color: #999; cursor: pointer; font-size: 1.5em; margin-top: 7px;"></i><span id="onBadge_'.$index.'" class="badge" style="background: #666; position: absolute; margin-left: -15px; margin-top: -5px; ">'.$results['data'][$index]['LackNums'].'</span>';
							$Z2_CompleteDoc = '<span style="font-size: 1em;">'.self::setNumColorLightStatus(self::limitCountDays(self::getDocManageSLA($mode, array($results['data'][$index]['ReceivedDocFormLB'], !empty($results['data'][$index]['AppToCA']) ? $results['data'][$index]['AppToCA']:$results['data'][$index]['CompletionDate'])))).'</span>';
							$Z2_CompleteST  = self::fnIconMonitorLightState('missing', array($this->effective->StandartDateRollback($results['data'][$index]['ReceivedDocFormLB']),  array("CompletionDocDate" => $this->effective->StandartDateRollback($results['data'][$index]['CompletionDate']), "SentToCADate" => $this->effective->StandartDateRollback($results['data'][$index]['AppToCA']), "CAReturnDate" => $Z2_CAReturnDoc), 'Z2', $results['data'][$index]['CompletionDoc'], $this->effective->StandartDateRollback($results['data'][$index]['AppToCA'])), $status_reason);
						
							$Return_dump 	= $this->effective->StandartDateRollback($this->fnArsortDateInReconcileDoc($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R'));
							
							$Z3_ReturnDate  = $this->effective->StandartDateRollback($this->fnArsortDateInReconcileDoc($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R'));
							$Z3_ReturnNums  = !empty($Return_dump) ? '<i id="ReturnsDoc_'.$index.'" onclick="openModalComponent(\''.$results['data'][$index]['DocID'].'\', \''.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BorrowerName']).'\', \''.$results['data'][$index]['IsRef'].'\', \'R\', '.$index.');" class="icon-copy on-left" style="color: #999;  cursor: pointer; font-size: 1.5em;  margin-top: 7px;"></i><span id="returndoc_onBadge_'.$index.'" class="badge" style="background: #666; position: absolute; margin-left: -15px; margin-top: -5px;">'.$results['data'][$index]['ReturnNums'].'</span>' : "";
							$Z3_ReturnDay   = '<span style="font-size: 1em;">'.self::setNumColorLightStatus($this->getDocReturnTime($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R')).'</span>';
							$Z3_ReturnState = $this->fnLeepLighterChange($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R');
							
							$Z1_LBToHQ		= $this->effective->StandartDateRollback($results['data'][$index]['SubmitDocToHQ']);
							if(!empty($Z1_LBToHQ)) {
								$Z1_light 	= self::fnIconMonitorLightState('reconcile', array($this->effective->StandartDateRollback($results['data'][$index]['SubmitDocToHQ']), $this->effective->StandartDateRollback($results['data'][$index]['ReceivedDocFormLB'])), $status_reason);
							} else {
								$Z1_light	= '';
							}
								
						} else {
							
							$Z2_AppDate		= '';
							$Z2_LackNum		= '';
							$Z2_CompleteDoc = '';
							$Z2_CompleteST	= '';
							
							$Return_dump 	= $this->effective->StandartDateRollback($this->fnArsortDateInReconcileDoc($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R'));
							
							$Z3_ReturnDate  = $this->effective->StandartDateRollback($this->fnArsortDateInReconcileDoc($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R'));
							$Z3_ReturnNums  = !empty($Return_dump) ? '<i id="ReturnsDoc_'.$index.'" onclick="openModalComponent(\''.$results['data'][$index]['DocID'].'\', \''.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BorrowerName']).'\', \''.$results['data'][$index]['IsRef'].'\', \'R\', '.$index.');" class="icon-copy on-left" style="color: #999;  cursor: pointer; font-size: 1.5em;  margin-top: 7px;"></i><span id="returndoc_onBadge_'.$index.'" class="badge" style="background: #666; position: absolute; margin-left: -15px; margin-top: -5px;">'.$results['data'][$index]['ReturnNums'].'</span>' : "";
							$Z3_ReturnDay   = '<span style="font-size: 1em;">'.self::setNumColorLightStatus($this->getDocReturnTime($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R')).'</span>';
							$Z3_ReturnState = $this->fnLeepLighterChange($results['data'][$index]['DocID'], $results['data'][$index]['IsRef'], 'R');
							
							$Z1_light		= '<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i>';
							
						}
						
						$borrower_type 		= '';
						foreach ($types['data'] as $indexed => $values) {
						
							if($results['data'][$index]['BorrowerType'] == $types['data'][$indexed]['BorrowerType']) {
								$borrower_type = $this->effective->get_chartypes($this->char_mode, $types['data'][$indexed]['BorrowerDesc']);
							}
						
						}
							
						$columns[] = array(
								"DocID" 			 => $results['data'][$index]['DocID'],
								"LogisticCode" 		 => self::iconLogisticTitle($results['data'][$index]['LogisticCode']),
								"SubmitDocToHQ" 	 => $this->effective->StandartDateRollback($results['data'][$index]['SubmitDocToHQ']),
								"LogisticDay" 		 => self::setNumColorLightStatus(self::limitCountDays(self::getDocManageSLA($mode, array($results['data'][$index]['SubmitDocToHQ'], $results['data'][$index]['ReceivedDocFormLB'])))),
								"LogisticStatus"	 => $Z1_light,
					
								"AppToCA"	 	 	 => $Z2_AppDate,
								"LackNums" 	 		 => $Z2_LackNum,
								"CompletionDay"	 	 => $Z2_CompleteDoc,
								"CompletionState"	 => $Z2_CompleteST,
									
								"ReturnDate"		 => $Z3_ReturnDate,
								"ReturnNum" 		 => $Z3_ReturnNums,
								"ReturnDay" 		 => $Z3_ReturnDay,
								"ReturnState"	     => $Z3_ReturnState,
					
								"NCBCheck"		 	 => self::setCheckNCB($results['data'][$index]['NCBCheck']),
								"BranchDigit"    	 => '<abbr title="Phone : " style="border:none;">'.$results['data'][$index]['BranchDigit'].'</abbr>',
								"BorrowerType"	 	 => $borrower_type,
								"BorrowerName"       => !empty($results['data'][$index]['BorrowerName']) ? '<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.($this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BorrowerName'])).'</abbr>':'<abbr title="Phone : '.(!empty($results['data'][$index]['Mobile']) ? $results['data'][$index]['Mobile']:$results['data'][$index]['Telephone']).'" style="border:none;">'.($this->effective->get_chartypes($this->char_mode, $results['data'][$index]['OwnerName'])).'</abbr>',
								"RMName"	    	 => '<abbr title="Phone : '.$results['data'][$index]['RMMobile'].'" style="border:none;">'.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['RMName']).'</abbr>',
								"Links"				 => '<a href="'.site_url('management/getDataVerifiedPreview').'?mod=1&cache=false&secure=c4ca4238a0b923820dcc509a6f75849b&rel='.$results['data'][$index]['DocID'].'&req=P2&live=1&t=53&whip=true&clw=false" target="_blank"><i class="icon-new-tab"></i></a>'
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
			//$this->output->enable_profiler(TRUE);
			
		} catch(Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
			
		}	
				
	}
		
	protected static function fnIconMonitorLightState($mode, $Dates = array(), $status_reason) {
	
		switch ($mode) {
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
				
			case 'missing':
			case 'allviews':
				
				switch($Dates[2]) {
					
					case 'Z1':
							
						if($Dates[0] != "" && $Dates[1] != "") :
							return  '<i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i>';
						else :
							return  '<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i>';
						endif;
	
					break;
					case 'Z2':
							
						if($Dates[0] != "" && $Dates[1]['CompletionDocDate'] == "" || $Dates[0] != "" && $Dates[1]['CompletionDocDate'] != ""):
							$mode = '1';
						endif;
	
						if($Dates[0] != "" && $Dates[1]['SentToCADate'] != "" && $Dates[1]['CAReturnDate'] == "" || $Dates[0] != "" && $Dates[1]['SentToCADate'] != "" && $Dates[1]['CAReturnDate'] != ""):
							$mode = '2';
						endif;
						
						if($Dates[0] != "" && $Dates[1]['SentToCADate'] == "" && $Dates[1]['CAReturnDate'] != ""):
							$mode = '3';
						endif;
	
						switch ($mode) {
							case '1':
								return '<i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i>';
							break;
							case '2':
								return '<abbr title="Completed: '.$Dates[1]['SentToCADate'].' '.$status_reason.'" style="border:none;"><i class="fa fa-circle" style="color: #60a917; font-size: 1.5em; cursor: pointer;"></i></abbr>';
							break;
							case '3':
								return '<abbr title="Return Document On Date : '.$Dates[1]['CAReturnDate'].' '.$status_reason.'" style="border:none;"><i class="fa fa-circle fg-red" style="font-size: 1.5em; cursor: pointer;"></i></abbr>';
							
								
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
							return  '<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i>';
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
								
									if(!empty($Dates[1]['CAReturnDate'])) {
										return '<abbr title="Completed: '.$Dates[1]['CAReturnDate'].' '.$status_reason.'" style="border:none;"><i class="fa fa-circle fg-red" style="font-size: 1.5em; cursor: pointer;"></i></abbr>';
									} else {
										return '<abbr title="Completed: '.$Dates[1]['SentToCADate'].' '.$status_reason.'" style="border:none;"><i class="fa fa-circle" style="color: #60a917; font-size: 1.5em; cursor: pointer;"></i></abbr>';
									}
									
								break;
									
						}
							
						break;
			
				}
					
			break;
	 
		}
		 
	}
	
	private function fnArsortDateInReconcileDoc($doc, $is_ref, $type) {
		$result 	= $this->dataReconInquiry($doc, $is_ref, $type);
	
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
	
		
	private function dataReconInquiry($doc, $is_ref, $type) {
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
			
		$result   = $this->dbmodel->loadData("ReconcileCompletion", $field, array('DocID' => $doc, 'IsRef' => $is_ref, 'DocType' => $type, 'IsActive' => 'A'));
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
			
		$result   = $this->dbmodel->loadData("ReconcileCompletion", $field, array('DocID' => $doc, 'IsRef' => $is_ref, 'DocType' => $type, 'IsActive' => 'A'));
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
									return '<abbr id="R'.$is_ref.'" title="LB received." style="border: 0;"><i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i></abbr>';
									
								} else {
									return '<abbr id="R'.$is_ref.'" title="HQ send document to LB" style="border: 0;"><i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i></abbr>';
								}
								
							} else {
								return '<abbr id="R'.$is_ref.'" title="CA send document to HQ" style="border: 0;"><i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i></abbr>';
							}
							
						} else {
							return '<abbr id="R'.$is_ref.'" title="HQ sumit document to CA" style="border: 0;"><i class="fa fa-circle" style="color: #60a917; font-size: 1.5em; cursor: pointer;"></i></abbr>';
						}
							
					} else {
						return '<abbr id="R'.$is_ref.'" title="HQ received" style="border: 0;"><i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i></abbr>';
					}
			
				} else {
					return '<abbr id="R'.$is_ref.'" title="LB sumit document to HQ" style="border: 0;"><i class="fa fa-circle" style="color: #666666; font-size: 1.5em; cursor: pointer;"></i></abbr>';
				}
				
			} else {
				//return '<abbr title="LB has created record" style="border: 0;"><i class="fa fa-circle" style="color: #666666; font-size: 1.5em; cursor: pointer;"></i></abbr>';
			}
			
		}
		
	}
	
	/*
	public function fnLeepLighterChange($doc, $is_ref, $type) {
			
		$result 	  = $this->dataReconTypeInquiry($doc, $is_ref, $type);
	
		$lbsubmitdate = self::autoStackCol($result, "LBSubmitDocDate");
		$hqgetdoc 	  = self::autoStackCol($result, "HQReceivedDocFromLBDate");
		$hqtoca 	  = self::autoStackCol($result, "SubmitDocToCADate");
		$careturn 	  = self::autoStackCol($result, "CAReturnDate");
		$hqtolbdate   = self::autoStackCol($result, "HQSentToLBDate");
		$lbreceived   = self::autoStackCol($result, "BranchReceivedDate");
		$totals		  = array_merge($lbsubmitdate, $hqgetdoc, $hqtoca, $careturn, $hqtolbdate, $lbreceived);
	
	
		foreach ($lbsubmitdate as $index => $value) {
				
			if(!$lbsubmitdate[$index] == 'FALSE') {
	
				if(!$hqgetdoc[$index] == 'FALSE') {
						
					if(!$careturn[$index] == 'FALSE') {
	
						if(!$hqtolbdate[$index] == 'FALSE') {
								
							if(!$lbreceived[$index] == 'FALSE') {
								
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
					return'<i class="fa fa-circle" style="color: #666666; font-size: 1.5em; cursor: pointer;"></i>';
				}
					
			} else {
				return '<i class="fa fa-circle" style="color: #666666; font-size: 1.5em; cursor: pointer;"></i>';
			}
				
		}
	
	}
	*/
		
	// Defend Reconcile
	public function setDefnedListRecords() {
		header("Content-Type: application/json");
		
		$this->load->model('dbmanagement');
		$this->load->library('effective');
		
		try {
				
			$results = $this->dbmanagement->getDefendListRecorder($this->authorized, array($this->emp_id));
			$iTotal  = $this->dbmanagement->getDefendListPagination($this->authorized, array($this->emp_id));
			
	
			foreach($results['data'] as $index => $value) {

				$fill = !empty($results['data'][$index]['Fill_Item']) ? $results['data'][$index]['Fill_Item']:"0";
				$max  = !empty($results['data'][$index]['Lists']) ? $results['data'][$index]['Lists']:"0";

				if($results['data'][$index]['DefendDate'] != "" && $results['data'][$index]['StatusDate'] != "" && $results['data'][$index]['Status']  == 'A' || $results['data'][$index]['Status']  == 'C' || $results['data'][$index]['Status']  == 'R'):
					$day_diff = self::compare_date(array('begin'=> $results['data'][$index]['DefendDate'], 'end'=> !empty($results['data'][$index]['StatusDate']) ? $results['data'][$index]['StatusDate']:date('Y-m-d')));;
				else:
					$day_diff = self::compare_date(array('begin'=> $results['data'][$index]['DefendDate'], 'end'=> date('Y-m-d')));
				endif;
				
				$cust_name	= !empty($results['data'][$index]['BorrowerName']) ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BorrowerName']):$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['OwnerName']);
				$ca_comment = !empty($results['data'][$index]['AppComment']) ? str_replace('"', '', $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['AppComment'])):"-";
				$defend_by	= !empty($results['data'][$index]['DefendBy']) ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['DefendBy']):"";
				
				// List Stack
				
				if($fill != '0' || $max != '0') :
					$list_doc = '( ' . $fill . ' / ' . $max . ' )';
				else:
					$list_doc = '';
				endif;
				
					
				$columns[] = array(
						"DocID"			 	=> $results['data'][$index]['DocID'],
						"DefendDate" 	 	=> $this->effective->StandartDateRollback($results['data'][$index]['DefendDate']),
						"LatestUpdateItem" 	=> $this->effective->StandartDateRollback($results['data'][$index]['LatestUpdateItem']),
						"FlagDay" 	 		=> self::setNumColorLightStatus($day_diff),
						"Times"				=> $results['data'][$index]['COUNTNUM'],
						"Fill_Item"		 	=> $list_doc,
						"BranchDigit"	 	=> '<abbr title="Phone : '.$results['data'][$index]['BranchTel'].'" style="border:none;">'.$results['data'][$index]['BranchDigit'].'</abbr>',
						"RMName"		 	=> '<abbr title="Phone : '.$results['data'][$index]['RMMobile'].'" style="border:none;">'.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['RMName']).'</abbr>',
						"BorrowerName"		=> '<abbr title="Phone : '.$results['data'][$index]['Mobile'].'" style="border:none;">'.$cust_name.'</abbr>',
						"DefendBy"			=> '<abbr title="Phone : '.$results['data'][$index]['DefendMobile'].'" style="border:none;">'.$defend_by.'</abbr>',
						"CAName"			=> '<abbr title="comment : '.$ca_comment.'" style="border: 0px;" class="nonprint">'.$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['CAName']).'</abbr>' . '<div class="printable hidden">',
						"DefendProcess"		=> !empty($results['data'][$index]['DefendModule']) ? '<abbr title="'.$results['data'][$index]['DefendProcess'].'" style="border:none;">'.$results['data'][$index]['DefendModule'].'</abbr>':"",
						"Status"			=> !empty($results['data'][$index]['Status']) ? $results['data'][$index]['Status']:"",
						"StatusDate" 	 	=> $this->effective->StandartDateRollback($results['data'][$index]['StatusDate']),
						"StatusReason" 	 	=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['StatusReason']),
						"Links"				=> '<a class="nonprint" href="'.site_url('defend_control/getIssueReasonList').'?mod=1&cache=false&secure='.md5(date('s')).'&rel='.$results['data'][$index]['DocID'].'&lnx='.$results['data'][$index]['Times'].'&t=53&whip=true&enable=true&editor=true&clw=false" target="_blank"><i class="icon-new-tab"></i></a>'
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
	
	
}