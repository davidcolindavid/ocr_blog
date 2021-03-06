<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Espace admin - Billet simple pour l'Alaska</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="public/css/fonts.css" rel="stylesheet" />
        <link href="public/css/backend.css" rel="stylesheet" /> 
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    </head>
    <body>
        <div id="container">
            <!-- header -->
            <header>
                <h1>Administration</h1>
                <nav>
                    <div id="btn_site"><a href="index.php" target="_blank">Aller sur le site</a></div>
                    <div id="btn_logout"><a href="admin.php?action=logout"><i class="fas fa-times"></i></a></div>
                </nav>
            </header>

            <!-- editor TinyMCE -->
            <form action="<?= $formAction ?>" method="post" class="admin_post_form add_post">
                <input type="text" class="admin_post_title" name="post_title" placeholder="Saisissez votre titre ici" value="<?= htmlspecialchars($formTitle) ?>" />
                <textarea id="post_content" name="post_content" ><?= $formContent ?></textarea>
                <button type="submit" id="btn_post">Envoyer</button>
                <button type="button" id="btn_cancel">Annuler</button>
            </form>

            <!-- tab link posts/comments -->
            <div id="tabs">
                <div id="tab_posts">Billets</div>
                <div id="tab_comments">Commentaires</div>
                <div id="tab_line"></div>
            </div>

            <!-- posts/comments list -->
            <section id="admin">
                <div id="admin_container">
                    <!-- posts -->
                    <div id ="posts_container">
                        <table class="posts_table" >
                            <tbody>
                            <?php
                            while ($data = $posts->fetch())
                            {
                            ?>
                                <tr class="table_details">
                                    <td class="table_edit"><a href="admin.php?action=editPost&amp;id=<?= $data['id'] ?>"><i class="fas fa-edit"></i></a></td>
                                    <td class="table_delete"><a href="admin.php?action=deletePost&amp;id=<?= $data['id'] ?>"><i class="fas fa-times"></i></a></td>
                                    <td class="table_eye"><a href="index.php?action=post&amp;id=<?= $data['id'] ?>" target="_blank"><i class="far fa-eye"></i></a></td>
                                    <td class="table_content">
                                        <div class="title"><?= $data['title'] ?></div>
                                        <div class="date"><?= $data['creation_date_fr'] ?></div>
                                    </td>
                                </tr>
                            <?php
                            }
                            $posts->closeCursor();
                            ?>    
                            </tbody>
                        </table>  
                        
                    </div>
                    
                    <!-- comments -->
                    <div id ="comments_container">
                        <!-- comments reported -->
                        <table class="comments_table comments_table_report_1" >
                            <tbody>
                            <?php
                            while ($commentReported = $commentsReported->fetch())
                            {
                            ?>
                                <tr>
                                    <td class="table_report table_report_1"><a href="admin.php?action=cancelReportComment&amp;id=<?= $commentReported['id'] ?>"><i class="fas fa-flag"></i></a></td>
                                    <td class="table_delete"><a href="admin.php?action=deleteComment&amp;id=<?= $commentReported['id'] ?>"><i class="fas fa-times"></i></a></td>
                                    <td class="table_eye"><a href="index.php?action=post&amp;id=<?= $commentReported['post_id'] ?>" target="_blank"><i class="far fa-eye"></i></a></td>
                                    <td class="table_comment">
                                        <div class="comment"><?= nl2br(htmlspecialchars($commentReported['comment'])) ?></div>
                                        <div class="comment_details">Par <?= htmlspecialchars($commentReported['author']) ?> le <?= $commentReported['comment_date_fr'] ?></div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>    
                            </tbody>
                        </table>  
                        
                        <!-- comments not reported -->
                        <table class="comments_table comments_table_report_0" >
                            <tbody>
                            <?php
                            while ($comment = $comments->fetch())
                            {
                            ?>
                                <tr>
                                    <td class="table_report table_report_0"><i class="far fa-flag"></td>
                                    <td class="table_delete"><a href="admin.php?action=deleteComment&amp;id=<?= $comment['id'] ?>"><i class="fas fa-times"></i></a></td>
                                    <td class="table_eye"><a href="index.php?action=post&amp;id=<?= $comment['post_id'] ?>" target="_blank"><i class="far fa-eye"></i></a></td>
                                    <td class="table_comment">
                                        <div class="comment"><?= nl2br(htmlspecialchars($comment['comment'])) ?></div>
                                        <div class="comment_details">Par <?= htmlspecialchars($comment['author']) ?> le <?= $comment['comment_date_fr'] ?></div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>    
                            </tbody>
                        </table>  
                    </div>
                </div>
            </section>
        </div>

        <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=nb0d4opnyr0m2r8cqzluz18pcienj856no2g6z1guc21ax20"></script>
        <script>
            tinymce.init({
                selector: '#post_content',
                plugins : 'advlist autolink link image lists charmap print preview emoticons',
                selector: 'textarea', // change this value according to your HTML
                menubar: false,
                toolbar: [
                    'undo redo | styleselect | bold italic | alignleft aligncenter alignright | emoticons | link image',
                ]
            });
        </script>
        <script src="https://code.jquery.com/jquery.min.js" ></script>
        <script src="public/js/backend.js"></script>
    </body>
</html>