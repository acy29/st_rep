<?php

class Acl_AclController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
 
		//$acl = $this->ini();

		 
        $auth= Zend_Auth::getInstance();
		if (!empty($auth) && ($auth instanceof Zend_Auth)) {  	 

		    $db = Zend_Db_Table::getDefaultAdapter();
		    $user= $auth->getStorage()->read();

		    $role= $user['id_role'];

		    $acl= new Acl_Model_Acl($db,$role);
		    //var_dump(acl);
			/*$acl= new Login_Acl($db,$role);    


	      if($acl->isAllowed($role,"http://localhost/st_rep/st/public/orden/crear"))
	        {
	             echo '<li><a href="/roles">Mensaje de Bienvenida</a></li>';
	        }
	      echo '</ul></li>';*/
 		 }

    }

	/*
	*Creo el objeto acl
	*/
    public function ini()
    {
 
	    $acl = new Zend_Acl();
	    $db = Zend_Db_Table::getDefaultAdapter();
	 
	    $sql = "SELECT * FROM roles";
	 
	    $rsRoles = $db->query($sql);

	 	//$rsRoles2 = $rsRoles->toArray();
	    foreach ($rsRoles as $row)
	    	$acl->addRole(new Zend_Acl_Role($row['role'])); 
	 
	    // Add resources
	 
	    $sql = "SELECT * FROM resources";
	 
	    $rsResources = $db->query($sql); 
	 
	    //while ($row = $rsResources->fetch_assoc()) 
	    foreach ($rsResources as $row)
	    	$acl->add(new Zend_Acl_Resource($row['resource']));
	 
	    // Add permissions
	 
	    $sql = "SELECT ro.role as role_name, re.resource as resource_name FROM roles as ro JOIN permissions as p ON ro.id = p.id_role JOIN resources as re ON re.id = p.id_resource";
	 
	    $rsRolesResources = $db->query($sql);
	 
	    //while ($row = $rsRolesResources->fetch_assoc()) 
	    foreach ($rsRolesResources as $row)
	    	$acl->allow($row['role_name'], $row['resource_name']);
	 
	    return $acl;
 

    }


}

