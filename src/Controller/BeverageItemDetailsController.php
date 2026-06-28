<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BeverageItemDetails Controller
 *
 * @property \App\Model\Table\BeverageItemDetailsTable $BeverageItemDetails
 *
 * @method \App\Model\Entity\BeverageItemDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BeverageItemDetailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['BeverageItemOrders', 'BeverageCategories', 'BeverageItems']
        ];
        $beverageItemDetails = $this->paginate($this->BeverageItemDetails);

        $this->set(compact('beverageItemDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Beverage Item Detail id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $beverageItemDetail = $this->BeverageItemDetails->get($id, [
            'contain' => ['BeverageItemOrders', 'BeverageCategories', 'BeverageItems']
        ]);

        $this->set('beverageItemDetail', $beverageItemDetail);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $beverageItemDetail = $this->BeverageItemDetails->newEntity();
        if ($this->request->is('post')) {
            $beverageItemDetail = $this->BeverageItemDetails->patchEntity($beverageItemDetail, $this->request->getData());
            if ($this->BeverageItemDetails->save($beverageItemDetail)) {
                $this->Flash->success(__('The beverage item detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The beverage item detail could not be saved. Please, try again.'));
        }
        $beverageItemOrders = $this->BeverageItemDetails->BeverageItemOrders->find('list', ['limit' => 200]);
        $beverageCategories = $this->BeverageItemDetails->BeverageCategories->find('list', ['limit' => 200]);
        $beverageItems = $this->BeverageItemDetails->BeverageItems->find('list', ['limit' => 200]);
        $this->set(compact('beverageItemDetail', 'beverageItemOrders', 'beverageCategories', 'beverageItems'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Beverage Item Detail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $beverageItemDetail = $this->BeverageItemDetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $beverageItemDetail = $this->BeverageItemDetails->patchEntity($beverageItemDetail, $this->request->getData());
            if ($this->BeverageItemDetails->save($beverageItemDetail)) {
                $this->Flash->success(__('The beverage item detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The beverage item detail could not be saved. Please, try again.'));
        }
        $beverageItemOrders = $this->BeverageItemDetails->BeverageItemOrders->find('list', ['limit' => 200]);
        $beverageCategories = $this->BeverageItemDetails->BeverageCategories->find('list', ['limit' => 200]);
        $beverageItems = $this->BeverageItemDetails->BeverageItems->find('list', ['limit' => 200]);
        $this->set(compact('beverageItemDetail', 'beverageItemOrders', 'beverageCategories', 'beverageItems'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Beverage Item Detail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $beverageItemDetail = $this->BeverageItemDetails->get($id);
        if ($this->BeverageItemDetails->delete($beverageItemDetail)) {
            $this->Flash->success(__('The beverage item detail has been deleted.'));
        } else {
            $this->Flash->error(__('The beverage item detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
