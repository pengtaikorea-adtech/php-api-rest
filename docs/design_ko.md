# ApiRest 디자인 목적

## cURL Wrapper

ApiRest 패키지는 curl 을 통한 http client wrapper 입니다.

(2021년 현재), 대부분 시스템의 API는 [Rest](https://ko.wikipedia.org/wiki/REST) 방식을 채용하고 있습니다. 그 상당수가 여러 언어로 SDK를 제공하고 있지만, "하필이면" php SDK가 없는 경우, [cURL](https://curl.se/)를 통한 raw HTTP 요청을 해석하는 과정이 필요합니다.

cURL 은 HTTP에 대한 거의 모든 기능을 제공하는 훌륭한 라이브러리입니다. 다만, 그 기능의 범위가 매우 넓기 때문에, 가장 단순한 GET Request 한 번을 위해 상당한 분량의 코드를 할애해야 합니다:

```php
// 초기설정
$curl = curl_init();
curl_setopt_array([
    CURLOPT_URL => $location,
    CURLOPT_RETURNTRANSFERER => true,
    CURLOPT_HTTPGET => true,
    CURLOPT_HEADER => false,
]);

// 여기서 HTTP Request 전송
$resp = curl_exec($curl);
// 응답 상태 확인
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

// responsed OK
if($status === 200) {
    // CURLOPT_HEADER => false 이기 때문에 다행히,
    // json text `{id: "a-123..."}의 "id"를 반환한다고 가정합니다.
    return json_decode($resp)->id;
} else {
    throw new Exception(curl_error($curl));
}
```

같은 내용을 ApiRest 를 통해 구현하면 다음과 같습니다:

```php

$rest = new ApiRest($location, [], [
    // URL 은 생성자 파라미터이므로 생략합니다.
    // returnTransferer 는 강제 true 설정됩니다.
    // 뒤에서 GET method 를 지정하기 때문에 method 는 생략됩니다
    // header 여부는 이후 결과 parsing에 영향을 주지 않습니다.
]);

/** 더 짧게 줄이면,
 * $rest = new ApiRest($location); // 유효합니다.
 **/

// 여기서 HTTP Request 전송
$response = $rest->get();
// responsed OK
if($response->ok()) {
    // json text `{id: "a-123..."}의 "id"를 반환한다고 가정합니다.
    return $resonse->jsonObject()->id;
} else {
    throw new Exception($resonse->error());
}
```

아직까지는 그 차이가 크지 않은 것 처럼 보입니다.. 그럼 이제, RestAPI SDK를 만드는 입장에서 보겠습니다.

## API Client

RestAPI SDK를 만들려 한다면, 위와 같은 curl 처리에 대한 부분은 httpClient 상위 클래스에서 구현하고 있어야 합니다.


