<?php

namespace application\models;

use application\core\Model;
use Imagick;

class Account extends Model {

	public function registerValidate($data){	
		if(trim($data['login']) == '') {
			$this->error = 'Введите логин';
			return false;
		}
		if(trim($data['name']) == '') {

			$this->error = 'Введите имя';
			return false;
		}
		if($data['password'] == '') {

			$this->error = 'Введите пароль';
			return false;
		}
		if($data['password_2'] != $data['password']) {

			$this->error = 'Пароли не совпадают';
			return false;
		}
		if(mb_strlen($data['login']) < 3 || mb_strlen($data['login']) > 50) {

			$this->error = 'Логин от 3 до 90 символов';
			return false;
		}
		if (mb_strlen($data['name']) < 2 || mb_strlen($data['name']) > 50){
			
			$this->error = 'Недопустимая длина имени (от 2 до 50)';
			return false;
		}
		if (mb_strlen($data['password']) < 2 || mb_strlen($data['password']) > 20){

			$this->error = 'Пароль от 2 до 20 символов';
			return false;
		}
		return true;
	}

	public function postAdd($post, $id) {
		$params = [
			'id' => '',
			'name' => $post['name'],
			'description' => $post['description'],
			'text' => $post['text'],
			'idUser' => $id,
		];
		$this->db->query('INSERT INTO posts VALUES (:id, :name, :description, :text, :idUser)', $params);
		return $this->db->lastInsertId();
	}

	public function postUploadImage($path, $id) {
		$img = new Imagick($path);
		$img->cropThumbnailImage(200, 200);
		$img->setImageCompressionQuality(80);
		$img->writeImage($_SERVER['DOCUMENT_ROOT'] . '/public/materials/'.$id.'.jpg');
	}
	
	public function postValidate($post, $type) {
		$nameLen = iconv_strlen($post['name']);
		$descriptionLen = iconv_strlen($post['description']);
		$textLen = iconv_strlen($post['text']);
		if ($nameLen < 2 or $nameLen > 100) {
			$this->error = 'Название должно содержать от 3 до 100 символов';
			return false;
		} elseif ($descriptionLen < 3 or $descriptionLen > 100) {
			$this->error = 'Описание должно содержать от 3 до 100 символов';
			return false;
		} elseif ($textLen < 10 or $textLen > 5000) {
			$this->error = 'Текст должнен содержать от 10 до 5000 символов';
			return false;
		}
		/*if (empty($_FILES['img']['tmp_name']) and $type == 'add') {
			$this->error = 'Изображение не выбрано';
			return false;
		} */
		return true;
	}

	public function loginValidate($data){
		if(trim($data['login']) == '') {
			$this->error = 'Введите логин';
			return false;
		}
		if($data['password'] == '') {

			$this->error = 'Введите пароль';
			return false;
		}
		return true;
	}
	public function checkNameExists($name) {
		$params = [
			'name' => $name,
		];
		if ($this->db->column('SELECT id FROM accounts WHERE name = :name', $params)) {
            $this->error = 'Это имя уже используется';
			return false;
        }
        return true;
	}

	public function checkLoginExists($login) {
		$params = [
			'login' => $login,
		];
		if ($this->db->column('SELECT id FROM accounts WHERE login = :login', $params)) {
			$this->error = 'Этот логин уже используется';
			return false;
		}
		return true;
	}

	public function register($post) {
		$params = [
			'id' => '',
            'login' => $post['login'],
            'name' => $post['name'],
			'password' => password_hash($post['password'], PASSWORD_BCRYPT),
			'status' => 1,
		];
		$this->db->query('INSERT INTO accounts VALUES (:id, :login, :name, :password, :status)', $params);
	}

	public function checkData($login, $password) {
		$params = [
			'login' => $login,
		];
		$hash = $this->db->column('SELECT password FROM accounts WHERE login = :login', $params);
		if (!$hash or !password_verify($password, $hash)) {
			return false;
		}
		return true;
	}

	public function login($login) {
		$params = [
			'login' => $login,
		];
		$data = $this->db->row('SELECT * FROM accounts WHERE login = :login', $params);
		$_SESSION['account'] = $data[0];
	}

	public function postEdit($post, $id) {
		$params = [
			'id' => $id,
			'name' => $post['name'],
			'description' => $post['description'],
			'text' => $post['text'],
		];
		$this->db->query('UPDATE posts SET name = :name, description = :description, text = :text WHERE id = :id', $params);
	}

	public function postsCount($id) {
		$params =[
			'id' => $id,
		];
		return $this->db->column('SELECT COUNT(id) FROM posts WHERE idUser = :id', $params);
	}

	public function postsAccountList($route, $id) {
		$max = 10;
		$params = [
			'id' => $id,
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
		];
		return $this->db->row('SELECT * FROM posts WHERE idUser = :id ORDER BY id DESC LIMIT :start, :max', $params);
	}

	public function isPostExists($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->column('SELECT id FROM posts WHERE id = :id', $params);
	}

	public function postDelete($id) {
		$params = [
			'id' => $id,
		];
		$this->db->query('DELETE FROM posts WHERE id = :id', $params);
		if(file_exists('public/materials/'.$id.'.jpg')){
			unlink($_SERVER['DOCUMENT_ROOT'] . '/public/materials/'.$id.'.jpg');
		}
	}

	public function postData($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT * FROM posts WHERE id = :id', $params);
	}
}