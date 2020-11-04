var users = {
    init: () => {
        users._filter();
        users._clickWindow();
    },

    _filter: (obj) => {
        $("#search > input").bind("change paste keyup", function () {
            let value = users._removeAccentuation($(this).val().toLowerCase());
            $("div#boxUsers").filter((index, el) => {
                el.setAttribute('data-visible', 'true');
                el.style.display='block';
                if(users._removeAccentuation(el.getAttribute('data-search').toLowerCase()).indexOf(value)<0) {
                    el.style.display='none';
                    el.setAttribute('data-visible', 'false');
                }
            });

            if($("div#boxUsers[data-visible='true']").length==0) $("div#noBoxs").show();
            else $("div#noBoxs").hide();
        });
    },

    _clickWindow: () => {
        $(window).click(function(event) {
            if(
                !$(event.target).hasClass('delUser')
                && !$(event.target).parent().hasClass('delUser')
                && !$(event.target).parent().parent().hasClass('delUser')
                && !$(event.target).parent().parent().parent().hasClass('delUser')
                && !$(event.target).parent().parent().parent().parent().hasClass('delUser')
                && !$(event.target).hasClass('userInfos')
                && !$(event.target).parent().hasClass('userInfos')
                && !$(event.target).parent().parent().hasClass('userInfos')
                && !$(event.target).parent().parent().parent().hasClass('userInfos')
                && !$(event.target).parent().parent().parent().parent().hasClass('userInfos')
                && !$(event.target).hasClass('show')
                && !$(event.target).parent().hasClass('box-buttons')
                && !$(event.target).parent().parent().hasClass('box-buttons')
            ) {
                $("#boxUsers > .delUser, #boxUsers > .userInfos").css("top", "100%");
            }
        });
    },

    _removeAccentuation: function(str) {
        let withAccentuation    = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÕÖØòóôõöøðÈÉÊËèéêëÇçÐÌÍÎÏìíîïÙÚÛÜùúûüÑñŠšŸÿýŽž",
            withoutAccentuation = "AAAAAAaaaaaaOOOOOOOoooooooEEEEeeeeCcDIIIIiiiiUUUUuuuuNnSsYyyZz";

        let newStr = "";
        for(let i=0; i<str.length; i++) {
            let changeCht = false;

            for (let a=0; a<withAccentuation.length; a++) {
                if (str.substr(i,1)==withAccentuation.substr(a,1)) {
                    newStr+=withoutAccentuation.substr(a,1);
                    changeCht=true;
                    break;
                }
            }

            if (changeCht===false)
                newStr+=str.substr(i,1);
        }

        return newStr;
    },
}

$(document).ready(() => {
    users.init();
});

$.fn.hasAttr = function(name) {
   return this.attr(name) !== undefined;
};