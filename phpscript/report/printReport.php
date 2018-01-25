<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Print Official Reciept</title>
</head>
<link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
 <link href="../../assets/bootstrap.css" rel="stylesheet">
<style>
	body{		
		padding: 0;
		font-family: 'Slabo 27px', serif;
		font-size: 14px;
	}
	.container{
		margin: 0 auto;
		width: 80%;
		
	}

	#body{
		text-align: center;
	}

	table {
	    border-collapse: collapse;
	    margin: 0 auto;
	    border-color: silver;
	    width: 80%;
	}
	#customer_info, #footer, #header{
		 margin: 0 auto;
		 width: 80%;
		
	}

	h4,p{
		padding: 0;
		margin:0;
	}

	.clearfix{
		content:"";
		clear:both;
		display: table;
	}

	.card-body h2, .card-body h6{
        margin-bottom: 0px;
        width: 100%;
        text-align: center;
        font-family: Arial;
      }
</style>
<?php    
    require_once('../../classes/Crud.php');
    require_once('../../classes/function.php');

    $crud = new Crud();
    $header=header_info();
    $content=$_GET['content'];   
?>  
<body>
		<div class="container">
			<br/>
			<br/>
			<div id="content" >
				<div id="header">
					<img src="<?php echo "../../".$header['logo'];?>" width="50" height="50" style="float:left;margin-right:6px;">
					<div style="float:left;line-height: 19px;" >
						<h4><?php echo $header['company_name'];?></h4>
						<p> <?php echo $header['company_address'];?></p>
						<p> <?php echo $header['contact_no'];?></p>
					</div>
				</div>
				<div class="clearfix"></div>
				<br/>
				<div class="card-body">
					<?php echo $content;?>
				</div>
				<br/>
				<br/>
				<div id="footer">
					<label>Printed by: </label><span><?php echo $_SESSION['firstname'].' '.$_SESSION['lastname'];?></span><br/>
					<label>Date &amp; Time Printed:</label><span><?php echo date('Y-m-d H:i:s');?> </span><br/>
				</div>
		</div>

</body>
</html>