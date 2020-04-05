<?php
include_once "includes/connection.php";
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		  <a class="navbar-brand" href="#">MyDynamicSite</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
			  <li class="nav-item">
				<a class="nav-link" href="index.php">Home</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="#">Link</a>
			  </li>
			  <li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  All Categories
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				<?php
					$sql = 'SELECT * FROM category';
					$result = mysqli_query($conn, $sql);
					while($row = mysqli_fetch_array($result)){
						$category_id = $row['category_id'];
						$category_name = $row['category_name'];
				?>
						<a class="dropdown-item" href="category.php?id=<?php echo $category_id; ?>"><?php echo $category_name; ?></a>
				<?php
					}
				?>
				</div>
			  </li>
			</ul>
			
		  </div>
		</nav>