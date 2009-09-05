<?php
class PeopleController extends AppController {

	var $name = 'People';
	var $helpers = array('Html', 'Form', 'Tree', 'Javascript');
	var $uses = 'Person';
	var $components = array("Image", "Email");

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allowedActions = array('index', 'view', 'login', 'logout','picture' , 'complain');
		
		//get the picture of the logged in user
		if ($this->Session->read('person')) {
            $this->set('person', $this->Person->read('picture', $this->Session->read('person')));
        }
		
		//set the default layout to modalbox
		$this->layout = 'popup';
		
		/**
		 * set the javascript for the bsic links to open modalbox
		 * This is not done on-the-fly, because that is very slow.
		 */
		$this->set('modalbox', 'Modalbox.show(this.href, {title: this.title, afterHide: function() {location.href = document.location}, width: 600, params: null, autoFocusing: true}); return false;');
	}
	
	function index() {
		$this->layout = 'default';
		$this->Person->recursive = 0;
		$this->set('people', $this->Person->findForTree());
	}
	
	//edit action for forumuser (uses guest account)
	function edit() {
		if(!empty($this->data)) {
		    //prevent from html-injection
		    $this->data['Person']['description'] = strip_tags($this->data['Person']['description'], '<a><b>');
		    
		    $this->Person->read(null, $this->Session->read('person'));
			if ($this->Person->save($this->data, array('fieldList' => array('description', 'parent_id', 'born_intro', 'born_year', 'died_year', 'status')))) {
			     $this->redirect(array('controller' => 'people', 'action' => 'view', 'id' => $this->Session->read('person')));
			}
		} else {
		    $this->data = $this->Person->read(null, $this->Session->read('person'));
		    //do not set ID in url
		    unset($this->data['Person']['id']);
        }
		$this->set('people', $this->Person->findForParentList($this->Session->read('person')));
	}
	
	//function to send the complain-mail
	function complain($name) {
       $person = $this->Person->getForumDataByUsername($name);
	   $from = $person['smf_members']['emailAddress'];
	   $this->Email->sendAs = 'html';
	   $this->Email->to = "tom@svliber.nl";
       $this->Email->bcc = array($from);
       $this->Email->from = $from;
       $this->Email->subject = "Aan de slag!";
       $this->Email->send(array("Welverdorie, ben je nu onze geliefde " . $person['smf_members']['realname'] . " vergeten? Waar wacht je nog op, toevoegen die handel!"));
	}
	
	//function to show the picture in the tootip and the large picture in the profile
	function picture($id = null) {
		if (!empty($this->params['named']['small'])) {
			$this->layout = 'tooltip'; 
		}
		$this->set('person', $this->Person->read(null, $id));
	}
	
	//function to let the forumuser upload an image 
	function upload() {
		 if (!empty($this->data['Image']['picture']['name'])) {
			//if image exists delete it
			$person = $this->Person->read('picture', $this->Session->read('person'));
		    if (!empty($person['Person']['picture'])) {
				$this->__deleteImage($person['Person']['picture']);
			}
			$this->data['Person']['picture'] = $this->Image->upload_image_and_thumbnail($this->data,"picture",573,80,"people",true);
			$this->Person->read(null, $this->Session->read('person'));
			$this->Person->save($this->data);
			$this->redirect(array('action' => 'index'));
		}
		
		$this->data = $this->Person->read(null, $this->Session->read('person'));
	}
	
	//function to let the forumuser delete his image 
    function picture_delete() {
		$person = $this->Person->read(null, $this->Session->read('person'));
		if (!empty($person['Person']['picture'])) {
			$this->__deleteImage($person['Person']['picture']);
		}
		$person['Person']['picture'] = "";
		$this->Person->save($person);
		$this->redirect($this->referer());
	}
	
	//function to login a forumuser
	function login() {
	    if (!empty($this->data)) {
	        //use the forumdatabase to login
			if ($forum = $this->Person->forumLogin($this->data)) {
			     //check if the person in the tree still has the status 'Lid'
			     if ($person = $this->Person->find('first', 
			        array('conditions' => array(
			        	'status' => 'Lid',
      			        'name' => $forum[0]['smf_members']['realname'])
      			    ))) {
			        //login as guest and bind the personid to the session
					$this->Session->write('person', $person['Person']['id']);
			        $this->Auth->login(array('username' => 'guest', 'password' => $this->Auth->password('mafketel')));
			        $this->Session->setFlash('Dag '.$person['Person']['name']);
					$this->redirect(array('controller' => 'pages', 'action' => 'hide'));
				} else {
				    //set link to complain
                    $link = '<a id="complain_link" href="'.$this->base.'/people/complain/'.$forum[0]['smf_members']['memberName'].'">Klik hier</a>';
					$this->Session->setFlash('Sorry, je bent nog niet toegevoegd aan de stamboom. '. $link .' om te klagen.');
				}
			} else {
				$this->Session->setFlash('Foute gebruiksnaam en/of wachtwoord');
			}
		} else {
			$this->Session->setFlash('Gebruik je forumgegevens om in te loggen');
		}
	}
	
    //function to logout a forumuser
	function logout() {
		$this->Auth->logout();
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
			    //set the id for in the URL
				$this->data['Person']['id'] = $id;
                $this->Session->setFlash(__('The Person could not be saved. Please, try again.', true));
			}
		} else {
    		$this->data = $this->Person->read(null, $id);
		}
		$this->set('people', $this->Person->findForParentList($id));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Person', true));
			$this->redirect(array('action'=>'index'));
		}
		
		$person = $this->Person->read(null, $id);
		if (!empty($person['Person']['picture'])) {
			$this->__deleteImage($person['Person']['picture']);
		}
		if (!empty($this->params['named']['remove_from_tree'])) {
			if ($this->Person->removefromtree($id, true)) {
				$this->redirect(array('action'=>'index'));
			}
		} else if ($this->Person->del($id)) {
			$this->redirect(array('action'=>'index'));
		}
	}
	
	//function to delete image
	function admin_picture_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Person', true));
			$this->redirect(array('action'=>'index'));
		}
		
		$person = $this->Person->read(null, $id);
		if (!empty($person['Person']['picture'])) {
			$this->__deleteImage($person['Person']['picture']);
		}
		$person['Person']['picture'] = "";
		$this->Person->save($person);
		$this->redirect(array('action'=>'index'));
	}
	
	//function to upload an image
	function admin_upload($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Person', true));
			$this->redirect(array('action'=>'index'));
		}
		
		if (!empty($this->data['Image']['picture']['name'])) {
			$person = $this->Person->read('picture', $id);
            //if image exists, delete it
			if (!empty($person['Person']['picture'])) {
            	$this->__deleteImage($person['Person']['picture']);
			}
			$this->data['Person']['picture'] = $this->Image->upload_image_and_thumbnail($this->data,"picture",573,80,"people",true);
			$this->Person->read(null, $id);
			$this->Person->save($this->data);
			$this->redirect(array('action' => 'index'));
		}
		$this->data = $this->Person->read(null, $id);
	}

}
?>