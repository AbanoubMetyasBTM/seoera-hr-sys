<?php 

class MY_Controller extends CI_Controller{
    
    public $data=array();
    public $userid;
    
    public function __construct() {
        parent::__construct();
        
        $this->data['errors']="";
        $this->data['site_name']="";
        
        //meta tags section
        $this->data['meta_title']="Seoera SYS";
        $this->data["meta_keyword"]="Seoera SYS MK";
        $this->data["meta_desc"]="Seoera SYS MD";
        
        
        $this->load->model("users_m");
        $this->load->model("attachments_m");
        //get user type
        
        
        
    }
    
    
    
    public function send_email_to_admins($subject,$body) {
        
        //get all site admins email
        $all_emails=$this->users_m->get();
        
        
        $to=array();
        foreach ($all_emails as $key => $email) {
            $to[]=$email->username;
        }
            
        
        $this->load->library('email',array("mailtype"=>"html"));
                
        $this->email->from("emprator@emprator.com", 'Emprator');
        $this->email->to($to); 

        $this->email->subject($subject);
        $this->email->message($body); 

        return $this->email->send();
    }
    
    public function general_save_img($item_id=null,$img_file_name,$new_title,$new_alt,$upload_new_img_check,$upload_file_path,$width,$height,$photo_id_for_edit,$edit_title,$edit_alt) {
        //$item_id could be pro id , cat_id any thing 
        $photo_id="not_enter";
        if ($item_id==null||($item_id>0&&$upload_new_img_check=="on")) {
            //save attachment first
            $upload_img=cms_upload($this->userid,$img_file_name,$upload_file_path,$width,$height);
            
            if (!(count($upload_img)>0))
            {
                return 0;
            }
            
            //save main photo
            $upload_img=$upload_img[0];
            $photo_id=$this->attachments_m->save(array(
                    "title"=>"$new_title",
                    "alt"=>"$new_alt",
                    "path"=>"$upload_img"
                    ));
            
            return $photo_id;
        }//end check of uplaod file
        
        
        if ($item_id!=null&&$photo_id_for_edit>0) {
            //edit photo data
            //update image info
            $photo_id=$this->attachments_m->save(array(
                    "title"=>"$edit_title",
                    "alt"=>"$edit_alt",
                    ),$photo_id_for_edit);
        }
        
        return $photo_id;
    }
    
    
}//end class