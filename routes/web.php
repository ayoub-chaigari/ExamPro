<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamVariantController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/student/quizzes/access', [App\Http\Controllers\QuizController::class, 'access'])->name('quizzes.access');
Route::get('/student/quizzes/{code}/{student_name}', [App\Http\Controllers\QuizController::class, 'start'])->name('quizzes.start');
Route::post('/student/quizzes/{code}/submit', [App\Http\Controllers\QuizController::class, 'submit'])->name('quizzes.submit');
Route::get('/student/quizzes/{code}/result/{student_name}', [App\Http\Controllers\QuizController::class, 'result'])->name('quizzes.result');

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Teacher Only: Question Bank and Exam Management
    Route::middleware('teacher')->group(function () {
        Route::resource('categories', CategoryController::class);
        
        // Question Import
        Route::get('questions/import', [App\Http\Controllers\QuestionImportController::class, 'show'])->name('questions.import.show');
        Route::post('questions/import', [App\Http\Controllers\QuestionImportController::class, 'store'])->name('questions.import.store');
        
        Route::resource('questions', QuestionController::class);
        Route::post('questions/reorder', [QuestionController::class, 'reorder'])->name('questions.reorder');
        Route::post('/questions/rephrase', [QuestionController::class, 'rephrase'])->name('questions.rephrase');
        Route::post('questions/upload-image', [QuestionController::class, 'uploadImage'])->name('questions.upload-image');
        Route::delete('questions/{question}/remove-from-exam', [QuestionController::class, 'removeFromExam'])->name('questions.remove-from-exam');
        
        // Exam Management (Creation/Editing)
        Route::get('exams/create', [ExamController::class, 'create'])->name('exams.create');
        Route::post('exams', [ExamController::class, 'store'])->name('exams.store');
        Route::get('exams/{exam}/edit', [ExamController::class, 'edit'])->name('exams.edit');
        Route::patch('exams/{exam}', [ExamController::class, 'update'])->name('exams.update');
        Route::delete('exams/{exam}', [ExamController::class, 'destroy'])->name('exams.destroy');
        
        Route::post('exams/{exam}/sections', [SectionController::class, 'store'])->name('exams.sections.store');
        Route::put('sections/{section}', [SectionController::class, 'update'])->name('exams.sections.update');
        Route::delete('sections/{section}', [SectionController::class, 'destroy'])->name('exams.sections.destroy');
        Route::post('exams/{exam}/sections/{section}/add-questions', [ExamController::class, 'addQuestionsToSection'])->name('exams.sections.add-questions');
        Route::post('exams/{exam}/generate-variants', [ExamController::class, 'generateVariants'])->name('exams.generate-variants');
        Route::get('exams/{exam}/correction', [ExamController::class, 'generateCorrection'])->name('exams.correction');
        Route::get('exams/{exam}/export-word', [ExamController::class, 'exportToWord'])->name('exams.export-word');
        
        Route::resource('exam_variants', ExamVariantController::class)->except(['index', 'show']);
        Route::resource('quizzes', App\Http\Controllers\QuizController::class);
        Route::get('quizzes/{quiz}/results', [App\Http\Controllers\QuizController::class, 'teacherResults'])->name('quizzes.teacher_results');
        Route::get('quizzes/{quiz}/results/{student_name}', [App\Http\Controllers\QuizController::class, 'studentDetails'])->name('quizzes.student_details');
    });

    // Both Admin and Teacher (Viewing Exams)
    Route::get('exams', [ExamController::class, 'index'])->name('exams.index');
    Route::get('exams/{exam}', [ExamController::class, 'show'])->name('exams.show');
    Route::get('exam_variants/{variant}/export-pdf', [ExamVariantController::class, 'exportPdf'])->name('exam_variants.export-pdf');

    // Admin Only: User Management
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/test-ai', [\App\Http\Controllers\AIController::class, 'test'])->name('ai.test');
    });
});

require __DIR__.'/auth.php';

// Custom Password Reset Routes
use App\Http\Controllers\Auth\PasswordResetController;

Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('custom.password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('custom.password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('custom.password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('custom.password.update');
