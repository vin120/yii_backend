<?php

/**
 * This is the model class for table "vcos_member".
 *
 * The followings are the available columns in table 'vcos_member':
 * @property string $member_id
 * @property string $smart_card_number
 * @property string $member_code
 * @property string $member_name
 * @property string $member_email
 * @property string $member_password
 * @property string $cn_name
 * @property string $last_name
 * @property string $first_name
 * @property string $sex
 * @property integer $date_of_birth
 * @property string $birth_place
 * @property string $nationality
 * @property string $country_code
 * @property string $nation_code
 * @property string $mobile_number
 * @property string $fixed_telephone
 * @property integer $email_verification
 * @property integer $mobile_verification
 * @property integer $member_level
 * @property double $member_money
 * @property integer $member_credit
 * @property integer $member_verification
 * @property string $passport_number
 * @property integer $passport_date_issue
 * @property string $passport_place_issue
 * @property string $passport_issue_country_code
 * @property integer $passport_expiry_date
 * @property string $resident_id_card
 * @property string $id_card_issuing_authority
 * @property string $id_card_address
 * @property integer $id_card_start_date
 * @property integer $id_card_expiry_date
 * @property integer $reg_time
 * @property string $reg_ip
 * @property string $create_by
 * @property integer $create_time
 */
class Membership extends MyCActiveRecord
{
    public $dbname='db';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vcos_member';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date_of_birth, email_verification, mobile_verification, member_level, member_credit, member_verification, passport_date_issue, passport_expiry_date, id_card_start_date, id_card_expiry_date, reg_time, create_time', 'numerical', 'integerOnly'=>true),
			array('member_money', 'numerical'),
			array('smart_card_number, member_name', 'length', 'max'=>50),
			array('member_code, resident_id_card, create_by', 'length', 'max'=>32),
			array('member_email, member_password, cn_name, last_name, first_name, passport_place_issue, id_card_issuing_authority, id_card_address, reg_ip', 'length', 'max'=>100),
			array('sex', 'length', 'max'=>1),
			array('birth_place', 'length', 'max'=>250),
			array('nationality', 'length', 'max'=>150),
			array('country_code', 'length', 'max'=>16),
			array('nation_code, mobile_number, fixed_telephone, passport_number', 'length', 'max'=>20),
			array('passport_issue_country_code', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('member_id, smart_card_number, member_code, member_name, member_email, member_password, cn_name, last_name, first_name, sex, date_of_birth, birth_place, nationality, country_code, nation_code, mobile_number, fixed_telephone, email_verification, mobile_verification, member_level, member_money, member_credit, member_verification, passport_number, passport_date_issue, passport_place_issue, passport_issue_country_code, passport_expiry_date, resident_id_card, id_card_issuing_authority, id_card_address, id_card_start_date, id_card_expiry_date, reg_time, reg_ip, create_by, create_time', 'safe', 'on'=>'search'),
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
			'member_id' => '会员id',
			'smart_card_number' => '智能卡号',
			'member_code' => '会员号',
			'member_name' => '会员名',
			'member_email' => '会员邮箱',
			'member_password' => '密码',
			'cn_name' => 'Cn Name',
			'last_name' => '姓',
			'first_name' => '名',
			'sex' => '性别：1男，2女',
			'date_of_birth' => '出生日期',
			'birth_place' => '出生地',
			'nationality' => '国籍(弃用)',
			'country_code' => '国籍代号',
			'nation_code' => '民族code',
			'mobile_number' => '手机',
			'fixed_telephone' => '固定电话',
			'email_verification' => '邮箱验证，默认0未验证，1验证',
			'mobile_verification' => '手机验证0未验证，1验证',
			'member_level' => '会员等级，默认0',
			'member_money' => '会员金额',
			'member_credit' => '会员积分',
			'member_verification' => '会员激活，0默认未激活，1激活,2冻结',
			'passport_number' => '护照号',
			'passport_date_issue' => '签发日期',
			'passport_place_issue' => '签发地',
			'passport_issue_country_code' => '护照发行国',
			'passport_expiry_date' => '护照到期时间',
			'resident_id_card' => '居民身份证',
			'id_card_issuing_authority' => '身份证签发机关',
			'id_card_address' => '身份证住址',
			'id_card_start_date' => '身份证开始日期',
			'id_card_expiry_date' => '身份证截止日期',
			'reg_time' => '注册时间',
			'reg_ip' => '注册ip,可兼容ipv6',
			'create_by' => '创建人',
			'create_time' => '创建时间',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('smart_card_number',$this->smart_card_number,true);
		$criteria->compare('member_code',$this->member_code,true);
		$criteria->compare('member_name',$this->member_name,true);
		$criteria->compare('member_email',$this->member_email,true);
		$criteria->compare('member_password',$this->member_password,true);
		$criteria->compare('cn_name',$this->cn_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('sex',$this->sex,true);
		$criteria->compare('date_of_birth',$this->date_of_birth);
		$criteria->compare('birth_place',$this->birth_place,true);
		$criteria->compare('nationality',$this->nationality,true);
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('nation_code',$this->nation_code,true);
		$criteria->compare('mobile_number',$this->mobile_number,true);
		$criteria->compare('fixed_telephone',$this->fixed_telephone,true);
		$criteria->compare('email_verification',$this->email_verification);
		$criteria->compare('mobile_verification',$this->mobile_verification);
		$criteria->compare('member_level',$this->member_level);
		$criteria->compare('member_money',$this->member_money);
		$criteria->compare('member_credit',$this->member_credit);
		$criteria->compare('member_verification',$this->member_verification);
		$criteria->compare('passport_number',$this->passport_number,true);
		$criteria->compare('passport_date_issue',$this->passport_date_issue);
		$criteria->compare('passport_place_issue',$this->passport_place_issue,true);
		$criteria->compare('passport_issue_country_code',$this->passport_issue_country_code,true);
		$criteria->compare('passport_expiry_date',$this->passport_expiry_date);
		$criteria->compare('resident_id_card',$this->resident_id_card,true);
		$criteria->compare('id_card_issuing_authority',$this->id_card_issuing_authority,true);
		$criteria->compare('id_card_address',$this->id_card_address,true);
		$criteria->compare('id_card_start_date',$this->id_card_start_date);
		$criteria->compare('id_card_expiry_date',$this->id_card_expiry_date);
		$criteria->compare('reg_time',$this->reg_time);
		$criteria->compare('reg_ip',$this->reg_ip,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('create_time',$this->create_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Membership the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
