<?php

/**
 * This is the model class for table "vcos_ad_language".
 *
 * The followings are the available columns in table 'vcos_ad_language':
 * @property string $id
 * @property string $ad_id
 * @property string $iso
 * @property string $name
 * @property string $img_url
 * @property string $link_url
 */
class VcosAdLanguage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosAdLanguage the static model class
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
		return 'vcos_ad_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ad_id, iso, name', 'required'),
			array('ad_id', 'length', 'max'=>10),
			array('iso', 'length', 'max'=>60),
			array('name, img_url, link_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ad_id, iso, name, img_url, link_url', 'safe', 'on'=>'search'),
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
			'ad_id' => 'Ad',
			'iso' => 'Iso',
			'name' => 'Name',
			'img_url' => 'Img Url',
			'link_url' => 'Link Url',
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
		$criteria->compare('ad_id',$this->ad_id,true);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('img_url',$this->img_url,true);
		$criteria->compare('link_url',$this->link_url,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}