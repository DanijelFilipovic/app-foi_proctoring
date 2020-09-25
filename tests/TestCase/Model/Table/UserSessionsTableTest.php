<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserSessionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserSessionsTable Test Case
 */
class UserSessionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserSessionsTable
     */
    protected $UserSessions;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UserSessions',
        'app.Users',
        'app.Sessions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UserSessions') ? [] : ['className' => UserSessionsTable::class];
        $this->UserSessions = $this->getTableLocator()->get('UserSessions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UserSessions);

        parent::tearDown();
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
