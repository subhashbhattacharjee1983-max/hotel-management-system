<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * FoodItemOrders Controller
 *
 * @property \App\Model\Table\FoodItemOrdersTable $FoodItemOrders
 *
 * @method \App\Model\Entity\FoodItemOrder[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FoodItemOrdersController extends AppController
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
            //'contain' => ['Bookings']
        ];
        $foodItemOrders = $this->paginate($this->FoodItemOrders);*/

		$foodItemOrders = $this->FoodItemOrders->find('all', ['conditions' => ['FoodItemOrders.is_payment <>' => "P"], 'order'=>'FoodItemOrders.id DESC'])->toArray();

        $this->set(compact('foodItemOrders'));
    }

	public function oldkotorder()
    {
		$this->limit_access(6);
		$today_year = date('Y');
		$year = isset($this->request->getParam('pass')[0]) && $this->request->getParam('pass')[0] != "" ? str_replace("_", " ", $this->request->getParam('pass')[0]) : "";
		if(isset($year) && $year!="")
		{
			$today_year = $year;
		}
        $this->FoodItemOrders = TableRegistry::get('FoodItemOrders');
		try {
			$this->paginate = [
				'limit' => 50,
				'conditions'=>['YEAR(FoodItemOrders.order_date)' => $today_year],
				'order' => ['FoodItemOrders.id DESC']
			];
		} catch (\Exception $e) {
			//Do nothing
			echo "No Record";
		}
		$foodItemOrders = $this->paginate($this->FoodItemOrders);

        $this->set(compact('foodItemOrders'));
    }

	public function foodbill($id = null)
    {
		$this->limit_access(6);
		$this->loadModel('Bookings');
        $foodItemOrder = $this->FoodItemOrders->get($id, [
            'contain' => ['FoodItemDetails']
        ]);

		$booking = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => ['Bookings.id' => $foodItemOrder->booking_id]])->first();

        $this->set(compact('booking', 'foodItemOrder'));
    }

	public function foodbillprint($id = null)
    {
		$this->viewBuilder()->setLayout('ajax');
		$this->loadModel('Bookings');
        $foodItemOrder = $this->FoodItemOrders->get($id, [
            'contain' => ['FoodItemDetails']
        ]);

		$booking = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => ['Bookings.id' => $foodItemOrder->booking_id]])->first();

        $this->set(compact('booking', 'foodItemOrder'));
    }

	public function orderprint($id = null)
    {
		$this->viewBuilder()->setLayout('ajax');
		$this->loadModel('Bookings');
        $foodItemOrder = $this->FoodItemOrders->get($id, [
            'contain' => ['FoodItemDetails']
        ]);

		$booking = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => ['Bookings.id' => $foodItemOrder->booking_id]])->first();

        $this->set(compact('booking', 'foodItemOrder'));
    }

	public function ordermark($id = null)
	{
		$foodItemOrders = $this->FoodItemOrders->find('all', ['conditions' => ['FoodItemOrders.id' => $id, 'FoodItemOrders.is_delivered' => "N"]])->first();
		if(!empty($foodItemOrders))
		{
			$ret_arr = $this->FoodItemOrders->updateAll(['is_delivered' => 'Y', 'status' => 'Y'], ['id' => $id]);
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
     * @param string|null $id Food Item Order id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $foodItemOrder = $this->FoodItemOrders->get($id, [
            'contain' => ['FoodItemDetails']
        ]);

        $this->set('foodItemOrder', $foodItemOrder);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($booking_id = null)
    {
		$this->limit_access(6);
		$this->loadModel('Rooms');
		$this->loadModel('Bookings');
		$this->loadModel('FoodCategories');
		$this->loadModel('FoodItems');
		$this->loadModel('FoodItemDetails');
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
		
        $foodItemOrder = $this->FoodItemOrders->newEntity();
        if ($this->request->is('post')) {
            $foodItemOrder = $this->FoodItemOrders->patchEntity($foodItemOrder, $this->request->getData());
			if($this->request->getData()['order_type'] == "R")
			{
				$foodItemOrder->table_number = "";
				$foodItemOrder->guest_name = "";
				$foodItemOrder->mobile_number = "";
				$foodItemOrder->number_of_persion = 0;
				$foodItemOrder->special_note = "";
			}
			if($this->request->getData()['order_type'] == "T")
			{
				$foodItemOrder->room_number = "";
			}
			if($this->request->getData()['order_type'] == "E")
			{
				$foodItemOrder->room_number = "";
			}
			if($this->request->getData()['order_type'] == "C")
			{
				$foodItemOrder->room_number = "";
			}
			$foodItemOrder->booking_id = $bookied_id;
			$foodItemOrder->order_date = date('Y-m-d H:i:s');
			$foodItemOrder->booked_by = $booked_by;	
			$foodItemOrders_data = $this->FoodItemOrders->save($foodItemOrder);
            if ($foodItemOrders_data) {
				if(isset($this->request->getData()['food_item_name']) && $this->request->getData()['food_item_name']!="")
				{
					foreach($this->request->getData()['food_item_name'] as $key=>$val)
					{
						$food_item = explode("@",$val);
						//$food_item = explode("@",$this->request->getData()['food_item_name'][$key]);
						$foodItmDetail = $this->FoodItemDetails->newEntity();
						$fooditmdetails['food_item_order_id'] = $foodItemOrders_data->id;
						//$fooditmdetails['food_category_id'] = $food_category[0];
						//$fooditmdetails['food_item_category'] = $food_category[1];
						//$fooditmdetails['food_item_id'] = $food_item[0];
						$fooditmdetails['booking_id'] = $bookied_id;
						$fooditmdetails['food_item_name'] = $food_item[0];
						$fooditmdetails['price'] = $this->request->getData()['item_price'][$key];
						$fooditmdetails['quantity'] = $this->request->getData()['item_quantity'][$key];
						$fooditmdetails['item_no_of_days'] = $this->request->getData()['item_no_of_days'][$key];
						$fooditmdetails['sub_total'] = $this->request->getData()['item_sub_total'][$key];
						$fooditmdetails['order_date'] = date('Y-m-d H:i:s');
						$foodItmDetail = $this->FoodItemDetails->patchEntity($foodItmDetail, $fooditmdetails);
						$this->FoodItemDetails->save($foodItmDetail);
					}
				}
                $this->Flash->success(__('The food item order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The food item order could not be saved. Please, try again.'));
        }
		$foodcategories = $this->FoodCategories->find('all', ['conditions' => ['FoodCategories.status' => 'Y']])->toArray();
		$foodItems = $this->FoodItems->find('all', ['conditions' => ['FoodItems.status' => 'Y']])->toArray();
        $bookings = $this->FoodItemOrders->Bookings->find('list', ['limit' => 200]);
        //$admins = $this->FoodItemOrders->Admins->find('list', ['limit' => 200]);
        $this->set(compact('foodItemOrder', 'bookings', 'bookied_id', 'rooms', 'foodItems', 'foodcategories'));
    }


	public function fetchItem(){
		$this->viewBuilder()->layout('ajax');
		$this->loadModel('FoodItems');
		$conditions = [];
		$item = [];
		if(isset($this->request->getData()['cat_id']) && $this->request->getData()['cat_id']!="")
		{
			$conditions['FoodItems.food_category_id'] = $this->request->getData()['cat_id'];
			$item = $this->FoodItems->find('list', ['conditions' => $conditions, 'keyField' => 'id', 'valueField' => 'food_item_name'])->toArray();
		}
		$data['item'] = $item;
		echo json_encode($data);
		exit;
	}

	public function fetchItemAmount(){
		$this->viewBuilder()->layout('ajax');
		$this->loadModel('FoodItems');
		$item = [];
		if(isset($this->request->getData()['item_id']) && $this->request->getData()['item_id']!="")
		{
			$item = $this->FoodItems->find('all', ['conditions' => ['FoodItems.id' => $this->request->getData()['item_id']]])->first();
		}
		echo $item['food_item_price'];
		exit;
	}

    /**
     * Edit method
     *
     * @param string|null $id Food Item Order id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->limit_access(6);
		$this->loadModel('FoodItems');
		$this->loadModel('FoodItemDetails');
		$this->loadModel('Rooms');
        $foodItemOrder = $this->FoodItemOrders->get($id, [
            'contain' => ['FoodItemDetails']
        ]);
		if($foodItemOrder->is_payment != "U"){
			$this->Flash->error(__('You are not autorised to access this'));
			return $this->redirect(['controller' => 'bookings', 'action' => 'dashboard']);
		}
        if ($this->request->is(['patch', 'post', 'put'])) {
            $foodItemOrder = $this->FoodItemOrders->patchEntity($foodItemOrder, $this->request->getData());
            $foodItemOrders_data = $this->FoodItemOrders->save($foodItemOrder); 
			if ($foodItemOrders_data) {
				if(isset($this->request->getData()['food_item_name']) && $this->request->getData()['food_item_name']!="")
				{
					foreach($this->request->getData()['food_item_name'] as $key=>$val)
					{
					    if($val!="")
						{
    						$food_item = explode("@",$val);
    						$foodItmDetail = $this->FoodItemDetails->newEntity();
    						$fooditmdetails['food_item_order_id'] = $id;
    						$fooditmdetails['booking_id'] = $foodItemOrder['bookied_id'];
    						$fooditmdetails['food_item_name'] = $food_item[0];
    						$fooditmdetails['price'] = $this->request->getData()['item_price'][$key];
    						$fooditmdetails['quantity'] = $this->request->getData()['item_quantity'][$key];
    						$fooditmdetails['item_no_of_days'] = $this->request->getData()['item_no_of_days'][$key];
    						$fooditmdetails['sub_total'] = $this->request->getData()['item_sub_total'][$key];
    						$fooditmdetails['order_date'] = date('Y-m-d H:i:s');
    						$foodItmDetail = $this->FoodItemDetails->patchEntity($foodItmDetail, $fooditmdetails);
    						$this->FoodItemDetails->save($foodItmDetail);
						}
					}
				}
                $this->Flash->success(__('The food item order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The food item order could not be saved. Please, try again.'));
        }
		$foodItems = $this->FoodItems->find('all', ['conditions' => ['FoodItems.status' => 'Y']])->toArray();
        $bookings = $this->FoodItemOrders->Bookings->find('list', ['limit' => 200]);
		$rooms = $this->Rooms->find('all', ['contain' => ['RoomCategories'], 'conditions' => ['Rooms.status' => 'Y', 'Rooms.room_status' => 'O']])->toArray();
        //$admins = $this->FoodItemOrders->Admins->find('list', ['limit' => 200]);
        $this->set(compact('foodItemOrder', 'bookings', 'rooms', 'foodItems'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Food Item Order id.
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
		$fetch_exist_chk = $this->FoodItemOrders->find('all', ['conditions' => ['FoodItemOrders.id'=>$id]])->first();
		if(empty($fetch_exist_chk))
		{
			return $this->redirect(['action' => 'index']);
		} 
        //$this->request->allowMethod(['post', 'delete']);
		$this->loadModel('FoodItemDetails');
        $foodItemOrder = $this->FoodItemOrders->get($id);
		if($foodItemOrder->is_payment != "U"){
			$this->Flash->error(__('You are not autorised to access this'));
			return $this->redirect(['controller' => 'bookings', 'action' => 'dashboard']);
		}
		$this->FoodItemDetails->deleteAll(['food_item_order_id' => $id]);
        if ($this->FoodItemOrders->delete($foodItemOrder)) {
            $this->Flash->success(__('The food item order has been deleted.'));
        } else {
            $this->Flash->error(__('The food item order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
