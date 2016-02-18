<?php

/* GetTimeShow $time的人性化显示 */
function GetTimeShow($time=0){
	$diff=time()-$time;
	$num=0;
	$unit='';
	if($diff<60){
		$num=$diff;
		$unit='秒';
	}elseif($diff<3600){
		$num=intval($diff/60);
		$unit='分钟';
	}elseif($diff<86400){
		$num=intval($diff/3600);
		$unit='小时';
	}elseif($diff<2592000){
		$num=intval($diff/86400);
		$unit='天';
	}elseif($diff<31104000){
		$num=intval($diff/2592000);
		$unit='月';
	}else{
		$num=intval($diff/31104000);
		$unit='年';
	}
	return $num.$unit.'前';
}

//post请求
    // $post_string = "app=request&version=beta";
    function request_by_curl($remote_server, $post_string)
	{
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $remote_server);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_USERAGENT, "Jimmy's CURL Example beta");
	    $data = curl_exec($ch);
	    curl_close($ch);
	    return $data;
	}
