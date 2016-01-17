<?php

/**
 * This is the model class for table "vcos_room_detail".
 *
 * The followings are the available columns in table 'vcos_room_detail':
 * @property integer $detail_id
 * @property integer $room_id
 * @property string $room_img_url
 * @property integer $detail_state
 */
class VcosRoomDetail extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosRoomDetail the static model class
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
		return 'vcos_room_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('room_id, room_img_url', 'required'),
			array('room_id, detail_state', 'numerical', 'integerOnly'=>true),
			array('room_img_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('detail_id, room_id, room_img_url, detail_state', 'safe', 'on'=>'search'),
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
			'detail_id' => 'Detail',
			'room_id' => 'Room',
			'room_img_url' => 'Room Img Url',
			'detail_state' => 'Detail State',
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

		$criteria->compare('detail_id',$this->detail_id);
		$criteria->compare('room_id',$this->room_id);
		$criteria->compare('room_img_url',$this->room_img_url,true);
		$criteria->compare('detail_state',$this->detail_state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}