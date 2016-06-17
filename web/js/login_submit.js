/**
 * Created by GCC-MED on 12/04/2016.
 */
$(function () {
    $(".login").click(function(e) {
        $('#login-dp').dropdown('toggle');
        e.stopPropagation();
    });

    $('#_submit').click(function (e) {
        e.preventDefault();
        $.ajax({
            type: $('form').attr('method'),
            url: PATH_FOS_USER_SECURITY_CHECK,
            data: $('form').serialize(),
            dataType: "json",
            success: function (data, status, object) {
                if (data.error) {
                    $('.error').html(data.error);
                }
                else if(data["has_error"] === false) {
                    $("#login-container li:eq(0)").text("Connecté en tant que " + data["username"]).removeClass("hidden");
                    $("#login-container li:eq(1)").removeClass("hidden");
                    $("#login-container li:eq(2)").addClass("hidden");
                    $("#login-container li:eq(3)").addClass("hidden");
                    $(".after-login[data-include]").each(function() {
                        var self = $(this);
                            $.ajax({
                                type: "GET",
                                url: $(this).attr("data-include"),
                                data: null,
                                success: function (data, status, object) {
                                    self.html(data);
                                }
                            });
                    });
                }
            },
            error: function (data, status, object) {
                console.log(data);
                console.log(data.message);
            }
        });
        return false;
    });
});