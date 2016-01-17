<?php

/**
 * This is the model class for table "vcos_country".
 *
 * The followings are the available columns in table 'vcos_country':
 * @property integer $country_id
 * @property string $country_code
 * @property string $country_number
 * @property string $country_name
 * @property string $country_name_en
 * @property string $country_short_code
 * @property integer $country_state
 * @property string $mark
 * @property string $create_by
 * @property integer $create_time
 */
class VcosCountry extends CActiveRecord
{
    public $dbname='db';
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosCountry the static model class
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
		return 'vcos_country';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_state, create_time', 'numerical', 'integerOnly'=>true),
			array('country_code, country_number, create_by', 'length', 'max'=>32),
			array('country_name, country_name_en, mark', 'length', 'max'=>128),
			array('country_short_code', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('country_id, country_code, country_number, country_name, country_name_en, country_short_code, country_state, mark, create_by, create_time', 'safe', 'on'=>'search'),
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
			'country_id' => 'Country',
			'country_code' => 'Country Code',
			'country_number' => 'Country Number',
			'country_name' => 'Country Name',
			'country_name_en' => 'Country Name En',
			'country_short_code' => 'Country Short Code',
			'country_state' => 'Country State',
			'mark' => 'Mark',
			'create_by' => 'Create By',
			'create_time' => 'Create Time',
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

		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('country_number',$this->country_number,true);
		$criteria->compare('country_name',$this->country_name,true);
		$criteria->compare('country_name_en',$this->country_name_en,true);
		$criteria->compare('country_short_code',$this->country_short_code,true);
		$criteria->compare('country_state',$this->country_state);
		$criteria->compare('mark',$this->mark,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('create_time',$this->create_time);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}