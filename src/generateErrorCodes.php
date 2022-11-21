<?php
// https://curl.se/libcurl/c/libcurl-errors.html
$site = file_get_contents('./site_dump.txt');
if($site === false)
    throw new \Exception("file_get_contents('./site_dump.txt') failure");

preg_match_all('#\(([0-9-]+)\)[\s]+(.+)#', $site, $m);

$ret = [];
$delta = 0;

foreach($m[1] as $err_code)
{
  $err_code_int = (int) $err_code;
  $ret []= formatLine($err_code_int, $m[2][$err_code_int-$delta]);

  if(strlen($err_code)==5){
    // "75-76" & "50-51"
    $ret []= formatLine($err_code_int+1, $m[2][$err_code_int-$delta]);
    ++$delta;
  }
}

$code = implode(','.PHP_EOL, $ret);
$code = sprintf("<?php return [%s];%s?>", $code, PHP_EOL);
file_put_contents('./CurlyErrorMessages.php', $code);

function formatLine(int $code, string $message) : string
{
  return sprintf("%d => '%s'", $code, addslashes($message));
}
 ?>
