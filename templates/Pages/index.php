<?php
$this->assign('title', $title);
$this->Html->script('fpp', ['block' => true]);
?>

<div class="recording-buttons">
	<button id="record-button">&#x23FA;</button>
	<button id="stop-button" disabled>&#x23F9;</button>
</div>
<div class="recording-video">
	<video id="video" width="800" height="600" autoplay></video>
</div>