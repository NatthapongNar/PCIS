<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dbstore extends CI_Model {
	
	public $db_types;
	
	public function __construct() {
		parent::__construct();
		$this->load->database('dbstore');

		$connected = $this->checkDatabaseConnection($this->db);
		if(!$connected):
			$this->db_reconnection();
		endif;
		
		$this->char_mode	= $this->config->item('char_mode');
		$this->db_types		= $this->config->item('database_types');
		
	}
	
	public function checkDatabaseConnection($_instants) {
		$initialized = $_instants->initialize();
		if($initialized) return TRUE;
		else return FALSE;
	}
	
	protected function db_reconnection() {
		$reconnected = $this->db->initialize();
		if(!$reconnected):
		 
		if(!$this->db->initialize()) $this->db_reconnection();
		else return $this->db;
			
		else:
		return $this->db;
		endif;
	
	}
	
	// STOREPROC DATA BUNDDLED [CHANC]
	public function exec_rmlogs($verify_id, $processtype, $empcode, $empname, $processdate, $processtime, $active, $mode) {
		$SQL 	= "PCIS_RMLogs_Insert '". $verify_id."', '".$processtype."', '".$empcode."', '".$empname."', '".$processdate."', '".$processtime."', '".$active."', '".$mode."'";
		$query  = $this->db->query($SQL);
		return TRUE;
	}
	
	public function exec_verification_bundledoc($docid, $active, $is_enabled, $createby, $createdate, $mode) {
		$SQL 	= "PCIS_Verification_DocBundled '". $docid."', '".$active."', '".$is_enabled."', '".$createby."', '".$createdate."', '".$mode."'";
		$query  = $this->db->query($SQL);
		return TRUE;
	}
	
	public function exec_appstate_bundledoc($docid, $active, $is_enabled, $createby, $createdate, $mode) {
		$SQL 	= "PCIS_AppState_DocBundled '". $docid."', '".$active."', '".$is_enabled."', '".$createby."', '".$createdate."', '".$mode."'";
		$query  = $this->db->query($SQL);
		return TRUE;
	}
	
	public function exec_appstate_bundlelogs($docid, $appstate, $appdate, $actors, $actordate, $active, $mode) {
		$SQL 	= "PCIS_AppStateLogs_Insert '". $docid."', '".$appstate."', '".$appdate."', '".$actors."', '".$actordate."', '".$active."', '".$mode."'";
		$query  = $this->db->query($SQL);
		return TRUE;
	}
	
	
	// STOREPROC DATA INQUIRIES	
	public function exec_getMasterErrorCat() {
		$SQL 	= "PCIS_GetMasterErrorCat";
		$query  = $this->db->query($SQL);
		return $query->result_array();
	}
	
	public function exec_getMasterErrorList() {
		$SQL 	= "PCIS_GetDocumentErrorList";
		$query  = $this->db->query($SQL);
		return $query->result_array();		
	}
	
	public function exec_getInformation($docid) {
		$SQL 	= "PCIS_GetVerifiedProcessInfo '". $docid."'";
		$query  = $this->db->query($SQL);
		return $query->result_array();
	}
	
	public function exec_getRegisStatusReason() {
		$SQL 	= "[dbo].[PCIS_GetRegisStatusReason]";
		$query  = $this->db->query($SQL);
		return $query->result_array();
	}
	
	public function exec_getCustomerInformation($docid) {
		$SQL 	= "PCIS_GetCustomerInformation '". $docid."'";
		$query  = $this->db->query($SQL);
		return $query->result_array();
	}
	
	// New Zone Defend
	public function getInfoBoundary($docid) {
		$SQL 	= "[dbo].[PCIS_CheckBoundary] @DocID = '". $docid."'";
		$query  = $this->db->query($SQL);
		
		if($this->db_types == 'sqlsrv') {
			$result_set   = $query->result();
			
			if(count($result_set) > 0) {
				$result = array();
			
				foreach ($result_set as $key => $value) {
					$result[$key]['DocID'] 			 	= $value->DocID;
					$result[$key]['RegionID'] 		 	= $value->RegionID;
					$result[$key]['RegionNameEng'] 	 	= $value->RegionNameEng;
					$result[$key]['AreaID']  	 		= $value->AreaID;
					$result[$key]['AreaName'] 	 		= $value->AreaName;
					$result[$key]['BranchCode'] 	 	= $value->BranchCode;
				}
			
				return array("data" => $result, "status" => "true");
			
			} else {
				return array("data" => array(0), "status" => "false");
			
			}
			
		} else {
			
			if($query->num_rows() > 0):
				return array(
					"data"   => $query->result_array(),
					"status" => "true"
				);
			
			else:
				return array(
					"data"   => array(0),
					"status" => "false"
				);
			
			endif;
		}
		
	}
	
	public function getDefendReference($doc_id) {
		if(empty($doc_id)) {
			return array("data" => array(0), "status" => "false");
			
		} else {
			
			$SQL 	= "[dbo].[getDefendReferance] @DocID = '". $doc_id."'";
			$query  = $this->db->query($SQL);
			
			if($this->db_types == 'sqlsrv') {
				$result_set   = $query->result();
			
				if(count($result_set) > 0):
					$result = array();
						
					foreach ($result_set as $key => $value) {
						$result[$key]['DocID'] 			 	= $value->DocID;
						$result[$key]['DefendRef'] 		 	= $value->DefendRef;
					}
						
					return array("data" => $result, "status" => "true");
						
				else:
					return array("data" => array(0), "status" => "false");
						
				endif;
			
			}
			
		}
			
	}
	
	
	//End of zone new defend

	public function exec_pcisGetNCBConsentDataList($docid) {
		$SQL 	= "[dbo].[Get_PCISNCBConsentDataLists] @DocID = '". $docid."'";
		$query  = $this->db->query($SQL);
	
		if($this->db_types == 'sqlsrv') {
			$result_set   = $query->result();
				
			if(count($result_set) > 0) {
				$result = array();
	
				foreach ($result_set as $key => $value) {
					$result[$key]['NCS_ID'] 			= $value->NCS_ID;
					$result[$key]['DocID'] 			 	= $value->DocID;
					$result[$key]['VerifyID'] 		 	= $value->VerifyID;
					$result[$key]['IDNO'] 		 		= $value->IDNO;
					$result[$key]['BorrowerType'] 	 	= $value->BorrowerType;
					$result[$key]['BorrowerName']  	 	= $value->BorrowerName;
					$result[$key]['NCBCheck'] 	 		= $value->NCBCheck;
					$result[$key]['NCBCheckDate'] 	 	= $value->NCBCheckDate;
					$result[$key]['SubmitToHQ'] 	 	= $value->SubmitToHQ;
					$result[$key]['HQReceivedFromLB'] 	= $value->HQReceivedFromLB;
					$result[$key]['HQSubmitToOper'] 	= $value->HQSubmitToOper;
					$result[$key]['OperReturn'] 		= $value->OperReturn;
					$result[$key]['OperReturnDate'] 	= $value->OperReturnDate;
					$result[$key]['NCBReturnDateLog'] 	= $value->NCBReturnDateLog;
					$result[$key]['IsActive'] 	 		= $value->IsActive;
					$result[$key]['IsRef']   			= $value->IsRef;
				}
	
				return array("data" => $result, "status" => "true");
	
			} else {
				return array("data" => array(0), "status" => "false");
	
			}
				
		} else {
			if($query->num_rows() > 0):
			return array(
					"data"   => $query->result_array(),
					"status" => "true"
			);
	
			else:
			return array(
					"data"   => array(0),
					"status" => "false"
			);
	
			endif;
		}
	
	}
	
	public function exec_pcisGetCreditReturnReasonList($inquiry) {
		
		$SQL 	= "[dbo].[PCIS_GetCreditReasonList] $inquiry"; 
		$query  = $this->db->query($SQL);
		
		if($this->db_types == 'sqlsrv') {
			$result_set   = $query->result();
			if(count($result_set) > 0):
			
				$result = array();
				foreach ($result_set as $key => $value) {
					$result[$key]['Rec_ID'] 			= $value->Rec_ID;
					$result[$key]['DocID'] 			 	= $value->DocID;
					$result[$key]['ReturnRef'] 		 	= $value->ReturnRef;
					$result[$key]['DefendCode']  	 	= $value->DefendCode;
					$result[$key]['DefendReason'] 	 	= $value->DefendReason;
					$result[$key]['DefendOther'] 	 	= $value->DefendOther;
					$result[$key]['ReturnDate'] 	 	= $value->ReturnDate;
					$result[$key]['Flag'] 				= $value->Flag;
					$result[$key]['IsActive'] 	 		= $value->IsActive;
				}
				
				return array("data" => $result, "status" => "true");
					
			else:
				return array("data" => array(0), "status" => "false");
			endif;
					
		} else {
			
			if($query->num_rows() > 0):
				return array("data" => $query->result_array(), "status" => "true");			
			else:
				return array("data" => array(0), "status" => "false");				
			endif;
		}
		
		
	
	}
	
	public function exec_pcisGeReconcileDataList($docid) {
		
		$SQL 	= "[dbo].[Get_PCISReconcileDocDataLists] @DocID = '". $docid."'";		
		$query  = $this->db->query($SQL);
	
		if($this->db_types == 'sqlsrv') {
			$result_set   = $query->result();	
		
			if(count($result_set) > 0) {
				$result = array();
				foreach ($result_set as $key => $value) {				
					$result[$key]['Rec_ID'] 			= $value->Rec_ID;
					$result[$key]['DocID'] 			 	= $value->DocID;
					$result[$key]['NCBCheck'] 		 	= $value->NCBCheck;
					$result[$key]['BorrowerName']  	 	= $value->BorrowerName;
					$result[$key]['BorrowerType'] 	 	= $value->BorrowerType;
					$result[$key]['LogisticCode'] 	 	= $value->LogisticCode;
					$result[$key]['SubmitDocToHQ'] 	 	= $value->SubmitDocToHQ;
					$result[$key]['ReceivedDocFormLB'] 	= $value->ReceivedDocFormLB;
					$result[$key]['CompletionDoc'] 	 	= $value->CompletionDoc;
					$result[$key]['CompletionDate'] 	= $value->CompletionDate;
					$result[$key]['AppToCA'] 		 	= $value->AppToCA;
					$result[$key]['CAReturn'] 		 	= $value->CAReturn;
					$result[$key]['CAReturnDate'] 	 	= $value->CAReturnDate;
					$result[$key]['CAReturnDateLog']   	= $value->CAReturnDateLog;
					$result[$key]['IsActive'] 		 	= $value->IsActive;
					$result[$key]['IsRef'] 			 	= $value->IsRef;
				}
				
				return array("data" => $result, "status" => "true");

			} else {
				return array("data" => array(0), "status" => "false");
				
			}
	
		} else {
			
			if($query->num_rows() > 0):
				return array(
						"data"   => $query->result_array(),
						"status" => "true"
				);
	
			else:
				return array(
						"data"   => array(0),
						"status" => "false"
				);
				
			endif;
			
		}

	}
	
	public function exec_getRMBoundaryList($branch_code) {
		$SQL 	= "[dbo].[PCIS_GetRMBoundaryList] '". $branch_code."'";
		$query  = $this->db->query($SQL);
		return $query->result_array();
	
	}
	
	public function exec_getProfileProcessInfo($docid) {
		$SQL 	= "PCIS_GetProfile_ProcessInfo '". $docid."'";
		$query  = $this->db->query($SQL);
		return $query->result_array();
		
	}
	
	public function exec_getVerificationInfo($docid) {
		$SQL 	= "PCIS_GetVerificationInfo '". $docid."'";
		$query  = $this->db->query($SQL);
		return $query->result_array();
	}
	
	public function check_RetrieveStatus($docid) {
		$SQL 	= "checkRetrieveStatus '". $docid."'";
		$query  = $this->db->query($SQL);
		return $query->result_array();
	}
	
	public function exec_getNCBConsentLogs($verify_id) {
		$SQL 	= "PCIS_GetNCBConsentLogs '". $verify_id."'";
		$query  = $this->db->query($SQL);
		return $query->result_array();
	}
	
	public function exec_getRMProcessLogs($verify_id) {
		$SQL 	= "PCIS_GetTransactionRMLogs '".$verify_id."'";
		$query  = $this->db->query($SQL);
		return $query->result_array();
	}
	
	public function exec_getActionNoteLogs($doc_id) {
		$SQL 	= "PCIS_GetActionNoteLogs '".$doc_id."'";
		$query  = $this->db->query($SQL);
		return $query->result_array();
	}
	
	public function exec_getActionNoteFilterMode($doc_id, $mode) {
		$SQL 	= "PCIS_GetActionNoteFilterMode '".$doc_id."', '".$mode."'";
		$query  = $this->db->query($SQL);
		return $query->result_array();
	}
	
	public function exec_getAmountBadgeCount($doc_id, $ref) {
		$SQL 	= "PCIS_GetBadgeAmount '".$doc_id."', '".$ref."'";
		$query  = $this->db->query($SQL);
		return $query->result_array();
	}
	
	public function exec_getReconcileDocLogs($doc_id) {
		$SQL 	= "PCIS_GetReconcileDocLogs '".$doc_id."'";
		$query  = $this->db->query($SQL);
		return $query->result_array();
	}
	
	public function exec_getReconcileCompleteDoc($doc_id, $name, $type) {
		$SQL 	= "[dbo].[PCIS_GetReconCileCompletionDocData] @DocID ='".$doc_id."', @DocRef='".$name."', @Doctype='".$type."'";		
		$query  = $this->db->query($SQL);
		return $query->result_array();
	}
		
	public function exec_getReconcileCompleteDocLogs($doc_id, $types) {
		$SQL 	= "PCIS_GetReconcileCompletionLogs '".$doc_id."', '".$types."'";
		$query  = $this->db->query($SQL);
		return $query->result_array();
	}
	
	public function exec_getTransactionForDefendProcess($doc_id) {
		$SQL 	= "[dbo].[checkRetrieveStatus] @DocID = '".$doc_id."'";
		$query  = $this->db->query($SQL);
		return $query->result_array();		
	}
	
	public function exec_getCAReturnAmount($doc_id) {
		$SQL 	= "[dbo].[PCIS_GetNumberOfCAReturn] @DocID = '".$doc_id."'";
		$query  = $this->db->query($SQL);
		if($query->num_rows() > 0):
			return array(
					"data"   => $query->result_array(),
					"status" => "true"
			);
			
		else:
			return array(
					"data"   => array(0),
					"status" => "false"
			);
			
		endif;
		
	}
	
	public function exec_getPostponeAmount($doc_id) {
		$SQL 	= "[dbo].[PCIS_GetNumberOfPostpone] @DocID = '".$doc_id."'";
		$query  = $this->db->query($SQL);
		if($query->num_rows() > 0):
			return array(
					"data"   => $query->result_array(),
					"status" => "true"
			);
			
		else:
			return array(
					"data"   => array(0),
					"status" => "false"
			);
			
		endif;
	
	}
	
	public function exec_drawdownTemplateInsert($appno, $plan_date, $createcode, $createby) {
		if(!empty($appno)):
			$SQL 	= "[dbo].[sp_DrawdownTemplate_INSERT_Info] @ApplicationNo = '". $appno."', @PlanDrawdown = '".$plan_date."', @CreateByCode = '".$createcode."', @CreateBy = '". $createby ."'";
			$query  = $this->db->query($SQL);
			return TRUE;
			
		else:
			return FALSE;
		endif;
	
	}
	
	public function exec_drawdownTemplateDelete($appno) {
		if(!empty($appno)):
			$SQL 	= "[dbo].[sp_DrawdownTemplate_DeleteAll] @ApplicationNo = '". $appno."'";
			$query  = $this->db->query($SQL);
			return TRUE;	
		else:
			return FALSE;
		endif;
		
	
	}

	public function exec_getDataRetrieve_Log($docid) {
		$SQL 	= "[dbo].[PCIS_GetDataRetrieve_Log] '". $docid."'";
		$query  = $this->db->query($SQL);
		return $query->result_array();
	
	}
	
	public function exec_getGroupSFEList() {		
		$SQL 	= "[dbo].[PCIS_GetAuthorityGroupSFE]";
		$query  = $this->db->query($SQL);
		return $query->result_array();
	}
	
	public function exec_getSourceFieldList() {
		$SQL 	= "[dbo].[PCIS_GetDataSouceFieldList]";
		$query  = $this->db->query($SQL);
		return $query->result_array();
	}

	public function exec_getDataAssignDefendName($doc_id) {
		$SQL 	= "[dbo].[PCIS_GetDataAssignDefendNameOnBundled] '". $doc_id."'";
		$query  = $this->db->query($SQL);
		return $query->result_array();
	}
	
	
	public function exec_getWhiteboardKPIPreview($primary, $mode) {

		if(!empty($primary)):
			$option = " ,@ModeState = '".$mode."'";
		else:
			$option = " @ModeState = '".$mode."'";
		endif;

		$SQL 	= "[dbo].[PCIS_GetDataWhiteboard_KPIReader] ".$primary."" . $option;	
		$query  = $this->db->query($SQL);
		
		if($this->db_types == 'sqlsrv') {
			
			$result_set   = $query->result();		
			if(count($result_set) > 0) {
				$result = array();
				foreach ($result_set as $key => $value) {				
					$result[$key]['DocID'] 				= $value->DocID;
					$result[$key]['VerifyID'] 			= $value->VerifyID;
					$result[$key]['SourceOfCustomer'] 	= $value->SourceOfCustomer;
					$result[$key]['StartDate'] 			= $value->StartDate;
					$result[$key]['CheckNCBDate'] 		= $value->CheckNCBDate;
					$result[$key]['NCBCheckDate'] 		= $value->NCBCheckDate;
					$result[$key]['RMCode'] 			= $value->RMCode;
					$result[$key]['RMName'] 			= $value->RMName;
					$result[$key]['BasicCriteria'] 		= $value->BasicCriteria;
					$result[$key]['CheckNCB'] 			= $value->CheckNCB;
					$result[$key]['BrnSentNCBDate'] 	= $value->BrnSentNCBDate;
					$result[$key]['OwnerName'] 			= $value->OwnerName;
					$result[$key]['MainLoanName'] 		= $value->MainLoanName;
					$result[$key]['BranchCode'] 		= $value->BranchCode;
					$result[$key]['BranchDigit'] 		= $value->BranchDigit;
					$result[$key]['BranchTel'] 			= $value->BranchTel;
					$result[$key]['Branch'] 			= $value->Branch;
					$result[$key]['BranchName'] 		= $value->BranchName;
					$result[$key]['RegionID'] 			= $value->RegionID;
					$result[$key]['AreaCode'] 			= $value->AreaCode;
					$result[$key]['RegionNameEng'] 		= $value->RegionNameEng;
					$result[$key]['ProductCode'] 		= $value->ProductCode;
					$result[$key]['ProductName'] 		= $value->ProductName;
					$result[$key]['ProductTypes'] 		= $value->ProductTypes;
					$result[$key]['RequestLoan'] 		= $value->RequestLoan;
					$result[$key]['HQReceiveCADocDate'] = $value->HQReceiveCADocDate;
					$result[$key]['RMProcess'] 			= $value->RMProcess;
					$result[$key]['SentToCADate'] 		= $value->SentToCADate;
					$result[$key]['CAReturnDateLog'] 	= $value->CAReturnDateLog;
					$result[$key]['IsDefend'] 			= $value->IsDefend;
					$result[$key]['CAName'] 			= $value->CAName;
					$result[$key]['CA_ReceivedDocDate'] = $value->CA_ReceivedDocDate;
					$result[$key]['Status'] 			= $value->Status;
					$result[$key]['StatusReason'] 		= $value->StatusReason;
					$result[$key]['PreLoan'] 			= $value->PreLoan;
					$result[$key]['StatusDate'] 		= $value->StatusDate;
					$result[$key]['ApprovedLoan'] 		= $value->ApprovedLoan;
					$result[$key]['AFCancelReason'] 	= $value->AFCancelReason;
					$result[$key]['PlanDrawdownDate'] 	= $value->PlanDrawdownDate;
					$result[$key]['PlanDateUnknown'] 	= $value->PlanDateUnknown;
					$result[$key]['DrawdownDate'] 		= $value->DrawdownDate;
					$result[$key]['DrawdownBaht'] 		= $value->DrawdownBaht;
					$result[$key]['ActionNote'] 		= $value->ActionNote;
					$result[$key]['ActiveRecord'] 		= $value->ActiveRecord;
					$result[$key]['LatestEvent'] 		= $value->LatestEvent;
					$result[$key]['ReActivated'] 		= $value->ReActivated;
					$result[$key]['ReActivateDate'] 	= $value->ReActivateDate;
					$result[$key]['Retrieved'] 			= $value->Retrieved;
					$result[$key]['RetrieveDate'] 		= $value->RetrieveDate;
					$result[$key]['RetrieveTime'] 		= $value->RetrieveTime;
					$result[$key]['IsActive'] 			= $value->IsActive;
					$result[$key]['KeyPoint'] 			= $value->KeyPoint;
					
				}
		
				return array("data" => $result, "status" => "true");
		
			} else {
				return array("data" => array(0), "status" => "false");
		
			}
		
		} else {
				
			if($query->num_rows() > 0):
			return array(
					"data"   => $query->result_array(),
					"status" => "true"
			);
		
			else:
			return array(
					"data"   => array(0),
					"status" => "false"
			);
		
			endif;
			
		}

	}
	
	public function exec_getWhiteboardKPILoanSummary($primary, $mode) {
		
		if(!empty($primary)):
			$option = " , @ModeState = '".$mode."'";
		else:
			$option = " @ModeState = '".$mode."'";
		endif;
	
		$SQL 	= "[dbo].[PCIS_GetDataWhiteboard_KPILoanSummary] ".$primary."" . $option;
		$query  = $this->db->query($SQL);
			
		if($this->db_types == 'sqlsrv') {

			$result_set   = $query->result();
			if(count($result_set) > 0) {
				$result = array();
				foreach ($result_set as $key => $value) {
					$result[$key]['RowRecord'] 			= $value->RowRecord;			
					$result[$key]['RequestLoan'] 		= $value->RequestLoan;					
					$result[$key]['PreLoan'] 			= !empty($value->PreLoan) ? $value->PreLoan:0;				
					$result[$key]['ApprovedLoan'] 		= $value->ApprovedLoan;					
					$result[$key]['DrawdownBaht'] 		= $value->DrawdownBaht;							

				}
					
				return array("data" => $result, "status" => "true");
					
			} else {
				return array("data" => array(0), "status" => "false");
					
			}
				
		} else {
				
			if($query->num_rows() > 0):
			return array(
					"data"   => $query->result_array(),
					"status" => "true"
			);
				
			else:
			return array(
					"data"   => array(0),
					"status" => "false"
			);
				
			endif;

		}

	}
	
	public function exec_getTLAVolumeSummary($primary) {
	
		$SQL 	= "[dbo].[PCIS_TL_Volume] $primary";
		$query  = $this->db->query($SQL);

		if($this->db_types == 'sqlsrv') {
	
			$result_set   = $query->result();
			if(count($result_set) > 0) {
				
				$result = array();
				foreach ($result_set as $key => $value) {
					$result[$key]['TLA_ID'] 			= $value->TL_ID;
					$result[$key]['JoinDate'] 			= $value->JoinDate;
					$result[$key]['TLA_Status']			= $value->TLA_Status;
					$result[$key]['SLA'] 				= $value->SLA;
					$result[$key]['TLA_Code']	 		= $value->TLA_Code;
					$result[$key]['TLA_Name'] 			= $value->TLA_Name;
					$result[$key]['ApprovedTotal'] 		= $value->ApprovedTotal;
					$result[$key]['RejectTotal'] 		= $value->RejectTotal;
					$result[$key]['Appr_Rate'] 			= str_pad($value->Appr_Rate, 4, '0', STR_PAD_LEFT);
					$result[$key]['TicketSize'] 		= str_pad($value->TicketSize, 4, '0', STR_PAD_LEFT);
					$result[$key]['DD_Total'] 			= !empty($value->DD_Total) ? $value->DD_Total : 0;
					$result[$key]['DD_YAPP'] 			= !empty($value->DD_YAPP) ? $value->DD_YAPP : 0;
					$result[$key]['DD_CM'] 				= !empty($value->DD_CM) ? $value->DD_CM : 0;
					$result[$key]['DD_MAPP'] 			= !empty($value->DD_MAPP) ? $value->DD_MAPP : 0;
					$result[$key]['A2CA_Total'] 		= !empty($value->A2CA_Total) ? $value->A2CA_Total : 0;
					$result[$key]['A2CA_CM'] 			= !empty($value->A2CA_CM) ? $value->A2CA_CM:0;
					$result[$key]['NCB_Total'] 			= !empty($value->NCB_Total) ? $value->NCB_Total : 0;
					$result[$key]['NCB_CM'] 			= !empty($value->NCB_CM) ? $value->NCB_CM : 0;
					$result[$key]['TLA_Position'] 		= !empty($value->TLA_Position) ? $value->TLA_Position:'';
					$result[$key]['TLA_BranchName'] 	= !empty($value->TLA_BranchName) ? $value->TLA_BranchName:0;
					$result[$key]['TLA_BranchTel'] 		= !empty($value->TLA_BranchTel) ? $value->TLA_BranchTel:'';
					$result[$key]['LB_BranchCode'] 		= $value->LB_BranchCode;
					$result[$key]['BranchName'] 		= !empty($value->BranchName) ? $value->BranchName:'';
					$result[$key]['BranchDigit'] 		= $value->BranchDigit;
					$result[$key]['BranchTel'] 			= !empty($value->BranchTel) ? $value->BranchTel:'';
					
					$result[$key]['AssignmentCode'] 	= !empty($value->AssignmentCode) ? $value->AssignmentCode:'';
					$result[$key]['Assignment'] 		= !empty($value->Assignment) ? $value->Assignment:'';
					$result[$key]['AssignNickname'] 	= !empty($value->AssignNickname) ? $value->AssignNickname:'';
					$result[$key]['AssignMobile'] 		= !empty($value->AssignMobile) ? $value->AssignMobile:'';

				}
					
				return array("data" => $result, "status" => "true");
					
			} else {
				return array("data" => array(0), "status" => "false");
					
			}
	
		} else {
	
			if($query->num_rows() > 0):
			return array(
					"data"   => $query->result_array(),
					"status" => "true"
			);
	
			else:
			return array(
					"data"   => array(0),
					"status" => "false"
			);
	
			endif;
	
		}
		
	}
	
	public function exec_getTLAVolumePagination($primary) {
		
		$SQL 	= "[dbo].[PCIS_TL_VolumePagination] $primary";
		$query  = $this->db->query($SQL);
		
		if($this->db_types == 'sqlsrv') {
		
			$result_set   = $query->result();
			if(count($result_set) > 0) {
				
				$result = array();
				foreach ($result_set as $key => $value) {
					$result[$key]['TLA_ID']  = $value->TL_ID;
				}
					
				return array("data" => $result, "status" => "true");
					
			} else {
				return array("data" => array(0), "status" => "false");
					
			}
			
		
		} else {
		
			if($query->num_rows() > 0):
			return array(
					"data"   => $query->result_array(),
					"status" => "true"
			);
		
			else:
			return array(
					"data"   => array(0),
					"status" => "false"
			);
		
			endif;
		
		}

	}
	
	public function exec_getTLAVolumeGrandTotal($primary) {
		$SQL 	= "[dbo].[PCIS_TL_VolumeSummery] $primary";
		$query  = $this->db->query($SQL);
		
		if($this->db_types == 'sqlsrv') {
		
			$result_set   = $query->result();
			if(count($result_set) > 0) {
		
				$result = array();
				foreach ($result_set as $key => $value) {
					$result[$key]['RowRecord']  = $value->RowRecord;
					$result[$key]['DD_Total']   = $value->DD_Total;
					$result[$key]['DD_CM']  	= $value->DD_CM;
				}
					
				return array("data" => $result, "status" => "true");
					
			} else {
				return array("data" => array(0), "status" => "false");
					
			}
		
		
		} else {
		
			if($query->num_rows() > 0):
				return array(
						"data"   => $query->result_array(),
						"status" => "true"
				);
		
			else:
				return array(
						"data"   => array(0),
						"status" => "false"
				);
		
			endif;
		
		}
		
	}
		
	public function getOSBalance($emp_code) {
	
		$SQL 	= "[dbo].[PCIS_COLLECTION_OS] @EmpCode = '".$emp_code."'";	
		$query  = $this->db->query($SQL);

		if($this->db_types == 'sqlsrv') {
		
			$result_set   = $query->result();			
			if(count($result_set) > 0) {
		
				$result = array();
				foreach ($result_set as $key => $value) {
					$result[$key]['Year']  			= $value->Year;					
					$result[$key]['OSActual']  		= $value->OSActual;
					$result[$key]['DDActual']   	= $value->DDActual;
					$result[$key]['ActualTotal']  	= $value->ActualTotal;					
					$result[$key]['PayPercentage']  = $value->PayPercentage;
					$result[$key]['FinalNetActual'] = $value->FinalNetActual;				
				}
					
				return array("data" => $result, "status" => "true");
					
			} else {
				return array("data" => array(0), "status" => "false");
					
			}
		
		
		} else {
		
			return array("data" => array(
					'Year'				=> '',
					'OSActual'			=> '',
					'DDActual'			=> '',
					'ActualTotal'		=> '',
					'PayPercentage'		=> '',
					'FinalNetActual'	=> ''
				),
				"status" => "false"
			);
		
		}
		
	}
	
	public function getFileDetails($doc_id, $defend_ref, $defend_code) {
		
		$criteria	= "@DocID = '".$doc_id."', @DefendRef = '".$defend_ref."', @DefendCode = '".$defend_code."'";
		$sql 		= "[dbo].[sp_PCIS_DefendFiles_Info]	$criteria";
		$query  	= $this->db->query($sql);
	
		if($this->db_types == 'sqlsrv') {
	
			$result_set   = $query->result();
			
			if(count($result_set) > 0) {
	
				$result = array();
				foreach ($result_set as $key => $value) {
					$result[$key]['RowNo']  		= $value->RowNo;
					$result[$key]['DocID']  		= $value->DocID;
					$result[$key]['DefendCode']   	= $value->DefendCode;
					$result[$key]['Files']  		= $value->Files;
					$result[$key]['File_Reference'] = $value->File_Reference;
					$result[$key]['File_Name'] 		= $value->File_Name;
					$result[$key]['Extension'] 		= $value->Extension;
					$result[$key]['CreateBy'] 		= $value->CreateBy;
					$result[$key]['CreateDate'] 	= $value->CreateDate;
					$result[$key]['FileState'] 		= $value->FileState;
				}
					
				return array("data" => $result, "status" => "true");
					
			} else {
				return array("data" => array(0), "status" => "false");
					
			}

		}
	
	}
	
	public function dbo_getRoyalGuidance() {
	
		$SQL 	= "[dbo].[PCIS_RoyalGuidance]";
		$query  = $this->db->query($SQL);
	
		if($this->db_types == 'sqlsrv') {
	
			$result_set   = $query->result();
			if(count($result_set) > 0) {
	
				$result = array();
				foreach ($result_set as $key => $value) {
					$result[$key]['RowID']  		= $value->RowID;
					$result[$key]['RoyalGuidance']  = $value->RoyalGuidance;
					$result[$key]['ActiveDay']   	= $value->ActiveDay;
					$result[$key]['IsActive']  		= $value->IsActive;
				}
					
				return array("data" => $result, "status" => "true");
					
			} else {
				return array("data" => array(0), "status" => "false");
					
			}
				
	
		} else {
	
			if($query->num_rows() > 0):
			return array(
					"data"   => $query->result_array(),
					"status" => "true"
			);
	
			else:
			return array(
					"data"   => array(0),
					"status" => "false"
			);
	
			endif;
	
		}
	
	}
	
	public function exec_getActionNoteJSONLogs($doc_id) {
		
		$SQL 	= "PCIS_GetActionNoteLogs '".$doc_id."'";
		$query  = $this->db->query($SQL);
		
		if($this->db_types == 'sqlsrv') {
			
			$result_set   = $query->result();
			if(count($result_set) > 0) {
				
				$result = array();
				foreach ($result_set as $key => $value) {
					$result[$key]['DocID']  		= $value->DocID;
					$result[$key]['ActionNote']  	= $value->ActionNote;
					$result[$key]['ActionNoteBy']   = $value->ActionNoteBy;
					$result[$key]['ActionName']  	= $value->ActionName;
					$result[$key]['ActionNoteDate'] = $value->ActionNoteDate;
					$result[$key]['ActionDateTime'] = $value->ActionDateTime;
					$result[$key]['PositionShort']  = $value->PositionShort;
					$result[$key]['BusinessType']  	= $value->BusinessType;
					$result[$key]['Business']   	= $value->Business;
				}
				
				return array("data" => $result, "status" => "true");
				
			} else {
				return array("data" => array(0), "status" => "false");
				
			}
				
		} else {
			
			if($query->num_rows() > 0):
				return array(
						"data"   => $query->result_array(),
						"status" => "true"
				);
			
			else:
				return array(
						"data"   => array(0),
						"status" => "false"
				);
			
			endif;
			
		}
		
	}
		
	public function getEmployeeWhiteboardList($emp_code, $role) {
		$SQL 	= "[dbo].[PCIS_GetEmployeeDashboard] @EmployeeCode = '".$emp_code."', @Role = $role";
		$query  = $this->db->query($SQL);
		
		if($this->db_types == 'sqlsrv') {
			
			$result_set   = $query->result();
			if(count($result_set) > 0) {
				
				$result = array();
				foreach ($result_set as $key => $value) {
					$result[$key]['EmployeeCode']  	= $value->EmployeeCode;
					$result[$key]['FullNameTh']  	= $value->FullNameTh;
					$result[$key]['PositionTitle']  = $value->PositionTitle;
					$result[$key]['PositionShort']  = $value->PositionShort;
					$result[$key]['RegionID'] 		= $value->RegionID;
					$result[$key]['RegionNameEng']  = $value->RegionNameEng;
					$result[$key]['AreaName']  		= $value->AreaName;
					$result[$key]['BranchCode']     = (!empty($value->BranchCode)) ? str_pad($value->BranchCode, 3, '0', STR_PAD_LEFT):'';
					$result[$key]['BranchDigit']  	= $value->BranchDigit;
					$result[$key]['BranchName']   	= $value->BranchName;
					$result[$key]['Flag']  			= $value->Flag;
				}
				
				return array("data" => $result, "status" => "true");
				
			} else {
				return array("data" => array(0), "status" => "false");
				
			}
			
		} else {
			
			if($query->num_rows() > 0):
			return array("data"   => $query->result_array(), "status" => "true");
			else:
			return array("data"   => array(0), "status" => "false");
			endif;
			
		}
	}
	
	public function exec_getRequestDefend() {
		$this->load->library('effective');
		
		$SQL 	= "[dbo].[sp_PCIS_RequestDefend_Schedule]";
		$query  = $this->db->query($SQL);
		
		if($this->db_types == 'sqlsrv') {
			
			$result_set   = $query->result();
			if(count($result_set) > 0) {				
				$result = array();
				foreach ($result_set as $key => $value) {
					$result[$key]['DocID']  		= $value->DocID;
					$result[$key]['ApplicationNo']  = $value->ApplicationNo;
					$result[$key]['IDCard']  		= $value->IDCard;
					$result[$key]['BorrowerName']  	= !empty($value->BorrowerName) ? $this->effective->get_chartypes($this->char_mode, $value->BorrowerName):'';					
					$result[$key]['RegionNameEng']  = !empty($value->RegionName) ? $this->effective->get_chartypes($this->char_mode, $value->RegionName):'';
					$result[$key]['BranchDigit']  	= !empty($value->BranchDigit) ? $this->effective->get_chartypes($this->char_mode, $value->BranchDigit):'';
					$result[$key]['BranchName']  	= !empty($value->BranchName) ? $this->effective->get_chartypes($this->char_mode, $value->BranchName):'';
					$result[$key]['RMName']  		= !empty($value->RMName) ? $this->effective->get_chartypes($this->char_mode, $value->RMName):'';
					$result[$key]['RMMobile']  		= !empty($value->RMMobile) ? $this->effective->get_chartypes($this->char_mode, $value->RMMobile):'';					
					$result[$key]['CreateDate']  	= $value->CreateDate;
				}
				
				return array("data" => $result, "status" => true, 'msg' => 'Success');
				
			} else {
				return array("data" => array(0), "status" => false, 'msg' => 'Not found data.');
			}
			
		} else {			
			if($query->num_rows() > 0):
				return array("data"   => $query->result_array(), "status" => true);
			else:
				return array("data"   => array(0), "status" => false);
			endif;			
		}
	}
	
	
	public function exec_getRequestDefendToInbox($emp_code) {
		$this->load->library('effective');
		
		$SQL 	= "[dbo].[sp_PCIS_DefendDashboard_RequestToManager] @EmpCode = '".$emp_code."'";
		$query  = $this->db->query($SQL);
		
		if($this->db_types == 'sqlsrv') {
			
			$result_set   = $query->result();
			if(count($result_set) > 0) {
				$result = array();
				foreach ($result_set as $key => $value) {
					$result[$key]['DocID']  		= $value->DocID;
					$result[$key]['RegionID']  		= $value->RegionID;
					$result[$key]['AreaCode']  		= $value->AreaCode;
					$result[$key]['AreaShortCode']  = $value->AreaShortCode;
					$result[$key]['BranchCode']  	= $value->BranchCode;					
					$result[$key]['BranchName']  	= !empty($value->BranchName) ? $this->effective->get_chartypes($this->char_mode, $value->BranchName):'';
					$result[$key]['RMCode']  		= $value->RMCode;
					$result[$key]['RMName']  		= !empty($value->RMName) ? $this->effective->get_chartypes($this->char_mode, $value->RMName):'';					
					$result[$key]['DefendRef']  	= $value->DefendRef;
					$result[$key]['ApprovedStatus'] = $value->ApprovedStatus;	
					$result[$key]['CreateID']  		= $value->CreateID;
					$result[$key]['CreateBy']  		= !empty($value->CreateBy) ? $this->effective->get_chartypes($this->char_mode, $value->CreateBy):'';
					$result[$key]['CreateDate']  	= $value->CreateDate;
				}
				
				return array("data" => $result, "status" => true, 'msg' => 'Success');
				
			} else {
				return array("data" => array(0), "status" => false, 'msg' => 'Not found data.');
			}
			
		} else {
			if($query->num_rows() > 0):
				return array("data" => $query->result_array(), "status" => true);
			else:
				return array("data" => array(0), "status" => false);
			endif;
		}
	}
	
	public function exec_defendsuspend($app_no) {
		$this->db_env = $this->config->item('database_env');		
		if(!empty($app_no)) {
			if($this->db_env == 'production') {
				$SQL 	= "[dbo].[sp_PCIS_DefendSuspend] @AppNo = '".$app_no."'";
				$query  = $this->db->query($SQL);
				return TRUE;
			} else {
				return FALSE;
			}
			
		} else {
			return FALSE;
		}
	}
	
	public function exec_getAllowReserved($appno) {
		$this->load->library('effective');
		
		$SQL 	= "[dbo].[sp_DrawdownTemplate_cutoff_Reserved] @ApplicationNo = '".$appno."'";
		$query  = $this->db->query($SQL);
		
		if($this->db_types == 'sqlsrv') {
			
			$result_set   = $query->result();
			if(count($result_set) > 0) {
				$result = array();
				foreach ($result_set as $key => $value) {
					$result[$key]['ApplicationNo']  		= $value->ApplicationNo;
					$result[$key]['AllowReserved']  		= ($value->AllowReserved == 1) ? 'Y' : 'N';
				}
				
				return array("data" => $result, "status" => true, 'msg' => 'Success');
				
			} else {
				return array("data" => array(0), "status" => false, 'msg' => 'Not found data.');
			}
			
		} else {
			if($query->num_rows() > 0):
			return array("data" => $query->result_array(), "status" => true);
			else:
			return array("data" => array(0), "status" => false);
			endif;
		}
	}
	
}

