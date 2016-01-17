<?php

/**
 * This is the model class for table "vcos_travel_schedule_language".
 *
 * The followings are the available columns in table 'vcos_travel_schedule_language':
 * @property string $id
 * @property string $ts_id
 * @property string $iso
 * @property string $ts_title
 * @property string $ts_address
 * @property string $ts_content
 */
class VcosTravelScheduleLanguage extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosTravelScheduleLanguage the static model class
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
		return 'vcos_travel_schedule_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ts_id, iso, ts_title, ts_address, ts_content', 'required'),
			array('ts_id', 'length', 'max'=>10),
			array('iso', 'length', 'max'=>60),
			array('ts_title, ts_address', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ts_id, iso, ts_title, ts_address, ts_content', 'safe', 'on'=>'search'),
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
			'ts_id' => 'Ts',
			'iso' => 'Iso',
			'ts_title' => 'Ts Title',
			'ts_address' => 'Ts Address',
			'ts_content' => 'Ts Content',
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
		$criteria->compare('ts_id',$this->ts_id,true);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('ts_title',$this->ts_title,true);
		$criteria->compare('ts_address',$this->ts_address,true);
		$criteria->compare('ts_content',$this->ts_content,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}