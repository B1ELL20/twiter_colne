<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class AppController extends Action {

        public function timeline() {

            $this->validaAcesso();

            $tweet = Container::getModel('Tweet');

            $tweet->__set('id_usuario', $_SESSION['id']);


            $tweets = $tweet->getAll();

            $this->view->tweets = $tweets;

            $usuario = Container::getModel('Usuario');

            $usuario->__set('id', $_SESSION['id']);

            $dados_usuario = array();

            array_push($dados_usuario ,$usuario->nomeUsuario()['nome'], $usuario->numeroTweets()['numero_tweets'], $usuario->numeroSeguindo()['numero_seguindo'], $usuario->numeroSeguidores()['numero_seguidores']);

            $this->view->dados_user = $dados_usuario;


            $this->render('timeline');
        }

        public function tweet() {

            $this->validaAcesso();
               
            $tweet = Container::getModel('Tweet');
            $tweet->__set('tweet', $_POST['tweet']);
            $tweet->__set('id_usuario', $_SESSION['id']);

            $tweet->salvar();

            header('Location: /timeline');

        }

        public function validaAcesso() {

            session_start();

            if (!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {

                header('Location: /timeline');
            }
        }

        public function quemSeguir() {

            $this->validaAcesso();

            $usuarios = array();

            if (isset($_GET['pesquisarPor'])) {

                $pesquisarPor = $_GET['pesquisarPor'];
                $usuario = Container::getModel('Usuario');
                $usuario->__set('nome', $pesquisarPor);
                $usuario->__set('id', $_SESSION['id']);


                $user = $usuario->getAll();

                $this->view->usuarios = $user;

            } else {

                $pesquisarPor = '';
            }

            $usuario = Container::getModel('Usuario');

            $usuario->__set('id', $_SESSION['id']);

            $dados_usuario = array();

            array_push($dados_usuario ,$usuario->nomeUsuario()['nome'], $usuario->numeroTweets()['numero_tweets'], $usuario->numeroSeguindo()['numero_seguindo'], $usuario->numeroSeguidores()['numero_seguidores']);

            $this->view->dados_user = $dados_usuario;

            $this->render('quemSeguir');

        }

        public function acao() {

            $this->validaAcesso();

            if (isset($_GET['acao']) && isset($_GET['id_usuario'])) {

                $acao = $_GET['acao'];
                $id_usuario_seguindo = $_GET['id_usuario'];

            } else {

                $acao = '';
            }

            $usuario = Container::getModel('Usuario');
            $usuario->__set('id', $_SESSION['id']);

            if ($acao == 'seguir') {

                $usuario->seguirUsuario($id_usuario_seguindo);

            } else if ($acao == 'deixar_de_seguir') {

                $usuario->deixarSeguirUsuario($id_usuario_seguindo);
            }

            header('Location: /quem_seguir');
        }

        public function remover() {

            $tweet =  Container::getModel('Tweet');
            $tweet->removerTweet();

            header('Location: /timeline');
        }

    }
?>