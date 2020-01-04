<?php

    Route::group(['namespace' => 'Kumarrahul\salaryslipuploader\Http\Controllers', 'middleware' => ['web'], 'prefix' => 'member'], function(){
        Route::get('salary', 'SalarySlipController@index')->middleware('auth');
        Route::get('salary/data',  'SalarySlipController@data')->name('member.salary.data')->middleware('auth');
        Route::get('salary/download/{id}',  'SalarySlipController@download')->name('member.salary.download')->middleware('auth');
    });