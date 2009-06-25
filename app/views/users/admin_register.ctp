<h2><?php __('Signup'); ?></h2>
<div class="users form">
<?php echo $form->create('User', array('action' => 'register'));?>
	<fieldset>
 		<legend><?php __('Register');?></legend>
	<?php
		echo $form->input('User.username', array(
			'label' => __('Username', true),
			'error' => array(
				'unique' => __('The username has already been taken', true),
				'alphanumeric' => __('Only alphabets and numbers allowed', true),
				'minlength' => __('Minimum length of 3 characters', true)
			)
		));
		echo $form->input('User.password', array(
			'label' => __('Password', true),
			'error' => array(
				'minlength' => __('Minimum length of 8 characters', true)
			)
		));
		echo $form->input('User.password_confirm', array(
			'type' => 'password',
			'label' => __('Confirm password', true),
			'error' => array(
				'minlength' => __('Minimum length of 8 characters', true)
			)
		));
	?>
	</fieldset>
<?php echo $form->end('Register');?>
</div>
