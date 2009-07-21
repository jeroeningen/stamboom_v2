<?php
class PeopleController extends AppController {

	var $name = 'People';
	var $helpers = array('Html', 'Form', 'Tree', 'Javascript');
	var $uses = 'Person';
	var $components = array("Image", "Email");

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allowedActions = array('index', 'view', 'login', 'logout', 'edit', 'upload', 'picture', 'picture_delete', 'complain');
		
		//do the necessary things for modalbox
		$this->layout = 'popup';
        $this->set('modalbox', array('onclick' => 'Modalbox.show(this.href, {title: this.title, afterHide: function() {location.href = document.location}, width: 600, params: null, autoFocusing: true}); return false;'));
        $this->set('modalbox_picture', array('onclick' => 'Modalbox.show(this.href, {title: this.title, afterHide: function() {location.href = document.location}, width: 600, method: \'post\', autoFocusing: true}); return false;'));
	}
	
	function index() {
		$this->layout = 'default';
		$this->Person->recursive = 0;
		$this->set('people', $this->Person->findForTree());
	}
	
	function edit() {
		if(isset($this->data['Person']['description'])) {
			$person = $this->Session->read('person');
			$this->Person->read(null, $person['Person']['id']);
			$this->Person->saveField('description', $this->data['Person']['description']);
			$this->redirect(array('controller' => 'people', 'action' => 'view', 'id' => $person['Person']['id']));
		} else if(!$this->data = $this->Session->read('person')) {
			$this->redirect(array('action' => 'login'));
		}
	}
	
	function complain($name) {
	   $person = $this->Person->getForumDataByUsername($name);
	   $from = $person['smf_members']['realname'] . "<" . $person['smf_members']['emailAddress']; 
	   $this->Email->sendAs = 'html';
	   $this->Email->to = "tom@svliber.nl <jeroeningen@gmail.com>";
       $this->Email->bcc = array($from);
       $this->Email->from = $from;
       $this->Email->subject = "Aan de slag!";
       pr($this->Email->send(array("Welverdorie, ben je nu onze geliefde " . $person['smf_members']['realname'] . "vergeten? Waar wacht je nog op, toevoegen die handel!")));
       
	   exit();
	}
	
	function picture($id = null) {
		if ($this->params['named']['small']) {
			$this->layout = 'tooltip'; 
		}
		$this->set('person', $this->Person->read(null, $id));
	}
	
	function upload() {
		 if (!empty($this->data['Image']['picture']['name'])) {
			if (!empty($this->data['Person']['picture'])) {
				$this->deleteImage($this->data['Person']['picture']);
			}
			$this->data['Person']['picture'] = $this->Image->upload_image_and_thumbnail($this->data,"picture",573,80,"people",true);
			$person = $this->Session->read('person');
			$person = $this->Person->read(null, $person['Person']['id']);
			$this->Person->save($this->data);
			$person = $this->Person->read(null, $person['Person']['id']);
			$this->Session->write('person', $person);
			$this->redirect(array('action' => 'index'));
		} else if(!$this->data = $this->Session->read('person')) {
			$this->redirect(array('action' => 'login'));
		}
		
		$person = $this->Session->read('person');
		$this->data = $this->Person->read(null, $person['Person']['id']);
	}
	
	function picture_delete() {
		$person = $this->Session->read('person');
		$person = $this->Person->read(null, $person['Person']['id']);
		if (!empty($person['Person']['picture'])) {
			$this->deleteImage($person['Person']['picture']);
		}
		$person['Person']['picture'] = "";
		$this->Person->save($person);
		$this->Session->write('person', $person);
		$this->redirect(array('action'=>'index'));
	}
	
	function login() {
	    $this->set('modalbox_login', array('onclick' => 'Modalbox.show(this.form.action, {method: \'post\', params: Form.serialize(this.form.id)})'));
		if (!empty($this->data)) {
			if ($person = $this->Person->forumLogin($this->data)) {
				if ($person = $this->Person->findByName($person[0]['smf_members']['realname'])) {
					$this->Session->write('person', $person);
					$this->Session->setFlash('Dag '.$person['Person']['name']);
					$this->redirect(array('controller' => 'pages', 'action' => 'hide'));
				} else {
					$this->Session->setFlash('Sorry, je bent nog niet toegevoegd aan de stamboom. <a href="mailto:tom@svliber.nl?subject=Tom, dit is weer een punt voor Leon">Hier</a> kun je erover klagen.');
				}
			} else {
				$this->Session->setFlash('Foute gebruiksnaam en/of wachtwoord');
			}
		} else {
			$this->Session->setFlash('Gebruik je forumgegevens om in te loggen');
		}
	}
	
	function logout() {
		$this->Session->del('person');
		$this->Session->setFlash('DOEI!');
		$this->redirect('/');
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Person.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('person', $this->Person->findPersonParentChilds($id));
	}

	function admin_index() {
		$this->layout = 'default';
		$this->Person->recursive = 0;
		$this->set('people', $this->Person->findForTree());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Person.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('person', $this->Person->findPersonParentChilds($id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Person->create();
			if (empty($this->data['Person']['parent_id'])) {
				$this->data['Person']['parent_id'] = 0;
			}
			if ($this->Person->save($this->data)) {
				$this->redirect(array('controller' => 'pages', 'action' => 'hide'));
			} else {
				$this->Session->setFlash(__('The Person could not be saved. Please, try again.', true));
			}
		}
		$this->set('people', $this->Person->find('list',
			array('fields' => array('id', 'name'),
			'order' => 'name',
		)));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Person', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->Person->id = $id;
			$newParentId = $this->Person->field('id', array('id' => $this->data['Person']['parent_id']));
			if ($this->Person->save($this->data)) {
				$this->redirect(array('controller' => 'pages', 'action' => 'hide'));
			} else {
				$this->Session->setFlash(__('The Person could not be saved. Please, try again.', true));
			}
		} else {
			$this->data = $this->Person->read(null, $id);
		}
		$this->set('people', $this->Person->find('list', 
			array('fields' => array('id', 'name'),
				'conditions' => array('id <>' => $id),
				'order' => 'name',
			)
		));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Person', true));
			$this->redirect(array('action'=>'index'));
		}
		
		$person = $this->Person->read(null, $id);
		if (!empty($person['Person']['picture'])) {
			$this->deleteImage($person['Person']['picture']);
		}
		if (!empty($this->params['named']['remove_from_tree'])) {
			if ($this->Person->removefromtree($id, true)) {
				$this->redirect(array('action'=>'index'));
			}
		} else if ($this->Person->del($id)) {
			$this->redirect(array('action'=>'index'));
		}
	}
	
	function admin_picture_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Person', true));
			$this->redirect(array('action'=>'index'));
		}
		
		$person = $this->Person->read(null, $id);
		if (!empty($person['Person']['picture'])) {
			$this->deleteImage($person['Person']['picture']);
		}
		$person['Person']['picture'] = "";
		$this->Person->save($person);
		$this->redirect(array('action'=>'index'));
	}
	
	function admin_upload($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Person', true));
			$this->redirect(array('action'=>'index'));
		}
		
		if (!empty($this->data['Image']['picture']['name'])) {
			if (!empty($this->data['Person']['picture'])) {
				$this->deleteImage($this->data['Person']['picture']);
			}
			$this->data['Person']['picture'] = $this->Image->upload_image_and_thumbnail($this->data,"picture",573,80,"people",true);
			$this->Person->read(null, $id);
			$this->Person->save($this->data);
			$this->redirect(array('action' => 'index'));
		}
		//$this->set('swfupload', true);
		$this->data = $this->Person->read(null, $id);
		$this->layout = 'default';
	}

}
?>