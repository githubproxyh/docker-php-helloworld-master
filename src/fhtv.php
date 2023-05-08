<?php
// 请求接口 URL
$url = 'https://nine.ifeng.com/PhoenixTvDelay?gv=7.65.0&av=0&proid=ifengnews&day='.date('Y-m-d').'&index=37&phtvType=';

// 根据输入参数获取对应的直播流类型
if ($_GET['id'] == 'phtvNews') {
  $phtvType = 'phtvNews';
} else if ($_GET['id'] == 'phtvChinese') {
  $phtvType = 'phtvChinese';
} else {
  die('Invalid input parameter.');
}

// 发送 HTTP 请求
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url.$phtvType);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_4_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Mobile/14E304');
$response = curl_exec($ch);
curl_close($ch);

// 解析响应体
$data = json_decode($response, true);
if ($data['code'] != 0) {
  die('Error: '.$data['msg']);
}

// 跳转播放链接进行播放
header('Location: '.$data['data']['m3u8']);
?>