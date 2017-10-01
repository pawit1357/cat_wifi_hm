<?php
class AdController extends CController {
	public $layout = '_main';
	private $_model;
	public function actionIndex() {
		// Authen Login
		if (! UserLoginUtils::isLogin ()) {
		$this->redirect ( Yii::app ()->createUrl ( 'Site/login' ) );
		}
		$model = new AdPlan ();
		$this->render ( 'main', array (
				'data' => $model 
		) );
	}
	public function actionCreate() {
		// Authen Login
		if (! UserLoginUtils::isLogin ()) {
			$this->redirect ( Yii::app ()->createUrl ( 'Site/login' ) );
		}
		
		if (isset ( $_POST ['AdPlan'] )) {
			$transaction = Yii::app ()->db->beginTransaction ();
			// Add Request
			$adPlan = new AdPlan ();
			$adPlan->attributes = $_POST ['AdPlan'];
			$adPlan->start_date = CommonUtil::getDate ( $adPlan->start_date );
			$adPlan->end_date = CommonUtil::getDate ( $adPlan->end_date );
			
			$addSuccess = true;
			
			try {
				
				if ($_FILES ['fileUpload'] ['name']) {
					// if no errors...
					if (! $_FILES ['fileUpload'] ['error']) {
						$currentdir = getcwd ();
						
						$target = $currentdir . "/uploads/";
						$target = $target . basename ( $_FILES ['fileUpload'] ['name'] );
						$temploc = $_FILES ['uploadedfile'] ['tmp_name'];
						
						// This is our size condition
						if ($uploaded_size > 350000) {
							echo "Your file is too large.<br>";
						}
						// This is our limit file type condition
						if ($uploaded_type == "text/php") {
							echo "No PHP files<br>";
						} 						

						// Here we check that $ok was not set to 0 by an error
						// if ($ok == 0) {
						// Echo "Sorry your file was not uploaded";
						// }
						
						// If everything is ok we try to upload it
						else {
							if (move_uploaded_file ( $_FILES ['fileUpload'] ['tmp_name'], $target )) {
								$adPlan->file_path = '/uploads/' . $_FILES ['fileUpload'] ['name'];
								// echo "The file " . basename ( $_FILES ['room_plan'] ['name'] ) . " has been uploaded";
							} else {
								echo "Sorry, there was a problem uploading your file.";
							}
						}
					}
				}
				
				if (! $adPlan->save ()) {
					$addSuccess = false;
				}
				if ($addSuccess) {
					$transaction->commit ();
					$this->redirect ( Yii::app ()->createUrl ( 'Ad/' ) );
				} else {
					$transaction->rollback ();
					$this->render ( 'create' );
				}
			} catch ( CDbException $e ) {
				$this->redirect ( Yii::app ()->createUrl ( 'Error/503' ) );
			}
		} else {
			// Render
			$this->render ( 'create' );
		}
	}
	public function actionDelete() {
		$model = $this->loadModel ();
		$model->delete ();
		
		$this->redirect ( Yii::app ()->createUrl ( 'Ad/' ) );
	}
	public function actionUpdate() {
		// Permission
		$model = $this->loadModel ();
		if (isset ( $_POST ['AdPlan'] )) {
			$transaction = Yii::app ()->db->beginTransaction ();
			// Add Request
			$model->attributes = $_POST ['AdPlan'];
			$model->start_date = CommonUtil::getDate ( $model->start_date );
			$model->end_date = CommonUtil::getDate ( $model->end_date );
			$addSuccess = true;
			
			try {
				
				if ($_FILES ['fileUpload'] ['name']) {
					// if no errors...
					if (! $_FILES ['fileUpload'] ['error']) {
						$currentdir = getcwd ();
						
						$target = $currentdir . "/uploads/";
						$target = $target . basename ( $_FILES ['fileUpload'] ['name'] );
						$temploc = $_FILES ['uploadedfile'] ['tmp_name'];
						
						// This is our size condition
						if ($uploaded_size > 350000) {
							echo "Your file is too large.<br>";
						}
						// This is our limit file type condition
						if ($uploaded_type == "text/php") {
							echo "No PHP files<br>";
						} 						

						// Here we check that $ok was not set to 0 by an error
						// if ($ok == 0) {
						// Echo "Sorry your file was not uploaded";
						// }
						
						// If everything is ok we try to upload it
					else {
							if (move_uploaded_file ( $_FILES ['fileUpload'] ['tmp_name'], $target )) {
								$model->file_path = '/uploads/' . $_FILES ['fileUpload'] ['name'];
								// echo "The file " . basename ( $_FILES ['room_plan'] ['name'] ) . " has been uploaded";
							} else {
								echo "Sorry, there was a problem uploading your file.";
							}
						}
					}
				}
				
				if (! $model->update ()) {
					$addSuccess = false;
				}
				if ($addSuccess) {
					$transaction->commit ();
					$this->redirect ( Yii::app ()->createUrl ( 'Ad/' ) );
				} else {
					$transaction->rollback ();
					$this->render ( 'create' );
				}
			} catch ( CDbException $e ) {
				$this->redirect ( Yii::app ()->createUrl ( 'Error/503' ) );
			}
		}
		
		$this->render ( 'update', array (
				'model' => $model 
		) );
	}
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] )) {
				$id = addslashes ( $_GET ['id'] );
				$this->_model = AdPlan::model ()->findbyPk ( $id );
			}
			if ($this->_model === null)
				throw new CHttpException ( 404, 'The requested page does not exist.' );
		}
		return $this->_model;
	}
}