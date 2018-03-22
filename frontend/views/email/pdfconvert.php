<?php
$apikey = ' f5d13534-e4be-4be6-a9eb-009142b2bea2';
$value = "<html><body><div style='border:1px solid;width:100%;'><div style='width:49%;border:1px solid;float:left;color:red;'>id</div></div><br></body></html>";
$result = file_get_contents("http://api.html2pdfrocket.com/pdf?apikey=" . urlencode($apikey) . "&value=" . urlencode($value));
file_put_contents('../mypdf.pdf',$result);
?>

