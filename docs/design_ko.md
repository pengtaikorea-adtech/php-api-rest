# ApiRest 디자인 목적

## cURL Wrapper

ApiRest 패키지는 curl 을 통한 http client wrapper 입니다.

(2021년 현재), 대부분 시스템의 API는 [Rest](https://ko.wikipedia.org/wiki/REST) 방식을 채용하고 있습니다. 그 상당수가 여러 언어로 SDK를 제공하고 있지만, "하필이면" php SDK가 없는 경우, [cURL](https://curl.se/)를 통한 raw HTTP 요청을 해석하는 과정이 필요합니다.

cURL 은 HTTP에 대한 거의 모든 기능을 제공하는 훌륭한 라이브러리입니다. 다만, 그 기능의 범위가 매우 넓기 때문에, 가장 단순한 GET Request 한 번을 위해 상당한 분량의 코드를 할애해야 합니다. HTTP 옵션을 설정하고, 오류를 처리하며 데이터를 파싱하는 일반적인 구문이 대부분입니다. 

여러 플랫폼 API를 구축한다면 추상화는 좀 더 어려운 문제가 됩니다. 어딘가는 Header: Bearer 키를 통해 AccessToken 을 암호화 하며, 또 다른 플랫폼에서는 쿼리 파라미터로 전달합니다. 결과 응답 MimeType 은 대부분 text/json 형식이 많지만, JSON 데이터 내부 형식은 플랫폼마다 천차만별입니다.

**cURL / HTTP 에 대한 공통 기능을 Wrapping 하고 플랫폼 API 로직에만 집중할 순 없을까?**

ApiRest 의 디자인은 여기서 출발합니다.

```php
/** 가장 간단한 API 요청 처리 **/
$session = new ApiCall();
$response = $session->get($location, $params);
if($response->ok()) {
    return $response->json();
} else {
    throw new Exception($response->error());
}

/** 빠른 API 클라이언트 만들기 **/
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



## 이토록 간단한 공통 루틴

`ApiRest` 패키지는 [cURL](./reference.md#curl), [HTTP](./reference.md#http), [Request](./reference.md#request), [Response](./reference.md#response) 에 대한 공통 기능을 제공합니다. 특히 cURL 의 경우, php-magic 을 통해 170+ 개가 넘는 옵션에 대한 간단 활용 기능을 담았습니다.

```php
/** 간단한 cURL 옵션 설정 **/
$session = new ApiCall();
// CURLOPT_REFERER 설정
$session->referer = 'https://pengtai.co.kr/';
// CURLOPT_HTTPHEADER
$session->httpHeader = [
    'Content-type: application/json; encoding=UTF-8',
    'Access-Token: Bearer; u1234...'
];
```

그리고 Request/Response 클래스도 손쉽게 사용할 수 있는 여러 method를 담고 있습니다.

```php

function (ApiRest\Request $req, ApiRest\Response $resp) {
    /** Request **/

    // URL
    $url = $req->location();
    // Request Headers
    foreach($req->headers() as $header) {
        // ... $header string 확인/편집
    }
    // Request Cookies
    foreach($req->cookies() as $key=>$value) {
        // ... 
    }


    /** Response **/
    // is Response OK?
    if($resp->ok()) {
        $data = $resp->json(); // (assoc array) 또는 $resp->jsonObject(); (object) 
        $text = $resp->text(); // 또는 strval($resp); $resp->__toString();
        // Response Header 에서 값 받아오기
        $mimeTypeHeader = $resp->header('content-type');
    } 
}
```
