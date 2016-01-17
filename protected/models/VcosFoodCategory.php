<?php

/**
 * This is the model class for table "vcos_food_category".
 *
 * The followings are the available columns in table 'vcos_food_category':
 * @property integer $food_category_id
 * @property integer $food_category_state
 * @property integer $list_order
 * @property integer $parent_id
 *
 * The followings are the available model relations:
 * @property VcosFoodCategoryLanguage[] $vcosFoodCategoryLanguages
 */
class VcosFoodCategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosFoodCategory the static model class
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
		return 'vcos_food_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('food_category_state, list_order, parent_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('food_category_id, food_category_state, list_order, parent_id', 'safe', 'on'=>'search'),
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
			'vcosFoodCategoryLanguages' => array(self::HAS_MANY, 'VcosFoodCategoryLanguage', 'food_category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'food_category_id' => 'Food Category',
			'food_category_state' => 'Food Category State',
			'list_order' => 'List Order',
			'parent_id' => 'Parent',
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

		$criteria->compare('food_category_id',$this->food_category_id);
		$criteria->compare('food_category_state',$this->food_category_state);
		$criteria->compare('list_order',$this->list_order);
		$criteria->compare('parent_id',$this->parent_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}