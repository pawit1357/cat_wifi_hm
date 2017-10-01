<?php
class UserLoginUtils {
	
	const ADMIN = "ADMIN";
	const STAFF = "STAFF";
	const USER = "USER";
	const EXCUTIVE = "EXCUTIVE";
	
// 	private static $userPermissions = array ();
// 	public static function hasPermission($permissionCodes) {
// 		$UsersLoginId = self::getUsersLoginId ();
// 		if ($UsersLoginId == null) {
// 			return false;
// 		}
		
// 		$currentTime = time ();
// 		// Cache timeout in 5 minites
// 		$cacheTimeout = (5 * 60 * 1000);
		
// 		if (self::$userPermissions ['latestUpdateTime'] < ($currentTime - $cacheTimeout)) {
// 			$UsersLogin = UsersLogin::model ()->with ( 'role' )->findByPk ( $UsersLoginId );
// 			$permissions = array ();
// 			if (isset ( $UsersLogin->role )) {
// 				$criteria = new CDbCriteria ();
// 				$criteria->condition = "role_id = '" . $UsersLogin->role->id . "'";
// 				$rolePermissions = RolePermission::model ()->with ( 'permission' )->findAll ( $criteria );
// 				foreach ( $rolePermissions as $rolePermission ) {
// 					if (! in_array ( $rolePermission->permission_code, $permissions )) {
// 						$permissions [count ( $permissions )] = $rolePermission->permission_code;
// 					}
// 				}
// 			}
// 			self::$userPermissions ['permissions'] = $permissions;
// 			self::$userPermissions ['latestUpdateTime'] = $currentTime;
// 		}
// 		$permissions = self::$userPermissions ['permissions'];
// 		foreach ( $permissionCodes as $permissionCode ) {
// 			if (in_array ( $permissionCode, $permissions )) {
// 				return true;
// 				break;
// 			}
// 		}
// 		return false;
// 	}
	
	public static function isLogin() {
		return isset ( $_SESSION ['USER_LOGIN_ID'] );
	}
	
