<?php
class PropManager
{
	public  function  getPublicPropList()
	{
		$account = Yii::app()->user->getAccount();

		$sql = "select * from docproperty where property_type = 0 and  corp_id =:corp_id";
		$model=Yii::app()->db->createCommand($sql);
		$model->bindValue(':corp_id', $account->corp_id);

		return $model->queryAll();
	}

	public function getDocPropList()
	{
		$account = Yii::app()->user->getAccount();

		$sql = "select p.is_source, p.id,p.property_type,p.name,t.name as type_name from docproperty as p left join doctype as t on p.type_id = t.id where p.corp_id =:corp_id";
		$model=Yii::app()->db->createCommand($sql);
		$model->bindValue(':corp_id', $account->corp_id);

		return $model->queryAll();
	}

	public  function getPropList($type_id)
	{
		$sql = "select * from docproperty where type_id =:type_id";
		$model=Yii::app()->db->createCommand($sql);
		$model->bindValue(':type_id', $type_id);

		return $model->queryAll();
	}
	
	public function addProp($pro_name,$pro_type,$type_id)
	{
		$account = Yii::app()->user->getAccount();

		$docProp = new DocProp();
		$docProp->name = $pro_name;
		$docProp->property_type = $pro_type;
		$docProp->corp_id = $account->corp_id;
		$docProp->type_id = $type_id;
		$docProp->save();

		return $docProp->id;

	}

	public  function  delProByField($fieldId)
	{


		$field = DocField::model()->findByPk($fieldId);

		$proId = $field->property_id;



		DocProp::model()->deleteByPk($proId);
	}


	public  function  delProp($proId)
	{
		DocProp::model()->deleteByPk($proId);

		$fieldManager = new FieldManager();


		$fieldArray =  DocField::model()->findAllByAttributes(array("property_id"=>$proId));


		foreach($fieldArray as $field)
		{
			$fieldManager->delField($field->id);
		}


		return;

	}


	public function getMyPropList($type_id)
	{
		$propTypeManager = new PropTypeManager();
		$publicProps = $propTypeManager->getFullPublicPropList($type_id);
		$privateProps = self::getPropList($type_id);

		return array_merge($publicProps,$privateProps);


	}

}