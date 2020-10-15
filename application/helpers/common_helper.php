<?php

function curlGet($data)
    {

        $url = $data['url'];
        $postFields = isset($data['postfields']) ? $data['postfields'] : [];
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_POSTFIELDS => json_encode($postFields),
          CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return FALSE;
        }

        return $response;
    }




?>