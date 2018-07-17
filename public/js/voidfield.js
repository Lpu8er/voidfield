
var voidfield = {};

/**
 * 
 * @param {jQuery} $el
 * @returns {voidfield.ClickToComplete}
 */
voidfield.ClickToComplete = function($el){
    this.$el = $el;
};

/**
 * 
 * @returns {undefined}
 */
voidfield.ClickToComplete.prototype.bindEvent = function(){
    this.$el.on('click', jQuery.proxy(this.complete, this));
};

/**
 * 
 * @returns {Boolean}
 */
voidfield.ClickToComplete.prototype.complete = function(){
    jQuery('#'+this.$el.data('target')).val(this.$el.text());
    return false;
};

/**
 * 
 * @param {String} whole
 * @param {Number} maxPoints
 * @returns {voidfield.WholeNumber}
 */
voidfield.WholeNumber = function(whole, maxPoints){
    this.whole = whole;
    this.maxPoints = maxPoints;
};

/**
 * 
 * @returns {undefined}
 */
voidfield.WholeNumber.prototype.bindEvents = function(){
    jQuery('.whole-control-number[data-whole="'+this.whole+'"]').on('change', jQuery.proxy(this.recompute, this));
};

/**
 * 
 * @returns {Boolean}
 */
voidfield.WholeNumber.prototype.recompute = function(){
    let returns = true;
    let points = 0;
    let mx = this.maxPoints;
    jQuery('.whole-control-number[data-whole="'+this.whole+'"]').each(function(){
        let ad = jQuery(this).val();
        if(!isNaN(ad)) {
            if((points + ad) <= mx) {
                points = points + ad;
            } else {
                returns = false;
            }
        }
    });
    let remainder = this.maxPoints - points;
    while(remainder < 0) { // fast way, bug here @TODO
        jQuery('.whole-control-number[data-whole="'+this.whole+'"][value!=0]').first().val(0);
    }
    jQuery('.whole-remainder-number[data-whole="'+this.whole+'"]').text(remainder);
    return returns;
};


jQuery(function(){
    jQuery('.click-to-complete').each(function(){
        let cc = new voidfield.ClickToComplete($(this));
        cc.bindEvent();
    });
});
