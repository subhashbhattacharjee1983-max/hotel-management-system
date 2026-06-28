<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ServiceCategories Controller
 *
 * @property \App\Model\Table\ServiceCategoriesTable $ServiceCategories
 *
 * @method \App\Model\Entity\ServiceCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ServiceCategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
		$this->limit_access(3);
        //$serviceCategories = $this->paginate($this->ServiceCategories);

		$serviceCategories = $this->ServiceCategories->find('all', ['conditions' => [], 'order'=>'ServiceCategories.id ASC'])->toArray();

        $this->set(compact('serviceCategories'));
    }

	public function statusupdate($id=null) {
		$this->viewBuilder()->setLayout('ajax');		
		$image1 = $this->ServiceCategories->find('all', ['conditions' => ['ServiceCategories.id' => $id]])->first();
		if(!empty($image1))
		{
			if($image1->status=='Y')
			{
				$ret_arr=$this->ServiceCategories->updateAll(['status' => 'N'], ['id' => $image1->id]);
				$data['status']='N';
			}
			else
			{
				$ret_arr=$this->ServiceCategories->updateAll(['status' => 'Y'], ['id' => $image1->id]);
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
     * @param string|null $id Service Category id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->limit_access(3);
        $serviceCategory = $this->ServiceCategories->get($id, [
            'contain' => ['RoomServices']
        ]);

        $this->set('serviceCategory', $serviceCategory);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->limit_access(3);
        $serviceCategory = $this->ServiceCategories->newEntity();
        if ($this->request->is('post')) {
			$fetch_exist_chk = $this->ServiceCategories->find('all', ['conditions' => ['ServiceCategories.category_name' => $this->request->getData(['category_name'])]])->first();
			if(empty($fetch_exist_chk))
			{
				$serviceCategory = $this->ServiceCategories->patchEntity($serviceCategory, $this->request->getData());
				if ($this->ServiceCategories->save($serviceCategory)) {
					$this->Flash->success(__('The service category has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The service category could not be saved. Please, try again.'));
			}
			else
			{
				$this->Flash->error(__('This category already exist'));
			}
        }
        $this->set(compact('serviceCategory'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Service Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->limit_access(3);
        $serviceCategory = $this->ServiceCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
			$fetch_exist_chk = $this->ServiceCategories->find('all', ['conditions' => ['ServiceCategories.category_name' => $this->request->getData(['category_name']), 'ServiceCategories.id <>' => $id]])->first();
			if(empty($fetch_exist_chk))
			{
				$serviceCategory = $this->ServiceCategories->patchEntity($serviceCategory, $this->request->getData());
				if ($this->ServiceCategories->save($serviceCategory)) {
					$this->Flash->success(__('The service category has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The service category could not be saved. Please, try again.'));
			}
			else
			{
				$this->Flash->error(__('This category already exist'));
			}
        }
        $this->set(compact('serviceCategory'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Service Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		$this->limit_access(3);
		$this->loadModel('RoomServices');
		if($id=='' || $id==null)
		{
			return $this->redirect(['action' => 'index']);
		}
		$fetch_exist_chk = $this->ServiceCategories->find('all', ['conditions' => ['ServiceCategories.id'=>$id]])->first();
		if(empty($fetch_exist_chk))
		{
			return $this->redirect(['action' => 'index']);
		}
        //$this->request->allowMethod(['post', 'delete']);
		$this->RoomServices->deleteAll(['service_category_id' => $id]);
        $serviceCategory = $this->ServiceCategories->get($id);
        if ($this->ServiceCategories->delete($serviceCategory)) {
            $this->Flash->success(__('The service category has been deleted.'));
        } else {
            $this->Flash->error(__('The service category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
