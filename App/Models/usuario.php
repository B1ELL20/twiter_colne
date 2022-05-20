<?php 

    namespace App\Models;

    use MF\Model\Model;

    class Usuario extends Model{

        private $id;
        private $nome;
        private $email;
        private $senha;

        public function __get($valor) {
            return $this->$valor;
        }

        public function __set($nome, $valor) {
            $this->$nome = $valor;
        }

        public function salvar() {
            $query = 'insert into usuarios (nome, email, senha) values (:nome , :email , :senha)';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue('senha', $this->__get('senha'));
            $stmt->execute();
            
            return $this;
        }

        public function validarCadastro() {
            $valido = true;

            if(strlen($this->__get('nome')) < 3  || strlen($this->__get('email')) < 3  || strlen($this->__get('senha')) < 3) {
                $valido = false;
            }
            return $valido;
        }

        public function getUsuarioEmail() {
            $query = 'select nome, email from usuarios where email = :email';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

?>