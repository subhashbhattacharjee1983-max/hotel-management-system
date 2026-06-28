<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FoodCategories Controller
 *
 * @property \App\Model\Table\FoodCategoriesTable $FoodCategories
 *
 * @method \App\Model\Entity\FoodCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FoodCategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
		$this->limit_access(6);
        //$foodCategories = $this->paginate($this->FoodCategories);

		$foodCategories = $this->FoodCategories->find('all', ['conditions' => [], 'order'=>'FoodCategories.id ASC'])->toArray();

        $this->set(compact('foodCategories'));
    }

	public function statusupdate($id=null) {
		$this->viewBuilder()->setLayout('ajax');		
		$image1 = $this->FoodCategories->find('all', ['conditions' => ['FoodCategories.id' => $id]])->first();
		if(!empty($image1))
		{
			if($image1->status=='Y')
			{
				$ret_arr=$this->FoodCategories->updateAll(['status' => 'N'], ['id' => $image1->id]);
				$data['status']='N';
			}
			else
			{
				$ret_arr=$this->FoodCategories->updateAll(['status' => 'Y'], ['id' => $image1->id]);
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
     * @param string|null $id Food Category id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->limit_access(6);
        $foodCategory = $this->FoodCategories->get($id, [
            'contain' => ['FoodItemDetails', 'FoodItems']
        ]);

        $this->set('foodCategory', $foodCategory);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->limit_access(6);
        $foodCategory = $this->FoodCategories->newEntity();
        if ($this->request->is('post')) {
			$fetch_exist_chk = $this->FoodCategories->find('all', ['conditions' => ['FoodCategories.food_item_name' => $this->request->getData(['food_item_name'])]])->first();
			if(empty($fetch_exist_chk))
			{
				$foodCategory = $this->FoodCategories->patchEntity($foodCategory, $this->request->getData());
				if ($this->FoodCategories->save($foodCategory)) {
					$this->Flash->success(__('The food category has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The food category could not be saved. Please, try again.'));
			}
			else
			{
				$this->Flash->error(__('This food category already exist'));
			}
        }
        $this->set(compact('foodCategory'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Food Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->limit_access(6);
        $foodCategory = $this->FoodCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
			$fetch_exist_chk = $this->FoodCategories->find('all', ['conditions' => ['FoodCategories.food_item_name' => $this->request->getData(['food_item_name']), 'FoodCategories.id <>' => $id]])->first();
			if(empty($fetch_exist_chk))
			{
				$foodCategory = $this->FoodCategories->patchEntity($foodCategory, $this->request->getData());
				if ($this->FoodCategories->save($foodCategory)) {
					$this->Flash->success(__('The food category has been saved.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('The food category could not be saved. Please, try again.'));
			}
			else
			{
				$this->Flash->error(__('This food category already exist'));
			}
        }
        $this->set(compact('foodCategory'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Food Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		$this->limit_access(6);
		$this->loadModel('FoodItems');
		if($id=='' || $id==null)
		{
			return $this->redirect(['action' => 'index']);
		}
		$fetch_exist_chk = $this->FoodCategories->find('all', ['conditions' => ['FoodCategories.id'=>$id]])->first();
		if(empty($fetch_exist_chk))
		{
			return $this->redirect(['action' => 'index']);
		}
        //$this->request->allowMethod(['post', 'delete']);
		$this->FoodItems->deleteAll(['food_category_id' => $id]);
        $foodCategory = $this->FoodCategories->get($id);
        if ($this->FoodCategories->delete($foodCategory)) {
            $this->Flash->success(__('The food category has been deleted.'));
        } else {
            $this->Flash->error(__('The food category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
