<?php
$files = glob("*.mp3");
for ($x=0; $x < count($files); $x++) {
  $filePath =  $files[$x];
  $strContext=stream_context_create(
    array(
      'http'=>array(
        'method'=>'GET',
        'header' => 'Icy-MetaData: 1',
        'header'=>"Accept-language: en\r\n"
        )
      )
    );

  $fl = $filePath; 
  echo $x.' track '.$fl.  ' Size - '.filesize($fl).' b</br>';
}
?>