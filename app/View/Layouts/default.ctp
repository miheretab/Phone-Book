<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'Phone Book');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->script('jquery');
		echo $this->Html->script('swfobject');
		echo $this->Html->script('scriptcam.min');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	
<script language="JavaScript"> 
	$(document).ready(function() {
		$("#webcam").scriptcam({
			showMicrophoneErrors:false,
			onError:onError,
			cornerRadius:20,
			disableHardwareAcceleration:1,
			cornerColor:'e3e5e2',
			onWebcamReady:onWebcamReady,
			uploadImage:'upload.gif',
			onPictureAsBase64:base64_tofield_and_image
		});
	});
	function base64_tofield_and_image(b64) {
		var image;
		if(b64) {
			image = b64;
		} else {
			image = $.scriptcam.getFrameAsBase64()
		}
		$('#UserImage').val(image);
		$('#image').attr("src","data:image/png;base64,"+image);
	};
	function changeCamera() {
		$.scriptcam.changeCamera($('#cameraNames').val());
	}
	function onError(errorId,errorMsg) {
		$( "#capture" ).attr( "disabled", true );
		alert(errorMsg);
	}			
	function onWebcamReady(cameraNames,camera,microphoneNames,microphone,volume) {
		$.each(cameraNames, function(index, text) {
			$('#cameraNames').append( $('<option></option>').val(index).html(text) )
		}); 
		$('#cameraNames').val(camera);
	}
</script>	
</head>
<body>
	<div id="container">
		<div id="header">
			<div class="menu">
				<ul>
				<?php if($this->Session->check('Auth.User')) { ?>
					<li><?php echo $this->Html->link(isset($user['User']['image']) ? '<img style="width:50px;height:23px;" src="data:image/png;base64,' . $user['User']['image'] . '"/>' : $user['User']['username'], '/profile', array('escape' => false)); ?></li>
					<li><?php echo $this->Html->link('Contacts', '/'); ?></li>
					<li><?php echo $this->Html->link('Logout', '/logout'); ?></li>
				<?php } else { ?>
					<li><?php echo $this->Html->link('Register', '/register'); ?></li>
					<li><?php echo $this->Html->link('Login', '/login'); ?></li>
				<?php } ?>
				</ul>
			</div>	
			<h1><?php echo $this->Html->link($cakeDescription, '/'); ?></h1>			
		</div>
		<div id="content">
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<!--<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'/',
					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				);
			?>
			<p>
				<?php //echo $cakeVersion; ?>
			</p>
		</div>-->
	</div>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
