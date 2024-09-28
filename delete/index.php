<?php 
    if($_SERVER['REQUEST_METHOD'] == 'DELETE')
    {
        if($params[1] != null || $params[1] != '')
        {
            $user = User::get_user($params[1]);
            $user->clear();
            $ctx['result'] = array('user' => $user->json());
        }
        else
        {
            User::clear_all();
        }
    }
    else
    {
        $ctx['success'] = false;
        $ctx['result'] = array('method' => 'not allowed request method');
    }
    
?>