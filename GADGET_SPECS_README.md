# TechStore - Gadget Specifications Setup Guide

## What Has Been Updated

### 1. **Product Information → Gadget Specifications**
   - Removed: Category, Rating, Reviews, Product ID
   - Added: Battery Life, Warranty, Storage, RAM, Processor, Weight, Operating System

### 2. **Database Changes**
The following new columns have been added to the `products` table:
- `battery_life` - Battery timing (e.g., "40 hrs", "5 days")
- `warranty_years` - Warranty period in years
- `storage` - Storage capacity (e.g., "256GB SSD")
- `ram` - RAM memory (e.g., "16GB")
- `processor` - Processor/Chip info (e.g., "Intel Core i7")
- `weight` - Weight (e.g., "1.2kg")
- `os` - Operating System (e.g., "Windows 11")

### 3. **Files Updated**
- `product.php` - Product detail page now displays gadget specs instead of basic info
- `config/database.php` - Auto-creates missing columns on first connection

## Setup Instructions

### Step 1: Run Database Migration
Open your browser and visit:
```
http://localhost/techstore/add_specs.php
```

This will:
- Add the gadget specification columns to your database (if not already present)
- Populate sample data for all existing products

### Step 2: Verify the Changes
1. Go to: http://localhost/techstore/products.php
2. Click on any product (e.g., "Smart Watch Pro")
3. The "Product Information" section will now show "Gadget Specifications" with battery life, warranty, storage, etc.

## Sample Gadget Specifications Included

Products updated with specifications:

1. **Premium Wireless Headphones**
   - Battery Life: 40 hrs
   - Warranty: 2 years
   - Weight: 250g

2. **True Wireless Earbuds**
   - Battery Life: 7 hrs (single), 35 hrs total
   - Warranty: 1 year

3. **Smart Watch Pro**
   - Battery Life: 5 days
   - Storage: 8GB
   - Warranty: 2 years

4. **UltraBook Laptop**
   - Battery Life: 14 hrs
   - Storage: 512GB SSD
   - RAM: 16GB
   - Processor: Intel Core i7 (13th Gen)
   - Weight: 1.2kg
   - OS: Windows 11

5. **Flagship Smartphone**
   - Battery Life: 24 hrs
   - Storage: 256GB
   - RAM: 12GB
   - Processor: Qualcomm Snapdragon 8 Gen 2

And more...

## How to Customize Specifications

### Option 1: Use phpMyAdmin
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Select `techstore` database
3. Edit `products` table
4. Update any product's specifications

### Option 2: Edit Your Store
You can create an admin panel to manage specs, or manually update via SQL:
```sql
UPDATE products SET 
    battery_life = '30 hrs',
    warranty_years = 2,
    storage = '256GB',
    processor = 'Your Processor'
WHERE id = 3;
```

### For Products Without Specific Features
If a gadget doesn't have a feature (e.g., a Keyboard has no battery shown if wired), just leave it empty - these fields will automatically hide.

## Notes

- The specs are displayed only if they contain data (empty fields won't show)
- You can add more spec fields anytime by modifying the database
- The interface automatically adapts based on available data
- All fields are optional

