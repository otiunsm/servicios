"use strict";
var KTLogin = function() {
    var t, i = function(i) {
        var o = "login-" + i + "-on";
        i = "kt_login_" + i + "_form";
        t.removeClass("login-forgot-on"), t.removeClass("login-signin-on"), t.removeClass("login-signup-on"), t.addClass(o), KTUtil.animateClass(KTUtil.getById(i), "animate__animated animate__backInUp")
    };
    return {
        init: function() {
            var o;
            t = $("#kt_login"), o = FormValidation.formValidation(KTUtil.getById("kt_login_signin_form"), {
                    fields: {
                        username: {
                            validators: {
                                notEmpty: {
                                    message: "Campo requerido"
                                }
                            }
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: "Campo requerido"
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger,
                        submitButton: new FormValidation.plugins.SubmitButton,
                        bootstrap: new FormValidation.plugins.Bootstrap
                    }
                }), $("#kt_login_signin_submit").on("click", (function(t) {
                    let user = $('[name="username"]').val();
                    let clave = $('[name="password"]').val();
                    t.preventDefault(), o.validate().then((function(t) {
                        'Valid' == t ?
                            $.ajax({
                                type: "post",
                                url: 'Login/login',
                                data:{user, clave},
                                dataType: "json",
                                success: function(response){
                                    if (response) {
                                        window.location = window.location;
                                    }else{
                                        window.location = window.location;
                                    }
                                }
                            })
                        : t.preventDefault()
                    }))
                }))
        }
    }
}();
jQuery(document).ready((function() {
    KTLogin.init()
}));
