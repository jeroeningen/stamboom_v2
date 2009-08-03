//set focus on first formelement
document.observe('dom:loaded', function() {
	if ($('user_form') != null) {
		$('user_form').getElements()[1].focus();
	}
});