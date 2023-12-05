<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            // The voucher code
            $table->string( 'code' )->unique()->nullable( );

            // The human readable voucher code name
            $table->string( 'name' )->unique();

            // The description of the voucher - Not necessary
            $table->string( 'description' )->nullable( );

            //The Image fr design
            $table->string( 'image' )->nullable( );

            //Availabilty
            $table->boolean( 'is_available')->default( true);

            // The number of uses currently
            $table->integer( 'uses' )->unsigned( )->default(0);

            // The max uses this voucher has
            $table->integer( 'max_uses' )->unsigned()->default(10000);

            // How many times a user can use this voucher.
            $table->integer( 'max_uses_user' )->unsigned( )->default(1);

            // The type can be: voucher, discount, sale. What ever you want.
            $table->foreignId( 'voucher_type_id' )->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            // The amount to discount by (in pennies) in this example.
            $table->float( 'discount_amount' );

            // Whether or not the voucher is a percentage or a fixed price.
            $table->enum( 'discount_type' ,['Fixed','Percent'])->default('Percent');

            // When the voucher begins
            $table->timestamp( 'starts_at' );

            // When the voucher ends
            $table->timestamp( 'expires_at' );

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}
