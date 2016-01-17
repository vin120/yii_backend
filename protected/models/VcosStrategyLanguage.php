<?php

/**
 * This is the model class for table "vcos_strategy_language".
 *
 * The followings are the available columns in table 'vcos_strategy_language':
 * @property integer $id
 * @property integer $strategy_id
 * @property string $strategy_name
 * @property string $strategy_describe
 * @property integer $show_style
 * @property string $img_url
 * @property string $img_url2
 * @property string $img_url3
 * @property integer $avg_price
 * @property string $address
 * @property string $strategy_type
 * @property string $telphone
 * @property string $strategy_feature
 * @property string $strategy_details
 * @property string $iso
 */
class VcosStrategyLanguage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosStrategyLanguage the static model class
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
		return 'vcos_strategy_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('strategy_id, show_style, avg_price', 'numerical', 'integerOnly'=>true),
			array('strategy_name, strategy_type', 'length', 'max'=>100),
			array('strategy_describe, img_url, img_url2, img_url3, address, strategy_feature', 'length', 'max'=>255),
			array('telphone', 'length', 'max'=>20),
			array('iso', 'length', 'max'=>10),
			array('strategy_details', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, strategy_id, strategy_name, strategy_describe, show_style, img_url, img_url2, img_url3, avg_price, address, strategy_type, telphone, strategy_feature, strategy_details, iso', 'safe', 'on'=>'search'),
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
			'strategy_id' => 'Strategy',
			'strategy_name' => 'Strategy Name',
			'strategy_describe' => 'Strategy Describe',
			'show_style' => 'Show Style',
			'img_url' => 'Img Url',
			'img_url2' => 'Img Url2',
			'img_url3' => 'Img Url3',
			'avg_price' => 'Avg Price',
			'address' => 'Address',
			'strategy_type' => 'Strategy Type',
			'telphone' => 'Telphone',
			'strategy_feature' => 'Strategy Feature',
			'strategy_details' => 'Strategy Details',
			'iso' => 'Iso',
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
		$criteria->compare('strategy_id',$this->strategy_id);
		$criteria->compare('strategy_name',$this->strategy_name,true);
		$criteria->compare('strategy_describe',$this->strategy_describe,true);
		$criteria->compare('show_style',$this->show_style);
		$criteria->compare('img_url',$this->img_url,true);
		$criteria->compare('img_url2',$this->img_url2,true);
		$criteria->compare('img_url3',$this->img_url3,true);
		$criteria->compare('avg_price',$this->avg_price);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('strategy_type',$this->strategy_type,true);
		$criteria->compare('telphone',$this->telphone,true);
		$criteria->compare('strategy_feature',$this->strategy_feature,true);
		$criteria->compare('strategy_details',$this->strategy_details,true);
		$criteria->compare('iso',$this->iso,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}