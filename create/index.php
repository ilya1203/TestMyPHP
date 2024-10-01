<?php 
    
    $input_data = json_decode(file_get_contents('php://input'));
    
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if($input_data)
        {
            $result = User::create($input_data);
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