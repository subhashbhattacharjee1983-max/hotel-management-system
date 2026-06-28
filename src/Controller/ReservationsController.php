<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Reservations Controller
 *
 * @property \App\Model\Table\ReservationsTable $Reservations
 *
 * @method \App\Model\Entity\Reservation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReservationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
		$this->limit_access(5);
        /*$this->paginate = [
            'contain' => ['Customers']
        ];
        $reservations = $this->paginate($this->Reservations);*/

		$reservations = $this->Reservations->find('all', ['contain' => ['Customers'], 'conditions' => [], 'order'=>'Reservations.id DESC'])->toArray();

        $this->set(compact('reservations'));
    }

    /**
     * View method
     *
     * @param string|null $id Reservation id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->limit_access(5);
        $reservation = $this->Reservations->get($id, [
            'contain' => ['ReservationRoomDetails', 'Customers']
        ]);

        $this->set('reservation', $reservation);
    }

	public function reservationbill($id = null)
    {
        $reservation = $this->Reservations->get($id, [
            'contain' => ['Customers', 'ReservationRoomDetails']
        ]);

        $this->set(compact('reservation'));
    }

	public function reservationbillprint($id = null)
    {
		$this->viewBuilder()->setLayout('ajax');
        $reservation = $this->Reservations->get($id, [
            'contain' => ['Customers', 'ReservationRoomDetails']
        ]);

        $this->set(compact('reservation'));
    }

	public function addtobooking($id = null)
    {
		$this->limit_access(5);
		$this->loadModel('Bookings');
		$this->loadModel('BookingPayments');
		$this->loadModel('BookingRoomDetails');
		$this->loadModel('ReservationRoomDetails');
		$booked_by = $this->request->getSession()->read('Auth.User.name')." (".$this->account_type[$this->request->getSession()->read('Auth.User.user_type')].")";
		$reservation = $this->Reservations->get($id, [
            'contain' => ['Customers', 'ReservationRoomDetails']
        ]);
		if(!empty($reservation))
		{
			$booking = $this->Bookings->newEntity();	
			$booking = $this->Bookings->patchEntity($booking, $this->request->getData());
			$booking->customer_id = $reservation->customer_id;
			$booking->check_in_date = $reservation->check_in_date;
			$booking->check_out_date = $reservation->check_out_date;
			$booking->adults = $reservation->adults;
			$booking->children = $reservation->children;
			$booking->room_price = $reservation->room_price;
			$booking->number_of_night = $reservation->number_of_night;	
			if($reservation->paid_amount > 0)
			{
				$booking->payment_status = "R";
			}
			$booking->booking_price = $reservation->booking_price;
			$booking->room_discount = $reservation->room_discount;
			$booking->booking_package = $reservation->booking_package;
			$booking->food_plan = $reservation->food_plan;
			$booking->allow_bst = $reservation->allow_bst;
			$booking->allow_gst = $reservation->allow_gst;
			$booking->allow_service_charge = $reservation->allow_service_charge;
			$booking->allow_bank_transfer_charge = $reservation->allow_bank_transfer_charge;
			$booking->bst_tax = $reservation->bst_tax;
			$booking->gst_tax = $reservation->gst_tax;
			$booking->service_tax = $reservation->service_tax;
			$booking->bank_transfer_charge = $reservation->bank_transfer_charge;
			$booking->booking_date = $reservation->booking_date;
			$booking->booked_by = $reservation->booked_by;
			$booking_data = $this->Bookings->save($booking);
			if($booking_data) {
				if($reservation->paid_amount > 0)
				{
					$bookingPayments = $this->BookingPayments->newEntity();
					$bookingPayments = $this->BookingPayments->patchEntity($bookingPayments, $this->request->getData());
					$bookingPayments->booking_id = $booking_data->id;
					$bookingPayments->payment_price = $reservation->paid_amount;
					$bookingPayments->bill_type = "RB";
					$bookingPayments->payment_method = "UPI";
					$bookingPayments->payment_date = date("Y-m-d");
					$bookingPayments->payment_time = date("H:i:s");
					$bookingPayments_data = $this->BookingPayments->save($bookingPayments);
				}
				if(!empty($reservation))
				{
					foreach($reservation->reservation_room_details as $key=>$val)
					{
						$bookingDetail = $this->BookingRoomDetails->newEntity();
						$bookingdetails['booking_id'] = $booking_data->id;
						$bookingdetails['booking_room_name'] = "";
						$bookingdetails['booking_room_category'] = $val['reservation_room_category'];
						$bookingdetails['booking_room_price'] = $val['booking_room_price'];
						$bookingdetails['booking_room_discount'] = $val['booking_room_discount'];
						$bookingdetails['room_booking_price'] = $val['room_booking_price'];
						$bookingDetail = $this->BookingRoomDetails->patchEntity($bookingDetail, $bookingdetails);
						$this->BookingRoomDetails->save($bookingDetail);
					}
				$this->ReservationRoomDetails->deleteAll(['reservation_id' => $id]);
				$reservation_delete = $this->Reservations->get($id);
				if ($this->Reservations->delete($reservation_delete)) {
					$this->Flash->success(__('The booking has been saved successfully'));
				} else {
					$this->Flash->error(__('The booking could not be saved. Please, try again.'));
				}			

				return $this->redirect(['controller' => 'Bookings', 'action' => 'index']);
				}
			}
		}else {
			$this->Flash->error(__('The booking could not be saved. Please, try again.'));
		}
	}

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->limit_access(5);
		$this->loadModel('Rooms');
		$this->loadModel('Settings');
		$this->loadModel('RoomCategories');
		$this->loadModel('Customers');
		$this->loadModel('ReservationRoomDetails');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		$booked_by = $this->request->getSession()->read('Auth.User.name')." (".$this->account_type[$this->request->getSession()->read('Auth.User.user_type')].")";
        $reservation = $this->Reservations->newEntity();
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
            $reservation = $this->Reservations->patchEntity($reservation, $this->request->getData());
			$bst_tax = 0;
			$service_tax = 0;
			$gst_tax = 0;
			$bank_transfer_charge = 0;
			if($this->request->getData()['allow_bst'] == "Y"){
				$bst_tax = $setting->bst_tax;
			}
			if($this->request->getData()['allow_service_charge'] == "Y"){
				$service_tax = $setting->service_tax;
			}
			if($this->request->getData()['allow_gst'] == "Y"){
				$gst_tax = $setting->gst_tax;
			}
			if($this->request->getData()['allow_bank_transfer_charge'] == "Y"){
				$bank_transfer_charge = $setting->bank_transfer_charge;
			}
			$reservation->customer_id = $customer_id;
			$reservation->booking_date = date('Y-m-d H:i:s');
			$reservation->booked_by = $booked_by;
			$reservation->bst_tax = $bst_tax;
			$reservation->service_tax = $service_tax;
			$reservation->gst_tax = $gst_tax;
			$reservation->bank_transfer_charge = $bank_transfer_charge;
			$reservation_data = $this->Reservations->save($reservation);
            if ($reservation_data) {
				if(isset($this->request->getData()['reservation_room_category']) && $this->request->getData()['reservation_room_category']!="")
				{
					foreach($this->request->getData()['reservation_room_category'] as $key=>$val)
					{
						$reservationDetail = $this->ReservationRoomDetails->newEntity();
						$reservationdetails['reservation_id'] = $reservation_data->id;
						$reservationdetails['reservation_room_number'] = $this->request->getData()['reservation_room_number'][$key];
						$reservationdetails['reservation_room_category'] = $val;
						$reservationdetails['booking_room_price'] = $this->request->getData()['booking_room_price'][$key];
						$reservationdetails['booking_room_discount'] = $this->request->getData()['booking_room_discount'][$key];
						$reservationdetails['room_booking_price'] = $this->request->getData()['room_booking_price'][$key];
						$reservationDetail = $this->ReservationRoomDetails->patchEntity($reservationDetail, $reservationdetails);
						$this->ReservationRoomDetails->save($reservationDetail);
					}
				}
                $this->Flash->success(__('The reservation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reservation could not be saved. Please, try again.'));
        }
		$rooms = $this->Rooms->find('all', ['contain' => ['RoomCategories'], 'conditions' => ['Rooms.status' => 'Y'], 'order'=>'Rooms.id ASC'])->toArray();
        $roomCategories = $this->RoomCategories->find('all', ['conditions'=>['RoomCategories.status'=>'Y']])->toArray();
        $customers = $this->Reservations->Customers->find('list', ['limit' => 200]);
        $this->set(compact('reservation', 'rooms', 'customers', 'roomCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reservation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->limit_access(5);
		$this->loadModel('Rooms');
		$this->loadModel('Settings');
		$this->loadModel('RoomCategories');
		$this->loadModel('Customers');
		$this->loadModel('ReservationRoomDetails');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
        $reservation = $this->Reservations->get($id, [
            'contain' => ['Customers', 'ReservationRoomDetails']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reservation = $this->Reservations->patchEntity($reservation, $this->request->getData());
            $bst_tax = 0;
			$service_tax = 0;
			$gst_tax = 0;
			$bank_transfer_charge = 0;
			if($this->request->getData()['allow_bst'] == "Y"){
				$bst_tax = $setting->bst_tax;
			}
			if($this->request->getData()['allow_service_charge'] == "Y"){
				$service_tax = $setting->service_tax;
			}
			if($this->request->getData()['allow_gst'] == "Y"){
				$gst_tax = $setting->gst_tax;
			}
			if($this->request->getData()['allow_bank_transfer_charge'] == "Y"){
				$bank_transfer_charge = $setting->bank_transfer_charge;
			}
			$reservation->bst_tax = $bst_tax;
			$reservation->service_tax = $service_tax;
			$reservation->gst_tax = $gst_tax;
			$reservation->bank_transfer_charge = $bank_transfer_charge;
			if ($this->Reservations->save($reservation)) {
				if(isset($this->request->getData()['reservation_room_category']) && $this->request->getData()['reservation_room_category']!="")
				{
					foreach($this->request->getData()['reservation_room_category'] as $key=>$val)
					{
						$edit_id = $this->request->getData()['edit_id'][$key];
							$reservationDetail = $this->ReservationRoomDetails->get($edit_id, [
						]);
						$reservationdetails['reservation_id'] = $id;
						$reservationdetails['reservation_room_number'] = $this->request->getData()['reservation_room_number'][$key];
						$reservationdetails['reservation_room_category'] = $val;
						$reservationdetails['booking_room_price'] = $this->request->getData()['booking_room_price'][$key];
						$reservationdetails['booking_room_discount'] = $this->request->getData()['booking_room_discount'][$key];
						$reservationdetails['room_booking_price'] = $this->request->getData()['room_booking_price'][$key];
						$reservationDetail = $this->ReservationRoomDetails->patchEntity($reservationDetail, $reservationdetails);
						$this->ReservationRoomDetails->save($reservationDetail);
					}
				}
                $this->Flash->success(__('The reservation has been updated'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reservation could not be saved. Please, try again.'));
        }
		$rooms = $this->Rooms->find('all', ['contain' => ['RoomCategories'], 'conditions' => ['Rooms.status' => 'Y'], 'order'=>'Rooms.id ASC'])->toArray();
        $roomCategories = $this->RoomCategories->find('all', ['conditions'=>['RoomCategories.status'=>'Y']])->toArray();
        $customers = $this->Reservations->Customers->find('list', ['limit' => 200]);
        $this->set(compact('reservation', 'rooms', 'customers', 'roomCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reservation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		$this->limit_access(5);
		if($id=='' || $id==null)
		{
			return $this->redirect(['action' => 'index']);
		}
		if(isset($id) && $id!=""){
			$reservation_id = base64_decode($id);
		}
		$fetch_exist_chk = $this->Reservations->find('all', ['conditions' => ['Reservations.id'=>$reservation_id]])->first();
		if(empty($fetch_exist_chk))
		{
			return $this->redirect(['action' => 'index']);
		}		
        //$this->request->allowMethod(['post', 'delete']);
		$this->loadModel('ReservationRoomDetails');
		$this->ReservationRoomDetails->deleteAll(['reservation_id' => $reservation_id]);
        $reservation = $this->Reservations->get($reservation_id);
        if ($this->Reservations->delete($reservation)) {
            $this->Flash->success(__('The reservation has been deleted'));
        } else {
            $this->Flash->error(__('The reservation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
