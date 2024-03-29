<?php

namespace HexMakina\Curly;

class Curly
{
  /**
   * @var resource
   */
    private $curl_handle;

  /**
   * @param array<string,string> $options
   */
    public function __construct(string $url, array $options = [])
    {
        $options['HTTPHEADER'] ??= $this->defaultHeader();

        $options['USERAGENT'] ??= 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36';

        $this->curl_handle = curl_init();
        curl_setopt($this->curl_handle, CURLOPT_URL, $url);
        curl_setopt($this->curl_handle, CURLOPT_USERAGENT, $options['USERAGENT']);
        curl_setopt($this->curl_handle, CURLOPT_HTTPHEADER, $options['HTTPHEADER']);
        curl_setopt($this->curl_handle, CURLOPT_AUTOREFERER, $options['AUTOREFERER'] ?? true);
        curl_setopt($this->curl_handle, CURLOPT_RETURNTRANSFER, $options['RETURNTRANSFER'] ?? 1);
        curl_setopt($this->curl_handle, CURLOPT_FOLLOWLOCATION, $options['FOLLOWLOCATION'] ?? 1);
        curl_setopt($this->curl_handle, CURLOPT_ENCODING, $options['ENCODING'] ?? 'gzip,deflate');
        curl_setopt($this->curl_handle, CURLOPT_TIMEOUT, $options['TIMEOUT'] ?? 20);
    }

    public function disguise(string $user_agent): void
    {
        // $user_agent ??= 'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.11) Gecko/2009060215 Firefox/3.0.11 (.NET CLR 3.5.30729)';
        // $user_agent ??= 'Mozilla/5.0 (Linux; Android 4.0.4; Galaxy Nexus Build/IMM76B) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.133 Mobile Safari/535.19';

        curl_setopt($this->curl_handle, CURLOPT_USERAGENT, $user_agent);
    }

    public function fetch(): string
    {
        $result = curl_exec($this->curl_handle);
        curl_close($this->curl_handle);

        return is_bool($result) ? '' : $result;
    }

    public function errno(): int
    {
        return curl_errno($this->curl_handle);
    }

    public function error(): string
    {
        if (!file_exists('CurlyErrorMessages.php')) {
            self::generateErrorMessageFile();
        }

        $err = require_once('CurlyErrorMessages.php');
        return $err[$this->errno()];
    }

    public function fetchToFile(string $path): void
    {
        $fp = fopen($path, "wb");

        if ($fp === false) {
            throw new \Exception('fopen(' . $path . ', "wb") failure');
        }

        curl_setopt($this->curl_handle, CURLOPT_FILE, $fp);
        curl_setopt($this->curl_handle, CURLOPT_HEADER, 0);

        curl_exec($this->curl_handle);
        curl_close($this->curl_handle);
        fclose($fp);
    }

  /**
   * @return array<string> $options
   */
    private function defaultHeader(): array
    {
        return [
        'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
        'Cache-Control: max-age=0',
        'Connection: keep-alive',
        'Keep-Alive: 300',
        'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
        'Accept-Language: en-us,en;q=0.5',
        'Pragma: '
        ];
    }

    public static function generateErrorMessageFile(): void
    {
      // https://curl.se/libcurl/c/libcurl-errors.html
        $site = file_get_contents('./site_dump.txt');
        if ($site === false) {
            throw new \Exception("file_get_contents('./site_dump.txt') failure");
        }

        preg_match_all('#\(([0-9-]+)\)[\s]+(.+)#', $site, $m);

        $ret = [];
        $delta = 0;

        foreach ($m[1] as $err_code) {
            $err_code_int = (int) $err_code;
            $ret [] = self::formatLine($err_code_int, $m[2][$err_code_int - $delta]);

            if (strlen($err_code) == 5) {
                // "75-76" & "50-51"
                $ret [] = self::formatLine($err_code_int + 1, $m[2][$err_code_int - $delta]);
                ++$delta;
            }
        }
        $comment = sprintf('// this file was generated using %s::%s', __CLASS__,__FUNCTION__).PHP_EOL;
        $code = PHP_EOL.implode(',' . PHP_EOL, $ret);

        $code = sprintf("<?php %s return [%s];", $comment);
        file_put_contents('./CurlyErrorMessages.php', $code);
    }

    private static function formatLine(int $code, string $message): string
    {
        return sprintf("%d => '%s'", $code, addslashes($message));
    }
}
