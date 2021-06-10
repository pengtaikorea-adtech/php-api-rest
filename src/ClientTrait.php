<?php namespace ApiRest;

trait ClientTrait {

	protected static $__singleton;

	protected $_session;
	protected $_options;
	protected $_headers;
	protected $_cookies;
	protected $_histories;

	// const API_HOST
	/**
	 * return api full endpoint location uri.
	 * 
	 */
	protected abstract static function endpoint(string $path) :string;

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

	public function __construct(array $options) {
		$this->init($options);
	}

	public function init(array $options) {
		$this->_session = curl_multi_init();
		// overwrite MUST options
		foreach(cURL::OPTION_DEFAULTS as $key=>$val) {
			$options[$key] = $val;
		}
		$this->_options = $options;
		// concurrent headers, cookies
		$this->_headers = Http::parseHeader($options[CURLOPT_HTTPHEADER] ?? "");
		$this->_cookies = Http::parseCookie($options[CURLOPT_COOKIE] ?? "");
		$this->_histories = [];
	}

	public function get(string $path, array $params=[]) {
		$location = Http::rebuildGetURI(static::API_HOST.$path, $params);
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

		// update options derived from reqeust:
		$this->_options[CURLOPT_HTTPHEADER] = $req->headers();
		$this->_options[CURLOPT_COOKIE] = $req->cookies();
		// $this->_options[CURLOPT_URL] = $this->endpoint($path);

		// method derivative
		cURL::setMethodOptions($method, $this->_options);

		// finalize with location 
		$location = $this->endpoint($path);
		cURL::setLocationParams($method, $this->_options, $location, $params);

		// sending...
		$resp = cURL::exec($this->_session, $this->_options);
		
		// parse
		$response = cURL::parseResponse($this->_session, $responsed);

		// appending history
		$history = [$req, $resp];
		array_push($this->_histories, $history);
		$historyLimits = self::maxHistories();
		while($historyLimits < count($this->_histories)) {
			array_shift($this->_histories);
		}

		return $this->onResponsed($req, $resp);
	}

	protected abstract function beforeSend(Request &$req);

	protected abstract function onResponsed(Request $req, Response $resp);



}