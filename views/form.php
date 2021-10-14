<form action="" id="test_form" enctype="multipart/form-data" method="post">
    <fieldset>
        <legend><h4><?php _e('Publish Your Post', 'frontend-post-submission-private') ?></h4></legend>
        <div>
            <label id='fpsp_input_title_label1' for="fpsp_input_title_send"><?php _e('Title', 'frontend-post-submission-private') ?></label>
            <div>
                <input type="text" id="fpsp_input_title_send" name="fpsp_input_title_send" required>
            </div>
        </div>
        <div>
            <label id='fpsp_input_title_label1' for="fpsp_content_box_send"><?php _e('Content', 'frontend-post-submission-private') ?></label>
            <div>
                <textarea name="fpsp_content_box_send" id="fpsp_content_box_send" cols="30" rows="5" required></textarea>
            </div>
        </div>
        <div>
            <label  id='fpsp_input_title_label1' for='fpsp_image_choice_send'></label>
            <input type="file" id="fpsp_image_choice_send" name='fpsp_image_choice_send' multiple>
        </div>
        <div>
            <button type="button" id="fpsp_button_send_draft" value="Submit"><?php _e('Send', 'frontend-post-submission-private') ?></button>
            <button type="button" id="fpsp_button2_send_draft" value="Submit2"><?php _e('Edit', 'frontend-post-submission-private') ?></button>
        </div>
        <div id="ajax_change">
        </div>
    </fieldset>
</form>
