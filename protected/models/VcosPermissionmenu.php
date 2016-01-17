<?php

/**
 * This is the model class for table "vcos_permission_menu".
 *
 * The followings are the available columns in table 'vcos_permission_menu':
 * @property string $menu_id
 * @property string $role_name
 * @property string $parent_menu_id
 * @property string $moudle_name
 * @property string $controller_name
 * @property string $method_name
 * @property string $list_order
 * @property integer $permission_state
 */
class Vcospermissionmenu extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Vcospermissionmenu the static model class
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
		return 'vcos_permission_menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_name, parent_menu_id, controller_name, permission_state', 'required'),
			array('permission_state', 'numerical', 'integerOnly'=>true),
			array('role_name, parent_menu_id, moudle_name, controller_name, method_name', 'length', 'max'=>255),
			array('list_order', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('menu_id, role_name, parent_menu_id, moudle_name, controller_name, method_name, list_order, permission_state', 'safe', 'on'=>'search'),
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
			'menu_id' => 'Menu',
			'role_name' => 'Role Name',
			'parent_menu_id' => 'Parent Menu',
			'moudle_name' => 'Moudle Name',
			'controller_name' => 'Controller Name',
			'method_name' => 'Method Name',
			'list_order' => 'List Order',
			'permission_state' => 'Permission State',
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

		$criteria->compare('menu_id',$this->menu_id,true);
		$criteria->compare('role_name',$this->role_name,true);
		$criteria->compare('parent_menu_id',$this->parent_menu_id,true);
		$criteria->compare('moudle_name',$this->moudle_name,true);
		$criteria->compare('controller_name',$this->controller_name,true);
		$criteria->compare('method_name',$this->method_name,true);
		$criteria->compare('list_order',$this->list_order,true);
		$criteria->compare('permission_state',$this->permission_state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}