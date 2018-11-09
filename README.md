# Output ExpressionEngine table data in JSON format

Provide a table name to dump every row:

```
{exp:json_table table="seolite_content"}
```

If there is an `entry_id` column, the table may be filtered to a single row:

```
{exp:json_table table="seolite_content" entry_id="99"}
```