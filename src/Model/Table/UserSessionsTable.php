<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserSessions Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\SessionsTable&\Cake\ORM\Association\BelongsTo $Sessions
 *
 * @method \App\Model\Entity\UserSession newEmptyEntity()
 * @method \App\Model\Entity\UserSession newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\UserSession[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserSession get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserSession findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\UserSession patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserSession[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserSession|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserSession saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserSession[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\UserSession[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\UserSession[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\UserSession[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class UserSessionsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('user_sessions');
        $this->setDisplayField('user_id');
        $this->setPrimaryKey(['user_id', 'session_id']);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Sessions', [
            'foreignKey' => 'session_id',
            'joinType' => 'INNER',
        ]);
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['session_id'], 'Sessions'), ['errorField' => 'session_id']);

        return $rules;
    }
}
