<?php

/**
 * This is the model class for table "vcos_common_problems_language".
 *
 * The followings are the available columns in table 'vcos_common_problems_language':
 * @property string $id
 * @property string $cm_id
 * @property string $iso
 * @property string $cm_title
 * @property string $cm_reply
 */
class VcosCommonProblemsLanguage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosCommonProblemsLanguage the static model class
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
		return 'vcos_common_problems_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cm_id, iso, cm_title, cm_reply', 'required'),
			array('cm_id', 'length', 'max'=>10),
			array('iso', 'length', 'max'=>60),
			array('cm_title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cm_id, iso, cm_title, cm_reply', 'safe', 'on'=>'search'),
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
			'cm_id' => 'Cm',
			'iso' => 'Iso',
			'cm_title' => 'Cm Title',
			'cm_reply' => 'Cm Reply',
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
		$criteria->compare('cm_id',$this->cm_id,true);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('cm_title',$this->cm_title,true);
		$criteria->compare('cm_reply',$this->cm_reply,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}