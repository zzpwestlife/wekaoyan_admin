<?php

Route::group(['prefix' => 'admin'], function () {
    Route::get('/test', '\App\Admin\Controllers\TestController@index');
    Route::get('/login', '\App\Admin\Controllers\LoginController@index');
    Route::post('/login', '\App\Admin\Controllers\LoginController@login');
    Route::get('/logout', '\App\Admin\Controllers\LoginController@logout');

    // 需要登陆的
//    Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/home', '\App\Admin\Controllers\HomeController@index');

    // 系统管理
    Route::group(['middleware' => 'can:system'], function () {
        // 用户管理
        Route::get('/users', '\App\Admin\Controllers\UserController@index');
        Route::get('/users/create', '\App\Admin\Controllers\UserController@create');
        Route::post('/users/store', '\App\Admin\Controllers\UserController@store');
        Route::get('/users/{user}/role', '\App\Admin\Controllers\UserController@role');
        Route::post('/users/{user}/role', '\App\Admin\Controllers\UserController@storeRole');

        // 角色管理
        Route::get('/roles', '\App\Admin\Controllers\RoleController@index');
        Route::get('/roles/create', '\App\Admin\Controllers\RoleController@create');
        Route::post('/roles/store', '\App\Admin\Controllers\RoleController@store');
        Route::get('/roles/{role}/permission', '\App\Admin\Controllers\RoleController@permission');
        Route::post('/roles/{role}/permission', '\App\Admin\Controllers\RoleController@storePermission');

        // 权限管理
        Route::get('/permissions', '\App\Admin\Controllers\PermissionController@index');
        Route::get('/permissions/create', '\App\Admin\Controllers\PermissionController@create');
        Route::post('/permissions/store', '\App\Admin\Controllers\PermissionController@store');
    });

    //
//    /**
//     * 学校管理
//     */
//    Route::get('/schools', '\App\Admin\Controllers\ForumController@index');
//    // 新增界面
//    Route::get('schools/create', [
//        'as' => 'schools.create',
//        'uses' => '\App\Admin\Controllers\ForumController@create'
//    ]);
//
//    // 编辑界面
//    Route::get('schools/create/{id}', [
//        'as' => 'schools.update',
//        'uses' => '\App\Admin\Controllers\ForumController@create'
//    ]);
//
//    Route::post('/schools/store', '\App\Admin\Controllers\ForumController@store');
//    Route::post('/schools/{school}/delete', '\App\Admin\Controllers\ForumController@delete');
//
//    /**
//     * 专业管理
//     */
//    Route::get('/majors', '\App\Admin\Controllers\MajorController@index');
//    // 新增界面
//    Route::get('majors/create', [
//        'as' => 'majors.create',
//        'uses' => '\App\Admin\Controllers\MajorController@create'
//    ]);
//
//    // 编辑界面
//    Route::get('majors/create/{id}', [
//        'as' => 'majors.update',
//        'uses' => '\App\Admin\Controllers\MajorController@create'
//    ]);
//
//    Route::post('/majors/store', '\App\Admin\Controllers\MajorController@store');
//    Route::post('/majors/{major}/delete', '\App\Admin\Controllers\MajorController@delete');

    /**
     * 论坛管理----------------------------------------------------------------------------------------------------------
     */
    Route::get('/forums', '\App\Admin\Controllers\ForumController@index');
    // 新增界面
    Route::get('forums/create', [
        'as' => 'forums.create',
        'uses' => '\App\Admin\Controllers\ForumController@create'
    ]);

    // 编辑界面
    Route::get('forums/create/{id}', [
        'as' => 'forums.update',
        'uses' => '\App\Admin\Controllers\ForumController@create'
    ]);

    Route::post('/forums/store', '\App\Admin\Controllers\ForumController@store');
    Route::post('/forums/delete', '\App\Admin\Controllers\ForumController@delete');

    /**
     * 说说管理----------------------------------------------------------------------------------------------------------
     */
    Route::get('/shuoshuos', '\App\Admin\Controllers\ShuoshuoController@index');
    // 新增界面
    Route::get('shuoshuos/create', [
        'as' => 'shuoshuos.create',
        'uses' => '\App\Admin\Controllers\ShuoshuoController@create'
    ]);

    // 编辑界面
    Route::get('shuoshuos/create/{id}', [
        'as' => 'shuoshuos.update',
        'uses' => '\App\Admin\Controllers\ShuoshuoController@create'
    ]);

    Route::post('/shuoshuos/store', '\App\Admin\Controllers\ShuoshuoController@store');
    Route::post('/shuoshuos/delete', '\App\Admin\Controllers\ShuoshuoController@delete');

    /**
     * 说说评论管理----------------------------------------------------------------------------------------------------------
     */
    Route::get('/shuoshuo_comments', '\App\Admin\Controllers\ShuoshuoCommentController@index');

    // 新增界面
    Route::get('shuoshuo_comments/create', [
        'as' => 'shuoshuo_comments.create',
        'uses' => '\App\Admin\Controllers\ShuoshuoCommentController@create'
    ]);

    // 编辑界面
    Route::get('shuoshuo_comments/create/{id}', [
        'as' => 'shuoshuo_comments.update',
        'uses' => '\App\Admin\Controllers\ShuoshuoCommentController@create'
    ]);

    Route::post('/shuoshuo_comments/store', '\App\Admin\Controllers\ShuoshuoCommentController@store');
    Route::post('/shuoshuo_comments/delete', '\App\Admin\Controllers\ShuoshuoCommentController@delete');

    /**
     * 经验贴管理----------------------------------------------------------------------------------------------------------
     */
    Route::get('/posts', '\App\Admin\Controllers\PostController@index');
    // 新增界面
    Route::get('posts/create', [
        'as' => 'posts.create',
        'uses' => '\App\Admin\Controllers\PostController@create'
    ]);

    // 编辑界面
    Route::get('posts/create/{id}', [
        'as' => 'posts.update',
        'uses' => '\App\Admin\Controllers\PostController@create'
    ]);

    Route::post('/posts/store', '\App\Admin\Controllers\PostController@store');
    Route::post('/posts/delete', '\App\Admin\Controllers\PostController@delete');

    // 图片上传
    Route::post('/posts/image/upload', '\App\Admin\Controllers\PostController@imageUpload');

    /**
     * 问题管理----------------------------------------------------------------------------------------------------------
     */
    Route::get('/questions', '\App\Admin\Controllers\QuestionController@index');
    // 新增界面
    Route::get('questions/create', [
        'as' => 'questions.create',
        'uses' => '\App\Admin\Controllers\QuestionController@create'
    ]);

    // 编辑界面
    Route::get('questions/create/{id}', [
        'as' => 'questions.update',
        'uses' => '\App\Admin\Controllers\QuestionController@create'
    ]);

    Route::post('/questions/store', '\App\Admin\Controllers\QuestionController@store');
    Route::post('/questions/delete', '\App\Admin\Controllers\QuestionController@delete');

    /**
     * 问题答案管理----------------------------------------------------------------------------------------------------------
     */
    Route::get('/answers', '\App\Admin\Controllers\AnswerController@index');

    // 新增界面
    Route::get('answers/create', [
        'as' => 'answers.create',
        'uses' => '\App\Admin\Controllers\AnswerController@create'
    ]);

    // 编辑界面
    Route::get('answers/create/{id}', [
        'as' => 'answers.update',
        'uses' => '\App\Admin\Controllers\AnswerController@create'
    ]);

    Route::post('/answers/store', '\App\Admin\Controllers\AnswerController@store');
    Route::post('/answers/delete', '\App\Admin\Controllers\AnswerController@delete');
    /**
     * 文件管理----------------------------------------------------------------------------------------------------------
     */
    Route::get('/files', '\App\Admin\Controllers\FileController@index');
    // 新增界面
    Route::get('files/create', [
        'as' => 'files.create',
        'uses' => '\App\Admin\Controllers\FileController@create'
    ]);

    // 编辑界面
    Route::get('files/create/{id}', [
        'as' => 'files.update',
        'uses' => '\App\Admin\Controllers\FileController@create'
    ]);

    Route::post('/files/store', '\App\Admin\Controllers\FileController@store');
    Route::post('/files/delete', '\App\Admin\Controllers\FileController@delete');
});
