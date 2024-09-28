<?php 
    
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if($_POST)
        {
            $result = User::create($_POST);
            $ctx['result'] = array('id'=>$result);
        }
        else{
            $ctx['success'] = false;
            $ctx['error'] = 'no post data';
        }
    }
    else
    {
        $ctx['success'] = false;
        $ctx['result'] = array('error' => 'not allowed request method');
    }
    
?>