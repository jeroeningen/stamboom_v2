<?php
	if ($this->action != 'index' || $this->name != 'People') {
		echo $html->link('Thuis', '/').' ';
	}
	
	//login link for guest user (forumuser)
	if (empty($authUser) && ($this->name == 'People' && $this->action != 'login')) {
		echo $html->link('Login Libertijnen', array('controller' => 'people', 'action' => 'login', 'admin' => 0), array('class' => 'modalbox_link')).' ';
	}
	
	//set menu for logged in user
	if ($this->name == 'People' && !empty($authUser) && $authUser['User']['username'] == 'guest') {
		echo $html->link('Wijzig je gegevens', array('controller' => 'people', 'action' => 'edit', 'admin' => 0, 'id' => null), array('class' => 'modalbox_link')).' ';
		echo $html->link('Upload je foto', array('controller' => 'people', 'action' => 'upload', 'admin' => 0), array('id' => 'picture_link')).' ';
		if (!empty($person['Person']['picture'])) {
			echo $html->link('Verwjder je foto', array('controller' => 'people', 'action' => 'picture_delete', 'admin' => 0), array('id' => 'picture_delete')).' ';
		}
		echo $html->link('Uitloggen', array('controller' => 'people', 'action' => 'logout', 'admin' => 0)).' ';
	}
	
	//set menu for admin user
	if (!empty($authUser) && $authUser['User']['username'] == 'admin') {
		echo $html->link('Users admin', array('controller' => 'users', 'action' => 'index', 'admin' => 1)).' ';
		echo $html->link('People admin', array('controller' => 'people', 'action' => 'index')).' ';
		echo $html->link('Logout admin', '/users/logout');
	}
?>