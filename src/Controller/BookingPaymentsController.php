<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BookingPayments Controller
 *
 * @property \App\Model\Table\BookingPaymentsTable $BookingPayments
 *
 * @method \App\Model\Entity\BookingPayment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BookingPaymentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index($booking_id = null)
    {
        /*$this->paginate = [
            'contain' => ['Bookings']
        ];
        $bookingPayments = $this->paginate($this->BookingPayments);*/

		$bookingPayments = $this->BookingPayments->find('all', ['contain' => ['Bookings'], 'conditions' => ['BookingPayments.booking_id' => $booking_id], 'order'=>'BookingPayments.id DESC'])->toArray();

        $this->set(compact('bookingPayments', 'booking_id'));
    }

    /**
     * View method
     *
     * @param string|null $id Booking Payment id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function view($id = null)
    {
        $bookingPayment = $this->BookingPayments->get($id, [
            'contain' => ['Bookings']
        ]);

        $this->set('bookingPayment', $bookingPayment);
    }*/

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($booking_id = null)
    {
		$this->loadModel('Bookings');
		$this->loadModel('FoodItemOrders');
		$this->loadModel('BeverageItemOrders');
		$booking = $this->Bookings->find('all', ['conditions' => ['Bookings.id' => $booking_id]])->first();
		$booking_payment = $this->payment_for_booking($booking_id);
        $bookingPayment = $this->BookingPayments->newEntity();
        if ($this->request->is('post')) {
            $bookingPayment = $this->BookingPayments->patchEntity($bookingPayment, $this->request->getData());
			$payment_price = $this->request->getData()['payment_price'];
			//echo "PAYMENT_PRICE ".$payment_price;
			$remaining_payment = $booking_payment - $payment_price;
			//echo "REMAINING_PAYMENT ".$remaining_payment;
			//exit;
			if($payment_price <= $booking_payment)
			{
				if($remaining_payment == 0)
				{
					$this->Bookings->updateAll(['payment_status' => "P"], ['id' => $booking_id]);
					$foodItemOrders = $this->FoodItemOrders->find('all', ['conditions' => ['FoodItemOrders.booking_id' => $booking_id], 'order'=>'FoodItemOrders.id ASC'])->toArray();
					if(!empty($foodItemOrders)){
						foreach($foodItemOrders as $fval){
							$this->FoodItemOrders->updateAll(['is_payment' => "P"], ['id' => $fval->id]);
						}
					}
					$beverageItemOrders = $this->BeverageItemOrders->find('all', ['conditions' => ['BeverageItemOrders.booking_id' => $booking_id], 'order'=>'BeverageItemOrders.id ASC'])->toArray();
					if(!empty($beverageItemOrders)){
						foreach($beverageItemOrders as $bval){
							$this->BeverageItemOrders->updateAll(['is_payment' => "P"], ['id' => $bval->id]);
						}
					}
				}
				else
				{
					$this->Bookings->updateAll(['payment_status' => "R"], ['id' => $booking_id]);
					$foodItemOrders = $this->FoodItemOrders->find('all', ['conditions' => ['FoodItemOrders.booking_id' => $booking_id], 'order'=>'FoodItemOrders.id ASC'])->toArray();
					if(!empty($foodItemOrders)){
						foreach($foodItemOrders as $fval){
							$this->FoodItemOrders->updateAll(['is_payment' => "R"], ['id' => $fval->id]);
						}
					}
					$beverageItemOrders = $this->BeverageItemOrders->find('all', ['conditions' => ['BeverageItemOrders.booking_id' => $booking_id], 'order'=>'BeverageItemOrders.id ASC'])->toArray();
					if(!empty($beverageItemOrders)){
						foreach($beverageItemOrders as $bval){
							$this->BeverageItemOrders->updateAll(['is_payment' => "R"], ['id' => $bval->id]);
						}
					}
				}
				$bookingPayment->booking_id = $booking_id;
				if ($this->BookingPayments->save($bookingPayment)) {
					$this->Flash->success(__('The booking payment has been updated'));

					if($remaining_payment == 0)
					{
						if($booking->booking_status!="O")
						{
							return $this->redirect(['controller' => 'Bookings', 'action' => 'index']);
						}
						else
						{
							return $this->redirect(['controller' => 'Bookings', 'action' => 'oldbooking']);
						}
					}
					else
					{
						return $this->redirect(['action' => 'index', $booking_id]);
					}
				}
			}
			else
			{
				$this->Flash->error(__('The payment price has greater than remaining price'));
			}
            //$this->Flash->error(__('The booking payment could not be saved. Please, try again.'));
        }
		$bookingPayments = $this->BookingPayments->find('all', ['conditions' => ['BookingPayments.booking_id' => $booking_id], 'order'=>'BookingPayments.id DESC'])->toArray();
        $bookings = $this->BookingPayments->Bookings->find('list', ['limit' => 200]);
        $this->set(compact('bookingPayment', 'bookings', 'booking_id', 'booking_payment', 'bookingPayments'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Booking Payment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null, $booking_id = null)
    {
        $bookingPayment = $this->BookingPayments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bookingPayment = $this->BookingPayments->patchEntity($bookingPayment, $this->request->getData());
			$bookingPayment->booking_id = $booking_id;
            if ($this->BookingPayments->save($bookingPayment)) {
                $this->Flash->success(__('The booking payment has been saved.'));

                return $this->redirect(['action' => 'index', $booking_id]);
            }
            $this->Flash->error(__('The booking payment could not be saved. Please, try again.'));
        }
        $bookings = $this->BookingPayments->Bookings->find('list', ['limit' => 200]);
        $this->set(compact('bookingPayment', 'bookings', 'booking_id'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Booking Payment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bookingPayment = $this->BookingPayments->get($id);
        if ($this->BookingPayments->delete($bookingPayment)) {
            $this->Flash->success(__('The booking payment has been deleted.'));
        } else {
            $this->Flash->error(__('The booking payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }*/
}
