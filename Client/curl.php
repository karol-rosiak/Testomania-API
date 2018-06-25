
<?php
function apiRequest($address,$requestType,$data = null){
	$ch = curl_init(); 
	$json = json_encode( $data );
	curl_setopt($ch, CURLOPT_URL, "127.0.0.1:5000/$address"); 
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $requestType);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
	if($data!=null){
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                   
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($json))                                                                       
		);   
	}
	
	$output = curl_exec($ch); 
	$httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	curl_close($ch);  
	return array("Status" => $httpStatus,"Body" => $output);
}

		
?>

