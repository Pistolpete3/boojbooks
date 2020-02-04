<?php

Route::get('/{any}', 'VueController@index')->where('any', '.*');
