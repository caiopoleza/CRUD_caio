<?php
require_once 'conexao.php';
$msg = "";
$usuarios = $conn->query("SELECT id, nome FROM usuarios ORDER BY nome");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $descricao = trim($_POST['descricao']);
    $setor = trim($_POST['setor']);
    $prioridade = $_POST['prioridade'];
    $data_cadastro = date('Y-m-d');
    $status = 'a fazer';
    if ($id_usuario && $descricao && $setor && $prioridade) {
        $stmt = $conn->prepare("INSERT INTO tarefas (id_usuario, descricao, setor, prioridade, data_cadastro, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $id_usuario, $descricao, $setor, $prioridade, $data_cadastro, $status);
        if ($stmt->execute()) {
            $msg = "Cadastro concluído com sucesso";
        } else {
            $msg = "Erro ao cadastrar tarefa.";
        }
        $stmt->close();
    } else {
        $msg = "Preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Tarefas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Cadastro de Tarefas</h1>
    <form method="post">
        <label>Usuário:</label><br>
        <select name="id_usuario" required>
            <option value="">Selecione</option>
            <?php while($u = $usuarios->fetch_assoc()): ?>
                <option value="<?php echo $u['id']; ?>"><?php echo $u['nome']; ?></option>
            <?php endwhile; ?>
        </select><br>
        <label>Descrição:</label><br>
        <input type="text" name="descricao" required><br>
        <label>Setor:</label><br>
        <input type="text" name="setor" required><br>
        <label>Prioridade:</label><br>
        <select name="prioridade" required>
            <option value="baixa">Baixa</option>
            <option value="media">Média</option>
            <option value="alta">Alta</option>
        </select><br>
        <button type="submit">Cadastrar</button>
    </form>
    <p><?php echo $msg; ?></p>
    <a href="index.php">Voltar ao menu</a>
</body>
</html>
