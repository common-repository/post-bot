<div class="aspost_popup">
    <p onclick="openForm()">Post using Bot</p>
</div>
<div class="chat-popup" id="myForm">
  <form action="/action_page.php" class="form-container" enctype="multipart/form-data">
    <p><span> <img src="<?php echo ASPC_IMG_URL.'LogoBot.png'; ?>"></span> <span class="pttitle">Create Your Post</span> <span class="closepup" onclick="closeForm();">&times;</span></p>
    <div class="add_post_messages">
    </div>
    <div class="input_area">
    </div>
    <button type="button" class="btn" id="add_post_send"><img src="<?php echo ASPC_PLUGIN_URL.'assets/images/arrow4.png'?>"></button>
    <div class="clearfix"></div>
  </form>
</div>