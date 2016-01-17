<?php

/**
 * This is the model class for table "vcos_food".
 *
 * The followings are the available columns in table 'vcos_food':
 * @property string $food_id
 * @property string $food_price
 * @property string $food_img_url
 * @property integer $max_buy
 * @property integer $food_state
 */
class VcosFood extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosFood the static model class
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
		return 'vcos_food';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('food_img_url, max_buy, food_state', 'required'),
			array('max_buy, food_state', 'numerical', 'integerOnly'=>true),
			array('food_price', 'length', 'max'=>10),
			array('food_img_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('food_id, food_price, food_img_url, max_buy, food_state', 'safe', 'on'=>'search'),
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
			'food_id' => 'Food',
			'food_price' => 'Food Price',
			'food_img_url' => 'Food Img Url',
			'max_buy' => 'Max Buy',
			'food_state' => 'Food State',
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

		$criteria->compare('food_id',$this->food_id,true);
		$criteria->compare('food_price',$this->food_price,true);
		$criteria->compare('food_img_url',$this->food_img_url,true);
		$criteria->compare('max_buy',$this->max_buy);
		$criteria->compare('food_state',$this->food_state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}