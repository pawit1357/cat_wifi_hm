<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class AdHistoryController extends CController {
	public $layout = '_main';
	private $_model;
	
	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex() {
		// Authen Login
		if (! UserLoginUtils::isLogin ()) {
		$this->redirect ( Yii::app ()->createUrl ( 'Site/login' ) );
		}
		$model = new AdLogs ();
		$this->render ( 'main', array (
				'data' => $model 
		) );
	}
	
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] )) {
				$id = addslashes ( $_GET ['id'] );
				$this->_model = AdLogs::model ()->findbyPk ( $id );
			}
			if ($this->_model === null)
				throw new CHttpException ( 404, 'The requested page does not exist.' );
		}
		return $this->_model;
	}
	
	
}