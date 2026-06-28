<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Settings Controller
 *
 * @property \App\Model\Table\SettingsTable $Settings
 *
 * @method \App\Model\Entity\Setting[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SettingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    /*public function index()
    {
        $settings = $this->paginate($this->Settings);

        $this->set(compact('settings'));
    }*/

    /**
     * View method
     *
     * @param string|null $id Setting id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function view($id = null)
    {
        $setting = $this->Settings->get($id, [
            'contain' => []
        ]);

        $this->set('setting', $setting);
    }*/

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    /*public function add()
    {
        $setting = $this->Settings->newEntity();
        if ($this->request->is('post')) {
            $setting = $this->Settings->patchEntity($setting, $this->request->getData());
            if ($this->Settings->save($setting)) {
                $this->Flash->success(__('The setting has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The setting could not be saved. Please, try again.'));
        }
        $this->set(compact('setting'));
    }*/

    /**
     * Edit method
     *
     * @param string|null $id Setting id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(){
		$this->limit_access(10);
		$settings_data=$this->Settings->find('all', ['conditions' => []])->first();
        $setting = $this->Settings->get($settings_data->id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
			$flag_website_logo = true;
			
			$setting = $this->Settings->patchEntity($setting, $this->request->getData());
			if(isset($this->request->getData()['up_website_logo']) && $this->request->getData()['up_website_logo']['name']!=''){
				if($this->request->getData()['up_website_logo']['error'] == 0){
					$extension_array = explode('.', $this->request->getData()['up_website_logo']['name']);
					$extension = end($extension_array);
					$file_extension = $this->validImageFormats;
					$website_logo = 'main_website_logo_'.time().".".$extension;
					$move_location_website_logo = WWW_ROOT . $this->upload_folder . DS . $this->website_logo_folder . DS . $website_logo; 
					if(in_array($extension, $file_extension)){
						$prev_website_logo=$this->request->getData()['website_logo'];
						$setting->website_logo = $website_logo;
					}else{
						$flag_website_logo=false;
					}
				}else{
					$flag_website_logo=false;
				}
			}
			if ($this->Settings->save($setting)) {
				if($this->request->getData()['up_website_logo']['tmp_name'] && $this->request->getData()['up_website_logo']['tmp_name']!='' && $flag_website_logo==true){
					if($prev_website_logo!='' && file_exists( WWW_ROOT . $this->upload_folder . DS . $this->website_logo_folder . DS . $prev_website_logo)){
						unlink( WWW_ROOT . $this->upload_folder . DS . $this->website_logo_folder . DS . $prev_website_logo);
					}
					move_uploaded_file($this->request->getData()['up_website_logo']['tmp_name'], $move_location_website_logo);
				}
				$this->Flash->success(__('Settings has been updated successfully.'));
				return $this->redirect(['action' => 'edit']);
			} else {
				$this->Flash->error(__('The settings could not be saved. Please, try again.'));
			}
			
			$fetch_data = $this->Settings->find('all', ['conditions' => []])->first();
		}
        $this->set(compact('setting'));
        $this->set('_serialize', ['setting']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Setting id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $setting = $this->Settings->get($id);
        if ($this->Settings->delete($setting)) {
            $this->Flash->success(__('The setting has been deleted.'));
        } else {
            $this->Flash->error(__('The setting could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }*/
}
