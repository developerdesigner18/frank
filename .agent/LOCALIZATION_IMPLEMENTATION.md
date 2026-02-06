# Simple Session-Based Localization Implementation

## ✅ What Has Been Implemented

### 1. **Session-Based Language Switching**
- No URL changes
- Language stored in session
- Persists across page navigation
- Default language: English

### 2. **Files Created/Updated**

#### Middleware
- **`app/Http/Middleware/SetLocale.php`** - Reads locale from session

#### Translation Files
- **`lang/en/messages.php`** - English translations (100+ keys)
- **`lang/nl/messages.php`** - Dutch translations (100+ keys)

#### Routes
- **`routes/admin.php`** - Language switch route already exists:
  ```php
  Route::get('/lang/{locale}', function ($locale) {
      if (in_array($locale, ['en', 'nl'])) {
          session(['locale' => $locale]);
      }
      return back();
  })->name('lang.switch');
  ```

#### Helper Functions (Already in `app/Http/Helper/helper.php`)
```php
// Get translated message
trans_message('dashboard')

// Get current locale
get_current_locale() // Returns 'en' or 'nl'

// Check if specific locale
is_locale('en') // Returns true/false
```

## 🚀 How It Works

### Language Switching Flow
1. User clicks on 🇬🇧 English or 🇳🇱 Nederlands button
2. Route `/lang/en` or `/lang/nl` is called
3. Locale is saved to session
4. User is redirected back to current page
5. Middleware reads session and sets app locale
6. All translations update automatically
7. **URL stays the same** ✅

### Example in Settings Page
```blade
<a href="{{ route('admin.lang.switch', 'en') }}" 
   class="{{ get_current_locale() === 'en' ? 'active' : '' }}">
    🇬🇧 {{ trans_message('english') }}
</a>

<a href="{{ route('admin.lang.switch', 'nl') }}" 
   class="{{ get_current_locale() === 'nl' ? 'active' : '' }}">
    🇳🇱 {{ trans_message('dutch') }}
</a>
```

## 📝 How to Use in Templates

### Basic Translation
```blade
{{-- Simple text --}}
<h1>{{ trans_message('dashboard') }}</h1>
<button>{{ trans_message('save') }}</button>
<label>{{ trans_message('email') }}</label>

{{-- Page title --}}
@section('title', trans_message('settings'))

{{-- Headings --}}
<h2>{{ trans_message('account_settings') }}</h2>
```

### Forms
```blade
<form>
    <div>
        <label>{{ trans_message('email') }}</label>
        <input type="email" placeholder="{{ trans_message('email') }}">
    </div>
    
    <div>
        <label>{{ trans_message('password') }}</label>
        <input type="password" placeholder="{{ trans_message('new_password') }}">
    </div>
    
    <button type="submit">{{ trans_message('save_changes') }}</button>
    <button type="button">{{ trans_message('cancel') }}</button>
</form>
```

### Navigation/Sidebar
```blade
<nav>
    <a href="{{ route('admin.dashboard') }}">
        {{ trans_message('dashboard') }}
    </a>
    <a href="{{ route('admin.settings') }}">
        {{ trans_message('settings') }}
    </a>
    <a href="#">
        {{ trans_message('logout') }}
    </a>
</nav>
```

### JavaScript Validation Messages
```javascript
$("#form").validate({
    messages: {
        name: {
            required: "{{ trans_message('name_required') }}"
        },
        email: {
            required: "{{ trans_message('field_required') }}"
        },
        password: {
            required: "{{ trans_message('password_required') }}"
        },
        password_confirmation: {
            required: "{{ trans_message('password_confirmation_required') }}",
            equalTo: "{{ trans_message('password_mismatch') }}"
        }
    }
});
```

### Conditional Content
```blade
@if(is_locale('en'))
    <p>English specific content</p>
@else
    <p>Dutch specific content</p>
@endif

{{-- Or --}}
<div class="{{ is_locale('nl') ? 'dutch-style' : 'english-style' }}">
    Content
</div>
```

## 📋 Available Translation Keys

### Common UI
`welcome`, `hello`, `save`, `cancel`, `delete`, `edit`, `add`, `search`, `filter`, `export`, `import`, `upload`, `download`, `submit`, `close`, `confirm`, `yes`, `no`, `ok`, `back`, `next`, `previous`, `loading`, `processing`, `success`, `error`, `warning`, `info`

### Settings Page
`settings`, `account_settings`, `language`, `english`, `dutch`, `profile_image`, `click_to_upload`, `email`, `display_name`, `change_password`, `new_password`, `confirm_password`, `save_changes`, `modify`, `edit_faq`, `edit_guides`, `email_attachment`, `successful_visitor_registration`, `upload_file`, `visitor_announcement`, `enter_announcement`

### Validation
`field_required`, `name_required`, `password_required`, `password_confirmation_required`, `password_mismatch`, `announcement_required`

### Success Messages
`account_updated`, `announcement_updated`, `email_attachment_updated`, `file_removed`, `faq_updated`, `guides_updated`

### Error Messages
`unable_to_update_account`, `unable_to_update_announcement`, `unable_to_update_email_attachment`, `unable_to_update_faq`, `unable_to_update_guides`

### Confirmation
`are_you_sure`, `confirm_remove_file`, `yes_remove`, `no_cancel`

### Dashboard
`dashboard`, `overview`, `statistics`, `recent_activities`

### Navigation
`home`, `profile`, `logout`, `login`

