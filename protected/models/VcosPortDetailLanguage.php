<?php

/**
 * This is the model class for table "vcos_port_detail_language".
 *
 * The followings are the available columns in table 'vcos_port_detail_language':
 * @property string $id
 * @property string $detail_id
 * @property string $iso
 * @property string $detail
 */
class VcosPortDetailLanguage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosPortDetailLanguage the static model class
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
		return 'vcos_port_detail_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('detail_id, iso, detail', 'required'),
			array('detail_id', 'length', 'max'=>10),
			array('iso', 'length', 'max'=>60),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, detail_id, iso, detail', 'safe', 'on'=>'search'),
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
			'detail_id' => 'Detail',
			'iso' => 'Iso',
			'detail' => 'Detail',
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
		$criteria->compare('detail_id',$this->detail_id,true);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('detail',$this->detail,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}