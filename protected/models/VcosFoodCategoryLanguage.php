<?php

/**
 * This is the model class for table "vcos_food_category_language".
 *
 * The followings are the available columns in table 'vcos_food_category_language':
 * @property integer $id
 * @property integer $food_category_id
 * @property string $iso
 * @property string $food_category_name
 *
 * The followings are the available model relations:
 * @property VcosFoodCategory $foodCategory
 */
class VcosFoodCategoryLanguage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosFoodCategoryLanguage the static model class
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
		return 'vcos_food_category_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, food_category_id', 'required'),
			array('id, food_category_id', 'numerical', 'integerOnly'=>true),
			array('iso', 'length', 'max'=>10),
			array('food_category_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, food_category_id, iso, food_category_name', 'safe', 'on'=>'search'),
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
			'foodCategory' => array(self::BELONGS_TO, 'VcosFoodCategory', 'food_category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'food_category_id' => 'Food Category',
			'iso' => 'Iso',
			'food_category_name' => 'Food Category Name',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('food_category_id',$this->food_category_id);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('food_category_name',$this->food_category_name,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}