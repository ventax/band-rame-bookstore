<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('shipping_cost', 10, 2)->default(0)->after('total_amount');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('shipping_cost');
            $table->decimal('grand_total', 12, 2)->after('discount_amount');

            $table->enum('payment_method', ['transfer_bank', 'cod'])->default('transfer_bank')->after('status');
            $table->enum('payment_status', ['unpaid', 'paid', 'failed', 'expired'])->default('unpaid')->after('payment_method');
            $table->string('payment_proof')->nullable()->after('payment_status');
            $table->timestamp('paid_at')->nullable()->after('payment_proof');
            $table->timestamp('shipped_at')->nullable()->after('notes');
            $table->timestamp('delivered_at')->nullable()->after('shipped_at');
            $table->timestamp('cancelled_at')->nullable()->after('delivered_at');
            $table->text('cancellation_reason')->nullable()->after('cancelled_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_cost',
                'discount_amount',
                'grand_total',
                'payment_method',
                'payment_status',
                'payment_proof',
                'paid_at',
                'shipped_at',
                'delivered_at',
                'cancelled_at',
                'cancellation_reason'
            ]);
        });
    }
};
