<?php

Route::group(['middleware' => ['web', 'permission:' . \Gcms::MAIN_ADMIN_PERMISSION], 'prefix' => getAdminPrefix('seo')], function () {
    Route::group(['middleware' => ['permission:modules_seo_admin_list']], function () {
        Route::get(DIRECTORY_SEPARATOR, function () {
        });
    });

    Route::group(['middleware' => ['permission:modules_seo_admin_list']], function () {
        // redirect
        Route::group(['prefix' => 'redirect'], function () {
            Route::get(DIRECTORY_SEPARATOR, function () {
                return 'redirect get';
            })->name('admin.seo.redirect');

            Route::post(DIRECTORY_SEPARATOR, function () {
                return 'redirect post';
            });

            Route::delete('/{rule}', function () {
                return 'redirect delete';
            });

            Route::put('/{rule}', function () {
                return 'redirect put';
            });
        });
    });
});
