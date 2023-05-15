<?php //云南易视腾切片代理源码
/*
使用方法：php?id={} (不带id参数可输出频道列表)

备用接口：
http://looktvepg.yna.bcs.ottcn.c ... tml?templateId=0691
http://looktvepg.yna.bcs.ottcn.c ... tml?templateId=0871
http://looktvepg.yna.bcs.ottcn.c ... tml?templateId=0872
http://looktvepg.yna.bcs.ottcn.c ... tml?templateId=0883
http://looktvepg.yna.bcs.ottcn.c ... tml?templateId=0887
http://looktvepg.yna.bcs.ottcn.c ... tml?templateId=0888
*/

$id = $_GET['id'];

$api = 'http://looktvepg.yna.bcs.ottcn.com:8080/ysten-lvoms-epg/epg/getChannels.shtml?templateId=0691';
$host = 'http://39.130.133.120:8085';
$php = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on" ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]";

if (is_null($id) && is_null($_GET['ts'])) {
  $data = file_get_contents($api);
  $json = json_decode($data);

  header('Content-Type: text/plain; charset=UTF-8');
  foreach ($json as $v) {
    echo $v -> channelName . ",$php?id=" . $v -> urlid . PHP_EOL;
  }

  exit;
}

switch ($_GET['fmt'] ?? 'hls') {
  case 'hls':
    $data = file_get_contents($api);
    $json = json_decode($data);

    foreach ($json as $v) {
      if($id == $v -> urlid) {
        $playurl = $v -> livePlayUrl;
        break;
      }
    }

    $m3u8 = preg_replace('/(http):\/\/([^\/]+)/i', $host, $playurl);
    echo preg_replace("/(.*?.ts)/i", $php."?fmt=ts&ts=$1", m3u8($m3u8));
    exit;

  case 'ts':
    header("Content-type: video/mp2t");
    ts($_GET['ts']);
    exit;
}

function m3u8($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($ch, CURLOPT_HTTPHEADER, ['User-Agent: 0151']);
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}

function ts($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($ch, CURLOPT_HTTPHEADER, ['User-Agent: 0151']);
  $result = curl_exec($ch);
  curl_close($ch);
}
?>