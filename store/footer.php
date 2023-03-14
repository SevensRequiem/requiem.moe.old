<style>
.footer {
  position: fixed;
  right: 0;
  bottom: 0;
  left: 0;
  padding: 0.5rem;
  background-color: <?php echo $website_button_color; ?>;
  text-align: center;
  color: white;
  font-size: 16;
}

.footer-link {
    text-decoration: none;
    color: white;

}

.footer-link:link {
    text-decoration: none;
    color: white;
}

.footer-link:visited {
    text-decoration: none;
    color: white;
}

.footer-link:hover {
    text-decoration: none;
    color: white;
}

.footer-link:active {
    text-decoration: none;
    color: white;
}

.footer-text {
    padding-bottom: 6px;
    padding-top: 3px;
}

.spacer {
    margin-top: 100px;
    padding-top: 100px;
}
</style>

<div class="spacer">
<br>
</div>

<div class="footer">
<p class="footer-text"><?php echo $website_name; ?> - <a class="footer-link" href="http://<?php echo $website_url; ?>"><?php echo $website_url; ?></a></p>
</div>