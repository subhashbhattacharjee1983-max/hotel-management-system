<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Setting Entity
 *
 * @property int $id
 * @property string|null $website_name
 * @property string|null $website_logo
 * @property string|null $company_name
 * @property string|null $billing_email_address
 * @property string|null $street_address
 * @property string|null $phone_number
 * @property string|null $site_url
 * @property string|null $whatsapp_number
 * @property string|null $contact_email
 * @property int $service_tax
 * @property int $bst_tax
 * @property int $gst_tax
 * @property int $bank_transfer_charge
 * @property int $food_service_tax
 * @property int $food_bst_tax
 * @property int $food_gst_tax
 * @property int $bar_service_tax
 * @property int $bar_bst_tax
 * @property int $bar_gst_tax
 * @property string|null $currency
 */
class Setting extends Entity
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
        'website_name' => true,
        'website_logo' => true,
		'company_name' => true,
        'billing_email_address' => true,
        'street_address' => true,
        'phone_number' => true,
        'whatsapp_number' => true,
		'site_url' => true,
        'service_tax' => true,
        'bst_tax' => true,
        'gst_tax' => true,
		'bank_transfer_charge' => true,
		'food_service_tax' => true,
        'food_bst_tax' => true,
        'food_gst_tax' => true,
		'bar_service_tax' => true,
        'bar_bst_tax' => true,
        'bar_gst_tax' => true,
        'currency' => true
    ];
}
