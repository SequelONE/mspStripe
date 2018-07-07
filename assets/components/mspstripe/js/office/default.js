Ext.onReady(function () {
    mspStripe.config.connector_url = OfficeConfig.actionUrl;

    var grid = new mspStripe.panel.Home();
    grid.render('office-mspstripe-wrapper');

    var preloader = document.getElementById('office-preloader');
    if (preloader) {
        preloader.parentNode.removeChild(preloader);
    }
});