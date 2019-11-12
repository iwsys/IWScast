<?php
set_time_limit(0);

header('Content-type: audio/mpeg');
header("Content-Transfer-Encoding: binary");
header("Pragma: no-cache");
header("icy-br: 128 ");
header("icy-notice1: (c) Created 07.10.2019");
header("icy-name: your name");
header("icy-url:"."yoursite.com");
header("icy-genre:"."PODCAST");

$dirPath = "";
$files = glob("*.mp3");
$filename = "counter.dat";      
if(file_exists($filename)){     
  $fp = fopen($filename,"r");     
  if ($fp) {                      
    $counter = fgets($fp,3);       
    fclose($fp);                    
  } else {                        
    $counter = 0;                   
  }
}

if ($counter >= count($files)) $counter=0;
$filecounter = $counter;
 header("icy-description: ".$files[$counter]);
 header("icy-notice1: Time start ".date("H:i:s"));
 header("icy-notice2: Track ".++$filecounter." from ".count($files));

for ($x=$counter; $x < count($files); $x++) {
  $filePath =  $files[$x];
  $bitrate = 128;
  $strContext=stream_context_create(
   array(
     'http'=>array(
       'method' =>'GET',
       'header' => 'Icy-MetaData: 1',
       'header' =>"Accept-language: en\r\n"
       )
     )
   );

  $fl = $filePath; 

  $fp = @fopen($filename,"w");    
  if ($fp) {                      
    $d = $x;
    $d++;
    $counter = fputs($fp,$d); 
    fclose($fp);                    
  }

//Save to log 
  $log = date('Y-m-d H:i:s') . ' Song - '.'counter '.$d.' '. $fl;
  file_put_contents('log.txt', $log .' size '. filesize($fl).' b'.PHP_EOL, FILE_APPEND);
//Out mp3
  $fpOrigin=fopen($filePath, 'rb', false, $strContext);
  while(!feof($fpOrigin)){
   $buffer=fread($fpOrigin, 4096);
   echo $buffer;
   flush();
 }
 fclose($fpOrigin);
}
?>
