<?php
    //Check if browser is IE6 or IE7
    if (strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE 6') || strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE 7')) {
        $ie = true;
    } else {
        $ie = false;
    }

    echo '<div class="person">';
    
	//create the tooltip if a picture is set
	if(!empty($data['Person']['picture'])) {
    	echo '<div class="link"
    		onmouseover="new Tip(this, {
    			borderColor: \'#ff4400\',
    			ajax: {
    				url: \'people/picture/'.$data['Person']['id'].'/small:1\',
    			}
    		});" >';
	} else {
		echo '<div class="link">';
	}
	
	//create link for explorer structure
	if (!empty($data['children']) && !$ie) {
           echo $html->link($html->image('collapse.png'), '', array('escape' => false, 'class' => 'fold'));
    }
    
	//if person is died or reunist set other link color
    $class = '';
	if ($data['Person']['status'] == 'Overleden') {
        $class .= 'died';
    } else if ($data['Person']['status'] == 'Reunist') {
        $class .= 'reunion';
    }

    if (!empty($data['children']) && !$ie) {
        $class .= ' children';
    }
    
    //display person link
    echo $html->link($data['Person']['name'], 
        array('controller' => 'people', 'action' => 'view', 'id' => $data['Person']['id']), 
        array('class' => $class, 'onclick' => $modalbox));
    
    //display born year and died year
    if ($data['Person']['born_year'] == 0) {
        $data['Person']['born_year'] = '?';
    }
    if ($data['Person']['died_year'] == 0) {
        $data['Person']['died_year'] = '?';
    }
    echo ' ' . $data['Person']['born_intro'] . ' ' . $data['Person']['born_year'] . 
        ' - '. $data['Person']['died_year'] . '</div>';

	if (!empty($data['Person']['description'])) {
		echo '<div class="description">'.nl2br($data['Person']['description']).'</div>';
	}
	echo '</div>';
	
	//display links for admin
	if (!empty($authUser) && $authUser['User']['username'] == 'admin') {
		echo '<div class="admin_bar">'.$html->link('Bewerk', array('controller' => 'people', 'action' => 'edit', 'id' => $data['Person']['id'], 'admin' => 1), array('onclick' => $edit_modalbox)).' '.
			$html->link('Voeg jojo toe', array('controller' => 'people', 'action' => 'add', 'parent_id' => $data['Person']['id'], 'admin' => 1), array('onclick' => $edit_modalbox)).' '.
			$html->link('Verwijder Libertijn en jojo\'s', array('controller' => 'people', 'action' => 'delete', 'id' => $data['Person']['id'], 'admin' => 1)).' '.
			$html->link('Verwijder Libertijn', array('controller' => 'people', 'action' => 'delete', 'id' => $data['Person']['id'], 'remove_from_tree' => true, 'admin' => 1)).' '.
			$html->link('Upload foto', array('controller' => 'people', 'action' => 'upload', 'id' => $data['Person']['id'], 'admin' => 1), array('onclick' => $edit_modalbox)).' ';
		if (!empty($data['Person']['picture'])) {
		    echo $html->link('Verwijder foto', array('controller' => 'people', 'action' => 'picture_delete', 'id' => $data['Person']['id'], 'admin' => 1));
		}
		echo '</div>';
	}
	   
	
?>