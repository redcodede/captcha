<?php

namespace Redcodede\Captcha\Tags;

use Redcodede\Captcha\Captcha;
use Statamic\Tags\Tags;

/**
 * This Tag only tracks Page views.
 * For FormSubmissions use the Event Listener.
 */
class CaptchaImage extends Tags
{
    protected static $handle = 'captcha_image';

    /**
     * The {{ track_page_view }} tag.
     *
     * @return string|array
     */
    public function index()
    {
        try {
            return $_SESSION['captcha'];
        } catch (\Exception $e) {
            // do nothing
        }
    }

}
