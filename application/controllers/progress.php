<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Progress extends MY_Controller {
	
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
	
	/*****      APPLICATION  PROCESS       ******/
	public function appComponents() {
		$this->load->model('dbprogress');
		$this->load->library('effective');
	
		//header('Content-Type: text/html; charset="UTF-8"');
	
		$results = $this->dbprogress->dataTableProgress($this->authorized, array($this->emp_id));
		$iTotal	 = $this->dbprogress->dataTablePagination($this->authorized, array($this->emp_id));
		
		foreach($results['data'] as $index => $value) {
			$cust_name = ($results['data'][$index]['MainLoanName'] != "") ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['MainLoanName']):$this->effective->get_chartypes($this->char_mode, $results['data'][$index]['OwnerName']);
			$retrieve  = !empty($results['data'][$index]['hasRetrieve']) ? ' <abbr title="Retrieve on date : '. $this->effective->StandartDateRollback($results['data'][$index]['RetrieveDate']) .'" style="border: 0;"><small>(' . $results['data'][$index]['hasRetrieve'] . ')</small></abbr>':null;
	
			$interest  = ($results['data'][$index]['Interest'] == 'Y') ? "สนใจ":"ไม่สนใจ";
			$products  = !empty($results['data'][$index]['ProductCode']) ? trim($results['data'][$index]['ProductTypes']).'-'.substr($results['data'][$index]['ProductCode'], -2, 2):"";
			$colums[]  = array(
					"CreateDate" 		=> $this->effective->StandartDateRollback($results['data'][$index]['CreateDate']),
					"SourceOfCustomer"  => '<abbr title="'.$results['data'][$index]['SourceChannel'].'" style="border:none;">'.$results['data'][$index]['SourceOfCustomer'].'</abbr>',
					"Interest"			=> '<abbr title="'.$interest.'" style="border:none;">'.$results['data'][$index]['Interest'].'</abbr>',
					"CSPotential"		=> '<abbr title="'.$this->levelCustomer($results['data'][$index]['CSPotential']).'" style="border:none;">'.$results['data'][$index]['CSPotential'].'</abbr>',
					"LoanGroup"			=> '<abbr title="'.$this->loanGroupType($results['data'][$index]['LoanGroup']).'" style="border:none;">'.$results['data'][$index]['LoanGroup'].'</abbr>',
					"OwnerName"			=> $cust_name . $retrieve,
					"DueDate"			=> $this->effective->StandartDateRollback($results['data'][$index]['DueDate']),
					"Downtown"			=> ($results['data'][$index]['Downtown'] != "") ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['Downtown']):'',
					"Business"			=> ($results['data'][$index]['Business'] != "") ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['Business']):'',
					"RequestLoan"		=> ($results['data'][$index]['RequestLoan'] != "") ? number_format($results['data'][$index]['RequestLoan'], 0):"",
					"BranchDigit"		=> $results['data'][$index]['BranchDigit'],
					"RMName"			=> ($results['data'][$index]['RMName'] != "") ? $this->effective->get_chartypes($this->char_mode, $results['data'][$index]['RMName']):'',
					"AppProcess"		=> !empty($results['data'][$index]['AppProcess']) ?
					'<div class="app-state">'.
					'<a target="_blank" href="'.$this->createlink($results['data'][$index]['AppProcess']).'?'.$this->urlInitial($results['data'][$index]['AppProcess']).'&d='.date('dmH:i').'&cache=false&secure='.md5(true).'&rel='.$results['data'][$index]['DocID'].'&req=P1&live='.$this->liveInitial($results['data'][$index]['AppProcess']).'&t='.date('s').'"><div '.$this->notify($results['data'][$index]['AppProcess']).' class="'.$this->processstate($results['data'][$index]['AppProcess']).'" data-state="'.$this->stateInitial($results['data'][$index]['AppProcess']).'">1</div></a>'.
					'</div>':"",
					"VerifyProcess"		=> !empty($results['data'][$index]['VerifyProcess']) ?
					'<div class="app-state">'.
					'<a target="_blank" href="'.$this->createlink($results['data'][$index]['VerifyProcess']).'?'.$this->urlInitial($results['data'][$index]['VerifyProcess']).'&d='.date('dmH:i').'&cache=false&secure='.md5(true).'&rel='.$results['data'][$index]['DocID'].'&req=P2&live='.$this->liveInitial($results['data'][$index]['VerifyProcess']).'&t='.date('s').'"><div '.$this->notify($results['data'][$index]['VerifyProcess']).' class="'.$this->processstate($results['data'][$index]['VerifyProcess']).'" data-state="'.$this->stateInitial($results['data'][$index]['VerifyProcess']).'">2</div></a>'.
					'</div>':"",
					"AStateProcess"		=> !empty($results['data'][$index]['AStateProcess']) ?
					'<div class="app-state">'.
					'<a target="_blank" href="'.$this->createlink($results['data'][$index]['AStateProcess']).'?'.$this->urlInitial($results['data'][$index]['AStateProcess']).'&d='.date('dmH:i').'&cache=false&secure='.md5(true).'&rel='.$results['data'][$index]['DocID'].'&ddflag=N&req=P3&live='.$this->liveInitial($results['data'][$index]['AStateProcess']).'&t='.date('s').'"><div '.$this->notify($results['data'][$index]['AStateProcess']).' class="'.$this->processstate($results['data'][$index]['AStateProcess']).'" data-state="'.$this->stateInitial($results['data'][$index]['AStateProcess']).'">3</div></a>'.
					'</div>':"",
			);
	
		}


		$sOutput = array(
			'draw'                => intval($this->input->post('draw')) ? intval($this->input->post('draw')) : 0,
			'recordsTotal'        => $iTotal,
			'recordsFiltered'     => $iTotal,
			'data'                => $colums
		);

		echo json_encode($sOutput);
			
	}
	
	/** Implement New Functionality **/
	
	function createlink($status) {
		switch($status) {
			case "Y":
			case "N":
				return site_url('metro/routers');
				break;
			case "":
			case false:
			default:
				//return "#";
				return site_url('metro/routers');
				break;
		}
	}
	
	function processstate($status) {
		switch($status) {
			case "Y":
				return "app-stateno state_success";
				break;
			case "N":
				return "app-stateno state_start";
				break;
			case "":
			case null:
			default:
				return "app-stateno state_pending";
				break;
	
		}
	}
	
	public function notify($status) {
		switch($status) {
			case "Y":
				$notify = 'data-hint="Status|Progress Complete" data-hint-position="top"';
				return $notify;
				break;
			case "N":
				return 'data-hint="Status|Progress Start" data-hint-position="top"';
				break;
			case "":
			case null:
			default:
				return 'data-hint="Status|Progress Pending" data-hint-position="top"';
				break;
	
		}
	}
	
	public function stateInitial($status) {
	
		switch($status) {
			case "Y":
			case "N":
				return "1";
				break;
			case "":
			case null:
			default:
				return "0";
				break;
		}
	
	}
	
	public function urlInitial($status) {
	
		switch($status) {
			case "Y":
				return "mod=1";
				break;
			case "N":
				return "mod=2";
				break;
			case "":
			case null:
			default:
				return "mod=3";
				break;
		}
	
	}
	
	public function liveInitial($status) {
	
		if($status == 'Y') {
			return '1';
		} else {
			return '2';
		}
	
	}
	
	private function levelCustomer($level) {
		switch($level) {
			case 'H':
				return 'High';
				break;
			case 'M':
				return 'Medium';
				break;
			case 'L';
			return 'Low';
			break;
			case '':
			default:
				return '';
				break;
		}
	}
	
	private function loanGroupType($type) {
		if(empty($type)) {
			return '-';
		} else {
			
			switch($type) {
				case 'NN':
					return 'Nano Finance';
				break;
				case 'NF':
					return 'Micro Finance';
				break;
				case 'SB':
					return 'Small Business Loan';
				break;
			}
			
		}
		
	}
	
	
}