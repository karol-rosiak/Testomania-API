<?php
header('Content-type: application/json');
	   // create curl resource 
        $ch = curl_init(); 

        // set url 
        curl_setopt($ch, CURLOPT_URL, "127.0.0.1:5000/questions/one"); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 
		
        // close curl resource to free up system resources 
        curl_close($ch);  
		
		echo $output;
?>