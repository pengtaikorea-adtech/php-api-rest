<?php namespace ApiRest;

class Http {
	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';
	const METHOD_PUT = 'PUT';
	const METHOD_PATCH = 'PATCH';
	const METHOD_DEL = 'DELETE';
	const NAME_METHODS = [
		self::METHOD_GET,
		self::METHOD_POST,
		self::METHOD_PUT,
		self::METHOD_PATCH,
		self::METHOD_DEL,
	];

	// HTTP STATUS CODE
	const STATUS_OK = 200;
	const STATUS_REDIRECT = 300;

	
	const URL_PROTOCOL = 'scheme';
	const URL_HOSTNAME = 'host';
	const URL_PATHNAME = 'path';
	const URL_QUERY = 'query';
	const URL_HASH = 'fragment';
	const URL_PORT = 'port';
	const URL_USER = 'user';
	const URL_PASS = 'pass';

	const HEADER_PATTERN = '/^\s*(?<key>[^:]+)\s*:(?<val>.*)$/';
	const COOKIE_PATTERN = '/^(?<key>.+)=(?<val>.*)$/';
	const SETCOOKIE_PATTERN = '/^(?<key>[^;=]+)=(?<val>[^;]*);?/';

	
	/**
	 * 
	 */
	public static function parseHeader(string $headerText) :array {
		$headers = [];
		$matches = [];
		foreach(explode("\n", $headerText) as $ln=>$line) {
			if(preg_match(static::HEADER_PATTERN, trim($line), $matches)) {
				$key = trim($matches['key'] ?? '');
				$val = trim($matches['val'] ?? '');
				array_push($headers, "$key: $val");
			}
		}
		return $headers;
	}

	/**
	 * appending header array
	 */
	public static function appendHeader(array &$headers, string $key, string $value) {
		$key = trim($key);
		$value = trim($value);
		array_push($headers, "$key: $value");
		return $headers;
	}

	protected static function headerSearchPattern(string $key)  {
		return "/^\s*$key\s*:(?<val>.*)$/i";
	}

	/**
	 * find a (first) value that matches $key
	 */
	public static function findHeader(array $headers, string $key) :?string {
		$pattern = static::headerSearchPattern($key);
		$match = [];
		foreach($headers as $ln=>$entity) {
			if(preg_match($pattern, $entity, $match)) {
				return trim($match['val']);
			}
		}
		return null;
	}

	/**
	 * search values that matches $key
	 */
	public static function searchHeaders(array $headers, string $key) :array {
		$rets = [];
		$match = [];
		$pattern = static::headerSearchPattern($key);
		foreach($headers as $ln=>$entity) {
			if(preg_match($pattern, $entity, $match)) {
				array_push($rets, trim($match['val']));
			}
		}
		return $rets;
	}

	public static function spliceHeaders(array &$headers, string $key, int $count=1) :array {
		$pattern = static::headerSearchPattern($key);
		$removed = 0;
		foreach($headers as $ln=>$entity) {
			if(preg_match($pattern, $entity)) {
				unset($headers[$ln]);
				$removed += 1;
				if(0<$count && $count<=$removed) {
					break;
				}
			}
		}
		return $headers;
	}



	/**
	 * parse cookie value from cookie string
	 */
	public static function parseCookie(string $cookieText) :array {
		$cookies = [];
		$matches = [];
		foreach(explode(';', $cookieText) as $ln=>$line) {
			if(preg_match(static::COOKIE_PATTERN, trim($line), $matches)) {
				$key = trim($matches['key'] ?? '');
				$val = trim($matches['val'] ?? '');
				$cookies[$key] = $val;
			}
		}
		return $cookies;
	}

	public static function stringifyCookies(array $cookies) :string {
		return implode("; ", array_map(function($ck) use($cookies) {
			$value = $cookies[$ck];
			return "$ck=$value";
		}, array_keys($cookies)));
	}

	/**
	 * 
	 */
	public static function loadSetCookie(string $setCookieText, array &$cookies) :bool {
		$matches = [];
		if(preg_match(static::SETCOOKIE_PATTERN, trim($setCookieText), $matches)) {
			$cookies[$matches['key']] = trim($matches['val']);
			return true;
		} else {
			return false;
		}
	}


	public static function parseURI(string $url) {
		return parse_url($url);
	}

	public static function buildURI(array $comps) {
		$protocol = $comps[static::URL_PROTOCOL] ?? '';
		$user = $comps[static::URL_USER] ?? '';
		$pass = $comps[static::URL_PASS] ?? '';
		$host = $comps[static::URL_HOSTNAME] ?? '';
		$port = $comps[static::URL_PORT] ?? '';
		$path = $comps[static::URL_PATHNAME] ?? '';
		$query = $comps[static::URL_QUERY] ?? '';
		$hash = $comps[static::URL_HASH] ?? '';

		return implode('', [
			$protocol ? $protocol.'://' : ''
			,
			// username & password
			$user,
			$pass ? ':' : '',
			$pass,
			$user.$pass ? '@' : '',
			// host
			$host,
			// port
			$port ? ':' : '',
			$port,
			// pathname
			$path && $path[0] != '/' ? '/' : '',
			$path,
			// query
			$query ? '?' : '',
			$query,
			// hash
			$hash ? '#': '',
			$hash,
		]);
	}

	public static function rebuildGetURI(string $baseUrl, ?array $getParams=null) {
		$components = static::parseURI($baseUrl);
		if($getParams) {
			$components[static::URL_QUERY] = 
				http_build_query($getParams, $components[static::URL_QUERY] ?? '');
		}
		return static::buildURI($components);
	}
}