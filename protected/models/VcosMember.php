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
 * @property string $passport_date_issue
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
 * @property integer $is_online_booking
 */
class VcosMember extends CActiveRecord
{
    public $dbname='db';
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosMember the static model class
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
			array('date_of_birth, email_verification, mobile_verification, member_level, member_credit, member_verification, passport_expiry_date, id_card_start_date, id_card_expiry_date, reg_time, create_time, is_online_booking', 'numerical', 'integerOnly'=>true),
			array('member_money', 'numerical'),
			array('smart_card_number, member_name', 'length', 'max'=>50),
			array('member_code, resident_id_card, create_by', 'length', 'max'=>32),
			array('member_email, member_password, cn_name, last_name, first_name, passport_place_issue, id_card_issuing_authority, id_card_address, reg_ip', 'length', 'max'=>100),
			array('sex', 'length', 'max'=>1),
			array('birth_place', 'length', 'max'=>250),
			array('nationality', 'length', 'max'=>150),
			array('country_code', 'length', 'max'=>16),
			array('nation_code', 'length', 'max'=>2),
			array('mobile_number, fixed_telephone, passport_number', 'length', 'max'=>20),
			array('passport_date_issue', 'length', 'max'=>11),
			array('passport_issue_country_code', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('member_id, smart_card_number, member_code, member_name, member_email, member_password, cn_name, last_name, first_name, sex, date_of_birth, birth_place, nationality, country_code, nation_code, mobile_number, fixed_telephone, email_verification, mobile_verification, member_level, member_money, member_credit, member_verification, passport_number, passport_date_issue, passport_place_issue, passport_issue_country_code, passport_expiry_date, resident_id_card, id_card_issuing_authority, id_card_address, id_card_start_date, id_card_expiry_date, reg_time, reg_ip, create_by, create_time, is_online_booking', 'safe', 'on'=>'search'),
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
			'member_id' => 'Member',
			'smart_card_number' => 'Smart Card Number',
			'member_code' => 'Member Code',
			'member_name' => 'Member Name',
			'member_email' => 'Member Email',
			'member_password' => 'Member Password',
			'cn_name' => 'Cn Name',
			'last_name' => 'Last Name',
			'first_name' => 'First Name',
			'sex' => 'Sex',
			'date_of_birth' => 'Date Of Birth',
			'birth_place' => 'Birth Place',
			'nationality' => 'Nationality',
			'country_code' => 'Country Code',
			'nation_code' => 'Nation Code',
			'mobile_number' => 'Mobile Number',
			'fixed_telephone' => 'Fixed Telephone',
			'email_verification' => 'Email Verification',
			'mobile_verification' => 'Mobile Verification',
			'member_level' => 'Member Level',
			'member_money' => 'Member Money',
			'member_credit' => 'Member Credit',
			'member_verification' => 'Member Verification',
			'passport_number' => 'Passport Number',
			'passport_date_issue' => 'Passport Date Issue',
			'passport_place_issue' => 'Passport Place Issue',
			'passport_issue_country_code' => 'Passport Issue Country Code',
			'passport_expiry_date' => 'Passport Expiry Date',
			'resident_id_card' => 'Resident Id Card',
			'id_card_issuing_authority' => 'Id Card Issuing Authority',
			'id_card_address' => 'Id Card Address',
			'id_card_start_date' => 'Id Card Start Date',
			'id_card_expiry_date' => 'Id Card Expiry Date',
			'reg_time' => 'Reg Time',
			'reg_ip' => 'Reg Ip',
			'create_by' => 'Create By',
			'create_time' => 'Create Time',
			'is_online_booking' => 'Is Online Booking',
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
		$criteria->compare('passport_date_issue',$this->passport_date_issue,true);
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
		$criteria->compare('is_online_booking',$this->is_online_booking);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}