<?php
/* SVN FILE: $Id: app_controller.php 6311 2008-01-02 06:33:52Z phpnut $ */
/**
 * Application-wide controller file.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		dpb
 * @subpackage	dpb
 */
class AppController extends Controller {
	
	/**
	 * Components made available to this controller
	 *
	 * @var array
	 */
	var $components = array('Acl','Auth');
	/**
	 * Models made available to this controller
	 *
	 * @var unknown_type
	 */
	var $uses = array('User');
	/**
	 * Which layout file to use
	 *
	 * @var string
	 */
	var $layout = 'default';
	/**
	 * Helpers made available to the views
	 *
	 * @var array
	 */
	var $helpers = array('Javascript');
	
	/**
	 * AuthComponent
	 *
	 * @var AuthComponent
	 */
	var $Auth;
	/**
	 * AclComponent
	 *
	 * @var AclComponent
	 */
	var $Acl;
	
	/**
	 * Configure AuthComponent
	 *
	 * @access public
	 */
	function beforeFilter() {
		$this->Auth->authorize = 'actions';
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
		$this->Auth->logoutRedirect = array('controller' => 'people', 'action' => 'index');
		$this->Auth->loginRedirect = array('controller' => 'people', 'action' => 'index');
		
		//Set security temporary lower to reload page with javascript
		Configure::write('Security.level', 'medium');
		
		if ($this->Auth->user()) {
			$this->set('authUser', $this->Auth->user());
		}
		
		Configure::write('Security.level', 'high');
		
	}
	
	/**
	 * Delete the people image
	 * 
	 * @param $name
	 * @access private
	 */
	function __deleteImage($name){
		unlink('img/people/small/'.$name);
		unlink('img/people/big/'.$name);
	}
	
}
?>
