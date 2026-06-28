<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RefundPayments Controller
 *
 * @property \App\Model\Table\RefundPaymentsTable $RefundPayments
 *
 * @method \App\Model\Entity\RefundPayment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RefundPaymentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index($booking_id = null)
    {
        /*$this->paginate = [
            'contain' => ['Bookings', 'Customers']
        ];

        $refundPayments = $this->paginate($this->RefundPayments);*/
		
		$this->loadModel('Bookings');
		$booking = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => ['Bookings.id' => $booking_id]])->first();
		$refundPayments = $this->RefundPayments->find('all', ['contain' => ['Bookings', 'Customers'], 'conditions' => ['RefundPayments.booking_id' => $booking_id], 'order'=>'RefundPayments.id DESC'])->toArray();

        $this->set(compact('refundPayments', 'booking_id', 'booking'));
    }

    /**
     * View method
     *
     * @param string|null $id Refund Payment id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function view($id = null)
    {
        $refundPayment = $this->RefundPayments->get($id, [
            'contain' => ['Bookings', 'Customers']
        ]);

        $this->set('refundPayment', $refundPayment);
    }*/

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($booking_id = null)
    {
		$this->loadModel('Bookings');
		$booking = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => ['Bookings.id' => $booking_id]])->first();
        $refundPayment = $this->RefundPayments->newEntity();
        if ($this->request->is('post')) {
			$refundPayment->booking_id = $booking_id;
			$refundPayment->customer_id = $booking->customer_id;
            $refundPayment = $this->RefundPayments->patchEntity($refundPayment, $this->request->getData());
            if ($this->RefundPayments->save($refundPayment)) {
				$this->Bookings->updateAll(['payment_status' => "P"], ['id' => $booking_id]);
                $this->Flash->success(__('The refund payment has been saved.'));

                return $this->redirect(['controller' => 'Bookings', 'action' => 'cancellation']);
            }
            $this->Flash->error(__('The refund payment could not be saved. Please, try again.'));
        }
        //$bookings = $this->RefundPayments->Bookings->find('list', ['limit' => 200]);
        $customers = $this->RefundPayments->Customers->find('list', ['limit' => 200]);
        $this->set(compact('refundPayment', 'booking', 'booking_id', 'customers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Refund Payment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
        $refundPayment = $this->RefundPayments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $refundPayment = $this->RefundPayments->patchEntity($refundPayment, $this->request->getData());
            if ($this->RefundPayments->save($refundPayment)) {
                $this->Flash->success(__('The refund payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The refund payment could not be saved. Please, try again.'));
        }
        $bookings = $this->RefundPayments->Bookings->find('list', ['limit' => 200]);
        $customers = $this->RefundPayments->Customers->find('list', ['limit' => 200]);
        $this->set(compact('refundPayment', 'bookings', 'customers'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Refund Payment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $refundPayment = $this->RefundPayments->get($id);
        if ($this->RefundPayments->delete($refundPayment)) {
            $this->Flash->success(__('The refund payment has been deleted.'));
        } else {
            $this->Flash->error(__('The refund payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }*/
}
