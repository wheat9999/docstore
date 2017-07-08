<?php
class PropTypeManager
{
	public  function  getSelectPublicPropList($type_id)
	{
		$account = Yii::app()->user->getAccount();

		$sql = "select * from propertytype where type_id =:type_id";
		$model=Yii::app()->db->createCommand($sql);
		$model->bindValue(':type_id', $type_id);

		return $model->queryAll();
	}

	public  function  getFullPublicPropList($type_id)
	{
		$account = Yii::app()->user->getAccount();

		$sql = "select p.* from propertytype as pt,docproperty as p where pt.property_id = p.id and pt.type_id =:type_id";
		$model=Yii::app()->db->createCommand($sql);
		$model->bindValue(':type_id', $type_id);

		return $model->queryAll();
	}


	public function changePublicProp($type_id,$propIds)
	{
		$mode = PropType::model();
		$mode->deleteAll("type_id=:type_id",array(":type_id"=>$type_id));

		$ids = explode(",",$propIds);

		foreach($ids as $propId)
		{
			$newPropType = new PropType();
			$newPropType->type_id = $type_id;
			$newPropType->property_id = $propId;
			$newPropType->save();
		}

	}



}