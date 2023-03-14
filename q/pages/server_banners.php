<?php

initiate_html_columns();

?>

<?php include 'template/includes/widgets/server_header.php'; ?>


<div class="panel panel-default">
    <div class="panel-body">

        <script type="text/javascript" src="template/js/jscolor/jscolor.js"></script>
        <script>
            $(document).ready(function() {

                /* Store some variables */
                var server_id = <?php echo $server->server_id; ?>;
                var link = '<?php echo $settings->url; ?>';
                var server_link = link+'server/'+'<?php echo $server->server_id; ?>';

                /* Display the default codes */
                var time = new Date();
                var background = $('[name="background"]').val();
                var text_color = 'FFFFFF';
                var border_color = 'FFFFFF';
                var image = 'banner/'+server_id+'/'+background+'/'+text_color+'/'+border_color+'/medium';
                var image2 = 'banner/'+server_id+'/'+background+'/'+text_color+'/'+border_color+'/small';
                $('[name="html_code"]').val('<a href="'+server_link+'"><img src="'+link+image+'" /></a>');
                $('[name="bb_code"]').val('[url='+server_link+'][img]'+link+image+'[/img][/url]');

                $('[name="html_code2"]').val('<a href="'+server_link+'"><img src="'+link+image2+'" /></a>');
                $('[name="bb_code2"]').val('[url='+server_link+'][img]'+link+image2+'[/img][/url]');


                /* On change, update it */
                $('.live').on('change', function(){

                    /* Refresh some variables */
                    var time = new Date();
                    var background = $('[name="background"]').val();
                    var text_color = $('[name="text_color"]').val();
                    var border_color = $('[name="border_color"]').val();
                    var image = 'banner/'+server_id+'/'+background+'/'+text_color+'/'+border_color+'/medium';

                    /* Update the image and the forms */
                    $('#live_banner').attr('src', image+'&time'+time.getTime());
                    $('[name="html_code"]').val('<a href="'+server_link+'"><img src="'+link+image+'" /></a>');
                    $('[name="bb_code"]').val('[url='+server_link+'][img]'+link+image+'[/img][/url]');
                });

            });
        </script>

        <img id="live_banner" src="banner/<?php echo $server->server_id; ?>/default/ffffff/ffffff/medium" />

        <div class="form-group">
            <label><?php echo $language['forms']['banner_background']; ?></label>
            <select name="background" class="form-control live">
                <?php
                /* Get all the available banners */
                $banners = glob('template/images/banners/medium/*.jpg');
                $banners = preg_replace('/.*\//', '', $banners);
                $banners = preg_replace('/\..*/', '', $banners);

                foreach($banners as $banner) {
                    echo '<option name="' . $banner . '">' . $banner . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label><?php echo $language['forms']['banner_text_color']; ?></label>
            <input type="text" name="text_color" class="form-control color live" />
        </div>

        <div class="form-group">
            <label><?php echo $language['forms']['banner_border_color']; ?></label>
            <input type="text" name="border_color" class="form-control color live" />
        </div>

        <div class="form-group">
            <label><?php echo $language['forms']['banner_html_code']; ?></label>
            <textarea name="html_code" class="form-control" rows="3" cols="40"></textarea>
        </div>

        <div class="form-group">
            <label><?php echo $language['forms']['banner_bb_code']; ?></label>
            <textarea name="bb_code" class="form-control" rows="3" cols="40"></textarea>
        </div>

        <hr />

        <img id="live_banner2" src="banner/<?php echo $server->server_id; ?>/default/ffffff/ffffff/small" />

        <div class="form-group">
            <label><?php echo $language['forms']['banner_html_code']; ?></label>
            <textarea name="html_code2" class="form-control" rows="3" cols="40"></textarea>
        </div>

        <div class="form-group">
            <label><?php echo $language['forms']['banner_bb_code']; ?></label>
            <textarea name="bb_code2" class="form-control" rows="3" cols="40"></textarea>
        </div>

    </div>
</div>


<hr class="custom-one" />

<?php include 'template/includes/widgets/server_options.php'; ?>
