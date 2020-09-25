<?php
namespace App\Http\Session;
use Cake\Http\Session\DatabaseSession;

class ExtendedDatabaseSession extends DatabaseSession {
	
	private $userSessionsTable;
	
	public function __construct(array $config = array()) {
		$this->userSessionsTable = $this->getTableLocator()->get('UserSession');
		parent::__construct($config);
	}
	
	public function write($id, $data): bool {
		
		return parent::write($id, $data);
	}
	
	public function destroy($id): bool {
		$this->userSessionsTable->deleteAll(['session_id' => $id]);
		return parent::destroy($id);
	}

	public function gc($maxlifetime): bool {
		return parent::gc($maxlifetime);
	}
	
}

