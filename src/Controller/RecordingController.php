<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Table\UserSessionsTable;

class RecordingController extends AppController {
	
	private UserSessionsTable $userSessionsTable;
	
	public function initialize(): void {
		parent::initialize();
		$this->userSessionsTable = $this->getTableLocator()->get('UserSessions');
	}
	
	public function beforeFilter(\Cake\Event\EventInterface $event) {
		parent::beforeFilter($event);
		$this->viewBuilder()->disableAutoLayout();
	}

	
	public function start() {
		$message = 'Could not update the UserSessions table with the start of recording.';
		$userSession = $this->getUserSession();
		if ($userSession != null) {
			$userSession->recording = 1;
			$this->userSessionsTable->save($userSession);
			$message = 'Recording marked as started in UserSessions table.';
		}
		$this->set('message', $message);
	}
	
	public function stop() {
		$message = 'Could not update the UserSessions table with the stop of recording.';
		$userSession = $this->getUserSession();
		if ($userSession != null) {
			$userSession->recording = 0;
			$this->userSessionsTable->save($userSession);
			$message = 'Recording marked as stopped in UserSessions table.';
		}
		$this->set('message', $message);
	}
	
	private function getUserSession() {
		$session = $this->request->getSession();
		return $this->userSessionsTable
			->find()
			->where(['session_id' => $session->id()])
			->first();
	}

}
