/**
 * Settings Panel Component
 */

import { useState } from '@wordpress/element';
import { TextControl, ToggleControl, Button } from '@wordpress/components';
import { updateSettings } from '@shared/utils/api';
import { PluginSettings } from '@shared/types';

interface SettingsPanelProps {
	settings: PluginSettings;
}

const SettingsPanel: React.FC<SettingsPanelProps> = ({ settings: initialSettings }) => {
	const [settings, setSettings] = useState(initialSettings);
	const [saving, setSaving] = useState(false);
	const [saved, setSaved] = useState(false);

	const handleChange = (key: string, value: any) => {
		setSettings((prev) => ({
			...prev,
			[key]: value,
		}));
		setSaved(false);
	};

	const handleSave = async () => {
		try {
			setSaving(true);
			await updateSettings(settings);
			setSaved(true);
			setTimeout(() => setSaved(false), 3000);
		} catch (error) {
			console.error('Failed to save settings', error);
		} finally {
			setSaving(false);
		}
	};

	return (
		<div className="settings-panel">
			<TextControl
				label="API Endpoint"
				value={settings.api_endpoint}
				onChange={(value) => handleChange('api_endpoint', value)}
				placeholder="https://api.example.com"
			/>

			<ToggleControl
				label="Enable Logging"
				checked={settings.enable_logging}
				onChange={(value) => handleChange('enable_logging', value)}
			/>

			<ToggleControl
				label="Debug Mode"
				checked={settings.debug_mode}
				onChange={(value) => handleChange('debug_mode', value)}
			/>

			<div className="button-group">
				<Button
					variant="primary"
					onClick={handleSave}
					disabled={saving}
				>
					{saving ? 'Saving...' : 'Save Settings'}
				</Button>
				{saved && <span className="save-success">Settings saved!</span>}
			</div>
		</div>
	);
};

export default SettingsPanel;
