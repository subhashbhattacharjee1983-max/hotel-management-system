<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OrderItemPayments Controller
 *
 * @property \App\Model\Table\OrderItemPaymentsTable $OrderItemPayments
 *
 * @method \App\Model\Entity\OrderItemPayment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrderItemPaymentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index($order_payment_id = null, $table_type = null)
    {
        //$orderItemPayments = $this->paginate($this->OrderItemPayments);

		if($table_type != "F" && $table_type != "B"){
			$this->Flash->error(__('You are not autorised to access this'));
			return $this->redirect(['controller' => 'Bookings', 'action' => 'dashboard']);
		}
		if($table_type == "F"){
			$orderItemPayments = $this->OrderItemPayments->find('all', ['conditions' => ['OrderItemPayments.food_item_order_id' => $order_payment_id], 'order'=>'OrderItemPayments.id DESC'])->toArray();
		}
		if($table_type == "B"){
			$orderItemPayments = $this->OrderItemPayments->find('all', ['conditions' => ['OrderItemPayments.beverage_item_order_id' => $order_payment_id], 'order'=>'OrderItemPayments.id DESC'])->toArray();
		}

        $this->set(compact('orderItemPayments', 'order_payment_id', 'table_type'));
    }

    /**
     * View method
     *
     * @param string|null $id Order Item Payment id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function view($id = null)
    {
        $orderItemPayment = $this->OrderItemPayments->get($id, [
            'contain' => []
        ]);

        $this->set('orderItemPayment', $orderItemPayment);
    }*/

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($order_payment_id = null, $table_type = null)
    {
		$this->loadModel('FoodItemOrders');
		$this->loadModel('BeverageItemOrders');
		if($table_type != "F" && $table_type != "B"){
			$this->Flash->error(__('You are not autorised to access this'));
			return $this->redirect(['controller' => 'Bookings', 'action' => 'dashboard']);
		}
		$payment_for_item_order = $this->payment_for_item_order($order_payment_id, $table_type);
		
        $orderItemPayment = $this->OrderItemPayments->newEntity();
        if ($this->request->is('post')) {
			$orderItemPayment = $this->OrderItemPayments->patchEntity($orderItemPayment, $this->request->getData());
			if($table_type == "F"){
				$orderItemPayment->food_item_order_id = $order_payment_id;
				$this->FoodItemOrders->updateAll(['is_payment' => "P"], ['id' => $order_payment_id]);
			}
			if($table_type == "B"){
				$orderItemPayment->beverage_item_order_id = $order_payment_id;
				$this->BeverageItemOrders->updateAll(['is_payment' => "P"], ['id' => $order_payment_id]);
			}
            if ($this->OrderItemPayments->save($orderItemPayment)) {

				if($table_type == "F"){
					$this->Flash->success(__('The order item payment has been updated successfully'));
					return $this->redirect(['controller' => 'FoodItemOrders', 'action' => 'oldkotorder']);
				}
				if($table_type == "B"){
					$this->Flash->success(__('The order item payment has been updated successfully'));
					return $this->redirect(['controller' => 'BeverageItemOrders', 'action' => 'oldbotorder']);
				}
            }
            $this->Flash->error(__('The order item payment could not be saved. Please, try again.'));
        }
        $this->set(compact('orderItemPayment', 'payment_for_item_order', 'order_payment_id', 'table_type'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order Item Payment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
        $orderItemPayment = $this->OrderItemPayments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orderItemPayment = $this->OrderItemPayments->patchEntity($orderItemPayment, $this->request->getData());
            if ($this->OrderItemPayments->save($orderItemPayment)) {
                $this->Flash->success(__('The order item payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order item payment could not be saved. Please, try again.'));
        }
        $this->set(compact('orderItemPayment'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Order Item Payment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderItemPayment = $this->OrderItemPayments->get($id);
        if ($this->OrderItemPayments->delete($orderItemPayment)) {
            $this->Flash->success(__('The order item payment has been deleted.'));
        } else {
            $this->Flash->error(__('The order item payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }*/
}
