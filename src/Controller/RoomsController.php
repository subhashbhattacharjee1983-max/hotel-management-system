<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Rooms Controller
 *
 * @property \App\Model\Table\RoomsTable $Rooms
 *
 * @method \App\Model\Entity\Room[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoomsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
		$this->limit_access(2);
        /*$this->paginate = [
            'contain' => ['RoomCategories']
        ];
        $rooms = $this->paginate($this->Rooms);*/
		$rooms = $this->Rooms->find('all', ['contain' => ['RoomCategories'], 'conditions' => [], 'order'=>'Rooms.id ASC'])->toArray();

        $this->set(compact('rooms'));
    }

	public function statusupdate($id=null) {
		$this->viewBuilder()->setLayout('ajax');		
		$image1 = $this->Rooms->find('all', ['conditions' => ['Rooms.id' => $id]])->first();
		if(!empty($image1))
		{
			if($image1->status=='Y')
			{
				$ret_arr=$this->Rooms->updateAll(['status' => 'N'], ['id' => $image1->id]);
				$data['status']='N';
			}
			else
			{
				$ret_arr=$this->Rooms->updateAll(['status' => 'Y'], ['id' => $image1->id]);
				$data['status']='Y';
			}
			if ($ret_arr) {
					$data['msg']='success';
					$data['success']='The status has been updated successfully.';
			} else {
				$data['msg']='We are having some problem. Plese try later.';
			}
		} else {
			$data['msg']="The image could not be deleted. Please, try again.";
		}
		echo json_encode($data);
		exit;
	}

    /**
     * View method
     *
     * @param string|null $id Room id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->limit_access(2);
        $room = $this->Rooms->get($id, [
            'contain' => ['RoomCategories', 'HousekeepingOrders']
        ]);

        $this->set('room', $room);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->limit_access(2);
        $room = $this->Rooms->newEntity();
        if ($this->request->is('post')) {
			$fetch_exist_chk = $this->Rooms->find('all', ['conditions' => ['Rooms.room_number' => $this->request->getData(['room_number'])]])->first();
			if(empty($fetch_exist_chk))
			{
				$room = $this->Rooms->patchEntity($room, $this->request->getData());
				if ($this->Rooms->save($room)) {
					$this->Flash->success(__('The room has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The room could not be saved. Please, try again.'));
			}
			else
			{
				$this->Flash->error(__('This room number already exist'));
			}
        }
		$roomCategories = $this->Rooms->RoomCategories->find('all', ['conditions'=>['RoomCategories.status'=>'Y']])->toArray();
        $this->set(compact('room', 'roomCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Room id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->limit_access(2);
        $room = $this->Rooms->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
			$fetch_exist_chk = $this->Rooms->find('all', ['conditions' => ['Rooms.room_number' => $this->request->getData(['room_number']), 'Rooms.id <>' => $id]])->first();
			if(empty($fetch_exist_chk))
			{
				$room = $this->Rooms->patchEntity($room, $this->request->getData());
				if ($this->Rooms->save($room)) {
					$this->Flash->success(__('The room has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The room could not be saved. Please, try again.'));
			}
			else
			{
				$this->Flash->error(__('This room number already exist'));
			}
        }
        $roomCategories = $this->Rooms->RoomCategories->find('all', ['conditions'=>['RoomCategories.status'=>'Y']])->toArray();
        $this->set(compact('room', 'roomCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Room id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		$this->limit_access(2);
		if($id=='' || $id==null)
		{
			return $this->redirect(['action' => 'index']);
		}
		$fetch_exist_chk = $this->Rooms->find('all', ['conditions' => ['Rooms.id'=>$id]])->first();
		if(empty($fetch_exist_chk))
		{
			return $this->redirect(['action' => 'index']);
		} 
        //$this->request->allowMethod(['post', 'delete']);
        $room = $this->Rooms->get($id);
        if ($this->Rooms->delete($room)) {
            $this->Flash->success(__('The room has been deleted.'));
        } else {
            $this->Flash->error(__('The room could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
