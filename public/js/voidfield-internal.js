import {voidfield} from "./voidfield.js";

/**
 * @
 */
if('undefined' !== typeof(voidfield)) {
    jQuery(function(){
        if(jQuery('#money').length) {
            const moneyAjax = new voidfield.AjaxHandler('/money', 'get');
            new voidfield.TimeoutHandler(() => {
                moneyAjax.query().then((r) => {
                    if(r.hasOwnProperty('money')) {
                        jQuery('#money').text(r.money);
                    }
                }).catch(() => {
                    voidfield.instantToast();
                });
            }, 'money');
            voidfield.timeoutRegister.money.run();
        }
    });
}
