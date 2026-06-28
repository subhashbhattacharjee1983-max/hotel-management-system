<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BeverageItems Controller
 *
 * @property \App\Model\Table\BeverageItemsTable $BeverageItems
 *
 * @method \App\Model\Entity\BeverageItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BeverageItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
		$this->limit_access(7);
        /*$this->paginate = [
            'contain' => ['BeverageCategories']
        ];
        $beverageItems = $this->paginate($this->BeverageItems);*/

		$beverageItems = $this->BeverageItems->find('all', ['contain' => ['BeverageCategories'], 'conditions' => [], 'order'=>'BeverageItems.id ASC'])->toArray();

        $this->set(compact('beverageItems'));
    }

	public function statusupdate($id=null) {
		$this->viewBuilder()->setLayout('ajax');		
		$image1 = $this->BeverageItems->find('all', ['conditions' => ['BeverageItems.id' => $id]])->first();
		if(!empty($image1))
		{
			if($image1->status=='Y')
			{
				$ret_arr=$this->BeverageItems->updateAll(['status' => 'N'], ['id' => $image1->id]);
				$data['status']='N';
			}
			else
			{
				$ret_arr=$this->BeverageItems->updateAll(['status' => 'Y'], ['id' => $image1->id]);
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
     * @param string|null $id Beverage Item id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->limit_access(7);
        $beverageItem = $this->BeverageItems->get($id, [
            'contain' => ['BeverageCategories', 'BeverageItemDetails']
        ]);

        $this->set('beverageItem', $beverageItem);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->limit_access(7);
        $beverageItem = $this->BeverageItems->newEntity();
        if ($this->request->is('post')) {
			$fetch_exist_chk = $this->BeverageItems->find('all', ['conditions' => ['BeverageItems.beverage_item_name' => $this->request->getData(['beverage_item_name'])]])->first();
			if(empty($fetch_exist_chk))
			{
				$beverageItem = $this->BeverageItems->patchEntity($beverageItem, $this->request->getData());
				if ($this->BeverageItems->save($beverageItem)) {
					$this->Flash->success(__('The beverage item has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The beverage item could not be saved. Please, try again.'));
			}
			else
			{
				$this->Flash->error(__('This beverage item already exist'));
			}
        }
		$beverageCategories = $this->BeverageItems->BeverageCategories->find('list', ['conditions'=>['BeverageCategories.status'=>'Y'], 'keyField' => 'id','valueField' => 'beverage_item_name']);
        $this->set(compact('beverageItem', 'beverageCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Beverage Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->limit_access(7);
        $beverageItem = $this->BeverageItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
			$fetch_exist_chk = $this->BeverageItems->find('all', ['conditions' => ['BeverageItems.beverage_item_name' => $this->request->getData(['beverage_item_name']), 'BeverageItems.id <>' => $id]])->first();
			if(empty($fetch_exist_chk))
			{
				$beverageItem = $this->BeverageItems->patchEntity($beverageItem, $this->request->getData());
				if ($this->BeverageItems->save($beverageItem)) {
					$this->Flash->success(__('The beverage item has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The beverage item could not be saved. Please, try again.'));
			}
			else
			{
				$this->Flash->error(__('This beverage item already exist'));
			}
        }
        $beverageCategories = $this->BeverageItems->BeverageCategories->find('list', ['conditions'=>['BeverageCategories.status'=>'Y'], 'keyField' => 'id','valueField' => 'beverage_item_name']);
        $this->set(compact('beverageItem', 'beverageCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Beverage Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		$this->limit_access(7);
		if($id=='' || $id==null)
		{
			return $this->redirect(['action' => 'index']);
		}
		$fetch_exist_chk = $this->BeverageItems->find('all', ['conditions' => ['BeverageItems.id'=>$id]])->first();
		if(empty($fetch_exist_chk))
		{
			return $this->redirect(['action' => 'index']);
		}
        //$this->request->allowMethod(['post', 'delete']);
        $beverageItem = $this->BeverageItems->get($id);
        if ($this->BeverageItems->delete($beverageItem)) {
            $this->Flash->success(__('The beverage item has been deleted.'));
        } else {
            $this->Flash->error(__('The beverage item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
