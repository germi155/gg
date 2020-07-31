<?php
// get the form inputs
$title = get_input('title');
$body = get_input('body');
$tags = string_to_tag_array(get_input('tags'));
$sum = get_input('sum');
$formcomment = get_input('formcomment');

// create a new aab object and put the content in it
$blog = new ElggObject();
$blog->title = $title;
$blog->description = $body;
$blog->tags = $tags;
$blog->sum = $sum;
$blog->formcomment = $formcomment;

// the object can and should have a subtype
$blog->subtype = 'aab';

// for now, make all aab posts public
$blog->access_id = ACCESS_PUBLIC;

// owner is logged in user
$blog->owner_guid = elgg_get_logged_in_user_guid();

// save to database and get id of the new aab
$blog_guid = $blog->save();

$body .= elgg_echo('aab:yandex:client_id2');

//integrating yandex api start
//code taken from https://github.com/yandex-money/yandex-money-sdk-php/

// For payments from the Yandex.Money wallet
require_once '\mod\aab\yandex-money-sdk-php-master\lib\api.php';

// For payments from bank cards without authorization
require_once '\mod\aab\yandex-money-sdk-php-master\lib/external_payment.php';


//Payments from the Yandex.Money wallet
//1.Obtain token URL and redirect user's browser to Yandex.Money service. Note: client_id, redirect_uri, 
//client_secret are constants that you get, when register app in Yandex.Money API.

use \YandexMoney\API;
$client_id = $yandex_client_id;
$redirect_uri = yandex_redirect_uri;


$auth_url = API::buildObtainTokenUrl($client_id, $redirect_uri, $scope);

