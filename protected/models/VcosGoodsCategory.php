<?php

/**
 * This is the model class for table "vcos_goods_category".
 *
 * The followings are the available columns in table 'vcos_goods_category':
 * @property integer $goods_category_id
 * @property string $goods_category_code
 * @property string $goods_category_name
 * @property string $parent_code
 * @property integer $sort_order
 * @property integer $state
 * @property string $creator
 * @property integer $creator_id
 */
class VcosGoodsCategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosGoodsCategory the static model class
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
		return 'vcos_goods_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sort_order, state, creator_id', 'numerical', 'integerOnly'=>true),
			array('goods_category_code, goods_category_name, parent_code, creator', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('goods_category_id, goods_category_code, goods_category_name, parent_code, sort_order, state, creator, creator_id', 'safe', 'on'=>'search'),
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
			'goods_category_id' => 'Goods Category',
			'goods_category_code' => 'Goods Category Code',
			'goods_category_name' => 'Goods Category Name',
			'parent_code' => 'Parent Code',
			'sort_order' => 'Sort Order',
			'state' => 'State',
			'creator' => 'Creator',
			'creator_id' => 'Creator',
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

		$criteria->compare('goods_category_id',$this->goods_category_id);
		$criteria->compare('goods_category_code',$this->goods_category_code,true);
		$criteria->compare('goods_category_name',$this->goods_category_name,true);
		$criteria->compare('parent_code',$this->parent_code,true);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('state',$this->state);
		$criteria->compare('creator',$this->creator,true);
		$criteria->compare('creator_id',$this->creator_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}