<?php

/**
 * This is the model class for table "vcos_wifi_buy".
 *
 * The followings are the available columns in table 'vcos_wifi_buy':
 * @property string $wifi_id
 * @property string $wifi_name
 * @property string $wifi_use_time
 * @property string $wifi_buy_time
 * @property string $wifi_price
 * @property integer $wifi_state
 */
class VcosWifiBuy extends CActiveRecord
{
    public $dbname='db';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vcos_wifi_buy';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wifi_name, wifi_use_time, wifi_buy_time, wifi_price, wifi_state', 'required'),
			array('wifi_state', 'numerical', 'integerOnly'=>true),
			array('wifi_name, wifi_use_time, wifi_buy_time, wifi_price', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('wifi_id, wifi_name, wifi_use_time, wifi_buy_time, wifi_price, wifi_state', 'safe', 'on'=>'search'),
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
			'wifi_name' => 'Wifi Name',
			'wifi_use_time' => 'Wifi Use Time',
			'wifi_buy_time' => 'Wifi Buy Time',
			'wifi_price' => 'Wifi Price',
			'wifi_state' => 'Wifi State',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('wifi_id',$this->wifi_id,true);
		$criteria->compare('wifi_name',$this->wifi_name,true);
		$criteria->compare('wifi_use_time',$this->wifi_use_time,true);
		$criteria->compare('wifi_buy_time',$this->wifi_buy_time,true);
		$criteria->compare('wifi_price',$this->wifi_price,true);
		$criteria->compare('wifi_state',$this->wifi_state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VcosWifiBuy the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
