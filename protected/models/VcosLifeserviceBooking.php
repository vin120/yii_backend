<?php

/**
 * This is the model class for table "vcos_lifeservice_booking".
 *
 * The followings are the available columns in table 'vcos_lifeservice_booking':
 * @property integer $id
 * @property integer $membership_id
 * @property integer $ls_id
 * @property string $ls_title
 * @property string $booking_time
 * @property integer $booking_num
 * @property string $remark
 * @property integer $state
 * @property string $create_time
 * @property integer $is_read
 */
class VcosLifeserviceBooking extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosLifeserviceBooking the static model class
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
		return 'vcos_lifeservice_booking';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('membership_id, ls_id, booking_num, state, is_read', 'numerical', 'integerOnly'=>true),
			array('ls_title, remark', 'length', 'max'=>255),
			array('booking_time, create_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, membership_id, ls_id, ls_title, booking_time, booking_num, remark, state, create_time, is_read', 'safe', 'on'=>'search'),
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
			'membership_id' => 'Membership',
			'ls_id' => 'Ls',
			'ls_title' => 'Ls Title',
			'booking_time' => 'Booking Time',
			'booking_num' => 'Booking Num',
			'remark' => 'Remark',
			'state' => 'State',
			'create_time' => 'Create Time',
			'is_read' => 'Is Read',
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
		$criteria->compare('membership_id',$this->membership_id);
		$criteria->compare('ls_id',$this->ls_id);
		$criteria->compare('ls_title',$this->ls_title,true);
		$criteria->compare('booking_time',$this->booking_time,true);
		$criteria->compare('booking_num',$this->booking_num);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('is_read',$this->is_read);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}