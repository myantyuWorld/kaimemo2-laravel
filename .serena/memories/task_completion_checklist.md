# Task Completion Checklist

## When completing any development task:

### Code Quality Checks
1. **PHP Formatting**: Run `./vendor/bin/pint` from `src/` directory
2. **Frontend Linting**: Run `npm run lint` from `src/` directory  
3. **Frontend Formatting**: Run `npm run format:check` from `src/` directory

### Testing
1. **PHP Tests**: Run `composer run test` from `src/` directory
2. Ensure all existing tests pass
3. Add new tests for new functionality if required

### Build Verification
1. **Production Build**: Run `npm run build` from `src/` directory
2. Ensure build completes without errors

### Final Verification
1. Test functionality in development server (`composer run dev`)
2. Check that no TypeScript errors exist
3. Verify all routes work correctly
4. Ensure database migrations run successfully if schema changes made

### Documentation
- Update relevant documentation if public APIs changed
- Update CLAUDE.md if new commands or patterns introduced