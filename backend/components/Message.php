<?php 
namespace backend\components;

use \Yii;

class Message{
	const MESSAGE_NAME = "message";

	public function setError($message){
		Yii::$app->session->setFlash(self::MESSAGE_NAME, self::errorMessage($message));
	}

	public function setSuccess($message){
        Yii::$app->session->setFlash(self::MESSAGE_NAME, self::successMessage($message));
	}

	public function setInfo($message){
        Yii::$app->session->setFlash(self::MESSAGE_NAME, self::infoMessage($message));
	}

	public function setWarning($message){
        Yii::$app->session->setFlash(self::MESSAGE_NAME, self::warningMessage($message));
	}

	public function errorMessage($message){
		return '<div class="alert alert-danger">'.$message.'</div>';
	}
	public function infoMessage($message){
		return '<div class="alert alert-info">'.$message.'</div>';
	}
	public function successMessage($message){
		return '<div class="alert alert-success">'.$message.'</div>';
	}
	public function warningMessage($message){
		return '<div class="alert alert-warning">'.$message.'</div>';
	}

	public function getMessage(){
		if(\Yii::$app->session->hasFlash(self::MESSAGE_NAME))
           return \Yii::$app->session->getFlash(self::MESSAGE_NAME);
       return null;
	}

	public function printMessage(){
		$msg = $this->getMessage();
		if(!empty($msg)){
			\Yii::$app->session->setFlash(self::MESSAGE_NAME,null);
			echo $msg;
		}
	}
}
?>