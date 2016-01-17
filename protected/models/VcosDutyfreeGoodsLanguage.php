<?php

/**
 * This is the model class for table "vcos_dutyfree_goods_language".
 *
 * The followings are the available columns in table 'vcos_dutyfree_goods_language':
 * @property string $id
 * @property string $goods_id
 * @property string $iso
 * @property string $goods_name
 * @property string $goods_info
 */
class VcosDutyfreeGoodsLanguage extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosDutyfreeGoodsLanguage the static model class
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
		return 'vcos_dutyfree_goods_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('goods_id, iso, goods_name, goods_info', 'required'),
			array('goods_id', 'length', 'max'=>10),
			array('iso', 'length', 'max'=>60),
			array('goods_name, goods_info', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, goods_id, iso, goods_name, goods_info', 'safe', 'on'=>'search'),
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
			'goods_id' => 'Goods',
			'iso' => 'Iso',
			'goods_name' => 'Goods Name',
			'goods_info' => 'Goods Info',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('goods_id',$this->goods_id,true);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('goods_name',$this->goods_name,true);
		$criteria->compare('goods_info',$this->goods_info,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}