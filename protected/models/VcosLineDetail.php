<?php

/**
 * This is the model class for table "vcos_line_detail".
 *
 * The followings are the available columns in table 'vcos_line_detail':
 * @property string $detail_id
 * @property string $line_id
 * @property integer $sequence
 * @property string $img_url
 * @property integer $detail_state
 */
class VcosLineDetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosLineDetail the static model class
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
		return 'vcos_line_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('line_id, sequence, detail_state', 'required'),
			array('sequence, detail_state', 'numerical', 'integerOnly'=>true),
			array('line_id', 'length', 'max'=>10),
			array('img_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('detail_id, line_id, sequence, img_url, detail_state', 'safe', 'on'=>'search'),
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
			'detail_id' => 'Detail',
			'line_id' => 'Line',
			'sequence' => 'Sequence',
			'img_url' => 'Img Url',
			'detail_state' => 'Detail State',
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

		$criteria->compare('detail_id',$this->detail_id,true);
		$criteria->compare('line_id',$this->line_id,true);
		$criteria->compare('sequence',$this->sequence);
		$criteria->compare('img_url',$this->img_url,true);
		$criteria->compare('detail_state',$this->detail_state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}