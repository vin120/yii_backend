<?php

/**
 * This is the model class for table "vcos_cruise_info".
 *
 * The followings are the available columns in table 'vcos_cruise_info':
 * @property integer $info_id
 * @property string $cruise_img
 * @property integer $state
 */
class VcosCruiseInfo extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosCruiseInfo the static model class
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
		return 'vcos_cruise_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cruise_img', 'required'),
			array('state', 'numerical', 'integerOnly'=>true),
			array('cruise_img', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('info_id, cruise_img, state', 'safe', 'on'=>'search'),
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
			'info_id' => 'Info',
			'cruise_img' => 'Cruise Img',
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

		$criteria->compare('info_id',$this->info_id);
		$criteria->compare('cruise_img',$this->cruise_img,true);
		$criteria->compare('state',$this->state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}