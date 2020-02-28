<?php
class LoginController extends AppController {
	var $uses=array("User","Role");
	public $helpers = array('Form', 'Html');
	
	public function beforeFilter(){
		$this->forceSSL();

		Configure::load("config");			
		if($this->params['action']=='index'){
			if($this->Session->read('userId')){
				$this->redirect(array("controller"=>"client",'action'=>'index'));
			}
		}
	}

	public function index() {
		$this->layout="login";
		 $this->set("message",'');		
		$this->set("title_for_layout","Login");
		if(isset($this->data['User'])){
			$userDetails=$this->User->find("first",array("conditions"=>array("LoginName"=>$this->data['User']['LoginName'],"Password"=>md5($this->data['User']['Password']),"StatusFlag"=>'Active')));
            $this->setSession($userDetails);
        }
	}
	
	public function logout(){
		$this->autoRender=false;
		$this->Session->destroy();		
		$this->redirect(array('controller'=>'login','action'=>'index'));
	}
	
	public function forgotPassword() {
		$this->autoRender=false;
		if(isset($this->data['LoginFrm']['Email'])){
			$userDetails=$this->User->find("first",array("conditions"=>array("User.Email"=>$this->data['LoginFrm']['Email'],"User.StatusFlag"=>'Active'),"order by"=>"id asc"));
			if($userDetails['User']['ID']){
				$this->sendMail($userDetails);
			}else{
				$this->Session->setFlash(Configure::read("User.EmailFail"));
				$this->redirect(array('controller'=>'login','action'=>'index'));
			}
		}
	}
	
	public function sendMail($userDetails){
		$this->autoRender=false;					
		  App::uses('CakeEmail', 'Network/Email');		 
		  $pwd_string=$this->generateRandomString(6); 
		  $userData['User']['ID']=$userDetails['User']['ID'];
		  $userData['User']['IsActive']=0;
		  $userData['User']['Password']=md5($pwd_string);
		  $this->User->save($userData);
		  $desc=array();
		  $email = new CakeEmail('smtp');
		  $email->subject("Encore - PRF :: Forgot Password Request");
		  $email->from(array('no-reply@encoress.com' => 'ENCORE'));
		  $email->to($userDetails['User']['Email']);
		  $email->emailFormat('text');
		  $email->viewVars(array('Name'=>$userDetails['User']['FirstName']));
		  $email->viewVars(array('title_for_layout'=>"Forgot Password Information"));	
		  $email->viewVars(array('loginName'=>$userDetails['User']['LoginName']));
		  $email->viewVars(array('Password'=>$pwd_string));	  
		  $email->template('forgotPassword');
		  $email->send();
		  $this->Session->setFlash(Configure::read("User.EmailSuccess"));
		  $this->redirect(array('controller'=>'login','action'=>'index'));		  
	 }

	public function sso(){
		$this->autoRender = false;
		require_once APP.DS."Vendor/autoload.php";
		$token = isset($_COOKIE['idToken'])?$_COOKIE['idToken']:'';
		if(empty($token))
		    $this->redirect(array('controller'=>'login','action'=>'index'));

        $validateToken = (new \Lcobucci\JWT\Parser())->parse((string)$token); // Parses from a string
        $userName = $validateToken->getClaim('sub'); // Retrieves the token claims
        $email = $userName. "@encoress.com";

        $validationData = new \Lcobucci\JWT\ValidationData();
        $validationData->setIssuer(Configure::read('ISSUER'));
        //$validationData->setAudience(Configure::read('AUDIENCE'));
        $validationData->setId(Configure::read('AUTH_KEY'));
        $validationData->setCurrentTime(time());

        if($validateToken->validate($validationData)){
            $userDetails=$this->User->find("first",array("conditions"=>array("Email"=>$email)));
            if(!empty($userDetails))
                $this->setSession($userDetails);
            else
                $this->redirect(array('controller'=>'login','action'=>'index'));
        }else{
            $this->redirect(array('controller'=>'login','action'=>'index'));
        }
	}

    /**
     * @param $userDetails
     */
    private function setSession($userDetails)
    {
        if (!empty($userDetails)) {
            //User Timezone
            $this->Session->write("userId", $userDetails['User']['ID']);
            $this->Session->write("userName", $userDetails['User']['FirstName']);
            $this->Session->write("roleInfo", $this->Role->field("Name", array("ID" => $userDetails['User']["RoleId"])));
            $this->Session->write("roleId", $userDetails['User']['RoleId']);
            if ($userDetails['User']['RoleId'] == 3 || $userDetails['User']['RoleId'] == 9) {
                $this->Session->write("AdminUser", true);
            } else {
                $this->Session->write("AdminUser", false);
            }
            if ($userDetails['User']['RoleId'] == 11) {
                $this->Session->write("ManagerRecruiter", true);
            } else {
                $this->Session->write("ManagerRecruiter", false);
            }
            //Added for normal user
            if ($userDetails['User']['RoleId'] == 10) {
                $this->Session->write("ProjectLead", true);
            } else {
                $this->Session->write("ProjectLead", false);
            }
            if ($userDetails['User']['IsActive']) {
                if ($userDetails['User']['RoleId'] == 5) {
                    $this->redirect(array("controller" => "CandidateAssignment", "action" => "index"));
                }
                if ($userDetails['User']['RoleId'] == 10) {
                    $this->redirect(array("controller" => "Report", "action" => "index"));
                }
                if (($userDetails['User']['RoleId'] != 10) && ($userDetails['User']['RoleId'] != 5)) {
                    $this->redirect(array("controller" => "Client", "action" => "index"));
                }
            } else {
                $this->Session->setFlash(Configure::read("User.changePassword"));
                $this->redirect(array("controller" => "Users", "action" => "changePassword"));
            }
        } else {
			 $this->set("message",Configure::read("User.loginFail"));		
            //$this->Session->setFlash(Configure::read("User.loginFail"));
        }
    }
}
?>
