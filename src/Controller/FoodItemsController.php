<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FoodItems Controller
 *
 * @property \App\Model\Table\FoodItemsTable $FoodItems
 *
 * @method \App\Model\Entity\FoodItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FoodItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
		$this->limit_access(6);
        /*$this->paginate = [
            'contain' => ['FoodCategories']
        ];
        $foodItems = $this->paginate($this->FoodItems);*/

		$foodItems = $this->FoodItems->find('all', ['contain' => ['FoodCategories'], 'conditions' => [], 'order'=>'FoodItems.id ASC'])->toArray();

        $this->set(compact('foodItems'));
    }

	public function statusupdate($id=null) {
		$this->viewBuilder()->setLayout('ajax');		
		$image1 = $this->FoodItems->find('all', ['conditions' => ['FoodItems.id' => $id]])->first();
		if(!empty($image1))
		{
			if($image1->status=='Y')
			{
				$ret_arr=$this->FoodItems->updateAll(['status' => 'N'], ['id' => $image1->id]);
				$data['status']='N';
			}
			else
			{
				$ret_arr=$this->FoodItems->updateAll(['status' => 'Y'], ['id' => $image1->id]);
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
     * @param string|null $id Food Item id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->limit_access(6);
        $foodItem = $this->FoodItems->get($id, [
            'contain' => ['FoodCategories', 'FoodItemDetails']
        ]);

        $this->set('foodItem', $foodItem);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->limit_access(6);
        $foodItem = $this->FoodItems->newEntity();
        if ($this->request->is('post')) {
			$fetch_exist_chk = $this->FoodItems->find('all', ['conditions' => ['FoodItems.food_item_name' => $this->request->getData(['food_item_name'])]])->first();
			if(empty($fetch_exist_chk))
			{
				$foodItem = $this->FoodItems->patchEntity($foodItem, $this->request->getData());
				if ($this->FoodItems->save($foodItem)) {
					$this->Flash->success(__('The food item has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The food item could not be saved. Please, try again.'));
			}
			else
			{
				$this->Flash->error(__('This food item already exist'));
			}
        }
		$foodCategories = $this->FoodItems->FoodCategories->find('list', ['conditions'=>['FoodCategories.status'=>'Y'], 'keyField' => 'id','valueField' => 'food_item_name']);
        $this->set(compact('foodItem', 'foodCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Food Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->limit_access(6);
        $foodItem = $this->FoodItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
			$fetch_exist_chk = $this->FoodItems->find('all', ['conditions' => ['FoodItems.food_item_name' => $this->request->getData(['food_item_name']), 'FoodItems.id <>' => $id]])->first();
			if(empty($fetch_exist_chk))
			{
				$foodItem = $this->FoodItems->patchEntity($foodItem, $this->request->getData());
				if ($this->FoodItems->save($foodItem)) {
					$this->Flash->success(__('The food item has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The food item could not be saved. Please, try again.'));
			}
			else
			{
				$this->Flash->error(__('This food item already exist'));
			}
        }
        $foodCategories = $this->FoodItems->FoodCategories->find('list', ['conditions'=>['FoodCategories.status'=>'Y'], 'keyField' => 'id','valueField' => 'food_item_name']);
        $this->set(compact('foodItem', 'foodCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Food Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		$this->limit_access(6);
		if($id=='' || $id==null)
		{
			return $this->redirect(['action' => 'index']);
		}
		$fetch_exist_chk = $this->FoodItems->find('all', ['conditions' => ['FoodItems.id'=>$id]])->first();
		if(empty($fetch_exist_chk))
		{
			return $this->redirect(['action' => 'index']);
		}
        //$this->request->allowMethod(['post', 'delete']);
        $foodItem = $this->FoodItems->get($id);
        if ($this->FoodItems->delete($foodItem)) {
            $this->Flash->success(__('The food item has been deleted.'));
        } else {
            $this->Flash->error(__('The food item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
