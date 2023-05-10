<?php
// 指定请求头地址和 m3u8 链接
$header_url = "http://www.macaulotustv.cc/index.php/index/live.html";
$m3u8_url = "http://live-hls.macaulotustv.com/lotustv/macaulotustv.m3u8";
// 模拟请求头
$headers = array(
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36",
    "Referer: http://www.macaulotustv.cc/",
    "Accept-Language: en-US,en;q=0.9",
);
// 初始化cURL请求
$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_URL => $m3u8_url,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_REFERER => $header_url,
));
$response = curl_exec($ch);
curl_close($ch);
// 指定响应头内容并输出m3u8
header("Content-Type: application/x-mpegURL");
header('Content-Disposition: inline; filename=index.m3u8');
echo $response;
?>