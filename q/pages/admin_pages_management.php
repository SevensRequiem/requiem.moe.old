<?php
User::check_permission(1);

if(isset($_GET['delete'])) {

    /* Check for errors */
    if(!$token->is_valid()) {
        $_SESSION['error'][] = $language['errors']['invalid_token'];
    }

    if(empty($_SESSION['error'])) {

        /* Delete page */
        $database->query("DELETE FROM `pages` WHERE `page_id` = {$_GET['delete']}");

        /* Set the success message & redirect*/
        $_SESSION['success'][] = $language['messages']['success'];
        User::get_back('admin/pages-management');
    }
}

if(!empty($_POST)) {
    /* Define some variables */
    $_POST['title']				 		= Database::clean_string($_POST['title']);
    $_POST['url']						= generate_slug(Database::clean_string($_POST['url']));
    $required_fields = array('title', 'url', 'description');


    /* Check for the required fields */
    foreach($_POST as $key=>$value) {
        if(empty($value) && in_array($key, $required_fields) == true) {
            $_SESSION['error'][] = $language['errors']['marked_fields_empty'];
            break 1;
        }
    }


    /* If there are no errors continue the updating process */
    if(empty($_SESSION['error'])) {

        Database::insert(
            'pages',
            [
                'title' => $_POST['title'],
                'url'   => $_POST['url'],
                'description' => $_POST['description']
            ],
            false
        );


        $_SESSION['success'][] = $language['messages']['success'];
    }

    display_notifications();

}


initiate_html_columns();

?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Url</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $result = $database->query("SELECT * FROM `pages` ORDER BY `page_id` ASC");
                while($page = $result->fetch_object()) {
                    ?>
                    <tr>
                        <td><?php echo $page->title; ?></td>
                        <td><a href="page/<?php echo $page->url; ?>"><?php echo $page->url; ?></td>
                        <td>
                            <a href="admin/edit-page/<?php echo $page->page_id; ?>" class="no-underline"><span class="label label-info">Edit <span class="glyphicon glyphicon-wrench white"></span></span></a>

                            &nbsp;<a data-confirm="<?php echo $language['messages']['category_confirm_delete']; ?>" href="admin/pages-management?delete=<?php echo $page->page_id . '&token=' . $token->hash; ?>" class="no-underline"><span class="label label-danger"><?php echo $language['misc']['delete']; ?><span class="glyphicon glyphicon-remove white"></span></span></a>
                        </td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>




<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo $language['headers']['add_page']; ?>
    </div>
    <div class="panel-body">

        <form action="" method="post" role="form">
            <div class="form-group">
                <label><?php echo $language['forms']['admin_add_page_title']; ?> *</label>
                <input type="text" name="title" class="form-control" />
            </div>

            <div class="form-group">
                <label><?php echo $language['forms']['admin_add_page_url']; ?> *</label>
                <input type="text" name="url" class="form-control" />
            </div>

            <div class="form-group">
                <label><?php echo $language['forms']['admin_add_page_description']; ?> *</label>
                <textarea id="description" name="description" class="form-control"></textarea>
            </div>


            <button type="submit" name="submit" class="btn btn-default"><?php echo $language['forms']['submit']; ?></button>
        </form>

        <script src="template/js/tinymce/tinymce.min.js"></script>

        <script>
            tinymce.init({
                selector: "#description"
            });
        </script>
    </div>
</div>