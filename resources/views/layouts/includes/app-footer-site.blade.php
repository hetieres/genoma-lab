</div>

{!! $footer !!}
<!-- Scripts -->

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" async="true" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5efe2429bd2b5328"></script>

<script src="{{ asset('assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bs/popper.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bs/bs.min.js') }}"></script>
<script src="{{ asset('assets/js/site.min.js') }}"></script>
<script src="{{ asset('assets/js/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/js/jquery.slicknav.min.js') }}"></script>
<script src="{{ asset('assets/js/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/js/slick.min.js') }}"></script>
<!-- Date Picker -->
<script src="{{ asset('assets/js/js/gijgo.min.js') }}"></script>
<!-- One Page, Animated-HeadLin -->
<script src="{{ asset('assets/js/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/js/js/animated.headline.js') }}"></script>
<script src="{{ asset('assets/js/js/jquery.magnific-popup.js') }}"></script>
<!-- Scrollup, nice-select, sticky -->
<script src="{{ asset('assets/js/js/jquery.scrollUp.min.js') }}"></script>
<script src="{{ asset('assets/js/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('assets/js/js/jquery.sticky.js') }}"></script>

<!-- contact js -->
<script src="{{ asset('assets/js/js/contact.js') }}"></script>
<script src="{{ asset('assets/js/js/jquery.form.js') }}"></script>
<script src="{{ asset('assets/js/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/js/mail-script.js') }}"></script>
<script src="{{ asset('assets/js/js/jquery.ajaxchimp.min.js') }}"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{ asset('assets/js/pages/search.min.js') }}"></script>

<!-- Jquery Plugins, main Jquery -->
<script src="{{ asset('assets/js/js/main.js') }}"></script>


<script src="{{ asset('assets/js/js/menu/plugins.min.js') }}"></script>
<script src="{{ asset('assets/js/js/menu/site.min.js') }}"></script>
<script src="{{ asset('assets/js/js/banner/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/js/banner/home.min.js') }}"></script>
<script>
    $("#IconeLupa").click(function() {
        $("#form-search").submit();
    });

    $("#icon_Pesquisa").html('<i id="arrow_Pesquisa" class="fas fa-angle-down ArrowMenu LabelMobil"></i>');
    $("#icon_Servicos").html('<i id="arrow_Servicos" class="fas fa-angle-down ArrowMenu LabelMobil"></i>');
    $("#icon_EnsinoDifusao").html('<i id="arrow_EnsinoDifusao" class="fas fa-angle-down ArrowMenu LabelMobil"></i>');
    $("#icon_Midia").html('<i id="arrow_GenomaNumeros" class="fas fa-angle-down ArrowMenu LabelMobil"></i>');
    $("#icon_quemsomos").html('<i id="arrow_QuemSomos" class="fas fa-angle-down ArrowMenu LabelMobil"></i>');
</script>

<script>
    function Arrow(id) {
        var windowWidth = window.innerWidth;
        if (windowWidth >= 993) {
            $('.ArrowMenu').removeClass('fas fa-angle-right');
            $('.ArrowMenu').addClass('fas fa-angle-down');
            $('#arrow_' + id).removeClass('fas fa-angle-down');
            $('#arrow_' + id).addClass('fas fa-angle-right');
            var e = $(".links > li");
            var r = e.hasClass("active");
            var control = $("#Control").val();

            if (control != id) {
                $('.ArrowMenu').removeClass('fas fa-angle-right');
                $('.ArrowMenu').addClass('fas fa-angle-down');
                $('#arrow_' + id).removeClass('fas fa-angle-down');
                $('#arrow_' + id).addClass('fas fa-angle-right');
            } else {

                if (r) {
                    $('#arrow_' + id).removeClass('fas fa-angle-right');
                    $('#arrow_' + id).addClass('fas fa-angle-down');
                    //    e.removeClass("active");
                } else {
                    $('#arrow_' + id).removeClass('fas fa-angle-down');
                    $('#arrow_' + id).addClass('fas fa-angle-right');
                }
            }
        }

        function Show(value) {
            if (value == "1") {
                $("#BoxSearch").show("slow");
            } else {
                $("#BoxSearch").hide("slow");
            }
        }
        $("#Control").val(id);
    }
</script>
<input type="hidden" id="Control" value="">

</body>

</html>