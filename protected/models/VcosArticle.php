<?php

/**
 * This is the model class for table "vcos_article".
 *
 * The followings are the available columns in table 'vcos_article':
 * @property string $article_id
 * @property string $article_time
 * @property string $article_start_time
 * @property string $article_end_time
 * @property integer $article_state
 * @property string $article_img_url
 * @property integer $article_type
 */
class VcosArticle extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosArticle the static model class
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
		return 'vcos_article';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('article_time, article_start_time, article_end_time, article_img_url', 'required'),
			array('article_state, article_type', 'numerical', 'integerOnly'=>true),
			array('article_img_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('article_id, article_time, article_start_time, article_end_time, article_state, article_img_url, article_type', 'safe', 'on'=>'search'),
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
			'article_id' => 'Article',
			'article_time' => 'Article Time',
			'article_start_time' => 'Article Start Time',
			'article_end_time' => 'Article End Time',
			'article_state' => 'Article State',
			'article_img_url' => 'Article Img Url',
			'article_type' => 'Article Type',
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

		$criteria->compare('article_id',$this->article_id,true);
		$criteria->compare('article_time',$this->article_time,true);
		$criteria->compare('article_start_time',$this->article_start_time,true);
		$criteria->compare('article_end_time',$this->article_end_time,true);
		$criteria->compare('article_state',$this->article_state);
		$criteria->compare('article_img_url',$this->article_img_url,true);
		$criteria->compare('article_type',$this->article_type);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}