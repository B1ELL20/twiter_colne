<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {


		if(isset($_GET['login'])) {
			$this->view->login = $_GET['login'];
		} else {
			$this->view->login = '';
		}

		$this->render('index');
		
	}

	public function inscreverse() {

		$this->view->usuario = array(
			'nome' => '',
			'email' => '',
			'senha' => ''

		);

		$this->view->errocadastro = false;
		$this->render('inscreverse');
		
	}

	public function registrar() {

		$usuario = Container::getModel('usuario');

		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', $_POST['senha']);

		if ($usuario->validarCadastro() && count($usuario->getUsuarioEmail()) == 0) {

			$usuario->salvar();
			$this->render('cadastro');
		
		} else {

			$this->view->usuario = array(
				'nome' => $_POST['nome'],
				'email' => $_POST['email'],
				'senha' => $_POST['senha']

			);

			$this->view->errocadastro = true;
			
			$this->render('inscreverse');
		}
		
	}

}


?>