<?php
User::check_permission(1);

$_GET['page_id'] = (int) $_GET['page_id'];

/* Check if page exists */
if(!Database::exists('page_id', 'pages', ['page_id' => $_GET['page_id']])) {
    User::get_back('admin/pages-management');
}

/* Get the page data from the database */
$page = Database::get('*', 'pages', ['page_id' => $_GET['page_id']]);

if(!empty($_POST)) {
    /* Filter some the variables */
    $_POST['title'] = Database::clean_string($_POST['title']);
    $_POST['url']	= generate_slug(Database::clean_string($_POST['url']));
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

        /* Update the database */
        Database::update(
            'pages',
            [
                'title' => $_POST['title'],
                'url'   => $_POST['url'],
                'description' => $_POST['description']
            ],
            ['page_id' => $_GET['page_id']]
        );

        /* Update the current settings */
        $page = Database::get('*', 'pages', ['page_id' => $_GET['page_id']]);

        /* Set a success message */
        $_SESSION['success'][] = $language['messages']['success'];
    }

    display_notifications();

}


initiate_html_columns();

?>


<h3><?php echo $language['headers']['edit_page'] . User::generate_go_back_button('admin/pages-management'); ?></h3>

<form action="" method="post" role="form">
    <div class="form-group">
        <label><?php echo $language['forms']['admin_add_page_title']; ?> *</label>
        <input type="text" name="title" class="form-control" value="<?php echo $page->title; ?>" />
    </div>

    <div class="form-group">
        <label><?php echo $language['forms']['admin_add_page_url']; ?> *</label>
        <input type="text" name="url" class="form-control" value="<?php echo $page->url; ?>" />
    </div>

    <div class="form-group">
        <label><?php echo $language['forms']['admin_add_page_description']; ?> *</label>
        <textarea id="description" name="description" class="form-control"><?php echo $page->description; ?></textarea>
    </div>


    <button type="submit" name="submit" class="btn btn-default"><?php echo $language['forms']['submit']; ?></button>
</form>

<script src="template/js/tinymce/tinymce.min.js"></script>

<script>
    tinymce.init({
        selector: "#description"
    });
</script>