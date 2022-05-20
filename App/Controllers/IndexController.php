<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {

		$this->render('index');
	}

	public function inscreverse() {

		$this->render('inscreverse');
	}

	public function registrar() {
		echo '<pre>';
		print_r($_POST);
		echo '</pre>';

		$usuario = Container::getModel('usuario');

		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', $_POST['senha']);

		if ($usuario->validarCadastro() && count($usuario->getUsusarioEmail()) == 0) {

			$usuario->salvar();
			$this->render('cadastro');
		
		} else {
			
			$this->render('inscreverse');
		}
		
	}

}


?>