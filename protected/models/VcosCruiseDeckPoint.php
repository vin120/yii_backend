<?php

/**
 * This is the model class for table "vcos_cruise_deck_point".
 *
 * The followings are the available columns in table 'vcos_cruise_deck_point':
 * @property integer $deck_point_id
 * @property integer $deck_id
 * @property string $deck_point_state
 * @property integer $deck_number
 */
class VcosCruiseDeckPoint extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosCruiseDeckPoint the static model class
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
		return 'vcos_cruise_deck_point';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('deck_id, deck_number', 'numerical', 'integerOnly'=>true),
			array('deck_point_state', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('deck_point_id, deck_id, deck_point_state, deck_number', 'safe', 'on'=>'search'),
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
			'deck_point_id' => 'Deck Point',
			'deck_id' => 'Deck',
			'deck_point_state' => 'Deck Point State',
			'deck_number' => 'Deck Number',
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

		$criteria->compare('deck_point_id',$this->deck_point_id);
		$criteria->compare('deck_id',$this->deck_id);
		$criteria->compare('deck_point_state',$this->deck_point_state,true);
		$criteria->compare('deck_number',$this->deck_number);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}