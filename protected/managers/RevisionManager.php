<?php
class RevisionManager
{
	public  function  saveRevision($typeId,$recordId,$revision=0)
	{

		$account = Yii::app()->user->getAccount();

		$mode = new Revision();


		if($revision == 0)
		{
			$revision = self::getInitRevision($typeId);
		}
		else
		{
			$revision = self::getNextRevison($recordId,$typeId);
		}
		$mode->revision = $revision;
		$mode->record_id = $recordId;

		$mode->type_id = $typeId;
		$mode->user_id = $account->id;

		$mode->create_time = date("Y-m-d H:i:s");
		$mode->save();

		return $mode;

	}

	public  function  getNextRevison($recordId,$typeId)
	{

		$sql = "select * from revision  where record_id =:recordId order by id desc limit 0,1";
		$model=Yii::app()->db->createCommand($sql);
		$model->bindValue(':recordId', $recordId);

		$list = $model->queryAll();

		if(count($list) == 0)
		{
			return self::getInitRevision($typeId);
		}

		else
		{
			$maxItem = $list[0]["revision"];

			$intFormate = intval($maxItem)+1;

			$len = strlen($maxItem);

			return sprintf("%0".$len."d",$intFormate);
		}
	}

	public  function getInitRevision($typeId)
	{

		$docType = DocType::model()->findByPk($typeId);
		$rule = $docType->rule;

		$matches = array();

		preg_match("{\{S(.+)\}}", $rule, $matches);

		$init_value = $matches[1];

		return $init_value;
	}


	public  function  getRevisionList()
	{
		$account = Yii::app()->user->getAccount();

		$sql = "select v.type_id,r.record,r.id as recordId,v.id as revisionId, v.revision,v.create_time,v.user_id from revision as v, record as r where v.record_id = r.id and r.corp_id =:corp_id order by r.id desc,v.id desc ";
		$model=Yii::app()->db->createCommand($sql);
		$model->bindValue(':corp_id', $account->corp_id);

		$list = $model->queryAll();

		return $list;
	}

}