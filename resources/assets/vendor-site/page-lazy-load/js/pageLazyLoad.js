var axios = require("axios");

var pageLazyLoad = {
    idContent:  'publications',
    idLoading:  'pageLoading',
    imgLoading: baseUrl + 'assets/vendor/page-lazy-load/loading.svg',
    url:        "api/ajax/get-news-home",

    loading:    false,
    ended:      false,

    page:       2,

    init: function() {
        this._bindLoadPage();
        this._bindScroll();
    },

    _bindLoadPage: function() {
        let scrollTop     = $(window).scrollTop(),
            screenHeight  = $(window).innerHeight(),
            contentHeight = $('body #' + this.idContent)[0].scrollHeight;

        if((scrollTop + screenHeight) >= contentHeight) {
            if(!this.loading && !this.ended) {
                this.loading = true;
                this._loadContent();
            }
        }
    },

    _bindScroll: function() {
        let $this = this;
        $(window).on('scroll', document, function() {
            let scrollTop     = $(this).scrollTop(),
                screenHeight  = $(this).innerHeight(),
                contentHeight = $('body #' + $this.idContent)[0].scrollHeight;

            if((scrollTop + screenHeight) >= contentHeight) {
                if(!$this.loading && !$this.ended) {
                    $this.loading = true;
                    $this._loadContent();
                }
            }
        });
    },

    _loadContent: function() {
        let url = baseUrl + this.url;
        $('body #' + this.idContent).after('<div id="' + this.idLoading + '" class="pageLoadingBox"><img src="' + this.imgLoading + '" /></div>');

        setTimeout(() => {
            axios.get(url, {
                params: {
                    page: this.page,
                    international: $('#international').val()
                }
            }).then(response => {
                    $('body #' + this.idLoading).remove();
                    $('body #' + this.idContent).append(response.data);

                    this.loading = false;
                    if(response.data != '') {
                        this.page = this.page+1;
                    } else {
                        this.ended = true;
                    }
            }).catch(error => {
                console.log("Error:");
                console.log(error);
            });
        }, 500);
    },
};

module.exports = pageLazyLoad;