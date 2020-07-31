<?php
echo elgg_view_field([
    '#type' => 'text',
    '#label' => elgg_echo('title'),
    'name' => 'title',
    'required' => true,
]);

echo elgg_view_field([
    '#type' => 'longtext',
    '#label' => elgg_echo('body'),
    'name' => 'body',
    'required' => true,
]);

echo elgg_view_field([
    '#type' => 'tags',
    '#label' => elgg_echo('tags'),
    '#help' => elgg_echo('tags:help'),
    'name' => 'tags',
]);

echo elgg_view_field([
    '#type' => 'number',
    '#label' => elgg_echo('sum'),
    'name' => 'sum',
	'min' => 0,
	'step' => 0.01,
]);

echo elgg_view_field([
    '#type' => 'text',
    '#label' => elgg_echo('formcomment'),
    'name' => 'formcomment',
	'value' => "Проект «Железный человек»: реактор холодного ядерного синтеза",
    'required' => true,
]);

$submit = elgg_view_field(array(
    '#type' => 'submit',
    '#class' => 'elgg-foot',
    'value' => elgg_echo('save'),
));
elgg_set_form_footer($submit);