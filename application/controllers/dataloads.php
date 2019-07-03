<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dataloads extends CI_Controller {
	
	private $char_mode;
	
	private $role_ad;
	private $role_rm;
	private $role_bm;
	private $role_am;
	private $role_rd;
	private $role_hq;
	private $role_spv;
	private $role_admin;
	
	public function __construct() {
		parent::__construct();
		
		/** table structure */
		$this->table_profile                = $this->config->item('table_profile');
		$this->table_verification           = $this->config->item('table_verification');
		$this->table_applicationstatus      = $this->config->item('table_applicationstatus');
		$this->table_branch                 = $this->config->item('table_branch');
		$this->table_callout                = $this->config->item('table_callout');
		$this->table_docrefund              = $this->config->item('table_docrefund');
		$this->table_masterchannel          = $this->config->item('table_masterchannel');
		$this->table_masterdoc              = $this->config->item('table_masterdoc');
		$this->table_masterdowntown         = $this->config->item('table_masterdowntown');
		$this->table_masteremployee         = $this->config->item('table_employee');
		$this->table_ncb                    = $this->config->item('table_ncb');
		$this->table_product				= $this->config->item('table_product');
		$this->table_rmprocesslog           = $this->config->item('table_rmprocesslog');
		$this->table_exportlog              = $this->config->item('table_exportlog');
		$this->table_province				= $this->config->item('table_province');
		
		// New table
		$this->table_depmap					= $this->config->item('table_depmap');
		$this->table_duecustom				= $this->config->item('table_duecustom');
		$this->table_region					= $this->config->item('table_region');
		$this->table_revisitreason			= $this->config->item('table_revisitreason');
		$this->table_lackdoc				= $this->config->item('table_lackdoc');
		$this->table_ledingbranchs			= $this->config->item('table_lendingbranchs');
		$this->table_lendingemp				= "LendingEmp";
		
		// Role Permission
		$this->role_ad 						= $this->config->item('ROLE_ADMIN');
		$this->role_rm 						= $this->config->item('ROLE_RM');
		$this->role_bm 						= $this->config->item('ROLE_BM');
		$this->role_am 						= $this->config->item('ROLE_AM');
		$this->role_rd 						= $this->config->item('ROLE_RD');
		$this->role_hq 						= $this->config->item('ROLE_HQ');
		$this->role_spv 					= $this->config->item('ROLE_SPV');
		$this->role_admin 					= $this->config->item('ROLE_ADMINSYS');
		
		$this->char_mode					= $this->config->item('char_mode');
		
	}
	
	public function index() {
		$this->load->view('404');
	}
	
	// Stepper Router
	public function stepper() {
		$this->load->model('dbmodel');
	
		$doc 	 = $this->input->post('doc');
		$results = $this->dbmodel->CIQuery("
			SELECT [Profile].DocID, [Profile].IsActive as ProfileActice, Verification.IsActive as VerifyActive, ApplicationStatus.IsActive as AppStateActive
			FROM [Profile]
			LEFT OUTER JOIN Verification
			ON [Profile].DocID = Verification.DocID
			LEFT OUTER JOIN ApplicationStatus
			ON [Profile].DocID = ApplicationStatus.DocID
			WHERE [Profile].DocID = '".$doc."'");
		$this->json_parse($results);
		
	}
	
	public function checkCustomValid() {
		$this->load->library('effective');
		
		$cust_valid         = $this->input->post('name_valid');
		$comp_valid         = $this->input->post('comp_valid');
		$mob_valid          = $this->input->post('mob_valid');
		$tel_valid          = $this->input->post('tel_valid');

		if(empty($cust_valid) && empty($comp_valid) || empty($tel_valid) && empty($mob_valid)) {
			$Error = array(
					'event'		=> 'failed',
					'status'    => false,
					'msg'       => 'กรุณาระบุข้อมูลให้ครบถ้วน'
			);
			
			$this->json_parse($Error);
			
			
		} else {
			
			$wheres = '';
			if(!empty($cust_valid)) {
				$wheres .= " OR OwnerName LIKE '%".$this->effective->set_chartypes($this->char_mode, $cust_valid)."%'";
			}
			
			if(!empty($comp_valid)) {
				$wheres .= " OR Company LIKE '%".$this->effective->set_chartypes($this->char_mode, $comp_valid)."%'";
			}
			
			if(!empty($mob_valid)) {
				$wheres .= " OR Mobile = '".$mob_valid."'";
			}
		
			if(!empty($tel_valid)) {
				$wheres .= " OR Telephone = '".$tel_valid."'";
			}
			
			$result = $this->db->query("
				SELECT OwnerName, Company, Telephone, Mobile, CreateDate
				FROM   [Profile]
				WHERE NOT CreateDate IS NULL
				AND (IsActive = 'A' $wheres)")->result_array();
			
			if(!empty($result[0]['OwnerName'])) {
				$Error = array(
					'event'		=> 'found',
					'status'    => true,
					'msg'       => 'ขออภัย!! มีข้อมูลอยู่ในระบบแล้ว กรุณาตรวจสอบอีกครั้ง หรือหากคุณยืนยันจะสร้างเพิ่มกรุณา กดยืนยัน.'
				);
				
				$this->json_parse($Error);
				
			} else {
				$Error = array(
					'event'		=> 'not_found',
					'status'    => false,
					'msg'       => 'กรุณาระบุข้อมูลให้ครบถ้วน'
				);
			
				$this->json_parse($Error);
				
			}
		}
		
	}
	
	public function empInfoInitialyze() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$empcode         = $this->input->post('eidx');
		$branchcode		 = $this->input->post('brnx');
		
		if (empty($empcode)) {
			
			if(!empty($branchcode)) {
				
				$result = $this->dbmodel->loadData($this->table_lendingemp, "EmployeeCode, PositionTitle, BranchCode, FullNameEng, FullNameTh", array("BranchCode" => $branchcode, 'PositionTitle' => 'Branch Manager'));
				if(!empty($result['data'][0]['FullNameTh'])) {
					$data   = array(
							'data'   => array("EmployeeCode" => $result['data'][0]['EmployeeCode'], "FullnameTh" => $this->effective->get_chartypes($this->char_mode, $result['data'][0]['FullNameTh'])),
							'status' => true,
							'oper'   => 'view',
							'msg'    => ''
					);
					
					$this->json_parse($data);
				} else {
					$Error   = array(
							'data'      => $empcode,
							'status'    => false,
							'oper'      => 'edit',
							'msg'       => 'ไม่พบข้อมูลพนักงาน'
					);
					$this->json_parse($Error);
				}
				
				
				
			} else {
				
				$Error  = array(
						'data'      => $empcode,
						'status'    => false,
						'oper'      => 'view',
						'msg'       => '* กรุณาระบุรหัสพนักงาน'
				);
				
				$this->json_parse($Error);
				
			}
			
		
		
		} else {
		
			$checked     = $this->dbmodel->data_validation($this->table_lendingemp, array("*"), array("EmployeeCode" => $empcode), false);
			if($checked == "FALSE") {
				$Error   = array(
						'data'      => $empcode,
						'status'    => false,
						'oper'      => 'edit',
						'msg'       => '* ไม่พบข้อมูลพนักงาน'
				);
				$this->json_parse($Error);
		
			} else {
	
				$result = $this->dbmodel->CIQuery("
					SELECT 
						LendingEmp.EmployeeCode, LendingEmp.FullNameTh, LendingEmp.Nickname, 
						LendingEmp.RegionID, MasterRegion.RegionNameEng, LendingEmp.BranchCode, LendingBranchs.BranchDigit, 
						LendingBranchs.BranchName, LendingEmp.PositionTitle, LendingEmp.Mobile,
						LendingEmp.RoleSpecial, LendingEmp.IsActive AS Active
					FROM LendingEmp
					LEFT OUTER JOIN LendingBranchs
					ON LendingEmp.BranchCode = LendingBranchs.BranchCode
					LEFT OUTER JOIN MasterRegion
					ON LendingEmp.RegionID = MasterRegion.RegionID
					WHERE LendingEmp.IsActive = 'A'
					AND LendingEmp.EmployeeCode = '".$empcode."'	
				");
					
				$data   = array(
					'data'   => array(array("EmployeeCode" => $result['data'][0]['EmployeeCode'], "FullnameTh" => $this->effective->get_chartypes($this->char_mode, $result['data'][0]['FullNameTh']), "Mobile" => $result['data'][0]['Mobile'])),
					'status' => true,
					'oper'   => 'view',
					'msg'    => ''
				);
				
				$this->json_parse($data);

			}
		
		}
		
		
	}
	
	public function loadDowntown() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		
		//$result = $this->dbmodel->loadData($this->table_masterdowntown, "Downtown", false);
		$result = $this->dbmodel->CIQuery("
			SELECT DISTINCT ROW_NUMBER() OVER (ORDER BY BusinessLocation ASC) DowntownID, BusinessLocation AS Downtown, NULL AS Province, NULL AS RMName, 'A' AS IsActive
			FROM (
				SELECT Downtown AS BusinessLocation
				FROM  MasterDowntown
				UNION
				select BusinessLocation from [Profile] group by BusinessLocation
			) A
			WHERE BusinessLocation IS NOT NULL
		");
		
		$conv['data'] = array();
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'], array("Downtown" => $this->effective->get_chartypes($this->char_mode, $value['Downtown'])));
		}
		
		$this->json_parse($conv);
	
	}
	
	public function findEmployee() {
		$this->load->model('dbmodel');
		$this->load->library('effective');

		$result = $this->dbmodel->loadDataIn($this->table_masteremployee, "FullnameTh", array("BranchCode",
				array("001","002","003","004","005","006","007","008","009","010","011","012","013","014","015","016","018","901","902","903","904","905","906","907","908","777","601")),
				array("Active" => "A"), "NOTIN");	
		
		$conv['data'] = array();
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'], array("FullnameTh" => $this->effective->get_chartypes($this->char_mode, $value['FullnameTh'])));
		}
		
		$this->json_parse($conv);
		
	}
	
	public function province() {
		$this->load->model('dbmodel');
		$this->load->library('effective');

		$province = $this->input->post('prn');	
		$result   = $this->dbmodel->loadData($this->table_province, "Province, District", array("Province" => $this->effective->set_chartypes($this->char_mode, $province)));
		
		if(empty($result['data'])) {
			$this->json_parse(array("province" => $this->effective->get_chartypes($this->char_mode, "ไม่ระบุ"), "district" => $this->effective->get_chartypes($this->char_mode, "ไม่ระบุ")));
				
		} else {
				
			$conv['data'] = array();
			foreach($result['data'] as $index => $value) {
				array_push($conv['data'], array("province" => $this->effective->get_chartypes($this->char_mode, $value['Province']), "district" => $this->effective->get_chartypes($this->char_mode, $value['District'])));
			}
				
			$this->json_parse($conv);
				
		}
		
	
	}
	
	public function country() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$district = $this->input->post('dist');
	
		$result   = $this->dbmodel->loadData($this->table_province, "District, PostCode", array("District" => $this->effective->set_chartypes($this->char_mode, $district)));
	
		if(empty($result['data'])) {
			$this->json_parse(array("district" => $this->effective->get_chartypes($this->char_mode, "ไม่ระบุ"), "postcode" => $this->effective->get_chartypes($this->char_mode, "ไม่ระบุ")));
				
		} else {
				
			$conv['data'] = array();
			foreach($result['data'] as $index => $value) {
				array_push($conv['data'], array("district" => $this->effective->get_chartypes($this->char_mode, $value['District']), "postcode" => $this->effective->get_chartypes($this->char_mode, $value['PostCode'])));
			}
	
			$this->json_parse($conv);
	
		}
	
	
	}
	/*
	public function channels() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
		
		$result     = $this->dbmodel->loadDataIn($this->table_masterchannel, "SubChannel", array("SubChannel",
				array(
					'ลด',
					'แลก',
					'แจก',
					'แถม',
					'การจัดนิทรรศการ',
					'การจัดประกวด',
					'การจัดแข่งขัน',
				  	'ไทยเครดิต สินเชื่อเพื่อรายย่อย',
				  	'เอกสาร ของใช้ เป็น Thai Credit ทั้งหมด',
					'การคำนวนสินเชื่อยอดประเมิน และ ยอดผ่อนต่อปี ให้ลูกค้าก่อนสมัคร App',
				  	'เครื่องแบบ ชุดฟอร์มของพนักงานในการไปพบลุกค้า และ สาขา Lending Office')),
				array(false),
				"NOTIN");
	
		$conv['data'] = array();
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'], array("SubChannel" => $this->effective->get_chartypes($this->char_mode, $value['SubChannel'])));
		}
	
		$this->json_parse($conv);
	}
		
	public function channeltypes() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
		
		$channel_type       = $this->effective->set_chartypes($this->char_mode, $this->input->post('channeltypes'));
		if (empty($channel_type)) {
			$Error          = array(
					'data'      => $channel_type,
					'status'    => false,
					'msg'       => 'เกิดข้อผิดพลาด'
			);
			$this->json_parse($Error);
	
		} else {
			$result = $this->dbmodel->loadData($this->table_masterchannel, "Channel", array('SubChannel' => $channel_type));
			$this->json_parse($result);
	
		}
	
	}
	*/
	
	public function channeltypes() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
		
		$channel_type = $this->dbmodel->CIQuery("SELECT DISTINCT [Channel] FROM [PCIS].[dbo].[MasterChannel] WHERE [IsActive] = 'A'");
		$this->json_parse($channel_type);
		
	}
	
	public function channels() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
		
		$channel_type       = $this->effective->set_chartypes($this->char_mode, $this->input->post('channeltypes'));
		
		$result = $this->dbmodel->CIQuery("SELECT [Channel], [SubChannel] FROM [PCIS].[dbo].[MasterChannel] WHERE [IsActive] = 'A' AND [Channel] = '".$channel_type."'");
		$this->json_parse($result);
		
	}
	
	public function channeltypesAll() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
		
		$channel_type = $this->dbmodel->CIQuery("SELECT DISTINCT [Channel] FROM [PCIS].[dbo].[MasterChannel]");
		$this->json_parse($channel_type);
	}
	
	public function channelsAll() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
		
		$channel_type       = $this->effective->set_chartypes($this->char_mode, $this->input->post('channeltypes'));
		
		$result = $this->dbmodel->CIQuery("SELECT [Channel], [SubChannel] FROM [PCIS].[dbo].[MasterChannel] WHERE [Channel] = '".$channel_type."'");
		$this->json_parse($result);
	}
	
	
	public function newproductionType() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
	
		$result			= $this->dbmodel->CIQuery("SELECT ProductTypeID, ProductTypeName, ProductType, IsActive FROM ProductType WHERE IsActive = 'A' AND ProductTypeID IN (1,2,4,6) ORDER BY ProductTypeID ASC");
		$conv['data'] = array();
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'], array("ProductTypeID" => $value['ProductTypeID'], "ProductTypeName" => $this->effective->get_chartypes($this->char_mode, $value['ProductTypeName']), "ProductType" => trim($value['ProductType'])));
		}
		$this->json_parse($conv);
	}
	
	public function productionType() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
		
		$result			= $this->dbmodel->CIQuery("SELECT ProductTypeID, ProductTypeName, ProductType, IsActive FROM ProductType WHERE IsActive = 'A' ORDER BY ProductTypeID ASC");
		$conv['data'] = array();
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'], array("ProductTypeID" => $value['ProductTypeID'], "ProductTypeName" => $this->effective->get_chartypes($this->char_mode, $value['ProductTypeName']), "ProductType" => trim($value['ProductType'])));
		}
		$this->json_parse($conv);
	}
	
	public function productlist() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
		
		$result			= $this->dbmodel->CIQuery("			
			SELECT ProductCode, ProductType.ProductTypeID, ProductName, ProductTypes, ProductType.ProductType
			FROM MasterProductDropdown 
			LEFT OUTER JOIN ProductType
			ON MasterProductDropdown.ProductTypeID = ProductType.ProductTypeID
			WHERE NOT New = 'Y'				
			AND MasterProductDropdown.IsActive = 'A'
			ORDER BY ProductType.ProductTypeID ASC, ProductCode ASC, ProductTypes ASC");
		
		$conv['data'] = array();
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'],
				array("ProductCode" 	=> $value['ProductCode'],
						"ProductTypeID" 	=> $value['ProductTypeID'],
						"ProductName" 	=> $this->effective->get_chartypes($this->char_mode, $value['ProductName']),
						"ProductTypes" 	=> trim($value['ProductTypes']),
						"ProductType" 	=> trim($value['ProductType']),
						"ProductSub" 		=> substr($value['ProductCode'], -2, 2)
				)
			);
		}
		
		$this->json_parse($conv);
		
	}
	
	public function productNewlist() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
	
		$result			= $this->dbmodel->CIQuery("
			SELECT ProductCode, ProductType.ProductTypeID, ProductName, ProductTypes, ProductType.ProductType
			FROM MasterProductDropdown
			LEFT OUTER JOIN ProductType
			ON MasterProductDropdown.ProductTypeID = ProductType.ProductTypeID
			WHERE New = 'Y'
			AND MasterProductDropdown.IsActive = 'A'
			ORDER BY ProductType.ProductTypeID ASC, ProductCode ASC, ProductTypes ASC");
	
		$conv['data'] = array();
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'],
				array("ProductCode" 	=> $value['ProductCode'],
						"ProductTypeID" 	=> $value['ProductTypeID'],
						"ProductName" 	=> $this->effective->get_chartypes($this->char_mode, $value['ProductName']),
						"ProductTypes" 	=> trim($value['ProductTypes']),
						"ProductType" 	=> trim($value['ProductType']),
						"ProductSub" 		=> substr($value['ProductCode'], -2, 2)
					)
				);
		}
	
		$this->json_parse($conv);
	
	}
	
	public function loadProductForNewWhiteboard() {
		
		$this->load->model("dbmodel");
		$this->load->library('effective');
		
		$result	= $this->dbmodel->CIQuery("
			SELECT ProductCode, ProductType.ProductTypeID, ProductTypeName,
			ProductName, ProductTypes, ProductType.ProductType
			FROM MasterProductDropdown
			LEFT OUTER JOIN ProductType
			ON MasterProductDropdown.ProductTypeID = ProductType.ProductTypeID
			WHERE New = 'Y'
			AND MasterProductDropdown.IsActive = 'A'
			ORDER BY ProductType.ProductTypeID ASC, ProductCode ASC, ProductTypes ASC");
		
		$conv['data'] = array();
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'],
				array("ProductCode" 		=> $value['ProductCode'],
					  "ProductTypeID" 		=> $value['ProductTypeID'],
					  "ProductTypeName"		=> $this->effective->get_chartypes($this->char_mode, $value['ProductTypeName']),
					  "ProductName" 		=> $this->effective->get_chartypes($this->char_mode, $value['ProductName']),
					  "ProductCat" 			=> trim($value['ProductTypes']),
					  "ProductType" 		=> trim($value['ProductType']),
					  "ProductShortCode" 	=> trim($value['ProductTypes']) .'-'. substr($value['ProductCode'], -2, 2)
					  
				)
			);
		}
		
		$this->json_parse($conv);

	}
	
	public function filterProductProgramList() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
	
		$productType 	= $this->input->post('productType');
		
		$where = "WHERE Product.IsActive = 'A'";
		if(empty($productType)) {
			
			
		} else {			

			if(in_array('Clean Loan', $productType)) {
				$where .= " AND ProductType.ProductType = 'Clean Loan'";
			}
			
			if(in_array('Clean Loan', $productType) && in_array('Refinace', $productType) && !in_array('Non-Refinace', $productType)) {
				$where .= " OR ProductType.ProductType = 'Secure Loan' AND NOT ProductName LIKE '%rehousing%' AND NOT ProductName LIKE '%รีไฟแนนซ์%' AND NOT ProductName LIKE '%Re%'";
			}

			if(in_array('Clean Loan', $productType) && !in_array('Refinace', $productType) && in_array('Non-Refinace', $productType)) {
				$where .= " OR ProductType.ProductType = 'Secure Loan' AND ProductName LIKE '%rehousing%' OR ProductName LIKE '%รีไฟแนนซ์%' OR ProductName LIKE '%Re%'";
			}
			
			
			if(in_array('Refinace', $productType) && !in_array('Non-Refinace', $productType)) {
				$where .= " AND NOT ProductName LIKE '%rehousing%' AND NOT ProductName LIKE '%รีไฟแนนซ์%' AND NOT ProductName LIKE '%Re%' AND ProductType.ProductType = 'Secure Loan'";
				
			}
			
			if(in_array('Non-Refinace', $productType) && !in_array('Refinace', $productType)) {
				$where .= " AND ProductName LIKE '%rehousing%' OR ProductName LIKE '%รีไฟแนนซ์%' OR ProductName LIKE '%Re%'";
				
			}
			
			if(in_array('Refinace', $productType) && in_array('Non-Refinace', $productType)) {
				$where .= " AND ProductType.ProductType = 'Secure Loan'";
			}
			
		}
		
		if($where === "WHERE Product.IsActive = 'A' AND ProductType.ProductType = 'Clean Loan' AND ProductType.ProductType = 'Secure Loan'") {
			$condition = " WHERE Product.IsActive = 'A' AND ProductType.ProductType in ('Clean Loan', 'Secure Loan')";
		
		} else {
			$condition = $where;
		}
		
		$result			= $this->dbmodel->CIQuery("
			SELECT ProductCode, ProductType.ProductTypeID, ProductName, ProductTypes, ProductType.ProductType
			FROM Product
			LEFT OUTER JOIN ProductType
			ON Product.ProductTypeID = ProductType.ProductTypeID
			$condition
			ORDER BY ProductType.ProductTypeID ASC, ProductCode ASC, ProductTypes ASC");
	
		$conv['data'] = array();
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'], 
					array("ProductCode" 	=> $value['ProductCode'], 
						  "ProductTypeID" 	=> $value['ProductTypeID'], 
						  "ProductName" 	=> $this->effective->get_chartypes($this->char_mode, $value['ProductName']), 
						  "ProductTypes" 	=> trim($value['ProductTypes']), 
						  "ProductType" 	=> trim($value['ProductType']),  
						  "ProductSub" 		=> substr($value['ProductCode'], -2, 2)						
					)
			);
		}
	
		$this->json_parse($conv);
		
	}
	
	
	public function dueCustomStatus() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
		
		$result       = $this->dbmodel->loadData($this->table_duecustom, "DueID, DueReason", FALSE);
		if(empty($result['data'])) {
			
			$Error          = array(
					'data'      => $result,
					'status'    => false,
					'msg'       => 'เกิดข้อผิดพลาด'
			);
			$this->json_parse($Error);
			
		} else {
			
			$conv['data'] = array();
			foreach($result['data'] as $index => $value) {
				array_push($conv['data'], array("DueID" => $value['DueID'], "DueReason" => $this->effective->get_chartypes($this->char_mode, $value['DueReason'])));
			}
			
			$this->json_parse($conv);
		}
		
	}
	
	public function areaInfo() {
		$this->load->model('dbcustom');
		$this->load->library('effective');
		
		$branchCode   = $this->input->post('brn');
		$result       = $this->dbcustom->getAreaInfo($branchCode);
		
		if(empty($result['data'])) {
				
			$Error          = array(
					'data'      => $result,
					'status'    => false,
					'msg'       => 'เกิดข้อผิดพลาด'
			);
			$this->json_parse($Error);
				
		} else {
				
			$conv['data'] = array();
			foreach($result['data'] as $index => $value) {
				array_push($conv['data'], array(
					"RegionNameEng" => strtoupper($value['RegionNameEng']), 
					"BranchCode" 	=> $value['BranchCode'], 
					"BranchName" 	=> $this->effective->get_chartypes($this->char_mode, $value['BranchName'])
					)
				);
			}
				
			$this->json_parse($conv);
			
		}
		
	}
	
	public function getAreaInfo() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$region_id   = $this->input->post('RegionID');
		$condition	 = !empty($region_id) ? array('ActiveStatus' => 1, 'RegionID' => $region_id):array('ActiveStatus' => 1);
		$result      = $this->dbmodel->loadData('VMasterArea', "*", $condition);
				
		if(empty($result['data'])) {
			$Error          = array(
					'data'      => $result,
					'status'    => false,
					'msg'       => 'เกิดข้อผิดพลาด'
			);
			$this->json_parse($Error);
		
		} else {
		
			$conv['data'] = array();
			foreach($result['data'] as $index => $value) {
				array_push($conv['data'], array(
						"AreaCode" 		=> $value['AreaCode'],
						"AreaName" 		=> $value['AreaName'],
						"AreaShortCode" => $value['AreaShortCode'],
						"AreaFullName"  => $value['AreaFullName'],
						"RegionID"		=> $value['RegionID']
					)
				);
			}
		
			$this->json_parse($conv);
				
		}
	}
	
	public function branchInfo() {
		$this->load->model('dbcustom');
		$this->load->library('effective');
	
		$branchCode   = $this->input->post('brn');
		$result       = $this->dbcustom->getBranchnIfo($branchCode);
		
		if(empty($result['data'][0]['FullNameTh'])) {
	
			$Error          = array(
					'data'      => '',
					'status'    => false,
					'msg'       => 'เกิดข้อผิดพลาด'
			);
			$this->json_parse($Error);
	
		} else {
			
			$conv['data'] = array("BMName" => $this->effective->get_chartypes($this->char_mode, $result['data'][0]['FullNameTh']));
			$this->json_parse($conv);
				
		}
	
	}
	
	public function getBMList() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$where = '';
		$branch_code = $this->input->post('brnx');		
		
		if(!empty($branch_code[0])):
			$where_branch   	= "'".implode("','", $branch_code)."'";
		else:
			$where_branch   	= "";
		endif;
		
		if(!empty($branch_code[0])) { $where .= " AND ISNULL(LendingEmp.BranchCode, LendingEmp.OfficeBase) in ($where_branch) "; }
		
		$result = $this->dbmodel->CIQuery("
		SELECT EmployeeCode, FullNameTh, LendingEmp.BranchCode, BranchName 
		FROM LendingEmp 
		LEFT OUTER JOIN LendingBranchs
		ON LendingEmp.BranchCode = LendingBranchs.BranchCode
		WHERE LendingEmp.IsActive = 'A' 
		AND PositionTitle LIKE '%Branch Manager%'
		$where");
		
		$conv['data'] = array();
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'], array(
					"EmployeeCode" 	=> $value['EmployeeCode'],					
					"FullNameTh"  	=> $this->effective->get_chartypes($this->char_mode, $value['FullNameTh']),
					"BranchCode"  	=> $value['BranchCode'],
					"BranchName"  	=> str_replace('สาขา', '', $this->effective->get_chartypes($this->char_mode, $value['BranchName']))
				)
			);
		}
		
		$conv['status']     = true;
		$conv['msg']     	= 'Inquiry succesfully.';
		$this->json_parse($conv);
		 
	}
	
	public function loadBranchManagerList() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		$branch_code = $this->input->post('brnx');
		$souce_data  = $this->input->post('source_channel');
		
