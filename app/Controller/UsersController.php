<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('register', 'login', 'logout');
	}

	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Session->setFlash(__('Invalid username or password, try again'));
		}
	}

	public function logout() {
		return $this->redirect($this->Auth->logout());
	}
/**
 * register method
 *
 * @return void
 */
	public function register() {
		if ($this->request->is('post')) {
			if($this->request->data['User']['password'] != $this->request->data['User']['c_password']) {
				$this->Session->setFlash(__('The password doesn\'t match.'));
				return $this->redirect(array('action' => 'register'));
			}
			
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been registered.'));
				return $this->redirect(array('action' => 'login'));
			} else {
				$this->Session->setFlash(__('The user could not be registered. Please, try again.'));
			}
		}
	}

/**
 * profile method
 *
 * @throws NotFoundException
 * @return void
 */
	public function profile() {
		$id = $this->Auth->user('id');
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if($this->request->data['User']['password'] != $this->request->data['User']['c_password']) {
				$this->Session->setFlash(__('The password doesn\'t match.'));
				return $this->redirect(array('action' => 'profile'));
			}
			
			if($this->request->data['User']['password'] == '') {
				unset($this->request->data['User']['password']);
			}
			
			if ($this->User->save($this->request->data, false)) {
				$this->Session->setFlash(__('The user has been saved.'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}
}
