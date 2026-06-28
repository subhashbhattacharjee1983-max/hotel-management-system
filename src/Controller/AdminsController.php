<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Admins Controller
 *
 * @property \App\Model\Table\AdminsTable $Admins
 *
 * @method \App\Model\Entity\Admin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdminsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
		if($this->request->getSession()->check('Auth.User.user_type') && $this->request->getSession()->read('Auth.User.user_type') != '1'){
			return $this->redirect(['action' => 'edit_profile']);
		}
		$admins = $this->Admins->find('all', ['conditions' => ['Admins.user_type <>' => 1], 'order'=>'Admins.id ASC'])->toArray();

        $this->set(compact('admins'));
    }

    /**
     * View method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $admin = $this->Admins->get($id, [
            'contain' => ['BeverageItemOrders', 'FoodItemOrders']
        ]);

        $this->set('admin', $admin);
    }

	public function statusupdate($id=null) 
	{
		$this->viewBuilder()->setLayout('ajax');		
		$image1 = $this->Admins->find('all', ['conditions' => ['Admins.id' => $id]])->first();
		if(!empty($image1))
		{
			if($image1->status=='Y')
			{
				$ret_arr=$this->Admins->updateAll(['status' => 'N'], ['id' => $image1->id]);
				$data['status']='N';
			}
			else
			{
				$ret_arr=$this->Admins->updateAll(['status' => 'Y'], ['id' => $image1->id]);
				$data['status']='Y';
			}
			if ($ret_arr) {
					$data['msg']='success';
					$data['success']='The status has been updated successfully.';
			} else {
				$data['msg']='We are having some problem. Plese try later.';
			}
		} else {
			$data['msg']="The status could not be updated. Please, try again.";
		}
		echo json_encode($data);
		exit;
	}

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		if($this->request->getSession()->check('Auth.User.user_type') && $this->request->getSession()->read('Auth.User.user_type') != '1'){
			return $this->redirect(['action' => 'edit_profile']);
		}		
		$admin = $this->Admins->newEntity();
		if ($this->request->is('post')) {
			$fetch_exist_chk=$this->Admins->find('all', ['conditions' => ['Admins.email'=>$this->request->getData()['email']]])->first();
			if(empty($fetch_exist_chk))
			{
				$admin = $this->Admins->patchEntity($admin, $this->request->getData());
				$limit_access = "";
				if($this->request->getData()['limit_access'] !="")
				{
					foreach($this->request->getData()['limit_access'] as $key => $val)
					{
						if($val > 0)
						{
							$limit_access .= $val.",";
						}
					}
				}
				$admin->limit_access = rtrim($limit_access,",");
				if ($this->Admins->save($admin)) {
					$this->Flash->success(__('The admin has been saved.'));
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('The admin could not be saved. Please, try again.'));
				}
			}
			else
			{
				$this->Flash->error(__('This email already exists.'));
			}
		}
        $this->set(compact('admin'));
        $this->set('_serialize', ['admin']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		if($this->request->getSession()->check('Auth.User.user_type') && $this->request->getSession()->read('Auth.User.user_type') != '1'){
			return $this->redirect(['action' => 'edit_profile']);
		}
		if($id=='' || $id==null)
		{
			return $this->redirect(['action' => 'index']);
		}
		$fetch_exist_chk=$this->Admins->find('all', ['conditions' => ['Admins.id'=>$id]])->first();
		if(empty($fetch_exist_chk))
		{
			return $this->redirect(['action' => 'index']);
		}
        $admin = $this->Admins->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
			$fetch_exist_chk=$this->Admins->find('all', ['conditions' => ['Admins.email'=>$this->request->getData()['email'], 'Admins.id <>'=>$id]])->first();
			if(empty($fetch_exist_chk))
			{
				$admin = $this->Admins->patchEntity($admin, $this->request->getData());
				$limit_access = "";
				if($this->request->getData()['limit_access'] !="")
				{
					foreach($this->request->getData()['limit_access'] as $key => $val)
					{
						if($val > 0)
						{
							$limit_access .= $val.",";
						}
					}
				}
				$admin->limit_access = rtrim($limit_access,",");
				if(($this->request->getData()['password']!=$this->request->getData()['confirm_pass']) ||($this->request->getData()['password']==''||$this->request->getData()['confirm_pass']==''))
				{
					unset($admin->password);
				}
				//print_r($admin); exit;
				if ($this->Admins->save($admin)) {
					$this->Flash->success(__('The admin has been updated successfully.'));
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('The admin could not be saved. Please, try again.'));
				}
			}
			else
			{
				$this->Flash->error(__('This email already exists.'));
			}
        }
        $this->set(compact('admin'));
        $this->set('_serialize', ['admin']);
    }

	public function editProfile()
    {	
		
		$fetch_exist_chk=$this->Admins->find('all', ['conditions' => ['Admins.id'=>$this->request->getSession()->read('Auth.User.id')]])->first();
		if(empty($fetch_exist_chk))
		{
			return $this->redirect(['action' => 'edit_profile']);
		}
        $admin = $this->Admins->get($this->request->getSession()->read('Auth.User.id'), [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
			$fetch_exist_chk=$this->Admins->find('all', ['conditions' => ['Admins.email'=>$this->request->getData()['email'], 'Admins.id <>'=>$this->request->getSession()->read('Auth.User.id')]])->first();
			if(empty($fetch_exist_chk))
			{
				$admin = $this->Admins->patchEntity($admin, $this->request->getData());
				if(($this->request->getData()['password']!=$this->request->getData()['admin_con_pass']) ||($this->request->getData()['password']==''||$this->request->getData()['admin_con_pass']==''))
				{
					unset($admin->password);
				}
				//print_r($admin); exit;
				if ($this->Admins->save($admin)) {
					$this->Flash->success(__('Your profile has been updated successfully.'));
					return $this->redirect(['action' => 'edit_profile']);
				} else {
					$this->Flash->error(__('Your profile could not be saved. Please, try again.'));
				}
			}
			else
			{
				$this->Flash->error(__('This email already exists.'));
			}
        }
		
        $this->set(compact('admin'));
        $this->set('_serialize', ['admin']);
	}

	public function privacyPolicy()
    {
		if($this->request->getSession()->check('Auth.User.user_type') && $this->request->getSession()->read('Auth.User.user_type') != ''){
			return $this->redirect(['controller' => 'Settings', 'action' => 'edit']);
		}
		$admin = $this->Admins->newEntity();
		$this->viewBuilder()->setLayout('admin_security_layout');
	}

	public function termCondition()
    {
		if($this->request->getSession()->check('Auth.User.user_type') && $this->request->getSession()->read('Auth.User.user_type') != ''){
			return $this->redirect(['controller' => 'Settings', 'action' => 'edit']);
		}
		$admin = $this->Admins->newEntity();
		$this->viewBuilder()->setLayout('admin_security_layout');
	}

    /**
     * Delete method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		if($this->request->getSession()->check('Auth.User.user_type') && $this->request->getSession()->read('Auth.User.user_type') != '1'){
			return $this->redirect(['action' => 'edit_profile']);
		}
		if($id=='' || $id==null)
		{
			return $this->redirect(['action' => 'index']);
		}
		$fetch_exist_chk=$this->Admins->find('all', ['conditions' => ['Admins.id'=>$id]])->first();
		if(empty($fetch_exist_chk))
		{
			return $this->redirect(['action' => 'index']);
		}
        //$this->request->allowMethod(['post', 'delete']);
        $admin = $this->Admins->get($id);
        if ($this->Admins->delete($admin)) {
            $this->Flash->success(__('The admin has been deleted successfully.'));
        } else {
            $this->Flash->error(__('The admin could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

	public function login()
    {
		if($this->request->getSession()->check('Auth.User.user_type') && $this->request->getSession()->read('Auth.User.user_type') != ''){
			return $this->redirect(['controller' => 'Settings', 'action' => 'edit']);
		}
		$admin = $this->Admins->newEntity();
		$this->viewBuilder()->setLayout('admin_login_layout');
		if ($this->request->is('post')) 
		{
            $user = $this->Auth->identify();
            if ($user) 
			{
				if($user['user_type'] == $this->request->getData()['type'] && $user['status'] == "Y")
				{
					$user['admin'] = 'admin';				
					$this->Auth->setUser($user);				
					if(isset($this->request->getData()['remember_me']) && $this->request->getData()['remember_me'] == 1)
					{
						if(@$_COOKIE['a1_car_email'] == '' && @$_COOKIE['a1_car_administrator_password'] == '')
						{
							$year = time() + 31536000;
							setcookie('taxi_email', $this->request->getData()['email'], $year);
							setcookie('taxi_administrator_password',$this->request->getData()['password'], $year);
						}
					}
					else
					{ 
						$year = time() - 31536000;
						setcookie('taxi_email', '', $year);
						setcookie('taxi_administrator_password','', $year);
						unset($_COOKIE['taxi_email']);
						//setcookie('a1_car_email', null, -1, '/');

						unset($_COOKIE['taxi_administrator_password']);
						//setcookie('a1_car_administrator_password', null, -1, '/');
					}
					return $this->redirect($this->Auth->redirectUrl());
				}
				else
				{
					$this->request->getData()['type'] = "";
					$this->Flash->error(__('Invalid user type, try again'));
				}
            }
			else
			{
				$this->Flash->error(__('Invalid username or password, try again'));
			}
        }
		$this->set(compact('admin'));
        $this->set('_serialize', ['admin']);
	}
	public function logout()
	{
		return $this->redirect($this->Auth->logout());
		exit;
	}

	public function forgot()
	{
		if($this->request->getSession()->check('Auth.User.user_type') && $this->request->getSession()->read('Auth.User.user_type') != ''){
			return $this->redirect(['controller' => 'Settings', 'action' => 'edit']);
		}
		$admin = $this->Admins->newEntity();
		$this->viewBuilder()->setLayout('admin_login_layout');
		if ($this->request->is('post')) 
		{
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$password_gen = substr( str_shuffle( $chars ), 0, 8 );
			$password_gen_2 = substr( str_shuffle( $chars ), 0, 8 );

			$get_acc = $this->Admins->find('all', ['conditions' => ['Admins.email' => $this->request->getData()['email']]])->first();

			if($get_acc)
			{

				$admin = $this->Admins->get($get_acc->id, [
					'contain' => []
				]);

				$this->request->getData()['password'] = $password_gen;

				$admin = $this->Admins->patchEntity($admin, $this->request->getData());
				if ($this->Admins->save($admin)) 
				{
					//print_r($password_gen); exit;
					$mail_subject = 'Your password details';
					$mail_Body = 'New information is as follows.<br/><br/>Username: <b>'.$get_acc->email.'</b><br/><br/>Password: <b>'.$password_gen.'</b>';
					$mail_To = $this->request->getData()['email'];
					$settings_data=$this->site_general_settings();
					$mail_From = $settings_data['from_email'];
					//$mail_Headers  = "MIME-Version: 1.0\r\n";
					//$mail_Headers .= "Content-type: text/html; charset=iso-8859-1\r\n";                
					//$mail_Headers .= "From: ${mail_From}\r\n";
					@$this->Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject, $mail_Body);
					//@mail($mail_To, $mail_subject, $mail_Body, $mail_Headers);
					$this->Flash->success(__('Your new password has been send to your email.'));
					return $this->redirect(['action' => 'login']);
				} 
				else 
				{
					$this->Flash->error(__('Sorry. Please, try again.'));
				}
			}
			else
			{
				$this->Flash->error(__('This email address is not exists with us. Please, try again.'));
			}
		}
		$this->set(compact('admin'));
        $this->set('_serialize', ['admin']);
	}
}
