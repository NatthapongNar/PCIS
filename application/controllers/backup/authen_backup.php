<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authen extends CI_Controller {
	
	public $logs; // Logs
	private $salt;
	private $hash;
	
	private $employee;
	private $sessid;
	private $emp_id, $empcode;
	private $name, $engname, $bm;
	private $email;
	private $position;
	private $branch;
	private $branch_code;
	private $region_id;
	private $region;
	private $region_th;
	private $authorized ;
	private $is_logged_in;
	private $remember;
	
	// tablename
	private $table_employee;
	private $table_branch;
	
	private $user_temp;
	private $pass_temp;
	
	
	// Web Service
	protected $protocal;
	protected $system_id;
	protected $api_checkuser;
	
	public function __construct() {
		parent::__construct();
		
		$this->real     = date('s');
		$this->salt     = 'secret';
		$this->hash_key = "i7x_ENVLends";
		
		// Load Configulation
		$this->protocal					= $this->config->item('uri_protocal');
		$this->api_checkuser			= $this->config->item('api_userlogin');
		$this->system_id				= $this->config->item('system_id');
		
		// Load Table
		$this->table_employee			= $this->config->item('table_employee');
		$this->table_branch				= $this->config->item('table_branch');
		
		//$this->logs						= $this->config->item('debug_log');
		$this->logs						= $_SERVER['DOCUMENT_ROOT'].'/ci/logs/debug/';
		
		
		$this->uhash		 			= $this->session->userdata("uhash");
		$this->phash		 			= $this->session->userdata("phash");
		
		$this->xuser		 			= $this->session->userdata("xuser");
		//$this->xpass        			= $this->session->userdata("xpass");
		$this->sess_id		 			= $this->session->userdata("session_id");
		$this->emp_id        			= $this->session->userdata("empcode");
		$this->name          			= $this->session->userdata("thname");
		$this->engname       			= $this->session->userdata("engname");
		$this->email         			= $this->session->userdata("email");
		$this->branch_code   			= $this->session->userdata("branchcode");
		$this->branch        			= $this->session->userdata("branch");
		$this->bm			 			= $this->session->userdata("bmname");
		$this->position      			= $this->session->userdata("position");
		$this->region_id	 			= $this->session->userdata("region_id");
		$this->region		 			= $this->session->userdata("region");
		$this->region_th	 			= $this->session->userdata("region_th");
		$this->authorized    			= $this->session->userdata("privileges");
		$this->is_logged_in  			= $this->session->userdata("is_logged_in");
		$this->secure		 			= $this->session->userdata("secure");
		
		$this->user_temp 				= $this->config->item('TempUser');
		$this->pass_temp 				= $this->config->item('TempPass');
		
		$this->char_mode				= $this->config->item('char_mode');
		
	}

	public function index() {
		$this->load->view('login');
	}

	// Input validation
	private  function loginValid() {
		$this->load->library("form_validation");
		$this->form_validation->set_rules("username", "username", "trim|required|min_length[4]|max_length[32]|xss_clean");
		$this->form_validation->set_rules("password", "password", "trim|required|min_length[4]|max_length[32]|xss_clean|md5");
		if($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			return TRUE;
		}
	
	}
	
	protected function CheckADUserInitial($domain_users, $domain_password) {
		$this->load->library('lib/nusoap_base');
	
		try {
	
			$protocal 		= $this->protocal;
			$this->nusoap   = new nusoap_client($protocal, true);
	
			$authen = array(
					"ADUser"            => $domain_users,
					"Password"          => $domain_password,
					"PRequest"			=> array(
						"ADUser"        => $domain_users,
						"SystemID"      => $this->system_id,
						"Description"   => ""
					)
			);
	
			$responsed  = $this->nusoap->call($this->api_checkuser, $authen);			
			if($responsed['CheckUserloginResult']['Message']['IsSuccess']) {
				$objResponsed =  array( 
						"status"  => $responsed['CheckUserloginResult']['Message']['IsSuccess'],
						"data"	  => $responsed['CheckUserloginResult']
				);
	
				return $objResponsed;
					
			} else {
				$objResponsed =  array(
						"status"  => $responsed['CheckUserloginResult']['Message']['IsSuccess'],
						"data"	  => $responsed['CheckUserloginResult']
				);
	
				return $objResponsed;
	
			}
			
		} catch(SoapFault $e) {
			log_message('error', 'Soap fault, Soap is has problem a connection to web service. Please your are check configulation. ' . $e->getTrace());
			
		}
	
	}
	
	// Create debug folder
	protected function makedirs($dirpath, $mode=0777) {
	    return is_dir($dirpath) || mkdir($dirpath, $mode, true);
	}
	
	private function writelogs($log_path, $result) {
		$this->load->library('xml/array2xml');
		
		$this->makedirs($log_path."login/".date("dmy"));
		
		$xml = new DOMDocument();
		$xml = Array2XML::createXML('root_node_name', $result);
		$xml->save($log_path."login/".date("dmy")."/"."LOGIN_Ex".date("His").".xml");
		
	}
		
	public function logged() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
		
		$this->username		= strtolower($this->input->post('username'));
		$this->password		= $this->input->post('password');
		$this->remember		= $this->input->post('remember');
		
		
		$is_login_valid = $this->loginValid();
		if($is_login_valid == TRUE) {
			
			// USER VERIFICATION
			if($this->username == $this->user_temp && $this->password == $this->pass_temp) {
				$objData = array(
					'empcode'       => '99999',
					'thname'        => 'Admin Support',
					'engname'       => 'Administrator Support',
					'position'      => 'Support',
					'email'         => '-',
					'branchcode'    => '000',
					'branch'        => 'สำนักงานใหญ่',
					'region_id'		=> '01',
					'region'		=> 'BKK - HQ',
					'region_th'		=> 'กรุงเทพ-สำนักงานใหญ่',
					'bmname'		=> '-',
					'privileges'	=> array('074006'),
					'is_logged_in'  => TRUE,
					'secure'        => TRUE
				);
					
				$created = $this->sessionWriteInitial($objData);
				if($created == 'TRUE') {
					redirect('metro');
						
				} else { log_message('error', 'Object session are can\'t created session.'); }
				
			} else {
				
				$responsed      = $this->CheckADUserInitial($this->username, $this->password);
				if($responsed['status']== 'true') {
					
					
					$this->employee		= !empty($responsed['data']['Employee']) ? $responsed['data']['Employee']:"";
					
					if(empty($this->employee)) {
						
						log_message('error', 'employee detail: '.$this->employee);
						$this->data['is_errors'] = array(
								"status" => "false",
								"types"  => "danger",
								"msg"    => "ค้นหาข้อมูลไม่พบ โปรดติดต่อผู้ดูแลระบบ"
						);
						
						$this->load->view('login', $this->data);
						
					} else {
						
						
						// CHECK PRIVILEGES
						$this->privileges   = !empty($this->employee['Groups']) ? $this->employee['Groups']:"denied";
						if($this->privileges == 'denied') {
							
							//$this->writelogs($this->logs, $responsed);
							$this->data['is_errors'] = array(
									"status" => "false",
									"types"  => "danger",
									"msg"    => "คุณไม่มีสิทธ์ในการใช้งานระบบ กรุณาติดต่อผู้ดูแลระบบเพื่อขอเพิ่มสิทธิในการใข้งานในระบบ"
							);
								
							$this->load->view('login', $this->data);
							
						} else {
							
							
							
							// WS: DATA FROM ACTIVE DIRECTORY  
							$PrivilegesDetails  = $responsed['data']['Employee']['Groups']['Group'];
							$this->empcode		= !empty($this->employee['Emp_Code']) ? trim($this->employee['Emp_Code']):"-";					
							$this->empname_en	= !empty($this->employee['ENG_Name']) ? $this->employee['ENG_Name']:"ไม่ระบุ";
							$this->email		= !empty($this->employee['Email']) ? $this->employee['Email']:"ไม่ระบุ";
							
							$result_lending		= $this->dbmodel->loadData('LendingEmp', 'ISNULL([OfficeBase],[BranchCode]) AS BranchCode', array('EmployeeCode' => $this->empcode));
							$this->branchcode	= !empty($result_lending['data'][0]['BranchCode']) ? $result_lending['data'][0]['BranchCode']:"";
						
							// ROLE SPECIFIED
							$Role 	=  array(
									"074001" 	=> $this->config->item('ROLE_ADMIN'),
									"074002" 	=> $this->config->item('ROLE_RM'),
									"074003" 	=> $this->config->item('ROLE_BM'),
									"074004" 	=> $this->config->item('ROLE_AM'),
									"074005" 	=> $this->config->item('ROLE_RD'),
									"074006" 	=> $this->config->item('ROLE_HQ'),
									"074007" 	=> $this->config->item('ROLE_SPV'), 
									"074008" 	=> $this->config->item('ROLE_ADMINSYS')	 
							);
							
							$i=0;
							$RolePrivileges = array();
							if(self::getParentStackComplete($this->config->item('ROLE_ADMIN'), $PrivilegesDetails)) {
								array_push($RolePrivileges, $this->config->item('ROLE_ADMIN'));
							} 
							
							if(self::getParentStackComplete($this->config->item('ROLE_RM'), $PrivilegesDetails)) {
								array_push($RolePrivileges, $this->config->item('ROLE_RM'));
									
							}
							
							if(self::getParentStackComplete($this->config->item('ROLE_BM'), $PrivilegesDetails)) {
								array_push($RolePrivileges, $this->config->item('ROLE_BM'));
							
							}
							
							if(self::getParentStackComplete($this->config->item('ROLE_AM'), $PrivilegesDetails)) {
								array_push($RolePrivileges, $this->config->item('ROLE_AM'));
							
							}
							
							if(self::getParentStackComplete($this->config->item('ROLE_RD'), $PrivilegesDetails)) {
								array_push($RolePrivileges, $this->config->item('ROLE_RD'));
							
							}
							
							if(self::getParentStackComplete($this->config->item('ROLE_HQ'), $PrivilegesDetails)) {
								array_push($RolePrivileges, $this->config->item('ROLE_HQ'));
							
							}
							
							if(self::getParentStackComplete($this->config->item('ROLE_SPV'), $PrivilegesDetails)) {
								array_push($RolePrivileges, $this->config->item('ROLE_SPV'));
							
							}
							
							if(self::getParentStackComplete($this->config->item('ROLE_ADMINSYS'), $PrivilegesDetails)) {
								array_push($RolePrivileges, $this->config->item('ROLE_ADMINSYS'));
							
							}
											
							/*
							if(@array_key_exists('PermissionID', $PrivilegesDetails['Permissions']['Permission'])) {
								array_push($RolePrivileges, $PrivilegesDetails['Permissions']['Permission']['PermissionID']);
							
							} else {
								
								foreach($PrivilegesDetails as $index => $values) {
									$userRole = $values['Permissions']['Permission']['PermissionID'];
									array_push($RolePrivileges, array_search($userRole, $Role));
								
								}
								
							}
							*/						
	
							$RoleFilter	= array_filter($RolePrivileges);
							if(empty($RoleFilter)) {
								
								//$this->writelogs($this->logs, $responsed);
								$this->data['is_errors'] = array(
										"status" => "false",
										"types"  => "incorrect",
										"msg"    => "เกิดข้อผิดพลาดในเรื่องสิทธิ์ โปรดติดต่อผู้ดูแลระบบ."
								);
								
								$this->load->view('login', $this->data);
	
							} else {
								
								// Insert Login-log
								$this->dbmodel->exec('SignIn_TransactionLog', 
								array(
									"EmployeeCode"	=> $this->empcode,
									"BranchCode"	=> $this->branchcode,
									"EventDate"		=> date('Y-m-d H:i:s'),
									"IsActive"		=> 'A'
								), false, 'insert');
								
								switch($RoleFilter[0]) {
										
									case "074001":
									case "074002":
										
										try {
												
											$result	= $this->dbmodel->CIQuery("
												SELECT 
													LendingEmp.EmployeeCode, LendingEmp.FullnameTh, LendingEmp.FullnameEng,LendingEmp.Nickname, 
													LendingEmp.RegionID, MasterRegion.RegionNameEng, MasterRegion.RegionNameTh, LendingEmp.BranchCode, 
													LendingBranchs.BranchDigit, LendingBranchs.BranchName, LendingEmp.PositionTitle, LendingEmp.Mobile,
													LendingEmp.RoleSpecial, LendingEmp.IsActive AS Active
												FROM LendingEmp
												LEFT OUTER JOIN LendingBranchs
												ON LendingEmp.BranchCode = LendingBranchs.BranchCode
												LEFT OUTER JOIN MasterRegion
												ON LendingEmp.RegionID = MasterRegion.RegionID
												WHERE LendingEmp.IsActive = 'A'
												AND LendingEmp.EmployeeCode = '".$this->empcode."'
		
											");
											
											$brnInfo = $this->dbmodel->CIQuery("
												SELECT 
													LendingEmp.EmployeeCode as BMCode, LendingEmp.FullnameTh AS BMName, 
													LendingEmp.PositionTitle AS BMPosition, LendingEmp.BranchCode AS BMBranchCode
												FROM LendingEmp
												WHERE  LendingEmp.PositionTitle like '%Branch Manager%'
												AND LendingEmp.BranchCode = '".$result['data'][0]['BranchCode']."'		
											");
												
											$objData = array(
													'xuser'			=> $this->username,
													//'xpass'			=> $this->password,
													'empcode'       => $this->empcode,
													'thname'        => $this->effective->get_chartypes($this->char_mode, $result['data'][0]['FullnameTh']),
													'engname'       => $this->empname_en,
													'position'      => $result['data'][0]['PositionTitle'],
													'email'         => $this->email,
													'branchcode'    => $result['data'][0]['BranchCode'],
													'branch'        => $this->effective->get_chartypes($this->char_mode, $result['data'][0]['BranchName']),
													'region_id'		=> $result['data'][0]['RegionID'],
													'region'		=> $result['data'][0]['RegionNameEng'],
													'region_th'		=> $this->effective->get_chartypes($this->char_mode, $result['data'][0]['RegionNameTh']),
													'bmname'		=> $this->effective->get_chartypes($this->char_mode, $brnInfo['data'][0]['BMName']),
													'privileges'	=> $RoleFilter,
													'is_logged_in'  => TRUE,
													'secure'        => TRUE
											);
										
											$created = $this->sessionWriteInitial($objData);
											if($created == 'TRUE') {
												redirect('metro');
										
											} else { log_message('error', 'Object session are can\'t created session.'); }
												
										} catch(Exception $e) {
											log_message('error', $e->getMessage());
												
										}
										
										break;
									case "074003":
									case "074006":
									case "074007":
									case "074008":
												
										try {
										
											$result	= $this->dbmodel->CIQuery("
												SELECT 
													LendingEmp.EmployeeCode, LendingEmp.FullnameTh, LendingEmp.FullnameEng,LendingEmp.Nickname, 
													LendingEmp.RegionID, MasterRegion.RegionNameEng, MasterRegion.RegionNameTh,LendingEmp.BranchCode, 
													LendingBranchs.BranchName, LendingEmp.PositionTitle, LendingEmp.Mobile,
													LendingBranchs.BranchDigit, LendingEmp.RoleSpecial, LendingEmp.IsActive AS Active
												FROM LendingEmp
												LEFT OUTER JOIN LendingBranchs
												ON LendingEmp.BranchCode = LendingBranchs.BranchCode
												LEFT OUTER JOIN MasterRegion
												ON LendingEmp.RegionID = MasterRegion.RegionID
												WHERE LendingEmp.IsActive = 'A'
												AND LendingEmp.EmployeeCode = '".$this->empcode."'
											");
										
											$objData = array(
													'xuser'			=> $this->username,
													//'xpass'			=> $this->password,
													'empcode'       => $this->empcode,
													'thname'        => $this->effective->get_chartypes($this->char_mode, $result['data'][0]['FullnameTh']),
													'engname'       => $this->empname_en,
													'position'      => $result['data'][0]['PositionTitle'],
													'email'         => $this->email,
													'branchcode'    => $result['data'][0]['BranchCode'],
													'branch'        => $this->effective->get_chartypes($this->char_mode, $result['data'][0]['BranchName']),
													'region_id'		=> $result['data'][0]['RegionID'],
													'region'		=> $result['data'][0]['RegionNameEng'],
													'region_th'		=> $this->effective->get_chartypes($this->char_mode, $result['data'][0]['RegionNameTh']),
													'privileges'	=> $RoleFilter,
													'is_logged_in'  => TRUE,
													'secure'        => TRUE
											);
											
											$created = $this->sessionWriteInitial($objData);
											if($created == 'TRUE') {
												redirect('metro');
											
											} else { log_message('error', 'Object session are can\'t created session.'); }
										
										} catch(Exception $e) {
											log_message('error', $e->getMessage());
												
										}	
												
										break;
									case "074004":
									case "074005":
										
										$result	= $this->dbmodel->CIQuery("
											SELECT
												LendingEmp.EmployeeCode, LendingEmp.FullnameTh, LendingEmp.FullnameEng,
												LendingEmp.Nickname, LendingEmp.RegionID, MasterRegion.RegionNameEng, MasterRegion.RegionNameTh,
												LendingEmp.PositionTitle, LendingEmp.Mobile, LendingEmp.RoleSpecial, LendingEmp.IsActive AS Active
												FROM LendingEmp
											LEFT OUTER JOIN MasterRegion
											ON LendingEmp.RegionID = MasterRegion.RegionID
											WHERE LendingEmp.IsActive = 'A'
											AND LendingEmp.EmployeeCode = '".$this->empcode."'								
										");
											
										$objData   = array(
												'xuser'			=> $this->username,
												//'xpass'			=> $this->password,
												'empcode'       => $this->empcode,
												'thname'        => $this->effective->get_chartypes($this->char_mode, $result['data'][0]['FullnameTh']),
												'engname'       => $this->empname_en,
												'position'      => $result['data'][0]['PositionTitle'],
												'email'         => $this->email,
												'branchcode'    => '-',
												'branch'        => '-',
												'region_id'		=> $result['data'][0]['RegionID'],
												'region'		=> $result['data'][0]['RegionNameEng'],
												'region_th'		=> $this->effective->get_chartypes($this->char_mode, $result['data'][0]['RegionNameTh']),
												'privileges'	=> $RoleFilter,
												'is_logged_in'  => TRUE,
												'secure'        => TRUE
										);
										$created = $this->sessionWriteInitial($objData);
										if($created == 'TRUE') {
											redirect('metro');
											
										} else { log_message('error', 'Object session are can\'t created session.'); }	
										
										break;
											
								}
							
							}
							
						}
						
							
					}
					
				} else {
		
					$this->data['is_errors'] = array(
							"status" => "false",
							"types"  => "incorrect",
							"msg"    => "username or password are incorrect."
					);
	
					$this->load->view('login', $this->data);
				}
				
			}
			
		}

	}
	
	static function getParentStackComplete($child, $stack) {
		$return = array();
		foreach ($stack as $k => $v) {
			if (is_array($v)) {
				$stack = self::getParentStackComplete($child, $v);
	
				if (is_array($stack) && !empty($stack)) {
					$return[$k] = $stack;
				}
			} else {
				if ($v == $child) {
					$return[$k] = $child;
				}
			}
		}
	
		// Return the stack
		return empty($return) ? false: $return;
	}

	
	public function loggedPass() {
		$logged    = $this->session->userdata("is_logged_in");
		if(empty($logged) || $logged != 1) {
			redirect("authen/logout");
		} else {
			redirect('metro').'?_='.$this->real;
		}
	}
	
	private function sessionWriteInitial($objSess) {
		$this->session->set_userdata($objSess);
		return 'TRUE';
	}
	
	private function storeAuth($username, $password, $saveMode) {
		if(empty($username) || empty($password)) {
			log_message('debug', 'the store is get empty value when '.date('H:i:s a'));
			
		} else {
			
			$this->hashing = md5($this->hash_key . $password);
			$sesssion_data = array(
					"uhash"     	=> md5($this->salt.$username),
					"phash"     	=> $password,
					'hashing'   	=> $this->hashing,
			);
			
			$this->sessionWriteInitial($sesssion_data);
			
		}
			
		return 'TRUE';
		
		
	}
	
	public function checkUserRole() {
		$this->username		= strtolower($this->input->post('username'));
		$this->password		= $this->input->post('password');
		$is_login_valid = $this->loginValid();
		if($is_login_valid == TRUE) {
			
			$responsed      = $this->CheckADUserInitial($this->username, $this->password);
			$this->writelogs($this->logs, $responsed);
			
		}
		
	}
	
	public function logout() {
		
		$session = array(
				'uhash'         => $this->uhash,
				'phash'         => $this->phash,
				'hashing'       => $this->sess_id,
				'sess_id'       => $this->sess_id,
				'xuser'			=> $this->xuser,
				//'xpass'			=> $this->xpass,
				'emp_id'        => $this->emp_id,
				'engname' 		=> $this->engname,
				'thname'        => $this->name,
				'bm'            => $this->bm,
				'position'      => $this->position,
				'region_id'	    => $this->region_id,
				'region'		=> $this->region,
				'branch_code'   => $this->branch_code,
				'branch'        => $this->branch,
				'privileges'    => $this->authorized,
				'is_logged_in'  => $this->is_logged_in,
				'secure'        => $this->secure
		);
		$this->session->unset_userdata($session);
		redirect("authen", 'refresh');
	}
	
	/** Function */
	// prepare handle
	public function prepareInput($handles) {
		if (!empty($handles)) return $handles;
		else return 'ไม่ระบุ';
	}
	
}