<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Register'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('c_password', array('label' => 'Confirm Password', 'type' => 'password'));
		echo $this->Form->input('image', array('type' => 'hidden'));
	?>
	<div style="width:330px;float:left;">
		<div id="webcam">
		</div>
		<div style="margin:5px;">
			<?php echo $this->Html->image('webcamlogo.png', array('style' => 'vertical-align:text-top')); ?>
			<select id="cameraNames" size="1" onChange="changeCamera()" style="width:245px;font-size:10px;height:25px;">
			</select>
		</div>
	</div>
	<div style="width:135px;float:left;">
		<p><button class="btn btn-small" type='button' id="capture" onclick="base64_tofield_and_image()">Capture</button></p>
	</div>
	<div style="width:200px;float:left;">
		<p><img id="image" style="width:200px;height:153px;"/></p>
	</div>	
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>