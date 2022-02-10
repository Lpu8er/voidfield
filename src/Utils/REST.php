<?php
namespace App\Utils;

/**
 * Description of REST
 *
 * @author lpu8er
 */
class REST {
    const METHOD_GET = 'get';
    const METHOD_POST = 'post';
    const METHOD_HEAD = 'head';
    const METHOD_PUT = 'put';
    const METHOD_DELETE = 'delete';
    const METHOD_PATCH = 'patch';
    
    /**
     * 
     * @param string $uri
     * @param string $method
     * @param array $data
     * @param array $headers
     * @param array $options
     * @return array of response and errors
     */
    public static function instant(string $uri, string $method, array $data = [], array $headers = [], array $options = []) {
        $r = (new REST($uri));
        foreach($data as $k => $v) { $r->setData($k, $v); }
        foreach($headers as $k => $v) { $r->setHeader($k, $v); }
        foreach($options as $k => $v) { $r->setOption($k, $v); }
        $r->call('', $method);
        $returns = [
            'response' => $r->getResponse(),
            'errors' => $r->getErrors(),
        ];
        unset($r); // force garbage
        return $returns;
    }
    
    /**
     * 
     * @param string $uri
     * @param string $method
     * @param array $data
     * @param array $headers
     * @param array $options
     * @return array of response and errors
     */
    public static function instantJson(string $uri, string $method, array $data = [], array $headers = [], array $options = []) {
        $r = (new REST($uri));
        foreach($data as $k => $v) { $r->setData($k, $v); }
        foreach($headers as $k => $v) { $r->setHeader($k, $v); }
        foreach($options as $k => $v) { $r->setOption($k, $v); }
        $r->call('', $method);
        $returns = [
            'response' => $r->getJsonResponse(),
            'errors' => $r->getErrors(),
        ];
        unset($r); // force garbage
        return $returns;
    }
    
    /**
     * 
     * @param string $uri
     * @param array $data
     * @param array $headers
     * @param array $options
     * @return array of response and errors
     */
    public static function iGet(string $uri, array $data = [], array $headers = [], array $options = []) {
        return static::instant($uri, static::METHOD_GET, $data, $headers, $options);
    }
    
    /**
     * 
     * @param string $uri
     * @param array $data
     * @param array $headers
     * @param array $options
     * @return array of response and errors
     */
    public static function jGet(string $uri, array $data = [], array $headers = [], array $options = []) {
        return static::instantJson($uri, static::METHOD_GET, $data, $headers, $options);
    }
    
    /**
     * 
     * @param string $uri
     * @param array $data
     * @param array $headers
     * @param array $options
     * @return array of response and errors
     */
    public static function iPost(string $uri, array $data = [], array $headers = [], array $options = []) {
        return static::instant($uri, static::METHOD_POST, $data, $headers, $options);
    }
    
    /**
     * 
     * @param string $uri
     * @param array $data
     * @param array $headers
     * @param array $options
     * @return array of response and errors
     */
    public static function jPost(string $uri, array $data = [], array $headers = [], array $options = []) {
        return static::instantJson($uri, static::METHOD_POST, $data, $headers, $options);
    }
    
    /**
     *
     * @var string
     */
    protected $base;
    /**
     *
     * @var string
     */
    protected $uri;
    /**
     *
     * @var string
     */
    protected $method;
    /**
     *
     * @var array
     */
    protected $data = [];
    /**
     *
     * @var array
     */
    protected $headers = [];
    /**
     *
     * @var array
     */
    protected $options = [];
    /**
     *
     * @var mixed
     */
    protected $response = null;
    /**
     *
     * @var array
     */
    protected $errors = [];
    
    /**
     * 
     * @param string $base
     */
    public function __construct(string $base) {
        $this->base = $base;
    }
    
    /**
     * 
     * @param string $k
     * @param mixed $v
     * @return $this
     */
    public function setData(string $k, $v) {
        $this->data[$k] = $v;
        return $this;
    }
    
    /**
     * 
     * @param string $k
     * @param string $v
     * @return $this
     */
    public function setHeader(string $k, string $v) {
        $this->headers[$k] = $v;
        return $this;
    }
    
    /**
     * 
     * @param integer $k
     * @param mixed $v
     * @return $this
     */
    public function setOption($k, $v) {
        $this->options[$k] = $v;
        return $this;
    }
    
    /**
     * 
     * @return $this
     */
    public function clearData() {
        $this->data = [];
        return $this;
    }
    
    /**
     * 
     * @return $this
     */
    public function clearHeaders() {
        $this->headers = [];
        return $this;
    }
    
    /**
     * 
     * @return $this
     */
    public function clearOptions() {
        $this->options = [];
        return $this;
    }
    
    /**
     * 
     * @param string $uri
     * @return $this
     */
    public function get(string $uri) {
        return $this->call($uri, static::METHOD_GET);
    }
    
    /**
     * 
     * @param string $uri
     * @return $this
     */
    public function post(string $uri) {
        return $this->call($uri, static::METHOD_POST);
    }
    
    /**
     * 
     * @param string $uri
     * @param string $method
     * @return $this
     */
    public function call(string $uri, string $method = null) {
        $this->uri = $uri;
        $this->method = empty($method)? static::METHOD_GET:$method;
        return $this->doRealCall();
    }
    
    /**
     * 
     * @return $this
     */
    protected function doRealCall() {
        $this->response = null;
        $this->errors = [];
        $ch = curl_init();
        // pre configure some options
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $bUri = trim($this->base, '/');
        if(!empty($this->uri)) {
            $bUri.= '/'.ltrim($this->uri, '/');
        }
        if(in_array($this->method, [static::METHOD_GET, static::METHOD_HEAD,])) {
            if(!empty($this->data)) {
                $bUri .= '?'.http_build_query($this->data);
            }
            curl_setopt($ch, CURLOPT_URL, $bUri);
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($this->method));
            curl_setopt($ch, CURLOPT_URL, $bUri);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);
        }
        $h = [];
        foreach($this->headers as $hk => $hv) { $h[] = $hk.': '.$hv; }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $h);
        foreach($this->options as $ok => $ov) {
            curl_setopt($ch, $ok, $ov);
        }
        $r = curl_exec($ch);
        $gi = curl_getinfo($ch);
        if(!empty($gi)) {
            $statusCode = $gi['http_code'];
            if(200 > $statusCode || 300 <= $statusCode) {
                $this->errors[] = $statusCode;
                $this->errors[] = $r;
            }
        } else {
            $this->errors[] = 'Fail to curl';
        }
        $this->response = $r;
        return $this;
    }
    
    /**
     * 
     * @return bool
     */
    public function hasErrors() {
        return !empty($this->errors);
    }
    
    /**
     * 
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }
    
    /**
     * 
     * @return string
     */
    public function getResponse() {
        return $this->response;
    }
    
    /**
     * 
     * @return array|false
     */
    public function getJsonResponse() {
        return json_decode($this->response, true);
    }
}
