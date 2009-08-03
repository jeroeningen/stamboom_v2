<div class="form">
<?php echo $form->create($this->model, array('url' => array('controller' => strtolower($this->name), 'action' => 'login'), 'id' => 'person_form')); ?>
	<fieldset>
 		<legend><?php __($this->model.' Login');?></legend>
		<?php
			echo $this->element('login');
		?>
	</fieldset>
<?php echo $form->end(array('value' => 'Login', 'id' => 'person_submit'));?>
</div>
