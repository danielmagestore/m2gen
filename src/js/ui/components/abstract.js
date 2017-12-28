/*
 * Magestore
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magestore
 * @package     Magestore_Webpos
 * @copyright   Copyright (c) 2016 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */
define([
    'ko',
    'jquery',
    'uiComponent',
    'eventManager'
], function (ko, $, Component, EventManager) {
    'use strict';

    return Component.extend({
        defaults: {
            template: ''
        },
        initialize: function () {
            this._super();
        },
        dispatchEvent: function(eventName, data, timeout){
            EventManager.dispatch(eventName, data, timeout);
        },
        observerEvent: function(eventName, function_callback){
            EventManager.observer(eventName, function_callback);
        }
    });
});