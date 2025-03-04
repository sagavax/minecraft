<?php

		$tiktok_url = "https://www.tiktok.com/@fortressgames/video/6957711024975793414?is_from_webapp=1&sender_device=pc&web_id=7159114764323522053";
		
		$tiktok = "https://www.tiktok.com/oembed?url=".$tiktok_url;

		$curl = curl_init($tiktok);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    $return = curl_exec($curl);

	    if (curl_errno($curl)) {
	        echo 'Curl error: ' . curl_error($curl);
	    }

	    $data = json_decode($return, true);

	    curl_close($curl);

	    //print_r($data);
	    //echo $data['html'];
	    echo $data['title'];