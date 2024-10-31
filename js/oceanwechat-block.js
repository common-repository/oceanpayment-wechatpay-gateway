
const oceanwechat_settings = window.wc.wcSettings.getSetting( 'oceanwechat_data', {} );


const oceanwechat_label = window.wp.htmlEntities.decodeEntities( oceanwechat_settings.title ) || window.wp.i18n.__( 'Oceanpayment WeChatPay Payment Gateway', 'oceanpayment-wechat-gateway' );




const oceanwechat_Content = () => {
    return window.wp.htmlEntities.decodeEntities( oceanwechat_settings.description || '' );
};


var I = function(e) {
    var t = e.components,
        n = e.title,
        r = e.icons,
        a = e.id;
    Array.isArray(r) || (r = [r]);
    var o = t.PaymentMethodLabel,
        i = t.PaymentMethodIcons;

    const style = {
        'align-items': 'center',
        'display': 'flex',
        'width': '100%'
    };

    return React.createElement("div", {
        className: "wc-oceanwechat-blocks-payment-method__label ".concat(a),
        style:style
    }, React.createElement(o, {
        text: n
    }), React.createElement(i, {
        icons: r
    }))
};
const Oceanwechat_Block_Gateway = {
    name: 'oceanwechat',

    label: React.createElement(I, {
        id: "oceanwechat",
        title: oceanwechat_settings.title,
        icons: oceanwechat_settings.icons
    }),

    content: Object( window.wp.element.createElement )( oceanwechat_Content, null ),
    edit: Object( window.wp.element.createElement )( oceanwechat_Content, null ),
    canMakePayment: () => true,
    ariaLabel: oceanwechat_label,
    // placeOrderButtonLabel: window.wp.i18n.__( 'Proceed to Oceanpayment', 'oceanpayment-wechat-gateway' ),

};

window.wc.wcBlocksRegistry.registerPaymentMethod( Oceanwechat_Block_Gateway );