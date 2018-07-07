mspStripe.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'mspstripe-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('mspstripe') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('mspstripe_items'),
                layout: 'anchor',
                items: [{
                    html: _('mspstripe_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'mspstripe-grid-items',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    mspStripe.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(mspStripe.panel.Home, MODx.Panel);
Ext.reg('mspstripe-panel-home', mspStripe.panel.Home);
