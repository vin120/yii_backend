<?php

/**
 * This is the model class for table "vcos_wifi_config".
 *
 * The followings are the available columns in table 'vcos_wifi_config':
 * @property string $config_id
 * @property string $config_login_url
 * @property string $config_logout_url
 * @property string $config_change_url
 * @property string $config_notice
 * @property string $config_policy
 * @property string $config_ssid
 * @property string $config_acip
 * @property string $config_apmac
 * @property integer $config_state
 * @property string $config_describe
 */
class VcosWifiConfig extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosWifiConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vcos_wifi_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('config_login_url, config_logout_url, config_change_url, config_notice, config_policy, config_ssid, config_acip, config_apmac, config_describe', 'required'),
			array('config_state', 'numerical', 'integerOnly'=>true),
			array('config_login_url, config_logout_url, config_change_url, config_notice, config_policy, config_ssid, config_acip, config_apmac, config_describe', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('config_id, config_login_url, config_logout_url, config_change_url, config_notice, config_policy, config_ssid, config_acip, config_apmac, config_state, config_describe', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'config_id' => 'Config',
			'config_login_url' => 'Config Login Url',
			'config_logout_url' => 'Config Logout Url',
			'config_change_url' => 'Config Change Url',
			'config_notice' => 'Config Notice',
			'config_policy' => 'Config Policy',
			'config_ssid' => 'Config Ssid',
			'config_acip' => 'Config Acip',
			'config_apmac' => 'Config Apmac',
			'config_state' => 'Config State',
			'config_describe' => 'Config Describe',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('config_id',$this->config_id,true);
		$criteria->compare('config_login_url',$this->config_login_url,true);
		$criteria->compare('config_logout_url',$this->config_logout_url,true);
		$criteria->compare('config_change_url',$this->config_change_url,true);
		$criteria->compare('config_notice',$this->config_notice,true);
		$criteria->compare('config_policy',$this->config_policy,true);
		$criteria->compare('config_ssid',$this->config_ssid,true);
		$criteria->compare('config_acip',$this->config_acip,true);
		$criteria->compare('config_apmac',$this->config_apmac,true);
		$criteria->compare('config_state',$this->config_state);
		$criteria->compare('config_describe',$this->config_describe,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}