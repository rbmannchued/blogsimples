<?php
include 'config.php';

// Verifica se o usuário está logado
session_start();
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit;
}

// Adiciona um novo post
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $action = $_POST['action'];
    
    if ($action == 'create') {
        $query = $pdo->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        $query->execute([$title, $content]);
        header('Location: admin.php');
        exit;
    } elseif ($action == 'edit') {
        $id = $_POST['id'];
        $query = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $query->execute([$title, $content, $id]);
        header('Location: admin.php');
        exit;
    } elseif ($action == 'delete') {
        $id = $_POST['id'];
        $query = $pdo->prepare("DELETE FROM posts WHERE id = ?");
        $query->execute([$id]);
        header('Location: admin.php');
        exit;
    }
}

// Carrega um post para edição
$edit_post = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $query = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $query->execute([$id]);
    $edit_post = $query->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração do Blog</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Administração do Blog</h1>
        <nav>
            <a href="index.php">Visite o Blog</a>
            <a href="logout.php">Sair</a>
        </nav>
    </header>
    
    <main>
        <section>
            <h2><?php echo $edit_post ? 'Editar Post' : 'Novo Post'; ?></h2>
            <form action="admin.php" method="POST">
                <input type="hidden" name="action" value="<?php echo $edit_post ? 'edit' : 'create'; ?>">
                <?php if ($edit_post): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_post['id']; ?>">
                <?php endif; ?>
                <label for="title">Título</label>
                <input type="text" id="title" name="title" value="<?php echo $edit_post ? htmlspecialchars($edit_post['title']) : ''; ?>" required>
                <label for="content">Conteúdo</label>
                <textarea id="content" name="content" rows="10" required><?php echo $edit_post ? htmlspecialchars($edit_post['content']) : ''; ?></textarea>
                <button type="submit"><?php echo $edit_post ? 'Atualizar' : 'Criar'; ?></button>
            </form>

            <?php if ($edit_post): ?>
                <form action="admin.php" method="POST" style="margin-top: 20px;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo $edit_post['id']; ?>">
                    <button type="submit" style="background-color: red;">Excluir</button>
                </form>
            <?php endif; ?>
        </section>

        <section>
            <h2>Posts</h2>
            <ul>
                <?php
                $query = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
                $posts = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach ($posts as $post):
                ?>
                    <li>
                        <a href="admin.php?edit=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a>
                        <small>Publicado em <?php echo date('d/m/Y H:i', strtotime($post['created_at'])); ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
</body>
</html>