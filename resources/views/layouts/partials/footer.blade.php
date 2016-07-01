
<script src="{!! elixir('js/vendor.js') !!}"></script>
<!-- Latest compiled and minified JS -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.5/waves.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="http://cdn.openwow.com/api/tooltip.js"></script>
<script>
    var openwowTooltips = {
        /* Enable or disable the rename of URLs into item, spell and other names automatically */
        rename: true,
        /* Enable or disable icons appearing on the left of the tooltip links. */
        icons: true,
        /* Overrides the default icon size of 15x15, 13x13 as an example, icons must be true */
        iconsize: 15,
        /* Enable or disable link rename quality colors, an epic item will be purple for example. */
        qualitycolor: true
    };
</script>
<script src="{!! elixir('js/bootstrap.js') !!}"></script>
<script src="{!! elixir('js/app.js') !!}"></script>

@stack('footer.scripts')