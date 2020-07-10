<?php 
namespace backend\components;

use \Yii;

class DateTimeHelper{

	const MILLIS_HR = 2.7777777777778E-7;
	const MILLIS_MINUTES = 1.6666666666667E-5;
	const MILLIS_SECOND = 0.001;

	public function toDateHr($datetime){
		$date = new \DateTime($datetime);
        return $date->format('Y-m-d H:i:s');
	}

	public function toDate($datetime){
		$date = new \DateTime($datetime);
        return $date->format('Y-m-d');
	}

	public function dateToDay($datetime){
		return date("d",strtotime($datetime));
	}

	public function dateToDayDesc($datetime){
		return date("D",strtotime($datetime));
	}

	public function dateToMonthDesc($datetime){
		return date("M",strtotime($datetime));
	}

	public function dateToMonth($datetime){
		return date("m",strtotime($datetime));
	}

	public function dateToYear($datetime){
		return date("Y",strtotime($datetime));
	}

	public function toISODateMin($datetime){
		try{
			$date = new \DateTime($datetime);
	        return $date->format("Y-m-d").'T00:00:00.00%2B0000';
	    }catch(\Exception $e){
	    	return '';
	    }
	}

	public function toISODateMax($datetime){
		try{
			$date = new \DateTime($datetime);
        	return $date->format("Y-m-d").'T23:59:59.59%2B0000';
	    }catch(\Exception $e){
	    	return '';
	    }
	}

	public function millisToMinutesOrHr($millis){
		if($millis >= 3600000){
			return $this->millisToHr($millis).'hr';
		}elseif($millis >= 60000 && $millis < 3600000)
			return $this->millisToMinutes($millis).'min';
		else
			return $this->millisToSecond($millis).'s';
	}

	public function millisToHr($millis){
		return round($millis * self::MILLIS_HR);
	}

	public function millisToMinutes($millis){
		return round($millis * self::MILLIS_MINUTES,2);
	}

	public function millisToSecond($millis){
		return round($millis * self::MILLIS_SECOND);
	}

	public function diffTime($startTime,$endTime){
		$startTime = 1000 * strtotime($startTime);
        $endTime = 1000 * strtotime($endTime);
        return $this->millisToMinutesOrHr($endTime-$startTime);
	}
}
?>