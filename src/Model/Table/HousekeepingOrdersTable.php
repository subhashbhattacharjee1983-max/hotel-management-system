<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HousekeepingOrders Model
 *
 * @property \App\Model\Table\BookingsTable|\Cake\ORM\Association\BelongsTo $Bookings
 * @property \App\Model\Table\RoomsTable|\Cake\ORM\Association\BelongsTo $Rooms
 * @property \App\Model\Table\RoomServicesTable|\Cake\ORM\Association\BelongsTo $RoomServices
 *
 * @method \App\Model\Entity\HousekeepingOrder get($primaryKey, $options = [])
 * @method \App\Model\Entity\HousekeepingOrder newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\HousekeepingOrder[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HousekeepingOrder|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HousekeepingOrder saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HousekeepingOrder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HousekeepingOrder[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\HousekeepingOrder findOrCreate($search, callable $callback = null, $options = [])
 */
class HousekeepingOrdersTable extends Table
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

        $this->setTable('housekeeping_orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Bookings', [
            'foreignKey' => 'booking_id',
            'joinType' => 'INNER'
        ]);
        /*$this->belongsTo('Rooms', [
            'foreignKey' => 'room_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('RoomServices', [
            'foreignKey' => 'room_service_id',
            'joinType' => 'INNER'
        ]);*/
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
        $rules->add($rules->existsIn(['booking_id'], 'Bookings'));
        /*$rules->add($rules->existsIn(['room_id'], 'Rooms'));
        $rules->add($rules->existsIn(['room_service_id'], 'RoomServices'));*/

        return $rules;
    }
}
