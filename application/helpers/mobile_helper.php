<?php

    /**
 * Validate mobile
 *
 * @access	public
 * @return	bool
 */
if ( ! function_exists('valid_mobile'))
{
	function valid_email($mobile)
	{
		return ( ! preg_match("/^1[34578]\d{9}$/", $mobile)) ? FALSE : TRUE;
	}
}

/**
*发短信
*
*
**/
if(!function_exists('verifySmsCode'))
{
	function verifySmsCode($mobile,$act='request',$code='')
	{
		$CI =& get_instance();
		if($act == 'request'){
			$remote_server = $CI->config->item('leancloud_url_request');
		}elseif($act == 'verify'){
			$remote_server = $CI->config->item('leancloud_url_verify');
			//$remote_server = 'https://api.leancloud.cn/1.1/verifySmsCode/320956?mobilePhoneNumber=15814073945';
			$remote_server .= '/'.$code.'?mobilePhoneNumber='.$mobile;
			
		}else{
			exit('未知操作');
		}
			
		$appid = $CI->config->item('leancloud_appid');
		$appkey = $CI->config->item('leancloud_key');
		$post_string = json_encode(array('mobilePhoneNumber'=>$mobile));

		$header = array(
            'Content-Type: application/json',
            'X-AVOSCloud-Application-Id: '.$appid,
            'X-AVOSCloud-Application-Key: '.$appkey,
        );

        $curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $remote_server);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_string);
		//curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
		$data = curl_exec($curl);
		curl_close($curl);

		return $data;
	}
}