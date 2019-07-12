<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
?>

<?php echo $this->view('includes/header');  ?>


<div class="container">
        <div class="row">
        
        	<div class="col-12 p-3 p-lg-5">
        		
     
        		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        				<h1><?php the_title(); ?></h1>
            			<?php the_content(); ?>
                   <?php endwhile;?>
                 <?php endif; ?>
        		
        	</div>
        </div>
    </div>

<?php echo $this->view('includes/footer');  ?>