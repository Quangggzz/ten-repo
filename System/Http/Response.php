<?php
namespace Http;

class Response {
    protected $version = '1.1';
    protected $headers = [];
    protected $content = '';
    protected $statusCodes = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        204 => 'No Content',
        301 => 'Moved Permanently',
        302 => 'Found',
        304 => 'Not Modified',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        422 => 'Unprocessable Entity',
        500 => 'Internal Server Error',
        503 => 'Service Unavailable',
    ];

    public function setHeader($header) {
        $this->headers[] = $header;
    }

    public function setVersion($version) {
        $this->version = $version;
    }

    public function getVersion() {
        return $this->version;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getContent() {
        return $this->content;
    }

    public function getStatusCodeText($code) {
        return isset($this->statusCodes[$code]) ? $this->statusCodes[$code] : 'Unknown';
    }

    public function render() {
        foreach ($this->headers as $header) {
            header($header);
        }
        echo $this->content;
    }
}
