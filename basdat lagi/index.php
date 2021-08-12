<?php
  ob_start();
// Memanggil file config.php
  include("config.php");
  
  // Mengambil url pendek pada address bar
  $url = $_GET['url'];
// Mengambil data dari database "url" yang sesuai dengan variabel $url
  $sql_url 	= mysqli_query($conn,"select * from url where url_pendek = '$url'");
// Menampilkan hasil $sql_url menjadi array berbentuk object
  $url_row 	= mysqli_fetch_object($sql_url);
// Menampilkan hasil $sql_url menjadi angkan atau menghitung semua data yang ada pada tabel "url"
  $cek = mysqli_num_rows($sql_url);
// Jika url pendek ada pada tabel url
  if($cek > 0){
    // Menambah 1 point pada field hit
    mysqli_query($conn, "update url set hit = '$url_row->hit'+1 where id = '$url_row->id'");
// Mengalihkan ke url asli dari url pendek
    header("location: $url_row->url_asli");
// Jika url pendek tidak terdapat pada tabel url
  }else{
    echo "<h1>URL Tidak ditemukan :(</h1>";
  }

    $response = "Hello";

    $keyboard = [
    'inline_keyboard' => [
        [
            ['text' => 'COMMANDS', 'callback_data' => 'someString']
        ]
    ]
];
$encodedKeyboard = json_encode($keyboard);
$parameters = 
    array(
        'chat_id' => $chatId, 
        'text' => $response, 
        'reply_markup' => $encodedKeyboard
    );

send('sendMessage', $parameters);
}

function send($method, $data)
{
    $url = $path. "/" . $method;

    if (!$curld = curl_init()) {
        exit;
    }
    curl_setopt($curld, CURLOPT_POST, true);
    curl_setopt($curld, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curld, CURLOPT_URL, $url);
    curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($curld);
    curl_close($curld);
    return $output;
}
function sendMessage ($chatId, $message){
  $url = $GLOBALS[website]."/sendMessage?chat_id=".$chatId."&text=".$message."&reply_to_message_id=".$message_id."&parse_mode=HTML";
  file_get_contents($url); 



?>