<?php

/**
 * This is the model class for table "vcos_survey_choose".
 *
 * The followings are the available columns in table 'vcos_survey_choose':
 * @property string $survey_choose_id
 * @property integer $survey_choose_state
 */
class VcosSurveyChoose extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosSurveyChoose the static model class
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
		return 'vcos_survey_choose';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('survey_choose_state', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('survey_choose_id, survey_choose_state', 'safe', 'on'=>'search'),
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
			'survey_choose_id' => 'Survey Choose',
			'survey_choose_state' => 'Survey Choose State',
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

		$criteria->compare('survey_choose_id',$this->survey_choose_id,true);
		$criteria->compare('survey_choose_state',$this->survey_choose_state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}