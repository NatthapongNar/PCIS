<?
class Logger {   

	protected $debug_path;
	protected $error_path;
	
	public function __construct() {
		$this->debug_path  = "/mobiledev-cache/logs/debug_".date("Y-m-d");
		$this->error_path  = "/mobiledev-cache/logs/debug_".date("Y-m-d");
	}
	
    public function debug($detail, $FunctionName){
    	$log_content =  " DEBUG[".$detail."]";
    	
    	$log_content = date("Y-m-d H:i:s") ." " .str_replace(base_url().'index.php/',"",current_url()).$log_content." in ".$FunctionName."\r\n";
		$f = fopen($this->debug_path, 'a+') or die("can't open file ".$this->debug_path);
		if (fwrite($f, $log_content) == FALSE) {
			echo "Cannot write to file ($filepath)";
       		exit;
		}
   		fclose($f);
    }
    
    public function error($detail,$FunctionName){
    	$log_content =  " ERROR[".$detail."]";
   
    	$log_content = date("Y-m-d H:i:s") ." " .str_replace(base_url().'index.php/',"",current_url()).$log_content." in ".$FunctionName."\r\n";
		$f = fopen($this->error_path, 'a+') or die("can't open file ".$this->error_path);
		if (fwrite($f, $log_content) == FALSE) {
			echo "Cannot write to file ($filepath)";
       		exit;
		}
   		fclose($f);
    }
	
}
?>