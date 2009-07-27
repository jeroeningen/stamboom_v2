<?php
	if (empty($person['Person']['picture'])) {
		$person['Person']['picture'] = 'no_picture.jpg';
		$picture = $html->image('people/small/'.$person['Person']['picture']);
	} else {
		$picture = $html->link($html->image('people/small/'.$person['Person']['picture']), array('action' => 'picture', 'id' => $person['Person']['id'], 'admin' => 0), array('escape' => false, key($modalbox) => current($modalbox)));
	}
?>

<div class="people view">
<h2><?php echo $person['Person']['name'];?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Foto'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $picture; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Beschrijving'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $person['Person']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Geboren'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $person['Person']['born_intro'].' '.$person['Person']['born_year']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Overleden'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
				if ($person['Person']['died_year'] != 0000) {
					echo $person['Person']['died_year'];
				}  else {
					echo "Nog lid / Reunist";
				}
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Bojo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
				echo $html->link($person['Parent']['name'], array('controller' => 'people', 'action' => 'view', 'id' => $person['Parent']['id']), $modalbox ); 
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Jojo\'s'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
				foreach($person['Children'] as $child) {
					echo $html->link($child['Person']['name'], array('controller' => 'people', 'action' => 'view', 'id' => $child['Person']['id']), $modalbox ).'<br />'; 
				}
				?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php
	if(!empty($authUser) && $authUser['User']['username'] == 'admin') {
?>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Wijzig Libertijn', true), array('action'=>'edit', $person['Person']['id'], 'admin' => 1), $modalbox); ?> </li>
		<li><?php echo $html->link(__('Nieuwe Libertijn', true), array('action'=>'add', 'admin' => 1), $modalbox); ?> </li>
	</ul>
</div>
<?php
	}
?>
