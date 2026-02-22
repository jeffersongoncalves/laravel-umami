# Changelog

All notable changes to this project will be documented in this file.

## v2.0.0 - 2026-02-22

### Breaking Changes

- **Configuration migrated to database**: Replaced \ with . Settings are now stored in the database instead of \ file.
- **New dependency**: \ is now required.

### Migration Guide

1. Remove any published \ from your application
2. Remove \ environment variables from \ (no longer used)
3. Ensure \ is configured (the \ table must exist)
4. Run \ to create the Umami settings in the database
5. Set your settings via code:

\

### What's Changed

- Removed \ and all \ reads
- Added \ class extending - Added settings migration with default values
- Updated \ to register settings class and migration paths
- Updated Blade view to resolve settings from the container
- Updated README with new installation and usage instructions

### Available Settings

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| \ | \ | \ | Your Umami website ID |
| \ | \ | \ | URL of your Umami instance |
| \ | \ | \ | Override data destination URL |
| \ | \ | \ | Automatically track pageviews and events |
| \ | \ | \ | Comma-delimited list of allowed domains |
| \ | \ | \ | Tag to group events in the dashboard |
| \ | \ | \ | Exclude search parameters from URL |
| \ | \ | \ | Exclude hash value from URL |

## v1.1.0 - 2025-03-07

**Full Changelog**: https://github.com/jeffersongoncalves/laravel-umami/compare/v1.0.1...v1.1.0

## v1.0.1 - 2025-03-04

**Full Changelog**: https://github.com/jeffersongoncalves/laravel-umami/compare/v1.0.0...v1.0.1

## v1.0.0 - 2025-03-04

**Full Changelog**: https://github.com/jeffersongoncalves/laravel-umami/commits/v1.0.0
