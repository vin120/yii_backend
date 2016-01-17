<?php

/**
 * This is the model class for table "vcos_notice_to_visitors_language".
 *
 * The followings are the available columns in table 'vcos_notice_to_visitors_language':
 * @property integer $id
 * @property integer $n_id
 * @property string $iso
 * @property string $img_url
 * @property string $content
 */
class VcosNoticeToVisitorsLanguage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosNoticeToVisitorsLanguage the static model class
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
		return 'vcos_notice_to_visitors_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('n_id', 'numerical', 'integerOnly'=>true),
			array('iso, img_url', 'length', 'max'=>255),
			array('content', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, n_id, iso, img_url, content', 'safe', 'on'=>'search'),
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
			'n_id' => 'N',
			'iso' => 'Iso',
			'img_url' => 'Img Url',
			'content' => 'Content',
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
		$criteria->compare('n_id',$this->n_id);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('img_url',$this->img_url,true);
		$criteria->compare('content',$this->content,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}