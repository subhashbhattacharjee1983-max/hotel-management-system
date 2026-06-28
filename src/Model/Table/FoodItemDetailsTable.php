<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FoodItemDetails Model
 *
 * @property \App\Model\Table\FoodItemOrdersTable|\Cake\ORM\Association\BelongsTo $FoodItemOrders
 * @property \App\Model\Table\FoodCategoriesTable|\Cake\ORM\Association\BelongsTo $FoodCategories
 * @property \App\Model\Table\FoodItemsTable|\Cake\ORM\Association\BelongsTo $FoodItems
 *
 * @method \App\Model\Entity\FoodItemDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\FoodItemDetail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FoodItemDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FoodItemDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FoodItemDetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FoodItemDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FoodItemDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FoodItemDetail findOrCreate($search, callable $callback = null, $options = [])
 */
class FoodItemDetailsTable extends Table
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

        $this->setTable('food_item_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('FoodItemOrders', [
            'foreignKey' => 'food_item_order_id',
            'joinType' => 'INNER'
        ]);
        /*$this->belongsTo('FoodCategories', [
            'foreignKey' => 'food_category_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('FoodItems', [
            'foreignKey' => 'food_item_id',
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
        $rules->add($rules->existsIn(['food_item_order_id'], 'FoodItemOrders'));
        //$rules->add($rules->existsIn(['food_category_id'], 'FoodCategories'));
        //$rules->add($rules->existsIn(['food_item_id'], 'FoodItems'));

        return $rules;
    }
}
