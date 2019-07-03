<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Referral_control extends MY_Controller {
	
	public $pages_default;
	public $pages_customiz;
	
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
		
		$this->role_ads 	 = $this->config->item('ROLE_ADMINSYS');

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
		
		$this->pages_default	= "frontend/metro";
		$this->pages_customiz	= "frontend/content/pages/";

		if(empty($this->authorized[0])) {
			redirect('authen/logout');
		}
		
	}
	
	public function index() {

		$this->pages  = "referral/refer_main";
		$this->_renders($this->pages_default, 'customiz');
		
	}
	
	public function getTLAMangement() {
		
	
		$this->pages  = "referral/refer_management";
		
		$version 	  = $this->config->item('ref_mangement');
		$this->data['stylesheet'] = array('../js/dataTables/extensions/Responsive/css/dataTables.responsive', 'animate/animate.min', 'notifIt/notifIt', 'multi-select/multiple-select', 'kalendea/kalendae');
		$this->data['javascript'] = array('dataTables/media/js/jquery.dataTables.min', 'build/referral_script/referral_mainscript.js' . $version, 'plugin/notifIt/notifIt', 'vendor/jquery.multiple.select', 'kalendea/kalendae.standalone.min');	
		
		$this->_renders($this->pages_default, 'customiz');
		
	}
	
	public function getReferVolume() {
		
		$this->pages  = "referral/refer_volume";
		
		$version 	  = $this->config->item('ref_dashboard');
		$this->data['stylesheet'] = array('../js/dataTables/extensions/Responsive/css/dataTables.responsive', 'animate/animate.min', 'notifIt/notifIt', 'multi-select/multiple-select', 'kalendea/kalendae');
		$this->data['javascript'] = array('dataTables/media/js/jquery.dataTables.min', 'build/referral_script/referral_volumescript.js' . $version, 'plugin/notifIt/notifIt', 'vendor/jquery.multiple.select', 'kalendea/kalendae.standalone.min');
		
		$this->_renders($this->pages_default, 'customiz');
		
	}
	
	public function cropSimulator() {
		$this->pages  = "referral/refer_cropimg";
		$this->load->view($this->pages_customiz.$this->pages, $this->data);
		
	}
	
	public function getTLADataComponent() {	
		$this->load->model('dbreferral');
		$this->load->library('effective');
		
		header('Content-Type: text/html; charset="UTF-8"');
		$authoriy_tl = $this->config->item('TLAgentTeam');
		
		try {
							
			$results = $this->dbreferral->getDataTLATransaction($this->authorized, array($this->emp_id));
			$iTotal  = $this->dbreferral->getDataTLATransactionPagination($this->authorized, array($this->emp_id));
			
			foreach($results['data'] as $index => $value) {

				$tla_name  	 = !empty($results['data'][$index]['TLA_Name']) ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['TLA_Name']):'';				
				$branchs   	 = !empty($results['data'][$index]['LB_BranchName']) ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['LB_BranchName']):'';
 				$brn_tel   	 = !empty($results['data'][$index]['BranchTel']) ?  $branchs . ' (' . $results['data'][$index]['BranchTel'] . ')':'';
 				
 				$nickname  	 = !empty($results['data'][$index]['Nickname']) ? 'คุณ' . $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['Nickname']):'';
 				$bm_mobile 	 = !empty($results['data'][$index]['BMMobile']) ? $nickname . ' ('. $results['data'][$index]['BMMobile'] .')':'';
 				
 				$mobile	   	 = !empty($results['data'][$index]['TLA_Mobile']) ? $this->effective->str_replace_assoc(array('-' => '', '/' => ' / ', ',' => ' / '), $results['data'][$index]['TLA_Mobile']):'';
 				
 				//class="badge fg-white" style="margin-top: 6px;"
 				if(strlen($mobile) > 10):
 					$sup_text	= '<sup>2</sup>';
 				else:
 					$sup_text	= '';	
 				endif; 				
 				
 				if(in_array(trim($this->emp_id), $authoriy_tl)):
 					$tools = '<i class="fa fa-edit icon_set editor" data-value="'.$results['data'][$index]['TL_ID'].'"></i>';
 				else:
 					$tools = '<i class="fa fa-close fg-red icon_set"></i>';
 				endif;
 				
 				if(!empty($results['data'][$index]['RMName'])):			
 					$extract 	= preg_match('/,/', $results['data'][$index]['RMName']) ? explode(',', $results['data'][$index]['RMName']):array($results['data'][$index]['RMName']);
 					$name_hide	= preg_match('/,/', $results['data'][$index]['RMName']) ? '...':'';
 				else:
 					$extract = array('');
 					$name_hide	= '';
 				endif;
 				
 				$expired_list	= '';
 				$expired_flag	= '';
 				if($results['data'][$index]['IDExpired']):
	 				$expired_flag = 'fg-amber';
	 				$expired_list = '(ID Card Expired)';
 				endif;
 					
 				if($results['data'][$index]['TLExpired']):
	 				$expired_flag = 'fg-darkBlue';
	 				$expired_list = '(TL Card Expired)';
 				endif;
 					
 				if($results['data'][$index]['IDExpired'] && $results['data'][$index]['TLExpired']):
	 				$expired_flag = 'fg-red';
	 				$expired_list = '(ID & TL Card Expired)';
 				endif;
 					
 				$lb_branch	  = !empty($results['data'][$index]['BranchName']) ? $this->effective->get_chartypes($results['data'][$index]['BranchName']):'';
 				$lb_branchTel = !empty($results['data'][$index]['BranchTel']) ? ' (' . $results['data'][$index]['BranchTel'] . ')':'-';
 				$tl_branchTel = !empty($results['data'][$index]['TLA_BranchTel']) ? $results['data'][$index]['TLA_BranchTel']:'-';
 				
 				$columns[] = array(
 						"JoinDate" 	 			=> $this->effective->StandartDateRollback($results['data'][$index]['JoinDate']),
 						"Period"				=> $this->effective->period($results['data'][$index]['JoinDate'], $results['data'][$index]['TLA_Status']),
 						"Seq"		 			=> self::setStatusColorRender($results['data'][$index]['TLA_Status']),
 						"TLA_Code"				=> $results['data'][$index]['TLA_Code'],
 						"TLA_Name"	 			=> '<span class="tooltip-top '.$expired_flag.'" data-tooltip="'.$tla_name.' '.$expired_list.'">'.$tla_name.'</span>',
 						"TLA_Mobile"			=> !empty($results['data'][$index]['TLA_Mobile']) ? '<div class="tooltip-top" data-tooltip="'. $mobile .'">'. substr(str_replace('-', '', $results['data'][$index]['TLA_Mobile']), 0, 10) .' '. $sup_text . '</div>':'',
 						"TLA_Position"	 		=> !empty($results['data'][$index]['TLA_Position']) ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['TLA_Position']):'',
 						"TLA_Branch"	 		=> !empty($results['data'][$index]['TLA_BranchName']) ? '<div class="tooltip-top" data-tooltip="'. $tl_branchTel .'">'. $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['TLA_BranchName']) . '</div>':'',
 						"RegionNameEng"		 	=> $results['data'][$index]['RegionNameEng'],
 						"BranchDigit"	 		=> !empty($results['data'][$index]['BranchDigit']) ? '<div class="tooltip-top" data-tooltip="' . $lb_branch . $brn_tel . '">'. $results['data'][$index]['BranchDigit'] .'</div>':'',
 						"BMName"	 			=> !empty($results['data'][$index]['BMName']) ? '<div class="tooltip-top" data-tooltip="' . $bm_mobile . '">'. $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['BMName']) .'</div>':'',
 						//"RMName"				=> !empty($extract) ? '<div class="tooltip-left" data-tooltip="' . $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['RMName']) . '">'. $this->effective->get_chartypes($this->char_mode, $extract[0]) . $name_hide .'</div>':'',
 						"LastUpdate"			=> $this->effective->StandartDateRollback($results['data'][$index]['UpdateDate']),
 						'Editor'				=> $tools
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
	
	private static function setStatusColorRender($status) {
		
		switch($status) {
			case 'Active':
			case 'Active_DD':
				return '<span style="color: #599e14;">' . $status. '</span>'; 
				break;
			default:
				return $status; 
				break;
					
					
		}
		
	}
	
	public function setDataInitialize() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$tl_code 		= $this->input->post('tl_code');
		$tl_name 		= $this->input->post('tl_name');
		$tl_position 	= $this->input->post('tl_position');
		$tl_po_short 	= $this->input->post('tl_pos_short');		
		$tl_mobile_1 	= $this->input->post('tl_mobile_1');
		$tl_mobile_2 	= $this->input->post('tl_mobile_2');
		$tl_branchname 	= $this->input->post('tl_branch');
		$tl_branchtel 	= $this->input->post('tl_branch_tel');
		$tl_region 		= $this->input->post('region_id');
		$tl_branchcode 	= $this->input->post('branch_code');
		$tl_code_ref1 	= $this->input->post('ref1_code');
		//$tl_code_ref2 	= $this->input->post('ref2_code');
		$tl_name_ref1 	= $this->input->post('tl_ref1');		
		$tl_name_ref2 	= $this->input->post('tl_ref2');
		$tl_register 	= $this->input->post('registerdate');
		$tl_status	 	= $this->input->post('tl_status');
		$bank_name		= $this->input->post('bank_name');
		$bank_acct		= $this->input->post('bank_acct');
		$expired_date	= $this->input->post('expired_date');
		$expired_idcard	= $this->input->post('expired_idcard');
		$remark			= $this->input->post('remark_text');
		
		$id_card		= $this->input->post('id_card');
		$tl_card		= $this->input->post('tl_card');
		
		$tl_address		= $this->input->post('tl_address');
		$tl_envelope	= $this->input->post('tl_envelope');
		$tl_channel		= $this->input->post('tl_channel');
		
		if(empty($tl_code)) {
			self::json_parse(array('status'	=> false, 'msg' => 'The occurrence handled exception in passing parameter..'));
			
		} else {
			
			$conv = array();
			if(!empty($tl_name_ref2)) {
			
				foreach ($tl_name_ref2 as $index => $value) {
					array_push($conv, explode('|', $tl_name_ref2[$index]));
				}
					
			}
			
			$rm_code = array();
			$rm_name = array();
			if(!empty($conv[0])) {
				
				foreach ($conv as $index => $value) {
					array_push($rm_code, $conv[$index][0]);
					array_push($rm_name, $conv[$index][1]);
				}
				
			}
			
			$object_data 	= array(
					"TLA_Code"    		=> $tl_code,
					"TLA_Name" 			=> trim($this->effective->set_chartypes($this->char_mode, $tl_name)),
					"TLA_Position" 		=> !empty($tl_position) ? $this->effective->set_chartypes($this->char_mode, $tl_position):NULL,
					"TLA_PositionShort" => !empty($tl_position) ? $this->effective->set_chartypes($this->char_mode, $tl_po_short):NULL,
					"TLA_Mobile" 		=> $tl_mobile_1,		
					"TLA_Mobile_2" 		=> $tl_mobile_2,
					"TLA_BranchName" 	=> !empty($tl_branchname) ? $this->effective->set_chartypes($this->char_mode, $tl_branchname):NULL,
					"TLA_BranchTel" 	=> !empty($tl_branchtel) ? $tl_branchtel:NULL,
					"LB_RegionID" 		=> !empty($tl_region) ? $tl_region:NULL,
					"LB_BranchCode" 	=> !empty($tl_branchcode) ? $tl_branchcode:NULL,
					"LB_Ref01_Code" 	=> !empty($tl_code_ref1) ? $tl_code_ref1:NULL,		
					"LB_Ref01" 			=> !empty($tl_name_ref1) ? $this->effective->set_chartypes($this->char_mode, $tl_name_ref1):NULL,
					"LB_Ref02_Code" 	=> !empty($rm_code[0]) ? implode(',', $rm_code):NULL,
					"LB_Ref02" 			=> !empty($rm_name[0]) ? $this->effective->set_chartypes($this->char_mode, implode(',', $rm_name)):NULL,
					"TLA_Status" 		=> $tl_status,
					"CreateDate" 		=> date('Y-m-d H:i:s'),
					"CreateBy" 			=> $this->effective->set_chartypes($this->char_mode, $this->name),					
					"JoinDate" 			=> $this->effective->StandartDateSorter($tl_register).' '.date('H:i:s'),
					"ExpiredDate"		=> !empty($expired_date) ? $this->effective->StandartDateSorter($expired_date):NULL,
					"IDCardExpired"		=> !empty($expired_idcard) ? $this->effective->StandartDateSorter($expired_idcard):NULL,
					"Bank_Code"			=> !empty($bank_name) ? $bank_name:NULL,
					"AcctNo"			=> !empty($bank_acct) ? $bank_acct:NULL,
					"Remark"			=> !empty($remark) ? $this->effective->set_chartypes($this->char_mode, $remark):NULL,
					"IDCard"			=> !empty($id_card) ? $id_card:NULL,
					"TLCard"			=> !empty($tl_card) ? $tl_card:NULL,
					"TLA_Address"		=> !empty($tl_address) ? $tl_address:NULL,
					"SentEnvelope"		=> !empty($tl_envelope) ? $tl_envelope:NULL,
					"TL_Channel"		=> !empty($tl_channel) ? $tl_channel:NULL
			);
			
			$result	= $this->dbmodel->exec('MasterTLA', $object_data, false, 'insert');		
			if($result == TRUE):
				self::json_parse(array('status'	=> true, 'msg' => 'The data bundled successfully.'));
			else:
				self::json_parse(array('status'	=> false, 'msg' => 'the data bundled failed.'));
			endif;
			
		}

	}
	
	public function setUpdateInitializeData() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		$tl_id			= $this->input->post('tl_id');
		$tl_code 		= $this->input->post('tl_code');
		$tl_name 		= $this->input->post('tl_name');
		$tl_position 	= $this->input->post('tl_position');
		$tl_po_short 	= $this->input->post('tl_pos_short');
		$tl_branchname 	= $this->input->post('tl_branch');
		$tl_branchtel 	= $this->input->post('tl_branch_tel');
		$tl_mobile_1 	= $this->input->post('tl_mobile_1');
		$tl_mobile_2 	= $this->input->post('tl_mobile_2');
		$tl_region 		= $this->input->post('region_id');
		$tl_branchcode 	= $this->input->post('branch_code');
		$tl_code_ref1 	= $this->input->post('ref1_code');		
		$tl_name_ref1 	= $this->input->post('tl_ref1');
		//$tl_code_ref2 	= $this->input->post('ref2_code');
		$tl_name_ref2 	= $this->input->post('tl_ref2');
		$tl_register 	= $this->input->post('registerdate');
		$tl_status	 	= $this->input->post('tl_status');
		$bank_name		= $this->input->post('bank_name');
		$bank_acct		= $this->input->post('bank_acct');
		$expired_date	= $this->input->post('expired_date');
		$expired_idcard	= $this->input->post('expired_idcard');
		$remark			= $this->input->post('remark_text');
		
		$id_card		= $this->input->post('id_card');
		$tl_card		= $this->input->post('tl_card');
		
		$tl_address		= $this->input->post('tl_address');
		$tl_envelope	= $this->input->post('tl_envelope');
		$tl_channel		= $this->input->post('tl_channel');
	
		if(empty($tl_code)) {
			self::json_parse(array('status'	=> false, 'msg' => 'The occurrence handled exception in passing parameter..'));
				
		} else {
			
			$conv = array();
			if(!empty($tl_name_ref2)) {
					
				foreach ($tl_name_ref2 as $index => $value) {
					array_push($conv, explode('|', $tl_name_ref2[$index]));
				}
					
			}
				
			$rm_code = array();
			$rm_name = array();
			if(!empty($conv[0])) {
			
				foreach ($conv as $index => $value) {
					array_push($rm_code, $conv[$index][0]);
					array_push($rm_name, $conv[$index][1]);
				}
			
			}
				
			$object_data 	= array(
					"TLA_Code"			=> $tl_code,
					"TLA_Name" 			=> trim($this->effective->set_chartypes($this->char_mode, $tl_name)),
					"TLA_Position" 		=> !empty($tl_position) ? $this->effective->set_chartypes($this->char_mode, $tl_position):NULL,
					"TLA_PositionShort" => !empty($tl_position) ? $this->effective->set_chartypes($this->char_mode, $tl_po_short):NULL,					
					"TLA_Mobile" 		=> $tl_mobile_1,		
					"TLA_Mobile_2" 		=> $tl_mobile_2,
					"TLA_BranchName" 	=> !empty($tl_branchname) ? $this->effective->set_chartypes($this->char_mode, $tl_branchname):NULL,
					"TLA_BranchTel" 	=> !empty($tl_branchtel) ? $tl_branchtel:NULL,
					"LB_RegionID" 		=> !empty($tl_region) ? $tl_region:NULL,
					"LB_BranchCode" 	=> !empty($tl_branchcode) ? $tl_branchcode:NULL,
					"LB_Ref01_Code" 	=> !empty($tl_code_ref1) ? $tl_code_ref1:NULL,					
					"LB_Ref01" 			=> !empty($tl_name_ref1) ? $this->effective->set_chartypes($this->char_mode, $tl_name_ref1):NULL,
					"LB_Ref02_Code" 	=> !empty($rm_code[0]) ? implode(',', $rm_code):NULL,
					"LB_Ref02" 			=> !empty($rm_name[0]) ? $this->effective->set_chartypes($this->char_mode, implode(',', $rm_name)):NULL,
					"TLA_Status" 		=> $tl_status,
					"UpdateBy" 			=> $this->effective->set_chartypes($this->char_mode, $this->name),
					"UpdateDate" 		=> date('Y-m-d H:i:s'),
					"JoinDate" 			=> $this->effective->StandartDateSorter($tl_register).' '.date('H:i:s'),
					"Bank_Code"			=> !empty($bank_name) ? $bank_name:NULL,
					"AcctNo"			=> !empty($bank_acct) ? $bank_acct:NULL,
					'ExpiredDate'		=> !empty($expired_date) ? $this->effective->StandartDateSorter($expired_date):NULL,
					"IDCardExpired"		=> !empty($expired_idcard) ? $this->effective->StandartDateSorter($expired_idcard):NULL,
					'Remark'			=> !empty($remark) ? $this->effective->set_chartypes($this->char_mode, $remark):NULL,
					'IDCard'			=> !empty($id_card) ? $id_card:NULL,
					'TLCard'			=> !empty($tl_card) ? $tl_card:NULL,
					"TLA_Address"		=> !empty($tl_address) ? $tl_address:NULL,
					"SentEnvelope"		=> !empty($tl_envelope) ? $tl_envelope:NULL,
					"TL_Channel"		=> !empty($tl_channel) ? $tl_channel:NULL
			);  
			
			$result	= $this->dbmodel->exec('MasterTLA', $object_data, array("TL_ID" => $tl_id), 'update');
		
			if($result == TRUE):
				self::json_parse(array('status'	=> true, 'msg' => 'The data bundled successfully.'));
			else:
				self::json_parse(array('status'	=> false, 'msg' => 'the data bundled failed.'));
			endif;
			
		}
	
	}

	public function getTLAVolumeList() {
		$this->load->model('dbstore');
		$this->load->model('dbreferral');
		$this->load->library('effective');
		
		/*
		$filter_type	= $this->input->post('filter_type');
		$start_date		= $this->input->post('start_date');
		$end_date 		= $this->input->post('end_date');

		$set_font 		= self::setValueColor($filter_type, array($start_date, $end_date));
		*/
		
		try {
									
			$result = $this->dbreferral->getDataTLAVolume($this->authorized, array($this->emp_id));	
			$paging = $this->dbreferral->exec_getTLAVolumePagination($this->authorized, array($this->emp_id));
			$iTotal = count($paging['data']);
			
			foreach($result['data'] as $index => $value) {
				
				$tl_name				= !empty($result['data'][$index]['TLA_Name']) ? $this->effective->str_replace_assoc(array('นางสาว' => '', 'นาง' => '', 'น.ส.' => '', 'นาย' => '', 'คุณ' => ''), $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['TLA_Name'])):'';
				$tl_mobile			= !empty($result['data'][$index]['TLA_Mobile']) ? ' (' . $result['data'][$index]['TLA_Mobile'] . ')':'';
				$tl_branch_tel		= !empty($result['data'][$index]['TLA_BranchTel']) ? $result['data'][$index]['TLA_BranchTel']:'-';
				$branch_tel  		= !empty($result['data'][$index]['BranchTel']) ?  ' (' . $result['data'][$index]['BranchTel'] . ')':'-';					
				$assign_nickname  	= !empty($result['data'][$index]['AssignNickname']) ? 'คุณ'.$this->effective->get_chartypes($this->char_mode, $result['data'][$index]['AssignNickname']):'-';
				$assign_tel  		= !empty($result['data'][$index]['AssignMobile']) ? ' (' . $result['data'][$index]['AssignMobile'] . ')':'-';
				$branch_name 		= !empty($result['data'][$index]['BranchName']) ? $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['BranchName']):'';
				
				$approved_total		= ($result['data'][$index]['ApprovedTotal'] > 0) ? $result['data'][$index]['ApprovedTotal']:0;
				$reject_total		= ($result['data'][$index]['RejectTotal']  > 0) ? $result['data'][$index]['RejectTotal']:0;
				
				$tooltip_text		= 'Approved ' . $approved_total . ', Reject ' . $reject_total;
				
				$total_drawdown		= !empty($result['data'][$index]['DD_Total']) ? number_format($result['data'][$index]['DD_Total'], 0):'';
				
				$tla_code = $result['data'][$index]['TLA_Code'];
				if($tla_code = '00781431') {
					
				}

				$columns[] = array(
					"JoinDate"		 => !empty($result['data'][$index]['JoinDate']) ? $this->effective->StandartDateRollback($result['data'][$index]['JoinDate']):'',					
					"SLA"			 => $this->effective->period($result['data'][$index]['JoinDate'], $result['data'][$index]['TLA_Status']),
					"Seq"	 		 => self::setStatusColorRender($result['data'][$index]['TLA_Status']),
					"TLA_Name"		 => !empty($result['data'][$index]['TLA_Name']) ? '<div class="tooltip-top" data-tooltip="Refer Code: ' . $result['data'][$index]['TLA_Code'] . $tl_mobile . '">'. $tl_name .'</div>':'',
					"TLA_Position"	 => !empty($result['data'][$index]['TLA_Position']) ? $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['TLA_Position']):'',
					"TLA_BranchName" => !empty($result['data'][$index]['TLA_BranchName']) ? '<div class="tooltip-top" data-tooltip="Tel : ' . $tl_branch_tel .'">'.$this->effective->get_chartypes($this->char_mode, $result['data'][$index]['TLA_BranchName']).'</div>':'',
					"BranchCode"	 => !empty($branch_name) ? '<div class="tooltip-top" data-tooltip="' . $branch_name . $branch_tel .'">'.$result['data'][$index]['BranchDigit'].'</div>':'',
					"Assignment"	 => !empty($result['data'][$index]['Assignment']) ? '<div class="tooltip-top" data-tooltip="' . $assign_nickname . $assign_tel .'">'.$this->effective->get_chartypes($this->char_mode, $result['data'][$index]['Assignment']).'</div>':'',
					"ApprovedRate"	 => '<span class="tooltip-top" data-tooltip="'.$tooltip_text.'">' . $result['data'][$index]['Appr_Rate'] . '%</span>',
					"TicketSize"	 => $result['data'][$index]['TicketSize'] . 'Mb',
					"DD_Total"		 => $total_drawdown,					
					"DD_CM"			 => !empty($result['data'][$index]['DD_CM']) ? number_format($result['data'][$index]['DD_CM'], 0):'',
					"DD_YAPP"		 => !empty($result['data'][$index]['DD_YAPP']) ? $result['data'][$index]['DD_YAPP']:'',
					"DD_MAPP"		 => !empty($result['data'][$index]['DD_MAPP']) ? $result['data'][$index]['DD_MAPP']:'',
					"A2CA_Total"	 => !empty($result['data'][$index]['A2CA_Total']) ? $result['data'][$index]['A2CA_Total']:'',
					"A2CA_CM"		 => !empty($result['data'][$index]['A2CA_CM']) ? $result['data'][$index]['A2CA_CM']:'',
					"NCB_Total"		 => !empty($result['data'][$index]['NCB_Total']) ? $result['data'][$index]['NCB_Total']:'',
					"NCB_CM"		 => !empty($result['data'][$index]['NCB_CM']) ? $result['data'][$index]['NCB_CM']:''		
				);
				
			};
			
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
	
	public static function setValueColor($mode, $value = array()) {
		if($mode == 'DrawdownDate'):
			if(!empty($value[0])) return TRUE;
			else return FALSE;
		else:
			return FALSE;
		endif;
	}
	
	public function getTLAVolumeListSummmary() {
		$this->load->model('dbstore');
		$this->load->model('dbcustom');
		$this->load->library('effective');

		try {
			
			$wheres	 		= '';
			$join_date 		= '';
			$tla_code		= '';
			$tla_name		= '';
			$tla_branch		= '';
			$tla_position	= '';
			$tla_status		= '';
			
			$lb_region_id	= '';
			$lb_branchcode	= '';
			$employee_find	= '';
			$has_drawdown	= '';
			$has_a2ca		= '';
			$has_ncb		= '';
			
			$filter_type	= $this->input->post('filter_type');
			$start_date		= $this->input->post('start_date');
			$end_date 		= $this->input->post('end_date');
			
			$tl_code 		= $this->input->post('tl_code');
			$tl_name 		= $this->input->post('tl_name');
			$tl_branch 		= $this->input->post('tl_branch');
			$tl_position 	= $this->input->post('tl_position');
			
			$tl_status		= $this->input->post('tl_status');
			$tl_state_main  = $this->input->post('tl_state_main');
			$drawdown_check	= $this->input->post('drawdown_check');
			$a2ca_check		= $this->input->post('a2ca_check');
			$ncb_check		= $this->input->post('ncb_check');
			
			$lb_region 		= $this->input->post('lb_region');
			$lb_branch 		= $this->input->post('lb_branch');
			$lb_emp 		= $this->input->post('lb_emp');
			
			if(!empty($tl_state_main[0]) && !empty($tl_status[0])):
			$status_object  = array_merge($tl_state_main, $tl_status);
				
			else:
					
				if(!empty($tl_state_main[0])):
					$status_object	= $tl_state_main;
				endif;
				
				if(!empty($tl_status[0])):
					$status_object  = $tl_status;
				endif;
				
			endif;

			// Condition
			if(!empty($tl_code)) { $tla_code = ", @TL_Code = '".$tl_code."'"; }
			if(!empty($tl_name)) { $tla_name = ", @TL_Name = '".$this->effective->set_chartypes($this->char_mode, $tl_name)."'"; }
			
			$conv_startdate  = !empty($start_date) ? $this->effective->StandartDateSorter($start_date):"";
			$conv_enddate	 = !empty($end_date) ? $this->effective->StandartDateSorter($end_date):"";
			
			if($filter_type == 'DrawdownDate') {
				
				if(!empty($conv_startdate) && !empty($end_date)) {
					$join_date = ", @DDStart = '".$conv_startdate."', @DDEnd = '".$conv_enddate."'";
					
				} else {
								
					if(!empty($conv_startdate)) $join_date = ", @DDStart = '".$conv_startdate."', @DDEnd = '".$conv_startdate."' ";		
					if(!empty($conv_enddate)) $join_date   = ", @DDStart = '".$conv_enddate."', @DDEnd = '".$conv_enddate."'";
			
				}
				
			} else {
				
				if(!empty($conv_startdate) && !empty($end_date)):
					$join_date = ", @JoinStart = '".$conv_startdate."', @JoinEnd = '".$conv_enddate."'";
				else:
					if(!empty($conv_startdate)) $join_date .= ", @JoinStart =  '".$conv_startdate."'";
					if(!empty($conv_enddate)) $join_date .= ", @JoinEnd = '".$conv_enddate."'";
				endif;
					
				if(!empty($tl_position[0])):
					$tla_position   = ", @TL_Position = '".$this->effective->set_chartypes($this->char_mode, implode(',', $tl_position))."'";
				endif;
					
				if(!empty($tl_branch[0])):
					$tla_branch   	= ", @TL_Branch = '".$this->effective->set_chartypes($this->char_mode, implode(',', $tl_branch))."'";
				endif;
					
				if(!empty($lb_branch[0])):
					$lb_branchcode  = ", @LB_Branch = '".implode(',', $lb_branch)."'";
				endif;
				
			}
			
			if(!empty($tl_position[0])):
				$tla_position   = ", @TL_Position = '".$this->effective->set_chartypes($this->char_mode, implode(',', $tl_position))."'";
			endif;
			
			if(!empty($tl_branch[0])):
				$tla_branch   	= ", @TL_Branch = '".$this->effective->set_chartypes($this->char_mode, implode(',', $tl_branch))."'";
			endif;
			
			if(!empty($lb_branch[0])):
				$lb_branchcode  = ", @LB_Branch = '".implode(',', $lb_branch)."'";
			endif;
			
			/*
			if(!empty($tl_state_main[0])):
				$tla_status   	= ", @Status = '".implode(',', $tl_state_main)."'";
			endif;
			*/
			
			if(!empty($status_object[0])) { $tla_status .= ", @Status = '".implode(',', $status_object)."'"; }
			
			if(!empty($lb_emp[0])):
				$employee_find  = ", @LB_Emp = '".implode(',', $lb_emp)."'";
			endif;
			
			
			if(!empty($lb_region)) $lb_region_id .= ", @LB_Region = '".$lb_region."'";
			if(!empty($drawdown_check)) $has_drawdown .= ", @hasDrawdown = '".$drawdown_check."'";
			if(!empty($a2ca_check)) $has_a2ca .= ", @hasA2CA = '".$a2ca_check."'";
			if(!empty($ncb_check)) $has_ncb .= ", @hasNCB = '".$ncb_check."'";
				
			if(empty($this->authorized[0])) {
				log_message('error', 'method '.__METHOD__ .'can not load data. Please you are check object criteria in parameter.');
				throw new Exception("The syntax is occurrence issue received parameter condition an errors. Please your are checked arguments.");
			
			} else {
			
				if(count($this->authorized) > 1) :
					$privileges = $this->authorized[0];
				else:
					$privileges = $this->authorized[0];
				endif;
			
				$employees   = $this->dbcustom->employeesInfo($this->emp_id);
				$empbranch   = str_pad($employees['data'][0]['BranchCode'], 3, '0', STR_PAD_LEFT);
				$emp_area    = $employees['data'][0]['AreaCode'];
				$emp_region  = $employees['data'][0]['RegionID'];
			
				$where_auth = '';
				switch($privileges) {
					case $this->role_ad:
			
						if($empbranch == "000" || $empbranch == "901"):
							$where_auth = '';
						else:
							$where_auth = ", @BrnCode = '".$empbranch."'";
						endif;
			
						break;
					case $this->role_rm:
						$where_auth	= ", @RMCode = '".$this->emp_id."'";
			
						break;
					case $this->role_bm:
						$where_auth = ", @BrnCode = '".$empbranch."'";
			
						break;
					case $this->role_am:
						$where_auth = ", @AreaCode = '".$emp_area."'";
			
						break;
					case $this->role_rd:
						$where_auth = ", @Region = '".$emp_region."'";
			
						break;
			
					case $this->role_hq:
					case $this->role_spv:
					case $this->role_ads:
						$where_auth = '';
						break;
				}
				
				$wheres .= "@Ordering = 'TL_ID' $join_date $tla_code $tla_name $tla_branch $tla_position $tla_status $lb_region_id $lb_branchcode $employee_find $has_drawdown $has_a2ca $has_ncb $where_auth";
								
				try {
						
					$result = $this->dbstore->exec_getTLAVolumeGrandTotal($wheres);
					
					header('Content-type: application/json; charset="UTF-8"');
					echo json_encode($result);
										
				} catch(Exception $e) {
					echo 'Caught exception: '.$e->getMessage()."\n";
					echo 'Caught exception: '.$e->getLine()."\n";
					echo 'The Exception: '.$e->getTrace()."\n";
				}
								
			}
			
	
		} catch(Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
		
		}
		
	}
		
		
	
	private static function dropColor($num) {
		if($num == 0):
			return '<div style="color: #999;">'. $num . '</div>';
		else:
			return $num;
		endif;
	}
	
	private static function json_parse($objArr) {
		header("Content-Type: application/json");
		echo json_encode($objArr);
	}
	
}