<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateBookQtyTriggers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Trigger for decreasing book quantity after inserting a borrowing record
        DB::unprepared('
            CREATE TRIGGER decrement_book_quantity_after_insert
            AFTER INSERT ON borrowdeatils
            FOR EACH ROW
            BEGIN
                UPDATE book
                SET book_quantity = book_quantity - NEW.qty
                WHERE id = NEW.book_id;
            END
        ');

        // Trigger for adjusting book quantity after updating a borrowing record
        DB::unprepared('
            CREATE TRIGGER adjust_book_quantity_after_update
            AFTER UPDATE ON borrowdeatils
            FOR EACH ROW
            BEGIN
                UPDATE book
                SET book_quantity = book_quantity + OLD.qty - NEW.qty
                WHERE id = NEW.book_id;
            END
        ');

        // Trigger for increasing book quantity after deleting a borrowing record
        DB::unprepared('
            CREATE TRIGGER increment_book_quantity_after_delete
            AFTER DELETE ON borrowdeatils
            FOR EACH ROW
            BEGIN
                UPDATE book
                SET book_quantity = book_quantity + OLD.qty
                WHERE id = OLD.book_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS decrement_book_quantity_after_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS adjust_book_quantity_after_update');
        DB::unprepared('DROP TRIGGER IF EXISTS increment_book_quantity_after_delete');
    }
}
