<?php

/**
 * Custom Admin Routes File
 *
 * This file allows adding custom admin routes without modifying the main admin.php
 * Routes defined here will be loaded by the main admin routes file.
 */

use Illuminate\Support\Facades\Route;

// Get the admin panel prefix from the main application
$prefix = getAdminPanelUrlPrefix();

/**
 * Define your custom admin panel routes here
 * They will be automatically loaded alongside the main admin routes
 * 
 * All routes will be prefixed with your admin panel prefix 
 * and will have 'web' and 'admin' middleware applied automatically
 */

// Example of custom routes:
// 
// Route::group(['prefix' => 'custom-section'], function () {
//     Route::get('/', 'YourCustomController@index')->name('admin.custom.index');
//     Route::get('/create', 'YourCustomController@create')->name('admin.custom.create');
//     Route::post('/store', 'YourCustomController@store')->name('admin.custom.store');
//     Route::get('/{id}/edit', 'YourCustomController@edit')->name('admin.custom.edit');
//     Route::post('/{id}/update', 'YourCustomController@update')->name('admin.custom.update');
//     Route::get('/{id}/delete', 'YourCustomController@delete')->name('admin.custom.delete');
// });

// You can add as many route groups as needed

Route::get('/bundles', 'Admin\BundleController@index');
Route::get('/bundles/create', 'Admin\BundleController@create');
Route::post('/bundles/store', 'Admin\BundleController@store');
Route::get('/bundles/{id}/edit', 'Admin\BundleController@edit');
Route::post('/bundles/{id}/update', 'Admin\BundleController@update');
Route::get('/bundles/{id}/students', 'Admin\BundleController@students');

Route::get('/upcoming_courses', 'Admin\UpcomingCoursesController@index');
Route::get('/upcoming_courses/create', 'Admin\UpcomingCoursesController@create');
Route::post('/upcoming_courses/store', 'Admin\UpcomingCoursesController@store');
Route::get('/upcoming_courses/{id}/edit', 'Admin\UpcomingCoursesController@edit');
Route::post('/upcoming_courses/{id}/update', 'Admin\UpcomingCoursesController@update');
Route::get('/upcoming_courses/{id}/followers', 'Admin\UpcomingCoursesController@followers');

Route::get('/quizzes', 'Admin\QuizController@index');
Route::get('/quizzes/create', 'Admin\QuizController@create');
Route::get('/quizzes/{id}/edit', 'Admin\QuizController@edit');

Route::get('/assignments', 'Admin\AssignmentController@index');
Route::get('/assignments/{id}/students', 'Admin\AssignmentController@students');

Route::get('/enrollments/history', 'Admin\EnrollmentController@history');
Route::get('/enrollments/add-student-to-class', 'Admin\EnrollmentController@addStudentToClass');

Route::get('/waitlists', 'Admin\WaitlistController@index');
Route::get('/waitlists/export', 'Admin\WaitlistController@exportExcel');
Route::get('/waitlists/{webinarId}/users', 'Admin\WaitlistController@viewList');
Route::get('/waitlists/{webinarId}/export_list', 'Admin\WaitlistController@exportUsersList');
Route::get('/waitlists/{webinarId}/disable', 'Admin\WaitlistController@disableWaitlist');

Route::get('/attendances/history', 'Admin\AttendanceController@index');
Route::get('/attendances/settings', 'Admin\AttendanceController@settings');
Route::post('/attendances/settings/store', 'Admin\AttendanceController@storeSettings');
Route::get('/attendances/history/excel', 'Admin\AttendanceController@exportExcel');
Route::get('/attendances/{sessionId}/details', 'Admin\AttendanceDetailsController@index');
Route::get('/attendances/{sessionId}/details/excel', 'Admin\AttendanceDetailsController@exportExcel');
Route::get('/attendances/{sessionId}/details/{studentId}/status/{status}', 'Admin\AttendanceDetailsController@changeStatus');

Route::get('/certificates', 'Admin\CertificateController@index');
Route::get('/certificates/templates', 'Admin\CertificateController@CertificatesTemplatesList');
Route::get('/certificates/templates/new', 'Admin\CertificateController@CertificatesNewTemplate');
Route::get('/certificates/templates/{template_id}/edit', 'Admin\CertificateController@CertificatesTemplatesEdit');
Route::get('/certificates/settings', 'Admin\CertificateController@settings');
Route::get('/certificates/course', 'Admin\WebinarCertificateController@index');
Route::post('/certificates/settings/store', 'Admin\CertificateController@storeSettings');
Route::get('/certificates/excel', 'Admin\CertificateController@exportExcel');
Route::get('/certificates/{id}/download', 'Admin\CertificateController@CertificatesDownload');
Route::get('/certificates/course/{certificateId}/download', 'Admin\WebinarCertificateController@show');

Route::get('/course-noticeboards', 'Admin\CourseNoticeboardController@index');
Route::get('/course-noticeboards/create', 'Admin\CourseNoticeboardController@create');
Route::post('/course-noticeboards/store', 'Admin\CourseNoticeboardController@store');
Route::post('/course-noticeboards/{noticeboard_id}/update', 'Admin\CourseNoticeboardController@update');
Route::get('/course-noticeboards/{noticeboard_id}/edit', 'Admin\CourseNoticeboardController@edit');

Route::get('/forums', 'Admin\ForumController@index');
Route::get('/forums/create', 'Admin\ForumController@create');
Route::get('/forums/{id}/edit', 'Admin\ForumController@edit');
Route::get('/forums/search-topics', 'Admin\ForumController@searchTopics');
Route::get('/forums/{forumId}/topics', 'Admin\ForumTopicsController@index');
Route::get('/forums/topics/create', 'Admin\ForumTopicsController@create');
Route::get('/recommended-topics', 'Admin\RecommendedTopicsController@index');
Route::get('/recommended-topics/create', 'Admin\RecommendedTopicsController@create');
Route::post('/recommended-topics/store', 'Admin\RecommendedTopicsController@store');
Route::get('/recommended-topics/{id}/edit', 'Admin\RecommendedTopicsController@edit');
Route::post('/recommended-topics/{id}/update', 'Admin\RecommendedTopicsController@update');
Route::post('/recommended-topics/{id}/delete', 'Admin\RecommendedTopicsController@destroy');
Route::get('/featured-topics', 'Admin\FeaturedTopicsController@index');
Route::get('/featured-topics/create', 'Admin\FeaturedTopicsController@create');
Route::post('/featured-topics/store', 'Admin\FeaturedTopicsController@store');
Route::get('/featured-topics/{id}/edit', 'Admin\FeaturedTopicsController@edit');
Route::post('/featured-topics/{id}/update', 'Admin\FeaturedTopicsController@update');
Route::post('/featured-topics/{id}/delete', 'Admin\FeaturedTopicsController@destroy');

/**
 * To use these routes, you must have your controller in App\Http\Controllers\Admin namespace
 * or specify the complete namespace like:
 * 
 * Route::get('/custom-page', '\App\Http\Controllers\YourNamespace\YourController@method');
 */
