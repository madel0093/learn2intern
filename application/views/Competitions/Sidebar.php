<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
	<dir class="form-group"></dir>
	<ul class="nav menu">
		<li class="<?php getSideBarActivebyController($this, 'index'); ?>">
			<a href="<?php echo site_url('competitions');?>">
				<svg class="glyph stroked star">
					<use xlink:href="#stroked-star"></use>
				</svg> 
				Competitions
			</a>
		</li>
		<?php if( $this->ion_auth->is_supervisor() ) : ?>
			<li class="<?php getSideBarActivebyController($this, 'manualVerifications'); ?>">
				<a href="<?php echo site_url('competitions/manualVerifications');?>">
					<svg class="glyph stroked table">
						<use xlink:href="#stroked-table"></use>
					</svg>
					Manual Verifications
				</a>
			</li>
		<?php endif; ?>
	</ul>
</div>