<?php
	if ($this->action != 'index' || $this->name != 'People') {
		echo $html->link('Thuis', '/').' ';
	}
	if ((!$person = $session->read('person')) && empty($authUser) && ($this->name == 'People' && $this->action != 'login')) {
		echo $html->link('Login', array('controller' => 'people', 'action' => 'login'), $modalbox).' ';
	}
	if ($this->name == 'People' && !empty($person)) {
		echo $html->link('Wijzig je beschrijving', array('controller' => 'people', 'action' => 'edit'), $modalbox).' ';
		echo $html->link('Upload je foto', array('controller' => 'people', 'action' => 'upload')).' ';
		if (!empty($person['Person']['picture'])) {
			echo $html->link('Verwjder je foto', array('controller' => 'people', 'action' => 'picture_delete'), array('onclick' => 'return confirm("Wil je je foto echt verwijderen??");')).' ';
		}
		echo $html->link('Uitloggen', array('controller' => 'people', 'action' => 'logout')).' ';
		echo '<br />';
	}
	if (!empty($authUser)) {
		echo $html->link('Users admin', array('controller' => 'users', 'action' => 'index', 'admin' => 1)).' ';
		echo $html->link('People admin', array('controller' => 'people', 'action' => 'index')).' ';
		echo $html->link('Logout admin', '/users/logout');
	}
?>