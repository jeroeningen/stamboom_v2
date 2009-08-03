<?php
	$tree->addItemAttribute('class', 'leaf');
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
	
	//if person is died set other link color and unset it for the next links
	if ($data['Person']['died_year'] != 0000 && $data['Person']['died_year'] <= date("Y")) {
        echo $html->link($data['Person']['name'], 
            array('controller' => 'people', 'action' => 'view', 'id' => $data['Person']['id']), 
            array('class' => 'modalbox_link died')).'</div>';
	} else {
    	echo $html->link($data['Person']['name'], 
    		array('controller' => 'people', 'action' => 'view', 'id' => $data['Person']['id']), 
    		array('class' => 'modalbox_link')).'</div>';
	}

	echo '<div class="description">'.$data['Person']['description'].'</div>';
	echo '</div>';
	
	//set links for admin
	if (!empty($authUser) && $authUser['User']['username'] == 'admin') {
		echo '<div class="admin_bar">'.$html->link('Bewerk', array('controller' => 'people', 'action' => 'edit', 'id' => $data['Person']['id'], 'admin' => 1), array('class' => 'modalbox_link')).' '.
			$html->link('Voeg jojo toe', array('controller' => 'people', 'action' => 'add', 'parent_id' => $data['Person']['id'], 'admin' => 1), array('class' => 'modalbox_link')).' '.
			$html->link('Verwijder Libertijn en jojo\'s', array('controller' => 'people', 'action' => 'delete', 'id' => $data['Person']['id'], 'admin' => 1)).' '.
			$html->link('Verwijder Libertijn', array('controller' => 'people', 'action' => 'delete', 'id' => $data['Person']['id'], 'remove_from_tree' => true, 'admin' => 1)).' '.
			$html->link('Upload foto', array('controller' => 'people', 'action' => 'upload', 'id' => $data['Person']['id'], 'admin' => 1), array('class' => 'modalbox_link')).' ';
		if (!empty($data['Person']['picture'])) {
		    echo $html->link('Verwijder foto', array('controller' => 'people', 'action' => 'picture_delete', 'id' => $data['Person']['id'], 'admin' => 1));
		}
		echo '</div>';
	}
	   
	
?>