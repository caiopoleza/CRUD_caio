<?php
require_once 'conexao.php';
$msg = "";
if (isset($_POST['acao'])) {
    $id = $_POST['id'];
    if ($_POST['acao'] === 'excluir') {
        $conn->query("DELETE FROM tarefas WHERE id = $id");
        $msg = "Tarefa excluída.";
    } elseif ($_POST['acao'] === 'atualizar') {
        $status = $_POST['status'];
        $prioridade = $_POST['prioridade'];
        $stmt = $conn->prepare("UPDATE tarefas SET status=?, prioridade=? WHERE id=?");
        $stmt->bind_param("ssi", $status, $prioridade, $id);
        $stmt->execute();
        $stmt->close();
        $msg = "Tarefa atualizada.";
    }
}
$tarefas = [
    'a fazer' => [],
    'fazendo' => [],
    'pronto' => []
];
$res = $conn->query("SELECT t.*, u.nome as usuario FROM tarefas t JOIN usuarios u ON t.id_usuario = u.id ORDER BY t.prioridade DESC, t.data_cadastro DESC");
while ($row = $res->fetch_assoc()) {
    $tarefas[$row['status']][] = $row;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Tarefas</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .kanban { display: flex; gap: 20px; }
        .coluna { flex: 1; background: #f4f4f4; padding: 10px; border-radius: 8px; }
        .tarefa { background: #fff; margin-bottom: 10px; padding: 8px; border-radius: 6px; box-shadow: 0 1px 3px #ccc; }
        .tarefa form { display: flex; flex-direction: column; gap: 4px; }
    </style>
</head>
<body>
    <h1>Gerenciar Tarefas</h1>
    <div class="kanban">
        <?php foreach ($tarefas as $status => $lista): ?>
        <div class="coluna">
            <h2><?php echo ucfirst($status); ?></h2>
            <?php foreach ($lista as $t): ?>
            <div class="tarefa">
                <strong><?php echo $t['descricao']; ?></strong><br>
                Setor: <?php echo $t['setor']; ?><br>
                Prioridade: <?php echo ucfirst($t['prioridade']); ?><br>
                Usuário: <?php echo $t['usuario']; ?><br>
                <form method="post" style="margin-top:5px;">
                    <input type="hidden" name="id" value="<?php echo $t['id']; ?>">
                    <select name="status">
                        <option value="a fazer" <?php if($t['status']==='a fazer')echo 'selected';?>>A Fazer</option>
                        <option value="fazendo" <?php if($t['status']==='fazendo')echo 'selected';?>>Fazendo</option>
                        <option value="pronto" <?php if($t['status']==='pronto')echo 'selected';?>>Pronto</option>
                    </select>
                    <select name="prioridade">
                        <option value="baixa" <?php if($t['prioridade']==='baixa')echo 'selected';?>>Baixa</option>
                        <option value="media" <?php if($t['prioridade']==='media')echo 'selected';?>>Média</option>
                        <option value="alta" <?php if($t['prioridade']==='alta')echo 'selected';?>>Alta</option>
                    </select>
                    <button type="submit" name="acao" value="atualizar">Atualizar</button>
                    <button type="submit" name="acao" value="excluir" onclick="return confirm('Confirma excluir?')">Excluir</button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <p><?php echo $msg; ?></p>
    <a href="index.php">Voltar ao menu</a>
</body>
</html>
