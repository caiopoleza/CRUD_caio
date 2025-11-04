<?php
require_once 'conexao.php';
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    if ($nome && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($senha)) {
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $msg = "E-mail já cadastrado.";
        } else {
            $stmt->close();
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nome, $email, $senha_hash);
            if ($stmt->execute()) {
                $msg = "Cadastro concluído com sucesso";
            } else {
                $msg = "Erro ao cadastrar usuário.";
            }
            $stmt->close();
        }
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
        <label>Senha:</label><br>
        <input type="password" name="senha" required><br>
        <button type="submit">Cadastrar</button>
    </form>
    <p><?php echo $msg; ?></p>
    <a href="index.php">Voltar ao menu</a>
</body>
</html>
