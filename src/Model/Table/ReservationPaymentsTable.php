<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReservationPayments Model
 *
 * @property \App\Model\Table\ReservationsTable|\Cake\ORM\Association\BelongsTo $Reservations
 *
 * @method \App\Model\Entity\ReservationPayment get($primaryKey, $options = [])
 * @method \App\Model\Entity\ReservationPayment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ReservationPayment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReservationPayment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReservationPayment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReservationPayment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ReservationPayment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReservationPayment findOrCreate($search, callable $callback = null, $options = [])
 */
class ReservationPaymentsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('reservation_payments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Reservations', [
            'foreignKey' => 'reservation_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['reservation_id'], 'Reservations'));

        return $rules;
    }
}
