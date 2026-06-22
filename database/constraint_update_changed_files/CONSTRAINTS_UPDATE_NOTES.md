# Database Constraint Update Notes

I checked the Laravel migrations and found that many relationship columns were created with `foreignId()` or integer/string IDs, but without real foreign key constraints.

## Main issues found

1. Missing foreign key constraints on important e-commerce tables:
   - `products`
   - `product_images`
   - `orders`
   - `orders_items`
   - `customer_addresses`
   - `wishlists`
   - `cart`
   - `messages`
   - `product_view`
   - `product_attributes`
   - `stocks`
   - `shipping_charges`

2. Some old relationship columns were created with the wrong type:
   - `shipping_charges.country_id` was a string.
   - `orders_items.order_id`, `orders_items.product_id`, and `orders_items.cart_id` were normal integers.
   - `stocks.color_id` and `stocks.size_id` were normal integers with default `0`.
   - `color.product_id`, `color.size_id`, and `size.product_id` were strings.

3. Existing old data can contain orphan records. The new migration cleans orphans before adding constraints.

## New migration added

```text
database/migrations/2026_06_22_000001_add_foreign_key_constraints_to_ecommerce_tables.php
```

This migration:

- Converts legacy ID columns to `BIGINT UNSIGNED NULL` where required.
- Changes invalid `0`, empty, and non-numeric references to `NULL` where safe.
- Deletes orphan rows where the child table should not exist without its parent, such as cart records without users/products.
- Adds named foreign key constraints with safe `cascadeOnDelete()` or `nullOnDelete()` behavior.

## How to run

First backup your database.

Then run:

```powershell
cd C:\xampp\htdocs\ProjectEcom\Laravel_Shop
php artisan optimize:clear
php artisan migrate
```

If you want to inspect the migration first, open:

```text
database/migrations/2026_06_22_000001_add_foreign_key_constraints_to_ecommerce_tables.php
```

## Important warning

This migration cleans old invalid data before adding constraints. For example:

- Invalid cart rows without a real user/product may be deleted.
- Invalid optional references may be set to `NULL`.

This is necessary because MySQL will not allow foreign keys if orphaned records already exist.
