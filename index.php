<?php
include 'config.php';
include 'header.php';

$query = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <section>
        <?php foreach ($posts as $post): ?>
            <article>
                <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars(substr($post['content'], 0, 400))) . '...'; ?></p>
                <a href="post.php?id=<?php echo $post['id']; ?>">Leia mais</a>
            </article>
        <?php endforeach; ?>
    </section>
</main>

<?php include 'footer.php'; ?>