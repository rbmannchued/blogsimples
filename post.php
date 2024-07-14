<?php
include 'config.php';
include 'header.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$query->execute([$id]);
$post = $query->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    echo 'Post não encontrado.';
    exit;
}
?>

<main>
    <article>
        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
    </article>
</main>

<?php include 'footer.php'; ?>