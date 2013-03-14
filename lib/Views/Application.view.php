<!DOCTYPE html>
<html>
	<head>
		<title><?=$this->_name?></title>
	</head>
	<body>
		
		<header>
			<h1><?=$this->_name?></h1>
		</header>
		
		<nav>
			<ul>
				<? foreach ($applicationPages as $page) { ?>
				<li>
					<a href="<?=$this->_request->getRelativePath()?>/<?=$page->getUrl()?>">
						<?=htmlentities($page->getUrl(), ENT_NOQUOTES, 'utf-8')?>
					</a>
				</li>
				<? } ?>
			</ul>
		</nav>

		<seciton>
			<?=$this->_html?>
		</section>

		<footer>
			
			<span class="rights">
				All rights reserved to GriTM 2013&copy;
			</span>

			<nav>
				<ul>
					<? foreach ($applicationPages as $page) { ?>
					<li>
						<a href="<?=$this->_request->getRelativePath()?>/<?=$page->getUrl()?>">
							<?=htmlentities($page->getUrl(), ENT_NOQUOTES, 'utf-8')?>
						</a>
					</li>
					<? } ?>
				</ul>
			</nav>

		</footer>
	</body>
</html>