var mspStripe = function (config) {
    config = config || {};
    mspStripe.superclass.constructor.call(this, config);
};
Ext.extend(mspStripe, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('mspstripe', mspStripe);

mspStripe = new mspStripe();