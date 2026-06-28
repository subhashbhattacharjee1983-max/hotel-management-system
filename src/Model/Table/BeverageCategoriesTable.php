<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BeverageCategories Model
 *
 * @property \App\Model\Table\BeverageItemDetailsTable|\Cake\ORM\Association\HasMany $BeverageItemDetails
 * @property \App\Model\Table\BeverageItemsTable|\Cake\ORM\Association\HasMany $BeverageItems
 *
 * @method \App\Model\Entity\BeverageCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\BeverageCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BeverageCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BeverageCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BeverageCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BeverageCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BeverageCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BeverageCategory findOrCreate($search, callable $callback = null, $options = [])
 */
class BeverageCategoriesTable extends Table
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

        $this->setTable('beverage_categories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('BeverageItemDetails', [
            'foreignKey' => 'beverage_category_id'
        ]);
        $this->hasMany('BeverageItems', [
            'foreignKey' => 'beverage_category_id'
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
