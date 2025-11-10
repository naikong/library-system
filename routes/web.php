<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AttendentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\YearController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('/registration', [AuthController::class, 'registration'])->name('register');
Route::post('/post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Securing Routes with Auth Middleware
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Attendent Routes
    Route::get('/attendent', [AttendentController::class, 'index'])->name('attendent.list');
    Route::get('/attendent/export', [AttendentController::class, 'export'])->name('attendent.export');
    Route::get('/attendent/create', [AttendentController::class, 'create'])->name('attendent.create');
    Route::post('/attendent', [AttendentController::class, 'store'])->name('attendent.store');
    Route::get('/attendent/{attendentId}/edit', [AttendentController::class, 'edit'])->name('attendent.edit');
    Route::put('/attendent/{attendentId}', [AttendentController::class, 'update'])->name('attendent.update');
    Route::delete('/attendent/{attendentId}', [AttendentController::class, 'destroy'])->name('attendent.delete');
    Route::get('/attendent/{attendentId}', [AttendentController::class, 'show'])->name('attendent.show');
    Route::get('/attendent/student', [AttendentController::class, 'showStudentPage'])->name('attendent.student');
    Route::post('/attendent/scan', [AttendentController::class, 'scanBarcode'])->name('attendent.scan');
    Route::post('/year/store', [YearController::class, 'store'])->name('year.store');
    Route::post('/faculty/store', [FacultyController::class, 'store'])->name('faculty.store');
    Route::delete('/year/delete/{id}', [YearController::class, 'destroy'])->name('year.destroy');
    Route::post('/subject/store', [SubjectController::class, 'store'])->name('subject.store');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    // Book Routes
    Route::get('/book', [BookController::class, 'index'])->name('book.list');
    Route::get('/book/create', [BookController::class, 'create'])->name('book.create');
    Route::post('/book', [BookController::class, 'store'])->name('book.store');
    Route::get('/book/{bookId}/edit', [BookController::class, 'edit'])->name('book.edit');
    Route::put('/book/{bookId}', [BookController::class, 'update'])->name('book.update');
    Route::delete('/book/{bookId}', [BookController::class, 'destroy'])->name('book.delete');
    Route::get('/book/{bookId}', [BookController::class, 'show'])->name('book.show');
    Route::get('/books/export', [BookController::class, 'export'])->name('books.export');

    // Student Routes
    Route::get('/student', [StudentController::class, 'index'])->name('student.list');
    Route::get('/students', [StudentController::class, 'index'])->name('student.index');
    Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/students', [StudentController::class, 'store'])->name('student.store');
    Route::get('/student/{studentId}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::put('/student/{studentId}', [StudentController::class, 'update'])->name('student.update');
    Route::delete('/student/{studentId}', [StudentController::class, 'destroy'])->name('student.delete');
    Route::get('/student/{studentId}', [StudentController::class, 'show'])->name('student.show');
    Route::get('/students/export', [StudentController::class, 'export'])->name('students.export');
    Route::get('student/{id}/barcode', [StudentController::class, 'generateBarcode'])->name('student.barcode');
    Route::get('student/{id}/barcode/pdf', [StudentController::class, 'generatePDF'])->name('student.barcode.pdf');

    // Borrow Routes
    Route::get('/borrow', [BorrowController::class, 'index'])->name('borrow.index');
    Route::get('/borrow/create', [BorrowController::class, 'create'])->name('borrow.create');
    Route::post('/borrow', [BorrowController::class, 'store'])->name('borrow.store');
    Route::get('/borrow/{borrowId}/edit', [BorrowController::class, 'edit'])->name('borrow.edit');
    Route::put('/borrow/{borrowId}', [BorrowController::class, 'update'])->name('borrow.update');
    Route::delete('/borrow/{borrowId}', [BorrowController::class, 'destroy'])->name('borrow.delete');
    Route::get('/borrow/{borrowId}', [BorrowController::class, 'show'])->name('borrow.show');
    Route::get('borrowings/borrowId', [BorrowController::class, 'export'])->name('borrowings.export');

    // Report Routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
    Route::get('/reports/export/{type}', [ReportController::class, 'export'])->name('reports.export');
});

Route::get('/testuser', function () {
    $user = DB::table('users')->where('id', 1)->first();
    dd($user);
});
