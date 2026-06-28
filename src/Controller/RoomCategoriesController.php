<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RoomCategories Controller
 *
 * @property \App\Model\Table\RoomCategoriesTable $RoomCategories
 *
 * @method \App\Model\Entity\RoomCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoomCategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
		$this->limit_access(2);
        //$roomCategories = $this->paginate($this->RoomCategories);

		$roomCategories = $this->RoomCategories->find('all', ['conditions' => [], 'order'=>'RoomCategories.id ASC'])->toArray();

        $this->set(compact('roomCategories'));
    }

	public function statusupdate($id=null) {
		$this->viewBuilder()->setLayout('ajax');		
		$image1 = $this->RoomCategories->find('all', ['conditions' => ['RoomCategories.id' => $id]])->first();
		if(!empty($image1))
		{
			if($image1->status=='Y')
			{
				$ret_arr=$this->RoomCategories->updateAll(['status' => 'N'], ['id' => $image1->id]);
				$data['status']='N';
			}
			else
			{
				$ret_arr=$this->RoomCategories->updateAll(['status' => 'Y'], ['id' => $image1->id]);
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
     * @param string|null $id Room Category id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->limit_access(2);
        $roomCategory = $this->RoomCategories->get($id, [
            'contain' => ['Reservations', 'Rooms']
        ]);

        $this->set('roomCategory', $roomCategory);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->limit_access(2);
        $roomCategory = $this->RoomCategories->newEntity();
        if ($this->request->is('post')) {
			$fetch_exist_chk = $this->RoomCategories->find('all', ['conditions' => ['RoomCategories.room_category_name' => $this->request->getData(['room_category_name'])]])->first();
			if(empty($fetch_exist_chk))
			{
				$roomCategory = $this->RoomCategories->patchEntity($roomCategory, $this->request->getData());
				if ($this->RoomCategories->save($roomCategory)) {
					$this->Flash->success(__('The room category has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The room category could not be saved. Please, try again.'));
			}
			else
			{
				$this->Flash->error(__('This room category already exist'));
			}
        }
        $this->set(compact('roomCategory'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Room Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->limit_access(2);
        $roomCategory = $this->RoomCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
			$fetch_exist_chk = $this->RoomCategories->find('all', ['conditions' => ['RoomCategories.room_category_name' => $this->request->getData(['room_category_name']), 'RoomCategories.id <>' => $id]])->first();
			if(empty($fetch_exist_chk))
			{
				$roomCategory = $this->RoomCategories->patchEntity($roomCategory, $this->request->getData());
				if ($this->RoomCategories->save($roomCategory)) {
					$this->Flash->success(__('The room category has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The room category could not be saved. Please, try again.'));
			}
			else
			{
				$this->Flash->error(__('This room category already exist'));
			}
        }
        $this->set(compact('roomCategory'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Room Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		$this->limit_access(2);
		$this->loadModel('Rooms');
		if($id=='' || $id==null)
		{
			return $this->redirect(['action' => 'index']);
		}
		$fetch_exist_chk = $this->RoomCategories->find('all', ['conditions' => ['RoomCategories.id'=>$id]])->first();
		if(empty($fetch_exist_chk))
		{
			return $this->redirect(['action' => 'index']);
		} 
        //$this->request->allowMethod(['post', 'delete']);
        $roomCategory = $this->RoomCategories->get($id);
		$this->Rooms->deleteAll(['room_category_id' => $id]);
        if ($this->RoomCategories->delete($roomCategory)) {
            $this->Flash->success(__('The room category has been deleted.'));
        } else {
            $this->Flash->error(__('The room category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
