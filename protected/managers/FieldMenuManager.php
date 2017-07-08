<?php
class FieldMenuManager
{
	public function getFieldMenuList($field_id)
	{
		$account = Yii::app()->user->getAccount();

		$sql = "select * from docfieldmenu  where field_id =:field_id";
		$model=Yii::app()->db->createCommand($sql);
		$model->bindValue(':field_id', $field_id);

		return $model->queryAll();
	}
	
	public function addFieldMenus($field_id,$menus)
	{
		$options = explode('$',$menus);
		foreach($options as $option)
		{
			$keyvalue = explode(',',$option);

			$key = $keyvalue[0];

			$value = $keyvalue[1];

            $fieldMenu = new DocFieldMenu();
			$fieldMenu->field_id = $field_id;

			$fieldMenu->key = $key;
			$fieldMenu->value = $value;
			$fieldMenu->save();

		}


	}

}