<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Table\UsersTable;
use App\Model\Table\UserSessionsTable;

class UsersController extends AppController {

	private UsersTable $usersTable;
	private UserSessionsTable $userSessionsTable;
	
	public function initialize(): void {
		parent::initialize();
		$this->usersTable = $this->Users;
		$this->userSessionsTable = $this->getTableLocator()->get('UserSessions');
	}
	
	public function index() {
		$this->RequestHandler->renderAs($this, 'json');
		$users = $this->usersTable->find();
		$usersInfo = [];
		foreach ($users as $user) {
			$userSession = $this->userSessionsTable
				->find()
				->where(['user_id' => $user->id])
				->first();
			$usersInfo[] = [
				'id' => $user->id,
				'username' => $user->username,
				'loggedIn' => $this->isLoggedIn($userSession),
				'recording' => $this->isRecording($userSession)
			];
		}
		$this->set('users', $usersInfo);
	}
	
	public function add() {
		$this->request->allowMethod(['get', 'post']);
		if ($this->request->is('post')) {
			$user = $this->usersTable->newEntity($this->request->getData());
			if ($this->usersTable->save($user)) {
				$this->Flash->success("User '$user->username' has been created successfully!");
			} else {
				$this->Flash->success('There was an error creating the new user.');
			}
		}
		$this->set('user');
	}
	
	public function check($username) {
		$this->request->allowMethod(['get']);
		$loggedIn = false;
		$recording = false;
		$user = $this->usersTable
			->find()
			->where(['username' => $username])
			->first();
		if ($user != null) {
			$userSession = $this->userSessionsTable
				->find()
				->where(['user_id' => $user->id])
				->first();
			$loggedIn = $this->isLoggedIn($userSession);
			$recording = $this->isRecording($userSession);
		}
		$this->RequestHandler->renderAs($this, 'json');
		$this->set([
			'username' => $username,
			'loggedIn' => $loggedIn,
			'recording' => $recording
		]);
	}
	
	public function upload() {
		$this->viewBuilder()->disableAutoLayout();
		$message = 'Nothing happened...';
		if ($this->request->is('post')) {
			$video = $this->request->getUploadedFile('video');
			if ($video != null) {
				$time = time();
				$video->moveTo("../videos/video-$time.webm");
				$message = "Upload success!";
			} else {
				$message = "Upload failed...";
			}
		}
		$this->set('message', $message);
	}
	
	private function isLoggedIn($userSession) {
		return $userSession != null;
	}

	public function isRecording($userSession) {
		return $userSession != null
			? $userSession->recording == 1
			: false;
	}

}
