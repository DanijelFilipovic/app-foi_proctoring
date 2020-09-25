<?php
declare (strict_types=1);

namespace App\Controller;

use App\Controller\AppController;

class PagesController extends AppController {
	
	public function index() {
		$this->set('title', 'FOI Proctoring Project');
	}
	
}

