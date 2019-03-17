// Tabs system: slide to the posts or the comments
document.querySelector("#tab_comments").addEventListener('click', function () {
    document.querySelector("#admin_container").style.transition = 'transform 0.3s' 
    document.querySelector("#admin_container").style.transform = 'translate3D(-50%,0,0)' 

    document.querySelector("#tab_line").style.transition = 'transform 0.3s' 
    document.querySelector("#tab_line").style.transform = 'translate3D(100%,0,0)' 
})

document.querySelector("#tab_posts").addEventListener('click', function () {
    document.querySelector("#admin_container").style.transition = 'transform 0.3s' 
    document.querySelector("#admin_container").style.transform = 'translate3D(0,0,0)' 

    document.querySelector("#tab_line").style.transition = 'transform 0.3s' 
    document.querySelector("#tab_line").style.transform = 'translate3D(0,0,0)' 
})


// Add a post
$("#container").on('submit', '.add_post', function(e) {
    e.preventDefault();
    let formElt = $(this);
    let url = formElt.attr('action');

    let titleElt = document.querySelector(".admin_post_title")
    // report if title empty
    if (titleElt.value.trim().length === 0) {
        titleElt.style.backgroundColor = "rgb(53, 234, 165)";
        titleElt.addEventListener("focus", function () {
            titleElt.style.backgroundColor = "#ffffff";
        }) 
    } else {
        $.ajax({
            type: "POST",
            url: url,
            data: formElt.serializeArray(),
            dataType: 'JSON',
            success: function(data) {
                // add a new row to the table
                $('<tr class="table_details"></tr>').prependTo('.posts_table tbody').hide();
                $('.posts_table tbody').find(':first').append('<td class="table_edit"><a href="admin.php?action=editPost&amp;id=' + data[0] + '"><i class="fas fa-edit"></i></a></td>');
                $('.posts_table tbody').find(':first').append('<td class="table_delete"><a href="admin.php?action=deletePost&amp;id=' + data[0] + '"><i class="fas fa-times"></i></a></td>');
                $('.posts_table tbody').find(':first').append('<td class="table_eye"><a href="index.php?action=post&amp;id=' + data[0] + '" target="_blank"><i class="far fa-eye"></i></a></td>');
                $('.posts_table tbody').find(':first').append('<td class="table_content"><div class="title">' + data[1] + '</div><div class="date">' + data[2] + '</div></td>');
                $('.posts_table tbody').find(':first').fadeIn();
                $(".admin_post_form")[0].reset()
            },
        })
    }
});


// Edit a post
$('#admin_container').on('click', '.table_edit', function(e) {
    e.preventDefault();
    let editElt = $(this);
    let url = editElt.find(':first').attr('href');
    
    $.ajax({
        type: "GET",
        url: url,
        data: editElt.serializeArray(),
        dataType: 'JSON',
        success: function(data) {
            $('html,body').animate({scrollTop: ( $(".admin_post_form").offset().top - $("#bar").height() )}, '300');
            // add data to fields of the form
            $('.admin_post_title').val(data[0]);
            top.tinyMCE.get('post_content').setContent(data[1]);   
            // modify the form to update the post
            $(".admin_post_form").addClass("update_post" );
            $(".admin_post_form").removeClass("add_post");  
            $('.admin_post_form').attr('action', data[2]);
            $('#btn_post').text('Modifier');
            // add ID to find the title to update
            $('#admin_container').find("#postToEdit").removeAttr('id', 'postToEdit');
            editElt.parents('.table_details').attr('id', 'postToEdit');
        },
    })
});


// Update a post
$("#container").on('submit', '.update_post', function(e) {
    e.preventDefault();
    let formElt = $(this);
    let url = formElt.attr('action');
    
    $.ajax({
        type: "POST",
        url: url,
        data: formElt.serializeArray(),
        dataType: 'JSON',
        success: function(data) {
            // modify the title
            $('#admin_container').find("#postToEdit").fadeTo(300, 0);
            $('#admin_container').find("#postToEdit").fadeTo(300, 1)
            setTimeout(function() { 
                $('#admin_container').find("#postToEdit .title").html(data[0]);
                $('#admin_container').find("#postToEdit").removeAttr('id', 'postToEdit');
            }, 300);
            // after update, modify the form to add a post
            $(".admin_post_form").removeClass("update_post" );
            $(".admin_post_form").addClass("add_post");
            $(".admin_post_form")[0].reset();
            formElt.attr('action', 'admin.php?action=addPost');
            $('#btn_post').text('Envoyer');
        },
    })
});


// Cancel the form
$("#container").on('click', '#btn_cancel', function(e) {
    if ($('.admin_post_form').hasClass('update_post')) {
        $(".admin_post_form").removeClass("update_post" );
        $(".admin_post_form").addClass("add_post");
    }
    $(".admin_post_form").attr('action', 'admin.php?action=addPost');
    $(".admin_post_form")[0].reset();
    $('#btn_post').text('Envoyer');
});


// Delete a post and its comments
$('#admin_container').on('click', '.table_delete', function(e) {
    e.preventDefault();
    let deleteElt = $(this);
    let url = deleteElt.find(':first').attr('href');
    
    $.ajax({
        type: "POST",
        url: url,
        data: deleteElt.serializeArray(),
        success: function() {
            deleteElt.parents('tr').fadeOut();
        },
    })
});


// Cancel the report of a comment
$('#admin_container').on('click', '.table_report_1', function(e) {
    e.preventDefault();
    let reportElt = $(this);
    let url = reportElt.find(':first').attr('href');
    
    $.ajax({
        type: "POST",
        url: url,
        data: reportElt.serializeArray(),
        success: function() {
            // move the comment to the table below
            reportElt.addClass('table_report_0').removeClass('table_report_1')
            $(reportElt).html('<i class="far fa-flag">');
        },
    })
});