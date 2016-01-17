<?php

/**
 * This is the model class for table "vcos_port_detail".
 *
 * The followings are the available columns in table 'vcos_port_detail':
 * @property string $detail_id
 * @property string $port_id
 * @property string $detail_img_url
 * @property integer $detail_state
 */
class VcosPortDetail extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosPortDetail the static model class
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
		return 'vcos_port_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('port_id, detail_img_url', 'required'),
			array('detail_state', 'numerical', 'integerOnly'=>true),
			array('port_id', 'length', 'max'=>10),
			array('detail_img_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('detail_id, port_id, detail_img_url, detail_state', 'safe', 'on'=>'search'),
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
			'port_id' => 'Port',
			'detail_img_url' => 'Detail Img Url',
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

		$criteria->compare('detail_id',$this->detail_id,true);
		$criteria->compare('port_id',$this->port_id,true);
		$criteria->compare('detail_img_url',$this->detail_img_url,true);
		$criteria->compare('detail_state',$this->detail_state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}