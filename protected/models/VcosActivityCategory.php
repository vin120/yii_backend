<?php

/**
 * This is the model class for table "vcos_activity_category".
 *
 * The followings are the available columns in table 'vcos_activity_category':
 * @property integer $activity_cid
 * @property string $activity_id
 * @property string $activity_category_name
 * @property integer $sort_order
 * @property integer $status
 */
class VcosActivityCategory extends PrCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosActivityCategory the static model class
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
		return 'vcos_activity_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('activity_id', 'required'),
			array('sort_order, status', 'numerical', 'integerOnly'=>true),
			array('activity_id', 'length', 'max'=>10),
			array('activity_category_name', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('activity_cid, activity_id, activity_category_name, sort_order, status', 'safe', 'on'=>'search'),
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
			'activity_cid' => 'Activity Cid',
			'activity_id' => 'Activity',
			'activity_category_name' => 'Activity Category Name',
			'sort_order' => 'Sort Order',
			'status' => 'Status',
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

		$criteria->compare('activity_cid',$this->activity_cid);
		$criteria->compare('activity_id',$this->activity_id,true);
		$criteria->compare('activity_category_name',$this->activity_category_name,true);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}