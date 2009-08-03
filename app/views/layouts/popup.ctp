<div id="container-popup">
<?php
    if(isset($javascript)) {
        echo $javascript->includeScript($this->name);
    }
?>
	<div id="frame-popup">
		<div id="header-popup">
		<a href="" title="Close window" class="modalbox_close">x</a>
		</div>
		<div id="flash">
				<h2><?php $session->flash(); ?></h2>
		</div>
		<div id="mainContent-popup">
			<?php echo $content_for_layout?>
		</div>		
	</div>
</div>
