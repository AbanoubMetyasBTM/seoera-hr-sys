<?php 

class users_m extends MY_Model{
    
    protected $table_name="users";
    protected $primary_key="userid";
    protected $primary_filter="intval";
    protected $order_by="userid";
    public    $rulse="";
    protected $timestamps=false;
    
    
    // Team_Member Panel >>> Ahmed Bakr
    
    public function get_users($cols="*" ,  $where="" , $method="result" , $ordered="") 
    {
        
        return $this->db->query("select $cols from $this->table_name user_obj"
            . " inner join attachments attach_obj on user_obj.user_img_id = attach_obj.id "
            . " inner join departments as dep_obj on dep_obj.dep_id=user_obj.department_id" 
            . " $where $ordered ")->$method();
        
    }

    
    // ./Team_Member Panel >>> Ahmed Bakr
    
    
    public function login($username,$password)
    {
        
        $password=$this->hash($password);
        
        $users=$this->get_by(array(
            "email"=>"$username",
            "password"=>"$password"
        ),true);
        if (count($users)) {
            $data=array(
            "userid"=>$users->userid,
            "loggedin"=>true,
            );
            
            $this->session->set_userdata($data);
            
            return $users->userid;
        }
        
    }
    
    public function logout()
    {
        $this->session->sess_destroy();
    }

    public function loggedin()
    {
        return (bool)$this->session->userdata('loggedin');
    }
    
    public function hash($string)
    {
        return hash('sha512',$string,FALSE);
    }
    
    
}