/**
 * Admin Panel Entry Point
 */

import { createRoot } from '@wordpress/element';
import App from './App';

// Find the root element
const root = document.getElementById('wordpress-app-test-admin');

if (root) {
	createRoot(root).render(<App />);
}
