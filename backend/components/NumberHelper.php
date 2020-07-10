<?php 
namespace backend\components;

use \Yii;

class NumberHelper{

	public function format($value,$size){
		return str_pad($value, $size, '0', STR_PAD_LEFT);
	}
}
?>