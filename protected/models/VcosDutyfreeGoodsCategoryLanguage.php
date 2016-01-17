<?php

/**
 * This is the model class for table "vcos_dutyfree_goods_category_language".
 *
 * The followings are the available columns in table 'vcos_dutyfree_goods_category_language':
 * @property string $id
 * @property string $gc_id
 * @property string $iso
 * @property string $gc_name
 */
class VcosDutyfreeGoodsCategoryLanguage extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosDutyfreeGoodsCategoryLanguage the static model class
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
		return 'vcos_dutyfree_goods_category_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gc_id, iso, gc_name', 'required'),
			array('gc_id', 'length', 'max'=>10),
			array('iso', 'length', 'max'=>60),
			array('gc_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, gc_id, iso, gc_name', 'safe', 'on'=>'search'),
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
			'gc_id' => 'Gc',
			'iso' => 'Iso',
			'gc_name' => 'Gc Name',
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
		$criteria->compare('gc_id',$this->gc_id,true);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('gc_name',$this->gc_name,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}