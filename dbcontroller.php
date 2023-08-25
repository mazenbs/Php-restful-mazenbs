<?php
class DBController {
	private $host = "sql304.infinityfree.com";
	private $user = "if0_34543480";
	private $password = "CeaYargmkASN5R";
	private $database = "if0_34543480_mazenbs";
	private $conn;

	function __construct() {
		$this->conn = $this->connectDB();
	}

	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		return $conn;
	}

	function runQuery($query) {
		$result = mysqli_query($this->conn,$query);
		if (!$result) {
			die("Query failed: " . mysqli_error($this->conn));
		}
		$resultset = [];
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}
		return $resultset;
	}



function runx2Query($query) {
    $result = mysqli_query($this->conn, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($this->conn));
    }

	if ($result->num_rows > 0) {
		$data = array();
	$data = array();
	
    while ($row = $result->fetch_assoc()) {
		$id = $row['id'];
		
		$TypeDoc = $row['TypeDoc'];
		$User_send = $row['User_send'];
		$Date_send = $row['Date_send'];
        $send_name = $row['send_name'];

		$User_rec = $row['User_rec'];
		$Date_rec = $row['Date_rec'];
		$rec_name = $row['rec_name'];

		$request_stat = $row['request_stat'];
		$request_done = $row['request_done'];
		$type_send = $row['type_send'];
		$bool_set = $row['bool_set'];
		$Date_add_doc = $row['Date_add_doc'];
        $NumberDoc = $row['NumberDoc'];
        $NameDoc = $row['NameDoc'];
		$tmp_rec = $row['tmp_rec'];
		$tmpr_name = $row['tmpr_name'];
        $tmp_date_rec = $row['tmp_date_rec'];

        if (!isset($data[$id])) {
            $data[$id] = array(
				'Date_add_doc' => $Date_add_doc,				
				'NumberDoc' => $NumberDoc,				
				'NameDoc' => $NameDoc,
				'TypeDoc' => $TypeDoc,				
                'visits' => array()
			);
        }

        

        $visit = array(
			'User_send' => $User_send,
			'send_name' => $send_name,
			'Date_send' => $Date_send,
			'User_rec' => $User_rec,
			'rec_name' => $rec_name,
			'Date_rec' => $Date_rec,
			'tmp_rec' => $tmp_rec,
			'tmpr_name' => $tmpr_name,
            'tmp_date_rec' => $tmp_date_rec,
			'request_stat' => $request_stat,
			'request_done' => $request_done,
			'type_send' => $type_send,
			'bool_set' => $bool_set
        );

		$data[$id]['visits'][] = $visit;
    }

    return $data;
}


}




	
	function runFQuery($MyUser, $number_doc, $name_doc, $type_doc) {
		$NumberDoc = mysqli_real_escape_string($this->conn, $number_doc);
		$NameDoc = mysqli_real_escape_string($this->conn, $name_doc);
		$TypeDoc = mysqli_real_escape_string($this->conn, $type_doc);
	
		// إدخال البيانات إلى جدول SRC
		$sql = "INSERT INTO SRC (Date_add_doc, NumberDoc, NameDoc, TypeDoc) 
				VALUES (NOW(), '$NumberDoc', '$NameDoc', '$TypeDoc')";
		$result = mysqli_query($this->conn, $sql);
	
		if ($result) {
			// الحصول على الرقم المعرف الخاص بالملف الذي تم إدخاله في جدول SRC
			$Doc_id = mysqli_insert_id($this->conn);
	
			// إدخال البيانات إلى جدول work
			$User_send = mysqli_real_escape_string($this->conn, "SRC");
			$sql = "INSERT INTO work (Doc_id, User_send, Date_send, User_rec, Date_rec, tmp_rec , tmp_date_rec, request_stat, request_done, type_send, bool_set, note) 
					VALUES ('$Doc_id', $MyUser, NOW(), 1, NOW(), 1, NULL, '1', '0', NULL, '1', NULL)";
			$result = mysqli_query($this->conn, $sql);
	
			if ($result) {
				// عرض محتوى الجدولين للرقم المعرف الذي تم إدخاله باستخدام JOIN
				$sql = "SELECT SRC.*, work.*
						FROM SRC 
						JOIN work ON SRC.id=work.Doc_id WHERE SRC.id='$Doc_id'";
				$result = mysqli_query($this->conn, $sql);
				if (!$result) {
					die("Query failed: " . mysqli_error($this->conn));
				}
				$row = mysqli_fetch_assoc($result);
				$response['row'] = $row;
				$response['error'] = "200";
       			$response['message'] = "Registration successful!";
				return $response;

			} else {
				
				die("Query failed: " . mysqli_error($this->conn));
			}
		} else {
			die("Query failed: " . mysqli_error($this->conn));
		}
	
		// إغلاق الاتصال بقاعدة البيانات
		mysqli_close($this->conn);
	}



	function recordDocReceived($MyUser, $work_id, $Doc_id) {
		$sql_select = "SELECT work.*, SRC.*
					   FROM SRC JOIN work ON SRC.id=work.Doc_id WHERE work._ID='$work_id'";
		$result = mysqli_query($this->conn, $sql_select);
	
		if (!$result) {
			die("Query failed: " . mysqli_error($this->conn));
		}
	
		$row = mysqli_fetch_assoc($result);
		$notg = $row["note"];
		$sendU = $row["User_send"];
		$recU = $row["User_rec"];
		

	
		$sql_update = "UPDATE work SET tmp_date_rec = NOW(), request_stat = '0', 
					   request_done = '0', bool_set = '0' 
					   WHERE _ID='$work_id'";
		$result = mysqli_query($this->conn, $sql_update);
	
		if (!$result) {
			die("Query failed: " . mysqli_error($this->conn));
		}
	
		$num_affected_rows = mysqli_affected_rows($this->conn);
	
		if ($num_affected_rows == 0) {
			die("No rows updated");
		} else {
			$sql = "INSERT INTO work (Doc_id, User_send, Date_send, User_rec, Date_rec, tmp_rec, tmp_date_rec, request_stat, request_done, type_send, bool_set, note) 
					VALUES ('$Doc_id', '$recU', NOW(), '$MyUser', NOW(), NULL, NULL, '1', '0', NULL, '1', '$notg')";
			$result = mysqli_query($this->conn, $sql);
	
			if (!$result) {
				die("Query failed: " . mysqli_error($this->conn));
			}
	
			$num_affected_rows = mysqli_affected_rows($this->conn);
	
			if ($num_affected_rows == 0) {
				die("No rows inserted");
			}
	
			    $response['row'] = $row;
				$response['error'] = "200";
       			$response['message'] = "success";
				return $response;
		}
	}



	function sendDoc($MyUser, $work_id, $to_user, $type, $note) {
    // التحقق من وجود قيم لكل متغير وتعيين قيمة null لأي متغير لا يحتوي على قيمة
    $MyUser = isset($MyUser) ? intval($MyUser) : null;
    $work_id = isset($work_id) ? intval($work_id) : null;
    $to_user = isset($to_user) ? intval($to_user) : null;
    $type = isset($type) ? $type : null;
    $note = isset($note) ? $note : null;
    
    // التحقق من أن $work_id صحيح
    if (!is_numeric($work_id)) {
        return;
    }
    
    $sql_update = "UPDATE work SET tmp_rec = '$to_user', tmp_date_rec = NOW(), request_stat = '$MyUser', request_done = 1, bool_set = 1, type_send = '$type', note = '$note' WHERE _ID = '$work_id'";
    $result = mysqli_query($this->conn, $sql_update);
    if ($result) {
        $response['row'] = mysqli_affected_rows($this->conn);
        $response['error'] = "200";
        $response['message'] = "success";
        return $response;
    } else {
        $error_message = mysqli_error($this->conn);
        echo "<p>حدث خطأ أثناء تحديث السجل: " . $error_message . "</p>";
        $response['row'] = 0;
        $response['error'] = "500";
        $response['message'] = "failure";
        $response['reason'] = $error_message;
        return $response;
    }
}