	public static function logout() {
		unset ( $_SESSION ['USER_LOGIN_ID'] );
		unset ( $_SESSION ['USER_APP_ID'] );
		unset ( $_SESSION ['USER_INFO'] );
		unset ( $_SESSION ['USER_ROLE'] );
		unset ( $_SESSION ['FAIL_MESSAGE'] );
// 		unset ( $_SESSION ['DEPARTMENT_ID'] );
		
	}
	public static function authen($username, $password) {
		$criteria = new CDbCriteria ();
		$criteria->condition = "username = '" . $username . "' and password='" . md5 ( $password ) . "' and status='A'";
		$UsersLogin = UsersLogin::model ()->findAll ( $criteria );
		if (isset ( $UsersLogin [0] )) {
			
			// $UsersLogin[0]->latest_login = date("Y-m-d H:i:s");
			// $UsersLogin[0]->update();
			$_SESSION ['USER_LOGIN_ID'] = $UsersLogin [0]->id;
			// $_SESSION['USER_APP_ID'] = $UsersLogin[0]->app_id;
			$_SESSION ['USER_ROLE'] = $UsersLogin [0]->role_id;
			$_SESSION ['USER_ROLE_NAME'] = $UsersLogin [0]->users_role->ROLE_NAME;
			
// 			$_SESSION ['DEPARTMENT_ID'] = $UsersLogin [0]->department_id;
			
			$_SESSION ['IS_FORCE_CHANGE_PASSWORD'] = ($UsersLogin [0]->is_force_change_password == "1" ? true : false);
			
			// $_SESSION['USER_INFO'] = $UsersLogin[0]->username.' Application('.$UsersLogin[0]->app_id.')';
			
			return true;
		} else {
			$_SESSION ['FAIL_MESSAGE'] = 'Incorrect Username or Password!';
			return false;
		}
	}
	public static function isForceChangePassword() {
		if (isset ( $_SESSION ['IS_FORCE_CHANGE_PASSWORD'] )) {
			return $_SESSION ['IS_FORCE_CHANGE_PASSWORD'];
		} else {
			return false;
		}
	}
	public static function getUserAppId() {
		if (isset ( $_SESSION ['USER_APP_ID'] )) {
			return $_SESSION ['USER_APP_ID'];
		} else {
			return - 1;
		}
	}
	public static function getUserRole() {
		if (isset ( $_SESSION ['USER_ROLE'] )) {
			return $_SESSION ['USER_ROLE'];
		} else {
			return - 1;
		}
	}
	public static function getUsersLoginId() {
		if (isset ( $_SESSION ['USER_LOGIN_ID'] )) {
			return $_SESSION ['USER_LOGIN_ID'];
		} else {
			return - 1;
		}
	}
	public static function getUserInfo() {
		if (isset ( $_SESSION ['USER_INFO'] )) {
			return $_SESSION ['USER_INFO'];
		} else {
			return null;
		}
	}
// 	public static function getDepartmentId() {
		
// // 		if (self::isLogin ()) {
// // 			
// // 			$UsersLogin = UsersLogin::model ()->findByPk ( self::getUsersLoginId () );
// // 			return $UsersLogin->department->id;
// // 		}else{
// // 			return -1;
// // 		}
		
		
// 		if (isset ( $_SESSION ['DEPARTMENT_ID'] )) {
// // 			echo $_SESSION ['DEPARTMENT_ID'].'xxx<br>';
// 			return $_SESSION ['DEPARTMENT_ID'];
// 		} else {
// 			return null;
// 		}
// 	}
	public static function getUserRoleName() {
		if (isset ( $_SESSION ['USER_ROLE_NAME'] )) {
			return $_SESSION ['USER_ROLE_NAME'];
		} else {
			return null;
		}
	}
	public static function getUsersLogin() {
		if (self::isLogin ()) {
			$UsersLogin = UsersLogin::model ()->findByPk ( self::getUsersLoginId () );
			return $UsersLogin;
		} else {
			return null;
		}
	}
	public static function getLoginInfo() {
		if (self::isLogin ()) {
			$UsersLogin = UsersLogin::model ()->findByPk ( self::getUsersLoginId () );
			
			return  "<i class=\"fa fa-user\"></i>" . $UsersLogin->first_name . "  " . $UsersLogin->last_name . " <i class=\"fa fa-key\"></i>(" . strtolower ( $UsersLogin->users_role->ROLE_NAME ) . ") ";
		} else {
			return '';
		}
	}
	public static function canCreate($cur_page) {
		if (! self::isLogin ()) {
			$this->redirect ( Yii::app ()->createUrl ( 'Site/login' ) );
		}
		$result = false;
		$cri = new CDbCriteria ();
		$currentPage = str_replace ( ConfigUtil::getAppName (), "", $cur_page );
		$link = explode ( "/", $currentPage );
		
		$cri->condition = "URL_NAVIGATE = '/" . $link [1] . '/' . $link [2] . "'";
		
// 		echo "<font color='red'>".$link [1] . '/' . $link [2]."</font>";
		
		$menus = Menu::model ()->findAll ( $cri );
		if (isset ( $menus [0] )) {
					
			$cri1 = new CDbCriteria ();
			$cri1->condition = " MENU_ID = " . $menus [0]->MENU_ID . " AND ROLE_ID=" . self::getUserRole ();
			$menuRoles = MenuRole::model ()->findAll ( $cri1 );
			if (isset ( $menuRoles )) {
		
				$result = $menuRoles [0]->IS_CREATE;
			}
		}

		return $result;
	}
	public static function canUpdate($cur_page) {
		if (! self::isLogin ()) {
			$this->redirect ( Yii::app ()->createUrl ( 'Site/login' ) );
		}
		
		$result = false;
		$cri = new CDbCriteria ();
		$currentPage = str_replace ( ConfigUtil::getAppName (), "", $cur_page );
		$link = explode ( "/", $currentPage );
				
		$cri->condition = "URL_NAVIGATE = '/" . $link [1] . '/' . $link [2] . "'";
		
		$menus = Menu::model ()->findAll ( $cri );
		if (isset ( $menus [0] )) {
		
			$cri1 = new CDbCriteria ();
			$cri1->condition = " MENU_ID = " . $menus [0]->MENU_ID . " AND ROLE_ID=" . self::getUserRole ();
			$menuRoles = MenuRole::model ()->findAll ( $cri1 );
			if (isset ( $menuRoles )) {
				
				$result = $menuRoles [0]->IS_EDIT;
			}
		}
		
		return $result;
	}
	public static function canDelete($cur_page) {
		if (! self::isLogin ()) {
			$this->redirect ( Yii::app ()->createUrl ( 'Site/login' ) );
		}
		$result = false;
		$cri = new CDbCriteria ();
		$currentPage = str_replace ( ConfigUtil::getAppName (), "", $cur_page );
		$link = explode ( "/", $currentPage );
		
		$cri->condition = "URL_NAVIGATE = '/" . $link [1] . '/' . $link [2] . "'";
		
		$menus = Menu::model ()->findAll ( $cri );
		if (isset ( $menus [0] )) {
		
			$cri1 = new CDbCriteria ();
			$cri1->condition = " MENU_ID = " . $menus [0]->MENU_ID . " AND ROLE_ID=" . self::getUserRole ();
			$menuRoles = MenuRole::model ()->findAll ( $cri1 );
			if (isset ( $menuRoles )) {
		
				$result = $menuRoles [0]->IS_DELETE;
			}
		}

		return $result;
	}
	public static function getUsersLoginById($user_id) {
		$UsersLogin = UsersLogin::model ()->findByPk ( $user_id );
		return $UsersLogin;
	}
	public static function authorizePage($cur_page) {
		if (! self::isLogin ()) {
			$this->redirect ( Yii::app ()->createUrl ( 'Site/login' ) );
		}
		$cur_page = str_replace ( ConfigUtil::getAppName (), "", $cur_page );
		$link = explode ( "/", $cur_page );
		
		// echo "<font color='red'>" . $cur_page . "</font>";
		
		$cri = new CDbCriteria ();
		$cri->condition = "URL_NAVIGATE = '/" . $link [1] . '/' . $link [2] . "'";
		
		$menus = Menu::model ()->findAll ( $cri );
		if (isset ( $menus [0] )) {
			
			$cri1 = new CDbCriteria ();
			$cri1->condition = " MENU_ID = " . $menus [0]->MENU_ID . " AND ROLE_ID=" . self::getUserRole () . " AND IS_ACTIVE=1";
			$menuRoles = MenuRole::model ()->findAll ( $cri1 );
			if (isset ( $menuRoles [0] )) {
				return $menuRoles [0]->IS_ACTIVE;
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
}
?>