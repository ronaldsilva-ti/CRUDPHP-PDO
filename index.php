<?php
require_once 'classe-pessoa.php';
$p = new Pessoa("cadastro","localhost","root","");

?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>CRUD PESSOAS</title>	
		<link rel="stylesheet" type="text/css" href="estilo.css">	
	</head>

	<body>	
	<?php
	if(isset($_POST['nome']))
	//clicou no botao cadastrar ou atualizar
	{	
	//----------------------------EDITAR--------------------------------------
	if(isset($_GET['cod_update']) && !empty($_GET['cod_update']))
	{
		$cod_upd = addslashes($_GET['cod_update']);
		$nome = addslashes($_POST['nome']);
		$sexo = addslashes($_POST['sexo']);
		$cidade = addslashes($_POST['cidade']);
		if(!empty($nome) && !empty($sexo) && !empty($cidade))
		{//atualizar

			$p->atualizarDados($cod_upd, $nome, $sexo, $cidade);
			header("location: index.php");			
		}
		else
		{
			?>
				<div class="aviso">
					<img src="aviso.png">
					<h4>Preencha todos os campos</h4>					
				</div>
			<?php	
		}

	}
	//----------------------------CADASTRAR--------------------------------------
	else
	{
		$nome = addslashes($_POST['nome']);
		$sexo = addslashes($_POST['sexo']);
		$cidade = addslashes($_POST['cidade']);
		if(!empty($nome) && !empty($sexo) && !empty($cidade))
		{//cadastrar
			if (!$p->cadastrarPessoa($nome, $sexo, $cidade)) 
			{

			?>
				<div class="aviso">
					<img src="aviso.png">
					<h4>Já cadastrado</h4>					
				</div>
			<?php
			}
		}
		else
		{
			?>
				<div class="aviso">
					<img src="aviso.png">
					<h4>Preencha todos os campos</h4>					
				</div>
			<?php			
		}
	}

	}		
	?>	
	<?php
		if(isset($_GET['cod_update']))
		{
			$cod_update = addslashes($_GET['cod_update']);
			$res = $p->buscarDadosPessoa($cod_update);
		}
	?>
		<section id="esquerda">
			<form method="POST">
				<h2>CADASTRAR PESSOA</h2>
				<label for="nome">Nome</label>
				<input type="text" name="nome"  id="" value="<?php if(isset($res)){echo $res['nome'];}?>">
				<label for="sexo">Sexo</label>
				<select name="sexo" id="sexo"  value="<?php if(isset($res)){echo $res['sexo'];}?>">
					<option value="Masculino">Masculino</option>
  					<option value="Feminino">Feminino</option>
				</select>
			
				<label for="cidade">Cidade</label>
				<input type="text" name="cidade" id=""  value="<?php if(isset($res)){echo $res['cidade'];}?>">
				<input type="submit" value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";} ?>">		

			</form>
			
			
		</section>


		<section id="direita">
			<table>
				<tr id="titulo">
					<td>Nome</td>
					<td>Sexo</td>
					<td colspan="2">Cidade</td>
				</tr>

			<?php
			$dados = $p->buscarDados();
			if (count($dados) > 0)
			{
				for ($i=0; $i < count($dados); $i++) {
				echo "<tr>"; 
					foreach ($dados[$i] as $k => $v)
					 {
						if($k != "codcontato" && $k != "data")
						{
							echo "<td>".$v."</td>";
						}
					}
					?>		
				<td>
					<a href="index.php?cod_update=<?php echo $dados[$i]['codcontato'];?>">Editar</a>

					<a href="index.php?codcontato=<?php echo $dados[$i]['codcontato'];?>">Excluir</a>
				</td>
					<?php
				echo "</tr>";
				}

			}	
			else//O banco esta vazio
			{
				?>				
			</table>
				<div class="aviso">					
					<h4>Ainda não há pessoas cadastradas</h4>
				</div>	
			<?php

			}
		?>	
			
		</section>

		
		
	</body>
</html>

<?php
	
	if (isset($_GET['codcontato']))
	{
		$cod_pessoa = addslashes($_GET['codcontato']);
		$p->excluirPessoa($cod_pessoa);
		header("location: index.php");

	}


?>