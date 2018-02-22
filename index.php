<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Paypal Payment Integret for Donation</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<form method="post" action="payment/index.php" style="max-width: 300px;margin: 100px auto;">
			<div class="form-group">
				<label for="donation">Donation Amount</label>
				<input type="number" name="donation" id="donation" class="form-control" placeholder="$10" value="10">
			</div>
			<input type="submit" name="submit" value="Donation" class="btn btn-success">
		</form>
	</div>
</body>
</html>