<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
/**
 * Bookings Controller
 *
 * @property \App\Model\Table\BookingsTable $Bookings
 *
 * @method \App\Model\Entity\Booking[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BookingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        /*$this->paginate = [
            'contain' => ['Customers']
        ];
        $bookings = $this->paginate($this->Bookings);*/

		$bookings = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => ['Bookings.booking_type' => "B", 'Bookings.booking_status' => "C"], 'order'=>'Bookings.id DESC'])->toArray();

        $this->set(compact('bookings'));
    }

	public function verify($booking_id = null, $verified = null)
	{
		$this->viewBuilder()->setLayout('ajax');
		$this->loadModel('Rooms');
		$booking_id = base64_decode($booking_id);
		if($verified == "all_verified"){
			$booking_verified = "All Verified";
		}else if($verified == "force_checkout"){
			$booking_verified = "Force Checkout";
		}
		$booking = $this->Bookings->find('all', ['conditions' => ['Bookings.id' => $booking_id, 'Bookings.booking_status' => "C"]])->first();
		$room_verify = $this->Rooms->find('all', ['conditions' => ['Rooms.booking_id' => $booking_id, 'Rooms.room_status' => "O"]])->first();
		if(empty($room_verify))
		{
			return $this->redirect(['controller' => 'Bookings', 'action' => 'dashboard']);
		}
		if(!empty($room_verify))
		{
			$this->Bookings->updateAll(['booking_status' => "O", 'booking_verified' => $booking_verified], ['id' => $booking_id]);
			$this->Rooms->updateAll(['room_status' => "A", 'booking_id' => "0"], ['booking_id' => $booking_id]);
			$this->Flash->success(__('Verify and check out process has been updated successfully'));
			return $this->redirect(['controller' => 'Bookings', 'action' => 'dashboard']);
		}
	}

	public function paymentbill($booking_id = null)
	{
		$this->viewBuilder()->setLayout('ajax');
		$booking = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => ['Bookings.id' => $booking_id]])->first();
		$this->set(compact('booking'));
	}

	public function report()
    {
		if(isset($this->request->getData()['start_date_master']) && isset($this->request->getData()['end_date_master'])){
			$parameter_arr=array();
			if($this->request->getData()["start_date_master"] != "" && $this->request->getData()["start_date_master"] != "Start Date Master"):
				$parameter_arr['start_date_master'] = $this->request->getData()["start_date_master"];
			endif;
			if($this->request->getData()["end_date_master"] != "" && $this->request->getData()["end_date_master"] != "End Date Master"):
				$parameter_arr['end_date_master'] = $this->request->getData()["end_date_master"];
			endif;
			return $this->redirect(['controller' => 'Bookings', 'action' => 'masterreport', "?" => $parameter_arr]);
		}
		if(isset($this->request->getData()['start_date_room']) && isset($this->request->getData()['end_date_room'])){
			$parameter_arr=array();
			if($this->request->getData()["start_date_room"] != "" && $this->request->getData()["start_date_room"] != "Start Date Room"):
				$parameter_arr['start_date_room'] = $this->request->getData()["start_date_room"];
			endif;
			if($this->request->getData()["end_date_room"] != "" && $this->request->getData()["end_date_room"] != "End Date Room"):
				$parameter_arr['end_date_room'] = $this->request->getData()["end_date_room"];
			endif;
			return $this->redirect(['controller' => 'Bookings', 'action' => 'roomreport', "?" => $parameter_arr]);
		}
		if(isset($this->request->getData()['start_date_food']) && isset($this->request->getData()['end_date_food'])){
			$start_date_food = $this->request->getData()['start_date_food'];
			$end_date_food = $this->request->getData()['end_date_food'];
			$parameter_arr=array();
			if($this->request->getData()["start_date_food"] != "" && $this->request->getData()["start_date_food"] != "Start Date Food"):
				$parameter_arr['start_date_food'] = $this->request->getData()["start_date_food"];
			endif;
			if($this->request->getData()["end_date_food"] != "" && $this->request->getData()["end_date_food"] != "End Date Food"):
				$parameter_arr['end_date_food'] = $this->request->getData()["end_date_food"];
			endif;
			return $this->redirect(['controller' => 'Bookings', 'action' => 'foodreport', "?" => $parameter_arr]);
		}
		if(isset($this->request->getData()['start_date_bar']) && isset($this->request->getData()['end_date_bar'])){
			$parameter_arr=array();
			if($this->request->getData()["start_date_bar"] != "" && $this->request->getData()["start_date_bar"] != "Start Date Bar"):
				$parameter_arr['start_date_bar'] = $this->request->getData()["start_date_bar"];
			endif;
			if($this->request->getData()["end_date_bar"] != "" && $this->request->getData()["end_date_bar"] != "End Date Bar"):
				$parameter_arr['end_date_bar'] = $this->request->getData()["end_date_bar"];
			endif;
			return $this->redirect(['controller' => 'Bookings', 'action' => 'barreport', "?" => $parameter_arr]);
		}
		if(isset($this->request->getData()['start_date_customer']) && isset($this->request->getData()['end_date_customer'])){
			$parameter_arr=array();
			if($this->request->getData()["start_date_customer"] != "" && $this->request->getData()["start_date_customer"] != "Start Date Customer"):
				$parameter_arr['start_date_customer'] = $this->request->getData()["start_date_customer"];
			endif;
			if($this->request->getData()["end_date_customer"] != "" && $this->request->getData()["end_date_customer"] != "End Date Customer"):
				$parameter_arr['end_date_customer'] = $this->request->getData()["end_date_customer"];
			endif;
			return $this->redirect(['controller' => 'Bookings', 'action' => 'customerreport', "?" => $parameter_arr]);
		}
		if(isset($this->request->getData()['start_date_bst']) && isset($this->request->getData()['end_date_bst'])){
			$parameter_arr=array();
			if($this->request->getData()["start_date_bst"] != "" && $this->request->getData()["start_date_bst"] != "Start Date Bst"):
				$parameter_arr['start_date_bst'] = $this->request->getData()["start_date_bst"];
			endif;
			if($this->request->getData()["end_date_bst"] != "" && $this->request->getData()["end_date_bst"] != "End Date Bst"):
				$parameter_arr['end_date_bst'] = $this->request->getData()["end_date_bst"];
			endif;
			return $this->redirect(['controller' => 'Bookings', 'action' => 'bstreport', "?" => $parameter_arr]);
		}
		if(isset($this->request->getData()['start_date_revenue']) && isset($this->request->getData()['end_date_revenue'])){
			$parameter_arr=array();
			if($this->request->getData()["start_date_revenue"] != "" && $this->request->getData()["start_date_revenue"] != "Start Date Revenue"):
				$parameter_arr['start_date_revenue'] = $this->request->getData()["start_date_revenue"];
			endif;
			if($this->request->getData()["end_date_revenue"] != "" && $this->request->getData()["end_date_revenue"] != "End Date Revenue"):
				$parameter_arr['end_date_revenue'] = $this->request->getData()["end_date_revenue"];
			endif;
			return $this->redirect(['controller' => 'Bookings', 'action' => 'revenuereport', "?" => $parameter_arr]);
		}
		if(isset($this->request->getData()['start_date_occupancy']) && isset($this->request->getData()['end_date_occupancy'])){
			$parameter_arr=array();
			if($this->request->getData()["start_date_occupancy"] != "" && $this->request->getData()["start_date_occupancy"] != "Start Date Occupancy"):
				$parameter_arr['start_date_occupancy'] = $this->request->getData()["start_date_occupancy"];
			endif;
			if($this->request->getData()["end_date_occupancy"] != "" && $this->request->getData()["end_date_occupancy"] != "End Date Occupancy"):
				$parameter_arr['end_date_occupancy'] = $this->request->getData()["end_date_occupancy"];
			endif;
			return $this->redirect(['controller' => 'Bookings', 'action' => 'roomoccupancyreport', "?" => $parameter_arr]);
		}
		if(isset($this->request->getData()['start_date_outstanding']) && isset($this->request->getData()['end_date_outstanding'])){
			$parameter_arr=array();
			if($this->request->getData()["start_date_outstanding"] != "" && $this->request->getData()["start_date_outstanding"] != "Start Date Outstanding"):
				$parameter_arr['start_date_outstanding'] = $this->request->getData()["start_date_outstanding"];
			endif;
			if($this->request->getData()["end_date_outstanding"] != "" && $this->request->getData()["end_date_outstanding"] != "End Date Outstanding"):
				$parameter_arr['end_date_outstanding'] = $this->request->getData()["end_date_outstanding"];
			endif;
			return $this->redirect(['controller' => 'Bookings', 'action' => 'outstandingreport', "?" => $parameter_arr]);
		}
	}

	public function masterreport()
	{
		$start_date_master = $this->request->getQuery('start_date_master');
		$end_date_master = $this->request->getQuery('end_date_master');
		$condition['Bookings.payment_status IN'] = ["P","R"];
		if(isset($start_date_master) && $start_date_master!="")
		{
			$condition['Bookings.booking_date >='] = $start_date_master." 00:00:00";
		}
		if(isset($end_date_master) && $end_date_master!="")
		{
			$condition['Bookings.booking_date <='] = $end_date_master." 23:59:59";
		}
		$this->Bookings = TableRegistry::get('Bookings');
		try {
			$this->paginate = [
				'limit' => 100,
				'conditions'=>$condition,
				'contain' => ['Customers'],
				'order' => ['Bookings.id DESC']
			];
		} catch (\Exception $e) {
			//Do nothing
			echo "No Record";
		}
		$bookings = $this->paginate($this->Bookings);

        $this->set(compact('bookings'));
	}

	public function roomreport()
	{
		$start_date_room = $this->request->getQuery('start_date_room');
		$end_date_room = $this->request->getQuery('end_date_room');
		$condition['Bookings.payment_status IN'] = ["P","R"];
		if(isset($start_date_room) && $start_date_room!="")
		{
			$condition['Bookings.booking_date >='] = $start_date_room." 00:00:00";
		}
		if(isset($end_date_room) && $end_date_room!="")
		{
			$condition['Bookings.booking_date <='] = $end_date_room." 23:59:59";
		}
		$this->Bookings = TableRegistry::get('Bookings');
		try {
			$this->paginate = [
				'limit' => 100,
				'conditions'=>$condition,
				'contain' => ['Customers'],
				'order' => ['Bookings.id DESC']
			];
		} catch (\Exception $e) {
			//Do nothing
			echo "No Record";
		}
		$bookings = $this->paginate($this->Bookings);

        $this->set(compact('bookings'));
	}

	public function foodreport()
	{
		$start_date_food = $this->request->getQuery('start_date_food');
		$end_date_food = $this->request->getQuery('end_date_food');
		$condition['FoodItemOrders.is_payment IN'] = ["P","R"];
		if(isset($start_date_food) && $start_date_food!="")
		{
			$condition['FoodItemOrders.order_date >='] = $start_date_food." 00:00:00";
		}
		if(isset($end_date_food) && $end_date_food!="")
		{
			$condition['FoodItemOrders.order_date <='] = $end_date_food." 23:59:59";
		}
		$this->FoodItemOrders = TableRegistry::get('FoodItemOrders');
		try {
			$this->paginate = [
				'limit' => 100,
				'conditions'=>$condition,
				'order' => ['FoodItemOrders.id DESC']
			];
		} catch (\Exception $e) {
			//Do nothing
			echo "No Record";
		}
		$foodItemOrders = $this->paginate($this->FoodItemOrders);

        $this->set(compact('foodItemOrders'));
	}

	public function barreport()
	{
		$start_date_bar = $this->request->getQuery('start_date_bar');
		$end_date_bar = $this->request->getQuery('end_date_bar');
		$condition['BeverageItemOrders.is_payment IN'] = ["P","R"];
		if(isset($start_date_bar) && $start_date_bar!="")
		{
			$condition['BeverageItemOrders.order_date >='] = $start_date_bar." 00:00:00";
		}
		if(isset($end_date_bar) && $end_date_bar!="")
		{
			$condition['BeverageItemOrders.order_date <='] = $end_date_bar." 23:59:59";
		}
		$this->BeverageItemOrders = TableRegistry::get('BeverageItemOrders');
		try {
			$this->paginate = [
				'limit' => 100,
				'conditions'=>$condition,
				'order' => ['BeverageItemOrders.id DESC']
			];
		} catch (\Exception $e) {
			//Do nothing
			echo "No Record";
		}
		$beverageItemOrders = $this->paginate($this->BeverageItemOrders);

        $this->set(compact('beverageItemOrders'));
	}

	public function customerreport()
	{
		$start_date_customer = $this->request->getQuery('start_date_customer');
		$end_date_customer = $this->request->getQuery('end_date_customer');
		$condition['Bookings.payment_status IN'] = ["P","R"];
		if(isset($start_date_customer) && $start_date_customer!="")
		{
			$condition['Bookings.booking_date >='] = $start_date_customer." 00:00:00";
		}
		if(isset($end_date_customer) && $end_date_customer!="")
		{
			$condition['Bookings.booking_date <='] = $end_date_customer." 23:59:59";
		}
		$this->Bookings = TableRegistry::get('Bookings');
		try {
			$this->paginate = [
				'limit' => 100,
				'conditions'=>$condition,
				'contain' => ['Customers'],
				'order' => ['Bookings.id DESC']
			];
		} catch (\Exception $e) {
			//Do nothing
			echo "No Record";
		}
		$bookings = $this->paginate($this->Bookings);

        $this->set(compact('bookings'));
	}

	public function revenuereport()
	{
		$start_date_revenue = $this->request->getQuery('start_date_revenue');
		$end_date_revenue = $this->request->getQuery('end_date_revenue');
		$condition['Bookings.payment_status IN'] = ["P","R"];
		if(isset($start_date_revenue) && $start_date_revenue!="")
		{
			$condition['Bookings.booking_date >='] = $start_date_revenue." 00:00:00";
		}
		if(isset($end_date_revenue) && $end_date_revenue!="")
		{
			$condition['Bookings.booking_date <='] = $end_date_revenue." 23:59:59";
		}
		$this->Bookings = TableRegistry::get('Bookings');
		try {
			$this->paginate = [
				'limit' => 100,
				'conditions'=>$condition,
				'contain' => ['Customers'],
				'order' => ['Bookings.id DESC']
			];
		} catch (\Exception $e) {
			//Do nothing
			echo "No Record";
		}
		$bookings = $this->paginate($this->Bookings);

        $this->set(compact('bookings'));
	}

	public function roomoccupancyreport()
	{
		$this->loadModel('Rooms');
		$start_date_occupancy = $this->request->getQuery('start_date_occupancy');
		$end_date_occupancy = $this->request->getQuery('end_date_occupancy');

		$room = $this->Rooms->find('all', ['conditions' => ['Rooms.status' => "Y"]])->toArray();
		$this->set(compact('room'));
	}

	public function bstreport()
	{
		$start_date_bst = $this->request->getQuery('start_date_bst');
		$end_date_bst = $this->request->getQuery('end_date_bst');
		$condition['Bookings.payment_status IN'] = ["P","R"];
		if(isset($start_date_bst) && $start_date_bst!="")
		{
			$condition['Bookings.booking_date >='] = $start_date_bst." 00:00:00";
		}
		if(isset($end_date_bst) && $end_date_bst!="")
		{
			$condition['Bookings.booking_date <='] = $end_date_bst." 23:59:59";
		}
		$this->Bookings = TableRegistry::get('Bookings');
		try {
			$this->paginate = [
				'limit' => 100,
				'conditions'=>$condition,
				'contain' => ['Customers'],
				'order' => ['Bookings.id DESC']
			];
		} catch (\Exception $e) {
			//Do nothing
			echo "No Record";
		}
		$bookings = $this->paginate($this->Bookings);

        $this->set(compact('bookings'));
	}

	public function outstandingreport()
	{
		$start_date_outstanding = $this->request->getQuery('start_date_outstanding');
		$end_date_outstanding = $this->request->getQuery('end_date_outstanding');
		$condition['Bookings.payment_status IN'] = ["P","R"];
		if(isset($start_date_outstanding) && $start_date_outstanding!="")
		{
			$condition['Bookings.booking_date >='] = $start_date_outstanding." 00:00:00";
		}
		if(isset($end_date_outstanding) && $end_date_outstanding!="")
		{
			$condition['Bookings.booking_date <='] = $end_date_outstanding." 23:59:59";
		}
		$this->Bookings = TableRegistry::get('Bookings');
		try {
			$this->paginate = [
				'limit' => 100,
				'conditions'=>$condition,
				'contain' => ['Customers'],
				'order' => ['Bookings.id DESC']
			];
		} catch (\Exception $e) {
			//Do nothing
			echo "No Record";
		}
		$bookings = $this->paginate($this->Bookings);

        $this->set(compact('bookings'));
	}

	public function oldbooking()
    {
		$today_year = date('Y');
		$year = isset($this->request->getParam('pass')[0]) && $this->request->getParam('pass')[0] != "" ? str_replace("_", " ", $this->request->getParam('pass')[0]) : "";
		if(isset($year) && $year!="")
		{
			$today_year = $year;
		}
		$this->Bookings = TableRegistry::get('Bookings');
		try {
			$this->paginate = [
				'limit' => 50,
				'conditions'=>['Bookings.booking_type' => "B", 'YEAR(Bookings.booking_date)' => $today_year],
				'contain' => ['Customers'],
				'order' => ['Bookings.id DESC']
			];
		} catch (\Exception $e) {
			//Do nothing
			echo "No Record";
		}
		$bookings = $this->paginate($this->Bookings);

		/*$this->paginate = [
            'contain' => ['Customers']
        ];
        $bookings = $this->paginate($this->Bookings);*/

		//$bookings = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => [], 'order'=>'Bookings.id DESC'])->toArray();

        $this->set(compact('bookings'));
    }

	public function unpaid()
    {
		$this->Bookings = TableRegistry::get('Bookings');
		try {
			$this->paginate = [
				'limit' => 50,
				'conditions'=>['Bookings.booking_type' => "B", 'Bookings.payment_status IN' => ["U","R"]],
				'contain' => ['Customers'],
				'order' => ['Bookings.id DESC']
			];
		} catch (\Exception $e) {
			//Do nothing
			echo "No Record";
		}
		$bookings = $this->paginate($this->Bookings);

        $this->set(compact('bookings'));
    }

	public function reservation()
    {
        /*$this->paginate = [
            'contain' => ['Customers']
        ];
        $bookings = $this->paginate($this->Bookings);*/

		$bookings = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => ['Bookings.booking_type' => "R"], 'order'=>'Bookings.id DESC'])->toArray();

        $this->set(compact('bookings'));
    }

	public function showUser()
	{
		$this->loadModel('Customers');
		$this->viewBuilder()->setLayout('ajax');
		$data['msg'] = "We are having some problem. Please, try again.";
		$mobile = $this->request->getData()['mobile'];
		if(isset($mobile) && $mobile!=""){
			$customer = $this->Customers->find('all', ['conditions' => ['Customers.mobile_number' => $mobile]])->first();
			if(!empty($customer))
			{
				$data['msg'] = "Success";
				$data['full_name'] = $customer->full_name;
				$data['email_address'] = $customer->email_address;
				$data['guest_category'] = $customer->guest_category;
				$data['address'] = $customer->address;
				$data['id_type'] = $customer->id_type;
				$data['id_number'] = $customer->id_number;
			}
		}
		echo json_encode($data);
		exit;
	}

	public function showBooking()
	{
		$this->loadModel('BookingPayments');
		$this->loadModel('FoodItemOrders');
		$this->loadModel('BeverageItemOrders');
		$this->loadModel('HousekeepingOrders');
		$this->Settings = TableRegistry::get('Settings');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		$site_url = Router::url('/',true);
		$this->viewBuilder()->setLayout('ajax');
		$data['msg'] = "We are having some problem. Please, try again.";
		$booking_id = $this->request->getData()['booking_id'];
		if(isset($booking_id) && $booking_id!=""){
			$booking = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => ['Bookings.id' => $booking_id]])->first();
			
			$booking_price = $this->Bookings->find('all' , array('fields' => ['total_booking_price' => 'SUM(booking_price)'], 'conditions' => array("Bookings.id" => $booking_id)))->first();
			$total_booking_price = 0;
			if($booking_price->total_booking_price!=""){
				$total_booking_price = round($booking_price->total_booking_price) * $booking->number_of_night;
			}
			$food_item_order_price = $this->FoodItemOrders->find('all' , array('fields' => ['total_food_item_order_price' => 'SUM(sub_total)'], 'conditions' => array("FoodItemOrders.booking_id" => $booking_id, 'FoodItemOrders.is_delivered' => "Y")))->first();
			$total_food_item_order_price = 0;
			if($food_item_order_price->total_food_item_order_price!=""){
				$total_food_item_order_price = round($food_item_order_price->total_food_item_order_price);
			}
			$bavarage_item_order_price = $this->BeverageItemOrders->find('all' , array('fields' => ['total_bavarage_item_order_price' => 'SUM(sub_total)'], 'conditions' => array("BeverageItemOrders.booking_id" => $booking_id, 'BeverageItemOrders.is_delivered' => "Y")))->first();
			$total_bavarage_item_order_price = 0;
			if($bavarage_item_order_price->total_bavarage_item_order_price!=""){
				$total_bavarage_item_order_price = round($bavarage_item_order_price->total_bavarage_item_order_price);
			}
			$house_keeping_order_price = $this->HousekeepingOrders->find('all' , array('fields' => ['total_house_keeping_order_price' => 'SUM(sub_total)'], 'conditions' => array("HousekeepingOrders.booking_id" => $booking_id)))->first();
			$total_house_keeping_order_price = 0;
			if($house_keeping_order_price->total_house_keeping_order_price!=""){
				$total_house_keeping_order_price = round($house_keeping_order_price->total_house_keeping_order_price);
			}
			$total_booking_amount = $total_booking_price + $total_food_item_order_price + $total_bavarage_item_order_price + $total_house_keeping_order_price;
			$bst_tax = 0;
			$service_tax = 0;
			$gst_tax = 0;
			/*if($total_food_item_order_price > 0 || $total_bavarage_item_order_price > 0 || $total_house_keeping_order_price > 0)
			{
				$bst_tax = round(($total_booking_amount * $setting->bst_tax)/100);
				$service_tax = round(($total_booking_amount * $setting->service_tax)/100);
				$gst_tax = round(($total_booking_amount * $setting->gst_tax)/100);
			}
			else
			{*/
				if($booking->allow_bst == "Y")
				{
					$bst_tax = round(($total_booking_amount * $booking->bst_tax)/100);
				}
				if($booking->allow_service_charge == "Y")
				{
					$service_tax = round(($total_booking_amount * $booking->service_tax)/100);
				}
				if($booking->allow_gst == "Y")
				{
					$gst_tax = round(($total_booking_amount * $booking->gst_tax)/100);
				}
			//}			
			$grand_total_booking_amount = $total_booking_amount + $bst_tax + $service_tax + $gst_tax;
			$booking_payments = $this->BookingPayments->find('all' , array('fields' => ['total_booking_payments' => 'SUM(payment_price)'], 'conditions' => array("BookingPayments.booking_id" => $booking_id)))->first();
			$total_booking_payments = 0;
			if($booking_payments->total_booking_payments!=""){
				$total_booking_payments = $booking_payments->total_booking_payments;
			}
			$remaining_amount = $grand_total_booking_amount - $total_booking_payments;
			if(!empty($booking))
			{
				$data['full_name'] = $booking->customer->full_name;
				$data['mobile_number'] = $booking->customer->mobile_number;
				$data['email_address'] = $booking->customer->email_address;
				$data['guest_category'] = $booking->customer->guest_category;
				$data['address'] = $booking->customer->address;
				$data['id_type'] = $booking->customer->id_type;
				$data['id_number'] = $booking->customer->id_number;
				$data['check_in_date'] = date("d/m/Y",strtotime($booking->check_in_date));
				$data['check_out_date'] = date("d/m/Y",strtotime($booking->check_out_date));
				$data['adults'] = $booking->adults;
				$data['children'] = $booking->children;
				$data['number_of_night'] = $booking->number_of_night;
				$data['room_booking_price'] = $setting->currency.round($total_booking_price);
				$data['total_food_item_order_price'] = $setting->currency.round($total_food_item_order_price);
				$data['total_bavarage_item_order_price'] = $setting->currency.round($total_bavarage_item_order_price);
				$data['total_house_keeping_order_price'] = $setting->currency.round($total_house_keeping_order_price);
				$data['total_booking_amount'] = $setting->currency.round($total_booking_amount);
				$data['bst_tax'] = $setting->currency.round($bst_tax);
				$data['service_tax'] = $setting->currency.round($service_tax);
				$data['gst_tax'] = $setting->currency.round($gst_tax);
				$data['booking_bst_tax'] = $booking->bst_tax;
				$data['booking_service_tax'] = $booking->service_tax;
				$data['booking_gst_tax'] = $booking->gst_tax;
				$data['grand_total_booking_amount'] = $setting->currency.round($grand_total_booking_amount);
				$data['total_booking_payments'] = $setting->currency.round($total_booking_payments);
				$data['remaining_amount'] = $setting->currency.round($remaining_amount);
				$view_booking = $site_url."bookings/view/".$booking_id;
				$view_payment = $site_url."booking-payments/index/".$booking_id;
				$add_payment = $site_url."booking-payments/add/".$booking_id;
				$add_food_order = $site_url."food-item-orders/add/".$booking_id;
				$add_drink_order = $site_url."beverage-item-orders/add/".$booking_id;
				$add_house_keeping = $site_url."housekeeping-orders/index/".$booking_id;
				$edit_booking = $site_url."bookings/edit/".$booking_id;
				$verify = $site_url."bookings/dashboard/".base64_encode($booking_id);
				$show_view = '<div class="col-lg-12" style="text-align: center;">
					<a href="'.$view_booking.'" style="margin: 5px;" class="btn btn-success">View Booking</a>
					<a href="'.$add_food_order.'" style="margin: 5px;" class="btn btn-info">Add Food Order</a>
					<a href="'.$add_drink_order.'" style="margin: 5px;" class="btn btn-warning">Add Drinks Order</a>
					<a href="'.$add_payment.'" style="margin: 5px;" class="btn btn-yellow">Add Payment</a>
					<a href="'.$view_payment.'" style="margin: 5px;" class="btn btn-success">Payment History</a>
					<a href="'.$add_house_keeping.'" style="margin: 5px;" class="btn btn-orange">Add House keeping</a>
					<a href="'.$edit_booking.'" style="margin: 5px;" class="btn btn-pink">Edit Booking</a>
					<a href="'.$edit_booking.'" style="margin: 5px;" class="btn btn-info">Extend Booking Date</a>
					<a href="'.$verify.'" style="margin: 5px;" class="btn btn-danger">Verify & Check Out</a>
				</div>';
				$data['show_view'] = $show_view;
			}
		}
		echo json_encode($data);
		exit;
	}

    /**
     * View method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->loadModel('RefundPayments');
		$this->loadModel('BookingPayments');
		$this->loadModel('FoodItemOrders');
		$this->loadModel('BeverageItemOrders');
		$this->loadModel('HousekeepingOrders');
        $booking = $this->Bookings->get($id, [
            'contain' => ['Customers', 'BeverageItemOrders', 'BookingPayments', 'FoodItemOrders', 'HousekeepingOrders', 'BookingRoomDetails']
        ]);

		$foodItemOrder = $this->FoodItemOrders->find('all', ['conditions' => ['FoodItemOrders.booking_id' => $id, 'FoodItemOrders.is_delivered' => "Y"]])->toArray();
		$bavarageItemOrder = $this->BeverageItemOrders->find('all', ['conditions' => ['BeverageItemOrders.booking_id' => $id, 'BeverageItemOrders.is_delivered' => "Y"]])->toArray();
		$housekeepingOrders = $this->HousekeepingOrders->find('all', ['conditions' => ['HousekeepingOrders.booking_id' => $id]])->toArray();
		$bookingPayments = $this->BookingPayments->find('all', ['conditions' => ['BookingPayments.booking_id' => $id]])->toArray();
		$refundPayments = $this->RefundPayments->find('all', ['conditions' => ['RefundPayments.booking_id' => $id]])->toArray();

		$this->set(compact('booking', 'foodItemOrder', 'bavarageItemOrder', 'bookingPayments', 'housekeepingOrders', 'refundPayments'));
    }

	public function dashboard($booking_id = null){
		$this->loadModel('Rooms');
		$this->loadModel('Reservations');
		$booking_id = base64_decode($booking_id);
		$booking_verify = [];
		$room_verify = [];
		$booking_reserve = $this->Bookings->find('all', ['contain' => ['BookingRoomDetails'], 'conditions' => ['Bookings.booking_status' => "C", 'Bookings.booking_type' => "B"]])->toArray();
		$reservation_booking_reserve = $this->Reservations->find('all', ['conditions' => ['Reservations.booking_status' => "C", 'Reservations.booking_type' => "R"]])->toArray();
		if(isset($booking_id) && $booking_id!=""){
			$booking_verify = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => ['Bookings.id' => $booking_id]])->first();
			$room_verify = $this->Rooms->find('all', ['conditions' => ['Rooms.booking_id' => $booking_id, 'Rooms.room_status' => "O"]])->first();
		}
		$rooms = $this->Rooms->find('all', ['conditions'=>['Rooms.status'=>'Y']])->toArray();
		$this->set(compact('rooms', 'booking_reserve', 'reservation_booking_reserve', 'booking_id', 'booking_verify', 'room_verify'));
	}

	public function roombill($id = null)
    {
        $booking = $this->Bookings->get($id, [
            'contain' => ['Customers', 'BookingRoomDetails']
        ]);

        $this->set('booking', $booking);
    }

	public function roombillprint($id = null)
    {
		$this->viewBuilder()->setLayout('ajax');
        $booking = $this->Bookings->get($id, [
            'contain' => ['Customers', 'BookingRoomDetails']
        ]);

        $this->set('booking', $booking);
    }

	public function foodbill($id = null)
    {
		$this->loadModel('FoodItemOrders');
        $booking = $this->Bookings->get($id, [
            'contain' => ['Customers', 'BookingRoomDetails']
        ]);

		$foodItemOrder = $this->FoodItemOrders->find('all', ['conditions' => ['FoodItemOrders.booking_id' => $id]])->toArray();

        $this->set(compact('booking', 'foodItemOrder'));
    }

	public function foodbillprint($id = null)
    {
		$this->viewBuilder()->setLayout('ajax');
		$this->loadModel('FoodItemOrders');
        $booking = $this->Bookings->get($id, [
            'contain' => ['Customers', 'BookingRoomDetails']
        ]);

		$foodItemOrder = $this->FoodItemOrders->find('all', ['conditions' => ['FoodItemOrders.booking_id' => $id]])->toArray();

        $this->set(compact('booking', 'foodItemOrder'));
    }

	public function barbill($id = null)
    {
		$this->loadModel('BeverageItemOrders');
        $booking = $this->Bookings->get($id, [
            'contain' => ['Customers', 'BookingRoomDetails']
        ]);

		$bavarageItemOrder = $this->BeverageItemOrders->find('all', ['conditions' => ['BeverageItemOrders.booking_id' => $id]])->toArray();

        $this->set(compact('booking', 'bavarageItemOrder'));
    }

	public function barbillprint($id = null)
    {
		$this->viewBuilder()->setLayout('ajax');
		$this->loadModel('BeverageItemOrders');
        $booking = $this->Bookings->get($id, [
            'contain' => ['Customers', 'BookingRoomDetails']
        ]);

		$bavarageItemOrder = $this->BeverageItemOrders->find('all', ['conditions' => ['BeverageItemOrders.booking_id' => $id]])->toArray();

        $this->set(compact('booking', 'bavarageItemOrder'));
    }

	public function masterbill($id = null)
    {
		$this->loadModel('RefundPayments');
		$this->loadModel('BookingPayments');
		$this->loadModel('FoodItemOrders');
		$this->loadModel('BeverageItemOrders');
		$this->loadModel('HousekeepingOrders');
        $booking = $this->Bookings->get($id, [
            'contain' => ['Customers', 'BookingRoomDetails']
        ]);

		$foodItemOrder = $this->FoodItemOrders->find('all', ['conditions' => ['FoodItemOrders.booking_id' => $id, 'FoodItemOrders.is_delivered' => "Y"]])->toArray();
		$bavarageItemOrder = $this->BeverageItemOrders->find('all', ['conditions' => ['BeverageItemOrders.booking_id' => $id, 'BeverageItemOrders.is_delivered' => "Y"]])->toArray();
		$housekeepingOrders = $this->HousekeepingOrders->find('all', ['conditions' => ['HousekeepingOrders.booking_id' => $id]])->toArray();
		$bookingPayments = $this->BookingPayments->find('all', ['conditions' => ['BookingPayments.booking_id' => $id]])->toArray();
		$refundPayments = $this->RefundPayments->find('all', ['conditions' => ['RefundPayments.booking_id' => $id]])->toArray();

        $this->set(compact('booking', 'foodItemOrder', 'bavarageItemOrder', 'bookingPayments', 'housekeepingOrders', 'refundPayments'));
    }

	public function masterbillprint($id = null)
    {
		$this->viewBuilder()->setLayout('ajax');
		$this->loadModel('RefundPayments');
		$this->loadModel('BookingPayments');
		$this->loadModel('FoodItemOrders');
		$this->loadModel('BeverageItemOrders');
		$this->loadModel('HousekeepingOrders');
        $booking = $this->Bookings->get($id, [
            'contain' => ['Customers', 'BookingRoomDetails']
        ]);

		$foodItemOrder = $this->FoodItemOrders->find('all', ['conditions' => ['FoodItemOrders.booking_id' => $id, 'FoodItemOrders.is_delivered' => "Y"]])->toArray();
		$bavarageItemOrder = $this->BeverageItemOrders->find('all', ['conditions' => ['BeverageItemOrders.booking_id' => $id, 'BeverageItemOrders.is_delivered' => "Y"]])->toArray();
		$housekeepingOrders = $this->HousekeepingOrders->find('all', ['conditions' => ['HousekeepingOrders.booking_id' => $id]])->toArray();
		$bookingPayments = $this->BookingPayments->find('all', ['conditions' => ['BookingPayments.booking_id' => $id]])->toArray();
		$refundPayments = $this->RefundPayments->find('all', ['conditions' => ['RefundPayments.booking_id' => $id]])->toArray();

        $this->set(compact('booking', 'foodItemOrder', 'bavarageItemOrder', 'bookingPayments', 'housekeepingOrders', 'refundPayments'));
    }

	public function masterbillrceiptprint($id = null)
    {
		$this->viewBuilder()->setLayout('ajax');
		$booking = $this->Bookings->get($id, [
            'contain' => ['Customers', 'BookingRoomDetails']
        ]);
		$this->set(compact('booking'));
	}

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($room_id = null)
    {
		$this->loadModel('Rooms');
		$this->loadModel('Settings');
		$this->loadModel('Customers');
		$this->loadModel('RoomCategories');
		$this->loadModel('BookingRoomDetails');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		$booked_by = $this->request->getSession()->read('Auth.User.name')." (".$this->account_type[$this->request->getSession()->read('Auth.User.user_type')].")";
		if(isset($room_id) && $room_id!="")
		{
			$rooms = $this->Rooms->find('all', ['contain' => ['RoomCategories'], 'conditions' => ['Rooms.status' => 'Y', 'Rooms.room_status' => 'A', 'Rooms.id' => $room_id]])->toArray();
		}
		else
		{
			$rooms = $this->Rooms->find('all', ['contain' => ['RoomCategories'], 'conditions' => ['Rooms.status' => 'Y', 'Rooms.room_status' => 'A'], 'order'=>'Rooms.id ASC'])->toArray();
		}
		if(empty($rooms))
		{
			$this->Flash->error(__('There is no room available for this booking'));
			return $this->redirect(['action' => 'dashboard']);
		} 
        $booking = $this->Bookings->newEntity();
        if ($this->request->is('post')) {
            
			$fetch_exist_chk = $this->Customers->find('all', ['conditions' => ['Customers.mobile_number' => $this->request->getData(['mobile_number'])]])->first();
			if(empty($fetch_exist_chk))
			{
				$customers = $this->Customers->newEntity();
				$customers = $this->Customers->patchEntity($customers, $this->request->getData());
				$customer = $this->Customers->save($customers);
				$customer_id = $customer->id;
			}
			else
			{
				$customer_id = $fetch_exist_chk->id;
			}

			$booking = $this->Bookings->patchEntity($booking, $this->request->getData());
			$bst_tax = 0;
			$service_tax = 0;
			$gst_tax = 0;
			if($this->request->getData()['allow_bst'] == "Y"){
				$bst_tax = $setting->bst_tax;
			}
			if($this->request->getData()['allow_service_charge'] == "Y"){
				$service_tax = $setting->service_tax;
			}
			if($this->request->getData()['allow_gst'] == "Y"){
				$gst_tax = $setting->gst_tax;
			}
			$booking->customer_id = $customer_id;
			$booking->booking_date = date('Y-m-d H:i:s');
			$booking->booked_by = $booked_by;
			$booking->bst_tax = $bst_tax;
			$booking->service_tax = $service_tax;
			$booking->gst_tax = $gst_tax;
			$booking_data = $this->Bookings->save($booking);
            if ($booking_data) {
				if(isset($this->request->getData()['booking_room_name']) && $this->request->getData()['booking_room_name']!="")
				{
					foreach($this->request->getData()['booking_room_name'] as $key=>$val)
					{
						$bookingDetail = $this->BookingRoomDetails->newEntity();
						$bookingdetails['booking_id'] = $booking_data->id;
						$bookingdetails['booking_room_name'] = $val;
						$bookingdetails['booking_room_category'] = $this->request->getData()['booking_room_category'][$key];
						$bookingdetails['booking_room_price'] = $this->request->getData()['booking_room_price'][$key];
						$bookingdetails['booking_room_discount'] = $this->request->getData()['booking_room_discount'][$key];
						$bookingdetails['room_booking_price'] = $this->request->getData()['room_booking_price'][$key];
						$bookingDetail = $this->BookingRoomDetails->patchEntity($bookingDetail, $bookingdetails);
						$this->BookingRoomDetails->save($bookingDetail);
						if($booking_data->booking_type == "B"){
							$this->Rooms->updateAll(['booking_id' => $booking_data->id, 'room_status' => "O"], ['room_number' => $val]);
						}
					}
				}

                if($booking_data->booking_type == "B"){
					$this->Flash->success(__('The booking has been saved successfully'));
					return $this->redirect(['action' => 'index']);
				}else{
					$this->Flash->success(__('The reservation has been saved successfully'));
					return $this->redirect(['action' => 'reservation']);
				}
            }
            
			$this->Flash->error(__('The booking could not be saved. Please, try again.'));
        }
		$roomCategories = $this->RoomCategories->find('all', ['conditions'=>['RoomCategories.status'=>'Y']])->toArray();
        $customers = $this->Bookings->Customers->find('list', ['limit' => 200]);
        $this->set(compact('booking', 'rooms', 'customers', 'room_id', 'roomCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->loadModel('Rooms');
		$this->loadModel('Settings');
		$this->loadModel('RoomCategories');
		$this->loadModel('BookingRoomDetails');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
        $booking = $this->Bookings->get($id, [
            'contain' => ['Customers', 'BookingRoomDetails']
        ]);
		if($booking->payment_status == "P"){
			$this->Flash->error(__('You are not autorised to access this'));
			return $this->redirect(['action' => 'dashboard']);
		}
        if ($this->request->is(['patch', 'post', 'put'])) {
            $booking = $this->Bookings->patchEntity($booking, $this->request->getData());
			$bst_tax = 0;
			$service_tax = 0;
			$gst_tax = 0;
			if($this->request->getData()['allow_bst'] == "Y"){
				$bst_tax = $setting->bst_tax;
			}
			if($this->request->getData()['allow_service_charge'] == "Y"){
				$service_tax = $setting->service_tax;
			}
			if($this->request->getData()['allow_gst'] == "Y"){
				$gst_tax = $setting->gst_tax;
			}
			$booking->bst_tax = $bst_tax;
			$booking->service_tax = $service_tax;
			$booking->gst_tax = $gst_tax;
            $booking_data = $this->Bookings->save($booking);
			if ($booking_data) {
				if(isset($this->request->getData()['booking_room_name']) && $this->request->getData()['booking_room_name']!="")
				{
					$this->Rooms->updateAll(['booking_id' => 0, 'room_status' => "A"], ['booking_id' => $id]);
					foreach($this->request->getData()['booking_room_name'] as $key=>$val)
					{
						$edit_id = $this->request->getData()['edit_id'][$key];
							$bookingDetail = $this->BookingRoomDetails->get($edit_id, [
						]);
						$bookingdetails['booking_id'] = $id;
						$bookingdetails['booking_room_name'] = $val;
						$bookingdetails['booking_room_category'] = $this->request->getData()['booking_room_category'][$key];
						$bookingdetails['booking_room_price'] = $this->request->getData()['booking_room_price'][$key];
						$bookingdetails['booking_room_discount'] = $this->request->getData()['booking_room_discount'][$key];
						$bookingdetails['room_booking_price'] = $this->request->getData()['room_booking_price'][$key];
						$bookingDetail = $this->BookingRoomDetails->patchEntity($bookingDetail, $bookingdetails);
						$this->BookingRoomDetails->save($bookingDetail);
						if($booking_data->booking_type == "B"){
							$this->Rooms->updateAll(['booking_id' => $id, 'room_status' => "O"], ['room_number' => $val]);
						}
					}
				}
                if($booking->booking_type == "B"){
					$this->Flash->success(__('The booking has been saved successfully'));
					return $this->redirect(['action' => 'index']);
				}else{
					$this->Flash->success(__('The reservation has been saved successfully'));
					return $this->redirect(['action' => 'reservation']);
				}
            }
            $this->Flash->error(__('The booking could not be saved. Please, try again.'));
        }
		$rooms = $this->Rooms->find('all', ['contain' => ['RoomCategories'], 'conditions' => ['Rooms.status' => 'Y', 'OR' => ['Rooms.room_status' => 'A', 'Rooms.booking_id' => $id]], 'order'=>'Rooms.id ASC'])->toArray();
        $roomCategories = $this->RoomCategories->find('all', ['conditions'=>['RoomCategories.status'=>'Y']])->toArray();
        $customers = $this->Bookings->Customers->find('list', ['limit' => 200]);
        $this->set(compact('booking', 'rooms', 'customers', 'roomCategories'));
    }

	public function masterbillpdf($start_date = null, $end_date = null)
	{
		$start_date_master = date('Y-m-01');
		$end_date_master = date('Y-m-t');
		$condition['Bookings.payment_status IN'] = ["P","R"];
		if(isset($start_date) && $start_date!="")
		{
			$start_date_master = $start_date;
		}
		if(isset($end_date) && $end_date!="")
		{
			$end_date_master = $end_date;
		}
		$condition['Bookings.booking_date >='] = $start_date_master." 00:00:00";
		$condition['Bookings.booking_date <='] = $end_date_master." 23:59:59";
		$booking_master = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => $condition, 'order' => 'Bookings.id DESC'])->toArray();
		$this->loadModel('Settings');
		$site_general_settings = $this->Settings->find('all', ['conditions' => []])->first();

		$this->set(compact('booking_master', 'site_general_settings'));

		$CakePdf = new \CakePdf\Pdf\CakePdf();
		$CakePdf->template('pdfmasterbill', 'default');
		$CakePdf->viewVars($this->viewVars);
		// Get the PDF string returned
		$pdf = $CakePdf->output();
		$this->response->getBody()->write($pdf);
		$this->response = $this->response->withType('pdf');
		return $this->response;
	}

	public function roombillpdf($start_date = null, $end_date = null)
	{
		$start_date_room = date('Y-m-01');
		$end_date_room = date('Y-m-t');
		$condition['Bookings.payment_status IN'] = ["P","R"];
		if(isset($start_date) && $start_date!="")
		{
			$start_date_room = $start_date;
		}
		if(isset($end_date) && $end_date!="")
		{
			$end_date_room = $end_date;
		}
		$condition['Bookings.booking_date >='] = $start_date_room." 00:00:00";
		$condition['Bookings.booking_date <='] = $end_date_room." 23:59:59";
		$booking_room = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => $condition, 'order' => 'Bookings.id DESC'])->toArray();
		$this->loadModel('Settings');
		$site_general_settings = $this->Settings->find('all', ['conditions' => []])->first();

		$this->set(compact('booking_room', 'site_general_settings'));

		$CakePdf = new \CakePdf\Pdf\CakePdf();
		$CakePdf->template('pdfroombill', 'default');
		$CakePdf->viewVars($this->viewVars);
		// Get the PDF string returned
		$pdf = $CakePdf->output();
		$this->response->getBody()->write($pdf);
		$this->response = $this->response->withType('pdf');
		return $this->response;
	}

	public function foodbillpdf($start_date = null, $end_date = null)
	{
		$start_date_food = date('Y-m-01');
		$end_date_food = date('Y-m-t');
		$this->loadModel('Settings');
		$this->loadModel('FoodItemOrders');
		$condition['FoodItemOrders.is_payment IN'] = ["P","R"];
		if(isset($start_date) && $start_date!="")
		{
			$start_date_food = $start_date;
		}
		if(isset($end_date) && $end_date!="")
		{
			$end_date_food = $end_date;
		}
		$condition['FoodItemOrders.order_date >='] = $start_date_food." 00:00:00";
		$condition['FoodItemOrders.order_date <='] = $end_date_food." 23:59:59";

		$foodItemOrders = $this->FoodItemOrders->find('all', ['conditions' => $condition, 'order' => 'FoodItemOrders.id DESC'])->toArray();
		
		$site_general_settings = $this->Settings->find('all', ['conditions' => []])->first();

		$this->set(compact('foodItemOrders', 'site_general_settings'));

		$CakePdf = new \CakePdf\Pdf\CakePdf();
		$CakePdf->template('pdffoodbill', 'default');
		$CakePdf->viewVars($this->viewVars);
		// Get the PDF string returned
		$pdf = $CakePdf->output();
		$this->response->getBody()->write($pdf);
		$this->response = $this->response->withType('pdf');
		return $this->response;
	}

	public function barbillpdf($start_date = null, $end_date = null)
	{
		$start_date_bar = date('Y-m-01');
		$end_date_bar = date('Y-m-t');
		$this->loadModel('Settings');
		$this->loadModel('BeverageItemOrders');
		$condition['BeverageItemOrders.is_payment IN'] = ["P","R"];
		if(isset($start_date) && $start_date!="")
		{
			$start_date_bar = $start_date;
		}
		if(isset($end_date) && $end_date!="")
		{
			$end_date_bar = $end_date;
		}
		$condition['BeverageItemOrders.order_date >='] = $start_date_bar." 00:00:00";
		$condition['BeverageItemOrders.order_date <='] = $end_date_bar." 23:59:59";

		$beverageItemOrders = $this->BeverageItemOrders->find('all', ['conditions' => $condition, 'order' => 'BeverageItemOrders.id DESC'])->toArray();
		
		$site_general_settings = $this->Settings->find('all', ['conditions' => []])->first();

		$this->set(compact('beverageItemOrders', 'site_general_settings'));

		$CakePdf = new \CakePdf\Pdf\CakePdf();
		$CakePdf->template('pdfbarbill', 'default');
		$CakePdf->viewVars($this->viewVars);
		// Get the PDF string returned
		$pdf = $CakePdf->output();
		$this->response->getBody()->write($pdf);
		$this->response = $this->response->withType('pdf');
		return $this->response;
	}

	public function customerbillpdf($start_date = null, $end_date = null)
	{
		$start_date_customer = date('Y-m-01');
		$end_date_customer = date('Y-m-t');
		$condition['Bookings.payment_status IN'] = ["P","R"];
		if(isset($start_date) && $start_date!="")
		{
			$start_date_customer = $start_date;
		}
		if(isset($end_date) && $end_date!="")
		{
			$end_date_customer = $end_date;
		}
		$condition['Bookings.booking_date >='] = $start_date_customer." 00:00:00";
		$condition['Bookings.booking_date <='] = $end_date_customer." 23:59:59";
		$booking_customer = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => $condition, 'order' => 'Bookings.id DESC'])->toArray();
		$this->loadModel('Settings');
		$site_general_settings = $this->Settings->find('all', ['conditions' => []])->first();

		$this->set(compact('booking_customer', 'site_general_settings'));

		$CakePdf = new \CakePdf\Pdf\CakePdf();
		$CakePdf->template('pdfbillcustomer', 'default');
		$CakePdf->viewVars($this->viewVars);
		// Get the PDF string returned
		$pdf = $CakePdf->output();
		$this->response->getBody()->write($pdf);
		$this->response = $this->response->withType('pdf');
		return $this->response;
	}

	public function revenuepdf($start_date = null, $end_date = null)
	{
		$start_date_revenue = date('Y-m-01');
		$end_date_revenue = date('Y-m-t');
		$condition['Bookings.payment_status IN'] = ["P","R"];
		if(isset($start_date) && $start_date!="")
		{
			$start_date_revenue = $start_date;
		}
		if(isset($end_date) && $end_date!="")
		{
			$end_date_revenue = $end_date;
		}
		$condition['Bookings.booking_date >='] = $start_date_revenue." 00:00:00";
		$condition['Bookings.booking_date <='] = $end_date_revenue." 23:59:59";
		$booking_revenue = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => $condition, 'order' => 'Bookings.id DESC'])->toArray();
		$this->loadModel('Settings');
		$site_general_settings = $this->Settings->find('all', ['conditions' => []])->first();

		$this->set(compact('booking_revenue', 'site_general_settings'));

		$CakePdf = new \CakePdf\Pdf\CakePdf();
		$CakePdf->template('pdfrevenuebill', 'default');
		$CakePdf->viewVars($this->viewVars);
		// Get the PDF string returned
		$pdf = $CakePdf->output();
		$this->response->getBody()->write($pdf);
		$this->response = $this->response->withType('pdf');
		return $this->response;
	}

	public function bstbillpdf($start_date = null, $end_date = null)
	{
		$start_date_bst = date('Y-m-01');
		$end_date_bst = date('Y-m-t');
		$condition['Bookings.payment_status IN'] = ["P","R"];
		if(isset($start_date) && $start_date!="")
		{
			$start_date_bst = $start_date;
		}
		if(isset($end_date) && $end_date!="")
		{
			$end_date_bst = $end_date;
		}
		$condition['Bookings.booking_date >='] = $start_date_bst." 00:00:00";
		$condition['Bookings.booking_date <='] = $end_date_bst." 23:59:59";
		$booking_bst = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => $condition, 'order' => 'Bookings.id DESC'])->toArray();
		$this->loadModel('Settings');
		$site_general_settings = $this->Settings->find('all', ['conditions' => []])->first();

		$this->set(compact('booking_bst', 'site_general_settings'));

		$CakePdf = new \CakePdf\Pdf\CakePdf();
		$CakePdf->template('pdfbstbill', 'default');
		$CakePdf->viewVars($this->viewVars);
		// Get the PDF string returned
		$pdf = $CakePdf->output();
		$this->response->getBody()->write($pdf);
		$this->response = $this->response->withType('pdf');
		return $this->response;
	}

	public function outstandingpdf($start_date = null, $end_date = null)
	{
		$start_date_outstanding = date('Y-m-01');
		$end_date_outstanding = date('Y-m-t');
		$condition['Bookings.payment_status IN'] = ["P","R"];
		if(isset($start_date) && $start_date!="")
		{
			$start_date_outstanding = $start_date;
		}
		if(isset($end_date) && $end_date!="")
		{
			$end_date_outstanding = $end_date;
		}
		$condition['Bookings.booking_date >='] = $start_date_outstanding." 00:00:00";
		$condition['Bookings.booking_date <='] = $end_date_outstanding." 23:59:59";
		$booking_outstanding = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => $condition, 'order' => 'Bookings.id DESC'])->toArray();
		$this->loadModel('Settings');
		$site_general_settings = $this->Settings->find('all', ['conditions' => []])->first();

		$this->set(compact('booking_outstanding', 'site_general_settings'));

		$CakePdf = new \CakePdf\Pdf\CakePdf();
		$CakePdf->template('pdfoutstandingbill', 'default');
		$CakePdf->viewVars($this->viewVars);
		// Get the PDF string returned
		$pdf = $CakePdf->output();
		$this->response->getBody()->write($pdf);
		$this->response = $this->response->withType('pdf');
		return $this->response;
	}

	public function occupancypdf($start_date = null, $end_date = null)
	{
		$this->loadModel('Rooms');
		$start_date_occupancy = date('Y-m-01');
		$end_date_occupancy = date('Y-m-t');
		if(isset($start_date) && $start_date!="")
		{
			$start_date_occupancy = $start_date;
		}
		if(isset($end_date) && $end_date!="")
		{
			$end_date_occupancy = $end_date;
		}

		$room = $this->Rooms->find('all', ['conditions' => ['Rooms.status' => "Y"]])->toArray();
		
		$this->loadModel('Settings');
		$site_general_settings = $this->Settings->find('all', ['conditions' => []])->first();
		
		$this->set(compact('room', 'start_date_occupancy', 'end_date_occupancy', 'site_general_settings'));

		$CakePdf = new \CakePdf\Pdf\CakePdf();
		$CakePdf->template('pdfoccupancy', 'default');
		$CakePdf->viewVars($this->viewVars);
		// Get the PDF string returned
		$pdf = $CakePdf->output();
		$this->response->getBody()->write($pdf);
		$this->response = $this->response->withType('pdf');
		return $this->response;
	}	

	public function masterbillcsv($start_date = null, $end_date = null)
    {
		$this->viewBuilder()->layout('ajax');
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="master_report_'.date("Y-m-d").'_.csv"');
		$this->Settings = TableRegistry::get('Settings');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		$data_array = array();
		$data_array_heading = "Booking Number<~@~>Customer Name<~@~>Mobile Number<~@~>Guest Category<~@~>Address<~@~>ID Type<~@~>ID Number<~@~>Total Room Charge<~@~>Total Food Charge<~@~>Total Bar Charge<~@~>Total House Keeping Charge<~@~>Gross Amount<~@~>Total Service Charge<~@~>Total BST Charge<~@~>Total GST Charge<~@~>Grand Total";
		array_push($data_array, $data_array_heading);

		$start_date_master = date('Y-m-01');
		$end_date_master = date('Y-m-t');
		$condition['Bookings.payment_status IN'] = ["P","R"];
		if(isset($start_date) && $start_date!="")
		{
			$start_date_master = $start_date;
		}
		if(isset($end_date) && $end_date!="")
		{
			$end_date_master = $end_date;
		}
		$condition['Bookings.booking_date >='] = $start_date_master." 00:00:00";
		$condition['Bookings.booking_date <='] = $end_date_master." 23:59:59";
		$booking_master = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => $condition, 'order' => 'Bookings.id DESC'])->toArray();
		$all_room_amount = 0;
		$all_food_amount = 0;
		$all_bar_amount = 0;
		$all_house_kipping_amount = 0;
		$all_gross_amount = 0;
		$all_bst_tax = 0;
		$all_service_tax = 0;
		$all_gst_tax = 0;
		$all_grand_amount = 0;
		if(!empty($booking_master))
		{
			foreach($booking_master as $booking)
			{
				$room_charge = round($booking->booking_price * $booking->number_of_night); 
				$all_room_amount = $all_room_amount + $room_charge;
				$food_order_total_amount = $this->food_order_total_amount_generate($booking->id);
				$all_food_amount = $all_food_amount + $food_order_total_amount;
				$bar_order_total_amount = $this->bar_order_total_amount_generate($booking->id);
				$all_bar_amount = $all_bar_amount + $bar_order_total_amount;
				$house_keeping_total_amount = $this->house_keeping_total_amount_generate($booking->id);
				$all_house_kipping_amount = $all_house_kipping_amount + $house_keeping_total_amount;
				$gross_amount = $room_charge + $food_order_total_amount + $bar_order_total_amount + $house_keeping_total_amount;
				$all_gross_amount = $all_gross_amount + $gross_amount;
				$bst_tax = 0;
				$service_tax = 0;
				$gst_tax = 0;
				/*if($food_order_total_amount > 0 || $bar_order_total_amount > 0 || $house_keeping_total_amount > 0)
				{
					$bst_tax = round(($gross_amount * $setting->bst_tax)/100);
					$service_tax = round(($gross_amount * $setting->service_tax)/100);
					$gst_tax = round(($gross_amount * $setting->gst_tax)/100);
				}
				else
				{*/
					if($booking->allow_bst == "Y")
					{
						$bst_tax = round(($gross_amount * $booking->bst_tax)/100);
					}
					if($booking->allow_service_charge == "Y")
					{
						$service_tax = round(($gross_amount * $booking->service_tax)/100);
					}
					if($booking->allow_gst == "Y")
					{
						$gst_tax = round(($gross_amount * $booking->gst_tax)/100);
					}
				//}
				$all_bst_tax = $all_bst_tax + $bst_tax;
				$all_service_tax = $all_service_tax + $service_tax;
				$all_gst_tax = $all_gst_tax + $gst_tax;
				$grand_total_booking_amount = $gross_amount + $bst_tax + $service_tax + $gst_tax;
				$all_grand_amount = $all_grand_amount + $grand_total_booking_amount;
				
				$booking_number = $booking->id;
				$customer_name = $booking->customer->full_name;
				$mobile_number = $booking->customer->mobile_number;
				$guest_category = $booking->customer->guest_category;
				$address = $booking->customer->address;
				$id_type = $booking->customer->id_type;
				$id_number = $booking->customer->id_number;
				$total_room_charge = $setting->currency.round($room_charge);
				$total_food_charge = $setting->currency.round($food_order_total_amount);
				$total_bar_charge = $setting->currency.round($bar_order_total_amount);
				$total_house_keeping_charge = $setting->currency.round($house_keeping_total_amount);
				$gross_amount = $setting->currency.round($gross_amount);
				$total_service_charge = $setting->currency.round($service_tax)." (".$booking->service_tax."%)";
				$total_bst_charge = $setting->currency.round($bst_tax)." (".$booking->bst_tax."%)";
				$total_gst_charge = $setting->currency.round($gst_tax)." (".$booking->gst_tax."%)";
				$grand_total = $setting->currency.round($grand_total_booking_amount);
				$data_line = $booking_number."<~@~>".$customer_name."<~@~>".$mobile_number."<~@~>".$guest_category."<~@~>".$address."<~@~>".$id_type."<~@~>".$id_number."<~@~>".$total_room_charge."<~@~>".$total_food_charge."<~@~>".$total_bar_charge."<~@~>".$total_house_keeping_charge."<~@~>".$gross_amount."<~@~>".$total_service_charge."<~@~>".$total_bst_charge."<~@~>".$total_gst_charge."<~@~>".$grand_total;
				array_push($data_array, $data_line);
			}
			$data_array_total = "Master Bill Report<~@~><~@~><~@~><~@~><~@~><~@~>All Total<~@~>".$setting->currency.round($all_room_amount)."<~@~>".$setting->currency.round($all_food_amount)."<~@~>".$setting->currency.round($all_bar_amount)."<~@~>".$setting->currency.round($all_house_kipping_amount)."<~@~>".$setting->currency.round($all_gross_amount)."<~@~>".$setting->currency.round($all_service_tax)."<~@~>".$setting->currency.round($all_bst_tax)."<~@~>".$setting->currency.round($all_gst_tax)."<~@~>".$setting->currency.round($all_grand_amount);
			array_push($data_array, $data_array_total);
		}

		$fp = fopen('php://output', 'w');
		foreach ( $data_array as $line ) {
			$val = explode("<~@~>", $line);
			fputcsv($fp, $val);
		}
		fclose($fp);
		exit;
	}

	public function roombillcsv($start_date = null, $end_date = null)
    {
		$this->viewBuilder()->layout('ajax');
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="room_report_'.date("Y-m-d").'_.csv"');
		$this->Settings = TableRegistry::get('Settings');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		$data_array = array();
		$data_array_heading = "Booking Number<~@~>Room Number<~@~>Customer Name<~@~>Mobile Number<~@~>Guest Category<~@~>Address<~@~>ID Type<~@~>ID Number<~@~>Check In<~@~>Check Out<~@~>Total Room Charge<~@~>Total Service Charge<~@~>Total BST Charge<~@~>Total GST Charge<~@~>Grand Total";
		array_push($data_array, $data_array_heading);

		$start_date_room = date('Y-m-01');
		$end_date_room = date('Y-m-t');
		$condition['Bookings.payment_status IN'] = ["P","R"];
		if(isset($start_date) && $start_date!="")
		{
			$start_date_room = $start_date;
		}
		if(isset($end_date) && $end_date!="")
		{
			$end_date_room = $end_date;
		}
		$condition['Bookings.booking_date >='] = $start_date_room." 00:00:00";
		$condition['Bookings.booking_date <='] = $end_date_room." 23:59:59";
		$booking_room = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => $condition, 'order' => 'Bookings.id DESC'])->toArray();
		$all_room_amount = 0;
		$all_bst_tax = 0;
		$all_service_tax = 0;
		$all_gst_tax = 0;
		$all_grand_amount = 0;
		if(!empty($booking_room))
		{
			foreach($booking_room as $booking)
			{
				$show_rooms = $this->show_rooms_generate($booking->id);
				$room_charge = round($booking->booking_price * $booking->number_of_night); 
				$all_room_amount = $all_room_amount + $room_charge;
				$bst_tax = 0;
				$service_tax = 0;
				$gst_tax = 0;
				if($booking->allow_bst == "Y")
				{
					$bst_tax = round(($all_room_amount * $booking->bst_tax)/100);
				}
				if($booking->allow_service_charge == "Y")
				{
					$service_tax = round(($all_room_amount * $booking->service_tax)/100);
				}
				if($booking->allow_gst == "Y")
				{
					$gst_tax = round(($all_room_amount * $booking->gst_tax)/100);
				}
				$all_bst_tax = $all_bst_tax + $bst_tax;
				$all_service_tax = $all_service_tax + $service_tax;
				$all_gst_tax = $all_gst_tax + $gst_tax;
				$grand_total_booking_amount = $room_charge + $bst_tax + $service_tax + $gst_tax;
				$all_grand_amount = $all_grand_amount + $grand_total_booking_amount;
				
				$booking_number = $booking->id;
				$room_number = $show_rooms;
				$customer_name = $booking->customer->full_name;
				$mobile_number = $booking->customer->mobile_number;
				$guest_category = $booking->customer->guest_category;
				$address = $booking->customer->address;
				$id_type = $booking->customer->id_type;
				$id_number = $booking->customer->id_number;
				$check_in = date("d/m/Y",strtotime($booking->check_in_date));
				$check_out = date("d/m/Y",strtotime($booking->check_out_date));
				$total_room_charge = $setting->currency.round($room_charge);
				$total_service_charge = $setting->currency.round($service_tax)." (".$booking->service_tax."%)";
				$total_bst_charge = $setting->currency.round($bst_tax)." (".$booking->bst_tax."%)";
				$total_gst_charge = $setting->currency.round($gst_tax)." (".$booking->gst_tax."%)";
				$grand_total = $setting->currency.round($grand_total_booking_amount);
				$data_line = $booking_number."<~@~>".$room_number."<~@~>".$customer_name."<~@~>".$mobile_number."<~@~>".$guest_category."<~@~>".$address."<~@~>".$id_type."<~@~>".$id_number."<~@~>".$check_in."<~@~>".$check_out."<~@~>".$total_room_charge."<~@~>".$total_service_charge."<~@~>".$total_bst_charge."<~@~>".$total_gst_charge."<~@~>".$grand_total;
				array_push($data_array, $data_line);
			}
			$data_array_total = "Room Bill Report<~@~><~@~><~@~><~@~><~@~><~@~><~@~><~@~><~@~>All Total<~@~>".$setting->currency.round($all_room_amount)."<~@~>".$setting->currency.round($all_service_tax)."<~@~>".$setting->currency.round($all_bst_tax)."<~@~>".$setting->currency.round($all_gst_tax)."<~@~>".$setting->currency.round($all_grand_amount);
			array_push($data_array, $data_array_total);
		}

		$fp = fopen('php://output', 'w');
		foreach ( $data_array as $line ) {
			$val = explode("<~@~>", $line);
			fputcsv($fp, $val);
		}
		fclose($fp);
		exit;
	}

	public function foodbillcsv($start_date = null, $end_date = null)
    {
		$this->viewBuilder()->layout('ajax');
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="food_report_'.date("Y-m-d").'_.csv"');
		$this->loadModel('FoodItemOrders');
		$this->Settings = TableRegistry::get('Settings');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		$data_array = array();
		$data_array_heading = "SL No<~@~>Room / Table Number<~@~>Customer Name<~@~>Mobile Number<~@~>Total Food Charge<~@~>Total Service Charge (".$setting->food_service_tax."%)<~@~>Total BST Charge (".$setting->food_bst_tax."%)<~@~>Total GST Charge (".$setting->food_gst_tax."%)<~@~>Grand Total";
		array_push($data_array, $data_array_heading);

		$start_date_food = date('Y-m-01');
		$end_date_food = date('Y-m-t');
		$condition['FoodItemOrders.is_payment IN'] = ["P","R"];
		if(isset($start_date) && $start_date!="")
		{
			$start_date_food = $start_date;
		}
		if(isset($end_date) && $end_date!="")
		{
			$end_date_food = $end_date;
		}
		$condition['FoodItemOrders.order_date >='] = $start_date_food." 00:00:00";
		$condition['FoodItemOrders.order_date <='] = $end_date_food." 23:59:59";
		$foodItemOrders = $this->FoodItemOrders->find('all', ['conditions' => $condition, 'order' => 'FoodItemOrders.id DESC'])->toArray();
		$all_food_amount = 0;
		$all_bst_tax = 0;
		$all_service_tax = 0;
		$all_gst_tax = 0;
		$all_grand_amount = 0;
		if(!empty($foodItemOrders))
		{
			foreach($foodItemOrders as $key => $foodItemOrder)
			{
				if($foodItemOrder->booking_id > 0){
					$show_rooms = "Room: ".$this->show_rooms_generate($foodItemOrder->booking_id);
					$booking = $this->booking_customer_details_generate($foodItemOrder->booking_id);
					$customer_name = $booking->customer->full_name;
					$mobile_number = $booking->customer->mobile_number;
				}else{
					$show_rooms = "Table: ".$foodItemOrder->table_number;
					$customer_name = $foodItemOrder->guest_name;
					$mobile_number = $foodItemOrder->mobile_number;
				}
				$food_charge = round($foodItemOrder->sub_total); 
				$all_food_amount = $all_food_amount + $food_charge;
				$bst_tax = round(($food_charge * $setting->food_bst_tax)/100);
				$service_tax = round(($food_charge * $setting->food_service_tax)/100);
				$gst_tax = round(($food_charge * $setting->food_gst_tax)/100);
				
				$all_bst_tax = $all_bst_tax + $bst_tax;
				$all_service_tax = $all_service_tax + $service_tax;
				$all_gst_tax = $all_gst_tax + $gst_tax;
				$grand_total_booking_amount = $food_charge + $bst_tax + $service_tax + $gst_tax;
				$all_grand_amount = $all_grand_amount + $grand_total_booking_amount;
				
				$serial_number = $key + 1;
				$room_number = $show_rooms;
				$total_food_charge = $setting->currency.round($food_charge);
				$total_service_charge = $setting->currency.round($service_tax);
				$total_bst_charge = $setting->currency.round($bst_tax);
				$total_gst_charge = $setting->currency.round($gst_tax);
				$grand_total = $setting->currency.round($grand_total_booking_amount);
				$data_line = $serial_number."<~@~>".$room_number."<~@~>".$customer_name."<~@~>".$mobile_number."<~@~>".$total_food_charge."<~@~>".$total_service_charge."<~@~>".$total_bst_charge."<~@~>".$total_gst_charge."<~@~>".$grand_total;
				array_push($data_array, $data_line);
			}
			$data_array_total = "Food & Kitchen Report<~@~><~@~><~@~>All Total<~@~>".$setting->currency.round($all_food_amount)."<~@~>".$setting->currency.round($all_service_tax)."<~@~>".$setting->currency.round($all_bst_tax)."<~@~>".$setting->currency.round($all_gst_tax)."<~@~>".$setting->currency.round($all_grand_amount);
			array_push($data_array, $data_array_total);
		}

		$fp = fopen('php://output', 'w');
		foreach ( $data_array as $line ) {
			$val = explode("<~@~>", $line);
			fputcsv($fp, $val);
		}
		fclose($fp);
		exit;
	}

	public function barbillcsv($start_date = null, $end_date = null)
    {
		$this->viewBuilder()->layout('ajax');
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="baverage_report_'.date("Y-m-d").'_.csv"');
		$this->loadModel('BeverageItemOrders');
		$this->Settings = TableRegistry::get('Settings');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		$data_array = array();
		$data_array_heading = "SL No<~@~>Room / Table Number<~@~>Customer Name<~@~>Mobile Number<~@~>Total Bar Charge<~@~>Total Service Charge (".$setting->bar_service_tax."%)<~@~>Total BST Charge (".$setting->bar_bst_tax."%)<~@~>Total GST Charge (".$setting->bar_gst_tax."%)<~@~>Grand Total";
		array_push($data_array, $data_array_heading);

		$start_date_bar = date('Y-m-01');
		$end_date_bar = date('Y-m-t');
		$condition['BeverageItemOrders.is_payment IN'] = ["P","R"];
		if(isset($start_date) && $start_date!="")
		{
			$start_date_bar = $start_date;
		}
		if(isset($end_date) && $end_date!="")
		{
			$end_date_bar = $end_date;
		}
		$condition['BeverageItemOrders.order_date >='] = $start_date_bar." 00:00:00";
		$condition['BeverageItemOrders.order_date <='] = $end_date_bar." 23:59:59";
		$beverageItemOrders = $this->BeverageItemOrders->find('all', ['conditions' => $condition, 'order' => 'BeverageItemOrders.id DESC'])->toArray();
		$all_bar_amount = 0;
		$all_bst_tax = 0;
		$all_service_tax = 0;
		$all_gst_tax = 0;
		$all_grand_amount = 0;
		if(!empty($beverageItemOrders))
		{
			foreach($beverageItemOrders as $key => $barItemOrder)
			{
				if($barItemOrder->booking_id > 0){
					$show_rooms = "Room: ".$this->show_rooms_generate($barItemOrder->booking_id);
					$booking = $this->booking_customer_details_generate($barItemOrder->booking_id);
					$customer_name = $booking->customer->full_name;
					$mobile_number = $booking->customer->mobile_number;
				}else{
					$show_rooms = "Table: ".$barItemOrder->table_number;
					$customer_name = $barItemOrder->guest_name;
					$mobile_number = $barItemOrder->mobile_number;
				}
				$bar_charge = round($barItemOrder->sub_total); 
				$all_bar_amount = $all_bar_amount + $bar_charge;
				$bst_tax = round(($bar_charge * $setting->bar_bst_tax)/100);
				$service_tax = round(($bar_charge * $setting->bar_service_tax)/100);
				$gst_tax = round(($bar_charge * $setting->bar_gst_tax)/100);
				
				$all_bst_tax = $all_bst_tax + $bst_tax;
				$all_service_tax = $all_service_tax + $service_tax;
				$all_gst_tax = $all_gst_tax + $gst_tax;
				$grand_total_booking_amount = $bar_charge + $bst_tax + $service_tax + $gst_tax;
				$all_grand_amount = $all_grand_amount + $grand_total_booking_amount;
				
				$serial_number = $key + 1;
				$room_number = $show_rooms;
				$total_bar_charge = $setting->currency.round($bar_charge);
				$total_service_charge = $setting->currency.round($service_tax);
				$total_bst_charge = $setting->currency.round($bst_tax);
				$total_gst_charge = $setting->currency.round($gst_tax);
				$grand_total = $setting->currency.round($grand_total_booking_amount);
				$data_line = $serial_number."<~@~>".$room_number."<~@~>".$customer_name."<~@~>".$mobile_number."<~@~>".$total_bar_charge."<~@~>".$total_service_charge."<~@~>".$total_bst_charge."<~@~>".$total_gst_charge."<~@~>".$grand_total;
				array_push($data_array, $data_line);
			}
			$data_array_total = "Beverage & Bar Report<~@~><~@~><~@~>All Total<~@~>".$setting->currency.round($all_bar_amount)."<~@~>".$setting->currency.round($all_service_tax)."<~@~>".$setting->currency.round($all_bst_tax)."<~@~>".$setting->currency.round($all_gst_tax)."<~@~>".$setting->currency.round($all_grand_amount);
			array_push($data_array, $data_array_total);
		}

		$fp = fopen('php://output', 'w');
		foreach ( $data_array as $line ) {
			$val = explode("<~@~>", $line);
			fputcsv($fp, $val);
		}
		fclose($fp);
		exit;
	}

	public function customercsv($start_date = null, $end_date = null)
    {
		$this->viewBuilder()->layout('ajax');
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="customer_report_'.date("Y-m-d").'_.csv"');
		$this->Settings = TableRegistry::get('Settings');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		$data_array = array();
		$data_array_heading = "Booking Number<~@~>Room Number<~@~>Customer Name<~@~>Mobile Number<~@~>Guest Category<~@~>Address<~@~>ID Type<~@~>ID Number<~@~>Room Bill<~@~>Food Bill<~@~>Bar Bill<~@~>House Keeping Bill<~@~>Gross Amount<~@~>Service Charge<~@~>BST Charge<~@~>GST Charge<~@~>Grand Total<~@~>Amount Paid<~@~>Outstanding";
		array_push($data_array, $data_array_heading);

		$start_date_customer = date('Y-m-01');
		$end_date_customer = date('Y-m-t');
		$condition['Bookings.payment_status IN'] = ["P","R"];
		if(isset($start_date) && $start_date!="")
		{
			$start_date_customer = $start_date;
		}
		if(isset($end_date) && $end_date!="")
		{
			$end_date_customer = $end_date;
		}
		$condition['Bookings.booking_date >='] = $start_date_customer." 00:00:00";
		$condition['Bookings.booking_date <='] = $end_date_customer." 23:59:59";
		$booking_customer = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => $condition, 'order' => 'Bookings.id DESC'])->toArray();
		$all_room_amount = 0;
		$all_food_amount = 0;
		$all_bar_amount = 0;
		$all_house_kipping_amount = 0;
		$all_gross_amount = 0;
		$all_bst_tax = 0;
		$all_service_tax = 0;
		$all_gst_tax = 0;
		$all_amount_paid = 0;
		$all_outstanding = 0;
		$all_grand_amount = 0;
		if(!empty($booking_customer))
		{
			foreach($booking_customer as $booking)
			{
				$show_rooms = $this->show_rooms_generate($booking->id);
				$room_charge = round($booking->booking_price * $booking->number_of_night); 
				$all_room_amount = $all_room_amount + $room_charge;
				$food_order_total_amount = $this->food_order_total_amount_generate($booking->id);
				$all_food_amount = $all_food_amount + $food_order_total_amount;
				$bar_order_total_amount = $this->bar_order_total_amount_generate($booking->id);
				$all_bar_amount = $all_bar_amount + $bar_order_total_amount;
				$house_keeping_total_amount = $this->house_keeping_total_amount_generate($booking->id);
				$all_house_kipping_amount = $all_house_kipping_amount + $house_keeping_total_amount;
				$gross_amount = $room_charge + $food_order_total_amount + $bar_order_total_amount + $house_keeping_total_amount;
				$all_gross_amount = $all_gross_amount + $gross_amount;
				$bst_tax = 0;
				$service_tax = 0;
				$gst_tax = 0;
				$final_tally_summery = $this->final_tally_summery_generate($booking->id); 
				$tally_summery = explode("@",$final_tally_summery);
				$amount_payble = round($tally_summery[0]);
				$amount_received = round($tally_summery[1]);
				$outstanding = round($tally_summery[2]);
				$all_amount_paid = $all_amount_paid + $amount_received;
				$all_outstanding = $all_outstanding + $outstanding;
				/*if($food_order_total_amount > 0 || $bar_order_total_amount > 0 || $house_keeping_total_amount > 0)
				{
					$bst_tax = round(($gross_amount * $setting->bst_tax)/100);
					$service_tax = round(($gross_amount * $setting->service_tax)/100);
					$gst_tax = round(($gross_amount * $setting->gst_tax)/100);
				}
				else
				{*/
					if($booking->allow_bst == "Y")
					{
						$bst_tax = round(($gross_amount * $booking->bst_tax)/100);
					}
					if($booking->allow_service_charge == "Y")
					{
						$service_tax = round(($gross_amount * $booking->service_tax)/100);
					}
					if($booking->allow_gst == "Y")
					{
						$gst_tax = round(($gross_amount * $booking->gst_tax)/100);
					}
				//}
				$all_bst_tax = $all_bst_tax + $bst_tax;
				$all_service_tax = $all_service_tax + $service_tax;
				$all_gst_tax = $all_gst_tax + $gst_tax;
				$grand_total_booking_amount = $gross_amount + $bst_tax + $service_tax + $gst_tax;
				$all_grand_amount = $all_grand_amount + $grand_total_booking_amount;
				
				$booking_number = $booking->id;
				$room_number = $show_rooms;
				$customer_name = $booking->customer->full_name;
				$mobile_number = $booking->customer->mobile_number;
				$guest_category = $booking->customer->guest_category;
				$address = $booking->customer->address;
				$id_type = $booking->customer->id_type;
				$id_number = $booking->customer->id_number;
				$total_room_charge = $setting->currency.round($room_charge);
				$total_food_charge = $setting->currency.round($food_order_total_amount);
				$total_bar_charge = $setting->currency.round($bar_order_total_amount);
				$total_house_keeping_charge = $setting->currency.round($house_keeping_total_amount);
				$gross_amount = $setting->currency.round($gross_amount);
				$total_service_charge = $setting->currency.round($service_tax)." (".$booking->service_tax."%)";
				$total_bst_charge = $setting->currency.round($bst_tax)." (".$booking->bst_tax."%)";
				$total_gst_charge = $setting->currency.round($gst_tax)." (".$booking->gst_tax."%)";
				$grand_total = $setting->currency.round($grand_total_booking_amount);
				$data_line = $booking_number."<~@~>".$room_number."<~@~>".$customer_name."<~@~>".$mobile_number."<~@~>".$guest_category."<~@~>".$address."<~@~>".$id_type."<~@~>".$id_number."<~@~>".$total_room_charge."<~@~>".$total_food_charge."<~@~>".$total_bar_charge."<~@~>".$total_house_keeping_charge."<~@~>".$gross_amount."<~@~>".$total_service_charge."<~@~>".$total_bst_charge."<~@~>".$total_gst_charge."<~@~>".$grand_total."<~@~>".$amount_received."<~@~>".$outstanding;
				array_push($data_array, $data_line);
			}
			$data_array_total = "Customer Report<~@~><~@~><~@~><~@~><~@~><~@~><~@~>All Total<~@~>".$setting->currency.round($all_room_amount)."<~@~>".$setting->currency.round($all_food_amount)."<~@~>".$setting->currency.round($all_bar_amount)."<~@~>".$setting->currency.round($all_house_kipping_amount)."<~@~>".$setting->currency.round($all_gross_amount)."<~@~>".$setting->currency.round($all_service_tax)."<~@~>".$setting->currency.round($all_bst_tax).$setting->currency.round($all_gst_tax)."<~@~>".$setting->currency.round($all_grand_amount)."<~@~>".$setting->currency.round($all_amount_paid)."<~@~>".$setting->currency.round($all_outstanding);
			array_push($data_array, $data_array_total);
		}

		$fp = fopen('php://output', 'w');
		foreach ( $data_array as $line ) {
			$val = explode("<~@~>", $line);
			fputcsv($fp, $val);
		}
		fclose($fp);
		exit;
	}

	public function revenuecsv($start_date = null, $end_date = null)
    {
		$this->viewBuilder()->layout('ajax');
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="revenue_report_'.date("Y-m-d").'_.csv"');
		$this->Settings = TableRegistry::get('Settings');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		$data_array = array();
		$data_array_heading = "Booking Number<~@~>Room Number<~@~>Total Room Charge<~@~>Total Food Charge<~@~>Total Bar Charge<~@~>Total House Keeping Charge<~@~>Gross Amount<~@~>Total Service Charge<~@~>Total BST Charge<~@~>Total GST Charge<~@~>Grand Total";
		array_push($data_array, $data_array_heading);

		$start_date_revenue = date('Y-m-01');
		$end_date_revenue = date('Y-m-t');
		$condition['Bookings.payment_status IN'] = ["P","R"];
		if(isset($start_date) && $start_date!="")
		{
			$start_date_revenue = $start_date;
		}
		if(isset($end_date) && $end_date!="")
		{
			$end_date_revenue = $end_date;
		}
		$condition['Bookings.booking_date >='] = $start_date_revenue." 00:00:00";
		$condition['Bookings.booking_date <='] = $end_date_revenue." 23:59:59";
		$booking_revenue = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => $condition, 'order' => 'Bookings.id DESC'])->toArray();
		$all_room_amount = 0;
		$all_food_amount = 0;
		$all_bar_amount = 0;
		$all_house_kipping_amount = 0;
		$all_gross_amount = 0;
		$all_bst_tax = 0;
		$all_service_tax = 0;
		$all_gst_tax = 0;
		$all_grand_amount = 0;
		if(!empty($booking_revenue))
		{
			foreach($booking_revenue as $booking)
			{
				$show_rooms = $this->show_rooms_generate($booking->id);
				$room_charge = round($booking->booking_price * $booking->number_of_night); 
				$all_room_amount = $all_room_amount + $room_charge;
				$food_order_total_amount = $this->food_order_total_amount_generate($booking->id);
				$all_food_amount = $all_food_amount + $food_order_total_amount;
				$bar_order_total_amount = $this->bar_order_total_amount_generate($booking->id);
				$all_bar_amount = $all_bar_amount + $bar_order_total_amount;
				$house_keeping_total_amount = $this->house_keeping_total_amount_generate($booking->id);
				$all_house_kipping_amount = $all_house_kipping_amount + $house_keeping_total_amount;
				$gross_amount = $room_charge + $food_order_total_amount + $bar_order_total_amount + $house_keeping_total_amount;
				$all_gross_amount = $all_gross_amount + $gross_amount;
				$bst_tax = 0;
				$service_tax = 0;
				$gst_tax = 0;
				/*if($food_order_total_amount > 0 || $bar_order_total_amount > 0 || $house_keeping_total_amount > 0)
				{
					$bst_tax = round(($gross_amount * $setting->bst_tax)/100);
					$service_tax = round(($gross_amount * $setting->service_tax)/100);
					$gst_tax = round(($gross_amount * $setting->gst_tax)/100);
				}
				else
				{*/
					if($booking->allow_bst == "Y")
					{
						$bst_tax = round(($gross_amount * $booking->bst_tax)/100);
					}
					if($booking->allow_service_charge == "Y")
					{
						$service_tax = round(($gross_amount * $booking->service_tax)/100);
					}
					if($booking->allow_gst == "Y")
					{
						$gst_tax = round(($gross_amount * $booking->gst_tax)/100);
					}
				//}
				$all_bst_tax = $all_bst_tax + $bst_tax;
				$all_service_tax = $all_service_tax + $service_tax;
				$all_gst_tax = $all_gst_tax + $gst_tax;
				$grand_total_booking_amount = $gross_amount + $bst_tax + $service_tax + $gst_tax;
				$all_grand_amount = $all_grand_amount + $grand_total_booking_amount;
				
				$booking_number = $booking->id;
				$room_number = $show_rooms;
				$total_room_charge = $setting->currency.round($room_charge);
				$total_food_charge = $setting->currency.round($food_order_total_amount);
				$total_bar_charge = $setting->currency.round($bar_order_total_amount);
				$total_house_keeping_charge = $setting->currency.round($house_keeping_total_amount);
				$gross_amount = $setting->currency.round($gross_amount);
				$total_service_charge = $setting->currency.round($service_tax)." (".$booking->service_tax."%)";
				$total_bst_charge = $setting->currency.round($bst_tax)." (".$booking->bst_tax."%)";
				$total_gst_charge = $setting->currency.round($gst_tax)." (".$booking->gst_tax."%)";
				$grand_total = $setting->currency.round($grand_total_booking_amount);
				$data_line = $booking_number."<~@~>".$room_number."<~@~>".$total_room_charge."<~@~>".$total_food_charge."<~@~>".$total_bar_charge."<~@~>".$total_house_keeping_charge."<~@~>".$gross_amount."<~@~>".$total_service_charge."<~@~>".$total_bst_charge."<~@~>".$total_gst_charge."<~@~>".$grand_total;
				array_push($data_array, $data_line);
			}
			$data_array_total = "Revenue Report<~@~>All Total<~@~>".$setting->currency.round($all_room_amount)."<~@~>".$setting->currency.round($all_food_amount)."<~@~>".$setting->currency.round($all_bar_amount)."<~@~>".$setting->currency.round($all_house_kipping_amount)."<~@~>".$setting->currency.round($all_gross_amount)."<~@~>".$setting->currency.round($all_service_tax)."<~@~>".$setting->currency.round($all_bst_tax)."<~@~>".$setting->currency.round($all_gst_tax)."<~@~>".$setting->currency.round($all_grand_amount);
			array_push($data_array, $data_array_total);
		}

		$fp = fopen('php://output', 'w');
		foreach ( $data_array as $line ) {
			$val = explode("<~@~>", $line);
			fputcsv($fp, $val);
		}
		fclose($fp);
		exit;
	}

	public function bstbillcsv($start_date = null, $end_date = null)
    {
		$this->viewBuilder()->layout('ajax');
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="bst_report_'.date("Y-m-d").'_.csv"');
		$this->Settings = TableRegistry::get('Settings');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		$data_array = array();
		$data_array_heading = "Booking Number<~@~>Room Number<~@~>Customer Name<~@~>Booking Date<~@~>Bill Number<~@~>Receipt Number<~@~>BST Amount<~@~>Total Bill Amount";
		array_push($data_array, $data_array_heading);

		$start_date_bst = date('Y-m-01');
		$end_date_bst = date('Y-m-t');
		$condition['Bookings.payment_status IN'] = ["P","R"];
		if(isset($start_date) && $start_date!="")
		{
			$start_date_bst = $start_date;
		}
		if(isset($end_date) && $end_date!="")
		{
			$end_date_bst = $end_date;
		}
		$condition['Bookings.booking_date >='] = $start_date_bst." 00:00:00";
		$condition['Bookings.booking_date <='] = $end_date_bst." 23:59:59";
		$booking_bst = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => $condition, 'order' => 'Bookings.id DESC'])->toArray();
		$all_room_amount = 0;
		$all_food_amount = 0;
		$all_bar_amount = 0;
		$all_house_kipping_amount = 0;
		$all_gross_amount = 0;
		$all_bst_tax = 0;
		$all_service_tax = 0;
		$all_gst_tax = 0;
		$all_grand_amount = 0;
		if(!empty($booking_bst))
		{
			foreach($booking_bst as $booking)
			{
				$show_rooms = $this->show_rooms_generate($booking->id);
				$room_charge = round($booking->booking_price * $booking->number_of_night); 
				$all_room_amount = $all_room_amount + $room_charge;
				$food_order_total_amount = $this->food_order_total_amount_generate($booking->id);
				$all_food_amount = $all_food_amount + $food_order_total_amount;
				$bar_order_total_amount = $this->bar_order_total_amount_generate($booking->id);
				$all_bar_amount = $all_bar_amount + $bar_order_total_amount;
				$house_keeping_total_amount = $this->house_keeping_total_amount_generate($booking->id);
				$all_house_kipping_amount = $all_house_kipping_amount + $house_keeping_total_amount;
				$gross_amount = $room_charge + $food_order_total_amount + $bar_order_total_amount + $house_keeping_total_amount;
				$all_gross_amount = $all_gross_amount + $gross_amount;
				$bst_tax = 0;
				$service_tax = 0;
				$gst_tax = 0;
				/*if($food_order_total_amount > 0 || $bar_order_total_amount > 0 || $house_keeping_total_amount > 0)
				{
					$bst_tax = round(($gross_amount * $setting->bst_tax)/100);
					$service_tax = round(($gross_amount * $setting->service_tax)/100);
					$gst_tax = round(($gross_amount * $setting->gst_tax)/100);
				}
				else
				{*/
					if($booking->allow_bst == "Y")
					{
						$bst_tax = round(($gross_amount * $booking->bst_tax)/100);
					}
					if($booking->allow_service_charge == "Y")
					{
						$service_tax = round(($gross_amount * $booking->service_tax)/100);
					}
					if($booking->allow_gst == "Y")
					{
						$gst_tax = round(($gross_amount * $booking->gst_tax)/100);
					}
				//}
				$all_bst_tax = $all_bst_tax + $bst_tax;
				$all_service_tax = $all_service_tax + $service_tax;
				$all_gst_tax = $all_gst_tax + $gst_tax;
				$grand_total_booking_amount = $gross_amount + $bst_tax + $service_tax + $gst_tax;
				$all_grand_amount = $all_grand_amount + $grand_total_booking_amount;
				
				$booking_number = $booking->id;
				$room_number = $show_rooms;
				$customer_name = $booking->customer->full_name;
				$booking_date = date("d/m/Y",strtotime($booking->booking_date));
				$bill_number = "BILL-".date("Y",strtotime($booking->booking_date))."-".$booking->id;
				$receipt_number = "PAY-".date("Ymd",strtotime($booking->booking_date))."-".$booking->id;
				$total_bst_charge = $setting->currency.round($bst_tax)." (".$booking->bst_tax."%)";
				$grand_total = $setting->currency.round($grand_total_booking_amount);
				$data_line = $booking_number."<~@~>".$room_number."<~@~>".$customer_name."<~@~>".$booking_date."<~@~>".$bill_number."<~@~>".$receipt_number."<~@~>".$total_bst_charge."<~@~>".$grand_total;
				array_push($data_array, $data_line);
			}
			$data_array_total = "BST Report<~@~><~@~><~@~><~@~><~@~>All Total<~@~>".$setting->currency.round($all_bst_tax)."<~@~>".$setting->currency.round($all_grand_amount);
			array_push($data_array, $data_array_total);
		}

		$fp = fopen('php://output', 'w');
		foreach ( $data_array as $line ) {
			$val = explode("<~@~>", $line);
			fputcsv($fp, $val);
		}
		fclose($fp);
		exit;
	}

	public function occupancycsv($start_date = null, $end_date = null)
    {
		$this->viewBuilder()->layout('ajax');
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="room_occupancy_report_'.date("Y-m-d").'_.csv"');
		$data_array = array();
		$data_array_heading = "Room Number<~@~>Number Of Days Occupied<~@~>From Date<~@~>To Date";
		array_push($data_array, $data_array_heading);

		$start_date_occupancy = date('Y-m-01');
		$end_date_occupancy = date('Y-m-t');
		if(isset($start_date) && $start_date!="")
		{
			$start_date_occupancy = $start_date;
		}
		if(isset($end_date) && $end_date!="")
		{
			$end_date_occupancy = $end_date;
		}
		$this->loadModel('Rooms');

		$room = $this->Rooms->find('all', ['conditions' => ['Rooms.status' => "Y"]])->toArray();

		if(!empty($room))
		{
			foreach ($room as $val)
			{
				$room_number = $val->room_number;
				$total_room = $this->total_room_occupancy_generate($val->room_number, $start_date_occupancy, $end_date_occupancy);
				$data_line = $room_number."<~@~>".$total_room."<~@~>".$start_date_occupancy."<~@~>".$end_date_occupancy;
				array_push($data_array, $data_line);
			}
		}

		$fp = fopen('php://output', 'w');
		foreach ( $data_array as $line ) {
			$val = explode("<~@~>", $line);
			fputcsv($fp, $val);
		}
		fclose($fp);
		exit;
	}

	public function outstandingcsv($start_date = null, $end_date = null)
    {
		$this->viewBuilder()->layout('ajax');
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="outstanding_report_'.date("Y-m-d").'_.csv"');
		$this->Settings = TableRegistry::get('Settings');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		$data_array = array();
		$data_array_heading = "Booking Number<~@~>Room Number<~@~>Customer Name<~@~>Mobile Number<~@~>Check In<~@~>Check Out<~@~>Gross Amount<~@~>Service Charge<~@~>BST Charge<~@~>GST Charge<~@~>Grand Total<~@~>Amount Paid<~@~>Outstanding<~@~>Remarks";
		array_push($data_array, $data_array_heading);

		$start_date_outstanding = date('Y-m-01');
		$end_date_outstanding = date('Y-m-t');
		$condition['Bookings.payment_status IN'] = ["P","R"];
		if(isset($start_date) && $start_date!="")
		{
			$start_date_outstanding = $start_date;
		}
		if(isset($end_date) && $end_date!="")
		{
			$end_date_outstanding = $end_date;
		}
		$condition['Bookings.booking_date >='] = $start_date_outstanding." 00:00:00";
		$condition['Bookings.booking_date <='] = $end_date_outstanding." 23:59:59";
		$booking_outstanding = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => $condition, 'order' => 'Bookings.id DESC'])->toArray();
		$all_room_amount = 0;
		$all_food_amount = 0;
		$all_bar_amount = 0;
		$all_house_kipping_amount = 0;
		$all_gross_amount = 0;
		$all_bst_tax = 0;
		$all_service_tax = 0;
		$all_gst_tax = 0;
		$all_amount_paid = 0;
		$all_outstanding = 0;
		$all_grand_amount = 0;
		if(!empty($booking_outstanding))
		{
			foreach($booking_outstanding as $booking)
			{
				$final_tally_summery = $this->final_tally_summery_generate($booking->id); 
				$tally_summery = explode("@",$final_tally_summery);
				$amount_payble = round($tally_summery[0]);
				$amount_received = round($tally_summery[1]);
				$outstanding = round($tally_summery[2]);
				if($outstanding > 0)
				{
					$show_rooms = $this->show_rooms_generate($booking->id);
					$room_charge = round($booking->booking_price * $booking->number_of_night); 
					$all_room_amount = $all_room_amount + $room_charge;
					$food_order_total_amount = $this->food_order_total_amount_generate($booking->id);
					$all_food_amount = $all_food_amount + $food_order_total_amount;
					$bar_order_total_amount = $this->bar_order_total_amount_generate($booking->id);
					$all_bar_amount = $all_bar_amount + $bar_order_total_amount;
					$house_keeping_total_amount = $this->house_keeping_total_amount_generate($booking->id);
					$all_house_kipping_amount = $all_house_kipping_amount + $house_keeping_total_amount;
					$gross_amount = $room_charge + $food_order_total_amount + $bar_order_total_amount + $house_keeping_total_amount;
					$all_gross_amount = $all_gross_amount + $gross_amount;
					$bst_tax = 0;
					$service_tax = 0;
					$gst_tax = 0;
					$all_amount_paid = $all_amount_paid + $amount_received;
					$all_outstanding = $all_outstanding + $outstanding;
					/*if($food_order_total_amount > 0 || $bar_order_total_amount > 0 || $house_keeping_total_amount > 0)
					{
						$bst_tax = round(($gross_amount * $setting->bst_tax)/100);
						$service_tax = round(($gross_amount * $setting->service_tax)/100);
						$gst_tax = round(($gross_amount * $setting->gst_tax)/100);
					}
					else
					{*/
						if($booking->allow_bst == "Y")
						{
							$bst_tax = round(($gross_amount * $booking->bst_tax)/100);
						}
						if($booking->allow_service_charge == "Y")
						{
							$service_tax = round(($gross_amount * $booking->service_tax)/100);
						}
						if($booking->allow_gst == "Y")
						{
							$gst_tax = round(($gross_amount * $booking->gst_tax)/100);
						}
					//}
					$all_bst_tax = $all_bst_tax + $bst_tax;
					$all_service_tax = $all_service_tax + $service_tax;
					$all_gst_tax = $all_gst_tax + $gst_tax;
					$grand_total_booking_amount = $gross_amount + $bst_tax + $service_tax + $gst_tax;
					$all_grand_amount = $all_grand_amount + $grand_total_booking_amount;
					
					$booking_number = $booking->id;
					$room_number = $show_rooms;
					$customer_name = $booking->customer->full_name;
					$mobile_number = $booking->customer->mobile_number;
					$check_in = date("d/m/Y",strtotime($booking->check_in_date));
					$check_out = date("d/m/Y",strtotime($booking->check_out_date));
					$total_room_charge = $setting->currency.round($room_charge);
					$total_food_charge = $setting->currency.round($food_order_total_amount);
					$total_bar_charge = $setting->currency.round($bar_order_total_amount);
					$total_house_keeping_charge = $setting->currency.round($house_keeping_total_amount);
					$gross_amount = $setting->currency.round($gross_amount);
					$total_service_charge = $setting->currency.round($service_tax)." (".$booking->service_tax."%)";
					$total_bst_charge = $setting->currency.round($bst_tax)." (".$booking->bst_tax."%)";
					$total_gst_charge = $setting->currency.round($gst_tax)." (".$booking->gst_tax."%)";
					$grand_total = $setting->currency.round($grand_total_booking_amount);
					$amount_received = $setting->currency.round($amount_received);
					$outstanding = $setting->currency.round($outstanding);
					$booking_verified = $booking->booking_verified;
					$data_line = $booking_number."<~@~>".$room_number."<~@~>".$customer_name."<~@~>".$mobile_number."<~@~>".$check_in."<~@~>".$check_out."<~@~>".$gross_amount."<~@~>".$total_service_charge."<~@~>".$total_bst_charge."<~@~>".$total_gst_charge."<~@~>".$grand_total."<~@~>".$amount_received."<~@~>".$outstanding."<~@~>".$booking_verified;
					array_push($data_array, $data_line);
				}
			}
			$data_array_total = "Outstanding Report<~@~><~@~><~@~><~@~><~@~>All Total<~@~>".$setting->currency.round($all_gross_amount)."<~@~>".$setting->currency.round($all_service_tax)."<~@~>".$setting->currency.round($all_bst_tax)."<~@~>".$setting->currency.round($all_gst_tax)."<~@~>".$setting->currency.round($all_grand_amount)."<~@~>".$setting->currency.round($all_amount_paid)."<~@~>".$setting->currency.round($all_outstanding)."<~@~>";
			array_push($data_array, $data_array_total);
		}

		$fp = fopen('php://output', 'w');
		foreach ( $data_array as $line ) {
			$val = explode("<~@~>", $line);
			fputcsv($fp, $val);
		}
		fclose($fp);
		exit;
	}

	public function revedit($id = null)
    {
		$this->loadModel('Rooms');
		$this->loadModel('RoomCategories');
		$this->loadModel('Customers');
		$this->loadModel('BookingRoomDetails');
        $booking = $this->Bookings->get($id, [
            'contain' => ['Customers', 'BookingRoomDetails']
        ]);
		if($booking->booking_type != "R"){
			$this->Flash->error(__('You are not autorised to access this'));
			return $this->redirect(['action' => 'dashboard']);
		}
        if ($this->request->is(['patch', 'post', 'put'])) {
            $booking = $this->Bookings->patchEntity($booking, $this->request->getData());
            if ($this->Bookings->save($booking)) {
				if(isset($this->request->getData()['booking_room_name']) && $this->request->getData()['booking_room_name']!="")
				{
					foreach($this->request->getData()['booking_room_name'] as $key=>$val)
					{
						$edit_id = $this->request->getData()['edit_id'][$key];
							$bookingDetail = $this->BookingRoomDetails->get($edit_id, [
						]);
						$booking_room_name = explode("@",$val);
						$bookingdetails['booking_id'] = $id;
						$bookingdetails['booking_room_name'] = $booking_room_name[0];
						$bookingdetails['booking_room_category'] = $this->request->getData()['booking_room_category'][$key];
						$bookingdetails['booking_room_price'] = $this->request->getData()['booking_room_price'][$key];
						$bookingdetails['booking_room_discount'] = $this->request->getData()['booking_room_discount'][$key];
						$bookingdetails['room_booking_price'] = $this->request->getData()['room_booking_price'][$key];
						$bookingDetail = $this->BookingRoomDetails->patchEntity($bookingDetail, $bookingdetails);
						$this->BookingRoomDetails->save($bookingDetail);
						if($booking->booking_type == "B"){
							$this->Rooms->updateAll(['booking_id' => $id, 'room_status' => "O"], ['room_number' => $booking_room_name[0]]);
						}
					}
				}

                if($booking->booking_type == "B"){
					$this->Flash->success(__('The booking has been saved successfully'));
					return $this->redirect(['action' => 'index']);
				}else if($booking->booking_type == "R"){
					$this->Flash->success(__('The reservation has been saved successfully'));
					return $this->redirect(['action' => 'reservation']);
				}else{
					$this->Flash->success(__('The cancellation has been saved successfully'));
					return $this->redirect(['action' => 'cancellation']);
				}
            }
            $this->Flash->error(__('The booking could not be saved. Please, try again.'));
        }
		$roomCategories = $this->RoomCategories->find('all', ['conditions'=>['RoomCategories.status'=>'Y']])->toArray();
		$rooms = $this->Rooms->find('all', ['contain' => ['RoomCategories'], 'conditions' => ['Rooms.status' => 'Y', 'Rooms.room_status' => 'A'], 'order'=>'Rooms.id ASC'])->toArray();
        $customers = $this->Bookings->Customers->find('list', ['limit' => 200]);
        $this->set(compact('booking', 'customers', 'rooms', 'roomCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		$this->loadModel('Rooms');
		$this->loadModel('BookingRoomDetails');
		if($id=='' || $id==null)
		{
			return $this->redirect(['action' => 'index']);
		}
        //$this->request->allowMethod(['post', 'delete']);
		if(isset($id) && $id!=""){
			$booking_id = base64_decode($id);
		}
		$fetch_exist_chk = $this->Bookings->find('all', ['conditions' => ['Bookings.id'=>$booking_id]])->first();
		if(empty($fetch_exist_chk))
		{
			return $this->redirect(['action' => 'index']);
		}
        $booking = $this->Bookings->get($booking_id);
		if($booking->payment_status != "U"){
			$this->Flash->error(__('You are not autorised to access this'));
			return $this->redirect(['action' => 'dashboard']);
		}
		$this->Rooms->updateAll(['room_status' => "A", 'booking_id' => "0"], ['booking_id' => $booking_id]);
		$this->BookingRoomDetails->deleteAll(['booking_id' => $booking_id]);
        if ($this->Bookings->delete($booking)) {
            $this->Flash->success(__('The booking has been deleted.'));
        } else {
            $this->Flash->error(__('The booking could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
