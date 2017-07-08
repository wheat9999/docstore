<?php

class DocFieldMenu extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'docfieldmenu';
	}
	
   public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}