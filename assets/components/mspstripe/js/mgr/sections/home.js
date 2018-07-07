mspStripe.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'mspstripe-panel-home',
            renderTo: 'mspstripe-panel-home-div'
        }]
    });
    mspStripe.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(mspStripe.page.Home, MODx.Component);
Ext.reg('mspstripe-page-home', mspStripe.page.Home);