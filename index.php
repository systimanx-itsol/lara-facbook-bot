<?php
// parameters
$verifyToken="larabot-token-verify";

$hubVerifyToken = null;
$accessToken =   "EAAYCXyd40oIBAFxejIDsTHwxwHV6Y5Ks1HdmTnrORSxoyXj7xoiCB92ZCRTvaN6x2OcNeZBLlZAsYaFAxuwPWfjQ7JTpiJX4JIIZBlGXPHh3L7oeYigbBElrQgNZBg8j7EKOp6wAqYzZARoKxKdlSrhNtXWOX5Qoio9dQhkUmx8wb2W8BZA6qZBWj6ZBo2JByQv8ZD";

if(isset($_REQUEST['hub_mode']) && $_REQUEST['hub_mode']=="subscribe")
{
  $challange=$_REQUEST['hub_challenge'];
  $hub_verify_token=$_REQUEST['hub_verify_token'];
  if($hub_verify_token===$verifyToken)
  { 
    header("HTTP/1.1 200 OK");
    echo $challange;
    die;
  }
}

// handle bot's anwser
$input = json_decode(file_get_contents('php://input'), true);
$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = isset($input['entry'][0]['messaging'][0]['message']['text'])?$input['entry'][0]['messaging'][0]['message']['text']:'';
//$response = null;
//set Message
if($message) {
    $message_to_replay = "Hello";
    $url='https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken;
    $jsonData='{
                  "recipient":{
                                "id":"'.$sender.'"
                              },
                  "message":{
                                "text":"'.$message_to_replay.'"
                              }

               }';


$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
$result = curl_exec($ch);
curl_close($ch);
}
 

 
?>
