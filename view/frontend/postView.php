<?php $title = htmlspecialchars($post['title']); ?>

<?php ob_start(); ?>

<div class="container container_single_post">
    <div class="row single_post_top">
        <div class="back col-6">
            <a href="index.php">Retour à la liste des billets</a>
        </div>
        <div class="comments_target col-6">
            <a href="#container_comment_form">Voir les commentaires</a>
        </div>
    </div>
</div>
    

<section class="single_post">
    <div class="container">
        <div class="row">
            <div class="single_post_title col-sm-12">
                <h2><?= $post['title'] ?></h2>
            </div>

            <div class="single_post_content col-sm-12">
                <?= $post['content'] ?>
            </div>

            <div class="single_post_date col-sm-12">
                Publié le <?= $post['creation_date_fr'] ?>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid container_comment_form">
        <form class="row comment_form" action="index.php?action=addComment&amp;id=<?= $post['id'] ?>" method="post">
            <div class="col-lg-6">
                <input type="text" id="author" name="author" placeholder="Nom" />
                <textarea id="comment" name="comment" placeholder="Votre Commentaire"></textarea>
            </div>

            <div class="col-lg-6 btn_send_container">
                <button id="btn_send">Envoyer</button>
            </div>
        </form>
    </div>

    
    <div class="container container_comments">
        <?php
        while ($comment = $comments->fetch())
        {
        ?>
            <div class="single_comment">
            <div class="row">
                <div class="col-7 comment_details"><?= htmlspecialchars($comment['author']) ?>, <?= $comment['comment_date_fr'] ?></div>
                <form class="col-5 col_report" action="index.php?action=reportComment&amp;id=<?= $comment['id'] ?>&amp;postId=<?= $comment['post_id'] ?>" method="post">
                    <button type="submit" class="btn_report">Signaler</button>
                </form>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="comment_sent"><?= nl2br(htmlspecialchars($comment['comment'])) ?></div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
    
</section>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
