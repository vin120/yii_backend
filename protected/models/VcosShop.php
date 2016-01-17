<?php

/**
 * This is the model class for table "vcos_shop".
 *
 * The followings are the available columns in table 'vcos_shop':
 * @property string $shop_id
 * @property string $shop_code
 * @property string $shop_title
 * @property string $shop_logo
 * @property string $shop_desc
 * @property string $legal_representative
 * @property string $company_name
 * @property string $shop_address
 * @property integer $cash_deposit
 * @property string $main_products
 * @property string $created
 * @property string $business_license
 * @property integer $shop_status
 * @property integer $cruise_id
 * @property string $shop_img_url
 */
class VcosShop extends PrCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosShop the static model class
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
		return 'vcos_shop';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cash_deposit, shop_status, cruise_id', 'numerical', 'integerOnly'=>true),
			array('shop_code', 'length', 'max'=>32),
			array('shop_title, shop_logo, legal_representative, company_name, shop_address, business_license', 'length', 'max'=>100),
			array('shop_desc', 'length', 'max'=>200),
			array('main_products', 'length', 'max'=>255),
			array('shop_img_url', 'length', 'max'=>128),
			array('created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('shop_id, shop_code, shop_title, shop_logo, shop_desc, legal_representative, company_name, shop_address, cash_deposit, main_products, created, business_license, shop_status, cruise_id, shop_img_url', 'safe', 'on'=>'search'),
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
			'shop_id' => 'Shop',
			'shop_code' => 'Shop Code',
			'shop_title' => 'Shop Title',
			'shop_logo' => 'Shop Logo',
			'shop_desc' => 'Shop Desc',
			'legal_representative' => 'Legal Representative',
			'company_name' => 'Company Name',
			'shop_address' => 'Shop Address',
			'cash_deposit' => 'Cash Deposit',
			'main_products' => 'Main Products',
			'created' => 'Created',
			'business_license' => 'Business License',
			'shop_status' => 'Shop Status',
			'cruise_id' => 'Cruise',
			'shop_img_url' => 'Shop Img Url',
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

		$criteria->compare('shop_id',$this->shop_id,true);
		$criteria->compare('shop_code',$this->shop_code,true);
		$criteria->compare('shop_title',$this->shop_title,true);
		$criteria->compare('shop_logo',$this->shop_logo,true);
		$criteria->compare('shop_desc',$this->shop_desc,true);
		$criteria->compare('legal_representative',$this->legal_representative,true);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('shop_address',$this->shop_address,true);
		$criteria->compare('cash_deposit',$this->cash_deposit);
		$criteria->compare('main_products',$this->main_products,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('business_license',$this->business_license,true);
		$criteria->compare('shop_status',$this->shop_status);
		$criteria->compare('cruise_id',$this->cruise_id);
		$criteria->compare('shop_img_url',$this->shop_img_url,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}