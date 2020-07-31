<?php
$titlebar = "All Site aabs";
$pagetitle = "List of all aabs";

$body = elgg_list_entities(array(
    'type' => 'object',
    'subtype' => 'aab',
));

//add button to create new aab:add
elgg_register_title_button();

$body = elgg_view_title($pagetitle) . elgg_view_layout('one_column', array('content' => $body));

echo elgg_view_page($titlebar, $body);

echo elgg_list_entities(array(
    'type' => 'object',
    'subtype' => 'aab',
    'owner_guid' => elgg_get_logged_in_user_guid()
));