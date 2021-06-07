<?php namespace ApiRest;

class ApiCall {
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
		foreach(cURL::SINGLE_DEFAULTS as $dk=>$dv) {
			$this->_options[$dk] = $dv;
		}
	}

	public function __get($name) {
		$key = cURL::Key($name);
		// valid key
		if($key!=0) {
			if(array_key_exists($key, $this->_options)) {
				return $this->_options[$key];
			}
			return null;
		} 
		throw new \MemberAccessException(sprintf("Option %s not exists", $name));
	}

	public function __set($name, $value) {
		$key = cURL::Key($name);
		// key validity
		if($key!=0 && !array_key_exists($key, cURL::SINGLE_DEFAULTS)) {
			if($value==null && array_key_exists($key, $this->_options)) {
				delete($this->_options[$key]);
			} else {
				$this->_options[$key] = $value;
			}
		} 
		throw new \MemberAccessException(sprintf("Option %s not exists", $name));
	}

	protected function _buildResponse(string $response) {
		$info = curl_getinfo($this->_session);

		return new Response(
			// status code
			$info[CURLINFO_REPONSE_CODE],
			// response body
			substr($response, $info[CURLINFO_HEADER_SIZE]),
			// info
			$info);
	}

	/** 
	 * common http sending request
	 */
	public function send(string $method) {
		// set method
		$method = strtoupper($method);
		// clear method options
		foreach(cURL::METHOD_OPTIONS as $mk=>$mv) {
			if(array_key_exists($mk, $this->_options)) {
				delete($this->_options[$mk]);
			}
		}
		// $this->_options = array_diff($this->_options, cURL::METHOD_OPTIONS);


		// set request method
		switch($method) {
		case 'GET':
			$this->_options[CURLOPT_HTTPGET] = true; break;
		case 'POST':
			$this->_options[CURLOPT_POST] = true; break;
		case 'PUT':
			$this->_options[CURLOPT_PUT] = true; break;
		default:
			$this->_options[CURLOPT_CUSTOMREQUEST] = $method; break;
		}

		// build request for later use
		$this->_request = new Request($this->_location, 
			$this->_options[CURLOPT_HTTPHEADER] ?? [], 
			$this->_options[CURLOPT_COOKIE] ?? []);

		// set options
		curl_setopt_array($this->_session, $this->_options);

		// send
		$responsed = curl_exec($this->_session);
		$info = curl_getinfo($this->_session);
		// on OK:
		if($responsed!==false) {
			$this->_response = new Response($responsed, $info);
		} else {
			$err = curl_error($this->_session);
			// set header parsing to 0
			$info[cURL::KEY_INFO_HEADER_LENGTH] = '0';
			$this->_response = new Response($err, $info);
		}
		return $this->_response;
	}

	/**
	 * send GET request
	 */
	public function get() {
		// build request
		$components = parse_url($this->_location);
		$components[Http::URL_QUERY] = 
			http_build_query($this->_params, $components[Http::URL_QUERY] ??  '');
		$this->_options[CURLOPT_URL] = Http::buildURI($components);
		
		// sending...
		return $this->send(Http::METHOD_GET);
	}

	public function options() {
		return $this->_options;
	}

	/**
	 * sending other methods
	 */
	public function __call($name, $args) {
		// sending methods
		switch(strtoupper($name)) {
		case Http::METHOD_GET:
			return $this->get();
		case 'DEL':
		case 'DELETE':
			$name = Http::METHOD_DEL;
		case Http::METHOD_POST:
		case Http::METHOD_PUT:
		case Http::METHOD_PATCH:
			$this->_options[CURLOPT_POSTFIELDS] = http_build_query($this->_params);
			return $this->send($name);
		}
	}

}