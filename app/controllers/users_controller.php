<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form');
	var $components = array('Acl', 'Auth');
	
	function beforeFilter() {
		parent::beforeFilter(); 
		$this->Auth->allowedActions = array('login', 'logout');
	}
	
	/**
	 * create the necessary rights for the admin
	 * 
	 * @access private
	 * @return unknown_type
	 */
	function createAcl() {
		/**$this->Acl->allow('admin', 'controllers/Users/createAcl');
		$this->Acl->allow('admin', 'controllers/Users/admin_index');
		$this->Acl->allow('admin', 'controllers/Users/admin_add');
		$this->Acl->allow('admin', 'controllers/Users/admin_edit');
		$this->Acl->allow('admin', 'controllers/Users/admin_view');
		$this->Acl->allow('admin', 'controllers/Users/admin_delete');
		$this->Acl->allow('admin', 'controllers/People/admin_index');
		$this->Acl->allow('admin', 'controllers/People/admin_add');
		$this->Acl->allow('admin', 'controllers/People/admin_edit');
		$this->Acl->allow('admin', 'controllers/People/admin_view');
		$this->Acl->allow('admin', 'controllers/People/admin_delete');
		$this->Acl->allow('admin', 'controllers/People/admin_upload');
		$this->Acl->allow('admin', 'controllers/People/admin_picture_delete');
		$this->Acl->allow('admin', 'controllers/Pages/display');
		$this->Acl->allow('guest', 'controllers/People/edit');
        $this->Acl->allow('guest', 'controllers/People/upload');
        $this->Acl->allow('guest', 'controllers/People/picture_delete');
		**/
	}
	
	function login() {
		if (!empty($this->data)) {
			if (!$this->Auth->login($this->data)) {
				$this->Session->setFlash('Foute gebruiksnaam en/of wachtwoord');
			}
		}
	}
	
	function admin_login() {
		$this->redirect('/users/login');
	}
	
	function logout() {
		$this->Session->setFlash('DOEI!');
		$this->redirect($this->Auth->logout());
	}

	function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
		$this->data['User']['password'] = '';
	}

	

}
?>