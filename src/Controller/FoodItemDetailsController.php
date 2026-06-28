<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FoodItemDetails Controller
 *
 * @property \App\Model\Table\FoodItemDetailsTable $FoodItemDetails
 *
 * @method \App\Model\Entity\FoodItemDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FoodItemDetailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['FoodItemOrders', 'FoodCategories', 'FoodItems']
        ];
        $foodItemDetails = $this->paginate($this->FoodItemDetails);

        $this->set(compact('foodItemDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Food Item Detail id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $foodItemDetail = $this->FoodItemDetails->get($id, [
            'contain' => ['FoodItemOrders', 'FoodCategories', 'FoodItems']
        ]);

        $this->set('foodItemDetail', $foodItemDetail);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $foodItemDetail = $this->FoodItemDetails->newEntity();
        if ($this->request->is('post')) {
            $foodItemDetail = $this->FoodItemDetails->patchEntity($foodItemDetail, $this->request->getData());
            if ($this->FoodItemDetails->save($foodItemDetail)) {
                $this->Flash->success(__('The food item detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The food item detail could not be saved. Please, try again.'));
        }
        $foodItemOrders = $this->FoodItemDetails->FoodItemOrders->find('list', ['limit' => 200]);
        $foodCategories = $this->FoodItemDetails->FoodCategories->find('list', ['limit' => 200]);
        $foodItems = $this->FoodItemDetails->FoodItems->find('list', ['limit' => 200]);
        $this->set(compact('foodItemDetail', 'foodItemOrders', 'foodCategories', 'foodItems'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Food Item Detail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $foodItemDetail = $this->FoodItemDetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $foodItemDetail = $this->FoodItemDetails->patchEntity($foodItemDetail, $this->request->getData());
            if ($this->FoodItemDetails->save($foodItemDetail)) {
                $this->Flash->success(__('The food item detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The food item detail could not be saved. Please, try again.'));
        }
        $foodItemOrders = $this->FoodItemDetails->FoodItemOrders->find('list', ['limit' => 200]);
        $foodCategories = $this->FoodItemDetails->FoodCategories->find('list', ['limit' => 200]);
        $foodItems = $this->FoodItemDetails->FoodItems->find('list', ['limit' => 200]);
        $this->set(compact('foodItemDetail', 'foodItemOrders', 'foodCategories', 'foodItems'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Food Item Detail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $foodItemDetail = $this->FoodItemDetails->get($id);
        if ($this->FoodItemDetails->delete($foodItemDetail)) {
            $this->Flash->success(__('The food item detail has been deleted.'));
        } else {
            $this->Flash->error(__('The food item detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
