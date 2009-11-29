<?php
class Person extends AppModel {

	var $name = 'Person';
	
	//Defines the hierarchical structure
	var $actsAs = array('Tree');
	
	var $validate = array(
        'name' => array('blank' =>
            array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Vul een naam in.'
            ),
            array(
            	'rule' => 'checkStatusLid',
                'message' => 'Sorry, er bestaat al een lid met deze naam.'
            )
        ),
       'status' => array('blank' =>
            array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Vul een staus in.'
            ),
            'allowedChoice' => array(
                'rule' => array('inList', array('Lid', 'Reunist', 'Overleden')),
                'message' => 'Toegestane waardes: \'Lid\',\'Reunist\' en \'Overleden\'',
            ),
            'notDied' => array(
                'rule' => 'checkNotDied',
                'message' => 'De status moet \'overleden\' of \'reunist\' zijn als de overlijdensdatum is ingevuld'
            )
        ),
        'picture' => array(
            'rule' => 'checkPhotoExtension',
            'message' => 'De foto moet in het formaat \'JPG\' zijn.'
        ),
        'born_intro' => array(
			'allowedChoice' => array(
				'rule' => array('inList', array('', 'intro', 'na-intro')),
				'message' => 'Toegestane waardes: \'intro\' en \'na-intro\'',
			),
		),
	);
		
	/**
	 * find the person and it's parent
	 * @param $id person_id
	 * @return array $person person
	 */
	function findPersonParentChilds($id) {
		//get the family of a person
	    $parent = $this->getparentnode($id);
	    if (!empty($parent)) {
		      $grandparent = $this->getparentnode($parent['Person']['id']);
		      $brothers = $this->children($parent['Person']['id'], true);
	    } else {
	          $grandparent = array();
	          $brothers = array();
	    }
		$children = $this->children($id, true);
		if (!empty($grandparent)) {
		     $uncles = $this->children($grandparent['Person']['id'], true);
		} else {
		     $uncles = array();
		}
        
		$cousins = array();
		foreach ($uncles as $uncle) {
		    if ($uncle['Person']['id'] != $parent['Person']['id']) {
      		   $uncle_children = $this->children($uncle['Person']['id'], true);
		       if (!empty($uncle_children)) {
      		        $cousins = array_merge($cousins, $uncle_children);
      		    }
		    }
        }
        
        //add all info to person
		$person = $this->findById($id);
		$person['Parent'] = $parent['Person'];
        $person['Grandparent'] = (!empty($grandparent['Person']) ? $grandparent['Person'] : '');
        $person['Brothers'] = $brothers;
        $person['Uncles'] = $uncles;
        $person['Cousins'] = $cousins;
        $person['Children'] = $children;
        return $person;
	}
	
	/**
	 * Find all the persons for the parent list sorted by name  
	 * except the person with the given id
	 * 
	 * @param $id person_id
	 * @return array $people people
	 */
	function findForParentList($id) {
	   return $this->find('list', 
            array('fields' => array('id', 'name'),
                'conditions' => array('id <>' => $id),
                'order' => 'name',
            ));
	}
	
	/**
	 * Logs a user in using his forumaccount
	 * @param $data
	 * @return $forumdata forumdata
	 */
	function forumLogin($data) {
		$this->useDbConfig = 'forum';
		$forumdata = $this->query("SELECT realname, memberName FROM smf_members WHERE memberName='".mysql_real_escape_string($data['Person']['username'])."' 
			AND passwd='".sha1(mysql_real_escape_string(strtolower($data['Person']['username'])) . mysql_real_escape_string($data['Person']['password']))."'");
		$this->useDbConfig = 'default';
	    return $forumdata;
	}
	
	/**
	 * Get the email and rrealname of a user
	 * @param $username
	 * @return boolean
	 */
	function getForumDataByUsername($username) {
        $this->useDbConfig = 'forum';
        $forumdata = $this->query("SELECT realname, emailAddress FROM smf_members WHERE memberName='".mysql_real_escape_string($username)."'");
        $this->useDbConfig = 'default';
        return $forumdata[0];
	}
	
	/**
	 * Check if there is another user exists with the same name and status 'Lid'
	 * @return boolean
	 */
	function checkStatusLid() {
	   if ($this->data['Person']['status'] != 'Lid') {
	      return true;
	   } else if ($this->find('first', array('conditions' => 
	      array('name' => $this->data['Person']['name'],
	         'status'=> 'Lid', 
	         'NOT' => 
	            array('id' => $this->id)) 
	      ))) {
	      return false;
       } else {
          return true;
       }
	}
	
	/**
	 * Check if status is correct if died date is filled in
	 * @return boolean
	 */
	function checkNotDied() {
	   if (($this->data['Person']['status'] != 'Overleden' && 
	       $this->data['Person']['status'] != 'Reunist') &&
	      ($this->data['Person']['died_year'] > 0 || 
	      !empty($this->data['Person']['died_intro']))) {
	      return false;
	   } else {
	      return true;
	   }
    }
    
    /**
     * Check if the file-extension is jpg
     * @return boolean
     */
    function checkPhotoExtension() {
       if (!empty($this->data['Image']['picture']['name'])) {
          $path_info = pathinfo($this->data['Image']['picture']['name']);
          if (strtolower($path_info['extension']) != 'jpg' && 
            strtolower($path_info['extension']) != 'jpeg') {
             return false;
          }
       }
       return true;  
    }
}
?>