### Date & Time
`today`, `yesterday`, `this_week`, `this_month`, `this_year`

### Status
`active`, `inactive`, `pending`, `approved`, `rejected`, `completed`, `in_progress`

## 🎨 Language Switcher Styles

### Already Implemented in Settings Page
```blade
<div class="w-full flex flex-col gap-2">
    <label class="block text-sm font-medium text-gray-700">
        {{ trans_message('language') }}
    </label>
    <div class="flex gap-2">
        <a href="{{ route('admin.lang.switch', 'en') }}" 
           class="flex-1 px-4 py-2.5 text-sm font-medium rounded-lg border transition-all duration-200 text-center
                  {{ get_current_locale() === 'en' 
                      ? 'bg-[#0073AF] text-white border-[#0073AF] shadow-sm' 
                      : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 hover:border-[#0073AF]' }}">
            🇬🇧 {{ trans_message('english') }}
        </a>
        <a href="{{ route('admin.lang.switch', 'nl') }}" 
           class="flex-1 px-4 py-2.5 text-sm font-medium rounded-lg border transition-all duration-200 text-center
                  {{ get_current_locale() === 'nl' 
                      ? 'bg-[#0073AF] text-white border-[#0073AF] shadow-sm' 
                      : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 hover:border-[#0073AF]' }}">
            🇳🇱 {{ trans_message('dutch') }}
        </a>
    </div>
</div>
```

### Compact Version (for Header/Navbar)
```blade
<div class="flex gap-2">
    <a href="{{ route('admin.lang.switch', 'en') }}" 
       class="px-3 py-1.5 rounded {{ is_locale('en') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
        🇬🇧
    </a>
    <a href="{{ route('admin.lang.switch', 'nl') }}" 
       class="px-3 py-1.5 rounded {{ is_locale('nl') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
        🇳🇱
    </a>
</div>
```

## 🔄 Step-by-Step Implementation for Each Page

### 1. Update Page Title
```blade
{{-- Before --}}
@section('title', 'Dashboard')

{{-- After --}}
@section('title', trans_message('dashboard'))
```

### 2. Update Headings
```blade
{{-- Before --}}
<h1>Dashboard</h1>

{{-- After --}}
<h1>{{ trans_message('dashboard') }}</h1>
```

### 3. Update Buttons
```blade
{{-- Before --}}
<button>Save</button>
<button>Cancel</button>

{{-- After --}}
<button>{{ trans_message('save') }}</button>
<button>{{ trans_message('cancel') }}</button>
```

### 4. Update Labels
```blade
{{-- Before --}}
<label>Email</label>
<label>Password</label>

{{-- After --}}
<label>{{ trans_message('email') }}</label>
<label>{{ trans_message('password') }}</label>
```

### 5. Update Links
```blade
{{-- Before --}}
<a href="{{ route('admin.dashboard') }}">Dashboard</a>

{{-- After --}}
<a href="{{ route('admin.dashboard') }}">{{ trans_message('dashboard') }}</a>
```

## 🧪 Testing

### Test Language Switching
1. Go to Settings page
2. Click on 🇬🇧 English button
3. Page should reload with all text in English
4. Click on 🇳🇱 Nederlands button
5. Page should reload with all text in Dutch
6. Navigate to another page
7. Language should persist

### Test Translations
1. Switch to English
2. Verify all static text is in English
3. Switch to Dutch
4. Verify all static text is in Dutch
5. Database content should remain unchanged

### Debug Current Locale
```blade
{{-- Add this anywhere to see current language --}}
<p>Current Language: {{ get_current_locale() }}</p>
```

## 📦 Adding New Translations

### 1. Add to English file (`lang/en/messages.php`)
```php
'new_key' => 'English Text',
```

### 2. Add to Dutch file (`lang/nl/messages.php`)
```php
'new_key' => 'Nederlandse Tekst',
```

### 3. Use in templates
```blade
{{ trans_message('new_key') }}
```

## 🎯 Quick Reference

| Task | Code |
|------|------|
| Translate text | `{{ trans_message('key') }}` |
| Get current language | `{{ get_current_locale() }}` |
| Check if English | `@if(is_locale('en'))` |
| Check if Dutch | `@if(is_locale('nl'))` |
| Switch to English | `{{ route('admin.lang.switch', 'en') }}` |
| Switch to Dutch | `{{ route('admin.lang.switch', 'nl') }}` |

## ✅ Implementation Checklist

For each page:
- [ ] Update page title with `trans_message()`
- [ ] Update all headings with `trans_message()`
- [ ] Update all buttons with `trans_message()`
- [ ] Update all labels with `trans_message()`
- [ ] Update all links text with `trans_message()`
- [ ] Update validation messages with `trans_message()`
- [ ] Test in English
- [ ] Test in Dutch
- [ ] Verify language persists on navigation

## 🚨 Important Notes

1. **URLs don't change** - Language is session-based only
2. **Database content unchanged** - Only static UI text is translated
3. **Default language is English** - Set in session on first visit
4. **Middleware is required** - Already registered in `bootstrap/app.php`
5. **Route exists** - `/lang/{locale}` already configured

## 💡 Tips

- Always use `trans_message()` for static text
- Never translate database content
- Keep translation keys consistent between EN and NL
- Test language switching after each change
- Use descriptive translation keys
- Group related translations together

## 🎉 Ready to Use!

The localization system is fully implemented and ready. The settings page already has the language switcher working. Just apply `trans_message()` to other pages following the examples above!
