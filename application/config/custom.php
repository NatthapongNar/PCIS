<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Configulation
$config['official holiday']		= array(
	'Jan' => array('01', '02', '03'),
	'Fen' => array('11', '13'),
	'Mar' => array(),
	'Apr' => array('06', '13', '14', '15', '17'),
	'May' => array('01', '05', '10'),
	'Jun' => array(),
	'Jul' => array('08', '09', '10', '11'),
	'Aug' => array('12', '14'),
	'Sep' => array(),
	'Oct' => array('23'),
	'Nov' => array(),
	'Dec' => array('05', '10', '11', '31')
);

// META TAG
$config['site_title']           = 'PCIS';
$config['site_description']     = 'Prospect Customer Information System';
$config['site_keyword']         = 'PCIS';
$config['site_author']          = 'PCIS';
$config['site_viewport']        = 'width=device-width, initial-scale=1';
$config['site_footer']          = '<div class="bottom-menu-wrapper"><ul class="horizontal-menu compact"><li class="animated slideInLeft">PCIS<sup>©</sup> 2017 TCRB Lending Branch<br> <b>Compatible with google chrome</b></li></ul></div>';

// logs
$config['debug_log']			= "application/logs/debug/";

// Web Service
// $config['uri_protocal']	        = "http://tc001thcs1p/WsUser/UserManagement.asmx?WSDL"; // test
$config['uri_protocal']	        = "http://tc001hpas1p/WsUser/UserManagement.asmx?WSDL"; // pro
$config['system_id']			= "074";

$config['collateral_uri']		= 'http://172.17.9.68/CollateralAppraisal/Default.aspx';

// API
$config['api_userlogin']	    = "CheckUserlogin";

$config['database_env']			= 'uat';
$config['database_types']		= 'sqlsrv';
$config['char_mode']			= false;

// Auth
$config['Role_Enabled']			= array('57251', '56225', '57249', '60848', '620470', '55143');
$config['Administrator']		= array('57251', '56225', '58141', '56679', '58106', '59016', '58385', '57568', '59440', '57160', '58355', '59411', '59408', '99999', '59151', '57249', '55143');
$config['DefendTeam']			= array('56365', '58360', '57017', '57151', '57249', '59184', '59414', '99999', '59628', '57568', '59692', '60223', '59440', '58252', '59389', '55143');
$config['MISTeam']				= array('57251', '56679', '58106', '58141', '56225', '611161', '58385', '57568', '59440', '55143');
$config['SupportTeam']			= array('56680', '56465', '57171', '56650', '58080', '56700', '58051', '57301', '60424', '55143');
$config['TLAgentTeam']			= array('58523', '58016', '57170', '56225', '57251', '58141', '58202', '58355', '59613', '58355', '55143');
$config['Tester']				= array('57251', '56679', '57568', '56225', '59440', '58141', '55143');
$config['AMActing']				= array('57552','57253','57299','60860','56453','60958','57537','57466','57579','57642','57647','58599','55272','53021','56101','57159');
$config['Audit']				= array('610911','610164','56514','57236','57451','57669','56451','601228','55191','59497','610899','610943','56573','55158','58580','610818','58516');

$config['FullCancel']			= array('REJECT', 'CANCEL', 'CANCELBYCA', 'CANCELBYRM', 'CANCELBYCUS');
$config['DecisionStutus'] 	 	= array('PENDING', 'APPROVED', 'REJECT', 'CANCEL');
$config['FinalDecisionStutus'] 	= array('PENDING', 'APPROVED', 'REJECT', 'CANCEL');
$config['CancelBefore'] 		= array('CANCELBYCA', 'CANCELBYRM', 'CANCELBYCUS');

$config['BM_Direct']			= array('58007');

$config['DefendName']			= array(
	'DEF_HEAD'		=> array('EmployeeCode' => '59389', 'FullNameTh' => 'ปรีดา วิเศษสุข'),
	'DEF_RATTAWIT'  => array('EmployeeCode' => '58252', 'FullNameTh' => 'ลัทธวิทย์ ศรีนวลจันทร์'),
	'DEF_WORAYA'	=> array('EmployeeCode' => '57249', 'FullNameTh' => 'วรญา ศรีเมือง'),
	'DEF_ACHARA'	=> array('EmployeeCode' => '57151', 'FullNameTh' => 'อัจฉรา สุวรรณรัตน์'),
	'DEF_NITTAYA'	=> array('EmployeeCode' => '57017', 'FullNameTh' => 'นิตยา ศรีชูยงค์'),
	'DEF_PILAIWAN'	=> array('EmployeeCode' => '59414', 'FullNameTh' => 'พิไลวรรณ หะสิตะ'),
	'DEF_NATTANUN'	=> array('EmployeeCode' => '59628', 'FullNameTh' => 'ณัฐนันท์ เหลืองสุภาพรกุล'),
	'DEF_NALINRAT'	=> array('EmployeeCode' => '59692', 'FullNameTh' => 'นลินรัตน์ เมฆะสิริพงศ์')
);

