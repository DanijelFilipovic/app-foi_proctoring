<div class="users form">
	<?= $this->Flash->render() ?>
	<?= $this->Form->create($user) ?>
	<fieldset>
		<legend><u>Create new user</u></legend>
		<?= $this->Form->control('username', ['required' => true]) ?>
		<?= $this->Form->control('password', ['required' => true]) ?>
	</fieldset>
	<?= $this->Form->submit('Create') ?>
	<?= $this->Form->end() ?>
</div>

