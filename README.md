# ApiRest Request for RestAPI call

pengtaikorea-adtech API Call Library to Simplify cURL request

## Design Purpose

[한국어](docs/design_ko.md)


## cURL Wrapper

The package `ApiRest` stands for "cURL-Http wrapper that are frequently used on Rest Api"

Now (2021.Jul.) most modern platforms runs API within [Rest](https://en.wikipedia.org/wiki/REST) methodology. Many services goes with various API but, "by rare chance", THE channel does not go well with php - you, developer should take hand on building it upon [cURL](https://curl.se/) and raw HTTP. 

cURL covers almost-all features that may needed on "any" http-clients. On the other side, it also means a developer hands with cURL must put bunch of codes, setting options, handling exceptions, and/or parsing data on it, even for a single simplest GET request.

"By very thin probabilty" if the targets - are plural, complexity sky rockets. Some encodes AccessToken over HTTP Header: Bearer, others use GET parameter. some set cookies but other handles session values. Response mimetype are "normaly" application/json, but it's not a rule. Don't even mentioned internal data structure.

There, `ApiRest` design began: 

**To focus only on API logic, Why don't we wrapping up common features in cURL/HTTP in a single library?**


```php
/** simple, intuitive and human-readable http in action **/
$session = new ApiCall();
$response = $session->get($location, $params);
if($response->ok()) {
    return $response->json();
} else {
    throw new Exception($response->error());
}

/** what a clean and simple api client **/
class ApiRestClient {
    use ApiRest\ClientTrait;
    protected static function endpoint(string $path) :string {
        return static::endpointWithHost("https://api.rest.com/vN.x", $path);
    }

    public function searchItems(string $query) {
        return $this->get("/items", ['q'=>$query]);
    }

    public function setItem(array $item) {
        $itemId = $item['id'] ?? "";
        return $this->post("/items/$itemId", $item);
    }

    public function removeItem(string $itemId) {
        return $this->del("/item/$itemId");
    }
}
```


## How simply it can be

`ApiRest` package comes with [cURL](./reference.md#curl), [HTTP](./reference.md#http), [Request](./reference.md#request), [Response](./reference.md#response) common features listed. especially cURL handles 170+ options provided, thank fully on php-magic.

```php
/** Let's see how simple it can be to set a cURL option **/
$session = new ApiCall();
// if you need CURLOPT_REFERER
$session->referer = 'https://pengtai.co.kr/';
// or CURLOPT_HTTPHEADER
$session->httpHeader = [
    'Content-type: application/json; encoding=UTF-8',
    'Access-Token: Bearer; u1234...'
];
```

It's also same for Request/Response. There's several straight-forward named, hands-on methods are set.

```php

function (ApiRest\Request $req, ApiRest\Response $resp) {
    /** Request **/

    // URL
    $url = $req->location();
    // test request headers
    foreach($req->headers() as $header) {
        
    }
    // or cookies?
    foreach($req->cookies() as $key=>$value) {
        // ... 
    }


    /** Response **/
    // is Response OK?
    if($resp->ok()) {
        $data = $resp->json(); // (assoc array) or $resp->jsonObject(); (object) 
        $text = $resp->text(); // or strval($resp); $resp->__toString();
        // need to search an header value?
        $mimeTypeHeader = $resp->header('content-type');
    } 
}
```

Some may not familar with [php-trait]()


## Documents

- [QuickStart](docs/quickstart.md)
- [Tips & Tricks](docs/tricks.md) ([한국어](docs/tricks_ko.md))
- [Reference](docs/reference.md)
  - [ApiCall](docs/reference.md#apicall)
  - [ClientTrait](docs/reference.md#client-trait)
  - [Request](docs/reference.md#request)
  - [Response](docs/reference.md#response)
  - [cURL](docs/reference.md#curl)
  - [Http](docs/reference.md#http)
  - Document: (Later)
- [ReleaseHistory](docs/history.md)
