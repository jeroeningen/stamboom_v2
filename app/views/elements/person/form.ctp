<div class="people form">
<?php
	echo $javascript->includeScript('focus');
	if (!empty($this->params['named'])) {
		echo $form->create('Person', array('url' => array('controller' => $this->name, 'action' => $this->action, key($this->params['named']) => current($this->params['named'])),'onsubmit' => 'return false;'));
	} else if(!empty($this->params['pass'])) { 
		echo $form->create('Person', array('url' => array('controller' => $this->name, 'action' => $this->action, 'id' => current($this->params['pass'])),'onsubmit' => 'return false;'));
	} else { 
		echo $form->create('Person', array('onsubmit' => 'return false;'));
	}
	
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
	if (!empty($authUser)) {
		echo $form->input('name', array('label' => 'Naam')).'<br />';
	}
	echo $form->input('description', array('label' => 'Beschrijving')).'<br />';
	if (!empty($authUser)) {
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
<?php echo $form->end(array('onclick' => 'Modalbox.show(this.form.action, {title: this.title, width: 600, params: Form.serialize(this.form), method: \'post\'}); return false;'));?>
</div>
