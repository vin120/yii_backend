<?php

/**
 * This is the model class for table "vcos_weather".
 *
 * The followings are the available columns in table 'vcos_weather':
 * @property string $weather_id
 * @property string $weather_name
 * @property string $weather_img_url
 * @property integer $weather_state
 */
class VcosWeather extends MyCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vcos_weather';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('weather_name, weather_img_url, weather_state', 'required'),
			array('weather_state', 'numerical', 'integerOnly'=>true),
			array('weather_name, weather_img_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('weather_id, weather_name, weather_img_url, weather_state', 'safe', 'on'=>'search'),
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
			'weather_id' => 'Weather',
			'weather_name' => 'Weather Name',
			'weather_img_url' => 'Weather Img Url',
			'weather_state' => 'Weather State',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('weather_id',$this->weather_id,true);
		$criteria->compare('weather_name',$this->weather_name,true);
		$criteria->compare('weather_img_url',$this->weather_img_url,true);
		$criteria->compare('weather_state',$this->weather_state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VcosWeather the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
