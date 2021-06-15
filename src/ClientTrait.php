<?php namespace ApiRest;

trait ClientTrait {
	// __get, __set magic trait
	use cURLOptionMagic;

	protected static $__singleton;

	protected $_session;
	protected $_options;
	protected $_histories;

	// const API_HOST
	/**
	 * return api full endpoint location uri.
	 * 
	 */
	protected abstract static function endpoint(string $path) :string;
	protected static function endpointWithHost(string $host, string $path) :string {
		return sprintf("%s/%s", rtrim($host, '/'), ltrim($path, '/'));
	}

	protected static function maxHistories() :int { return 20; }

	public static function initialize(array $options=[]) {
		return new self($options);
	}

	public static function getInstance() {
		if(!self::$__singleton) {
			self::$__singleton = self::initialize();
		}
		return self::$__singleton;
	}

	public function __construct(array $options=[]) {
		$this->init($options);
	}

	public function init(array $options) {
		$this->_session = curl_multi_init();
		// overwrite MUST options
		foreach(cURL::OPTION_DEFAULTS as $key=>$val) {
			$options[$key] = $val;
		}
		$this->_options = $options;
		$this->_histories = [];
	}

	public function get(string $path, array $params=[]) {
		$location = self::endpoint($path);
		return $this->send(Http::METHOD_GET, $path);
	}

	public function post(string $path, array $params=[]) {
		return $this->send(Http::METHOD_POST, $path, $params);
	}

	public function del(string $path, array $params=[]) {
		return $this->send(Http::METHOD_DEL, $path, $params);
	}

	public function send(string $method, string $path, array $params=[]) {
		// build http request for later
		$req = new Request($this->_options);

		// alter the request
		$this->beforeSend($req);
		
		// method derivative
		cURL::setMethodOptions($method, $this->_options);

		// finalize with location 
		$location = $this->endpoint($path);
		cURL::setLocationParams($method, $this->_options, $location, $params);

		// sending...
		$resp = cURL::exec($this->_session, $this->_options);
		
		// parse
		$response = cURL::parseResponse($this->_session, $responsed);
		// update cookie
		foreach($response->cookies() as $ck=>$cv) {
			$this->_cookies[$ck] = $cv;
		}

		// appending history
		$history = [$req, $resp];
		array_push($this->_histories, $history);
		$historyLimits = self::maxHistories();
		while($historyLimits < count($this->_histories)) {
			array_shift($this->_histories);
		}

		return $this->onResponsed($req, $resp);
	}

	public function appendHeader(string $key, string $value) {
		$headers = $this->headers();
		Http::appendHeader($headers, $key, $value);
		$this->_options[CURLOPT_HTTPHEADER] = $headers;
	}

	public function removeHeader(string $key, int $counts=1) {
		$headers = $this->headers();
		$headers = Http::spliceHeaders($headers, $key, $counts);
		$this->_options[CURLOPT_HTTPHEADER] = $headers;
	}

	public function findHeader(string $key) {
		$headers = $this->headers();
		return Http::findHeader($headers, $key);
	}

	public function searchHeaders(string $key) {
		$headers = $this->headers();
		return Http::searchHeaders($headers, $key);
	}

	public function headers() {
		return $this->_options[CURLOPT_HTTPHEADER] ?? [];
	}

	public function cookies() {
		return Http::parseCookie($this->_options[CURLOPT_COOKIE] ?? "");
	}

	public function options() {
		return $this->_options;
	}

	public function getCookie(string $key) :?string {
		$cookies = $this->cookies();
		return $cookies[$key] ?? "";
	}

	public function setCookie(string $key, string $value) {
		$cookies = $this->cookies();
		$cookies[$key] = $value;
		$this->_options[CURLOPT_COOKIE] = Http::stringifyCookies($cookies);
	}

	public function removeCookie(string $key) :bool {
		$cookies = $this->cookies();
		if(array_key_exists($key, $cookies)) {
			unset($cookies[$key]);
			$this->_options[CURLOPT_COOKIE] = Http::stringifyCookies($cookies);
			return true;
		} else {
			return false;
		}
	}

	protected abstract function beforeSend(Request &$req);

	protected abstract function onResponsed(Request $req, Response $resp);



}