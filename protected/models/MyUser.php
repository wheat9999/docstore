<?php

class MyUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}
	
   public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}