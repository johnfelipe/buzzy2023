<div class="widget widget-nopad">
    <div class="widget-header">
        <i class="fa fa-list-alt"></i>
        <span>{{__("Your Code")}}</span>
    </div>
    <!-- /widget-header -->
    <div class="widget-content">

        <textarea style="margin: 0px; width: 100%;outline:none; border:none;height: 361px;">
    <!-- easyComment Content Div -->
    <div id="easyComment_Content"></div>

    <!-- easyComment -->
    <script type="text/javascript">
    // CONFIGURATION VARIABLES
    var easyComment_ContentID = 'MyUnquieId';

    /* * * DON'T EDIT BELOW THIS LINE * * */
    var easyComment_Domain = '{!!url("/")!!}';
    (function() {
        var EC = document.createElement('script');
        EC.type = 'text/javascript';
        EC.async = true;
        EC.src =  easyComment_Domain + '/plugin/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(EC);
    })();
</script>
</textarea><!-- /easyComment -->
        <div class="alert alert-default" style="margin-bottom:0">
            <a href="https://support.akbilisim.com/docs/easycomment/usage" target="_blank">
                <i class="fa fa-info-circle"></i>
                {{__('See here to how to use this code.')}}
            </a>
        </div>
    </div>
</div><!-- /widget -->
