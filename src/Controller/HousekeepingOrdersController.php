<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * HousekeepingOrders Controller
 *
 * @property \App\Model\Table\HousekeepingOrdersTable $HousekeepingOrders
 *
 * @method \App\Model\Entity\HousekeepingOrder[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HousekeepingOrdersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index($booking_id = null)
    {
        /*$this->paginate = [
            'contain' => ['Bookings', 'Rooms', 'RoomServices']
        ];
        $housekeepingOrders = $this->paginate($this->HousekeepingOrders);*/

		$housekeepingOrders = $this->HousekeepingOrders->find('all', ['contain' => ['Bookings'], 'conditions' => ['HousekeepingOrders.booking_id' => $booking_id], 'order'=>'HousekeepingOrders.id ASC'])->toArray();

        $this->set(compact('housekeepingOrders', 'booking_id'));
    }

    /**
     * View method
     *
     * @param string|null $id Housekeeping Order id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $housekeepingOrder = $this->HousekeepingOrders->get($id, [
            'contain' => ['Bookings', 'Rooms', 'RoomServices']
        ]);

        $this->set('housekeepingOrder', $housekeepingOrder);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($booking_id = null)
    {
		$this->loadModel('Rooms');
		$this->loadModel('RoomServices');
        $housekeepingOrder = "";
        if ($this->request->is('post')) {
            if(!empty($this->request->getData()['room_number']) && $this->request->getData()['room_number']!="")
			{
				foreach($this->request->getData()['room_number'] as $key=>$val)
				{
					$service_name = explode("@",$this->request->getData()['service_name'][$key]);
					$housekeepingOrder = $this->HousekeepingOrders->newEntity();
					$servicedetails['booking_id'] = $booking_id;
					$servicedetails['room_number'] = $val;
					$servicedetails['service_name'] = $service_name[0];
					$servicedetails['service_price'] = $this->request->getData()['service_price'][$key];
					$servicedetails['quantity'] = $this->request->getData()['quantity'][$key];
					$servicedetails['sub_total'] = $this->request->getData()['sub_total'][$key];
					$housekeepingOrder = $this->HousekeepingOrders->patchEntity($housekeepingOrder, $servicedetails);
					$this->HousekeepingOrders->save($housekeepingOrder);
				}
				$this->Flash->success(__('The house keeping has been saved'));

				return $this->redirect(['action' => 'index', $booking_id]);
			}
            $this->Flash->error(__('The house keeping could not be saved. Please, try again.'));
        }
		$bookings = $this->HousekeepingOrders->Bookings->find('list', ['limit' => 200]);
		$rooms = $this->Rooms->find('all', ['conditions' => ['Rooms.status' => 'Y', 'Rooms.booking_id' => $booking_id]])->toArray();
		$roomServices = $this->RoomServices->find('all', ['conditions'=>['RoomServices.status'=>'Y']])->toArray();

		/*$housekeepingOrder = $this->HousekeepingOrders->newEntity();
        if ($this->request->is('post')) {
            $housekeepingOrder = $this->HousekeepingOrders->patchEntity($housekeepingOrder, $this->request->getData());
            if ($this->HousekeepingOrders->save($housekeepingOrder)) {
                $this->Flash->success(__('The housekeeping order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The housekeeping order could not be saved. Please, try again.'));
        }*/
        //$rooms = $this->HousekeepingOrders->Rooms->find('list', ['limit' => 200]);
        //$roomServices = $this->HousekeepingOrders->RoomServices->find('list', ['limit' => 200]);
		
        $this->set(compact('housekeepingOrder', 'bookings', 'booking_id', 'rooms', 'roomServices'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Housekeeping Order id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
        $housekeepingOrder = $this->HousekeepingOrders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $housekeepingOrder = $this->HousekeepingOrders->patchEntity($housekeepingOrder, $this->request->getData());
            if ($this->HousekeepingOrders->save($housekeepingOrder)) {
                $this->Flash->success(__('The housekeeping order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The housekeeping order could not be saved. Please, try again.'));
        }
        $bookings = $this->HousekeepingOrders->Bookings->find('list', ['limit' => 200]);
        $rooms = $this->HousekeepingOrders->Rooms->find('list', ['limit' => 200]);
        $roomServices = $this->HousekeepingOrders->RoomServices->find('list', ['limit' => 200]);
        $this->set(compact('housekeepingOrder', 'bookings', 'rooms', 'roomServices'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Housekeeping Order id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $booking_id = null)
    {
		$id = base64_decode($id);
        $housekeepingOrder = $this->HousekeepingOrders->get($id);
        if ($this->HousekeepingOrders->delete($housekeepingOrder)) {
            $this->Flash->success(__('The housekeeping order has been deleted.'));
        } else {
            $this->Flash->error(__('The housekeeping order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index', $booking_id]);
    }
}
