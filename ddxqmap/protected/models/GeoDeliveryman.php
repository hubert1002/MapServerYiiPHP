<?php

/**
 * This is the model class for table "tbl_geo_deliveryman".
 *
 * The followings are the available columns in table 'tbl_geo_deliveryman':
 * @property integer $id
 * @property string $user_id
 * @property double $lat
 * @property double $lon
 * @property double $amend_lat
 * @property double $amend_lon
 * @property integer $acc
 * @property integer $time
 */
class GeoDeliveryman extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_geo_deliveryman';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, lat, lon, amend_lat, amend_lon, acc, time', 'required'),
			array('acc, time', 'numerical', 'integerOnly'=>true),
			array('lat, lon, amend_lat, amend_lon', 'numerical'),
			array('user_id', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, lat, lon, amend_lat, amend_lon, acc, time', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'lat' => 'Lat',
			'lon' => 'Lon',
			'amend_lat' => 'Amend Lat',
			'amend_lon' => 'Amend Lon',
			'acc' => 'Acc',
			'time' => 'Time',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('lat',$this->lat);
		$criteria->compare('lon',$this->lon);
		$criteria->compare('amend_lat',$this->amend_lat);
		$criteria->compare('amend_lon',$this->amend_lon);
		$criteria->compare('acc',$this->acc);
		$criteria->compare('time',$this->time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GeoDeliveryman the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
