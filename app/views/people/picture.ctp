<?php
	if (!empty($this->params['named']['small'])) {
		if (empty($person['Person']['picture'])) {
			$person['Person']['picture'] = 'no_picture.jpg';
		}
		echo $html->link($html->image('people/small/'.$person['Person']['picture']), array('action' => 'view', 'id' => $person['Person']['id']), array('escape' => false, key($modalbox) => current($modalbox)));
	} else {
		echo $html->link($html->image('people/big/'.$person['Person']['picture']), array('action' => 'view', 'id' => $person['Person']['id']), array('escape' => false, key($modalbox) => current($modalbox)));
	}
?>