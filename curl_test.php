<?php 
//curlセッション開始
$ch = curl_init();
//通信オプション設定
curl_setopt($ch,CURLOPT_URL,"https://zipcloud.ibsnet.co.jp/api/search?zipcode=5300003"); //接続先設定
//返り値の設定。第三引数をtrueにすることでサーバから取得した情報を保存する設定に切り替えられる
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); 
//リクエスト&結果受信
$data = curl_exec($ch);
//curlセッション終了
curl_close($ch);
?>

<pre>
    <?php var_dump(json_decode($data)); ?>
</pre>