# QuickStart

- [Single GET request](single-get-request)
- [Single POST request](single-post-request)
- [Simple Client](simple-client)

## Single GET request

```php single GET call
	// setup at construction
	$location = 'https://www.pengtai.co.kr';
	$params = [
		'utm_campaign'=>'ajax_test',
		'utm_source'=>'ajax',
		'utm_medium'=>'curl',
	];
	// initiate client
	$session = new ApiRest\ApiCall($location, $params);
	
	// send the call
	$response = $session->get();
	
	// run response
	if($response->ok()) {
		var_dump($response->json());
	} else {
		throw new Exception($response->error());
	}
```
    
### Single Post request
    
```php single POST call
// location, params can be set on request
$session = new ApiRest\ApiCall();

// send the post call
$response = $session->post('https://api.pengtai.co.kr/v1/items', [
	'q'=>'campaign'
]);

if($response->ok()) {
	var_dump($response->json());
} else {
	throw new Exception($response->error());
}
```

### simple client

```php simple client with GET/POST/DEL
class Connector {
    // let there be methods.
    use ApiRest\ClientTrait;

    /** @abstract ApiRest\ClientTrait
     * implement endpoint builder 
     */
    protected static function endpoint(string $path) :string {
        return self::endpointWithHost('https://api.pengtai.co.kr/v1', $path);
    }
    
    /** retrieve items via GET api call 
     * @param array $searchParams key=>map style GET params
     * @return array|false search results
     */
    public function getItems(array $searchParams)  {
        // get request send then receive the response
        $resp = $this->get('/items', $searchParams);

        return $resp->ok() ? $resp->json() : false;
    }

    /** send item setup api call then get the inserted ID,
     * assumming api responsed JSON: {id: "1234"}
     * @param array $values item property
     * @return string|false DB inserted ID or false
     */
    public function setItem(array $values) {
        // send post update call then get the response
        $resp = $this->post('/item', $values);
        
        return $resp->ok() ? $resp->jsonObject()->id : false;
    }

    /** send item delete request then return the result.
     * assumming api response 200(HTTP_OK) when success, else otherwise.
     * @param string $id item ID
     * @return bool delete response
     */
    public function removeItem(string $id) {
        return $this->del("/item/$id")->ok();
    }
}
```

    