<?php

function getStr($string, $start, $end){
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}

extract($_GET);
$lista = str_replace(" " , "", $lista);
$card = explode("|", $lista);
$host = $card[0];

error_reporting(0);

$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => "https://checkforcloudflare.selesti.com/api.php",
CURLOPT_POST => 1,
CURLOPT_ENCODING => 'gzip',
CURLOPT_HEADER => 0,
CURLOPT_NOBODY => 0,
CURLOPT_HTTPHEADER  => array(
    'Host: checkforcloudflare.selesti.com',
    'accept: application/json, text/javascript, */*; q=0.01',
    // 'accept-encoding: gzip, deflate, br',
    'accept-language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
    'content-type: application/x-www-form-urlencoded; charset=UTF-8',
    'cookie: _ga=GA1.2.905885844.1653960062; _gid=GA1.2.247151369.1653960062; _gat=1',
    'origin: https://checkforcloudflare.selesti.com',
    'referer: https://checkforcloudflare.selesti.com/?q=igrejajs.tk',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.67 Safari/537.36',
    'x-requested-with: XMLHttpRequest'
),
CURLOPT_FOLLOWLOCATION => 1,
CURLOPT_POSTFIELDS => 'domain='.$card[0].'',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_COOKIESESSION => 0,
CURLOPT_SSL_VERIFYPEER => 0,
CURLOPT_SSL_VERIFYHOST => 0, 
));
$result = curl_exec($curl);
curl_close($curl);
$tempo = json_decode($result)->timing;
$lc = json_decode($result)->data;
$ip = gethostbyname($host);
$ls = $lc->locationsFound;

foreach ($ls as $a) {
    
}

// print_r($ls);



if(strpos($result,'"success":true,"')){
    echo "<font size=4 color=white><span class='badge badge-success'>Aprovado!</span> <span class='badge badge-dark'>Host: ".$host." Ip: ".$ip."</span> <span class='badge badge-light'>Retornou:</span> <span class='badge badge-primary'>Host com CloudFlare</span> <span class='badge badge-warning'>Tempo: ".$tempo."</span> <span class='badge badge-info'>Países Testados: England China Denmark Germany Russia USA </span> <span class='badge badge-danger'>@FreeSourcesBR</span>";
} else {
    echo "<font size=4 color=white><span class='badge badge-danger'>Reprovado!</span> <span class='badge badge-dark'>".$host." </span> <span class='badge badge-light'>Retornou:</span> <span class='badge badge-primary'>Host sem CloudFlare</span> <span class='badge badge-danger'>@FreeSourcesBR</span>";
}

?>
