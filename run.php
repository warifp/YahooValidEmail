<?php
echo "Email\t\t: ";
$list = trim(fgets(STDIN));

$file = file_get_contents("$list");
$data = explode("\n", str_replace("\r", "", $file));
$x = 0;
for ($a = 0; $a < count($data); $a++) {
    $email   = $data[$a];
    $x++;
     
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://widhitools.000webhostapp.com/api/yahoo.php?email='.$email);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    
    $headers   = array();
    $headers[] = 'Connection: Keep-Alive';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $result = curl_exec($ch);
    $hasil = json_decode($result);
    curl_close($ch);

    if($hasil->status === "live"){
        $x = fopen("LIVE.txt", "a+");
        fwrite($x, $email."\r\n");
    }else{
        $x = fopen("DEAD.txt", "a+");
        fwrite($x, $email."\r\n");
    }
    echo "\e[1;90m$x.\e[0m \e[1;92m$email \t| \e[1;91m".$hasil->status."\e[0m\n";
}
?>
