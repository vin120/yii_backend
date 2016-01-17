<?php

/**
 * This is the model class for table "vcos_commentandhelp_category".
 *
 * The followings are the available columns in table 'vcos_commentandhelp_category':
 * @property string $id
 * @property string $cnh_category_name
 * @property string $cnh_img_url
 * @property string $cnh_herf_url
 * @property string $bg_color
 * @property integer $state
 */
class VcosCommentAndHelpCategory extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosCommentAndHelpCategory the static model class
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
		return 'vcos_commentandhelp_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cnh_category_name, cnh_img_url, cnh_herf_url, bg_color', 'required'),
			array('state', 'numerical', 'integerOnly'=>true),
			array('cnh_category_name', 'length', 'max'=>50),
			array('cnh_img_url, cnh_herf_url', 'length', 'max'=>255),
			array('bg_color', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cnh_category_name, cnh_img_url, cnh_herf_url, bg_color, state', 'safe', 'on'=>'search'),
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
			'cnh_category_name' => 'Cnh Category Name',
			'cnh_img_url' => 'Cnh Img Url',
			'cnh_herf_url' => 'Cnh Herf Url',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('cnh_category_name',$this->cnh_category_name,true);
		$criteria->compare('cnh_img_url',$this->cnh_img_url,true);
		$criteria->compare('cnh_herf_url',$this->cnh_herf_url,true);
		$criteria->compare('bg_color',$this->bg_color,true);
		$criteria->compare('state',$this->state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}