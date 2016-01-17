<?php

/**
 * This is the model class for table "vcos_ad".
 *
 * The followings are the available columns in table 'vcos_ad':
 * @property string $ad_id
 * @property string $ad_img_url
 * @property integer $ad_position
 * @property integer $ad_state
 * @property integer $link_type
 */
class VcosAd extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosAd the static model class
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
		return 'vcos_ad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ad_position, ad_state, link_type', 'numerical', 'integerOnly'=>true),
			array('ad_img_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ad_id, ad_img_url, ad_position, ad_state, link_type', 'safe', 'on'=>'search'),
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
			'ad_id' => 'Ad',
			'ad_img_url' => 'Ad Img Url',
			'ad_position' => 'Ad Position',
			'ad_state' => 'Ad State',
			'link_type' => 'Link Type',
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

		$criteria->compare('ad_id',$this->ad_id,true);
		$criteria->compare('ad_img_url',$this->ad_img_url,true);
		$criteria->compare('ad_position',$this->ad_position);
		$criteria->compare('ad_state',$this->ad_state);
		$criteria->compare('link_type',$this->link_type);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}