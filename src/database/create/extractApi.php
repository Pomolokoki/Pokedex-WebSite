<?php

// $baseUrl = 'https://pokeapi.co/api/v2';
// $curl_handle = curl_init();
// curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($curl_handle, CURLOPT_HEADER, false);
// function getDataFromApi($curl, $where)
// {
//     curl_setopt($curl, CURLOPT_URL, $where);
//     $curl_data = curl_exec($curl);
//     // if (curl_errno($curl_handle)) {
//     //     echo 'Error: ' . curl_error($ch);
//     //     return false;
//     // }
//     $data = json_decode($curl_data);
//     //echo $data;
//     //echo '<br>';
//     //echo print_r(array_keys((array)$data));
//     return $data;
// }


function getDataFromFile($path, $usebasePath = true)
{
    if ($usebasePath)
    {

        static $basePath = '../../../v2';
        if (file_exists($basePath . $path . '/index.json'))
        {
            return json_decode(file_get_contents($basePath . $path . '/index.json'));
        }   
    }
    else
    {
        if (file_exists($path))
        {
            return json_decode(file_get_contents($path));
        } 
    }
}

include_once 'getDataFunction.php';
