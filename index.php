<?php 
$product = [
	'0' => 'Cap', 
	'1' => 'Tshirt', 
	'2' => 'Shirt', 
	'3' => 'Tie', 
];
 ?>
 <div>
 	<select name="products" id="products">
 		<?php
 		foreach ($product as $key => $value):
 				echo "<option value='{$key}'>{$value}</option>";
 		 endforeach;
 		?>
 	</select>
 	<select name="variation" id="variation">
 		<option value="1">1</option>
 		<option value="2">2</option>
 		<option value="3">3</option>
 	</select>
 </div>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>
 <script >
 	$( "#products" ).change(function() {
 			var productid = $(this).val();
 			$.ajax({
            url: "ajax.php",
            dataType: 'Json',
            type:'GET',
            success: function(data) {
            	$('#variation').empty();
                $.each(data, function(key, value) {
                    $('#variation').append('<option value="'+ key +'">'+ value +'</option>');
                })
            }
            })
          })
 </script>