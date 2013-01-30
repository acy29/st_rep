<?php
class Zend_View_Helper_CreateMenu extends Zend_View_Helper_Abstract
{
    /*
    *Create a menu with ul-li
    */
    public function CreateMenu(){
        $auth =  Zend_Auth::getInstance();
        $menu = '';
        if ($auth->hasIdentity()) {

            $menu = '<ul id="menu_app">';
            $menu .='<li><a href="/st_rep/st/public/contenedores/index">Buscar orden</a></li>';
            $menu .='<li><a href="/st_rep/st/public/contenedores/listar">Contenedores</a></li>';
            $menu .='<li><a href="/st_rep/st/public/contenedores/envios">Todos los env&#237;os</a></li>';
            $menu .='</ul>';

         }
         return $menu;
    }
}
 
?>