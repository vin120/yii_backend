<?php

/**
 * This is the model class for table "vcos_net_communication_category".
 *
 * The followings are the available columns in table 'vcos_net_communication_category':
 * @property integer $id
 * @property string $net_category_name
 * @property string $net_img_url
 * @property string $net_href_url
 * @property string $bg_color
 * @property integer $state
 */
class VcosNetCommunicationCategory extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosNetCommunicationCategory the static model class
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
		return 'vcos_net_communication_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('net_category_name', 'required'),
			array('state', 'numerical', 'integerOnly'=>true),
			array('net_category_name', 'length', 'max'=>50),
			array('net_img_url, net_href_url', 'length', 'max'=>255),
			array('bg_color', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, net_category_name, net_img_url, net_href_url, bg_color, state', 'safe', 'on'=>'search'),
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
			'net_category_name' => 'Net Category Name',
			'net_img_url' => 'Net Img Url',
			'net_href_url' => 'Net Href Url',
			'bg_color' => 'Bg Color',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('net_category_name',$this->net_category_name,true);
		$criteria->compare('net_img_url',$this->net_img_url,true);
		$criteria->compare('net_href_url',$this->net_href_url,true);
		$criteria->compare('bg_color',$this->bg_color,true);
		$criteria->compare('state',$this->state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}