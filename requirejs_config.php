<script>
    requirejs.config({
        baseUrl: "http://m2gen.magentovn.com/src/js/",
        urlArgs: "bust=" + (new Date()).getTime(), // Disable require js cache
        waitSeconds: 0,
        paths: {
            domReady: 'domReady',
            jquery: 'lib/jquery/jquery-3.2.1.js',
            underscore: 'lib/underscore',
            ko: 'lib/knockoutjs/knockout',
            'knockout-es5': 'lib/knockoutjs/knockout-es5',
            'es6-collections': 'es6-collections',
            uiApp: 'ui/core/app',
            uiClass: 'ui/lib/core/class',
            uiElement: 'ui/lib/core/element/element',
            uiComponent: 'ui/lib/core/collection',
            uiRegistry: 'ui/lib/registry/registry',
            eventManager: 'model/event-manager',
            accounting: 'lib/accounting.min',
            'mage/url': 'lib/mage/url',
            'mage/utils/wrapper': 'lib/mage/utils/wrapper',
            'mage/apply/main': 'lib/mage/apply/main',
            mageUtils: 'lib/mage/utils/main',
            'hammerjs': 'hammer.min',
            'velocity': 'velocity.min',
            'materialize': 'materialize',
        },
        config: {
            text: {
                useXhr: function (url, protocol, hostname, port) {
                    return true;
                }
            }
        },
        shim: {
            'velocity': {
                deps: ['jquery']
            },
            'materialize': {
                deps: ['jquery', 'velocity']
            }
        }
    });
</script>