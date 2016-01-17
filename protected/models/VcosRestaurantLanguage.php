<?php

/**
 * This is the model class for table "vcos_restaurant_language".
 *
 * The followings are the available columns in table 'vcos_restaurant_language':
 * @property string $id
 * @property string $restaurant_id
 * @property string $iso
 * @property string $restaurant_name
 * @property string $restaurant_address
 * @property string $restaurant_feature
 * @property string $restaurant_describe
 * @property string $restaurant_opening_time
 */
class VcosRestaurantLanguage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosRestaurantLanguage the static model class
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
		return 'vcos_restaurant_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('restaurant_id, iso, restaurant_name, restaurant_address, restaurant_feature, restaurant_describe, restaurant_opening_time', 'required'),
			array('restaurant_id', 'length', 'max'=>10),
			array('iso', 'length', 'max'=>60),
			array('restaurant_name, restaurant_address, restaurant_feature, restaurant_opening_time', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, restaurant_id, iso, restaurant_name, restaurant_address, restaurant_feature, restaurant_describe, restaurant_opening_time', 'safe', 'on'=>'search'),
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
			'restaurant_id' => 'Restaurant',
			'iso' => 'Iso',
			'restaurant_name' => 'Restaurant Name',
			'restaurant_address' => 'Restaurant Address',
			'restaurant_feature' => 'Restaurant Feature',
			'restaurant_describe' => 'Restaurant Describe',
			'restaurant_opening_time' => 'Restaurant Opening Time',
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
		$criteria->compare('restaurant_id',$this->restaurant_id,true);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('restaurant_name',$this->restaurant_name,true);
		$criteria->compare('restaurant_address',$this->restaurant_address,true);
		$criteria->compare('restaurant_feature',$this->restaurant_feature,true);
		$criteria->compare('restaurant_describe',$this->restaurant_describe,true);
		$criteria->compare('restaurant_opening_time',$this->restaurant_opening_time,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}