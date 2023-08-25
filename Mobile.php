<?php
require_once "dbcontroller.php";

class Mobile {
    private $db_handle;

    function __construct() {
        $this->db_handle = new DBController();
    }

   
    function getAllReceivedDocs($MyUser) {
        $query = "SELECT SRC.*, work.*, 
        sender.section_name AS send_name, receiver.section_name AS rec_name, tmpr.section_name AS tmpr_name
        FROM SRC 
        JOIN work ON SRC.id = work.Doc_id 
        LEFT JOIN section AS sender ON work.User_send = sender.id
        LEFT JOIN section AS receiver ON work.User_rec = receiver.id
        LEFT JOIN section AS tmpr ON work.tmp_rec = tmpr.id
        WHERE work.User_rec = '$MyUser' AND work.bool_set = 1
        OR work.tmp_rec = '$MyUser' AND work.bool_set = 1 AND request_done = 1";
	
        $result = $this->db_handle->runQuery($query);
        return $result;
    }
    function getusers() {
        $query = "SELECT section.* FROM section";         
        $result = $this->db_handle->runQuery($query);
        return $result;
    }

    function getmydoc($MyUser) {
        $query = "SELECT SRC.*, work.*, 
        sender.section_name AS send_name, receiver.section_name AS rec_name, tmpr.section_name AS tmpr_name
        FROM SRC 
        JOIN work ON SRC.id = work.Doc_id 
        LEFT JOIN section AS sender ON work.User_send = sender.id
        LEFT JOIN section AS receiver ON work.User_rec = receiver.id
        LEFT JOIN section AS tmpr ON work.tmp_rec = tmpr.id
        WHERE work.User_rec = '$MyUser' AND work.bool_set = 1";	
        $result = $this->db_handle->runQuery($query);
        return $result;
    }

    function getDocDetails($doc_id) {
        $query = "SELECT work.*, SRC.*,
        sender.section_name AS send_name, 
        receiver.section_name AS rec_name,
        tmpr.section_name AS tmpr_name
        FROM work JOIN SRC ON SRC.id = work.Doc_id
        LEFT JOIN section AS sender ON work.User_send = sender.id
        LEFT JOIN section AS receiver ON work.User_rec = receiver.id
        LEFT JOIN section AS tmpr ON work.tmp_rec = tmpr.id
        WHERE work.Doc_id = '$doc_id'";
        $result = $this->db_handle->runx2Query($query);
        return $result;
    }

    function geAlldoc() {
        $query = "SELECT SRC.*, work.*, 
        sender.section_name AS send_name, 
        receiver.section_name AS rec_name, tmpr.section_name AS tmpr_name
        FROM SRC 
        JOIN work ON SRC.id = work.Doc_id 
        LEFT JOIN section AS sender ON work.User_send = sender.id
        LEFT JOIN section AS receiver ON work.User_rec = receiver.id
        LEFT JOIN section AS tmpr ON work.tmp_rec = tmpr.id";

        $result = $this->db_handle->runx2Query($query);
        return $result;
    }

    function recordDocReceived($user_id, $work_id, $doc_id, $note) {
        $result = $this->db_handle->run_rec($user_id, $work_id, $doc_id, $note);
        return $result;
    }

    
    function addNewDoc($user_id, $number, $name, $type) {
        $result = $this->db_handle->runFQuery($user_id, $number, $name, $type);
        return $result;
    }

    
    
}
?>