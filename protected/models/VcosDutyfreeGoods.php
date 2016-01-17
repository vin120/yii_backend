<?php

/**
 * This is the model class for table "vcos_dutyfree_goods".
 *
 * The followings are the available columns in table 'vcos_dutyfree_goods':
 * @property string $goods_id
 * @property string $goods_price
 * @property string $goods_img_url
 * @property integer $goods_category
 * @property integer $goods_state
 */
class VcosDutyfreeGoods extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosDutyfreeGoods the static model class
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
		return 'vcos_dutyfree_goods';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('goods_img_url, goods_category, goods_state', 'required'),
			array('goods_category, goods_state', 'numerical', 'integerOnly'=>true),
			array('goods_price', 'length', 'max'=>10),
			array('goods_img_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('goods_id, goods_price, goods_img_url, goods_category, goods_state', 'safe', 'on'=>'search'),
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
			'goods_id' => 'Goods',
			'goods_price' => 'Goods Price',
			'goods_img_url' => 'Goods Img Url',
			'goods_category' => 'Goods Category',
			'goods_state' => 'Goods State',
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

		$criteria->compare('goods_id',$this->goods_id,true);
		$criteria->compare('goods_price',$this->goods_price,true);
		$criteria->compare('goods_img_url',$this->goods_img_url,true);
		$criteria->compare('goods_category',$this->goods_category);
		$criteria->compare('goods_state',$this->goods_state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}