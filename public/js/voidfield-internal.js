import {voidfield} from "./voidfield.js";

/**
 * @
 */
if('undefined' !== typeof(voidfield)) {
    jQuery(function(){
        if(jQuery('#money').length) {
            new voidfield.TimeoutHandler(() => {
                fetch('/money')
                .then(response => response.json())
                .then((r) => {
                if(r.hasOwnProperty('money')) {
                    jQuery('#money').text(r.money);
                    jQuery('#money').attr('title', r.pure);
                }
                }).catch(() => {
                    voidfield.instantToast();
                });
            }, 'money');
            voidfield.timeoutRegister.money.run();
        }
    });
}
