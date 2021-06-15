<?php namespace ApiRest;

class ApiCall {
	// __get, __set magic trait
	use cURLOptionMagic;

	protected $_location;
	protected $_params;
	protected $_options;

	protected $_request;
	protected $_response;

	protected $_session;

	/**
	 * ApiCall Constructor:
	 * @var string $url path to send
	 * @var array $params parameters - will be embeded on URL location (GET) or message BODY (others)
	 * @var array $options - cURL options. refer ApiRest\cURL::OPTIONS
	 */
	public function __construct(string $url=null, array $params=[], array $options=[]) {
		$this->_location = $url;
		$this->_params = $params;

		// initialize curl session
		$this->_session = curl_init($url);
		// convert options
		$this->_options = cURL::Converts($options);
		foreach(cURL::OPTION_DEFAULTS as $dk=>$dv) {
			$this->_options[$dk] = $dv;
		}
	}

	

	/** 
	 * common http sending request
	 */
	public function send(string $method) {
		// set method options
		cURL::setMethodOptions($method, $this->_options);
		// then params
		cURL::setLocationParams($method, $this->_options, $this->_location, $this->_params);
		
		// build request for later use
		$this->_request = new Request($this->_options);

		// send request
		$responsed = cURL::exec($this->_session, $this->_options, $method, $this->_location, $this->_params);
		
		$this->_response = cURL::parseResponse($this->_session, $responsed);
		
		return $this->_response;
	}

	public function request() {
		return $this->_request;
	}

	public function response() {
		return $this->_response;	
	}


	public function options() {
		return $this->_options;
	}

	/**
	 * sending other methods
	 */
	public function __call($name, $args) {
		$name = strtoupper($name);
		if(in_array($name, Http::NAME_METHODS)) {
			return $this->send($name);
		}
	}
}