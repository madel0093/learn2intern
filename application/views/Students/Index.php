<?php
$this->load->view('Public/Header');
?>

<body>
<?php
$this->load->view('Public/Nav');
$this->load->view('Students/Sidebar');
?>
		

		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<br />
	<div class="row">			
			<div class="col-md-12">			
				<div class="panel panel-info">
					<div class="panel-heading dark-overlay"><svg class="glyph stroked clipboard-with-paper"><use xlink:href="#stroked-clipboard-with-paper"></use></svg>To-do List</div>
					<div class="panel-body">
					
					</div>
				</div>
								
			</div><!--/.col-->		
		</div>						
	</div>	<!--/.main-->

<?php
$this->load->view('Public/Footer');
?>
</body>

</html>
