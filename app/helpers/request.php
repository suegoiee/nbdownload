<?php
    function retrieve_data($list, $method, $url){
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
?>