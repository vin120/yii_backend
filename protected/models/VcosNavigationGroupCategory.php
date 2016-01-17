<?php

/**
 * This is the model class for table "vcos_navigation_group_category".
 *
 * The followings are the available columns in table 'vcos_navigation_group_category':
 * @property string $navigation_group_cid
 * @property integer $navigation_group_id
 * @property string $navigation_category_name
 * @property integer $sort_order
 * @property integer $is_highlight
 * @property integer $category_type
 * @property string $mapping_id
 * @property integer $status
 */
class VcosNavigationGroupCategory extends PrCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosNavigationGroupCategory the static model class
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
		return 'vcos_navigation_group_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('navigation_category_name', 'required'),
			array('navigation_group_id, sort_order, is_highlight, category_type, status', 'numerical', 'integerOnly'=>true),
			array('navigation_category_name', 'length', 'max'=>64),
			array('mapping_id', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('navigation_group_cid, navigation_group_id, navigation_category_name, sort_order, is_highlight, category_type, mapping_id, status', 'safe', 'on'=>'search'),
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
			'navigation_group_cid' => 'Navigation Group Cid',
			'navigation_group_id' => 'Navigation Group',
			'navigation_category_name' => 'Navigation Category Name',
			'sort_order' => 'Sort Order',
			'is_highlight' => 'Is Highlight',
			'category_type' => 'Category Type',
			'mapping_id' => 'Mapping',
			'status' => 'Status',
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

		$criteria->compare('navigation_group_cid',$this->navigation_group_cid,true);
		$criteria->compare('navigation_group_id',$this->navigation_group_id);
		$criteria->compare('navigation_category_name',$this->navigation_category_name,true);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('is_highlight',$this->is_highlight);
		$criteria->compare('category_type',$this->category_type);
		$criteria->compare('mapping_id',$this->mapping_id,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}