<?php
class DocController extends Controller
{
	public function actionList()
	{
		$revisionManager = new RevisionManager();

		$docTypeManager = new DocTypeManager();

		$userManager = new UserManager();



		$this->render('list',array("menu"=>$docTypeManager->getDocTypeList(),
			"revisionlist"=>$revisionManager->getRevisionList(),
			"userlist"=>$userManager->getUserList(),
			"typelist"=>$docTypeManager->getTypeKeyNameList(),
		));
	}



	public function actionAdd($typeId)
	{
		$fieldManager = new FieldManager();
		$fieldArray = $fieldManager->getFieldListByTypeId($typeId);



		$menuList = array();

		$menuMnager = new FieldMenuManager();

		foreach($fieldArray as $field)
		{
			if($field["type"] == 1)
			{
				$menu = $menuMnager->getFieldMenuList($field["id"]);
				$menuList[$field["id"]] = $menu;
			}
		}

		$this->render('newdoc',array("menuList"=>$menuList,"fieldArray"=>$fieldArray,"typeId"=>$typeId));
	}



	public  function  actionSave($typeId,$inputs)
	{


		$recordManager = new RecordManager();
		$recordManager->saveRecord($typeId,$inputs);

		return true;
	}


	public function  actionUpdate($typeId,$recordId)
	{
		$revisionManager = new RevisionManager();
		$revisionManager->saveRevision($typeId,$recordId,-1);
		return true;
	}
	public function  actionDel($revisionId,$recordId)
	{

		$resourceList = Resource::model()->findAllByAttributes(array("revision_id"=>$revisionId));

		foreach($resourceList as $r)
		{
			self::delResource($r->id);
		}

		Revision::model()->deleteByPk($revisionId);

		//record has no revision
		$revisionList = Revision::model()->findAllByAttributes(array("record_id"=>$recordId));
        if(count($revisionList) == 0)
		{
			//删除input
			DocInput::model()->deleteAll("record_id=:record_id",array(":record_id"=>$recordId));

			//删除record
			Record::model()->deleteByPk($recordId);
		}


		return true;
	}

	public function  actionFileList($revisionId)
	{
		$resouceManager = new ResourceManager();
		$resourceList = $resouceManager->getListByRevision($revisionId);
		$userManager = new UserManager();
		$this->render('filelist',array("revisonId"=>$revisionId,"resourcelist"=>$resourceList,"userlist"=>$userManager->getUserList()));
	}

	public  function  actionUploadFile()
	{
		header("content-type:text/html;charset=utf-8");
		$pImg=$_FILES['file'];
		$revision = $_POST['revision'];



		if($pImg['error']==UPLOAD_ERR_OK){

			//取得扩展名

			$extName=strtolower(end(explode('.',$pImg['name'])));



			$oldname = $pImg['name'];

			$filename= $revision."-".date("Ymdhis").".".$extName;

			//echo $filename;



			$dest="files/".$filename;

			move_uploaded_file($pImg['tmp_name'],$dest);

			$resourceManager = new ResourceManager();

			$resourceManager->addResource($filename,$oldname,$revision);



		}else{



		}

		$this->redirect(array('doc/fileList','revisionId'=>$revision));
	}

	private function delResource($resourceId)
	{

		$oldResource = Resource::model()->findByPk($resourceId);
		$filename = $oldResource->path;
		$dest="files/".$filename;
		@unlink($dest);


		Resource::model()->deleteByPk($resourceId);
	}

	public  function  actionDelResource($resourceId)
	{
        self::delResource($resourceId);
		return true;
	}

}