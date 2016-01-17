<?php

/**
 * This is the model class for table "vcos_activity".
 *
 * The followings are the available columns in table 'vcos_activity':
 * @property string $activity_id
 * @property string $activity_name
 * @property string $activity_desc
 * @property string $activity_img
 * @property string $start_time
 * @property string $end_time
 * @property integer $status
 * @property string $created
 * @property string $creator
 * @property integer $creator_id
 * @property integer $is_show_category
 * @property integer $cruise_id
 * @property integer $is_show_head
 */
class VcosActivity extends PrCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosActivity the static model class
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
		return 'vcos_activity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cruise_id', 'required'),
			array('status, creator_id, is_show_category, cruise_id, is_show_head', 'numerical', 'integerOnly'=>true),
			array('activity_name', 'length', 'max'=>128),
			array('activity_desc, activity_img', 'length', 'max'=>255),
			array('creator', 'length', 'max'=>64),
			array('start_time, end_time, created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('activity_id, activity_name, activity_desc, activity_img, start_time, end_time, status, created, creator, creator_id, is_show_category, cruise_id, is_show_head', 'safe', 'on'=>'search'),
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
			'activity_id' => 'Activity',
			'activity_name' => 'Activity Name',
			'activity_desc' => 'Activity Desc',
			'activity_img' => 'Activity Img',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
			'status' => 'Status',
			'created' => 'Created',
			'creator' => 'Creator',
			'creator_id' => 'Creator',
			'is_show_category' => 'Is Show Category',
			'cruise_id' => 'Cruise',
			'is_show_head' => 'Is Show Head',
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

		$criteria->compare('activity_id',$this->activity_id,true);
		$criteria->compare('activity_name',$this->activity_name,true);
		$criteria->compare('activity_desc',$this->activity_desc,true);
		$criteria->compare('activity_img',$this->activity_img,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('creator',$this->creator,true);
		$criteria->compare('creator_id',$this->creator_id);
		$criteria->compare('is_show_category',$this->is_show_category);
		$criteria->compare('cruise_id',$this->cruise_id);
		$criteria->compare('is_show_head',$this->is_show_head);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}