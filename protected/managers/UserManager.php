<?php
class UserManager
{


	public  function  addUser($login,$permission)
	{

		$account = Yii::app()->user->getAccount();

		$user = new MyUser();
		$user->login = $login;
		$user->pwd = "123";
		$user->permission = $permission;
		$user->corp_id = $account->corp_id;
		$user->save();
	}


	public  function  getMyUserArray()
	{

		$account = Yii::app()->user->getAccount();

		$sql = "select * from user  where corp_id =:corp_id order by id desc";
		$model=Yii::app()->db->createCommand($sql);
		$model->bindValue(':corp_id', $account->corp_id);

		$list = $model->queryAll();

		return $list;
	}
	public  function  getUserList()
	{

		$list = self::getMyUserArray();

		$userArray = array();

		foreach($list as $item)
		{
           $userArray[$item["id"]]=$item["login"];
		}

		return $userArray;

	}



}