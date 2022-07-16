<?php

function limpar_texto($str){ 
  return preg_replace("/[^0-9]/", "", $str); 
}

$erro =  false;
if(count($_POST) > 0){
    
    include('conexao.php');

	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$telefone = $_POST['telefone'];
	$nascimento = $_POST['nascimento'];

	if (empty($nome)) {
		$erro = "Preencha nome por favor";
	}

	if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
	   
		$erro = "Preencha email por favor";
	    }


	if(!empty($nascimento)){
		$pedacos = explode('/', $nascimento);
		if(count($pedacos) == 3){ 
			$nascimento = implode ('-', array_reverse($pedacos));
		}else{

			$erro = "A data de nascimento deve seguir o padrão dia-mês-ano";
		}

	}

	if(!empty($telefone)) {
		$telefone = limpar_texto($telefone);
		if(strlen($telefone) != 11)
			$erro = "O telefone deve ser preenchido no padrão (98) 98888-8888 ";
		
	}

	if($erro){
		echo "<p><b>ERRO:$erro</b></p>";
	 }else{

	 $sql_code = "INSERT INTO clientes (nome, email, telefone, nascimento, data) 
	 	VALUES('$nome', '$email', '$telefone', '$nascimento', NOW())";
	 	$deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
	 	if($deu_certo){
	 		echo "<p><b>Usuário cadastrado com sucesso</b></p>";
	 		unset($_POST);
	 	}

	 }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cadastro de clientes</title>
</head>
<body>
	<a href="">Voltar para lista</a><br><br>
	<form action="" method="POST">

		<label>Nome:</label>
		<input value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" type=" text" name="nome"><br><br>
		<label>Email:</label>
		<input value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"type=" text" name="email"><br><br>
		<label>Telefone:</label>
		<input value="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>"placeholder= "(98) 8888-8888" 
		type=" text" name="telefone"><br><br>
		<label>Data de nascimento:</label>
		<input value="<?php if(isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>"  type="text" name="nascimento"><br><bb><br>
		
		<button input = "submit" >Cadastrar clientes</button>
	</form>
	
	
	
</body>
</html>