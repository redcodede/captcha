<?php

namespace Redcodede\Captcha\Tags;

use Redcodede\Captcha\Captcha;
use Statamic\Tags\Tags;

/**
 * This Tag only tracks Page views.
 * For FormSubmissions use the Event Listener.
 */
class RefreshCaptcha extends Tags
{
    protected static $handle = 'refresh_captcha';

    /**
     * The {{ track_page_view }} tag.
     *
     * @return string|array
     */
    public function index()
    {
        try {
            Captcha::refreshCaptcha();
        } catch (\Exception $e) {
            // do nothing
        }
    }

}
