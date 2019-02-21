<?php $title = htmlspecialchars($post['title']); ?>

<?php ob_start(); ?>
<h1>Mon titre</h1>
<p><a href="index.php">Retour à la liste des billets</a></p>

<div class="article">
    <h3>
        <?= $post['title'] ?>
        <em>le <?= $post['creation_date_fr'] ?></em>
    </h3>
    
    <p>
        <?= $post['content'] ?>
    </p>
</div>

<h2>Commentaires</h2>

<form action="index.php?action=addComment&amp;id=<?= $post['id'] ?>" method="post">
    <div>
        <label for="author">Auteur</label><br />
        <input type="text" id="author" name="author" />
    </div>
    <div>
        <label for="comment">Commentaire</label><br />
        <textarea id="comment" name="comment"></textarea>
    </div>
    <div>
        <input type="submit" />
    </div>
</form>

<?php
while ($comment = $comments->fetch())
{
?>
    <p><strong><?= htmlspecialchars($comment['author']) ?></strong> le <?= $comment['comment_date_fr'] ?></p>
    <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
    <form action="index.php?action=reportComment&amp;id=<?= $comment['id'] ?>&amp;postId=<?= $comment['post_id'] ?>" method="post">
        <div>
            <button type="submit" id="btn_report">Signaler</button>
        </div>
    </form>
<?php
}
?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
