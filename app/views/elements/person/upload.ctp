<div class="people form" style="margin-top: 25px;">
<?php
	echo $form->create('Person', array('url' => array('action' => 'upload', 'id' => $this->data['Person']['id'], 'admin' => $admin), 'type' => 'file'));
	echo $form->label('Foto');
	echo $form->hidden('picture');
	echo $form->file('Image.picture', array('onchange' => 'this.form.submit()'));
	echo $form->end('Upload');
?>
</div>