<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Create_data extends MY_Controller {
	
	public $pages_default;
	public $pages_customiz;
	
	protected $emp_id;
	protected $email;
	protected $name, $engname, $bm;
	protected $position;
	protected $branch;
	protected $branch_code;
	protected $region_id;
	protected $region;
	protected $region_th;
	protected $authorized;
	protected $is_logged_in;
	protected $pilot;
	protected $logs;

	
	public function __construct() {
		parent::__construct();
		
		$this->load->helper('cookie');
		$ck_info = json_decode(get_cookie('authen_info'), TRUE);
				
		$this->emp_id        = !empty($ck_info['Session']) ? $ck_info['Session']["sess_empcode"] : null;
		$this->name          = !empty($ck_info['Session']) ? $ck_info['Session']["sess_thname"] : null;
		$this->engname       = !empty($ck_info['Session']) ? $ck_info['Session']["sess_engname"] : null;
		$this->email         = !empty($ck_info['Session']) ? $ck_info['Session']["sess_email"] : null;
		$this->branch_code   = !empty($ck_info['Session']) ? $ck_info['Session']["sess_branch_code"] : null;
		$this->branch        = !empty($ck_info['Session']) ? $ck_info['Session']["sess_branch"] : null;
		$this->bm			 = !empty($ck_info['Session']) ? $ck_info['Session']["sess_bmname"] : null;
		$this->position      = !empty($ck_info['Session']) ? $ck_info['Session']["sess_position"] : null;
		$this->region_id	 = !empty($ck_info['Session']) ? $ck_info['Session']["sess_region_id"] : null;
		$this->region		 = !empty($ck_info['Session']) ? $ck_info['Session']["sess_region"] : null;
		$this->region_th	 = !empty($ck_info['Session']) ? $ck_info['Session']["sess_region_th"] : null;
		$this->authorized    = !empty($ck_info['Session']) ? $ck_info['Session']["sess_authorized"] : null;
		$this->is_logged_in  = !empty($ck_info['Session']) ? $ck_info['Session']["sess_is_logged"] : FALSE;
		$this->pilot		 = !empty($ck_info['Session']) ? $ck_info['Session']["sess_pilot"] : null;
		
		// Object: Session Enrolled.
		$this->data['session_data'] = array(
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
		
		
		$this->pages_default	= "frontend/metro";
		$this->pages_customiz	= "frontend/content/pages/";
		$this->logs			 = $_SERVER['DOCUMENT_ROOT'].'/ci/logs/debug/';
		
	}
	
	public function profile() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		$this->load->library('form_validation');
		
		$this->data['autofill']		= array(
			'RMCode'		=> $this->input->get('eid'),
			'BranchCode'	=> $this->input->get('br'),
			'IsOwner'		=> $this->input->get('owner'),
			'Customer'		=> $this->input->get('cth'),
			'Company'		=> $this->input->get('corp'),
			'Mobile'		=> $this->input->get('mno'),
			'SourceCode'	=> $this->input->get('sid'),	
			'SourceField'	=> $this->input->get('sch')			
		);
		
		$this->pages				= "form/create/profile_refinfo";
		$this->data['char_mode']	= $this->char_mode;
		
		$this->data['stylesheet']	= array('pikaday', 'custom/bsi', 'custom/form', 'webui-popover/jquery.webui-popover', 'custom/tooltip_custom');
		$this->data['javascript']	= array('moment.min', 'pikaday', 'autocomplete', 'vendor/jquery.number.min', 'vendor/jquery.mask.min', 'vendor/jquery.cookie', 'build/form/profile_process_refer/cprofile.js?v=001', 'build/form/profile_process_refer/profile_validation.js?v=001', 'plugin/webui-popover/jquery.webui-popover.min');
		
		$this->data['user_role']	= $this->getRole($this->authorized[0], $this->branch_code);
		$this->data['branchs']		= $this->dbmodel->loadData($this->table_ledingbranchs, "BranchCode, BranchName, BranchDigit", array("BranchCode !=" => ""));
		
 		$this->_renders($this->pages_default, 'customiz');
	}
	
	
	public function getRole($role, $branch_code) {
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
	
	private function DocGenerate() {
		$this->load->model("dbmodel");
		
		$checked    = $this->dbmodel->loadData($this->table_masterdoc, "CurrentYear", array("CurrentYear" => date("Y")));
		if($checked['status'] == "false") {
			$result = $this->dbmodel->exec($this->table_masterdoc, array("CurrentYear" => date("Y"), "Runno" => "1"), false, "insert");
			if($result == TRUE)  {
				$doc_id = $this->dbmodel->loadData($this->table_masterdoc, "Runno", array("CurrentYear" => date("Y")));
				return $doc_id['data'][0]['Runno'];
				
			}
			else throw new Exception("Error exception: Table masterdoc is insert missing... ");
			
		} else {
			$doc_id = $this->dbmodel->loadData($this->table_masterdoc, "Runno", array("CurrentYear" => date("Y")));
			return $doc_id['data'][0]['Runno'];
			
		}
		
	}
	
	/** Check unique document identify */
	private function checkUniqueDoc($table, $doc_id) {
		$this->load->model("dbmodel");
		$result   =  $this->dbmodel->loadData($table, "DocID", array("DocID" => $doc_id));
		return $result;
		
	}
	
	private function checkUnique($table, $fields, $condition = array()) {
		$this->load->model("dbmodel");
		$result   =  $this->dbmodel->loadData($table,  $fields, $condition);
		return $result;
		
	}
	
	
	/** Field Forms Validation */
	public function profileFormValid() {
		$this->load->library("form_validation");
		
		$this->form_validation->set_rules("rmcode", "rm code", "trim|required");
		$this->form_validation->set_rules("rmmobile", "rm mobile", "trim");
		$this->form_validation->set_rules("empname", "rm name", "");
		$this->form_validation->set_rules("bm", "bm name", "");
		$this->form_validation->set_rules("region", "region", "trim");
		$this->form_validation->set_rules("branchcode", "branch code", "trim");
		$this->form_validation->set_rules("branch", "branch", "trim");
		
		$this->form_validation->set_rules("interest", "interest", "");
		$this->form_validation->set_rules("sourceofcustomer", "source of customer", "");
		$this->form_validation->set_rules("sourceoption", "source option", "");
		$this->form_validation->set_rules("ownertype", "owner type", "required");
		$this->form_validation->set_rules("owner", "customer name", "required");
		$this->form_validation->set_rules("company", "company", "");
		$this->form_validation->set_rules("businesstype", "business type", "");
		$this->form_validation->set_rules("business", "business type", "");
		$this->form_validation->set_rules("telephone", "telephone number", "trim");
		$this->form_validation->set_rules("mobile", "mobile number", "trim");
		$this->form_validation->set_rules("downtown", "business downtown", "required");
		$this->form_validation->set_rules("address", "address", "");
		$this->form_validation->set_rules("province", "province", "");
		$this->form_validation->set_rules("district", "district", "");
		$this->form_validation->set_rules("postcode", "postcode", "");
		$this->form_validation->set_rules("channelmodule", "news channel", "required");
		$this->form_validation->set_rules("channel", "channel", "");
		$this->form_validation->set_rules("loanrequest", "request loan", "");
		$this->form_validation->set_rules("duedatestatus", "due status", "");
		$this->form_validation->set_rules("duedate", "due date", "");
		$this->form_validation->set_rules("endevent", "end event", "");
		$this->form_validation->set_rules("referralcode", "referral code", "");
		$this->form_validation->set_rules("cspotential", "Customer Potential", "");
		$this->form_validation->set_rules("remark", "remark", "");
		if($this->form_validation->run() == FALSE) {
			$this->profile();
			
		} else {
			return TRUE;
		}
		
	}
	
	/** Form Exc: Insert Processes
	 *  Application Processes: Profile Process
	 **/
	public function profileFormIntial() {
		$this->load->model("dbmodel");
		$this->load->model("dbstore");
		$this->load->library('effective');
		
		// Post input handled
		$branchcode     = $this->input->post('branchcode');
		$branch         = $this->input->post('branch');
		$region         = $this->input->post('region');
		$rmcode         = $this->input->post('rmcode');
		$rmname         = $this->input->post('empname');
		$rmmobile       = $this->input->post('rmmobile');
		$bmname         = $this->input->post('bm');
		
		$custtypes		= $this->input->post('register');
		$gencreatedate	= $this->input->post('createdate');
		$interest       = (int)$this->input->post('interest');
		$sourceofcustom = $this->input->post('sourceofcustomer');
		$sourceoption	= $this->input->post('sourceoption');
		$ownertype      = (int)$this->input->post('ownertype');
		$prefixname     = $this->input->post('prefixname');
		$owner          = $this->input->post('owner');
		$prefixcorp     = $this->input->post('prefixcorp');
		$company        = $this->input->post('company');
		$businesstype   = $this->input->post('businesstype');
		$business       = $this->input->post('business');
		$loan_group		= $this->input->post('loan_group');
		$telephone      = $this->input->post('telephone');
		$mobile         = $this->input->post('mobile');
		$downtown       = $this->input->post('downtown');
		$address        = $this->input->post('address');
		$province       = $this->input->post('province');
		$district		= $this->input->post('district');
		$postcode       = $this->input->post('postcode');
		$channel        = $this->input->post('channelmode');
		$subchannel     = $this->input->post('channelmodule');
		$rqloan         = $this->input->post('loanrequest');
		$referral       = $this->input->post('referralcode');
		$potential      = (int)$this->input->post('potential');
		$remark         = $this->input->post('remark');
		
		$duestatus		= $this->input->post('duedatestatus');
		$duedate		= $this->input->post('duedate');
		$duerepeat		= $this->input->post('endevent');
		$duenote		= $this->input->post('dueoption');
		
		$assign_case	= $this->input->post('assign_case');
		$assignname		= $this->input->post('assignname');
		
		// New 07/01/2015
		$criteria       = $this->input->post('criteria');
		$criteria_rea	= $this->input->post('criteria_reason');
		
		// New 16/02/2019
		$refer_ch_code  = $this->input->post('fill_source_field_id');		
		
		$fieldForms		= array(
			'RMCode'            => $rmcode,
			'RMName'            => $this->effective->set_chartypes($this->char_mode, $rmname),
			'RMMobile'          => $rmmobile,
			'BMName'            => $this->effective->set_chartypes($this->char_mode, $bmname),
			'BranchCode'        => $branchcode,
			'Branch'            => $this->effective->set_chartypes($this->char_mode, $branch),
			'Region'            => $region,
			'CustType'			=> $custtypes,
			'Interest'          => $interest,
			'IsAssignCase'		=> ($assign_case == 'Y') ? $assign_case:NULL,
			'AssignByID'		=> !empty($assignname) ? $assignname:NULL,
			'SourceOfCustomer'  => $this->effective->set_chartypes($this->char_mode, $sourceofcustom),
			'SourceOption'		=> $this->effective->set_chartypes($this->char_mode, $sourceoption),
			'CSPotential'		=> $potential,
			'OwnerType'         => $ownertype,
			"PrefixName"		=> $this->effective->set_chartypes($this->char_mode, $prefixname),
			'OwnerName'         => $this->effective->set_chartypes($this->char_mode, $owner),
			"PrefixCorp"		=> $this->effective->set_chartypes($this->char_mode, $prefixcorp),
			'Company'           => $this->effective->set_chartypes($this->char_mode, $company),
			'BusinessType'      => $this->effective->set_chartypes($this->char_mode, $businesstype),
			'Business'          => $this->effective->set_chartypes($this->char_mode, $business),
			'LoanGroup'			=> $loan_group,
			'Telephone'         => $telephone,
			'Mobile'            => $mobile,
			'Downtown'          => $this->effective->set_chartypes($this->char_mode, $downtown),
			'BusinessLocation' 	=> $this->effective->set_chartypes($this->char_mode, $downtown),
			'Address'           => $this->effective->set_chartypes($this->char_mode, $address),
			'Province'          => $this->effective->set_chartypes($this->char_mode, $province),
			'District'			=> $this->effective->set_chartypes($this->char_mode, $district),
			'Postcode'          => $postcode,
			'Channel'           => $channel,
			'SubChannel'        => $this->effective->set_chartypes($this->char_mode, $subchannel),
			'RequestLoan'       => !empty($rqloan) ? intval(str_replace(',', '', $rqloan)):0,
			'ReferralCode'      => $referral,
			'Remark'            => $this->effective->set_chartypes($this->char_mode, $remark),
			'CreateBy'          => $this->effective->set_chartypes($this->char_mode, $this->name),
			'CreateDate'		=> $this->effective->StandartDateSorter($gencreatedate),
			'ReferChannelCode'  => !empty($refer_ch_code) ? $refer_ch_code:NULL,
			'IsEnabled'			=> 'A'
		);
		
		$validForm		= $this->profileFormValid();
		if($validForm) {
			
			if(!empty($rmcode) && !empty($ownertype) && !empty($owner) && !empty($subchannel) && !empty($province) && !empty($downtown) || !empty($telephone) || !empty($mobile) || in_array($rmcode, array('57199'))) {
				$this->is_active = "Y";
			} else {
				$this->is_active = "P";
			}
			
			// Document Identification Generate
			$doc_id  = $this->DocGenerate();
			$checked = $this->checkUniqueDoc($this->table_profile, substr(date("Y") + 543, 2).str_pad($doc_id, 6, "0", STR_PAD_LEFT));
			
			// Check Authorized
			if(in_array($this->role_ad, $this->authorized) || in_array($this->role_admin, $this->authorized) || in_array($this->role_rm, $this->authorized) || in_array($this->role_bm, $this->authorized)) {
				
				// Document unique identify
				if($checked['status'] == 'true') {
					$doc_id     		= (int)$doc_id + 1;
					$this->identify     = substr(date("Y") + 543, 2).str_pad($doc_id, 6, "0", STR_PAD_LEFT);
					$objForms			= array_merge($fieldForms, array("DocID" => $this->identify, 'IsActive' => $this->is_active));
					
				} else {
					$this->identify     = substr(date("Y") + 543, 2).str_pad($doc_id, 6, "0", STR_PAD_LEFT);
					$objForms			= array_merge($fieldForms, array("DocID" => $this->identify, 'IsActive' => $this->is_active));
					
				}
				
				if(array_key_exists('DocID', $objForms)) {
					
					$source = $this->dbmodel->data_validation($this->table_profile, "RMCode, Ownername, Company, Province", array("RMCode" => $rmcode, 'BranchCode' => $branchcode, "Ownername"  => $this->effective->set_chartypes($this->char_mode, $owner), "CreateDate" => date('Y-m-d')), false);
					
					if($source == 'TRUE') {
						
						log_message('error', __METHOD__ .' - The Customer are already in pcis. Please your confirm data forms.');
						$this->data['databundled'] = array(
								"status"  => false,
								"access"  => 'databundle',
								"msg"     => "ขออภัย!มีลูกค้าคนนี้อยู่ในระบบแล้ว."
						);
						$this->profile();
						
					} else {
						
						$create_profile = $this->dbmodel->exec($this->table_profile, $objForms, false, "insert");
						$create_verify  = $this->dbstore->exec_verification_bundledoc($this->identify, null, 'A', $this->effective->set_chartypes($this->char_mode, $this->name), date('Y-m-d'), 1);
						$create_app   	= $this->dbstore->exec_appstate_bundledoc($this->identify, null, 'A', $this->effective->set_chartypes($this->char_mode, $this->name), date('Y-m-d'), 1);
						
						if($create_profile == TRUE && $create_verify == TRUE && $create_app == TRUE) {
							$DocRunno = $this->dbmodel->exec($this->table_masterdoc, array("Runno" => (int)($doc_id + 1)), array("CurrentYear" => date("Y")), "update");
							
							if($DocRunno == TRUE) {
								
								if(empty($criteria)) $check_criteria = '1';
								else $check_criteria = '0';
								$verification = $this->dbmodel->exec($this->table_verification, array("BasicCriteria" => $check_criteria, "CriteriaReasonID" => $criteria_rea), array("DocID" => $this->identify), 'update');
								
								if($verification == TRUE) {
									redirect('create_data/profile?_='.date('s').'&forms=success&cache=false&msg='.true.'&rel='.$this->identify);
								}	
								
							} else {
								
								log_message('error', 'method '.__METHOD__ .' not had update document identify please your check object.');
								$this->data['databundled'] = array(
										"status"  => false,
										"access"  => 'databundle',
										"msg"     => "เกิดข้อผิดพลาดในการบันทึกข้อมูล โปรดติดต่อผู้ดูแลระบบ."
								);
								$this->profile();
								
							}
							
							
						} else {
							
							log_message('error', 'method '.__METHOD__ .' not had inserting please your check object.');
							$this->data['databundled'] = array(
									"status"  => false,
									"access"  => 'databundle',
									"msg"     => "เกิดข้อผิดพลาดในการบันทึกข้อมูล โปรดติดต่อผู้ดูแลระบบ."
							);
							$this->profile();
							
						}
						
						
					}
					
					
				} else {
					
					log_message('error', __METHOD__ .' - Object not had key DocID in array. Please your check value in array.');
					$this->data['databundled'] = array(
							"status"  => false,
							"access"  => 'databundle',
							"msg"     => "เกิดข้อผิดพลาดในการสร้างเลขที่เอกสาร โปรดติดต่อผู้ดูแลระบบ."
					);
					$this->profile().'&forms=errors&cache=false&msg='.false.'&rel=""';
				}
				
			} else {
				
				$this->data['role_handled'] = array(
						"status"  => false,
						"access"  => 'permission',
						"msg"     => "ขออภัย! คุณไม่มีสิทธิในการสร้างเอกสาร โปรดติดต่อผู้ดูแลระบบ."
				);
				$this->profile().'&forms=errors&cache=false&msg='.false.'&rel=""';
				
			}
			
		}		
		
	}
	
	
	
}

?>