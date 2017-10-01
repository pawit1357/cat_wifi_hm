<?php
class MenuUtil {
	public static function getMenuByRole($currentPage) {
		if (! UserLoginUtils::isLogin ()) {
			$this->redirect ( Yii::app ()->createUrl ( 'Site/login' ) );
		}
	
		$currentPage = str_replace ( ConfigUtil::getAppName (), "", $currentPage );
// 		echo "<font color='red'>" . $currentPage . "</font>";
		$listOfMenuInRole = '';
		// Get Current User role
		$cri = new CDbCriteria ();
		$cri->condition = " ROLE_ID=" . UserLoginUtils::getUserRole () . " AND IS_ACTIVE='1'";
		
		$mroles = MenuRole::model ()->findAll ( $cri );
		if (isset ( $mroles )) {
			foreach ( $mroles as $mr ) {
				$listOfMenuInRole .= $mr->MENU_ID . ',';
			}
			if (strlen ( $listOfMenuInRole ) > 0) {
				$navMenu = "";
				$criMP = new CDbCriteria ();
				$criMP->condition = " PREVIOUS_MENU_ID=-1 AND MENU_ID in (" . rtrim ( $listOfMenuInRole, ',' ) . ")";
				
				$Menus = Menu::model ()->findAll ( $criMP );
				if (isset ( $Menus )) {
					foreach ( $Menus as $parent ) {
						
						$criCh = new CDbCriteria ( array (
								'condition' => " PREVIOUS_MENU_ID = '" . $parent->MENU_ID . "' AND MENU_ID in (" . rtrim ( $listOfMenuInRole, ',' ) . ")",
								'order' => 'DISPLAY_ORDER ASC' 
						) );
						
						$MenusChilds = Menu::model ()->findAll ( $criCh );
						
						$bActiveSelectedMenu = false;
						
						if (isset ( $MenusChilds )) {
							foreach ( $MenusChilds as $child ) {
								
								// echo "<font color='red'>" . ($currentPage . "==" . $child->URL_NAVIGATE) . "</font>";
								
								if ($child->URL_NAVIGATE == "#") {
									$criCh1 = new CDbCriteria ( array (
											'condition' => " PREVIOUS_MENU_ID = '" . $child->MENU_ID . "' AND MENU_ID in (" . rtrim ( $listOfMenuInRole, ',' ) . ")",
											'order' => 'DISPLAY_ORDER ASC' 
									) );
									$MenusChilds1 = Menu::model ()->findAll ( $criCh1 );
									if (isset ( $MenusChilds1 )) {
										
										foreach ( $MenusChilds1 as $child ) {
											if (0 === strpos ( $currentPage, $child->URL_NAVIGATE )) {
												$bActiveSelectedMenu = true;
												// echo "<font color='green'>Match!</font>";
												break;
											}
										}
									}
								}
								
								if (0 === strpos ( $currentPage, $child->URL_NAVIGATE )) {
									$bActiveSelectedMenu = true;
									// echo "<font color='green'>Match!</font>";
									
									break;
								}
								
								// echo "<br>";
							}
						}
						
						/* - BEGIN ADD MAIN MENU - */
						$navMenu = $navMenu . "<li class=\"nav-item " . ($bActiveSelectedMenu == true ? "start active open" : "") . "  \">";
						$navMenu = $navMenu . "<a href=\"javascript:;\" class=\"nav-link nav-toggle\">";
						$navMenu = $navMenu . "<i class=\"" . $parent->MENU_ICON . "\"></i>";
						$navMenu = $navMenu . "<span class=\"title\">" . $parent->MENU_NAME . "</span>";
						$navMenu = $navMenu . "<span class=\"arrow\"></span>";
						$navMenu = $navMenu . "</a>";
						/* - BEGIN ADD SUBMENU - */
						$navMenu = $navMenu . "<ul class=\"sub-menu\">";
						if (isset ( $MenusChilds )) {
							
							foreach ( $MenusChilds as $child ) {
								
								// ---- end sub menu ----
								$isActive = false;
								if (0 === strpos ( $currentPage, $child->URL_NAVIGATE )) {
									$isActive = true;
								}
								
								$navMenu = $navMenu . "<li class=\"nav-item " . ($isActive == true ? "start active open" : "") . " \">";
								$navMenu = $navMenu . "<a href=\"" . ($child->URL_NAVIGATE == "#" ? "javascript:;" : ConfigUtil::getAppName () . $child->URL_NAVIGATE) . "\" class=\"nav-link " . ($child->URL_NAVIGATE == "#" ? "nav-toggle" : "") . "\">";
								$navMenu = $navMenu . "<i class=\"" . $child->MENU_ICON . "\"></i>";
								
								$navMenu = $navMenu . "<span class=\"title\">" . $child->MENU_NAME . "</span>";
								$navMenu = $navMenu . "" . ($isActive == true ? '<span class=\" selected\"></span>' : '');
								// $navMenu = $navMenu . "" . ($isActive == true ? '<span class=\"arrow open\"></span>' : '');
								if ($child->URL_NAVIGATE == "#") {
									
									$navMenu = $navMenu . "<span class=\"arrow open\"></span>";
								}
								$navMenu = $navMenu . "</a>";
								
								if ($child->URL_NAVIGATE == "#") {
									// echo "<font color='red'>" . $currentPage . "," . $child->URL_NAVIGATE . "</font>";
									
									$criCh1 = new CDbCriteria ( array (
											'condition' => " PREVIOUS_MENU_ID = '" . $child->MENU_ID . "' AND MENU_ID in (" . rtrim ( $listOfMenuInRole, ',' ) . ")",
											'order' => 'DISPLAY_ORDER ASC' 
									) );
									
									$MenusChilds1 = Menu::model ()->findAll ( $criCh1 );
									
									$navMenu = $navMenu . "<ul class=\"sub-menu\">";
									if (isset ( $MenusChilds1 )) {
										
										foreach ( $MenusChilds1 as $child ) {
											$navMenu = $navMenu . "<li class=\"nav-item\" >";
											$navMenu = $navMenu . "<a href=\"" . (ConfigUtil::getAppName () . $child->URL_NAVIGATE) . "\" class=\"nav-link nav-toggle\"> ";
											$navMenu = $navMenu . "<span class=\"title\">" . $child->MENU_NAME . "</span>";
											// $navMenu = $navMenu . "" . ($isActive == true ? '<span class=\" selected\"></span>' : '') . "</a>";
											$navMenu = $navMenu . "</li>";
										}
									}
									$navMenu = $navMenu . "</ul>";
								}
								
								$navMenu = $navMenu . "</li>";
							}
							$navMenu = $navMenu . "</ul>";
							/* - END SUBMENU - */
							$navMenu = $navMenu . "</li>";
							/* - END MAIN MENU - */
						}
					}
				}
			} else {
			}
		}
		return $navMenu;
	}
	public static function getNavigator($currentPage) {
		
		// echo "<font color='red'>" . $currentPage . "</font>";
		if (strcmp ( $currentPage, "/" ) == 0) {
			header ( "Location: ".ConfigUtil::getSiteName());
			die ();
		}
		
		// if (! UserLoginUtils::isLogin ()) {
		// $this->redirect ( Yii::app ()->createUrl ( 'Site/login' ) );
		// }
		
		$currentPage = str_replace ( ConfigUtil::getAppName (), "", $currentPage );
		
		$link = explode ( "/", $currentPage );
		
		$_tmpPage = "";
		switch (count ( $link )) {
			case 3 :
				break;
			case 4 :
				$_tmpPage = "/" . $link [3];
				break;
			default :
				break;
		}
		
		$nav = "";
		
		$nav = $nav . "<li>";
		$nav = $nav . "<i class=\"fa fa-home\"></i>";
		$nav = $nav . "<a href=\"" . "#" . "\">Home</a>";
		$nav = $nav . "</li>";
		
		$criMenu = new CDbCriteria ();
		$criMenu->condition = "URL_NAVIGATE = '/" . $link [1] . "/" . $link [2] . ($link [2] == "Report" ? "/" . $link [3] : "") . "'";
		
		// echo "<font color='red'>/" . $link [1] . "/" . $link [2] . $_tmpPage .' ('.count($link).")". "</font>";
		
		$childs = Menu::model ()->findAll ( $criMenu );
		if (isset ( $childs )) {
			
			foreach ( $childs as $child ) {
				
				if (0 === strpos ( $currentPage, $child->URL_NAVIGATE )) {
					
					$criMenuParent = new CDbCriteria ();
					$criMenuParent->condition = "MENU_ID = " . $child->PREVIOUS_MENU_ID;
					
					$parent = Menu::model ()->findAll ( $criMenuParent );
					if (isset ( $parent [0] )) {
						$nav = $nav . "<li>";
						$nav = $nav . "<i class=\"fa fa-angle-right\"></i>";
						$nav = $nav . "<a href=\"" . (ConfigUtil::getAppName () . $child->URL_NAVIGATE) . "\">" . $parent [0]->MENU_NAME . "</a>";
						$nav = $nav . "</li>";
					}
					
					$nav = $nav . "<li>";
					$nav = $nav . "<i class=\"fa fa-angle-right\"></i>";
					$nav = $nav . "<a href=\"#\">" . $child->MENU_NAME . "</a>";
					$nav = $nav . "</li>";
				}
			}
		}
		
		return $nav;
	}
	public static function getMenuName($currentPage) {
		if (! UserLoginUtils::isLogin ()) {
			$this->redirect ( Yii::app ()->createUrl ( 'Site/login' ) );
		}
		$currentPage = str_replace ( ConfigUtil::getAppName (), "", $currentPage );
		$link = explode ( "/", $currentPage );
		
		// $_tmpPage = "";
		// switch (count ( $link )) {
		// case 3 :
		// break;
		// case 4 :
		// $_tmpPage = "/" . $link [3];
		// break;
		// default :
		// break;
		// }
		
		// echo "<font color='red'>" . "/" . $link [1] . "/" . $link [2] . $_tmpPage ."===>".count( $link ). "</font>";
		
		$menuName = "";
		
		$criMenu = new CDbCriteria ();
		$criMenu->condition = "URL_NAVIGATE = '/" . $link [1] . "/" . $link [2] . ($link [2] == "Report" ? "/" . $link [3] : "") . "'";
		
		$childs = Menu::model ()->findAll ( $criMenu );
		if (isset ( $childs )) {
			
			$menuName = "<i class=\"fa fa-database\"></i>" . $childs [0]->MENU_NAME;
			if (isset ( $link [3] )) {
				switch ($link [3]) {
					case "Create" :
						$menuName = "<i class=\"fa fa-plus\"></i>" . $childs [0]->MENU_NAME . " (เพิ่มข้อมูล)";
						break;
					case "Update" :
						$menuName = "<i class=\"fa fa-edit\"></i>" . $childs [0]->MENU_NAME . " (แก้ไขข้อมูล)";
						break;
					case "View" :
						$menuName = "<i class=\"fa fa-television\"></i>" . $childs [0]->MENU_NAME . " (ดูข้อมูลที่บันทึก)";
						break;
					// case "Report" :
					// $menuName = "<i class=\"fa fa-pie-chart\"></i> รายงาน" . $childs [0]->MENU_NAME;
					// break;
					case "Revision" :
						$menuName = "<i class=\"fa fa-clock-o\"></i>" . $childs [0]->MENU_NAME . " (ประวัติการแก้ไขข้อมูล)";
						;
						break;
				}
			}
			if (isset ( $link [2] )) {
				switch ($link [2]) {
					case "Report" :
						$menuName = "<i class=\"fa fa-pie-chart\"></i> รายงาน" . $childs [0]->MENU_NAME;
						break;
				}
			}
			
			// $menuName = $link [2] == "Report" ? "<i class=\"fa fa-pie-chart\"></i> รายงาน" . $childs [0]->MENU_NAME : (((basename ( $_tmpPage ) == "Create") ? "<i class=\"fa fa-plus\"></i>" : (basename ( $_tmpPage ) == "Update" ? "<i class=\"fa fa-edit\"></i>" : (basename ( $_tmpPage ) == "Revision" ? "<i class=\"fa fa-clock-o\"></i>" : ((basename ( $_tmpPage ) == "View" ? "<i class=\"fa fa-television\"></i>" : "<i class=\"fa fa-database\"></i>")))))) . $childs [0]->MENU_NAME . (basename ( $_tmpPage ) == "Revision" ? "(ประวัติการแก้ไข)" : (($_tmpPage == "View" ? "(ดูข้อมูลที่บันทึก)" : ""))) . ((basename ( $_tmpPage ) == "Create" ? "(เพิ่มข้อมูล)" : (basename ( $_tmpPage ) == "Update" ? "(แก้ไขข้อมูล)" : "")));
		}
		
		return $menuName;
	}
}