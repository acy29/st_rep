<?php

class Acl_Model_Acl extends Zend_Acl
{

    public function __construct($db,$role) {
        $this->loadRoles($db);
        $roles = new Acl_Model_Roles($db);
        $inhRole= $role;

       // while (!empty($inhRole)) {
            $this->loadResources($db,$inhRole);
            $this->loadPermissions($db,$inhRole);
            //$inhRole= $roles->getParentRole($inhRole);
      // }
    }

    public function loadRoles($db) {
    	if (empty($db)) {
    		return false;
    	}
        $roles = new Acl_Model_Roles($db);
        $allRoles = $roles->getRoles();
        foreach ($allRoles as $role) {
            if (!empty($role->id_parent)) {
                $this->addRole(new Zend_Acl_Role($role->id),$role->id_parent);
            } else {
                $this->addRole(new Zend_Acl_Role($role->id));
            }
        }
        return true;
    }

    public function loadPermissions($db,$role) {
    	if (empty($db)) {
    		return false;
    	}
    	$p= new Acl_Model_Permissions($db);

    	$Permissions= $p->getPermissions($role);
    	$allPermissions= $p->getAllPermissions();
    	print_r($allPermissions);

    	foreach ($allPermissions as $res) {

    		if (in_array($res,$Permissions)) {

    			//$this->allow($res['id_role'],$res['resource']);
    			echo"allow     ".$res['resource'];
    		} else {
    			//$this->deny($res['id_role'],$res['resource']);
    			echo"deny    ".$res['resource'];
    		}
    	}
        return true;
    }

    public function loadResources($db,$role) {
    	if (empty($db)) {
    		return false;
    	}
    	$resources= new Acl_Model_Resources($db);
    	$allResources= $resources->getResources($role);
    	foreach ($allResources as $res) {
                if (!$this->has($res)) {
                    $this->addResource(new Zend_Acl_Resource($res['resource']));
                }

    	}
        return true;
    }

}