function Cancel_send($MyUser, $work_id, $to_user, $type, $note) {
    // التحقق من وجود قيم لكل متغير وتعيين قيمة null لأي متغير لا يحتوي على قيمة
    $MyUser = isset($MyUser) ? intval($MyUser) : null;
    $work_id = isset($work_id) ? intval($work_id) : null;
    $to_user = isset($to_user) ? intval($to_user) : null;
    $type = isset($type) ? $type : null;
    $note = isset($note) ? $note : null;
    
    // التحقق من أن $work_id صحيح
    if (!is_numeric($work_id)) {
        return;
    }
	
$sql_select = "SELECT bool_set FROM work WHERE _ID = '$work_id'";
$result = mysqli_query($this->conn, $sql_select);
$row = mysqli_fetch_assoc($result);
$boolSet = $row['bool_set'];

if ($boolSet != 0) {
    $sql_update = "UPDATE work SET tmp_rec = NULL, tmp_date_rec = NULL, request_stat = 1, request_done = 0, bool_set = 1, type_send = NULL, note = NULL 
	WHERE _ID = '$work_id' AND bool_set = 1";
    $result = mysqli_query($this->conn, $sql_update);
    
    if ($result) {
        $response['row'] = mysqli_affected_rows($this->conn);
        $response['error'] = "200";
        $response['message'] = "success";
        return $response;
    } else {
        $error_message = mysqli_error($this->conn);
        $response['row'] = 0;
        $response['error'] = "500";
        $response['message'] = "failure";
        $response['reason'] = $error_message;
        return $response;
	}
}else {
    $error_message = mysqli_error($this->conn);
    $response['row'] = 0;
    $response['error'] = "500";
    $response['message'] = "failure";
    $response['reason'] = $error_message;
    return $response;
}
}
	
	




	function numRows($query) {
		$result  = mysqli_query($this->conn,$query);
		if (!$result) {
			die("Query failed: " . mysqli_error($this->conn));
		}
		$rowcount = mysqli_num_rows($result);
		return $rowcount;
	}
	
}

?>
