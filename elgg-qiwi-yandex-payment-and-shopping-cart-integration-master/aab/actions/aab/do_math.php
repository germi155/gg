elgg_ajax_gatekeeper();

$arg1 = (int)get_input('arg1');
$arg2 = (int)get_input('arg2');

//will be rendered client side
system_message('We did it!');

echo json_encode([
	'sum' =>  $arg1 + $arg2,
	'product' => $arg1 * $arg2,
]);

var Ajax = require('elgg/Ajax');
var ajax = new Ajax;

ajax.action('do_math', {
	data: {
		arg1:1,
		arg2:2
	},
}).done(functin (output, statusText, jqXHR) {
	if (jqXHR.AjaxData.status == -1) {
		return;
	}
	
	alert(output.sum);
	alert(output.product);
});