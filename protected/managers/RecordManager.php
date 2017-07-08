<?php
class RecordManager
{
	public  function  saveRecord($typeId,$input)
	{
		$docType = DocType::model()->findByPk($typeId);
		$rule = $docType->rule;

		$keyValueArray = array();
		$keyValueList = explode("#&#",$input);

		foreach($keyValueList as $kv)
		{
			$itemArray = explode("$&$",$kv);

			$keyValueArray[$itemArray[0]] = $itemArray[1];
		}

		$inputManager = new DocInputManager();

		$fieldProList = array();


		foreach($keyValueArray as $key=>$value)
		{
			$field = DocField::model()->findByPk($key);

			$proId = $field->property_id;

			$fieldProList[$key] = $proId;

			if($value == '#*#')
			{
			  $value =	$inputManager->getNextSeri($key,$field->value);
				$keyValueArray[$key] = $value;

			}


			$rule = str_replace("{P$proId}",$value,$rule);
		}


		$rule = str_replace("{T}",$docType->code,$rule);


		$matches = array();
		preg_match("{\{S(.+)\}}", $rule, $matches);
		$rep = $matches[0];

		$rule = str_replace($rep,"",$rule);





		//添加record
		$account = Yii::app()->user->getAccount();

		$mode = new Record();
		$mode->record = $rule;

		$mode->type_id = $typeId;
		$mode->corp_id = $account->corp_id;
		$mode->user_id = $account->id;

		$mode->create_time = date("Y-m-d H:i:s");
		$mode->save();

		//添加版本
		$revisionManager = new RevisionManager();
		$revision = $revisionManager->saveRevision($typeId,$mode->id);

		//修改版本
//        $rule = str_replace($rep,$revision->revision,$rule);
//
//		$mode->updateByPk($mode->id,array("record"=>$rule));



		//添加输入信息
		foreach($keyValueArray as $key=>$value)
		{
			$inputManager->saveInput($key,$value,$fieldProList[$key],$typeId,$mode->id);
		}


	}


	public  function  getRecordList()
	{
		$account = Yii::app()->user->getAccount();

		$sql = "select t.name,r.record,r.create_time,u.login from record as r,doctype as t,user as u  where r.type_id = t.id and r.user_id = u.id and r.corp_id =:corp_id order by r.id desc ";
		$model=Yii::app()->db->createCommand($sql);
		$model->bindValue(':corp_id', $account->corp_id);

		$list = $model->queryAll();

		return $list;
	}


}