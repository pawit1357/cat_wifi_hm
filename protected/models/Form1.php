<?php
class Form1 extends CActiveRecord {
	public $rev_id;
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'tb_form1';
	}
	public function relations() {
		return array (
				'rad_machine' => array (
						self::BELONGS_TO,
						'MRadMachine',
						'rad_machine_id' 
				),
				'code_usage' => array (
						self::BELONGS_TO,
						'MCodeUsage',
						'code_usage_id' 
				),
				'maufacturer' => array (
						self::BELONGS_TO,
						'Manufacturer',
						'maufacturer_id' 
				),
				'use_type' => array (
						self::BELONGS_TO,
						'MUseType',
						'use_type_id' 
				),
				'power_unit' => array (
						self::BELONGS_TO,
						'MPowerUnit',
						'power_unit_id' 
				),
				'dealer' => array (
						self::BELONGS_TO,
						'MDealer',
						'dealer_id' 
				),
				'usage_status' => array (
						self::BELONGS_TO,
						'MUsageStatus',
						'usage_status_id' 
				),
				'company' => array (
						self::BELONGS_TO,
						'MDealerCompany',
						'config_company_id' 
				),
				
				'room' => array (
						self::BELONGS_TO,
						'MRoom',
						'room_id' 
				),
				'supervisor' => array (
						self::BELONGS_TO,
						'UsersLogin',
						'supervisor_id' 
				) ,
				'updateby' => array (
						self::BELONGS_TO,
						'UsersLogin',
						'update_by'
				),
				'createby' => array (
						self::BELONGS_TO,
						'UsersLogin',
						'create_by'
				)
		);
	}
	public function rules() {
		return array (
				array (
						'id,
						refer_doc,
						rad_machine_id,
						name,
						code_usage_id,
						maufacturer_id,
						model,
						serial_number,
						use_type_id,
						power_unit_id,
						max_power,
						dealer_id,
						license_no,
						license_expire_date,
						supervisor_id,
						mobile_number,
						usage_status_id,
						room_id,
						setup_date,
						config_date,
						config_company_id,sci_config_date,
						check_date,create_by,create_date,update_by,update_date,revision,owner_department_id',
						'safe' 
				) 
		);
	}
	public function attributeLabels() {
		return array ();
	}
	public function getUrl($post = null) {
		if ($post === null)
			$post = $this->post;
		return $post->url . '#c' . $this->id;
	}
	protected function beforeSave() {
		return true;
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		switch (UserLoginUtils::getUserRoleName ()) {
			case UserLoginUtils::ADMIN :
			case UserLoginUtils::EXCUTIVE :
				if (isset ( $this->rev_id )) {
					$criteria->condition = " t.status='F' and t.update_from_id=" . $this->rev_id;
				} else {
					$criteria->condition = " t.status = 'T'";
				}
				break;
			case UserLoginUtils::STAFF :
			case UserLoginUtils::USER :
				if (isset ( $this->rev_id )) {
					$criteria->condition = " t.status='F' and t.update_from_id=" . $this->rev_id;
				} else {
					$criteria->condition = " t.owner_department_id = " . UserLoginUtils::getDepartmentId () . " and t.status ='T'";
				}
				break;
		}
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria,
				'sort' => array (
						'defaultOrder' => 't.id asc' 
				),
				'pagination' => array (
						'pageSize' => ConfigUtil::getDefaultPageSize () 
				) 
		) );
	}
}