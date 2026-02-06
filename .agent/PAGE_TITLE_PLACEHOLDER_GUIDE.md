# Complete Localization Guide - Page Titles & Placeholders

## ✅ Translation Keys Added

### English & Dutch translation files updated with:
- Branches: `branches`, `branch`, `add_branch`, `edit_branch`, `company_branch_profile`
- Form Fields: `name`, `address_line_1`, `locality`, `postal_code`, `first_name`, `last_name`, `phone`
- Contact: `contact_person`, `new_contact_person`, `edit_contact_person`, `add_more`
- Filters: `show`, `sort_by`, `name_a_z`, `name_z_a`

## 📝 How to Translate Page Titles

### Current Format (Example from branch/index.blade.php):
```blade
@section('title',$company->company_name.' Branches')
```

### Updated Format with Translation:
```blade
@section('title', $company->company_name.' '.trans_message('branches'))
```

## 🎯 Page Title Translation Pattern

For all pages, update the `@section('title')` as follows:

### Pattern 1: Simple Title
```blade
{{-- Before --}}
@section('title', 'Dashboard')

{{-- After --}}
@section('title', trans_message('dashboard'))
```

### Pattern 2: Title with Variable
```blade
{{-- Before --}}
@section('title', $company->company_name.' Branches')

{{-- After --}}
@section('title', $company->company_name.' '.trans_message('branches'))
```

### Pattern 3: Title with Multiple Parts
```blade
{{-- Before --}}
@section('title', 'Company - '.$company->name.' - Branches')

{{-- After --}}
@section('title', trans_message('company').' - '.$company->name.' - '.trans_message('branches'))
```

## 🔤 Placeholder Translation Pattern

### Pattern 1: Simple Placeholder
```blade
{{-- Before --}}
<input type="text" placeholder="Name">

{{-- After --}}
<input type="text" placeholder="{{ trans_message('name') }}">
```

### Pattern 2: Placeholder Already Exists
```blade
{{-- If placeholder exists, update it --}}
<input type="text" placeholder="Email">
{{-- becomes --}}
<input type="text" placeholder="{{ trans_message('email') }}">

{{-- If no placeholder, skip (as requested) --}}
<input type="text">
{{-- stays as is --}}
```

## 📋 Complete Translation List for branch/index.blade.php

### Line 2: Page Title
```blade
{{-- Before --}}
@section('title',$company->company_name.' Branches')

{{-- After --}}
@section('title', $company->company_name.' '.trans_message('branches'))
```

### Line 7: Breadcrumb
```blade
{{-- Before --}}
<span>Companies</span>

{{-- After --}}
<span>{{ trans_message('companies') }}</span>
```

### Line 13: Mobile Header
```blade
{{-- Before --}}
<span class="text-2xl font-semibold text-gray-800 short_desc_1">{{ $company->company_name }} Branches</span>

{{-- After --}}
<span class="text-2xl font-semibold text-gray-800 short_desc_1">{{ $company->company_name }} {{ trans_message('branches') }}</span>
```

### Line 17: Add Branch Button
```blade
{{-- Before --}}
<span>Add Branch</span>

{{-- After --}}
<span>{{ trans_message('add_branch') }}</span>
```

### Line 39: Modal Title
```blade
{{-- Before --}}
<h3>Company Branch Profile</h3>

{{-- After --}}
<h3>{{ trans_message('company_branch_profile') }}</h3>
```

### Line 79: Label
```blade
{{-- Before --}}
<label>Name</label>

{{-- After --}}
<label>{{ trans_message('name') }}</label>
```

### Line 82: Placeholder
```blade
{{-- Before --}}
placeholder="Name"

{{-- After --}}
placeholder="{{ trans_message('name') }}"
```

### Line 89: Address Label
```blade
{{-- Before --}}
<label>Address Line 1</label>

{{-- After --}}
<label>{{ trans_message('address_line_1') }}</label>
```

### Line 94: Address Placeholder
```blade
{{-- Before --}}
placeholder="Address Line 1"

{{-- After --}}
placeholder="{{ trans_message('address_line_1') }}"
```

### Line 98: Locality Label
```blade
{{-- Before --}}
<label>Locality</label>

{{-- After --}}
<label>{{ trans_message('locality') }}</label>
```

### Line 101: Locality Placeholder
```blade
{{-- Before --}}
placeholder="Locality"

{{-- After --}}
placeholder="{{ trans_message('locality') }}"
```

### Line 105: Postal Code Label
```blade
{{-- Before --}}
<label>Postal Code</label>

{{-- After --}}
<label>{{ trans_message('postal_code') }}</label>
```

### Line 108: Postal Code Placeholder
```blade
{{-- Before --}}
placeholder="Postal Code"

{{-- After --}}
placeholder="{{ trans_message('postal_code') }}"
```

### Line 116: Upselling Input Label
```blade
{{-- Before --}}
<label>Upselling Input</label>

{{-- After --}}
<label>{{ trans_message('upselling_input') }}</label>
```

