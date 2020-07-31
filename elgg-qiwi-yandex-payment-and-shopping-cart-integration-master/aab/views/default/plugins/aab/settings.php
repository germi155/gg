<?php


// elgg_load_library('elgg:pay');

$currency = elgg_get_plugin_setting('currency', 'pay');
$body .= elgg_echo('pay:settings:currency');
$body .= '<br />';
$body .= elgg_view('input/text',array('name'=>'params[currency]','value'=>$currency));
$body .= '<br />';

$body .= '<br />';
$body .= '<h3>' . elgg_echo('pay:settings:enabled_payment_handlers') . '</h3>';

$body .= '<br />';
	global $CONFIG;
	$handlers = $CONFIG->pay['payment_handlers'];
	foreach($handlers as $k => $v){
		$enabled = elgg_get_plugin_setting('enabled_payment_handlers_' . $k , 'pay') ? 'on' : false;	
		
		$body .= $k;
			
		$body .= elgg_view("input/checkbox", array(
														'name' => 'params[enabled_payment_handlers_' . $k .']',
														//'default' => $enabled,
														'checked' => $enabled
													
													));

	}
$body .= '<br />';

/* Yandex handler settings
 */

$body .= '<br />';
$body .= '<h3>yandex settings</h3>';
$yandex_client_id2 = elgg_get_plugin_setting('client_id2', 'aab');
$body .= elgg_echo('aab:yandex:client_id2');
$body .= '<br />';
$body .= elgg_view('input/text',array('name'=>'params[yandex_client_id2]','value'=>$yandex_client_id2));
$body .= '<br />';


$yandex_client_secret = elgg_get_plugin_setting('yandex_client_secret', 'aab');
$body .= elgg_echo('aab:yandex:client_secret');
$body .= '<br />';
$body .= elgg_view('input/text',array('name'=>'params[yandex_client_secret]','value'=>$yandex_client_secret));
$body .= '<br />';

$yandex_redirect_uri = elgg_get_plugin_setting('yandex_redirect_uri', 'aab');
$body .= elgg_echo('aab:yandex:redirect_uri');
$body .= '<br />';
$body .= elgg_view('input/text',array('name'=>'params[yandex_redirect_uri]','value'=>$yandex_redirect_uri));
$body .= '<br />';


$yandex_client_id = elgg_get_plugin_setting('yandex_client_id', 'aab');
$body .= elgg_echo('aab:yandex:client_id');
$body .= '<br />';
$body .= elgg_view('input/text',array('name'=>'params[yandex_client_id]','value'=>$yandex_client_id));
$body .= '<br />';


echo $body;
