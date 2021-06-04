<?php namespace ApiRest;

trait ClientTrait {

	protected static $__singleton;

	protected $_session;
	protected $_cookies;
	protected $_headers;
	protected $_histories;

	// const API_HOST

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
		// build curl session
	}


	public function get(string $endpoint, array $headers=null, array $options=null) {
		return $this->send(Http::METHOD_GET, $endpoint, $headers, $options);
	}

	public function post(string $endpoint, array $headers=null, array $options=null) {
		return $this->send(Http::METHOD_POST, $endpoint, $headers, $options);
	}

	public function del(string $endpoint, array $headers=null, array $options=null) {
		return $this->send(Http::METHOD_DEL, $endpoint, $headers, $options);
	}

	public function send(string $method, string $endpoint, array $headers=null, array $options=null) {
		// build new option
		$req = new Request($endpoint, $headers, $options);
		// alter
		$this->beforeSend($req);
		// send
		$resp = $req->send($method);
		// parse
		return $this->onResponsed($req, $resp);
	}

	protected abstract function beforeSend(Request &$req);

	protected abstract function onResponsed(Request $req, Response $resp);



}