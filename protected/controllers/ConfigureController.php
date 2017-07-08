<?php
class ConfigureController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionNavi()
	{
		$this->renderPartial ("navi");
	}
	
    public function actionDocIndex()
	{
		
		$docTypeManager = new DocTypeManager();
		$this->renderPartial('doc_index',array("data"=>$docTypeManager->getDocTypeList()));
	}
	public function actionPrivateIndex($typeId)
	{

		$fieldManager = new FieldManager();
		$fieldArray = $fieldManager->getFieldListByTypeId($typeId);
		$this->renderPartial('private_index',array("data"=>$fieldArray,"typeId"=>$typeId));
	}
	
	public function actionDocAdd($doc_name,$doc_code)
	{
		$docTypeManager = new DocTypeManager();
		$newId =  $docTypeManager->addDocType($doc_name, $doc_code);
		
		return $newId;
	}
	public function  actionDelType($typeId)
	{
		DocType::model()->deleteByPk($typeId);
		return true;
	}
	
	
    public function actionProIndex()
	{
		$docTypeManager = new DocTypeManager();
		$docPropManager = new PropManager();
		$this->renderPartial('property_index',array("menu"=>$docTypeManager->getDocTypeList(),"data"=>$docPropManager->getPublicPropList()));
	}
	
	public function actionProAdd($pro_name,$pro_type,$type_id=0)
	{
		$propManager = new PropManager();
		$propManager->addProp($pro_name, $pro_type, $type_id);
		
		return true;
	}

	public function actionFieldIndex($proId)
	{
		$pro = DocProp::model()->findByPk($proId);
		$docFieldManager = new FieldManager();

		$this->renderPartial('field_index',array("pro"=>$pro,"data"=>$docFieldManager->getFieldList($proId)));
	}

	public  function  actionQuickAdd($typeId, $type,$name,$value,$menulist)
	{

		//add pro

		$propManager = new PropManager();
		$proId = $propManager->addProp($name, 1, $typeId);


		//add Field

		self::addField($proId,$type,"**",$name,$value,$menulist);

		return true;

	}

	public function  actionQuickDel($fieldId)
	{


		$proManager = new PropManager();
		$proManager->delProByField($fieldId);

		$fieldManager = new FieldManager();
		$fieldManager->delField($fieldId);


		return true;

	}

	public  function  actionDelPro($proId)
	{
		$proManager = new PropManager();
		$proManager->delProp($proId);

		return true;


	}


	private function addField($proId,$type,$code,$name,$value,$menulist)
	{
		$docFieldManager = new FieldManager();
		$docFieldMenuManager = new FieldMenuManager();

		$docField = $docFieldManager->addField($proId,$type,$name,$code,$value);

		//add menu
		if($type == 1)
		{
			$docFieldMenuManager->addFieldMenus($docField->id,$menulist);
		}

	}

	public function actionFieldAdd($proId,$type,$code,$name,$value,$menulist)
	{

		self::addField($proId,$type,$code,$name,$value,$menulist);
		return true;
	}

	public function actionChangeSource($proId,$fieldId)
	{
		$docFieldManager = new FieldManager();

		$docFieldManager->changeSourceSelect($proId,$fieldId);

		return true;
	}
	
    public function actionRuleIndex()
	{
		$docTypeManager = new DocTypeManager();
		$this->renderPartial('rule_index',array("data"=>$docTypeManager->getDocTypeList()));
	}
	public function actionPropertyConfig($typeId)
	{
		$propManager = new PropManager();
		$propTypeManager = new PropTypeManager();
		$selectPropList = $propTypeManager->getSelectPublicPropList($typeId);

		$selectPropIds = array();

		foreach($selectPropList as $proptype)
		{
			$selectPropIds[] = $proptype["property_id"];
		}
		$this->renderPartial('property_config',array("type_id"=>$typeId, "data"=>$propManager->getPublicPropList(),"selectIds"=>$selectPropIds));
	}

	public function actionChangePublicProp($type_id,$proids)
	{
         $propTypeManager = new PropTypeManager();

		 $propTypeManager->changePublicProp($type_id,$proids);

		 return true;
	}

	public function actionRuleDetail($typeId)
	{
		$propManager = new PropManager();
		$docTypeManager = new DocTypeManager();
		$docType = $docTypeManager->getDocType($typeId);

		$this->renderPartial('rule_detail',array("typeId"=>$typeId,"rule"=>$docType->rule, "data"=>$propManager->getMyPropList($typeId)));
	}
	public  function  actionUpdateRule($typeId,$rule)
	{
		$typeManager = new DocTypeManager();
		$typeManager->updateRule($typeId,$rule);

		return true;
	}


    public function actionUserIndex()
	{

		$userManager = new UserManager();
		$this->renderPartial('user_index',array("userlist"=>$userManager->getMyUserArray()));
	}

	public  function  actionAddUser($login,$permission)
	{

		$userManager = new UserManager();
		$userManager->addUser($login,$permission);

		return true;
	}

	public  function  actionDelUser($userId)
	{
		MyUser::model()->deleteByPk($userId);
		return true;
	}

}