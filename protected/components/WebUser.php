<?php
class WebUser extends CWebUser { 

  // Store model to not repeat query. 
  private $_model; 

  // Return first name. 
  // access it by Yii::app()->user->first_name 
  function getLogin(){ 
    $user = $this->loadUser(Yii::app()->user->id); 
    return $user->login; 
  } 

  // This is a function that checks the field 'role' 
  // in the User model to be equal to 1, that means it's admin 
  // access it by Yii::app()->user->isAdmin() 
  public function getRole(){ 
  	
    $user = $this->loadUser(Yii::app()->user->id); 

    if ($user == null)
    {
    	return -1;
    } 
    else
    {
    	return $user->permission;
    }
  } 
  
  public function getAccount()
  {
  	$user = $this->loadUser(Yii::app()->user->id); 
  	return $user;
  }
  

  // Load user model. 
  protected function loadUser($id=null) 
    { 
        if($this->_model===null) 
        { 
            if($id!==null) 
                $this->_model=MyUser::model()->findByAttributes(array("login"=>$id));
        } 
        return $this->_model; 
    } 
} 