<?php

class DocField extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'docfield';
	}
	
   public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}