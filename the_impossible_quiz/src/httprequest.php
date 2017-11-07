<?php

class HTTPResponse
{
  var $_headers;
  var $_body;

  function HTTPResponse($headers, $body) {
    $this->_headers = $headers;
    $this->_body = $body;
  }

  function get_headers() {
    return $this->_headers;
  }

  function get_body() {
    return $this->_body;
  }
}
class HTTPRequest
{
    var $_fp;        // HTTP socket
    var $_url;        // full URL
    var $_host;        // HTTP host
    var $_protocol;    // protocol (HTTP/HTTPS)
    var $_uri;        // request URI
    var $_port;        // port

    // scan url
    function _scan_url()
    {
        $req = $this->_url;

        $pos = strpos($req, '://');
        $this->_protocol = strtolower(substr($req, 0, $pos));

        $req = substr($req, $pos+3);
        $pos = strpos($req, '/');
        if($pos === false)
            $pos = strlen($req);
        $host = substr($req, 0, $pos);

        if(strpos($host, ':') !== false)
        {
            list($this->_host, $this->_port) = explode(':', $host);
        }
        else
        {
            $this->_host = $host;
            $this->_port = ($this->_protocol == 'https') ? 443 : 80;
        }

        $this->_uri = substr($req, $pos);
        if($this->_uri == '')
            $this->_uri = '/';
    }

    // constructor
    function HTTPRequest($url)
    {
        $this->_url = $url;
        $this->_scan_url();
    }

    // download URL to string
    function DownloadToString()
    {
        $crlf = "\r\n";

        // generate request
        $req = 'GET ' . $this->_uri . ' HTTP/1.0' . $crlf
            .    'Host: ' . $this->_host . $crlf
            .    $crlf;

        // fetch
        $this->_fp = fsockopen(($this->_protocol == 'https' ? 'ssl://' : '') . $this->_host, $this->_port);
        fwrite($this->_fp, $req);
        while(is_resource($this->_fp) && $this->_fp && !feof($this->_fp))
            $response .= fread($this->_fp, 1024);
        fclose($this->_fp);

        // split header and body
        $pos = strpos($response, $crlf . $crlf);
        if($pos === false)
            return($response);
        $header = substr($response, 0, $pos);
        $body = substr($response, $pos + 2 * strlen($crlf));

        // parse headers
        $headers = array();
        $lines = explode($crlf, $header);
        foreach($lines as $line)
            if(($pos = strpos($line, ':')) !== false)
                $headers[strtolower(trim(substr($line, 0, $pos)))] = trim(substr($line, $pos+1));

        return new HTTPResponse($headers, $body);
    }
}
?>
