<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BeverageItemDetails Model
 *
 * @property \App\Model\Table\BeverageItemOrdersTable|\Cake\ORM\Association\BelongsTo $BeverageItemOrders
 * @property \App\Model\Table\BeverageCategoriesTable|\Cake\ORM\Association\BelongsTo $BeverageCategories
 * @property \App\Model\Table\BeverageItemsTable|\Cake\ORM\Association\BelongsTo $BeverageItems
 *
 * @method \App\Model\Entity\BeverageItemDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\BeverageItemDetail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BeverageItemDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BeverageItemDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BeverageItemDetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BeverageItemDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BeverageItemDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BeverageItemDetail findOrCreate($search, callable $callback = null, $options = [])
 */
class BeverageItemDetailsTable extends Table
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

        $this->setTable('beverage_item_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('BeverageItemOrders', [
            'foreignKey' => 'beverage_item_order_id',
            'joinType' => 'INNER'
        ]);
        /*$this->belongsTo('BeverageCategories', [
            'foreignKey' => 'beverage_category_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('BeverageItems', [
            'foreignKey' => 'beverage_item_id',
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
        $rules->add($rules->existsIn(['beverage_item_order_id'], 'BeverageItemOrders'));
        //$rules->add($rules->existsIn(['beverage_category_id'], 'BeverageCategories'));
        //$rules->add($rules->existsIn(['beverage_item_id'], 'BeverageItems'));

        return $rules;
    }
}
