<?php

/**
 * This is the model class for table "vcos_country".
 *
 * The followings are the available columns in table 'vcos_country':
 * @property string $country_id
 * @property string $country_cn_name
 * @property string $country_en_name
 * @property string $country_code
 * @property string $country_short_code
 * @property integer $country_number
 * @property string $country_logo
 * @property integer $state
 */
class VcosCountry extends CActiveRecord
{
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
			array('country_number, state', 'numerical', 'integerOnly'=>true),
			array('country_cn_name, country_en_name, country_logo', 'length', 'max'=>128),
			array('country_code', 'length', 'max'=>2),
			array('country_short_code', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('country_id, country_cn_name, country_en_name, country_code, country_short_code, country_number, country_logo, state', 'safe', 'on'=>'search'),
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
			'country_cn_name' => 'Country Cn Name',
			'country_en_name' => 'Country En Name',
			'country_code' => 'Country Code',
			'country_short_code' => 'Country Short Code',
			'country_number' => 'Country Number',
			'country_logo' => 'Country Logo',
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

		$criteria->compare('country_id',$this->country_id,true);
		$criteria->compare('country_cn_name',$this->country_cn_name,true);
		$criteria->compare('country_en_name',$this->country_en_name,true);
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('country_short_code',$this->country_short_code,true);
		$criteria->compare('country_number',$this->country_number);
		$criteria->compare('country_logo',$this->country_logo,true);
		$criteria->compare('state',$this->state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}