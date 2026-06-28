<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FoodCategories Model
 *
 * @property \App\Model\Table\FoodItemDetailsTable|\Cake\ORM\Association\HasMany $FoodItemDetails
 * @property \App\Model\Table\FoodItemsTable|\Cake\ORM\Association\HasMany $FoodItems
 *
 * @method \App\Model\Entity\FoodCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\FoodCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FoodCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FoodCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FoodCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FoodCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FoodCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FoodCategory findOrCreate($search, callable $callback = null, $options = [])
 */
class FoodCategoriesTable extends Table
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

        $this->setTable('food_categories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('FoodItemDetails', [
            'foreignKey' => 'food_category_id'
        ]);
        $this->hasMany('FoodItems', [
            'foreignKey' => 'food_category_id'
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
