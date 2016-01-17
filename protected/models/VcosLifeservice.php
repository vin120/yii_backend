<?php

/**
 * This is the model class for table "vcos_lifeservice".
 *
 * The followings are the available columns in table 'vcos_lifeservice':
 * @property string $ls_id
 * @property string $ls_category
 * @property string $ls_price
 * @property string $ls_img_url
 * @property string $ls_tel
 * @property integer $ls_state
 */
class VcosLifeservice extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosLifeservice the static model class
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
		return 'vcos_lifeservice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ls_category, ls_img_url, ls_tel', 'required'),
			array('ls_state', 'numerical', 'integerOnly'=>true),
			array('ls_category, ls_price', 'length', 'max'=>10),
			array('ls_img_url, ls_tel', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ls_id, ls_category, ls_price, ls_img_url, ls_tel, ls_state', 'safe', 'on'=>'search'),
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
			'ls_id' => 'Ls',
			'ls_category' => 'Ls Category',
			'ls_price' => 'Ls Price',
			'ls_img_url' => 'Ls Img Url',
			'ls_tel' => 'Ls Tel',
			'ls_state' => 'Ls State',
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

		$criteria->compare('ls_id',$this->ls_id,true);
		$criteria->compare('ls_category',$this->ls_category,true);
		$criteria->compare('ls_price',$this->ls_price,true);
		$criteria->compare('ls_img_url',$this->ls_img_url,true);
		$criteria->compare('ls_tel',$this->ls_tel,true);
		$criteria->compare('ls_state',$this->ls_state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}