<?php

		Class Pessoa{

			private $p;

			//Conexao com banco de dados
			public function __construct($dbname,$host,$user,$senha)
			{

				try{
					$this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
				}
				catch (PDOException $e){
				echo "Erro no banco de dados: ".$e->getMessage();

				}
				catch (Exception $e){
				echo "Erro Generico :".$e->getMessage();
				exit();
				
				}
			}

			//BUSCAR DADOS E MOSTRAR NO CAMPO DIREITO
			public function buscarDados()
			{
				$res = array();
				$cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
				$res = $cmd->fetchAll(PDO::FETCH_ASSOC);
				return $res;
			}

			//Função cadastrar pessoa no Banco de Dados
			public function cadastrarPessoa($nome, $sexo, $cidade){

			//Verificar se há nomes iguais completos cadastros
			$cmd = $this->pdo->prepare("SELECT codcontato FROM pessoa WHERE nome = :n");
			$cmd->bindValue(":n", $nome);
			$cmd->execute();
			if ($cmd->rowCount() > 0) {  //Se nome já existe
				return false;				
			}else//Se nome não foi encontrado
			{
				$cmd = $this->pdo->prepare("INSERT INTO pessoa (nome, sexo, cidade, data) VALUES (:n, :s, :c, NOW())");
				$cmd->bindValue(":n",$nome);
				$cmd->bindValue(":s",$sexo);
				$cmd->bindValue(":c",$cidade);
				$cmd->execute();
				return true;
			}

		}

			//EXCLUIR PESSOA
		function excluirPessoa($codcontato){
			
				$cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE codcontato = :id");
				$cmd->bindValue(":id",$codcontato);
				$cmd->execute();
			}

			//BUSCAR DADOS PESSOA
		public function buscarDadosPessoa($codcontato)
		{
			$res = array();
			$cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE codcontato = :id");
			$cmd->bindValue(":id",$codcontato);
			$cmd->execute();
			$res = $cmd->fetch(PDO::FETCH_ASSOC);
			return $res;

		}
			//ATUALIZAR DADOS PESSOA
		public function atualizarDados($codcontato, $nome, $sexo, $cidade)
		{	

			$cmd = $this->pdo->prepare("UPDATE pessoa SET nome = :n, sexo = :s, cidade = :c WHERE codcontato = :id");
			$cmd->bindValue(":n",$nome);
			$cmd->bindValue(":s",$sexo);
			$cmd->bindValue(":c",$cidade);
			$cmd->bindValue(":id",$codcontato);
			$cmd->execute();
			return true;
	}

		public function contarDados(){
			//Total de registros

			$contar = $conn->prepare("SELECT COUNT(codcontato) FROM pessoa");
			$contar->execute();
			$total = $contar->fetch(PDO::FETCH_OBJ);
			echo $total_de_registros = $total->totalReg;
		}
}

?>