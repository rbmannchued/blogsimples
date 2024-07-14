<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifica as credenciais (em um cenário real, você deve verificar as credenciais com segurança e armazenar senhas com hashing)
    if ($username == 'admin' && $password == 'password') { // Troque isso por uma verificação segura
        $_SESSION['logged_in'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Usuário ou senha incorretos.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
         
        <h1>Login</h1>
        <a href="index.php">voltar</a>
    </header>
    
    <main>
        <section>
            <form action="login.php" method="POST">
                <label for="username">Usuário</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Entrar</button>
                <?php if (isset($error)): ?>
                    <p><?php echo $error; ?></p>
                <?php endif; ?>
            </form>
        </section>
    </main>
</body>
</html>
