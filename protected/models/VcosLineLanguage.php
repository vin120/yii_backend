<?php

/**
 * This is the model class for table "vcos_line_language".
 *
 * The followings are the available columns in table 'vcos_line_language':
 * @property string $id
 * @property string $line_id
 * @property string $iso
 * @property string $line_name
 * @property string $voyage_time
 */
class VcosLineLanguage extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosLineLanguage the static model class
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
		return 'vcos_line_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('line_id, iso, line_name, voyage_time', 'required'),
			array('line_id', 'length', 'max'=>10),
			array('iso', 'length', 'max'=>60),
			array('line_name, voyage_time', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, line_id, iso, line_name, voyage_time', 'safe', 'on'=>'search'),
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
			'line_id' => 'Line',
			'iso' => 'Iso',
			'line_name' => 'Line Name',
			'voyage_time' => 'Voyage Time',
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
		$criteria->compare('line_id',$this->line_id,true);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('line_name',$this->line_name,true);
		$criteria->compare('voyage_time',$this->voyage_time,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}