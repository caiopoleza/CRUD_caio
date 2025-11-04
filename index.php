<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Menu Principal</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; }
        .menu { margin: 50px auto; max-width: 400px; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px #ccc; }
        .menu h1 { text-align: center; margin-bottom: 30px; }
        .menu a { display: block; margin: 15px 0; padding: 12px; background: #007bff; color: #fff; text-align: center; border-radius: 6px; text-decoration: none; font-size: 18px; transition: background 0.2s; }
        .menu a:hover { background: #0056b3; }
    </style>
</head>
<body>
    <?php
        $foxId = rand(1, 122); 
        $foxImg = "https://randomfox.ca/images/" . $foxId . ".jpg";
    ?>
    <div class="menu">
        <h1>Menu Principal</h1>
        <a href="cadastro_usuario.php">Cadastro de Usuários</a>
        <a href="cadastro_tarefa.php">Cadastro de Tarefas</a>
        <a href="gerenciar_tarefas.php">Gerenciar Tarefas</a>

        <img src="<?php echo $foxImg; ?>" alt="Raposa aleatória">
        
    </div>
</body>
</html>
