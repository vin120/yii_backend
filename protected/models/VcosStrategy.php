<?php

/**
 * This is the model class for table "vcos_strategy".
 *
 * The followings are the available columns in table 'vcos_strategy':
 * @property integer $strategy_id
 * @property integer $strategy_state
 * @property integer $strategy_category_id
 * @property integer $city_id
 */
class VcosStrategy extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosStrategy the static model class
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
		return 'vcos_strategy';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('strategy_state, strategy_category_id, city_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('strategy_id, strategy_state, strategy_category_id, city_id', 'safe', 'on'=>'search'),
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
			'strategy_id' => 'Strategy',
			'strategy_state' => 'Strategy State',
			'strategy_category_id' => 'Strategy Category',
			'city_id' => 'City',
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

		$criteria->compare('strategy_id',$this->strategy_id);
		$criteria->compare('strategy_state',$this->strategy_state);
		$criteria->compare('strategy_category_id',$this->strategy_category_id);
		$criteria->compare('city_id',$this->city_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}