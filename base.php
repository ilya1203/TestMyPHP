<?php 
    
    $BASE_ROOT = $_SERVER['DOCUMENT_ROOT'];
    header('Content-type: application/json');
    
    require_once($BASE_ROOT.'/source/models.php');
    
    $params = explode('/',$_GET['file']);
    
    $ctx = array('success'=> true);
    
    try {
        if($params[0] == 'get')
        {
            require_once $BASE_ROOT.'/get/index.php';
        }
        else if($params[0] == 'create')
        {
            require_once $BASE_ROOT.'/create/index.php';
        }
        else if($params[0] == 'update')
        {
            require_once $BASE_ROOT.'/update/index.php';
        }
        else if($params[0] == 'delete')
        {
            require_once $BASE_ROOT.'/delete/index.php';
        }
        else
        {
            $ctx['success'] = false;
            $ctx['error'] = 'no such method';
            header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
        }
    }catch(Exception $e)
    {
        $ctx['success'] = false;
        $ctx['result'] = array('error' => $e->getMessage());
    }
    echo json_encode($ctx);
?>