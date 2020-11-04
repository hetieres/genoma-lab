const main = {
    init: function() {
        this.bindSearch();
    },

    bindSearch: function() {
        let form = $('form#form-search');
        form.find('input#searchInput').keypress(event =>  {
            let keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13') form.submit();
        });

        $('button#searchBtn').on('click', event => {
            event.preventDefault();
            form.submit();
        });
    }
};

main.init();