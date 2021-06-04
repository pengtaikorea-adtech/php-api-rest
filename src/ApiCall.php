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
		$this->_options = array_merge(cURL::SINGLE_DEFAULTS,cURL::Converts($options));
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
		// valid key
		if($key!=0) {
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
		$this->_options = array_diff($this->_options, cURL::METHOD_OPTIONS);

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
		$this->_request = new Request($url, 
			$this->_options[CURLOPT_HTTPHEADER] ?? [], 
			$this->_options[CURLOPT_COOKIE] ?? []);

		// set options
		curl_setopt_array($this->_session, $this->_options);

		// send
		$responsed = curl_exec($this->_session);

		// build response to return
		$this->_response = new Response($responsed, $curl_getinfo($this->_session));

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

	/**
	 * sending other methods
	 */
	public function __invoke($name, $args) {
		// sending methods
		switch(strtoupper($name)) {
		case Http::METHOD_GET:
			return $this->get();
		case 'DEL':
			$name = Http::METHOD_DEL;
		case Http::METHOD_POST:
		case Http::METHOD_PUT:
		case Http::METHOD_PATCH:
			$this->_options[CURLOPT_POSTFIELDS] = http_build_query($this->_params);
			return $this->send($name);
		}

		// ...
	}

}