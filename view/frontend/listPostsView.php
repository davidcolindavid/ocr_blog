<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>
<h1>Mon titre</h1>
<p>Derniers billets du blog :</p>

<div id="listposts">
<?php
while ($data = $posts->fetch())
{
?>
    <div class="article">
        <h3>
            <?= $data['title'] ?>
            <em>le <?= $data['creation_date_fr'] ?></em>
        </h3>
        
        <p>
            <?= $data['content'] ?>
            <br />
            <em><a href="index.php?action=post&amp;id=<?= $data['id'] ?>">Commentaires</a></em>
        </p>
    </div>
<?php
}
$posts->closeCursor();
?>
</div>

<div id="paging">
<?php
for ($i = 1; $i <= $nbPage; $i++) {
    if ($i == $currentPage) {
        echo " $i /";
    }
    else {
        echo " <a href=\"index.php?action=page&amp;id=$i\">$i</a> /";
    }
}
?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>