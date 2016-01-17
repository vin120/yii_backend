<?php

/**
 * This is the model class for table "vcos_goods_order".
 *
 * The followings are the available columns in table 'vcos_goods_order':
 * @property string $order_id
 * @property string $order_serial_num
 * @property integer $membership_id
 * @property integer $totale_price
 * @property integer $pay_type
 * @property string $order_check_num
 * @property string $pay_time
 * @property string $order_create_time
 * @property integer $order_state
 * @property string $order_remark
 * @property integer $is_read
 */
class VcosGoodsOrder extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VcosGoodsOrder the static model class
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
		return 'vcos_goods_order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('membership_id, totale_price, pay_type, order_state, is_read', 'numerical', 'integerOnly'=>true),
			array('order_serial_num, order_check_num', 'length', 'max'=>32),
			array('order_remark', 'length', 'max'=>100),
			array('pay_time, order_create_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('order_id, order_serial_num, membership_id, totale_price, pay_type, order_check_num, pay_time, order_create_time, order_state, order_remark, is_read', 'safe', 'on'=>'search'),
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
			'order_id' => 'Order',
			'order_serial_num' => 'Order Serial Num',
			'membership_id' => 'Membership',
			'totale_price' => 'Totale Price',
			'pay_type' => 'Pay Type',
			'order_check_num' => 'Order Check Num',
			'pay_time' => 'Pay Time',
			'order_create_time' => 'Order Create Time',
			'order_state' => 'Order State',
			'order_remark' => 'Order Remark',
			'is_read' => 'Is Read',
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

		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('order_serial_num',$this->order_serial_num,true);
		$criteria->compare('membership_id',$this->membership_id);
		$criteria->compare('totale_price',$this->totale_price);
		$criteria->compare('pay_type',$this->pay_type);
		$criteria->compare('order_check_num',$this->order_check_num,true);
		$criteria->compare('pay_time',$this->pay_time,true);
		$criteria->compare('order_create_time',$this->order_create_time,true);
		$criteria->compare('order_state',$this->order_state);
		$criteria->compare('order_remark',$this->order_remark,true);
		$criteria->compare('is_read',$this->is_read);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}