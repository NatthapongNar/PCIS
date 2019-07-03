<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Defend_control extends MY_Controller {
	
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
				"pilot"		 => $this->pilot
		);
		
	}
	
	public function defenddashboard() {
		$this->load->model('dbmodel');
		$this->data['user_role']	= $this->getRole($this->authorized[0]);
		
		if(empty($this->authorized[0])):
			redirect('authen/logout');
		endif;
		
		$this->data['approved_role']  = $this->dbmodel->CIQuery("SELECT CASE NEWBIE WHEN 'N' THEN 'Y' ELSE 'N' END NEWBIE FROM LendingEmp WHERE EmployeeCode = '".$this->emp_id."'");
		
		$this->load->view($this->pages_customiz.'defend_note/defend_dashboard', $this->data);		
	}
	
	public function defenddashboard_v2() {
		$this->load->model('dbmodel');
		$this->data['user_role']	= $this->getRole($this->authorized[0]);
		
		if(empty($this->authorized[0])):
			redirect('authen/logout');
		endif;
		
		$this->data['approved_role']  = $this->dbmodel->CIQuery("SELECT CASE NEWBIE WHEN 'N' THEN 'Y' ELSE 'N' END NEWBIE FROM LendingEmp WHERE EmployeeCode = '".$this->emp_id."'");
		
		$this->load->view($this->pages_customiz.'defend_note/defend_dashboard_v2', $this->data);
	}
	
	public function getRole($role) {
		if(!empty($role)) {
			switch ($role) {
				case $this->config->item('ROLE_ADMIN'):
					if($this->branch_code == '000') return 'admin_role';
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
	
	public function getIssueReasonList() {
		$this->load->model('dbmodel');
		$this->load->model('dbstore');
		$this->load->library('effective');
		
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
		
		$this->data['char_mode']	   = $this->char_mode;
		
		$this->load->view($this->pages_customiz.'defend_note/notepad_reform', $this->data);
		
	}
	
	public function savePDF() {
		$this->load->model('dbmodel');
		
		$this->load->library('Pdfmerger');
		$this->load->library('email');
		$this->load->library('encrypt');
		$this->load->library('effective');
		
		date_default_timezone_set("Asia/Bangkok");
		
		$appx = $this->input->get('appx');
		$docx = $this->input->get('docx');
		$data = substr($this->input->post('data'), strpos($this->input->post('data'), ",") + 1);
		
		$local_pathname = 'D:\PCIS_File_Uploads\\';
		$destination_path = "D:\PCIS Document\\";		
		
		if(!is_dir($local_pathname)) mkdir($local_pathname, 0777, true); 		
		if(!is_dir($destination_path)) mkdir($destination_path, 0777, true);

		$local_path = $local_pathname. 'application\\';
		
		if(is_dir($local_pathname)) {
			if (!file_exists($local_path)) {
				mkdir($local_path, 0777, true);
			}
		}
		
		$filename = (!empty($appx) ? $appx : $docx) . '.pdf';
		$decodedData = base64_decode($data);
		
		$specific_intra_path = $destination_path.$filename;
		$specific_local_path = $local_path.$filename;
		
 		file_put_contents($specific_local_path, $decodedData);
 		
		$docOptional = array();
		if(is_file($specific_local_path) === TRUE) {
			
			$page_break_new_attach = $_SERVER['DOCUMENT_ROOT'] . 'pcis/template/pages_break_new.pdf';
			$page_break_exist_attach = $_SERVER['DOCUMENT_ROOT'] . 'pcis/template/page_break_exist.pdf';
			
			$pdf = new Pdfmerger;
			$pdf->addPDF($specific_local_path, 'all');
			
			$has_new_attach = FALSE;
			$result_new_file = $this->dbmodel->CIQuery("
				SELECT * FROM [DefendUploads]
				WHERE [IsActive] = 'A'
				AND [Extension] = 'pdf'
				AND [DocID] = '".$docx."'
				AND [IsPrint] IS NULL
				ORDER BY [CreateDate] DESC
			");
			
			if($result_new_file['status'] !== 'false') {
				$has_new_attach = TRUE;
				if(!empty($result_new_file['data'][0]['DocID'])) {
					
					$pdf->addPDF($page_break_new_attach, 'all');
					array_push($docOptional, $page_break_new_attach);
					
					foreach ($result_new_file['data'] as $key => $value):
					if (file_exists($value['Files'])){
						$pdf->addPDF($value['Files'], 'all');
						array_push($docOptional, $value['Files']);
					}
					endforeach;
				}				
			}
			
			$result_old_file = $this->dbmodel->CIQuery("
				SELECT * FROM [DefendUploads]
				WHERE [IsActive] = 'A'
				AND [Extension] = 'pdf'
				AND [DocID] = '".$docx."'
				AND [IsPrint] IS NOT NULL
				ORDER BY [CreateDate] DESC
			");
			
			if($result_old_file['status'] !== 'false') {
				if(!empty($result_old_file['data'][0]['DocID'])) {
					
					$pdf->addPDF($page_break_exist_attach, 'all');
					array_push($docOptional, $page_break_exist_attach);
					
					foreach ($result_old_file['data'] as $key => $value):
					if (file_exists($value['Files'])){
						$pdf->addPDF($value['Files'], 'all');
						array_push($docOptional, $value['Files']);
					}
					endforeach;
				}
								
			}

			if(count($docOptional) > 0) {
				$pdf->merge('file', $specific_local_path);
			}
			
			$file_transfer = $this->smartCopy($specific_local_path, $specific_intra_path);	
			if($file_transfer) {
				
				if($has_new_attach == TRUE) {
					$this->dbmodel->exec('DefendUploads', array('IsPrint' => 'Y'), array('DocID' => $value['DocID']), 'update');
				}
				
				$event_logs 		 = array(
					'DocID'			=> $docx,
					'ApplicationNo' => $appx,
					'EventProcess'	=> 'DEFEND GENERATION',
					'CreateByID'	=> $this->session->userdata("empcode"),
					'CreateByName'	=> $this->effective->get_chartypes($this->char_mode, $this->session->userdata("thname")),
					'CreateByDate'	=> date('Y-m-d H:i:s')
				);
				
				$insert_logs = $this->dbmodel->exec('PCISEventLogs', $event_logs, false, 'insert');
				
				if($insert_logs === TRUE) {
					
					if (file_exists($specific_intra_path)) {
						$results = $this->dbmodel->loadData('ApplicationStatus', "ApplicationNo", array('DocID' => $docx));
						if(!empty($results['data'][0]['ApplicationNo'])) {							
							$send_already = $this->dbmodel->CIQuery("
								SELECT [ApplicationNo] 
								FROM [Defend_Insert_SDE_Log] 
								WHERE [dbo].[DateOnlyFormat]([SendDate]) = [dbo].[DateOnlyFormat](GETDATE())
								AND [ApplicationNo] = '".$results['data'][0]['ApplicationNo']."'
							");						
														
							if(empty($send_already['data'][0]['ApplicationNo'])) {
								$cust_id   = $this->session->userdata("empcode");
								$cust_name = $this->effective->get_chartypes($this->char_mode, $this->session->userdata("thname"));
								$this->dbmodel->CIQuery("[dbo].[sp_pcis_defend_INSERT_ToSDE] @ApplicationNo = '".$results['data'][0]['ApplicationNo']."', @EmpID = '".$cust_id."', @SendBy =  '".$cust_name."'");
							}

						}
					
					}
					
					$defend_list = $this->dbmodel->CIQuery("
						 SELECT DocID, DefendRef
						 FROM New_DefendHead
						 WHERE DocID = '".$docx."'
						 AND IsActive = 'A'
						 AND DefendProgress NOT IN ('Send to CA', 'Completed')
					");
					
					if(!empty($defend_list['data'][0]['DocID'])) {
						foreach ($defend_list['data'] as $key => $value) {
							$param	= array(
								'AssignmentDate'  => date('Y-m-d H:i:s'),
								'DefendProgress'  => 'Send to CA',
								'UpdateID'		  => trim($this->emp_id),
								'UpdateBy'	  	  => $this->name,
								'UpdateDate'	  => date('Y-m-d H:i:s')
							);
							
							$logs	= array(
								'DocID'			=> $value['DocID'],
								'DefendRef'		=> $value['DefendRef'],
								'DefendCode'	=> NULL,
								'DefendEvent'	=> 'PRINT',
								'CreateID'		=> trim($this->emp_id),
								'CreateBy'		=> $this->name,
								'CreateDate'	=> date('Y-m-d H:i:s')
							);
							
							$statelogs	= array(
								'DocID'				=> $value['DocID'],
								'DefendRef'			=> $value['DefendRef'],
								'DefendProgress'	=> 'Send to CA',
								'AssignDate'		=> date('Y-m-d H:i:s'),
								'AssignID'			=> trim($this->emp_id),
								'AssignBy'			=> $this->name
							);
							
							$this->dbmodel->exec('New_DefendHead', $param, array('DocID' => $value['DocID'], 'DefendRef' => $value['DefendRef']), 'update');
							$this->dbmodel->exec('New_DefendEventLog', $logs, false, 'insert');
							$this->dbmodel->exec('New_DefendAssignLogs', $statelogs, false, 'insert');
							
						}
						
					}
			
				}
				
				echo json_encode(
					array(
						'status' => 'true',
						'info' => $specific_local_path,
						'doc_option' => $docOptional,
						'msg' => 'success'
					)
				);
				
			} else {
				echo json_encode(
					array(
						'status' => 'false',
						'info' => '',
						'doc_option' => '',
						'msg' => 'บันทึกข้อมูลไม่สำเร็จ'
					)
				);
				
			}
		
		}
		
	}
	
	public function reupdatefile() {
		$this->load->model('dbmodel');
		
		$result_set = $this->dbmodel->CIQuery("
			SELECT RowID, DocID, ApplicationNo, EventProcess, CreateByID, CreateByName, CreateByDate
			FROM PCISEventLogs
			WHERE EventProcess = 'DEFEND UN-GENERATION'
			AND ApplicationNo IS NOT NULL
			ORDER BY CreateByDate DESC
		");
		
		$destination_path = "\\\\172.17.9.68\cds\appl_pcis_defend\\";
		if($result_set['status'] == 'true') {

			if(!empty($result_set['data'][0]['DocID'])) {				
				$local_pathname = 'C:\xampp\htdocs\pcis\upload\application\\';
				
				$update_logs = array();
				foreach ($result_set['data'] as $index => $value) {
					
					$filename = $local_pathname.$value['ApplicationNo'].'.pdf';
					$filedestiny = $destination_path.$value['ApplicationNo'].'.pdf';
					
					if(is_file($filename)) {
						
						$file_transfer = $this->rcopy_unlog($filename, $filedestiny);		
						if($file_transfer) {
							$update_state = $this->dbmodel->exec('PCISEventLogs', array('EventProcess' => 'DEFEND UN-GENERATION (RE-UPDATE-SUCC)'), array('RowID' => $value['RowID']), 'update');
							if($update_state == TRUE) {
								array_push($update_logs, 
									array(
										'DocID'			=> $value['DocID'],
										'ApplicationNo' => $value['ApplicationNo'],
										'UpdateStatus'	=> (string)$update_state
									)
								);
							}
						} else {
							array_push($update_logs,
								array(
										'DocID'			=> $value['DocID'],
										'ApplicationNo' => $value['ApplicationNo'],
										'UpdateStatus'	=> 'false'
								)
							);
						}
					}
					
				}
				
				echo json_encode(array('data' => $update_logs));
				
			}
			
		} else {
			echo json_encode(array('data' => array(), 'status' => false, 'msg' => 'Data not found.'));
		}
		
	}

	
	// Function to remove folders and files
	private function rrmdir($dir) {
		if (is_dir($dir)) {
			$files = scandir($dir);
			foreach ($files as $file)
				if ($file != "." && $file != "..") $this->rrmdir("$dir/$file");
				$this->rmdir($dir);
		}
		else if (file_exists($dir)) {
			if(!fopen($dir, 'r')) unlink($dir);
		}
	}
	
	// Function to Copy folders and files
	public function rcopy_unlog($src, $dst) {
		if (file_exists ( $dst ))
			
			$this->rrmdir ( $dst );
			if (is_dir ( $src )) {
				mkdir ( $dst );
				$files = scandir ( $src );
				foreach ( $files as $file )
					if ($file != "." && $file != "..")
						$this->rcopy ( "$src/$file", "$dst/$file" );
			} else if (file_exists ( $src )) {
				if(!@copy ( $src, $dst )) {
					return false;
				} else {
					@copy ( $src, $dst );
					return true;
				}
			}
			
	}
	
	public function rcopy($src, $dst, $docx, $appx) {
		$this->load->library('effective');
		
		if (file_exists ( $dst )) {
			$this->rrmdir ( $dst );
			if (is_dir ( $src )) {
				mkdir ( $dst );
				$files = scandir ( $src );
				foreach ( $files as $file )
					if ($file != "." && $file != "..")
						$this->rcopy ( "$src/$file", "$dst/$file" );
			} else if (file_exists ( $src )) {
				if(!copy( $src, $dst )) {
					$event_logs 		 = array(
							'DocID'			=> $docx,
							'ApplicationNo' => $appx,
							'EventProcess'	=> 'DEFEND UN-GENERATION',
							'CreateByID'	=> $this->session->userdata("empcode"),
							'CreateByName'	=> $this->effective->get_chartypes($this->char_mode, $this->session->userdata("thname")),
							'CreateByDate'	=> date('Y-m-d H:i:s')
					);
					
					$this->dbmodel->exec('PCISEventLogs', $event_logs, false, 'insert');
					return false;
					
				} else {
					@copy ( $src, $dst );					
					return true;
				}

			}
		}
	}
	
	public function smartCopy($source, $dest, $options = array('folderPermission' => 0755,'filePermission' => 0755)) {
		$result = false;
		
		if (is_file ( $source )) {
			if ($dest [strlen ( $dest ) - 1] == '/') {
				if (! file_exists ( $dest )) {
					cmfcDirectory::makeAll ( $dest, $options ['folderPermission'], true );
				}
				$__dest = $dest . "/" . basename ( $source );
			} else {
				$__dest = $dest;
			}
			$result = @copy ( $source, $__dest );
			chmod ( $__dest, $options ['filePermission'] );
		} elseif (is_dir ( $source )) {
			if ($dest [strlen ( $dest ) - 1] == '/') {
				if ($source [strlen ( $source ) - 1] == '/') {
					// Copy only contents
				} else {
					// Change parent itself and its contents
					$dest = $dest . basename ( $source );
					@mkdir ( $dest );
					chmod ( $dest, $options ['filePermission'] );
				}
			} else {
				if ($source [strlen ( $source ) - 1] == '/') {
					// Copy parent directory with new name and all its content
					@mkdir ( $dest, $options ['folderPermission'] );
					chmod ( $dest, $options ['filePermission'] );
				} else {
					// Copy parent directory with new name and all its content
					@mkdir ( $dest, $options ['folderPermission'] );
					chmod ( $dest, $options ['filePermission'] );
				}
			}
			
			$dirHandle = opendir ( $source );
			while ( $file = readdir ( $dirHandle ) ) {
				if ($file != "." && $file != "..") {
					if (! is_dir ( $source . "/" . $file )) {
						$__dest = $dest . "/" . $file;
					} else {
						$__dest = $dest . "/" . $file;
					}
					$result = smartCopy ( $source . "/" . $file, $__dest, $options );
				}
			}
			closedir ( $dirHandle );
		} else {
			$result = false;
		}
		return $result;
	} 

	public function setDefendInitialyzeForm() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		$whip					= $this->input->post('whip');
		$doc_id 				= $this->input->post('doc_id');
		$enabled				= $this->input->post('enable');
		$editor					= $this->input->post('editor');
		
		$defend_ref 			= $this->input->post('defendref');	

		$actor_date				= $this->input->post('actor_date');
		$actor_name				= $this->input->post('actor_name');
		
		// Main: Issue Reason Field
		$defend_id				= $this->input->post('record_id');
		$defend_code			= $this->input->post('defend_id');
		$defend_subject			= $this->input->post('defend_subject');
		$defend_content			= $this->input->post('defend_reason');
		$defend_identity		= $this->input->post('editor_id');
		$defend_names			= $this->input->post('editor_name');
		
		// Supplment: Defend Filed
		$defend_supply_content	= $this->input->post('defend_supplement_content');
		$defend_supplement_id	= $this->input->post('editor_otherid');
		$defend_supplement_name	= $this->input->post('editor_othername');
		
		// RM/BM
		$defend_lending_content	= $this->input->post('defend_lending_content');
		$editor_lendingid		= $this->input->post('editor_lendingid');
		$editor_lendingname		= $this->input->post('editor_lendingname');

		// Supplement
		$def_assignID			= $this->input->post('defendEmpID');
		$def_assignName			= $this->input->post('defendEmpName');
		$def_assignBy			= $this->input->post('assignmentBy');
		$def_assignDate			= $this->input->post('assignmentDate');
		
		date_default_timezone_set("Asia/Bangkok");
		
		$audit_validate			= array();
		
		foreach($defend_names as $i => $v) {
		
			if(!empty($defend_names[$i])) {
				array_push($audit_validate, 'TRUE');
			} else {
				array_push($audit_validate, 'FALSE');
			}
		
		}
		
		if(!empty($defend_supplement_name)):
			array_push($audit_validate, 'TRUE');
		else:
			array_push($audit_validate, 'FALSE');
		endif;
		
		if(!empty($editor_lendingname)):
			array_push($audit_validate, 'TRUE');
		else:
			array_push($audit_validate, 'FALSE');
		endif;
		
		// Def bundled.
		if(!empty($def_assignID)) {
			$this->dbmodel->exec('DefendHead',array(
				"DefendEmpID" 	 => $def_assignID,
				"DefendEmpName"	 => !empty($def_assignName) ? $this->effective->set_chartypes($this->char_mode, $def_assignName):'',
				"AssignmentBy"   => !empty($def_assignBy) ? $this->effective->set_chartypes($this->char_mode, $def_assignBy):NULL,
				"AssignmentDate" => !empty($def_assignDate) ? $this->effective->StandartDateSorter($def_assignDate):NULL
			),
			array("DocID" => $doc_id, "DefendRef" => $defend_ref), 'update');
		
		}
		
		if(!in_array('TRUE', $audit_validate)) {
			redirect('defend_control/getIssueReasonList?rel='.$doc_id.'&lnx='.$defend_ref.'&enable=true&st=true&sp=1&whip='.$whip.'&enable='.$enabled.'&editor='.$editor, 'refresh');
			
		} else {
			
			if(empty($doc_id) || empty($defend_ref)) {
				redirect('defend_control/getIssueReasonList?rel='.$doc_id.'lnx='.$defend_ref.'&enable=true&st=false&sp=1&whip='.$whip.'&enable='.$enabled.'&editor='.$editor, 'refresh');
			
			} else {
					
				try {
									
					
					$table_head = $this->dbmodel->exec('DefendHead',
					array("DefendSubject"	 => $this->effective->set_chartypes($this->char_mode, 'เพิ่มเติม'),
						  "DefendSupplement" => !empty($defend_supply_content) ? $this->effective->set_chartypes($this->char_mode, $defend_supply_content):NULL,
						  "UpdateBy"		 => !empty($defend_supplement_name) ? $this->effective->set_chartypes($this->char_mode, $defend_supplement_name):NULL,
						  "UpdateDate"		 => date('Y-m-d H:i:s'),
						  "LBRemark"		 => !empty($defend_lending_content) ? $this->effective->set_chartypes($this->char_mode, $defend_lending_content):NULL
					),
					array("DocID" => $doc_id, "DefendRef" => $defend_ref), 'update');
		
					// write logs
					if($table_head == TRUE) {
						$this->setDescriptionWritelogs(
							array($doc_id, $defend_ref),
							array($defend_code, $defend_content, $defend_identity, $defend_names, $defend_subject),
							array($defend_supply_content, $defend_supplement_id, $defend_supplement_name),
							array($defend_lending_content, $editor_lendingid, $editor_lendingname)
						);
					}
			
					foreach($defend_content as $index => $value) {
							
						if(empty($defend_content[$index])):
							continue;
						else:
							$table_subscription = $this->dbmodel->exec('DefendSubscription',
							array("DefendNote"  => $this->effective->set_chartypes($this->char_mode, str_replace ('"', '', $defend_content[$index])),
								  "CreateBy"    => $this->effective->set_chartypes($this->char_mode, $defend_names[$index]),
								  "CreateDate"  => date('Y-m-d H:i:s'),
							),
							array("DFS_ID"	    => $defend_id[$index],
								  "DocID"	    => $doc_id,
								  "DefendRef"   => $defend_ref,
								  "DefendCode"  => $defend_code[$index]
							), 'update'); 
						endif;
							
					}
		
					$objData = array();
					foreach($defend_identity as $index => $values) {
							
						if(empty($defend_identity[$index])):
							continue;
						else:
			
							array_push($objData,
								array(
										'DocID'			=> $doc_id,
										'DefendCode'	=> $defend_code[$index],
										'DefendRef'		=> $defend_ref,
										'CreateID'		=> $defend_identity[$index],
										'CreateName'	=> $this->effective->set_chartypes($this->char_mode, $defend_names[$index]),
										'CreateDate'	=> date('Y-m-d H:i:s'),
										'IsActive'		=> 'A'
								)
							);
			
						endif;
							
					}
					
					
					if(!empty($defend_supplement_id)):
						array_push($objData,
							array('DocID'		=> $doc_id,
								'DefendCode'	=> 'SPE99',
								'DefendRef'		=> $defend_ref,
								'CreateID'		=> $defend_supplement_id,
								'CreateName'	=> $this->effective->set_chartypes($this->char_mode, $defend_supplement_name),
								'CreateDate'	=> date('Y-m-d H:i:s'),
								'IsActive'		=> 'A'
							)
						);
					endif;
				
					if(!empty($editor_lendingid)):
						array_push($objData,
							array('DocID'			=> $doc_id,
									'DefendCode'	=> 'SLB99',
									'DefendRef'		=> $defend_ref,
									'CreateID'		=> $editor_lendingid,
									'CreateName'	=> $this->effective->set_chartypes($this->char_mode, $editor_lendingname),
									'CreateDate'	=> date('Y-m-d H:i:s'),
									'IsActive'		=> 'A'
							)
						);
					endif;
			
					if(!empty($objData[0]['DocID'])):
						$this->writeDataLogs($objData);
					endif;
			
					if($table_head == TRUE) {
						redirect('defend_control/getIssueReasonList?rel='.$doc_id.'&lnx='.$defend_ref.'&enable=true&st=true&sp=1&whip='.$whip.'&enable='.$enabled.'&editor='.$editor, 'refresh');
					} else {
						redirect('defend_control/getIssueReasonList?rel='.$doc_id.'&lnx='.$defend_ref.'&enable=true&st=false&sp=2&whip='.$whip.'&enable='.$enabled.'&editor='.$editor, 'refresh');
					}
					
				} catch (Exception $e) {
					echo 'Caught exception: '.$e->getMessage()."\n";
					echo 'Caught exception: '.$e->getLine()."\n";
					echo 'The Exception: '.$e->getTrace()."\n";
			
				}
					
			}			
		}

	}

	public function setDescriptionWritelogs($condition = array(), $defend_list = array(), $supplement = array(), $lbcontent = array()) {
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		if(!empty($condition[0])) {
		
			// Combine reason
			$objData = array();
			foreach($defend_list[1] as $index => $values) {
					
				if(empty($defend_list[1][$index])):
					continue;
				else:
						
					array_push($objData,
						array('DocID'			=> $condition[0],
							  'DefendRef'		=> $condition[1],
							  'DefendCode'		=> $defend_list[0][$index],
							  'DefendOther'		=> !empty($defend_list[4][$index]) ? $this->effective->set_chartypes($this->char_mode, $this->strip_html_contents($defend_list[4][$index])):NULL,
							  'DefendNote'		=> $this->effective->set_chartype_ignore($this->char_mode, $this->strip_html_contents($defend_list[1][$index])),
							  'ActorBy'			=> $defend_list[2][$index],
							  'ActorName'		=> $this->effective->set_chartypes($this->char_mode, $this->strip_html_contents($defend_list[3][$index])),
							  'ActorDate'		=> date('Y-m-d H:i:s'),
							  'IsActive'		=> 'A'
						)
					);
					
				endif;
					
			}
			
			if(!empty($supplement[2])):
			
				array_push($objData,
					array('DocID'		=> $condition[0],
						  'DefendRef'	=> $condition[1],
						  'DefendCode'	=> 'SPE99',		
						  'DefendOther'	=> NULL,
						  'DefendNote'	=> $this->effective->set_chartype_ignore($this->char_mode, $this->strip_html_contents($supplement[0])),
						  'ActorBy'		=> $supplement[1],
						  'ActorName'	=> $this->effective->set_chartypes($this->char_mode, $this->strip_html_contents($supplement[2])),
						  'ActorDate'	=> date('Y-m-d H:i:s'),
						  'IsActive'	=> 'A'
					)
				);
			
			endif;
			
			if(!empty($lbcontent[2])):
				
				array_push($objData,
					array('DocID'		=> $condition[0],
						'DefendRef'		=> $condition[1],
						'DefendCode'	=> 'SLB99',
						'DefendOther'	=> NULL,
						'DefendNote'	=> $this->effective->set_chartype_ignore($this->char_mode, $this->strip_html_contents($lbcontent[0])),
						'ActorBy'		=> $lbcontent[1],
						'ActorName'		=> $this->effective->set_chartypes($this->char_mode, $this->strip_html_contents($lbcontent[2])),
						'ActorDate'		=> date('Y-m-d H:i:s'),
						'IsActive'		=> 'A'
					)
				);
				
			endif;
						
			if(!empty($objData[0]['DocID'])) {
				
				foreach($objData as $index => $value) {		
					
					if($objData[$index]['DefendNote'] == ""):
						continue;
					else:	
						
						if(empty($objData[$index]['ActorBy'])) {
							continue;
							
						} else {
							$this->dbmodel->exec('DefendSubscriptionLogs', $objData[$index], false, 'insert');
						}
						
					endif;
								
				}
				
			}
		
		}

	}
	
	public function setRetrieveOnbundled() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$doc_id 				= $this->input->post('docix');
		$app_no					= $this->input->post('appnx');
		
		$retrieve_reason		= $this->input->post('reasx');
		$retrieve_date			= $this->input->post('rdate');
		
		$result = $this->dbmodel->loadData('ApplicationStatus', 'ApplicationNo, CAName, CONVERT(NVARCHAR(10), CA_ReceivedDocDate, 120) AS CA_ReceivedDocDate', array('DocID' => $doc_id), false);

		if(!empty($app_no)) {
					
			if(!empty($result['data'][0]['CAName'])) {
				$this->dbmodel->exec('Retrieve_CATransactionLog',
				array(  'DocID' 		  => $doc_id,
						'CAName' 		  => !empty($result['data'][0]['CAName']) ? $result['data'][0]['CAName']:'',
						'CA_ReceivedDate' => !empty($result['data'][0]['CA_ReceivedDocDate']) ? $result['data'][0]['CA_ReceivedDocDate']:'',
						'CreateBy'		  => $this->effective->set_chartypes($this->char_mode, $this->name),
						'CreateDate'	  => date('Y-m-d H:i:s'),
						'ApplicationNo'	  => $app_no
				), false, 'insert');
	
			}
			
			$verification = array('RMProcess' => 'ระหว่างติดตามเอกสาร', 'RMProcessDate' => date('Y-m-d H:i:s'));
			$this->dbmodel->exec('Verification', $verification, array("DocID" => $doc_id, 'RMProcess' => null, 'RMProcessDate' => null), 'update');
			
			if($app_no === $result['data'][0]['ApplicationNo']) {
				$table_clearing = $this->dbmodel->exec('ApplicationStatus',
						array('CAName' 				=> NULL,
						 	  'CA_ReceivedDocDate' 	=> NULL,
							  'PreLoan' 			=> NULL,
							  'PreApprovedDate' 	=> NULL,
							  'Status' 				=> NULL,
							  'StatusDate' 			=> NULL,
							  'StatusReason' 		=> NULL,
							  'DiviateReason'		=> NULL,
							  'PreApproved' 		=> NULL,
							  'ApprovedLoan' 		=> NULL,
							  'TermYear' 			=> NULL,
							  'DrawdownDate' 		=> NULL,
							  'DrawdownType' 		=> NULL,
							  'DrawdownBaht' 		=> NULL,
							  'Diff' 				=> NULL,
							  'CountDay' 			=> NULL,
							  'IsActive' 			=> 'A',
							  'ChangeBy' 			=> NULL,
							  'ChangeDate' 			=> NULL,
							  'PlanDrawdownDate'  	=> NULL,
							  'PlanDateUnknown' 	=> NULL,
							  'DrawdownReservation' => NULL,
							  'ReceivedContactDate' => NULL,
							  'AFCancelReason' 		=> NULL,
							  'AFCancelReasonOther' => NULL,
							  'ContactRemark' 		=> NULL,
							  'IsEnabled' 			=> 'A'
						),
						array("DocID" => $doc_id), 'update');
					
			} else {
				$table_clearing = $this->dbmodel->exec('ApplicationStatus',
					array('ApplicationNo' 		=> $app_no,
						  'CAName' 				=> NULL,
						  'CA_ReceivedDocDate' 	=> NULL,
						  'ApproverName' 		=> NULL,
						  'PreLoan' 			=> NULL,
						  'PreApprovedDate' 	=> NULL,
						  'Status' 				=> NULL,
						  'StatusDate' 			=> NULL,
						  'StatusReason' 		=> NULL,
						  'DiviateReason'		=> NULL,
						  'PreApproved' 		=> NULL,
						  'ApprovedLoan' 		=> NULL,
						  'TermYear' 			=> NULL,
						  'DrawdownDate' 		=> NULL,
						  'DrawdownType' 		=> NULL,
						  'DrawdownBaht' 		=> NULL,
						  'Diff' 				=> NULL,
						  'CountDay' 			=> NULL,
						  'IsActive' 			=> 'A',
					      'ChangeBy' 			=> NULL,
						  'ChangeDate' 			=> NULL,
						  'PlanDrawdownDate'  	=> NULL,
						  'PlanDateUnknown' 	=> NULL,
						  'DrawdownReservation' => NULL,
						  'AppComment' 		    => NULL,
						  'ReceivedContactDate' => NULL,
						  'AFCancelReason' 		=> NULL,
						  'AFCancelReasonOther' => NULL,
						  'ContactRemark' 		=> NULL,
						  'IsEnabled' 			=> 'A'
					),
					array("DocID" => $doc_id), 'update');
			}
				
		}

		if(!empty($doc_id)) {
						
			$write_logs = $this->dbmodel->exec('Retrieve_TransactionLog',
				array(
					'DocID'				=> $doc_id,
					"EmployeeCode"		=> $this->emp_id,
					'RetrieveCode'		=> $retrieve_reason,
					"EventDate"			=> $this->effective->StandartDateSorter($retrieve_date),
					"EventTime"			=> date('H:i:s'),
					"RetrieveToNewDoc"  => $doc_id,
					"IsActive"			=> 'A'
				), false, 'insert');
			
		} 
		
		if($table_clearing == TRUE && $write_logs == TRUE):		
			$this->dbmodel->exec('DocumentErrorTracker', array('IsActive' => 'N'), array('DocID' => $doc_id), 'update');
			$this->dbmodel->exec('DocumentErrorSubList', array('IsActive' => 'N'), array('DocID' => $doc_id), 'update');
		
			echo json_encode(array('status' => true, 'msg' => 'save successfully.'));
		else:
			echo json_encode(array('status' => true, 'msg' => 'save failed.'));
		endif;
		
	}
	
	private function writeDataLogs($logs) {
		$this->load->model('dbmodel');
		
		foreach($logs as $index => $values) {
			$this->dbmodel->exec('DefendEventHandled', $logs[$index], false, 'insert');
		}
		
	}
	
	private function getBorrowerNameRelation($doc_id, $borrow_type) {
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
	
	private function strip_html_contents($string) {
		$str = strip_tags(preg_replace('/<[^>]*>/', '', html_entity_decode($string, ENT_QUOTES)));
		return $str;
	}

	private function getDataCAInfo($ca_name) {
		$this->load->model('dbmodel');
	
		if(!empty($ca_name)) :
			$result = $this->dbmodel->CIQuery("SELECT * FROM MasterCA_Name WHERE TH_NAME LIKE '%".$ca_name."%'");
			return $result;
		endif;
	
	}
	
	private function getGroupSFEList() {
		$this->load->model('dbstore');
	
		$data	= array();
		$result = $this->dbstore->exec_getGroupSFEList();
		foreach($result as $index => $values) {
			array_push($data, $result[$index]['EmployeeCode']);
	
		}
	
		return $data;
	
	}
	
	private function getSFEDataList() {
		$this->load->model('dbstore');
	
		$data	= array();
		$result = $this->dbstore->exec_getGroupSFEList();
		foreach($result as $index => $values) {
			array_push($data,
				array(
				    "EmployeeCode" => $result[$index]['EmployeeCode'],
				    "FullNameTh"	 => @$this->effective->get_chartypes($this->char_mode, $result[$index]['FullNameTh'])
				)
			);

		}
	
		return $data;
	
	}
	
	private function setEmployeeRelation($position, $condition = array()) {
		$this->load->model('dbmanagement');
		$result = $this->dbmanagement->getEmployeeRelation($position, $condition);
	
		return $result;
	
	}
	
	private function getCreateActor($doc_id, $list_lot) {
		$this->load->model('dbmanagement');
	
		if(empty($doc_id)):
			return;
		else:
			$result = $this->dbmanagement->getActorInfo($doc_id, $list_lot);
			return $result;
		endif;
	
	}
	
	private function getDefendHelper($doc_id) {
	
		if(empty($doc_id)):
			return;
		else:
			$result = $this->dbmanagement->getDefendListHelper($doc_id);
			return $result;
		endif;
	
	
	}
	
	private function setDefendNoteLists($doc_id, $list_lot) {
		$this->load->model('dbmanagement');
	
		if(empty($doc_id) || empty($list_lot)):
			return;
		else:	
			$result = $this->dbmanagement->getDefendItemList($doc_id, $list_lot);
			return $result;	
		endif;
	
	}
	
	private function setDefendNoteOther($doc_id, $list_ref) {
		$this->load->model('dbmodel');
	
		if(empty($doc_id) || empty($list_ref)):
			return;
		else:
			$result = $this->dbmodel->loadData('DefendHead', "CASE DefendDate WHEN '1900-01-01' THEN '' ELSE CONVERT(nvarchar(10), DefendDate, 120) END AS DefendDate, DefendSubject, DefendSupplement, LBRemark, CreateBy, CASE CreateDate WHEN '1900-01-01' THEN '' ELSE CONVERT(nvarchar(10), CreateDate, 120) END AS CreateDate, UpdateBy, RIGHT(CONVERT(VARCHAR(20), UpdateDate, 113), 8) AS UpdateTime, CASE UpdateDate WHEN '1900-01-01' THEN '' ELSE CONVERT(nvarchar(10), UpdateDate, 120) END AS UpdateDate, LastUpdateBy, CASE LastUpdateDate WHEN '1900-01-01' THEN '' ELSE CONVERT(nvarchar(10), LastUpdateDate, 120) END AS LastUpdateDate, RIGHT(CONVERT(VARCHAR(20), LastUpdateDate, 113), 8) AS LastUpdateTime", array("DocID" => $doc_id, "DefendRef" => $list_ref), false);
			return $result;		
		endif;
	}
	
	private function setDefendListLogs($doc_id, $list_lot) {
		$this->load->model('dbmanagement');
	
		if(empty($doc_id) || empty($list_lot)):
			return;
		else:			
			$result = $this->dbmanagement->getDefenListLogs($doc_id, $list_lot);
			return $result;
		endif;
	}
	
	// Load Data And Convert
	private function getCustomerInformation($doc_id) {
		$result		= $this->dbstore->exec_getCustomerInformation($doc_id);
		if(!empty($result)) {
				
			$data = array(
					'DocID'   	 		 => $result[0]['DocID'],
					'CustType'   		 => $result[0]['CustType'],
					'Interest'  		 => $result[0]['Interest'],
					'SourceOfCustomer'   => @$this->effective->get_chartypes($this->char_mode, $result[0]['SourceOfCustomer']),
					'SourceOption'  	 => @$this->effective->get_chartypes($this->char_mode, $result[0]['SourceOption']),
					'CSPotential' 		 => $result[0]['CSPotential'],
					'OwnerType'   		 => $result[0]['OwnerType'],
					'PrefixName'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['PrefixName']),
					'OwnerName'   		 => $this->effective->get_chartypes($this->char_mode, $result[0]['OwnerName']),
					'BorrowerName'   	 => !empty($result[0]['BorrowerName']) ? @$this->effective->get_chartypes($this->char_mode, $result[0]['BorrowerName']):'',
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
	
}