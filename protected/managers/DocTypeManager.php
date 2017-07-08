<?php
class DocTypeManager
{
	public function getDocTypeList()
	{
		$account = Yii::app()->user->getAccount();
		
		$docTypeList = DocType::model()->findAllByAttributes(array('corp_id'=>$account->corp_id));
		
		return $docTypeList;
	}


	public  function  getTypeKeyNameList()
	{
		$docTypeList = self::getDocTypeList();

		$docTypeArray = array();

		foreach($docTypeList as $item)
		{
			$docTypeArray[$item->id] = $item->name;
		}

		return $docTypeArray;
	}
	
	public function addDocType($doc_name,$doc_code)
	{
		$account = Yii::app()->user->getAccount();
		
		$docType = new DocType();
		$docType->name = $doc_name;
		$docType->code = $doc_code;
		$docType->corp_id = $account->corp_id;
		$docType->rule = "";
		$docType->save();
		return $docType->id;
		
	}

	public function getDocType($type_id)
	{
		$mode = DocType::model();
		$docType = $mode->findByPk($type_id);
		return $docType;
	}

	public  function  updateRule($typeId,$rule)
	{
		$mode = DocType::model();

		$mode->updateByPk($typeId,array('rule'=>$rule));
	}
	
}