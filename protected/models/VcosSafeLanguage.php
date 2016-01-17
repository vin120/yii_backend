<?php

/**
 * This is the model class for table "vcos_safe_language".
 *
 * The followings are the available columns in table 'vcos_safe_language':
 * @property string $id
 * @property string $safe_id
 * @property string $iso
 * @property string $safe_title
 * @property string $safe_content
 */
class VcosSafeLanguage extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosSafeLanguage the static model class
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
		return 'vcos_safe_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('safe_id, iso, safe_title, safe_content', 'required'),
			array('safe_id', 'length', 'max'=>10),
			array('iso', 'length', 'max'=>60),
			array('safe_title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, safe_id, iso, safe_title, safe_content', 'safe', 'on'=>'search'),
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
			'safe_id' => 'Safe',
			'iso' => 'Iso',
			'safe_title' => 'Safe Title',
			'safe_content' => 'Safe Content',
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
		$criteria->compare('safe_id',$this->safe_id,true);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('safe_title',$this->safe_title,true);
		$criteria->compare('safe_content',$this->safe_content,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}