### Line 119: Upselling Input Placeholder
```blade
{{-- Before --}}
placeholder="Upselling Input"

{{-- After --}}
placeholder="{{ trans_message('upselling_input') }}"
```

### Line 123: Upselling Report Label
```blade
{{-- Before --}}
<label>Upselling Report</label>

{{-- After --}}
<label>{{ trans_message('upselling_report') }}</label>
```

### Line 126: Upselling Report Placeholder
```blade
{{-- Before --}}
placeholder="Upselling Report"

{{-- After --}}
placeholder="{{ trans_message('upselling_report') }}"
```

### Line 148: Route Label
```blade
{{-- Before --}}
<label>Route</label>

{{-- After --}}
<label>{{ trans_message('route') }}</label>
```

### Line 170, 342, 398, 480, 562: Cancel Button
```blade
{{-- Before --}}
Cancel

{{-- After --}}
{{ trans_message('cancel') }}
```

### Line 174, 346, 402, 484, 567: Save Button
```blade
{{-- Before --}}
Save

{{-- After --}}
{{ trans_message('save') }}
```

### Line 200: Edit Modal Title
```blade
{{-- Before --}}
<h3>Edit Company Branch Profile</h3>

{{-- After --}}
<h3>{{ trans_message('edit_company_branch_profile') }}</h3>
```

### Line 222: Active Label
```blade
{{-- Before --}}
<label>Active</label>

{{-- After --}}
<label>{{ trans_message('active') }}</label>
```

### Line 372: Contact Person Title
```blade
{{-- Before --}}
<h3>Contact Person</h3>

{{-- After --}}
<h3>{{ trans_message('contact_person') }}</h3>
```

### Line 391: Add More Button
```blade
{{-- Before --}}
Add More

{{-- After --}}
{{ trans_message('add_more') }}
```

### Line 428: New Contact Person Title
```blade
{{-- Before --}}
<h3>New Contact Person</h3>

{{-- After --}}
<h3>{{ trans_message('new_contact_person') }}</h3>
```

### Line 443: First Name Label
```blade
{{-- Before --}}
<label>First Name<span class="text-[red]">*</span></label>

{{-- After --}}
<label>{{ trans_message('first_name') }}<span class="text-[red]">*</span></label>
```

### Line 446: First Name Placeholder
```blade
{{-- Before --}}
placeholder="First Name"

{{-- After --}}
placeholder="{{ trans_message('first_name') }}"
```

### Line 451: Last Name Label
```blade
{{-- Before --}}
<label>Last Name<span class="text-[red]">*</span></label>

{{-- After --}}
<label>{{ trans_message('last_name') }}<span class="text-[red]">*</span></label>
```

### Line 454: Last Name Placeholder
```blade
{{-- Before --}}
placeholder="Last Name"

{{-- After --}}
placeholder="{{ trans_message('last_name') }}"
```

### Line 460: Email Label
```blade
{{-- Before --}}
<label>Email<span class="text-[red]">*</span></label>

{{-- After --}}
<label>{{ trans_message('email') }}<span class="text-[red]">*</span></label>
```

### Line 463: Email Placeholder
```blade
{{-- Before --}}
placeholder="Email"

{{-- After --}}
placeholder="{{ trans_message('email') }}"
```

### Line 469: Phone Label
```blade
{{-- Before --}}
<label>Phone<span class="text-[red]">*</span></label>

{{-- After --}}
<label>{{ trans_message('phone') }}<span class="text-[red]">*</span></label>
```

### Line 472: Phone Placeholder
```blade
{{-- Before --}}
placeholder="Phone"

{{-- After --}}
placeholder="{{ trans_message('phone') }}"
```

### Line 510: Edit Contact Person Title
```blade
{{-- Before --}}
<h3>Edit Contact Person</h3>

{{-- After --}}
<h3>{{ trans_message('edit_contact_person') }}</h3>
```

### Line 587: Show Filter
```blade
{{-- Before --}}
<option value="">Show</option>

{{-- After --}}
<option value="">{{ trans_message('show') }}</option>
```

### Line 588: Active Option
```blade
{{-- Before --}}
<option value="ACTIVE">Active</option>

{{-- After --}}
<option value="ACTIVE">{{ trans_message('active') }}</option>
```

### Line 589: Inactive Option
```blade
{{-- Before --}}
<option value="INACTIVE">Inactive</option>

{{-- After --}}
<option value="INACTIVE">{{ trans_message('inactive') }}</option>
```

### Line 599: Sort By Filter
```blade
{{-- Before --}}
<option value="">Sort by</option>

{{-- After --}}
<option value="">{{ trans_message('sort_by') }}</option>
```

### Line 600-601: Sort Options
```blade
{{-- Before --}}
<option value="name_asc">Name (A-Z)</option>
<option value="name_desc">Name (Z-A)</option>

{{-- After --}}
<option value="name_asc">{{ trans_message('name_a_z') }}</option>
<option value="name_desc">{{ trans_message('name_z_a') }}</option>
```

