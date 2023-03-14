<?php

initiate_html_columns();

?>

<?php include 'template/includes/widgets/server_header.php'; ?>


<div class="panel panel-default">
    <div class="panel-body">

        <div id="blog_posts"></div>

    </div>
</div>


<script>
    /* Load the first blog results */
    showMore(0, 'processing/blog_show_more.php', '#blog_posts', '#showMoreBlogPosts');
</script>


<hr class="custom-one" />

<?php include 'template/includes/widgets/server_options.php'; ?>


<script>
$(document).ready(function() {
    /* Delete system */
    $('#comments, #blog_posts').on('click', '.delete', function () {
        /* selector = div to be removed */
        var answer = confirm("<?php echo $language['messages']['confirm_delete']; ?>");

        if (answer) {
            $('html, body').animate({scrollTop: 0}, 'slow');

            var $div = $(this).closest('.media');
            var reported_id = $(this).attr('data-id');
            var type = $(this).attr('data-type');

            /* Post and get response */
            $.post("processing/process_comments.php", "delete=true&reported_id=" + reported_id + "&type=" + type, function (data) {
                var result = JSON.parse(data);

                /* Display success message */
                $('#response').html(result.message).fadeIn('slow');

                if(result.status) {
                    /* Remove comment */
                    $div.fadeOut('slow');
                }

                setTimeout(function () {
                    $("#response").fadeOut('slow');
                }, 5000);
            });
        }
    });
});
</script>