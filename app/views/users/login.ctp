<div class="form">
<h2><?php  __('Login voor Stamboombeheerder');?></h2>
<?php echo $form->create($this->model, array('url' => array('controller' => strtolower($this->name), 'action' =>'login')));?>
	<fieldset>
 		<legend><?php __($this->model.' Login');?></legend>
		<?php
			echo $this->element('login');
		?>
	</fieldset>
<?php echo $form->end('Login');?>
</div>
<?php
	echo $javascript->includeScript('focus');
?>