// 		$str_name	 = '';
// 		if($souce_data == 'BM') $str_name = 'Branch Manager';
// 		else $str_name = 'Relationship Manager';
	
		if(!empty($branch_code)) { 
			//$bm_set = $this->dbmodel->loadData('LendingEmp', '*', array('BranchCode' => $branch_code, 'PositionTitle' => 'Branch Manager', 'IsActive' => 'A')); 
			$bm_set= $this->dbmodel->CIQuery("
					SELECT * FROM LendingEmp
					WHERE LendingEmp.IsActive = 'A'
					AND BranchCode = '".$branch_code."'
					AND PositionTitle LIKE '%Branch Manager%'
					ORDER BY RoleSpecial DESC");
	
			
		} else { $bm_set = array(); }
	
		// 		$result = $this->dbmodel->CIQuery("
		// 				SELECT EmployeeCode, FullNameTh, LendingEmp.BranchCode, BranchName
		// 				FROM LendingEmp
		// 				LEFT OUTER JOIN LendingBranchs
		// 				ON LendingEmp.BranchCode = LendingBranchs.BranchCode
		// 				WHERE LendingEmp.IsActive = 'A'
		// 				AND PositionTitle LIKE '%Branch Manager%'");
	
		// 		$conv['data'] = array();
		// 		foreach($result['data'] as $index => $value) {
		// 			array_push($conv['data'], array(
		// 					"EmployeeCode" 	=> $value['EmployeeCode'],
		// 					"FullNameTh"  	=> $this->effective->get_chartypes($this->char_mode, $value['FullNameTh']),
		// 					"BranchCode"  	=> $value['BranchCode'],
		// 					"BranchName"  	=> str_replace('สาขา', '', $this->effective->get_chartypes($this->char_mode, $value['BranchName']))
		// 				)
		// 			);
		// 		}
	
		$conv['status']     = true;
		$conv['manager']	= !empty($bm_set['data'][0]) ? array("BMCode" => $bm_set['data'][0]['EmployeeCode'], "BMName" => $this->effective->get_chartypes($this->char_mode, $bm_set['data'][0]['FullNameTh'])):null;
		$conv['msg']     	= !empty($bm_set['data'][0]) ? 'Inquiry succesfully':'Inquiry failed';
		$this->json_parse($conv);
			
	}
	
	public function branchList() {
		$this->load->model('dbmodel');
		
		$result	= $this->dbmodel->CIQuery("
					select Distinct BranchDigit, BranchCode from depmap
					where NOT BranchDigit in ('C', 'S', 'E', 'BKK', 'NE') 
					AND NOT BranchDigit = ''
					ORDER BY BranchDigit");
		
		$this->json_parse($result);
		
	}
	
	public function regionInfo() {
		$this->load->model("dbmodel");
		
		$result       = $this->dbmodel->loadData($this->table_region, "*", array('IsActive' => 'A', 'RegionID !=' => '01'));
	
		$conv['data'] = array();
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'], array("RegionID" => $value['RegionID'], "RegionNameEng" => strtoupper($value['RegionNameEng'])));
		}
		
		$this->json_parse($conv);
		
	}
	
	public function getBranchListAll() {
		$this->load->model("dbmodel");
		$this->load->library("effective");
	
		$result       = $this->dbmodel->loadData($this->table_ledingbranchs, "*", array('IsActive' => 'A', 'BranchCode !=' => '000'));
	
		$conv['data'] = array();
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'], array(
					"RegionID" => $value['RegionID'], 
					"BranchCode" => $value['BranchCode'], 
					"BranchName" => $this->effective->get_chartypes($this->char_mode, $value['BranchName']), 
					"BranchDigit" => $value['BranchDigit']				
				)
			);
		}
	
		$this->json_parse($conv);
	
	}
	
	public function revisitList() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
		
		$result       = $this->dbmodel->loadData($this->table_revisitreason, "*", FALSE);
		
		$conv['data'] = array();
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'], array("RevisitID" => $value['RevisitID'], "RevisitReason" =>  $this->effective->get_chartypes($this->char_mode, $value['RevisitReason'])));
		}
		
		$this->json_parse($conv);
		
		
	}
	
	public function revisitListChecked() {
		$this->load->model("dbmodel");
		
		$doc_id 	  = $this->input->post('relx');
		if(empty($doc_id)) {
	
			$Error = array(
				'data'      => '',
				'status'    => false,
				'msg'       => 'เกิดข้อผิดพลาด'
			);
			
			$this->json_parse($Error);
	
		} else {
			
			$verify       = $this->dbmodel->loadData('Verification', "VerifyID", array('DocID' => $doc_id));
			$result       = $this->dbmodel->loadData('ReActivateList', "*", array('VerifyID' => $verify['data'][0]['VerifyID'], 'IsActive' => 'A'));
			
			$this->json_parse($result);
			
		}
			
	}
	
	
	public function criteriaReasonList() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
		
		$result       = $this->dbmodel->loadData("MasterCriteriaReason", "CriteriaReasonID, CriteriaReason", array("IsActive" => 'A'));
	
		$conv['data'] = array();
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'], array("CriteriaReasonID" => $value['CriteriaReasonID'], "CriteriaReason" =>  $this->effective->get_chartypes($this->char_mode, $value['CriteriaReason'])));
		}
	
		$this->json_parse($conv);
	}
	
	
	public function lackdoc() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
		
		$result       = $this->dbmodel->loadData($this->table_lackdoc, "*", FALSE);
	
		$conv['data'] = array();
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'], array("LackID" => $value['LackID'], "LackDoc" =>  $this->effective->get_chartypes($this->char_mode, $value['LackDoc'])));
		}
	
		$this->json_parse($conv);
	
	
	}
	
	public function lackcategory() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
		
		$doc_group 	  = $this->input->post('typex');
		$result       = $this->dbmodel->CIQuery("SELECT * FROM MasterLackCat WHERE IsActive = 'A' AND LackStatus IN ('N', 'A') ORDER BY LackGroupID ASC"); //AND LackCatType = '".$doc_group."'  OR LackCatType = 'O' 
		
		$conv['data'] = array();
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'], array("LackGroupID" => $value['LackGroupID'], "LackCategory" =>  $this->effective->get_chartypes($this->char_mode, $value['LackCategory'])));
		}
		
		$this->json_parse($conv);
		
	}
	
	public function lackdoctype() {
		$this->load->model("dbmodel");
		$this->load->library('effective');
		
		$doc_group 	  = $this->input->post('typex');
		$result       = $this->dbmodel->CIQuery("SELECT * FROM MasterLackDoc WHERE IsActive = 'A' AND LackStatus IN ('N', 'A') ORDER BY LackID ASC"); // AND LackDocType = '".$doc_group."'  OR LackDocType = 'O'
	
		$conv['data'] = array();
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'], array("LackID" => $value['LackID'], "LackGroupID" => $value['LackGroupID'], "LackDoc" =>  $this->effective->get_chartypes($this->char_mode, $value['LackDoc']), "LackSpecify" => $value['LackSpecify'], 'ImportantDoc' => $value['Important']));
		}
	
		$this->json_parse($conv);		
	
	}
	
	// New Implement 21/01/2015
	public function loadInformation() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$id_card = $this->input->post('keys');
		
		if(empty($id_card)) {
		
			$this->json_parse(array(
					'data'      => '',
					'status'    => false,
					'msg'       => 'โปรดระบุหมายเลขบัตรประชาชน.'
			));
		
		} else {
		
			$result = $this->dbmodel->CIQuery("
				SELECT [Profile].*, Verification.ID_Card, Verification.BasicCriteria
				FROM [Profile]
				LEFT OUTER JOIN Verification
				ON [Profile].DocID = Verification.DocID
				WHERE ID_Card = '".$id_card."'");
			
			
			if(empty($result['data'][0]['ID_Card'])) {
				$this->json_parse(array(
						'data'      => '',
						'status'    => false,
						'msg'       => 'ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง.'
				));
					
			} else {
					
				$conv['data']   = array();
				foreach($result['data'] as $index => $value) {
					array_push($conv['data'],
					array(
					"Interest"    		=> $value['Interest'],
					"SourceOfCustomer"  => $this->effective->get_chartypes($this->char_mode, $value['SourceOfCustomer']),
					"SourceOption"    	=> $this->effective->get_chartypes($this->char_mode, $value['SourceOption']),
					"CSPotential"    	=> $value['CSPotential'],
					"OwnerType"    		=> $value['OwnerType'],
					"PrefixName"    	=> $this->effective->get_chartypes($this->char_mode, $value['PrefixName']),
					"OwnerName"    		=> $this->effective->get_chartypes($this->char_mode, $value['OwnerName']),
					"PrefixCorp"    	=> $this->effective->get_chartypes($this->char_mode, $value['PrefixCorp']),
					"Company"    		=> $this->effective->get_chartypes($this->char_mode, $value['Company']),
					"BusinessType"      => $this->effective->get_chartypes($this->char_mode, $value['BusinessType']),
					"Business"   		=> $this->effective->get_chartypes($this->char_mode, $value['Business']),
					"Telephone"    		=> $value['Telephone'],
					"Mobile"    		=> $value['Mobile'],
					"Downtown"    		=> $this->effective->get_chartypes($this->char_mode, $value['Downtown']),
					"Address"    		=> $this->effective->get_chartypes($this->char_mode, $value['Address']),
					"Province"    		=> $this->effective->get_chartypes($this->char_mode, $value['Province']),
					"District"    		=> $this->effective->get_chartypes($this->char_mode, $value['District']),
					"Postcode"    		=> $value['Postcode'],
					"Channel"    		=> $this->effective->get_chartypes($this->char_mode, $value['Channel']),
					"SubChannel"    	=> $this->effective->get_chartypes($this->char_mode, $value['SubChannel']),
					"RequestLoan"    	=> $value['RequestLoan'],
					"ReferralCode"    	=> $value['ReferralCode'],
					"BasicCriteria"     => $value['BasicCriteria'],
					"CriteriaRemark"    => $this->effective->get_chartypes($this->char_mode, $value['CriteriaRemark']),
					"Remark"    		=> $this->effective->get_chartypes($this->char_mode, $value['Remark'])
					)	
				);
					
				$this->json_parse($conv);
			
				}
			
			}
			
		
			
		}
				
		
		
	}
	

	public function getDocumentErrorlist() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$result	 = $this->dbmodel->CIQuery("
			SELECT * FROM MasterErrorList
			WHERE IsActive = 'A'
		");
		

		if(empty($result['data'][0]['Category'])) {
			$this->json_parse(array(
				'data'      => '',
				'status'    => false,
				'msg'       => 'ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง.'
			));
				
		} else {
			
			$conv['data']   = array();
			foreach($result['data'] as $index => $value) {
				
				array_push($conv['data'],
					array(
						"Cat_Code" 		=> $result['data'][$index]['Cat_Code'],
						"Category"		=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['Category']),
						"Sub_Cat"		=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['Sub_Cat']),
						"Priority"		=> $result['data'][$index]['Priority']
					)
				);

			}
			
			$this->json_parse($conv);
			
		}
	
	}
	
	
	public function branchBoundary() {
		$this->load->model('dbprogress');		
		$this->load->library('effective');
		
		$region_id = $this->input->post('rgnidx');		
		if(empty($region_id)) {
			
			$this->emp_id     = $this->session->userdata("empcode");
			$this->authorized = $this->session->userdata("privileges");					
			
			$result	= $this->dbprogress->appProgressBranch($this->authorized, array($this->emp_id));
			
			if(!empty($result['data'][0]['BranchCode'])) {
				
				$conv['data']   = array();
				foreach($result['data'] as $index => $value) {
					array_push($conv['data'],
						array(
								"RegionID"		=> $result['data'][$index]['RegionID'],
								"BranchCode" 	=> $result['data'][$index]['BranchCode'],
								"BranchDigit"	=> $result['data'][$index]['BranchDigit'],
								"BranchName"	=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['BranchName'])
						)
					);
				}
				
				$conv['status'] = true;
				$this->json_parse($conv);
				
			} else {
				$this->json_parse(array(
						'data'      => '',
						'status'    => false,
						'msg'       => 'ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง.'
					)
				);
			}
			
		} else {
			
			$result	= $this->dbprogress->setBranchBoundary(trim($region_id));
			
			$conv['data']   = array();
			foreach($result['data'] as $index => $value) {
				array_push($conv['data'],
						array(
							"RegionID"		=> $result['data'][$index]['RegionID'],
							"BranchCode" 	=> $result['data'][$index]['BranchCode'],
							"BranchDigit"	=> $result['data'][$index]['BranchDigit'],
							"BranchName"	=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['BranchName'])
						)
				);
			}
			
			$conv['status'] = true;			
			$this->json_parse($conv);
		}
		
		
	}
	
	public function appProgressBranch() {
		$this->load->model('dbmodel');
		$this->load->library('effective');

		$auth  		= $this->input->post('auth');
		$emp_id	    = $this->input->post('xemp');
		$region_id  = $this->input->post('xreg');
		$branchcode = $this->input->post('xbrn');
		
		$authority	= !empty($auth) ? explode(',', $auth):'';
		
		if(empty($authority)) {
	
			$objForms = array(
					"Privileges" => $authority,
					"Condition"	 => $condition,
					"Optional"	 => $optional
			);
	

		} else {
				
			if(count($authority) > 1):
				$privileges = $authority[0];
			else:
				$privileges = $authority[0];
			endif;
	
			$employees = $this->employeesInfo($emp_id);
			$branchs   = str_pad($branchcode, 3, "0", STR_PAD_LEFT);
				
			switch ($privileges) {
				case $this->role_ad:
				case $this->role_rm:
				case $this->role_bm:
				case $this->role_hq:
				case $this->role_spv:
				case $this->role_admin:
	
					if($branchs == "000" || $branchs == "901") {
	
						$result = $this->dbmodel->CIQuery("
							SELECT RegionID, BranchCode, BranchDigit, BranchName
							FROM LendingBranchs
							ORDER BY BranchDigit ASC");				
	
					} else {
										
						// Admin are not head office
						// Check has authority area manager
						$select_privilege = '';
						if(in_array($this->role_am, $authority)):
							$select_privilege = " WHERE BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$emp_id."' AND IsActive = 'A' GROUP BY BranchCode)";
						else:
							$select_privilege = " WHERE BranchCode = '".$branchcode."'";
						endif;
	
						$result = $this->dbmodel->CIQuery("
							SELECT
							LendingBranchs.RegionID, MasterRegion.RegionNameEng, LendingBranchs.BranchCode, LendingBranchs.BranchDigit, LendingBranchs.BranchName
							FROM LendingBranchs
							LEFT OUTER JOIN MasterRegion
							ON LendingBranchs.RegionID = MasterRegion.RegionID
							$select_privilege
							ORDER BY LendingBranchs.BranchDigit ASC");					
	
					}
					
					$conv['data']   = array();
					foreach($result['data'] as $index => $value) {
						array_push($conv['data'],
							array(
									"BranchCode" 	=> $result['data'][$index]['BranchCode'],
									"BranchDigit"	=> $result['data'][$index]['BranchDigit'],
									"BranchName"	=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['BranchName'])
							)
						);
					}
						
					$this->json_parse($conv);
						
					break;
				case $this->role_am:
						
					$result	= $this->dbmodel->CIQuery("
						SELECT
						LendingBranchs.RegionID, MasterRegion.RegionNameEng, LendingBranchs.BranchCode, LendingBranchs.BranchDigit, LendingBranchs.BranchName
						FROM LendingBranchs
						LEFT OUTER JOIN MasterRegion
						ON LendingBranchs.RegionID = MasterRegion.RegionID
						WHERE LendingBranchs.BranchCode in (SELECT BranchCode FROM AreaBoundary WHERE EmployeeCode = '".$emp_id."' GROUP BY BranchCode)
						ORDER BY LendingBranchs.BranchDigit ASC");
					
					$conv['data']   = array();
					foreach($result['data'] as $index => $value) {
						array_push($conv['data'],
								array(
										"BranchCode" 	=> $result['data'][$index]['BranchCode'],
										"BranchDigit"	=> $result['data'][$index]['BranchDigit'],
										"BranchName"	=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['BranchName'])
								)
								);
					}
						
					$this->json_parse($conv);
						
					break;
				case $this->role_rd:
						
					$result = $this->dbmodel->CIQuery("
						SELECT
						LendingBranchs.RegionID, MasterRegion.RegionNameEng, LendingBranchs.BranchCode, LendingBranchs.BranchDigit, LendingBranchs.BranchName
						FROM LendingBranchs
						LEFT OUTER JOIN MasterRegion
						ON LendingBranchs.RegionID = MasterRegion.RegionID
						WHERE LendingBranchs.BranchCode in (SELECT BranchCode FROM LendingBranchs WHERE RegionID = '".$region_id."' GROUP BY BranchCode)
						ORDER BY LendingBranchs.BranchDigit ASC");
					
					$conv['data']   = array();
					foreach($result['data'] as $index => $value) {
						array_push($conv['data'],
								array(
										"BranchCode" 	=> $result['data'][$index]['BranchCode'],
										"BranchDigit"	=> $result['data'][$index]['BranchDigit'],
										"BranchName"	=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['BranchName'])
								)
								);
					}
						
					$this->json_parse($conv);
										
					break;
	
			}
		
		}
	
	}
	
	public function employeesInfo($emp_code) {
		$this->load->model('dbmodel');
		if(empty($emp_code)) {
			throw new Exception(__function__.' method is exception handled please check argusment was null.');
				
		} else {
				
			$result = $this->dbmodel->CIQuery("
				SELECT
					LendingEmp.EmployeeCode, LendingEmp.FullnameTh, LendingEmp.FullnameEng, LendingEmp.Nickname, LendingEmp.PositionTitle,
					LendingEmp.Mobile, LendingEmp.RegionID, MasterRegion.RegionNameTh, MasterRegion.RegionNameEng,
					LendingEmp.BranchCode, LendingBranchs.BranchName, LendingBranchs.BranchDigit,
					LendingEmp.RoleSpecial, LendingEmp.IsActive
				FROM LendingEmp
				LEFT OUTER JOIN LendingBranchs
				ON LendingEmp.BranchCode = LendingBranchs.BranchCode
				LEFT OUTER JOIN MasterRegion
				ON LendingEmp.RegionID = MasterRegion.RegionID
				WHERE LendingEmp.IsActive = 'A'
				AND LendingEmp.EmployeeCode = '".$emp_code."'
			");
				
			return $result;
				
		}
	
	}
	
		
	public function getRMListBoundary() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$branchs = $this->input->post('branchcode');
		if(!empty($branchs[0])) {
			
			if(!empty($branchs[0])) {
				$where_brachs 	= "'".implode("','", $branchs)."'";
			} else {
				$where_brachs   = "";
			}
			
			$SQL = "SELECT EmployeeCode, FullNameEng, FullNameTh, PositionTitle, 
					CASE PositionTitle
						WHEN 'Branch Manager' THEN 'BM'
						WHEN 'Relationship Manager' THEN 'RM'
					END AS User_Role, LendingEmp.RegionID, 
					LendingEmp.BranchCode, LendingBranchs.BranchDigit,
					LendingBranchs.BranchName
					FROM LendingEmp
					LEFT OUTER JOIN LendingBranchs
					ON LendingEmp.BranchCode = LendingBranchs.BranchCode
					WHERE LendingEmp.PositionTitle in ('Relationship Manager', 'Branch Manager')
					AND LendingBranchs.BranchDigit in ($where_brachs)
					AND LendingEmp.IsActive = 'A'
					ORDER BY User_Role ASC";

		} else {
			
			$SQL = "
			SELECT EmployeeCode, FullNameEng, FullNameTh, PositionTitle,
			CASE PositionTitle
			WHEN 'Branch Manager' THEN 'BM'
			WHEN 'Relationship Manager' THEN 'RM'
			END AS User_Role, LendingEmp.RegionID,
			LendingEmp.BranchCode, LendingBranchs.BranchDigit, 
			LendingBranchs.BranchName
			FROM LendingEmp
			LEFT OUTER JOIN LendingBranchs
			ON LendingEmp.BranchCode = LendingBranchs.BranchCode
			WHERE LendingEmp.PositionTitle in ('Relationship Manager', 'Branch Manager')
			AND LendingEmp.IsActive = 'A'
			ORDER BY User_Role ASC";
			
			
		}
		
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
						array(
							"EmployeeCode" 	 => $result['data'][$index]['EmployeeCode'],
							"FullNameEng"	 => $result['data'][$index]['FullNameEng'],
							"FullNameTh"	 => $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['FullNameTh']),
							"RegionID" 	 	 => $result['data'][$index]['RegionID'],
							"BranchCode" 	 => $result['data'][$index]['BranchCode'],
							"BranchDigit" 	 => $result['data'][$index]['BranchDigit'],
							"User_Role"		 => $result['data'][$index]['User_Role']		
					)
				);
			}
				
			$this->json_parse($conv);
			
		}
		
	}
	
	public function getEmpListSpecify() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		$branchs = $this->input->post('branchcode');
		if(!empty($branchs[0])) {
				
			if(!empty($branchs[0])) {
				$where_brachs 	= "'".implode("','", $branchs)."'";
			} else {
				$where_brachs   = "";
			}
				
			$SQL = "SELECT EmployeeCode, FullNameEng, FullNameTh, PositionTitle,
			CASE PositionTitle
			WHEN 'Branch Manager' THEN 'BM'
			WHEN 'Relationship Manager' THEN 'RM'
			END AS User_Role, LendingEmp.RegionID,
			LendingEmp.BranchCode, LendingBranchs.BranchDigit,
			LendingBranchs.BranchName
			FROM LendingEmp
			LEFT OUTER JOIN LendingBranchs
			ON LendingEmp.BranchCode = LendingBranchs.BranchCode
			WHERE LendingEmp.PositionTitle in ('Relationship Manager', 'Branch Manager')
			AND LendingBranchs.BranchCode in ($where_brachs)
			AND LendingEmp.IsActive = 'A'
			ORDER BY User_Role ASC";
	
		} else {
				
			$SQL = "
			SELECT EmployeeCode, FullNameEng, FullNameTh, PositionTitle,
			CASE PositionTitle
			WHEN 'Branch Manager' THEN 'BM'
			WHEN 'Relationship Manager' THEN 'RM'
			END AS User_Role, LendingEmp.RegionID,
			LendingEmp.BranchCode, LendingBranchs.BranchDigit,
			LendingBranchs.BranchName
			FROM LendingEmp
			LEFT OUTER JOIN LendingBranchs
			ON LendingEmp.BranchCode = LendingBranchs.BranchCode
			WHERE LendingEmp.PositionTitle in ('Relationship Manager', 'Branch Manager')
			AND LendingEmp.IsActive = 'A'
			ORDER BY User_Role ASC";
				
				
		}
	
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
						array(
								"EmployeeCode" 	 => $result['data'][$index]['EmployeeCode'],
								"FullNameEng"	 => $result['data'][$index]['FullNameEng'],
								"FullNameTh"	 => $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['FullNameTh']),
								"RegionID" 	 	 => $result['data'][$index]['RegionID'],
								"BranchCode" 	 => $result['data'][$index]['BranchCode'],
								"BranchDigit" 	 => $result['data'][$index]['BranchDigit'],
								"User_Role"		 => $result['data'][$index]['User_Role']
						)
						);
			}
	
			$this->json_parse($conv);
				
		}
	
	}

	public function getRMListBoundaryByCode() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		$branchs = $this->input->post('branchcode');
		$region	 = $this->input->post('regioncode');		
		$section = $this->input->post('section');
		
		if($section === 'false'):
			$position = "'Relationship Manager'";
		else:
			$position = "'Relationship Manager', 'Branch Manager'";
		endif;
	
		if(!empty($branchs[0])) {
				
			if(!empty($branchs[0])) {
				$where_brachs 	= "'".implode("','", $branchs)."'";
			} else {
				$where_brachs   = "";
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
					WHERE LendingEmp.PositionTitle in ($position)
					AND LendingEmp.IsActive = 'A'
					AND LendingBranchs.BranchCode in ($where_brachs)
					ORDER BY BranchCode ASC, PositionTitle ASC";
			
			
				
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
									"BranchDigit" 	 => $result['data'][$index]['BranchDigit'],
									"User_Role"		 => $result['data'][$index]['User_Role']
	
							)
					);
				}
					
				$this->json_parse($conv);
			}
				
		} else {
			
			if(empty($branchs[0])) {
				
				$SQL = "SELECT EmployeeCode, FullNameEng, FullNameTh, PositionTitle,
						CASE PositionTitle
						WHEN 'Branch Manager' THEN 'BM'
						WHEN 'Relationship Manager' THEN 'RM'
						END AS User_Role, LendingEmp.RegionID,
						LendingEmp.BranchCode, LendingBranchs.BranchDigit
						FROM LendingEmp
						LEFT OUTER JOIN LendingBranchs
						ON LendingEmp.BranchCode = LendingBranchs.BranchCode
						WHERE LendingEmp.PositionTitle in ($position)
						AND LendingEmp.IsActive = 'A'
						ORDER BY BranchCode ASC, PositionTitle ASC";
				
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
										"BranchDigit" 	 => $result['data'][$index]['BranchDigit'],
										"User_Role"		 => $result['data'][$index]['User_Role']
				
								)
								);
					}
						
					$this->json_parse($conv);
				}
				
			}
			
		}
	
	}
	
	public function getRMListBoundaryOnly() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		$branchs = $this->input->post('branchcode');
		$region	 = $this->input->post('regioncode');
	
		if(!empty($branchs[0])) {
	
			if(!empty($branchs[0]) && !in_array('000', $branchs)):
				$where_brachs 	= "'".implode("','", $branchs)."'";
			else:
				$where_brachs   = "";
			endif;
			
			$where = "";
			if(!empty($where_brachs)) $where = "AND LendingBranchs.BranchCode in ($where_brachs)";
	
			$SQL = "
				SELECT 
					EmployeeCode, FullNameEng, FullNameTh, PositionTitle,
					CASE PositionTitle
					WHEN 'Branch Manager' THEN 'BM'
					WHEN 'Relationship Manager' THEN 'RM'
					END AS User_Role, LendingEmp.RegionID,
					LendingEmp.BranchCode, LendingBranchs.BranchDigit
				FROM LendingEmp
				LEFT OUTER JOIN LendingBranchs
				ON LendingEmp.BranchCode = LendingBranchs.BranchCode
				WHERE LendingEmp.PositionTitle in ('Relationship Manager')
				AND LendingEmp.IsActive = 'A'
				$where
				ORDER BY BranchCode ASC, PositionTitle ASC
			";
	
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
								"BranchDigit" 	 => $result['data'][$index]['BranchDigit'],
								"User_Role"		 => $result['data'][$index]['User_Role']
						)
					);
				}
					
				$this->json_parse($conv);
			}
	
		} else {
				
			if(empty($branchs[0])) {
	
				$SQL = "SELECT EmployeeCode, FullNameEng, FullNameTh, PositionTitle,
						CASE PositionTitle
						WHEN 'Branch Manager' THEN 'BM'
						WHEN 'Relationship Manager' THEN 'RM'
						END AS User_Role, LendingEmp.RegionID,
						LendingEmp.BranchCode, LendingBranchs.BranchDigit
						FROM LendingEmp
						LEFT OUTER JOIN LendingBranchs
						ON LendingEmp.BranchCode = LendingBranchs.BranchCode
						WHERE LendingEmp.PositionTitle in ('Relationship Manager')
						AND LendingEmp.IsActive = 'A'
						ORDER BY BranchCode ASC, PositionTitle ASC";
	
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
										"BranchDigit" 	 => $result['data'][$index]['BranchDigit'],
										"User_Role"		 => $result['data'][$index]['User_Role']
	
								)
								);
					}
	
					$this->json_parse($conv);
				}
	
			}
				
		}
	
	}
	
	public function getRMListBoundaryByRegion() {
		$this->load->model('dbmodel');
		$this->load->library('effective');

		$region	 = $this->input->post('regioncode');
		
		if(!empty($region)) {		
					
			$SQL = "
				SELECT EmployeeCode, FullNameEng, FullNameTh, PositionTitle, 
				CASE PositionTitle
					WHEN 'Branch Manager' THEN 'BM'
					WHEN 'Relationship Manager' THEN 'RM'
				END AS User_Role, LendingEmp.RegionID, 
				LendingEmp.BranchCode, LendingBranchs.BranchDigit
				FROM LendingEmp
				LEFT OUTER JOIN LendingBranchs
				ON LendingEmp.BranchCode = LendingBranchs.BranchCode
				WHERE LendingEmp.PositionTitle in ('Relationship Manager', 'Branch Manager')
				AND LendingBranchs.RegionID = '".$region."'
				AND LendingEmp.IsActive = 'A'";
				
		} else {
			
			$SQL = "
				SELECT EmployeeCode, FullNameEng, FullNameTh, PositionTitle,
				CASE PositionTitle
					WHEN 'Branch Manager' THEN 'BM'
					WHEN 'Relationship Manager' THEN 'RM'
				END AS User_Role, LendingEmp.RegionID,
				LendingEmp.BranchCode, LendingBranchs.BranchDigit
				FROM LendingEmp
				LEFT OUTER JOIN LendingBranchs
				ON LendingEmp.BranchCode = LendingBranchs.BranchCode
				WHERE LendingEmp.PositionTitle in ('Relationship Manager', 'Branch Manager')
				AND LendingEmp.IsActive = 'A'";
			
		}
		
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
						array(
								"EmployeeCode" 	 => $result['data'][$index]['EmployeeCode'],
								"FullNameEng"	 => $result['data'][$index]['FullNameEng'],
								"FullNameTh"	 => $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['FullNameTh']),
								"RegionID" 	 	 => $result['data'][$index]['RegionID'],
								"BranchCode" 	 => $result['data'][$index]['BranchCode'],
								"BranchDigit" 	 => $result['data'][$index]['BranchDigit'],
								"User_Role"		 => $result['data'][$index]['User_Role']
		
						)
						);
					
			}
				
			$this->json_parse($conv);
		}
		
	}

	private function json_parse($objArr) {
		header('Content-type: application/json; charset="UTF-8"');
		echo json_encode($objArr);
	}
	
	public function getNCBConsentLogs() {
		$this->load->model('dbmodel');
		$this->load->model('dbstore');
		$this->load->library('effective');		
		
		$doc_id = $this->input->post('relx');
		if(empty($doc_id)) {
			
			$this->json_parse(array(
					'data'      => '',
					'status'    => false,
					'msg'       => 'ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง.'
				)
			);
			
		} else {
			
		
			$result 	= $this->dbmodel->loadData('NCBConsent', 'VerifyID', array('DocID' => $doc_id));
			$raw_log	= $this->dbstore->exec_getNCBConsentLogs($result['data'][0]['VerifyID']);

			$conv['data'] = array();
			foreach($raw_log as $index => $value) {
	
				switch($raw_log[$index]['NCBCheck']) {
					case '0':
					case '2':
						$ncb_state = 'ไม่ผ่าน';
						break;
					case '1':
					case '3':
						$ncb_state = 'ผ่าน';
						break;
				}
				
				$ncb_tooper  = $raw_log[$index]['HQSubmitToOper'];
				$ncb_recheck = $raw_log[$index]['OperReturnDate'];
				if($ncb_recheck != '' && $ncb_tooper != '' || $ncb_recheck >= '2015-07-01'):
					$bind_rows = '';
				else:
					$bind_rows = 'class="bind_unbelive"';
				endif;
			
				array_push($conv['data'], array(
						"BRT" => $this->effective->get_chartypes($this->char_mode, $raw_log[$index]['BorrowerDesc']),
						"BRN" => $this->effective->get_chartypes($this->char_mode, $raw_log[$index]['BorrowerName']),
						"NCK" => $ncb_state,
						"NCD" => $this->effective->StandartDateRollback($raw_log[$index]['NCBCheckDate']),
						"SHQ" => $this->effective->StandartDateRollback($raw_log[$index]['SubmitToHQ']),
						"RLB" => $this->effective->StandartDateRollback($raw_log[$index]['HQReceivedFromLB']),
						"STO" => $this->effective->StandartDateRollback($raw_log[$index]['HQSubmitToOper']),
						"ORS" => ($raw_log[$index]['OperReturn'] == 'Y') ? "มี":"ไม่มี",
						"ORD" => !empty($raw_log[$index]['OperReturnDate']) ? $this->effective->StandartDateRollback($raw_log[$index]['OperReturnDate']):"-",
						"Act" => $raw_log[$index]['IsActive'],
						"CRB" => $this->effective->get_chartypes($this->char_mode, $raw_log[$index]['CreateBy']),
						"CRD" => $this->effective->StandartDateRollback($raw_log[$index]['CreateDate']),
						"CHB" => $this->effective->get_chartypes($this->char_mode, $raw_log[$index]['ChangeBy']),
						"CHD" => $this->effective->StandartDateRollback($raw_log[$index]['ChangeDate']),
						"DES" => !empty($raw_log[$index]['Description']) ? $this->effective->get_chartypes($this->char_mode, $raw_log[$index]['Description']):"",
						"BDR" => $bind_rows
					)
				);
			
			}
				
			$this->json_parse($conv);
			
		}
		
	}
	
	public function getReconcileDocLogs() {
		$this->load->model('dbmodel');
		$this->load->model('dbstore');
		$this->load->library('effective');
		
		$doc_id = $this->input->post('relx');
		if(empty($doc_id)) {
				
			$this->json_parse(array(
					'data'      => '',
					'status'    => false,
					'msg'       => 'ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง.'
				)
			);
				
		} else {
			
			$raw_log	= $this->dbstore->exec_getReconcileDocLogs($doc_id);
			
			$conv['data'] = array();
			foreach($raw_log as $index => $value) {
				
				$logistic_state = '';
				switch($raw_log[$index]['LogisticCode']) {
					case 301:
						$logistic_state = '<i class="fa fa-envelope"></i>';
						break;
					case 302:
						$logistic_state = '<i class="fa fa-motorcycle"></i>';
						break;
					case 303:
						$logistic_state = '<i class="fa fa-users"></i>';
						break;
				}
				
				$completio_doc = !empty($raw_log[$index]['CompletionDoc']) ? $raw_log[$index]['CompletionDoc']:"";
				$return_doc	   = !empty($raw_log[$index]['CAReturn']) ? $raw_log[$index]['CAReturn']:"";
				
				if($completio_doc == "Y") { $completion_status = 'ครบ'; }
				else if($completio_doc == "N") { $completion_status = 'ไม่ครบ'; }
				else { $completion_status = ''; }
				
				$hq_received = $raw_log[$index]['ReceivedDocFormLB'];
				$submitdoc_ToHQ = $raw_log[$index]['AppToCA'];
				$careturn = $raw_log[$index]['CAReturnDate'];
				if($careturn != '' && $submitdoc_ToHQ != '' && $hq_received != '' || $careturn >= '2015-07-01'):
					$bind_rows = '';
				else:
					$bind_rows = 'class="bind_unbelive"';
				endif;
					
				array_push($conv['data'], array(
						"DID"		=> $raw_log[$index]['DocID'], 
						"BRN"		=> $this->effective->get_chartypes($this->char_mode, $raw_log[$index]['BorrowerName']), 
						"BRT"		=> $this->effective->get_chartypes($this->char_mode, $raw_log[$index]['BorrowerDesc']), 
						"LGC"		=> $logistic_state, 
						"STH"		=> $this->effective->StandartDateRollback($raw_log[$index]['SubmitDocToHQ']), 
						"RFB" 		=> $this->effective->StandartDateRollback($raw_log[$index]['ReceivedDocFormLB']), 
						"CPL"		=> $completion_status, 
						"CPD"		=> $this->effective->StandartDateRollback($raw_log[$index]['CompletionDate']), 
						"ATA"		=> !empty($raw_log[$index]['AppToCA']) ? $this->effective->StandartDateRollback($raw_log[$index]['AppToCA']):"", 
						"CAR"		=> ($return_doc == 'Y') ? "มี":"ไม่มี", 
						"CAD"		=> !empty($raw_log[$index]['CAReturnDate']) ? $this->effective->StandartDateRollback($raw_log[$index]['CAReturnDate']):"-", 
                        "IAT"		=> $raw_log[$index]['IsActive'], 
                        "CRB"		=> $this->effective->get_chartypes($this->char_mode, $raw_log[$index]['CreateBy']), 
                        "CRD"		=> $this->effective->StandartDateRollback($raw_log[$index]['CreateDate']), 
                        "CHB"		=> $this->effective->get_chartypes($this->char_mode, $raw_log[$index]['ChangeBy']), 
                        "CHD"		=> $this->effective->StandartDateRollback($raw_log[$index]['ChangeDate']),
						"BDR"		=> $bind_rows
					)
				);
				
			}
	
			$this->json_parse($conv);
			
		}
		
	}
	
	public function getReconcileCompletionLogs() {
		$this->load->model('dbmodel');
		$this->load->model('dbstore');
		$this->load->library('effective');
	
		$doc_id 	= $this->input->post('relx');
		$doc_type 	= $this->input->post('rtype');
		
		if(empty($doc_id)) {
	
			$this->json_parse(array(
					'data'      => '',
					'status'    => false,
					'msg'       => 'ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง.'
				)
			);
	
		} else {
				
			$raw_log	= $this->dbstore->exec_getReconcileCompleteDocLogs($doc_id, $doc_type);
			
			$conv['data'] = array();
			foreach($raw_log as $index => $value) {
						
				array_push($conv['data'], array(
						"DocID" 					=> $raw_log[$index]['DocID'],
						"DocOwner" 					=> $this->effective->get_chartypes($this->char_mode, $raw_log[$index]['DocOwner']),
						"DocType" 					=> $raw_log[$index]['DocType'],
						"DocList" 					=> trim($raw_log[$index]['DocList']),
						"LackDoc" 					=> $this->effective->get_chartypes($this->char_mode, $raw_log[$index]['LackDoc']),
						"DocOther" 					=> $this->effective->get_chartypes($this->char_mode, $raw_log[$index]['DocOther']),
						"LBSubmitDocDate" 			=> !empty($raw_log[$index]['LBSubmitDocDate']) ? $this->effective->StandartDateRollback($raw_log[$index]['LBSubmitDocDate']):"",
						"HQReceivedDocFromLBDate" 	=> !empty($raw_log[$index]['HQReceivedDocFromLBDate']) ? $this->effective->StandartDateRollback($raw_log[$index]['HQReceivedDocFromLBDate']):"",
						"SubmitDocToCADate"  		=> !empty($raw_log[$index]['SubmitDocToCADate']) ? $this->effective->StandartDateRollback($raw_log[$index]['SubmitDocToCADate']):"",
						"CAReturnDate" 				=> !empty($raw_log[$index]['CAReturnDate']) ? $this->effective->StandartDateRollback($raw_log[$index]['CAReturnDate']):"",
						"HQSentToLBDate" 			=> !empty($raw_log[$index]['HQSentToLBDate']) ? $this->effective->StandartDateRollback($raw_log[$index]['HQSentToLBDate']):"",
						"BranchReceivedDate"  		=> !empty($raw_log[$index]['BranchReceivedDate']) ? $this->effective->StandartDateRollback($raw_log[$index]['BranchReceivedDate']):"",
						"CARejectDocDate"  			=> !empty($raw_log[$index]['CARejectDocDate']) ? $this->effective->StandartDateRollback($raw_log[$index]['CARejectDocDate']):"",
						"CreateDocBy"				=> $this->effective->get_chartypes($this->char_mode, $raw_log[$index]['CreateDocBy']),
						"CreateDocDate"				=> !empty($raw_log[$index]['CreateDocDate']) ? $this->effective->StandartDateRollback($raw_log[$index]['CreateDocDate']):"",
						"ChangeDocBy"				=> $this->effective->get_chartypes($this->char_mode, $raw_log[$index]['ChangeDocBy']),
						"ChangeDocDate"				=> !empty($raw_log[$index]['ChangeDocDate']) ? $this->effective->StandartDateRollback($raw_log[$index]['ChangeDocDate']):"",
						'IsActive'					=> $raw_log[$index]['IsActive']
					)
				);
	
			}
	
			$this->json_parse($conv);
						
		}
	
	
	}
	
	public function getReconcileCompletionDocData() {
		$this->load->model('dbstore');
		$this->load->library('effective');
		
		$doc_id 	= $this->input->post('relx');
		$doc_owner	= $this->input->post('refx');
		$doc_ref	= $this->input->post('ridx');
		$doc_type	= $this->input->post('type');
		
		if(empty($doc_id) && empty($doc_ref)) {
			$this->json_parse(array(
					'data'      => '',
					'status'    => false,
					'msg'       => 'ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง.'
				)
			);
			
		} else {
			
			try {
				
			
				$result['data'] = $this->dbstore->exec_getReconcileCompleteDoc($doc_id, $doc_ref, $doc_type);
				if(!empty($result['data'][0]['DocID']) && !empty($result['data'][0]['DocOwner'])) {
				
					$conv['data'] = array();
					foreach($result['data'] as $index => $values) {
				
						array_push($conv['data'], 
							array(
								"MissID" 					=> $result['data'][$index]['MISS_ID'],
								"DocID" 					=> $result['data'][$index]['DocID'],
								"DocOwner" 					=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['DocOwner']),
								"DocType" 					=> $result['data'][$index]['DocType'],
								"DocStatus" 				=> $result['data'][$index]['DocStatus'],
								"DocList" 					=> $result['data'][$index]['DocList'],
								"DocDetail" 				=> !empty($result['data'][$index]['LackDoc']) ? $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['LackDoc']):"",
								"DocOther" 					=> !empty($result['data'][$index]['DocOther']) ? $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['DocOther']):"",
								"LBSubmitDocDate" 			=> !empty($result['data'][$index]['LBSubmitDocDate']) ? $this->effective->StandartDateRollback($result['data'][$index]['LBSubmitDocDate']):"",
								"HQReceivedDocFromLBDate" 	=> !empty($result['data'][$index]['HQReceivedDocFromLBDate']) ? $this->effective->StandartDateRollback($result['data'][$index]['HQReceivedDocFromLBDate']):"",
								"SubmitDocToCADate"  		=> !empty($result['data'][$index]['SubmitDocToCADate']) ? $this->effective->StandartDateRollback($result['data'][$index]['SubmitDocToCADate']):"",
								"CAReturnDate" 				=> !empty($result['data'][$index]['CAReturnDate']) ? $this->effective->StandartDateRollback($result['data'][$index]['CAReturnDate']):"",
								"HQSentToLBDate" 			=> !empty($result['data'][$index]['HQSentToLBDate']) ? $this->effective->StandartDateRollback($result['data'][$index]['HQSentToLBDate']):"",
								"BranchReceivedDate"  		=> !empty($result['data'][$index]['BranchReceivedDate']) ? $this->effective->StandartDateRollback($result['data'][$index]['BranchReceivedDate']):"",
								"CARejectDocDate"  			=> !empty($result['data'][$index]['CARejectDocDate']) ? $this->effective->StandartDateRollback($result['data'][$index]['CARejectDocDate']):"",
								"IsRef" 					=> $result['data'][$index]['IsRef'],
								'ImportantDoc' 				=> $result['data'][$index]['Important'],
								"DocIsLock"					=> !empty($result['data'][$index]['DocIsLock']) ? $result['data'][$index]['DocIsLock']:'',
								"CreateDocBy"				=> !empty($result['data'][$index]['CreateDocBy']) ? $result['data'][$index]['CreateDocBy']:'',
								"CreateDocDate"  			=> !empty($result['data'][$index]['CreateDocDate']) ? $result['data'][$index]['CreateDocDate']:""
							)
						);
				
					}

					$conv['status']	= 'true';
					$this->json_parse($conv);
				
				} else {
					$this->json_parse(array("data" => '', "status" => false, "msg" => 'Not found data.'));
						
				}
				
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
			
		}
		
	}
	
	public function getNumBadgeByType() {
		$this->load->model('dbstore');
		
		$doc_id 	= $this->input->post('relx');
		$doc_ref	= $this->input->post('refx');	
		
		if(empty($doc_id) && empty($doc_ref)) {
			$this->json_parse(array(
				'data'      => '',
				'status'    => false,
				'msg'       => 'ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง.'
				)
			);
				
		} else {
			
			try {
				
				$result['data'] = $this->dbstore->exec_getAmountBadgeCount($doc_id, $doc_ref);
				
				$conv['data'] = array();
				foreach($result['data'] as $index => $values) {
				
					array_push($conv['data'], array(
						"DocID" 					=> $result['data'][$index]['DocID'],
						"CompletionDoc"				=> $result['data'][$index]['CompletionDoc'],
						"NumMissingDoc"  			=> !empty($result['data'][$index]['NumMissingDoc']) ? $result['data'][$index]['NumMissingDoc']:0,
						"NumReturnDoc"  			=> !empty($result['data'][$index]['NumReturnDoc']) ? $result['data'][$index]['NumReturnDoc']:0,
						"IsRef" 					=> $result['data'][$index]['IsRef']
						)
					);
				
				}
				
				$this->json_parse($conv);
			
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
					
			
		}
		
	}
	
	
	public function getNumBadgeByDashboard() {
		$this->load->model('dbstore');
		$this->load->library('effective');
	
		$doc_id 	= $this->input->post('relx');
		$doc_ref	= $this->input->post('refx');
	
		if(empty($doc_id) && empty($doc_ref)) {
			$this->json_parse(array(
					'data'      => '',
					'status'    => false,
					'msg'       => 'ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง.'
				)
			);
	
		} else {
				
			try {
	
				$results['data'] = $this->dbstore->exec_getAmountBadgeCount($doc_id, $doc_ref);
	
				$conv['data'] = array();
				foreach($results['data'] as $index => $values) {

					$Z2_CAReturnDoc = !empty($results['data'][$index]['CAReturnDate']) ? $this->effective->StandartDateRollback($results['data'][$index]['CAReturnDate']):"";
					
					array_push($conv['data'], array(
							"DocID" 					=> $results['data'][$index]['DocID'],
							"CompletionDoc"				=> $results['data'][$index]['CompletionDoc'],
							//"AppToCA"					=> $this->effective->StandartDateRollback(!empty($results['data'][$index]['AppToCA']) ? $results['data'][$index]['AppToCA']:$results['data'][$index]['CompletionDate']),
							//"AppStatus"				=> self::fnIconMonitorLightState('missing', array($this->effective->StandartDateRollback($results['data'][$index]['ReceivedDocFormLB']),  array("CompletionDocDate" => $this->effective->StandartDateRollback($results['data'][$index]['CompletionDate']), "SentToCADate" => $this->effective->StandartDateRollback($results['data'][$index]['AppToCA']), "CAReturnDate" => $Z2_CAReturnDoc), 'Z2', $results['data'][$index]['CompletionDoc'], $this->effective->StandartDateRollback($results['data'][$index]['AppToCA'])), $index), 
							"NumMissingDoc"  			=> !empty($results['data'][$index]['NumMissingDoc']) ? $results['data'][$index]['NumMissingDoc'] : 0,
							"NumReturnDoc"  			=> !empty($results['data'][$index]['NumReturnDoc']) ? $results['data'][$index]['NumReturnDoc'] : 0,
							"IsRef" 					=> $results['data'][$index]['IsRef']
						)
					);
	
				}
	
				$this->json_parse($conv);
				//print_r($conv);
					
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
				
				
		}
	
	}
	
	public function getMasterPendingCancelReason() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$results  =  $this->dbmodel->CIQuery("SELECT * FROM [dbo].[MasterAfterPendingCancel] WHERE [Isactive] = 'A' ORDER BY [Seq] ASC");
		
		$conv['data'] = array();
		foreach($results['data'] as $index => $values):
			array_push($conv['data'],
				array(
						"ProcessCode"			=> $results['data'][$index]['PC_Code'],
						"ProcessReason"			=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['PC_Name']),
						"ProcessGroup"			=> $results['data'][$index]['PC_Group'],
						"IsActive"  			=> $results['data'][$index]['Isactive']
				)
			);
		endforeach;
		
		$this->json_parse($conv);
		
	}
	
	public function getPendingCancelReasonByCustomer() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$doc_id 	= $this->input->post('docx');
		
		$results  =  $this->dbmodel->CIQuery("
			SELECT TOP 1 * FROM [PCIS].[dbo].[ApplicationPendingCancelLogs]
			WHERE [IsActive] = 'A'
			AND [DocID] = '".$doc_id."'
			ORDER BY [CreateByDate] DESC
		");
		
		
		$str_data = "'" . implode("','", explode(',', $results['data'][0]['PendingCancelReason'])) . "'";
		$results_set  =  $this->dbmodel->CIQuery("SELECT * FROM [dbo].[MasterAfterPendingCancel] WHERE [PC_Code] IN ($str_data)  ORDER BY [Seq] ASC");
		
	
		if(!empty($results_set['data'][0]['PC_Code'])) {			
			$conv['data'] = array();
			foreach($results_set['data'] as $index => $values):
				array_push($conv['data'],
					array(
						"ProcessCode"	=> $results_set['data'][$index]['PC_Code'],
						"ProcessName"	=> $this->effective->get_chartypes($this->char_mode, $results_set['data'][$index]['PC_Name']),
						"CreateByName"	=> $this->effective->get_chartypes($this->char_mode, $results['data'][0]['CreateByName']),
						"CreateByDate"	=> $results['data'][0]['CreateByDate']
					)
				);
			endforeach;
			
			$conv['status']	= true;
			$conv['msg']	= 'Inquiry Successfully.';
			
			$this->json_parse($conv);
			
		} else {
			$this->json_parse(array(
					'data'      => '',
					'status'    => false,
					'msg'       => 'ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง.'
				)
			);
		}
		
	}
	
	public function getProcessCancelReason() {
		$this->load->model('dbmodel');
		$this->load->library('effective');

		$load_list	= $this->input->post('ctpye');
		
		if(empty($load_list)) {
			$this->json_parse(array(
					'data'      => '',
					'status'    => false,
					'msg'       => 'ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง.'
				)
			);
	
		} else {
	
			try {

				$conv['data'] = array();
				switch(strtoupper($load_list)) {
					case 'CANCELBYCUS':
					case 'NOTACCEPT':	
						
						/*
						if(date('Y-m-d') >= '2019-05-02') {
							$results  =  $this->dbmodel->CIQuery("SELECT * FROM [dbo].[MasterAfterPendingCancel] WHERE [Isactive] = 'A' ORDER BY [Seq] ASC");
							
							foreach($results['data'] as $index => $values):
								array_push($conv['data'],
									array(
										"ProcessCode"			=> $results['data'][$index]['PC_Code'],
										"ProcessReason"			=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['PC_Name']),
										"ProcessGroup"			=> $results['data'][$index]['PC_Group'],
										"IsActive"  			=> $results['data'][$index]['Isactive']
									)
								);
							endforeach;
						} else {
						*/
							$results  = $this->dbmodel->CIQuery("SELECT * FROM MasterProcessCancelReason WHERE IsActive = 'A' ORDER BY Seq ASC");
	
							foreach($results['data'] as $index => $values):	
								array_push($conv['data'], array(
										"ProcessCode"			=> $results['data'][$index]['ProcessCode'],
										"ProcessReason"			=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['ProcessReason']),
										"IsActive"  			=> $results['data'][$index]['IsActive']
									)
								);
	
							endforeach;
						//}
												
					break;
					case 'CANCELBYCA':						
					case 'CANCELBYRM':
						
						$SQL = "SELECT DefendCode, DefendReason, DefendType, MasterDefendType.MDefendType, MasterDefendReason.IsActive
								FROM MasterDefendReason
								LEFT OUTER JOIN MasterDefendType
								ON MasterDefendReason.DefendType = MasterDefendType.MDefendCode
								WHERE MasterDefendReason.IsActive = 'A' 
								ORDER BY MasterDefendReason.DefendType ASC, DefendCode ASC";						
					
						$results = $this->dbmodel->CIQuery($SQL);
						
						foreach($results['data'] as $index => $values):
						
							array_push($conv['data'], array(
									"ProcessCode"			=> $results['data'][$index]['DefendCode'],
									"ProcessReason"			=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['DefendReason']),
									"IsActive"  			=> $results['data'][$index]['IsActive']
								)
							);
								
						endforeach;
						
					break;
				}

				$this->json_parse($conv);
					
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
	
	
		}
	
	}
	
	public function getCancelReasonByCustomer() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$doc_id 	= $this->input->post('docx');
		
		if(!empty($doc_id)):

			$results = $this->dbmodel->CIQuery("
				SELECT DocID, AFCancelReason 
				FROM ApplicationStatus
				WHERE DocID = '".$doc_id."'
			");
		
			
			if(!empty($results['data'][0]['DocID'])) {
				
				$objList = explode(',', $results['data'][0]['AFCancelReason']);
				
				if(in_array("CM999", $objList)):
					$key = array_search("CM999", $objList);
					if(!empty($key)) unset($objList[$key]);
				endif;
				
				if(!empty($objList[0])):
					$wheres_reason 	= "'".implode("','", $objList)."'";
					/*
					if(date('Y-m-d') >= '2019-05-02') {
						$list_result =  $this->dbmodel->CIQuery("SELECT * FROM [dbo].[MasterAfterPendingCancel] WHERE [Isactive] = 'A' AND [PC_Code] in ($wheres_reason) ORDER BY [Seq] ASC");
					} else {
					*/
						$list_result = $this->dbmodel->CIQuery("
							SELECT * FROM MasterProcessCancelReason
							WHERE ProcessCode in ($wheres_reason)
							AND IsActive = 'A'
						");
					//}
										
					$conv['data'] = array();
					foreach($list_result['data'] as $index => $values):

						if(date('Y-m-d') >= '2019-05-01') {
							array_push($conv['data'],
								array(
									"ProcessCode"			=> $values['PC_Code'],
									"ProcessReason"			=> $this->effective->get_chartypes($this->char_mode, $values['PC_Name']),
									"ProcessGroup"			=> $values['PC_Group'],
									"IsActive"  			=> $values['Isactive']
								)
							);	
							
						} else {
							array_push($conv['data'], array(
									"ProcessCode"			=> $list_result['data'][$index]['ProcessCode'],
									"ProcessReason"			=> $this->effective->get_chartypes($this->char_mode, $list_result['data'][$index]['ProcessReason']),
									"IsActive"  			=> $list_result['data'][$index]['IsActive']
								)
							);
						}
						
 					endforeach;
					
					$conv['status']	= true;
					$conv['msg']	= 'Inquiry Successfully.';

					
					$this->json_parse($conv);
					
				endif;

			}
		
		endif;
		
		
	}
	
	public function getDefendList() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		$doc_id    = $this->input->post('relx');
		$defend_no = $this->input->post('lnox');

		$conv['header'] = array();
		$conv['data'] 	= array();
		$headers   = $this->dbmodel->CIQuery("SELECT DocID, DefendRef, DefendDepart, CreateBy, CONVERT(nvarchar(19), CreateDate, 120) AS CreateDate FROM New_DefendHead WHERE DocID = '".$doc_id."' AND IsActive = 'A' ORDER BY CreateDate DESC");
		foreach($headers['data']  as $index => $values) {
			array_push($conv['header'], array(
					"DocID"			=> $headers['data'][$index]['DocID'],
					"DefendRef"		=> $headers['data'][$index]['DefendRef'],
					"DefendBy"		=> $this->effective->get_chartypes($this->char_mode, $headers['data'][$index]['CreateBy']),
					"DefendDate"	=> $headers['data'][$index]['CreateDate']
					
				)
			);
		}
		
		$results   = $this->dbmodel->CIQuery("
			SELECT New_DefendSubHead.DocID, New_DefendSubHead.DefendRef, New_DefendSubHead.DefendCode, 
			REPLACE(CONVERT(NVARCHAR(200), DefendReason), 'อื่น ๆ (โปรดระบุรายละเอียด)', 'อื่น ๆ') AS DefendReason, 
			DefendTitleOption AS DefendTitleOption, New_DefendHead.CreateID, New_DefendHead.CreateBy, 
			CONVERT(nvarchar(19), New_DefendHead.CreateDate, 120) AS CreateDate, New_DefendSubHead.IsActive
			FROM New_DefendSubHead
			LEFT OUTER JOIN MasterDefendReason
			ON MasterDefendReason.DefendCode = New_DefendSubHead.DefendCode
			LEFT OUTER JOIN New_DefendHead
			ON New_DefendHead.DocID = New_DefendSubHead.DocID
			AND New_DefendHead.DefendRef = New_DefendSubHead.DefendRef
			WHERE New_DefendSubHead.DocID = '".$doc_id."'
			AND New_DefendSubHead.DefendCode NOT IN ('SP001', 'SP002', 'SP003', 'SP004')
			AND New_DefendHead.IsActive = 'A'
			ORDER BY CreateDate DESC	
		");
		
		foreach($results['data'] as $index => $values) {
		
			array_push($conv['data'], array(
					"DocID"			=> $results['data'][$index]['DocID'],
					"DefendRef"		=> $results['data'][$index]['DefendRef'],
					"DefendCode"	=> $results['data'][$index]['DefendCode'],
					"DefendReason"	=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['DefendReason']),
					"DefendOther"	=> !empty( $results['data'][$index]['DefendTitleOption']) ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['DefendTitleOption']):'',
					"DefendDate"	=> $results['data'][$index]['CreateDate'],
					"DefendBy"		=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['CreateBy']),
					"IsActive"  	=> $results['data'][$index]['IsActive']
				)
			);
		
		}
	
		$this->json_parse($conv);
	
	}
	
	public function getDefendReason() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		$defend_types = $this->input->post('dftype');
		
		if(!empty($defend_types)) {
				
			$results = $this->dbmodel->CIQuery("
					SELECT DefendCode, DefendReason, DefendType, MasterDefendType.MDefendType, MasterDefendReason.IsActive
					FROM MasterDefendReason
					LEFT OUTER JOIN MasterDefendType
					ON MasterDefendReason.DefendType = MasterDefendType.MDefendCode
					WHERE MasterDefendType.MDefendType = '".$defend_types."'
					AND NOT MasterDefendReason.DefendType  = 'DEF00'
					AND MasterDefendReason.IsActive = 'A'
					ORDER BY DefendCode ASC, MasterDefendReason.DefendType ASC
				");
				
				$conv['data'] = array();
				foreach($results['data'] as $index => $values) {
				
					array_push($conv['data'], array(
							"DefendCode"			=> $results['data'][$index]['DefendCode'],
							"DefendReason"			=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['DefendReason']),
							"DefendType"			=> $results['data'][$index]['DefendType'],
							"IsActive"  			=> $results['data'][$index]['IsActive']
						)
					);
						
				}
				
				$this->json_parse($conv);
				
		} else {

			try {
				
				$results = $this->dbmodel->CIQuery("
					SELECT * FROM MasterDefendReason
					WHERE NOT DefendType  = 'DEF00'
					AND IsActive = 'A'
					ORDER BY DefendCode ASC, MasterDefendReason.DefendType ASC
				");
				
				$conv['data'] = array();
				foreach($results['data'] as $index => $values) {
				
					array_push($conv['data'], array(
							"DefendCode"			=> $results['data'][$index]['DefendCode'],
							"DefendReason"			=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['DefendReason']),
							"DefendType"			=> $results['data'][$index]['DefendType'],
							"IsActive"  			=> $results['data'][$index]['IsActive']
						)
					);
						
				}
				
				$this->json_parse($conv);
				
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
			

		}
		
	
	}
	
	public function getDefendType() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$defend_types = $this->input->post('dftype');
	
		if(empty($defend_types)) {
	
				$results = $this->dbmodel->CIQuery("SELECT * FROM MasterDefendType WHERE NOT MDefendCode = 'DEF00' AND IsActive = 'A' ORDER BY MDefendType ASC");
	
				$conv['data'] = array();
				foreach($results['data'] as $index => $values) {
	
					array_push($conv['data'], array(
							"MDefendCode"			=> $results['data'][$index]['MDefendCode'],
							"MDefendSubject"		=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['MDefendSubject']),
							"MDefendType"			=> $results['data'][$index]['MDefendType'],
							"IsActive"  			=> $results['data'][$index]['IsActive']
						)
					);
	
				}
	
				$this->json_parse($conv);
	
		} else {
	
			try {
	
				
				$results = $this->dbmodel->CIQuery("
					SELECT  *
					FROM  MasterDefendType
					WHERE IsActive = 'A'
					AND NOT MDefendCode = 'DEF00'
					AND MDefendType = 'REQUEST'
					OR MasterDefendType.MDefendType = 'OTHER'
					ORDER BY MDefendType ASC
				");
	
				$conv['data'] = array();
				foreach($results['data'] as $index => $values) {
	
					array_push($conv['data'], array(
							"MDefendCode"			=> $results['data'][$index]['MDefendCode'],
							"MDefendSubject"		=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['MDefendSubject']),
							"MDefendType"			=> $results['data'][$index]['MDefendType'],
							"IsActive"  			=> $results['data'][$index]['IsActive']
						)
					);
	
				}
	
				$this->json_parse($conv);
	
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
				
	
		}

	}
	
	public function getDefendTypeConfig() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		$defend_types = $this->input->post('dftype');
	
		if(empty($defend_types)) {
	
			$this->json_parse(array(
					'data'      => '',
					'status'    => false,
					'msg'       => 'ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง.'
				)
			);
	
		} else {
	
			try {
	
				$results = $this->dbmodel->loadData('MasterDefendType', '*', array('IsActive' => 'A', 'MDefendType' => $defend_types));
	
				$conv['data'] = array();
				foreach($results['data'] as $index => $values) {
	
					array_push($conv['data'], array(
							"value"		=> $results['data'][$index]['MDefendCode'],
							"text"		=> $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['MDefendSubject']),
						)
					);
	
				}
	
				$this->json_parse($conv);
	
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
	
	
		}	
	
	}
	
	protected static function fnIconMonitorLightState($mode, $Dates = array(), $row) {
	
		switch ($mode) {
			case 'reconcile':
			default:
					
				if($Dates[0] != "" && $Dates[1] != "") :
				return  '<abbr title="HQ Received Date : '.$Dates[1].'" style="border: 0;"><i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i></abbr>';
				else :
					
				if($Dates[0] == "" && $Dates[1] == ""):
				return;
	
				else:
				return  '<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i>';
				endif;
					
				endif;
	
				break;
	
			case 'missing':
			case 'returndoc':
			case 'allviews':
	
				switch($Dates[2]) {
						
					case 'Z1':
							
						if($Dates[0] != "" && $Dates[1] != "") :
						return  '<abbr title="HQ Received Date : '.$Dates[1].'" style="border: 0;"><i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i></abbr>';
						else :
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
	
						if($Dates[0] != "" && $Dates[1]['CAReturnDate'] != ""):
						$mode = '3';
						endif;
	
						switch ($mode) {
							case '1':
									return '<span id="Z2_App_'.$row.'"><i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i></span>';
								break;
							case '2':
									return '<span id="Z2_App_'.$row.'"><abbr title="Completed: '.$Dates[1]['SentToCADate'].'" style="border:none;"><i class="fa fa-circle" style="color: #60a917; font-size: 1.5em; cursor: pointer;"></i></abbr></span>';
								break;
							case '3':
	
								if(!empty($Dates[1]['CAReturnDate'])):
									return '<span id="Z2_App_'.$row.'"><abbr title="Return Document On Date : '.$Dates[1]['CAReturnDate'].'" style="border:none;"><i class="fa fa-circle fg-red" style="font-size: 1.5em; cursor: pointer;"></i></abbr></span>';
								else:
									return '<span id="Z2_App_'.$row.'"><abbr title="Completed On Date: '.$Dates[1]['SentToCADate'].'" style="border:none;"><i class="fa fa-circle" style="color: #60a917; font-size: 1.5em; cursor: pointer;"></i></abbr></span>';
								endif;
	
								break;
									
									
						}
							
						break;
	
				}
	
				break;
			
	
		}
			
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
	
	public function fnLeepLighterChange() {
		
		$doc		  = $this->input->post('relx');
		$is_ref		  = $this->input->post('refx');
		$type		  = $this->input->post('type');
			
		$result 	  = $this->dataReconTypeInquiry($doc, $is_ref, $type[0]);
	
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
									
									$objState = array(
										"DocID" 	=> $doc,
										"IsRef" 	=> $is_ref,
										"State"		=> '<i class="fa fa-circle fg-yellow" style="font-size: 1.5em; cursor: pointer;"></i>'	
									);
										
								} else {
									
									$objState = array(
										"DocID" 	=> $doc,
										"IsRef" 	=> $is_ref,
										"State"		=> '<i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i>'
									);
								}
	
							} else {
								
								$objState = array(
									"DocID" 	=> $doc,
									"IsRef" 	=> $is_ref,
									"State"		=> '<i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i>'
								);
							}
								
						} else {
							
							$objState = array(
								"DocID" 	=> $doc,
								"IsRef" 	=> $is_ref,
								"State"		=> '<i class="fa fa-circle" style="color: #60a917; font-size: 1.5em; cursor: pointer;"></i>'
							);
						}
							
					} else {
						
						$objState = array(
							"DocID" 	=> $doc,
							"IsRef" 	=> $is_ref,
							"State"		=> '<i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.5em; cursor: pointer;"></i>'
						);
					}
						
				} else {
					
					$objState = array(
						"DocID" 	=> $doc,
						"IsRef" 	=> $is_ref,
						"State"		=> '<i class="fa fa-circle" style="color: #666666; font-size: 1.5em; cursor: pointer;"></i>'						
					);
				}
	
			} else {
				//return '<abbr title="LB has created record" style="border: 0;"><i class="fa fa-circle" style="color: #666666; font-size: 1.5em; cursor: pointer;"></i></abbr>';
			}
			
							
		}
		
		echo json_encode($objState);	
		
	}
	
	public function getActionListLogs() {
		
		$doc_id 	= $this->input->post('relx');		
		if(empty($doc_id)) {
			$this->json_parse(array(
					'data'      => '',
					'status'    => false,
					'msg'       => 'ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง.'
				)
			);
		
		} else {
			
			$result	= $this->getActionNoteLogs($doc_id);
			$this->json_parse($result);
			
		}
		
		
		
	} 
	
	public function getActionNoteLogs($DocID) {
		$this->load->model('dbstore');
		$this->load->library('effective');
		
		if(empty($DocID)) :
		return 0;
			
		else :
	
		try {
	
			$data['data']		  = array();
			$result		  = $this->dbstore->exec_getActionNoteLogs($DocID);
			foreach($result as $index => $values) {
					
				array_push($data['data'], array(
						"ActionNote" 		  => $this->effective->get_chartypes($this->char_mode, $result[$index]['ActionNote']),
						"ActionNoteBy" 		  => $result[$index]['ActionNoteBy'],
						"ActionName" 		  => $this->effective->get_chartypes($this->char_mode, $result[$index]['ActionName']),
						"ActionNoteDate" 	  => $result[$index]['ActionNoteDate']
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
	
	public function getRegisStatusReason() {
		$this->load->model('dbstore');
		$this->load->library('effective');
		
		try {
	
			$data['data']		 	= array();
			$result		  			= $this->dbstore->exec_getRegisStatusReason();
			foreach($result as $index => $values) {
					
				array_push($data['data'], array(
					"NumID"			=> $index,
					"PendingName" 	=> $this->effective->get_chartypes($this->char_mode, $result[$index]['PendingName']),
				));
					
	
			}
			
			$this->json_parse($data);
	
		} catch (Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
		}
	
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
	
	
	public function getDocumentCategoryList() {
		header('Content-Type: application/json; charset=UTF-8;');
		
		$this->load->model('dbmanagement');
		$this->load->library('effective');
		$result = $this->dbmanagement->getDocumentCategoryTrackList();
	
		$data = array();
		foreach($result['data'] as $index => $values) {
			array_push($data, array(
					"Doc_CatID"     => $result['data'][$index]['Doc_CatID'],
					"Doc_Category"  => $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['Doc_Category']),
					"IsActive"      => $result['data'][$index]['IsActive']
				)
			);
	
		}

		
		echo json_encode($data);
	
	}
	
	public function getDocumentTrackList() {
		header('Content-Type: application/json; charset=UTF-8;');
		
		$this->load->model('dbmanagement');
		$this->load->library('effective');
		$result = $this->dbmanagement->getTrackDataList();
	
		$data = array();
		foreach($result as $index => $values) {
			array_push($data, array(
					"ItemList"      => $result[$index]['RowID'],
					"Doc_CatID"     => $result[$index]['Doc_CatID'],
					"Doc_Category"  => $this->effective->get_chartypes($this->char_mode, $result[$index]['Doc_Category']),
					"Onbehalf_ID"   => $result[$index]['Onbehalf_ID'],
					"Onbehalf_Type" => $this->effective->get_chartypes($this->char_mode, $result[$index]['Onbehalf_Type']),
					"Document_List" => $this->effective->get_chartypes($this->char_mode, $result[$index]['Document_List']),
					"Weight_ID"     => $result[$index]['Weight_ID'],
					"Weight"        => $result[$index]['Weight'],
					"Point"         => $result[$index]['Point'],
					"IsActive"      => $result[$index]['IsActive']	
	
				)
			);
	
		}
	
		echo json_encode($data);
	
	}
	
	public function getActiveErrorList() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		$doc_id  = $this->input->post('DocID');
		$doc_ref = $this->input->post('DocRef');
	
		if(empty($DocID) && empty($doc_ref)) :
		echo json_encode(array('status' => 'false', 'msg' => $this->effective->get_chartypes($this->char_mode, 'เกิดข้อผิดพลาดในการรับ-ส่งข้อมูล กรุณาลองใหม่อีกครั้ง หากยังไม่สามารถบันทึกข้อมูลได้ กรุณาติดต่อผู้ดูแลระบบ.')));
	
		else:
			
		try {
	
			$result = $this->dbmodel->loadData('DocumentErrorSubList', "*", array('DocID' => $doc_id, 'IsRef' => $doc_ref, 'IsActive' => 'A'), false);
			$this->json_parse($result);
	
		} catch (Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
		}
			
		endif;
	
	}
	
	public function applicationchecked() {
		$this->load->model('dbmodel');
	
		$appno  = $this->input->post('appno');
		if(empty($appno)) {
	
			$this->json_parse(array(
					'data'      => '',
					'valid'     => 'T01',
					'status'    => false,
					'msg'       => 'Please enter application no.'
				)
			);
	
		} else {
	
			$checked = $this->dbmodel->data_validation('ApplicationStatus', '*', array('ApplicationNo' => $appno), false);
			if($checked == 'TRUE') {
				$this->json_parse(array(
						'data'      => '',
						'valid'     => 'T02',
						'status'    => true,
						'msg'       => 'Found Record.'
					)
				);
	
			} else {
				$this->json_parse(array(
						'data'      => '',
						'valid'     => 'T02',
						'status'    => false,
						'msg'       => 'Not found record.'
					)
				);
	
			}
	
		}
	
	}
	
	public function getCreditReturnReason() {
		$this->load->model('dbstore');
		$this->load->library('effective');
				
		$rec_id    = $this->input->post('rec_ref');
		$doc_id	   = $this->input->post('doc_ref');
		$return_id = $this->input->post('return_ref');
		$mode 	   = $this->input->post('mode');
	
		if(!empty($rec_id)) $reconcile_id = "@Rec_ID = '".$rec_id."'";
		if(!empty($doc_id)) $document_id  = "@DocID  = '".$doc_id."'";		
		
		if(empty($mode)) {
		
			$this->json_parse(array(
					'data'      => '',
					'status'    => false,
					'msg'       => 'ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง.'
				)
			);
		
		} else {
		
			try {
				
				if($mode == 'popover') {
					$results = $this->dbstore->exec_pcisGetCreditReturnReasonList($reconcile_id);
					
				} else if($mode == 'list_load') {
					
					if($return_id == 0) $return_ref = "@ReturnRef = '1'";
					else $return_ref = "@ReturnRef = '".$return_id."'";			
					
					$list_load	= $document_id. ', ' .$return_ref;			
					$results = $this->dbstore->exec_pcisGetCreditReturnReasonList($list_load);
				
				}
								
				if(!empty($results['data'][0]['DocID'])) {
					
					$conv['data'] = array();
					foreach($results['data'] as $index => $values) {
		
						array_push($conv['data'], array(
								"DocID"			=> $results['data'][$index]['DocID'],
								"ReturnRef"		=> $results['data'][$index]['ReturnRef'],
								"DefendCode"	=> $results['data'][$index]['DefendCode'],
								"DefendReason"  => $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['DefendReason']),
								"DefendOther"   => $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['DefendOther']),
								"ReturnDate"	=> !empty($results['data'][$index]['ReturnDate']) ? $this->effective->StandartDateRollback($results['data'][$index]['ReturnDate']):"",
								"ReturnDateSub"	=> !empty($results['data'][$index]['ReturnDate']) ? substr($this->effective->StandartDateRollback($results['data'][$index]['ReturnDate']), 0, 5):"",
								"Flag"			=> $results['data'][$index]['Flag'],
								"IsActive"		=> $results['data'][$index]['IsActive']
							)
						);
					
					}
					
					$conv['status'] = true;
					$conv['msg'] 	= 'successfully.';
					$this->json_parse($conv);
					
				} else {
					
					$this->json_parse(array(
							'data'      => '',
							'status'    => false,
							'msg'       => 'ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง.'
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
	
	public function getPostponeReasonlist() {
		$this->load->model('dbmodel');
		$this->load->library('effective');

		$result = $this->dbmodel->loadData("MasterPostponeReason", "PostponeCode, PostponeReason", array('IsActive' => 'A'));
		$conv['data'] = array();
		foreach($result['data'] as $index => $value) {
			array_push($conv['data'], 
				array("PostponeCode"   => $result['data'][$index]['PostponeCode'], 
					  "PostponeReason" => $this->effective->get_chartypes($this->char_mode, $value['PostponeReason'])					
				)
			);
			
		}
	
		$this->json_parse($conv);
	
	}
	
	public function setApplicationNoBundled() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		date_default_timezone_set("Asia/Bangkok");
		
		$doc_id	 			 = $this->input->post('docid');
		$app_no 			 = $this->input->post('appno');
		
		$this->emp_id        = $this->session->userdata("empcode");
		$this->name          = $this->session->userdata("thname");
		
		$data_verify		 = $this->dbmodel->data_validation('PCISEventLogs', '*', array('DocID'	=> $doc_id), false);
		
		$event_logs 		 = array(
			'DocID'			=> $doc_id,
			'ApplicationNo' => $app_no,
			'EventProcess'	=> ($data_verify == 'FALSE') ? 'CHECK-IDCARD':'RECHECK-IDCARD',
			'CreateByID'	=> $this->emp_id,
			'CreateByName'	=> $this->effective->get_chartypes($this->char_mode, $this->name),
			'CreateByDate'	=> date('Y-m-d H:i:s')
		);
		
		if(!empty($app_no) && !empty($doc_id)) {
			
			try {				
								
				$this->dbmodel->exec('PCISEventLogs', $event_logs, false, 'insert');
				$result = $this->dbmodel->exec('ApplicationStatus', array('ApplicationNo' => $app_no), array('DocID' => $doc_id), 'update');	
				if($result == TRUE):
				
				if($event_logs['EventProcess'] === 'RECHECK-IDCARD') {					
					$this->dbmodel->exec('ApplicationStatus',
						array(
							'CAName' 				=> NULL,
							'CA_ReceivedDocDate' 	=> NULL,
							'ApproverName' 			=> NULL,
							'PreLoan' 				=> NULL,
							'PreApprovedDate' 		=> NULL,
							'Status' 				=> NULL,
							'StatusDate' 			=> NULL,
							'StatusReason' 			=> NULL,
							'DiviateReason'			=> NULL,
							'PreApproved' 			=> NULL,
							'ApprovedLoan' 			=> NULL,
							'TermYear' 				=> NULL,
							'DrawdownDate' 			=> NULL,
							'DrawdownType' 			=> NULL,
							'DrawdownBaht' 			=> NULL,
							'Diff' 					=> NULL,
							'CountDay' 				=> NULL,
							'IsActive' 				=> 'A',
							'ChangeBy' 				=> NULL,
							'ChangeDate' 			=> NULL,
							'PlanDrawdownDate'  	=> NULL,
							'PlanDateUnknown' 		=> NULL,
							'DrawdownReservation' 	=> NULL,
							'AppComment' 		    => NULL,
							'ReceivedContactDate' 	=> NULL,
							'AFCancelReason' 		=> NULL,
							'AFCancelReasonOther' 	=> NULL,
							'ContactRemark' 		=> NULL,
							'IsEnabled' 			=> 'A'
						),
						array("DocID" => $doc_id), 'update');
					}
				
					$this->json_parse(array(
						'data'      => 'Data update successfully.',
						'status'    => true,
						'msg'       => 'บันทึกข้อมูลสำเร็จ.'
						)
					);
					
				else:
					$this->json_parse(array(
						'data'      => 'Data failed.',
						'status'    => false,
						'msg'       => 'เกิดข้อผิดพล กรุณาลองใหม่อีกครั้ง.'
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
	
	public function setTrashDefendTransaction() {
		$this->load->model('dbmodel');
	
		$doc_id 	 = $this->input->post('relx');
		$pages_no 	 = $this->input->post('lnsx');

		$defend_head = $this->dbmodel->exec('DefendHead', array('IsActive' => 'N'), array('DocID' => $doc_id, 'DefendRef' => $pages_no), 'update');
		$defend_subs = $this->dbmodel->exec('DefendSubscription', array('IsActive' => 'N'), array('DocID' => $doc_id, 'DefendRef' => $pages_no), 'update');
		
		if($defend_head == TRUE && $defend_subs == TRUE):
			$this->json_parse(array(
					'data'      => array('DocID' => $doc_id, 'DefendRef' => $pages_no),
					'status'    => true,
					'msg'       => 'บันทึกข้อมูลสำเร็จ.'
				)
			);
			
		else:
			$this->json_parse(array(
					'data'      => 'Data failed.',
					'status'    => false,
					'msg'       => 'เกิดข้อผิดพล กรุณาลองใหม่อีกครั้ง.'
				)
			);
			
		endif;
	
	}
	
	public function deleteTrashDefendTransaction() {
		$this->load->model('dbmodel');
	
		$doc_id 	 = $this->input->post('relx');
		$request_no  = $this->input->post('lnsx');
	
		$defend_head = $this->dbmodel->exec('New_DefendHead', array('IsActive' => 'N'), array('DocID' => $doc_id, 'DefendRef' => $request_no), 'update');
		$defend_subs = $this->dbmodel->exec('New_DefendSubHead', array('IsActive' => 'N'), array('DocID' => $doc_id, 'DefendRef' => $request_no), 'update');
	
		if($defend_head == TRUE && $defend_subs == TRUE):
			$this->json_parse(array(
					'data'      => array('DocID' => $doc_id, 'DefendRef' => $request_no),
					'status'    => true,
					'msg'       => 'บันทึกข้อมูลสำเร็จ.'
				)
			);
			
		else:
			$this->json_parse(array(
					'data'      => 'Data failed.',
					'status'    => false,
					'msg'       => 'เกิดข้อผิดพล กรุณาลองใหม่อีกครั้ง.'
				)
			);
			
		endif;
	
	}
	
	public function acceptDefendLog() {
		$this->load->model('dbmodel');
	
		$row_id 	  = $this->input->post('relx');
		$update_id	  = $this->input->post('actor_id');
		$update_name  = $this->input->post('actor_name');
		
		$defend_logs  = $this->dbmodel->exec('New_DefendEventLog', 
			array(
				'IsActive' 	 => 'N', 
				'UpdateID'	 => $update_id,
				'UpdateName' => $update_name,
				'UpdateDate' => date('Y-m-d H:i:s')
			), 
			array('RowID' => $row_id), 'update');
	
		if($defend_logs == TRUE):
			$this->json_parse(array(
					'data'      => array('RowID' => $row_id),
					'status'    => true,
					'msg'       => 'บันทึกข้อมูลสำเร็จ.'
				)
			);
			
		else:
			$this->json_parse(array(
					'data'      => null,
					'status'    => false,
					'msg'       => 'เกิดข้อผิดพล กรุณาลองใหม่อีกครั้ง.'
				)
			);
			
		endif;
	
	}
	
	public function getFileInDefend() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$doc_id	 	= $this->input->post('docx');
		$doc_ref 	= $this->input->post('refx');
		$list_code	= $this->input->post('codx');
		
		$result = $this->dbmodel->CIQuery("
			SELECT RowID, DocID, NumRef, DefendRef, DefendCode, Files, [File_Name], Extension, CreateBy,
			CONVERT(NVARCHAR(10), CreateDate, 120) AS CreateDate,
        	RIGHT(CONVERT(NVARCHAR(20), CreateDate, 113), 8) AS CreateTime
			FROM   DefendUploads
			WHERE DocID = '".$doc_id."'
			AND DefendRef = '".$doc_ref."'
			AND DefendCode = '".$list_code."'
        	ORDER BY CONVERT(NVARCHAR(20), CreateDate, 113) DESC		
		");
		
		if(!empty($result['data'][0]['DocID'])) {
			
			$conv['data'] = array();
			foreach($result['data'] as $index => $value) {
				
				array_push($conv['data'],
					array("RowID"		=> $result['data'][$index]['RowID'],
						  "DocID"    	=> $result['data'][$index]['DocID'],
						  "NumRef" 		=> $result['data'][$index]['NumRef'],
						  "DefendRef" 	=> $result['data'][$index]['DefendRef'],
						  "Files" 		=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['Files']),
						  "File_Name" 	=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['File_Name']),
						  "Extension" 	=> $result['data'][$index]['Extension'],
						  "CreateBy" 	=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['CreateBy']),
						  "CreateDate" 	=> $this->effective->StandartDateRollback($result['data'][$index]['CreateDate']),
						  "CreateTime" 	=> $result['data'][$index]['CreateTime']
							
					)
				);
				
			}
			
			$this->json_parse($conv);
			
		} else {
			
			$this->json_parse(array(
					'data'      => 'Data failed.',
					'status'    => false,
					'msg'       => 'เกิดข้อผิดพล กรุณาลองใหม่อีกครั้ง.'
				)
			);
			
		}
		
	}
	
	public function checkTLAUnique() {
		$this->load->model('dbmodel');
		
		$agent_code = $this->input->post('cox');
		if(!empty($agent_code)) {
			
			$validation = $this->dbmodel->data_validation('MasterTLA', 'TLA_Code', array('TLA_Code' => $agent_code), false);
			if($validation == 'FALSE'):
				$this->json_parse(array('status' => true, 'msg' => 'Inquiry Successfully, The Data doesn\'t unique.'));
			else:
				$this->json_parse(array('status' => false, 'msg' => 'Data not found.'));
			endif;
			
		} else {
			$this->json_parse(array('status' => false, 'msg' => 'The occurrence handled exception in passing parameter...'));
		}
		
	}
		
	public function getTLADataDetail() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$val_container	= $this->input->post('tl_ref');
		$tla_code	 	= !empty($val_container) ? $this->input->post('tl_ref'):$this->input->get('tl_ref');
		
		$description	= $this->input->post('getdesc');
		$get_desc	    = !empty($description) ? $this->input->post('getdesc'):$this->input->get('getdesc');
		
		if($get_desc == 'true' || $get_desc == true):
			$where = "WHERE TLA_Code = '".$tla_code."'";
		else:
			$where = "WHERE TL_ID = '".$tla_code."'";
		endif;
		
		if(!empty($tla_code)) {
									
			$result = $this->dbmodel->CIQuery("
				SELECT * FROM (
					SELECT TL_ID, TLA_Code, TLA_Name, TLA_Position, TLA_PositionShort, TLA_BranchName, TLA_BranchTel, TLA_Mobile, TLA_Mobile_2 , LendingEmp.EmployeeCode AS LB_EmpCode,
						LendingEmp.FullNameTh AS LB_EmpName, LB_RegionID, LB_BranchCode, LendingEmp.PositionTitle, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng,
						BranchName AS LB_BranchName, BranchDigit, BranchTel, LB_Ref01_Code, LB_Ref02_Code, LB_Ref01, LB_Ref02, TLA_Status, Bank_Code, AcctNo,
						IDCard, TLCard, TLA_Address, SentEnvelope, TL_Channel,
						CONVERT(NVARCHAR(10), JoinDate, 120) AS JoinDate,
						CONVERT(NVARCHAR(10), ExpiredDate, 120) AS ExpiredDate,
						CONVERT(NVARCHAR(10), IDCardExpired, 120) AS IDCardExpired,
						CreateBy, CONVERT(NVARCHAR(10), CreateDate, 120) AS CreateDate,
						UpdateBy, CONVERT(NVARCHAR(10), UpdateDate, 120) AS UpdateDate,
						Remark
					FROM MasterTLA
					LEFT OUTER JOIN LendingEmp
					ON MasterTLA.LB_BranchCode = LendingEmp.BranchCode
					AND PositionTitle = 'Branch Manager' AND LendingEmp.IsActive = 'A'
					LEFT OUTER JOIN LendingBranchs
					ON LendingEmp.BranchCode = LendingBranchs.BranchCode
					LEFT OUTER JOIN MasterRegion
					ON LendingBranchs.RegionID = MasterRegion.RegionID
					WHERE MasterTLA.TLA_Code IS NOT NULL
				) A
				$where
			");
			
			if(!empty($result['data'][0]['TLA_Code'])) {
				
				if(!empty($result['data'][0]['LB_Ref02_Code'])):
					$extract_code = preg_match('/,/', $result['data'][0]['LB_Ref02_Code']) ? explode(',', $result['data'][0]['LB_Ref02_Code']):array($result['data'][0]['LB_Ref02_Code']);
					$extract_name = preg_match('/,/', $result['data'][0]['LB_Ref02']) ? explode(',', $this->effective->get_chartypes($this->char_mode, $result['data'][0]['LB_Ref02'])):array($this->effective->get_chartypes($this->char_mode, $result['data'][0]['LB_Ref02']));
				else:
					$extract_code = '';
					$extract_name = '';
				endif;
		
				$conv['data'] = array();
				foreach($result['data'] as $index => $value) {
			
					array_push($conv['data'],
						array(
							"TL_ID"				=> $result['data'][$index]['TL_ID'],
							"TLA_Code"    		=> trim($result['data'][$index]['TLA_Code']),
							"TLA_Name" 			=> trim($this->effective->get_chartypes($this->char_mode, $result['data'][$index]['TLA_Name'])),
							"TLA_Position" 		=> trim($this->effective->get_chartypes($this->char_mode, $result['data'][$index]['TLA_Position'])),
							"TLA_PositionShort" => trim($this->effective->get_chartypes($this->char_mode, $result['data'][$index]['TLA_PositionShort'])),
							"TLA_BranchName" 	=> !empty($result['data'][$index]['TLA_BranchName']) ? $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['TLA_BranchName']):'-',							
							"TLA_BranchTel" 	=> $result['data'][$index]['TLA_BranchTel'],
							"TLA_Mobile" 		=> $result['data'][$index]['TLA_Mobile'],
							"TLA_Mobile_2" 		=> $result['data'][$index]['TLA_Mobile_2'],							
							"Bank_Code" 		=> !empty($result['data'][$index]['Bank_Code']) ? $result['data'][$index]['Bank_Code']:'',
							"AcctNo" 			=> !empty($result['data'][$index]['AcctNo']) ? $result['data'][$index]['AcctNo']:'',
							"LB_EmpCode" 		=> $result['data'][$index]['LB_EmpCode'],
							"LB_EmpName" 		=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['LB_EmpName']),
							"LB_RegionID" 		=> $result['data'][$index]['LB_RegionID'],
							"LB_BranchCode" 	=> $result['data'][$index]['LB_BranchCode'],
							"PositionTitle" 	=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['PositionTitle']),
							"RegionNameEng" 	=> $result['data'][$index]['RegionNameEng'],
							"LB_BranchName" 	=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['LB_BranchName']),
							"BranchDigit" 		=> $result['data'][$index]['BranchDigit'],
							"BranchTel" 		=> $result['data'][$index]['BranchTel'],
							"LB_Ref01_Code"		=> $result['data'][$index]['LB_Ref01_Code'],
							"LB_Ref01" 			=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['LB_Ref01']),
							"LB_Ref02_Code"		=> !empty($extract_code[0]) ? $extract_code:'',															
							"LB_Ref02" 			=> !empty($extract_name[0]) ? $extract_name:'',					
							"TLA_Status" 		=> trim($result['data'][$index]['TLA_Status']),
							"IDCard"			=> $result['data'][$index]['IDCard'],
							"TLCard"			=> $result['data'][$index]['TLCard'],
							"TL_Channel"		=> $result['data'][$index]['TL_Channel'],
							"TLA_Address"		=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['TLA_Address']),
							"SentEnvelope"		=> !empty($result['data'][$index]['SentEnvelope']) ? $result['data'][$index]['SentEnvelope']:'',
							"JoinDate"			=> $this->effective->StandartDateRollback($result['data'][$index]['JoinDate']),
							"ExpDate"			=> $this->effective->StandartDateRollback($result['data'][$index]['ExpiredDate']),
							"IDCard_ExpDate"	=> $this->effective->StandartDateRollback($result['data'][$index]['IDCardExpired']),
							"CreateBy" 			=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['CreateBy']),
							"CreateDate" 		=> $this->effective->StandartDateRollback($result['data'][$index]['CreateDate']),
							"UpdateBy" 			=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['UpdateBy']),
							"UpdateDate" 		=> $this->effective->StandartDateRollback($result['data'][$index]['UpdateDate']),
							"Remark" 			=> !empty($result['data'][$index]['Remark']) ? $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['Remark']):''
						)
					);
					
				}
				
				$conv['status']     = true;
				$conv['msg']     	= 'The data inquiry succesfully.';
			
				$this->json_parse($conv);
			
			} else {
			
				$this->json_parse(array(
						'data'      => 'Data failed.',
						'status'    => false,
						'msg'       => 'The occurrence handled exception in passing parameter..'
					)
				);
			
			}
			
		} else {

			$result = $this->dbmodel->CIQuery("
				SELECT * FROM (
					SELECT TL_ID, TLA_Code, TLA_Name, TLA_Position, TLA_PositionShort, TLA_BranchName, TLA_BranchTel, TLA_Mobile, TLA_Mobile_2, LendingEmp.EmployeeCode AS LB_EmpCode,
					LendingEmp.FullNameTh AS LB_EmpName, LB_RegionID, LB_BranchCode, LendingEmp.PositionTitle, UPPER(MasterRegion.RegionNameEng) AS RegionNameEng,
					BranchName AS LB_BranchName, BranchDigit, BranchTel, LB_Ref01_Code, LB_Ref02_Code, LB_Ref01, LB_Ref02, TLA_Status, 
					Bank_Code, AcctNo, IDCard, TLCard, TLA_Address, SentEnvelope, TL_Channel,
					CONVERT(NVARCHAR(10), CreateDate, 120) AS RegisterDate,
					CreateBy, CONVERT(NVARCHAR(10), CreateDate, 120) AS CreateDate,
					UpdateBy, CONVERT(NVARCHAR(10), UpdateDate, 120) AS UpdateDate	
					FROM MasterTLA
					LEFT OUTER JOIN LendingEmp
					ON MasterTLA.LB_BranchCode = LendingEmp.BranchCode
					AND PositionTitle = 'Branch Manager' AND LendingEmp.IsActive = 'A'
					LEFT OUTER JOIN LendingBranchs
					ON LendingEmp.BranchCode = LendingBranchs.BranchCode
					LEFT OUTER JOIN MasterRegion
					ON LendingBranchs.RegionID = MasterRegion.RegionID
					WHERE NOT MasterTLA.TLA_Code = '99999999'
					AND MasterTLA.TLA_Code IS NOT NULL
				) A
			");
			
			if(!empty($result['data'][0]['TLA_Code'])) {
				

				if(!empty($result['data'][0]['LB_Ref02_Code'])):
					$extract_code = preg_match('/,/', $result['data'][0]['LB_Ref02_Code']) ? explode(',', $result['data'][0]['LB_Ref02_Code']):array($result['data'][0]['LB_Ref02_Code']);
					$extract_name = preg_match('/,/', $result['data'][0]['LB_Ref02']) ? explode(',', $this->effective->get_chartypes($this->char_mode, $result['data'][0]['LB_Ref02'])):array($this->effective->get_chartypes($this->char_mode, $result['data'][0]['LB_Ref02']));
				else:
					$extract_code = '';
					$extract_name = '';
				endif;
					
				$conv['data'] = array();
				foreach($result['data'] as $index => $value) {
						
					array_push($conv['data'],
						array(  "TL_ID"				=> $result['data'][$index]['TL_ID'],
								"TLA_Code"    		=> trim($result['data'][$index]['TLA_Code']),
								"TLA_Name" 			=> trim($this->effective->get_chartypes($this->char_mode, $result['data'][$index]['TLA_Name'])),
								"TLA_Position" 		=> trim($this->effective->get_chartypes($this->char_mode, $result['data'][$index]['TLA_Position'])),
								"TLA_PositionShort" => trim($this->effective->get_chartypes($this->char_mode, $result['data'][$index]['TLA_PositionShort'])),
								"TLA_BranchName" 	=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['TLA_BranchName']),
								"TLA_BranchTel" 	=> $result['data'][$index]['TLA_BranchTel'],
								"TLA_Mobile" 		=> $result['data'][$index]['TLA_Mobile'],
								"TLA_Mobile_2" 		=> $result['data'][$index]['TLA_Mobile_2'],
								"Bank_Code" 		=> !empty($result['data'][$index]['Bank_Code']) ? $result['data'][$index]['Bank_Code']:'',
								"AcctNo" 			=> !empty($result['data'][$index]['AcctNo']) ? $result['data'][$index]['AcctNo']:'',
								"LB_EmpCode" 		=> $result['data'][$index]['LB_EmpCode'],
								"LB_EmpName" 		=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['LB_EmpName']),
								"LB_RegionID" 		=> $result['data'][$index]['LB_RegionID'],
								"LB_BranchCode" 	=> $result['data'][$index]['LB_BranchCode'],
								"PositionTitle" 	=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['PositionTitle']),
								"RegionNameEng" 	=> $result['data'][$index]['RegionNameEng'],
								"LB_BranchName" 	=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['LB_BranchName']),
								"BranchDigit" 		=> $result['data'][$index]['BranchDigit'],
								"BranchTel" 		=> $result['data'][$index]['BranchTel'],
								"LB_Ref01_Code"		=> $result['data'][$index]['LB_Ref01_Code'],
								"LB_Ref01" 			=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['LB_Ref01']),
								"LB_Ref02_Code"		=> !empty($extract_code[0]) ? $extract_code:'',
								"LB_Ref02" 			=> !empty($extract_name[0]) ? $extract_name:'',
								"TLA_Address"		=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['TLA_Address']),
								"SentEnvelope"		=> ($result['data'][$index]['SentEnvelope'] == 'Y') ? $result['data'][$index]['SentEnvelope']:'',
								"TLA_Status" 		=> trim($result['data'][$index]['TLA_Status']),
								"IDCard"			=> $result['data'][$index]['IDCard'],
								"TLCard"			=> $result['data'][$index]['TLCard'],
								"TL_Channel"		=> $result['data'][$index]['TL_Channel'],
								"CreateBy" 			=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['CreateBy']),
								"CreateDate" 		=> $this->effective->StandartDateRollback($result['data'][$index]['CreateDate']),
								"UpdateBy" 			=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['UpdateBy']),
								"UpdateDate" 		=> $this->effective->StandartDateRollback($result['data'][$index]['UpdateDate'])
								
						)
					);
						
				}
			
				$conv['status']     = true;
				$conv['msg']     	= 'The data inquiry succesfully.';
					
				$this->json_parse($conv);
					
			} else {
					
				$this->json_parse(array(
						'data'      => 'Data failed.',
						'status'    => false,
						'msg'       => 'The occurrence handled exception in passing parameter..'
					)
				);
					
			}
			
		}
		
		
	}
	
	public function getTLABelongToBranch() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$result = $this->dbmodel->CIQuery("SELECT TLA_BranchName FROM MasterTLA WHERE TLA_BranchName IS NOT NULL GROUP BY TLA_BranchName ORDER BY TLA_BranchName ASC");
		if(!empty($result['data'][0]['TLA_BranchName'])) {
				
			$conv['data'] = array();
			foreach($result['data'] as $index => $value):		
				array_push($conv['data'], array("TLA_BranchName" => $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['TLA_BranchName'])));		
			endforeach;
			
			$conv['status']     = true;
			$conv['msg']     	= 'Inquiry succesfully.';
			
			$this->json_parse($conv);
				
		} else {				
			$this->json_parse(array('status' => false, 'msg' => 'เกิดข้อผิดพล กรุณาลองใหม่อีกครั้ง.'));
				
		}
	}

	public function getTLAPositionTitle() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		$result = $this->dbmodel->CIQuery("SELECT TLA_Position FROM MasterTLA WHERE TLA_Position IS NOT NULL GROUP BY TLA_Position ORDER BY TLA_Position ASC");
		if(!empty($result['data'][0]['TLA_Position'])) {
	
			$conv['data'] = array();
			foreach($result['data'] as $index => $value):
			array_push($conv['data'], array("TLA_Position" => $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['TLA_Position'])));
			endforeach;
				
			$conv['status']     = true;
			$conv['msg']     	= 'Inquiry succesfully.';
				
			$this->json_parse($conv);
	
		} else {
			$this->json_parse(array('status' => false, 'msg' => 'เกิดข้อผิดพล กรุณาลองใหม่อีกครั้ง.'));
	
		}
		
	}
	
	public function loadMasterCollectionReason() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
	
		$result	= $this->dbmodel->CIQuery("
			SELECT  RowID, ColID, Reason, ReasonType, IsActive
			FROM  MasterCollectionReason
			WHERE IsActive = 'A'
			ORDER BY ReasonType ASC				
		");
		
		
		$conv['data'] = array();
		foreach($result['data'] as $index => $value):
			array_push($conv['data'], array(
					"RowID"			=> $result['data'][$index]['RowID'],
					"ColID"			=> $result['data'][$index]['ColID'],
					"Reason"  		=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['Reason']),
					"ReasonType"	=> $result['data'][$index]['ReasonType'],
					"IsActive"		=> $result['data'][$index]['IsActive']
				)
			);
		endforeach;
		
		header('Content-Type: application/json; charset="UTF-8"');	
		echo json_encode($conv);
		
		
	}
	
	public function getBankList() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		

		$data_result  = $this->dbmodel->loadData('Master_Bank', 'Bank_Code, Bank_NameTh, Bank_NameEng, Bank_Digit, IsActive', array('Bank_Code !=' => '001', 'IsActive' => 'A'));
		
		$conv['data'] = array();
		foreach($data_result['data'] as $index => $value) {
	
			array_push($conv['data'], 
				array(
					"Bank_Code"    => !empty($data_result['data'][$index]['Bank_Code']) ? $data_result['data'][$index]['Bank_Code']:'',
					"Bank_NameTh"  => !empty($data_result['data'][$index]['Bank_NameTh']) ? $this->effective->get_chartypes($this->char_mode, $data_result['data'][$index]['Bank_NameTh']):'',
					"Bank_NameEng" => !empty($data_result['data'][$index]['Bank_NameEng']) ? $data_result['data'][$index]['Bank_NameEng']:'',
					"Bank_Digit"   => !empty($data_result['data'][$index]['Bank_Digit']) ? trim($data_result['data'][$index]['Bank_Digit']):''							
				)
			);
				
		}
		
		$this->json_parse($conv);
		
	}
	
	public function getMasterTLAStatusList() {
		$this->load->model('dbmodel');
		
		$where		  = '';
		$not_use	  = $this->input->post('unstatus');
		
		if(!empty($not_use)) {
			$status_pieces = explode(',', $not_use);
			if(!empty($status_pieces[0])):
				$where 	= "WHERE NOT TL_Status IN ('".implode("','", $status_pieces)."') AND IsActive = 'A'";
			else:
				$where	= "WHERE IsActive = 'A'";
			endif;
			
		}

		$data_result  = $this->dbmodel->CIQuery("
			SELECT RowID, TL_Status, IsActive, Seq
			FROM   MasterTLAStatus
			$where 
			ORDER BY Seq ASC
		");
		
		$i = 1;
		$conv['data'] = array();
		foreach($data_result['data'] as $index => $value) {	
			
			array_push($conv['data'],
				array(
					"RowID"    	 => !empty($data_result['data'][$index]['RowID']) ? $data_result['data'][$index]['RowID']:'',
					"TL_Status"  => !empty($data_result['data'][$index]['TL_Status']) ? $data_result['data'][$index]['TL_Status']:'',
					"IsActive" 	 => !empty($data_result['data'][$index]['IsActive']) ? $data_result['data'][$index]['IsActive']:'',
					"Seq"   	 => $i
				)
			);
			
			$i++;
		
		}
		
		$conv['status']     = true;
		$conv['msg']     	= 'Inquiry succesfully.';
		
		$this->json_parse($conv);
		
		
	}
	
	public function getPostponeReasonForSpanText() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$doc_id = $this->input->post('docx');
		
		$conv['data'] = array();
		if(empty($doc_id)) {
			
			$conv['text']		= null;
			$conv['status']     = false;
			$conv['msg']     	= 'Inquiry failed.';
			echo json_encode($conv);
			
		} else {
			
			$result	= $this->dbmodel->CIQuery("
				SELECT PostponeSubscription.ListID, PostponeSubscription.DocID, PostponeSubscription.PostponeRef, PostponeSubscription.PostponeCode,
				MasterPostponeReason.PostponeReason, PostponeSubscription.IsActive
				FROM PostponeSubscription
				LEFT OUTER JOIN MasterPostponeReason
				ON MasterPostponeReason.PostponeCode = PostponeSubscription.PostponeCode
				WHERE (PostponeSubscription.DocID = '".$doc_id."')
				AND PostponeRef = (SELECT MAX(PostponeRef) FROM PostponeSubscription WHERE DocID = '".$doc_id."')
			");

			foreach($result['data'] as $index => $value):
				array_push($conv['data'], $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['PostponeReason']));
			endforeach;
			
			$conv['text']		= implode(',', $conv['data']);
			$conv['status']     = true;
			$conv['msg']     	= 'Inquiry succesfully.';
			
			header('Content-Type: application/json; charset="UTF-8"');
			echo json_encode($conv);
			
		}
		
	}
	
	public function confirmDefend() {
		$this->load->model('dbmodel');
		
		date_default_timezone_set("Asia/Bangkok");
		
		$doc_id			= $this->input->post('relidx');
		$defend_ref		= $this->input->post('relnox');
		$defend_id		= $this->input->post('defidx');
		$defend_name	= $this->input->post('defnamex');
		$defend_assign	= date('Y-m-d H:i:s');
		
		$verify = $this->dbmodel->data_validation('New_DefendAssignLogs', '*', array('DocID' => $doc_id, 'DefendRef' => $defend_ref, 'DefendProgress' => 'DEF Received'), false);
		if($verify == 'TRUE') {
			
			$result = $this->dbmodel->CIQuery("
				SELECT * FROM New_DefendAssignLogs
				WHERE DocID = '".$doc_id."' 
				AND DefendRef = '".$defend_ref."'
				ORDER BY AssignDate DESC
			");
			
			$latest_state = !empty($result['data'][0]['DefendProgress']) ? $result['data'][0]['DefendProgress']:'Send to CA';
			
			$param = array(
					'AssignmentID'		=> $defend_id,
					'AssignmentName'	=> $defend_name,
					'AssignmentDate'	=> $defend_assign,
					'AssignmentConfirm'	=> 'Y'
			);
			
			$logs  = array(
					'DocID'				=> $doc_id,
					'DefendRef'			=> $defend_ref,
					'DefendProgress'	=> $latest_state,
					'AssignDate'		=> $defend_assign,
					'AssignID'			=> $defend_id,
					'AssignBy'			=> $defend_name						
			);
			
		} else {
			$param = array(
					'AssignmentID'		=> $defend_id,
					'AssignmentName'	=> $defend_name,
					'AssignmentDate'	=> $defend_assign,
					'AssignmentConfirm'	=> 'Y',
					'DefendProgress'	=> 'DEF Received'
			);
			
			$logs  = array(
					'DocID'				=> $doc_id,
					'DefendRef'			=> $defend_ref,
					'DefendProgress'	=> 'DEF Received',
					'AssignDate'		=> $defend_assign,
					'AssignID'			=> $defend_id,
					'AssignBy'			=> $defend_name
			);
			
		}
		
		if(!empty($doc_id)) {
			$reps = $this->dbmodel->exec('New_DefendHead', $param, array('DocID' => $doc_id, 'DefendRef' => $defend_ref), 'update');
			$this->dbmodel->exec('New_DefendAssignLogs', $logs, false, 'insert');
			 	
			$this->json_parse(array('status' => true, 'msg' => 'บันทึกข้อมูลสำเร็จ.'));
		
		} else {
			$this->json_parse(array('status' => false, 'msg' => 'เกิดข้อผิดพล กรุณาลองใหม่อีกครั้ง.'));		
		}
				
	}
	
	public function printDefend() {
		$this->load->model('dbmodel');
		
		date_default_timezone_set("Asia/Bangkok");
	
		$doc_id			= $this->input->post('doc_id');
		$defend_ref		= $this->input->post('defendref');
		$user_id		= $this->input->post('userid');
		$user_name		= $this->input->post('username');
		$actiondate		= date('Y-m-d H:i:s');
				
		//$param	= array('DefendProgress' => 'Send to CA', 'UpdateID' => $user_id, 'UpdateBy' => $user_name);

		$logs	= array(
			'DocID'			=> $doc_id,
			'DefendRef'		=> $defend_ref,
			'DefendCode'	=> NULL,
			'DefendEvent'	=> 'PRINT',
			'CreateID'		=> $user_id,
			'CreateBy'		=> $user_name,
			'CreateDate'	=> $actiondate
		);
				
		//$statelogs	= array('DocID'	=> $doc_id, 'DefendRef' => $defend_ref, 'DefendProgress' => 'Send to CA', 'AssignDate' => $actiondate, 'AssignID' => $user_id, 'AssignBy' => $user_name);
			
		if(!empty($doc_id)) {
			$this->dbmodel->exec('New_DefendEventLog', $logs, false, 'insert');
			//$this->dbmodel->exec('New_DefendHead', $param, array('DocID' => $doc_id, 'DefendRef' => $defend_ref), 'update');			
			//$this->dbmodel->exec('New_DefendAssignLogs', $statelogs, false, 'insert');
			$this->json_parse(array('status' => true, 'msg' => 'บึนทึกข้อมูลสำเร็จ.'));
	
		} else {
			$this->json_parse(array('status' => false, 'msg' => 'เกิดข้อผิดพล กรุณาลองใหม่อีกครั้ง.'));
	
		}
	
	}
	
	public function unlockProcessDefend() {
		$this->load->model('dbmodel');
		
		date_default_timezone_set("Asia/Bangkok");
	
		$doc_id			= $this->input->post('doc_id');
		$defend_ref		= $this->input->post('defendref');
		$user_id		= $this->input->post('userid');
		$user_name		= $this->input->post('username');
		$actiondate		= date('Y-m-d H:i:s');
	
		$param	= array(
				'DefendProgress' => 'Re-Process',
				'UpdateID'		 => $user_id,
				'UpdateBy'	  	 => $user_name
		);
	
		$logs	= array(
				'DocID'			=> $doc_id,
				'DefendRef'		=> $defend_ref,
				'DefendCode'	=> NULL,
				'DefendEvent'	=> 'RE-PROCESS',
				'CreateID'		=> $user_id,
				'CreateBy'		=> $user_name,
				'CreateDate'	=> $actiondate
		);
		
		$statelogs	= array(
				'DocID'				=> $doc_id,
				'DefendRef'			=> $defend_ref,
				'DefendProgress'	=> 'Re-Process',
				'AssignDate'		=> $actiondate,
				'AssignID'			=> $user_id,
				'AssignBy'			=> $user_name
		);
	
		if(!empty($doc_id)) {
			$this->dbmodel->exec('New_DefendHead', $param, array('DocID' => $doc_id, 'DefendRef' => $defend_ref), 'update');
			$this->dbmodel->exec('New_DefendEventLog', $logs, false, 'insert');
			$this->dbmodel->exec('New_DefendAssignLogs', $statelogs, false, 'insert');
			$this->json_parse(array('status' => true, 'msg' => 'บึนทึกข้อมูลสำเร็จ.'));
	
		} else {
			$this->json_parse(array('status' => false, 'msg' => 'เกิดข้อผิดพล กรุณาลองใหม่อีกครั้ง.'));
	
		}
	
	}
	
	public function endOfProcessDefend() {
		$this->load->model('dbmodel');
	
		date_default_timezone_set("Asia/Bangkok");
	
		$doc_id			= $this->input->post('doc_id');
		$defend_ref		= $this->input->post('defendref');
		$user_id		= $this->input->post('userid');
		$user_name		= $this->input->post('username');
		$completed		= $this->input->post('complete');
		$actiondate		= date('Y-m-d H:i:s');
	
		
		$param	= array(
				'DefendProgress' => $completed,
				'UpdateID'		 => $user_id,
				'UpdateBy'	  	 => $user_name
		);
	
		$logs	= array(
				'DocID'			=> $doc_id,
				'DefendRef'		=> $defend_ref,
				'DefendCode'	=> NULL,
				'DefendEvent'	=> strtoupper($completed),
				'CreateID'		=> $user_id,
				'CreateBy'		=> $user_name,
				'CreateDate'	=> $actiondate
		);
	
		$statelogs	= array(
				'DocID'				=> $doc_id,
				'DefendRef'			=> $defend_ref,
				'DefendProgress'	=> $completed,
				'AssignDate'		=> $actiondate,
				'AssignID'			=> $user_id,
				'AssignBy'			=> $user_name
		);
				
		if(!empty($doc_id)) {
			$this->dbmodel->exec('New_DefendHead', $param, array('DocID' => $doc_id, 'DefendRef' => $defend_ref), 'update');
			$this->dbmodel->exec('New_DefendEventLog', $logs, false, 'insert');
			$this->dbmodel->exec('New_DefendAssignLogs', $statelogs, false, 'insert');
			$this->json_parse(array('status' => true, 'msg' => 'บึนทึกข้อมูลสำเร็จ.'));
	
		} else {
			$this->json_parse(array('status' => false, 'msg' => 'เกิดข้อผิดพล กรุณาลองใหม่อีกครั้ง.'));
	
		}
	
	}
	
	public function rollbackProcessDefend() {
		$this->load->model('dbmodel');
	
		date_default_timezone_set("Asia/Bangkok");
	
		$doc_id			= $this->input->post('doc_id');
		$defend_ref		= $this->input->post('defendref');
		$user_id		= $this->input->post('userid');
		$user_name		= $this->input->post('username');
		$actiondate		= date('Y-m-d H:i:s');
	
		$param	= array(
				'DefendProgress' => 'Re-Process',
				'UpdateID'		 => $user_id,
				'UpdateBy'	  	 => $user_name
		);
	
		$logs	= array(
				'DocID'			=> $doc_id,
				'DefendRef'		=> $defend_ref,
				'DefendCode'	=> NULL,
				'DefendEvent'	=> 'RE-PROCESS (ROLLBACK)',
				'CreateID'		=> $user_id,
				'CreateBy'		=> $user_name,
				'CreateDate'	=> $actiondate
		);
	
		$statelogs	= array(
				'DocID'				=> $doc_id,
				'DefendRef'			=> $defend_ref,
				'DefendProgress'	=> 'Re-Process',
				'AssignDate'		=> $actiondate,
				'AssignID'			=> $user_id,
				'AssignBy'			=> $user_name
		);
	
		if(!empty($doc_id)) {
			$this->dbmodel->exec('New_DefendHead', $param, array('DocID' => $doc_id, 'DefendRef' => $defend_ref), 'update');
			$this->dbmodel->exec('New_DefendEventLog', $logs, false, 'insert');
			$this->dbmodel->exec('New_DefendAssignLogs', $statelogs, false, 'insert');
			$this->json_parse(array('status' => true, 'msg' => 'บึนทึกข้อมูลสำเร็จ.'));
	
		} else {
			$this->json_parse(array('status' => false, 'msg' => 'เกิดข้อผิดพล กรุณาลองใหม่อีกครั้ง.'));
	
		}
	
	}
	
	
	public function getDefendGroup() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
				
		$data_result  = $this->dbmodel->loadData('LendingEmp', 'EmployeeCode, FullNameTh, Mobile', array('GroupID ' => '1', 'IsActive' => 'A'));
		
		$conv['data'] = array();
		foreach($data_result['data'] as $index => $value) {
		
			array_push($conv['data'],
				array(
					"EmployeeCode"  => !empty($data_result['data'][$index]['EmployeeCode']) ? $data_result['data'][$index]['EmployeeCode']:'',
					"FullNameTh" 	=> !empty($data_result['data'][$index]['FullNameTh']) ? $this->effective->get_chartypes($this->char_mode, $data_result['data'][$index]['FullNameTh']):'',
					"Mobile" 		=> !empty($data_result['data'][$index]['Mobile']) ? $data_result['data'][$index]['Mobile']:''
				)
			);
		
		}
		
		$conv['status']		= true;
		$this->json_parse($conv);
	}
	
	public function getEmployeeDrawdownList() {
		$this->load->model('dbmodel');
		
		$empcode 	= $this->input->post('empcode');
		$viewmode	= $this->input->post('viewmode');
		$authen		= $this->input->post('role');

		$profiles	= $this->dbmodel->CIQuery("
			SELECT LendingEmp.EmployeeCode, FullNameTh, MasterRegion.RegionID, MasterRegion.RegionNameEng,
			MasterArea.AreaName, ISNULL(LendingEmp.BranchCode, LendingEmp.OfficeBase) AS BranchCode,  LendingBranchs.BranchName
			FROM LendingEmp
			LEFT OUTER JOIN LendingBranchs
			ON LendingBranchs.BranchCode = ISNULL(LendingEmp.BranchCode, LendingEmp.OfficeBase)
			LEFT OUTER JOIN MasterRegion
			ON MasterRegion.RegionID = LendingBranchs.RegionID
			LEFT OUTER JOIN MasterArea
			ON MasterArea.AreaName = LendingEmp.AreaCode
			WHERE LendingEmp.EmployeeCode = '".$empcode."'		
		");
		
		$where		= '';
		switch ($authen) {
			case 'rd_role':
				$where	= "WHERE RegionID = '". $profiles['data'][0]['RegionID'] ."'";
			break;
			case 'am_role':
				$where	= "WHERE MasterArea.AreaName = '". $profiles['data'][0]['AreaName'] ."'";
			break;
			case 'bm_role':
			case 'adminbr_role':
			case 'admin_role':
				if($profiles['data'][0]['BranchCode'] === '000'):
					$where	= "";
				else:
					$where	= "WHERE BranchCode = '". $profiles['data'][0]['BranchCode'] ."'";
				endif;				
			break;
			case 'rm_role':
				$where	= "WHERE EmployeeCode = '". $empcode ."'";
			break;	
			case 'dev_role':
			case 'hq_role':
			default: 
				$where	= '';
			break;
		}
		
		$condition_additional = "AND PositionTitle NOT IN ('Branch Admin')";
		if(!empty($viewmode)) {
		
			if(in_array($viewmode, array('whiteboard'))) {
				$condition_additional = " AND PositionTitle NOT IN ('Branch Admin', 'Relationship Manager')";
			} 
			
		}
		
		$condition_bmonly = 'ON LendingBranchs.BranchCode = ISNULL(LendingEmp.BranchCode, OfficeBase)';
		if(in_array($authen, array('bm_role', 'adminbr_role'))) {
			$condition_bmonly = 'ON LendingBranchs.BranchCode = LendingEmp.BranchCode';
		}
		
		$result	= $this->dbmodel->CIQuery("
			SELECT * FROM (
				SELECT EmployeeCode, 
				CASE 
					WHEN PositionTitle = 'Deputy Regional Director' THEN MasterArea.AreaName
					ELSE FullNameTh
				END AS FullNameTh, PositionTitle, 
				CASE
					WHEN PositionTitle = 'Regional Director' THEN 'RD'
					WHEN PositionTitle = 'Area Manager' THEN 'AM'
					WHEN PositionTitle = 'Deputy Regional Director' THEN 'AM'
					WHEN PositionTitle = 'Branch Manager' THEN 'BM'
					WHEN PositionTitle = 'Relationship Manager' THEN 'RM'
				END AS PositionShort,
				LendingEmp.RegionID, MasterRegion.RegionNameEng, MasterArea.AreaName, 
				LendingBranchs.BranchCode, LendingBranchs.BranchDigit, LendingBranchs.BranchName,
				CASE
					WHEN PositionTitle = 'Regional Director' THEN 1
					WHEN PositionTitle = 'Area Manager' THEN 2
					WHEN PositionTitle = 'Deputy Regional Director' THEN 2
					WHEN PositionTitle = 'Branch Manager' THEN 3
					WHEN PositionTitle = 'Relationship Manager' THEN 4
				END AS Flag
				FROM LendingEmp
				LEFT OUTER JOIN LendingBranchs
				$condition_bmonly
				LEFT OUTER JOIN MasterRegion
				ON MasterRegion.RegionID = LendingBranchs.RegionID
				LEFT OUTER JOIN MasterArea
				ON MasterArea.AreaCode = LendingBranchs.AreaID
				WHERE NOT LendingEmp.RegionID = '01'
				AND LendingEmp.IsActive = 'A'
				AND PositionTitle NOT IN ('Admin-SFE')
				$condition_additional
			) A
			$where
			ORDER BY Flag ASC, AreaName ASC, FullNameTh ASC
		");
		
		$result['overview'] = array(
			'EmployeeCode'	=> '56225',
			'FullNameTh'	=> 'Overview Summary',
			'PositionShort' => 'HO'
		);
		
		
		$result['status'] = true;
		$this->json_parse($result);

	}
	
	public function getNewEmployeeDrawdownList() {
		$this->load->model('dbstore');
		$this->load->library('effective');
		
		$empcode 	= $this->input->post('empcode');
		$authen		= $this->input->post('role');
		
		if(empty($empcode)) :
			$this->json_parse(array(
					'data'      => '',
					'status'    => false,
					'msg'       => 'load failed'
				)
			);
		
		else:
		
			try {
				
				$data['data'] = array();
				$result_set	  = $this->dbstore->getEmployeeWhiteboardList($empcode, $authen);
				
				foreach($result_set['data'] as $index => $values) {
					
					array_push($data['data'], array(
							"EmployeeCode"    => $values['EmployeeCode'],
							"FullNameTh"      => $this->effective->get_chartypes($this->char_mode, $values['FullNameTh']),
							"PositionTitle"   => $values['PositionTitle'],
							"PositionShort"   => $values['PositionShort'],
							"RegionID" 	  	  => $values['RegionID'],
							"RegionNameEng"   => $values['RegionNameEng'],
							"AreaName"   	  => $values['AreaName'],
							"BranchCode"      => $values['BranchCode'],
							"BranchDigit" 	  => $values['BranchDigit'],
							"BranchName"      => $this->effective->get_chartypes($this->char_mode, $values['BranchName']),
							"Flag" 		      => $values['Flag']
						)
					);
					
				}
				
				$data['overview'] = array(
						'EmployeeCode'	=> '56225',
						'FullNameTh'	=> 'Overview Summary',
						'PositionShort' => 'HO'
				);
				
				$data['status'] = true;
				$data['msg']    = 'load success';
				
				$this->json_parse($data);
				
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
		
		endif;
		
	}
		
	public function getReconcileChecker() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		date_default_timezone_set("Asia/Bangkok");
		
		$doc_id	  = $this->input->post('relx');
		$custname = $this->input->post('xname');
		$old_date = $this->input->post('odate');
		$new_date = $this->input->post('ndate');
		$event 	  = $this->input->post('event');
		$field	  = $this->input->post('field');
		
		$emp_id   = $this->session->userdata("empcode");
		$emp_name = $this->session->userdata("thname");
		
		$object	  = array(
			'DocID'		   => $doc_id,
			'BorrowerName' => $this->effective->get_chartypes($this->char_mode, $custname),
			'EventType'    => $event,
			'EventField'   => !empty($field) ? $field:NULL,
			'OldDate'	   => !empty($old_date) ? $this->effective->StandartDateSorter($old_date):NULL,
			'NewDate'	   => !empty($new_date) ? $this->effective->StandartDateSorter($new_date):NULL,
			'ActiveID'	   => $emp_id,
			'ActiveBy'	   => $this->effective->get_chartypes($this->char_mode, $emp_name),
			'ActiveDate'   => date('Y-m-d H:i:s')
		);
		
		$this->dbmodel->exec('ReconcileDocEventHandledLog', $object, false, 'insert');	
		
	}
	
	public function getReconcileCompletionChecker() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		date_default_timezone_set("Asia/Bangkok");
		
		$doc_id	  = $this->input->post('relx');
		$custname = $this->input->post('xname');
		$old_date = $this->input->post('odate');
		$new_date = $this->input->post('ndate');
		$doc_type = $this->input->post('dtype');
		$event 	  = $this->input->post('event');
		$field	  = $this->input->post('field');
		
		$emp_id   = $this->session->userdata("empcode");
		$emp_name = $this->session->userdata("thname");
		
		$object	  = array(
				'DocID'		   => $doc_id,
				'BorrowerName' => $this->effective->get_chartypes($this->char_mode, $custname),
				'DocType'	   => !empty($doc_type) ? $doc_type:NULL,
				'EventType'    => $event,
				'EventField'   => !empty($field) ? $field:NULL,
				'OldDate'	   => !empty($old_date) ? $this->effective->StandartDateSorter($old_date):NULL,
				'NewDate'	   => !empty($new_date) ? $this->effective->StandartDateSorter($new_date):NULL,
				'ActiveID'	   => $emp_id,
				'ActiveBy'	   => $this->effective->get_chartypes($this->char_mode, $emp_name),
				'ActiveDate'   => date('Y-m-d H:i:s')
		);
		
		$this->dbmodel->exec('ReconcileCompletionHandledLog', $object, false, 'insert');
		
	}
	
	function getTLChannel() {		
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$tl_year = $this->config->item('tlagent_year');
		$result  = $this->dbmodel->CIQuery("select * from MasterTLChannel where [Year] = '".$tl_year."'");
		
		$data['data'] = array();
		foreach($result['data'] as $index => $values) {
			array_push($data['data'], array(
					"RowID"      		=> $result['data'][$index]['RowID'],
					"Year"      		=> $result['data'][$index]['Year'],
					"SourceCategory"    => $result['data'][$index]['SourceCategory'],
					"SourceChannel"  	=> $this->effective->get_chartypes($this->char_mode, $result['data'][$index]['SourceChannel']),
					"IsActive"   		=> $result['data'][$index]['IsActive']
		
				)
			);
		
		}
		
		echo json_encode($data);
		
	}
	
	function getUserPlanDrawdownDate() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		date_default_timezone_set("Asia/Bangkok");
		
		$emp_id   = $this->session->userdata("empcode");
		$emp_name = $this->session->userdata("thname");
		
		$doc_id	 			 = $this->input->post('docid');
		$app_no 			 = $this->input->post('appno');
		$plandd				 = $this->input->post('pdate');
		
		$event_logs 		 = array(
				'DocID'			=> $doc_id,
				'ApplicationNo' => $app_no,
				'EventProcess'	=> 'PLAN DRAWDOWN (SELECTED '. $plandd .')',
				'CreateByID'	=> $emp_id,
				'CreateByName'	=> $this->effective->get_chartypes($this->char_mode, $emp_name),
				'CreateByDate'	=> date('Y-m-d H:i:s')
		);

		$result = $this->dbmodel->exec('PCISEventLogs', $event_logs, false, 'insert');
		if($result) $this->json_parse(array('status' => true, 'msg' => 'Log Bundled.'));
		else $this->json_parse(array('status' => false, 'msg' => 'Insert failed.'));
		
		
	}
	
	function unlockPlanDrawdownDate() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		date_default_timezone_set("Asia/Bangkok");
		
		$emp_id   = $this->session->userdata("empcode");
		$emp_name = $this->session->userdata("thname");
		
		$doc_id	 			 = $this->input->post('docid');
		$app_no 			 = $this->input->post('appno');
		$plandd				 = $this->input->post('pdate');
		
		$event_logs 		 = array(
				'DocID'			=> $doc_id,
				'ApplicationNo' => $app_no,
				'EventProcess'	=> 'UNLOCK PLAN DD (BEFORE DATE '. $plandd .')',
				'CreateByID'	=> $emp_id,
				'CreateByName'	=> $this->effective->get_chartypes($this->char_mode, $emp_name),
				'CreateByDate'	=> date('Y-m-d H:i:s')
		);
		
		$result = $this->dbmodel->exec('PCISEventLogs', $event_logs, false, 'insert');
		if($result) $this->json_parse(array('status' => true, 'msg' => 'Log Bundled.'));
		else $this->json_parse(array('status' => false, 'msg' => 'Insert failed.'));

	}
	
	public function getDrawdownHistory() {
		$this->load->model('dbmodel');
		
		$doc_id	= ($this->input->get('DocID')) ? $this->input->get('DocID'):$this->input->post('DocID');
		if(empty($doc_id)) {
			
			$conv['data'] 	= null;
			$conv['status'] = false;
			$conv['msg']    = 'The Parameter was has issue passing...';
			
			$this->json_parse($conv);
			
		} else {
			
			$result  = $this->dbmodel->CIQuery("
				SELECT ISNULL([ApplicationNoReplace].[ApplicationNoReplace],[Drawdown_History].[ApplicationNo]) [ApplicationNo],
				ApplicationStatus.DocID, DrawdownLoan, [Drawdown_History].DrawdownDate
				FROM [PCIS].[dbo].[Drawdown_History]
				LEFT OUTER JOIN ApplicationStatus on [PCIS].[dbo].[Drawdown_History].ApplicationNo = ApplicationStatus.ApplicationNo
				LEFT OUTER JOIN [PCIS].[dbo].[ApplicationNoReplace] ON [Drawdown_History].[ApplicationNo] = [ApplicationNoReplace].[ApplicationNo]
				WHERE ApplicationStatus.DocID = '".$doc_id."'
			");
						
			if(!empty($result['data'][0]['ApplicationNo'])) {
			
				$conv['data'] 	= $result['data'];
				$conv['status'] = true;
				$conv['msg']    = 'Inquiry succesfully.';
			
				$this->json_parse($conv);
			
			} else {
				$this->json_parse(array('data' => null, 'status' => false, 'msg' => 'The issue inquiry. Data not found'));
			
			}
			
		}
			
	}
	
	public function getNCBConsentByPerson() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$index_id	= ($this->input->get('idx')) ? $this->input->get('idx'):$this->input->post('idx');
		if(empty($index_id)) {
			$conv['data'] 	= null;
			$conv['status'] = false;
			$conv['msg']    = 'The Parameter was has issue passing...';
			
			$this->json_parse($conv);
			
		} else {
			
			$result  = $this->dbmodel->CIQuery("
				SELECT NCS_ID, NCBConsent.DocID, NCBConsent.VerifyID, NCBConsent.BorrowerType, NCBConsent.BorrowerName, NCBConsent.NCBCheck,  
				CASE NCBConsent.NCBCheckDate
						WHEN '1900-01-01' THEN ''
						WHEN '' THEN NULL
						ELSE CONVERT(nvarchar(10), NCBConsent.NCBCheckDate, 120)
					END AS NCBCheckDate,
					CASE NCBConsent.SubmitToHQ
						WHEN '1900-01-01' THEN NULL
						WHEN '' THEN NULL
						ELSE CONVERT(nvarchar(10), NCBConsent.SubmitToHQ, 120)
					END AS SubmitToHQ,
					CASE NCBConsent.HQReceivedFromLB
						WHEN '1900-01-01' THEN NULL
						WHEN '' THEN NULL
						ELSE CONVERT(nvarchar(10), NCBConsent.HQReceivedFromLB, 120)
					END AS HQReceivedFromLB,
					CASE NCBConsent.HQSubmitToOper
						WHEN '1900-01-01' THEN NULL
						WHEN '' THEN NULL
						ELSE CONVERT(nvarchar(10), NCBConsent.HQSubmitToOper, 120)
					END AS HQSubmitToOper, NCBConsent.OperReturn,
					CASE NCBConsent.OperReturnDate
						WHEN '1900-01-01' THEN NULL
						WHEN '' THEN NULL
						ELSE CONVERT(nvarchar(10), NCBConsent.OperReturnDate, 120)
					END AS OperReturnDate, NCBConsentRetrunLogs.NCBReturnDateLog, 
					NCBConsent.IsActive, NCBConsent.IsRef
				FROM  NCBConsent
				LEFT OUTER JOIN (
					SELECT * FROM (
					SELECT ROW_NUMBER() OVER(PARTITION BY BorrowerType,REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(BorrowerName, '(REA)', ''), '(RET)', ''), '(Retrieve)', ''), '(Re-Activated)', ''), '(revisited)', ''), '(Resubmit ใหม่)', ''),VerifyID ORDER BY OperReturnDate DESC, VerifyID, BorrowerType) as Numindex,
					VerifyID AS VFL, BorrowerType, 
					REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(BorrowerName, '(REA)', ''), '(RET)', ''), '(Retrieve)', ''), '(Re-Activated)', ''), '(revisited)', ''), '(Resubmit ใหม่)', '') AS BorrowerName,
					OperReturn AS ReCheck,
					CASE OperReturnDate
						WHEN '1900-01-01' THEN NULL
						WHEN '' THEN NULL
						ELSE CONVERT(nvarchar(10), OperReturnDate, 120)
					END AS NCBReturnDateLog
					FROM dbo.NCBConsentLogs) Tmp
					WHERE Numindex = 1					
				) NCBConsentRetrunLogs
				ON NCBConsent.VerifyID = NCBConsentRetrunLogs.VFL 
				AND NCBConsent.BorrowerType = NCBConsentRetrunLogs.BorrowerType
				AND REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(NCBConsent.BorrowerName, '(REA)', ''), '(RET)', ''), '(Retrieve)', ''), '(Re-Activated)', ''), '(revisited)', ''), '(Resubmit ใหม่)', '') = NCBConsentRetrunLogs.BorrowerName
				WHERE NCBConsent.NCS_ID = '".$index_id."'
				AND NCBConsent.IsActive = 'A'
				ORDER BY NCBConsent.BorrowerType ASC
			");
			
			if(!empty($result['data'][0]['DocID'])) {
				
				$result['data'][0]['BorrowerName'] 	   = $this->effective->get_chartypes($this->char_mode, $result['data'][0]['BorrowerName']);
				$result['data'][0]['NCBCheckDate'] 	   = (!empty($result['data'][0]['NCBCheckDate'])) ? $this->effective->StandartDateRollback($result['data'][0]['NCBCheckDate']):null;
				$result['data'][0]['SubmitToHQ']   	   = (!empty($result['data'][0]['SubmitToHQ'])) ? $this->effective->StandartDateRollback($result['data'][0]['SubmitToHQ']):null;
				$result['data'][0]['HQReceivedFromLB'] = (!empty($result['data'][0]['HQReceivedFromLB'])) ? $this->effective->StandartDateRollback($result['data'][0]['HQReceivedFromLB']):null;
				$result['data'][0]['HQSubmitToOper']   = (!empty($result['data'][0]['HQSubmitToOper'])) ? $this->effective->StandartDateRollback($result['data'][0]['HQSubmitToOper']):null;
				$result['data'][0]['OperReturnDate']   = (!empty($result['data'][0]['OperReturnDate'])) ? $this->effective->StandartDateRollback($result['data'][0]['OperReturnDate']):null;
				
				$conv['data'] 	= $result['data'];
				
				$conv['status'] = true;
				$conv['msg']    = 'Inquiry succesfully.';
				
				$this->json_parse($conv);
				
			} else {
				$this->json_parse(array('data' => null, 'status' => false, 'msg' => 'The issue inquiry. Data not found'));
				
			}
			
		}
		
		
	}
	
	public function setNCBConsentManagement() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		date_default_timezone_set("Asia/Bangkok");
		
		$emp_id   = $this->session->userdata("empcode");
		$emp_name = $this->session->userdata("thname");
		$action	  = date('Y-m-d H:i:s');
		
		$ncs_id	 			 = $this->input->post('ncsx');
		$verify_id	 		 = $this->input->post('verx');
		$doc_id				 = $this->input->post('docx');
		$borrowername		 = $this->input->post('bname');
		$borrowertype		 = $this->input->post('btype');
		$ncb_state		 	 = $this->input->post('bstate');
		$ncb_checkdate	 	 = $this->input->post('ncbdate');
		$ncb_lb2ho 			 = $this->input->post('lb2ho');
		$horeceived			 = $this->input->post('hodoc');
		$ncb_ho2ca			 = $this->input->post('ho2ca');
		$isref				 = $this->input->post('isref');
		
		$objNCBConsent		 = array(
			'NCBCheckDate'		=> (!empty($ncb_checkdate)) ? $this->effective->StandartDateSorter($ncb_checkdate):NULL,
			'SubmitToHQ'		=> (!empty($ncb_lb2ho)) ? $this->effective->StandartDateSorter($ncb_lb2ho):NULL,
			'HQReceivedFromLB'	=> (!empty($horeceived)) ? $this->effective->StandartDateSorter($horeceived):NULL,
			'HQSubmitToOper'	=> (!empty($ncb_ho2ca)) ? $this->effective->StandartDateSorter($ncb_ho2ca):NULL, 
		);

		$objNCBConsentLogs	= array(
			'DocID'				=> $doc_id,
			'VerifyID'			=> $verify_id,
			'BorrowerType'		=> $borrowertype, 
			'BorrowerName'		=> $this->effective->get_chartypes($this->char_mode, $borrowername), 
			'NCBCheck'			=> $ncb_state, 
			'NCBCheckDate'		=> (!empty($ncb_checkdate)) ? $this->effective->StandartDateSorter($ncb_checkdate):NULL, 
			'SubmitToHQ'		=> (!empty($ncb_lb2ho)) ? $this->effective->StandartDateSorter($ncb_lb2ho):NULL, 
			'HQReceivedFromLB'	=> (!empty($horeceived)) ? $this->effective->StandartDateSorter($horeceived):NULL, 
			'HQSubmitToOper'	=> (!empty($ncb_ho2ca)) ? $this->effective->StandartDateSorter($ncb_ho2ca):NULL, 
			'OperReturn'		=> NULL, 
			'OperReturnDate'	=> NULL, 
			'IsActive'			=> 'A', 
			'IsRef'				=> (!empty($isref)) ? $isref:NULL, 
			'CreateBy'			=> $emp_name, 
			'CreateDate'		=> $action
		);
		
		if(!empty($doc_id)) {
			$upt_ncb = $this->dbmodel->exec('NCBConsent', $objNCBConsent, array('NCS_ID' => $ncs_id), 'update');
			$this->dbmodel->exec('NCBConsentSubmitHandledLogs', $objNCBConsentLogs, false, 'insert');
			if($upt_ncb) {
				$conv['data'] 	= $objNCBConsent;
				$conv['status'] = true;
				$conv['msg']    = 'update success';
				
				$this->json_parse($conv);
				
			} else {
				$conv['data'] 	= $objNCBConsent;
				$conv['status'] = false;
				$conv['msg']    = 'update faild';
				
				$this->json_parse($conv);
			}
			
		} else {
			$conv['data'] 	= null;
			$conv['status'] = false;
			$conv['msg']    = 'The Parameter was has issue passing...';
			
			$this->json_parse($conv);
		}
		
	}
	
	public function loadIssueOption() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$doc_id	= ($this->input->get('DocID')) ? $this->input->get('DocID'):$this->input->post('DocID');
		$def_ref= ($this->input->get('DefendRef')) ? $this->input->get('DefendRef'):$this->input->post('DefendRef');

		if(empty($doc_id)) {
			
			$this->json_parse(array(
					'data'      => '',
					'status'    => false,
					'msg'       => 'ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง.'
				)
			);
			
		} else {
			
			$raw_log = $this->dbmodel->CIQuery("	
				SELECT ROW_NUMBER() OVER(ORDER BY #DefendAssignLogs.DocID ASC) AS RowID,
				[Profile].DocID, MasterRegion.RegionID, MasterRegion.RegionNameEng, MasterArea.AreaCode, MasterArea.AreaName, 
				LendingBranchs.BranchCode, LendingBranchs.BranchDigit, LendingBranchs.BranchName, LendingBranchs.BranchTel,
				RMCode, RMName, RMMobile, NCBConsent.BorrowerName, BusinessType, Business AS BusinessDesc, ApprovedStatus,
				DefendRef, ProgressLabel, AssignDate, AssignID, AssignBy, LendingEmp.Mobile AS AssignMobile
				FROM (
					SELECT New_DefendAssignLogs.DocID, New_DefendAssignLogs.DefendRef, ProgressLabel, AssignDate, AssignID, AssignBy, ApprovedStatus,
					ROW_NUMBER() OVER(PARTITION BY New_DefendAssignLogs.DocID, New_DefendAssignLogs.DefendRef ORDER BY AssignDate DESC) as Numindex
					FROM  New_DefendAssignLogs
					LEFT OUTER JOIN DefendProgress
					ON DefendProgress.InProgress = New_DefendAssignLogs.DefendProgress
					LEFT OUTER JOIN New_DefendRequestToManager
					ON New_DefendRequestToManager.DocID = New_DefendAssignLogs.[DocID]
					AND New_DefendRequestToManager.DefendRef = New_DefendAssignLogs.DefendRef  AND ApprovedStatus = 'N'
					WHERE IsActive = 'A' 
					AND ([New_DefendAssignLogs].[DocID] = '".$doc_id."')
					AND ([New_DefendAssignLogs].[DefendRef] = '".$def_ref."')
				) AS #DefendAssignLogs
				LEFT OUTER JOIN [Profile]
				ON #DefendAssignLogs.DocID = [Profile].DocID
				LEFT OUTER JOIN LendingEmp
				ON LendingEmp.EmployeeCode = #DefendAssignLogs.AssignID
				LEFT OUTER JOIN NCBConsent
				ON [Profile].DocID = NCBConsent.DocID AND BorrowerType = '101'
				INNER JOIN LendingBranchs
				ON [Profile].BranchCode = LendingBranchs.BranchCode
				INNER JOIN MasterRegion
				ON LendingBranchs.RegionID = MasterRegion.RegionID
				INNER JOIN MasterArea
				ON LendingBranchs.AreaID = MasterArea.AreaCode
				WHERE Numindex = 1
			");
		
			$conv['data'] = array();
			foreach($raw_log['data'] as $index => $value) {
				
				array_push($conv['data'], array(
						"DocID" 					=> $value['DocID'],
						"RegionID" 					=> $value['RegionID'],
						"RegionNameEng" 			=> $value['RegionNameEng'],
						"AreaCode" 					=> $value['AreaCode'],
						"AreaName" 					=> $value['AreaName'],
						"RMCode" 					=> $value['RMCode'],
						"RMName" 					=> $this->effective->get_chartypes($this->char_mode, $value['RMName']),
						"RMMobile" 					=> $value['RMMobile'],		
						"BorrowerName" 				=> $this->effective->get_chartypes($this->char_mode, $value['BorrowerName']),
						"BusinessType" 				=> $this->effective->get_chartypes($this->char_mode, $value['BusinessType']),
						"BusinessDesc" 				=> $this->effective->get_chartypes($this->char_mode, $value['BusinessDesc']),	
						"ApprovedStatus" 			=> $value['ApprovedStatus'],
						"DefendRef" 				=> $value['DefendRef'],
						"ProgressLabel" 			=> $value['ProgressLabel'],
						"AssignDate" 				=> $value['AssignDate'],
						"AssignID" 					=> $value['AssignID'],
						'AssignBy'					=> $this->effective->get_chartypes($this->char_mode, $value['AssignBy']),
						"AssignMobile" 				=> $value['AssignMobile']
						
					)
				);
				
			}
		
			$this->json_parse($conv);
			
		}
		
	}
	
	public function loadActionNoteJSONLog() {
		$this->load->model('dbstore');
		$this->load->library('effective');
		
		$doc_id = ($this->input->get('docx')) ? $this->input->get('DocID'):$this->input->post('docx');
		
		if(empty($doc_id)) :
			$this->json_parse(array(
				'data'      => '',
				'status'    => false,
				'msg'       => 'load failed'
				)
			);
			
		else :
		
			try {
				
				$data['data'] = array();
				$result		  = $this->dbstore->exec_getActionNoteJSONLogs($doc_id);
				
				foreach($result['data'] as $index => $values) {
					
					array_push($data['data'], array(
							"DocID" 		  	  => $values['DocID'],
							"ActionNote" 		  => $this->effective->get_chartypes($this->char_mode, $values['ActionNote']),
							"ActionNoteBy" 		  => $values['ActionNoteBy'],
							"ActionName" 		  => $this->effective->get_chartypes($this->char_mode, $values['ActionName']),
							"ActionNoteDate" 	  => ($values['ActionNoteDate']) ? $this->effective->StandartDateRollback($values['ActionNoteDate']):'',
							"ActionDateTime" 	  => ($values['ActionDateTime']) ? substr($values['ActionDateTime'], -8, 8):'',
							"PositionShort" 	  => $this->effective->get_chartypes($this->char_mode, $values['PositionShort']),
							"BusinessType" 		  => $this->effective->get_chartypes($this->char_mode, $values['BusinessType']),
							"BusinessDesc" 		  => $this->effective->get_chartypes($this->char_mode, $values['Business'])
					));
					
				}
							
				$data['status'] = true;
				$data['msg']    = 'load success';
				
				$this->json_parse($data);
				
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
		
		endif;
	
	}
	
	public function onResetEventDocumentFlow() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		date_default_timezone_set("Asia/Bangkok");
		
		$emp_id   = $this->session->userdata("empcode");
		$emp_name = $this->session->userdata("thname");
		$action	  = date('Y-m-d H:i:s');

		$doc_id				 = $this->input->post('doc_id');
		$recx_id			 = $this->input->post('recx_id');
		$logistic			 = $this->input->post('logistic');
		$borrower_name		 = $this->input->post('custname');
		$borrower_type		 = $this->input->post('custtype');
		$lb2ho_date			 = $this->input->post('lb2ho');
		$hqreceived_date	 = $this->input->post('hq_received');
		$completeddoc		 = $this->input->post('completeddoc');
		$ho2ca_date			 = $this->input->post('ho2ca');
		$isref				 = $this->input->post('isref');
		
		$reset_reconcile 	 = array(
			'DocID' 			=> $doc_id,
			'LogisticCode' 		=> NULL,
			'SubmitDocToHQ' 	=> NULL,
			'ReceivedDocFormLB' => NULL,
			'CompletionDoc' 	=> NULL,
			'CompletionDate' 	=> NULL,
			'AppToCA' 			=> NULL
		);
		
		$reset_reconcilelogs  = array(
			'DocID' 			=> $doc_id,
			'EventMode' 		=> 'RESET',
			'BorrowerName' 		=> $borrower_name,
			'BorrowerType' 		=> $borrower_type,
			'LogisticCode' 		=> (!empty($logistic)) ? $logistic:NULL,
			'SubmitDocToHQ' 	=> (!empty($lb2ho_date)) ? $this->effective->StandartDateSorter($lb2ho_date):NULL,
			'ReceivedDocFormLB' => (!empty($hqreceived_date)) ? $this->effective->StandartDateSorter($hqreceived_date):NULL,
			'CompletionDoc' 	=> $completeddoc,
			'AppToCA' 			=> (!empty($ho2ca_date)) ? $this->effective->StandartDateSorter($ho2ca_date):NULL,
			'CreateID' 			=> $emp_id,
			'CreateBy' 			=> $emp_name,
			'CreateDate' 		=> $action
		);
		
		if(!empty($doc_id)) {
			$upt_reconcile = $this->dbmodel->exec('ReconcileDoc', $reset_reconcile, array('Rec_ID' => $recx_id), 'update');
			$this->dbmodel->exec('ReconcileDocEventLogs', $reset_reconcilelogs, false, 'insert');
			
			if($upt_reconcile) {
				$conv['data'] 	= array('current_clear' => $reset_reconcile, 'old_data' => $reset_reconcilelogs);
				$conv['status'] = true;
				$conv['msg']    = 'reset success';
				
				$this->json_parse($conv);
				
			} else {
				$conv['data'] 	= $reset_reconcilelogs;
				$conv['status'] = false;
				$conv['msg']    = 'reset failed';
				
				$this->json_parse($conv);
			}
			
		} else {
			$conv['data'] 	= null;
			$conv['status'] = false;
			$conv['msg']    = 'The Parameter was has issue passing...';
			
			$this->json_parse($conv);
		}
	
	}
	
	public function application_verify() {
		$this->load->model('dbmodel');
		
		$doc_id	= $this->input->post('doc_id');
		$app_no = $this->input->post('app_no');
		
		if(empty($doc_id) && empty($app_no)) {			
			$this->json_parse(array(
					'data'      => '',
					'status'    => false,
					'msg'       => 'กรุณาระบุข้อมูลให้ครบถ้วน'
				)
			);
			
		} else {			
			$verify = $this->dbmodel->data_validation('PCISEventLogs', "*", array('DocID' => $doc_id,'ApplicationNo' => $app_no), false);
			if($verify === 'FALSE') {
				$this->json_parse(array(
						'data'      => '',
						'status'    => false,
						'msg'       => 'ไม่พบข้อมูล กรุณาลองใหม่อีกครั้ง.'
					)
				);
			} else {
				$this->json_parse(array(
						'data'      => $app_no,
						'status'    => true,
						'msg'       => 'ค้นหาข้อมูลสำเร็จ'
					)
				);
			}			
		}		
	}
	
	public function application_update() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		date_default_timezone_set("Asia/Bangkok");
				
		$doc_id	= $this->input->post('doc_id');
		$cur_appno = $this->input->post('oApp');
		$new_appno = $this->input->post('nApp');
		
		$emp_id   = $this->session->userdata("empcode");
		$emp_name = $this->session->userdata("thname");
		
		if(empty($doc_id) && empty($app_no)) {
			$this->json_parse(array(
					'data'      => '',
					'status'    => false,
					'msg'       => 'กรุณาระบุข้อมูลให้ครบถ้วน'
				)
			);			
		} else {	
						
			$app_from 		 = (!empty($cur_appno)) ? $cur_appno:'-';
			$app_to			 = (!empty($new_appno)) ? $new_appno:'-';
			
			$event_logs 		 = array(
				'DocID'			=> $doc_id,
				'ApplicationNo' => $cur_appno.'-'.$app_to,
				'EventProcess'	=> 'CHANGE APPLICATION',
				'CreateByID'	=> $emp_id,
				'CreateByName'	=> $this->effective->get_chartypes($this->char_mode, $emp_name),
				'CreateByDate'	=> date('Y-m-d H:i:s')
			);
			
			$this->dbmodel->exec('PCISEventLogs', $event_logs, false, 'insert');
			$result = $this->dbmodel->exec('ApplicationStatus', 
				array('ApplicationNo' => $app_to, 'ChangeBy' => $this->effective->get_chartypes($this->char_mode, $emp_name), 'ChangeDate' => date('Y-m-d H:i:s')), 
				array('DocID' => $doc_id), 
				'update'
			);

			if($result) $this->json_parse(array('status' => true, 'msg' => 'Sucess, change bundled.'));
			else $this->json_parse(array('status' => false, 'msg' => 'Sucess, change failed.'));
	
		}	
		
	}
	
	
	public function checkSendEmail(){
		$this->load->model('dbmodel');
		$this->load->model('dbstore');
		date_default_timezone_set("Asia/Bangkok");
		
		$config = array(
			'start_period_1' => date('Y-m-d 10:00:00'),
			'end_period_1' => date('Y-m-d 11:30:00'),
			'start_period_2' => date('Y-m-d 14:00:00'),
			'end_period_2' => date('Y-m-d 15:30:00'),
			'start_period_3' => date('Y-m-d 16:00:00'),
			'end_period_3' => date('Y-m-d 20:00:00')
		);
		
		$time_today = time(); //date('Y-m-d H:i:s');
		
		$condition_period = '';
		if($time_today >= strtotime($config['start_period_1']) && $time_today <= strtotime($config['end_period_1'])) {
			$condition_period = "WHERE [dbo].[DateOnlyFormat](SentDate) BETWEEN [dbo].[DateOnlyFormat]('". $config['start_period_1'] ."') AND [dbo].[DateOnlyFormat]('".$config['end_period_1']."')";
		} 
		else if($time_today >= strtotime($config['start_period_2']) && $time_today <= strtotime($config['end_period_2'])){
			$condition_period = "WHERE [dbo].[DateOnlyFormat](SentDate) BETWEEN [dbo].[DateOnlyFormat]('". $config['start_period_2'] ."') AND [dbo].[DateOnlyFormat]('".$config['end_period_2']."')";
		}
		else if($time_today >= strtotime($config['start_period_3']) && $time_today <= strtotime($config['end_period_3'])){
			$condition_period = "WHERE [dbo].[DateOnlyFormat](SentDate) BETWEEN [dbo].[DateOnlyFormat]('". $config['start_period_3'] ."') AND [dbo].[DateOnlyFormat]('".$config['end_period_3']."')";
		}
		
		$result_set = $this->dbmodel->CIQuery("SELECT * FROM PCISEmail_SendLogs $condition_period");
		if($result_set['status'] == 'true') {
			echo $this->json_parse(array('data' => array(), 'status' => false, 'msg' => 'Sorry, The system has send data to credit analysis already.'));
		} else {			
			echo $this->json_parse($this->dbstore->exec_getRequestDefend());			
		}

	}
	
	public function updateSendEmail() {
		$this->load->model('dbmodel');
		date_default_timezone_set("Asia/Bangkok");
		
		$list	= $this->input->post('items');
		
		if(!empty($list[0]['DocID'])) {
			foreach ($list as $i => $v) {
				$data_set = array(
					'DocID'			=> $v['DocID'],
					'ApplicationNo' => $v['ApplicationNo'],
					'SentDate'		=> date('Y-m-d H:i:s')
				);
				
				$this->dbmodel->exec('PCISEmail_SendLogs', $data_set, false, 'insert');
		
			}
			
			$this->json_parse(array('status' => true, 'msg' => 'Success'));
			
		}
		
	}
	
	public function sendAppToManager() {
		$this->load->model('dbmodel');
		date_default_timezone_set("Asia/Bangkok");
		
		$doc_id		= $this->input->post('DocID');
		$def_id		= $this->input->post('DefendRef');
		$cust_id 	= $this->input->post('CreateID');
		$cust_name	= $this->input->post('CreateBy');
		
		if(!empty($doc_id)) {
			$data_set = array(
				'DocID'				=> $doc_id,
				'DefendRef' 		=> $def_id,
				'ApprovedStatus'	=> 'W',
				'CreateID'			=> $cust_id,
				'CreateBy'			=> $cust_name,
				'CreateDate'		=> date('Y-m-d H:i:s')
			);
			
			$this->dbmodel->exec('New_DefendRequestToManager', $data_set, false, 'insert');
			
			echo $this->json_parse(array('status' => true, 'msg' => 'Success'));
			
		} else {
			echo $this->json_parse(array('status' => false, 'msg' => 'Sorry, The system has send data to credit analysis already.'));
		}

	}
	
	public function getDataInbox() {
		$this->load->model('dbstore');
		$this->load->library('effective');
		
		$emp_code = ($this->input->get('emp_code')) ? $this->input->get('emp_code'):$this->input->post('emp_code');
		
		if(empty($emp_code)) :
			$this->json_parse(array(
					'data'      => array(),
					'status'    => false,
					'msg'       => 'load failed'
				)
			);
		
		else :
		
			try {
				
				$data['data'] = array();
				$result		  = $this->dbstore->exec_getRequestDefendToInbox($emp_code);
				
				foreach($result['data'] as $index => $values) {
					
					array_push($data['data'], array(
							"DocID" 		  	  => $values['DocID'],
							"RegionID" 		  	  => $values['RegionID'],
							"AreaCode" 		  	  => $values['AreaCode'],
							"AreaShortCode" 	  => $values['AreaShortCode'],
							"BranchCode" 		  => $values['BranchCode'],
							"BranchName" 		  => $this->effective->get_chartypes($this->char_mode, $values['BranchName']),
							"RMCode" 		  	  => $values['RMCode'],
							"RMName" 		  	  => !empty($values['RMName']) ? $this->effective->get_chartypes($this->char_mode, $values['RMName']) : null,
							"DefendRef" 		  => $values['DefendRef'],
							"ApprovedStatus" 	  => $values['ApprovedStatus'],
							"CreateID" 		  	  => $values['CreateID'],
							"CreateBy" 		  	  => $this->effective->get_chartypes($this->char_mode, $values['CreateBy']),
							"CreateDate" 		  => !empty($values['CreateDate']) ? $values['CreateDate'] : null
					));
					
				}
				
				$data['status'] = true;
				$data['msg']    = 'load success';
				
				$this->json_parse($data);
				
			} catch (Exception $e) {
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
			}
			
		endif;
	}
	
	public function loadDefendList() {
		$this->load->model('dbmodel');
		$this->load->library('effective');
		
		$doc_id = ($this->input->get('doc_id')) ? $this->input->get('doc_id'):$this->input->post('doc_id');
		
		if(empty($doc_id)) :
			$this->json_parse(array(
					'data'      => array(),
					'status'    => false,
					'msg'       => 'load failed'
				)
			);
		
		else :

			$raw_log = $this->dbmodel->CIQuery("				
				SELECT 
					[DocID], 
					[New_DefendSubHead].[DefendCode], 
					CASE 
						WHEN DefendTitleOption IS NOT NULL AND NOT DefendTitleOption = '' THEN CAST(DefendReason AS NVARCHAR(MAX)) + '-' + DefendTitleOption
						ELSE DefendReason
					END [DefendReason],
					[CreateName], 
					CONVERT(nvarchar(10), [CreateDate], 120) [CreateDate]
				FROM [dbo].[New_DefendSubHead]
				OUTER APPLY (	
					SELECT [MainCode], [MainReason] [DefendReason], [Isactive], [Seq] 
					FROM [dbo].[MasterDeviateCategoryForDefend]
					WHERE [Isactive] = 'Y'
					AND [MainCode] = [New_DefendSubHead].[DefendCode]
				) [MasterDefendProgress]
				WHERE [New_DefendSubHead].[IsActive] = 'A'
				AND [New_DefendSubHead].[DefendCode] NOT IN ('SP001','SP002','SP003','SP004')
				AND DocID = '".$doc_id."'
				ORDER BY CreateDate DESC
			");
			
			$conv['data'] = array();
			foreach($raw_log['data'] as $index => $value) {				
				array_push($conv['data'], array(
						"DocID" 					=> $value['DocID'],
						"DefendCode" 				=> $value['DefendCode'],
						"DefendReason" 				=> $this->effective->get_chartypes($this->char_mode, $value['DefendReason']),
						"CreateName" 				=> !empty($value['CreateName']) ? $this->effective->get_chartypes($this->char_mode, $value['CreateName']):null,
						"CreateDate" 				=> !empty($value['CreateDate']) ? $value['CreateDate']:null
						
					)
				);				
			}
			
			$conv['status'] = true;
			$conv['msg']    = 'load success';
				
			$this->json_parse($conv);
	
		endif;
								
	}
	
	public function getDefendTopicNewList() {
		$this->load->model('dbmodel');
		$this->load->library('effective');

		try {
			
			$results = $this->dbmodel->CIQuery("
				SELECT [MainCode], [MainReason], [Isactive], [Seq] 
				FROM [dbo].[MasterDeviateCategoryForDefend]
				WHERE [Isactive] = 'Y'
				AND [MainCode] NOT IN ('SP001','SP002','SP003','SP004')
				ORDER BY [Seq] ASC
			");
			
			$conv['data'] = array();
			$conv['dataList'] = array();
			
			foreach($results['data'] as $index => $value) {				
				array_push($conv['data'], array(
						"MainCode"		=> $value['MainCode'],
						"MainReason"	=> !empty($value['MainReason']) ? $this->effective->get_chartypes($this->char_mode, $value['MainReason']):''
					)
				);				
			}
			
			if(!empty($conv['data'][0]['MainCode'])) {
				
				$results2 = $this->dbmodel->CIQuery("
					SELECT [DeviateCode], [MainCode], [DeviateReason], [Remark], [Isactive]
					FROM [dbo].[MasterDeviateReasonForDefend]
					WHERE [Isactive] = 'Y'
					ORDER BY [DeviateCode] ASC
				");
				
				foreach($results2['data'] as $index => $value) {
					array_push($conv['dataList'], array(
							"DeviateCode"	=> $value['DeviateCode'],
							"MainCode"		=> $value['MainCode'],
							"DeviateReason"	=> !empty($value['DeviateReason']) ? $this->effective->get_chartypes($this->char_mode, $value['DeviateReason']):'',
							"Remark"		=> !empty($value['Remark']) ? $this->effective->get_chartypes($this->char_mode, $value['Remark']):''
						)
					);
				}
			
				$conv['status'] = true;
				$conv['msg'] = 'success';
				
				$this->json_parse($conv);
				
			} else {
				$conv['status'] = true;
				$conv['msg'] = 'success';
				
				$this->json_parse($conv);
				
			}
			
		} catch (Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
		}
		
	}
	
	// NEW API ON 23 FEB 2019
	public function requestClearPendingCancel() {
		$this->load->model('dbmodel');
		
		$doc_id		= $this->input->post('DocID');
		$cust_id 	= $this->input->post('CreateID');
		$cust_name	= $this->input->post('CreateBy');
		
		if(!empty($doc_id)) {			
			$data_set = array(
				'DocID'	=> $doc_id,
				'PendingCancelStatus'	=> 'N',
				'PendingCancelReason'	=> 'Clear pending cancel from user',
				'IsActive'				=> 'A',
				'CreateByID'			=> $cust_id,
				'CreateByName'      	=> $cust_name,
				'CreateByDate'      	=> date("Y-m-d H:i:s")
			);
			
			$result = $this->dbmodel->exec('ApplicationPendingCancelLogs', $data_set, false, 'insert');
			if($result == TRUE) {
				echo $this->json_parse(array('status' => true, 'msg' => 'Success'));
			} else {
				echo $this->json_parse(array('status' => false, 'msg' => 'Insert failed'));
			}
			
			
		} else {
			echo $this->json_parse(array('status' => false, 'msg' => 'Failed, criteria incorrect.'));
		}
		
	}
	
// 	public function checkApplicationUnique() {
// 		$this->load->model('dbmodel');
// 		$this->load->library('effective');
		
// 		$appno		= $this->input->post('AppNo');
		
// 		try {
			
// 			$results = $this->dbmodel->CIQuery("SELECT * FROM [dbo].[ApplicationStatus] WHERE [ApplicationNo] = '".$appno."'");
			
			
			
// 		} catch (Exception $e) {
// 			echo 'Caught exception: '.$e->getMessage()."\n";
// 			echo 'Caught exception: '.$e->getLine()."\n";
// 			echo 'The Exception: '.$e->getTrace()."\n";
// 		}
		
// 	}
	
		
}

?>