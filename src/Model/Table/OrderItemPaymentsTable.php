<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderItemPayments Model
 *
 * @property \App\Model\Table\FoodItemOrdersTable|\Cake\ORM\Association\BelongsTo $FoodItemOrders
 * @property \App\Model\Table\BeverageItemOrdersTable|\Cake\ORM\Association\BelongsTo $BeverageItemOrders
 *
 * @method \App\Model\Entity\OrderItemPayment get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderItemPayment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrderItemPayment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderItemPayment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderItemPayment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderItemPayment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderItemPayment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderItemPayment findOrCreate($search, callable $callback = null, $options = [])
 */
class OrderItemPaymentsTable extends Table
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

        $this->setTable('order_item_payments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        /*$this->belongsTo('FoodItemOrders', [
            'foreignKey' => 'food_item_order_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('BeverageItemOrders', [
            'foreignKey' => 'beverage_item_order_id',
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
        //$rules->add($rules->existsIn(['food_item_order_id'], 'FoodItemOrders'));
        //$rules->add($rules->existsIn(['beverage_item_order_id'], 'BeverageItemOrders'));

        return $rules;
    }
}
