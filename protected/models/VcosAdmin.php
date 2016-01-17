<?php 
/**
 * This is the model class for table "vcos_admin".
 *
 * The followings are the available columns in table 'vcos_admin':
 * @property string $admin_id
 * @property string $admin_name
 * @property string $admin_real_name
 * @property string $admin_password
 * @property string $role_id
 * @property string $last_login_ip
 * @property string $last_login_time
 * @property string $admin_email
 * @property integer $admin_state
 * @property integer $is_login
 */
 class VcosAdmin extends MyCActiveRecord
 {
 	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosAdmin the static model class
	 */
 	public static function model($className = __CLASS__)
 	{
 		return parent::model($className);
 	}

 	/**
	 * @return string the associated database table name
	 */
 	public function tableName()
 	{
 		return 'vcos_admin';
 	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		//NOTE: you should only define rules for those attributes that will receive user inputs.
		return array(
			array('admin_name,admin_real_name,admin_password,role_id,last_login_ip,last_login_time,admin_email','required'),
			array('admin_state,is_login','numerical','integerOnly'=>true),
			array('admin_name,admin_real_name,admin_password,last_login_ip,admin_email','length','max'=>255),
			array('role_id','length','max'=>10),
			array('admin_id,admin_name,admin_real_name,admin_password,role_id,last_login_ip,last_login_time,admin_email,admin_state,is_login','safe','on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'admin_id'=>'Admin',
			'admin_name'=>'Admin Name',
			'admin_real_name'=>'Admin Real Name',
			'admin_password' => 'Admin Password',
			'role_id'=>'Role',
			'last_login_ip'=>'Last Login Ip',
			'last_login_time'=>'Last Login Time',
			'admin_email'=>'Admin Email',
			'admin_state'=>'Admin State',
			'is_login'=>'Is Login',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('admin_id',$this->admin_id,true);
		$criteria->compare('admin_name',$this->admin_name,true);
		$criteria->compare('admin_real_name',$this->admin_real_name,true);
		$criteria->compare('admin_password',$this->admin_password,true);
		$criteria->compare('role_id',$this->role_id,true);
		$criteria->compare('last_login_ip',$this->last_login_ip,true);
		$criteria->compare('last_login_time',$this->last_login_time,true);
		$criteria->compare('admin_email',$this->admin_email,true);
		$criteria->compare('admin_state',$this->admin_state);
		$criteria->compare('is_login',$this->is_login);

		return new CActiveDataProvider(get_class($this),array(
			'criteria'=>$criteria,
		));
	}
 }