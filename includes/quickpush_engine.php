<?php
function quickpushme($AppID, $RestApiKey, $Message, $sendToChannels = null, $JoeJson = false) {
    $url = 'https://onesignal.com/api/v1/notifications';
    $fields = array(
        'app_id' => $AppID,
        'included_segments' => $sendToChannels,
    );
    if($JoeJson){
        $fields['headings'] = array(
            "en" => $Message['title']
        );
        $fields['contents'] = array(
            "en" => $Message['content']
        );
        $fields['data'] = array("opUrl" => $Message['url']);
    } else {
        $fields['contents'] = array(
            "en" => $Message['title']
        );
    }
    // var_dump($fields);
    $fields = json_encode($fields);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                               'Authorization: Basic '.$RestApiKey));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
    // var_dump($response);
}
?>