<?php

/**
 * This is the model class for table "vcos_weather_record".
 *
 * The followings are the available columns in table 'vcos_weather_record':
 * @property string $record_id
 * @property integer $city_id
 * @property string $weather_id
 * @property string $record_temperature_min
 * @property string $record_temperature_max
 * @property string $record_start_time
 * @property string $record_end_time
 */
class VcosWeatherRecord extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosWeatherRecord the static model class
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
		return 'vcos_weather_record';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('weather_id, record_temperature_min, record_temperature_max, record_start_time, record_end_time', 'required'),
			array('city_id', 'numerical', 'integerOnly'=>true),
			array('weather_id', 'length', 'max'=>10),
			array('record_temperature_min, record_temperature_max', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('record_id, city_id, weather_id, record_temperature_min, record_temperature_max, record_start_time, record_end_time', 'safe', 'on'=>'search'),
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
			'record_id' => 'Record',
			'city_id' => 'City',
			'weather_id' => 'Weather',
			'record_temperature_min' => 'Record Temperature Min',
			'record_temperature_max' => 'Record Temperature Max',
			'record_start_time' => 'Record Start Time',
			'record_end_time' => 'Record End Time',
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

		$criteria->compare('record_id',$this->record_id,true);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('weather_id',$this->weather_id,true);
		$criteria->compare('record_temperature_min',$this->record_temperature_min,true);
		$criteria->compare('record_temperature_max',$this->record_temperature_max,true);
		$criteria->compare('record_start_time',$this->record_start_time,true);
		$criteria->compare('record_end_time',$this->record_end_time,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}