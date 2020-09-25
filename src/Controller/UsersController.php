<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use App\Model\Table\UserSessionsTable;

class UsersController extends AppController {

	private UsersTable $usersTable;
	private UserSessionsTable $userSessionsTable;
	private $unathenticatedActions = ['add', 'check', 'index', 'upload'];
	
	public function initialize(): void {
		parent::initialize();
		$this->usersTable = $this->Users;
		$this->userSessionsTable = $this->getTableLocator()->get('UserSessions');
	}
	
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);
		$action = $this->request->getParam('action');
		$session = $this->request->getSession();
		if (!in_array($action, $this->unathenticatedActions) && !$session->check('user.id')) {
			$this->redirect(['controller' => 'Login', 'action' => 'login']);
		}
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
				'loggedIn' => $userSession != null
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
		$user = $this->usersTable
			->find()
			->where(['username' => $username])
			->first();
		if ($user != null) {
			$userSessions = $this->userSessionsTable
				->find()
				->where(['user_id' => $user->id])
				->first();
			$loggedIn = $userSessions != null;
		} else {
			$loggedIn = false;
		}
		$this->RequestHandler->renderAs($this, 'json');
		$this->set([
			"username" => $username,
			"loggedIn" => $loggedIn
		]);
	}
	
	public function upload() {
		$this->viewBuilder()->disableAutoLayout();
		$message = 'Nothing happened...';
		if ($this->request->is('post')) {
			$video = $this->request->getUploadedFile('video');
			if ($video != null) {
				try {
					$time = time();
					$video->moveTo("../videos/video-$time.webm");
					$message = "Upload success!";
				} catch (Exception $ex) {
					$message = $ex->getMessage();
				}
			} else {
				$message = "Upload failed...";
			}
		}
		$this->set('message', $message);
	}

}
