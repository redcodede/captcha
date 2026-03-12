<?php

namespace Redcodede\Captcha\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Redcodede\Captcha\Captcha;

class RefreshCaptchaController extends Controller
{
    public function __invoke(Request $request, Captcha $captcha): array
    {
        return [
            'image' => $captcha->refreshImage(),
        ];
    }
}