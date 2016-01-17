<?php

/**
 * This is the model class for table "vcos_product".
 *
 * The followings are the available columns in table 'vcos_product':
 * @property string $product_id
 * @property string $product_code
 * @property string $product_name
 * @property string $product_desc
 * @property string $product_img
 * @property integer $inventory_num
 * @property integer $sale_price
 * @property integer $standard_price
 * @property string $category_code
 * @property integer $cruise_id
 * @property integer $shop_id
 * @property integer $brand_id
 * @property integer $sale_num
 * @property integer $comment_num
 * @property string $sale_start_time
 * @property string $sale_end_time
 * @property integer $creator_type
 * @property string $created
 * @property string $creator
 * @property integer $creator_id
 * @property integer $status
 * @property string $origin
 */
class VcosProduct extends PrCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosProduct the static model class
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
		return 'vcos_product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('inventory_num, sale_price, standard_price, cruise_id, shop_id, brand_id, sale_num, comment_num, creator_type, creator_id, status', 'numerical', 'integerOnly'=>true),
			array('product_code', 'length', 'max'=>32),
			array('product_name, product_img', 'length', 'max'=>128),
			array('product_desc', 'length', 'max'=>255),
			array('category_code', 'length', 'max'=>12),
			array('creator', 'length', 'max'=>64),
			array('origin', 'length', 'max'=>100),
			array('sale_start_time, sale_end_time, created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('product_id, product_code, product_name, product_desc, product_img, inventory_num, sale_price, standard_price, category_code, cruise_id, shop_id, brand_id, sale_num, comment_num, sale_start_time, sale_end_time, creator_type, created, creator, creator_id, status, origin', 'safe', 'on'=>'search'),
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
			'product_id' => 'Product',
			'product_code' => 'Product Code',
			'product_name' => 'Product Name',
			'product_desc' => 'Product Desc',
			'product_img' => 'Product Img',
			'inventory_num' => 'Inventory Num',
			'sale_price' => 'Sale Price',
			'standard_price' => 'Standard Price',
			'category_code' => 'Category Code',
			'cruise_id' => 'Cruise',
			'shop_id' => 'Shop',
			'brand_id' => 'Brand',
			'sale_num' => 'Sale Num',
			'comment_num' => 'Comment Num',
			'sale_start_time' => 'Sale Start Time',
			'sale_end_time' => 'Sale End Time',
			'creator_type' => 'Creator Type',
			'created' => 'Created',
			'creator' => 'Creator',
			'creator_id' => 'Creator',
			'status' => 'Status',
			'origin' => 'Origin',
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

		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('product_code',$this->product_code,true);
		$criteria->compare('product_name',$this->product_name,true);
		$criteria->compare('product_desc',$this->product_desc,true);
		$criteria->compare('product_img',$this->product_img,true);
		$criteria->compare('inventory_num',$this->inventory_num);
		$criteria->compare('sale_price',$this->sale_price);
		$criteria->compare('standard_price',$this->standard_price);
		$criteria->compare('category_code',$this->category_code,true);
		$criteria->compare('cruise_id',$this->cruise_id);
		$criteria->compare('shop_id',$this->shop_id);
		$criteria->compare('brand_id',$this->brand_id);
		$criteria->compare('sale_num',$this->sale_num);
		$criteria->compare('comment_num',$this->comment_num);
		$criteria->compare('sale_start_time',$this->sale_start_time,true);
		$criteria->compare('sale_end_time',$this->sale_end_time,true);
		$criteria->compare('creator_type',$this->creator_type);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('creator',$this->creator,true);
		$criteria->compare('creator_id',$this->creator_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('origin',$this->origin,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}