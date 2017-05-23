<?php   
    
class MY_Model extends CI_Model{

    protected $table_name='';
    protected $primary_key='id';
    protected $primary_filter='intval';
    protected $order_by='';
    public $rules=array();
    protected $timestamps=FALSE;



    function __construct()
    {
        parent::__construct();
    }


    public function array_from_post($fields)
    {
        $data = array();
        foreach($fields as $field)
        {
            $data[$field] = $this->input->post($field);
        }

        return $data;
    }

    // function that select single row or all result from table name
    public function get($id = null, $single = FALSE){

        if($id != null)
        {
            $filter = $this->primary_filter;
            $id = $filter($id); // intval($id)
            $this->db->where($this->primary_key,$id);
            $method = 'row';
        }
        else if($single == TRUE)
        {
            $method = 'row';
        }

        else
        {
            $method = 'result';
        }

         if(!count($this->db->ar_orderby))
         {
             $this->db->order_by($this->order_by);
         }

        return $this->db->get($this->table_name)->$method();
    }

    // frunction that select single row or all result from table name of specific condition
    public function get_by($where , $single = FALSE){

        $this->db->where($where);
        return $this->get(null , $single);
    }

    // function that insert new row or update exist row
    public function save($data , $id=null){

        //set time stamps
        if($this->timestamps == TRUE)
        {
            $now = date('Y-m-d H:i:s');
            $id || $data['created'] = $now;
            $data['modified'] = $now;
        }

        //insert
        if($id == null)
        {
            !isset($data[$this->primary_key]) || $data[$this->primary_key] = null; // autoincreament in data base
            $this->db->set($data);
            $this->db->insert($this->table_name);
            $id = $this->db->insert_id();
        }

        //update
        else
        {
            $filter = $this->primary_filter;
            $id = $filter($id);
            $this->db->set($data);
            $this->db->where($this->primary_key , $id);
            $this->db->update($this->table_name);
        }

        return $id;
    }

    // function that delete exist row 
    public function delete($id){

        $filter = $this->primary_filter;
        $id = $filter($id);
        if(!$id)
        {
            return false;
        }

        $this->db->where($this->primary_key,$id);
        $this->db->limit(1);
        $this->db->delete($this->table_name);
    }

}


?>