<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Management extends MY_Controller {
	
	// Variable Path
	public $pages_default;
	public $pages_customiz;
	
	public function __construct() {
		parent::__construct();
		
		$this->pages_default	= "frontend/metro";
		$this->pages_customiz	= "frontend/content/pages/";
		
		$this->sessid        = $this->session->userdata("session_id");
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
		$this->pilot		 = $this->session->userdata("pilot");

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
				"auth"       => $this->authorized,
				"role"		 => $this->getRole($this->authorized[0], $this->branch_code),
				"pilot"		 => $this->pilot
		);
		
		if(empty($this->authorized[0])):
			redirect('authen/logout');
		endif;
		
	}
	
	// Function
	// prepare handle
	public static function prepareInput($handles) {
		if (!empty($handles)) return $handles;
		else return null;
	}
	
	private static function prepareChecked($handles) {
		if (!empty($handles)) return $handles;
		else return null;
	
	}

	// Simulator
	private function getRole($role, $branch_code) {
		
		if(!empty($role)) {
			switch ($role) {
				case $this->config->item('ROLE_ADMIN'):
					if($branch_code == '000') return 'admin_role';
					else return 'adminbr_role';
					
					break;
				case $this->config->item('ROLE_RM'):
					return 'rm_role';
					break;
				case $this->config->item('ROLE_BM'):
					return 'bm_role';
					break;
				case $this->config->item('ROLE_AM'):
					return 'am_role';
					break;
				case $this->config->item('ROLE_RD'):
					return 'rd_role';
					break;
				case $this->config->item('ROLE_ADMINSYS'):
					return 'dev_role';
					break;
				case $this->config->item('ROLE_SPV'):
				case $this->config->item('ROLE_HQ'):
				default:
					return 'hq_role';
					break;
			}
			
		}
		
	}
	
	public function getActionList() {
		$this->load->model('dbmodel');
		$this->load->model('dbstore');
	
		$this->load->view($this->pages_customiz.'defend_note/sfe_note', $this->data);
	}
	
	// VERSION 2
	public function getPageVerificationManagement() {
		$this->load->model('dbmodel');
		$this->load->model('dbstore');
		
		$doc_id						= $this->input->get('rel');		
		$this->data['getCustInfo']  = $this->getCustomerInformation($doc_id);
		
		$this->pages 				= "form/update_new/Process_2_v2/process_management";
		
		$script_version				= '.js?v=001';
		$this->data['stylesheet']	= array('scrollbar/jquery.scrollbar', 'vendor/jquery.multiselect', 'multi-select/multiple-select', 'custom/verified_new_process', 'custom/bsi', 'custom/form', 'custom/check_progress', 'floatmenu/contact-buttons', 'themify-icons', 'custom/tooltip_custom', 'webui-popover/jquery.webui-popover');
		$this->data['javascript']	= array(
			'scrollbar/jquery.scrollbar.min', 
			'vendor/src/jquery.multiselect.min', 
			'vendor/jquery.multiple.select', 
			'moment.min', 
			'vendor/jquery.truncate.min', 
			'vendor/jquery.number.min', 
			'vendor/jquery.mask.min',
			'vendor/jquery.cookie', 
			'plugin/floatmenu/jquery.contact-buttons', 
			'plugin/floatmenu/leftmenu' . $script_version, 
			'plugin/webui-popover/jquery.webui-popover.min',
			'build/form/process_management/process_2_new/process2' . $script_version
		);
		
		$this->_renders($this->pages_default, 'customiz');
	}
	
	
	// VERSION 1
	public function getDataVerifiedManagement() {
		$this->load->model('dbmodel');
		$this->load->model('dbstore');
		
		$doc_id						= $this->input->get('rel');
		
		$this->data['getFlag']		= $this->getFlagOnValidation($doc_id);
		$this->data['getCustInfo']  = $this->getCustomerInformation($doc_id);
		$this->data['getVerify']    = $this->getVerifyInfo($doc_id);
		$this->data['NCBConsent']	= $this->getNCBConsentData($doc_id);
		$this->data['DocFlow']		= $this->getDataReconcileDoc($doc_id);
		$this->data['rmlogs']		= $this->getTransactionRMLogs($doc_id);
		$this->data['RmReason']		= $this->getCancelReasonLists($doc_id);
		$this->data['CustReason']	= $this->getCustCancelReasonLists($doc_id);
		$this->data['ActionLogs']	= $this->getActionNoteLogs($doc_id);
		$this->data['AppStatus']	= $this->dbmodel->CIQuery("SELECT [ApplicationNo], [CA_ReceivedDocDate], [Status], [StatusDate] FROM ApplicationStatus WHERE DocID = '".$doc_id."'");
		
		$this->data['ListRetrieve']	= $this->getRetrieveReason();
		
		// View: Retrieve Logs
		$this->data['getDocRetr']	= $this->getDataRetrieveLog($doc_id);
		$this->data['getSFEList']	= $this->getGroupSFEList();
		
		// Check Document Expired
		$this->data['DocExpired']	= $this->getDocExpiredValid($doc_id);
		$this->data['user_role']	= $this->getRole($this->authorized[0], $this->branch_code);
				
		// Defend
		$this->data['getDefend']	= $this->getDefendInfo($doc_id);
		$this->data['getDefendNum']	= $this->getDefendCount($doc_id);
		$this->data['DefProcess']	= $this->getDefendProcessList($doc_id);
		$this->data['BPMAppTime']	= $this->getSDEInfo($doc_id);
	
						
		$this->data['char_mode']	= $this->char_mode;
		
		$this->pages 				= "form/update_new/process_2/verified_management";

		$script_version				= '.js?v=006';
		$this->data['stylesheet']	= array('scrollbar/jquery.scrollbar', 'vendor/jquery.multiselect', 'multi-select/multiple-select', 'custom/verified_new_process', 'custom/bsi', 'custom/form', 'custom/check_progress', 'floatmenu/contact-buttons', 'themify-icons', 'custom/tooltip_custom', 'webui-popover/jquery.webui-popover');
		$this->data['javascript']	= array('scrollbar/jquery.scrollbar.min', 'vendor/src/jquery.multiselect.min', 'vendor/jquery.multiple.select', 'moment.min', 'vendor/jquery.truncate.min', 'vendor/jquery.number.min', 'vendor/jquery.mask.min', 
				'vendor/jquery.cookie', 'build/form/process_management/process_2/verified_lastest' . $script_version, 'build/form/process_management/process_2/verified_lastest_validation'  . $script_version, 'build/form/process_management/process_2/switch_borrower' . $script_version,  'build/form/process_management/process_2/retrieve_script' . $script_version,
				'plugin/floatmenu/jquery.contact-buttons', 'plugin/floatmenu/leftmenu' . $script_version, 'build/form/process_management/process_2/reasonChooser' . $script_version, 'build/form/process_management/process_2/verified_rmprocess' . $script_version, 'plugin/webui-popover/jquery.webui-popover.min', 'build/form/process_management/process_2/defend' . $script_version);
				
		$this->_renders($this->pages_default, 'customiz');
		
	}
	
	//MODIFY: NEW METHOD VERIFICATION FOR PREVIEW
	public function getDataVerifiedPreview() {
		$this->load->model('dbmodel');
		$this->load->model('dbstore');
		$this->load->library('effective');
	
		$doc_id						= $this->input->get('rel');
	
		$this->data['getFlag']		= $this->getFlagOnValidation($doc_id);
		$this->data['getCustInfo']  = $this->getCustomerInformation($doc_id);
		$this->data['getVerify']    = $this->getVerifyInfo($doc_id);
		$this->data['NCBConsent']	= $this->getNCBConsentData($doc_id);
		$this->data['DocFlow']		= $this->getDataReconcileDoc($doc_id);
		$this->data['rmlogs']		= $this->getTransactionRMLogs($doc_id);
		$this->data['RmReason']		= $this->getCancelReasonLists($doc_id);
		$this->data['CustReason']	= $this->getCustCancelReasonLists($doc_id);
		$this->data['ActionLogs']	= $this->getActionNoteLogs($doc_id);
		$this->data['RevisitList']	= $this->getReActivateList($doc_id);
		
		$this->data['getDefend']	= $this->getDefendInfo($doc_id);
		$this->data['ListRetrieve']	= $this->getRetrieveReason();
		
		// Defend
		$this->data['getDefendNum']	= $this->getDefendCount($doc_id);
		$this->data['DefProcess']	= $this->getDefendProcessList($doc_id);
		
		// View: Retrieve Logs
		$this->data['getDocRetr']	= $this->getDataRetrieveLog($doc_id);
		$this->data['user_role']	= $this->getRole($this->authorized[0], $this->branch_code);
	
		$this->data['char_mode']	= $this->char_mode;
			
		$this->pages 				= "form/update_new/process_2/verified_preview";
	
		$script_version				= '.js?v=005';
		$this->data['stylesheet']	= array('responsive/bootstrap.min', 'custom/verified_new_process', 'custom/bsi', 'custom/form', 'custom/check_progress', 'floatmenu/contact-buttons', 'custom/tooltip_custom', 'themify-icons', 'webui-popover/jquery.webui-popover');
		$this->data['javascript']	= array('responsive/bootstrap.min', 'vendor/jquery.truncate.min', 'moment.min', 'vendor/jquery.number.min', 'vendor/jquery.mask.min', 'vendor/jquery.cookie', 
											'plugin/floatmenu/jquery.contact-buttons', 'build/form/process_management/process_2/verified_preview' . $script_version, 'plugin/webui-popover/jquery.webui-popover.min');
	
		$this->_renders($this->pages_default, 'customiz');
	
	}

	public function getDataVerificationInRetrieve() {
		$this->load->model('dbmodel');
		$this->load->model('dbstore');
		$this->load->library('effective');
		
		$doc_id						= $this->input->get('rel');
		
		$this->data['getFlag']		= $this->getFlagOnValidation($doc_id);
		$this->data['getCustInfo']  = $this->getCustomerInformation($doc_id);
		$this->data['getVerify']    = $this->getVerifyInfo($doc_id);
		$this->data['NCBConsent']	= $this->getNCBConsentData($doc_id);
		$this->data['DocFlow']		= $this->getDataReconcileDoc($doc_id);
		$this->data['rmlogs']		= $this->getTransactionRMLogs($doc_id);
		$this->data['RmReason']		= $this->getCancelReasonLists($doc_id);
		$this->data['CustReason']	= $this->getCustCancelReasonLists($doc_id);
		$this->data['ActionLogs']	= $this->getActionNoteLogs($doc_id);
		$this->data['RevisitList']	= $this->getReActivateList($doc_id);
		
		$this->data['getDefend']	= $this->getDefendInfo($doc_id);
		$this->data['getSFEList']	= $this->getGroupSFEList();
		
		$this->data['char_mode']	= $this->char_mode;
		
		// View: Retrieve Logs
		$this->data['getDocRetr']	= $this->getDataRetrieveLog($doc_id);
		
		$this->pages 				= "form/history_form/process_2/verification_form";
		
		$this->data['stylesheet']	= array('responsive/bootstrap.min', 'custom/verified_new_process', 'custom/bsi', 'custom/form', 'custom/check_progress', 'themify-icons');
		$this->data['javascript']	= array('responsive/bootstrap.min', 'vendor/jquery.truncate.min', 'moment.min', 'vendor/jquery.number.min', 'vendor/jquery.mask.min', 'vendor/jquery.cookie', 'build/form/process_management/process_2/verified_preview');
	
		$this->_renders($this->pages_default, 'customiz');
	}
	
	public function getDocExpiredValid($doc_id) {
		$this->load->model('dbmodel');
		
		if(empty($doc_id)) {
			return array('data' => array(0), 'status' => fasle, 'msg' => 'Not Found');
			
		} else {
			
			return $this->dbmodel->CIQuery("				
				SELECT * FROM (
					SELECT * FROM ActionNote
					WHERE ActionNote.DocID = '".$doc_id."'
					AND ActionNote LIKE '%CN003%'
					AND ActionName = 'System'
					UNION
					SELECT * FROM SystemNoteLog
					WHERE DocID = '".$doc_id."'
					AND ActionNote LIKE '%CN003%'
					AND ActionName = 'System'
				) A			
			");			
			
		}

	}
	
	public function getSDEInfo($doc_id) {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$this->db_env = $this->config->item('database_env');
		
		if(!empty($doc_id)) {

			$objList['data'] = array();
			if($this->db_env == 'production') {
				$result = $this->dbmodel->CIQuery("
					SELECT TOP 1 DATEDIFF(DAY, [dbo].[DateOnlyFormat](ACD_ReceiveDate), [dbo].[DateOnlyFormat](GETDATE())) A2CA_TIME
					FROM vSDE_CA
					LEFT OUTER JOIN vSDE_STATUS ON vSDE_CA.ACD_AppNo = vSDE_STATUS.AppNo
					LEFT OUTER JOIN ApplicationStatus ON vSDE_CA.ACD_AppNo = ApplicationStatus.ApplicationNo COLLATE Thai_CI_AI
					WHERE ApplicationStatus.DocID = '".$doc_id."'
					ORDER BY ACD_Approver DESC
				");
			} else {
				$result['data'] = array();
			}
						
			$objList['data']    = $result['data'];
			$objList['status']	= true;
			$objList['msg']		= 'query successfully.';
			
			return $result;
			
		} else {
			return array('data' => array(0), 'status' => false, 'msg' => 'Not Found.');
		}
		
	}
	
	/**
	 Supplement: loadSFEActionNote
	*/
	
	public function setEmployeeRelation($position, $condition = array()) {
		$this->load->model('dbmanagement');
		$result = $this->dbmanagement->getEmployeeRelation($position, $condition);
		
		return $result;
		
	}
	
	public function getCreateActor($doc_id, $list_lot) {
		$this->load->model('dbmanagement');
		
		if(empty($doc_id)):
			return;
		else:
			$result = $this->dbmanagement->getActorInfo($doc_id, $list_lot);
			return $result;
		endif;
		
	}
	
	public function getCancelReasonLists($doc_id) {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		if(empty($doc_id)):
			return;
		else:
		
			$result = $this->dbmodel->CIQuery("
				SELECT DocID, MasterCode, DefendReason, CancelTypes, OtherDetail
				FROM CancelReasonList
				LEFT OUTER JOIN MasterDefendReason
				ON CancelReasonList.MasterCode = MasterDefendReason.DefendCode	
				WHERE DocID = '".$doc_id."'
				AND CancelReasonList.IsActive = 'A'
			");
		
			if(empty($result['data'][0]['DocID'])) {				
				return array('data' => array(0), 'status' => false, 'msg' => 'Not Found.');
				
			} else {
				
				$objList['data'] = array();
				foreach ($result['data'] as $index => $value) {
					array_push($objList['data'], array(
							"DocID" 	   => $result['data'][$index]['DocID'],
							"MasterCode"   => $result['data'][$index]['MasterCode'],
							"MasterReason" => $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['DefendReason']),
							"OtherReason"  => $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['OtherDetail']),
							"CancelTypes"  => $result['data'][$index]['CancelTypes']
						)
					);	
				}
				
				$objList['status']	= true;
				$objList['msg']		= 'query successfully.';
				
				return $objList;
				
			}
		
		endif;
		
	}
	
	public function getCustCancelReasonLists($doc_id) {		
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		if(empty($doc_id)):
			return;
		else:
		
		$result = $this->dbmodel->CIQuery("
			SELECT DocID, CancelReasonListByCust.MasterCode, MasterProcessCancelReason.ProcessReason AS MasterReason, 
			CancelReasonListByCust.OtherDetail, CancelReasonListByCust.CancelTypes
			FROM CancelReasonListByCust
			LEFT OUTER JOIN MasterProcessCancelReason
			ON CancelReasonListByCust.MasterCode = MasterProcessCancelReason.ProcessCode				
			WHERE DocID = '".$doc_id."'
			AND CancelReasonListByCust.IsActive = 'A'
			AND CancelReasonListByCust.CancelTypes = 'CANCELBYCUS'
		");
		
		if(empty($result['data'][0]['DocID'])) {
			return array('data' => array(0), 'status' => false, 'msg' => 'Not Found.');
		
		} else {
		
			$objList['data'] = array();
			foreach ($result['data'] as $index => $value) {
				array_push($objList['data'], array(
						"DocID" 	   => $result['data'][$index]['DocID'],
						"MasterCode"   => $result['data'][$index]['MasterCode'],
						"MasterReason" => $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['MasterReason']),
						"OtherReason"  => $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['OtherDetail']),
						"CancelTypes"  => $result['data'][$index]['CancelTypes']
					)
				);
			}
		
			$objList['status']	= true;
			$objList['msg']		= 'query successfully.';
		
			return $objList;
		
		}
		
		endif;
		
	}
		
	public function getDefendHelper($doc_id) {
	
		if(empty($doc_id)):
			return;
		else:
			$result = $this->dbmanagement->getDefendListHelper($doc_id);
			return $result;
		endif;
	
	
	}
	
	public function setDefendNoteLists($doc_id, $list_lot) {
		$this->load->model('dbmanagement');
		
		if(empty($doc_id) || empty($list_lot)):
			return;
		else:
		
			$result = $this->dbmanagement->getDefendItemList($doc_id, $list_lot);
			return $result;
		
		endif;
		
	}
	
	public function setDefendNoteOther($doc_id, $list_ref) {
		$this->load->model('dbmodel');
		
		if(empty($doc_id) || empty($list_ref)):
			return;
		else:
			$result = $this->dbmodel->loadData('DefendHead', "CASE DefendDate WHEN '1900-01-01' THEN '' ELSE CONVERT(nvarchar(10), DefendDate, 120) END AS DefendDate, DefendSubject, DefendSupplement, CreateBy, CASE CreateDate WHEN '1900-01-01' THEN '' ELSE CONVERT(nvarchar(10), CreateDate, 120) END AS CreateDate, UpdateBy, RIGHT(CONVERT(VARCHAR(20), UpdateDate, 113), 8) AS UpdateTime, CASE UpdateDate WHEN '1900-01-01' THEN '' ELSE CONVERT(nvarchar(10), UpdateDate, 120) END AS UpdateDate, LastUpdateBy, CASE LastUpdateDate WHEN '1900-01-01' THEN '' ELSE CONVERT(nvarchar(10), LastUpdateDate, 120) END AS LastUpdateDate, RIGHT(CONVERT(VARCHAR(20), LastUpdateDate, 113), 8) AS LastUpdateTime", array("DocID" => $doc_id, "DefendRef" => $list_ref), false);
			return $result;
		
		endif;
	}

	public function setDefendListLogs($doc_id, $list_lot) {
		$this->load->model('dbmanagement');
		
		if(empty($doc_id) || empty($list_lot)):
			return;
		else:
			
			$result = $this->dbmanagement->getDefenListLogs($doc_id, $list_lot);
			return $result;
		
		endif;
	}
	
	// End
	// Verification: Defend Part
	public function loadSFEOnDefendPages() {
		$this->load->model('dbmodel');
		$this->load->model('dbstore');
		
		$doc_id		= $this->input->get('rel');
		$list_lot	= $this->input->get('lnx');
		
		// Supplement Information
		$this->data['getBorrower']	   = $this->getBorrowerNameRelation($doc_id, '101');
		$this->data['getCustInfo']     = $this->getCustomerInformation($doc_id);
		$this->data['getBMInfo']       = $this->setEmployeeRelation('BM', array($this->data['getCustInfo']['RegionID'], $this->data['getCustInfo']['BranchCode']));
		$this->data['getAMInfo']       = $this->setEmployeeRelation('AM', array($this->data['getCustInfo']['RegionID'], $this->data['getCustInfo']['BranchCode']));
		$this->data['getRDInfo']       = $this->setEmployeeRelation('RD', array($this->data['getCustInfo']['RegionID'], $this->data['getCustInfo']['BranchCode']));
		
		$caname_information			   = !empty($this->data['getCustInfo']['CAName']) ? $this->effective->set_chartypes($this->char_mode, $this->data['getCustInfo']['CAName']):"";
		$this->data['ca_info']		   = $this->getDataCAInfo($caname_information);
		$this->data['getSFEList']	   = $this->getGroupSFEList();
		$this->data['getSFEDataList']  = $this->getSFEDataList();

		// Defend List
		$this->data['getSFEActor']	   = $this->getCreateActor($doc_id, $list_lot);
		$this->data['getDefendHelper'] = $this->getDefendHelper($doc_id);
		$this->data['getDefendList']   = $this->setDefendNoteLists($doc_id, $list_lot);		
		$this->data['getDefendOther']  = $this->setDefendNoteOther($doc_id, $list_lot);
		$this->data['getDefendLogs']   = $this->setDefendListLogs($doc_id, $list_lot);

		$this->load->view($this->pages_customiz.'defend_note/sfe_defend_news', $this->data);

	}
	
	// ERROR TRACKING
	public function gridErrorTrack() {
		$this->load->model('dbmodel');
		$this->load->model('dbstore');
		
		$doc_id  = $this->input->get('rel');
		$doc_ref = $this->input->get('rfx');
		$hasType = $this->input->get('hasType');
		
		if($hasType == '1'):
			$has_condition = array('Onbehalf_ID' => $hasType);
		else:
			$has_condition = false;
		endif;
		
		$this->data['getCustInfo']    = $this->getCustomerTabInformation($doc_id,  $doc_ref);
		$this->data['getTrackerList'] = $this->getDataTrackList($doc_id, $doc_ref);
		$this->data['getListRows']	  = $this->dbmodel->getNumRecords('DocumentErrorTrackSubscription', 'RowID', false);
		
		$this->load->view($this->pages_customiz.'track/error_track', $this->data);
		
	}
	
	
	public function getFlagOnValidation($doc_id) {
		$this->load->model('dbmodel');
		$checked = $this->dbmodel->data_validation('NCBConsent', 'DocID', array('DocID' => $doc_id), false);
		if($checked == 'FALSE') {
			return 0;
		} else {
			return 1;
		}
		
		
	}
	
	// Process Management
	private function ReActivateGenerate($branch_code) {
		$this->load->model("dbmodel");
	
		if(empty($branch_code)) {
				
			return array(
					"Runno"		=> '',
					"IsCheck"	=> FALSE,
					"msg"		=> "Branch code is empty."
			);
				
		} else {

			$checked    = $this->dbmodel->loadData($this->table_masterrevisit, "BranchCode, [Year]", array("BranchCode" => $branch_code, "[Year]" => date("Y")));
			if($checked['status'] == "false") {
				$result = $this->dbmodel->exec($this->table_masterrevisit, array("BranchCode" => $branch_code, "[Year]" => date("Y"), "Runno" => "1", "IsActive" => 'A'), false, "insert");
				if($result == TRUE)  {
					$doc_id = $this->dbmodel->loadData($this->table_masterrevisit, "Runno", array("BranchCode" => $branch_code, "[Year]" => date("Y")));
					return array("Runno" => $doc_id['data'][0]['Runno'], "IsCheck" => TRUE, "msg" => "");
	
				}
				else throw new Exception("Error exception: Table ".__function__." is insert missing... ");
	
	
			} else {
				$doc_id = $this->dbmodel->loadData($this->table_masterrevisit, "Runno", array("BranchCode" => $branch_code, "[Year]" => date("Y")));
				return array("Runno" => $doc_id['data'][0]['Runno'], "IsCheck" => TRUE, "msg" => "");
					
			}
			
		}
	
	}

	
	// WRITE LOG
	protected function onWriteNCBBundledLogs($data_stack) {	
	
		$data_bundled = array();
		for($index = 0; $index <= count($data_stack['BorrowerType']); $index++) {
			
			if(empty($data_stack['BorrowerType'][$index]) && empty($data_stack['ReturnDate'][$index])) {
				continue;
					
			} else {
			
				array_push($data_bundled, array(
						"VerifyID"			=> $data_stack['VerifyID'],
						"BorrowerType"		=> $data_stack['BorrowerType'][$index],
						"BorrowerName"		=> $this->effective->set_chartypes($this->char_mode, $data_stack['BorrowerName'][$index]),
						"NCBCheck"			=> $data_stack['NCBCheck'][$index],
						"NCBCheckDate"		=> $this->effective->StandartDateSorter($data_stack['NCBCheckDate'][$index]),
						"SubmitToHQ"		=> $this->effective->StandartDateSorter($data_stack['SubmitToHQ'][$index]),
						"HQReceivedFromLB"	=> $this->effective->StandartDateSorter($data_stack['HQReceived'][$index]),
						"HQSubmitToOper"	=> $this->effective->StandartDateSorter($data_stack['SubmitToOper'][$index]),
						"OperReturn"		=> !empty($data_stack['ReturnDate'][$index]) ? 'Y':'N',
						"OperReturnDate"	=> $this->effective->StandartDateSorter($data_stack['ReturnDate'][$index]),
						"IsActive"			=> 'A',
						"Event_Type"		=> !empty($data_stack['Event_Type'][$index]) ? $data_stack['Event_Type'][$index]:NULL,
						//"IsRef"			=> $data_stack['IsRef'][$index],
						"CreateBy"			=> $this->effective->set_chartypes($this->char_mode, $this->name),
						"CreateDate" 		=> date("Y-m-d H:i:s")
				));
					
			}
			
			
		}		
				
		if(!empty($data_bundled[0]['BorrowerType']) && !empty($data_bundled[0]['OperReturnDate'])) {
		
			foreach ($data_bundled as $index => $values) {
				$this->dbmodel->exec("NCBConsentLogs", $data_bundled[$index], false, 'insert');
		
			}
				
		}
	
	}
	
	protected function onWriteReconcileBundledLogs($data_stack) {
		$this->load->library('effective');
		

		$data_bundled = array();
		for($index = 0; $index <= count($data_stack['BorrowerType']); $index++) {
		
			if(empty($data_stack['SubmitDocToHQ'][$index]) && empty($data_stack['AppToCA'][$index])) {
				continue;
					
			} else {
		
				array_push($data_bundled, array(
						"DocID"				=> $data_stack['DocID'],
						"BorrowerType"		=> $data_stack['BorrowerType'][$index],
						"BorrowerName"		=> $this->effective->set_chartypes($this->char_mode, $data_stack['BorrowerName'][$index]),
						"LogisticCode"		=> $data_stack['LogisticCode'][$index],
						"SubmitDocToHQ"		=> $this->effective->StandartDateSorter($data_stack['SubmitDocToHQ'][$index]),
						"ReceivedDocFormLB"	=> $this->effective->StandartDateSorter($data_stack['ReceivedDocFormLB'][$index]),
						"CompletionDoc"		=> $data_stack['CompletionDoc'][$index],
						"CompletionDate"	=> $this->effective->StandartDateSorter($data_stack['ReceivedDocFormLB'][$index]).' '.date('H:i:s'),
						"AppToCA"			=> $this->effective->StandartDateSorter($data_stack['AppToCA'][$index]),
						"CAReturn"			=> !empty($data_stack['CAReturnDate'][$index]) ? 'Y':'N',
						"CAReturnDate"		=> $this->effective->StandartDateSorter($data_stack['CAReturnDate'][$index]),
						"IsActive"			=> 'A',
						"Event_Type"		=> $data_stack['Event_Type'][$index],
						"CreateBy"			=> $this->effective->set_chartypes($this->char_mode, $this->name),
						"CreateDate" 		=> date("Y-m-d H:i:s")
				));
					
			}
		
		}
		
		if(!empty($data_bundled[0]['SubmitDocToHQ']) && !empty($data_bundled[0]['AppToCA'])) {
		
			foreach ($data_bundled as $index => $values) {
				$this->dbmodel->exec("ReconcileDocLogs", $data_bundled[$index], false, 'insert');
		
			}
		
		}
			
	}
	
	public function setWriteDocumentManagementLogs($data_stack) {
		$this->load->library('effective');
		
		$table_reconcile = 'ReconcileCompletionLogs';
		header('Content-Type: text/html; charset="UTF-8"');
		
		foreach($data_stack as $index => $values) {
			unset($data_stack[$index]['IsRef']);
				
			$completion_doc = $this->dbmodel->data_validation($table_reconcile, "*",
					array("DocID"    		=> $data_stack[$index]['DocID'],
							"DocType"  		=> $data_stack[$index]['DocType'],
							"DocList"  		=> $data_stack[$index]['DocList'],
							"LBSubmitDocDate" => $data_stack[$index]['LBSubmitDocDate'],
							"IsActive" 		=> 'A'), array( "DocOther" => $data_stack[$index]['DocOther']));
		
					if($completion_doc == 'TRUE'):
						
					$data_stack[$index]["ChangeDocBy"] 	   = $this->effective->set_chartypes($this->char_mode, $this->name);
					$data_stack[$index]["ChangeDocDate"]   = date("Y-m-d H:i:s");
						
					$log_state = $this->dbmodel->exec($table_reconcile, $data_stack[$index],
							array("DocID" 	 		=> $data_stack[$index]['DocID'],
									"DocType"  		=> $data_stack[$index]['DocType'],
									"DocList"  		=> $data_stack[$index]['DocList'],
									"LBSubmitDocDate" => $data_stack[$index]['LBSubmitDocDate'],
									"DocOther"  		=> $data_stack[$index]['DocOther']), 'update');
								
							else:
		
							$data_stack[$index]["CreateDocBy"] 	   = $this->effective->set_chartypes($this->char_mode, $this->name);
							$data_stack[$index]["CreateDocDate"]   = date("Y-m-d H:i:s");
								
							$log_state = $this->dbmodel->exec($table_reconcile, $data_stack[$index], false, 'insert');
		
							endif;
								
		}
				
	}
	
	// STACK ARRAY
	private function setNewJoinLoan($data_stack = array(), $condition) {
		
		try {
			
			foreach($data_stack as $index => $values) {

				$verified_checked = $this->dbmodel->data_validation("NCBConsent", "VerifyID", array("DocID" => $condition, 'IsRef' => $data_stack[$index]['IsRef']), false);
				if($verified_checked == 'TRUE'):
					$ncb_cstate = $this->dbmodel->exec("NCBConsent", $data_stack[$index], array("DocID" => $condition, 'IsRef' => $data_stack[$index]['IsRef']), 'update');
				else:
					$ncb_cstate = $this->dbmodel->exec("NCBConsent", $data_stack[$index], false, 'insert');
				endif;		
				
			}
			
			if($ncb_cstate == TRUE):
				$this->setBorrowerListLogs($data_stack);
				return TRUE;
			else:
				return FALSE;
			endif;
			
			
		} catch (Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
			
		}
		
	}
	
	private function setBorrowerListLogs($data_stack = array()) {
		
		if(count($data_stack) > 0) {
			try {
				
				foreach($data_stack as $index => $values) {
					$data_stack[$index]["CreateBy"]	  = $this->effective->set_chartypes($this->char_mode, $this->name);
					$data_stack[$index]["CreateDate"] = date("Y-m-d H:i:s");
					$ncb_cstate = $this->dbmodel->exec("NCBConsentSubmitHandledLogs", $data_stack[$index], false, 'insert');
				}
				
				if($ncb_cstate == TRUE):
				return TRUE;
				else:
				return FALSE;
				endif;
				
				
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
				
			}
		}

	}
	
	private function OnDataRelationToReconcile($data_stack = array(), $condition) {
	
		
		$data = array();
		foreach($data_stack as $index => $values) {
			
			array_push($data, array(
				"DocID" 	   => $data_stack[$index]['DocID'],
				"BorrowerName" => $data_stack[$index]['BorrowerName'],
				"BorrowerType" => $data_stack[$index]['BorrowerType'],
				"IsActive"	   => 'A',
				"IsRef"		   => $data_stack[$index]['IsRef']
				)
			);
			
			
		}
		
		if(!empty($data)) {
		
			try {

				foreach($data as $index => $values) {
						
					$reconcile_checked = $this->dbmodel->data_validation("ReconcileDoc", "DocID", array("DocID" => $condition, 'IsRef' => $data_stack[$index]['IsRef']), false);
					if($reconcile_checked == 'TRUE'):
						$reconcile_state = $this->dbmodel->exec("ReconcileDoc", $data[$index], array("DocID" => $condition, 'IsRef' => $data_stack[$index]['IsRef']), 'update');
					else:
						$reconcile_state = $this->dbmodel->exec("ReconcileDoc", $data[$index], false, 'insert');
					endif;
					
				}
				
				if($reconcile_state == TRUE):
					return TRUE;
				else:
					return FALSE;
				endif;
				
				
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
			
		} else {
			return FALSE;
			
		}
		
		
	}
	
	private function setReconcileDoc($data_stack, $condition, $department) {
		
		$auth_limit		= array('adminbr_role', 'rm_role', 'bm_role', 'am_role', 'rd_role');
		$user_role	 	= $this->getRole($this->authorized[0], $this->branch_code);

		$i = 1;
		$data 	 = array();
		$memory  = array();
		$logs	 = array();
		$MainNCB = array();
		foreach($data_stack['BorrowerName'] as $index => $values) {
				
			if(!empty($data_stack['CAReturnDate'][$index])):
				$careturn = 'Y';
			else:
				$careturn = 'N';
			endif;
			
			//$complete_date = !empty($data_stack['CompletionDoc'][$index]) ? date('Y-m-d'):NULL;
			array_push($data, array(
					"DocID"				=> $condition,
					"BorrowerName"		=> $this->effective->set_chartypes($this->char_mode, $data_stack['BorrowerName'][$index]),
					"BorrowerType"		=> $this->effective->set_chartypes($this->char_mode, $data_stack['BorrowerType'][$index]),
					"LogisticCode"		=> !empty($data_stack['LogisticCode'][$i]) ? $data_stack['LogisticCode'][$i]:"",
					"SubmitDocToHQ" 	=> (!empty($data_stack['SubmitDocToHQ'][$index])) ? $this->effective->StandartDateSorter($data_stack['SubmitDocToHQ'][$index]):NULL,
					"ReceivedDocFormLB" => (!empty($data_stack['ReceivedDocFormLB'][$index])) ? $this->effective->StandartDateSorter($data_stack['ReceivedDocFormLB'][$index]):NULL,
					"CompletionDoc"		=> (!empty($data_stack['CompletionDoc'][$index])) ? $this->prepareInput($data_stack['CompletionDoc'][$index]):NULL,
					"CompletionDate"	=> (!empty($data_stack['CompletionDate'][$index])) ? $this->effective->StandartDateSorter($data_stack['CompletionDate'][$index]):NULL,
					"AppToCA"			=> (!empty($data_stack['AppToCA'][$index])) ? $this->effective->StandartDateSorter($data_stack['AppToCA'][$index]):NULL,
					"CAReturn"			=> $careturn,
					"CAReturnDate"		=> (!empty($data_stack['CAReturnDate'][$index])) ? $this->effective->StandartDateSorter($data_stack['CAReturnDate'][$index]):NULL,
					"IsRef"				=> $data_stack['IsRef'][$index]
				)
			);
			
			array_push($logs, array(
					"DocID"				=> $condition,
					"EventMode"			=> "SUBMIT",
					"BorrowerName"		=> !empty($data_stack['BorrowerName'][$index]) ? $this->effective->set_chartypes($this->char_mode, $data_stack['BorrowerName'][$index]):null,
					"BorrowerType"		=> !empty($data_stack['BorrowerType'][$index]) ? $this->effective->set_chartypes($this->char_mode, $data_stack['BorrowerType'][$index]):null,
					"LogisticCode"		=> !empty($data_stack['LogisticCode'][$i]) ? $data_stack['LogisticCode'][$i]:null,
					"SubmitDocToHQ" 	=> !empty($data_stack['SubmitDocToHQ'][$index]) ? $this->effective->StandartDateSorter($data_stack['SubmitDocToHQ'][$index]):null,
					"ReceivedDocFormLB" => !empty($data_stack['ReceivedDocFormLB'][$index]) ? $this->effective->StandartDateSorter($data_stack['ReceivedDocFormLB'][$index]):null,
					"CompletionDoc"		=> !empty($data_stack['CompletionDoc'][$index]) ? $this->prepareInput($data_stack['CompletionDoc'][$index]):null,
					"AppToCA"			=> !empty($data_stack['AppToCA'][$index]) ? $this->effective->StandartDateSorter($data_stack['AppToCA'][$index]):null,
					"CreateID"			=> trim($this->emp_id),
					"CreateBy"			=> $this->effective->set_chartypes($this->char_mode, $this->name),
					"CreateDate"		=> date('Y-m-d H:i:s')
				)
			);
			
			if(in_array($department, array('SB', 'DRM'))) {
				array_push($memory, array(
						"DocID"				=> $condition,
						"ReceivedDocFormLB" => $this->effective->StandartDateSorter($data_stack['ReceivedDocFormLB'][$index]),
						"CompletionDoc"		=> $this->prepareInput($data_stack['CompletionDoc'][$index]),
						"CompletionDate"	=> $this->effective->StandartDateSorter($data_stack['CompletionDate'][$index]),
						"AppToCA"			=> $this->effective->StandartDateSorter($data_stack['AppToCA'][$index]),
						"CAReturn"			=> $careturn,
						"CAReturnDate"		=> $this->effective->StandartDateSorter($data_stack['CAReturnDate'][$index]),
						"IsRef"				=> $data_stack['IsRef'][$index]
					)
				);
			} else {
				if(in_array($user_role, $auth_limit)) {
					array_push($memory, array(
							"DocID"				=> $condition,
							"LogisticCode"		=> !empty($data_stack['LogisticCode'][$i]) ? $data_stack['LogisticCode'][$i]:"",
							"SubmitDocToHQ" 	=> $this->effective->StandartDateSorter($data_stack['SubmitDocToHQ'][$index]),
							"IsRef"				=> $data_stack['IsRef'][$index]
						)
					);
				
				} else {
					
					if(in_array($user_role, array('dev_role'))) {
						array_push($memory, array(
								"DocID"				=> $condition,
								"LogisticCode"		=> !empty($data_stack['LogisticCode'][$i]) ? $data_stack['LogisticCode'][$i]:"",
								"SubmitDocToHQ" 	=> $this->effective->StandartDateSorter($data_stack['SubmitDocToHQ'][$index]),
								"ReceivedDocFormLB" => $this->effective->StandartDateSorter($data_stack['ReceivedDocFormLB'][$index]),
								"CompletionDoc"		=> $this->prepareInput($data_stack['CompletionDoc'][$index]),
								"CompletionDate"	=> $this->effective->StandartDateSorter($data_stack['CompletionDate'][$index]),
								"AppToCA"			=> $this->effective->StandartDateSorter($data_stack['AppToCA'][$index]),
								"CAReturn"			=> $careturn,
								"CAReturnDate"		=> $this->effective->StandartDateSorter($data_stack['CAReturnDate'][$index]),
								"IsRef"				=> $data_stack['IsRef'][$index]
						)
								);
					} else {
						array_push($memory, array(
								"DocID"				=> $condition,
								"ReceivedDocFormLB" => $this->effective->StandartDateSorter($data_stack['ReceivedDocFormLB'][$index]),
								"CompletionDoc"		=> $this->prepareInput($data_stack['CompletionDoc'][$index]),
								"CompletionDate"	=> $this->effective->StandartDateSorter($data_stack['CompletionDate'][$index]),
								"AppToCA"			=> $this->effective->StandartDateSorter($data_stack['AppToCA'][$index]),
								"CAReturn"			=> $careturn,
								"CAReturnDate"		=> $this->effective->StandartDateSorter($data_stack['CAReturnDate'][$index]),
								"IsRef"				=> $data_stack['IsRef'][$index]
							)
						);
					}
				}
			}
			
			if($data_stack['BorrowerType'][$index] == '101') {
				
				if(!$data_stack['CompletionDoc'][$index] = ""):
					$complete_doc = '1';
				else:
					$complete_doc = '0';
				endif;
				
				if($careturn == 'Y'):
					$doc_state = '1';
				else:
					$doc_state = '0';
				endif;
				
				// UPDATE TABLE NCB
				array_push($MainNCB, array(
						"HQReceiveCADocDate"	=> $this->effective->StandartDateSorter($data_stack['ReceivedDocFormLB'][$index]),
						"CompletionDoc"	  	   	=> $complete_doc,
						"CompletionDocDate" 	=> $this->effective->StandartDateSorter($data_stack['CompletionDate'][$index]),
						"SentDocToCA"         	=> $doc_state,
						"SentToCADate"		  	=> $this->effective->StandartDateSorter($data_stack['AppToCA'][$index])
					)
				);
					
			}

			$i++;
			
		}	
	
		if(!empty($logs[0])) {
			foreach($logs as $index => $values):
				$this->dbmodel->exec("ReconcileDocEventLogs", $logs[$index], false, 'insert');
			endforeach;			
		}
	
		$table_reconciledoc = "ReconcileDoc";
		if(!empty($data)) {
			
			try {
				// UPDATE TABLE NCB
				if(!empty($MainNCB[0])):
					$verification = $this->dbmodel->exec($this->table_verification, $MainNCB[0], array("DocID" => $condition), 'update');
				else:
					$verification = TRUE;
				endif;		
				
				
				// UPDATE TABLE NCB CONSENT
				foreach($data as $index => $values) {
					
					$reconcile_checked = $this->dbmodel->data_validation($table_reconciledoc, "DocID", array("DocID" => $condition, 'IsRef' => $data[$index]['IsRef']), false);
					if($reconcile_checked == 'TRUE') {
										
						$confirm_data = $this->dbmodel->CIQuery("SELECT * FROM $table_reconciledoc WHERE DocID = '".$condition."' ORDER BY BorrowerType ASC, ReconcileDoc.IsRef ASC");
						//print_r(array($data_stack['RecID'][$index], $confirm_data['data'][$index]['Rec_ID'], $memory[$index]));
						
						if(in_array($user_role, $auth_limit)) {
							$reconcile_state = $this->dbmodel->exec($table_reconciledoc, $memory[$index], array('Rec_ID' => $data_stack['RecID'][$index]), 'update');
							
						} else {
							
							if(empty($values['HQReceiveCADocDate']) && empty($values['AppToCA']) && 
							  !empty($confirm_data['data'][$index]['ReceivedDocFormLB']) && !empty($confirm_data['data'][$index]['AppToCA'])) {
							  	$reconcile_state = TRUE;
							  	
							} else {
								$reconcile_state = $this->dbmodel->exec($table_reconciledoc, $memory[$index], array('Rec_ID' => $data_stack['RecID'][$index]), 'update');
								
							}
							
						}
						
					}
					
					//if($reconcile_checked == 'TRUE'): $reconcile_state = $this->dbmodel->exec($table_reconciledoc, $memory[$index], array("DocID" => $condition, 'IsRef' => $data[$index]['IsRef']), 'update'); else: $reconcile_state = $this->dbmodel->exec($table_reconciledoc, $data[$index], false, 'insert'); endif;
					
				}
				
				if($verification == TRUE && $reconcile_state == TRUE):
					return TRUE;
				else:
					return FALSE;
				endif;
					
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			
			}
		
		} else {
			return FALSE;
		}
		
	}
	
	public function setEventRMLogs($verify_id, $process = array(), $name) {
		$this->load->model("dbmodel");
		$this->load->model('dbstore');
		$this->load->library('effective');
		
		$rmLog_checked 	= $this->dbmodel->data_validation('RMProcessLog', "*", array("VerifyID" => $verify_id, "ProcessType" => $process[0], "ProcessDate" => $this->effective->StandartDateSorter($process[1])), false);
		
		try {
				
			date_default_timezone_set("Asia/Bangkok");
				
			$timing 	= date('H:i:s');
			$conv_date  = $this->effective->StandartDateSorter($process[1]);
						
			if($rmLog_checked == 'FALSE') {				
				$rmlog_bundle   = $this->dbstore->exec_rmlogs($verify_id, $process[0], $this->emp_id, $this->effective->set_chartypes($this->char_mode, $this->name), $conv_date, $timing, 'A', 1);
				
			} 
			
		} catch(Exception $e) {
		
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
		
		
		}
			
	}

	public  function delRecordBorrowerLoan() {
		$this->load->model('dbmodel');
		
		$doc_id = $this->input->post('relx');
		$name	= $this->input->post('refx');
		$mode	= $this->input->post('modx');
		
		if(empty($doc_id) && empty($name)) {
			echo json_encode(array("data" => '', "status" => 'false', "msg" => 'The parameter have empty value please passing data to thread for inquiry'));
			
		} else {
			
			switch($mode) {
				case 'rclx7':
					
					try {
					
						$verified_checked = $this->dbmodel->data_validation("NCBConsent", "DocID", array("DocID" => $doc_id, 'IsRef' => $name), false);
						if($verified_checked == 'TRUE'):
						$ncb_cstate = $this->dbmodel->exec("NCBConsent", array("IsActive" => 'N'), array("DocID" => $doc_id, 'IsRef' => $name), 'update');
						endif;
					
						$reconcile_checked = $this->dbmodel->data_validation("ReconcileDoc", "DocID", array("DocID" => $doc_id, 'IsRef' => $name), false);
						if($reconcile_checked == 'TRUE'):
						$reconcile_state = $this->dbmodel->exec("ReconcileDoc", array("IsActive" => 'N'), array("DocID" => $doc_id, 'IsRef' => $name), 'update');
						endif;
					
							
						if($ncb_cstate == TRUE && $reconcile_state == TRUE) {
							echo json_encode(array("data" => '', "status" => 'true', "msg" => ''));
					
						} else {
							echo json_encode(array("data" => '', "status" => 'false', "msg" => 'Exception handled, Please re-checked input.'));
						}
					
					} catch(Exception $e) {
						echo 'Caught exception: '.$e->getMessage()."\n";
						echo 'Caught exception: '.$e->getLine()."\n";
						echo 'The Exception: '.$e->getTrace()."\n";
					}
				
				break;
				case 'rcpx5':
					
					try {
						
						$list_doc = $this->input->post('ltsx');
						$real_id  = $this->input->post('real');
						$completion_doc = $this->dbmodel->data_validation("ReconcileCompletion", "DocID, IsRef, DocList", array("DocID" => $doc_id, 'IsRef' => $real_id, "DocList" => $list_doc), false);
						if($completion_doc == 'TRUE'):
						$completion_bundled = $this->dbmodel->exec("ReconcileCompletion", array("IsActive" => 'N'), array("DocID" => $doc_id, 'IsRef' => $real_id, "DocList" => $list_doc), 'update');
						endif;
						
						if($completion_bundled == TRUE) {
							echo json_encode(array("data" => '', "status" => 'true', "msg" => ''));
								
						} else {
							echo json_encode(array("data" => '', "status" => 'false', "msg" => 'Exception handled, Please re-checked input.'));
						}
					
					} catch(Exception $e) {
						echo 'Caught exception: '.$e->getMessage()."\n";
						echo 'Caught exception: '.$e->getLine()."\n";
						echo 'The Exception: '.$e->getTrace()."\n";
					}
					
				break;
				default:
					echo json_encode(array("data" => '', "status" => 'false', "msg" => 'The mode have incorrect. '));
				break;
			}

		}
		
		
	}
	
	// SET DATA BUNDLED
	public function setVerificationInitialyzeForm() {
		$this->load->model('dbmodel');
		$this->load->model('dbstore');
		
		$this->load->library('effective');
		
		$doc_id				= $this->input->post('DocID');
		$department			= $this->input->post('Department');
		
		$onbehalf 			= $this->input->post('on_helf');
		$id_card			= $this->input->post('id_card');
		$appno_responsed	= $this->input->post('appno_responsed'); // append on date 24/11/2015
		$productcode		= $this->input->post('productprg');
		$loantypes			= $this->input->post('loantypes');
		$bank_list			= $this->input->post('banklist');
		$mrat				= $this->input->post('mrta');
		$cashy				= $this->input->post('cashy');
		$rmprocess			= $this->effective->set_chartypes($this->char_mode, $this->input->post('rmprocess_draft'));
		$rmprocessdate		= $this->input->post('rmprocessdate');
				
		//$rmprocessreason	= $this->input->post('rmprocess_reason');
		//$rm_otherreason		= $this->input->post('rmprocess_otherreason');
		
		// Modifier on date: 03/12/2015
		$rmprocessreason	= $this->input->post('rmprocess_list_bundled');
		$rm_otherreason		= $this->input->post('rmprocess_otherlist_bundled');
		
		$reactivereason		= $this->input->post('reactivate');
		$reactivedate		= $this->input->post('reactivate_plan');
		$request_loan		= $this->input->post('RequestLoan');
		
		$action_mode		= $this->input->post('action_flag');
		$actionnote			= ltrim(rtrim($this->input->post('actionnote')));
		$actionnotedate		= $this->input->post('action_hidden_date');				
		$action_datelatest	= $this->input->post('actionnote_datelatest'); // append on date 26/05/2017
		$action_actorlatest	= $this->input->post('actionnote_actorlatest'); // append on date 26/05/2017
		
		$ncb_note			= $this->input->post('ncb_comment');
		
		// NCB Consent
		$borrowtype			= $this->input->post('NCBRelation');
		$borrowname			= $this->input->post('NCBName');
		$borrow_id_card		= $this->input->post('NCBIDNo');
		$NameIsRef			= $this->input->post('NCBIsRef');
		$ncb_checked		= $this->input->post('NCBResult');
		$ncb_date			= $this->input->post('NCBResultDate');
		$submitToHQ			= $this->input->post('LBSentToHQ');
		$receivedLB			= $this->input->post('ReceivedFromLB');
		$HQToOper			= $this->input->post('HQToOper');
 		$OperReuturn		= $this->input->post('OperReturn'); // Logic: if not have null data a equal 1 
		
 		//Reconcile Document 
		$rec_borrowname 	= $this->input->post('Relation_name');
		$rec_reconcile_id	= $this->input->post('Relation_RecID');
		$rec_borrowtype 	= $this->input->post('Relation_type');
		$rec_logistic		= $this->input->post('Relation_Logistics');
		$rec_submitToHQ 	= $this->input->post('Relation_SubmitToHQ');
		$rec_receivedDoc	= $this->input->post('Relation_HQReceived');
		$rec_completionDoc	= $this->input->post('Relation_ComplementionDoc');
		$rec_completionDate	= $this->input->post('Relation_DocCheckDate');
		$rec_submitToCA		= $this->input->post('Relation_SubmitToCA');
		$rec_docCAReturn	= $this->input->post('Relation_CAReturn');
		$ref_reference		= $this->input->post('Relation_ref');
		
		// NCB Consent Hidden - Log Bundled
		$bt_hidden			= $this->input->post('BorrowerType_hidden');
		$bn_hidden			= $this->input->post('BorrowerName_hidden');
		$bp_hidden			= $this->input->post('NCBPass_hidden');
		$bc_hidden			= $this->input->post('NCBCheck_hidden');
		$bl_hidden			= $this->input->post('SubmitToHQ_hidden');
		$bh_hidden			= $this->input->post('HQReceived_hidden');
		$bo_hidden			= $this->input->post('SubmitTOOper_hidden');
		$br_hidden			= $this->input->post('ReChecked_hidden');
		$rf_hidden			= $this->input->post('IsRef_hidden');
		$rr_hidden			= $this->input->post('RecheckReason_hidden'); // create 10/02/2016
		
		// Reconcile Doc Hidden - Log Bundled
		$rel_logictic		= $this->input->post('RELLogistic_hidden');
		$rel_borrowertype	= $this->input->post('RELBorrowerType_hidden');
		$rel_borrowername	= $this->input->post('RELBorrowerName_hidden');
		$rel_LBToCA			= $this->input->post('RELLBToHQ_hidden_');
		$rel_HQReceived		= $this->input->post('RELHQReceived_hidden');
		$rel_Completion		= $this->input->post('RELCompletion_hidden');
		$rel_HQToCADate		= $this->input->post('RELHQToCA_hidden');
		$rel_CAReturnDate	= $this->input->post('RELRETurn_hidden');
		$rel_EventLogs		= $this->input->post('RELEventLog_hidden');
		
		// Defend
		// Not use: change process
		/*
		$proposer_id		= $this->input->post('proposer');
		$proposer_name		= $this->input->post('proposer_name');
		$proposer_type		= $this->input->post('defend_proposer');
		
		$defend_process		= $this->input->post('defend_process_hidden');
		$defend_no      	= $this->input->post('defend_no');
		$defend_set     	= $this->input->post('defend_trigger');
		*/
		
		// dropdown reason list - cancels
		//$defend_list		= $this->input->post('defend_reason');
		//$defend_other		= $this->input->post('defend_other');
		
		$defend_date		= $this->input->post('defend_date');
		$defend_conv    	= !empty($defend_date) ? $this->effective->StandartDateSorter($defend_date):null;
		
		
		// new list - re process: 24/11/2015
		$defend_list		= $this->input->post('defend_list_bundled');
		$defend_other		= $this->input->post('defend_otherlist_bundled');
		
		// new list - modify process: 27/03/2018
		$app2ca_date		= $this->input->post('app2ca_latest');
		$defend_creation 	= $this->input->post('defend_creation_state');
		$defend_owner_id	= $this->input->post('defend_owner_id');
		$defend_owner_name	= $this->input->post('defend_owner_name');
		
		// credit return in part careturn: code appending on 25/11/2015
		$return_isenabled	= $this->input->post('checkCreditReturn');
		$reconcile_ownerlist= $this->input->post('reconcile_id_bundled');
		$credit_returnlist	= $this->input->post('creditreturn_list_bundled');
		$credit_returnOther	= $this->input->post('creditreturn_otherlist_bundled');
		
		// Plan A2CA : add 08/03/2016
		$plan_apptoca		= $this->input->post('plan_a2ca');
		// Plan A2ca : add 15/03/2016
		$plan_apptoca_log	= $this->input->post('plan_a2ca_log');
		
		// Check Plan App To CA
		if(!empty($plan_apptoca_log)) {
		
			if($plan_apptoca !== $plan_apptoca_log) {
				$this->dbmodel->exec('AppToCA_History', array(
						'DocID' 		=> $doc_id,
						'A2CA_PlanDate' => $this->effective->StandartDateSorter($plan_apptoca_log). ' ' .date('H:i:s'),
						'IsActive' 		=> 'A',
						'CreateBy' 		=> $this->effective->set_chartypes($this->char_mode, $this->name),
						'CreateDate' 	=> date('Y-m-d H:i:s')
				), false, 'insert');
			}
		
		}
				
		$borrowMainInfo = array(
			"OnBehalf"			=> $onbehalf,
			"ID_Card" 			=> $id_card,			
			"MRTA"				=> self::prepareChecked($mrat),
			"Cashy"				=> self::prepareChecked($cashy),
			"RMProcess"			=> $rmprocess,
			"RMProcessDate"		=> !empty($rmprocessdate) ? $this->effective->StandartDateSorter($rmprocessdate):NULL,
			"AppToCAPlanDate"	=> !empty($plan_apptoca) ? $this->effective->StandartDateSorter($plan_apptoca):NULL	
		);
		
		$borrower_mainopt	= array();		
		if($borrowtype[0] == '101' && !empty($borrowname[0])) {

			$verified_id  = $this->dbmodel->loadData($this->table_verification, "VerifyID", array("DocID" => $doc_id));
	
			// DATA CONVERT
			$MainNCB 	  = array();  // BORROWER MAIN NAME
			$NCB_Consent  = array();  // BORROWER JOIN NAME
			foreach($ncb_date as $index => $values) {
				
				if ($ncb_checked[$index] == '0' || $ncb_checked[$index] == '2') { $status = "Y"; }
				else if ($ncb_checked[$index] == '') { $status = "N"; }
				else if ($ncb_date[$index] != '' && $borrowname[$index] && $rmprocess == "Completed" || $rmprocess == "CANCELBYRM" || $rmprocess == "CANCELBYCUS" || $rmprocess == "CANCELBYCA") { $status = "Y"; }
				else { $status = "N"; }
					
				if(!$OperReuturn[$index] == ""):
					$operstate = 'Y';
				else:
					$operstate = 'N';
				endif;
					
				if($NameIsRef[$index] == '') {
					$is_ref = $data_stack[$index]["IsRef"] = $gen_id = substr((date('Y') + 543), -2, 2).$verified_id['data'][0]['VerifyID'].'LB'.str_pad($index, 3, "0", STR_PAD_LEFT);
				} else {
					$is_ref = $NameIsRef[$index];
				}				
				
				if($borrowtype[$index] == '101') {
			
					array_push($MainNCB, array(
						"VerifyID"		  	   => $verified_id['data'][0]['VerifyID'],
						"MainLoanName"         => $this->effective->set_chartypes($this->char_mode, $borrowname[$index]),
						"CheckNCB"		  	   => $ncb_checked[$index],
						"CheckNCBDate"	  	   => $this->effective->StandartDateSorter($ncb_date[$index]),
						"BrnSentNCBDate" 	   => $this->effective->StandartDateSorter($submitToHQ[$index]),
						"HQGetNCBDate"    	   => $this->effective->StandartDateSorter($receivedLB[$index]),
						"HQSentNCBToOperDate"  => $this->effective->StandartDateSorter($HQToOper[$index]),
						"Comments"			   => $this->effective->set_chartypes($this->char_mode, $ncb_note),
						)
					);
			
					array_push($borrower_mainopt, array("IsActive" => $status));
						
				}
					
				// STACK OBJECT DATA
				array_push($NCB_Consent, array(
					"DocID"			  => $doc_id,
					"VerifyID"		  => $verified_id['data'][0]['VerifyID'],
					"IDNO"			  => $borrow_id_card[$index],
					"BorrowerName"    => $this->effective->set_chartypes($this->char_mode, $borrowname[$index]),
					"BorrowerType"	  => $borrowtype[$index],
					"NCBCheck"		  => $ncb_checked[$index],
					"NCBCheckDate"	  => $this->effective->StandartDateSorter($ncb_date[$index]),
					"SubmitToHQ"	  => $this->effective->StandartDateSorter($submitToHQ[$index]),
					"HQReceivedFromLB"=> $this->effective->StandartDateSorter($receivedLB[$index]),
					"HQSubmitToOper"  => $this->effective->StandartDateSorter($HQToOper[$index]),
					"OperReturn"	  => $operstate,
					"OperReturnDate"  => $this->effective->StandartDateSorter($OperReuturn[$index]),
					"IsActive"		  => 'A',
					"IsRef"			  => $is_ref
					)
				);
			}

			// VERIFICATION BUNDLED
			$main_information = array_merge($borrowMainInfo, $borrower_mainopt[0]);			
			$verification = $this->dbmodel->exec($this->table_verification, $main_information, array("DocID" => $doc_id), 'update');
			
			// Check Product Program
			if(empty($productcode)):
					
			else:				
				$product_program = array("ProductCode" => $productcode, "ProductLoanTypeID" => !empty($loantypes) ? $loantypes:NULL, 'Bank' => !empty($bank_list) ? $bank_list:NULL);
				$this->dbmodel->exec($this->table_verification, $product_program, array("DocID" => $doc_id), 'update');	
			endif;
			
			if($verification == TRUE) {
			
				if(!empty($request_loan)) {
					$this->dbmodel->exec($this->table_profile, array('RequestLoan' => (int)str_replace(',', '', $request_loan)), array("DocID" => $doc_id), 'update');
				}
				
				// ApplicationNo on bundled into application status
				if(!empty($appno_responsed)) {
					$this->dbmodel->exec($this->table_applicationstatus, array('ApplicationNo' => $appno_responsed), array("DocID" => $doc_id), 'update');
				}
								
				// NCB OLD BUNDLED
				$verified_checked = $this->dbmodel->data_validation($this->table_ncb, "VerifyID", array("VerifyID" => $verified_id['data'][0]['VerifyID']), false);
				if($verified_checked == 'TRUE') {
					$ncb_state = $this->dbmodel->exec($this->table_ncb, $MainNCB[0], array("VerifyID" => $verified_id['data'][0]['VerifyID']), 'update');
						
				} else {
					$ncb_state = $this->dbmodel->exec($this->table_ncb, $MainNCB[0], false, 'insert');	
					
				}
				
				// NCB NEW BUNDLED
				if($ncb_state == TRUE):
					$relation = $this->setNewJoinLoan($NCB_Consent, $doc_id);

					// Logs
					$Log_Consent = array(
						"VerifyID"		=> $verified_id['data'][0]['VerifyID'],
						'BorrowerType'  => $bt_hidden,
						'BorrowerName'  => $bn_hidden,
						'NCBCheck'		=> $bp_hidden,
						'NCBCheckDate' 	=> $bc_hidden,
						'SubmitToHQ' 	=> $bl_hidden,
						'HQReceived' 	=> $bh_hidden,
						'SubmitToOper' 	=> $bo_hidden,
						'ReturnDate' 	=> $br_hidden,
						'IsRef'			=> $rf_hidden,
						'Event_Type' 	=> $rr_hidden
					);
					
					$this->onWriteNCBBundledLogs($Log_Consent);
					
				endif;
				

				// RM LOGS
				if(!empty($rmprocess) && !empty($rmprocessdate)) {
					$this->fnVerificationCancelProcess($doc_id, $rmprocess,  $this->effective->StandartDateSorter($rmprocessdate), $rmprocessreason, $verified_id['data'][0]['VerifyID'], $this->effective->StandartDateSorter($plan_apptoca_log)); // Cancel Processes
					$this->setEventRMLogs($verified_id['data'][0]['VerifyID'], array($rmprocess, $rmprocessdate), $this->effective->set_chartypes($this->char_mode, $this->name));
						
					if(!empty($rmprocessreason[0])):
						$this->getCancelReasonListOnBundled($doc_id, array("RMProcess"	=> $rmprocess, "RMProcessDate" => $this->effective->StandartDateSorter($rmprocessdate), "RMProcessReason" => $rmprocessreason, "OtherReason" => $rm_otherreason));
					endif;
						
				}

				if($relation == TRUE):
					$migrate = $this->OnDataRelationToReconcile($NCB_Consent, $doc_id);
				endif;
								
				if($return_isenabled === 'Y') {
					$this->setDataReturnReasonBundled($doc_id, array($this->emp_id, $this->name), array($credit_returnlist, $credit_returnOther, $reconcile_ownerlist));
				}
				
		
				/* Not used: Change proccess 
				if($proposer_type != "") {
					//$this->setDefendOnBundled($doc_id, $defend_list, array($defend_conv, $defend_no, $defend_set, $defend_other), array($defend_process, $proposer_type, $proposer_id, $proposer_name));
					$this->createDefendList($doc_id, $defend_list, array($defend_conv, $defend_other), array($defend_process, $proposer_type, $proposer_id, $proposer_name));
				}
				*/
				
				// new list - modify process: 27/03/2018
				if(!empty($defend_creation) && $defend_creation == 'Draft') {
					$this->createDefendListModify(
						$doc_id,
						$defend_list,
						$defend_other,
						array(
							'EmployeeCode' => $defend_owner_id,
							'EmployeeName' => $defend_owner_name
						),
						array('A2CA' => !empty($app2ca_date) ? $app2ca_date:null)
					);
					
				}
								
				
				// Action note bundled
				$check_note = trim($actionnote);
				if(!empty($check_note) || !empty($rmprocess)) {
					$logs	= 'FALSE'; //$this->dbmodel->data_validation('ActionNote', '*', array('DocID' => $doc_id, 'ActionNote' => $actionnote), false);
					if($logs == 'FALSE') :
						$this->setActionNoteBundled($doc_id, array($this->effective->set_chartypes($this->char_mode, $actionnote), $actionnotedate), array($rmprocess,  $this->effective->StandartDateSorter($rmprocessdate)), $action_mode);
					endif;
				}
				
// Not used				
// 				// Action note bundled				
// 				$check_note = trim($actionnote);
// 				if(!empty($check_note) || !empty($rmprocess)) {					
// 					$logs	= 'FALSE'; //$this->dbmodel->data_validation('ActionNote', '*', array('DocID' => $doc_id, 'ActionNote' => $actionnote), false);
// 					if($logs == 'FALSE') :
					
// 						$object_note = array(
// 							'DocID' 	  => $doc_id, 
// 							'ActionNote'  => $actionnote,
// 							'LatestDate'  => $action_datelatest,
// 							'LatestActor' => $action_actorlatest
// 						);
						
// 						// $this->setActionNoteNewBundled($object_note, ($action_mode == 1) ? 'TRUE':'FALSE');
// 						$this->setActionNoteBundled($doc_id, array($this->effective->set_chartypes($this->char_mode, $actionnote), $actionnotedate), array($rmprocess,  $this->effective->StandartDateSorter($rmprocessdate)), $action_mode);
// 					endif;
// 				}

				// MIGRATE INTO RECONCILE
				if($migrate == TRUE) {
					
					// RECONCILE DOCUMENT FLOW
					if(!empty($rec_borrowname[0])) {
						
						// OLD VERIFY AND NEW STRUCTURE RECONCILE BUNDLED
						$relation_reconcile = array(
							"RecID"				=> !empty($rec_reconcile_id) ? $rec_reconcile_id:null,
							"BorrowerName"		=> $rec_borrowname,
							"BorrowerType" 		=> $rec_borrowtype,
							"LogisticCode"		=> $rec_logistic,
							"SubmitDocToHQ" 	=> $rec_submitToHQ,
							"ReceivedDocFormLB" => $rec_receivedDoc,
							"CompletionDoc"		=> $rec_completionDoc,
							"CompletionDate"	=> $rec_completionDate,
							"AppToCA"			=> $rec_submitToCA,
							"CAReturnDate"		=> $rec_docCAReturn,
							"IsRef"				=> $ref_reference
						);
						
						$set_docflow = $this->setReconcileDoc($relation_reconcile, $doc_id, $department);
						
						// Reconcile Doc Hidden				
						$reconcile_bundled = array(
								"DocID"				=> $doc_id,
								"BorrowerName"		=> $rel_borrowername,
								"BorrowerType" 		=> $rel_borrowertype,
								"LogisticCode"		=> $rel_logictic,
								"SubmitDocToHQ" 	=> $rel_LBToCA,
								"ReceivedDocFormLB" => $rel_HQReceived,
								"CompletionDoc"		=> $rel_Completion,
								"CompletionDate"	=> $rel_HQReceived,
								"AppToCA"			=> $rel_HQToCADate,
								"CAReturnDate"		=> $rel_CAReturnDate,
								'Event_Type'		=> $rel_EventLogs
						);
	
						$this->onWriteReconcileBundledLogs($reconcile_bundled);
						
					}	
					
					if(!empty($reactivereason[0]) && !empty($reactivedate)) {
					 // $reactivate = $this->setReActivatePlan($reactivereason, $reactivedate, array($verified_id['data'][0]['VerifyID'], $doc_id));
						$reactivate =  $this->setReactivateTransaction($reactivereason, $reactivedate, array($doc_id, $verified_id['data'][0]['VerifyID'], $rmprocess));
						if($reactivate == 'TRUE') {
							redirect('management/getDataVerifiedManagement?rel='.$doc_id, 'refresh');
						} else {
							redirect('management/getDataVerifiedManagement?rel='.$doc_id, 'refresh');
						}
						
						
					} else {
						redirect('management/getDataVerifiedManagement?rel='.$doc_id, 'refresh');
						
					}
					
				} else {
					// Migrate Exception
					throw new Exception(__FUNCTION__.' is error occurence handled. please re-checked processes.');
				}
			
			}
			
		} else {			
			// Force Alert MainLoanName
			redirect('management/getDataVerifiedManagement?rel='.$doc_id, 'refresh');
			
		}
		
	}
	
	public function getRetrieveReason() {
		$this->load->model('dbmodel');	
		
		$conv['data'] = array();
		$result = $this->dbmodel->CIQuery("SELECT * FROM MasterRetrieveReason WHERE IsActive = 'A'");		
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'], array(
					"RetrieveCode"		=> $result['data'][$index]['RetrieveCode'],
					"RetrieveReason"	=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['RetrieveReason']),
					"IsActive"			=> 'A'
				)
			);
		}
		
		return $conv;
		
	}
	
	// Get Cancel Reason from RM Process
	public function getCancelReasonListOnBundled($doc_id, $data_stack = array()) {
		$this->load->model('dbmodel');
		
		if($data_stack['RMProcess'] === "CANCELBYRM" || $data_stack['RMProcess'] === "CANCELBYCUS" || $data_stack['RMProcess'] === "CANCELBYCA") {
		
			if(!empty($data_stack['RMProcessReason'])) $rmprocess_list = explode(',', $data_stack['RMProcessReason']);
			if(!empty($data_stack['OtherReason'])) $rmprocess_others_reason = explode(',', $data_stack['OtherReason']);
					
			try {		
	
				if(in_array("OT099", $rmprocess_list)):
					$otkey = array_search("OT099", $rmprocess_list);				
					if($otkey !== false) unset($rmprocess_list[$otkey]);
				endif;
				
				if(in_array("CM999", $rmprocess_list)):
					$cmkey = array_search("CM999", $rmprocess_list);
					if($cmkey !== false) unset($rmprocess_list[$cmkey]);
				endif;
								
				$object_reason 		 = array();
				$object_reason_other = array();
				if(!empty($data_stack['RMProcessReason'][0])) {
									
					foreach($rmprocess_list as $index => $value) {
						array_push($object_reason, array(
								"DocID"			=> $doc_id,
								"MasterCode"	=> $rmprocess_list[$index],
								"OtherDetail"	=> NULL,
								"CancelTypes"	=> $data_stack['RMProcess'],
								"CancelDate"	=> $data_stack['RMProcessDate'],
								"IsActive"		=> 'A',
								"CreateByID"	=> $this->emp_id,
								"CreateByName"	=> $this->effective->set_chartypes($this->char_mode, $this->name),
								"CreateByDate"	=> date('Y-m-d H:i:s'),
							)
						);
						
					}
				
				}				
			
				if(!empty($rmprocess_others_reason[0])) {
					
					if($data_stack['RMProcess'] == "CANCELBYCUS "):
						$code_type = "CM999";
					else:
						$code_type = "OT099";
					endif;
					
					foreach($rmprocess_others_reason as $index => $value) {
						
						if(empty($rmprocess_others_reason[$index])):
							continue;
						else:
							
						array_push($object_reason_other, array(
								"DocID"			=> $doc_id,
								"MasterCode"	=> $code_type,
								"OtherDetail"	=> !empty($rmprocess_others_reason[$index]) ? $this->effective->set_chartypes($this->char_mode, $rmprocess_others_reason[$index]):'',
								"CancelTypes"	=> $data_stack['RMProcess'],
								"CancelDate"	=> $data_stack['RMProcessDate'],
								"IsActive"		=> 'A',
								"CreateByID"	=> $this->emp_id,
								"CreateByName"	=> $this->effective->set_chartypes($this->char_mode, $this->name),
								"CreateByDate"	=> date('Y-m-d H:i:s'),
						)
								);
							
						endif;
						
					}
				
				}
				
				if(!empty($object_reason_other[0])):
					$data_merge	= array_merge($object_reason, $object_reason_other);
				else:
					$data_merge	= $object_reason;
				endif;
				
				if(!empty($data_merge[0]['DocID'])):		
				
					if($data_stack['RMProcess'] == "CANCELBYCUS"):
						foreach($data_merge as $index => $value):
							$this->dbmodel->exec('CancelReasonListByCust', $data_merge[$index], false, 'insert');
						endforeach;
					else:
						foreach($data_merge as $index => $value):
							$this->dbmodel->exec('CancelReasonList', $data_merge[$index], false, 'insert');
						endforeach;
					endif;
										
				endif;				
				
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
		
			}
			
		}
		
	}
	
	// Modify: Defend 02/04/2018
	public function getDefendInfo($doc_id) {
		$this->load->model('dbmodel');
		$result_set = $this->dbmodel->CIQuery("
			SELECT [New_DefendHead].RowID, [New_DefendHead].DocID, DefendRef, CONVERT(nvarchar(10), DefendDate, 120) DefendDate, 
			DefendDepart, DefendProcess, [New_DefendHead].DefendProgress, ProgressNewLabel,
			AssignmentID, AssignmentName, AssignmentDate, AssignmentConfirm, Remark, [New_DefendHead].IsActive, 
			CreateID, CreateBy, CONVERT(nvarchar(10), CreateDate, 120) CreateDate, 
			UpdateID, UpdateBy, CONVERT(nvarchar(10), UpdateDate, 120) UpdateDate
			FROM [New_DefendHead]
			LEFT OUTER JOIN [PCIS].[dbo].[DefendProgress] ON [DefendProgress].[InProgress] = [New_DefendHead].[DefendProgress]
			WHERE [New_DefendHead].[DocID] = '".$doc_id."'
			AND [New_DefendHead].IsActive = 'A'
			ORDER BY DefendRef DESC
		");

		return $result_set;
	
	}

	public function setDefendOnBundled($doc_id, $defend_reason, $supplement = array(), $defend_env = array()) {
		$this->load->model('dbmodel');
		
		$defend_mode = 'Y';
		$defend_data = array(
			'DocID'         => $doc_id,
			'DefendRef'     => $supplement[1],
			'DefendDate'    => !empty($supplement[0]) ? $supplement[0]:date("Y-m-d H:i:s"),
			'IsDefend'      => $defend_mode,
			'DefendReset'   => 'N',
			'IsActive'      => 'A',
			'CreateByID'	=> $this->emp_id,
			'CreateBy'      => $this->effective->set_chartypes($this->char_mode, $this->name),
			'CreateDate'    => date('Y-m-d')
		);
	
		switch ($defend_env[1]) {
			case 'RM':
		
				$assign_name   = $this->getDataAssignDefendName($doc_id);
		
				$defendNameId  = !empty($assign_name[0]['DefendEmpID']) ? $assign_name[0]['DefendEmpID']:NULL;
				$defendName    = !empty($assign_name[0]['DefendEmpName']) ? $assign_name[0]['DefendEmpName']:NULL;
		
				$defend_info = array_merge($defend_data,
					array(
							'DefendProcess'	=> $defend_env[0],
							'ProposerType'  => $defend_env[1],
							'ProposerID'    => $defend_env[2],
							'ProposerName'  => $this->effective->set_chartypes($this->char_mode, $defend_env[3]),
							'DefendEmpID'   => $defendNameId,
							'DefendEmpName' => $defendName
								
					)
				);
		
			break;
			case 'DF':
		
				$defend_info = array_merge($defend_data,
					array(
						'DefendProcess'	=> $defend_env[0],
						'ProposerType'  => $defend_env[1],
						'ProposerID'    => $defend_env[2],
						'ProposerName'  => $this->effective->set_chartypes($this->char_mode, $defend_env[3]),
						'DefendEmpID'   => $defend_env[2],
						'DefendEmpName' => $this->effective->set_chartypes($this->char_mode, $defend_env[3])
			
					)
				);
		
			break;
		}
	
		if(!empty($defend_reason)) $defend_list = explode(',', $defend_reason);
		if(!empty($supplement[3])) $others_reason = explode(',', $supplement[3]);
		
		try {
			
			if(!empty($defend_list[0])) {
				
				if(in_array("OT099", $defend_list)):				
					$key = array_search("OT099", $defend_list);
					if($key !== false) unset($defend_list[$key]);					
				endif;				
				
				$defend_check = $this->dbmodel->data_validation('DefendHead', '*', array('DocID' => $doc_id, 'DefendRef' => $supplement[1]), false);
				
				if($defend_check == 'FALSE'):

					//Table: DefendHead - Data bundled.
					$this->dbmodel->exec('DefendHead', $defend_info, false, 'insert');
				
					try {
						
						$objDefend  = array();
						$objSupply  = array();
						foreach($defend_list as $index => $value) {
							
							array_push($objDefend, array(
									'DocID'         => $doc_id,
									'DefendRef'     => $supplement[1],
									'DefendCode'    => $defend_list[$index],
									'IsActive'      => 'A'
								)
							);
							
						}						
						
						if(!empty($others_reason[0])) {
							
							foreach($others_reason as $index => $value) {
								
								if(empty($others_reason[$index])):
									continue;
								else:
									array_push($objSupply, array(
											'DocID'         => $doc_id,
											'DefendRef'     => $supplement[1],
											'DefendCode'    => "OT099",
											'DefendOther'    => $this->effective->set_chartypes($this->char_mode, $others_reason[$index]),
											'IsActive'      => 'A'
										)
									);
								endif;
								
								
			
							}
		
						} 
						
						if(!empty($objSupply[0])):
							$data_merge	= array_merge($objDefend, $objSupply);
						else:
							$data_merge	= $objDefend;					
						endif;
						
						//Table: DefendSubscription - Data bundled
						foreach($data_merge as $index => $value) {
							$this->dbmodel->exec('DefendSubscription', $data_merge[$index], false, 'insert');
						
						}
						
						return TRUE;
						
						
					} catch(Exception $e) {
						echo 'Caught exception: '.$e->getMessage()."\n";
						echo 'Caught exception: '.$e->getLine()."\n";
						echo 'The Exception: '.$e->getTrace()."\n";
			
					}
					
				endif;
				
			}
		
			
		} catch(Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The exception: '.$e->getTrace()."\n";
		}	
	
	}

	private function setActionNoteNewBundled($action_note, $action_mode) {
		$this->load->model("dbmodel");
		$this->load->model("dbstore");
		
		$table_action_note = "ActionNote";
		$table_action_logs = "ActionNoteLog";
		
		date_default_timezone_set("Asia/Bangkok");
		
		$emp_code 	  = $this->session->userdata("empcode");
		$emp_name     = $this->session->userdata("thname");
		
		$data_bundled = array();
		$logs_bundled = array();
		
		// Object action note latest in logs
		$result_latest = $this->dbstore->exec_getActionNoteLogs($action_note['DocID']);
		$note_latests  = (!empty($result_latest[0])) ? $result_latest[0]:null;
		$latests_note  = array(
				"RowID"				 => $note_latests['ACN_RowID'],
				"DocID" 	 		 => $note_latests['DocID'],
				"ActionNote" 		 => !empty($note_latests['ActionNote']) ? $this->effective->set_chartypes($this->char_mode, $note_latests['ActionNote']):"",
				"ActionNoteDate" 	 => $note_latests['ActionNoteDate'],
				"ActionNoteBy"		 => $note_latests['ActionNoteBy'],
				"ActionName"		 => !empty($note_latests['ActionName']) ? $this->effective->set_chartypes($this->char_mode, $note_latests['ActionName']):NULL,
				"OwnerMaster"		 => $note_latests['OwnerMaster']
		);
		
		$table_opposite = null;
		if(!empty($latests_note['OwnerMaster'])) {
			$_table = '';
			$_field = '';
			switch(strtoupper($latests_note['OwnerMaster'])) {
				case 'ACTIONNOTE':
					$_table = $table_action_logs;
					$_field = '
						DISTINCT AA.RowID, AA.DocID, [dbo].[StripDoubleSpaces](ActionNoteLog.ActionNote) AS ActionNote,
						ActionNoteLog.ActionNoteByID AS ActionNoteBy, ActionNoteLog.ActionNoteByName AS ActionName, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate,
						IsActive, CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime';					
				break;
				case 'ACTIONNOTELOG':
					$_table = $table_action_note;
					$_field = '
						DISTINCT AA.RowID, AA.DocID, [dbo].[StripDoubleSpaces](ActionNote.ActionNote) AS ActionNote,
						ActionNote.ActionNoteBy AS ActionNoteBy, ActionNote.ActionName AS ActionName, CONVERT(nvarchar(10), ActionNoteDate, 120) AS ActionNoteDate,
						IsActive, CONVERT(nvarchar(19), ActionNoteDate, 120) AS ActionDateTime';
				break;
			}
			
			if(!empty($action_note['DocID'])) {
				$_result = $this->dbmodel->CIQuery("					
					SELECT $_field, Runno
					FROM (
						SELECT RowID, DocID, [dbo].[TRIM](ActionNote) AS ActionNote, ROW_NUMBER() OVER(ORDER BY ActionNoteDate DESC) AS Runno 
						FROM $_table
						WHERE IsActive = 'A'
						AND NOT ActionNote = ''
						AND DocID = '".$action_note['DocID']."'
					) AA  
					LEFT OUTER JOIN $_table
					ON AA.RowID = $_table.RowID
					WHERE AA.DocID = '".$action_note['DocID']."'
					AND Runno = 1
				");
				
				$table_opposite = (!empty($_result['data'][0])) ? array(
					"RowID"				 => $_result['data'][0]['RowID'],
					"DocID" 	 		 => $_result['data'][0]['DocID'],
					"ActionNote" 		 => !empty($_result['data'][0]['ActionNote']) ? $this->effective->set_chartypes($this->char_mode, $_result['data'][0]['ActionNote']):"",
					"ActionNoteDate" 	 => $_result['data'][0]['ActionNoteDate'],
					"ActionNoteBy"		 => !empty($_result['data'][0]['ActionNoteBy']) ? $this->effective->set_chartypes($this->char_mode, $_result['data'][0]['ActionNoteBy']):"",
					"ActionName"		 => !empty($_result['data'][0]['ActionName']) ? $this->effective->set_chartypes($this->char_mode, $_result['data'][0]['ActionName']):NULL
				):null;
				
			}
			
			
		}
		
		// Object action note latest submitted 
		$draft_note  = array(
				"DocID" 	 		 => $action_note['DocID'],
				"ActionNote" 		 => !empty($action_note['ActionNote']) ? $this->effective->set_chartypes($this->char_mode, $action_note['ActionNote']):"",
				"ActionNoteBy" 		 => $emp_code,
				"ActionName" 		 => $emp_name,
				"ActionNoteDate" 	 => date('Y-m-d H:i:s'),
				"IsActive" 	 		 => 'A'
		);
		
		$action_state = array();
		if(empty($latests_note['DocID'])) {
			$action_state = array(
				'ACTION_PROCESS'	=> 'INSERT',
				'ACTION_EVENT'		=> 'CREATE'
			);
			
		} else {
			
			if($action_mode === 'TRUE') {
				$action_state = array(
					'ACTION_PROCESS'	=> 'INSERT',
					'ACTION_EVENT'		=> 'NEW_TEXT'
				);
				
			} else {
				
				if(($latests_note['ActionNote'] == $action_note['ActionNote']) &&
				   ($latests_note['ActionName'] == $action_note['LatestActor']) &&
				   ($latests_note['ActionNoteDate'] == $action_note['LatestDate'])) {
					
					$action_state = array(
						'ACTION_PROCESS'	=> 'HOLD',
						'ACTION_EVENT'		=> NULL
					);
					
				} else if(
				   ($latests_note['ActionNote'] !== $action_note['ActionNote']) &&
				   ($latests_note['ActionName'] == $action_note['LatestActor']) &&
				   ($latests_note['ActionNoteDate'] == $action_note['LatestDate'])) {
				   	
					$action_state = array(
						'ACTION_PROCESS'	=> 'UPDATE',
						'ACTION_EVENT'		=> 'REPLACE'
					);
					
				}
		
			}

		}
		
		if(!empty($action_state['ACTION_PROCESS'])) {

			switch(strtoupper($action_state['ACTION_PROCESS'])) {
				case 'INSERT':
	
					$draft_note['EventNote'] = $action_state['ACTION_EVENT'];
					
					$data_bundled = $draft_note;
					$logs_bundled = array(
						"DocID" 	 		 => $draft_note['DocID'], 
						"ActionNote" 	 	 => $draft_note['ActionNote'], 
						"ActionNoteByID" 	 => $draft_note['ActionNoteBy'],
						"ActionNoteByName" 	 => $draft_note['ActionName'], 
						"ActionNoteDate" 	 => $draft_note['ActionNoteDate'], 
						"IsActive" 	 		 => 'A', 
						"EventNote" 	 	 => $action_state['ACTION_EVENT']
					);

										
				break;
				case 'UPDATE':
					
					if($action_state['ACTION_EVENT'] !== 'HOLD') {
						
						if($action_state['ACTION_EVENT'] == 'REPLACE') {	
							$draft_note['EventNote'] = $action_state['ACTION_EVENT'];
							
							$data_bundled = $draft_note;							
							$logs_bundled = array(
								"DocID" 	 		 => $draft_note['DocID'],
								"ActionNote" 	 	 => $draft_note['ActionNote'],
								"ActionNoteByID" 	 => $draft_note['ActionNoteBy'],
								"ActionNoteByName" 	 => $draft_note['ActionName'],
								"ActionNoteDate" 	 => $draft_note['ActionNoteDate'],
								"IsActive" 	 		 => 'A',
								"EventNote" 	 	 => $action_state['ACTION_EVENT']
							);
							
						}
						
					}
					
				break;
			}
			
		}

		if(!empty($data_bundled['DocID'])) {
			
			if($action_state['ACTION_PROCESS'] == 'INSERT') {
				
				$this->dbmodel->exec($table_action_note, $data_bundled, false, strtolower($action_state['ACTION_PROCESS']));
				$this->dbmodel->exec($table_action_logs, $logs_bundled, false, strtolower($action_state['ACTION_PROCESS']));
				
			} else {
				
				if($action_state['ACTION_EVENT'] == 'REPLACE') {
					$this->dbmodel->exec($latests_note['OwnerMaster'], $data_bundled, array("DocID" => $action_note['DocID'], "RowID" => $note_latests['ACN_RowID']), strtolower($action_state['ACTION_PROCESS']));
					$this->dbmodel->exec(
						($latests_note['OwnerMaster'] == 'ActionNote') ? 'ActionNoteLog':'ActionNote', 
						($latests_note['OwnerMaster'] == 'ActionNote') ? $logs_bundled:$data_bundled, 
						array(
							"DocID" => $action_note['DocID'], 
							"RowID" => $table_opposite['RowID']), 
							strtolower($action_state['ACTION_PROCESS'])
						);
				}
								
			}
			
		}

	}

	// ROOT	
	public function setActionNoteBundled($doc_id, $action_note = array(), $rmprocess = array(), $action_mode) {
		$this->load->model("dbmodel");
		$this->load->model("dbstore");
		
		$data		  = array();
		$data_bundled = array();
		$logs_bundled = array();

		date_default_timezone_set("Asia/Bangkok");		
		$result 	  = $this->dbstore->exec_getActionNoteLogs($doc_id);
		if(!empty($result[0]['DocID'])) {
			
			foreach($result as $index => $values) {
								
				array_push($data, array(
						"ActionNote" 		 => !empty($result[$index]['ActionNote']) ? $this->effective->set_chartypes($this->char_mode, $result[$index]['ActionNote']):"",
						"ActionNoteBy" 		 => $this->effective->set_chartypes($this->char_mode, $result[$index]['ActionNoteBy']),
						"ActionName" 		 => !empty($result[$index]['ActionName']) ? $this->effective->set_chartypes($this->char_mode, $result[$index]['ActionName']):"",
						"ActionNoteDate" 	 => $result[$index]['ActionNoteDate']
					)
				);
				
			}
	
		}
		
		// Prefix action note process
		$rmdate_replc = substr(str_replace('/', '' , $this->effective->StandartDateRollback($rmprocess[1])), 0, 4);
		$note_remark  = !empty($action_note[0]) ? $action_note[0]:'';		
		$transfer	  = !empty($rmprocess[0]) ? '#'.$rmdate_replc.' '.$rmprocess[0]. '; ':"";	
		$note_bundled = $transfer.$note_remark; 
				
		// Check AppToCA & RM Log
		$check_app2ca	  = $this->dbstore->check_RetrieveStatus($doc_id);
		$process_checked  = $this->dbmodel->data_validation("RMProcessBundled", "*", array("DocID" => $doc_id, "RMProcess" => $rmprocess[0], 'IsBundled' => $rmprocess[1]), false);
		
		// Check store: first logs.
		if(empty($result[0]['DocID'])) {
			
			array_push($data_bundled,
				array(
						"DocID" 		 => $doc_id,
						"ActionNoteBy"	 => $this->emp_id,
						"ActionName"	 => $this->effective->set_chartypes($this->char_mode, $this->name),
						"ActionNoteDate" => $action_note[1]. ' ' .date('H:i:s'),
						"IsActive"		 => 'A'
				)
			);
						
			array_push($logs_bundled, array("DocID" => $doc_id, "ActionNoteByID" => $this->emp_id, "ActionNoteByName"  => $this->effective->set_chartypes($this->char_mode, $this->name), "ActionNoteDate" => $action_note[1]. ' ' .date('H:i:s'), "IsActive" => 'A'));
				
			// Throw Note to Data Bundle
			if(empty($rmprocess[0]) && empty($rmprocess[1])):
				$data_bundled[0]['ActionNote']	= $action_note[0];
				$logs_bundled[0]['ActionNote']	= $action_note[0];
			else:
				
				if(empty($check_app2ca[0]['CA_ReceivedDocDate'])) $process = $note_bundled;
				else $process = $action_note[0];
				
				if($process_checked == 'FALSE') {
					$data_bundled[0]['ActionNote']	= $process;
					$logs_bundled[0]['ActionNote']	= $process;
				} else {
					$data_bundled[0]['ActionNote']	= $action_note[0];
					$logs_bundled[0]['ActionNote']	= $action_note[0];
				}
			
			endif;
			
		} else {
		
			// Gen new action note.
			if($action_mode == '1') {
					
				// If not have rm process
				if(empty($rmprocess[0]) && empty($rmprocess[1])):
					
					array_push($data_bundled,
						array(
								"DocID" 		 => $doc_id,
								"ActionNote" 	 => $action_note[0],
								"ActionNoteBy"	 => $this->emp_id,
								"ActionName"	 => $this->effective->set_chartypes($this->char_mode, $this->name),
								"ActionNoteDate" => $action_note[1]. ' ' .date('H:i:s'),
								"IsActive"		 => 'A'
						)
					);
				
					// write logs
					array_push($logs_bundled,array("DocID" => $doc_id, "ActionNote" => $action_note[0], "ActionNoteByID" => $this->emp_id, "ActionNoteByName"  => $this->effective->set_chartypes($this->char_mode, $this->name), "ActionNoteDate" => $action_note[1]. ' ' .date('H:i:s'), "IsActive" => 'A'));
					
				// If user is have choose rm process
				else:
					
					array_push($data_bundled,
						array(
								"DocID" 		 => $doc_id,
								"ActionNoteBy"	 => $this->emp_id,
								"ActionName"	 => $this->effective->set_chartypes($this->char_mode, $this->name),
								"ActionNoteDate" => $action_note[1]. ' ' .date('H:i:s'),
								"IsActive"		 => 'A'
						)
					);
				
					array_push($logs_bundled,
						array(
								"DocID" 		 	 => $doc_id,
								"ActionNoteByID"	 => $this->emp_id,
								"ActionNoteByName"	 => $this->effective->set_chartypes($this->char_mode, $this->name),
								"ActionNoteDate" 	 => $action_note[1]. ' ' .date('H:i:s'),
								"IsActive"		 	 => 'A'
						)
					);
				
					// Check Process
					if(empty($check_app2ca[0]['CA_ReceivedDocDate'] )) $process = $note_bundled;
					else $process = $action_note[0];
						
					if($process_checked == 'FALSE') {
						$data_bundled[0]['ActionNote']	= $process;	
						$logs_bundled[0]['ActionNote']	= $process;
					} else {
						$data_bundled[0]['ActionNote']	= $action_note[0];	
						$logs_bundled[0]['ActionNote']	= $action_note[0];
					}
			
				endif;
			
			}
			
			// User are not create new log, But update same data in action note.
			if($action_mode == '0') {
			
				if(empty($rmprocess[0]) && empty($rmprocess[1])):
			
					if(empty($result[0]['DocID'])) {
						array_push($data_bundled,
							array(
									"DocID" 		 => $doc_id,
									"ActionNote" 	 => $action_note[0],
									"ActionNoteBy"	 => $this->emp_id,
									"ActionName"	 => $this->effective->set_chartypes($this->char_mode, $this->name),
									"ActionNoteDate" => $action_note[1]. ' ' .date('H:i:s'),
									"IsActive"		 => 'A'
							)
						);
						
						// write logs
						array_push($logs_bundled, array("DocID" => $doc_id, "ActionNote" => $action_note[0], "ActionNoteByID" => $this->emp_id, "ActionNoteByName"  => $this->effective->set_chartypes($this->char_mode, $this->name), "ActionNoteDate" => $action_note[1]. ' ' .date('H:i:s'), "IsActive" => 'A'));
				
					} else {
							
						foreach($result as $index => $values) {
							array_push($data_bundled, array(
									"ActionNote" 		  => $action_note[0],
									"ActionNoteDate" 	  => $result[$index]['ActionNoteDate']. ' ' .date('H:i:s')
								)
							);
								
						}
						
						// write logs
						array_push($logs_bundled, array("DocID" => $doc_id, "ActionNote" => $action_note[0], "ActionNoteByID" => $this->emp_id, "ActionNoteByName"  => $this->effective->set_chartypes($this->char_mode, $this->name), "ActionNoteDate" => $action_note[1]. ' ' .date('H:i:s'), "IsActive" => 'A'));
							
					}
						
					
				else:
					
					if($data[0]['ActionName'] == 'System' || $data[0]['ActionName'] == 'SYSTEM') {
							
						array_push($data_bundled,
							array(
									"DocID" 		 => $doc_id,
									"ActionNoteBy"	 => $this->emp_id,
									"ActionName"	 => $this->effective->set_chartypes($this->char_mode, $this->name),
									"ActionNoteDate" => $action_note[1]. ' ' .date('H:i:s'),
									"IsActive"		 => 'A'
							)
						);
						
						array_push($logs_bundled,
							array(
									"DocID" 		 => $doc_id,
									"ActionNoteByID"	 => $this->emp_id,
									"ActionNoteByName"	 => $this->effective->set_chartypes($this->char_mode, $this->name),
									"ActionNoteDate" => $action_note[1]. ' ' .date('H:i:s'),
									"IsActive"		 => 'A'
							)
						);
					
					
							
					} else {
						
							
						if(empty($result[0]['DocID'])) {
							
							array_push($data_bundled,
								array(
										"DocID" 		 => $doc_id,
										"ActionNoteBy"	 => $this->emp_id,
										"ActionName"	 => $this->effective->set_chartypes($this->char_mode, $this->name),
										"ActionNoteDate" => $action_note[1]. ' ' .date('H:i:s'),
										"IsActive"		 => 'A'
									)
							);		
							
							array_push($logs_bundled,
								array(
										"DocID" 			 => $doc_id,
										"ActionNoteByID"	 => $this->emp_id,
										"ActionNoteByName"	 => $this->effective->set_chartypes($this->char_mode, $this->name),
										"ActionNoteDate" 	=> $action_note[1]. ' ' .date('H:i:s'),
										"IsActive"		 	=> 'A'
								)
							);
							
								
						} else {
								
							foreach($result as $index => $values) {
								array_push($data_bundled, array(
										"ActionNoteDate" 	 => $result[$index]['ActionNoteDate']. ' ' .date('H:i:s')
									)										
								);
				
							}
							
							// write logs
							array_push($logs_bundled, array("DocID" => $doc_id, "ActionNoteByID" => $this->emp_id, "ActionNoteByName"  => $this->effective->set_chartypes($this->char_mode, $this->name), "ActionNoteDate" => $action_note[1]. ' ' .date('H:i:s'), "IsActive" => 'A'));
						
						}
							
					}
				
					// Check Process
					if(empty($check_app2ca[0]['CA_ReceivedDocDate'] )) $process = $note_bundled;
					else $process = $action_note[0];
					
					if($process_checked == 'FALSE') {
						$data_bundled[0]['ActionNote']	= $process;
						$logs_bundled[0]['ActionNote']	= $process;
					} else {
						$data_bundled[0]['ActionNote']	= $action_note[0];
						$logs_bundled[0]['ActionNote']	= $action_note[0];
					}

				endif;
			
			}
			
		}
	
		// Escape exception error. because data when create new log or first logs data first transaction will empty
		if(empty($data[0]['ActionNote'])) :
			$store_note = '';
		else:	
			$store_note = trim($data[0]['ActionNote']);
		endif;
		
		// check top log by user or system
		$table_logs = !empty($data[0]['ActionName']) ? $data[0]['ActionName']:"";
		
		// Check note unique, if true system will cancel object datas				
		if(trim($action_note[0]) === $store_note) {			
			unset($data_bundled);
			unset($logs_bundled);
			
		} else {
			
			// Data bundled logs
			if($action_mode == '1') {
				
				if($process_checked == 'FALSE'):
					$this->dbmodel->exec('RMProcessBundled', array("DocID" => $doc_id, "RMProcess" => $rmprocess[0], 'IsBundled' => $rmprocess[1]), false, 'insert');
				endif;
				
				$verification 		 = $this->dbmodel->exec($this->table_verification, array('ActionNote' => $action_note[0]), array("DocID" => $doc_id), 'update');
				$this->dbmodel->exec("ActionNote", $data_bundled[0], false, 'insert');
			
				$this->writeActionNoteLogs($doc_id, $logs_bundled);
				
			} else {
					
				if($table_logs == 'System' || $table_logs == 'SYSTEM') {
					$this->dbmodel->exec("ActionNote", $data_bundled[0], false, 'insert');
					$this->dbmodel->exec($this->table_verification, array("ActionNote" => $note_bundled[0], "ChangeBy" => $this->effective->set_chartypes($this->char_mode, $this->name), "ChangeDate" => date('Y-m-d H:i:s')), array("DocID" => $doc_id), 'update');
			
					$this->writeActionNoteLogs($doc_id, $logs_bundled);
					
				} else {
					
					$inquery = $this->getActionNoteLog_FilterMode($doc_id, 1);
					if(empty($result[0]['DocID'])) {		
						
						if($process_checked == 'FALSE'):
							$this->dbmodel->exec('RMProcessBundled', array("DocID" => $doc_id, "RMProcess" => $rmprocess[0], 'IsBundled' => $rmprocess[1]), false, 'insert');
						endif;
						
						$this->dbmodel->exec("ActionNote", $data_bundled[0], false, 'insert');
						$this->dbmodel->exec($this->table_verification, array("ActionNote" => $note_bundled[0], "ChangeBy" => $this->effective->set_chartypes($this->char_mode, $this->name), "ChangeDate" => date('Y-m-d H:i:s')), array("DocID" => $doc_id), 'update');
						
						$this->writeActionNoteLogs($doc_id, $logs_bundled);
						
					} else {	
						
						if($process_checked == 'FALSE'):
							$this->dbmodel->exec('RMProcessBundled', array("DocID" => $doc_id, "RMProcess" => $rmprocess[0], 'IsBundled' => $rmprocess[1]), false, 'insert');
						endif;
						
						$this->dbmodel->exec('ActionNote', $data_bundled[0], array("DocID" => $doc_id, "RowID" => $inquery[0]['RowID']), 'update');
						$this->dbmodel->exec($this->table_verification, array("ActionNote" => $note_bundled[0], "ChangeBy" => $this->effective->set_chartypes($this->char_mode, $this->name), "ChangeDate" => date('Y-m-d H:i:s')), array("DocID" => $doc_id), 'update');
							
						$this->writeActionNoteLogs($doc_id, $logs_bundled);
						
					}
				
				}
								
			}
			
		}	
		
	}
	
	public function writeActionNoteLogs($doc_id, $logs_bundled) {
		$this->load->model('dbmodel');
		$logs	= $this->dbmodel->data_validation('ActionNoteLog', '*', array('DocID' => $doc_id, 'ActionNote' => $logs_bundled[0]['ActionNote']), false);
		if($logs == 'FALSE') {
			$this->dbmodel->exec('ActionNoteLog', $logs_bundled[0], false, 'Insert');
		}
		
	}
	
	// BEHIDE SCENE 
	public function setActionOnBundled() {
		header('Content-Type: application/json; charset="utf-8"');
		
		$this->load->model("dbmodel");
		$this->load->model("dbstore");
		
		$doc_id			= $this->input->post('relx');
		$action_mode	= $this->input->post('action_mode');
		$actionnote		= $this->input->post('actionnote');
		$actionnotedate	= $this->input->post('actiondate');
		
		date_default_timezone_set("Asia/Bangkok");
		if(empty($doc_id)) {
			
			echo json_encode(
				array(
					'status' => 'false',
					'msg' 	 => 'เกิดข้อผิดพลาดในการรับข้อมูล กรุณาลองใหม่อีกครั้ง.'
				)
			);
			
		} else {
			
			try {
				
				$objActionNote = array(
						"DocID" 		 => $doc_id,
						"ActionNote" 	 => $this->effective->set_chartypes($this->char_mode, $actionnote),
						"ActionNoteBy"	 => $this->emp_id,
						"ActionName"	 => $this->effective->set_chartypes($this->char_mode, $this->name),
						"ActionNoteDate" => $actionnotedate. ' ' .date('H:i:s'),
						"IsActive"		 => 'A'
				);
				
				
				if($action_mode == '1') {
					
					$verification_logs 	 = $this->dbmodel->exec("ActionNote", $objActionNote, false, 'insert');	
					if($verification_logs == TRUE) {
						echo json_encode(
								array(
										'data'	 => array(
												"ActionNote" 	 => $actionnote,
												"ActionNoteBy"	 => $this->emp_id,
												"ActionName"	 => $this->name,
												"ActionNoteDate" => $actionnotedate. ' ' .date('H:i:s')
										),
										'status' => 'true',
										'msg' 	 => 'บันทึกข้อมูลสำเร็จ'
								)
						);
							
					} else {
							
						echo json_encode(
								array('status' => 'false',
									  'msg'    => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล กรุณาติดต่อผู้ดูแลระบบ.'
								)
						);
					
					}
					
					
							
				} else {

					$verification = $this->dbmodel->exec($this->table_verification, array('ActionNote' => $this->effective->set_chartypes($this->char_mode, $actionnote)), array("DocID" => $doc_id), 'update');
					if($verification == TRUE) {
						
						
						$data		  = array();
						$result 	  = $this->dbstore->exec_getActionNoteLogs($doc_id);
						foreach($result as $index => $values) {
								
							array_push($data, array(
									"ActionNote" 		  => $this->effective->get_chartypes($this->char_mode, $result[$index]['ActionNote']),
									"ActionNoteBy" 		  => $result[$index]['ActionNoteBy'],
									"ActionName" 		  => $this->effective->get_chartypes($this->char_mode, $result[$index]['ActionName']),
									"ActionNoteDate" 	  => $result[$index]['ActionNoteDate']
							));
														
						}

						if($data[0]['ActionName'] == 'System') {							
							$inquery = $this->getActionNoteLog_FilterMode($doc_id, 2);							
							if(!empty($inquery[0]['RowID'])) {
								$verification_logs 	 = $this->dbmodel->exec("SystemNoteLog", array("ActionNote" => $this->effective->set_chartypes($this->char_mode, $actionnote)), array('DocID' => $doc_id, 'RowID' => $inquery[0]['RowID']), 'update');
									
							} else {
								$verification_logs 	 = $this->dbmodel->exec("SystemNoteLog", $objActionNote, false, 'insert');	
								
							}
						
							
						} else {
							
							$inquery = $this->getActionNoteLog_FilterMode($doc_id, 1);
							if(!empty($inquery[0]['RowID'])) {
								$verification_logs 	 = $this->dbmodel->exec("ActionNote", $objActionNote,  array('DocID' => $doc_id, 'RowID' => $inquery[0]['RowID']), 'update');								
								
							} else {							
								$verification_logs 	 = $this->dbmodel->exec("ActionNote", $objActionNote, false, 'insert');				
								
							}
							
						}
						
						
						if($verification_logs == TRUE) {
							echo json_encode(
									array(
										'data'	 => array(
												"ActionNote" 	 => $actionnote,
												"ActionNoteBy"	 => $this->emp_id,
												"ActionName"	 => $this->name,
												"ActionNoteDate" => $actionnotedate. ' ' .date('H:i:s')
										),
										'status' => 'true',
										'msg' 	 => 'บันทึกข้อมูลสำเร็จ'
									)
							);
							
						} else {
					
							echo json_encode(
								array(
										'status' => 'false',
										'msg' 	 => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล กรุณาติดต่อผู้ดูแลระบบ.'
								)
							);
				
						}
				
						
					} else {
			
						echo json_encode(
							array('status' => 'false',
								  'msg'    => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล กรุณาติดต่อผู้ดูแลระบบ.'
							)
						);
			
					}
				
					
				}
							
								
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
			
		}
				
		 
	}
	
	private function checkUnique($table, $fields, $condition = array()) {
		$this->load->model("dbmodel");
		$result   =  $this->dbmodel->loadData($table,  $fields, $condition);
		return $result;
	
	}
	
	private function setReactivateTransaction($reactivereason, $reactivedate, $condition = array()) {
		$this->load->model('dbmodel');
		
		if(!empty($reactivereason) && !empty($reactivedate)) {
			
			$cancel_reason = $this->config->item('CancelBefore');
			if(in_array($condition[2], $cancel_reason)) {
					
				$appstatus = $this->dbmodel->loadData($this->table_applicationstatus, "DocID, CONVERT(nvarchar(10), CA_ReceivedDocDate, 120) AS CA_ReceivedDocDate, Status, IsActive", array("DocID" => $condition[0]));
				if(empty($appstatus['data'][0]['CA_ReceivedDocDate'])) {
				
					if(in_array($appstatus['data'][0]['Status'], $cancel_reason)) {
							
						try {
								
							$clear_state = array(
									"Status"          => NULL,
									"StatusDate"      => NULL,
									"IsActive"        => "",
									"ChangeBy"        => $this->effective->set_chartypes($this->char_mode, $this->prepareInput($this->name)),
									"ChangeDate"      => date("Y-m-d H:i:s")
							);
				
							$reactivate_enrolled = implode(',', $reactivereason);
							$reactivate_log = array(
									"DocID"             => $condition[0],
									"EmployeeCode"      => $this->emp_id,
									"ReActivateDate"    => date("Y-m-d H:i:s"),
									"IsActive"          => "A",
									"ReActivatedReason" => !empty($reactivate_enrolled) ? $reactivate_enrolled:NULL
							);
				
							
							$borrower_info = $this->dbmodel->loadData('NCB', 'MainLoanName', array('VerifyID' => $condition[1]));
									
							$borrwer_names  = $borrower_info['data'][0]['MainLoanName'] . '(REA)';
							$this->dbmodel->exec('NCB', array('MainLoanName' => $borrwer_names), array('VerifyID' =>  $condition[1]), 'update');
							$this->dbmodel->exec('NCBConsent', array('BorrowerName' => $borrwer_names), array('DocID' => $condition[0], 'BorrowerType' => '101'), 'update');
									
							$this->dbmodel->exec($this->table_applicationstatus, $clear_state, array("DocID" => $condition[0]), 'update');
							$this->dbmodel->exec($this->table_verification, array('RMProcess' => NULL, 'RMProcessDate' => NULL), array("DocID" => $condition[0]), 'update');
							$logs_bundled = $this->dbmodel->exec('Reactivate_TransactionLog', $reactivate_log, false, 'insert');
							
							if($logs_bundled == TRUE):
							
								$this->dbmodel->exec('DocumentErrorTracker', array('IsActive' => 'N'), array('DocID' => $condition[0]), 'update');
								$this->dbmodel->exec('DocumentErrorSubList', array('IsActive' => 'N'), array('DocID' => $condition[0]), 'update');
														
								return 'TRUE';
								
							else:
								return 'FALSE';
							
							endif;
											
						} catch (Exception $e) {
							echo 'Caught exception: '.$e->getMessage()."\n";
							echo 'Caught exception: '.$e->getLine()."\n";
							echo 'The Exception: '.$e->getTrace()."\n";
						}
							
					}
				
				}
					
			}
					
		} else {	
			echo 'FALSE';		
		}
		
	}
	
	// This function cancel because change objective in using method.
	private function setReActivatePlan($reactivereason, $reactivedate, $condition = array()) {
		
		if(!empty($reactivereason) && !empty($reactivedate)):
		
			$cust_info  = $this->getCustomerInformation($condition[1]);

			$ReActivate	= array(
					"VerifyID" 			=> $condition[0],
					"RevisitDate" 		=> $this->effective->StandartDateSorter($reactivedate),
					"BranchCode" 		=> $cust_info['BranchCode'],
					"CreateRevisitBy"	=> $this->effective->set_chartypes($this->char_mode, $this->name),
					"CreateRevisitDate" => date('Y-m-d H:i:s'),
					"IsActive"			=> "A"
			);

			try {
				
				$revisit  	 = $this->ReActivateGenerate($cust_info['BranchCode']);
				$revisit_id	 = $cust_info['BranchCode'].'-'.substr(date('Y'), 2).str_pad($revisit['Runno'], 3, "0",   STR_PAD_LEFT);
				$checked 	 = $this->checkUnique('ReActivate', "RevisitRef, BranchCode", array("RevisitRef" => $revisit_id, "BranchCode" => $cust_info['BranchCode']));
					
				if($checked['status'] == 'true'):
					$revisitno     	       = (int)$revisit['Runno'] + 1;
					$revisit_ref  	       = $cust_info['BranchCode'].'-'.substr(date('Y'), 2).str_pad($revisitno, 3, "0",   STR_PAD_LEFT);
					$objForms			   = array_merge($ReActivate, array("RevisitRef" => $revisit_ref));
				
				else:
					$revisit_ref    	   = $cust_info['BranchCode'].'-'.substr(date('Y'), 2).str_pad($revisit['Runno'], 3, "0",   STR_PAD_LEFT);
					$objForms			   = array_merge($ReActivate, array("RevisitRef" => $revisit_ref));
				
				endif;

				
				if(array_key_exists('RevisitRef', $objForms)) {
				
					$reactivate_checked = $this->dbmodel->data_validation('ReActivate', "VerifyID", array("VerifyID" => $condition[0]), false);
					if($reactivate_checked == 'FALSE') :
						$revisit_bundle    = $this->dbmodel->exec('ReActivate', $objForms, false, 'insert');
						$Runno 			   = $this->dbmodel->exec('MasterRevisit', array("Runno" => (int)$revisit['Runno'] + 1), array("Year" => date("Y")), "update");
						
					else:
						$revisit_bundle	   = TRUE;
					
					endif;
	
					if($revisit_bundle == TRUE) {
						
						$reactive_option = array();
						foreach ($reactivereason as $index => $values) {
							
							array_push($reactive_option, array(
									"VerifyID" 	=> $condition[0],
									"RevisitID" => $reactivereason[$index],
									"IsActive" 	=> 'A'
								)
							);
	
						}
						
						if(!empty($reactive_option[0])) {
							$this->dbmodel->exec('ReActivateList', array("IsActive" => 'N'), array("VerifyID" => $condition[0]), "update");
							foreach ($reactive_option as $index => $values) {
									
								$list_checked = $this->dbmodel->data_validation('ReActivateList', "VerifyID", array("VerifyID" => $condition[0], "RevisitID" => $reactivereason[$index]), false);
								if($list_checked == 'FALSE') :
									$list_bundle    = $this->dbmodel->exec('ReActivateList', $reactive_option[$index], false, 'insert');
								else:
									$list_bundle    = $this->dbmodel->exec('ReActivateList', array("IsActive" => 'A'), array("VerifyID" => $condition[0], "RevisitID" => $reactivereason[$index]), 'update');
									
								endif;
										
							}
							
						}

						if($list_bundle == TRUE):
							return 'TRUE';
						else:
							return 'FALSE';
						endif;
	
						
					} else {
						throw new Exception("Error exception: Table ".__function__." is insert missing in reactivate table... ");
					}
					
					
				} else {
					echo 'Caught exception: '.$e->getMessage()."\n";
					echo 'Caught exception: '.$e->getLine()."\n";
					echo 'The Exception: '.$e->getTrace()."\n";
				}
				
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
			
		else:
			return  'FALSE';
		
		endif;
		
	}
	
	public function setDocumentManagementForm() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
				
		$miss_id		= $this->input->post('MissID');
		$doc_id			= $this->input->post('DocID');
		$borrowname		= $this->input->post('DocBorrowerName');
		$doc_ref		= $this->input->post('DocIsRef');
		$doc_type		= $this->input->post('DocTypes');
		$doc_status		= $this->input->post('DocStatus');
		$doc_other		= $this->input->post('DocOther');
		$doc_list		= $this->input->post('DocList');
		$submitToHQ		= $this->input->post('Doc_SubmitToHQ');
		$hq_receivedLB	= $this->input->post('Doc_HQReceived');
		$hqtoca			= $this->input->post('Doc_HQToCA');
		$ca_returndoc	= $this->input->post('Doc_CAToHQ'); 
		$hqsent_toLB	= $this->input->post('Doc_HQToLB');
		$lbreceived		= $this->input->post('Doc_LBReceived');
		$save_mode		= $this->input->post('Doc_Mode');
		
		// Modifier Date: 25/04/2015
		$non_return		= $this->input->post('NonReturn');	
				
		if(empty($doc_type[0]) && empty($doc_list[0])) {
			echo json_encode(
				array(
					'status' => 'false',
					'msg' 	 => $this->effective->get_chartypes($this->char_mode, 'กรุณาระบุข้อมูลประเภทและรายการของเอกสาร')
				)
			);
			
		} else {
			
			header('Content-Type: text/html; charset="tis-620"');
			
			$data_stack		= array();
		
			$completion_subtohq['SubmitToHQ']    = array();
			$completion_receivedlb['HQReceived'] = array();
			$completion_hqtoca['HQToCA']	     = array();
			$competion_document					 = array();
			
			$defend_group		= $this->config->item('DefendTeam');
			$support_group		= $this->config->item('SupportTeam');
			$administ_group		= $this->config->item('MISTeam');
			
			$this->role_ad 		= $this->config->item('ROLE_ADMIN');
			$this->role_rm 		= $this->config->item('ROLE_RM');
			$this->role_bm 		= $this->config->item('ROLE_BM');
			$this->role_am 		= $this->config->item('ROLE_AM');
			$this->role_rd 		= $this->config->item('ROLE_RD');
			$this->role_hq 		= $this->config->item('ROLE_HQ');
			$this->role_spv 	= $this->config->item('ROLE_SPV');
			$this->role_ads 	= $this->config->item('ROLE_ADMINSYS');
			
			$actor_user = 'UNKNOWN AUTH';
			if(in_array($this->emp_id, $defend_group)) {
				$actor_user = 'DEFEND';
			}
			else if(in_array($this->emp_id, $support_group)) {
				$actor_user = 'SUPPORT';
			}
			else if(in_array($this->emp_id, $administ_group)) {
				$actor_user = 'ADMINISTRATOR';
			} else {
				
				if(count($this->authorized) >= 1) :
					$privileges = $this->authorized[0];
				else:
					$privileges = $this->authorized[0];
				endif;
			
				switch($privileges) {
					case $this->role_ad:							
						if($empbranch !== "000" || $empbranch !== "901"):
							$actor_user	= 'ADMIN BRANCH';
						endif;							
						break;
					case $this->role_rm:
						$actor_user	= 'RM';
						break;
					case $this->role_bm:
						$actor_user	= 'BM';
						break;
					case $this->role_am:
						$actor_user	= 'BM';
						break;
					case $this->role_rd:
						$actor_user	= 'RD';
						break;				
					case $this->role_hq:
					case $this->role_spv:
					case $this->role_admin:
						$actor_user	= 'HO';						
						break;
							
				}
				
			}
						
			foreach($doc_type as $index => $values) {
				
				if(empty($doc_type[$index]) && empty($doc_list[$index]) || 
				  !empty($doc_type[$index]) && empty($doc_list[$index]) ||
				   empty($doc_type[$index]) && !empty($doc_list[$index])):
					 continue;
				
				else:
			
					array_push($data_stack, array(
							"DocID"	  					=> $doc_id,
							"DocOwner"					=> $this->effective->set_chartypes($this->char_mode, $borrowname),
							"DocType"					=> $doc_type[$index],
							"DocStatus"					=> $doc_status[$index],
							"DocList"					=> $doc_list[$index],							
							"DocOther"					=> !empty($doc_other[$index]) ? $this->effective->set_chartypes($this->char_mode, $doc_other[$index]):null,
							"LBSubmitDocDate"			=> $this->effective->StandartDateSorter($submitToHQ[$index]),
							"HQReceivedDocFromLBDate"	=> $this->effective->StandartDateSorter($hq_receivedLB[$index]),
							"SubmitDocToCADate"			=> $this->effective->StandartDateSorter($hqtoca[$index]),
							"CAReturnDate"				=> $this->effective->StandartDateSorter($ca_returndoc[$index]),
							"HQSentToLBDate"			=> $this->effective->StandartDateSorter($hqsent_toLB[$index]),
							"BranchReceivedDate"		=> $this->effective->StandartDateSorter($lbreceived[$index]),
							"IsActive"					=> 'A',
							"IsRef"						=> $doc_ref,
							"DocIsLock"					=> !empty($non_return[$index]) ? $non_return[$index]:NULL
						)
					);
					
				endif;
								
				if($doc_type[$index] == 'M' && !empty($submitToHQ[$index])):
					array_push($completion_subtohq['SubmitToHQ'], 'TRUE');
				else:
					array_push($completion_subtohq['SubmitToHQ'], 'FALSE');
				endif;
			
				if($doc_type[$index] == 'M' && !empty($hq_receivedLB[$index])):
					array_push($completion_receivedlb['HQReceived'], 'TRUE');
				else:
					array_push($completion_receivedlb['HQReceived'], 'FALSE');
				endif;
				
				
				if($doc_type[$index] == 'M' && !empty($hqtoca[$index])) {
					array_push($completion_hqtoca['HQToCA'], 'TRUE');
				} else {
					array_push($completion_hqtoca['HQToCA'], 'FALSE');
				}

			}
			
			try {

				$objmerge = array_merge($completion_subtohq['SubmitToHQ'], $completion_receivedlb['HQReceived'], $completion_hqtoca['HQToCA']);
				if(!in_array('FALSE', $objmerge)) {
					array_push($competion_document, array('CompletionDoc' => 'Y', 'CompletionDate' => date('Y-m-d')));				
				} else {
					array_push($competion_document, array('CompletionDoc' => 'N', 'CompletionDate' => date('Y-m-d')));					
				}
				
				if($save_mode == 'M') {
					$reconcile_checked = $this->dbmodel->data_validation("ReconcileDoc", "DocID", array("DocID" => $doc_id, 'IsRef' => $doc_ref), false);
					if($reconcile_checked == 'TRUE'):
					$reconcile_state = $this->dbmodel->exec("ReconcileDoc", $competion_document[0], array("DocID" => $doc_id, 'IsRef' => $doc_ref), 'update');
					endif;
				}
				
				foreach($data_stack as $index => $value) {
					
					
					$completion_doc = $this->dbmodel->data_validation("ReconcileCompletion", "DocID, DocList, IsRef", 
								array("DocID"   => $data_stack[$index]['DocID'], 
								      "MISS_ID" => $miss_id[$index], "IsActive" => 'A'), false);
					
					if($completion_doc == 'TRUE'):
				
						$completion_bundled = $this->dbmodel->exec("ReconcileCompletion", $data_stack[$index],  
								array("DocID"   => $data_stack[$index]['DocID'], 
									  "MISS_ID" => $miss_id[$index]), 'update');
					else:
						
						$data_stack[$index]["Team"]			   = $actor_user;
						$data_stack[$index]["CreateDocID"] 	   = $this->emp_id;
						$data_stack[$index]["CreateDocBy"] 	   = $this->effective->set_chartypes($this->char_mode, $this->name);
						$data_stack[$index]["CreateDocDate"]   = date("Y-m-d H:i:s");
					
						$completion_bundled = $this->dbmodel->exec("ReconcileCompletion", $data_stack[$index], false, 'insert');
						
					endif;
					
				}				
				
				if($completion_bundled == TRUE) {
					$logs = $this->setWriteDocumentManagementLogs($data_stack);
					echo json_encode(
						array(
							'status' => 'true',
							'msg' 	 => $this->effective->get_chartypes($this->char_mode, 'บันทึกข้อมูลสำเร็จ.')
						)
					);
					
				} else {
					echo json_encode(
						array(
							'status' => 'false',
							'msg' 	 => $this->effective->get_chartypes($this->char_mode, 'เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาติดต่อผู้ดูแลระบบ')
						)
					);
				
				}
				
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
				
			}
		
		}
		
			
	}
	
	public function setNewBorrowerTypes() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$doc_id 		= $this->input->post('relx');
		$verify_id 		= $this->input->post('vefx');
		$id_card		= $this->input->post('id_card');
		$ncb_id 		= $this->input->post('ncb_id');		
		$ncb_type 		= $this->input->post('ncb_type');
		$ncb_name		= $this->input->post('ncb_name');
		$ncb_isref		= $this->input->post('ncb_isref');
		
		$docflow_id     = $this->input->post('df_id');
		$docflow_type   = $this->input->post('df_type');
		$docflow_name   = $this->input->post('df_name');
		$docflow_isref  = $this->input->post('df_isref');
		 
		$ncb_renew_type = $this->input->post('ncb_renew_type');
		$df_renew_type	= $this->input->post('df_renew_type');

		if(empty($ncb_renew_type[0]) && empty($df_renew_type[0])) {
			
			header('Content-Type: text/html; charset="UTF-8"');
			echo json_encode(array('status' => 'false', 'msg' =>'เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาติดต่อผู้ดูแลระบบ'));
			
		} else {
			
			$ncb_renew = array();
			$doc_renew = array();
			$main_ncb  = array();			
			
			$is_length = (count($ncb_type) - 1);
			foreach ($ncb_renew_type as $index => $values) {
				
				$gen_ref  = substr((date('Y') + 543), -2, 2).$verify_id[$index].'LB'.str_pad($is_length, 3, "0", STR_PAD_LEFT);				
				array_push($ncb_renew,
					array(
						"NCS_ID"  		=> $ncb_id[$index],
						"BorrowerType"	=> $ncb_renew_type[$index],
						"BorrowerName"	=> $this->effective->set_chartypes($this->char_mode, $ncb_name[$index]),
						"IsRef" 		=> $gen_ref
					)				
				);
				
				array_push($doc_renew, 
					array(
						"Rec_ID"  		=> $docflow_id[$index],
						"BorrowerType"	=> $df_renew_type[$index],
						"BorrowerName"	=> $this->effective->set_chartypes($this->char_mode, $docflow_name[$index]),
						"IsRef" 		=> $gen_ref
					)
				);
				
				if($ncb_renew_type[$index] == '101') {
						
					array_push($main_ncb, array(
						"VerifyID"		  	   => $verify_id[0],
						"MainLoanName"         => $this->effective->set_chartypes($this->char_mode, $ncb_name[$index])						
						)
					);
						
						
				}
				
				$is_length--;
				
			}
			
			array_multisort($ncb_renew, SORT_NUMERIC, SORT_ASC);
			array_multisort($doc_renew, SORT_NUMERIC, SORT_ASC);
			
			// Old data of ncb.
			$verified_checked = $this->dbmodel->data_validation($this->table_ncb, "VerifyID", array("VerifyID" => $verify_id[0]), false);
			if($verified_checked == 'TRUE'):
				$ncb_state = $this->dbmodel->exec($this->table_ncb, $main_ncb[0], array("VerifyID" => $verify_id[0]), 'update');
			endif;
			
			foreach($ncb_renew as $index => $values) {
							
				$ncbconsent_checked = $this->dbmodel->data_validation("NCBConsent", "NCS_ID, DocID, VerifyID", array("DocID" => $doc_id, 'NCS_ID' => $ncb_renew[$index]['NCS_ID']), false);
				if($ncbconsent_checked == 'TRUE'):
					
					$ncb_state = $this->dbmodel->exec("NCBConsent", array(
						"BorrowerType"	=> $ncb_renew[$index]['BorrowerType'],
						"BorrowerName"	=> $ncb_renew[$index]['BorrowerName'],
						"IsRef" 		=> $ncb_renew[$index]['IsRef']
					), array("DocID" => $doc_id, 'NCS_ID' => $ncb_renew[$index]['NCS_ID']), 'update');		
					
				endif;
				
				$reconcile_checked = $this->dbmodel->data_validation("ReconcileDoc", "Rec_ID, DocID", array("DocID" => $doc_id, 'Rec_ID' => $doc_renew[$index]['Rec_ID']), false);
				if($reconcile_checked == 'TRUE'):
				
					$reconcile_state = $this->dbmodel->exec("ReconcileDoc", array(
						"BorrowerType"	=> $doc_renew[$index]['BorrowerType'],
						"BorrowerName"	=> $doc_renew[$index]['BorrowerName'],
						"IsRef" 		=> $doc_renew[$index]['IsRef']
					), array("DocID" => $doc_id, 'Rec_ID' => $doc_renew[$index]['Rec_ID']), 'update');
							
				endif;
		
			}
			
			if($ncb_state == TRUE && $reconcile_state == TRUE) {
				header('Content-Type: text/html; charset="UTF-8"');
				echo json_encode(
					array('data' => $doc_id, 'status' => 'true', 'msg' => $this->effective->get_chartypes($this->char_mode, 'ปรับปรุงข้อมูลสำเร็จ กรุณารอสักครู่...'))
				);
					
			} else {
				header('Content-Type: text/html; charset="UTF-8"');
				echo json_encode(
					array('data' => $doc_id, 'status' => 'false', 'msg' => $this->effective->get_chartypes($this->char_mode, 'เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาติดต่อผู้ดูแลระบบ'))
				);
			
			}
					

		}
	
		
	}
	
	// Verification
	private function fnVerificationCancelProcess($doc_id, $rmprocess, $rmprocessdate, $reason, $verify_id, $plan_a2ca_log) {
		$this->load->model("dbmodel");
		$this->load->model('dbstore');
		$this->load->library('effective');
		
		$this->db_env = $this->config->item('database_env');
	
		date_default_timezone_set("Asia/Bangkok");
		$process_action = $this->effective->get_chartypes($this->char_mode, $rmprocess);
	
		if($process_action === "CANCELBYRM" || $process_action === "CANCELBYCUS" || $process_action === "CANCELBYCA") {
	
			try {
	
				$AppStateLog_Checked = $this->dbmodel->data_validation("AppStateLog", "DocID, AppState_Date", array("DocID" => $doc_id, "AppState_Date" => date('Y-m-d')), false);

				try {
					
					if($AppStateLog_Checked == 'TRUE'):
						$appstatelog_bundle   = $this->dbstore->exec_appstate_bundlelogs($doc_id, $rmprocess, $rmprocessdate, $this->effective->set_chartypes($this->char_mode, $this->prepareInput($this->name)), date('Y-m-d H:i:s'), "Y", 0);
					else:
						$appstatelog_bundle   = $this->dbstore->exec_appstate_bundlelogs($doc_id, $rmprocess, $rmprocessdate, $this->effective->set_chartypes($this->char_mode, $this->prepareInput($this->name)), date('Y-m-d H:i:s'), "Y", 1);
					endif;
					
					$collection_state = array(
							"Status"          => $this->prepareInput($rmprocess),
							"StatusDate"      => $rmprocessdate,
							"IsActive"        => "Y",
							"ChangeBy"        => $this->effective->set_chartypes($this->char_mode, $this->prepareInput($this->name)),
							"ChangeDate"      => date("Y-m-d H:i:s")
					);
					
					if($process_action === "CANCELBYCA"):
						$collection_state['StatusReason'] = 'CANCEL CN003';
					endif;
							
					$this->dbmodel->exec($this->table_applicationstatus, $collection_state, array("DocID" => $doc_id), 'update');
					
					if($this->db_env == 'production') {
						$app_info = $this->dbmodel->loadData($this->table_applicationstatus, 'ApplicationNo', array("DocID" => $doc_id));
						$app_num = !empty($app_info['data'][0]['ApplicationNo']) ? $app_info['data'][0]['ApplicationNo']:'';
						if(!empty($app_info['data'][0]['ApplicationNo'])):
							$this->dbstore->exec_defendsuspend($app_num);
						endif;						
					}
					
					// New Modifier
					if(!empty($plan_a2ca_log)) {
						$plan_apptoca_log = $this->dbmodel->exec('AppToCA_History', array(
								'DocID' 		=> $doc_id,
								'A2CA_PlanDate' => $plan_a2ca_log. ' ' .date('H:i:s'),
								'IsActive' 		=> 'A',
								'CreateBy' 		=> $this->effective->set_chartypes($this->char_mode, $this->name),
								'CreateDate' 	=> date('Y-m-d H:i:s')
						), false, 'insert');
							
						if($plan_apptoca_log == TRUE):
						$this->dbmodel->exec($this->table_verification, array("AppToCAPlanDate"	=> NULL), array("DocID" => $doc_id), 'update');
						endif;
					}	
					
				} catch (Exception $e) {
	
					echo 'Caught exception: '.$e->getMessage()."\n";
					echo 'Caught exception: '.$e->getLine()."\n";
					echo 'The Exception: '.$e->getTrace()."\n";
	
				}					
				
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
	
			}
			
		} 
		
	}

	public function setDefendInitialyzeForm() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
	
		$dfs_id			= $this->input->post('record_id');	
		$doc_id 		= $this->input->post('doc_id');		
		$defend_ref 	= $this->input->post('defendref');
		$defend_id		= $this->input->post('defend_id');
		$defend_reason	= $this->input->post('defend_reason');
		$defend_other	= $this->input->post('defend_other');
		
		$actor_date		= $this->input->post('actor_date');
		$actor_name		= $this->input->post('actor_name');
		
		$defend_subject = $this->input->post('defned_subject');
		$acdate_other	= $this->input->post('actor_date_other');
		$acname_other	= $this->input->post('actor_name_other');
		
		// Supplement
		$def_assignID	= $this->input->post('DefendEmpID');
		$def_assignName	= $this->input->post('DefendEmpName');
		
		$whip			= $this->input->post('whip');
		$enabled		= $this->input->post('enable');
		
		// Supplment
		$actor_date_latest		= $this->input->post('actor_date_latest');
		$actor_name_latest		= $this->input->post('actor_name_latest');
		
		$acdate_other_latest	= $this->input->post('actor_latestdate_other');
		$acname_other_latest	= $this->input->post('actor_latestname_other');
	
		date_default_timezone_set("Asia/Bangkok");
		if(empty($doc_id) || empty($defend_ref)) {
			redirect('management/loadSFEOnDefendPages?rel='.$doc_id.'lnx='.$defend_ref.'&enable=true&st=false&sp=1&whip='.$whip.'&enable='.$enabled, 'refresh');
	
		} else {
			
			try {
				
				foreach($defend_reason as $index => $value) {
					
					$table_subscription = $this->dbmodel->exec('DefendSubscription', 
						array("DefendNote" => $this->effective->set_chartypes($this->char_mode, htmlspecialchars($defend_reason[$index])),
							  "CreateBy"   => $this->effective->set_chartypes($this->char_mode, $actor_name[$index]),
							  "CreateDate" => $this->effective->StandartDateTime(ltrim($actor_date[$index])),
							  "UpdateBy"   => $this->effective->set_chartypes($this->char_mode, $actor_name_latest[$index]),
							  "UpdateDate" => $this->effective->StandartDateTime(ltrim($actor_date_latest[$index]))
						), 
					    array(
					    	"DFS_ID"	 => $dfs_id[$index],
					    	"DocID"		 => $doc_id,
					    	"DefendRef"	 => $defend_ref,
					    	"DefendCode" => $defend_id[$index]
					    ), 'update');
					
					if(!empty($def_assignID)) {
						$this->dbmodel->exec('DefendHead',array(
								"DefendEmpID" 	 => $def_assignID,
								"DefendEmpName"	 => !empty($def_assignName) ? $this->effective->set_chartypes($this->char_mode, $def_assignName):''
							), array("DocID" => $doc_id, "DefendRef" => $defend_ref), 'update'
						);
					}
					
					$defend_checklog = $this->dbmodel->data_validation('DefendSubscriptionLogs', "*", array("DocID"	=> $doc_id, "DefendRef"	=> $defend_ref, "DefendCode" => $defend_id[$index], "DefendNote" => $this->effective->set_chartypes($this->char_mode, $defend_reason[$index])), false);
					if($defend_checklog == 'FALSE') {
						
						if(empty($defend_reason[$index])) {
							continue;	
							
						} else {
							
							$this->dbmodel->exec('DefendSubscriptionLogs',
									array(
										"DocID"			=> $doc_id,
										"DefendRef"		=> $defend_ref,
										"DefendCode"	=> $defend_id[$index],
										"DefendNote"	=> $this->effective->set_chartypes($this->char_mode, $defend_reason[$index]),
										"IsActive"	 	=> 'A',
										"ActorBy"	 	=> $this->emp_id,
										"ActorName"		=> $this->effective->set_chartypes($this->char_mode, $this->name),
										"ActorDate"		=> date('Y-m-d H:i:s')
							), false, 'insert');
							
						}
						
						
					}
	
				}	
							
				if(!empty($defend_other)):
					$table_head = $this->dbmodel->exec('DefendHead', 
						array("DefendSubject"	 => $this->effective->set_chartypes($this->char_mode, $defend_subject),
							  "DefendSupplement" => $this->effective->set_chartypes($this->char_mode, $defend_other),
							  "UpdateBy"		 => $this->effective->set_chartypes($this->char_mode, $acname_other),	
							  "UpdateDate"		 => $this->effective->StandartDateTime(ltrim($acdate_other)),
							  "LastUpdateBy"	 => $this->effective->set_chartypes($this->char_mode, $acname_other_latest),
							  "LastUpdateDate"	 => $this->effective->StandartDateTime(ltrim($acdate_other_latest))								  							  
						),  
					array("DocID" => $doc_id, "DefendRef" => $defend_ref), 'update');
				else:
					$table_head = TRUE;
				endif;
				
			
				if($table_head == TRUE && $table_subscription == TRUE) {
					redirect('management/loadSFEOnDefendPages?rel='.$doc_id.'&lnx='.$defend_ref.'&enable=true&st=true&sp=1&whip='.$whip.'&enable='.$enabled, 'refresh');
				} else {
					redirect('management/loadSFEOnDefendPages?rel='.$doc_id.'&lnx='.$defend_ref.'&enable=true&st=false&sp=2&whip='.$whip.'&enable='.$enabled, 'refresh');
				}
				
				
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";

			}		
			
		}
	
	}
	
	// Set Error Tracker
	public function setErrorTrackList() {
		date_default_timezone_set("Asia/Bangkok");
		
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$table_name	= 'DocumentErrorTracker';
		$table_sub	= 'DocumentErrorSubList';
		
		$DocID 		= $this->input->post('DocID');
		$DocRef 	= $this->input->post('DocRef');
		$BranchCode	= $this->input->post('BranchCode');
		$CustName	= $this->input->post('CustName');
		$CustType	= $this->input->post('CustType');
		$RMCode		= $this->input->post('RMCode');
		$Score		= $this->input->post('KPIPoint');
		$Tracker_ID = $this->input->post('Tracker_ID');
		$Tracker	= $this->input->post('Tracker');
		$UpdateDate	= $this->input->post('UpdateDate');
		$ItemList	= $this->input->post('ItemList');
		$Completed  = $this->input->post('completed');
		
		$auth_adminsys = $this->config->item('Role_Enabled');
		$auth_defend = $this->config->item('DefendTeam');
		$auth_support = $this->config->item('SupportTeam');
		
		$team = 'Unknown';
		if(in_array($this->emp_id, $auth_adminsys)) {
			$team = 'Administrator';
		}
		else if(in_array($this->emp_id, $auth_defend)) {
			$team = 'Defend';
		}
		else if(in_array($this->emp_id, $auth_defend)) {
			$team = 'Admin Support';
		}
		
		$data_stack  = array(
			"DocID"  		=> $DocID,
			"BorrowerName"  => $this->effective->set_chartypes($this->char_mode, $CustName),
			"BorrowerType"  => $CustType,
			"BranchCode"  	=> $BranchCode,
			"RMCode"  		=> $RMCode,
			"Point"  		=> $Score,
			"Completed"		=> !empty($Completed) ? $Completed:NULL,
			"Team"			=> !empty($team) ? strtoupper($team):NULL,
			"IsRef"  		=> $DocRef,
			"IsActive"  	=> 'A'
		);
		
		$event_logs = array(
			"DocID"  		=> $DocID,
			"ApplicationNo" => NULL,
			"EventProcess"  => 'ERROR_TRACKING',
			'CreateByID'	=> $this->emp_id,
			'CreateByName'	=> $this->effective->get_chartypes($this->char_mode, $this->name),
			'CreateByDate'	=> date('Y-m-d H:i:s')
		);
		
		if(empty($DocID) && empty($CustType)) {
			echo json_encode(
				array(
					'status' => 'false',
					'msg' 	 => $this->effective->get_chartypes($this->char_mode, 'เกิดข้อผิดพลาดในการรับ-ส่งข้อมูล กรุณาลองใหม่อีกครั้ง หากยังไม่สามารถบันทึกข้อมูลได้ กรุณาติดต่อผู้ดูแลระบบ.')
				)
			);
		
		} else {
			
			$this->dbmodel->exec('PCISEventLogs', $event_logs, false, 'insert');
			
			try {
					
				$track_state = null;
				$track_check = $this->dbmodel->data_validation($table_name, '*', array('DocID' => $DocID, 'BorrowerType' => $CustType, 'IsActive' => 'A'), false);
				
				if($track_check == 'FALSE'):
					
					$data_stack["CreateByID"] 	 = $Tracker_ID;
					$data_stack["CreateByName"]  = $this->effective->set_chartypes($this->char_mode, $Tracker);
					$data_stack["CreateDate"]    = date("Y-m-d H:i:s");

 					$track_state = $this->dbmodel->exec($table_name, $data_stack, false, 'insert');

				else:
					
					$data_stack["UpdateByID"] 	 = $Tracker_ID;
					$data_stack["UpdateByName"]  = $this->effective->set_chartypes($this->char_mode, $Tracker);
					$data_stack["UpdateDate"]    = date("Y-m-d H:i:s");
					
					$track_state = $this->dbmodel->exec($table_name, $data_stack, array('DocID' => $DocID, 'BorrowerType' => $CustType, 'IsActive' => 'A'), 'update');

				endif;
		
				if($track_state == TRUE):
									
					if($ItemList == false) {
						
						$tracker_status = TRUE;
						if($tracker_status == TRUE) {
							echo json_encode(array('status' => 'true', 'msg' => $this->effective->get_chartypes($this->char_mode, 'บันทึกข้อมูลสำเร็จ.')));
						
						} else {
							echo json_encode(array('status' => 'false', 'msg' 	 => $this->effective->get_chartypes($this->char_mode, 'เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาติดต่อผู้ดูแลระบบ')));
						
						}
						
					} else {
						
						$this->dbmodel->exec($table_sub, array('IsActive' => 'N'), array('DocID' => $DocID, 'IsRef' => $DocRef, 'IsActive' => 'A'), 'update');
						foreach($ItemList as $index => $value) {
						
							$sub_list = $this->dbmodel->data_validation($table_sub, "*", array("DocID" => $DocID, "IsRef" => $DocRef, "ItemList_Error" => $ItemList[$index], 'IsActive' => 'A'), false);
							if($sub_list == 'TRUE'):
							$tracker_status = $this->dbmodel->exec($table_sub,
								array("DocID"  		      => $DocID,
									  "IsRef"   		  => $DocRef,
									  "ItemList_Error"    => $ItemList[$index],
									  "IsActive"		  => 'A'
								), array("DocID" => $DocID, "IsRef" => $DocRef, "ItemList_Error" => $ItemList[$index], 'IsActive' => 'A'), 'update');
							else:
							$tracker_status = $this->dbmodel->exec($table_sub,
								array("DocID"  		      => $DocID,
									  "IsRef"   		  => $DocRef,
									  "ItemList_Error"    => $ItemList[$index],
									  "IsActive"		  => 'A',
									  'CreateDate'		  => $this->effective->StandartDateSorter($UpdateDate).' '.date('H:i:s')
								), false, 'insert');
					
							endif;
						
						}
							
						if($tracker_status == TRUE) {
							echo json_encode(array('status' => 'true', 'msg' => $this->effective->get_chartypes($this->char_mode, 'บันทึกข้อมูลสำเร็จ.')));
								
						} else {
							echo json_encode(array('status' => 'false', 'msg' => $this->effective->get_chartypes($this->char_mode, 'เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาติดต่อผู้ดูแลระบบ')));
								
						}
						
					}
					
				else:
				
					echo json_encode(
						array(
							'status' => 'false',
							'msg' 	 => $this->effective->get_chartypes($this->char_mode, 'เกิดข้อผิดพลาดในการรับ-ส่งข้อมูล กรุณาลองใหม่อีกครั้ง หากยังไม่สามารถบันทึกข้อมูลได้ กรุณาติดต่อผู้ดูแลระบบ.')
						)
					);
					
				
				endif;
				
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";

			}
			
		}
		
	}
	
	public function setResetErrorTracking() {
		date_default_timezone_set("Asia/Bangkok");
		
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$table_name	= 'DocumentErrorTracker';
		$table_sub	= 'DocumentErrorSubList';
		
		$DocID 		= $this->input->post('DocID');
		$DocRef 	= $this->input->post('DocRef');
		
		$event_logs = array(
				"DocID"  		=> $DocID,
				"ApplicationNo" => NULL,
				"EventProcess"  => 'RESET ERROR_TRACKING',
				'CreateByID'	=> $this->emp_id,
				'CreateByName'	=> $this->effective->get_chartypes($this->char_mode, $this->name),
				'CreateByDate'	=> date('Y-m-d H:i:s')
		);
		
		if(empty($DocID) && empty($DocRef)) {
			echo json_encode(
				array(
					'status' => 'false',
					'msg' 	 => $this->effective->get_chartypes($this->char_mode, 'เกิดข้อผิดพลาดในการรับ-ส่งข้อมูล กรุณาลองใหม่อีกครั้ง หากยังไม่สามารถบันทึกข้อมูลได้ กรุณาติดต่อผู้ดูแลระบบ.')
				)
			);
			
		} else {
			
			$this->dbmodel->exec('PCISEventLogs', $event_logs, false, 'insert');
			
			$request_data = array(
				'IsActive' => 'N',
				'UpdateByID'	=> $this->emp_id,
				'UpdateByName'	=> $this->effective->get_chartypes($this->char_mode, $this->name),
				'UpdateDate'	=> date('Y-m-d H:i:s')
			);
			
			$tracker_actor = $this->dbmodel->exec($table_name, $request_data, array("DocID" => $DocID, "IsRef" => $DocRef), 'update');
			$tracker_list = $this->dbmodel->exec($table_sub, array('IsActive' => 'N'), array("DocID" => $DocID, "IsRef" => $DocRef), 'update');
			if($tracker_actor == TRUE && $tracker_list == TRUE) {
				echo json_encode(array('status' => 'true', 'msg' => $this->effective->get_chartypes($this->char_mode, 'รีเซ็ตข้อมูลสำเร็จ...')));
				
			} else {
				echo json_encode(array('status' => 'false', 'msg' => $this->effective->get_chartypes($this->char_mode, 'เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาติดต่อผู้ดูแลระบบ')));
				
			}
		
		}
		
	}
	
	// CAReturn Reason Bundled
	/* Parameter 
	 * @param 1: DocID
	 * @param 2: Employee Info arrray($emp_id, $emp_name)
	 * @param 3: List Reason arrray($item_data, $item_supplement)
	 */
	public function setDataReturnReasonBundled($doc_id, $employee = array(), $data_list = array()) {
		$this->load->model('dbstore');
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$table_main	= 'CAReturnLog';
		$table_sub	= 'CAReturnSubscriptionLog';

		$data_stack  = array(
				"DocID"  		=> $doc_id,
				"ReturnDate"  	=> date('Y-m-d H:i:s'),
				"IsActive"  	=> 'A',
				"CreateByID"  	=> $employee[0],
				"CreateByName"	=> $this->effective->set_chartypes($this->char_mode, $employee[1])
		);		
		
		if(empty($doc_id) && empty($employee[0])) {	
			//This code for behind scene
			//echo json_encode(array('status' => 'false', 'msg' => $this->effective->get_chartypes($this->char_mode, 'เกิดข้อผิดพลาดในการรับ-ส่งข้อมูล กรุณาลองใหม่อีกครั้ง หากยังไม่สามารถบันทึกข้อมูลได้ กรุณาติดต่อผู้ดูแลระบบ.')));
		
		} else {
			
			//if(!empty($data_list[0])) $item_data = explode(',', $data_list[0]);
			//if(!empty($data_list[1])) $item_supplement = explode(',', $data_list[1]);
			
			$item_data 			= array();
			$item_supplement	= array();
		
			// Convert and merge into object
			foreach($data_list[0] as $index => $value) {
				$item_data[$index]['ItemCode'] = explode(',', $value);
			}
			
			foreach($data_list[1] as $index => $value) { 
				$item_supplement[$index]['ItemSupplement'] = explode(',', $value); 
			}
			
			foreach($data_list[2] as $index => $value) {
				$item_data[$index]['Rec_ID'] 	   = explode(',', $value);
				$item_supplement[$index]['Rec_ID'] = explode(',', $value);
			}
	
			try {

				$return_check = $this->dbstore->exec_getCAReturnAmount($doc_id);				
				if($return_check['status'] == 'true') {			
					$data_amount 			 = $return_check['data'][0]['ReturnRef'] + 1;
					$data_stack["ReturnRef"] = $data_amount;
					
				} else {					
					$data_amount			 = 1;
					$data_stack["ReturnRef"] = $data_amount;
		
				}
				
				$data_bundled = $this->dbmodel->exec($table_main, $data_stack, false, 'insert');
				if($data_bundled == TRUE):					
					
					if(empty($item_data[0]['ItemCode'])) {							
						//This code for behind scene
						//echo json_encode(array('status' => 'false', 'msg' => $this->effective->get_chartypes($this->char_mode, 'กรุณาเลือกระบุเหตุผลอย่างน้อย 1 รายการ.')));
					
					} else {	
						
						// unset other list for create new transaction
						foreach($item_data as $index => $value) {		
							if(in_array("OT099", $item_data[$index]['ItemCode'])):	
								$keyno = array_search("OT099", $item_data[$index]['ItemCode']);
								if($keyno !== false) unset($item_data[$index]['ItemCode'][$keyno]);							
							endif;
							
						}
					
						// This is object get data list about ca return reason. And optional reason. 	
						$credit_returnreason  	 = array();
						$credit_returnetcreason  = array();						
						foreach($item_data as $index => $value) {							
						
							foreach ($item_data[$index]['ItemCode'] as $pointer => $content) {
								
								if(empty($item_data[$index]['ItemCode'][$pointer])):
									continue;
								else:
									
									array_push($credit_returnreason, array(
											'DocID'         => $doc_id,
											'ReturnRef'     => $data_amount,
											'DefendCode'    => $item_data[$index]['ItemCode'][$pointer],
											'DefendOther'	=> NULL,
											'Flag'			=> 'N',
											'Rec_ID'		=> $item_data[$index]['Rec_ID'][0],
											'IsActive'      => 'A'
										)
									);
									
								endif;
								
								
							}
																			
						}
	
						foreach($item_supplement as $index => $value) {
							
							foreach ($item_supplement[$index]['ItemSupplement'] as $pointer => $content) {
							
								if($item_supplement[$index]['ItemSupplement'][$pointer] == ""):
									continue;
								else:
								
									array_push($credit_returnetcreason, array(
											'DocID'         => $doc_id,
											'ReturnRef'     => $data_amount,
											'DefendCode'    => "OT099",
											'DefendOther'   => $this->effective->set_chartypes($this->char_mode, $item_supplement[$index]['ItemSupplement'][$pointer]),
											'Flag'			=> 'N',
											'Rec_ID'		=> $item_supplement[$index]['Rec_ID'][0],
											'IsActive'      => 'A'
										)
									);
									
								endif;
								
							}
							
						}	

						if(!empty($credit_returnetcreason[0])):
							$data_merge	= array_merge($credit_returnreason, $credit_returnetcreason);
						else:
							$data_merge	= $credit_returnreason;
						endif;
						
						$state_bundled = array();				
						foreach($data_merge as $index => $value) {
							
							$list_bundled = $this->dbmodel->exec($table_sub, $data_merge[$index], false, 'insert');
							
							if($list_bundled) array_push($state_bundled, 'TRUE');
							else array_push($state_bundled, 'FALSE');
							
						}
						
					}
					
				
				else:	
					//This code for behind scene
					//echo json_encode(array('status' => 'false', 'msg' => $this->effective->get_chartypes($this->char_mode, 'เกิดข้อผิดพลาดในการรับ-ส่งข้อมูล กรุณาลองใหม่อีกครั้ง หากยังไม่สามารถบันทึกข้อมูลได้ กรุณาติดต่อผู้ดูแลระบบ.')));
				
				endif;
						
				
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";

			}			
		
		}
		
		
	}
	
	
	// OBJECT CONVERTER	
	private function getVerifyInfo($doc_id) {
		$this->load->model('dbstore');
		$this->load->library('effective');
		
		if(empty($doc_id)):
			return 0;
		else:
		
			$result = $this->dbstore->exec_getVerificationInfo($doc_id);
			if(!empty($result)) {
				
				return array(
						'DocID'             => $result[0]['DocID'],
						'VerifyID'          => $result[0]['VerifyID'],
						"ID_Card"			=> trim($result[0]['ID_Card']),
						"ProductCode"       => $result[0]['ProductCode'],
						"ProductType"       => $result[0]['ProductType'],
						"ProductLoanTypeID"	=> $result[0]['ProductLoanTypeID'],
						"Bank"				=> $result[0]['Bank'],
						"ProductName"       => $this->effective->get_chartypes($this->char_mode, $result[0]['ProductName']),
						"OnBehalf"			=> $result[0]['OnBehalf'],
						"CheckNCB"			=> $result[0]['CheckNCB'],
						"CheckNCBDate"		=> $this->effective->StandartDateRollback($result[0]['CheckNCBDate']),
						"Comments"			=> $this->effective->get_chartypes($this->char_mode, $result[0]['Comments']),
						"RMProcess"         => $this->effective->get_chartypes($this->char_mode, $result[0]['RMProcess']),
						"RMProcessDate"     => $this->effective->StandartDateRollback($result[0]['RMProcessDate']),
						"RMProcessReason"   => $result[0]['RMProcessReason'],
						"AppToCAPlanDate"   => $this->effective->StandartDateRollback($result[0]['AppToCAPlanDate']),
						"ProcessReason"		=> $this->effective->get_chartypes($this->char_mode, $result[0]['ProcessReason']),
						'ActionNote'        => $this->effective->get_chartypes($this->char_mode, $result[0]['ActionNoteLog']),
						'ActionNameLog'     => $this->effective->get_chartypes($this->char_mode, $result[0]['ActionNameLog']),
						'ActionNoteDate'	=> (!empty($result[0]['ActionNoteDate'])) ? $result[0]['ActionNoteDate']:'', 
						'ActionDateTime'	=> (!empty($result[0]['ActionDateTime'])) ? $result[0]['ActionDateTime']:'',
						"MRTA"              => $result[0]['MRTA'],
						"Cashy"             => $result[0]['Cashy'],
						"RevisitRef"        => $result[0]['RevisitRef'],
						"RevisitDate"       => $this->effective->StandartDateRollback($result[0]['RevisitDate']),
						"IsActive"          => $result[0]['IsActive']
				);
				
			}
			
		
		endif;		
		
	}
	
	private function getNCBConsentData($DocID) {
		$this->load->model('dbapp');
		$this->load->library('effective');
		
		if(empty($DocID)) :
			return 0;
		
		else :
		
			try {
			
				$result = $this->dbapp->getDataConsent($DocID);
				if(!empty($result)) {
					
					foreach($result['data'] as $index => $values) {
					
						$data[] = array(
							"NCS_ID"			=> $result['data'][$index]['NCS_ID'],
							"DocID" 			=> $result['data'][$index]['DocID'],
							"VerifyID" 			=> $result['data'][$index]['VerifyID'],
							"IDNO" 				=> !empty($result['data'][$index]['IDNO']) ? $result['data'][$index]['IDNO']:'',
							"BorrowerType" 		=> $result['data'][$index]['BorrowerType'],
							"BorrowerName" 		=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['BorrowerName']),
							"NCBCheck" 			=> $result['data'][$index]['NCBCheck'],
							"NCBCheckDate" 		=> !empty($result['data'][$index]['NCBCheckDate']) ? $this->effective->StandartDateRollback($result['data'][$index]['NCBCheckDate']):"",
							"SubmitToHQ" 		=> !empty($result['data'][$index]['SubmitToHQ']) ? $this->effective->StandartDateRollback($result['data'][$index]['SubmitToHQ']):"",
							"HQReceivedFromLB"  => !empty($result['data'][$index]['HQReceivedFromLB']) ? $this->effective->StandartDateRollback($result['data'][$index]['HQReceivedFromLB']):"",
							"HQSubmitToOper" 	=> !empty($result['data'][$index]['HQSubmitToOper']) ? $this->effective->StandartDateRollback($result['data'][$index]['HQSubmitToOper']):"",
							"OperReturnDate" 	=> !empty($result['data'][$index]['OperReturnDate']) ? $this->effective->StandartDateRollback($result['data'][$index]['OperReturnDate']):"",
							"OperReturnDateLog"	=> !empty($result['data'][$index]['NCBReturnDateLog']) ? $this->effective->StandartDateRollback($result['data'][$index]['NCBReturnDateLog']):"",
							"IsRef" 			=> $result['data'][$index]['IsRef']
						);

					}
					
					return $data;
					
				}
				
				
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
			
		endif;	
		
	}
	
	public function getTransactionRMLogs($DocID) {
		$this->load->library('effective');
		
		if(empty($DocID)) :
			return 0;
			
		else :
		
			try {

				$verified_id  = $this->dbmodel->loadData($this->table_verification, "VerifyID", array("DocID" => $DocID));
			
				$data		  = array();
				$result		  = $this->dbstore->exec_getRMProcessLogs($verified_id['data'][0]['VerifyID']);
				foreach($result as $index => $values) {
					
					 array_push($data, array(
						"VerifyID" 	    => $result[$index]['VerifyID'],
					 	"ProcessType"   => $result[$index]['ProcessType'],
					 	"EmployeeCode"  => $result[$index]['EmployeeCode'],
					 	"EmployeeName"  => $result[$index]['EmployeeName'],
						"ProcessDate"   => $this->effective->StandartDateRollback($result[$index]['ProcessDate']),
					 	"ProcessTime"   => substr($result[$index]['ProcessTime'], 0, 5),
						"Runno" 	    => $result[$index]['Runno']
					));
					
				}
				
				return $data;
			
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
				
		endif;
	}
	
	public function getActionNoteLogs($DocID) {
		$this->load->library('effective');
		
		if(empty($DocID)) :
			return 0;
			
		else :
		
		try {
		
			$data		  = array();
			$result		  = $this->dbstore->exec_getActionNoteLogs($DocID);
			foreach($result as $index => $values) {
					
				array_push($data, array(
					"ActionNote" 		  => $result[$index]['ActionNote'],
					"ActionNoteBy" 		  => $result[$index]['ActionNoteBy'],
					"ActionName" 		  => $result[$index]['ActionName'],
					"ActionNoteDate" 	  => $this->effective->StandartDateRollback($result[$index]['ActionNoteDate']),
					"ActionDateTime" 	  => substr($result[$index]['ActionDateTime'], -8, 5)
				));
					

			}
		
			return $data;
				
		} catch (Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
		}
		
		endif;
		
	}
	
	public function getActionNoteLog_FilterMode($DocID, $Mode) {
		$this->load->library('effective');
	
		if(empty($DocID)) :
			return 0;
			
		else :
	
			try {
		
				$data		  = array();
				$result		  = $this->dbstore->exec_getActionNoteFilterMode($DocID, $Mode);
				foreach($result as $index => $values) {
						
					array_push($data, array(
							"RowID"				=> $result[$index]['RowID'],
							"DocID"				=> $result[$index]['DocID'],
							"ActionNote" 		=> $this->effective->get_chartypes($this->char_mode, $result[$index]['ActionNote']),
							"ActionNoteBy" 		=> $result[$index]['ActionNoteBy'],
							"ActionName" 		=> $this->effective->get_chartypes($this->char_mode, $result[$index]['ActionName']),
							"ActionNoteDate" 	=> $this->effective->StandartDateRollback($result[$index]['ActionNoteDate']),
							"ActionDateTime" 	=> substr($result[$index]['ActionDateTime'], -8, 5)
					));
						
		
				}
		
				return $data;
		
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
	
		endif;
	
	}

	public function getDataReconcileDoc($DocID) {
		$this->load->model('dbapp');
		$this->load->library('effective');

		if(empty($DocID)) :
			return 0;
		
		else :
		
			try {
			
				$result = $this->dbapp->getDataReconcileDoc($DocID);	
					
				
				if(!empty($result)) {
					
					foreach($result['data'] as $index => $values) {

						$data[] = array(
							"Rec_ID"			=> $result['data'][$index]['Rec_ID'],
							"DocID"				=> $result['data'][$index]['DocID'],
							"BorrowerName"		=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['BorrowerName']),
							"BorrowerType"		=> $result['data'][$index]['BorrowerType'],
							"LogisticCode"		=> $result['data'][$index]['LogisticCode'],
							"SubmitDocToHQ"		=> $this->effective->StandartDateRollback($result['data'][$index]['SubmitDocToHQ']),
							"ReceivedDocFormLB" => $this->effective->StandartDateRollback($result['data'][$index]['ReceivedDocFormLB']),
							"CompletionDoc"		=> $result['data'][$index]['CompletionDoc'],
							"CompletionDate"	=> $this->effective->StandartDateRollback($result['data'][$index]['CompletionDate']),
							"AppToCA"			=> $this->effective->StandartDateRollback($result['data'][$index]['AppToCA']),
							"CAReturnDate"		=> $this->effective->StandartDateRollback($result['data'][$index]['CAReturnDate']),
							"CAReturnDate"		=> $this->effective->StandartDateRollback($result['data'][$index]['CAReturnDate']),
							"CAReturnDateLog"	=> $this->effective->StandartDateRollback($result['data'][$index]['CAReturnDateLog']),
							"IsRef" 			=> $result['data'][$index]['IsRef']
						);
						
					}
		
					return $data;
					
				}
				
				
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
		
		endif;
		
	}
	
	private function getReconcileCompletionData($DocID) {
		$this->load->model('dbapp');
		$this->load->library('effective');
	
		if(empty($DocID)) :
		return 0;
	
		else :
	
		try {
				
			$result = $this->dbapp->getDataReconcileCompletion($DocID);
			if(!empty($result)) {
					
				foreach($result['data'] as $index => $values) {
						
					$data[] = array(
							"DocID" 					=> $result['data'][$index]['DocID'],
							"DocOwner" 					=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['DocOwner']),
							"DocType" 					=> $result['data'][$index]['DocType'],
							"DocList" 					=> $result['data'][$index]['DocList'],
							"LBSubmitDocDate" 			=> !empty($result['data'][$index]['LBSubmitDocDate']) ? $this->effective->StandartDateRollback($result['data'][$index]['LBSubmitDocDate']):"",
							"HQReceivedDocFromLBDate" 	=> !empty($result['data'][$index]['HQReceivedDocFromLBDate']) ? $this->effective->StandartDateRollback($result['data'][$index]['HQReceivedDocFromLBDate']):"",
							"SubmitDocToCADate"  		=> !empty($result['data'][$index]['SubmitDocToCADate']) ? $this->effective->StandartDateRollback($result['data'][$index]['SubmitDocToCADate']):"",
							"CAReturnDate" 				=> !empty($result['data'][$index]['CAReturnDate']) ? $this->effective->StandartDateRollback($result['data'][$index]['CAReturnDate']):"",
							"HQSentToLBDate" 			=> !empty($result['data'][$index]['HQSentToLBDate']) ? $this->effective->StandartDateRollback($result['data'][$index]['HQSentToLBDate']):"",
							"BranchReceivedDate"  		=> !empty($result['data'][$index]['BranchReceivedDate']) ? $this->effective->StandartDateRollback($result['data'][$index]['BranchReceivedDate']):""
					);
	
				}
					
				return $data;
					
			}
	
	
		} catch (Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
		}
			
		endif;
	
	}
	
	// Load Data And Convert
	private function getCustomerInformation($doc_id) {
		$this->load->library('effective');
		
		$result		= $this->dbstore->exec_getCustomerInformation($doc_id);
		if(!empty($result)) {
			
			$data = array(
					'DocID'   	 		 => $result[0]['DocID'],
					'CustType'   		 => $result[0]['CustType'],
					'Interest'  		 => $result[0]['Interest'],
					'LoanGroup'			 => $result[0]['LoanGroup'],
					'SourceOfCustomer'   => $this->effective->get_chartypes($this->char_mode, $result[0]['SourceOfCustomer']),
					'SourceOption'  	 => $this->effective->get_chartypes($this->char_mode, $result[0]['SourceOption']),
					'CSPotential' 		 => $result[0]['CSPotential'],
					'OwnerType'   		 => $result[0]['OwnerType'],
					'PrefixName'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['PrefixName']),
					'OwnerName'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['OwnerName']),
					'BorrowerName'   	 => !empty($result[0]['BorrowerName']) ? $this->effective->get_chartypes($this->char_mode, $result[0]['BorrowerName']):'',
					'PrefixCorp'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['PrefixCorp']),
					'Company'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['Company']),
					'BusinessType'   	 => $this->effective->get_chartypes($this->char_mode, $result[0]['BusinessType']),
					'Business'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['Business']),
					'Telephone'   		 => $result[0]['Telephone'],
					'Mobile'   			 => $result[0]['Mobile'],
					'Downtown'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['Downtown']),
					'Address'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['Address']),
					'Province'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['Province']),
					'District'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['District']),
					'Postcode'   		 => $result[0]['Postcode'],
					'Channel'   		 => $result[0]['Channel'],
					'SubChannel'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['SubChannel']),
					'RequestLoan'   	 => $result[0]['RequestLoan'],
					'ReferralCode'   	 => $result[0]['ReferralCode'],
					'RegionID'   	 	 => $result[0]['RegionID'],
					'Region'   			 => $this->effective->get_chartypes($this->char_mode, $result[0]['Region']),
					'BranchCode'   	 	 => $result[0]['BranchCode'],
					'BranchDigit'   	 => $result[0]['BranchDigit'],
					'BranchTel'   	 	 => $result[0]['BranchTel'],
					'Branch'   			 => $this->effective->get_chartypes($this->char_mode, $result[0]['Branch']),
					'RMCode'   			 => $result[0]['RMCode'],
					'RMMobile'   		 => $result[0]['RMMobile'],
					'RMName'   			 => $this->effective->get_chartypes($this->char_mode, $result[0]['RMName']),
					'BMName'   			 => $this->effective->get_chartypes($this->char_mode, $result[0]['BMName']),
					'Remark'   			 => $this->effective->get_chartypes($this->char_mode, $result[0]['Remark']),
					'CAName'   			 => $this->effective->get_chartypes($this->char_mode, $result[0]['CAName']),
					'IsActive'   		 => $result[0]['IsActive'],
					'CreateBy'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['CreateBy']),
					'CreateDate'   		 => $result[0]['CreateDate'],
					'ChangeBy'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['ChangeBy']),
					'ChangeDate'   		 => $result[0]['ChangeDate'],
					'IsEnabled'  		 => $result[0]['IsEnabled']
			);
			
			return $data;
		}
		
	}
	
	public function getBorrowerNameRelation($doc_id, $borrow_type) {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$result = $this->dbmodel->CIQuery("
				SELECT [Profile].DocID, MasterBorrowerType.BorrowerDesc, NCBConsent.BorrowerType, NCBConsent.BorrowerName,[Profile].BranchCode,
				[Profile].Mobile AS CustMobile, LendingBranchs.BranchDigit, LendingBranchs.BranchName, [Profile].RMCode, [Profile].RMMobile, [Profile].RMName
				FROM [Profile]
				LEFT OUTER JOIN NCBConsent
				ON [Profile].DocID = NCBConsent.DocID
				LEFT OUTER JOIN LendingBranchs
				ON [Profile].BranchCode = LendingBranchs.BranchCode	
				LEFT OUTER JOIN MasterBorrowerType
				ON NCBConsent.BorrowerType = MasterBorrowerType.BorrowerType
				WHERE [Profile].DocID = '".$doc_id."'
				AND NCBConsent.BorrowerType = '".$borrow_type."'
		");
		
		if(!empty($result)) {
				
			$data = array(
					"DocID"			=> $result['data'][0]['DocID'],
					"BorrowerDesc"	=> $this->effective->get_chartypes($this->char_mode, $result['data'][0]['BorrowerDesc']),
					"BorrowerType"	=> $result['data'][0]['BorrowerType'],
					"BorrowerName"	=> $this->effective->get_chartypes($this->char_mode, $result['data'][0]['BorrowerName']),
					"CustMobile"	=> $result['data'][0]['CustMobile'],
					"BranchCode"	=> $result['data'][0]['BranchCode'],
					"BranchDigit"	=> $result['data'][0]['BranchDigit'],
					"BranchName"	=> $this->effective->get_chartypes($this->char_mode, $result['data'][0]['BranchName']),
					"RMCode"		=> $result['data'][0]['RMCode'],
					"RMMobile"		=> $result['data'][0]['RMMobile'],
					"RMName"		=> $this->effective->get_chartypes($this->char_mode, $result['data'][0]['RMName'])
			);
				
			return $data;
				
		}
		
	}
	
	public function getCustomerTabInformation($doc_id, $is_ref) {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$result = $this->dbmodel->CIQuery("
		 	SELECT [Profile].DocID, MasterBorrowerType.BorrowerDesc, NCBConsent.BorrowerType, NCBConsent.BorrowerName, [Profile].Mobile,
				[Profile].BranchCode, LendingBranchs.BranchDigit, LendingBranchs.BranchName, LendingBranchs.BranchTel, 
				[Profile].RMCode, [Profile].RMName, [Profile].RMMobile, [Profile].BMName, NCBConsent.IsRef
			FROM [Profile]
			LEFT OUTER JOIN NCBConsent
			ON [Profile].DocID = NCBConsent.DocID
			LEFT OUTER JOIN LendingBranchs
			ON [Profile].BranchCode = LendingBranchs.BranchCode	
			LEFT OUTER JOIN MasterBorrowerType
			ON NCBConsent.BorrowerType = MasterBorrowerType.BorrowerType		
			WHERE NCBConsent.DocID = '".$doc_id."'
			AND NCBConsent.IsRef = '".$is_ref."'
			AND NOT [Profile].CreateDate IS NULL
		");

		if(!empty($result)) {
			
			$data = array(
				"DocID"			=> $result['data'][0]['DocID'], 
				"BorrowerDesc"	=> $this->effective->get_chartypes($this->char_mode, $result['data'][0]['BorrowerDesc']), 
				"BorrowerType"	=> $result['data'][0]['BorrowerType'], 
				"BorrowerName"	=> $this->effective->get_chartypes($this->char_mode, $result['data'][0]['BorrowerName']),
				"Mobile"		=> $result['data'][0]['Mobile'],
				"BranchCode"	=> $result['data'][0]['BranchCode'], 
				"BranchDigit"	=> $result['data'][0]['BranchDigit'], 
				"BranchName"	=> $this->effective->get_chartypes($this->char_mode, $result['data'][0]['BranchName']), 
				"BranchTel"		=> $result['data'][0]['BranchTel'],
				"RMCode"		=> $result['data'][0]['RMCode'], 
				"RMName"		=> $this->effective->get_chartypes($this->char_mode, $result['data'][0]['RMName']), 
				"RMMobile"		=> $result['data'][0]['RMMobile'],
				"BMName"		=> $this->effective->get_chartypes($this->char_mode, $result['data'][0]['BMName']),
				"IsRef"			=> $result['data'][0]['IsRef']
			);
			
			return $data;
			
		}		
		
	}
	
	public function getDataTrackList($doc_id, $doc_ref) {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$result = $this->dbmodel->CIQuery("
			SELECT RowID, DocID, BorrowerName, BorrowerType, BranchCode, RMCode, Point, IsRef, Completed, CreateByID, CreateByName, 
			CASE CreateDate
				WHEN '1900-01-01' THEN NULL
				ELSE CONVERT(nvarchar(10), CreateDate, 120)
			END AS CreateDate,
			UpdateByID, UpdateByName, 
			CASE UpdateDate
				WHEN '1900-01-01' THEN NULL
				ELSE CONVERT(nvarchar(10), UpdateDate, 120)
			END AS UpdateDate, IsActive
			FROM  DocumentErrorTracker
			WHERE DocID = '".$doc_id."'
			AND IsRef =  '".$doc_ref."'
			AND IsActive = 'A'");
		
		if(!empty($result['data'][0]['DocID'])) {
			
			$data = array(
					"DocID"			=> $result['data'][0]['DocID'],
					"BorrowerName"	=> $this->effective->get_chartypes($this->char_mode, $result['data'][0]['BorrowerName']),
					"BorrowerType"	=> $result['data'][0]['BorrowerType'],
					"BranchCode"	=> $result['data'][0]['BranchCode'],
					"Point"			=> $result['data'][0]['Point'],
					"Completed"		=> $result['data'][0]['Completed'],
					"CreateByID"	=> !empty($result['data'][0]['CreateByID']) ? $result['data'][0]['CreateByID']:"",
					"CreateByName"	=> !empty($result['data'][0]['CreateByName']) ? $this->effective->get_chartypes($this->char_mode, $result['data'][0]['CreateByName']):"",
					"CreateDate"	=> !empty($result['data'][0]['CreateDate']) ? $this->effective->StandartDateRollback($result['data'][0]['CreateDate']):"",
					"UpdateByID"	=> !empty($result['data'][0]['UpdateByID']) ? $result['data'][0]['UpdateByID']:"" ,
					"UpdateByName"	=> !empty($result['data'][0]['UpdateByName']) ? $this->effective->get_chartypes($this->char_mode, $result['data'][0]['UpdateByName']):"",
					"UpdateDate"	=> !empty($result['data'][0]['UpdateDate']) ? $this->effective->StandartDateRollback($result['data'][0]['UpdateDate']):"",
					"IsRef"			=> $result['data'][0]['IsRef']
			);
				
			return $data;
			
		}
		
	}
	

	public function getDefendProcessList($doc_id) {
		$this->load->model('dbstore');
		$this->load->library('effective');
		
		if(!empty($doc_id)):
			$result = $this->dbstore->exec_getTransactionForDefendProcess($doc_id);
			
			if(!empty($result[0]['DocID'])) {
				
				return array("DocID" 		=> $result[0]['DocID'],
					  "RMProcess" 		 	=> $this->effective->get_chartypes($this->char_mode, $result[0]['RMProcess']),
					  "AppToCA" 			=> $result[0]['AppToCA'],
					  "CAReturnDateLog"		=> $result[0]['CAReturnDateLog'],
					  "CA_ReceivedDocDate" 	=> $result[0]['CA_ReceivedDocDate'],
				      "Status" 			 	=> $result[0]['Status'],
					  "CC_AfterAppr" 		=> $result[0]['Cancel_AfterApprove']
						
				);				
				
			} else {
				return;
			}
		
		else:
			return;
		endif;

	}
	
	public function getReActivateList($DocID) {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		if(empty($DocID)) :
			return 0;
		
		else :
		
		try {
		
			$verify       = $this->dbmodel->loadData('Verification', "VerifyID", array('DocID' => $DocID));
			$result = $this->dbmodel->CIQuery("
				SELECT ReActivateList.VerifyID, ReActivateList.RevisitID, MasterRevisitReason.RevisitReason, ReActivateList.IsActive
				FROM ReActivateList
				LEFT OUTER JOIN MasterRevisitReason
				ON ReActivateList.RevisitID = MasterRevisitReason.RevisitID
				WHERE ReActivateList.VerifyID = '".$verify['data'][0]['VerifyID']."'
				AND ReActivateList.IsActive = 'A'");
			
			if(!empty($result['data'][0]['VerifyID'])) {
					
				foreach($result['data'] as $index => $values) {
		
					$data[] = array(
						"VerifyID"		=> $result['data'][$index]['VerifyID'],
						"RevisitID"		=> $result['data'][$index]['RevisitID'],
						"RevisitReason"	=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['RevisitReason']),
						"IsActive"		=> $result['data'][$index]['IsActive']
					);
		
				}
					
				return $data;
					
			}
		
		
		} catch (Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
		}
			
		endif;
			
	}
	
	private function getDataRetrieveLog($doc_id) {
		$this->load->model('dbstore');
	
		if(!empty($doc_id)):
		
			$result = $this->dbstore->exec_getDataRetrieve_Log($doc_id);			
			if(!empty($result[0]['DocID'])) {
				return $result;
			} else {
				return;
			}
			
		else:
			return;
		
		endif;
	
	}
	

	// ROUTER
	// MODIFY: NEW METHOD VERIFICATION FOR EDITOR
	public function getDefendCount($doc_id) {
		$this->load->model('dbmanagement');
		return $this->dbmanagement->getNumDefendNote($doc_id);
	
	}
	
	public function getLatestDatalog($doc_id) {
		$this->load->model('dbmanagement');
	
		if(empty($doc_id)):
			return;
		else :
			$result = $this->dbmanagement->getLatestReturnLogs();
			return $result;
		endif;
	
	}
	
	public function getDataCAInfo($ca_name) {
		$this->load->model('dbmodel');
	
		if(!empty($ca_name)) :
		$result = $this->dbmodel->CIQuery("SELECT * FROM MasterCA_Name WHERE TH_NAME LIKE '%".$ca_name."%'");
		return $result;
		endif;
	
	}
	
	public function getDataAssignDefendName($doc_id) {
		$this->load->model('dbstore');
		
		if(!empty($doc_id)):		
			$result = $this->dbstore->exec_getDataAssignDefendName($doc_id);
			if(!empty($result[0]['DocID'])) {
				
				$data	= array();
				foreach($result as $index => $values) {
					array_push($data, 
					array("DefendEmpID" 	=> $result[$index]['DefendEmpID'],
						  "DefendEmpName"	=> $result[$index]['DefendEmpName']
						)
					);
				
				}
				
				return $data;
				
			} else {
				return;
			}
			
		else:
			return;		
		endif;
		
	}
	
	public function getGroupSFEList() {
		$this->load->model('dbstore');
		
		$data	= array();
		$result = $this->dbstore->exec_getGroupSFEList();	
		foreach($result as $index => $values) {		
			array_push($data, $result[$index]['EmployeeCode']);
		
		}
		
		return $data;
	
	}
	
	public function getSFEDataList() {
		$this->load->model('dbstore');
		$this->load->library('effective');
	
		$data	= array();
		$result = $this->dbstore->exec_getGroupSFEList();
		foreach($result as $index => $values) {
			array_push($data, 
			array("EmployeeCode" => $result[$index]['EmployeeCode'],
				  "FullNameTh"	 => $this->effective->get_chartypes($this->char_mode, $result[$index]['FullNameTh'])
				  )
			);
	
		}
	
		return $data;
	
	}
	
	public function getRMListBoundaryDefault() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		if(empty($this->authorized[0])) {
				
				
		} else {
			
			if(count($this->authorized) > 1) :
				$privileges = $this->authorized[0];
			else:
				$privileges = $this->authorized[0];
			endif;
			
			switch($privileges) {
				case $this->role_ad:
						
					if($this->branch_code == "000" || $this->branch_code == "901"):
						$wheres = '';
					else:
						
						// Admin are not head office
						// Check has authority area manager
						$select_privilege = '';
						if(in_array($this->role_am, $this->authorized)):
							$wheres = " AND LendingEmp.BranchCode IN (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$this->emp_id."' AND IsActive = 'A' GROUP BY BranchCode)";
						else:
							$wheres = " AND LendingEmp.BranchCode = '". str_pad($this->branch_code, 3, '0', STR_PAD_LEFT) ."'";
						endif;
					
					endif;
						
					break;
				case $this->role_rm:
					$wheres	= " AND LendingEmp.EmployeeCode = '".$this->emp_id ."'";
						
					break;
				case $this->role_bm:
					$wheres = " AND LendingEmp.BranchCode = '".str_pad($this->branch_code, 3, '0', STR_PAD_LEFT)."'";
						
					break;
				case $this->role_am:
					$wheres = " AND LendingEmp.BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$this->emp_id ."' GROUP BY BranchCode)";
						
					break;
				case $this->role_rd:
					$wheres = " AND LendingEmp.BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$this->region_id."' GROUP BY BranchCode)";
						
					break;
				case $this->role_admin:
				case $this->role_hq:
				case $this->role_spv:
					$wheres	= '';
					break;
						
			}
				
			$SQL = "SELECT EmployeeCode, FullNameEng, FullNameTh, PositionTitle,
					CASE PositionTitle
					WHEN 'Branch Manager' THEN 'BM'
					WHEN 'Relationship Manager' THEN 'RM'
					END AS User_Role, LendingEmp.RegionID,
					LendingEmp.BranchCode, LendingBranchs.BranchDigit
					FROM LendingEmp
					LEFT OUTER JOIN LendingBranchs
					ON LendingEmp.BranchCode = LendingBranchs.BranchCode
					WHERE LendingEmp.PositionTitle in ('Relationship Manager', 'Branch Manager')
					$wheres
					ORDER BY User_Role ASC";
	
			$result	= $this->dbmodel->CIQuery($SQL);
			if(empty($result['data'][0]['EmployeeCode'])) {
				$this->json_parse(array(
						'data'      => '',
						'status'    => false,
						'msg'       => 'ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง.'
				)
				);
					
			} else {
					
				$conv['data']   = array();
				foreach($result['data'] as $index => $value) {
					array_push($conv['data'],
							array("EmployeeCode" 	 => $result['data'][$index]['EmployeeCode'],
									"FullNameEng"	 => $result['data'][$index]['FullNameEng'],
									"FullNameTh"	 => $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['FullNameTh']),
									"RegionID" 	 	 => $result['data'][$index]['RegionID'],
									"BranchCode" 	 => $result['data'][$index]['BranchCode'],
									"User_Role"		 => $result['data'][$index]['User_Role']
										
							)
					);
				}
				
				header('Content-Type: application/json; charset="UTF-8"');
				echo json_encode($conv);
				
			}
				
				
		}
	
	}
	
	// Defend New Zone
	public function getProgressReason($progress_id) {
		$this->load->model('dbmodel');	
		if(!empty($progress_id)):
			$result = $this->dbmodel->loadData('DefendProgress', 'InProgress', array('RowID' => $progress_id, 'IsActive' => 'A'));
			return $result['data'][0]['InProgress'];
		else:
			return NULL;
		endif;
	}
	
	public function setAssigtmentDefend($doc_id) {
		$this->load->model('dbstore');
		
		$def_role 	 = $this->config->item('Defend_Role');
		$defend_list = $this->config->item('DefendName');
		
		$result   = $this->dbstore->getInfoBoundary($doc_id);
		if(!empty($result['data'])):
			$resp = $result['data'][0];
			if(!empty($def_role[$resp['RegionNameEng']][$resp['AreaName']])):
				return $def_role[$resp['RegionNameEng']][$resp['AreaName']];
			else:
				return $defend_list['DEF_HEAD'];
			endif;
		else:
			return $defend_list['DEF_HEAD'];
		endif;
	
	}
	
	public function createDefendListModify($doc_id, $defend_reason, $supplement = array(), $owner = array(), $optional = array()) {
		$this->load->model('dbstore');
		$this->load->model('dbmodel');
		
		date_default_timezone_set("Asia/Bangkok");
		
		$in_progress = 1;
		$current_date = date('Y-m-d H:i:s');
			
		$defend_head    = array(
			'DocID'         	=> $doc_id,
			'DefendRef'     	=> 1,
			'DefendDate'    	=> date("Y-m-d H:i:s"),			
			'DefendDepart'		=> 'LB',
			'DefendProcess'		=> !empty($optional['A2CA']) ? 'On Process':'Before Process',
			'DefendProgress'	=> $this->getProgressReason($in_progress),
			'AssignmentID'		=> !empty($owner['EmployeeCode']) ? $owner['EmployeeCode'] : null,
			'AssignmentName'	=> !empty($owner['EmployeeName']) ? $this->effective->set_chartypes($this->char_mode, $owner['EmployeeName']) : null,
			'AssignmentDate'	=> $current_date,
			'AssignmentConfirm'	=> 'N',
			'IsActive'      	=> 'A',
			'CreateID'			=> $this->emp_id,
			'CreateBy'      	=> $this->effective->set_chartypes($this->char_mode, $this->name),
			'CreateDate'   	 	=> $current_date
		);
		
		$assign_log		= array(
			'DocID'         	=> $doc_id,
			'DefendRef'     	=> 1,
			'DefendProgress'	=> 'Draft',
			'AssignID'			=> $this->emp_id,
			'AssignBy'			=> $this->effective->set_chartypes($this->char_mode, $this->name),
			'AssignDate'		=> date('Y-m-d H:i:s')
		);
		
		$defend_inbound = array('SP001', 'SP002', 'SP003', 'SP004');
		$defend_subhead = array();		
		foreach($defend_inbound as $value):
			array_push($defend_subhead,
				array(
					'DocID'         => $doc_id,
					'DefendRef'     => 1,
					'DefendCode'	=> $value,
					'IsActive'		=> 'A',
					'CreateID'			=> $this->emp_id,
					'CreateName'      	=> $this->effective->set_chartypes($this->char_mode, $this->name),
					'CreateDate'   	 	=> $current_date
				)
			);
		endforeach;
		
		if(!empty($defend_reason)) $defend_itemlist   = explode(',', $defend_reason);
		if(!empty($supplement[1])) $defend_itemoption = explode(',', $supplement[1]);
				
		// Main List at Defend
		if(!empty($defend_itemlist[0])) {
			
			if(in_array("OT099", $defend_itemlist)):
				$key = array_search("OT099", $defend_itemlist);
				if($key !== false) unset($defend_itemlist[$key]);
			endif;
			
			$item_list 	 = array();
			$item_option = array();
			
			foreach($defend_itemlist as $index => $value) {
				
				array_push($item_list,
					array(
							'DocID'         => $doc_id,
							'DefendRef'     => 1,
							'DefendCode'    => $defend_itemlist[$index],
							'IsActive'      => 'A',
							'CreateID'		=> $this->emp_id,
							'CreateName'      => $this->effective->set_chartypes($this->char_mode, $this->name),
							'CreateDate'   	 => $current_date
					)
				);
				
			}
			
		}
		
		// List Other at Defend
		if(!empty($defend_itemoption[0])) {
			
			foreach($defend_itemoption as $index => $value) {
				
				if(empty($defend_itemoption[$index])):
				continue;
				else:
					array_push($item_option,
						array(
							'DocID'        		=> $doc_id,
							'DefendRef'     	=> 1,
							'DefendCode'    	=> "OT099",
							'DefendTitleOption' => $this->effective->set_chartypes($this->char_mode, $defend_itemoption[$index]),
							'IsActive'      	=> 'A',
							'CreateID'			=> $this->emp_id,
							'CreateName'      	=> $this->effective->set_chartypes($this->char_mode, $this->name),
							'CreateDate'   	 	=> $current_date
						)
					);
				endif;
				
			}
			
		}
		
		// Array Merge
		if(!empty($item_option[0])):
			$data_merge	= array_merge($item_list, $item_option);
		else:
			$data_merge	= $item_list;
		endif;
		
		if(!empty($data_merge[0]['DocID'])):
			foreach($data_merge as $index => $value):
				array_push($defend_subhead, $data_merge[$index]);
			endforeach;
		endif;
		
		if(!empty($defend_head['DocID'])):
			$this->dbmodel->exec('New_DefendHead', $defend_head, false, 'insert');
			$this->dbmodel->exec('New_DefendAssignLogs', $assign_log, false, 'insert');
		endif;
		
		if(!empty($defend_subhead[0]['DocID'])):
			foreach($defend_subhead as $value):
				$this->dbmodel->exec('New_DefendSubHead', $value, false, 'insert');
			endforeach;
		endif;
	
		unset($in_progress);		
		unset($current_date);
		unset($defend_head);
		unset($defend_subhead);
		unset($data_merge);
		unset($item_list);
		unset($item_option);
		unset($defend_inbound);
		unset($app_info);

	}
	
	public function createDefendList($doc_id, $defend_reason, $supplement = array(), $defend_env = array()) {
		$this->load->model('dbstore');
		$this->load->model('dbmodel');
		
		date_default_timezone_set("Asia/Bangkok");
		
		$check_ref   = $this->dbstore->getDefendReference($doc_id);
		$assingment  = $this->setAssigtmentDefend($doc_id);
		
		$in_progress = 1;
		if(!empty($defend_env[1])) {
			if(in_array($defend_env[1], array('RM', 'DF'))) {
				if($defend_env[1] == 'RM') $in_progress = 1;
				else $in_progress = 2;
			} 
		}
		
		$defend_head    = array(
				'DocID'         	=> $doc_id,
				'DefendRef'     	=> $check_ref['data'][0]['DefendRef'],
				'DefendDate'    	=> !empty($supplement[0]) ? $supplement[0]. ' ' .date("H:i:s"):date("Y-m-d H:i:s"),
				'DefendProcess'		=> $defend_env[0], 
				'DefendDepart'		=> self::getProposerType($defend_env[1]),
				'DefendProgress'	=> $this->getProgressReason($in_progress),
				'AssignmentID'		=> $assingment['EmployeeCode'],
				'AssignmentName'	=> $assingment['FullNameTh'],
				'AssignmentDate'	=> date("Y-m-d H:i:s"),
				'AssignmentConfirm'	=> 'N',
				'IsActive'      	=> 'A',
				'CreateID'			=> $this->emp_id,
				'CreateBy'      	=> $this->effective->set_chartypes($this->char_mode, $this->name),
				'CreateDate'   	 	=> date('Y-m-d H:i:s')
		);
		
		$assign_log		= array(
				'DocID'         	=> $doc_id,
				'DefendRef'     	=> $check_ref['data'][0]['DefendRef'],
				'DefendProgress'	=> (self::getProposerType($defend_env[1]) == 'LB') ? 'LB Submit':'DEF Received',
				'AssignID'			=> $this->emp_id, 
				'AssignBy'			=> $this->effective->set_chartypes($this->char_mode, $this->name), 
				'AssignDate'		=> date('Y-m-d H:i:s')
		);
		
		$defend_inbound = array('SP001', 'SP002', 'SP003', 'SP004');
		$defend_subhead = array();
		foreach($defend_inbound as $value):
			array_push($defend_subhead, 
				array(
					'DocID'         => $doc_id,
					'DefendRef'     => $check_ref['data'][0]['DefendRef'],
					'DefendCode'	=> $value,
					'IsActive'		=> 'A'
				)
			);
		endforeach;
		
		if(!empty($defend_reason)) $defend_itemlist   = explode(',', $defend_reason);
		if(!empty($supplement[1])) $defend_itemoption = explode(',', $supplement[1]);
		
		// Main List at Defend
		if(!empty($defend_itemlist[0])) {
			
			if(in_array("OT099", $defend_itemlist)):
				$key = array_search("OT099", $defend_itemlist);
				if($key !== false) unset($defend_itemlist[$key]);
			endif;
			
			$item_list 	 = array();
			$item_option = array();
			
			foreach($defend_itemlist as $index => $value) {
					
				array_push($item_list, 
					array(
						'DocID'         => $doc_id,
						'DefendRef'     => $check_ref['data'][0]['DefendRef'],
						'DefendCode'    => $defend_itemlist[$index],
						'IsActive'      => 'A'
					)
				);
					
			}
	
		}
		
		// List Other at Defend
		if(!empty($defend_itemoption[0])) {
				
			foreach($defend_itemoption as $index => $value) {
		
				if(empty($defend_itemoption[$index])):
					continue;
				else:
					array_push($item_option, 
						array(
							'DocID'        		=> $doc_id,
							'DefendRef'     	=> $check_ref['data'][0]['DefendRef'],
							'DefendCode'    	=> "OT099",
							'DefendTitleOption' => $this->effective->set_chartypes($this->char_mode, $defend_itemoption[$index]),
							'IsActive'      	=> 'A'
						)
					);
				endif;
					
			}
		
		}
		
		// Array Merge
		if(!empty($item_option[0])):
			$data_merge	= array_merge($item_list, $item_option);
		else:
			$data_merge	= $item_list;
		endif;
		
		if(!empty($data_merge[0]['DocID'])):
			foreach($data_merge as $index => $value):
				array_push($defend_subhead, $data_merge[$index]);
			endforeach;
		endif;
				
		if(!empty($defend_head['DocID'])):
 			$this->dbmodel->exec('New_DefendHead', $defend_head, false, 'insert');
 			$this->dbmodel->exec('New_DefendAssignLogs', $assign_log, false, 'insert');
		endif;
		
		if(!empty($defend_subhead[0]['DocID'])):
 			foreach($defend_subhead as $value):
 				$this->dbmodel->exec('New_DefendSubHead', $value, false, 'insert');
 			endforeach;
		endif;
		
	}
	
	private static function getProposerType($proposer) {
		if(!empty($proposer)) {
			switch ($proposer) {
				case 'RM':
					return 'LB';
				break;
				case 'DF':
					return 'HO';
				break;
			}
		} else {
			return NULL;
		}
	}

}
