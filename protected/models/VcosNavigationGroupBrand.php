<?php

/**
 * This is the model class for table "vcos_navigation_group_brand".
 *
 * The followings are the available columns in table 'vcos_navigation_group_brand':
 * @property string $navigation_group_bid
 * @property integer $navigation_group_id
 * @property integer $brand_id
 * @property integer $sort_order
 * @property integer $status
 */
class VcosNavigationGroupBrand extends PrCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosNavigationGroupBrand the static model class
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
		return 'vcos_navigation_group_brand';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('navigation_group_id, brand_id, sort_order, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('navigation_group_bid, navigation_group_id, brand_id, sort_order, status', 'safe', 'on'=>'search'),
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
			'navigation_group_bid' => 'Navigation Group Bid',
			'navigation_group_id' => 'Navigation Group',
			'brand_id' => 'Brand',
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

		$criteria->compare('navigation_group_bid',$this->navigation_group_bid,true);
		$criteria->compare('navigation_group_id',$this->navigation_group_id);
		$criteria->compare('brand_id',$this->brand_id);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}