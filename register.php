<?php
	$pageTitle = "Register Form";
	include_once('config/config.php');
	include_once('config/dbConf.php');
    include_once('functions.php');
    require $root."templates/$theme/header.php";
?>

<script>
	<?php
		echo "
			function launchForm(menu,idUsuario){
				let root='".$root."'

				if(menu=='1'){
					$.ajax({
						url: './templates/acil/uploadFiles.php',
						type: 'POST',
						data: 
						{
							root:root,
							idUsuario:idUsuario
						},
						success: function(result)
						{
							$('#principal').html(result);
						}
					});
				}
				
				else{
					$.ajax({
						url: './templates/acil/registerForm.php',
						type: 'POST',
						data: 
						{
							root:root
						},
						success: function(result)
						{
							$('#principal').html(result);
						}
					});
				}	
			}
			";
	?>
</script>

<!-- General Canvas-->
<div id=principal></div>

<!-- Lanza funcion de recarga -->
<script> launchForm() </script>

<?php require $root."templates/$theme/footer.php";?>
	
	



