import { voidfield } from './voidfield.js';

export const MainAppData = {
    data() {
        return {};
    },
    mounted() {
        voidfield.loadTabFromUri();
    }
};

export const MainApp = Vue.createApp(MainAppData);
MainApp.mount('#mainContent');

export const ToastrAppData = {
    data() {
        return {
            'ko': [],
            'warn': [],
            'info': [],
            'ok': []
        };
    },
    mounted() {
        window.toastr = this;
        this.refreshAll();
    }, created() {
        for(const t of ['ko', 'warn', 'info', 'ok']) {
            this.$watch(t, () => {
                this.refreshAll();
            }, { deep: true, flush: 'post' });
        }
    }, methods: {
        refreshAll() {
            const toastElList = [].slice.call(document.querySelectorAll('.toast'));
            const toastList = toastElList.map(function (toastEl) {
              const t = new bootstrap.Toast(toastEl, {
                    'autohide': true,
                    'delay': 5000
                });
                t.show();
            });
        },
        add(t, msg) {
            if(['ko', 'warn', 'info', 'ok'].includes(t)) {
                this[t].push({
                    'message': msg,
                    'date': new Date()
                });
            }
        }
    }
};

export const ToastrApp = Vue.createApp(ToastrAppData);
ToastrApp.config.compilerOptions.delimiters = ['${', '}'];
ToastrApp.mount('#toasts-main-area');

jQuery(function(){
    jQuery('.click-to-complete').each(function(){
        let cc = new voidfield.ClickToComplete($(this));
        cc.bindEvent();
    });
    
    jQuery(document).on('change', '.instant-submit', function(){ jQuery(jQuery(this)[0].form).submit(); });
    
});