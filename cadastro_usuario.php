<?php
require_once 'conexao.php';
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    if ($nome && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $nome, $email);
        if ($stmt->execute()) {
            $msg = "Cadastro concluído com sucesso";
        } else {
            $msg = "Erro ao cadastrar usuário.";
        }
        $stmt->close();
    } else {
        $msg = "Preencha todos os campos corretamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuários</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Cadastro de Usuários</h1>
    <form method="post">
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br>
        <label>E-mail:</label><br>
        <input type="email" name="email" required><br>
        <button type="submit">Cadastrar</button>
    </form>
    <p><?php echo $msg; ?></p>
    <a href="index.php">Voltar ao menu</a>
</body>
</html>
