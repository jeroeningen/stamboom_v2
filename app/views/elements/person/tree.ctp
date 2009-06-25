<?php
	$tree->addItemAttribute('class', 'leaf');
	$photolink = "";
	$photolink = $html->link('Verwijder foto', array('controller' => 'people', 'action' => 'picture_delete', 'id' => $data['Person']['id'], 'admin' => 1));
	echo '<div class="person">';
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
	echo $html->link($data['Person']['name'], 
		array('controller' => 'people', 'action' => 'view', 'id' => $data['Person']['id']), 
		$modalbox).'</div>';
	echo '<div class="description">'.$data['Person']['description'].'</div>';
	echo '</div>';
	if (!empty($authUser)) {
		echo '<div class="small">'.$html->link('Bewerk', array('controller' => 'people', 'action' => 'edit', 'id' => $data['Person']['id'], 'admin' => 1), $modalbox).' '.
			$html->link('Voeg jojo toe', array('controller' => 'people', 'action' => 'add', 'parent_id' => $data['Person']['id'], 'admin' => 1), $modalbox).' '.
			$html->link('Verwijder Libertijn en jojo\'s', array('controller' => 'people', 'action' => 'delete', 'id' => $data['Person']['id'], 'admin' => 1)).' '.
			$html->link('Verwijder Libertijn', array('controller' => 'people', 'action' => 'delete', 'id' => $data['Person']['id'], 'remove_from_tree' => true, 'admin' => 1)).' '.
			$html->link('Upload foto', array('controller' => 'people', 'action' => 'upload', 'id' => $data['Person']['id'], 'admin' => 1)).' '.
			$photolink.'</div>';
	}
?>