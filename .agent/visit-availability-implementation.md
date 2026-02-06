# Visit Availability Implementation

## Overview
Implemented a feature where a visit becomes unavailable to all other visitors once an admin approves one visitor for that visit.

## Changes Made

### 1. User Visit Controller (`app/Http/Controllers/User/VisitController.php`)

#### Available Visits Query (Lines 51-58)
- Added `whereNull('visitor_id')` condition to exclude visits that have been assigned to any visitor
- This ensures that once a visit is assigned, it disappears from the "Available" tab for all users

**Before:**
```php
if($page=='available'){
    // Show OPEN visits that this user has NOT marked as interested
    $query->where('status','=','OPEN')
        ->whereDoesntHave('interests', function($subQuery) {
            $subQuery->where('user_id', $this->user_id);
        });
}
```

**After:**
```php
if($page=='available'){
    // Show OPEN visits that this user has NOT marked as interested
    // AND that have NOT been assigned to any visitor yet
    $query->where('status','=','OPEN')
        ->whereNull('visitor_id') // Exclude visits already assigned to someone
        ->whereDoesntHave('interests', function($subQuery) {
            $subQuery->where('user_id', $this->user_id);
        });
}
```

#### Interested Visits Query (Lines 59-72)
- Added condition to only show visits that are either unassigned OR assigned to the current user
- This ensures that when a visit is assigned to someone else, it disappears from other users' "Interested" tab
- If the visit is assigned to the current user, it stays visible (and will move to "Scheduled" tab)

**Before:**
```php
}elseif ($page=='interested'){
    // Show visits where this user has expressed interest AND status is OPEN or INTERESTED
    // Once assigned/scheduled, it moves to 'Scheduled' tab
    $query->whereHas('interests', function($subQuery) {
        $subQuery->where('user_id', $this->user_id);
    })->where(function ($q) {
        $q->where('status', VisitStatus::OPEN->value)
          ->orWhere('status', VisitStatus::INTERESTED->value);
    });
}
```

**After:**
```php
}elseif ($page=='interested'){
    // Show visits where this user has expressed interest AND status is OPEN or INTERESTED
    // Once assigned/scheduled, it moves to 'Scheduled' tab
    // Also exclude visits that have been assigned to OTHER visitors
    $query->whereHas('interests', function($subQuery) {
        $subQuery->where('user_id', $this->user_id);
    })->where(function ($q) {
        $q->where('status', VisitStatus::OPEN->value)
          ->orWhere('status', VisitStatus::INTERESTED->value);
    })->where(function ($q) {
        // Only show if visit is unassigned OR assigned to this user
        $q->whereNull('visitor_id')
          ->orWhere('visitor_id', $this->user_id);
    });
}
```

### 2. Admin Visit Controller (`app/Http/Controllers/Admin/VisitController.php`)

#### Interested Visits List (Lines 503-507)
- Added `whereNull('visitor_id')` condition to exclude visits that have already been assigned
- This ensures that once an admin assigns a visitor to a visit, it disappears from the "Interested" tab in the admin panel

**Before:**
```php
try {
    // Show visits that have at least one interested visitor (from visit_interests table)
    $response = Visit::with(['branch', 'questionnaire', 'interests.user'])
        ->whereHas('interests') // Only visits with interest records
        ->latest();
```

**After:**
```php
try {
    // Show visits that have at least one interested visitor (from visit_interests table)
    // AND have NOT been assigned to anyone yet
    $response = Visit::with(['branch', 'questionnaire', 'interests.user'])
        ->whereHas('interests') // Only visits with interest records
        ->whereNull('visitor_id') // Exclude visits already assigned
        ->latest();
```

## How It Works

### Flow:
1. **Visit Created**: Admin creates a visit with status `OPEN` and `visitor_id = null`
2. **Visitors See Visit**: All visitors see the visit in their "Available" tab
3. **Visitors Express Interest**: Visitors can click "I'm Interested" which creates a record in `visit_interests` table
4. **Visit Moves to Interested**: The visit now appears in visitors' "Interested" tab and admin's "Interested" tab
5. **Admin Assigns Visitor**: Admin selects one visitor and clicks "Assign"
   - The `assignVisitor` method sets `visitor_id` to the selected visitor's ID
   - The visit status changes to `ASSIGNED`
   - All other interest records are deleted
6. **Visit Becomes Unavailable**: 
   - The visit disappears from ALL other visitors' "Available" and "Interested" tabs
   - The visit disappears from admin's "Interested" tab
   - Only the assigned visitor can see it in their "Scheduled" tab

### Database Changes:
- The `visits` table has a `visitor_id` column (nullable)
- When `visitor_id` is NULL, the visit is available to everyone
- When `visitor_id` is set, the visit is assigned to that specific visitor

## Testing Recommendations

1. **Test as Visitor A**:
   - See a visit in "Available" tab
   - Express interest
   - See it move to "Interested" tab

2. **Test as Visitor B**:
   - See the same visit in "Available" tab
   - Express interest
   - See it move to "Interested" tab

3. **Test as Admin**:
   - See the visit in "Interested" tab with both visitors listed
   - Assign the visit to Visitor A
   - Verify the visit disappears from "Interested" tab
   - Verify the visit appears in "Scheduled" tab with Visitor A assigned

4. **Verify as Visitor A**:
   - The visit should move from "Interested" to "Scheduled" tab
   - Should be able to start the survey

5. **Verify as Visitor B**:
   - The visit should disappear from both "Available" and "Interested" tabs
   - Should not be able to see or access the visit anymore

## Notes
- The existing `assignVisitor` method already handles setting the `visitor_id` and deleting other interests
- No changes were needed to the assignment logic itself
- The changes only affect the query filters for displaying visits in different tabs
