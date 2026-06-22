<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
         |--------------------------------------------------------------------------
         | Drop existing legacy foreign keys first
         |--------------------------------------------------------------------------
         | Some columns already have old foreign keys with different names. MySQL
         | cannot MODIFY a column while it is used by a foreign key, so we drop
         | all existing foreign keys on the columns handled by this migration first.
         */
        $this->dropExistingForeignKeysBeforeColumnChanges();

        /*
         |--------------------------------------------------------------------------
         | Normalize legacy columns
         |--------------------------------------------------------------------------
         | Some old migrations created relationship columns as string/integer
         | columns without constraints. Foreign keys in MySQL need compatible
         | BIGINT UNSIGNED columns, so we normalize only the columns that need it.
         */
        $this->prepareStringForeignId('shipping_charges', 'country_id');
        $this->prepareStringForeignId('color', 'product_id');
        $this->prepareStringForeignId('color', 'size_id');
        $this->prepareStringForeignId('size', 'product_id');

        $this->prepareIntegerForeignId('orders_items', 'order_id');
        $this->prepareIntegerForeignId('orders_items', 'product_id');
        $this->prepareIntegerForeignId('orders_items', 'cart_id');
        $this->prepareIntegerForeignId('stocks', 'color_id');
        $this->prepareIntegerForeignId('stocks', 'size_id');

        $this->prepareIntegerForeignId('cart', 'color_id');
        $this->prepareIntegerForeignId('cart', 'size_id');
        $this->prepareIntegerForeignId('cart', 'product_attribute_id');

        /*
         |--------------------------------------------------------------------------
         | Clean old invalid references before adding constraints
         |--------------------------------------------------------------------------
         */
        $this->nullOrphans('sub_categories', 'category_id', 'categories');

        $this->nullOrphans('sub_sub_categories', 'category_id', 'categories');
        $this->nullOrphans('sub_sub_categories', 'subcategory_id', 'sub_categories');

        $this->nullOrphans('products', 'categories_id', 'categories');
        $this->nullOrphans('products', 'sub_category_id', 'sub_categories');
        $this->nullOrphans('products', 'sub_sub_category_id', 'sub_sub_categories');
        $this->nullOrphans('products', 'brands_id', 'brands');

        $this->deleteOrphans('product_images', 'product_id', 'products');
        $this->deleteOrphans('product_ratings', 'product_id', 'products');

        $this->deleteOrphans('stocks', 'product_id', 'products');
        $this->nullOrphans('stocks', 'color_id', 'color');
        $this->nullOrphans('stocks', 'size_id', 'size');

        $this->deleteOrphans('product_attributes', 'product_id', 'products');
        $this->nullOrphans('product_attributes', 'color_id', 'color');
        $this->nullOrphans('product_attributes', 'size_id', 'size');

        $this->nullOrphans('color', 'product_id', 'products');
        $this->nullOrphans('color', 'size_id', 'size');
        $this->nullOrphans('size', 'product_id', 'products');

        $this->deleteOrphans('cart', 'user_id', 'users');
        $this->deleteOrphans('cart', 'product_id', 'products');
        $this->nullOrphans('cart', 'color_id', 'color');
        $this->nullOrphans('cart', 'size_id', 'size');
        $this->nullOrphans('cart', 'product_attribute_id', 'product_attributes');

        $this->nullOrphans('orders', 'user_id', 'users');
        $this->nullOrphans('orders', 'country_id', 'countries');

        $this->deleteOrphans('orders_items', 'order_id', 'orders');
        $this->nullOrphans('orders_items', 'product_id', 'products');
        $this->nullOrphans('orders_items', 'cart_id', 'cart');

        $this->deleteOrphans('customer_addresses', 'user_id', 'users');
        $this->nullOrphans('customer_addresses', 'country_id', 'countries');

        $this->deleteOrphans('wishlists', 'user_id', 'users');
        $this->deleteOrphans('wishlists', 'product_id', 'products');
        $this->nullOrphans('wishlists', 'color_id', 'color');
        $this->nullOrphans('wishlists', 'size_id', 'size');

        $this->deleteOrphans('shipping_charges', 'country_id', 'countries');

        $this->nullOrphans('product_view', 'user_id', 'users');
        $this->deleteOrphans('product_view', 'product_id', 'products');

        $this->deleteOrphans('messages', 'sender_id', 'users');
        $this->deleteOrphans('messages', 'receiver_id', 'users');

        $this->deleteOrphans('cart_coupon_amounts', 'user_id', 'users');
        $this->deleteOrphans('cart_coupon_amounts', 'cart_id', 'cart');

        /*
         |--------------------------------------------------------------------------
         | Add foreign key constraints
         |--------------------------------------------------------------------------
         */
        $this->addForeign('sub_categories', 'category_id', 'categories', 'fk_sub_categories_category_id', 'set null');

        $this->addForeign('sub_sub_categories', 'category_id', 'categories', 'fk_sub_sub_categories_category_id', 'set null');
        $this->addForeign('sub_sub_categories', 'subcategory_id', 'sub_categories', 'fk_sub_sub_categories_subcategory_id', 'set null');

        $this->addForeign('products', 'categories_id', 'categories', 'fk_products_categories_id', 'set null');
        $this->addForeign('products', 'sub_category_id', 'sub_categories', 'fk_products_sub_category_id', 'set null');
        $this->addForeign('products', 'sub_sub_category_id', 'sub_sub_categories', 'fk_products_sub_sub_category_id', 'set null');
        $this->addForeign('products', 'brands_id', 'brands', 'fk_products_brands_id', 'set null');

        $this->addForeign('product_images', 'product_id', 'products', 'fk_product_images_product_id', 'cascade');
        $this->addForeign('product_ratings', 'product_id', 'products', 'fk_product_ratings_product_id', 'cascade');

        $this->addForeign('stocks', 'product_id', 'products', 'fk_stocks_product_id', 'cascade');
        $this->addForeign('stocks', 'color_id', 'color', 'fk_stocks_color_id', 'set null');
        $this->addForeign('stocks', 'size_id', 'size', 'fk_stocks_size_id', 'set null');

        $this->addForeign('product_attributes', 'product_id', 'products', 'fk_product_attributes_product_id', 'cascade');
        $this->addForeign('product_attributes', 'color_id', 'color', 'fk_product_attributes_color_id', 'set null');
        $this->addForeign('product_attributes', 'size_id', 'size', 'fk_product_attributes_size_id', 'set null');

        $this->addForeign('color', 'product_id', 'products', 'fk_color_product_id', 'set null');
        $this->addForeign('color', 'size_id', 'size', 'fk_color_size_id', 'set null');
        $this->addForeign('size', 'product_id', 'products', 'fk_size_product_id', 'set null');

        $this->addForeign('cart', 'user_id', 'users', 'fk_cart_user_id', 'cascade');
        $this->addForeign('cart', 'product_id', 'products', 'fk_cart_product_id', 'cascade');
        $this->addForeign('cart', 'color_id', 'color', 'fk_cart_color_id', 'set null');
        $this->addForeign('cart', 'size_id', 'size', 'fk_cart_size_id', 'set null');
        $this->addForeign('cart', 'product_attribute_id', 'product_attributes', 'fk_cart_product_attribute_id', 'set null');

        $this->addForeign('orders', 'user_id', 'users', 'fk_orders_user_id', 'set null');
        $this->addForeign('orders', 'country_id', 'countries', 'fk_orders_country_id', 'set null');

        $this->addForeign('orders_items', 'order_id', 'orders', 'fk_orders_items_order_id', 'cascade');
        $this->addForeign('orders_items', 'product_id', 'products', 'fk_orders_items_product_id', 'set null');
        $this->addForeign('orders_items', 'cart_id', 'cart', 'fk_orders_items_cart_id', 'set null');

        $this->addForeign('customer_addresses', 'user_id', 'users', 'fk_customer_addresses_user_id', 'cascade');
        $this->addForeign('customer_addresses', 'country_id', 'countries', 'fk_customer_addresses_country_id', 'set null');

        $this->addForeign('wishlists', 'user_id', 'users', 'fk_wishlists_user_id', 'cascade');
        $this->addForeign('wishlists', 'product_id', 'products', 'fk_wishlists_product_id', 'cascade');
        $this->addForeign('wishlists', 'color_id', 'color', 'fk_wishlists_color_id', 'set null');
        $this->addForeign('wishlists', 'size_id', 'size', 'fk_wishlists_size_id', 'set null');

        $this->addForeign('shipping_charges', 'country_id', 'countries', 'fk_shipping_charges_country_id', 'cascade');

        $this->addForeign('product_view', 'user_id', 'users', 'fk_product_view_user_id', 'set null');
        $this->addForeign('product_view', 'product_id', 'products', 'fk_product_view_product_id', 'cascade');

        $this->addForeign('messages', 'sender_id', 'users', 'fk_messages_sender_id', 'cascade');
        $this->addForeign('messages', 'receiver_id', 'users', 'fk_messages_receiver_id', 'cascade');

        $this->addForeign('cart_coupon_amounts', 'user_id', 'users', 'fk_cart_coupon_amounts_user_id', 'cascade');
        $this->addForeign('cart_coupon_amounts', 'cart_id', 'cart', 'fk_cart_coupon_amounts_cart_id', 'cascade');
    }

    public function down(): void
    {
        $foreignKeys = [
            ['cart_coupon_amounts', 'fk_cart_coupon_amounts_cart_id'],
            ['cart_coupon_amounts', 'fk_cart_coupon_amounts_user_id'],
            ['messages', 'fk_messages_receiver_id'],
            ['messages', 'fk_messages_sender_id'],
            ['product_view', 'fk_product_view_product_id'],
            ['product_view', 'fk_product_view_user_id'],
            ['shipping_charges', 'fk_shipping_charges_country_id'],
            ['wishlists', 'fk_wishlists_size_id'],
            ['wishlists', 'fk_wishlists_color_id'],
            ['wishlists', 'fk_wishlists_product_id'],
            ['wishlists', 'fk_wishlists_user_id'],
            ['customer_addresses', 'fk_customer_addresses_country_id'],
            ['customer_addresses', 'fk_customer_addresses_user_id'],
            ['orders_items', 'fk_orders_items_cart_id'],
            ['orders_items', 'fk_orders_items_product_id'],
            ['orders_items', 'fk_orders_items_order_id'],
            ['orders', 'fk_orders_country_id'],
            ['orders', 'fk_orders_user_id'],
            ['cart', 'fk_cart_product_attribute_id'],
            ['cart', 'fk_cart_size_id'],
            ['cart', 'fk_cart_color_id'],
            ['cart', 'fk_cart_product_id'],
            ['cart', 'fk_cart_user_id'],
            ['size', 'fk_size_product_id'],
            ['color', 'fk_color_size_id'],
            ['color', 'fk_color_product_id'],
            ['product_attributes', 'fk_product_attributes_size_id'],
            ['product_attributes', 'fk_product_attributes_color_id'],
            ['product_attributes', 'fk_product_attributes_product_id'],
            ['stocks', 'fk_stocks_size_id'],
            ['stocks', 'fk_stocks_color_id'],
            ['stocks', 'fk_stocks_product_id'],
            ['product_ratings', 'fk_product_ratings_product_id'],
            ['product_images', 'fk_product_images_product_id'],
            ['products', 'fk_products_brands_id'],
            ['products', 'fk_products_sub_sub_category_id'],
            ['products', 'fk_products_sub_category_id'],
            ['products', 'fk_products_categories_id'],
            ['sub_sub_categories', 'fk_sub_sub_categories_subcategory_id'],
            ['sub_sub_categories', 'fk_sub_sub_categories_category_id'],
            ['sub_categories', 'fk_sub_categories_category_id'],
        ];

        foreach ($foreignKeys as [$table, $constraint]) {
            $this->dropForeignIfExists($table, $constraint);
        }
    }

    private function dropExistingForeignKeysBeforeColumnChanges(): void
    {
        $columns = [
            ['sub_categories', 'category_id'],
            ['sub_sub_categories', 'category_id'],
            ['sub_sub_categories', 'subcategory_id'],
            ['products', 'categories_id'],
            ['products', 'sub_category_id'],
            ['products', 'sub_sub_category_id'],
            ['products', 'brands_id'],
            ['product_images', 'product_id'],
            ['product_ratings', 'product_id'],
            ['stocks', 'product_id'],
            ['stocks', 'color_id'],
            ['stocks', 'size_id'],
            ['product_attributes', 'product_id'],
            ['product_attributes', 'color_id'],
            ['product_attributes', 'size_id'],
            ['color', 'product_id'],
            ['color', 'size_id'],
            ['size', 'product_id'],
            ['cart', 'user_id'],
            ['cart', 'product_id'],
            ['cart', 'color_id'],
            ['cart', 'size_id'],
            ['cart', 'product_attribute_id'],
            ['orders', 'user_id'],
            ['orders', 'country_id'],
            ['orders_items', 'order_id'],
            ['orders_items', 'product_id'],
            ['orders_items', 'cart_id'],
            ['customer_addresses', 'user_id'],
            ['customer_addresses', 'country_id'],
            ['wishlists', 'user_id'],
            ['wishlists', 'product_id'],
            ['wishlists', 'color_id'],
            ['wishlists', 'size_id'],
            ['shipping_charges', 'country_id'],
            ['product_view', 'user_id'],
            ['product_view', 'product_id'],
            ['messages', 'sender_id'],
            ['messages', 'receiver_id'],
            ['cart_coupon_amounts', 'user_id'],
            ['cart_coupon_amounts', 'cart_id'],
        ];

        foreach ($columns as [$table, $column]) {
            $this->dropForeignKeysOnColumn($table, $column);
        }
    }

    private function dropForeignKeysOnColumn(string $table, string $column): void
    {
        if (!$this->hasColumn($table, $column)) {
            return;
        }

        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = ?
              AND COLUMN_NAME = ?
              AND REFERENCED_TABLE_NAME IS NOT NULL
        ", [$table, $column]);

        foreach ($foreignKeys as $foreignKey) {
            $constraintName = $foreignKey->CONSTRAINT_NAME;
            DB::statement("ALTER TABLE `{$table}` DROP FOREIGN KEY `{$constraintName}`");
        }
    }

    private function prepareStringForeignId(string $table, string $column): void
    {
        if (!$this->hasColumn($table, $column)) {
            return;
        }

        DB::statement("ALTER TABLE `{$table}` MODIFY `{$column}` VARCHAR(255) NULL");
        DB::statement("UPDATE `{$table}` SET `{$column}` = NULL WHERE `{$column}` = ''");
        DB::statement("UPDATE `{$table}` SET `{$column}` = NULL WHERE `{$column}` IS NOT NULL AND `{$column}` NOT REGEXP '^[0-9]+$'");
        DB::statement("UPDATE `{$table}` SET `{$column}` = NULL WHERE `{$column}` = '0'");
        DB::statement("ALTER TABLE `{$table}` MODIFY `{$column}` BIGINT UNSIGNED NULL");
    }

    private function prepareIntegerForeignId(string $table, string $column): void
    {
        if (!$this->hasColumn($table, $column)) {
            return;
        }

        DB::statement("ALTER TABLE `{$table}` MODIFY `{$column}` BIGINT UNSIGNED NULL");
        DB::statement("UPDATE `{$table}` SET `{$column}` = NULL WHERE `{$column}` = 0");
    }

    private function nullOrphans(string $table, string $column, string $referenceTable, string $referenceColumn = 'id'): void
    {
        if (!$this->hasColumn($table, $column) || !Schema::hasTable($referenceTable)) {
            return;
        }

        DB::statement("\n            UPDATE `{$table}` AS child\n            LEFT JOIN `{$referenceTable}` AS parent ON child.`{$column}` = parent.`{$referenceColumn}`\n            SET child.`{$column}` = NULL\n            WHERE child.`{$column}` IS NOT NULL AND parent.`{$referenceColumn}` IS NULL\n        ");
    }

    private function deleteOrphans(string $table, string $column, string $referenceTable, string $referenceColumn = 'id'): void
    {
        if (!$this->hasColumn($table, $column) || !Schema::hasTable($referenceTable)) {
            return;
        }

        DB::statement("\n            DELETE child FROM `{$table}` AS child\n            LEFT JOIN `{$referenceTable}` AS parent ON child.`{$column}` = parent.`{$referenceColumn}`\n            WHERE child.`{$column}` IS NOT NULL AND parent.`{$referenceColumn}` IS NULL\n        ");
    }

    private function addForeign(
        string $table,
        string $column,
        string $referenceTable,
        string $constraintName,
        string $onDelete = 'set null',
        string $referenceColumn = 'id'
    ): void {
        if (!$this->hasColumn($table, $column) || !Schema::hasTable($referenceTable)) {
            return;
        }

        if ($this->foreignKeyExists($table, $constraintName) || $this->foreignKeyExistsOnColumn($table, $column)) {
            return;
        }

        Schema::table($table, function (Blueprint $schemaTable) use ($column, $referenceTable, $referenceColumn, $constraintName, $onDelete) {
            $foreign = $schemaTable->foreign($column, $constraintName)
                ->references($referenceColumn)
                ->on($referenceTable);

            if ($onDelete === 'cascade') {
                $foreign->cascadeOnDelete();
            } else {
                $foreign->nullOnDelete();
            }
        });
    }

    private function dropForeignIfExists(string $table, string $constraintName): void
    {
        if (!Schema::hasTable($table) || !$this->foreignKeyExists($table, $constraintName)) {
            return;
        }

        DB::statement("ALTER TABLE `{$table}` DROP FOREIGN KEY `{$constraintName}`");
    }

    private function foreignKeyExists(string $table, string $constraintName): bool
    {
        if (!Schema::hasTable($table)) {
            return false;
        }

        $result = DB::selectOne("\n            SELECT CONSTRAINT_NAME\n            FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS\n            WHERE CONSTRAINT_SCHEMA = DATABASE()\n              AND TABLE_NAME = ?\n              AND CONSTRAINT_NAME = ?\n              AND CONSTRAINT_TYPE = 'FOREIGN KEY'\n        ", [$table, $constraintName]);

        return $result !== null;
    }

    private function foreignKeyExistsOnColumn(string $table, string $column): bool
    {
        if (!$this->hasColumn($table, $column)) {
            return false;
        }

        $result = DB::selectOne("
            SELECT CONSTRAINT_NAME
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = ?
              AND COLUMN_NAME = ?
              AND REFERENCED_TABLE_NAME IS NOT NULL
        ", [$table, $column]);

        return $result !== null;
    }

    private function hasColumn(string $table, string $column): bool
    {
        return Schema::hasTable($table) && Schema::hasColumn($table, $column);
    }
};
