<?php

return [
    'auth' => [
        'login' => [
            'title' => 'Sign In',
            'heading' => env('APP_NAME', ''),
            'register' => 'Don\'t have an account?',
            'forgot' => 'Forgot your password?',
            'remember' => 'Remember me',
            'submit' => 'Sign in',
            'forms' => [
                'email' => 'Email address',
                'password' => 'Password',
            ],
        ],
        'register' => [
            'title' => 'Sign Up',
            'heading' => env('APP_NAME', ''),
            'login' => 'Already have an account?',
            'forms' => [
                'name' => 'Full name',
                'email' => 'Email address',
                'password' => 'Password',
                'password_confirmation' => 'Confirm password',
            ],
            'submit' => 'Sign up',
        ],
    ]
];
