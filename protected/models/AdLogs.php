<?php

class AdLogs extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tb_ad_logs';
	}

	public function relations()
	{
		return array(
				'ad_plan' => array(self::BELONGS_TO, 'AdPlan', 'plan_id'),
				
		);
	}

	public function rules() {
		return array(
				array(
						'id',
						'plan_id',
						'play_from_mac',
						'hotspot_name',
						 'safe'),
		);
	}

	public function attributeLabels()
	{
		return array(
				
		);
	}

	public function getUrl($post=null)
	{
		if($post===null)
			$post=$this->post;
		return $post->url.'#c'.$this->id;
	}

	protected function beforeSave()
	{
		return true;
	}

	public function search()
	{
		$criteria = new CDbCriteria;
		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
				'sort' => array(
						'defaultOrder' => 't.id asc',
				),
				'pagination' => array(
						'pageSize' => ConfigUtil::getDefaultPageSize()
				),
		));
	}
}