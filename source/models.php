<?php
    require_once $BASE_ROOT.'/source/db.php';
    
    class User{
        public function __construct($data_user = null) 
        {
            if($data_user)
            {
                $this->data = $data_user;
            }
        }
        
        public static function validate($data)
        {
            $status = true;
            $fields = array(
                "full_name" => array('type'=>'string', 'min_length'=> 3,'max_length'=>64),
                "efficiency" => array('type'=>'integer'),
                "role" => array('type'=>'string', 'min_length'=> 3, 'max_length'=>32),
            );
            
            foreach($fields as $key=>$value)
            {
                if($data[$key])
                {
                    
                    if(''.gettype($data[$key]) == $fields[$key]['type'])
                    {
                        if($fields[$key]['max_length'])
                        {
                            if(strlen(''.$data[$key]) > $fields[$key]['max_length'])
                            {
                                return false;
                            }
                        }
                        if($fields[$key]['min_length'])
                        {
                            if(strlen(''.$data[$key]) < $fields[$key]['min_length'])
                            {
                                return false;
                            }
                        }
                    }
                    else{
                        return false;
                    }
                }
            }
            
            return $status;
        }
        
        static function get_roles($name=null, $simple=true)
        {
            $sql = 'SELECT * FROM roles';
            $result = $GLOBALS['connect']->query($sql);
            $return_roles = array();
            
            while($row = $result->fetch_assoc())
            {
                if($name == $row['name'])
                {
                    return $row;
                }
                if(!$simple)
                {
                    $return_roles[intval($row['id'])] = $row['name'];
                }else
                {
                    $return_roles[] = $row;
                }
            }
            
            if($name !== null)
            {
                $sql = 'INSERT INTO roles (name) VALUES ("'.$name.'")';
                $GLOBALS['connect']->query($sql);
                return array("name"=>$name, 'id'=>$GLOBALS['connect']->insert_id);
            }
            else{
                return $return_roles;
            }
        }
        
        public static function get_users($role_id=null)
        {
            $sql = "SELECT * FROM users";
            if($role_id)
            {
                $sql .= ' WHERE role_id='.$role_id;
            }
            $roles = User::get_roles($name=null, $simple=false);
            $result = $GLOBALS['connect']->query($sql);
            $return_array = array();
            while($row = $result->fetch_assoc())
            {
                $row['role'] = $roles[intval($row['role_id'])];
                $return_array[] = new User($row);
            }
            
            return $return_array;
        }
        
        public static function get_user($id)
        {
            $sql = 'SELECT * FROM users WHERE id='.$id;
            $result = $GLOBALS['connect']->query($sql);
            $roles = User::get_roles($name=null, $simple=false);
            while($row = $result->fetch_assoc())
            {
                $row['role'] = $roles[intval($row['role_id'])];
                return new User($row);
            }
               
        }
        
        public static function create($data)
        {
            
            $is_validated = User::validate((array) $data);
            if(!$is_validated)
            {
                return false;
            }
            
            $role = User::get_roles($name=$data->role);
            $role_id = intval($role["id"]);
            
            $sql = 'INSERT INTO users (full_name, role_id, efficiency) VALUES ("'.$data->full_name.'", '.$role_id.', '.$data->efficiency.')';
            $result = $GLOBALS['connect']->query($sql);
            
            return $GLOBALS['connect']->insert_id;
        }
        
        function json()
        {
            return array(
                "id" => intval($this->data["id"]), 
                "full_name" => $this->data["full_name"],
                "role" => $this->data["role"],
                "efficiency" => intval($this->data['efficiency'])
                );
        }
        
        function save()
        {
            $is_validated = User::validate((array) $this->data);
            if(!$is_validated)
            {
                return false;
            }
            
            $role_id = User::get_roles($this->data['role'])['id'];
            
            $sql = 'UPDATE users SET full_name="'.$this->data['full_name'].'", role_id='.$role_id.', efficiency='.$this->data['efficiency'].' WHERE id='.$this->data['id'];
            $GLOBALS['connect']->query($sql);
            
            return $this->data;
        }
        
        function clear()
        {
            $sql = 'DELETE FROM users WHERE id='.$this->data['id'];
            $GLOBALS['connect']->query($sql);
            return true;
        }
        
        public static function clear_all()
        {
            $sql = 'DELETE FROM users';
            $GLOBALS['connect']->query($sql);
            return true;
        }
    }
?>