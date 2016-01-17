<?php

/**
 * This is the model class for table "vcos_main_nav".
 *
 * The followings are the available columns in table 'vcos_main_nav':
 * @property string $nav_id
 * @property integer $category_id
 * @property integer $sequence
 * @property integer $state
 */
class VcosMainNav extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosMainNav the static model class
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
		return 'vcos_main_nav';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, sequence, state', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nav_id, category_id, sequence, state', 'safe', 'on'=>'search'),
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
			'nav_id' => 'Nav',
			'category_id' => 'Category',
			'sequence' => 'Sequence',
			'state' => 'State',
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

		$criteria->compare('nav_id',$this->nav_id,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('sequence',$this->sequence);
		$criteria->compare('state',$this->state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}