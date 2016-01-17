<?php

/**
 * This is the model class for table "vcos_service_time_language".
 *
 * The followings are the available columns in table 'vcos_service_time_language':
 * @property string $id
 * @property string $service_id
 * @property string $iso
 * @property string $service_department
 * @property string $service_address
 * @property string $service_opening_time
 */
class VcosServiceTimeLanguage extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosServiceTimeLanguage the static model class
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
		return 'vcos_service_time_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_id, iso, service_department, service_address, service_opening_time', 'required'),
			array('service_id', 'length', 'max'=>10),
			array('iso', 'length', 'max'=>60),
			array('service_department, service_address, service_opening_time', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, service_id, iso, service_department, service_address, service_opening_time', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'service_id' => 'Service',
			'iso' => 'Iso',
			'service_department' => 'Service Department',
			'service_address' => 'Service Address',
			'service_opening_time' => 'Service Opening Time',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('service_id',$this->service_id,true);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('service_department',$this->service_department,true);
		$criteria->compare('service_address',$this->service_address,true);
		$criteria->compare('service_opening_time',$this->service_opening_time,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}