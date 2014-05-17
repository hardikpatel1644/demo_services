(function($) {
    $(function() {
        var $resendEmail = $('#resendmail');
        if ($resendEmail.length > 0) {
            $resendEmail.click(function() {
                // Only process if not disabled
                if ($resendEmail.hasClass('disabled'))
                    return false;
                $resendEmail.addClass('disabled');

                // Resend...
                $.post(
                    $this.data('url'), 
                    {}, 
                    function() {
                        $resendEmail.removeClass('disabled');
                    }
                );
        
                return false;
            });
        }
    });
})(window.jQuery);