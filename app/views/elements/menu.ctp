<?php
	if ($this->action != 'index' || $this->name != 'People') {
		echo $html->link('Thuis', '/').' ';
	}
	if (empty($authUser) && ($this->name == 'People' && $this->action != 'login')) {
		echo $html->link('Login', array('controller' => 'people', 'action' => 'login', 'admin' => 0), $modalbox).' ';
	}
	if ($this->name == 'People' && !empty($authUser) && $authUser['User']['username'] == 'guest') {
		echo $html->link('Wijzig je beschrijving', array('controller' => 'people', 'action' => 'edit', 'admin' => 0), $modalbox).' ';
		echo $html->link('Upload je foto', array('controller' => 'people', 'action' => 'upload', 'admin' => 0), $modalbox_picture).' ';
		if (!empty($person['Person']['picture'])) {
			echo $html->link('Verwjder je foto', array('controller' => 'people', 'action' => 'picture_delete', 'admin' => 0), array('onclick' => 'return confirm("Wil je je foto echt verwijderen??");')).' ';
		}
		echo $html->link('Uitloggen', array('controller' => 'people', 'action' => 'logout', 'admin' => 0)).' ';
		echo '<br />';
	}
	if (!empty($authUser) && $authUser['User']['username'] == 'admin') {
		echo $html->link('Users admin', array('controller' => 'users', 'action' => 'index', 'admin' => 1)).' ';
		echo $html->link('People admin', array('controller' => 'people', 'action' => 'index')).' ';
		echo $html->link('Logout admin', '/users/logout');
	}
?>