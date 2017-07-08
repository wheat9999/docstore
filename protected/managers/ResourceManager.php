<?php
class ResourceManager
{
	public  function  addResource($path,$name,$revisonId)
	{


		$account = Yii::app()->user->getAccount();

		$revision = Revision::model()->findByPk($revisonId);

		$mode = new Resource();
		$mode->name = $name;
		$mode->path = $path;
		$mode->revision_id = $revisonId;
		$mode->user_id = $account->id;
		$mode->record_id = $revision->record_id;
        $mode->create_time = date("Y-m-d H:i:s");

		$mode->save();

	}

	public  function  getListByRevision($revisidonId)
	{
		$sql = "select * from resource   where revision_id=:revision_id order by id desc ";
		$model=Yii::app()->db->createCommand($sql);
		$model->bindValue(':revision_id', $revisidonId);

		$list = $model->queryAll();

		return $list;

	}



}