<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BeverageCategories Controller
 *
 * @property \App\Model\Table\BeverageCategoriesTable $BeverageCategories
 *
 * @method \App\Model\Entity\BeverageCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BeverageCategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
		$this->limit_access(7);
        //$beverageCategories = $this->paginate($this->BeverageCategories);

		$beverageCategories = $this->BeverageCategories->find('all', ['conditions' => [], 'order'=>'BeverageCategories.id ASC'])->toArray();

        $this->set(compact('beverageCategories'));
    }

	public function statusupdate($id=null) {
		$this->viewBuilder()->setLayout('ajax');		
		$image1 = $this->BeverageCategories->find('all', ['conditions' => ['BeverageCategories.id' => $id]])->first();
		if(!empty($image1))
		{
			if($image1->status=='Y')
			{
				$ret_arr=$this->BeverageCategories->updateAll(['status' => 'N'], ['id' => $image1->id]);
				$data['status']='N';
			}
			else
			{
				$ret_arr=$this->BeverageCategories->updateAll(['status' => 'Y'], ['id' => $image1->id]);
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
     * @param string|null $id Beverage Category id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->limit_access(7);
        $beverageCategory = $this->BeverageCategories->get($id, [
            'contain' => ['BeverageItemDetails', 'BeverageItems']
        ]);

        $this->set('beverageCategory', $beverageCategory);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->limit_access(7);
        $beverageCategory = $this->BeverageCategories->newEntity();
        if ($this->request->is('post')) {
			$fetch_exist_chk = $this->BeverageCategories->find('all', ['conditions' => ['BeverageCategories.beverage_item_name' => $this->request->getData(['beverage_item_name'])]])->first();
			if(empty($fetch_exist_chk))
			{
				$beverageCategory = $this->BeverageCategories->patchEntity($beverageCategory, $this->request->getData());
				if ($this->BeverageCategories->save($beverageCategory)) {
					$this->Flash->success(__('The beverage category has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The beverage category could not be saved. Please, try again.'));
			}
			else
			{
				$this->Flash->error(__('This beverage category already exist'));
			}
        }
        $this->set(compact('beverageCategory'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Beverage Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->limit_access(7);
        $beverageCategory = $this->BeverageCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
			$fetch_exist_chk = $this->BeverageCategories->find('all', ['conditions' => ['BeverageCategories.beverage_item_name' => $this->request->getData(['beverage_item_name']), 'BeverageCategories.id <>' => $id]])->first();
			if(empty($fetch_exist_chk))
			{
				$beverageCategory = $this->BeverageCategories->patchEntity($beverageCategory, $this->request->getData());
				if ($this->BeverageCategories->save($beverageCategory)) {
					$this->Flash->success(__('The beverage category has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The beverage category could not be saved. Please, try again.'));
			}
			else
			{
				$this->Flash->error(__('This beverage category already exist'));
			}
        }
        $this->set(compact('beverageCategory'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Beverage Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		$this->limit_access(7);
		$this->loadModel('BeverageItems');
		if($id=='' || $id==null)
		{
			return $this->redirect(['action' => 'index']);
		}
		$fetch_exist_chk = $this->BeverageCategories->find('all', ['conditions' => ['BeverageCategories.id'=>$id]])->first();
		if(empty($fetch_exist_chk))
		{
			return $this->redirect(['action' => 'index']);
		}
        //$this->request->allowMethod(['post', 'delete']);
		$this->BeverageItems->deleteAll(['beverage_category_id' => $id]);
        $beverageCategory = $this->BeverageCategories->get($id);
        if ($this->BeverageCategories->delete($beverageCategory)) {
            $this->Flash->success(__('The beverage category has been deleted.'));
        } else {
            $this->Flash->error(__('The beverage category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
