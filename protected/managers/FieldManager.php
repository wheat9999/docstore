<?php
class FieldManager
{


	public function getFieldList($property_id)
	{
		$account = Yii::app()->user->getAccount();

		$sql = "select * from docfield  where property_id =:property_id";
		$model=Yii::app()->db->createCommand($sql);
		$model->bindValue(':property_id', $property_id);

		return $model->queryAll();
	}


	public  function  delField($fieldId)
	{



		DocField::model()->deleteByPk($fieldId);


		DocFieldMenu::model()->deleteAll("field_id=:field_id",array(":field_id"=>$fieldId));
	}
	
	public function addField($pro_id,$type,$name,$code,$value)
	{
	    $fieldArray = DocField::model()->findAllByAttributes(array("property_id"=>$pro_id));

		if(count($fieldArray) == 1)
		{
			$oldField = $fieldArray[0];
			$oldField->is_select=1;
			$oldField->save();

			DocProp::model()->updateByPk($pro_id,array('is_source'=>1));
		}

		$docField = new DocField();
		$docField->property_id = $pro_id;
		$docField->type = $type;
		$docField->name = $name;
		$docField->code = $code;
		$docField->value = $value;
		$docField->is_select =0;

		$docField->save();

		return $docField;

	}

	public  function changeSourceSelect($pro_id,$field_id)
	{
		$mode = DocField::model();

		$mode->updateAll(array('is_select'=>0),'property_id=:pro_id',array(':pro_id'=>$pro_id));

		$mode->updateByPk($field_id,array('is_select'=>1));



	}


	public function getFieldListByTypeId($typeId)
	{

		//private pro

		$sql = "select id from docproperty where type_id =:typeId union SELECT property_id as id FROM propertytype where type_id =:typeId;";
		$model=Yii::app()->db->createCommand($sql);
		$model->bindValue(':typeId', $typeId);
		$proList =  $model->queryAll();

		if(count($proList) == 0)
			return array();

		$proIds = array();

		foreach($proList as $pro)
		{
			$proIds[] = $pro["id"];
		}




		$proIdStr = implode(",",$proIds);



		$sql = "(SELECT * FROM docfield where property_id in ($proIdStr) and is_select = 1  order by property_id)";

		$sql .= " union ";
		$sql .= "(SELECT * FROM docfield where property_id in ($proIdStr) group by property_id having count(property_id)=1 order by property_id)";


		$model=Yii::app()->db->createCommand($sql);

		$fieldList =  $model->queryAll();

		return $fieldList;

	}



}