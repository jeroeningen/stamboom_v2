<div class="form">
<?php echo $form->create($this->model, array('url' => array('controller' => strtolower($this->name), 'action' => 'login'), 'onsubmit' => 'return false;')); ?>
	<fieldset>
 		<legend><?php __($this->model.' Login');?></legend>
		<?php
			echo $this->element('login');
		?>
	</fieldset>
<?php echo $form->end(array('Login', key($modalbox_login) => current($modalbox_login)));?>
</div>
<?php
	echo $javascript->includeScript('focus');
?>