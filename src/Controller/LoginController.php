<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use App\Model\Table\UserSessionsTable;
use App\Model\Entity\User;

class LoginController extends AppController {
	
	private UsersTable $usersTable;
	private UserSessionsTable $userSessionsTable;
	
	public function initialize(): void {
		parent::initialize();
		$this->usersTable = $this->getTableLocator()->get('Users');
		$this->userSessionsTable = $this->getTableLocator()->get('UserSessions');
	}
	
	public function login() {
		$this->request->allowMethod(['get', 'post']);
		if ($this->request->is('post')) {
			$userData = $this->usersTable->newEmptyEntity();
			$userData->username = $this->request->getData('username');
			$userData->password = $this->request->getData('password');
			$query = $this->usersTable->find()->where(['username' => $userData->username, 'password' => $userData->password]);
			$user = $query->first();
			if ($user == null) {
				$this->Flash->error('Invalid username or password.');
			} else {
				$this->createSession($user);
				$this->Flash->success("Successfully loged in as '$user->username'.");
				$this->redirect(['controller' => 'Pages', 'action' => 'index']);
			}
		}
		$this->set('loginData');
	}
	
	public function logout() {
		$this->clearSessionAndRedirect();
	}

	private function createSession(User $user) {
		$session = $this->request->getSession();
		$session->write([
			'user.id' => $user->id,
			'user.username' => $user->username
		]);
		
		$userSession = $this->userSessionsTable->newEmptyEntity();
		$userSession->user_id = $user->id;
		$userSession->session_id = $session->id();
		$this->userSessionsTable->save($userSession);
	}

	private function clearSessionAndRedirect() {
		$session = $this->request->getSession();
		if ($session->check('user.id')) {
			$this->userSessionsTable->deleteAll(['user_id' => $session->read('user.id')]);
		}
		$session->destroy();
		$this->redirect(['action' => 'login']);
	}
	
}

