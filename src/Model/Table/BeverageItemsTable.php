<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BeverageItems Model
 *
 * @property \App\Model\Table\BeverageCategoriesTable|\Cake\ORM\Association\BelongsTo $BeverageCategories
 * @property \App\Model\Table\BeverageItemDetailsTable|\Cake\ORM\Association\HasMany $BeverageItemDetails
 *
 * @method \App\Model\Entity\BeverageItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\BeverageItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BeverageItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BeverageItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BeverageItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BeverageItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BeverageItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BeverageItem findOrCreate($search, callable $callback = null, $options = [])
 */
class BeverageItemsTable extends Table
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

        $this->setTable('beverage_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('BeverageCategories', [
            'foreignKey' => 'beverage_category_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('BeverageItemDetails', [
            'foreignKey' => 'beverage_item_id'
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
        $rules->add($rules->existsIn(['beverage_category_id'], 'BeverageCategories'));

        return $rules;
    }
}
