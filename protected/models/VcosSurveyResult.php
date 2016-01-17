<?php

/**
 * This is the model class for table "vcos_survey_result".
 *
 * The followings are the available columns in table 'vcos_survey_result':
 * @property string $survey_result_id
 * @property integer $survey_id
 * @property integer $survey_choose_id
 * @property integer $membership_id
 * @property string $survey_result_time
 */
class VcosSurveyResult extends MyCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vcos_survey_result';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('survey_id, survey_choose_id, membership_id', 'numerical', 'integerOnly'=>true),
			array('survey_result_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('survey_result_id, survey_id, survey_choose_id, membership_id, survey_result_time', 'safe', 'on'=>'search'),
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
			'survey_result_id' => 'Survey Result',
			'survey_id' => 'Survey',
			'survey_choose_id' => 'Survey Choose',
			'membership_id' => 'Membership',
			'survey_result_time' => 'Survey Result Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('survey_result_id',$this->survey_result_id,true);
		$criteria->compare('survey_id',$this->survey_id);
		$criteria->compare('survey_choose_id',$this->survey_choose_id);
		$criteria->compare('membership_id',$this->membership_id);
		$criteria->compare('survey_result_time',$this->survey_result_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VcosSurveyResult the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
