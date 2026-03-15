<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
  dd(app()->getLocale());
});
