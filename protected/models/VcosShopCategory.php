<?php

/**
 * This is the model class for table "vcos_shop_category".
 *
 * The followings are the available columns in table 'vcos_shop_category':
 * @property string $shop_cid
 * @property string $shop_id
 * @property integer $category_code
 * @property integer $type
 * @property integer $sort_order
 */
class VcosShopCategory extends PrCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosShopCategory the static model class
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
		return 'vcos_shop_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shop_id, category_code', 'required'),
			array('category_code, type, sort_order', 'numerical', 'integerOnly'=>true),
			array('shop_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('shop_cid, shop_id, category_code, type, sort_order', 'safe', 'on'=>'search'),
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
			'shop_cid' => 'Shop Cid',
			'shop_id' => 'Shop',
			'category_code' => 'Category Code',
			'type' => 'Type',
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

		$criteria->compare('shop_cid',$this->shop_cid,true);
		$criteria->compare('shop_id',$this->shop_id,true);
		$criteria->compare('category_code',$this->category_code);
		$criteria->compare('type',$this->type);
		$criteria->compare('sort_order',$this->sort_order);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}