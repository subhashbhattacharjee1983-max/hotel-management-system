<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RoomCategories Model
 *
 * @property \App\Model\Table\ReservationsTable|\Cake\ORM\Association\HasMany $Reservations
 * @property \App\Model\Table\RoomsTable|\Cake\ORM\Association\HasMany $Rooms
 *
 * @method \App\Model\Entity\RoomCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\RoomCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RoomCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RoomCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RoomCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RoomCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RoomCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RoomCategory findOrCreate($search, callable $callback = null, $options = [])
 */
class RoomCategoriesTable extends Table
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

        $this->setTable('room_categories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Rooms', [
            'foreignKey' => 'room_category_id'
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
}