$config['Defend_Role']			= array(
	'SOUTH'		=> array(
		'SOUTH1' =>  $config['DefendName']['DEF_NITTAYA'], 
		'SOUTH2' =>  $config['DefendName']['DEF_NITTAYA']
	),
	'NORTH'		=> array(
		'NORTH1' => $config['DefendName']['DEF_NALINRAT'], 
		'NORTH2' => $config['DefendName']['DEF_NALINRAT']
	),
	'EAST'		=> array(
		'EAST1' => $config['DefendName']['DEF_PILAIWAN'], 
		'EAST2' => $config['DefendName']['DEF_PILAIWAN'], 
		'EAST3' => $config['DefendName']['DEF_PILAIWAN']
	),
	'CENTRAL'	=> array(
		'CENTRAL1' => $config['DefendName']['DEF_RATTAWIT'], 
		'CENTRAL2' => $config['DefendName']['DEF_RATTAWIT'], 
		'CENTRAL3' => $config['DefendName']['DEF_RATTAWIT']
	),
	'NORTHEAST'	=> array(
		'N/E1' => $config['DefendName']['DEF_ACHARA'], 
		'N/E2' => $config['DefendName']['DEF_ACHARA'], 
		'N/E3' => $config['DefendName']['DEF_ACHARA']
	)
);

$config['ROLE_SENT_APPROVED'] = array(
	'SOUTH'		=> array(
		'SOUTH1' => array('rd_role', 'dev_role'),
		'SOUTH2' => array('rd_role', 'dev_role')
	),
	'NORTH'		=> array(
		'NORTH1' => array('am_role', 'dev_role'),
		'NORTH2' => array('am_role', 'dev_role')
	),
	'EAST'		=> array(
		'EAST1' => array('am_role', 'dev_role'),
		'EAST2' => array('am_role', 'dev_role'),
		'EAST3' => array('am_role', 'dev_role')
	),
	'CENTRAL'	=> array(
		'CENTRAL1' => array('am_role', 'dev_role'),
		'CENTRAL2' => array('am_role', 'dev_role'),
		'CENTRAL3' => array('am_role', 'dev_role')
	),
	'NORTHEAST'	=> array(
		'N/E1' => array('am_role', 'dev_role'),
		'N/E2' => array('am_role', 'dev_role'),
		'N/E3' => array('am_role', 'dev_role')
	)
);

// TABLE NAME
$config['table_profile']                = 'Profile';
$config['table_verification']           = 'Verification';
$config['table_applicationstatus']      = 'ApplicationStatus';
$config['table_branch']                 = 'Branchs';
$config['table_callout']                = 'CallOut';
$config['table_docrefund']              = 'DocRefund';
$config['table_masterchannel']          = 'MasterChannel';
$config['table_masterdoc']              = 'MasterDoc';
$config['table_masterdowntown']         = 'MasterDowntown';
$config['table_employee']         		= 'Employees';
$config['table_ncb']                    = 'NCB';
$config['table_product']                = 'Product';
$config['table_rmprocesslog']           = 'RMProcesslog';
$config['table_exportlog']              = 'ExportLog';
$config['table_province']               = 'NewProvince'; //'Province';

// NEW TABLE
$config['table_depmap']					= "DepMap";
$config['table_lendingemp']				= "LendingEmp";
$config['table_lendingbranchs']			= "LendingBranchs";
$config['table_region']				    = "MasterRegion";
$config['table_duecustom']				= "MasterDueReason";
$config['table_clndrevent']				= "ClndrEvent";
$config['table_clndrplan']				= "ClndrPlant";
$config['table_notification']			= "Notification";
$config['table_masterrevisit']			= "MasterRevisit";
$config['table_revisitreason']			= "MasterRevisitReason";
$config['table_reactivate']				= "ReActivate";
$config['table_lackdoc']				= "MasterLackDoc";
$config['table_lacklist']				= "LackList";
$config['table_appointment']			= "Appointment";

// SCRIPT VERSION
$config['mainchart_version']			= "?v=001";
$config['collection_version']			= "?v=003";
$config['chatscript_version']			= "?v=074";
$config['ref_mangement']				= "?v=001";
$config['ref_dashboard']				= "?v=001";
$config['whiteboard']					= "?v=001";
$config['whiteboard_v2']				= "?v=001";
$config['reset_chat']					= date('YmdHis');

$config['tlagent_year']					= '2016';


// STORE PROCEDURE: CALL STORE NAME



// Role Specify
$config['ROLE_ADMIN']					= "074001";
$config['ROLE_RM']						= "074002";
$config['ROLE_BM']						= "074003";
$config['ROLE_AM']						= "074004";
$config['ROLE_RD']						= "074005";
$config['ROLE_HQ']						= "074006";
$config['ROLE_SPV']						= "074007";
$config['ROLE_ADMINSYS']				= "074008";
$config['ROLE_CA']						= "074009";
$config['ROLE_OPER']					= "074010";

// Special User
$config['TempUser']						= 'julaluk';
$config['TempPass']						= 'tcrb2017';
