<?php

/**
 * This is the model class for table "vcos_shop_brand".
 *
 * The followings are the available columns in table 'vcos_shop_brand':
 * @property string $shop_brand_id
 * @property string $shop_id
 * @property integer $brand_id
 * @property integer $sort_order
 */
class VcosShopBrand extends PrCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosShopBrand the static model class
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
		return 'vcos_shop_brand';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shop_id', 'required'),
			array('brand_id, sort_order', 'numerical', 'integerOnly'=>true),
			array('shop_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('shop_brand_id, shop_id, brand_id, sort_order', 'safe', 'on'=>'search'),
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
			'shop_brand_id' => 'Shop Brand',
			'shop_id' => 'Shop',
			'brand_id' => 'Brand',
			'sort_order' => 'Sort Order',
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

		$criteria->compare('shop_brand_id',$this->shop_brand_id,true);
		$criteria->compare('shop_id',$this->shop_id,true);
		$criteria->compare('brand_id',$this->brand_id);
		$criteria->compare('sort_order',$this->sort_order);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}