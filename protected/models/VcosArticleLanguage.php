<?php

/**
 * This is the model class for table "vcos_article_language".
 *
 * The followings are the available columns in table 'vcos_article_language':
 * @property string $id
 * @property string $article_id
 * @property string $iso
 * @property string $article_title
 * @property string $article_content
 * @property string $article_abstract
 */
class VcosArticleLanguage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosArticleLanguage the static model class
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
		return 'vcos_article_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('article_id, iso, article_title, article_content, article_abstract', 'required'),
			array('article_id', 'length', 'max'=>10),
			array('iso', 'length', 'max'=>60),
			array('article_title, article_abstract', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, article_id, iso, article_title, article_content, article_abstract', 'safe', 'on'=>'search'),
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
			'article_id' => 'Article',
			'iso' => 'Iso',
			'article_title' => 'Article Title',
			'article_content' => 'Article Content',
			'article_abstract' => 'Article Abstract',
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
		$criteria->compare('article_id',$this->article_id,true);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('article_title',$this->article_title,true);
		$criteria->compare('article_content',$this->article_content,true);
		$criteria->compare('article_abstract',$this->article_abstract,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}