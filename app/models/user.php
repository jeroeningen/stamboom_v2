<?php
class User extends AppModel {

	var $name = 'User';
	var $validate = array(
		'username' => array('blank' =>
			array(
				'rule' => array('minLength',1),
				'required' => true,
				'message' => 'The field cannot be left blank'
			)
		),
	);
	
	var $actsAs = array('Acl' => array('requester'));

	function parentNode() {
		
	}
}
?>