<?php

// get the entity
$guid = elgg_extract('guid', $vars);
$aab = get_entity($guid);

elgg_push_context('aab/add');
// get the content of the post
$content = elgg_view_entity($aab, array('full_view' => true));

$params = array(
    'title' => $aab->title,
    'content' => $content,
	'filter' => '',
);
//$content .= elgg_view("$aab->sum");
$body = elgg_view_layout('content', $params);

echo elgg_view_page($aab->title, $body);
echo elgg_view('resources/aab/hello', ['name' => $aab->sum]);




//echo '<form method="POST" action="resources/aab/welcome.php">
echo '<form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml">
    <input type="hidden" name="receiver" value="410011361822871">
    <input type="hidden" name="formcomment" value="Проект «Железный человек»: реактор холодного ядерного синтеза">
    <input type="hidden" name="short-dest" value="$vars->title">
    <input type="hidden" name="label" value="$order_id">
    <input type="hidden" name="quickpay-form" value="donate">
    <input type="hidden" name="targets" value="транзакция {order_id}">
    <input type="hidden" name="sum" value="1" data-type="number">
    <input type="hidden" name="comment" value="Хотелось бы получить дистанционное управление.">
    <input type="hidden" name="need-fio" value="true">
    <input type="hidden" name="need-email" value="true">
    <input type="hidden" name="need-phone" value="false">
    <input type="hidden" name="need-address" value="false">
    <label><input type="radio" name="paymentType" value="PC">Яндекс.Деньгами</label>
    <label><input type="radio" name="paymentType" value="AC">Банковской картой</label>
    <input type="submit" value="Перевести">
</form>';


/*echo '<form action="resources/aab/welcome.php" method="post">
Name: <input type="text" name="name"><br>
E-mail: <input type="text" name="email"><br>
<input type="submit">
</form>';
*/

