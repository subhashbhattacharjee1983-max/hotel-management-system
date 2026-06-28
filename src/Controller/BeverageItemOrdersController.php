<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * BeverageItemOrders Controller
 *
 * @property \App\Model\Table\BeverageItemOrdersTable $BeverageItemOrders
 *
 * @method \App\Model\Entity\BeverageItemOrder[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BeverageItemOrdersController extends AppController
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
            //'contain' => ['Bookings', 'Admins']
        ];
        $beverageItemOrders = $this->paginate($this->BeverageItemOrders);*/

		$beverageItemOrders = $this->BeverageItemOrders->find('all', ['conditions' => ['BeverageItemOrders.is_payment <>' => "P"], 'order'=>'BeverageItemOrders.id DESC'])->toArray();

        $this->set(compact('beverageItemOrders'));
    }

	public function oldbotorder()
    {
		$this->limit_access(7);
		$today_year = date('Y');
		$year = isset($this->request->getParam('pass')[0]) && $this->request->getParam('pass')[0] != "" ? str_replace("_", " ", $this->request->getParam('pass')[0]) : "";
		if(isset($year) && $year!="")
		{
			$today_year = $year;
		}
        $this->BeverageItemOrders = TableRegistry::get('BeverageItemOrders');
		try {
			$this->paginate = [
				'limit' => 50,
				'conditions'=>['YEAR(BeverageItemOrders.order_date)' => $today_year],
				'order' => ['BeverageItemOrders.id DESC']
			];
		} catch (\Exception $e) {
			//Do nothing
			echo "No Record";
		}
		$beverageItemOrders = $this->paginate($this->BeverageItemOrders);

        $this->set(compact('beverageItemOrders'));
    }

	public function barbill($id = null)
    {
		$this->limit_access(7);
		$this->loadModel('Bookings');
        $beverageItemOrder = $this->BeverageItemOrders->get($id, [
            'contain' => ['BeverageItemDetails']
        ]);

		$booking = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => ['Bookings.id' => $beverageItemOrder->booking_id]])->first();

        $this->set(compact('booking', 'beverageItemOrder'));
    }

	public function barbillprint($id = null)
    {
		$this->viewBuilder()->setLayout('ajax');
		$this->loadModel('Bookings');
        $beverageItemOrder = $this->BeverageItemOrders->get($id, [
            'contain' => ['BeverageItemDetails']
        ]);

		$booking = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => ['Bookings.id' => $beverageItemOrder->booking_id]])->first();

        $this->set(compact('booking', 'beverageItemOrder'));
    }

	public function orderprint($id = null)
    {
		$this->viewBuilder()->setLayout('ajax');
		$this->loadModel('Bookings');
        $beverageItemOrder = $this->BeverageItemOrders->get($id, [
            'contain' => ['BeverageItemDetails']
        ]);

		$booking = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => ['Bookings.id' => $beverageItemOrder->booking_id]])->first();

        $this->set(compact('booking', 'beverageItemOrder'));
    }

	public function ordermark($id = null)
	{
		$beverageItemOrders = $this->BeverageItemOrders->find('all', ['conditions' => ['BeverageItemOrders.id' => $id, 'BeverageItemOrders.is_delivered' => "N"]])->first();
		if(!empty($beverageItemOrders))
		{
			$ret_arr = $this->BeverageItemOrders->updateAll(['is_delivered' => 'Y', 'status' => 'Y'], ['id' => $id]);
			if($ret_arr) 
			{
				$this->Flash->success(__('Order marked as completed successfully'));
				return $this->redirect(['action' => 'index']);
			}
			else
			{
				$this->Flash->success(__('Order id is not exists'));
				return $this->redirect(['action' => 'index']);
			}
		}
	}

    /**
     * View method
     *
     * @param string|null $id Beverage Item Order id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->limit_access(7);
        $beverageItemOrder = $this->BeverageItemOrders->get($id, [
            'contain' => ['BeverageItemDetails']
        ]);

        $this->set('beverageItemOrder', $beverageItemOrder);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($booking_id = null)
    {
		$this->limit_access(7);
		$this->loadModel('Rooms');
		$this->loadModel('Bookings');
		$this->loadModel('BeverageCategories');
		$this->loadModel('BeverageItemDetails');
		$this->loadModel('BeverageItems');
		$booked_by = $this->request->getSession()->read('Auth.User.name')." (".$this->account_type[$this->request->getSession()->read('Auth.User.user_type')].")";
		$rooms = [];
		$bookied_id = 0;
		if(isset($booking_id) && $booking_id!="")
		{
			$bookied_id = $booking_id;
			$booking_order = $this->Bookings->find('all', ['conditions' => ['Bookings.id' => $booking_id]])->first();
		}
		if(!empty($booking_order))
		{
			$rooms = $this->Rooms->find('all', ['contain' => ['RoomCategories'], 'conditions' => ['Rooms.status' => 'Y', 'Rooms.booking_id' => $booking_id]])->toArray();
		}
		else
		{
			$rooms = $this->Rooms->find('all', ['contain' => ['RoomCategories'], 'conditions' => ['Rooms.status' => 'Y', 'Rooms.room_status' => 'O']])->toArray();
		}
        $beverageItemOrder = $this->BeverageItemOrders->newEntity();
        if ($this->request->is('post')) {
            $beverageItemOrder = $this->BeverageItemOrders->patchEntity($beverageItemOrder, $this->request->getData());
			if($this->request->getData()['order_type'] == "R")
			{
				$beverageItemOrder->table_number = "";
				$beverageItemOrder->guest_name = "";
				$beverageItemOrder->mobile_number = "";
				$beverageItemOrder->number_of_persion = 0;
				$beverageItemOrder->special_note = "";
			}
			if($this->request->getData()['order_type'] == "T")
			{
				$beverageItemOrder->room_number = "";
			}
			if($this->request->getData()['order_type'] == "E")
			{
				$beverageItemOrder->room_number = "";
			}
			$beverageItemOrder->booking_id = $bookied_id;
			$beverageItemOrder->order_date = date('Y-m-d H:i:s');
			$beverageItemOrder->booked_by = $booked_by;
			$beverageItemOrders_data = $this->BeverageItemOrders->save($beverageItemOrder);
            if ($beverageItemOrders_data) {
				if(isset($this->request->getData()['beverage_item_name']) && $this->request->getData()['beverage_item_name']!="")
				{
					foreach($this->request->getData()['beverage_item_name'] as $key=>$val)
					{
						$beverage_item = explode("@",$val);
						//$beverage_item = explode("@",$this->request->getData()['beverage_item_name'][$key]);
						$beverageItmDetail = $this->BeverageItemDetails->newEntity();
						$beverageitmdetails['beverage_item_order_id'] = $beverageItemOrders_data->id;
						//$beverageitmdetails['beverage_category_id'] = $beverage_category[0];
						//$beverageitmdetails['beverage_item_category'] = $beverage_category[1];
						//$beverageitmdetails['beverage_item_id'] = $beverage_item[0];
						$beverageitmdetails['booking_id'] = $bookied_id;
						$beverageitmdetails['beverage_item_name'] = $beverage_item[0];
						$beverageitmdetails['price'] = $this->request->getData()['item_price'][$key];
						$beverageitmdetails['quantity'] = $this->request->getData()['item_quantity'][$key];
						$beverageitmdetails['sub_total'] = $this->request->getData()['item_sub_total'][$key];
						$beverageitmdetails['order_date'] = date('Y-m-d H:i:s');
						$beverageItmDetail = $this->BeverageItemDetails->patchEntity($beverageItmDetail, $beverageitmdetails);
						$this->BeverageItemDetails->save($beverageItmDetail);
					}
				}
                $this->Flash->success(__('The beverage item order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The beverage item order could not be saved. Please, try again.'));
        }
		$beveragecategories = $this->BeverageCategories->find('all', ['conditions' => ['BeverageCategories.status' => 'Y']])->toArray();
		$beverageItems = $this->BeverageItems->find('all', ['conditions' => ['BeverageItems.status' => 'Y']])->toArray();
        $bookings = $this->BeverageItemOrders->Bookings->find('list', ['limit' => 200]);
        //$admins = $this->BeverageItemOrders->Admins->find('list', ['limit' => 200]);
        $this->set(compact('beverageItemOrder', 'bookings', 'bookied_id', 'rooms', 'beverageItems', 'beveragecategories'));
    }

	public function fetchItem(){
		$this->viewBuilder()->layout('ajax');
		$this->loadModel('BeverageItems');
		$conditions = [];
		$item = [];
		if(isset($this->request->getData()['cat_id']) && $this->request->getData()['cat_id']!="")
		{
			$conditions['BeverageItems.beverage_category_id'] = $this->request->getData()['cat_id'];
			$item = $this->BeverageItems->find('list', ['conditions' => $conditions, 'keyField' => 'id', 'valueField' => 'beverage_item_name'])->toArray();
		}
		$data['item'] = $item;
		echo json_encode($data);
		exit;
	}

	public function fetchItemAmount(){
		$this->viewBuilder()->layout('ajax');
		$this->loadModel('BeverageItems');
		$item = [];
		if(isset($this->request->getData()['item_id']) && $this->request->getData()['item_id']!="")
		{
			$item = $this->BeverageItems->find('all', ['conditions' => ['BeverageItems.id' => $this->request->getData()['item_id']]])->first();
		}
		echo $item['beverage_item_price'];
		exit;
	}

    /**
     * Edit method
     *
     * @param string|null $id Beverage Item Order id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
        $beverageItemOrder = $this->BeverageItemOrders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $beverageItemOrder = $this->BeverageItemOrders->patchEntity($beverageItemOrder, $this->request->getData());
            if ($this->BeverageItemOrders->save($beverageItemOrder)) {
                $this->Flash->success(__('The beverage item order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The beverage item order could not be saved. Please, try again.'));
        }
        $bookings = $this->BeverageItemOrders->Bookings->find('list', ['limit' => 200]);
        $admins = $this->BeverageItemOrders->Admins->find('list', ['limit' => 200]);
        $this->set(compact('beverageItemOrder', 'bookings', 'admins'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Beverage Item Order id.
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
		$fetch_exist_chk = $this->BeverageItemOrders->find('all', ['conditions' => ['BeverageItemOrders.id'=>$id]])->first();
		if(empty($fetch_exist_chk))
		{
			return $this->redirect(['action' => 'index']);
		}
        //$this->request->allowMethod(['post', 'delete']);
		$this->loadModel('BeverageItemDetails');
        $beverageItemOrder = $this->BeverageItemOrders->get($id);
		if($beverageItemOrder->is_payment != "U"){
			$this->Flash->error(__('You are not autorised to access this'));
			return $this->redirect(['action' => 'dashboard']);
		}
		$this->BeverageItemDetails->deleteAll(['beverage_item_order_id' => $id]);
        if ($this->BeverageItemOrders->delete($beverageItemOrder)) {
            $this->Flash->success(__('The beverage item order has been deleted.'));
        } else {
            $this->Flash->error(__('The beverage item order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
