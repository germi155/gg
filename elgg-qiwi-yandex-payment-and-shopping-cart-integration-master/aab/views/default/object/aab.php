<?php
$full = elgg_extract('full_view', $vars, FALSE);

// full view
if ($full) {
    echo elgg_view('output/longtext', array('value' => $vars['entity']->description));
    echo elgg_view('output/tags', array('tags' => $vars['entity']->tags));
	echo elgg_view('output/text', array('value' => $vars['entity']->sum));
	echo elgg_view('output/text', array('value' => $vars['entity']->formcomment));

// list view or short view
} else {
    // make a link out of the post's title
    echo elgg_view_title(
        elgg_view('output/url', array(
            'href' => $vars['entity']->getURL(),
            'text' => $vars['entity']->title,
			'is_trusted' => true
    )));
    echo elgg_view('output/tags', array('tags' => $vars['entity']->tags));
}