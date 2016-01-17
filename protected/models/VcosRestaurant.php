<?php

/**
 * This is the model class for table "vcos_restaurant".
 *
 * The followings are the available columns in table 'vcos_restaurant':
 * @property string $restaurant_id
 * @property integer $restaurant_type
 * @property string $restaurant_tel
 * @property string $restaurant_img_url
 * @property string $restaurant_img_url2
 * @property integer $restaurant_state
 * @property string $restaurant_sequence
 * @property string $bg_color
 * @property integer $can_delivery
 * @property integer $can_book
 * @property string $food_setting
 */
class VcosRestaurant extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosRestaurant the static model class
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
		return 'vcos_restaurant';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('restaurant_type, restaurant_tel, restaurant_img_url, restaurant_img_url2, restaurant_state, restaurant_sequence', 'required'),
			array('restaurant_type, restaurant_state, can_delivery, can_book', 'numerical', 'integerOnly'=>true),
			array('restaurant_tel, restaurant_img_url, restaurant_img_url2, bg_color', 'length', 'max'=>255),
			array('restaurant_sequence', 'length', 'max'=>10),
			array('food_setting', 'length', 'max'=>1000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('restaurant_id, restaurant_type, restaurant_tel, restaurant_img_url, restaurant_img_url2, restaurant_state, restaurant_sequence, bg_color, can_delivery, can_book, food_setting', 'safe', 'on'=>'search'),
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
			'restaurant_id' => 'Restaurant',
			'restaurant_type' => 'Restaurant Type',
			'restaurant_tel' => 'Restaurant Tel',
			'restaurant_img_url' => 'Restaurant Img Url',
			'restaurant_img_url2' => 'Restaurant Img Url2',
			'restaurant_state' => 'Restaurant State',
			'restaurant_sequence' => 'Restaurant Sequence',
			'bg_color' => 'Bg Color',
			'can_delivery' => 'Can Delivery',
			'can_book' => 'Can Book',
			'food_setting' => 'Food Setting',
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

		$criteria->compare('restaurant_id',$this->restaurant_id,true);
		$criteria->compare('restaurant_type',$this->restaurant_type);
		$criteria->compare('restaurant_tel',$this->restaurant_tel,true);
		$criteria->compare('restaurant_img_url',$this->restaurant_img_url,true);
		$criteria->compare('restaurant_img_url2',$this->restaurant_img_url2,true);
		$criteria->compare('restaurant_state',$this->restaurant_state);
		$criteria->compare('restaurant_sequence',$this->restaurant_sequence,true);
		$criteria->compare('bg_color',$this->bg_color,true);
		$criteria->compare('can_delivery',$this->can_delivery);
		$criteria->compare('can_book',$this->can_book);
		$criteria->compare('food_setting',$this->food_setting,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}