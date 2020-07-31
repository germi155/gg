<?php

// register an initializer
elgg_register_event_handler('init', 'system', 'aab_init');

function aab_init() {
    // register the save action
    elgg_register_action("aab/save", __DIR__ . "/actions/aab/save.php");
	
	// register the ajax example action do_math
    elgg_register_action("aab/save", __DIR__ . "/actions/aab/do_math.php");

    // register the page handler
    elgg_register_page_handler('aab', 'aab_page_handler');

    // register a hook handler to override urls
    elgg_register_plugin_hook_handler('entity:url', 'object', 'aab_set_url');
	
	// add a site navigation item
	$item = new ElggMenuItem('aab', elgg_echo('aab:aabs'), 'aab/all');
	elgg_register_menu_item('site', $item);
	
}
function aab_set_url($hook, $type, $url, $params) {
    $entity = $params['entity'];
    if (elgg_instanceof($entity, 'object', 'aab')) {
        return "aab/view/{$entity->guid}";
    }
}
function aab_page_handler($segments) {
    switch ($segments[0]) {
        case 'add':
           echo elgg_view_resource('aab/add');
           break;

        case 'view':
            $resource_vars['guid'] = elgg_extract(1, $segments);
            echo elgg_view_resource('aab/view', $resource_vars);
            break;

        case 'all':
        default:
           echo elgg_view_resource('aab/all');
           break;
    }

    return true;
}