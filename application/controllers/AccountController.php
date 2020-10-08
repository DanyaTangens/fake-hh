<?php

namespace application\controllers;
use application\core\Controller;
use application\lib\Pagination;
use application\models\Account;

class AccountController extends Controller {

	public function __construct($route) {
		parent::__construct($route);
		$this->view->layout = 'account';
	}
	// Регистрация

	public function registerAction() {
		if (!empty($_POST)) {
			if (!$this->model->registerValidate($_POST)) {
				$this->view->message('error1', $this->model->error);
			}
			elseif (!$this->model->checkNameExists($_POST['name'])) {
				$this->view->message('error2', $this->model->error);
			}
			elseif (!$this->model->checkLoginExists($_POST['login'])) {
				$this->view->message('error', $this->model->error);
			} 
			$this->model->register($_POST);
			$this->view->message('success', 'Регистрация завершена');
			$this->view->redirect('account/login');
		}	
		$this->view->render('Регистрация');	
	}

	// Вход

	public function loginAction() {
		if (!empty($_POST)) {
			if (isset($_SESSION['account'])) {
				$this->view->redirect('account/add');
			}
			if (!$this->model->loginValidate($_POST)) {
				$this->view->message('error', $this->model->error);
			}
			elseif (!$this->model->checkData($_POST['login'], $_POST['password'])) {
				$this->view->message('error', 'Логин или пароль указан неверно');
			}
			$this->model->login($_POST['login']);
			$this->view->location('account/add');
		}
		$this->view->render('Вход');
	}

	// Профиль

	public function profileAction() {
		if (!empty($_POST)) {
			if (!$this->model->validate(['name'], $_POST)) {
				$this->view->message('error', $this->model->error);
			}
			$id = $this->model->checkNameExists($_POST['name']);
			if ($id and $id != $_SESSION['account']['id']) {
				$this->view->message('error', 'Этот E-mail уже используется');
			}
			if (!empty($_POST['password']) and !$this->model->validate(['password'], $_POST)) {
				$this->view->message('error', $this->model->error);
			}
			$this->model->save($_POST);
			$this->view->message('error', 'Сохранено');
		}
		$this->view->render('Профиль');
	}

	//Выход

	public function logoutAction() {
		unset($_SESSION['account']);
		$this->view->redirect('account/login');
	}

	//Добавление нового резюме

	public function addAction() {
		if (!empty($_POST)) {
			if (!$this->model->postValidate($_POST, 'add')) {
				$this->view->message('error', $this->model->error);
			}
			$id = $this->model->postAdd($_POST,$_SESSION['account']['id']);
			if (!$id) {
				$this->view->message('success', 'Ошибка обработки запроса');
			}
			if (!empty($_FILES['img']['tmp_name'])){
				$this->model->postUploadImage($_FILES['img']['tmp_name'], $id);
			}
			$this->view->message('success', 'Резюме размещено');
		}
		$this->view->render('Создать новое резюме');
	}
	
	//Просмотр созданных резюме (конкретным пользователем)
	public function postsAction() {
		$accModel = new Account;
		$pagination = new Pagination($this->route, $accModel->postsCount($_SESSION['account']['id']));
		$vars = [
			'pagination' => $pagination->get(),
			'list' => $accModel->postsAccountList($this->route, $_SESSION['account']['id']),
		];
		$this->view->render('Посты', $vars);
	}

	//удаление резюме
	public function deleteAction() {
		if (!$this->model->isPostExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$this->model->postDelete($this->route['id']);
		$this->view->redirect('account/posts');
	}

	//Изменения в резюме
	public function editAction() {
		if (!$this->model->isPostExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		if (!empty($_POST)) {
			if (!$this->model->postValidate($_POST, 'edit')) {
				$this->view->message('error', $this->model->error);
			}
			$this->model->postEdit($_POST, $this->route['id']);
			/*if ($_FILES['img']['tmp_name']) {
				$this->model->postUploadImage($_FILES['img']['tmp_name'], $this->route['id']);
			}*/
			$this->view->message('success', 'Сохранено');
		}
		$vars = [
			'data' => $this->model->postData($this->route['id'])[0],
		];
		$this->view->render('Редактировать пост', $vars);
	}
}