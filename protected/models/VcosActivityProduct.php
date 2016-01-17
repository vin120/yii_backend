<?php

/**
 * This is the model class for table "vcos_activity_product".
 *
 * The followings are the available columns in table 'vcos_activity_product':
 * @property integer $id
 * @property string $activity_id
 * @property integer $product_id
 * @property integer $activity_cid
 * @property integer $sort_order
 * @property string $start_show_time
 * @property string $end_show_time
 * @property integer $product_type
 */
class VcosActivityProduct extends PrCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosActivityProduct the static model class
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
		return 'vcos_activity_product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('activity_id, sort_order, product_type', 'required'),
			array('product_id, activity_cid, sort_order, product_type', 'numerical', 'integerOnly'=>true),
			array('activity_id', 'length', 'max'=>10),
			array('start_show_time, end_show_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, activity_id, product_id, activity_cid, sort_order, start_show_time, end_show_time, product_type', 'safe', 'on'=>'search'),
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
			'activity_id' => 'Activity',
			'product_id' => 'Product',
			'activity_cid' => 'Activity Cid',
			'sort_order' => 'Sort Order',
			'start_show_time' => 'Start Show Time',
			'end_show_time' => 'End Show Time',
			'product_type' => 'Product Type',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('activity_id',$this->activity_id,true);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('activity_cid',$this->activity_cid);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('start_show_time',$this->start_show_time,true);
		$criteria->compare('end_show_time',$this->end_show_time,true);
		$criteria->compare('product_type',$this->product_type);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}