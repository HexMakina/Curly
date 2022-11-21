<?php
namespace HexMakina\Curly;

class Curly
{
  private $curl_handle; // before PHP8
  private ?string $url;
  
  public function __construct(array $options=[])
  {
      $options['HTTPHEADER'] ??= $this->defaultHeader();

      $options['USERAGENT'] ??= 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36';

      $this->curl_handle = curl_init();
      curl_setopt($this->curl_handle, CURLOPT_URL, $url);
      curl_setopt($this->curl_handle, CURLOPT_USERAGENT,      $options['USERAGENT']);
      curl_setopt($this->curl_handle, CURLOPT_HTTPHEADER,     $options['HTTPHEADER']);
      curl_setopt($this->curl_handle, CURLOPT_AUTOREFERER,    $options['AUTOREFERER'] ?? true);
      curl_setopt($this->curl_handle, CURLOPT_RETURNTRANSFER, $options['RETURNTRANSFER'] ?? 1);
      curl_setopt($this->curl_handle, CURLOPT_FOLLOWLOCATION, $options['FOLLOWLOCATION'] ?? 1);
      curl_setopt($this->curl_handle, CURLOPT_ENCODING,       $options['ENCODING'] ?? 'gzip,deflate');
      curl_setopt($this->curl_handle, CURLOPT_TIMEOUT,        $options['TIMEOUT'] ?? 20);

      $this->curl_handle = self::initWithOptions($url);
  }

  public function disguise(string $user_agent)
  {
      // $user_agent ??= 'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.11) Gecko/2009060215 Firefox/3.0.11 (.NET CLR 3.5.30729)';
      // $user_agent ??= 'Mozilla/5.0 (Linux; Android 4.0.4; Galaxy Nexus Build/IMM76B) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.133 Mobile Safari/535.19';

    curl_setopt($this->curl_handle, CURLOPT_USERAGENT,      $user_agent);
  }

  public function fetch($url)
  {
    $this->curl_handle = self::initWithOptions($url);

    $result = curl_exec($this->curl_handle);
    curl_close ($this->curl_handle);
    return $result;
  }

  public function fetchToFile($url, string $path)
  {
    $fp = fopen($path, "wb");

    curl_setopt($this->curl_handle, CURLOPT_FILE, $fp);
    curl_setopt($this->curl_handle, CURLOPT_HEADER, 0);

    curl_exec($this->curl_handle);
    curl_close($this->curl_handle);
    fclose($fp);
  }

  private function defaultHeader() : array
  {
    $ret = [];

    $ret []= 'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5';
    $ret []= 'Cache-Control: max-age=0';
    $ret []= 'Connection: keep-alive';
    $ret []= 'Keep-Alive: 300';
    $ret []= 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7';
    $ret []= 'Accept-Language: en-us,en;q=0.5';
    $ret []= 'Pragma: ';

    return $ret;
  }
}
?>
