<?php

/**
 * This is the model class for table "vcos_lifeservice_img".
 *
 * The followings are the available columns in table 'vcos_lifeservice_img':
 * @property string $id
 * @property integer $lifeservice_id
 * @property string $img_url
 * @property string $iso
 * @property integer $state
 */
class VcosLifeserviceImg extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosLifeserviceImg the static model class
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
		return 'vcos_lifeservice_img';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lifeservice_id, state', 'numerical', 'integerOnly'=>true),
			array('img_url', 'length', 'max'=>255),
			array('iso', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, lifeservice_id, img_url, iso, state', 'safe', 'on'=>'search'),
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
			'lifeservice_id' => 'Lifeservice',
			'img_url' => 'Img Url',
			'iso' => 'Iso',
			'state' => 'State',
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
		$criteria->compare('lifeservice_id',$this->lifeservice_id);
		$criteria->compare('img_url',$this->img_url,true);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('state',$this->state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}