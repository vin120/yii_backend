<?php

/**
 * This is the model class for table "vcos_survey_choose_language".
 *
 * The followings are the available columns in table 'vcos_survey_choose_language':
 * @property string $id
 * @property string $survey_choose_id
 * @property string $iso
 * @property string $survey_choose_name
 */
class VcosSurveyChooseLanguage extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosSurveyChooseLanguage the static model class
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
		return 'vcos_survey_choose_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('survey_choose_id, iso, survey_choose_name', 'required'),
			array('survey_choose_id', 'length', 'max'=>10),
			array('iso, survey_choose_name', 'length', 'max'=>60),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, survey_choose_id, iso, survey_choose_name', 'safe', 'on'=>'search'),
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
			'survey_choose_id' => 'Survey Choose',
			'iso' => 'Iso',
			'survey_choose_name' => 'Survey Choose Name',
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
		$criteria->compare('survey_choose_id',$this->survey_choose_id,true);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('survey_choose_name',$this->survey_choose_name,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}