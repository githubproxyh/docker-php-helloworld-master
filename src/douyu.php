<?php
$id = $_GET[ 'id' ];
        /**
    $bstrURL = 'https://wxapp.douyucdn.cn/api/nc/stream/roomPlayer';
    $postData = "room_id=$id&big_ct=cpn-androidmpro&did=10000000000000000000000000001501&mt=2&rate=1";
        **/
$bstrURL = 'https://wxapp.douyucdn.cn/Livenc/Getplayer/newRoomPlayer';
$postData = 'room_id=' . $id . '&token=wxapp&rate=1&did=10000000000000000000000000001501&big_ct=cpn-androidinpro&is_Mix=false';
$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $bstrURL );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
curl_setopt( $ch, CURLOPT_POST, TRUE );
curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0" );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $postData );
$data = curl_exec( $ch );
curl_close( $ch );

        /**
        $url = preg_split('/&token=/',$json->data->live_url)[0];
        header('location:'.$url);
        **/
$url = json_decode( $data )->data->hls_url;
$hlsName = explode( '_', basename( parse_url( $url, PHP_URL_PATH ) ) );
$playURL = 'https://openhls-tct.douyucdn2.cn/live/' . $hlsName[ 0 ] . '.m3u8';
header( 'location:' . $playURL );
?>
