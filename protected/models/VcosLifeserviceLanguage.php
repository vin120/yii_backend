<?php

/**
 * This is the model class for table "vcos_lifeservice_language".
 *
 * The followings are the available columns in table 'vcos_lifeservice_language':
 * @property string $id
 * @property string $ls_id
 * @property string $iso
 * @property string $ls_title
 * @property string $ls_desc
 * @property string $ls_info
 * @property string $ls_address
 * @property string $ls_opening_time
 */
class VcosLifeserviceLanguage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosLifeserviceLanguage the static model class
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
		return 'vcos_lifeservice_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ls_id, iso, ls_title, ls_info, ls_address, ls_opening_time', 'required'),
			array('ls_id', 'length', 'max'=>10),
			array('iso', 'length', 'max'=>60),
			array('ls_title, ls_desc, ls_address, ls_opening_time', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ls_id, iso, ls_title, ls_desc, ls_info, ls_address, ls_opening_time', 'safe', 'on'=>'search'),
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
			'ls_id' => 'Ls',
			'iso' => 'Iso',
			'ls_title' => 'Ls Title',
			'ls_desc' => 'Ls Desc',
			'ls_info' => 'Ls Info',
			'ls_address' => 'Ls Address',
			'ls_opening_time' => 'Ls Opening Time',
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
		$criteria->compare('ls_id',$this->ls_id,true);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('ls_title',$this->ls_title,true);
		$criteria->compare('ls_desc',$this->ls_desc,true);
		$criteria->compare('ls_info',$this->ls_info,true);
		$criteria->compare('ls_address',$this->ls_address,true);
		$criteria->compare('ls_opening_time',$this->ls_opening_time,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}