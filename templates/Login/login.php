<div class="users form">
	<?= $this->Flash->render() ?>
	<?= $this->Form->create($loginData) ?>
	<fieldset>
		<legend><u>Login</u></legend>
		<?= $this->Form->control('username', ['required' => true]) ?>
		<?= $this->Form->control('password', ['required' => true]) ?>
	</fieldset>
	<?= $this->Form->submit('Login') ?>
	<?= $this->Form->end() ?>
</div>