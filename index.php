<?php

$json = '[{"SKU":"ipd", "Name" : "Super iPad", "Price" : "549.99"},
{"SKU" :"mbp", "Name" : "Macbook Pro", "Price" : "1399.99"},
{"SKU" :"atv", "Name" : "Apple TV", "Price" : "109.50"},
{"SKU" :"vga", "Name" : "VGA adapter", "Price" : "30"}]';

$decode_data = json_decode($json);
//atv, atv, atv, vga
// mbp, vga, ipd
// atv, ipd, ipd, atv, ipd, ipd, ipd
$scan = ["atv", "atv", "atv", "vga"];   // Scan SKU

echo "Scan :";
foreach($scan as $scan_val) {
	echo $scan_val." " ;
}
echo "<br>Total : $".total($scan,$decode_data);  // Run Function



function total($scan, $decode_data) {
	$length = count($scan);
	$total_atv = 0;
	$total_ipd = 0;
	$price = 0;
	for ($i = 0; $i < $length; $i++) {
		for($j=0; $j<count($decode_data);$j++) {
			if($scan[$i]==$decode_data[$j]->SKU) {
				if($scan[$i]==="atv") {
					$total_atv++;
					if($total_atv===3) {
						$price = $decode_data[$j]->Price*2;
					}
					else {
						$price = $decode_data[$j]->Price+$price;
					}
				}
				if($scan[$i]==="vga") {
					
					if(is_free_vga($scan,$length)==1) {
						$price = 0+$price;
					}
					else {
						$price = $decode_data[$j]->Price+$price;
					}
					
				}
				if($scan[$i]==="ipd") {
					
					$total_ipd = 0;
					for ($l = 0; $l < $length; $l++) {
						if($scan[$l]==="ipd") {  
							$total_ipd++;
						}
					}
					if($total_ipd>4) {
						$ipd_price = 499.99;
					}
					else {
						$ipd_price =  $decode_data[$j]->Price;
					
					}
					$price = $ipd_price+$price;
				
				}
				if($scan[$i]==="mbp") {
						$price = $decode_data[$j]->Price+$price;
				}
			}
		}
	}
	return $price;
}


function is_free_vga($scan, $length) {
	$free_vga=0;
	for ($k = 0; $k < $length; $k++) {
		if($scan[$k]==="mbp") {  // sold mbp = free vga
			$free_vga = 1;
		}
	}
	return $free_vga;
}

?>