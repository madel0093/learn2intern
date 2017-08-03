	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<div class="form-group"></div>
		<ul class="nav menu">

			<li class="<?php getSideBarActivebyController($this,'index'); ?>"><a href="<?php echo getUrl("students","index");?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
			<li class="<?php getSideBarActivebyController($this,'Competitions'); ?>"><a href="<?php echo getUrl("students","competitions");?>"><svg class="glyph stroked star"><use xlink:href="#stroked-star"></use></svg>Competitions</a></li>
			<li class="<?php getSideBarActivebyController($this,'todolist'); ?>"><a href="<?php echo getUrl("students","todolist");?>"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> To Do List</a></li>
			<li class="<?php getSideBarActivebyController($this,'profile'); ?>"><a href="<?php echo getUrl("students","profile");?>"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Profile</a></li>
			<li role="presentation" class="divider"></li>
			<li><a href="login.html"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>Contact us</a></li>
		</ul>

	</div><!--/.sidebar-->