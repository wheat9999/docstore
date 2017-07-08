<?php
class DocInputManager
{
	public  function  saveInput($field_id,$value,$property_id,$type_id,$record_id)
	{


		$account = Yii::app()->user->getAccount();

		$mode = new DocInput();


		$mode->value = $value;
		$mode->field_id = $field_id;
		$mode->property_id = $property_id;
		$mode->type_id = $type_id;
		$mode->user_id = $account->id;
		$mode->record_id = $record_id;

		$mode->create_time = date("Y-m-d H:i:s");
		$mode->save();

	}

	public  function  getNextSeri($field_id,$field_value)
	{
		$sql = "select * from docinput  where field_id =:field_id order by id desc limit 0,1";
		$model=Yii::app()->db->createCommand($sql);
		$model->bindValue(':field_id', $field_id);

		$list = $model->queryAll();

		if(count($list) == 0)
		{
			return $field_value;
		}

		else
		{
			$maxItem = $list[0]["value"];

			$intFormate = intval($maxItem)+1;

			$len = strlen($field_value);

			return sprintf("%0".$len."d",$intFormate);
		}


	}


}