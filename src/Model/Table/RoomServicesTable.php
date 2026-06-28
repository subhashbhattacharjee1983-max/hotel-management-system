<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RoomServices Model
 *
 * @property \App\Model\Table\ServiceCategoriesTable|\Cake\ORM\Association\BelongsTo $ServiceCategories
 * @property \App\Model\Table\HousekeepingOrdersTable|\Cake\ORM\Association\HasMany $HousekeepingOrders
 *
 * @method \App\Model\Entity\RoomService get($primaryKey, $options = [])
 * @method \App\Model\Entity\RoomService newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RoomService[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RoomService|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RoomService saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RoomService patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RoomService[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RoomService findOrCreate($search, callable $callback = null, $options = [])
 */
class RoomServicesTable extends Table
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

        $this->setTable('room_services');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ServiceCategories', [
            'foreignKey' => 'service_category_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('HousekeepingOrders', [
            'foreignKey' => 'room_service_id'
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
        $rules->add($rules->existsIn(['service_category_id'], 'ServiceCategories'));

        return $rules;
    }
}
