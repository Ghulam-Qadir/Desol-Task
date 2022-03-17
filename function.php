<?php 
add_shortcode('variable-search', 'variable_search_function');
    function variable_search_function() { 
		$args     = array( 'post_type' => 'product', 'posts_per_page' => -1 );
		$product = get_posts( $args );

?>
    <select name="products" id="products" onchange="productfetchdata()" class="form-control">
 		<?php
 		foreach ($product as $value):
 				echo "<option value='{$value->ID}'>{$value->post_title}</option>";
 		 endforeach;
 		?>
 	</select>
 	<select name="variation" id="variation" class="form-control">
 		<option value="">variation</option>
 	</select>
 	<button onclick="fetch()">Search</button>

<div id="productfetch"></div>
        <?php
    }
    
add_action( 'wp_footer', 'ajax_fetch' );
function ajax_fetch() { ?>

 <script type="text/javascript">
 	productfetchdata();
        function productfetchdata() {
       		 jQuery.ajax( {
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'post',
                    data: { action: 'variation_fetch', id: jQuery('#products').val() },
                    success: function(data) {
                    jQuery('#variation').empty();
                    jQuery('#variation').html( data )
                }
                });
        }
        function fetch() {

                jQuery.ajax( {
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'post',
                    data: { action: 'data_fetch', keyword: jQuery('#products').find("option:selected").text() },
                    success: function(data) {
                        jQuery('#productfetch').html( data );
                    }
                });
        }
    </script>
<?php
}
 add_action('wp_ajax_variation_fetch' , 'variation_fetch');
 add_action('wp_ajax_nopriv_variation_fetch','variation_fetch');
 function variation_fetch()
 {
$product_id = $_POST['id'];
$handle=new WC_Product_Variable($product_id);
$variations1=$handle->get_children();
foreach ($variations1 as $value) {
    $single_variation = new WC_Product_Variation($value);
    echo '<option  value="'.$value.'">'.implode(" / ", $single_variation->get_variation_attributes()).'</option>';
}

 }
    
    add_action('wp_ajax_data_fetch' , 'product_fetch');
    add_action('wp_ajax_nopriv_data_fetch','product_fetch');
    function product_fetch() {
   $the_query = new WP_Query( array( 'posts_per_page' => -1, 's' => esc_attr( $_POST['keyword'] ), 'post_type' => 'product' ) );
    
        if( $the_query->have_posts() ) :
            while( $the_query->have_posts() ): $the_query->the_post(); ?>
    
        <a href="<?php echo esc_url( post_permalink() ); ?>"><?php the_title();?></a><br>
            <?php endwhile;
            wp_reset_postdata();
        endif;
    die();
    }

 ?>