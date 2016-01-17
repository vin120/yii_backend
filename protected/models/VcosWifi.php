<?php

/**
 * This is the model class for table "vcos_wifi".
 *
 * The followings are the available columns in table 'vcos_wifi':
 * @property integer $wifi_id
 * @property integer $wifi_price
 * @property integer $wifi_time
 * @property integer $wifi_state
 */
class VcosWifi extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosWifi the static model class
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
		return 'vcos_wifi';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wifi_price, wifi_time, wifi_state', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('wifi_id, wifi_price, wifi_time, wifi_state', 'safe', 'on'=>'search'),
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
			'wifi_id' => 'Wifi',
			'wifi_price' => 'Wifi Price',
			'wifi_time' => 'Wifi Time',
			'wifi_state' => 'Wifi State',
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

		$criteria->compare('wifi_id',$this->wifi_id);
		$criteria->compare('wifi_price',$this->wifi_price);
		$criteria->compare('wifi_time',$this->wifi_time);
		$criteria->compare('wifi_state',$this->wifi_state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}