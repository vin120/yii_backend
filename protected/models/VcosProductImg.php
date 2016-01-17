<?php

/**
 * This is the model class for table "vcos_product_img".
 *
 * The followings are the available columns in table 'vcos_product_img':
 * @property string $product_img_id
 * @property integer $product_id
 * @property string $img_url
 * @property integer $img_type
 * @property integer $sort_order
 */
class VcosProductImg extends PrCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosProductImg the static model class
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
		return 'vcos_product_img';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, img_type, sort_order', 'numerical', 'integerOnly'=>true),
			array('img_url', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('product_img_id, product_id, img_url, img_type, sort_order', 'safe', 'on'=>'search'),
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
			'product_img_id' => 'Product Img',
			'product_id' => 'Product',
			'img_url' => 'Img Url',
			'img_type' => 'Img Type',
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

		$criteria->compare('product_img_id',$this->product_img_id,true);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('img_url',$this->img_url,true);
		$criteria->compare('img_type',$this->img_type);
		$criteria->compare('sort_order',$this->sort_order);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}