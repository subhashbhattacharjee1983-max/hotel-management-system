<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RoomServices Controller
 *
 * @property \App\Model\Table\RoomServicesTable $RoomServices
 *
 * @method \App\Model\Entity\RoomService[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoomServicesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
		$this->limit_access(3);
        /*$this->paginate = [
            'contain' => ['ServiceCategories']
        ];
        $roomServices = $this->paginate($this->RoomServices);*/

		$roomServices = $this->RoomServices->find('all', ['contain' => ['ServiceCategories'], 'conditions' => [], 'order'=>'RoomServices.id ASC'])->toArray();

        $this->set(compact('roomServices'));
    }

	public function statusupdate($id=null) {
		$this->viewBuilder()->setLayout('ajax');		
		$image1 = $this->RoomServices->find('all', ['conditions' => ['RoomServices.id' => $id]])->first();
		if(!empty($image1))
		{
			if($image1->status=='Y')
			{
				$ret_arr=$this->RoomServices->updateAll(['status' => 'N'], ['id' => $image1->id]);
				$data['status']='N';
			}
			else
			{
				$ret_arr=$this->RoomServices->updateAll(['status' => 'Y'], ['id' => $image1->id]);
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
     * @param string|null $id Room Service id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->limit_access(3);
        $roomService = $this->RoomServices->get($id, [
            'contain' => ['ServiceCategories', 'HousekeepingOrders']
        ]);

        $this->set('roomService', $roomService);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->limit_access(3);
        $roomService = $this->RoomServices->newEntity();
        if ($this->request->is('post')) {
			$fetch_exist_chk = $this->RoomServices->find('all', ['conditions' => ['RoomServices.service_name' => $this->request->getData(['service_name'])]])->first();
			if(empty($fetch_exist_chk))
			{
				$roomService = $this->RoomServices->patchEntity($roomService, $this->request->getData());
				if ($this->RoomServices->save($roomService)) {
					$this->Flash->success(__('The room service has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The room service could not be saved. Please, try again.'));
			}
			else
			{
				$this->Flash->error(__('This service already exist'));
			}
        }
		$serviceCategories = $this->RoomServices->ServiceCategories->find('list', ['conditions'=>['ServiceCategories.status'=>'Y'], 'keyField' => 'id','valueField' => 'category_name']);
        $this->set(compact('roomService', 'serviceCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Room Service id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->limit_access(3);
        $roomService = $this->RoomServices->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
			$fetch_exist_chk = $this->RoomServices->find('all', ['conditions' => ['RoomServices.service_name' => $this->request->getData(['service_name']), 'RoomServices.id <>' => $id]])->first();
			if(empty($fetch_exist_chk))
			{
				$roomService = $this->RoomServices->patchEntity($roomService, $this->request->getData());
				if ($this->RoomServices->save($roomService)) {
					$this->Flash->success(__('The room service has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The room service could not be saved. Please, try again.'));
			}
			else
			{
				$this->Flash->error(__('This service already exist'));
			}
        }
        $serviceCategories = $this->RoomServices->ServiceCategories->find('list', ['conditions'=>['ServiceCategories.status'=>'Y'], 'keyField' => 'id','valueField' => 'category_name']);
        $this->set(compact('roomService', 'serviceCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Room Service id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		$this->limit_access(3);
		if($id=='' || $id==null)
		{
			return $this->redirect(['action' => 'index']);
		}
		$fetch_exist_chk = $this->RoomServices->find('all', ['conditions' => ['RoomServices.id'=>$id]])->first();
		if(empty($fetch_exist_chk))
		{
			return $this->redirect(['action' => 'index']);
		}
        //$this->request->allowMethod(['post', 'delete']);
        $roomService = $this->RoomServices->get($id);
        if ($this->RoomServices->delete($roomService)) {
            $this->Flash->success(__('The room service has been deleted.'));
        } else {
            $this->Flash->error(__('The room service could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
