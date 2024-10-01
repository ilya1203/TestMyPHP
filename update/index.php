<?php

    if($_SERVER['REQUEST_METHOD'] == 'PATCH')
    {
        if($params[1] != '' || $params[1] != null)
        {
            $user = User::get_user($params[1]);
            $input_data = json_decode(file_get_contents('php://input'));
            if($user != null)
            {
                
                foreach($input_data as $key=>$value)
                {
                    $user->data[$key] = $value;
                }
                
                $user->save();
            
                $ctx['result'] = array("users" => $user->json());
            }
            else{
                $ctx['success'] = false;
                $ctx['result'] = array('error' => 'no such user');
            }
        }
        else
        {
            $ctx['success'] = false;
            $ctx['result'] = array('error' => 'no such data');
        }
    }
    else
    {
        $ctx['success'] = false;
        $ctx['result'] = array('error' => 'not allowed request method');
    }
    
?>