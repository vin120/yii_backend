<?php

/**
 * This is the model class for table "vcos_travel_schedule".
 *
 * The followings are the available columns in table 'vcos_travel_schedule':
 * @property integer $ts_id
 * @property string $ts_time
 * @property string $ts_img_url
 * @property string $ts_start_time
 * @property string $ts_end_time
 * @property integer $ts_state
 */
class VcosTravelSchedule extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosTravelSchedule the static model class
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
		return 'vcos_travel_schedule';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ts_time, ts_start_time, ts_end_time, ts_state', 'required'),
			array('ts_state', 'numerical', 'integerOnly'=>true),
			array('ts_img_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ts_id, ts_time, ts_img_url, ts_start_time, ts_end_time, ts_state', 'safe', 'on'=>'search'),
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
			'ts_id' => 'Ts',
			'ts_time' => 'Ts Time',
			'ts_img_url' => 'Ts Img Url',
			'ts_start_time' => 'Ts Start Time',
			'ts_end_time' => 'Ts End Time',
			'ts_state' => 'Ts State',
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

		$criteria->compare('ts_id',$this->ts_id);
		$criteria->compare('ts_time',$this->ts_time,true);
		$criteria->compare('ts_img_url',$this->ts_img_url,true);
		$criteria->compare('ts_start_time',$this->ts_start_time,true);
		$criteria->compare('ts_end_time',$this->ts_end_time,true);
		$criteria->compare('ts_state',$this->ts_state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}