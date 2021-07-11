
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
    this.maxPoints = parseInt(maxPoints);
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
 * @param {String} tab
 * @returns {undefined}
 */
voidfield.showTab = function(tab) {
    try {
        const triggerEl = document.querySelector('.nav-tabs a[href="#' + tab + '"]');
        if(bootstrap.Tab.getInstance(triggerEl)) {
            bootstrap.Tab.getInstance(triggerEl).show();
        } else {
            const ttab = new bootstrap.Tab(triggerEl);
            ttab.show();
        }
    } catch(e) { // catch it, because not showing a tab is not THAT bad.
        console.log(e);
    }
};

/**
 * 
 * @returns {undefined}
 */
voidfield.loadTabFromUri = function() {
    const url = document.location.toString();
    const xs = url.split('#');
    if(xs.length > 1) {
        voidfield.showTab(xs[1]);
    }
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
        let ad = parseInt(jQuery(this).val());
        if(!isNaN(ad)) {
            if((points + ad) > mx) {
                returns = false;
            }
            points = points + ad;
        }
    });
    let remainder = this.maxPoints - points;
    while(points > this.maxPoints) { // fast way, bug here @TODO
        let $ce = jQuery('.whole-control-number[data-whole="'+this.whole+'"]').filter(function(){
            return (0 < this.value);
        }).first();
        points = points - parseInt($ce.val());
        remainder = this.maxPoints - points;
        $ce.val(0);
    }
    jQuery('.whole-remainder-number[data-whole="'+this.whole+'"]').text(remainder);
    return returns;
};

voidfield.SocketHandler = function(){
    this.conn = null;
};

voidfield.SocketHandler.prototype.init = function() {
    let loc = window.location, new_uri;
    if (loc.protocol === 'https:') {
        new_uri = 'wss:';
    } else {
        new_uri = 'ws:';
    }
    new_uri += '//' + loc.host;
    new_uri += ':8080';
    this.connection = new WebSocket(new_uri);
    this.connection.onopen = (e) => { return this.handleOpen(e); };
    this.connection.onmessage = (e) => { return this.handleMessage(e); };
};

voidfield.SocketHandler.prototype.handleOpen = function(data) {
    console.log('opened');
    console.log(data);
};

voidfield.SocketHandler.prototype.handleMessage = function(data) {
    console.log('message');
    console.log(data);
};

voidfield.merge = function(a, b) {
    return Object.assign({}, a, b);
};

voidfield.date = function(d, f) {
    let returns = '';
    const cc = {
        'd': 'DD',
        'j': 'd',
        'w': 'D',
        'z': 'DDD',
        'W': 'w',
        'm': 'MM',
        'n': 'M',
        't': moment(d).daysInMonth(),
        'o': 'Y',
        'Y': 'YYYY',
        'y': 'YY',
        'a': 'a',
        'A': 'A',
        'g': 'h',
        'G': 'H',
        'h': 'hh',
        'H': 'HH',
        'i': 'mm',
        's': 'ss'
    };
    for(let c of f.split('')) {
        if(cc.hasOwnProperty(c)) {
            returns += cc[c];
        } else {
            returns += c;
        }
    }
    return moment(d).format(returns);
};

voidfield.wait = ms => new Promise(resolve => setTimeout(resolve, ms));

voidfield.ws = new voidfield.SocketHandler();

voidfield.parameters = {};

export { voidfield };