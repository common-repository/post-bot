<div class="wrap">
	<h1>POST CHATBOX</h1>
	<div class="options">
		<div class="card">
			<h1>Options</h1>
			<form action="" method="post">
				<div class="form-group">
					<h3>User Role</h3>
					<p>Choose user role for post chatbox</p>
					<div class="post_u_roles">
						
						<label><input type="checkbox" <?php echo (in_array("administrator",$roles) ? 'checked="checked"' : ''); ?> name="post_publish_roles[]" value="administrator"> Administrator</label>
						<label><input type="checkbox" <?php echo (in_array("subscriber",$roles) ? 'checked="checked"' : ''); ?> name="post_publish_roles[]" value="subscriber"> Subscriber</label>
						<label><input type="checkbox" <?php echo (in_array("contributor",$roles) ? 'checked="checked"' : ''); ?> name="post_publish_roles[]" value="contributor"> Contributor</label>
						<label><input type="checkbox" <?php echo (in_array("author",$roles) ? 'checked="checked"' : ''); ?> name="post_publish_roles[]" value="author"> Author</label>
						<label><input type="checkbox" <?php echo (in_array("editor",$roles) ? 'checked="checked"' : ''); ?> name="post_publish_roles[]" value="editor"> Editor</label>
					</div>
					<input type="submit" name="as_post_popup_admin" class="button button-primary" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>