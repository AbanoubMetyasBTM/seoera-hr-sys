<?php

class MY_session extends CI_Session{
    
    public function sess_update()
    {
        
        if (isset($_REQUEST['HTTP_X_REQUESTED_WITH'])&&$_REQUEST['HTTP_X_REQUESTED_WITH']!="XMLHttpRequest") {
            parent::sess_update();
        }
        
        
    }
    
    
}


?>