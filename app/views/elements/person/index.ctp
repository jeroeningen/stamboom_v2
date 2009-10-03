<div class="people index">
<h2><?php __('Liber stamboom');?></h2>
<?php
    //link for folding / collapsing the whole tree
    echo $html->link('Alles inklappen', '', array('id' => 'toggle_tree'));
    
    if(empty($people)) {
		echo 'Sorry, nog geen leden aan de stamboom toegevoegd.';
	} else {
		echo $tree->generate($people, array('element' => 'person/tree', 'class' => 'tree'));
	}
	if (!empty($authUser) && $authUser['User']['username'] == 'admin') {
?>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Nieuwe Libertijn', true), array('action'=>'add', 'admin' => 1), array('onclick' => $modalbox)); ?></li>
	</ul>
</div>
<?php
	}
?>
