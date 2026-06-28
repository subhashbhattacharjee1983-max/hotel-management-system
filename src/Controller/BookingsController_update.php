<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

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

	public function verify($booking_id = null)
	{
		$this->loadModel('Rooms');
		$booking_id = base64_decode($booking_id);
		$booking = $this->Bookings->find('all', ['conditions' => ['Bookings.id' => $booking_id, 'Bookings.booking_status' => "C"]])->first();
		$room_verify = $this->Rooms->find('all', ['conditions' => ['Rooms.booking_id' => $booking_id, 'Rooms.room_status' => "O"]])->first();
		if(empty($room_verify))
		{
			return $this->redirect(['controller' => 'Bookings', 'action' => 'dashboard']);
		}
		if(!empty($room_verify))
		{
			$this->Bookings->updateAll(['booking_status' => "O"], ['id' => $booking_id]);
			$this->Rooms->updateAll(['room_status' => "A"], ['booking_id' => $booking_id]);
			$this->Flash->success(__('Verify and check out process has been updated successfully'));
			return $this->redirect(['controller' => 'Bookings', 'action' => 'dashboard']);
		}
	}

	public function oldbooking()
    {
        /*$this->paginate = [
            'contain' => ['Customers']
        ];
        $bookings = $this->paginate($this->Bookings);*/

		//$bookings = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => [], 'order'=>'Bookings.id DESC'])->toArray();
		$this->Bookings = TableRegistry::get('Bookings');
		try {
			$this->paginate = [
				'limit' => 100,
				'conditions'=>['Bookings.booking_type' => "B"],
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

	public function showBooking()
	{
		$this->loadModel('BookingPayments');
		$this->loadModel('FoodItemOrders');
		$this->loadModel('BeverageItemOrders');
		$this->loadModel('HousekeepingOrders');
		$this->Settings = TableRegistry::get('Settings');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		$this->viewBuilder()->setLayout('ajax');
		$data['msg'] = "We are having some problem. Please, try again.";
		$booking_id = $this->request->getData()['booking_id'];
		if(isset($booking_id) && $booking_id!=""){
			$booking = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => ['Bookings.id' => $booking_id]])->first();
			
			$booking_price = $this->Bookings->find('all' , array('fields' => ['total_booking_price' => 'SUM(booking_price)'], 'conditions' => array("Bookings.id" => $booking_id)))->first();
			$total_booking_price = 0;
			if($booking_price->total_booking_price!=""){
				$total_booking_price = $booking_price->total_booking_price * $booking->number_of_night;
			}
			$food_item_order_price = $this->FoodItemOrders->find('all' , array('fields' => ['total_food_item_order_price' => 'SUM(sub_total)'], 'conditions' => array("FoodItemOrders.booking_id" => $booking_id, 'FoodItemOrders.is_delivered' => "Y")))->first();
			$total_food_item_order_price = 0;
			if($food_item_order_price->total_food_item_order_price!=""){
				$total_food_item_order_price = $food_item_order_price->total_food_item_order_price;
			}
			$bavarage_item_order_price = $this->BeverageItemOrders->find('all' , array('fields' => ['total_bavarage_item_order_price' => 'SUM(sub_total)'], 'conditions' => array("BeverageItemOrders.booking_id" => $booking_id, 'BeverageItemOrders.is_delivered' => "Y")))->first();
			$total_bavarage_item_order_price = 0;
			if($bavarage_item_order_price->total_bavarage_item_order_price!=""){
				$total_bavarage_item_order_price = $bavarage_item_order_price->total_bavarage_item_order_price;
			}
			$house_keeping_order_price = $this->HousekeepingOrders->find('all' , array('fields' => ['total_house_keeping_order_price' => 'SUM(sub_total)'], 'conditions' => array("HousekeepingOrders.booking_id" => $booking_id)))->first();
			$total_house_keeping_order_price = 0;
			if($house_keeping_order_price->total_house_keeping_order_price!=""){
				$total_house_keeping_order_price = $house_keeping_order_price->total_house_keeping_order_price;
			}
			$total_booking_amount = $total_booking_price + $total_food_item_order_price + $total_bavarage_item_order_price + $total_house_keeping_order_price;
			$bst_tax = 0;
			$service_tax = 0;
			if($total_food_item_order_price > 0 || $total_bavarage_item_order_price > 0 || $total_house_keeping_order_price > 0)
			{
				$bst_tax = ($total_booking_amount * $setting->bst_tax)/100;
				$service_tax = ($total_booking_amount * $setting->service_tax)/100;
			}
			else
			{
				if($booking->allow_bst == "Y")
				{
					$bst_tax = ($total_booking_amount * $setting->bst_tax)/100;
				}
				if($booking->allow_service_charge == "Y")
				{
					$service_tax = ($total_booking_amount * $setting->service_tax)/100;
				}
			}
			$grand_total_booking_amount = $total_booking_amount + $bst_tax + $service_tax;
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
				$data['room_booking_price'] = $setting->currency.number_format($total_booking_price,2);
				$data['total_food_item_order_price'] = $setting->currency.number_format($total_food_item_order_price,2);
				$data['total_bavarage_item_order_price'] = $setting->currency.number_format($total_bavarage_item_order_price,2);
				$data['total_house_keeping_order_price'] = $setting->currency.number_format($total_house_keeping_order_price,2);
				$data['total_booking_amount'] = $setting->currency.number_format($total_booking_amount,2);
				$data['bst_tax'] = $setting->currency.number_format($bst_tax,2);
				$data['service_tax'] = $setting->currency.number_format($service_tax,2);
				$data['grand_total_booking_amount'] = $setting->currency.number_format($grand_total_booking_amount,2);
				$data['total_booking_payments'] = $setting->currency.number_format($total_booking_payments,2);
				$data['remaining_amount'] = $setting->currency.number_format($remaining_amount,2);
				$view_booking = $setting->site_url."bookings/view/".$booking_id;
				$view_payment = $setting->site_url."booking-payments/index/".$booking_id;
				$add_payment = $setting->site_url."booking-payments/add/".$booking_id;
				$add_food_order = $setting->site_url."food-item-orders/add/".$booking_id;
				$add_drink_order = $setting->site_url."beverage-item-orders/add/".$booking_id;
				$add_house_keeping = $setting->site_url."housekeeping-orders/index/".$booking_id;
				$edit_booking = $setting->site_url."bookings/edit/".$booking_id;
				$verify = $setting->site_url."bookings/dashboard/".$booking_id;
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

		$this->set(compact('booking', 'foodItemOrder', 'bavarageItemOrder', 'bookingPayments', 'housekeepingOrders'));
    }

	public function dashboard($booking_id = null){
		$this->loadModel('Rooms');
		$booking_verify = [];
		$room_verify = [];
		if(isset($booking_id) && $booking_id!=""){
			$booking_verify = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => ['Bookings.id' => $booking_id]])->first();
			$room_verify = $this->Rooms->find('all', ['conditions' => ['Rooms.booking_id' => $booking_id, 'Rooms.room_status' => "O"]])->first();
		}
		$rooms = $this->Rooms->find('all', ['conditions'=>['Rooms.status'=>'Y']])->toArray();
		$this->set(compact('rooms', 'booking_id', 'booking_verify', 'room_verify'));
	}

	public function roombill($id = null)
    {
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

	public function barbill($id = null)
    {
		$this->loadModel('BeverageItemOrders');
        $booking = $this->Bookings->get($id, [
            'contain' => ['Customers', 'BookingRoomDetails']
        ]);

		$bavarageItemOrder = $this->BeverageItemOrders->find('all', ['conditions' => ['BeverageItemOrders.booking_id' => $id]])->toArray();

        $this->set(compact('booking', 'bavarageItemOrder'));
    }

	public function masterbill($id = null)
    {
		$this->loadModel('FoodItemOrders');
		$this->loadModel('BeverageItemOrders');
		$this->loadModel('HousekeepingOrders');
        $booking = $this->Bookings->get($id, [
            'contain' => ['Customers', 'BookingRoomDetails']
        ]);

		$foodItemOrder = $this->FoodItemOrders->find('all', ['conditions' => ['FoodItemOrders.booking_id' => $id, 'FoodItemOrders.is_delivered' => "Y"]])->toArray();
		$bavarageItemOrder = $this->BeverageItemOrders->find('all', ['conditions' => ['BeverageItemOrders.booking_id' => $id, 'BeverageItemOrders.is_delivered' => "Y"]])->toArray();
		$housekeepingOrders = $this->HousekeepingOrders->find('all', ['conditions' => ['HousekeepingOrders.booking_id' => $id]])->toArray();

        $this->set(compact('booking', 'foodItemOrder', 'bavarageItemOrder', 'housekeepingOrders'));
    }

	public function masterbillprint($id = null)
    {
		$this->viewBuilder()->setLayout('ajax');
		$this->loadModel('FoodItemOrders');
		$this->loadModel('BeverageItemOrders');
		$this->loadModel('HousekeepingOrders');
        $booking = $this->Bookings->get($id, [
            'contain' => ['Customers', 'BookingRoomDetails']
        ]);

		$foodItemOrder = $this->FoodItemOrders->find('all', ['conditions' => ['FoodItemOrders.booking_id' => $id, 'FoodItemOrders.is_delivered' => "Y"]])->toArray();
		$bavarageItemOrder = $this->BeverageItemOrders->find('all', ['conditions' => ['BeverageItemOrders.booking_id' => $id, 'BeverageItemOrders.is_delivered' => "Y"]])->toArray();
		$housekeepingOrders = $this->HousekeepingOrders->find('all', ['conditions' => ['HousekeepingOrders.booking_id' => $id]])->toArray();

        $this->set(compact('booking', 'foodItemOrder', 'bavarageItemOrder', 'housekeepingOrders'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($room_id = null)
    {
		$this->loadModel('Rooms');
		$this->loadModel('Customers');
		$this->loadModel('RoomCategories');
		$this->loadModel('BookingRoomDetails');
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
			$booking->customer_id = $customer_id;
			$booking->booking_date = date('Y-m-d H:i:s');
			$booking->booked_by = $booked_by;			
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
		$this->loadModel('RoomCategories');
		$this->loadModel('Customers');
		$this->loadModel('BookingRoomDetails');
        $booking = $this->Bookings->get($id, [
            'contain' => ['Customers', 'BookingRoomDetails']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
			$fetch_exist_chk = $this->Customers->find('all', ['conditions' => ['Customers.mobile_number' => $this->request->getData(['mobile_number'])]])->first();
			if(empty($fetch_exist_chk))
			{
				$customers = $this->Customers->newEntity();
				$customers = $this->Customers->patchEntity($customers, $this->request->getData());
				$customer = $this->Customers->save($customers);
				$booking->customer_id = $customer->id;
			}
			else
			{
				$customers = $this->Customers->get($fetch_exist_chk->id, [
					'contain' => []
				]);
				$customers = $this->Customers->patchEntity($customers, $this->request->getData());
				$customer = $this->Customers->save($customers);
				$booking->customer_id = $fetch_exist_chk->id;
			}			
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
				}else{
					$this->Flash->success(__('The reservation has been saved successfully'));
					return $this->redirect(['action' => 'reservation']);
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
    /*public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $booking = $this->Bookings->get($id);
        if ($this->Bookings->delete($booking)) {
            $this->Flash->success(__('The booking has been deleted.'));
        } else {
            $this->Flash->error(__('The booking could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }*/
}
