
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
    jQuery('.nav-tabs a[href="#' + tab + '"]').tab('show');
};

/**
 * 
 * @returns {undefined}
 */
voidfield.loadTabFromUri = function() {
    let url = document.location.toString();
    let xs = url.split('#');
    if(xs.length) {
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

voidfield.AjaxHandler = function(uri, method = 'post', data = {}) {
    this.uri = uri;
    this.method = method;
    this.xhr = new XMLHttpRequest();
    this.data = data;
};

voidfield.AjaxHandler.prototype.query = function(data = {}) {
    this.data = voidfield.merge(this.data, data);
    this.promise = new Promise((resolve, reject) => {
        this.xhr.open(this.method, this.uri);

        this.xhr.onload = (e) => { resolve(this.xhr.response, e); };

        this.xhr.onerror = (e) => { reject({
                status: e.status,
                statusText: this.xhr.statusText
            }); };
        
        this.xhr.send(this.data);
    });
    return this.promise;
};

voidfield.timeoutRegister = {};

voidfield.TimeoutHandler = function(name = null, time = 1000) {
    this.time = time;
    this.handler = null;
    if(null !== name) {
        voidfield.timeoutRegister[name] = this;
    }
};

voidfield.TimeoutHandler.prototype.run = function() {
    return new Promise((resolve, reject) => {
        this.handler = window.setTimeout(() => {
            resolve(this.run());
        }, this.time);
    });
};

voidfield.TimeoutHandler.prototype.cancel = function() {
    if(null !== this.handler) {
        window.clearInterval(this.handler);
    }
};

voidfield.ws = new voidfield.SocketHandler();

jQuery(function(){
    jQuery('.click-to-complete').each(function(){
        let cc = new voidfield.ClickToComplete($(this));
        cc.bindEvent();
    });
    
    jQuery(document).on('change', '.instant-submit', function(){ jQuery(jQuery(this)[0].form).submit(); });
    
    voidfield.loadTabFromUri();
    
    if(jQuery('#money').length) {
        new voidfield.TimeoutHandler('money');
        const moneyAjax = new voidfield.AjaxHandler('/money', 'get');
        voidfield.timeoutRegister['money'].run()
            .then(moneyAjax.query()
                .then((r) => { jQuery('#money').text(r.money); }));
    }
    
    jQuery('.toast').toast({
        'autohide': true,
        'delay': 5000
    });
    jQuery('.toast').toast('show');
});
