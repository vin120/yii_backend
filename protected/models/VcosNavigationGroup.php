<?php

/**
 * This is the model class for table "vcos_navigation_group".
 *
 * The followings are the available columns in table 'vcos_navigation_group':
 * @property integer $navigation_group_id
 * @property integer $navigation_id
 * @property string $navigation_group_name
 * @property integer $sort_order
 * @property integer $show_type
 * @property integer $status
 * @property integer $activity_id
 * @property string $img_url
 */
class VcosNavigationGroup extends PrCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosNavigationGroup the static model class
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
		return 'vcos_navigation_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('navigation_id, sort_order, show_type, status, activity_id', 'numerical', 'integerOnly'=>true),
			array('navigation_group_name', 'length', 'max'=>64),
			array('img_url', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('navigation_group_id, navigation_id, navigation_group_name, sort_order, show_type, status, activity_id, img_url', 'safe', 'on'=>'search'),
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
			'navigation_group_id' => 'Navigation Group',
			'navigation_id' => 'Navigation',
			'navigation_group_name' => 'Navigation Group Name',
			'sort_order' => 'Sort Order',
			'show_type' => 'Show Type',
			'status' => 'Status',
			'activity_id' => 'Activity',
			'img_url' => 'Img Url',
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

		$criteria->compare('navigation_group_id',$this->navigation_group_id);
		$criteria->compare('navigation_id',$this->navigation_id);
		$criteria->compare('navigation_group_name',$this->navigation_group_name,true);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('show_type',$this->show_type);
		$criteria->compare('status',$this->status);
		$criteria->compare('activity_id',$this->activity_id);
		$criteria->compare('img_url',$this->img_url,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}