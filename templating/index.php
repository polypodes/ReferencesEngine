<?php 
	$rooturl = "http://sandbox.com/podfolio/v1_angular/"; 

	$book_id = $_GET['id'];

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $rooturl."templating/data/".$book_id.".json");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	$data = json_decode(curl_exec($curl),true);

	curl_close($curl);

	// echo "<pre>";
	// print_r($data);
	// echo "</pre>";

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Project</title>
	<link type="text/css" rel="stylesheet" media="screen" href="<?= $rooturl;?>src/templates/<?= $data['theme']['src']; ?>.css">
	
	<link type="text/css" rel="stylesheet" media="screen" href="<?= $rooturl; ?>templating/src/style/style.css">
</head>
<body>

	<section class="render">
        <article class="cover">
            <div class="cover_image" style="background-image:url(<?= $rooturl.$data['cover']; ?>);"></div>
            <div class="cover_content">
                <h1 class="text"><?= $data['btitle']; ?></h1>
                <h2 class="text"><?= $data['subtitle']; ?></h2>
                <h4 class="text"><?= $data['bottomline']; ?></h4>
            </div>
            <div class="gradient"></div>
        </article>
        <?php foreach($data['projects_a'] as $k => $p): ?>
	          <article class="item">
	              <section class="project">

	                  <div class="project_image" style="background-image:url(<?= $rooturl.$p['cover']; ?>);"></div>
	                  <div class="project_content">

	                     <h3 class="text"><?= $p['intro']; ?></h3>
	                     <h2 class="text"><?= $p['title']; ?></h2>
	                     <h4 class="text"><?= $p['date']; ?></h4>
	                     <div class="desc">
	                         <?= $p['desc']; ?>
	                     </div>
	                </div>
	                <div class="gradient"></div>
	              </section>
	              <div class="pagination">Projet n°<?= $k+1; ?></div>
	          </article>

	          <?php if(isset($p['files'])): ?>
		          <article class="item">
		              <div class="medias">
		                <h3><?= $p['title']; ?> | Medias</h3>
		                <div class="images">
		                  <div class="images_content">
		                  	<?php foreach($p['files'] as $i): ?>
		                  		<div  class="image row-<?= $i['row']; ?> col-<?= $i['col']; ?> sizex-<?= $i['sizeX']; ?> sizey-<?= $i['sizeY']; ?>"><div class="imagecontent" style="background-image:url(<?= $rooturl.$i['path']; ?>);"></div></div>
		                  	<?php endforeach; ?>
		                  </div>
		                </div>
		              </div>
		              <div class="pagination">Médias complémentaires - Projet n°<?= $k+1; ?></div>
		          </article>
		      <?php endif; ?>
        <?php endforeach; ?>
        
    </section>

</body>
</html>