<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBorrowQtyTriggers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER update_student_borrow_qty_after_insert
            AFTER INSERT ON borrowdeatils
            FOR EACH ROW
            BEGIN
                UPDATE student
                SET borrow_qty = borrow_qty + NEW.qty
                WHERE id = NEW.stu_id;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER update_student_borrow_qty_after_update
            AFTER UPDATE ON borrowdeatils
            FOR EACH ROW
            BEGIN
                UPDATE student
                SET borrow_qty = borrow_qty - OLD.qty + NEW.qty
                WHERE id = NEW.stu_id;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER update_student_borrow_qty_after_delete
            AFTER DELETE ON borrowdeatils
            FOR EACH ROW
            BEGIN
                UPDATE student
                SET borrow_qty = borrow_qty - OLD.qty
                WHERE id = OLD.stu_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS update_student_borrow_qty_after_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS update_student_borrow_qty_after_update');
        DB::unprepared('DROP TRIGGER IF EXISTS update_student_borrow_qty_after_delete');
    }
}