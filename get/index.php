<?php
    if($ctx == null)    
    {
        echo json_encode(array('a'=>1));
        exit();
    }

    $ctx['result'] = array('users' => array());
    
    if($params[1] == "" || $params[1] === null)
    {
        $role_id = null;
        if($_GET['role'])
        {
            $role_id = User::get_roles($_GET['role'])['id'];
        }
        $res = User::get_users($role_id);
        foreach($res as $u)
        {
            $ctx['result']['users'][] = $u->json();
        }
    }
    else
    {
        $user = User::get_user($params[1]);
        if($user != null)
        {
            $ctx['result']['users'][] = $user->json();
        }
        else
        {
            $ctx['success'] = false;
            $ctx['result'] = array('error' => 'no such user');
        }
    }
    
?>