/*

//2.After that, user fills Yandex.Money HTML form and user is redirected back to REDIRECT_URI?code=CODE.

//3.You should immediately exchange CODE with ACCESS_TOKEN.

$access_token_response = API::getAccessToken($client_id, $code, $redirect_uri, $client_secret=$yandex_client_secret);
if(property_exists($access_token_response, "error")) {
    // process error
}
$access_token = $access_token_response->access_token;



//4.Now you can use Yandex.Money API.

$api = new API($access_token);

// get account info
$acount_info = $api->accountInfo();

// check status 

// get operation history with last 3 records
$operation_history = $api->operationHistory(array("records"=>3));

// check status 

// make request payment
$request_payment = $api->requestPayment(array(
    "pattern_id" => "p2p",
    "to" => $money_wallet,
    "amount_due" => $amount_due,
    "comment" => $comment,
    "message" => $message,
    "label" => $label,
));

// check status 

// call process payment to finish payment
$process_payment = $api->processPayment(array(
    "request_id" => $request_payment->request_id,
));

//Payments from bank cards without authorization

//1.Fetch instantce-id(ussually only once for every client. You can store result in DB).

    use \YandexMoney\ExternalPayment;

    $response = ExternalPayment::getInstanceId($client_id);
    if($response->status == "success") {
        $instance_id = $response->instance_id;
    }
    else {
        // throw exception with $response->error message
    }

//2.Make request payment

    // make instance
    $external_payment = ExternalPayment($instance_id);

    $payment_options = array(
        // pattern_id, etc..
    );
    $response = $external_payment->request($payment_options);
    if($response->status == "success") {
        $request_id = $response->request_id;
    }
    else {
        // throw exception with $response->message
    }

//3.Process the request with process-payment.

    $process_options = array(
        "request_id" => $request_id
        // other params..
    );
    $result = $external_payment->process($process_options);
    // process $result according to docs


//integrating yandex api END




/*
//QIWI PAYMENT PROCESS BEGINNING EXAMPLE AT https://webcodingsolutions.blogspot.ru/2014/07/qiwi.html
//Сначала нужно выставить пользователю счет. Для этого отправим запрос через cURL:

$url = 'https://w.qiwi.com/api/v2/prv/'.$shopid.'/bills/'.$id;
$loginPass = $apiid.':'.$pass;
$lifetime = date('c', time() + 86400);
$parameters = array(
    "user" => "tel:+".intval($mobile),
    "amount" => $amount,
    "ccy" => $currency,
    "comment" => $comment,
    "lifetime" => $lifetime,
    "pay_source" => "qw"
);
$headers = array(
 "Accept: application/json",
 "Content-Type: application/x-www-form-urlencoded; charset=utf-8"
);
$parameters = http_build_query($parameters);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, $loginPass);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
curl_setopt($ch, CURLOPT_POST, 1);
$httpResponse = curl_exec($ch);
$results = json_decode($httpResponse);
$result_code = $results->response->result_code;
$description = $results->response->description;


//$shopid - Идентификатор вашего магазина
//$id - ID платежа в вашей системе. Будет использован для поиска нужного платежа в вашей БД
//$apiid - Ваш API ID
//$pass - Пароль API
//$mobile - Телефон (аккаунт) пользователя, на который будет выставлен счет
//$amount - Сумма, на которую выставляется счет
//$currency - Валюта. По-умолчанию доступна только RUB (рубли РФ)
//$comment - Описание платежа
//$lifetime - Время, которое выставленный счет будет активен (можно оплатить). В примере - сутки.
//$result_code - Код ответа сервера. Если не равен 0 - ошибка.
//$description - Текст ошибки, если она есть


$url = 'https://w.qiwi.com/order/external/main.action?shop='.$shopid.'&transaction='.$id.'&successUrl='.$success_url.'&failUrl='.$fail_url.'&qiwi_phone='.$mobile;


//$shopid - Идентификатор вашего магазина (тот-же, что и выше)
//$id - ID платежа в вашей системе. Будет использован для поиска нужного платежа в вашей БД (тот-же, что и выше)
//$success_url - Ссылка на страницу успешной оплаты (Вернуться на ваш сайт после оплаты)
//$fail_url - Ссылка на страницу ошибки или отказа от оплаты (Вернуться на ваш сайт после неудачной оплаты)
//$mobile - Телефон (аккаунт) пользователя, на который будет выставлен счет (тот-же, что и выше)


// И отправляем пользователя на этот URL, например так:

header('Location: '.$url);


//Настройка аккаунта

//Настроить аккаунт можно по адресу: https://ishop.qiwi.com/balance/overview.action (официальный сайт Qiwi)
//Нужно создать проект: "Новый проект". Поля элементарные, описывать не буду. Обратите внимание, что API будут работать только после проверки проекта администрацией Qiwi (статус "Подтвержден").
//Переходим в настройки проекта, кликом на его название:
//Аутентификационные данные для всех протоколов - Сгенерировать новый ID. Записать в свою БД (Идентификатор - переменная $apiid в этой статье, пароль - переменная $pass)
//Идентификатор магазина - Записать в свою БД (переменная $shopid в этой статье)
//Настройки Pull (REST) протокола - Включить
//Включить уведомления - Включить
//URL для оповещения - Ссылка на файл обработки операции. Описание содержания этого файла смотрите в пункте "Обработка запроса" этой статьи
//Сменить пароль оповещения - нажать и сохранить пароль в БД (переменная $key в этой статье)
//Подпись - Отметить галочкой




//Обработка запроса

//После оплаты платежная система присылает запрос на указанный вами URL для оповещения. В этом файле, в первую очередь, необходимо проверить подлинность запроса, ведь он мог быть запущен не платежной системой. После чего уже делаем нужны операции: изменение статуса платежа в вашей БД или пополнение счета пользователя на сайте. Начнем по порядку.
//Система присылает следующие данные (сразу сократим названия переменных, зачем нам в коде длинные переменные?):

$id          =trim($_POST['bill_id']);
$status      =trim($_POST['status']);
$error       =trim($_POST['error']);
$amount      =trim($_POST['amount']);
$user        =trim($_POST['user']);
$prv_name    =trim($_POST['prv_name']);
$ccy         =trim($_POST['ccy']);
$comment     =trim($_POST['comment']);
$command     =trim($_POST['command']);
$head        =apache_request_headers();
$hash        =$head['X-Api-Signature'];


//bill_id - ID платежа в вашей системе
//status - Статус платежа. Успешный: paid
//error - Ошибка, если она есть
//amount - Сумма платежа
//user - Телефон (аккаунт) пользователя, который оплатил счет
//ccy - Валюта платежа
//comment - Описание платежа
//X-Api-Signature - Подпись запроса (хеш)

//Теперь нужно проверить хеш. Это обязательное действие. Без него безопасность данной операции будет близка к нулю.
//Создадим свой вариант хеша, по возможности используя данные из своей БД (постфикс _bd в переменных; используйте $id для поиска нужной транзакции):


$hash_gen = base64_encode(hash_hmac("sha1", $amount_bd.'|'.$id.'|'.$ccy_bd.'|'.$command.'|'.$comment.'|'.$error.'|'.$prv_name.'|'.$status.'|'.$user_bd, $key, $raw_output=TRUE));
if($hash_gen!=$hash) // ошибка


//Переменная $key - пароль оповещения, который вы встречали в настройках аккаунта

//С проверками закончили. Теперь можно сделать то, ради чего этот запрос пришел - изменить статус транзакции или пополнить счет пользователя, на ваше усмотрение. И эти действия я описывать не буду - все в ваших руках.

//Осталось только вернуть системе правильный ответ.
//Ответ для успешного завершения:


header("HTTP/1.1 200 OK");
header('content-type: text/xml; charset=UTF-8');
echo '0'; 
exit; 


//Для завершения с ошибкой - измените result_code (0) на другой:
//5 - Ошибка формата параметров запроса
//13 - Ошибка соединения с базой данных
//150 - Ошибка проверки пароля
//151 - Ошибка проверки подписи
//300 - Ошибка связи с сервером
QIWI PAYMENT PROCESS ENDING EXAMPLE AT https://webcodingsolutions.blogspot.ru/2014/07/qiwi.html
*/


// if the aab was saved, we want to display the new post
// otherwise, we want to register an error and forward back to the form
if ($blog_guid) {
   system_message("Your blog post was saved.");
   forward($blog->getURL());
} else {
   register_error("The blog post could not be saved.");
   forward(REFERER); // REFERER is a global variable that defines the previous page
}