# ADR-001: Common Components Extraction from Pages Directory

## Status
Proposed

## Context
After analyzing the Vue files in `frontend/src/pages`, several recurring patterns and components have been identified that are being duplicated across multiple pages. This duplication leads to:
- Code redundancy and maintenance overhead
- Inconsistent styling and behavior
- Difficulty in implementing global UI changes
- Violation of the DRY (Don't Repeat Yourself) principle

## Analysis Results

### Current Page Structure
The following 8 pages were analyzed:
1. ExpenseListView.vue
2. BudgetManagementView.vue  
3. LoginView.vue
4. ExpenseInputView.vue
5. DashboardView.vue
6. ShoppingMemoView.vue
7. StatisticsView.vue
8. UserManagementView.vue

### Common UI Patterns Identified

#### 1. Page Card Wrapper
**Pattern**: All pages use the same basic card structure
```vue
<template>
  <v-container>
    <v-card>
      <v-card-title>Page Title</v-card-title>
      <v-card-text>
        <!-- Content -->
      </v-card-text>
      <v-card-actions>
        <!-- Actions -->
      </v-card-actions>
    </v-card>
  </v-container>
</template>
```
**Usage**: All 8 pages
**Proposed Component**: `PageCard.vue`

#### 2. Data Table with Actions
**Pattern**: Standardized data table with consistent action buttons
```vue
<v-data-table 
  :headers="headers" 
  :items="items" 
  :items-per-page="10"
>
  <template v-slot:item.actions="{ item }">
    <v-btn icon size="small" color="primary" @click="edit(item.id)">
      <v-icon>mdi-pencil</v-icon>
    </v-btn>
    <v-btn icon size="small" color="error" @click="delete(item.id)">
      <v-icon>mdi-delete</v-icon>
    </v-btn>
  </template>
</v-data-table>
```
**Usage**: ExpenseListView.vue, UserManagementView.vue
**Proposed Component**: `ActionDataTable.vue`

#### 3. Form with Validation
**Pattern**: Standardized form wrapper with consistent validation
```vue
<v-form @submit.prevent="onSubmit">
  <v-row>
    <v-col>
      <v-text-field />
    </v-col>
  </v-row>
</v-form>
```
**Usage**: LoginView.vue, ExpenseInputView.vue
**Proposed Component**: `FormCard.vue`

#### 4. Filter Controls
**Pattern**: Consistent filter interface with date picker and select controls
```vue
<v-row>
  <v-col>
    <v-text-field v-model="filter.date" label="日付" type="date" />
  </v-col>
  <v-col>
    <v-select />
  </v-col>
</v-row>
```
**Usage**: ExpenseListView.vue, StatisticsView.vue
**Proposed Component**: `FilterControls.vue`

#### 5. Summary Cards
**Pattern**: Metric display cards with consistent styling
```vue
<v-card color="primary" dark>
  <v-card-text>
    <div class="text-h6">Label</div>
    <div class="text-h4">Value</div>
  </v-card-text>
</v-card>
```
**Usage**: DashboardView.vue, StatisticsView.vue
**Proposed Component**: `MetricCard.vue`

#### 6. Navigation Buttons
**Pattern**: Consistent button styling and navigation patterns
```vue
<v-btn color="primary" @click="$router.push('/path')">
  Label
</v-btn>
```
**Usage**: All pages except LoginView
**Proposed Component**: `NavigationButton.vue`

#### 7. Item List with Actions
**Pattern**: List display with add/delete functionality
```vue
<v-list>
  <v-list-item v-for="item in items" :key="item.id">
    <v-list-item-content>
      {{ item.name }}
    </v-list-item-content>
    <v-list-item-action>
      <v-btn icon @click="delete(item.id)">
        <v-icon>mdi-delete</v-icon>
      </v-btn>
    </v-list-item-action>
  </v-list-item>
</v-list>
```
**Usage**: ShoppingMemoView.vue
**Proposed Component**: `ActionList.vue`

## Decision

### Primary Components to Extract (High Priority)

1. **PageCard.vue** - Universal page wrapper
   - Props: title, showActions (boolean)
   - Slots: default, actions
   - Location: `shared/ui/containers/`

2. **ActionDataTable.vue** - Enhanced data table
   - Props: headers, items, itemsPerPage, showEdit, showDelete
   - Events: edit, delete
   - Location: `shared/ui/data-display/`

3. **MetricCard.vue** - Summary metric display
   - Props: title, value, color, icon
   - Location: `shared/ui/data-display/`

4. **FilterControls.vue** - Standardized filtering interface
   - Props: filters (configurable filter types)
   - Events: filter-change
   - Location: `shared/ui/forms/`

### Secondary Components (Medium Priority)

5. **FormCard.vue** - Form wrapper with validation
   - Props: title, submitLabel
   - Events: submit
   - Slots: default, actions
   - Location: `shared/ui/forms/`

6. **NavigationButton.vue** - Consistent navigation
   - Props: to, color, variant
   - Location: `shared/ui/controls/`

7. **ActionList.vue** - List with item actions
   - Props: items, showDelete, showEdit
   - Events: delete, edit
   - Location: `shared/ui/data-display/`

## Implementation Plan

### Phase 1: Core Components
1. Create `PageCard.vue` in `shared/ui/containers/`
2. Refactor all pages to use `PageCard`
3. Test consistency across all views

### Phase 2: Data Display Components  
1. Create `ActionDataTable.vue` and `MetricCard.vue`
2. Refactor ExpenseListView, UserManagementView, DashboardView, StatisticsView
3. Ensure consistent styling and behavior

### Phase 3: Form and Filter Components
1. Create `FilterControls.vue` and `FormCard.vue`
2. Refactor remaining components
3. Add validation and error handling

### Phase 4: Utility Components
1. Create remaining utility components
2. Comprehensive refactoring
3. Documentation and testing

## Benefits

- **Consistency**: Unified look and feel across all pages
- **Maintainability**: Single source of truth for common UI patterns
- **Development Speed**: Faster development with pre-built components
- **Testing**: Centralized testing of common functionality
- **Bundle Size**: Potential reduction through better tree-shaking

## Risks and Mitigation

- **Over-abstraction**: Risk of creating overly complex components
  - Mitigation: Start with simple, focused components
- **Breaking Changes**: Refactoring may introduce bugs
  - Mitigation: Implement incrementally with thorough testing
- **Performance**: Additional prop passing overhead
  - Mitigation: Profile and optimize critical paths

## Notes

- All components should follow FSD architecture principles
- Components should be placed in appropriate shared/ui subdirectories
- Comprehensive testing should be implemented for each component
- Documentation should be created for component API and usage patterns

## Date
2025-01-12