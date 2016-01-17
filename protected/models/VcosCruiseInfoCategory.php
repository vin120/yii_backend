<?php

/**
 * This is the model class for table "vcos_cruise_info_category".
 *
 * The followings are the available columns in table 'vcos_cruise_info_category':
 * @property string $id
 * @property string $cruise_info_category_name
 * @property string $cruise_info_category_img_url
 * @property string $bg_color
 * @property string $category_href_url
 * @property integer $state
 */
class VcosCruiseInfoCategory extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosCruiseInfoCategory the static model class
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
		return 'vcos_cruise_info_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cruise_info_category_name, bg_color, category_href_url', 'required'),
			array('state', 'numerical', 'integerOnly'=>true),
			array('cruise_info_category_name, cruise_info_category_img_url, category_href_url', 'length', 'max'=>255),
			array('bg_color', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cruise_info_category_name, cruise_info_category_img_url, bg_color, category_href_url, state', 'safe', 'on'=>'search'),
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
			'cruise_info_category_name' => 'Cruise Info Category Name',
			'cruise_info_category_img_url' => 'Cruise Info Category Img Url',
			'bg_color' => 'Bg Color',
			'category_href_url' => 'Category Href Url',
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
		$criteria->compare('cruise_info_category_name',$this->cruise_info_category_name,true);
		$criteria->compare('cruise_info_category_img_url',$this->cruise_info_category_img_url,true);
		$criteria->compare('bg_color',$this->bg_color,true);
		$criteria->compare('category_href_url',$this->category_href_url,true);
		$criteria->compare('state',$this->state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}