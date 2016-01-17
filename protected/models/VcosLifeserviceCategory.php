<?php

/**
 * This is the model class for table "vcos_lifeservice_category".
 *
 * The followings are the available columns in table 'vcos_lifeservice_category':
 * @property string $lc_id
 * @property string $lc_img_url
 * @property string $bg_color
 * @property integer $lc_state
 */
class VcosLifeserviceCategory extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosLifeserviceCategory the static model class
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
		return 'vcos_lifeservice_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lc_img_url, bg_color', 'required'),
			array('lc_state', 'numerical', 'integerOnly'=>true),
			array('lc_img_url', 'length', 'max'=>255),
			array('bg_color', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lc_id, lc_img_url, bg_color, lc_state', 'safe', 'on'=>'search'),
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
			'lc_id' => 'Lc',
			'lc_img_url' => 'Lc Img Url',
			'bg_color' => 'Bg Color',
			'lc_state' => 'Lc State',
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

		$criteria->compare('lc_id',$this->lc_id,true);
		$criteria->compare('lc_img_url',$this->lc_img_url,true);
		$criteria->compare('bg_color',$this->bg_color,true);
		$criteria->compare('lc_state',$this->lc_state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}