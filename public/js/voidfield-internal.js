import {voidfield} from "./voidfield.js";

const MainMenuAppData = {
    data() {
      return {
        money: 0,
        formattedMoney: 0
      };
    }, mounted() {
        this.loadMoney();
    }, methods: {
        loadMoney() {
            fetch('/money')
            .then(response => response.json())
            .then((r) => {
                if(r.hasOwnProperty('money')) {
                    this.formattedMoney = r.money;
                    this.money = r.pure;
                    voidfield.wait(10*1000).then(this.loadMoney);
                }
            }).catch((e) => {
                console.error('oopsie doopsie');
                console.error(e);
                window.toastr.add('ko', e);
            });
        }
    }
};

const MainMenuApp = Vue.createApp(MainMenuAppData);
MainMenuApp.config.compilerOptions.delimiters = ['${', '}'];
MainMenuApp.mount('#internal-main-menu');
