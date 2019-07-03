<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authen extends CI_Controller {

	private $ad_user;
	private $empcode;
	private $engname;
	private $thname;
	private $email;
	private $branch_name;
	private $branch_code;
	private $position;
	private $region;
	private $region_id;
	private $privileges;
	private $is_logged_in;
	private $secure;
	
	private $admin_sp;
	private $bm_pilot; // ADD NEW ON 12 NOV 2018
	private $online;
	

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		
		$this->online = $this->session->userdata("is_logged_in");
		$this->admin_sp = array('57253');
		$this->bm_pilot = array( // ADD NEW ON 12 NOV 2018
			'57357', '57359', '60901', '57474' // LOT 1 : 12 NOV 2018
		);

	}
	
	public function index() {
		$this->load->view('login');
	}
	
	public function logged() {
		$this->load->model('dbmodel');
		
		$role 	=  array(
			"ROLE_ADMIN" 	=> $this->config->item('ROLE_ADMIN'),
			"ROLE_RM" 		=> $this->config->item('ROLE_RM'),
			"ROLE_BM" 		=> $this->config->item('ROLE_BM'),
			"ROLE_AM" 		=> $this->config->item('ROLE_AM'),
			"ROLE_RD" 		=> $this->config->item('ROLE_RD'),
			"ROLE_HQ" 		=> $this->config->item('ROLE_HQ'),
			"ROLE_SPV" 		=> $this->config->item('ROLE_SPV'),
			"ROLE_ADMINSYS" => $this->config->item('ROLE_ADMINSYS'),
			"ROLE_CA" 		=> $this->config->item('ROLE_CA'),
			"ROLE_OPER" 	=> $this->config->item('ROLE_OPER')
		);

		$this->ad_user		= $this->input->post('ADUser');
		$this->empcode		= $this->input->post('empcode');
		$this->engname		= $this->input->post('engname');
		$this->thname		= $this->input->post('thname');
		$this->email		= $this->input->post('email');
		$this->branch_name	= $this->input->post('branch');
		$this->branch_code	= $this->input->post('branchCode');

		$this->position		= $this->input->post('position');
		$this->region		= $this->input->post('region');
		$this->region_id	= $this->input->post('region_id');
		$this->region_th	= $this->input->post('region_th');
		$this->privileges	= $this->input->post('privileges');
		
		$this->is_logged_in	= $this->input->post('is_logged_in');
		$this->secure		= $this->input->post('secure');
		$this->auth_role	= $this->input->post('role');
					
		$privileges			= is_array($this->privileges) ? $this->privileges:array($this->privileges);
		if(is_array($privileges)) {
			$verify = array();
			foreach($privileges as $index => $value) {
				if(in_array($value, array('074004', '074005'))):
					array_push($verify, 'TRUE');
				else:
					array_push($verify, 'FALSE');
				endif;
			}
			
			if(in_array('TRUE', $verify)) rsort($privileges);
			
		}
		
		$pilot_list 			= array();
		$authority_pilot 		= $this->dbmodel->CIQuery("SELECT [BranchCode] FROM [dbo].[AreaBoundary] WHERE [Pilot] = 'Y' AND EmployeeCode = '".$this->empcode."' AND IsActive = 'A' GROUP BY BranchCode"); // ADD NEW ON 12 NOV 2018
		if(!empty($authority_pilot['data'])) {
			foreach ($authority_pilot['data'] as $v) {
				array_push($pilot_list, $v['BranchCode']);
			}
		}
	
		$handled = array(
				'empcode'       => $this->empcode,
				'thname'        => $this->thname,
				'engname'       => $this->engname,
				'position'      => $this->position,
				'email'         => $this->email,
				'branchcode'    => $this->branch_code,
				'branch'        => $this->branch_name,
				'region_id'		=> $this->region_id,
				'region'		=> $this->region,
				'region_th'		=> $this->region_th,
				'bmname'		=> '-',
				'privileges'	=> (in_array($this->empcode, $this->bm_pilot)) ? array($role['ROLE_AM']) : $privileges,
				'is_logged_in'  => $this->is_logged_in,
				'secure'        => $this->secure,
				'role'			=> (in_array($this->empcode, $this->bm_pilot)) ? self::getRole($role, $role['ROLE_AM'], $this->branch_code) : $this->auth_role,
				'pilot'			=> $pilot_list// ADD NEW ON 12 NOV 2018
		);
		
		if(in_array($this->empcode, $this->config->item('AMActing'))) {
			array_push($handled['privileges'], $this->config->item('ROLE_AM'));
			rsort($handled['privileges']);
		}	

		if(!empty($handled['empcode'])) {
			
			$created = $this->sessionWriteInitial($handled);
			if($created == 'TRUE') {
				
				$emp_code        		= $this->session->userdata("empcode");
				$thname          		= $this->session->userdata("thname");
				$engname       			= $this->session->userdata("engname");
				$email         			= $this->session->userdata("email");
				$branch_code   			= $this->session->userdata("branchcode");
				$branch        			= $this->session->userdata("branch");
				$bmname		 			= $this->session->userdata("bmname");
				$position      			= $this->session->userdata("position");
				$region_id	 			= $this->session->userdata("region_id");
				$region		 			= $this->session->userdata("region");
				$region_th	 			= $this->session->userdata("region_th");
				$authorized    			= $this->session->userdata("privileges");
				$is_logged_in  			= $this->session->userdata("is_logged_in");
				$secure		 			= $this->session->userdata("secure");
				$auth_role		 		= $this->session->userdata("role");
				$pilot 				    = $this->session->userdata("pilot"); // ADD NEW ON 12 NOV 2018
				
				$session_handled		= array(
					'sess_empcode' 		=> $emp_code,
					'sess_thname'	    => $thname,
					'sess_engname' 		=> $engname,
					'sess_email'		=> $email,
					'sess_branch_code'	=> $branch_code,
					'sess_branch'		=> $branch,
					'sess_bmname'		=> $bmname,
					'sess_position'		=> $position,
					'sess_region_id'	=> $region_id,
					'sess_region'		=> $region,
					'sess_region_th'	=> $region_th,
					'sess_authorized'	=> $authorized,
					'sess_is_logged'	=> $is_logged_in,
					'sess_secure'		=> $secure,
					'sess_pilot'		=> $pilot // ADD NEW ON 12 NOV 2018
				);
				
				$this->load->helper('cookie');
				$this->input->set_cookie(
					'authen_info', 
					json_encode(
						array(
							'Deparment' => 'LENDING', 
							'Status'    => TRUE, 
							'Session'	=> $session_handled, 
							'Role'	    => !empty($authorized[0]) ? self::getRole($role, $authorized[0], $branch_code):'Unknown', 
							'Auth'      => $this->auth_role
								
						)
					), 
					(time() + 86500)
				);
			
				switch($authorized) {
					case $role['ROLE_CA']:
					case $role['ROLE_OPER']:
						
						$this->json_parse(
							array(
								'Deparment' => 'OTHER',
								'Status'	=> TRUE,
								'Session'	=> $session_handled,
								'Role'		=> !empty($authorized[0]) ? self::getRole($role, $authorized[0], $branch_code):'Unknown', 
								'Auth' 		=> $this->auth_role
							)
						);
						
					break;
					default:
						
						$this->json_parse(
							array(
								'Deparment' => 'LENDING',
								'Status'	=> TRUE,
								'Session'	=> $session_handled,
								'Role'		=> !empty($authorized[0]) ? self::getRole($role, $authorized[0], $branch_code):'Unknown', 
								'Auth' 		=> $this->auth_role
							)
						);
						
					break;
				}
			
			} else { 
				$this->json_parse(array('status' => false, 'msg' => 'Object session are cant created session...'));
			}
			
		} else {
			$this->json_parse(array('status' => false, 'msg' => 'No properties...'));
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
	
	private static function getRole($role, $authen, $branch_code) {

		if(!empty($authen)) {
			switch ($authen) {
				case $role['ROLE_ADMIN']:
					if($branch_code == '000') return 'admin_role';
					else return 'adminbr_role';					
				break;
				case $role['ROLE_RM']:
					return 'rm_role';
				break;
				case $role['ROLE_BM']:
					return 'bm_role';
				break;
				case $role['ROLE_AM']:
					return 'am_role';
				break;
				case $role['ROLE_RD']:
					return 'rd_role';
				break;
				case $role['ROLE_ADMINSYS']:
					return 'dev_role';
				break;
				case $role['ROLE_SPV']:
				case $role['ROLE_HQ']:
				default:
					return 'hq_role';
				break;
			}
			
		}
		
	}
	
	private function sessionWriteInitial($objSess) {
		$this->load->model('dbmodel');
		
		date_default_timezone_set("Asia/Bangkok");
		$this->session->set_userdata($objSess);
		
		// Insert Login-log
		
		$emp_code = ($objSess['empcode'] == '*') ? str_replace('T', '', $this->ad_user):$objSess['empcode'];
		$this->dbmodel->exec('SignIn_TransactionLog',
				array(
						"EmployeeCode"	=> $objSess['empcode'],
						"BranchCode"	=> $objSess['branchcode'],
						"EventDate"		=> date('Y-m-d H:i:s'),
						"IsActive"		=> 'A'
				), false, 'insert');
		
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
	
	public function loggedPass() {
		if(empty($this->online)) {
			redirect("authen/logout");
		} else {
			redirect('metro');
		}
	}
	
	public function logout() {
		$session = array(
				'emp_code'      => $this->session->userdata("empcode"),
				'thname'        => $this->session->userdata("thname"),
				'engname'       => $this->session->userdata("engname"),
				'email'         => $this->session->userdata("email"),
				'branch_code'   => $this->session->userdata("branchcode"),
				'branch'        => $this->session->userdata("branch"),
				'bmname'	    => $this->session->userdata("bmname"),
				'position'      => $this->session->userdata("position"),
				'region_id'	    => $this->session->userdata("region_id"),
				'region'	    => $this->session->userdata("region"),
				'region_th'	    => $this->session->userdata("region_th"),
				'authorized'    => $this->session->userdata("privileges"),
				'is_logged_in'  => $this->session->userdata("is_logged_in"),
				'secure'		=> $this->session->userdata("secure"),
				'role'			=> $this->session->userdata("role"),
				'pilot'			=> $this->session->userdata("pilot") // ADD NEW ON 12 NOV 2018
		);
		
		$this->session->unset_userdata($session);
		redirect("authen", 'refresh');
		
	}

	private function json_parse($objArr) {
		header('Content-type: application/json; charset="UTF-8"');
		echo json_encode($objArr);
	}
	
	
}