<div class="people form" style="margin-top: 25px;">
<?php
	echo $form->create('Person', array('url' => array('action' => 'upload', 'id' => $this->data['Person']['id'], 'admin' => $admin), 'type' => 'file', 'id' => 'person_form'));
	echo '<h2>Alleen foto\'s in JPG-formaat kunnen worden verwerkt.</h2>';
	echo $form->label('Foto');
	echo $form->file('Image.picture');
    echo $form->end(array('value' => 'Upload'));
?>
</div>