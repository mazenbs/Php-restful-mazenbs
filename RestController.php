<?php
require_once "MobileRestHandler.php";

// تحديد نوع الطلب
$request_method = $_SERVER['REQUEST_METHOD'];

// التحقق من صحة الطلب
if ($request_method === 'POST') {
    // قراءة المدخلات وضبط القيم الافتراضية
    $input_data = [
        'view' => '',
        'MyUser' => '',
        'work_id' => '',
        'Doc_id' => '',
        'NumberDoc' => '',
        'NameDoc' => '',
        'TypeDoc' => '',
        'To_Name' => '',
        'Notee' => '',
        'api_key' => '',
        'id_key' => '',
        'type_send' => ''
    ];

    foreach ($input_data as $key => $default_value) {
        if (isset($_POST[$key])) {
            if (is_numeric($_POST[$key])) {
                $input_data[$key] = intval($_POST[$key]);
            } else {
                $input_data[$key] = $_POST[$key];
            }
        }
    }

    // إنشاء كائن من الكلاس
    $mobileRestHandler = new MobileRestHandler();

    // تمرير المدخلات إلى الكائن
    $mobileRestHandler->setInputData($input_data);

    $checkkey = $mobileRestHandler->verifySession();
if ($checkkey) {

    // تحديد العملية المطلوبة
    $view = $input_data['view'];
    switch ($view) {
        case "all":
            // Handle REST Url /mobile/list/
            $mobileRestHandler->getAllReceivedDocs();
            break;
        case "getalldoc":
            // Handle REST Url /mobile/list/
            $mobileRestHandler->getalldoc();
            break;
        case "get_mydoc":
            // انشاء تقرير كم عدد المعاملات المستلمة في الادارة
            $mobileRestHandler->getmydoc();
            break;
        case "get_mydoc_M":
            // انشاء تقرير شهري كم عدد المعاملات المستلمة في الادارة
            $mobileRestHandler->getmydoc();
            break;
        case "NewDoc":
            // Handle REST Url /mobile/show/<id>/
            $mobileRestHandler->addNewDoc();
            break;
        case "getdocid":
            $mobileRestHandler->getDocDetails();
            break;
        case "RecDoc":
            $mobileRestHandler->recordDocReceived();
            break;
        case "SEND":
            $mobileRestHandler->sendDoc();
            break;
        case "CANCEL_SEND":
            $mobileRestHandler->cancel_send();
            break;
        case "GETUSERS":
            $mobileRestHandler->getusers();
            break;
        case "CHECKAPI":
            $mobileRestHandler->verifySession();
            break;
        default:
            //404 - not found;
            http_response_code(404);
            exit("العملية '$view' غير معرفة");
            break;
    
    }
}else{
    exit("الجلسة انتهت او ان المعرف غير صحيح ");

}

} else {
    http_response_code(405);
    exit("الطلبات '$request_method' غير مدعومة");
}
?>