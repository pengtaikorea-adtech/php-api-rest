# ApiRest Request for RestAPI call

pengtaikorea-adtech API Call Library to Simplify cURL request

## How to use (TODO)

### single http get request

```php
// set api call info
$call = new ApiRest\ApiCall("$apihost/$endpoint", $params);
// send get request
$response = $call->get();

// sending RestAPI Call has done above.
// from now, parse the response...

// status 200
if($response->ok()) {
	// get response header
	$someHeaderValue = $response->header($RESPONSE_HEADER_KEY);
	// get response cookie
	$someCookieValue = $response->cookie($RESPONSE_COOKIE_KEY);
	//  - response text
	$textValue = strval($response);
	//  - or same value as,
	$textValue = $response->text();
	//  - or response as json, i.e. { "result": "OK" }
	$jsonStatus = $response->result;
	//  - or json parse
	$jsonValues = $response->json($assoc);
	// ...
} 
else if($response->redirected()) {
	// if redirected (and not OK!)
	$redirectedUrls = $response->redirected();
}
// error handling
else if($response->error()) {
	// ...
}
```


### Quickest Client implementation (NOT YET)

Not yet implemented, but designed how to would be like as below:

- QuickApiClient.php
	```php
	/** 
	 *  - file : QuickApiClient.php
	 **/

	class  QuickApiClient {
		// use trait
		use ApiRest\ClientTrait;
		// ClientTrait prerequisitive
		const API_HOST = 'http://quick.service...';

		// abstraction at must. common settings for all requests
		public beforeSend(ApiRest\Request &$req) { 
			return $req; 
		}
		// abstraction at must. common parsings
		public onResponsed(ApiRest\Request $req, ApiRest\Response $resp) { 
			// return json parsed responsed
			return $resp->json(); 
		}


	}
	```

	```php
	/** short, quick, simple usage **/
	$client = new QuickApiClient($options);
	// the value will be parsed as json, with had set QuickApiClient::onResponsed
	$resp = $client->post('/some/resource/endpoint', [
		'param1'=>'a', ...
	]);

	$resp['data']...
	```








### TO build RestAPI Client (NOT YET)

Singleton, or Dependency injection, applicable many designs with trait setup


- SomeApiClient.php 
	```php 

	/** 
	 * - file : /SomeApiClient.php 
	 **/

	use ApiRest\ClientTrait;
	use ApiRest\Request;
	use ApiRest\Response;

	class SomeApiClient {
		
		// using php trait 
		// refer: https://www.php.net/manual/en/language.oop5.traits.php 
		use ClientTrait {
			// initiate for singleton using
			//  - Client::initialize(array $options) :void
			initialize,
			// get instance (static) for singleton using
			//  -  Client::getInstance() :self
			getInstance,
			// common initialize, usually for constructor
			//  - $client->init()
			init,
			// send get request 
			//  - $client->get(string $endpoint, array $params=null)
			get,
			// send post request
			//  - $client->post(string $endpoint, array $params=null)
			post,
			// send delete request
			//  - $client->del(string $endpoint, array $params=null)
			del,
			// or any sending request
			//  - $client->send(string $method, string $endpoint, array $params=null)
			send,
		};

		// trait requisitives
		const API_HOST = "https://api.service"

		/** common settings **/
		public function __construct(array $options) {
			// common initialize (curl session, settings, etc...)
			$this->init();
		}

		/** implementation of ApiClient trait abstractions **/
		// before sending the request, setup middleware
		protected function beforeSend(Request &$req) {
			// set headers..
			$req->headers([]);
			//  - or single value
			$req->header($headerKey, $value);
			// set cookies, ditto..
			$req->cookies([]);

			// 
		}

		// after response recieved, parsing middleware
		protected function onResponsed(Request $req, Response $resp) {
			// throw new error if needed...
			if($resp->ok()) {
				// parsing values
				if($req->matching("/pattern/")) {
					// 
					return new SomeApiResourceModel($resp->aKey, $resp->data, ...);
				}
			}
			else if($resp->error()) {
				throw new SomeApiClientException(...);
			}
			return $resp;
		}

		
	}
	```

- AppOnSomeApi.php 
	```php
	/** 
	 * - file : /AppOnSomeApi.php 
	 **/

	use SomeApiClient;
	use SomeApiResourceModel;
	use SomeApiClientException;

	class AppOnSomeApi {
		public static function getListResources(string $resource_id) {
			$client = SomeApiClient::getInstance();
			// or use constructor instead, as you like.
			// $client = new SomeApiClient($options);

			try {
				// send get request
				$value = $client->get("/endpoint/$resource_id", [
					"param_required_1" => 1,
					"param_required_2" => true,
				]);
				// $value has already parsed through ::onResponsed
			} 
			// 
			catch(SomeApiClientException $ex) {
				// error handling...
			}

		}
	}
	```