<?php
	echo $this->element('person/index');
/**	$level = 0;
	for($i = 0; $i < sizeof($people); $i++) {
		$person = $people[$i]['Person'];
		$parent = $person['parent_id'];
		while ($parent == 0 && $level > 0) {
			echo '</ul>';
			$level--;
		}
		if ($level == 0 || $parent == $people[$i - 1]['Person']['id']) {
			echo '<ul>';
			$level++;
		} else if ($parent != $people[$i - 1]['Person']['parent_id']) {
			$j = 2;
			while ( $i - $j >= 0 ) {
				if ($parent == $people[$i - $j]['Person']['id']) {
					$parent = $people[$i - $j]['Person']['parent_id'];
					$level--;
					echo '</ul>';
				}
				$j++;
			}
		}
		echo '<li>'.$this->element('tree', array('data' => $person)).'</li>';
	}
	echo '</ul>';
**/
?>
