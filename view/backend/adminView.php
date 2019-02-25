<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Administration</title>
        <link href="public/css/style.css" rel="stylesheet" /> 
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    </head>
    <body>
        <h1>Administration</h1>
        <div id="admin_logout"><a href="admin.php?action=logout">Se déconnecter</a><div>

        <?php 
        if (isset($_GET['action']) == 'editPost') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $formTitle = $form['title'];
                $formContent = $form['content'];
                $formAction = "admin.php?action=updatePost&amp;id=" . $form['id'];
            }
            
        }
        else {
            $formTitle = "";
            $formContent = "Exprimez-vous";
            $formAction = "admin.php?action=addPost";
        }
        ?>

        <form action="<?= $formAction ?>" method="post" class="admin_post_form">
            <input type="text" class="admin_post_title" name="post_title" placeholder="Saisissez votre titre ici" value="<?= htmlspecialchars($formTitle) ?>" />
            <textarea id="post_content" name="post_content" ><?= $formContent ?></textarea>
            <button type="submit" id="btn_post">Envoyer</button>
        </form>

        <div id="tabs">
            <div id="tab_posts">Billets</div>
            <div id="tab_comments">Commentaires</div>
            <div id="tab_line"></div>
        </div>

        
        <?php        
        ?>
        <section id="admin_container">
            <div id ="posts_container">
                
                <table class="posts_table" >
                    <tbody>
                    <?php
                    // Affichage de chaque message
                    while ($data = $posts->fetch())
                    {
                    ?>
                        <tr class="table_details">

                            <td class="table_delete"><a href="admin.php?action=deletePost&amp;id=<?= $data['id'] ?>"><i class="fas fa-times"></i></a></td>
                            <td class="table_edit"><a href="admin.php?action=editPost&amp;id=<?= $data['id'] ?>"><i class="fas fa-edit"></i></a></td>
                            <td class="table_eye"><a href="index.php?action=post&amp;id=<?= $data['id'] ?>" target="_blank"><i class="far fa-eye"></i></a></td>
                            <td class="table_title"><?= $data['title'] ?></td>
                            <td class="table_date"><?= $data['creation_date_fr'] ?></td>
                        </tr>
                        <tr class="table_detail_content">
                            <td class="table_content" colspan="5"><?= $data['content'] ?></td>
                        </tr>
                    <?php
                    }
                    $posts->closeCursor();
                    ?>    
                    </tbody>
                </table>  
                
            </div>

            <div id ="comments_container">

                <table class="comments_table" >
                    <tbody>
                    <?php
                    while ($commentReported = $commentsReported->fetch())
                    {
                    ?>
                        <tr>
                            <td class="table_report"><a href="admin.php?action=cancelReportComment&amp;id=<?= $commentReported['id'] ?>"><i class="fas fa-flag"></i></a></td>
                            <td class="table_delete"><a href="admin.php?action=deleteComment&amp;id=<?= $commentReported['id'] ?>"><i class="fas fa-times"></i></a></td>
                            <td class="table_eye"><a href="index.php?action=post&amp;id=<?= $commentReported['post_id'] ?>" target="_blank"><i class="far fa-eye"></i></a></td>
                            <td class="table_comment">
                                Par <?= htmlspecialchars($commentReported['author']) ?> le <?= $commentReported['comment_date_fr'] ?> <br /><br />
                                <?= nl2br(htmlspecialchars($commentReported['comment'])) ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>    
                    </tbody>
                </table>  

                <table class="comments_table" >
                    <tbody>
                    <?php
                    while ($comment = $comments->fetch())
                    {
                    ?>
                        <tr>
                            <td class="table_report"><i class="far fa-flag"></td>
                            <td class="table_delete"><a href="admin.php?action=deleteComment&amp;id=<?= $commentReported['id'] ?>"><i class="fas fa-times"></i></a></td>
                            <td class="table_eye"><a href="index.php?action=post&amp;id=<?= $comment['post_id'] ?>" target="_blank"><i class="far fa-eye"></i></a></td>
                            <td class="table_comment">
                                Par <?= htmlspecialchars($comment['author']) ?> le <?= $comment['comment_date_fr'] ?> <br /><br />
                                <?= nl2br(htmlspecialchars($comment['comment'])) ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>    
                    </tbody>
                </table>  

            </div>
        </section>

        <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=nb0d4opnyr0m2r8cqzluz18pcienj856no2g6z1guc21ax20"></script>
        <script>
            tinymce.init({
                selector: '#post_content',
                plugins : 'advlist autolink link image lists charmap print preview emoticons',
                menubar: false,
                toolbar: [
                    'undo redo | styleselect | bold italic | alignleft aligncenter alignright | emoticons | link image',
                ]
            });
        </script>
        <script src="public/js/app.js"></script>
    </body>
</html>