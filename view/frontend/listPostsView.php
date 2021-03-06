<?php $title = "Billet simple pour l'Alaska"; ?>

<?php ob_start(); ?>

<?php 
$index = 0
?>

<!-- about the blog -->
<section class="blog_intro">
    <div class="container-fluid">
        <div class="row">
            <div id="blog_author" class="col-10"><h2>Roman de Jean Forteroche</h2></div>
            <div id="plus" class="col-1"><i class="fas fa-plus"></i></div>
        </div>

        <div class="row blog_description">
            <div class="col-lg-12">
                Pandente itaque viam fatorum sorte tristissima, qua praestitutum erat eum vita et imperio spoliari, 
                itineribus interiectis permutatione iumentorum emensis venit Petobionem oppidum Noricorum, ubi reseratae sunt insidiarum 
                latebrae omnes, et Barbatio repente apparuit comes.
            </div>
        </div>
    </div>
</section>


<!-- container of the first two posts -->
<section class="container-fluid listPostsContainer1">
    <div class="cache1"></div>
</section>

<!-- container of the last two posts -->
<section class="container-fluid listPostsContainer2">
    <div class="cache2"></div>
</section>

<!-- get the posts -->
<?php
while ($data = $posts->fetch())    
{
?>
<?php $index = $index + 1 ?>
    <div class="post<?= $index ?> col-lg-6">
        <div class="row content_top col-lg-12">
            <div class="title col-lg-12" >
                <h3>
                <a href="index.php?action=post&amp;id=<?= $data['id'] ?>"><?= $data['title'] ?></a>
                </h3>
            </div>
        </div>
        
        <div class="col-lg-12">                
            <div class="row">
                <div class="post_content offset-md-1 col-md-10">
                    <div class="content" >
                        <?php 
                        // get an extract of the post (950 characters)
                        $extract = substr($data['content'], 0, 950);
                        // find the last space after the last word $extract
                        $space = strrpos($extract, ' ');
                        // get the $extract including the last space
                        if (strlen($extract) < 950) {
                            echo $extract;
                        } else {
                            echo substr($extract, 0, $space) . ' <a href="index.php?action=post&amp;id=' . $data['id'] . '">...</a>';
                        }
                        ?>
                    </div>
                        
                </div>
            </div>
        </div>

        <div class="row content_bottom col-lg-12">
            <div class="folio col-lg-12" >
            <?php
                // number of the post
                $folio = $folio -1;
                echo ($folio);
            ?>
            </div>
            <div class="post_content_date col-6">
                <p><?= $data['creation_date_fr'] ?></p>
            </div>

            <div class="post_content_read_more col-6">
                <p><a href="index.php?action=post&amp;id=<?= $data['id'] ?>">lire plus</a></p>
            </div>
         </div>

    </div>
<?php
}
$posts->closeCursor();
?>

<!-- slider contact -->
<section class="contact">
    <div class="contact_container">
        
        <div class="contact_link">
            <div class="contact_col1">
                <div id="contact_text">Me laisser un message</div>
            </div>

            <div class="contact_col2">
                <div id="btn_contact">Contact</div>
            </div>
        </div>

        <form class="contact_send" action="index.php?action=sendEmail" method="post">
            <div class="contact_col3">
                <input type="text" name="email" id="email" placeholder="Email">
                <textarea id="message" name="message" placeholder="Votre message"></textarea>
            </div>

            <div class="contact_col4">
                <button type="submit" id="btn_send">Envoyer</button>
            </div>
        </form>
    </div>
    <div class="contact_message">Email envoyé</div>
</section>

<!-- pagination -->
<footer class="container-fluid">
    <div class="row">
        <div class="pagination_prev col-2">
        <?php
        // go to previous page
        $prev = $currentPage - 1;
        if ($prev != 0) {
            echo "<a href=\"index.php?action=page&amp;id=$prev\"><i class=\"btn_prev fas fa-long-arrow-alt-left\"></i></a>";
        }
        ?>
        </div>

        <div class="pagination_pages col-8">
        <?php
        // pages links
        for ($i = 1; $i <= $nbPage; $i++) {
            if ($i == $currentPage) {
                echo "<div class=\"page_item_current\">$i</div>";
            }
            else {
                echo "<div class=\"page_item\"><a href=\"index.php?action=page&amp;id=$i\">$i</a></div>";
            }
        }
        ?>
        </div>

        <div class="pagination_next col-2">
        <?php
        // go to next page
        $next = $currentPage + 1;
        if ($next <= $nbPage) {
            echo "<a href=\"index.php?action=page&amp;id=$next\"><i class=\"btn_next fas fa-long-arrow-alt-right\"></i></a>";
        }
        ?>
        </div>
    </div>
</footer>



<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>