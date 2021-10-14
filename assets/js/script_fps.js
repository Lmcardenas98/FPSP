jQuery(document).ready(function($) {
    jQuery('#fpsp_button_send_draft').on('click', function(e) {
        e.preventDefault();
        var fpsp_form_Data = new FormData();
        var fpsp_input_title_send = jQuery('#fpsp_input_title_send').val();
        var fpsp_content_box_send = jQuery('#fpsp_content_box_send').val();
        var fpsp_image_choice_send = $('#fpsp_image_choice_send').prop('files')[0];
        var nonce_send = $('#nonce_sended').val();
        fpsp_form_Data.append('image_choice_send', fpsp_image_choice_send)
        fpsp_form_Data.append('action', 'new_post_as_draft')
        fpsp_form_Data.append('input_title_send', fpsp_input_title_send)
        fpsp_form_Data.append('content_box_send', fpsp_content_box_send)
        fpsp_form_Data.append('_wpnonce', ajax_var.nonce)
        jQuery.ajax({
            type: 'post',
            url: ajax_var.url,
            data: fpsp_form_Data,
            processData: false,
            contentType: false,
            success: function(data) {
                jQuery('#ajax_change').html(data)
                $('#fpsp_input_title_send').val('');
                $('#fpsp_content_box_send').val('');
                $('#fpsp_image_choice_send').val('');

            }
        }).fail(function(error) {
            console.log(error);
        });
    });
    $(document).on('click', '.def_link', function(d) {
        d.preventDefault();
        fpsp_id_save = $(this).attr('href').replace(/^.*?p=/, '');

        $.ajax({
            type: 'post',
            url: ajax_var.url,
            data: {
                _wpnonce: ajax_var.nonce,
                send_id_link: fpsp_id_save,
                action: 'received_id_link',
            },
            success: function(info_post) {
                var title = eval("(" + info_post + ")")
                var content_sanitize = title.content.replace(/<[^>]+>/g, '')
                $('#fpsp_input_title_send').val(title.name);
                $('#fpsp_content_box_send').val(content_sanitize);
            }
        })
    })
    $('#fpsp_button2_send_draft').on('click', function(r) {
        r.preventDefault();
        var fpsp_form_Data_edit = new FormData();
        var fpsp_input_title_edit = jQuery('#fpsp_input_title_send').val();
        var fpsp_content_box_edit = jQuery('#fpsp_content_box_send').val();
        var fpsp_image_box_edit = $('#fpsp_image_choice_send').prop('files')[0];
        fpsp_form_Data_edit.append('image_box_edit', fpsp_image_box_edit)
        fpsp_form_Data_edit.append('action', 'modify_the_selected_form')
        fpsp_form_Data_edit.append('input_title_edit', fpsp_input_title_edit)
        fpsp_form_Data_edit.append('content_box_edit', fpsp_content_box_edit)
        fpsp_form_Data_edit.append('send_id', fpsp_id_save)
        fpsp_form_Data_edit.append('_wpnonce', ajax_var.nonce)
        $.ajax({
            type: 'post',
            url: ajax_var.url,
            data: fpsp_form_Data_edit,
            processData: false,
            contentType: false,
            success: function(recive) {
                jQuery('#ajax_change').html(recive)
                $('#fpsp_input_title_send').val('');
                $('#fpsp_content_box_send').val('');
                $('#fpsp_image_choice_send').val('');

            }

        })
    })

    return false;

});








// send_id :id,
// input_name_edit,
// content_box_edit,
// action: 'modify_the_slected_form',