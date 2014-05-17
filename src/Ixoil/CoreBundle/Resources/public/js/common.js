/* 
 * filename: common.js
 * description: this file contains common javascript functions and methods.
 * author: OXIND
 */

/*
 * confirmation box/ popup-model
 * set message, title, url
 */
$(function() {
    $('#confirmDelete')
        // On modal open
        .on('show.bs.modal', function (e) {
            // set message
            $message = $(e.relatedTarget).attr('data-message');
            $(this).find('.modal-body p').text($message);

            // set title
            $title = $(e.relatedTarget).attr('data-title');
            $(this).find('.modal-title').text($title);

            // set url to redirect
            $url = $(e.relatedTarget).attr('data-url');
        })
        // Form confirm (yes/ok) handler
        .find('.modal-footer #confirm')
            .on('click', function() { location.href = $url; })
        .end();
});