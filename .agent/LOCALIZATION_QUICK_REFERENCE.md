# Localization Quick Reference Card

## 🚀 Quick Start

### Language Switcher (Copy & Paste)
```blade
<div class="flex gap-2">
    <a href="{{ route('admin.lang.switch', 'en') }}" 
       class="{{ is_locale('en') ? 'bg-blue-600 text-white' : 'bg-gray-200' }} px-4 py-2 rounded">
        🇬🇧 {{ trans_message('english') }}
    </a>
    <a href="{{ route('admin.lang.switch', 'nl') }}" 
       class="{{ is_locale('nl') ? 'bg-blue-600 text-white' : 'bg-gray-200' }} px-4 py-2 rounded">
        🇳🇱 {{ trans_message('dutch') }}
    </a>
</div>
```

## 📝 Common Usage

### Text Translation
```blade
{{ trans_message('dashboard') }}
{{ trans_message('save') }}
{{ trans_message('cancel') }}
```

### Page Title
```blade
@section('title', trans_message('settings'))
```

### Buttons
```blade
<button>{{ trans_message('save') }}</button>
<button>{{ trans_message('cancel') }}</button>
<button>{{ trans_message('delete') }}</button>
```

### Form Labels
```blade
<label>{{ trans_message('email') }}</label>
<label>{{ trans_message('password') }}</label>
<label>{{ trans_message('name') }}</label>
```

### Links
```blade
<a href="{{ route('admin.dashboard') }}">
    {{ trans_message('dashboard') }}
</a>
```

## 🔧 Helper Functions

| Function | Returns | Example |
|----------|---------|---------|
| `trans_message('key')` | Translated text | `trans_message('dashboard')` → "Dashboard" or "Dashboard" |
| `get_current_locale()` | Current language code | `get_current_locale()` → "en" or "nl" |
| `is_locale('en')` | Boolean | `is_locale('en')` → true/false |

## 📋 Most Used Keys

### Navigation
- `dashboard`, `settings`, `profile`, `logout`, `login`, `home`

### Actions
- `save`, `cancel`, `delete`, `edit`, `add`, `search`, `filter`, `export`, `import`

### Common
- `yes`, `no`, `ok`, `back`, `next`, `close`, `confirm`, `loading`, `processing`

### Forms
- `email`, `password`, `name`, `display_name`, `new_password`, `confirm_password`

### Messages
- `success`, `error`, `warning`, `are_you_sure`

## 🎯 Find & Replace Guide

### Step 1: Page Titles
```
Find: @section('title', 'Dashboard')
Replace: @section('title', trans_message('dashboard'))
```

### Step 2: Headings
```
Find: <h1>Dashboard</h1>
Replace: <h1>{{ trans_message('dashboard') }}</h1>
```

### Step 3: Buttons
```
Find: >Save<
Replace: >{{ trans_message('save') }}<

Find: >Cancel<
Replace: >{{ trans_message('cancel') }}<
```

### Step 4: Labels
```
Find: >Email<
Replace: >{{ trans_message('email') }}<

Find: >Password<
Replace: >{{ trans_message('password') }}<
```

## ✅ Page Update Checklist

- [ ] Update `@section('title')` with `trans_message()`
- [ ] Update all `<h1>`, `<h2>`, `<h3>` with `trans_message()`
- [ ] Update all `<button>` text with `trans_message()`
- [ ] Update all `<label>` text with `trans_message()`
- [ ] Update all `<a>` link text with `trans_message()`
- [ ] Update JavaScript validation messages
- [ ] Test in English
- [ ] Test in Dutch

## 🧪 Testing

```blade
{{-- Debug: Show current language --}}
<p>Current: {{ get_current_locale() }}</p>

{{-- Test translation --}}
<p>{{ trans_message('dashboard') }}</p>
```

## 💡 Pro Tips

1. **Always use trans_message()** for static text
2. **Never translate database content**
3. **Test both languages** after changes
4. **Keep keys descriptive** (e.g., `dashboard` not `d1`)
5. **Group related keys** in translation files

## 🚨 Common Mistakes

❌ **Don't:**
```blade
<h1>Dashboard</h1>
<button>Save</button>
```

✅ **Do:**
```blade
<h1>{{ trans_message('dashboard') }}</h1>
<button>{{ trans_message('save') }}</button>
```

## 📞 Need Help?

- Check `.agent/LOCALIZATION_IMPLEMENTATION.md` for full guide
- View translations: `lang/en/messages.php` and `lang/nl/messages.php`
- Test with: `{{ get_current_locale() }}`
