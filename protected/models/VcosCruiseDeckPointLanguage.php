<?php

/**
 * This is the model class for table "vcos_cruise_deck_point_language".
 *
 * The followings are the available columns in table 'vcos_cruise_deck_point_language':
 * @property integer $id
 * @property integer $deck_point_id
 * @property string $deck_point_name
 * @property string $img_url
 * @property string $deck_point_describe
 * @property string $deck_point_info
 * @property string $iso
 */
class VcosCruiseDeckPointLanguage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosCruiseDeckPointLanguage the static model class
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
		return 'vcos_cruise_deck_point_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('deck_point_id', 'numerical', 'integerOnly'=>true),
			array('deck_point_name', 'length', 'max'=>100),
			array('img_url, deck_point_describe', 'length', 'max'=>255),
			array('iso', 'length', 'max'=>10),
			array('deck_point_info', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, deck_point_id, deck_point_name, img_url, deck_point_describe, deck_point_info, iso', 'safe', 'on'=>'search'),
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
			'deck_point_id' => 'Deck Point',
			'deck_point_name' => 'Deck Point Name',
			'img_url' => 'Img Url',
			'deck_point_describe' => 'Deck Point Describe',
			'deck_point_info' => 'Deck Point Info',
			'iso' => 'Iso',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('deck_point_id',$this->deck_point_id);
		$criteria->compare('deck_point_name',$this->deck_point_name,true);
		$criteria->compare('img_url',$this->img_url,true);
		$criteria->compare('deck_point_describe',$this->deck_point_describe,true);
		$criteria->compare('deck_point_info',$this->deck_point_info,true);
		$criteria->compare('iso',$this->iso,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}