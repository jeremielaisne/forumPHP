<?php    
    require_once(dirname(__DIR__) ."/vendor/autoload.php");
    require_once(dirname(__DIR__) ."/common.php");

    use App\Topic;
    use App\Cookie\UserCookie;
    use App\User;

    $tab_req = ["topic" => "fvd", "message" => "ezf", "state" => false, "error" => [], "fatalError" => ""];

    $topic_content = (string) getFormVal("topic-content");
    $message_content = (string) getFormVal("message-content");

    $tab_req["topic"] = $topic_content;
    $tab_req["message"] = $message_content;
    $tab_req["state"] = true;

    echo json_encode($tab_req);
?>