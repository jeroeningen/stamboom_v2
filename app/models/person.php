<?php
class Person extends AppModel {

	var $name = 'Person';
	
	//Defines the hierarchical structure
	var $actsAs = array('Tree');
	
	var $validate = array(
		'name' => array('blank' =>
			array(
				'rule' => array('minLength',1),
				'required' => true,
				'message' => 'Vul een naam in.'
			)
		),
		'born_intro' => array(
			'allowedChoice' => array(
				'rule' => array('inList', array('', 'intro', 'na-intro')),
				'message' => 'Toegestane waardes: \'intro\' en \'na-intro\'',
			),
		),
		'died_intro' => array(
			'allowedChoice' => array(
				'rule' => array('inList', array('', 'intro', 'na-intro')),
				'message' => 'Toegestane waardes: \'intro\' en \'na-intro\'',
			),
		),
		);
		
	/**
	 * find the data sorted for the tree
	 * @return array $tree tree_data
	 */
	function findForTree() {
		return $this->find('all', array('fields' => array('id', 'name', 'description', 'picture', 'parent_id', 'lft', 'rght'), 'order' => 'lft ASC'));
	}
	
	/**
	 * find the person and it's parent
	 * @param $id person_id
	 * @return array $person person
	 */
	function findPersonParentChilds($id) {
		$parent = $this->getparentnode($id);
		$children = $this->children($id, true);
		$person = $this->findById($id);
		$person['Parent'] = $parent['Person'];
		$person['Children'] = $children;
		return $person;
	}
	
	/**
	 * Logs a user in using his forumaccount
	 * @param $data
	 * @return $forumdata forumdata
	 */
	function forumLogin($data) {
		$this->useDbConfig = 'forum';
		$forumdata = $this->query("SELECT realname, passwd FROM smf_members WHERE memberName='".$data['Person']['username']."' 
			AND passwd='".sha1(strtolower($data['Person']['username']) . $data['Person']['password'])."'");
		$this->useDbConfig = 'default';
		if (!empty($forumdata)) {
			return $forumdata;
		} else {
			return false;
		}
	}
}
?>