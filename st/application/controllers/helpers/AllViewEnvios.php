<?php

class Zend_Controller_Action_Helper_AllViewEnvios extends Zend_Controller_Action_Helper_Abstract
{
    //*** me devuelve una json con todos los envios
    function allviewenvios()
    {
        /*$db = Zend_Db_Table::getDefaultAdapter();  
        $select = $db->select()
                    ->from(array('ve' => 'vw_Envios'),
                    array("NoGuia","NombreCentroDestino","CodEnvio","Fecha","NombreTransporte"));

        $rows = $select->query()->fetchAll();
        $date;
        foreach($rows as $entry) {
            $x[] = array($entry['Fecha'],$entry['CodEnvio'],$entry['NoGuia'], $entry['NombreCentroDestino'],$entry['NombreTransporte']);
        }
       // $this->view->json = json_encode(array("aaData" => $x));

        return json_encode(array("aaData" =>$x));*/

            /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Easy set variables
     */
    
    /* Array of database columns which should be read and sent back to DataTables. Use a space where
     * you want to insert a non-database field (for example a counter or static image)
     */
    $aColumns = array( 'Fecha', 'CodEnvio', 'NoGuia', 'NombreCentroDestino', 'NombreTransporte' );
    
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "CodEnvio";
    
    /* DB table to use */
    $sTable = "vw_Envios";
    
    $db = Zend_Db_Table::getDefaultAdapter();
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * If you just want to use the basic configuration for DataTables with PHP server-side, there is
     * no need to edit below this line
     */
    
    /* 
     * Paging
     */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $sCountRowStart="SET ROWCOUNT ".intval( $_GET['iDisplayStart'] );
        $sLimit = "Top ".
            intval( $_GET['iDisplayLength'] );
    }
    
    
    /*
     * Ordering
     */
    $sOrder = "";

    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
        {
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
            {
                $sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
                    ($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
                    $sIndexColumn=$aColumns[ intval( $_GET['iSortCol_'.$i] ) ];
            }
        }
        
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" )
        {
            $sOrder = "";
        }
    }
    
    
    /* 
     * Filtering
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here, but concerned about efficiency
     * on very large tables, and MySQL's regex functionality is very limited
     */
    $sWhere = "";
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
    {
        $sWhere = "WHERE (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            $sWhere .= "".$aColumns[$i]." LIKE '%".$_GET['sSearch'] ."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
    
    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" )
            {
                $sWhere = "WHERE ";
            }
            else
            {
                $sWhere .= " AND ";
            }
            $sWhere .= "'".$aColumns[$i]."' LIKE '%".$_GET['sSearch_'.$i]."%' ";
        }
    }
    
    
    /*
     * SQL queries
     * Get data to display
     */
    $sQuery = "
    SELECT  * FROM    (
        SELECT ROW_NUMBER() OVER ( $sOrder) AS RowNum,
        ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   $sTable
        $sWhere
        )AS RowConstrainedResult
        WHERE   RowNum >= ".$_GET['iDisplayStart']."
            AND RowNum < ".($_GET['iDisplayStart']+$_GET['iDisplayLength'])."
        $sOrder
        ";
        //echo $sQuery;
    $rResult = $db->query( $sQuery);
    
    /* Data set length after filtering */
    $sQuery = "
        SELECT count(*) as ResultFilterTotal
        FROM   $sTable
        $sWhere
    ";

    $rResultFilterTotal = $db->query( $sQuery);
    $aResultFilterTotal = $rResultFilterTotal->fetch();
    $iFilteredTotal = $aResultFilterTotal["ResultFilterTotal"];
    
    /* Total data set length */
    $sQuery = "
        SELECT COUNT(".$sIndexColumn.") as Total
        FROM   $sTable
    ";
    $rResultTotal = $db->query( $sQuery);
    $aResultTotal = $rResultTotal->fetch();
    $iTotal = $aResultTotal;
    
    
    /*
     * Output
     */
    $output = array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $iTotal["Total"],
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );
    
    while ( $aRow =$rResult->fetch()  )
    {
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( $aColumns[$i] == "version" )
            {
                /* Special output formatting for 'version' column */
                $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
            }
            else if ( $aColumns[$i] != ' ' )
            {
                /* General output */
                $row[] = $aRow[ $aColumns[$i] ];
            }
        }
        $output['aaData'][] = $row;
    }

    return json_encode($output);


    }

}

?>
