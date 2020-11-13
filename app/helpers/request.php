<?php

    function retrieve_by_get_content($list, $method, $url){
        $postdata = http_build_query($list);

        $opts = array('http' =>
            array(
                'method'  => $method,
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postdata,
            )
        );
        
        $context  = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result, true);
        
        return $result;
    }

    
    function retrieve_by_curl($list, $method, $url){         
        $curl = curl_init();
        $method = $method == 'POST' ? true : false;
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, $method);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('API_KEY:a41a0438fd6f4083f76bc83d7f6280da145c4f80'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($list)); 
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
        $result = curl_exec($curl);
        // dd(json_decode($result, true), $list, $method, $url); 
        $result = json_decode($result, true);
        curl_close($curl);
        return $result;
    }

?>