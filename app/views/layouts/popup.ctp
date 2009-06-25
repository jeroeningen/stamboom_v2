<div id="container-popup">
	<div id="frame-popup">
		<div id="header-popup">
		<a href="" title="Close window" onclick="Modalbox.hide({afterHide: function() { location.href = document.location; } });">x</a>
		</div>
		<div id="flash">
				<h2><?php $session->flash(); ?></h2>
		</div>
		<div id="mainContent-popup">
			<?php echo $content_for_layout?>
		</div>		
	</div>
</div>
