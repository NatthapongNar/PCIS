<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File_upload extends MY_Controller {
	
	protected $sessid;
	protected $emp_id;
	protected $email;
	protected $name, $engname, $bm;
	protected $position;
	protected $branch;
	protected $branch_code;
	protected $region_id;
	protected $region;
	protected $region_th;
	protected $authorized ;
	protected $is_logged_in;
	
	protected $path_upload;
	
	public function __construct() {
		parent::__construct();
	
		$this->sessid       = $this->session->userdata("session_id");
		$this->uhash        = substr($this->session->userdata("uhash"), 6);
	
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
		
		//$this->path_upload	 = $_SERVER["DOCUMENT_ROOT"].'/pcis/upload/';
		$this->path_upload	 = 'D:/pcis_file_uploads/';
	
		// Object: Session Enrolled.
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

		if(empty($this->authorized[0])) {
			redirect('authen/logout');
		}
		
	}
	
	public function testFileUploader() {
		$this->load->model('dbmodel');
		$this->load->library('uploader');
		
		date_default_timezone_set("Asia/Bangkok");
		
		header('Content-Type: application/json; charset="UTF-8"');
		
		$files 			= !empty($_FILES["file"]) ? $_FILES["file"]:null;
		print_r($files);		
		
	}
	
	public function setFileUploader() {
		$this->load->model('dbmodel');
		$this->load->library('uploader');
		$this->load->library('effective');
		
		date_default_timezone_set("Asia/Bangkok");
		
		header('Content-Type: application/json; charset="UTF-8"');
		
		$files 			= !empty($_FILES["file"]) ? $_FILES["file"]:null;

		$doc_id 		= $this->input->post('rel');
		$defend_ref 	= $this->input->post('ref');
		$defend_code 	= $this->input->post('cox');
		$defend_primary	= $this->input->post('pri');
		
		$uploader = new Uploader();
		$data = $uploader->upload($_FILES['file'], array(
				'limit' 	 	=> 100,
				'maxSize' 	 	=> 100000000,
				'extensions' 	=> null,
				'required' 	 	=> false,
				'uploadDir'  	=> $this->path_upload,
				'title' 		=> array('name'),
				'removeFiles' 	=> true, 
				'perms' 		=> null,
				'onCheck' 		=> null,
				'onError' 		=> null,
				'onSuccess' 	=> null,
				'onUpload' 		=> null,
				'onComplete' 	=> null,
				'onRemove' 		=> 'onFilesRemoveCallback'
			)
		);		

		if($data['hasErrors']) {
			$errors = $data['errors'];
			echo json_encode(array('status' => false, 'msg'	=> $errors));
			
		} else {
			
			if($data['isComplete']){
				$files = $data['data'];
				
				$data_upload = array(
						'DocID'		 	 => $doc_id,
						'DefendRef'  	 => $defend_ref,
						'DefendCode' 	 => $defend_code,
						'Files'		 	 => $this->effective->set_chartypes($this->char_mode, $files['metas'][0]['file']),
						'File_Name'	 	 => $this->effective->set_chartypes($this->char_mode, $files['metas'][0]['name']),
						'File_Reference' => $files['metas'][0]['re_name'],
						'Extension'	 	 => $files['metas'][0]['extension'],
						'CreateBy'	 	 => $this->effective->set_chartypes($this->char_mode, $this->name),
						'CreateDate' 	 => date('Y-m-d H:i:s'),
						'NumRef' 		 => !empty($defend_primary) ? $defend_primary:NULL,
						'IsActive'	 	 => 'A'
				);
					
				$success 	= $this->dbmodel->exec('DefendUploads', $data_upload, false, 'insert');

				if($success):	
				
					/*
					$condition  = '';
					if(in_array($defend_code, array('SLB99', 'SPE99'))):
						$condition = " AND DefendCode = '".$defend_code."'";
					else:
						$condition = " AND NumRef = '".$defend_primary."'";
					endif;
					*/
				
					$file_amount = $this->dbmodel->CIQuery("
						SELECT COUNT(DocID) [File_Amt] 
						FROM [DefendUploads]
						WHERE [DocID] = '".$doc_id."'
						AND [DefendRef] = '".$defend_ref."'
						AND IsActive = 'A'
					");
				
					echo json_encode(
						array('status'   => true, 
							  'msg' 	 => 'Upload Successfully.',
							  'files' 	 => $files['metas'][0]['name'],
							  're_name'	 => $files['metas'][0]['re_name'],
							  'uploadon' => date('Y-m-d H:i:s'),
							  'amt'		 => !empty($file_amount['data'][0]['File_Amt']) ? $file_amount['data'][0]['File_Amt']:'',
							  'answer' => 'File transfer completed'
						)
					);
				else:
					echo json_encode(array('status' => false, 'msg' => 'Upload Failed.', 'files' => '', 'uploadon' => '', 'amt' => ''));
				endif;
					
			}
			
		}
		
	}
	
	public function getFileInformation() {
		$this->load->model('dbstore');
	
		header('Content-Type: application/json; charset="UTF-8"');
		
		$doc_id 		= $this->input->post('rel');
		$defend_ref 	= $this->input->post('ref');
		$defend_code 	= $this->input->post('doc');
		
		if(!empty($doc_id) && !empty($defend_ref) && !empty($defend_code)) {
			$result = $this->dbstore->getFileDetails($doc_id, $defend_ref, $defend_code);
			if(!empty($result['data'][0]['DefendCode'])):
				echo json_encode(
					array(
							'progress' => true,
							'status'   => true,
							'msg' 	   => 'Inquiry successfully',
							'data'     => $result['data']
					)
				);
			else: 
				echo json_encode(
					array(
							'progress' => true,
							'status'   => false,
							'msg' 	   => 'Data not found',
							'data'     => null
					)
				);
			endif;
			
		} else {
			echo json_encode(
				array(
					'progress' => true,
					'status'   => false,
					'msg' 	   => 'Please try again check your parameter.',
					'data'     => null
				)
			);
		}
		
	}
	
	public function fileReadState() {	
		$this->load->model('dbmodel');
		
		$file_ref  = $this->input->post('refx');
		
		if(!empty($file_ref)) {
			$success 	= $this->dbmodel->exec('DefendUploads', array('FileState' => 'Y'), array('RowID' => $file_ref), 'update');
			if($success):
				echo $this->json_parse(array('status' => true, 'msg' => 'Saved Successfully'));
			else:
				echo $this->json_parse(array('status' => false, 'msg' => 'Saved Failed'));
			endif;
			
		} else { echo $this->json_parse(array('status' => false, 'msg'	=> 'Please check parameter try again.')); }
		
	}
	
	protected function makedirs($dirpath, $mode = 0777) {
		return is_dir($dirpath) || mkdir($dirpath, $mode, true);
	}
	
	public function onFilesRemoveCallback($removed_files){
		foreach($removed_files as $key=>$value){
			$file = $this->path_upload . $value;
			if(file_exists($file)){
				unlink($file);
			}
		}
	
		return $removed_files;
		
	}
	
	public function removeFile() {		
		$file	= $this->input->post('file');		
		if(isset($file)):
			$path_file = $this->path_upload . $file;
			if(file_exists($path_file)):
				unlink($path_file);
			endif;
		endif;
	}
	
	public function fnDelete_files() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		$file_ref	   = $this->input->post('refx');
		if(!empty($file_ref)) {
			
			$unfile = $this->dbmodel->exec('DefendUploads', array('IsActive' => 'N'), array('RowID' => $file_ref), 'update');	
			if($unfile == TRUE):
				
				$this->dbmodel->exec('DefendDeleteFileLog',
				array('Row_Ref' 	=> $file_ref,
					  'CreateBy'	=> $this->effective->set_chartypes($this->char_mode, $this->name),
					  'CreateDate'	=> date('Y-m-d H:i:s')
				), false, 'insert');
				
				$this->json_parse(array('status' => true, 'msg' => 'ลบข้อมูลสำเร็จ.'));
				
			else:
				$this->json_parse(array('status' => false, 'msg' => 'เกิดข้อผิดพล กรุณาลองใหม่อีกครั้ง.'));
			endif;
		}
	
	}
	
	private function json_parse($objArr) {
		header("Content-type: application/json");
		echo json_encode($objArr);
	}

}