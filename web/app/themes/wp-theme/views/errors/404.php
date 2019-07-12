<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
?>

<?php get_header(); ?>

<div class="container">
    <div class="row">

		
		<?php echo $this->view('page/intro');  ?>
        <h1>Dit is een 404 Pagina </h1>
        <i class="fab fa-andriod"></i>
        <a href="">Dit is een link</a>
		<?php echo $this->view('page/slider');  ?>
        
    </div>
</div>

<?php get_footer(); ?>