### Line 612: Add Branch Button (Desktop)
```blade
{{-- Before --}}
<span>Add Branch</span>

{{-- After --}}
<span>{{ trans_message('add_branch') }}</span>
```

## 🔍 Quick Find & Replace Commands

Use these in your IDE for `resources/views/admin/branch/index.blade.php`:

```
Find: @section('title',$company->company_name.' Branches')
Replace: @section('title', $company->company_name.' '.trans_message('branches'))

Find: <span>Companies</span>
Replace: <span>{{ trans_message('companies') }}</span>

Find: <span>Add Branch</span>
Replace: <span>{{ trans_message('add_branch') }}</span>

Find: >Company Branch Profile<
Replace: >{{ trans_message('company_branch_profile') }}<

Find: >Edit Company Branch Profile<
Replace: >{{ trans_message('edit_company_branch_profile') }}<

Find: >Name<
Replace: >{{ trans_message('name') }}<

Find: placeholder="Name"
Replace: placeholder="{{ trans_message('name') }}"

Find: >Address Line 1<
Replace: >{{ trans_message('address_line_1') }}<

Find: placeholder="Address Line 1"
Replace: placeholder="{{ trans_message('address_line_1') }}"

Find: >Locality<
Replace: >{{ trans_message('locality') }}<

Find: placeholder="Locality"
Replace: placeholder="{{ trans_message('locality') }}"

Find: >Postal Code<
Replace: >{{ trans_message('postal_code') }}<

Find: placeholder="Postal Code"
Replace: placeholder="{{ trans_message('postal_code') }}"

Find: >Upselling Input<
Replace: >{{ trans_message('upselling_input') }}<

Find: placeholder="Upselling Input"
Replace: placeholder="{{ trans_message('upselling_input') }}"

Find: >Upselling Report<
Replace: >{{ trans_message('upselling_report') }}<

Find: placeholder="Upselling Report"
Replace: placeholder="{{ trans_message('upselling_report') }}"

Find: >Route<
Replace: >{{ trans_message('route') }}<

Find: >Active<
Replace: >{{ trans_message('active') }}<

Find: >Cancel
Replace: >{{ trans_message('cancel') }}

Find: >Save
Replace: >{{ trans_message('save') }}

Find: >Contact Person<
Replace: >{{ trans_message('contact_person') }}<

Find: >New Contact Person<
Replace: >{{ trans_message('new_contact_person') }}<

Find: >Edit Contact Person<
Replace: >{{ trans_message('edit_contact_person') }}<

Find: >First Name<
Replace: >{{ trans_message('first_name') }}<

Find: placeholder="First Name"
Replace: placeholder="{{ trans_message('first_name') }}"

Find: >Last Name<
Replace: >{{ trans_message('last_name') }}<

Find: placeholder="Last Name"
Replace: placeholder="{{ trans_message('last_name') }}"

Find: >Email<
Replace: >{{ trans_message('email') }}<

Find: placeholder="Email"
Replace: placeholder="{{ trans_message('email') }}"

Find: >Phone<
Replace: >{{ trans_message('phone') }}<

Find: placeholder="Phone"
Replace: placeholder="{{ trans_message('phone') }}"

Find: >Add More
Replace: >{{ trans_message('add_more') }}

Find: >Show<
Replace: >{{ trans_message('show') }}<

Find: >Sort by<
Replace: >{{ trans_message('sort_by') }}<

Find: >Name (A-Z)<
Replace: >{{ trans_message('name_a_z') }}<

Find: >Name (Z-A)<
Replace: >{{ trans_message('name_z_a') }}<

Find: >Inactive<
Replace: >{{ trans_message('inactive') }}<
```

## 📚 Apply Same Pattern to All Pages

For every `.blade.php` file:

1. **Update Page Title**:
   ```blade
   @section('title', trans_message('key'))
   ```

2. **Update Labels**:
   ```blade
   <label>{{ trans_message('key') }}</label>
   ```

3. **Update Placeholders** (only if they exist):
   ```blade
   placeholder="{{ trans_message('key') }}"
   ```

4. **Update Buttons**:
   ```blade
   <button>{{ trans_message('key') }}</button>
   ```

5. **Update Headings**:
   ```blade
   <h1>{{ trans_message('key') }}</h1>
   ```

## ✅ Implementation Checklist

- [ ] Update page title `@section('title')`
- [ ] Update all labels `<label>`
- [ ] Update all placeholders (if they exist)
- [ ] Update all buttons
- [ ] Update all headings
- [ ] Update breadcrumbs
- [ ] Update modal titles
- [ ] Update dropdown options
- [ ] Test in English
- [ ] Test in Dutch

## 🎉 Result

After applying these changes:
- ✅ Page titles translate based on selected language
- ✅ All placeholders translate automatically
- ✅ Forms work in both languages
- ✅ Consistent user experience

## 💡 Tips

1. **Use Find & Replace** - Much faster than manual editing
2. **Test frequently** - Switch languages after each page
3. **Keep keys consistent** - Use same key for same text
4. **Skip empty placeholders** - As requested, only translate existing ones
