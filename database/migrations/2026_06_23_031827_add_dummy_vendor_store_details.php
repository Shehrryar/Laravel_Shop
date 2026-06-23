<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Add store details columns
        |--------------------------------------------------------------------------
        */
        Schema::table('stores', function (Blueprint $table) {
            if (!Schema::hasColumn('stores', 'store_name')) {
                $table->string('store_name')->nullable()->after('id');
            }

            if (!Schema::hasColumn('stores', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('store_name');
            }

            if (!Schema::hasColumn('stores', 'owner_name')) {
                $table->string('owner_name')->nullable()->after('slug');
            }

            if (!Schema::hasColumn('stores', 'email')) {
                $table->string('email')->nullable()->after('owner_name');
            }

            if (!Schema::hasColumn('stores', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }

            if (!Schema::hasColumn('stores', 'logo')) {
                $table->string('logo')->nullable()->after('phone');
            }

            if (!Schema::hasColumn('stores', 'banner')) {
                $table->string('banner')->nullable()->after('logo');
            }

            if (!Schema::hasColumn('stores', 'address')) {
                $table->text('address')->nullable()->after('banner');
            }

            if (!Schema::hasColumn('stores', 'city')) {
                $table->string('city')->nullable()->after('address');
            }

            if (!Schema::hasColumn('stores', 'country')) {
                $table->string('country')->nullable()->after('city');
            }

            if (!Schema::hasColumn('stores', 'commission_rate')) {
                $table->decimal('commission_rate', 8, 2)->default(10)->after('country');
            }

            if (!Schema::hasColumn('stores', 'status')) {
                $table->tinyInteger('status')->default(1)->after('commission_rate');
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Add store_id to users table
        |--------------------------------------------------------------------------
        */
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'store_id')) {
                $table->unsignedBigInteger('store_id')->nullable()->after('id');

                $table->foreign('store_id')
                    ->references('id')
                    ->on('stores')
                    ->onDelete('set null');
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Insert dummy vendors and stores
        |--------------------------------------------------------------------------
        */
        $vendors = [
            [
                'store_name' => 'Fashion Store',
                'owner_name' => 'Vendor One',
                'email' => 'vendor1@gmail.com',
                'phone' => '03000000001',
                'password' => 'vendor123',
                'city' => 'Seoul',
                'country' => 'South Korea',
                'address' => 'Fashion Market Street',
            ],
            [
                'store_name' => 'Electronics Store',
                'owner_name' => 'Vendor Two',
                'email' => 'vendor2@gmail.com',
                'phone' => '03000000002',
                'password' => 'vendor123',
                'city' => 'Incheon',
                'country' => 'South Korea',
                'address' => 'Electronics Market Road',
            ],
            [
                'store_name' => 'Grocery Store',
                'owner_name' => 'Vendor Three',
                'email' => 'vendor3@gmail.com',
                'phone' => '03000000003',
                'password' => 'vendor123',
                'city' => 'Busan',
                'country' => 'South Korea',
                'address' => 'Grocery Market Avenue',
            ],
        ];

        foreach ($vendors as $vendor) {
            $slug = Str::slug($vendor['store_name']);

            $existingStore = DB::table('stores')
                ->where('email', $vendor['email'])
                ->first();

            if ($existingStore) {
                $storeId = $existingStore->id;

                DB::table('stores')
                    ->where('id', $storeId)
                    ->update([
                        'store_name' => $vendor['store_name'],
                        'slug' => $slug,
                        'owner_name' => $vendor['owner_name'],
                        'phone' => $vendor['phone'],
                        'address' => $vendor['address'],
                        'city' => $vendor['city'],
                        'country' => $vendor['country'],
                        'commission_rate' => 10,
                        'status' => 1,
                        'updated_at' => now(),
                    ]);
            } else {
                $storeId = DB::table('stores')->insertGetId([
                    'store_name' => $vendor['store_name'],
                    'slug' => $slug,
                    'owner_name' => $vendor['owner_name'],
                    'email' => $vendor['email'],
                    'phone' => $vendor['phone'],
                    'logo' => null,
                    'banner' => null,
                    'address' => $vendor['address'],
                    'city' => $vendor['city'],
                    'country' => $vendor['country'],
                    'commission_rate' => 10,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $existingUser = DB::table('users')
                ->where('email', $vendor['email'])
                ->first();

            if ($existingUser) {
                DB::table('users')
                    ->where('id', $existingUser->id)
                    ->update([
                        'store_id' => $storeId,
                        'name' => $vendor['owner_name'],
                        'phone' => $vendor['phone'],
                        'password' => Hash::make($vendor['password']),
                        'role' => 3,
                        'status' => 1,
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('users')->insert([
                    'store_id' => $storeId,
                    'name' => $vendor['owner_name'],
                    'email' => $vendor['email'],
                    'phone' => $vendor['phone'],
                    'password' => Hash::make($vendor['password']),
                    'role' => 3,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $emails = [
            'vendor1@gmail.com',
            'vendor2@gmail.com',
            'vendor3@gmail.com',
        ];

        DB::table('users')->whereIn('email', $emails)->delete();
        DB::table('stores')->whereIn('email', $emails)->delete();

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'store_id')) {
                try {
                    $table->dropForeign(['store_id']);
                } catch (\Throwable $e) {
                    // Foreign key may already be removed.
                }

                $table->dropColumn('store_id');
            }
        });

        Schema::table('stores', function (Blueprint $table) {
            $columns = [
                'store_name',
                'slug',
                'owner_name',
                'email',
                'phone',
                'logo',
                'banner',
                'address',
                'city',
                'country',
                'commission_rate',
                'status',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('stores', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};