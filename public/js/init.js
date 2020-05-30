import { voidfield } from './voidfield.js';

jQuery(function(){
    jQuery('.click-to-complete').each(function(){
        let cc = new voidfield.ClickToComplete($(this));
        cc.bindEvent();
    });
    
    jQuery(document).on('change', '.instant-submit', function(){ jQuery(jQuery(this)[0].form).submit(); });
    
    voidfield.loadTabFromUri();
    
    voidfield.refreshToasts();
});