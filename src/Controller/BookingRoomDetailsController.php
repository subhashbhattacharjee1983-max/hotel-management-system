<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BookingRoomDetails Controller
 *
 * @property \App\Model\Table\BookingRoomDetailsTable $BookingRoomDetails
 *
 * @method \App\Model\Entity\BookingRoomDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BookingRoomDetailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Bookings']
        ];
        $bookingRoomDetails = $this->paginate($this->BookingRoomDetails);

        $this->set(compact('bookingRoomDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Booking Room Detail id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bookingRoomDetail = $this->BookingRoomDetails->get($id, [
            'contain' => ['Bookings']
        ]);

        $this->set('bookingRoomDetail', $bookingRoomDetail);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bookingRoomDetail = $this->BookingRoomDetails->newEntity();
        if ($this->request->is('post')) {
            $bookingRoomDetail = $this->BookingRoomDetails->patchEntity($bookingRoomDetail, $this->request->getData());
            if ($this->BookingRoomDetails->save($bookingRoomDetail)) {
                $this->Flash->success(__('The booking room detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The booking room detail could not be saved. Please, try again.'));
        }
        $bookings = $this->BookingRoomDetails->Bookings->find('list', ['limit' => 200]);
        $this->set(compact('bookingRoomDetail', 'bookings'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Booking Room Detail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bookingRoomDetail = $this->BookingRoomDetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bookingRoomDetail = $this->BookingRoomDetails->patchEntity($bookingRoomDetail, $this->request->getData());
            if ($this->BookingRoomDetails->save($bookingRoomDetail)) {
                $this->Flash->success(__('The booking room detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The booking room detail could not be saved. Please, try again.'));
        }
        $bookings = $this->BookingRoomDetails->Bookings->find('list', ['limit' => 200]);
        $this->set(compact('bookingRoomDetail', 'bookings'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Booking Room Detail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bookingRoomDetail = $this->BookingRoomDetails->get($id);
        if ($this->BookingRoomDetails->delete($bookingRoomDetail)) {
            $this->Flash->success(__('The booking room detail has been deleted.'));
        } else {
            $this->Flash->error(__('The booking room detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
