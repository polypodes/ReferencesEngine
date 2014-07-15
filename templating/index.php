<?php $rooturl = "http://sandbox.com/podfolio/v0_angular/templating"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Project</title>
	<script ></script>
	<script src="<?= $rooturl; ?>/src/js/handlebars.js"></script>
	<script src="<?= $rooturl; ?>/src/js/zepto.js"></script>

	<script id="header-template" type="text/x-handlebars-template">
		<h1>{{book.couv.btitle}}</h1>
		<h2>{{book.couv.subtitle}}</h2>
		<span>{{book.couv.bottomline}}</span>
	</script>

	<script id="slide-template" type="text/x-handlebars-template">
		{{#each slides}}
			<h4>{{intro}}</h4>
			<h3>{{title}}</h3>
			<p>{{description}}</p>
		{{/each}}
	</script>

</head>
<body>
	<section class="theme"></section>
	<section class="header"></section>
	<section class="slides">
		
	</section>
	<section class="footer"></section>

	<script>
		var id = "<?php echo $_GET['id']; ?>";
		var book = "http://sandbox.com/podfolio/v0_angular/templating/book.json";
	</script>
	<script src="<?= $rooturl; ?>/src/js/application.js"></script>
</body>
</html>