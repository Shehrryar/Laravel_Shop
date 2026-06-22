# Constraint migration fix

This updated migration fixes MySQL error 1832:

`Cannot change column 'country_id': used in a foreign key constraint 'fk_shipping_charges_country'`

The migration now drops existing legacy foreign keys on affected columns before modifying column types, then adds the final named constraints again.
