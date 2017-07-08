<?php

class DocInput extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'docinput';
	}
	
   public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}