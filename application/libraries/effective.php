<?php
/**
 * Created by PhpStorm.
 * User: Natthapongnar
 * Date: 5/20/14
 * Time: 2:58 PM
 */


class Effective {

    public function StandartDateSorter($date) {
        if($date == "") {
            return null;

        } else {

            $spl = explode("/", $date);

            if($spl[2] != '0000') {

                $year = (int)$spl[2];
                if($year > 2400) {
                    $y = ((int)$spl[2] - 543);
                } else {
                    $y = ((int)$spl[2]);
                }
                $m = $spl[1];
                $d = $spl[0];

                return "$y-$m-$d";

            } else {
                return NULL;
            }


        }

    }
    
    public function StandartDateTime($date) {    	
    	if($date == "" || empty($date)) {
    		return null;
    
    	} else {
    
    		$spl = explode("/", $date);
    
    		if($spl[2] != '0000') {
    
    			$year = (int)$spl[2];
    			if($year > 2400) {
    				$y = ((int)$spl[2] - 543);
    			} else {
    				$y = ((int)$spl[2]);
    			}
    			$m = $spl[1];
    			$d = $spl[0];
    
    			return "$y-$m-$d " . date('H:i:s');
    
    		} else {
    			return NULL;
    		}
  
    	}
    	
    }

    public function StandartDateRollback($date) {
        if($date == "") {
            return "";

        } else {

            $spl = explode("-", $date);

            $y = $spl[0];
            $m = $spl[1];
            $d = $spl[2];

            return "$d/$m/$y";

        }

    }

    public function ThStadartDate($date) {
        if($date === "0000-00-00") {
            return "";
            
        } else {
            $spl = explode("-", $date);

            $year = $spl[0];
            $m = $spl[1];
            $d = $spl[2];
            if($year < 2200)  $y = (int)$spl[0] + 543;

            return "$d/$m/$y";
        }

    }
    
    public function unlessformat($date) {
    	if($date == "") {
    		return "";
    
    	} else {
    
    		$spl = explode("-", $date);
    
    		$y = $spl[0];
    		$m = $spl[1];
    		$d = $spl[2];
    
    		return "$d$m$y";
    
    	}
    
    }
    
    public function str_replace_assoc(array $replace, $subject) {
    	return str_replace(array_keys($replace), array_values($replace), $subject);
    }

    public function compare_date($array) {
    
    	if(!is_array($array)) { return;}
    
    	if((!array_key_exists('begin', $array)) || empty($array['begin'])){ return;}
    	if((!array_key_exists('end', $array)) || empty($array['end'])){ return; }
    
    	$begin_time  = strtotime( $array['begin'] );
    	$end_time 	 = strtotime( $array['end'] );
    
    	$amount_time = $end_time - $begin_time ;
    
    	$list = array('day' => array('', '86400'));
    
    	foreach($list as $value):
    
    	$result = round($amount_time / $value[1]);
    	$join   = explode(" ", $result);
    
    	endforeach;
    
    	return implode('', $join);

    }
    
    public function compare_checkdate($date1, $date2) {
    	
    	$arrDate1 = !empty($date1) ? explode("-", $date1):null;
    	$arrDate2 = !empty($date2) ? explode("-", $date2):null;
    	    
    	if(!empty($arrDate1[0]) && !empty($arrDate2[0])):
    		$timStmp1 = mktime(0, 0, 0, $arrDate1[1], $arrDate1[2], $arrDate1[0]);
    		$timStmp2 = mktime(0, 0, 0, $arrDate2[1], $arrDate2[2], $arrDate2[0]);
    	else:
    		$timStmp1 = 0;
    		$timStmp2 = 0;
    	endif;
    	
    	if ($timStmp1 >= $timStmp2) {
    		return 'TRUE';
    	} else {
    		return 'FALSE';
    	}
    }
    
    
    public function timespan($seconds = 1, $time = '') {
        $timestemps = strtotime('0000-00-00');
        if(empty($time) || $time == $timestemps) {
            $time = date('Y-m-d');
        }

        if ( ! is_numeric($seconds)) {
            $seconds = 1;
        }

        if ( ! is_numeric($time)) {
            $time = time();
        }

        if ($time <= $seconds) {
            $seconds = 1;
        }
        else{
            $seconds = $time - $seconds;
        }

        $str = '';
        $years = floor($seconds / 31536000);

        if ($years > 0) {
            $str .= $years.' ปี, ';
        }

        $seconds -= $years * 31536000;
        $months = floor($seconds / 2628000);

        if ($years > 0 OR $months > 0) {
            if ($months > 0)
            {
                $str .= $months.' เดือน, ';
            }

            $seconds -= $months * 2628000;
        }

        $weeks = floor($seconds / 604800);

        if ($years > 0 OR $months > 0 OR $weeks > 0) {
            if ($weeks > 0) {
                $str .= $weeks.' สัปดาห์, ';
            }

            $seconds -= $weeks * 604800;
        }

        $days = floor($seconds / 86400);

        if ($months > 0 OR $weeks > 0 OR $days > 0) {
            if ($days > 0)
            {
                $str .= $days.' วัน, ';
            }

            $seconds -= $days * 86400;
        }

        return substr(trim($str), 0, -1);
    }
    
    public function period($start_work, $status) {

    	if(empty($start_work)) {
    		return '0.0.0';
    		
    	} else {
    		
    		switch($status) {
    			case 'Active_DD':
    			case 'Active':    
    			case 'New':
    			case 'Pending':
    			case 'Inactive':
    				$today = date("Y-m-d");
    				break;
    			default:
    				$today = $start_work;
    				break;
    		}    		
    		
    		list($work_year, $work_month, $work_day) = explode("-", $start_work);
    		list($year, $month, $day) = explode("-", $today); 
    		
    		$mbirthday = mktime(0, 0, 0, $work_month, $work_day, $work_year);
    		$mnow = mktime(0, 0, 0, $month, $day, $year);
    		$mage = ($mnow - $mbirthday);
    			
    		$u_y = date("Y", $mage)-1970;
    		$u_m = date("m", $mage)-1;
    		$u_d = date("d", $mage)-1;
    		
    		return $u_y.'.'.$u_m.'.'.$u_d;
    	}
		
    }
    
    function get_chartypes($chart_str, $str) {
    	if($chart_str == false):
    		return $str;
    	else:
    		return @iconv('TIS-620', 'UTF-8', $str);
    	endif;
    	
    }
    
    function set_chartypes($chart_str, $str) {
    	if($chart_str == false):
    		return $str;
    	else:
    		return @iconv('UTF-8', 'TIS-620', $str);
    	endif;
    	 
    }
    
    function set_chartype_ignore($chart_str, $str) {
    	if($chart_str == false):
    	return $str;
    	else:
    	return @iconv('UTF-8', 'TIS-620//ignore', $str);
    	endif;
    
    }
    
    function date_in_period($format, $start, $end, $skip = NULL){
    	$output = array();
    	$days = floor((strtotime($end) - strtotime($start))/86400);
    	for($i=0;$i<=$days;$i++){
    		$in_period = strtotime("+" . $i . " day", strtotime($start));
    		if(is_array($skip) and in_array(date("D",$in_period), $skip)){
    			continue;
    		}
    		array_push($output, date($format, $in_period));
    	}
    	return $output;
    }

} 