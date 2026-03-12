<?php

use Illuminate\Support\Facades\Route;
use Redcodede\Captcha\Http\Controllers\RefreshCaptchaController;

Route::get('/redcodede/captcha/refresh', RefreshCaptchaController::class)
    ->name('redcodede.captcha.refresh');