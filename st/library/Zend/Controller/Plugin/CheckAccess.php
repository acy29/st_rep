<?php

class Zend_Controller_Plugin_CheckAccess extends Zend_Controller_Plugin_Abstract
{
    /*
     * Contiene el objeto Zend_Auth
     */
    private $_auth;
    private $_module;
 
    public function __construct()
    {
        $this->_auth =  Zend_Auth::getInstance();
        $this->_acl = new Zend_Acl;
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $controllerName = $request->getControllerName();
        $actionName = $request->getActionName();
        $this->_module = $this->getRequest()->getModuleName();

        if ($this->_module != "login") {// || $this->_module != "default"
            if ($this->_auth->hasIdentity()) {
               // echo "logueado";
               // $db = Zend_Db_Table::getDefaultAdapter();
               // $user= $this->_auth->getStorage()->read();
               // $role= $user['id_role'];
               // $this->loadRoles();
               // $this->loadResources($db,$role);
               // $this->loadPermissions($db,$role);

               // $this->_isAllowed($request);

            } else {
                //$this->view->msj_error =  "Debe autenticarce";
                //echo  "Debe autenticarce";
                if ($controllerName != 'login') {
                    
                     //redirect to user to login
                    $request->setModuleName("login");
                    $request->setControllerName("login");
                    $request->setActionName("login");
                }
            }
        }
    }
        /*
        ******************************************************************
        * load the roles - permissions - resources in acl
        */
      public function loadRoles() {
        $allRoles = $this->getRoles();
        foreach ($allRoles as $role) {
           // if (!empty($role->id_parent)) {
                //$this->_acl->addRole(new Zend_Acl_Role($role->id),$role->id_parent);
           // } else {
                //***if not place the role
                if (!in_array($role->id,$this->_acl->getRoles())) 
                    $this->_acl->addRole(new Zend_Acl_Role($role->id));
           // }
        }
        return true;
    }

    public function loadPermissions($db,$role) {
        if (empty($db)) {
            return false;
        }

        $Resources= $this->getResourcesResource($role); //*** user's resource
        $allResources= $this->getAllResourcesResource();//*** all resource system
        
        foreach ($allResources as $res) {
            //*** if the rol is present in usuario's roles 'alow' cc deny

            if (in_array($res,$Resources)) 
                $this->_acl->allow($role,$res);
            else 
                $this->_acl->deny($role,$res);
            
        }
        return true;
    }

    public function loadResources($db,$role) {
        if (empty($db)) {
            return false;
        }

        $allResources= $this->getResources();
        foreach ($allResources as $res) {
            echo $res['resource'];
            if (!$this->_acl->has($res['resource'])) {
                $this->_acl->addResource(new Zend_Acl_Resource($res['resource']));
            }

        }
        return true;
    }
        /*
        ******************************************************************
        * find in BD the roles - permissions - resources
        */
    public function getRoles() {
        $resource_table= new Zend_Db_Table("roles");
        return $resource_table->fetchAll();
    }


    public function getResources() {
        $resource_table= new Zend_Db_Table("resources");
        return $resource_table->fetchAll();
    }

    public function getResourcesResource($role) {
        $resource_table= new Zend_Db_Table("resources");
        $array = $resource_table->fetchAll($resource_table->select()
               ->from(array('r'=>'resources'))
               ->join(array('p'=>'permissions'),'r.id=p.id_resource',array())
               ->where('p.id_role=?',$role))->toArray();

        $array2 = array();
        foreach ($array as $a) {
            $array2[] = $a["resource"];
        }
        return $array2;
    
    }

    public function getAllResourcesResource() {
        $resource_table = new Zend_Db_Table("resources");

        $array = $resource_table->fetchAll();
        $array2 = array();
        foreach ($array as $a) {
            $array2[] = $a["resource"];
        }
        return $array2;

    }
        /*
        ******************************************************************
        * find in BD the roles - permissions - resources
        */
    private function _isAllowed(Zend_Controller_Request_Abstract $request) 
    {

        $user= $this->_auth->getStorage()->read();
        $role= $user['id_role'];
       // var_dump($this->_acl->getRoles());
       // echo $this->_module.'/*/*';
        //echo "ddddd".$this->_acl->isAllowed($role,$this->_module.'/*/*');
        if (!$this->_acl->isAllowed($role,$this->_module.'/*/*')) { 
          //  echo "denegado";
            $request->setModuleName("default");
            $request->setControllerName("index");
            $request->setActionName("denegate");
        }else
            echo "pasa";



    }

}
