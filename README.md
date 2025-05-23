# Captcha

> Captcha is a Statamic addon that makes a classic captcha available for Statamic forms.

## Features

This addon does:

- Provide Captcha Image
- Provide Tags to use in your Forms

## Accessibility Notice
Please note that this captcha requires vision to solve.
This captcha provides an image with a 4-character string that needs to be entered in the coresponding form field.

## How to Install

You can search for this addon in the `Tools > Addons` section of the Statamic control panel and click **install**, or run the following command from your project root:

``` bash
composer require redcodede/captcha
```

## How to Use

### 1. Install the addon
Install the Captcha addon into your Statamic project as described in __How to Install__.

### 2. Add new validation rule
To use the Captcha in your form you need to add a new validation rule.
Do this by running `php artisan make:rule VerifyCaptcha` in your terminal.

The new rule should contain these methods:

<code>
public function passes($attribute, mixed $value): bool
{
    try {
        if (strtolower($_SESSION['phrase']) === strtolower($value)) {
            Captcha::refreshCaptcha();
            return true;
        } else {
            return false;
        }
    } catch(\Exception $e) {
        return false;
    }

}

public function message(): string
{
    return '__(validation.verify_captcha)';
}
</code>

The message handles the error messages you may want to define in resources > lang.

### 3. Extend Rule to App Service Provider
At the bottom of the __boot__ method of your *Http/Providers/AppServiceProvider.php* add the following code.

<code>
/*
 * Make Captcha Validation available to Statamic
 * */
Validator::extend('captcha', function ($attribute, $value, $parameters, $validator) {
    return (new VerifyCaptcha())->passes($attribute, $value);
});
</code>

### 4. Add your form field
Your form needs to contain a text form field with the validation rules `required` and `captcha`.

### 5. Include the captcha into your form template
The form template should include the `{{ refresh_captcha }}` tag to generate a new captcha on reloading the form to get a fresh one every time.

Your form field template should include an img tag with the src of `{{ captcha_image }}`. 
This that will provide you with the image URL.

Now you should be all set to use the Captcha on your own Website.
