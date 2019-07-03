<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dbapp extends CI_model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database('dbapp');
		
	}
	
	public function getDataConsent($doc_id) {
		$this->load->model('dbstore');
		
		if(empty($doc_id)) :
			return array("data"  => '', "status" => false, "msg" => '');
			
		else:
			
			try {						
							
				$result = $this->dbstore->exec_pcisGetNCBConsentDataList($doc_id);
				return $result;
				
			} catch (Exception $e) {
				
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
					
			}
			
		endif;
		
		
	}
	
	public function getDataReconcileDoc($doc_id) {
		$this->load->model('dbstore');

		if(empty($doc_id)):
			return array("data" => '', "status" => false, "msg" => '');
			
		else:
		
			try {
			
				$result = $this->dbstore->exec_pcisGeReconcileDataList($doc_id);
				return $result;
				
			} catch (Exception $e) {
					
				echo 'Caught exception: '.$e->getMessage()."\n";
				echo 'Caught exception: '.$e->getLine()."\n";
				echo 'The Exception: '.$e->getTrace()."\n";
					
			}
		
		
		endif;
	}

	public function getSourceFieldList() {
		$this->load->model('dbstore');
		
		try {
			
			$result = $this->dbstore->exec_getSourceFieldList();
			return $result;
				
		} catch (Exception $e) {				
			echo 'Caught exception: '.$e->getMessage()."\n";
			echo 'Caught exception: '.$e->getLine()."\n";
			echo 'The Exception: '.$e->getTrace()."\n";
				
		}
		
		
		
		
	}
	
}