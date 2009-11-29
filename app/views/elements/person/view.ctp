<div class="people view">
<h2><?php echo $person['Person']['name'];?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Foto'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php
                if (empty($person['Person']['picture'])) {
                    $person['Person']['picture'] = 'no_picture.jpg';
                    echo $html->image('people/small/'.$person['Person']['picture']);
                } else {
                    echo $html->link($html->image('people/small/'.$person['Person']['picture']), array('action' => 'picture', 'id' => $person['Person']['id'], 'admin' => 0), array('escape' => false, 'class' => 'modalbox_link'));
                }
            ?>
			&nbsp;
		</dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Beschrijving'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php echo nl2br($person['Person']['description']); ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php echo $person['Person']['status']; ?>
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
					echo "Nog lid";
				}
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Bojo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
                //if child is died or reunist set other link color
                $status_class = '';
                if ($person['Parent']['status'] == 'Overleden') {
                    $status_class = 'died';
                } else if ($person['Parent']['status'] == 'Reunist') {
                    $status_class = 'reunion';
                }
				echo $html->link($person['Parent']['name'], array('controller' => 'people', 'action' => 'view', 'id' => $person['Parent']['id']), array('class' => 'modalbox_link '. $status_class)); 
			?>
			&nbsp;
		</dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Jojo\'s'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php 
                foreach($person['Children'] as $child) {
                    //if child is died or reunist set other link color
                    $status_class = '';
                    if ($child['Person']['status'] == 'Overleden') {
                        $status_class = 'died';
                    } else if ($child['Person']['status'] == 'Reunist') {
                        $status_class = 'reunion';
                    }
                    
                    echo $html->link($child['Person']['name'], array('controller' => 'people', 'action' => 'view', 'id' => $child['Person']['id']), array('class' => 'modalbox_link '. $status_class)).'<br />'; 
                }
                ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Broers en zussen'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php 
                foreach($person['Brothers'] as $bro) {
                    if ($bro['Person']['id'] != $person['Person']['id']) {
                        //if brother is died or reunist set other link color
                        $status_class = '';
                        if ($bro['Person']['status'] == 'Overleden') {
                            $status_class = 'died';
                        } else if ($bro['Person']['status'] == 'Reunist') {
                            $status_class = 'reunion';
                        }
                        
                        echo $html->link($bro['Person']['name'], array('controller' => 'people', 'action' => 'view', 'id' => $bro['Person']['id']), array('class' => 'modalbox_link '. $status_class)).'<br />'; 
                    }
                }
                ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Opa / oma'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php 
                if ($person['Grandparent'] != '') {
                    //if grandparent is died or reunist set other link color
                    $status_class = '';
                    if ($person['Grandparent']['status'] == 'Overleden') {
                        $status_class = 'died';
                    } else if ($person['Grandparent']['status'] == 'Reunist') {
                        $status_class = 'reunion';
                    }
                    echo $html->link($person['Grandparent']['name'], array('controller' => 'people', 'action' => 'view', 'id' => $person['Grandparent']['id']), array('class' => 'modalbox_link '. $status_class));
                } 
            ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ooms en tantes'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php 
                foreach($person['Uncles'] as $uncle) {
                    if ($uncle['Person']['id'] != $person['Parent']['id']) {
                        //if uncle is died or reunist set other link color
                        $status_class = '';
                        if ($uncle['Person']['status'] == 'Overleden') {
                            $status_class = 'died';
                        } else if ($uncle['Person']['status'] == 'Reunist') {
                            $status_class = 'reunion';
                        }
                        
                        echo $html->link($uncle['Person']['name'], array('controller' => 'people', 'action' => 'view', 'id' => $uncle['Person']['id']), array('class' => 'modalbox_link '. $status_class)).'<br />';
                    } 
                }
                ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Neven en nichten'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php 
                foreach($person['Cousins'] as $cousin) {
                    //if cousin is died or reunist set other link color
                    $status_class = '';
                    if ($cousin['Person']['status'] == 'Overleden') {
                        $status_class = 'died';
                    } else if ($cousin['Person']['status'] == 'Reunist') {
                        $status_class = 'reunion';
                    }
                    
                    echo $html->link($cousin['Person']['name'], array('controller' => 'people', 'action' => 'view', 'id' => $cousin['Person']['id']), array('class' => 'modalbox_link '. $status_class)).'<br />';
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
		<li><?php echo $html->link(__('Wijzig Libertijn', true), array('action'=>'edit', $person['Person']['id'], 'admin' => 1), array('class' => 'modalbox_link')); ?> </li>
		<li><?php echo $html->link(__('Nieuwe Libertijn', true), array('action'=>'add', 'admin' => 1), array('class' => 'modalbox_link')); ?> </li>
	</ul>
</div>
<?php
	}
?>
