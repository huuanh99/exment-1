<?php

namespace Exceedone\Exment\Middleware;

use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin as Ad;

/**
 * Middleware as Bootstrap, for public form.
 * Setup for display. ex. set css, js, ...
 */
class BootstrapPublicForm
{
    use BootstrapTrait;
    
    public function handle(Request $request, \Closure $next)
    {
        $this->setCssJs($request, $next);

        return $next($request);
    }

    /**
     * Set css and js. only first request(not ajax and pjax)
     *
     * @param Request $request
     * @param \Closure $next
     * @return void
     */
    protected function setCssJs(Request $request, \Closure $next)
    {
        if ($request->ajax() || $request->pjax()) {
            return;
        }

        if ($this->isStaticRequest($request)) {
            return;
        }

        Ad::js(asset('lib/js/jquery-ui.min.js'));
        Ad::css(asset('lib/css/jquery-ui.min.css'));
        Ad::js(asset('lib/js/bignumber.min.js'));

        $this->setCssJsList([
            'vendor/exment/fullcalendar/core/main.min.css',
            'vendor/exment/fullcalendar/daygrid/main.min.css',
            'vendor/exment/fullcalendar/list/main.min.css',
            'vendor/exment/fullcalendar/timegrid/main.min.css',
            'vendor/exment/css/common.css',
            'vendor/exment/codemirror/codemirror.css',
            'vendor/exment/jstree/themes/default/style.min.css',
        ], true);

        $this->setCssJsList([
            'vendor/exment/validation/jquery.validate.js',
            'vendor/exment/chartjs/chart.min.js',
            'vendor/exment/codemirror/codemirror.js',
            'vendor/exment/codemirror/mode/htmlmixed/htmlmixed.js',
            'vendor/exment/codemirror/mode/xml/xml.js',
            'vendor/exment/codemirror/mode/javascript/javascript.js',
            'vendor/exment/codemirror/mode/css/css.js',
            'vendor/exment/codemirror/mode/php/php.js',
            'vendor/exment/codemirror/mode/clike/clike.js',
            'vendor/exment/jquery/jquery.color.min.js',
            'vendor/exment/mathjs/math.min.js',
            'vendor/exment/js/numberformat.js',
            'vendor/exment/fullcalendar/core/main.min.js',
            'vendor/exment/fullcalendar/core/locales-all.min.js',
            'vendor/exment/fullcalendar/interaction/main.min.js',
            'vendor/exment/fullcalendar/daygrid/main.min.js',
            'vendor/exment/fullcalendar/list/main.min.js',
            'vendor/exment/fullcalendar/timegrid/main.min.js',
            'vendor/exment/jstree/jstree.min.js',
            'vendor/exment/js/common_all.js',
            'vendor/exment/js/common.js',
            'vendor/exment/js/calc.js',
            'vendor/exment/js/modal.js',
            'vendor/exment/js/changefield.js',
            'vendor/exment/js/webapi.js',
            'vendor/exment/js/publicform.webapi.js',
            'vendor/exment/js/getbox.js',
            'vendor/exment/js/publicform.getbox.js',
        ], false);
    }
}
