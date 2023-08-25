<?php
require_once "SimpleRest.php";
require_once "Mobile.php";

// إرجاع رد الخادم بصيغة JSON
header('Content-Type: application/json; charset=utf-8');
class MobileRestHandler extends SimpleRest {
    private $input_data;

    public function setInputData($data) {
        $this->input_data = $data;
    }

    public function getAllReceivedDocs() {
        $getall = new Mobile();
        $rawData = $getall->getAllReceivedDocs($this->input_data['MyUser']);

        if(empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => 'No Doc found!');		
        } else {
            $statusCode = 200;
        }

        $requestContentType = 'application/json';
        $this->setHttpHeaders($requestContentType, $statusCode);

        $result["output"] = $rawData;

        if(strpos($requestContentType,'application/json') !== false){
            $response = $this->encodeJson($result);
            echo $response;
        }
    }

    public function getalldoc() {
        $getall = new Mobile();
        $rawData = $getall->geAlldoc();

        if(empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => 'No Doc found!');		
        } else {
            $statusCode = 200;
        }

        $requestContentType = 'application/json';
        $this->setHttpHeaders($requestContentType, $statusCode);

        $result["output"] = $rawData;
        $result['message'] = "success";


        if(strpos($requestContentType,'application/json') !== false){
            $response = $this->encodeJson($result);
            echo $response;
        }
    }
    
    public function getmydoc() {
        $getall = new Mobile();
        $rawData = $getall->getmydoc($this->input_data['MyUser']);

        if(empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => 'No Doc found!');		
        } else {
            $statusCode = 200;
        }

        $requestContentType = 'application/json';
        $this->setHttpHeaders($requestContentType, $statusCode);

        $result["output"] = $rawData;

        if(strpos($requestContentType,'application/json') !== false){
            $response = $this->encodeJson($result);
            echo $response;
        }
    }

    public function getDocDetails() {
        $getiddoc = new Mobile();
        $rawData = $getiddoc->getDocDetails($this->input_data['Doc_id']);

        if(empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => 'No Doc found!');		
        } else {
            $statusCode = 200;
        }

        $requestContentType = 'application/json';
        $this->setHttpHeaders($requestContentType, $statusCode);

        $result["output"] = $rawData;

        if(strpos($requestContentType,'application/json') !== false){
            $response = $this->encodeJson($result);
            echo $response;
        }
    }

    public function getusers() {
        $getiddoc = new Mobile();
        $rawData = $getiddoc->getusers();

        if(empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => 'No Doc found!');		
        } else {
            $statusCode = 200;
        }

        $requestContentType = 'application/json';
        $this->setHttpHeaders($requestContentType, $statusCode);

        $result["output"] = $rawData;

        if(strpos($requestContentType,'application/json') !== false){
            $response = $this->encodeJson($result);
            echo $response;
        }
    }

    public function addNewDoc() {
        $x = new Mobile();
        $rawData = $x->addNewDoc($this->input_data['MyUser'], $this->input_data['NumberDoc'], $this->input_data['NameDoc'], $this->input_data['TypeDoc']);

        if(empty($rawData)) {
            $statusCode = 404;
        } else {
            $statusCode = 200;
        }

        $requestContentType = 'application/json';
        $this->setHttpHeaders($requestContentType, $statusCode);

        $result["output"] = $rawData;

        if(strpos($requestContentType,'application/json') !== false){
            $response = $this->encodeJson($result);
            echo $response;
        }
    }

    public function recordDocReceived() {
		require_once "dbcontroller.php";

        $db = new DBController();
        $message = $db->recordDocReceived($this->input_data['MyUser'], $this->input_data['work_id'], $this->input_data['Doc_id']);
        if(empty($message)) {
            $statusCode = 404;
            $rawData = array('error' => 'No Doc found!');		
        } else {
            $statusCode = 200;
        }
        $requestContentType = 'application/json';
        $this->setHttpHeaders($requestContentType, $statusCode);

        $result["output"] = $message;

        if(strpos($requestContentType,'application/json') !== false){
            $response = $this->encodeJson($result);
            echo $response;
        }
    }

    public function sendDoc() {
        require_once "dbcontroller.php";
        $db = new DBController();
        $message = $db->sendDoc($this->input_data['MyUser'],$this->input_data['work_id'], $this->input_data['To_Name'], $this->input_data['type_send'], $this->input_data['Notee']);

        if(empty($message)) {
            $statusCode = 404;
            $message = array('error' => 'No Doc found!');		
        } else {
            $statusCode = 200;
        }

        $requestContentType = 'application/json';
        $this->setHttpHeaders($requestContentType, $statusCode);

        $result["output"] = $message;

        if(strpos($requestContentType,'application/json') !== false){
            $response = $this->encodeJson($result);
            echo $response;
        }
    }

    public function cancel_send() {
        require_once "dbcontroller.php";
        $db = new DBController();
        $message = $db->Cancel_send($this->input_data['MyUser'],$this->input_data['work_id'], $this->input_data['To_Name'], $this->input_data['type_send'], $this->input_data['Notee']);

        if(empty($message)) {
            $statusCode = 404;
            $message = array('error' => 'No Doc found!');		
        } else {
            $statusCode = 200;
        }

        $requestContentType = 'application/json';
        $this->setHttpHeaders($requestContentType, $statusCode);

        $result["output"] = $message;

        if(strpos($requestContentType,'application/json') !== false){
            $response = $this->encodeJson($result);
            echo $response;
        }
    }

  public function verifySession() {
        require_once "dbcontroller.php";
        $db = new DBController();
        $sessionID = $this->input_data['id_key'];
        $api_key = $this->input_data['api_key'];
        // استعلم عن تواجد المعرف في قاعدة البيانات
        $query = "SELECT * FROM Users 
                  WHERE Users.id = '$sessionID' AND Users.api_key = '$api_key'";
        $result = $db->runQuery($query);
        // قارن نتيجة الاستعلام مع المعرفات المخزنة
        if ($result) {

           // echo "true";
            return true;
        } else {
            //echo "false";

            return false;
        }
    }

    public function encodeJson($responseData) {
        $jsonResponse = json_encode($responseData);
        if(json_last_error() !== JSON_ERROR_NONE){
            throw new Exception('Error encoding JSON data: '.json_last_error_msg());
        } 
        return $jsonResponse;		
    }
}
?>