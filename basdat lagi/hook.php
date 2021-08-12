<?php 
include 'config.php';
//$path = "https://api.telegram.org/bot1902723765:AAGu_zt7qqdEX3Emu4TPunJggJ0ogCkygZk";
//$update = json_decode(file_get_contents("php://input"), TRUE);
//$chatId = $update["message"]["chat"]["id"];
//$message = $update["message"]["text"];
//if (strpos($message, "/start") === 0) {
 //   $chat = urlencode("halo perkenalkan nama saya siddiq sanjaya bakti \nDengan NIM 10119167 \n\nList Command \n /download <link yang akan didownload>\n /info untuk informasi \n\n\nDownloader Support : yt soundcloud bilibili bandcamp dailymotion instagram");
    //file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=".$chat);
    //file_get_contents($path."/sendmessage?chat_id=".$chatId."&reply_markup=aaaaa&callback_data=test.com");
  //}


//if (strpos($message, "/download") === 0) {
    $messageurl = urlencode(substr($message, 11));
    $url = "http://backend-ihsandevs.herokuapp.com/api/Youtube%20Downloader%20v2/?url_video=https://www.youtube.com/watch?v=1ArWgZuoB7g";
    $data = json_decode(file_get_contents($url), true);
    //error_reporting(0);
    //
    
    
    //get array
    $datastreaming = $data['result']['streamingData']['formats'][0];
    $expire        = ($data['result']['streamingData']['expiresInSeconds']/60);
    
    echo $urlvid        = $datastreaming['url'];
    $reso          = $datastreaming['width']."x".$datastreaming['height'];
    $title         = $data['result']['videoDetails']['title'];
    $thumnail      = $data['result']['videoDetails']['thumbnail']['thumbnails'][4]['url'];
    //sent image
    file_get_contents($path."/sendPhoto?chat_id=".$chatId."&photo=".$thumnail);
    if($datastreaming['url'] != NULL){
                $url_pendek = acak(2).substr(uniqid(), 6, 5);
                //mysqli_query($conn, "insert into url values (NULL, '$link','$url_pendek','0', NOW())");
                $linkpendek = $site."?url=".$url_pendek;
    }
    
    
    //send chat
    

    echo "<pre>";
    print_r($data);
    echo "<pre>";
//} 
?>