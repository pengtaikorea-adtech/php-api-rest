<?php namespace ApiRest;

class Http {
	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';
	const METHOD_PUT = 'PUT';
	const METHOD_PATCH = 'PATCH';
	const METHOD_DEL = 'DELETE';

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

	
	public static function parseHeader(string $headerText) :array {
		$headers = [];
		$matches = [];
		foreach(explode('\n', $headerText) as $ln=>$line) {
			if(preg_match('/^(?<key>.+):(?<val>.*)$/', trim($line), $matches)) {
				$key = strtolower(trim($matches['key'] ?? ''));
				$val = trim($matches['val'] ?? '');
				array_push($headers, [$key, $val]);
			}
		}
		return $headers;
	}

	public static function parseCookie(string $cookieText) :array {
		$cookies = [];
		$matches = [];
		foreach(explode(';', $cookieText) as $ln=>$line) {
			if(preg_match('/^(?<key>.+)=(?<val>.*)$/', trim($line), $matches)) {
				$key = trim($matches['key'] ?? '');
				$val = trim($matches['val'] ?? '');
				$cookies[$key] = $val;
			}
		}
		return $cookies;
	}


	public static function parseURI(string $url) {
		return parse_url($url);
	}

	public static function buildURI(array $comps) {
		$protocol = $comps[static::URL_PROTOCOL] ?? 'https';
		$user = $comps[static::URL_USER] ?? '';
		$pass = $comps[static::URL_PASS] ?? '';
		$host = $comps[static::URL_HOSTNAME] ?? '';
		$port = $comps[static::URL_PORT] ?? '';
		$path = $comps[static::URL_PATHNAME] ?? '';
		$query = $comps[static::URL_QUERY] ?? '';
		$hash = $comps[static::URL_HASH] ?? '';

		return implode('', [
			$protocol
			,
			'://',
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
}