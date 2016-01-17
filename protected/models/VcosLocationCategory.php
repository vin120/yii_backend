<?php

/**
 * This is the model class for table "vcos_location_category".
 *
 * The followings are the available columns in table 'vcos_location_category':
 * @property string $id
 * @property string $location_category_name
 * @property string $location_category_img_url
 * @property string $location_category_herf_url
 * @property string $bg_color
 * @property integer $state
 */
class VcosLocationCategory extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosLocationCategory the static model class
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
		return 'vcos_location_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('location_category_name, state', 'required'),
			array('state', 'numerical', 'integerOnly'=>true),
			array('location_category_name', 'length', 'max'=>50),
			array('location_category_img_url, location_category_herf_url', 'length', 'max'=>255),
			array('bg_color', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, location_category_name, location_category_img_url, location_category_herf_url, bg_color, state', 'safe', 'on'=>'search'),
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
			'location_category_name' => 'Location Category Name',
			'location_category_img_url' => 'Location Category Img Url',
			'location_category_herf_url' => 'Location Category Herf Url',
			'bg_color' => 'Bg Color',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('location_category_name',$this->location_category_name,true);
		$criteria->compare('location_category_img_url',$this->location_category_img_url,true);
		$criteria->compare('location_category_herf_url',$this->location_category_herf_url,true);
		$criteria->compare('bg_color',$this->bg_color,true);
		$criteria->compare('state',$this->state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}