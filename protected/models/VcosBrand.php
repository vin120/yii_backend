<?php

/**
 * This is the model class for table "vcos_brand".
 *
 * The followings are the available columns in table 'vcos_brand':
 * @property string $brand_id
 * @property string $brand_cn_name
 * @property string $brand_en_name
 * @property integer $country_id
 * @property string $brand_logo
 * @property string $brand_desc
 * @property integer $brand_status
 */
class VcosBrand extends PrCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosBrand the static model class
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
		return 'vcos_brand';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_id, brand_status', 'numerical', 'integerOnly'=>true),
			array('brand_cn_name, brand_en_name, brand_logo', 'length', 'max'=>128),
			array('brand_desc', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('brand_id, brand_cn_name, brand_en_name, country_id, brand_logo, brand_desc, brand_status', 'safe', 'on'=>'search'),
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
			'brand_id' => 'Brand',
			'brand_cn_name' => 'Brand Cn Name',
			'brand_en_name' => 'Brand En Name',
			'country_id' => 'Country',
			'brand_logo' => 'Brand Logo',
			'brand_desc' => 'Brand Desc',
			'brand_status' => 'Brand Status',
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

		$criteria->compare('brand_id',$this->brand_id,true);
		$criteria->compare('brand_cn_name',$this->brand_cn_name,true);
		$criteria->compare('brand_en_name',$this->brand_en_name,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('brand_logo',$this->brand_logo,true);
		$criteria->compare('brand_desc',$this->brand_desc,true);
		$criteria->compare('brand_status',$this->brand_status);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}