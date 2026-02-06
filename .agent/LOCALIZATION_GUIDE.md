# Localization Implementation Guide

## Overview
This project now has a complete localization system supporting English (EN) and Dutch (NL) languages.

## Files Created/Modified

### 1. Translation Files
- **`lang/en/messages.php`** - English translations
- **`lang/nl/messages.php`** - Dutch (Nederlands) translations

### 2. Helper Functions (`app/Http/Helper/helper.php`)
Added three helper functions for easy translation access:

```php
// Get translated message
trans_message('key', $replace = [], $locale = null)

// Get current locale
get_current_locale()

// Check if current locale matches
is_locale('en')
```

### 3. Middleware
- **`app/Http/Middleware/SetLocale.php`** - Already exists, sets locale from session
- Registered in `bootstrap/app.php` as web middleware

### 4. Routes
- **`routes/admin.php`** - Language switch route already exists:
  ```php
  Route::get('/lang/{locale}', function ($locale) {
      if (in_array($locale, ['en', 'nl'])) {
          session(['locale' => $locale]);
      }
      return back();
  })->name('lang.switch');
  ```

## Usage Examples

### In Blade Templates

```blade
{{-- Simple translation --}}
<h1>{{ trans_message('settings') }}</h1>

{{-- Translation with parameters --}}
<p>{{ trans_message('welcome_message', ['name' => $user->name]) }}</p>

{{-- Check current locale --}}
@if(get_current_locale() === 'en')
    <p>English content</p>
@endif

{{-- Or use is_locale helper --}}
@if(is_locale('nl'))
    <p>Nederlandse inhoud</p>
@endif
```

### Language Switcher UI

```blade
<div class="flex gap-2">
    <a href="{{ route('admin.lang.switch', 'en') }}" 
       class="px-4 py-2.5 rounded-lg border {{ get_current_locale() === 'en' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700' }}">
        🇬🇧 {{ trans_message('english') }}
    </a>
    <a href="{{ route('admin.lang.switch', 'nl') }}" 
       class="px-4 py-2.5 rounded-lg border {{ get_current_locale() === 'nl' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700' }}">
        🇳🇱 {{ trans_message('dutch') }}
    </a>
</div>
```

### In Controllers

```php
// Get translation in controller
$message = trans_message('account_updated');

// Or use Laravel's built-in function
$message = __('messages.account_updated');

// With parameters
$message = trans_message('welcome_user', ['name' => $user->name]);
```

### In JavaScript/Blade Scripts

```blade
<script>
    // Pass translations to JavaScript
    const messages = {
        save: "{{ trans_message('save') }}",
        cancel: "{{ trans_message('cancel') }}",
        confirm: "{{ trans_message('confirm') }}"
    };
    
    // Use in validation
    $("#form").validate({
        messages: {
            name: {required: "{{ trans_message('name_required') }}"},
            email: {required: "{{ trans_message('email_required') }}"}
        }
    });
</script>
```

## Available Translation Keys

### Common UI
- `welcome`, `hello`, `save`, `cancel`, `delete`, `edit`, `add`
- `search`, `filter`, `export`, `import`, `upload`, `download`
- `submit`, `close`, `confirm`, `yes`, `no`, `ok`
- `back`, `next`, `previous`, `loading`, `processing`
- `success`, `error`, `warning`, `info`

### Settings Page
- `settings`, `account_settings`, `language`
- `english`, `dutch`, `profile_image`
- `click_to_upload`, `email`, `display_name`
- `change_password`, `new_password`, `confirm_password`
- `save_changes`, `modify`
- `edit_faq`, `edit_guides`
- `email_attachment`, `successful_visitor_registration`
- `upload_file`, `visitor_announcement`, `enter_announcement`

### Validation Messages
- `field_required`, `name_required`, `password_required`
- `password_confirmation_required`, `password_mismatch`
- `announcement_required`

### Success Messages
- `account_updated`, `announcement_updated`
- `email_attachment_updated`, `file_removed`
- `faq_updated`, `guides_updated`

### Error Messages
- `unable_to_update_account`, `unable_to_update_announcement`
- `unable_to_update_email_attachment`, `unable_to_update_faq`
- `unable_to_update_guides`

### Confirmation Messages
- `are_you_sure`, `confirm_remove_file`
- `yes_remove`, `no_cancel`

## Adding New Translations

1. **Add to English file** (`lang/en/messages.php`):
   ```php
   'new_key' => 'English Text',
   ```

2. **Add to Dutch file** (`lang/nl/messages.php`):
   ```php
   'new_key' => 'Nederlandse Tekst',
   ```

3. **Use in templates**:
   ```blade
   {{ trans_message('new_key') }}
   ```

## How It Works

1. **User clicks language link** → Route: `admin.lang.switch`
2. **Locale stored in session** → `session(['locale' => 'nl'])`
3. **Middleware reads session** → `SetLocale` middleware
4. **Laravel sets app locale** → `app()->setLocale($locale)`
5. **Translations loaded** → From `lang/{locale}/messages.php`
6. **Helper functions available** → `trans_message()`, `get_current_locale()`, etc.

## Configuration

### Default Locale
Set in `config/app.php`:
```php
'locale' => env('APP_LOCALE', 'en'),
'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
```

### Environment Variables
Add to `.env`:
```
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
```

## Best Practices

1. **Always use translation keys** - Never hardcode text
2. **Use descriptive keys** - `account_settings` not `as1`
3. **Group related translations** - Keep similar items together
4. **Provide fallbacks** - Always have English as fallback
5. **Test both languages** - Switch between EN and NL to verify
6. **Keep translations in sync** - Same keys in both files

## Troubleshooting

### Translations not showing?
1. Check if locale is set: `{{ get_current_locale() }}`
2. Verify translation key exists in both language files
3. Clear cache: `php artisan cache:clear`
4. Check middleware is registered

### Language not switching?
1. Verify route exists: `route('admin.lang.switch', 'nl')`
2. Check session is working
3. Verify middleware is in web group
4. Check browser cookies/session

## Future Enhancements

1. **Add more languages** - Create `lang/de/messages.php` for German, etc.
2. **Database translations** - Store translations in database for dynamic content
3. **Translation management UI** - Admin panel to manage translations
4. **Auto-translation** - Integrate with translation APIs
5. **RTL support** - Add right-to-left language support
6. **Pluralization** - Handle singular/plural forms
7. **Date/Time localization** - Format dates per locale

## Example: Complete Settings Page Implementation

See `resources/views/admin/settings/index.blade.php` for a complete example of:
- Language switcher with active state
- All labels and buttons translated
- JavaScript validation messages translated
- Dynamic content based on locale
