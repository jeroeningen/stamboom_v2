<div class="people form">
<?php
	echo $form->create('Person', array('url' => array('action' => $this->action), 'id' => 'person_form'));

	//create options for selectboxes
	$years = array();
	for($i = 1990; $i < 2015; $i++) {
		$years[$i] = $i;
	}
	$intro = array('intro' => 'intro', 'na-intro' => 'na-intro');
?>
	<fieldset>
 		<legend><?php echo $legend;?></legend>
<?php
	$parent = "";
	if (!empty($this->params['named']['parent_id'])) {
		$parent = $this->params['named']['parent_id'];
	} elseif(strstr($this->params['action'], 'edit')) {
		$parent = $this->data['Person']['parent_id'];
	}
	if (!empty($authUser) && $authUser['User']['username'] == 'admin') {
		echo $form->input('name', array('label' => 'Naam')).'<br />';
	}
	echo $form->input('description', array('label' => 'Beschrijving')).'<br />';
	if (!empty($authUser) && $authUser['User']['username'] == 'admin') {
		if (!empty($this->params['named']['parent_id'])) {
			echo $form->hidden('parent_id', array('value' => $parent));
		} else {
			echo $form->label('Bojo');
			echo $form->select('parent_id', $people, array('selected' => $parent)).'<br />';
		}
		echo $form->label('Geboren');
		echo $form->select('born_intro', $intro);
		echo $form->select('born_year', $years).'<br />';
		echo $form->label('Overleden');
		echo $form->select('died_intro', $intro);
		echo $form->select('died_year', $years).'<br />';
		echo $form->input('status', array('options' => array('' => '', 'Lid' => 'Lid', 'Reunist' => 'Reunist', 'Overleden' => 'Overleden')));
	}
?>
	</fieldset>
<?php echo $form->end(array('value' => 'Verzend', 'id' => 'person_submit'));?>
</div>
