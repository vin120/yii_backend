<?php

/**
 * This is the model class for table "vcos_product_detail".
 *
 * The followings are the available columns in table 'vcos_product_detail':
 * @property string $product_detail_id
 * @property integer $product_id
 * @property string $text_detail
 * @property string $graphic_detail
 */
class VcosProductDetail extends PrCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosProductDetail the static model class
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
		return 'vcos_product_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id', 'numerical', 'integerOnly'=>true),
			array('text_detail, graphic_detail', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('product_detail_id, product_id, text_detail, graphic_detail', 'safe', 'on'=>'search'),
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
			'product_detail_id' => 'Product Detail',
			'product_id' => 'Product',
			'text_detail' => 'Text Detail',
			'graphic_detail' => 'Graphic Detail',
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

		$criteria->compare('product_detail_id',$this->product_detail_id,true);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('text_detail',$this->text_detail,true);
		$criteria->compare('graphic_detail',$this->graphic_detail,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}