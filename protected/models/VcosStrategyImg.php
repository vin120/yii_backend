<?php

/**
 * This is the model class for table "vcos_strategy_img".
 *
 * The followings are the available columns in table 'vcos_strategy_img':
 * @property string $id
 * @property integer $strategy_id
 * @property string $img_url
 * @property string $iso
 * @property integer $state
 * @property string $img_desc
 */
class VcosStrategyImg extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosStrategyImg the static model class
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
		return 'vcos_strategy_img';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('strategy_id, state', 'numerical', 'integerOnly'=>true),
			array('img_url', 'length', 'max'=>255),
			array('iso', 'length', 'max'=>10),
			array('img_desc', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, strategy_id, img_url, iso, state, img_desc', 'safe', 'on'=>'search'),
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
			'img_url' => 'Img Url',
			'iso' => 'Iso',
			'state' => 'State',
			'img_desc' => 'Img Desc',
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
		$criteria->compare('strategy_id',$this->strategy_id);
		$criteria->compare('img_url',$this->img_url,true);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('img_desc',$this->img_desc,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}