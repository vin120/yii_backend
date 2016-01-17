<?php

/**
 * This is the model class for table "vcos_navigation".
 *
 * The followings are the available columns in table 'vcos_navigation':
 * @property string $navigation_id
 * @property string $navigation_name
 * @property integer $sort_order
 * @property integer $status
 * @property integer $navigation_style_type
 * @property integer $activity_id
 * @property integer $cruise_id
 * @property integer $is_show
 * @property integer $is_category
 * @property integer $is_main
 */
class VcosNavigation extends PrCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosNavigation the static model class
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
		return 'vcos_navigation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sort_order, status, navigation_style_type, activity_id, cruise_id, is_show, is_category, is_main', 'numerical', 'integerOnly'=>true),
			array('navigation_name', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('navigation_id, navigation_name, sort_order, status, navigation_style_type, activity_id, cruise_id, is_show, is_category, is_main', 'safe', 'on'=>'search'),
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
			'navigation_id' => 'Navigation',
			'navigation_name' => 'Navigation Name',
			'sort_order' => 'Sort Order',
			'status' => 'Status',
			'navigation_style_type' => 'Navigation Style Type',
			'activity_id' => 'Activity',
			'cruise_id' => 'Cruise',
			'is_show' => 'Is Show',
			'is_category' => 'Is Category',
			'is_main' => 'Is Main',
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

		$criteria->compare('navigation_id',$this->navigation_id,true);
		$criteria->compare('navigation_name',$this->navigation_name,true);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('status',$this->status);
		$criteria->compare('navigation_style_type',$this->navigation_style_type);
		$criteria->compare('activity_id',$this->activity_id);
		$criteria->compare('cruise_id',$this->cruise_id);
		$criteria->compare('is_show',$this->is_show);
		$criteria->compare('is_category',$this->is_category);
		$criteria->compare('is_main',$this->is_main);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}