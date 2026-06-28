<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ReservationPayments Controller
 *
 * @property \App\Model\Table\ReservationPaymentsTable $ReservationPayments
 *
 * @method \App\Model\Entity\ReservationPayment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReservationPaymentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Reservations']
        ];
        $reservationPayments = $this->paginate($this->ReservationPayments);

        $this->set(compact('reservationPayments'));
    }

    /**
     * View method
     *
     * @param string|null $id Reservation Payment id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reservationPayment = $this->ReservationPayments->get($id, [
            'contain' => ['Reservations']
        ]);

        $this->set('reservationPayment', $reservationPayment);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $reservationPayment = $this->ReservationPayments->newEntity();
        if ($this->request->is('post')) {
            $reservationPayment = $this->ReservationPayments->patchEntity($reservationPayment, $this->request->getData());
            if ($this->ReservationPayments->save($reservationPayment)) {
                $this->Flash->success(__('The reservation payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reservation payment could not be saved. Please, try again.'));
        }
        $reservations = $this->ReservationPayments->Reservations->find('list', ['limit' => 200]);
        $this->set(compact('reservationPayment', 'reservations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reservation Payment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reservationPayment = $this->ReservationPayments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reservationPayment = $this->ReservationPayments->patchEntity($reservationPayment, $this->request->getData());
            if ($this->ReservationPayments->save($reservationPayment)) {
                $this->Flash->success(__('The reservation payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reservation payment could not be saved. Please, try again.'));
        }
        $reservations = $this->ReservationPayments->Reservations->find('list', ['limit' => 200]);
        $this->set(compact('reservationPayment', 'reservations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reservation Payment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reservationPayment = $this->ReservationPayments->get($id);
        if ($this->ReservationPayments->delete($reservationPayment)) {
            $this->Flash->success(__('The reservation payment has been deleted.'));
        } else {
            $this->Flash->error(__('The reservation payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
