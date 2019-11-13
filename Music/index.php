<?php
set_time_limit(0);
header('Content-type: audio/mpeg');
header("Content-Transfer-Encoding: binary");
header("Pragma: no-cache");
header("icy-br: 128 ");
header("icy-name: your name");
header("icy-description: your description"); 

$files = glob("*.mp3");
shuffle($files); //Random on

for ($x=0; $x < count($files);) {
  $filePath =  $files[$x++];
  $bitrate = 128;
  $strContext=stream_context_create(
   array(
     'http'=>array(
       'method' =>'GET',
       'header' =>'Icy-MetaData: 1',
       'header' =>'Accept-language: en\r\n'
       )
     )
   );

//Save to log 
  $fl = $filePath; 
  $log = date('Y-m-d H:i:s') . ' Song - ' . $fl;
  file_put_contents('log.txt', $log . PHP_EOL, FILE_APPEND);
  $fpOrigin=fopen($filePath, 'rb', false, $strContext);
  while(!feof($fpOrigin)){
   $buffer=fread($fpOrigin, 4096);
   echo $buffer;
   flush();
 }
 fclose($fpOrigin);
}
?>
