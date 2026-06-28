<?php
namespace App\Model\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * Admin Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string $email
 * @property string $password
 * @property int $user_type
 * @property string $status
 * @property string|null $limit_access
 * @property \Cake\I18n\FrozenDate|null $created
 * @property \Cake\I18n\FrozenDate|null $modified
 *
 * @property \App\Model\Entity\BeverageItemOrder[] $beverage_item_orders
 * @property \App\Model\Entity\FoodItemOrder[] $food_item_orders
 */
class Admin extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'email' => true,
        'password' => true,
        'user_type' => true,
        'status' => true,
		'limit_access' => true,
        'created' => true,
        'modified' => true,
        'beverage_item_orders' => true,
        'food_item_orders' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
	protected function _setPassword($password){
        return (new DefaultPasswordHasher)->hash($password);
    }
}
