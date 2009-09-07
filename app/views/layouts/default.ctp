<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="content-language" content="dutch" />
<meta http-equiv="copyright" content="Copyright &copy; SV Liber" />
<meta http-equiv="robots" content="index,follow" />
<title>Liber stamboom - <?php echo $title_for_layout?></title>
	<?php 
	echo $html->css('liber');
	if(isset($javascript)) {
		
		/**
		 * we use a compressed version of it
		echo $javascript->link('prototype.js');
		echo $javascript->link('scriptaculous.js');
		**/
		
		//compressed version of prototype and scriptaculous
		echo $javascript->link('protoaculous.1.8.2.min.js');
		
		echo $javascript->link('prototip.js');
		echo $javascript->link('modalbox.js');
        echo $javascript->link($this->name);
        echo $html->css('modalbox');
		echo $html->css('prototip');
	}
	?>
</head>

<body>
<div id="container">
	<div id="frame">
		<div id="header">
			<div id="logo">
				<?php echo $html->image('logo.gif'); ?>
			</div>
			<div id="flash">
				<h2><?php $session->flash(); ?></h2>
			</div>
			<div id="menu">
				<?php echo $this->renderElement('menu'); ?>
			</div>
			</div>
		</div>
		<div id="mainContent">
			<?php echo $content_for_layout?>
		</div>
	</div>
</div>
</body>
</html>
