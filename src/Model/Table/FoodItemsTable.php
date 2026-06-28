<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FoodItems Model
 *
 * @property \App\Model\Table\FoodCategoriesTable|\Cake\ORM\Association\BelongsTo $FoodCategories
 * @property \App\Model\Table\FoodItemDetailsTable|\Cake\ORM\Association\HasMany $FoodItemDetails
 *
 * @method \App\Model\Entity\FoodItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\FoodItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FoodItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FoodItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FoodItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FoodItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FoodItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FoodItem findOrCreate($search, callable $callback = null, $options = [])
 */
class FoodItemsTable extends Table
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

        $this->setTable('food_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('FoodCategories', [
            'foreignKey' => 'food_category_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('FoodItemDetails', [
            'foreignKey' => 'food_item_id'
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
        $rules->add($rules->existsIn(['food_category_id'], 'FoodCategories'));

        return $rules;
    }
}
