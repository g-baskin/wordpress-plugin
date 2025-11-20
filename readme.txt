=== WordPress App Test ===
Contributors: developers
Tags: admin-panel, rest-api, license, typescript, react
Requires at least: 6.0
Tested up to: 6.4
Requires PHP: 7.4
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Test WordPress plugin with TypeScript, REST API, and license system.

== Description ==

WordPress App Test is a modern WordPress plugin built with:
- TypeScript support for type-safe development
- React-based admin panel using WordPress Components
- Custom REST API endpoints
- License key system for premium functionality
- PHPUnit testing framework
- wp-scripts build system

This plugin demonstrates professional WordPress development practices and patterns.

== Features ==

- Modern TypeScript/React admin interface
- REST API endpoints for settings management
- License key validation system
- Comprehensive logging capabilities
- Professional folder structure
- Full test coverage with PHPUnit and Vitest
- Pre-configured build tools and linting

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wordpress-app-test` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure settings in the WordPress App Test admin page

== Development ==

```bash
# Install dependencies
npm install
composer install

# Development server
npm start

# Build for production
npm run build

# Run tests
npm test

# Linting
npm run lint:js
npm run lint:style
```

== Changelog ==

= 1.0.0 =
- Initial release
- Admin panel with settings management
- REST API endpoints
- License system
- TypeScript support
- PHPUnit tests

== Support ==

For support, please visit https://example.com or email support@example.com
