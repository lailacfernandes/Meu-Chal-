<?php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco_de_dados = "chale";
$tabela_contato = "reserva"; 

$conexao = new mysqli($servidor, $usuario, $senha, $banco_de_dados);

if ($conexao->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conexao->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if ($_POST['email'] !== $_POST['confirmar_email']) {
        die("Erro: Os campos E-mail e Confirme o E-mail devem ser idênticos.");
    }

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $contato = trim($_POST['contato']);
    
    $cpf = trim($_POST['cpf']);

    $sql = "INSERT INTO $tabela_contato (nome, email, contato,cpf) VALUES (?, ?, ?, ?, ?)";
    
    if ($stmt = $conexao->prepare($sql)) {
        
        $stmt->bind_param("sssss", $nome, $email, $contato,  $cpf);
        
        if ($stmt->execute()) {
            echo "<h1>Sucesso!</h1>";
            echo "<p>Sua hospedagem foi reservada na tabela **Reserva** com sucesso!Em caso de desistência,entrar em contato via Whatsapp</p>";
            echo "<p>Nome: **$nome**</p>";
            echo "<p>E-mail: **$email**</p>";
            echo "<p>cpf: **$cpf**</p>";
            echo "<p><a href='index.html'>Voltar para a Home</a></p>";
        } else {
            echo "<h1>Erro!</h1>";
            echo "<p>Erro ao cadastrar:data já preenchida " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<h1>Erro na preparação!</h1>";
        echo "<p>Ocorreu um erro ao preparar a consulta SQL: " . $conexao->error . "</p>";
    }

    $conexao->close();

} else {
    header('Location: reserva.html');
    exit;
}
?>